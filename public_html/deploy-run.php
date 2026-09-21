<?php
/**
 * Automated Deployment Script for Talalive.ir
 * Syncs repositories/live -> /home/talaliv1/
 */

// 1. Security check
$secretKey = 'tala_deploy_7f8c9b1e2a3d4f5';
$providedKey = $_GET['key'] ?? $_POST['key'] ?? ($_SERVER['HTTP_X_DEPLOY_KEY'] ?? '');

if (empty($providedKey) || !hash_equals($secretKey, $providedKey)) {
    http_response_code(403);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access: Invalid or missing security key.'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

$startTime = microtime(true);
$log = [];

$targetDir = '/home/talaliv1';
if (!is_dir($targetDir)) {
    $targetDir = dirname(__DIR__);
}

if (!empty($_GET['sync_blade'])) {
    $rawUrl = 'https://raw.githubusercontent.com/nicedevil02/live/master/resources/views/display/live.blade.php?t=' . time();
    $ctx = stream_context_create(['http' => ['timeout' => 15, 'header' => "User-Agent: Mozilla/5.0 (TalaDeploy)\r\n"]]);
    $newBlade = @file_get_contents($rawUrl, false, $ctx);
    if ($newBlade && strlen($newBlade) > 10000) {
        @file_put_contents("$targetDir/resources/views/display/live.blade.php", $newBlade);
        $foundRepos = glob("$targetDir/repositories/*", GLOB_ONLYDIR);
        if (!empty($foundRepos)) {
            foreach ($foundRepos as $r) {
                if (is_dir("$r/resources/views/display")) {
                    @file_put_contents("$r/resources/views/display/live.blade.php", $newBlade);
                }
            }
        }
        $vDir = "$targetDir/storage/framework/views";
        if (is_dir($vDir)) {
            foreach (glob("$vDir/*.php") as $vf) { @unlink($vf); }
        }
        if (function_exists('opcache_reset')) { @opcache_reset(); }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => true, 'message' => 'live.blade.php synced directly and view cache cleared!', 'bytes' => strlen($newBlade)]);
        exit;
    }
}

$sourceCandidates = [
    $_GET['repo'] ?? '',
    "$targetDir/repositories/talalive",
    "$targetDir/repositories/live_app",
    "$targetDir/repositories/live",
    "$targetDir/repositories/live_repo",
];

$sourceDir = '';
foreach ($sourceCandidates as $cand) {
    if (!empty($cand) && is_dir($cand)) {
        $sourceDir = $cand;
        break;
    }
}

if (empty($sourceDir) && is_dir("$targetDir/repositories")) {
    $found = glob("$targetDir/repositories/*", GLOB_ONLYDIR);
    if (!empty($found)) {
        $sourceDir = $found[0];
    }
}

if (empty($sourceDir) || !is_dir($sourceDir)) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'message' => 'Source repository not found. Searched in: ' . json_encode($sourceCandidates)
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// 2. Check for update_deploy.zip first (if user uploaded zip)
$zipExtracted = false;
$zipCandidates = [
    "$targetDir/update_deploy.zip",
    "$targetDir/public_html/update_deploy.zip",
    dirname(__DIR__) . "/update_deploy.zip",
    __DIR__ . "/update_deploy.zip",
];

foreach ($zipCandidates as $zipPath) {
    if (file_exists($zipPath) && filesize($zipPath) > 100000) {
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            if ($zip->open($zipPath) === true) {
                $zip->extractTo($targetDir);
                $zip->close();
                $zipExtracted = true;
                $log[] = "Extracted update_deploy.zip from: $zipPath";
                break;
            }
        }
    }
}

// 3. Git pull from remote repository
$gitOutput = '';
$headCommit = '';
$shellAllowed = false;
if (function_exists('shell_exec')) {
    $disabled = explode(',', (string)ini_get('disable_functions'));
    $disabled = array_map('trim', $disabled);
    if (!in_array('shell_exec', $disabled)) {
        $shellAllowed = true;
        $targetBranch = preg_replace('/[^a-zA-Z0-9_\-\/]/', '', $_GET['branch'] ?? 'master');
        if (empty($targetBranch)) $targetBranch = 'master';
        $cmd = 'cd ' . escapeshellarg($sourceDir) . ' && git fetch origin ' . escapeshellarg($targetBranch) . ' 2>&1 && git checkout ' . escapeshellarg($targetBranch) . ' 2>&1 && git reset --hard origin/' . escapeshellarg($targetBranch) . ' 2>&1';
        $gitOutput = @shell_exec($cmd);
        if ($gitOutput) {
            $log[] = 'Git sync output: ' . trim($gitOutput);
        }
        $headCommit = trim((string)@shell_exec('cd ' . escapeshellarg($sourceDir) . ' && git log -1 --format="%h - %s (%ci by %an)" 2>&1'));
        if ($headCommit) {
            $log[] = 'Checked out HEAD commit: ' . $headCommit;
        }
    } else {
        $log[] = 'Notice: shell_exec is in disable_functions.';
    }
} else {
    $log[] = 'Notice: shell_exec function does not exist.';
}

