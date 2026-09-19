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

    /**
     * نمایش صفحه اختصاصی اطلاعات فروشگاه و تنظیم کد QR
     */
    public function shopProfile()
    {
        $user = auth()->user();
        $settings = DisplaySetting::firstOrCreate(['user_id' => $user->id], [
            'theme_mode'          => 'dark-glass',
            'slider_interval_sec' => 8,
            'show_weight'         => true,
            'show_labor'          => true,
            'show_profit'         => true,
            'shop_name'           => $user->name ?? 'گالری طلای جدید',
            'phone'               => $user->phone ?? '',
            'instagram'           => '',
            'rubika'              => '',
            'qr_link'             => '',
            'qr_label'            => '',
            'qr_desc'             => '',
            'published_at'        => null,
        ]);

        if (request()->expectsJson()) {
            return response()->json([
                'settings' => $settings,
                'user'     => $user,
            ]);
        }

        return view('admin.shop-profile.index', compact('settings', 'user'));
    }

    /**
     * به‌روزرسانی اطلاعات فروشگاه، شهر و تنظیم کد QR
     */
    public function updateShopProfile(Request $request)
    {
        $user = auth()->user();
        $settings = DisplaySetting::firstOrCreate(['user_id' => $user->id]);

        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'city'      => 'nullable|string|max:50',
            'phone'     => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:255',
            'rubika'    => 'nullable|string|max:255',
            'qr_link'   => 'nullable|string|max:1000',
            'qr_label'  => 'nullable|string|max:255',
            'qr_desc'   => 'nullable|string|max:255',
        ]);

        // به‌روزرسانی شهر و نام گالری کاربر
        $cityInput = $request->input('city', $user->city_slug ?: 'tehran');
        $citiesConfig = config('cities', []);
        if (isset($citiesConfig[$cityInput])) {
            $user->city_slug = $cityInput;
            $user->city_name = $citiesConfig[$cityInput]['name'];
        } elseif ($cityInput === 'other') {
            $user->city_slug = 'iran';
            $user->city_name = 'ایران';
        }

        $user->name = $validated['shop_name'];
        $user->save();

        // به‌روزرسانی تنظیمات نمایش
        $settings->shop_name = $validated['shop_name'];
        $settings->phone = $validated['phone'] ?? '';
        $settings->instagram = $validated['instagram'] ?? '';
        $settings->rubika = $validated['rubika'] ?? '';
        $settings->qr_link = $validated['qr_link'] ?? '';
        $settings->qr_label = $validated['qr_label'] ?? '';
        $settings->qr_desc = $validated['qr_desc'] ?? '';
        $settings->published_at = now();
        $settings->save();

        return response()->json([
            'message'  => 'اطلاعات فروشگاه و کد QR با موفقیت ذخیره شد.',
            'settings' => $settings,
            'user'     => $user,
        ]);
    }

    /**
     * به‌روزرسانی سریع زمان‌بندی اسلایدر ویترین
     */
    public function updateSliderTiming(Request $request)
    {
        $validated = $request->validate([
            'slider_interval_sec' => 'required|integer|min:3|max:60',
        ]);

        $settings = DisplaySetting::firstOrCreate(['user_id' => auth()->id()]);
        $settings->slider_interval_sec = $validated['slider_interval_sec'];
        $settings->published_at = now();
        $settings->save();

        return response()->json([
            'message'             => 'زمان‌بندی اسلایدر با موفقیت به‌روزرسانی شد.',
            'slider_interval_sec' => $settings->slider_interval_sec,
        ]);
    }
}
