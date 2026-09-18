<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvDevice;
use App\Models\User;
use Illuminate\Http\Request;

class TvDeviceController extends Controller
{
    /**
     * نمایش فهرست تلویزیون‌های متصل کاربر
     */
    public function index()
    {
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
     * بررسی دسترسی کاربر به دستگاه (مالک یا سوپرادمین)
     */
    private function authorizeDevice(TvDevice $device): void
    {
        $user = auth()->user();
        $isOwner = (int) $device->user_id === (int) $user->id;
        $isSuperAdmin = (bool) ($user->is_super_admin ?? false);

        if (!$isOwner && !$isSuperAdmin) {
            abort(403, 'شما دسترسی مجاز به این دستگاه ندارید.');
        }
    }

    /**
     * ویرایش نام/برچسب دستگاه تلویزیون
     */
    public function update(Request $request, TvDevice $device)
    {
        $this->authorizeDevice($device);

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
        $this->authorizeDevice($device);

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
        $this->authorizeDevice($device);

        $device->update([
            'revoked_at' => null,
            'last_seen_at' => now(),
        ]);

        return redirect()->route('admin.devices.index')
            ->with('success', 'دستگاه تلویزیون مجدداً فعال شد.');
    }

    /**
     * حذف دائمی و کامل دستگاه از دیتابیس
     */
    public function forceDelete(TvDevice $device)
    {
        $this->authorizeDevice($device);

        $label = $device->label ?: ('دستگاه #' . $device->id);
        $device->delete();

        return redirect()->route('admin.devices.index')
            ->with('success', 'دستگاه «' . $label . '» با موفقیت از سیستم حذف شد.');
    }
}
