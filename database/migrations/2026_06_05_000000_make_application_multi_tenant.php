<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. اصلاح جدول کاربران: افزودن نام کاربری، نقش سوپرادمین و توکن نمایشگر تلویزیون
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('email');
            $table->string('display_token')->nullable()->unique()->after('username');
            $table->boolean('is_super_admin')->default(false)->after('is_admin');
        });

        // ۲. اصلاح جدول تنظیمات نمایش: افزودن user_id
        Schema::table('display_settings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('id');
        });

        // ۳. اصلاح جدول فرمول‌ها: افزودن user_id
        Schema::table('formula_config', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('id');
        });

        // ۴. اصلاح جدول اسلایدر محصولات: افزودن user_id
        Schema::table('product_slide', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('id');
        });

        // ۵. اصلاح جدول آیتم‌های فعال نمایش: افزودن user_id و تغییر کلید یونیک
        Schema::table('display_items', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('id');
            // حذف شاخص یونیک سراسری روی فیلد key
            $table->dropUnique('display_items_key_unique');
            // ایجاد کلید منحصربه‌فرد ترکیبی برای هر کاربر
            $table->unique(['user_id', 'key']);
        });

        // ۶. انتقال داده‌های مغازه فعلی به اکانت ادمین موجود
        $admin = DB::table('users')->where('is_admin', true)->first();
        if ($admin) {
            DB::table('users')->where('id', $admin->id)->update([
                'username' => 'admin',
                'is_super_admin' => true,
                'display_token' => 'dt_' . bin2hex(random_bytes(8))
            ]);
            DB::table('display_settings')->update(['user_id' => $admin->id]);
            DB::table('formula_config')->update(['user_id' => $admin->id]);
            DB::table('product_slide')->update(['user_id' => $admin->id]);
            DB::table('display_items')->update(['user_id' => $admin->id]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'display_token', 'is_super_admin']);
        });

        Schema::table('display_settings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('formula_config', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('product_slide', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('display_items', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropUnique(['user_id', 'key']);
            $table->unique('key');
        });
    }
};
