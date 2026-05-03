<?php
require __DIR__ . '/vendor/autoload.php';

echo "=== Direct cURL Test ===\n\n";

$url = 'https://Api.BrsApi.ir/Market/Gold_Currency.php?key=B7zBRPpXvrVrPRtHYuknH9JXH1XwtxUw';

// Test 1: Using PHP streams
echo "Test 1: PHP Streams (file_get_contents)\n";
echo "---\n";

$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'timeout' => 10
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false
    ]
]);

$start = microtime(true);
$response = @file_get_contents($url, false, $context);
$time = (microtime(true) - $start) * 1000;

if ($response !== false) {
    echo "✓ Success\n";
    echo "Status: 200\n";
    echo "Response size: " . strlen($response) . " bytes\n";
    echo "Time: " . round($time, 2) . " ms\n";
    $data = json_decode($response, true);
    echo "JSON Keys: " . implode(", ", array_keys($data ?? [])) . "\n";
} else {
    echo "✗ Failed\n";
    if (isset($http_response_header)) {
        print_r($http_response_header);
    }
}

echo "\n";

// Test 2: Direct cURL
echo "Test 2: Using cURL\n";
echo "---\n";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'Connection: close'
    ]
]);

$start = microtime(true);
$response = curl_exec($ch);
$time = (microtime(true) - $start) * 1000;
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

if ($response !== false) {
    echo "✓ Success\n";
    echo "HTTP Status: " . $httpCode . "\n";
    echo "Response size: " . strlen($response) . " bytes\n";
    echo "Time: " . round($time, 2) . " ms\n";
    $data = json_decode($response, true);
    echo "JSON Keys: " . implode(", ", array_keys($data ?? [])) . "\n";
} else {
    echo "✗ Failed\n";
    echo "Error: " . $error . "\n";
}

curl_close($ch);

echo "\n";

// Test 3: Check if API is even accessible
echo "Test 3: Basic Connectivity\n";
echo "---\n";

$parts = parse_url($url);
$host = $parts['host'];
$port = 443;

echo "Resolving " . $host . "...\n";
$ip = @gethostbyname($host);
if ($ip !== $host) {
    echo "✓ Resolved to: " . $ip . "\n";
} else {
    echo "✗ Could not resolve hostname\n";
}

// Try to connect
$sock = @fsockopen('ssl://' . $host, $port, $errno, $errstr, 5);
if ($sock) {
    echo "✓ Can connect to " . $host . ":443\n";
    fclose($sock);
} else {
    echo "✗ Cannot connect: " . $errstr . " (" . $errno . ")\n";
}
