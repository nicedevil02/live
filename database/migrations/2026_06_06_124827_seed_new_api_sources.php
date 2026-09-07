<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\ApiSourceConfig;

return new class extends Migration
{
    public function up(): void
    {
        // ۱. انس جهانی (GoldAPI)
        ApiSourceConfig::updateOrCreate(
            ['key' => 'ounce_goldapi'],
            [
                'label' => 'انس جهانی (Gold-API.com)',
                'base_url' => 'https://api.gold-api.com/price/XAU/USD',
                'auth_token' => '',
                'interval_seconds' => 10,
                'is_active' => true,
                'fallback_urls' => [],
            ]
        );

        // ۲. بیت کوین (Binance)
        ApiSourceConfig::updateOrCreate(
            ['key' => 'btc_bin'],
            [
                'label' => 'بیت کوین (Binance)',
                'base_url' => 'https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT',
                'interval_seconds' => 10,
                'is_active' => true,
                'fallback_urls' => [],
            ]
        );

        // ۳. تتر (Zipodo)
        ApiSourceConfig::updateOrCreate(
            ['key' => 'usdt'],
            [
                'label' => 'تتر (Zipodo)',
                'base_url' => 'https://api.zipodo.ir/usdt/',
                'interval_seconds' => 10,
                'is_active' => true,
                'fallback_urls' => [],
            ]
        );

        // ۴. کانال پشتیبان بله
        ApiSourceConfig::updateOrCreate(
            ['key' => 'bale_backup'],
            [
                'label' => 'کانال پشتیبان بله (talanerkh)',
                'base_url' => 'https://ble.ir/s/talanerkh',
                'interval_seconds' => 60,
                'is_active' => true,
                'fallback_urls' => [],
            ]
        );
    }

    public function down(): void
    {
        ApiSourceConfig::whereIn('key', ['ounce_goldapi', 'btc_bin', 'usdt', 'bale_backup'])->delete();
    }
};