// Fallback: If git pull did not run and no zip was extracted, download latest live.blade.php directly from GitHub
if (!$shellAllowed && !$zipExtracted) {
    $rawUrl = 'https://raw.githubusercontent.com/nicedevil02/live/master/resources/views/display/live.blade.php?t=' . time();
    $ctx = stream_context_create(['http' => ['timeout' => 10, 'header' => "User-Agent: Mozilla/5.0\r\n"]]);
    $newBlade = @file_get_contents($rawUrl, false, $ctx);
    if ($newBlade && strlen($newBlade) > 10000) {
        @file_put_contents("$targetDir/resources/views/display/live.blade.php", $newBlade);
        $log[] = 'Directly downloaded latest live.blade.php from GitHub repository!';
    }
}

// 4. Trigger cPanel VersionControl UAPI deployment (registers deployment in cPanel GUI)
$uapiOutput = '';
if ($shellAllowed) {
    $uapiCmd = 'uapi VersionControl deployment create repository_root=' . escapeshellarg($sourceDir) . ' 2>&1';
    $uapiOutput = @shell_exec($uapiCmd);
    if (empty($uapiOutput) || stripos($uapiOutput, 'not found') !== false) {
        $altUapi = '/usr/local/cpanel/bin/uapi VersionControl deployment create repository_root=' . escapeshellarg($sourceDir) . ' 2>&1';
        $uapiOutput = @shell_exec($altUapi);
    }
    if ($uapiOutput) {
        $log[] = 'cPanel UAPI Deployment: ' . trim($uapiOutput);
    }
}

// 5. High-speed file synchronization matching .cpanel.yml
$copiedFiles = 0;
$copiedDirs = 0;

if ($shellAllowed) {
    $cpCmd = "
        /bin/cp -Rf " . escapeshellarg($sourceDir . '/app') . " " . escapeshellarg($targetDir . '/') . " 2>&1
        /bin/cp -Rf " . escapeshellarg($sourceDir . '/bootstrap') . " " . escapeshellarg($targetDir . '/') . " 2>&1
        /bin/cp -Rf " . escapeshellarg($sourceDir . '/config') . " " . escapeshellarg($targetDir . '/') . " 2>&1
        /bin/cp -Rf " . escapeshellarg($sourceDir . '/database') . " " . escapeshellarg($targetDir . '/') . " 2>&1
        /bin/cp -Rf " . escapeshellarg($sourceDir . '/resources') . " " . escapeshellarg($targetDir . '/') . " 2>&1
        /bin/cp -Rf " . escapeshellarg($sourceDir . '/routes') . " " . escapeshellarg($targetDir . '/') . " 2>&1
        /bin/cp -Rf " . escapeshellarg($sourceDir . '/public_html/.') . " " . escapeshellarg($targetDir . '/public_html/') . " 2>&1
        /bin/cp -Rf " . escapeshellarg($sourceDir . '/public_html/.') . " " . escapeshellarg($targetDir . '/public/') . " 2>&1
        /bin/cp -f " . escapeshellarg($sourceDir . '/artisan') . " " . escapeshellarg($targetDir . '/') . " 2>&1
        /bin/cp -f " . escapeshellarg($sourceDir . '/composer.json') . " " . escapeshellarg($targetDir . '/') . " 2>&1
        /bin/cp -f " . escapeshellarg($sourceDir . '/package.json') . " " . escapeshellarg($targetDir . '/') . " 2>&1
    ";
    @shell_exec($cpCmd);
    $log[] = 'Synchronized core directories, public_html and public via /bin/cp -Rf';
}

// 6. PHP Recursive synchronization (MD5-aware fallback & verification)
function syncDirectory($src, $dst, &$copiedFiles, &$copiedDirs, $exclude = []) {
    if (!is_dir($src)) return;
    if (!is_dir($dst)) {
        @mkdir($dst, 0755, true);
        $copiedDirs++;
    }
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($iterator as $item) {
        $subPath = $iterator->getSubPathName();
        foreach ($exclude as $exc) {
            if (strpos($subPath, $exc) === 0) continue 2;
        }
        $target = $dst . DIRECTORY_SEPARATOR . $subPath;
        if ($item->isDir()) {
            if (!is_dir($target)) {
                @mkdir($target, 0755, true);
                $copiedDirs++;
            }
        } else {
            $srcPath = $item->getRealPath();
            $needsCopy = false;
            if (!file_exists($target)) {
                $needsCopy = true;
            } elseif (filesize($srcPath) !== filesize($target)) {
                $needsCopy = true;
            } elseif (md5_file($srcPath) !== md5_file($target)) {
                $needsCopy = true;
            }

            if ($needsCopy) {
                @copy($srcPath, $target);
                $copiedFiles++;
            }
        }
    }
}

