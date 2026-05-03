<?php
echo "Starting test...\n";

require __DIR__ . '/vendor/autoload.php';
echo "Vendor loaded\n";

try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "App bootstrapped\n";
} catch (\Exception $e) {
    echo "Bootstrap error: " . $e->getMessage() . "\n";
    exit(1);
}

try {
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "Kernel bootstrapped\n";
} catch (\Exception $e) {
    echo "Kernel error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "All loaded successfully\n";
