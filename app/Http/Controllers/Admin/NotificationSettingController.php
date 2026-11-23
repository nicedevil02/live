<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BotNotificationSetting;
use App\Models\User;
use App\Services\AdminBotNotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationSettingController extends Controller
{
    public function index(AdminBotNotificationService $notificationService)
    {
        $config = $notificationService->getEffectiveConfig();

        $tokenPreviews = [];
        foreach (['bale', 'telegram'] as $platform) {
            $rawToken = $config['platforms'][$platform]['bot_token'] ?? '';
            $tokenPreviews[$platform] = $rawToken !== ''
                ? (strlen($rawToken) > 12 ? substr($rawToken, 0, 8) . '••••' . substr($rawToken, -4) : '••••••')
                : null;
        }

        return view('admin.notifications.index', compact('config', 'tokenPreviews'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bale_bot_token'     => 'nullable|string|max:255',
            'bale_chat_id'       => 'nullable|string|max:64',
            'telegram_bot_token' => 'nullable|string|max:255',
            'telegram_chat_id'   => 'nullable|string|max:64',
            'telegram_api_base'  => 'nullable|url|max:255',
        ], [
            'telegram_api_base.url' => 'آدرس رله تلگرام باید یک نشانی معتبر http/https باشد.',
        ]);

        $setting = BotNotificationSetting::query()->first() ?? new BotNotificationSetting();

        $baleTokenInput = trim((string) ($validated['bale_bot_token'] ?? ''));
        $telegramTokenInput = trim((string) ($validated['telegram_bot_token'] ?? ''));

        $setting->bale_enabled = $request->boolean('bale_enabled');
        $setting->bale_chat_id = trim((string) ($validated['bale_chat_id'] ?? '')) ?: null;
        if ($request->boolean('clear_bale_token')) {
            $setting->bale_bot_token = null;
        } elseif ($baleTokenInput !== '') {
            $setting->bale_bot_token = $baleTokenInput;
        }

        $setting->telegram_enabled = $request->boolean('telegram_enabled');
        $setting->telegram_chat_id = trim((string) ($validated['telegram_chat_id'] ?? '')) ?: null;
        $setting->telegram_api_base = rtrim(trim((string) ($validated['telegram_api_base'] ?? '')), '/') ?: null;
        if ($request->boolean('clear_telegram_token')) {
            $setting->telegram_bot_token = null;
        } elseif ($telegramTokenInput !== '') {
            $setting->telegram_bot_token = $telegramTokenInput;
        }

        $setting->notify_on_register = $request->boolean('notify_on_register');
        $setting->save();

        return redirect()
            ->route('admin.notifications')
            ->with('success', 'تنظیمات اطلاع‌رسانی ربات بله و تلگرام با موفقیت ذخیره شد.');
    }

    public function detectChatId(Request $request, AdminBotNotificationService $notificationService): JsonResponse
    {
        $validated = $request->validate([
            'platform'  => 'required|in:bale,telegram',
            'bot_token' => 'nullable|string|max:255',
            'api_base'  => 'nullable|url|max:255',
        ]);

        $platform = $validated['platform'];
        $config = $notificationService->getEffectiveConfig()['platforms'][$platform];

        $token = trim((string) ($validated['bot_token'] ?? '')) ?: $config['bot_token'];
        $apiBase = trim((string) ($validated['api_base'] ?? '')) ?: $config['api_base'];

        $result = $notificationService->detectChatId($platform, $token, $apiBase);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function test(Request $request, AdminBotNotificationService $notificationService): RedirectResponse
    {
        $validated = $request->validate([
            'platform' => 'required|in:bale,telegram,both',
        ]);

        $config = $notificationService->getEffectiveConfig();
        $sampleText = implode("\n", [
            '🧪 پیام تستی ربات اطلاع‌رسانی طلالایو',
            '',
            '🏪 نام گالری: گالری نمونه طلالایو',
            '📱 شماره موبایل: 09120000000',
            '📍 شهر: تهران',
            '👤 نام کاربری: @demo_gallery',
            '🔗 لینک تابلو: ' . rtrim((string) config('app.url', 'https://talalive.ir'), '/') . '/demo',
            '🕒 زمان تست: ' . User::toJalali(now()->setTimezone('Asia/Tehran'), true),
        ]);

        $targets = $validated['platform'] === 'both' ? ['bale', 'telegram'] : [$validated['platform']];
        $messages = [];
        $allOk = true;

        foreach ($targets as $platform) {
            $res = $notificationService->sendToPlatform($platform, $sampleText, $config['platforms'][$platform]);
            $messages[] = $res['message'];
            if (empty($res['success'])) {
                $allOk = false;
            }
        }

        return redirect()
            ->route('admin.notifications')
            ->with($allOk ? 'success' : 'error', implode(' | ', $messages));
    }
}
