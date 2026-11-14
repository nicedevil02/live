<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisplaySetting;
use App\Models\ProductSlide;
use App\Models\TvDevice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $username = $user->username;

        $tvConnected = false;
        $productAdded = false;
        $profileCustomized = false;
        $productsCount = 0;
        $setting = null;
        $tvTelemetry = [
            'activeCount'  => 0,
            'onlineCount'  => 0,
            'isOnlineNow'  => false,
            'lastSeenText' => null,
            'primaryLabel' => '',
        ];

        try {
            $activeDevices = collect();
            if (Schema::hasTable('tv_devices')) {
                $activeDevices = TvDevice::where('user_id', $user->id)
                    ->whereNull('revoked_at')
                    ->orderByDesc('last_seen_at')
                    ->get();
                $tvConnected = $activeDevices->isNotEmpty();
            }

            if ($activeDevices->isNotEmpty()) {
                $onlineCount = $activeDevices->filter(function ($dev) {
                    if (!$dev->last_seen_at) return false;
                    $dt = $dev->last_seen_at instanceof \DateTimeInterface
                        ? \Carbon\Carbon::instance($dev->last_seen_at)
                        : \Carbon\Carbon::parse($dev->last_seen_at);
                    return $dt->gt(now()->subMinutes(3));
                })->count();

                $latestSeen = $activeDevices->first()?->last_seen_at;
                $latestSeenParsed = $latestSeen
                    ? ($latestSeen instanceof \DateTimeInterface ? \Carbon\Carbon::instance($latestSeen) : \Carbon\Carbon::parse($latestSeen))
                    : null;

                $tvTelemetry = [
                    'activeCount'  => $activeDevices->count(),
                    'onlineCount'  => $onlineCount,
                    'isOnlineNow'  => $onlineCount > 0,
                    'lastSeenText' => $latestSeenParsed ? \App\Models\User::toJalali($latestSeenParsed) : null,
                    'primaryLabel' => $activeDevices->first()?->label ?: 'تلویزیون ویترین مغازه',
                ];
            }

            if (!$tvConnected && Schema::hasTable('tv_sessions')) {
                $pairedSession = DB::table('tv_sessions')
                    ->where('paired_user_id', $user->id)
                    ->where('is_paired', true)
                    ->orderByDesc('updated_at')
                    ->first();
                if ($pairedSession) {
                    $tvConnected = true;
                    $sessionLastSeen = $pairedSession->last_seen_at ?? $pairedSession->updated_at ?? null;
                    $parsedSeen = $sessionLastSeen ? \Carbon\Carbon::parse($sessionLastSeen) : null;
                    $tvTelemetry = [
                        'activeCount'  => 1,
                        'onlineCount'  => ($parsedSeen && $parsedSeen->gt(now()->subMinutes(3))) ? 1 : 0,
                        'isOnlineNow'  => (bool) ($parsedSeen && $parsedSeen->gt(now()->subMinutes(3))),
                        'lastSeenText' => $parsedSeen ? \App\Models\User::toJalali($parsedSeen) : null,
                        'primaryLabel' => 'مرورگر / تلویزیون متصل',
                    ];
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Onboarding TV status check failed: ' . $e->getMessage());
        }

        try {
            if (Schema::hasTable('product_slide')) {
                $productAdded = ProductSlide::where('user_id', $user->id)->exists();
                $productsCount = ProductSlide::where('user_id', $user->id)->where('is_visible', true)->count();
            }
        } catch (\Throwable $e) {
            \Log::warning('Onboarding ProductSlide check failed: ' . $e->getMessage());
        }

        try {
            if (Schema::hasTable('display_settings')) {
                DisplaySettingController::ensureEmptyShowcaseColumnsExist();
                $setting = DisplaySetting::where('user_id', $user->id)->first();
                if ($setting) {
                    $hasSocialOrQr = !empty(trim((string) $setting->instagram))
                        || !empty(trim((string) $setting->rubika))
                        || !empty(trim((string) $setting->qr_link));
                    $wasEdited = $setting->created_at
                        && $setting->updated_at
                        && $setting->updated_at->gt($setting->created_at->copy()->addSeconds(15));
                    $profileCustomized = $hasSocialOrQr || $wasEdited;
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Onboarding DisplaySetting check failed: ' . $e->getMessage());
        }

        $completedCount = 1 + ($tvConnected ? 1 : 0) + ($productAdded ? 1 : 0) + ($profileCustomized ? 1 : 0);
        $onboardingChecklist = [
            'account_created'    => true,
            'tv_connected'       => $tvConnected,
            'product_added'      => $productAdded,
            'profile_customized' => $profileCustomized,
            'completed_count'    => $completedCount,
            'total_count'        => 4,
            'progress_percent'   => (int) round(($completedCount / 4) * 100),
            'is_all_done'        => $completedCount >= 4,
        ];

        $isWelcomePeriod = $user->isEligibleForWelcomeOffer();
        $welcomeHoursLeft = $user->welcomeOfferHoursLeft();

        $shopMeta = [
            'shopName'  => !empty($setting?->shop_name) ? $setting->shop_name : ($user->name ?? 'گالری طلا'),
            'shopPhone' => $setting?->phone ?: ($user->phone ?? ''),
            'publicUrl' => url('/' . $username),
        ];
        $showcaseConfig = [
            'empty_showcase_mode'  => $setting?->empty_showcase_mode ?: 'guide',
            'empty_showcase_title' => $setting?->empty_showcase_title ?? '',
            'empty_showcase_text'  => $setting?->empty_showcase_text ?? '',
            'empty_showcase_theme' => $setting?->empty_showcase_theme ?: 'gold',
        ];

        return view('admin.dashboard', compact(
            'username',
            'onboardingChecklist',
            'isWelcomePeriod',
            'welcomeHoursLeft',
            'tvTelemetry',
            'productsCount',
            'shopMeta',
            'showcaseConfig'
        ));
    }

    /**
     * ثبت درخواست تماس و راه‌اندازی رایگان تلویزیون توسط کارشناس طلالایو
     */
    public function requestSetupCall(\Illuminate\Http\Request $request, \App\Services\SmsService $smsService)
    {
        $user = auth()->user();

        \App\Models\AuditLog::create([
            'id'          => 'call-' . now()->timestamp . rand(100, 999),
            'actor'       => $user->name ?? $user->phone ?? 'کاربر',
            'action'      => 'request_setup_call',
            'entity_type' => 'user',
            'entity_id'   => (string) $user->id,
            'payload'     => json_encode([
                'phone'        => $user->phone,
                'name'         => $user->name,
                'city'         => $user->city_name,
                'ip'           => $request->ip(),
                'requested_at' => now()->toDateTimeString(),
            ], JSON_UNESCAPED_UNICODE),
            'created_at'  => now(),
        ]);

        $smsService->notifyAdminSetupCallRequest($user->name ?? 'طلافروشی', $user->phone ?? '');

        return response()->json([
            'success' => true,
            'message' => 'درخواست تماس شما با اولویت بالا ثبت شد. کارشناس فنی طلالایو جهت راه‌اندازی سریع تلویزیون مغازه به زودی با شما تماس می‌گیرد.',
        ]);
    }
}
