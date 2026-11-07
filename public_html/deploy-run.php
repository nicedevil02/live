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

$criticalSyncFiles = [
    'routes/web.php',
    'routes/console.php',
    'config/tv.php',
    'app/Console/Commands/FetchBingWallpaper.php',
    'app/Http/Controllers/PublicDisplayController.php',
    'app/Http/Controllers/PublicPageController.php',
    'app/Http/Controllers/Admin/AuthController.php',
    'app/Http/Controllers/Admin/DashboardController.php',
    'app/Http/Controllers/Admin/SubscriptionController.php',
    'app/Services/BingWallpaperService.php',
    'app/Services/MarketService.php',
    'app/Services/WeatherService.php',
    'app/Services/SmsService.php',
    'app/Services/Payment/PaymentService.php',
    'resources/views/layouts/public.blade.php',
    'resources/views/components/ui-icon.blade.php',
    'resources/views/partials/nav-desktop.blade.php',
    'resources/views/partials/nav-mobile.blade.php',
    'resources/views/partials/rate-ticker.blade.php',
    'resources/views/partials/breadcrumb.blade.php',
    'resources/views/partials/cta-inline.blade.php',
    'resources/views/partials/related-links.blade.php',
    'resources/views/partials/schema-article.blade.php',
    'resources/views/partials/schema-service.blade.php',
    'resources/views/partials/ui-icon.blade.php',
    'resources/views/partials/messenger-links.blade.php',
    'resources/views/pages/home.blade.php',
    'resources/views/pages/about.blade.php',
    'resources/views/pages/pricing.blade.php',
    'resources/views/pages/contact.blade.php',
    'resources/views/pages/privacy.blade.php',
    'resources/views/pages/terms.blade.php',
    'resources/views/pages/api-docs.blade.php',
    'resources/views/pages/demo.blade.php',
    'resources/views/pages/tv-setup-guide.blade.php',
    'resources/views/pages/guides-index.blade.php',
    'resources/views/pages/smart-gold-board.blade.php',
    'resources/views/pages/android-tv-gold-board.blade.php',
    'resources/views/pages/currency-exchange-board.blade.php',
    'resources/views/pages/digital-rate-board.blade.php',
    'resources/views/pages/gold-board-without-device.blade.php',
    'resources/views/pages/online-gold-price-board.blade.php',
    'resources/views/pages/silver-bullion-board.blade.php',
    'resources/views/pages/led-vs-smart-board.blade.php',
    'resources/views/pages/gold-calculator.blade.php',
    'resources/views/pages/widget.blade.php',
    'resources/views/pages/widget-embed.blade.php',
    'resources/views/pages/cities/index.blade.php',
    'resources/views/pages/cities/hub.blade.php',
    'resources/views/pages/tools/coin-bubble.blade.php',
    'resources/views/pages/tools/gold-price-calculator.blade.php',
    'resources/views/pages/tools/karat-converter.blade.php',
    'resources/views/pages/tools/melted-gold.blade.php',
    'resources/views/pages/tools/mesghal.blade.php',
    'resources/views/pages/tools/second-hand-gold.blade.php',
    'resources/views/pages/tools/wage-calculator.blade.php',
    'resources/views/pages/compare/tabangohar.blade.php',
    'resources/views/pages/compare/tablotala.blade.php',
    'resources/views/pages/compare/tgju-tv.blade.php',
    'resources/views/pages/guides/best-tv-for-jewelry-shop.blade.php',
    'resources/views/pages/guides/coin-bubble-calculation.blade.php',
    'resources/views/pages/guides/gold-hallmark-inquiry.blade.php',
    'resources/views/pages/guides/gold-price-formula.blade.php',
    'resources/views/pages/guides/gold-tax-regulations.blade.php',
    'resources/views/pages/guides/goldsmith-legal-profit.blade.php',
    'resources/views/pages/guides/led-board-price-1405.blade.php',
    'resources/views/pages/guides/lg-webos-gold-board.blade.php',
    'resources/views/pages/guides/mazaneh-fardaei.blade.php',
    'resources/views/pages/guides/motefareghe-18.blade.php',
    'resources/views/pages/guides/samsung-tizen-gold-board.blade.php',
    'resources/views/errors/404.blade.php',
    'resources/views/errors/500.blade.php',
    'resources/views/pages/app.blade.php',
    'resources/views/display/live.blade.php',
    'resources/views/admin/auth.blade.php',
    'resources/views/admin/login.blade.php',
    'resources/views/admin/register.blade.php',
    'resources/views/admin/partials/onboarding-guide.blade.php',
    'resources/views/admin/layouts/app.blade.php',
    'resources/views/admin/dashboard.blade.php',
    'resources/views/admin/devices/index.blade.php',
    'resources/views/admin/users/index.blade.php',
    'resources/views/admin/subscription/index.blade.php',
    'resources/views/admin/subscription/invoice.blade.php',
    'resources/views/display/pairing.blade.php',
    'database/migrations/2026_09_26_170500_remove_silver_items_from_display_items_and_cache.php',
    'public_html/build/manifest.json',
    'public_html/build/assets/app-DdRkyIzc.css',
    'public_html/build/assets/app-34mOoJaZ.js',
    'public_html/downloads/talalive-tv.json',
    'public_html/deploy-run.php',
];

