<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$output = "=== CACHE CLEAR AND FETCH TEST ===\n\n";

// Clear cache
try {
    \Cache::forget('market_last_fetch_at');
    $output .= "[OK] Cleared corrupted cache\n\n";
} catch (\Exception $e) {
    $output .= "[ERROR] Cache clear failed: {$e->getMessage()}\n\n";
}

// Force fetch
$output .= "Starting fetch...\n";
try {
    resolve(\App\Services\MarketService::class)->fetchAndCache();
    $output .= "[OK] Fetch completed\n\n";
} catch (\Exception $e) {
    $output .= "[ERROR] Fetch failed: {$e->getMessage()}\n\n";
}

// Check audit log
$output .= "=== Last 5 API Requests ===\n";
use App\Models\AuditLog;
AuditLog::where('entity_type', 'api_source')
    ->orderBy('created_at', 'desc')
    ->take(5)
    ->get()
    ->each(function($log) use (&$output) {
        $payload = $log->payload ?? [];
        $key = $payload['key'] ?? '?';
        $action = $log->action;
        $status = $payload['status'] ?? 'N/A';
        $error = $payload['error'] ?? '';
        
        $output .= "\n{$log->created_at->format('H:i:s')} | $action | $key | Status: $status";
        if ($error) $output .= " | Error: " . substr($error, 0, 50);
        $output .= "\n";
    });

echo $output;
