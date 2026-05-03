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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (!$user->isAdmin()) {
                Auth::logout();
                return back()->withErrors(['email' => 'این حساب دسترسی ادمین ندارد.']);
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
}
