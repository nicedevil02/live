<?php
/**
 * ابزار تست و عیب‌یابی عکس روز بینگ و تم فعال - TalaLive
 */

$secretKey = 'tala_deploy_7f8c9b1e2a3d4f5';
$providedKey = $_GET['key'] ?? '';

if (!hash_equals($secretKey, $providedKey)) {
    http_response_code(403);
    die("<div style='font-family:Tahoma; direction:rtl; text-align:center; padding:50px; color:#b91c1c;'>دسترسی غیرمجاز: کلید امنیتی ارسال نشده یا اشتباه است.</div>");
}

header('Content-Type: text/html; charset=utf-8');

$bingDir = __DIR__ . '/images/bing';
$todayFile = $bingDir . '/today.jpg';
$metaFile = $bingDir . '/meta.json';
$today = date('Y-m-d');

// بررسی دیتابیس برای مشاهده تم فعال فروشگاه
$dbTheme = 'نامشخص';
try {
    $envFile = dirname(__DIR__) . '/.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $dbConfig = [];
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && !str_starts_with(trim($line), '#')) {
                [$k, $v] = explode('=', $line, 2);
                $dbConfig[trim($k)] = trim($v);
            }
        }
        $pdo = new PDO(
            "mysql:host=" . ($dbConfig['DB_HOST'] ?? '127.0.0.1') . ";port=" . ($dbConfig['DB_PORT'] ?? '3306') . ";dbname=" . ($dbConfig['DB_DATABASE'] ?? 'talaliv1_db1'),
            $dbConfig['DB_USERNAME'] ?? 'root',
            $dbConfig['DB_PASSWORD'] ?? '',
            [PDO::ATTR_TIMEOUT => 3]
        );
        $stmt = $pdo->query("SELECT user_id, theme_mode, shop_name FROM display_settings LIMIT 5");
        $settingsRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (\Throwable $e) {
    $settingsRows = [];
}

// در صورت درخواست دریافت مجدد یا اگر فایل موجود نباشد
$forceRefetch = isset($_GET['refetch']);

// آدرس بینگ جهانی (بدون mkt=en-US تا تصاویر جهانی و توریستی نظیر اسپانیا/فرانسه لود شوند)
$apiUrl = 'https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1';
if (isset($_GET['market']) && $_GET['market'] === 'us') {
    $apiUrl .= '&mkt=en-US';
}

$report = [];
$report['local_file_exists'] = file_exists($todayFile);
$report['local_file_size'] = file_exists($todayFile) ? round(filesize($todayFile) / 1024, 2) . ' KB' : 'وجود ندارد';
$report['local_file_time'] = file_exists($todayFile) ? date('Y-m-d H:i:s', filemtime($todayFile)) : '---';

$meta = file_exists($metaFile) ? json_decode(file_get_contents($metaFile), true) : [];

