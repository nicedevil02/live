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
    echo "<h3 style='color: #fbbf24; margin-top: 0;'>⏳ در حال اجرای مایگریشن‌های دیتابیس...</h3>";
    flush();
    
    $status = Artisan::call('migrate', ['--force' => true]);
    $output = Artisan::output();
    
    echo "<h3 style='color: #34d399;'>✅ عملیات پایگاه داده با موفقیت انجام شد:</h3>";
    echo "<pre style='background: #1e293b; color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #334155; overflow-x: auto; font-family: monospace; font-size: 14px; text-align: left;' dir='ltr'>" . ($output ?: "Nothing to migrate. (دیتابیس بروز است)") . "</pre>";
    
    echo "<p style='color: #ef4444; font-weight: bold;'>⚠️ هشدار امنیتی: لطفاً پس از اتمام کار، این فایل (run-migrations.php) را از پوشه public_html پاک کنید!</p>";
} catch (\Exception $e) {
    echo "<h3 style='color: #f87171;'>❌ خطا در اجرای مایگریشن دیتابیس:</h3>";
    echo "<pre style='background: #1e293b; color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #334155; overflow-x: auto; font-family: monospace; font-size: 14px; text-align: left;' dir='ltr'>" . $e->getMessage() . "</pre>";
}

echo "</div>";