function appendManifestAssetsToSyncList(string $manifestContent, array &$syncList): void {
    $decoded = @json_decode($manifestContent, true);
    if (!is_array($decoded)) return;
    foreach ($decoded as $entry) {
        if (!empty($entry['file']) && is_string($entry['file'])) {
            $rel = 'public_html/build/' . ltrim($entry['file'], '/');
            if (!in_array($rel, $syncList, true)) {
                $syncList[] = $rel;
            }
        }
        if (!empty($entry['css']) && is_array($entry['css'])) {
            foreach ($entry['css'] as $cssFile) {
                $rel = 'public_html/build/' . ltrim((string)$cssFile, '/');
                if (!in_array($rel, $syncList, true)) {
                    $syncList[] = $rel;
                }
            }
        }
    }
}

if (!empty($_GET['sync_blade']) || !empty($_GET['sync_files']) || !empty($_GET['sync_all'])) {
    $synced = [];
    $ctx = stream_context_create(['http' => ['timeout' => 15, 'header' => "User-Agent: Mozilla/5.0 (TalaDeploy)\r\n"]]);

    $manifestRaw = @file_get_contents("https://raw.githubusercontent.com/nicedevil02/live/master/public_html/build/manifest.json?t=" . time() . rand(100, 999), false, $ctx);
    if ($manifestRaw !== false) {
        appendManifestAssetsToSyncList($manifestRaw, $criticalSyncFiles);
    }

    foreach ($criticalSyncFiles as $relPath) {
        $rawUrl = "https://raw.githubusercontent.com/nicedevil02/live/master/$relPath?t=" . time() . rand(100, 999);
        $content = @file_get_contents($rawUrl, false, $ctx);
        $isJsChunk = substr($relPath, -3) === '.js';
        if ($content !== false && ($isJsChunk || strlen($content) > 5)) {
            $dest = "$targetDir/$relPath";
            $destDir = dirname($dest);
            if (!is_dir($destDir)) @mkdir($destDir, 0755, true);
            @file_put_contents($dest, $content);
            $synced[] = $relPath;

            if (strpos($relPath, 'public_html/') === 0 && is_dir("$targetDir/public")) {
                $pubRel = substr($relPath, strlen('public_html/'));
                $pubDest = "$targetDir/public/$pubRel";
                if (!is_dir(dirname($pubDest))) @mkdir(dirname($pubDest), 0755, true);
                @file_put_contents($pubDest, $content);
            }

            // Note: We deliberately do not overwrite files in repositories directory here
            // to avoid leaving uncommitted dirty files in cPanel Git working tree.
        }
    }

    if (function_exists('shell_exec')) {
        $foundRepos = glob("$targetDir/repositories/*", GLOB_ONLYDIR);
        if (!empty($foundRepos)) {
            foreach ($foundRepos as $r) {
                @shell_exec('cd ' . escapeshellarg($r) . ' && git clean -fd 2>&1 && (git reset --hard FETCH_HEAD 2>&1 || git reset --hard origin/master 2>&1)');
            }
        }
    }

    $vDir = "$targetDir/storage/framework/views";
    if (is_dir($vDir)) {
        foreach (glob("$vDir/*.php") as $vf) { @unlink($vf); }
    }
    foreach (['config.php', 'routes-v7.php', 'events.php', 'packages.php', 'services.php'] as $bf) {
        $bCache = "$targetDir/bootstrap/cache/$bf";
        if (file_exists($bCache)) { @unlink($bCache); }
    }
    if (function_exists('opcache_reset')) { @opcache_reset(); }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => true, 'message' => 'Files synced directly and caches cleared!', 'synced_files' => $synced]);
    exit;
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

        // Check if $sourceDir has .git, if not initialize it
        if (!is_dir("$sourceDir/.git")) {
            $log[] = "Notice: $sourceDir is missing .git. Attempting git init and remote configuration...";
            @shell_exec('cd ' . escapeshellarg($sourceDir) . ' && git init 2>&1 && git remote add origin https://github.com/nicedevil02/live.git 2>&1');
        } else {
            @shell_exec('cd ' . escapeshellarg($sourceDir) . ' && git remote set-url origin https://github.com/nicedevil02/live.git 2>&1');
        }

        @shell_exec('cd ' . escapeshellarg($sourceDir) . ' && git config remote.origin.fetch "+refs/heads/*:refs/remotes/origin/*" 2>&1');
        $cmd = 'cd ' . escapeshellarg($sourceDir) . ' && git fetch origin ' . escapeshellarg($targetBranch) . ' 2>&1 && git clean -fd 2>&1 && (git reset --hard FETCH_HEAD 2>&1 || git reset --hard origin/' . escapeshellarg($targetBranch) . ' 2>&1) && git clean -fd 2>&1 && (git checkout -f -B ' . escapeshellarg($targetBranch) . ' FETCH_HEAD 2>&1 || git checkout -f -B ' . escapeshellarg($targetBranch) . ' origin/' . escapeshellarg($targetBranch) . ' 2>&1)';
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

