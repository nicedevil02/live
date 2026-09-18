<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvDevice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class TvDeviceController extends Controller
{
    /**
     * اطمینان از وجود جدول دیتابیس tv_devices و اجرای خودکار مایگریشن در صورت عدم وجود
     */
    private function ensureTvDevicesTable(): void
    {
        try {
            if (!Schema::hasTable('tv_devices')) {
                Artisan::call('migrate', ['--force' => true]);
            }
        } catch (\Throwable $e) {
            \Log::warning('ensureTvDevicesTable auto-migration notice: ' . $e->getMessage());
        }
    }

    /**
     * نمایش فهرست تلویزیون‌های متصل کاربر
     */
    public function index()
    {
        $this->ensureTvDevicesTable();

        $user = auth()->user();
        try {
            $devices = TvDevice::where('user_id', $user->id)
                ->latest('last_seen_at')
                ->get();
        } catch (\Throwable $e) {
            \Log::error('TvDevice index error: ' . $e->getMessage());
            $devices = collect();
        }

        return view('admin.devices.index', compact('devices'));
    }

    /**
     * ویرایش نام/برچسب دستگاه تلویزیون
     */
    public function update(Request $request, TvDevice $device)
    {
        if ($device->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'label' => 'nullable|string|max:100',
        ]);

        $device->update([
            'label' => $validated['label'] ?: null,
        ]);

        return redirect()->route('admin.devices.index')
            ->with('success', 'نام دستگاه با موفقیت به‌روزرسانی شد.');
    }

    /**
     * ابطال و قطع اتصال دستگاه
     */
    public function destroy(TvDevice $device)
    {
        if ($device->user_id !== auth()->id()) {
            abort(403);
        }

        $device->update([
            'revoked_at' => now(),
        ]);

        return redirect()->route('admin.devices.index')
            ->with('success', 'اتصال تلویزیون با موفقیت لغو شد.');
    }

    /**
     * فعال‌سازی مجدد اتصال دستگاه
     */
    public function restore(TvDevice $device)
    {
        if ($device->user_id !== auth()->id()) {
            abort(403);
        }

        $device->update([
            'revoked_at' => null,
            'last_seen_at' => now(),
        ]);

        return redirect()->route('admin.devices.index')
            ->with('success', 'دستگاه تلویزیون مجدداً فعال شد.');
    }
}
