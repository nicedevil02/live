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

$sourceDir = '/home/talaliv1/repositories/live';
$targetDir = '/home/talaliv1';

// Fallback detection if paths differ
if (!is_dir($sourceDir)) {
    $docRoot = dirname(__DIR__); // /home/talaliv1
    if (is_dir("$docRoot/repositories/live")) {
        $sourceDir = "$docRoot/repositories/live";
        $targetDir = $docRoot;
    }
}

if (!is_dir($sourceDir)) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'message' => 'Source repository not found at: ' . $sourceDir
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// 2. Try git pull if shell_exec is allowed
$gitOutput = '';
if (function_exists('shell_exec')) {
    $disabled = explode(',', (string)ini_get('disable_functions'));
    $disabled = array_map('trim', $disabled);
    if (!in_array('shell_exec', $disabled)) {
        $cmd = 'cd ' . escapeshellarg($sourceDir) . ' && git fetch origin master 2>&1 && git reset --hard origin/master 2>&1';
        $gitOutput = @shell_exec($cmd);
        if ($gitOutput) {
            $log[] = 'Git pull output: ' . trim($gitOutput);
        }
    }
}

// 3. Define directories and files to sync
$dirsToSync = [
    'app',
    'bootstrap',
    'config',
    'database',
    'resources',
    'routes',
];

$filesToSync = [
    'artisan',
    'composer.json',
    'package.json',
];

$copiedFiles = 0;
$copiedDirs = 0;

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
            if (!file_exists($target) || filemtime($item->getRealPath()) > filemtime($target) || filesize($item->getRealPath()) !== filesize($target)) {
                @copy($item->getRealPath(), $target);
                $copiedFiles++;
            }
        }
    }
}

// Sync core directories
foreach ($dirsToSync as $dir) {
    syncDirectory("$sourceDir/$dir", "$targetDir/$dir", $copiedFiles, $copiedDirs);
}

// Sync public_html (exclude deploy script itself to prevent overwrite while executing)
syncDirectory("$sourceDir/public_html", "$targetDir/public_html", $copiedFiles, $copiedDirs, ['deploy-run.php']);

// Sync root files
foreach ($filesToSync as $file) {
    $srcFile = "$sourceDir/$file";
    $dstFile = "$targetDir/$file";
    if (file_exists($srcFile)) {
        if (!file_exists($dstFile) || filemtime($srcFile) > filemtime($dstFile) || filesize($srcFile) !== filesize($dstFile)) {
            @copy($srcFile, $dstFile);
            $copiedFiles++;
        }
    }
}

// 4. Clear Blade compiled views cache
$viewCacheDir = "$targetDir/storage/framework/views";
$clearedViews = 0;
if (is_dir($viewCacheDir)) {
    foreach (glob("$viewCacheDir/*.php") as $vFile) {
        @unlink($vFile);
        $clearedViews++;
    }
}

// 5. Run Artisan migrations and optimize cache
$migrateOutput = '';
if (function_exists('shell_exec')) {
    $disabled = explode(',', (string)ini_get('disable_functions'));
    $disabled = array_map('trim', $disabled);
    if (!in_array('shell_exec', $disabled)) {
        $phpBin = PHP_BINARY ?: 'php';
        $migrateCmd = 'cd ' . escapeshellarg($targetDir) . ' && ' . escapeshellarg($phpBin) . ' artisan migrate --force 2>&1';
        $migrateOutput = @shell_exec($migrateCmd);
        if ($migrateOutput) {
            $log[] = 'Migrate output: ' . trim($migrateOutput);
        }
    }
}

$duration = round(microtime(true) - $startTime, 3);

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'success' => true,
    'message' => '🚀 Deployment successfully completed!',
    'duration_seconds' => $duration,
    'stats' => [
        'files_synced' => $copiedFiles,
        'directories_created' => $copiedDirs,
        'views_cache_cleared' => $clearedViews,
    ],
    'git' => $gitOutput ? trim($gitOutput) : 'Synchronized from repository snapshot',
    'timestamp' => date('Y-m-d H:i:s T')
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);