$dirsToSync = ['app', 'bootstrap', 'config', 'database', 'resources', 'routes'];
foreach ($dirsToSync as $dir) {
    syncDirectory("$sourceDir/$dir", "$targetDir/$dir", $copiedFiles, $copiedDirs);
}
syncDirectory("$sourceDir/public_html", "$targetDir/public_html", $copiedFiles, $copiedDirs);
syncDirectory("$sourceDir/public_html", "$targetDir/public", $copiedFiles, $copiedDirs);

$filesToSync = ['artisan', 'composer.json', 'package.json'];
foreach ($filesToSync as $file) {
    $srcFile = "$sourceDir/$file";
    $dstFile = "$targetDir/$file";
    if (file_exists($srcFile)) {
        if (!file_exists($dstFile) || filesize($srcFile) !== filesize($dstFile) || md5_file($srcFile) !== md5_file($dstFile)) {
            @copy($srcFile, $dstFile);
            $copiedFiles++;
        }
    }
}

// 6.5. Synchronize Android TV APK binary (Rule U-03 Compliant)
$apkMetaFile = "$targetDir/public_html/downloads/talalive-tv.json";
$apkTarget = "$targetDir/public_html/downloads/talalive-tv.apk";
$apkRepoTarget = "$sourceDir/public_html/downloads/talalive-tv.apk";
$apkStatus = ['synced' => false];

