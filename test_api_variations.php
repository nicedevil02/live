<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing API Request with Different Configurations ===\n\n";

use Illuminate\Support\Facades\Http;

$url = 'https://Api.BrsApi.ir/Market/Gold_Currency.php?key=B7zBRPpXvrVrPRtHYuknH9JXH1XwtxUw';

// Test 1: Current request method
echo "Test 1: Current Method (with retry)\n";
try {
    $response = Http::withOptions(['verify' => false])
        ->connectTimeout(10)
        ->timeout(15)
        ->retry(2, 1000)
        ->get($url);
    echo "Status: " . $response->status() . "\n";
    echo "Size: " . strlen($response->body()) . " bytes\n";
    $data = $response->json();
    echo "JSON Keys: " . implode(', ', array_keys($data ?? [])) . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: With User-Agent
echo "Test 2: With Custom User-Agent\n";
try {
    $response = Http::withOptions(['verify' => false])
        ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36')
        ->connectTimeout(10)
        ->timeout(15)
        ->get($url);
    echo "Status: " . $response->status() . "\n";
    echo "Size: " . strlen($response->body()) . " bytes\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Simple GET without all options
echo "Test 3: Simple GET Request\n";
try {
    $response = Http::withOptions(['verify' => false])->get($url);
    echo "Status: " . $response->status() . "\n";
    echo "Size: " . strlen($response->body()) . " bytes\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Check response headers
echo "Test 4: Response Headers\n";
try {
    $response = Http::withOptions(['verify' => false])->get($url);
    echo "Status: " . $response->status() . "\n";
    $headers = $response->headers();
    foreach ($headers as $key => $value) {
        echo "$key: " . (is_array($value) ? implode(', ', $value) : $value) . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
