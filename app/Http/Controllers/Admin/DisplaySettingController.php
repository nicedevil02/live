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
        $settings = DisplaySetting::firstOrCreate(['id' => 1], [
            'theme_mode' => 'dark-glass',
            'slider_interval_sec' => 8,
            'show_weight' => true,
            'show_labor' => true,
            'show_profit' => true,
            'shop_name' => 'گالری طلای سجاد',
            'phone' => '',
            'instagram' => '',
            'rubika' => '',
            'published_at' => null,
        ]);

        $items = DisplayItem::orderBy('order')->get();

        // پاسخ JSON برای درخواست‌های Alpine
        if (request()->expectsJson()) {
            return response()->json([
                'settings' => $settings,
                'items'    => $items,
            ]);
        }

        return view('admin.display-control.index', compact('settings', 'items'));
    }

    /**
     * به‌روزرسانی تنظیمات
     */
    public function update(Request $request)
    {
        $settings = DisplaySetting::firstOrFail();

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
        ]);

        $settings->update($validated);

        return response()->json($settings);
    }

    /**
     * انتشار روی تابلو (ثبت زمان انتشار)
     */
    public function publish()
    {
        $settings = DisplaySetting::firstOrFail();
        $settings->published_at = now();
        $settings->save();

        return response()->json([
            'message'      => 'انتشار با موفقیت انجام شد.',
            'published_at' => $settings->published_at->toISOString(),
        ]);
    }
}
