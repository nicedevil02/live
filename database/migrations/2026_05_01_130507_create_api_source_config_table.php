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
    }

    public function down(): void
    {
        Schema::dropIfExists('api_source_config');
    }
};