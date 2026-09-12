<?php
/**
 * ابزار تست و عیب‌یابی دریافت ۱۰ ثانیه‌ای نرخ تتر - TalaLive
 */

$secretKey = 'tala_deploy_7f8c9b1e2a3d4f5';
$providedKey = $_GET['key'] ?? '';

if (!hash_equals($secretKey, $providedKey)) {
    http_response_code(403);
    die(json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_UNICODE));
}

header('Content-Type: application/json; charset=utf-8');

$baseDir = dirname(__DIR__);
$report = [
    'timestamp' => date('Y-m-d H:i:s'),
    'timezone' => date_default_timezone_get(),
    'tehran_hour' => (int) (new DateTime('now', new DateTimeZone('Asia/Tehran')))->format('G'),
];

// 1. Connect to Database via .env
try {
    $envFile = $baseDir . '/.env';
    $dbConfig = [];
    if (file_exists($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (strpos($line, '=') !== false && !str_starts_with(trim($line), '#')) {
                [$k, $v] = explode('=', $line, 2);
                $dbConfig[trim($k)] = trim($v);
            }
        }
    }

    $pdo = new PDO(
        "mysql:host=" . ($dbConfig['DB_HOST'] ?? '127.0.0.1') . ";port=" . ($dbConfig['DB_PORT'] ?? '3306') . ";dbname=" . ($dbConfig['DB_DATABASE'] ?? 'talaliv1_db1'),
        $dbConfig['DB_USERNAME'] ?? 'root',
        $dbConfig['DB_PASSWORD'] ?? '',
        [PDO::ATTR_TIMEOUT => 3]
    );

    // Get USDT from market_caches
    $stmt = $pdo->prepare("SELECT * FROM market_caches WHERE symbol = 'usdt' LIMIT 1");
    $stmt->execute();
    $usdtRow = $stmt->fetch(PDO::FETCH_ASSOC);

    $report['usdt_in_db'] = $usdtRow ?: 'رکورد تتر در دیتابیس یافت نشد!';
    if ($usdtRow && !empty($usdtRow['fetched_at'])) {
        $fetchedAt = new DateTime($usdtRow['fetched_at']);
        $now = new DateTime();
        $diffSec = $now->getTimestamp() - $fetchedAt->getTimestamp();
        $report['usdt_age_seconds'] = $diffSec;
        $report['usdt_is_recent'] = ($diffSec < 30) ? 'بله (تازه و برخط)' : "خیر ({$diffSec} ثانیه پیش)";
    }

    // Get ApiSourceConfig for USDT
    $stmtSource = $pdo->prepare("SELECT * FROM api_source_configs WHERE `key` = 'usdt' LIMIT 1");
    $stmtSource->execute();
    $sourceRow = $stmtSource->fetch(PDO::FETCH_ASSOC);
    $report['usdt_source_config'] = $sourceRow ?: 'منبع تتر ثبت نشده است!';

} catch (\\Throwable $e) {
    $report['db_error'] = $e->getMessage();
}

// 2. Direct HTTP call to Zipodo API from server
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.zipodo.ir/usdt/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 6);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$start = microtime(true);
$res = curl_exec($ch);
$latency = round((microtime(true) - $start) * 1000);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

$report['zipodo_curl_http_code'] = $httpCode;
$report['zipodo_curl_latency_ms'] = $latency;
$report['zipodo_curl_error'] = $curlErr ?: null;
$report['zipodo_raw_response'] = $res ? json_decode($res, true) : null;

// 3. If action=force_fetch is requested, perform direct save to DB
if (isset($_GET['action']) && $_GET['action'] === 'force_fetch' && isset($pdo)) {
    if ($httpCode === 200 && $res) {
        $data = json_decode($res, true);
        if (!empty($data['price'])) {
            $val = (float)$data['price'];
            $nowStr = date('Y-m-d H:i:s');
            
            $stmtUp = $pdo->prepare("
                INSERT INTO market_caches (symbol, value, unit, change_value, change_percent, direction, is_stale, fetched_at, created_at, updated_at)
                VALUES ('usdt', :val, 'تومان', 0, 0, 'flat', 0, :now, :now, :now)
                ON DUPLICATE KEY UPDATE value = :val, is_stale = 0, fetched_at = :now, updated_at = :now
            ");
            $stmtUp->execute(['val' => $val, 'now' => $nowStr]);
            $report['force_fetch_result'] = "تتر با قیمت {$val} تومان با موفقیت در دیتابیس ثبت شد.";
        }
    }
}

echo json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