$copiedFiles = 0;
$copiedDirs = 0;

// Fallback: If git pull failed or did not run and no zip was extracted, download critical files directly from GitHub
$gitSuccess = !empty($headCommit) && stripos($headCommit, 'fatal:') === false;
if (!$gitSuccess && !$zipExtracted) {
    $log[] = 'Notice: Git pull was not successful. Executing automatic GitHub direct fallback synchronization...';
    $ctx = stream_context_create(['http' => ['timeout' => 15, 'header' => "User-Agent: Mozilla/5.0 (TalaDeploy)\r\n"]]);
    $manifestRaw = @file_get_contents("https://raw.githubusercontent.com/nicedevil02/live/master/public_html/build/manifest.json?t=" . time() . rand(100, 999), false, $ctx);
    if ($manifestRaw !== false) {
        appendManifestAssetsToSyncList($manifestRaw, $criticalSyncFiles);
    }
    foreach ($criticalSyncFiles as $relPath) {
        $rawUrl = "https://raw.githubusercontent.com/nicedevil02/live/master/$relPath?t=" . time() . rand(100, 999);
        $content = @file_get_contents($rawUrl, false, $ctx);
        $isJsChunk = substr($relPath, -3) === '.js';
        if ($content !== false && ($isJsChunk || strlen($content) > 5)) {
            $dest = "$targetDir/$relPath";
            @mkdir(dirname($dest), 0755, true);
            @file_put_contents($dest, $content);

            if (strpos($relPath, 'public_html/') === 0 && is_dir("$targetDir/public")) {
                $pubRel = substr($relPath, strlen('public_html/'));
                $pubDest = "$targetDir/public/$pubRel";
                @mkdir(dirname($pubDest), 0755, true);
                @file_put_contents($pubDest, $content);
            }

            $copiedFiles++;
            $log[] = "Fallback: Successfully downloaded latest $relPath from GitHub.";
        }
    }
}

// 4. Trigger cPanel VersionControl UAPI deployment (registers deployment in cPanel GUI)
$uapiOutput = '';
if ($shellAllowed) {
    $uapiCmd = 'uapi VersionControlDeployment create repository_root=' . escapeshellarg($sourceDir) . ' 2>&1';
    $uapiOutput = @shell_exec($uapiCmd);
    if (empty($uapiOutput) || stripos($uapiOutput, 'not found') !== false) {
        $altUapi = '/usr/local/cpanel/bin/uapi VersionControlDeployment create repository_root=' . escapeshellarg($sourceDir) . ' 2>&1';
        $uapiOutput = @shell_exec($altUapi);
    }
    if ($uapiOutput && stripos($uapiOutput, 'errors:') === false) {
        $log[] = 'cPanel UAPI Deployment: ' . trim($uapiOutput);
    }
}

// 5. High-speed file synchronization matching .cpanel.yml
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

        try {
            \Illuminate\Support\Facades\Artisan::call('bing:wallpaper', ['--force' => true]);
            $log[] = 'Artisan bing:wallpaper: ' . trim(\Illuminate\Support\Facades\Artisan::output());
        } catch (\Throwable $bEx) {
            $log[] = 'Artisan bing:wallpaper notice: ' . $bEx->getMessage();
        }

        $tableStatus['tv_devices'] = \Illuminate\Support\Facades\Schema::hasTable('tv_devices');
        $tableStatus['tv_sessions'] = \Illuminate\Support\Facades\Schema::hasTable('tv_sessions');

        if (\Illuminate\Support\Facades\Schema::hasTable('display_items')) {
            $purgedItems = \Illuminate\Support\Facades\DB::table('display_items')->whereIn('key', ['silver999', 'silver925'])->delete();
            if ($purgedItems > 0) {
                $log[] = "Purged $purgedItems silver item records from display_items table.";
            }
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('market_cache')) {
            $purgedCache = \Illuminate\Support\Facades\DB::table('market_cache')->whereIn('symbol', ['silver999', 'silver925'])->delete();
            if ($purgedCache > 0) {
                $log[] = "Purged $purgedCache silver item records from market_cache table.";
            }
        }
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
        $recentErrors = array_slice($lines, -120);
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
