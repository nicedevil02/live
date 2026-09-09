<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

header('Content-Type: text/html; charset=utf-8');

echo "<div style='font-family: Tahoma, sans-serif; direction: rtl; padding: 30px; background: #0f172a; color: #38bdf8; border-radius: 20px; margin: 40px auto; max-width: 700px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);'>";
echo "<h3 style='color: #fbbf24; margin-top: 0;'>🔧 عیب‌یابی و اصلاح پوشه آپلود تصاویر (Storage)...</h3>";

try {
    // 1. Create directory if missing
    $publicStoragePath = storage_path('app/public');
    $productsPath = $publicStoragePath . '/products';
    
    if (!file_exists($productsPath)) {
        echo "⏳ در حال ساخت پوشه محصولات: $productsPath...<br>";
        if (mkdir($productsPath, 0755, true)) {
            echo "✅ پوشه با موفقیت ساخته شد.<br>";
        } else {
            echo "❌ خطا در ساخت پوشه محصولات!<br>";
        }
    } else {
        echo "✅ پوشه محصولات از قبل وجود دارد.<br>";
    }

    // 2. Fix permissions
    echo "⏳ در حال تنظیم دسترسی پوشه‌ها به 775...<br>";
    @chmod(storage_path(), 0775);
    @chmod(storage_path('app'), 0775);
    @chmod($publicStoragePath, 0775);
    @chmod($productsPath, 0775);
    @chmod(storage_path('framework/views'), 0775);
    @chmod(storage_path('framework/sessions'), 0775);
    @chmod(storage_path('logs'), 0775);
    echo "✅ دسترسی‌های پوشه‌های اصلی تصحیح شد.<br>";

    // 3. Check/Create Symlink
    $linkPath = base_path('public_html/storage');
    
    if (is_link($linkPath)) {
        echo "⏳ حذف میانبر (Symlink) قدیمی یا خراب...<br>";
        @unlink($linkPath);
    } elseif (is_dir($linkPath)) {
        echo "⏳ شناسایی پوشه فیزیکی storage. در حال تغییر نام آن به storage_old...<br>";
        $newName = $linkPath . '_old_' . time();
        if (@rename($linkPath, $newName)) {
            echo "✅ پوشه قدیمی به <b>" . basename($newName) . "</b> تغییر نام یافت.<br>";
        } else {
            echo "❌ خطا در تغییر نام پوشه قدیمی!<br>";
        }
    } elseif (file_exists($linkPath)) {
        echo "⏳ حذف فایل مزاحم قدیمی...<br>";
        @unlink($linkPath);
    }
    
    echo "⏳ ایجاد میانبر (Symlink) جدید برای تصاویر...<br>";
    if (symlink($publicStoragePath, $linkPath)) {
        echo "✅ میانبر با موفقیت به <b>public_html/storage</b> ایجاد شد.<br>";
    } else {
        echo "❌ خطا در ایجاد میانبر! احتمالاً به دلیل محدودیت‌های هاست است.<br>";
    }

    // 4. Test Writable
    $testFile = $productsPath . '/test.txt';
    if (@file_put_contents($testFile, 'test')) {
        echo "✅ تست نوشتن در پوشه با موفقیت انجام شد (پوشه کاملاً قابل نوشتن است).<br>";
        @unlink($testFile);
    } else {
        echo "❌ پوشه قابل نوشتن نیست! لطفاً دسترسی پوشه storage و زیرمجموعه‌های آن را در cPanel به صورت دستی بررسی کنید.<br>";
    }

} catch (\Exception $e) {
    echo "<h3 style='color: #f87171;'>❌ خطا:</h3>";
    echo "<pre style='background: #1e293b; color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #334155; overflow-x: auto; font-family: monospace; font-size: 14px; text-align: left;' dir='ltr'>" . $e->getMessage() . "</pre>";
}

echo "<p style='color: #ef4444; font-weight: bold; margin-top: 20px;'>⚠️ هشدار امنیتی: لطفاً پس از اتمام کار، این فایل (fix-storage.php) را از پوشه public_html پاک کنید!</p>";
echo "</div>";
