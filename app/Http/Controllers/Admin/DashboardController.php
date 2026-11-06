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

        try {
            if (Schema::hasTable('tv_devices')) {
                $tvConnected = TvDevice::where('user_id', $user->id)
                    ->whereNull('revoked_at')
                    ->exists();
            }
            if (!$tvConnected && Schema::hasTable('tv_sessions')) {
                $tvConnected = DB::table('tv_sessions')
                    ->where('paired_user_id', $user->id)
                    ->where('is_paired', true)
                    ->exists();
            }
        } catch (\Throwable $e) {
            \Log::warning('Onboarding TV status check failed: ' . $e->getMessage());
        }

        try {
            if (Schema::hasTable('product_slide')) {
                $productAdded = ProductSlide::where('user_id', $user->id)->exists();
            }
        } catch (\Throwable $e) {
            \Log::warning('Onboarding ProductSlide check failed: ' . $e->getMessage());
        }

        try {
            if (Schema::hasTable('display_settings')) {
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

        $isWelcomePeriod = $user->created_at ? (now()->diffInHours($user->created_at, false) <= 48) : false;
        $welcomeHoursLeft = $user->created_at ? max(0, 48 - (int)now()->diffInHours($user->created_at, false)) : 0;

        return view('admin.dashboard', compact('username', 'onboardingChecklist', 'isWelcomePeriod', 'welcomeHoursLeft'));
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
