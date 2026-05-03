<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_source_config', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->string('base_url');
            $table->text('fallback_urls')->nullable(); // JSON
            $table->string('auth_token')->default('');
            $table->integer('interval_seconds')->default(60);
            $table->boolean('is_active')->default(true);
            $table->string('last_status')->default('ok');
            $table->integer('last_latency_ms')->default(0);
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamps();
        });

        // منابع پیش‌فرض
        DB::table('api_source_config')->insert([
            [
                'key' => 'market',
                'label' => 'مارکت طلا و ارز',
                'base_url' => 'https://Api.BrsApi.ir/Market/Gold_Currency.php?key=B7dDfdamFZiX7K6fY3xMipNbAH6W8HGZ',
                'fallback_urls' => json_encode([]),
                'auth_token' => '',
                'interval_seconds' => 60,
                'is_active' => true,
                'last_status' => 'ok',
                'last_latency_ms' => 0,
                'last_checked_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('api_source_config');
    }
};