if ($forceRefetch || !file_exists($todayFile)) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 8);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    
    $start = microtime(true);
    $response = curl_exec($ch);
    $duration = round((microtime(true) - $start) * 1000);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($httpCode === 200 && $response) {
        $data = json_decode($response, true);
        if (!empty($data['images'][0])) {
            $imageInfo = $data['images'][0];
            $imgUrl = 'https://www.bing.com' . $imageInfo['urlbase'] . '_1920x1080.jpg';
            
            $chImg = curl_init();
            curl_setopt($chImg, CURLOPT_URL, $imgUrl);
            curl_setopt($chImg, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chImg, CURLOPT_TIMEOUT, 14);
            curl_setopt($chImg, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($chImg, CURLOPT_USERAGENT, 'Mozilla/5.0');
            $imgBytes = curl_exec($chImg);
            $imgCode = curl_getinfo($chImg, CURLINFO_HTTP_CODE);
            curl_close($chImg);
            
            if ($imgCode === 200 && strlen($imgBytes) > 1000) {
                if (!is_dir($bingDir)) @mkdir($bingDir, 0755, true);
                
                // پاکسازی فایل‌های قدیمی
                foreach (glob($bingDir . '/*') as $f) {
                    @unlink($f);
                }
                
                @file_put_contents($todayFile, $imgBytes);
                $meta = [
                    'url'       => '/images/bing/today.jpg?d=' . $today,
                    'title'     => $imageInfo['title'] ?? 'عکس روز بینگ',
                    'copyright' => $imageInfo['copyright'] ?? '',
                    'date'      => $today,
                ];
                @file_put_contents($metaFile, json_encode($meta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
                $report['refetch_status'] = 'تصویر جدید با موفقیت از بینگ جهانی دریافت و ذخیره شد!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تست و عیب‌یابی تم عکس بینگ - TalaLive</title>
    <style>
        body { font-family: Tahoma, sans-serif; background: #0b1120; color: #f8fafc; padding: 40px 20px; line-height: 1.7; }
        .box { max-width: 700px; margin: 0 auto; background: #1e293b; border: 1px solid #334155; border-radius: 20px; padding: 30px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); }
        h2 { color: #fbbf24; margin-top: 0; font-size: 20px; }
        .item { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; padding: 12px 0; font-size: 14px; }
        .label { color: #94a3b8; }
        .val { font-weight: bold; font-family: monospace; direction: ltr; }
        .badge-ok { background: #065f46; color: #34d399; padding: 4px 10px; border-radius: 8px; font-size: 12px; }
        .badge-warn { background: #854d0e; color: #fde047; padding: 4px 10px; border-radius: 8px; font-size: 12px; }
        .badge-err { background: #881337; color: #f43f5e; padding: 4px 10px; border-radius: 8px; font-size: 12px; }
        .btn { display: inline-block; background: #2563eb; hover:background: #1d4ed8; color: #fff; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: bold; font-size: 13px; transition: all 0.2s; }
        .preview { margin-top: 25px; text-align: center; }
        .preview img { max-width: 100%; height: 260px; object-fit: cover; border-radius: 16px; border: 2px solid #fbbf24; box-shadow: 0 10px 25px rgba(0,0,0,0.4); }
    </style>
</head>
<body>
    <div class="box">
        <h2>✦ وضعیت تصویر روز بینگ و تم فعال نمایشگر</h2>

        <?php if (!empty($report['refetch_status'])): ?>
            <div style="background:#065f46; color:#34d399; padding:12px; border-radius:10px; margin-bottom:15px; font-size:13px;">
                ✓ <?= htmlspecialchars($report['refetch_status']) ?>
            </div>
        <?php endif; ?>

        <!-- تم فعال ذخیره شده در دیتابیس -->
        <div class="item" style="background:#0f172a; padding:12px 15px; border-radius:10px; margin-bottom:10px;">
            <span class="label" style="color:#f8fafc; font-weight:bold;">تم ذخیره‌شده در دیتابیس (theme_mode):</span>
            <span class="val">
                <?php if (!empty($settingsRows)): ?>
                    <?php foreach ($settingsRows as $row): ?>
                        <span class="<?= $row['theme_mode'] === 'bing-daily' ? 'badge-ok' : 'badge-warn' ?>">
                            <?= htmlspecialchars($row['theme_mode']) ?> (<?= htmlspecialchars($row['shop_name'] ?: 'بدون نام') ?>)
                        </span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="badge-warn">دسترسی به جدول تنظیمات برقرار نشد</span>
                <?php endif; ?>
            </span>
        </div>

        <div class="item">
            <span class="label">فایل محلی today.jpg:</span>
            <span class="val"><?= file_exists($todayFile) ? '<span class="badge-ok">موجود است (' . round(filesize($todayFile)/1024, 2) . ' KB)</span>' : '<span class="badge-err">موجود نیست</span>' ?></span>
        </div>

        <div class="item">
            <span class="label">عنوان تصویر فعلی:</span>
            <span class="val" style="direction:rtl; font-family:Tahoma;"><?= htmlspecialchars($meta['title'] ?? '---') ?></span>
        </div>

        <div class="item">
            <span class="label">توضیحات و عکاس:</span>
            <span class="val" style="direction:rtl; font-family:Tahoma; font-size:12px; max-width:350px;"><?= htmlspecialchars($meta['copyright'] ?? '---') ?></span>
        </div>

        <div style="margin-top:20px; display:flex; gap:10px; justify-content:center;">
            <a href="?key=<?= htmlspecialchars($secretKey) ?>&refetch=1" class="btn">
                🔄 دریافت مجدد تصویر از بینگ جهانی (Global)
            </a>
            <a href="?key=<?= htmlspecialchars($secretKey) ?>&refetch=1&market=us" class="btn" style="background:#475569;">
                🇺🇸 دریافت تصویر نسخه آمریکا (US)
            </a>
        </div>

        <div class="preview">
            <p style="font-size:13px; color:#94a3b8; margin-bottom:10px;">پیش‌نمایش تصویر فعال روی هاست:</p>
            <img src="/images/bing/today.jpg?t=<?= time() ?>" alt="Bing Wallpaper">
        </div>
    </div>
</body>
</html>
