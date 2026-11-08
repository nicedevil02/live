<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // به‌روزرسانی عنوان تتر به «تتر (دلار دیجیتال)» در تابلوی تمام کاربران
        DB::table('display_items')
            ->where('key', 'usdt')
            ->update(['label' => 'تتر (دلار دیجیتال)']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('display_items')
            ->where('key', 'usdt')
            ->update(['label' => 'تتر (ارز دیجیتال)']);
    }
};
