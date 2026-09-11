<?php
/**
 * ابزار تست ارتباط هاست با سرور بینگ (Bing Daily Wallpaper Diagnostic)
 */

$secretKey = 'tala_deploy_7f8c9b1e2a3d4f5';
$providedKey = $_GET['key'] ?? '';

if (!hash_equals($secretKey, $providedKey)) {
    http_response_code(403);
    die("<div style='font-family:Tahoma; direction:rtl; text-align:center; padding:50px; color:#b91c1c;'>دسترسی غیرمجاز: کلید امنیتی ارسال نشده یا اشتباه است.</div>");
}

header('Content-Type: text/html; charset=utf-8');

$report = [];
$today = date('Y-m-d');
$bingDir = __DIR__ . '/images/bing';
$todayFile = $bingDir . '/today.jpg';
$metaFile = $bingDir . '/meta.json';

$report['local_file_exists'] = file_exists($todayFile);
$report['local_file_size'] = file_exists($todayFile) ? round(filesize($todayFile) / 1024, 2) . ' KB' : 'وجود ندارد';
$report['local_file_time'] = file_exists($todayFile) ? date('Y-m-d H:i:s', filemtime($todayFile)) : '---';

// تست اتصال به بینگ
$apiUrl = 'https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=en-US';
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

$report['api_http_code'] = $httpCode;
$report['api_duration'] = $duration . ' ms';
$report['api_error'] = $curlError ?: 'بدون خطا';

$downloadSuccess = false;
$imageInfo = null;

if ($httpCode === 200 && $response) {
    $data = json_decode($response, true);
    if (!empty($data['images'][0])) {
        $imageInfo = $data['images'][0];
        $imgUrl = 'https://www.bing.com' . $imageInfo['urlbase'] . '_1920x1080.jpg';
        
        // تست دانلود فایل تصویر
        $chImg = curl_init();
        curl_setopt($chImg, CURLOPT_URL, $imgUrl);
        curl_setopt($chImg, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chImg, CURLOPT_TIMEOUT, 12);
        curl_setopt($chImg, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($chImg, CURLOPT_USERAGENT, 'Mozilla/5.0');
        
        $imgBytes = curl_exec($chImg);
        $imgCode = curl_getinfo($chImg, CURLINFO_HTTP_CODE);
        curl_close($chImg);
        
        $report['image_http_code'] = $imgCode;
        $report['image_bytes'] = strlen($imgBytes) . ' بایت';
        
        if ($imgCode === 200 && strlen($imgBytes) > 1000) {
            if (!is_dir($bingDir)) @mkdir($bingDir, 0755, true);
            @file_put_contents($todayFile, $imgBytes);
            
            $meta = [
                'url'       => '/images/bing/today.jpg?d=' . $today,
                'title'     => $imageInfo['title'] ?? 'عکس روز بینگ',
                'copyright' => $imageInfo['copyright'] ?? '',
                'date'      => $today,
            ];
            @file_put_contents($metaFile, json_encode($meta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            $downloadSuccess = true;
            $report['download_status'] = 'موفقیت‌آمیز - تصویر دانلود و روی هاست ذخیره شد.';
        } else {
            $report['download_status'] = 'خطا در دریافت بایت‌های تصویر';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تست ارتباط با بینگ - TalaLive</title>
    <style>
        body { font-family: Tahoma, sans-serif; background: #0f172a; color: #f8fafc; padding: 40px 20px; line-height: 1.7; }
        .box { max-width: 650px; margin: 0 auto; background: #1e293b; border: 1px solid #334155; border-radius: 16px; padding: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        h2 { color: #f59e0b; margin-top: 0; }
        .item { display: flex; justify-content: space-between; border-bottom: 1px solid #334155; padding: 10px 0; font-size: 14px; }
        .label { color: #94a3b8; }
        .val { font-weight: bold; font-family: monospace; direction: ltr; }
        .badge-ok { background: #065f46; color: #34d399; padding: 3px 8px; border-radius: 6px; }
        .badge-err { background: #881337; color: #f43f5e; padding: 3px 8px; border-radius: 6px; }
        .preview { margin-top: 20px; text-align: center; }
        .preview img { max-width: 100%; height: 220px; object-fit: cover; border-radius: 12px; border: 2px solid #f59e0b; }
    </style>
</head>
<body>
    <div class="box">
        <h2>✦ وضعیت ارتباط هاست با مایکروسافت بینگ</h2>
        
        <div class="item">
            <span class="label">فایل محلی today.jpg:</span>
            <span class="val"><?= $report['local_file_exists'] ? '<span class="badge-ok">موجود است (' . $report['local_file_size'] . ')</span>' : '<span class="badge-err">موجود نیست</span>' ?></span>
        </div>

        <div class="item">
            <span class="label">تاریخ فایل محلی:</span>
            <span class="val"><?= $report['local_file_time'] ?></span>
        </div>

        <div class="item">
            <span class="label">کد پاسخ API بینگ:</span>
            <span class="val"><?= $report['api_http_code'] == 200 ? '<span class="badge-ok">200 OK</span>' : '<span class="badge-err">' . $report['api_http_code'] . '</span>' ?></span>
        </div>

        <div class="item">
            <span class="label">مدت زمان پاسخ (Latency):</span>
            <span class="val"><?= $report['api_duration'] ?></span>
        </div>

        <div class="item">
            <span class="label">خطای شبکه cURL:</span>
            <span class="val"><?= $report['api_error'] ?></span>
        </div>

        <?php if (!empty($report['download_status'])): ?>
        <div class="item">
            <span class="label">نتیجه دانلود مستقیم:</span>
            <span class="val"><?= $downloadSuccess ? '<span class="badge-ok">' . $report['download_status'] . '</span>' : '<span class="badge-err">' . $report['download_status'] . '</span>' ?></span>
        </div>
        <?php endif; ?>

        <?php if ($imageInfo): ?>
        <div class="item">
            <span class="label">عنوان عکس روز بینگ:</span>
            <span class="val" style="direction: rtl; font-family: Tahoma;"><?= htmlspecialchars($imageInfo['title'] ?? '') ?></span>
        </div>
        <?php endif; ?>

        <div class="preview">
            <p style="font-size:13px; color:#94a3b8; margin-bottom:8px;">پیش‌نمایش تصویر فعلی روی هاست:</p>
            <img src="/images/bing/today.jpg?t=<?= time() ?>" onerror="this.src='/icons/icon-512x512.png'; this.style.borderColor='#ef4444';" alt="Bing Wallpaper">
        </div>
    </div>
</body>
</html>
