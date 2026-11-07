<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('admin.login')->withErrors(['email' => 'شما دسترسی ادمین ندارید.']);
        }

        $user = Auth::user();
        $isImpersonating = $request->session()->has('impersonator_id');

        // بررسی تایید شدن حساب کاربری توسط سوپرادمین (در حالت ورود با هویت کاربر، سوپرادمین مستثنی است)
        if (!$user->is_approved && !$user->is_super_admin && !$isImpersonating) {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors(['email' => 'حساب کاربری شما در انتظار تایید مدیریت است.']);
        }

        // بررسی تاریخ انقضای اعتبار حساب (در حالت ورود با هویت کاربر، سوپرادمین مستثنی است)
        if ($user->expires_at && $user->expires_at->isPast() && !$user->is_super_admin && !$isImpersonating) {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors(['email' => 'اعتبار حساب کاربری شما به پایان رسیده است. جهت تمدید اعتبار با مدیریت تماس بگیرید.']);
        }

        return $next($request);
    }
}
