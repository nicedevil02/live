<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Direct API Investigation ===\n\n";

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

$url = 'https://Api.BrsApi.ir/Market/Gold_Currency.php?key=B7zBRPpXvrVrPRtHYuknH9JXH1XwtxUw';

// Test 1: Get full response including headers
echo "Test 1: Full Response & Headers\n";
echo "---\n";
try {
    $response = Http::withOptions(['verify' => false])
        ->get($url);
    
    echo "HTTP Status: " . $response->status() . "\n";
    echo "Content-Type: " . $response->header('content-type') . "\n";
    echo "Content-Length: " . $response->header('content-length') . "\n";
    echo "Server: " . $response->header('server') . "\n";
    echo "X-Powered-By: " . $response->header('x-powered-by') . "\n";
    echo "Date: " . $response->header('date') . "\n";
    
    $data = $response->json();
    echo "\nParsed JSON Keys: " . implode(", ", array_keys($data)) . "\n";
    echo "Total Size: " . strlen($response->body()) . " bytes\n";
    
    // Check for rate limit headers
    echo "\nRate Limit Headers:\n";
    echo "X-RateLimit-Limit: " . $response->header('x-ratelimit-limit') . "\n";
    echo "X-RateLimit-Remaining: " . $response->header('x-ratelimit-remaining') . "\n";
    echo "X-RateLimit-Reset: " . $response->header('x-ratelimit-reset') . "\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n\nTest 2: Check if API has IP-based access control\n";
echo "---\n";

// Try with explicit localhost header
try {
    $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            'X-Forwarded-For' => '1.1.1.1',
        ])
        ->get($url);
    
    echo "With X-Forwarded-For: " . $response->status() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n\nTest 3: Check API changelog or version\n";
echo "---\n";

$baseUrl = 'https://Api.BrsApi.ir/Market/';
try {
    $response = Http::withOptions(['verify' => false])->get($baseUrl);
    echo "Base URL response status: " . $response->status() . "\n";
    echo "First 200 chars: " . substr($response->body(), 0, 200) . "\n";
} catch (\Exception $e) {
    echo "Base URL error: " . $e->getMessage() . "\n";
}

echo "\n\nTest 4: Request counter/ID in database\n";
echo "---\n";

// Check how many times we've hit this API
$auditCount = \App\Models\AuditLog::where('action', 'api_request_success')->count();
echo "Total successful requests logged: " . $auditCount . "\n";

$latestAudit = \App\Models\AuditLog::where('action', 'api_request_success')
    ->latest()
    ->first();
    
if ($latestAudit) {
    echo "Latest request time: " . $latestAudit->created_at . "\n";
    echo "Latency: " . $latestAudit->metadata['latency_ms'] ?? 'N/A' . " ms\n";
}
