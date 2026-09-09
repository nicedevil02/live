<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Boot Console Kernel instead of HTTP request to bypass HTTP middlewares (like StartSession)
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Force session driver to file to avoid database dependency
config(['session.driver' => 'file']);

header('Content-Type: text/html; charset=utf-8');

echo "<div style='font-family: Tahoma, sans-serif; direction: rtl; padding: 30px; background: #0f172a; color: #38bdf8; border-radius: 20px; margin: 40px auto; max-width: 700px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);'>";

try {
    echo "<h3 style='color: #fbbf24; margin-top: 0;'>⏳ در حال اجرای سیدر دیتابیس (ایجاد کاربر ادمین و اطلاعات پایه)...</h3>";
    flush();
    
    $status = Artisan::call('db:seed', ['--force' => true]);
    $output = Artisan::output();
    
    echo "<h3 style='color: #34d399;'>✅ اطلاعات پایه و کاربر ادمین با موفقیت ایجاد شدند:</h3>";
    echo "<pre style='background: #1e293b; color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #334155; overflow-x: auto; font-family: monospace; font-size: 14px; text-align: left;' dir='ltr'>" . ($output ?: "Seeding completed successfully.") . "</pre>";
    
    echo "<div style='background: #1e293b; color: #fbbf24; padding: 15px; border-radius: 12px; margin-top: 15px;'>";
    echo "🔑 <b>مشخصات ورود ادمین پیش‌فرض:</b><br>";
    echo "ایمیل: <code style='color: #f8fafc;'>nicedevil02@gmail.com</code><br>";
    echo "کلمه عبور: <code style='color: #f8fafc;'>Bahman+11</code><br>";
    echo "</div>";
    
    echo "<p style='color: #ef4444; font-weight: bold; margin-top: 20px;'>⚠️ هشدار امنیتی: پس از لاگین، حتماً کلمه عبور و ایمیل خود را تغییر دهید و فایل (run-seeder.php) را از روی هاست حذف کنید!</p>";
} catch (\Exception $e) {
    echo "<h3 style='color: #f87171;'>❌ خطا در اجرای سیدر:</h3>";
    echo "<pre style='background: #1e293b; color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #334155; overflow-x: auto; font-family: monospace; font-size: 14px; text-align: left;' dir='ltr'>" . $e->getMessage() . "</pre>";
}

echo "</div>";
