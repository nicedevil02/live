<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ApiSourceConfig;
use App\Models\AuditLog;

echo "=== API SOURCES CONFIGURATION ===\n\n";
ApiSourceConfig::all()->each(function($s) {
    echo "Key: {$s->key}\n";
    echo "  URL: {$s->base_url}\n";
    echo "  Active: " . ($s->is_active ? 'YES' : 'NO') . "\n";
    echo "  Status: {$s->last_status}\n";
    echo "  Last Error: " . ($s->last_error ?? 'None') . "\n";
    echo "  Last Checked: " . ($s->last_checked_at ? $s->last_checked_at->diffForHumans() : 'Never') . "\n\n";
});

echo "=== RECENT API REQUEST AUDIT LOG (Last 15) ===\n\n";
AuditLog::where('entity_type', 'api_source')
    ->orderBy('created_at', 'desc')
    ->take(15)
    ->get()
    ->each(function($log) {
        $payload = $log->payload ?? [];
        echo $log->created_at->format('H:i:s') . " | {$log->action}\n";
        echo "  Key: " . ($payload['key'] ?? 'N/A') . "\n";
        if (isset($payload['status'])) echo "  HTTP Status: {$payload['status']}\n";
        if (isset($payload['error'])) echo "  Error: {$payload['error']}\n";
        echo "\n";
    });
