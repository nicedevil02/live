<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('bot_notification_settings')) {
            Schema::create('bot_notification_settings', function (Blueprint $table) {
                $table->id();
                $table->boolean('bale_enabled')->default(false);
                $table->text('bale_bot_token')->nullable();
                $table->string('bale_chat_id', 64)->nullable();
                $table->boolean('telegram_enabled')->default(false);
                $table->text('telegram_bot_token')->nullable();
                $table->string('telegram_chat_id', 64)->nullable();
                $table->string('telegram_api_base', 255)->nullable();
                $table->boolean('notify_on_register')->default(true);
                $table->string('last_bale_status', 500)->nullable();
                $table->string('last_telegram_status', 500)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('bot_notification_settings');
    }
};
