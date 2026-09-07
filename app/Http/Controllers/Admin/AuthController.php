<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (!$user->isAdmin()) {
                Auth::logout();
                return back()->withErrors(['email' => 'این حساب دسترسی ادمین ندارد.']);
            }

            // بررسی تایید بودن اکانت
            if (!$user->is_approved && !$user->is_super_admin) {
                Auth::logout();
                return back()->withErrors(['email' => 'حساب کاربری شما در انتظار تایید مدیریت است.']);
            }

            // بررسی انقضای حساب کاربری
            if ($user->expires_at && $user->expires_at->isPast() && !$user->is_super_admin) {
                Auth::logout();
                return back()->withErrors(['email' => 'اعتبار حساب کاربری شما به پایان رسیده است. جهت تمدید اعتبار با مدیریت تماس بگیرید.']);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'اطلاعات ورود اشتباه است.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    /**
     * نمایش فرم تنظیمات امنیتی
     */
    public function editSecurity()
    {
        return view('admin.security.index');
    }

    /**
     * به‌روزرسانی نام کاربری و رمز عبور ادمین
     */
    public function updateSecurity(Request $request)
    {
        $validated = $request->validate([
            'currentPassword' => 'required|string',
            'newUsername'     => 'nullable|string|min:3',
            'newPassword'     => 'nullable|string|min:6|confirmed',
        ]);

        $user = auth()->user();

        // بررسی رمز عبور فعلی
        if (!\Hash::check($validated['currentPassword'], $user->password)) {
            return response()->json(['message' => 'رمز عبور فعلی اشتباه است.'], 401);
        }

        // تغییر نام کاربری (ذخیره در فیلد name یا email؟ در پروژه اصلی username بود)
        if (!empty($validated['newUsername'])) {
            $user->email = $validated['newUsername']; // چون از email به جای username استفاده می‌کنیم
            $user->name = $validated['newUsername'];
        }

        // تغییر رمز عبور
        if (!empty($validated['newPassword'])) {
            $user->password = \Hash::make($validated['newPassword']);
        }

        $user->save();

        // لاگ
        \App\Models\AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => $user->name ?? 'admin',
            'action'      => 'update',
            'entity_type' => 'security_settings',
            'entity_id'   => (string) $user->id,
            'payload'     => json_encode(['ip' => $request->ip()]),
            'created_at'  => now(),
        ]);

        return response()->json(['message' => 'اطلاعات با موفقیت ذخیره شد.']);
    }

    /**
     * نمایش فرم ثبت نام
     */
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    /**
     * ثبت نام طلافروشی جدید
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|min:3|max:50|alpha_dash|unique:users,username',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // ایجاد کاربر جدید با نقش ادمین، غیرفعال و دارای ۱ سال اعتبار اولیه
        $user = \App\Models\User::create([
            'name'           => $validated['name'],
            'username'       => $validated['username'],
            'email'          => $validated['email'],
            'password'       => \Hash::make($validated['password']),
            'is_admin'       => true,
            'is_super_admin' => false,
            'is_approved'    => false, // غیرفعال تا زمان تایید سوپرادمین
            'expires_at'     => now()->addYear(), // ۱ سال اعتبار اولیه
            'display_token'  => 'dt_' . \Illuminate\Support\Str::random(16),
        ]);

        // ایجاد تنظیمات پیش‌فرض برای مغازه جدید
        \App\Models\DisplaySetting::create([
            'user_id'             => $user->id,
            'theme_mode'          => 'dark-glass',
            'slider_interval_sec' => 8,
            'show_weight'         => true,
            'show_labor'          => true,
            'show_profit'         => true,
            'shop_name'           => $validated['name'],
            'phone'               => '',
            'instagram'           => '',
            'rubika'              => '',
        ]);

        // ایجاد فرمول پیش‌فرض برای مغازه جدید
        \App\Models\FormulaConfig::create([
            'user_id'          => $user->id,
            'buy_multiplier_a' => 740,
            'buy_divisor_b'    => 750,
        ]);

        // ایجاد آیتم‌های تابلوی پیش‌فرض برای مغازه جدید
        $items = [
            ['key' => 'gold18', 'label' => 'طلای ۱۸ عیار', 'order' => 1],
            ['key' => 'buy_gold', 'label' => 'گرم خرید ۱۸ عیار', 'order' => 2],
            ['key' => 'gold24', 'label' => 'طلای ۲۴ عیار', 'order' => 3],
            ['key' => 'coin_emami', 'label' => 'سکه امامی', 'order' => 4],
            ['key' => 'coin_bahar', 'label' => 'سکه بهار آزادی', 'order' => 5],
            ['key' => 'coin_nim', 'label' => 'نیم سکه', 'order' => 6],
            ['key' => 'coin_rob', 'label' => 'ربع سکه', 'order' => 7],
            ['key' => 'usd', 'label' => 'دلار', 'order' => 8],
            ['key' => 'euro', 'label' => 'یورو', 'order' => 9],
            ['key' => 'dirham', 'label' => 'درهم', 'order' => 10],
            ['key' => 'bitcoin', 'label' => 'بیت کوین', 'order' => 11],
            ['key' => 'ounce', 'label' => 'انس جهانی', 'order' => 12],
            ['key' => 'mesghal17', 'label' => 'مثقال ۱۷', 'order' => 13],
            ['key' => 'coin_gerami', 'label' => 'سکه گرمی', 'order' => 14],
            ['key' => 'usdt', 'label' => 'تتر', 'order' => 15],
        ];

        foreach ($items as $item) {
            \App\Models\DisplayItem::create([
                'user_id' => $user->id,
                'key'     => $item['key'],
                'label'   => $item['label'],
                'enabled' => true,
                'order'   => $item['order'],
            ]);
        }

        // لاگ
        \App\Models\AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => $user->name,
            'action'      => 'register',
            'entity_type' => 'user',
            'entity_id'   => (string) $user->id,
            'payload'     => json_encode(['ip' => $request->ip()]),
            'created_at'  => now(),
        ]);

        return redirect()->route('admin.login')->with('success', 'ثبت نام طلافروشی شما با موفقیت انجام شد. حساب شما در انتظار تایید مدیریت است و پس از تایید فعال خواهد شد.');
    }
}
