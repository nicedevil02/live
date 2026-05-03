<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ApiSourceConfig;
use App\Models\AuditLog;

echo "=== API SOURCE CONFIGURATION IN DATABASE ===\n\n";
$source = ApiSourceConfig::where('key', 'market')->first();
echo "Key: " . $source->key . "\n";
echo "URL: " . $source->base_url . "\n";
echo "Active: " . ($source->is_active ? 'YES' : 'NO') . "\n";
echo "Status: " . $source->last_status . "\n";
echo "Last Checked: " . $source->last_checked_at?->diffForHumans() . "\n\n";

// Extract the API key from the URL
if (preg_match('/key=([a-zA-Z0-9]+)/', $source->base_url, $matches)) {
    echo "API KEY BEING USED: " . $matches[1] . "\n\n";
}

echo "=== LAST 5 SUCCESSFUL REQUESTS ===\n\n";
AuditLog::where('entity_type', 'api_source')
    ->where('action', 'api_request_success')
    ->orderBy('created_at', 'desc')
    ->take(5)
    ->get()
    ->each(function($log) {
        $payload = $log->payload ?? [];
        echo "Time: " . $log->created_at->format('Y-m-d H:i:s') . "\n";
        echo "URL: " . ($payload['url'] ?? 'N/A') . "\n";
        echo "Status: " . ($payload['status'] ?? 'N/A') . "\n";
        echo "Latency: " . ($payload['latency_ms'] ?? 'N/A') . " ms\n";
        if (isset($payload['body_preview'])) {
            $preview = json_decode($payload['body_preview'], true);
            if ($preview && is_array($preview)) {
                echo "Response Keys: " . implode(', ', array_keys($preview)) . "\n";
            }
        }
        echo "\n";
    });
