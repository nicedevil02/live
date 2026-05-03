<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Network & IP Information ===\n\n";

// Check current IP
echo "Server IP: " . gethostbyname(gethostname()) . "\n";
echo "Client IP from request: " . request()->ip() . "\n\n";

// Test with IP logging from API
use Illuminate\Support\Facades\Http;

$testUrl = 'https://httpbin.org/ip';
echo "Testing with httpbin.org:\n";
try {
    $response = Http::withOptions(['verify' => false])->get($testUrl);
    $data = $response->json();
    echo "Detected IP: " . ($data['origin'] ?? 'Unknown') . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test if API endpoint shows unique request tracking
$url = 'https://Api.BrsApi.ir/Market/Gold_Currency.php?key=B7zBRPpXvrVrPRtHYuknH9JXH1XwtxUw';
echo "Testing API response metadata:\n";
try {
    $response = Http::withOptions(['verify' => false])->get($url);
    $data = $response->json();
    
    // Check if there's any meta/request info in response
    if (isset($data['meta'])) {
        echo "Meta: " . json_encode($data['meta']) . "\n";
    }
    if (isset($data['request_id'])) {
        echo "Request ID: " . $data['request_id'] . "\n";
    }
    if (isset($data['status'])) {
        echo "Status: " . $data['status'] . "\n";
    }
    
    echo "Response has " . count($data) . " top-level keys\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