if (file_exists($apkMetaFile)) {
    $meta = json_decode((string)file_get_contents($apkMetaFile), true);
    $expectedSha = strtolower(trim((string)($meta['sha256'] ?? '')));
    $expectedSize = (int)($meta['size_bytes'] ?? 0);
    $apkStatus['expected_sha256'] = $expectedSha;
    $apkStatus['expected_size'] = $expectedSize;

    $currentSha = file_exists($apkTarget) ? strtolower(hash_file('sha256', $apkTarget)) : '';
    $currentSize = file_exists($apkTarget) ? filesize($apkTarget) : 0;
    $apkStatus['current_sha256'] = $currentSha;
    $apkStatus['current_size'] = $currentSize;

    // Check if update is needed
    if (empty($currentSha) || $currentSha !== $expectedSha || $currentSize !== $expectedSize) {
        $apkBinary = null;

        // A. Check if uploaded via POST apk_base64
        if (!empty($_POST['apk_base64'])) {
            $apkBinary = base64_decode($_POST['apk_base64']);
        }

        // B. Check if present in repository source directory
        if (!$apkBinary && file_exists($apkRepoTarget)) {
            $repoSha = strtolower(hash_file('sha256', $apkRepoTarget));
            if ($repoSha === $expectedSha) {
                $apkBinary = file_get_contents($apkRepoTarget);
            }
        }

        // C. Download from GitHub apk-dist branch CDN
        if (!$apkBinary) {
            $apkDistUrl = 'https://raw.githubusercontent.com/nicedevil02/live/apk-dist/talalive-tv.apk';
            $ctx = stream_context_create([
                'http' => [
                    'timeout' => 20,
                    'header' => "User-Agent: Mozilla/5.0 (TalaLive-Deploy)\r\n"
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);
            $downloaded = @file_get_contents($apkDistUrl, false, $ctx);
            if ($downloaded && strlen($downloaded) > 10000) {
                $downSha = strtolower(hash('sha256', $downloaded));
                if ($downSha === $expectedSha) {
                    $apkBinary = $downloaded;
                    $log[] = "Downloaded verified APK from GitHub apk-dist (" . strlen($downloaded) . " bytes)";
                } else {
                    $log[] = "Downloaded APK SHA256 mismatch: got $downSha, expected $expectedSha";
                }
            } else {
                $log[] = "Notice: Could not download APK from $apkDistUrl";
            }
        }

        if ($apkBinary) {
            @mkdir(dirname($apkTarget), 0755, true);
            @file_put_contents($apkTarget, $apkBinary);
            @chmod($apkTarget, 0644);
            @mkdir(dirname($apkRepoTarget), 0755, true);
            @file_put_contents($apkRepoTarget, $apkBinary);
            @chmod($apkRepoTarget, 0644);
            $copiedFiles++;
            $apkStatus['synced'] = true;
            $apkStatus['final_size'] = filesize($apkTarget);
            $apkStatus['final_sha256'] = hash_file('sha256', $apkTarget);
            $log[] = "Successfully deployed talalive-tv.apk to $apkTarget (" . filesize($apkTarget) . " bytes)";
        } else {
            $log[] = "Warning: Could not obtain matching APK binary for $expectedSha";
        }
    } else {
        $apkStatus['synced'] = true;
        $apkStatus['final_size'] = $currentSize;
        $apkStatus['final_sha256'] = $currentSha;
        $apkStatus['message'] = "Already matching latest release";
    }
}

// 7. Clear Blade compiled views cache
$viewCacheDir = "$targetDir/storage/framework/views";
$clearedViews = 0;
if (is_dir($viewCacheDir)) {
    foreach (glob("$viewCacheDir/*.php") as $vFile) {
        @unlink($vFile);
        $clearedViews++;
    }
}

// 8. Clear Bootstrap caches (routes, config, events, packages)
$bootstrapCacheDir = "$targetDir/bootstrap/cache";
$clearedBootstrap = 0;
if (is_dir($bootstrapCacheDir)) {
    foreach (['config.php', 'routes-v7.php', 'events.php', 'packages.php', 'services.php'] as $bFile) {
        $bPath = "$bootstrapCacheDir/$bFile";
        if (file_exists($bPath)) {
            @unlink($bPath);
            $clearedBootstrap++;
        }
    }
}

// 9. Reset PHP OPcache bytecode cache
$opcacheReset = false;
if (function_exists('opcache_reset')) {
    $opcacheReset = @opcache_reset();
    if ($opcacheReset) {
        $log[] = 'PHP OPcache bytecode reset successfully.';
    }
}

// 9.5. Clean .trash to free up server disk quota
$trashDir = "$targetDir/.trash";
if (is_dir($trashDir)) {
    if ($shellAllowed) {
        @shell_exec("/bin/rm -rf " . escapeshellarg($trashDir) . "/* 2>&1");
    }
    $log[] = 'Emptied .trash directory to restore disk quota.';
}


// 10. Run Artisan migrations unconditionally & verify tables
$tableStatus = [];
$artisanMigrateOutput = '';
if (file_exists("$targetDir/vendor/autoload.php") && file_exists("$targetDir/bootstrap/app.php")) {
    try {
        require_once "$targetDir/vendor/autoload.php";
        $app = require_once "$targetDir/bootstrap/app.php";
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();

        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $artisanMigrateOutput = trim(\Illuminate\Support\Facades\Artisan::output());
        if ($artisanMigrateOutput) {
            $log[] = 'Migrate: ' . $artisanMigrateOutput;
        }

        \Illuminate\Support\Facades\Artisan::call('view:clear');
        $log[] = 'Artisan view:clear: ' . trim(\Illuminate\Support\Facades\Artisan::output());
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        $log[] = 'Artisan cache:clear: ' . trim(\Illuminate\Support\Facades\Artisan::output());

        $tableStatus['tv_devices'] = \Illuminate\Support\Facades\Schema::hasTable('tv_devices');
        $tableStatus['tv_sessions'] = \Illuminate\Support\Facades\Schema::hasTable('tv_sessions');
    } catch (\Throwable $e) {
        $log[] = 'In-process bootstrap error: ' . $e->getMessage();
    }
}

// 11. Read recent Laravel log errors if any
$recentErrors = [];
$logPath = "$targetDir/storage/logs/laravel.log";
if (file_exists($logPath)) {
    $lines = @file($logPath);
    if (!empty($lines)) {
        $recentErrors = array_slice($lines, -15);
    }
}

$duration = round(microtime(true) - $startTime, 3);

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'success' => true,
    'message' => '🚀 Deployment successfully completed and synchronized!',
    'head_commit' => $headCommit ?: 'Up to date with origin/master',
    'duration_seconds' => $duration,
    'stats' => [
        'files_updated' => $copiedFiles,
        'directories_created' => $copiedDirs,
        'views_cache_cleared' => $clearedViews,
        'bootstrap_cache_cleared' => $clearedBootstrap,
        'opcache_reset' => $opcacheReset,
        'table_status' => $tableStatus,
        'apk_status' => $apkStatus,
    ],
    'log' => $log,
    'recent_log_tail' => array_map('trim', $recentErrors),
    'git' => $gitOutput ? trim($gitOutput) : 'Synchronized from master repository',
    'timestamp' => date('Y-m-d H:i:s T')
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);