<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AuditLog;

$items = AuditLog::orderBy('created_at', 'desc')->take(10)->get();
foreach ($items as $i) {
    echo $i->created_at->toISOString() . ' ' . $i->action . ' ' . ($i->payload ? json_encode($i->payload) : '') . PHP_EOL;
}
