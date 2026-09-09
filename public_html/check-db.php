<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
config(['session.driver' => 'file']);

header('Content-Type: text/html; charset=utf-8');

echo "<div style='font-family: Tahoma, sans-serif; direction: rtl; padding: 30px; background: #0f172a; color: #38bdf8; border-radius: 20px; margin: 40px auto; max-width: 700px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);'>";
echo "<h3 style='color: #fbbf24; margin-top: 0;'>🔍 تست سلامت دیتابیس و جدول‌ها:</h3>";

try {
    // 1. Check connection
    DB::connection()->getPdo();
    echo "✅ اتصال به دیتابیس برقرار است.<br><br>";

    // 2. Check tables
    $tables = ['users', 'sessions', 'display_settings', 'formula_config', 'product_slide', 'display_items'];
    echo "<b>وضعیت جدول‌ها:</b><ul style='text-align: left;' dir='ltr'>";
    foreach ($tables as $table) {
        $exists = Schema::hasTable($table);
        $statusIcon = $exists ? "✅" : "❌";
        echo "<li>$statusIcon $table</li>";
    }
    echo "</ul>";

    // 3. Check users count
    if (Schema::hasTable('users')) {
        $count = DB::table('users')->count();
        echo "👥 تعداد کاربران ثبت شده: <b>$count</b><br>";
        
        $users = DB::table('users')->get();
        echo "<pre style='background: #1e293b; color: #f8fafc; padding: 10px; border-radius: 8px; font-size: 11px; overflow-x: auto; text-align: left;' dir='ltr'>";
        foreach ($users as $u) {
            echo "ID: {$u->id} | Email: {$u->email} | Username: " . ($u->username ?? 'NULL') . " | Admin: {$u->is_admin} | SuperAdmin: " . ($u->is_super_admin ?? 'NULL') . " | Approved: " . ($u->is_approved ?? 'NULL') . "\n";
        }
        echo "</pre>";
    }

} catch (\Exception $e) {
    echo "<h3 style='color: #f87171;'>❌ خطا:</h3>";
    echo "<pre style='background: #1e293b; color: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #334155; overflow-x: auto; font-family: monospace; font-size: 14px; text-align: left;' dir='ltr'>" . $e->getMessage() . "</pre>";
}

echo "<p style='color: #ef4444; font-weight: bold;'>⚠️ هشدار امنیتی: لطفاً پس از اتمام کار، این فایل (check-db.php) را از پوشه public_html پاک کنید!</p>";
echo "</div>";
