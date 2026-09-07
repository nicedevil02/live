<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisplaySetting;
use App\Models\DisplayItem;
use Illuminate\Http\Request;

class DisplaySettingController extends Controller
{
    /**
     * نمایش صفحه تنظیمات تابلو
     */
    public function index()
    {
        $settings = DisplaySetting::firstOrCreate(['user_id' => auth()->id()], [
            'theme_mode' => 'dark-glass',
            'slider_interval_sec' => 8,
            'show_weight' => true,
            'show_labor' => true,
            'show_profit' => true,
            'shop_name' => auth()->user()->name ?? 'گالری طلای جدید',
            'phone' => '',
            'instagram' => '',
            'rubika' => '',
            'qr_link' => '',
            'qr_label' => '',
            'qr_desc' => '',
            'published_at' => null,
        ]);

        $items = DisplayItem::where('user_id', auth()->id())->orderBy('order')->get();

        // پاسخ JSON برای درخواست‌های Alpine
        if (request()->expectsJson()) {
            return response()->json([
                'settings' => $settings,
                'items'    => $items,
            ]);
        }

        return view('admin.display-control.index', compact('settings', 'items'));
    }

    public function update(Request $request)
    {
        $settings = DisplaySetting::firstOrCreate(['user_id' => auth()->id()]);

        $validated = $request->validate([
            'theme_mode'          => 'required|string',
            'slider_interval_sec' => 'required|integer|min:3',
            'show_weight'         => 'sometimes|boolean',
            'show_labor'          => 'sometimes|boolean',
            'show_profit'         => 'sometimes|boolean',
            'shop_name'           => 'nullable|string|max:255',
            'phone'               => 'nullable|string|max:20',
            'instagram'           => 'nullable|string|max:255',
            'rubika'              => 'nullable|string|max:255',
            'qr_link'             => 'nullable|string|max:1000',
            'qr_label'            => 'nullable|string|max:255',
            'qr_desc'             => 'nullable|string|max:255',
        ]);

        // تبدیل مقادیر نال شده به رشته‌های خالی یا پیش‌فرض جهت هماهنگی با قیدهای پایگاه‌داده (NOT NULL)
        $validated['shop_name'] = $validated['shop_name'] ?? 'گالری طلای جدید';
        $validated['phone'] = $validated['phone'] ?? '';
        $validated['instagram'] = $validated['instagram'] ?? '';
        $validated['rubika'] = $validated['rubika'] ?? '';
        $validated['qr_link'] = $validated['qr_link'] ?? '';
        $validated['qr_label'] = $validated['qr_label'] ?? '';
        $validated['qr_desc'] = $validated['qr_desc'] ?? '';

        $settings->update($validated);

        return response()->json($settings);
    }

    /**
     * انتشار روی تابلو (ثبت زمان انتشار)
     */
    public function publish()
    {
        $settings = DisplaySetting::firstOrCreate(['user_id' => auth()->id()]);
        $settings->published_at = now();
        $settings->save();

        return response()->json([
            'message'      => 'انتشار با موفقیت انجام شد.',
            'published_at' => $settings->published_at->toISOString(),
        ]);
    }
}
