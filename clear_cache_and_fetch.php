<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Cache;

echo "=== CLEARING CORRUPTED CACHE ===\n";
Cache::forget('market_last_fetch_at');
echo "✓ Cleared market_last_fetch_at\n\n";

echo "=== FORCING FRESH FETCH ===\n";
try {
    \Log::info('Manual fresh fetch started');
    resolve(\App\Services\MarketService::class)->fetchAndCache();
    echo "✓ Fetch completed successfully\n";
} catch (\Exception $e) {
    echo "✗ Fetch failed: " . $e->getMessage() . "\n";
}

echo "\n=== CHECKING AUDIT LOG ===\n";
use App\Models\AuditLog;
$recent = AuditLog::where('entity_type', 'api_source')
    ->orderBy('created_at', 'desc')
    ->take(5)
    ->get();

foreach ($recent as $log) {
    $payload = $log->payload ?? [];
    echo $log->created_at->format('H:i:s') . " | {$log->action} | Key: " . ($payload['key'] ?? '?') . "\n";
    if (isset($payload['status'])) echo "    Status: {$payload['status']}\n";
    if (isset($payload['error'])) echo "    Error: {$payload['error']}\n";
}
