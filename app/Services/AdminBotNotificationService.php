<?php

namespace App\Services;

use App\Models\BotNotificationSetting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AdminBotNotificationService
{
    private const PLATFORMS = [
        'bale' => [
            'label'        => 'بله',
            'default_base' => 'https://tapi.bale.ai',
        ],
        'telegram' => [
            'label'        => 'تلگرام',
            'default_base' => 'https://api.telegram.org',
        ],
    ];

    /**
     * استخراج تنظیمات فعال ربات‌ها از دیتابیس با فال‌بک به env
     */
    public function getEffectiveConfig(): array
    {
        $dbSetting = BotNotificationSetting::current();

        $platforms = [];
        foreach (self::PLATFORMS as $key => $meta) {
            $token = trim((string) ($dbSetting?->{"{$key}_bot_token"} ?: config("services.{$key}.bot_token", '')));
            $chatId = trim((string) ($dbSetting?->{"{$key}_chat_id"} ?: config("services.{$key}.chat_id", '')));
            $apiBase = $key === 'telegram'
                ? rtrim(trim((string) ($dbSetting?->telegram_api_base ?: config('services.telegram.api_base', $meta['default_base']))), '/')
                : $meta['default_base'];

            if ($apiBase === '') {
                $apiBase = $meta['default_base'];
            }

            $enabled = $dbSetting
                ? (bool) $dbSetting->{"{$key}_enabled"}
                : (bool) config("services.{$key}.enabled", true) && $token !== '' && $chatId !== '';

            $platforms[$key] = [
                'label'       => $meta['label'],
                'enabled'     => $enabled,
                'bot_token'   => $token,
                'chat_id'     => $chatId,
                'api_base'    => $apiBase,
                'configured'  => $token !== '' && $chatId !== '',
                'last_status' => $dbSetting?->{"last_{$key}_status"},
            ];
        }

        return [
            'has_db_row'         => $dbSetting !== null,
            'notify_on_register' => $dbSetting ? (bool) $dbSetting->notify_on_register : true,
            'platforms'          => $platforms,
        ];
    }

    /**
     * ساخت متن پیام اطلاع‌رسانی ثبت‌نام کاربر جدید
     */
    public function buildNewRegistrationMessage(User $user): string
    {
        $createdAt = ($user->created_at ?? now())->copy()->setTimezone('Asia/Tehran');
        $jalaliDate = User::toJalali($createdAt, true);
        $cityName = $user->city_name ?: 'ثبت‌نشده';
        $boardUrl = rtrim((string) config('app.url', 'https://talalive.ir'), '/') . '/' . ltrim((string) $user->username, '/');

        return implode("\n", [
            '🆕 ثبت‌نام کاربر جدید در طلالایو',
            '',
            "🏪 نام گالری: {$user->name}",
            "📱 شماره موبایل: {$user->phone}",
            "📍 شهر: {$cityName}",
            "👤 نام کاربری: @{$user->username}",
            "🔗 لینک تابلو: {$boardUrl}",
            "🕒 زمان ثبت‌نام: {$jalaliDate}",
            '⏳ دوره آزمایشی: ۱۴ روز رایگان',
        ]);
    }

    /**
     * زمان‌بندی ارسال غیرمسدودکننده اعلان پس از پاسخ HTTP ثبت‌نام
     */
    public function dispatchNewRegistrationNotification(User $user): void
    {
        try {
            $config = $this->getEffectiveConfig();
            if (!$config['notify_on_register']) {
                return;
            }

            $hasActivePlatform = false;
            foreach ($config['platforms'] as $platform) {
                if ($platform['enabled'] && $platform['configured']) {
                    $hasActivePlatform = true;
                    break;
                }
            }

            if (!$hasActivePlatform) {
                return;
            }

            $message = $this->buildNewRegistrationMessage($user);

            app()->terminating(function () use ($message) {
                try {
                    $this->sendToActivePlatforms($message);
                } catch (\Throwable $e) {
                    Log::warning('AdminBotNotification terminating dispatch failed: ' . $e->getMessage());
                }
            });
        } catch (\Throwable $e) {
            Log::warning('AdminBotNotification dispatch setup failed: ' . $e->getMessage());
        }
    }

    /**
     * ارسال مستقیم متن به تمام پلتفرم‌های فعال
     */
    public function sendToActivePlatforms(string $text): array
    {
        $config = $this->getEffectiveConfig();
        $results = [];

        foreach (array_keys(self::PLATFORMS) as $key) {
            $cfg = $config['platforms'][$key];
            if (!$cfg['enabled'] || !$cfg['configured']) {
                continue;
            }

            $results[$key] = $this->sendToPlatform($key, $text, $cfg);
        }

        return $results;
    }

    /**
     * ارسال پیام از طریق Bot API یکسان برای بله و تلگرام
     */
    public function sendToPlatform(string $platform, string $text, ?array $override = null): array
    {
        if (!isset(self::PLATFORMS[$platform])) {
            return ['success' => false, 'message' => 'پلتفرم نامعتبر است.'];
        }

        $meta = self::PLATFORMS[$platform];
        $effective = $override ?? $this->getEffectiveConfig()['platforms'][$platform];
        $token = trim((string) ($effective['bot_token'] ?? ''));
        $chatId = trim((string) ($effective['chat_id'] ?? ''));
        $apiBase = rtrim(trim((string) ($effective['api_base'] ?? $meta['default_base'])), '/') ?: $meta['default_base'];

        if ($token === '' || $chatId === '') {
            $msg = "توکن یا Chat ID ربات {$meta['label']} وارد نشده است.";
            $this->recordStatus($platform, false, $msg);
            return ['success' => false, 'message' => $msg];
        }

        $endpoint = "{$apiBase}/bot{$token}/sendMessage";

        try {
            $response = Http::timeout(5)
                ->acceptJson()
                ->post($endpoint, [
                    'chat_id'                  => $chatId,
                    'text'                     => $text,
                    'disable_web_page_preview' => true,
                ]);

            $payload = $response->json();
            if ($response->successful() && is_array($payload) && !empty($payload['ok'])) {
                $statusMsg = 'ارسال موفق در ' . User::toJalali(now()->setTimezone('Asia/Tehran'));
                $this->recordStatus($platform, true, $statusMsg);

                return [
                    'success' => true,
                    'message' => "پیام تستی در {$meta['label']} با موفقیت ارسال شد.",
                ];
            }

            $apiDesc = is_array($payload) ? ($payload['description'] ?? $response->body()) : $response->body();
            $msg = "خطای {$meta['label']} (کد {$response->status()}): " . mb_substr((string) $apiDesc, 0, 220);
            $this->recordStatus($platform, false, $msg);

            return ['success' => false, 'message' => $msg];
        } catch (\Throwable $e) {
            $err = $e->getMessage();
            $hint = ($platform === 'telegram' && str_contains($apiBase, 'api.telegram.org'))
                ? ' (اگر سرور داخل ایران است، آدرس پایه تلگرام را روی Cloudflare Worker تنظیم کنید)'
                : '';

            $msg = "خطای ارتباط با {$meta['label']}: {$err}{$hint}";
            Log::warning("AdminBotNotification {$platform} error: " . $err);
            $this->recordStatus($platform, false, $msg);

            return ['success' => false, 'message' => $msg];
        }
    }

    /**
     * استخراج خودکار آخرین Chat ID از متد getUpdates (پس از /start توسط کاربر)
     */
    public function detectChatId(string $platform, string $token, ?string $apiBase = null): array
    {
        if (!isset(self::PLATFORMS[$platform])) {
            return ['success' => false, 'message' => 'پلتفرم نامعتبر است.'];
        }

        $meta = self::PLATFORMS[$platform];
        $token = trim($token);
        if ($token === '') {
            return ['success' => false, 'message' => "ابتدا توکن ربات {$meta['label']} را وارد کنید."];
        }

        $base = rtrim(trim((string) ($apiBase ?: $meta['default_base'])), '/') ?: $meta['default_base'];

        try {
            $response = Http::timeout(6)
                ->acceptJson()
                ->get("{$base}/bot{$token}/getUpdates");

            $payload = $response->json();
            if (!$response->successful() || !is_array($payload) || empty($payload['ok'])) {
                $desc = is_array($payload) ? ($payload['description'] ?? $response->body()) : $response->body();
                return [
                    'success' => false,
                    'message' => "دریافت اطلاعات از {$meta['label']} ناموفق بود: " . mb_substr((string) $desc, 0, 200),
                ];
            }

            $updates = array_reverse($payload['result'] ?? []);
            foreach ($updates as $update) {
                $chat = $update['message']['chat']
                    ?? $update['edited_message']['chat']
                    ?? $update['channel_post']['chat']
                    ?? $update['my_chat_member']['chat']
                    ?? null;

                if (is_array($chat) && isset($chat['id'])) {
                    $title = trim((string) ($chat['title'] ?? trim(($chat['first_name'] ?? '') . ' ' . ($chat['last_name'] ?? ''))));
                    return [
                        'success'   => true,
                        'chat_id'   => (string) $chat['id'],
                        'chat_type' => (string) ($chat['type'] ?? 'private'),
                        'title'     => $title !== '' ? $title : 'چت شناسایی‌شده',
                        'message'   => "شناسه چت ({$chat['id']}) از {$meta['label']} با موفقیت دریافت شد.",
                    ];
                }
            }

            return [
                'success' => false,
                'message' => "هیچ پیامی یافت نشد. لطفاً ابتدا وارد ربات خود در {$meta['label']} شوید و دکمه Start (/start) را بزنید، سپس دوباره امتحان کنید.",
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => "خطای اتصال به {$meta['label']}: " . $e->getMessage(),
            ];
        }
    }

    /**
     * ثبت آخرین وضعیت ارسال در جدول تنظیمات (در صورت وجود)
     */
    protected function recordStatus(string $platform, bool $ok, string $message): void
    {
        try {
            if (!Schema::hasTable('bot_notification_settings')) {
                return;
            }

            $row = BotNotificationSetting::query()->first();
            if (!$row) {
                return;
            }

            $column = "last_{$platform}_status";
            $prefix = $ok ? '✅ ' : '❌ ';
            $row->update([
                $column => mb_substr($prefix . $message, 0, 480),
            ]);
        } catch (\Throwable $e) {
            // خطای ثبت وضعیت هرگز نباید جریان اصلی را متوقف کند
        }
    }
}
