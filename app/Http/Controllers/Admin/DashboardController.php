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

        return view('admin.dashboard', compact('username', 'onboardingChecklist'));
    }
}
