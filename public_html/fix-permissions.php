<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h3>Starting Permission Fix...</h3>";

function chmod_r($path) {
    if (!file_exists($path)) {
        return;
    }
    
    if (is_dir($path)) {
        // Set directories to 755
        @chmod($path, 0755);
        $items = scandir($path);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            chmod_r($path . '/' . $item);
        }
    } else {
        // Set files to 644
        @chmod($path, 0644);
    }
}

// Directories to recursively fix
$dirs = ['app', 'vendor', 'config', 'routes', 'bootstrap', 'resources', 'storage', 'public_html'];
foreach ($dirs as $dir) {
    $targetPath = dirname(__DIR__) . '/' . $dir;
    echo "Fixing permissions for: <b>$dir</b> ($targetPath)...<br>";
    chmod_r($targetPath);
}

echo "<h3>Permissions Fixed Successfully!</h3>";
