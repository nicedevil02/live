<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BotNotificationSetting extends Model
{
    protected $fillable = [
        'bale_enabled',
        'bale_bot_token',
        'bale_chat_id',
        'telegram_enabled',
        'telegram_bot_token',
        'telegram_chat_id',
        'telegram_api_base',
        'notify_on_register',
        'last_bale_status',
        'last_telegram_status',
    ];

    protected $casts = [
        'bale_enabled'       => 'boolean',
        'telegram_enabled'   => 'boolean',
        'notify_on_register' => 'boolean',
    ];

    /**
     * دریافت ایمن رکورد تنظیمات ربات بدون بروز خطا در صورت اجرا نشدن مایگریشن
     */
    public static function current(): ?self
    {
        try {
            if (!Schema::hasTable('bot_notification_settings')) {
                return null;
            }

            return self::query()->first();
        } catch (\Throwable $e) {
            return null;
        }
    }
}
