<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('is_admin');
            $table->dateTime('expires_at')->nullable()->after('display_token');
        });

        // تایید کردن و معتبر ساختن بدون انقضای کاربران سوپر ادمین موجود
        DB::table('users')->where('is_admin', true)->update([
            'is_approved' => true,
            'expires_at'  => null // بدون انقضا برای سوپر ادمین
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_approved', 'expires_at']);
        });
    }
};
