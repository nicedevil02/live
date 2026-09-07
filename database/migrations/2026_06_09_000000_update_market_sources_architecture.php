<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\ApiSourceConfig;

return new class extends Migration
{
    public function up(): void
    {
        // اطمینان از Auto Increment بودن فیلد id در دیتابیس MySQL هاست
        try {
            if (DB::getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE `api_source_config` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");
            }
        } catch (\Exception $e) {
            // در صورت وجود محدودیت خاص، رد می‌شود
        }

        // ۱. حذف منابع حذف شده (انس گلد ای‌پی‌آی، بایننس، نرخیاب و هر منبع قدیمی دیگر)
        ApiSourceConfig::whereIn('key', ['ounce_goldapi', 'btc_bin', 'market', 'exchange_gold'])->delete();
        ApiSourceConfig::where('base_url', 'like', '%nerkh.io%')->delete();

        // تعریف منابع جدید
        $sources = [
            [
                'key' => 'bale_channel',
                'label' => 'کانال تالالایو (talaliveir) - منبع اصلی',
                'base_url' => 'https://ble.ir/s/talaliveir',
                'auth_token' => '',
                'interval_seconds' => 60,
                'is_active' => true,
                'fallback_urls' => [],
            ],
            [
                'key' => 'bale_backup',
                'label' => 'کانال پشتیبان بله (talanerkh) - فال‌بک اضطراری',
                'base_url' => 'https://ble.ir/s/talanerkh',
                'auth_token' => '',
                'interval_seconds' => 60,
                'is_active' => true,
                'fallback_urls' => [],
            ],
            [
                'key' => 'usdt',
                'label' => 'تتر (Zipodo)',
                'base_url' => 'https://api.zipodo.ir/usdt/',
                'auth_token' => '',
                'interval_seconds' => 10,
                'is_active' => true,
                'fallback_urls' => [],
            ],
        ];

        foreach ($sources as $data) {
            $existing = ApiSourceConfig::where('key', $data['key'])->first();
            if ($existing) {
                $existing->update($data);
            } else {
                $nextId = (int)(DB::table('api_source_config')->max('id') ?? 0) + 1;
                $record = new ApiSourceConfig();
                $record->id = $nextId;
                $record->key = $data['key'];
                $record->label = $data['label'];
                $record->base_url = $data['base_url'];
                $record->auth_token = $data['auth_token'];
                $record->interval_seconds = $data['interval_seconds'];
                $record->is_active = $data['is_active'];
                $record->fallback_urls = $data['fallback_urls'];
                $record->save();
            }
        }
    }

    public function down(): void
    {
        ApiSourceConfig::whereIn('key', ['bale_channel'])->delete();
    }
};
