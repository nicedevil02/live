@extends('admin.layouts.app')

@section('title', 'وضعیت درگاه پیامک s.api.ir')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- هدر صفحه -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div>
            <h1 class="text-xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                <span>📱</span>
                <span>بررسی وضعیت درگاه پیامک (s.api.ir)</span>
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                سرویس ارسال سریع کد تأیید (SmsOTP) بدون نیاز به مجوز و با خطوط خدماتی
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.clear-cache') }}" class="px-3.5 py-2 text-xs font-bold bg-amber-500/10 hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/30 rounded-xl transition-all">
                🔄 بازنشانی کش سیستم
            </a>
            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 text-xs font-bold bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl transition-all">
                ← بازگشت
            </a>
        </div>
    </div>

    @if(isset($testResult))
        <!-- نتیجه تست ارسال پیامک -->
        <div class="p-5 rounded-2xl border {{ $testResult['success'] ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-800 dark:text-emerald-300' : 'bg-rose-500/10 border-rose-500/30 text-rose-800 dark:text-rose-300' }}">
            <div class="flex items-start gap-3">
                <span class="text-2xl">{{ $testResult['success'] ? '✅' : '❌' }}</span>
                <div class="space-y-1">
                    <h3 class="font-black text-sm">{{ $testResult['success'] ? 'ارسال پیامک با موفقیت انجام شد!' : 'ارسال پیامک با خطا مواجه شد' }}</h3>
                    <p class="text-xs">{{ $testResult['message'] ?? '' }}</p>
                    @if(!empty($testResult['raw']))
                        <pre class="mt-2 p-3 bg-slate-900 text-slate-200 rounded-xl text-xs font-mono overflow-x-auto" dir="ltr">{{ json_encode($testResult['raw'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}</pre>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- کارت‌های خلاصه وضعیت -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- کارت ۱: وضعیت توکن -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-2">
            <span class="text-xs text-slate-500 dark:text-slate-400 font-bold block">وضعیت توکن احراز هویت</span>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full {{ $diag['token_active'] ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                <span class="text-sm font-black text-slate-800 dark:text-white">
                    {{ $diag['token_active'] ? 'متصل و فعال' : 'تنظیم نشده' }}
                </span>
            </div>
            <p class="text-[11px] text-slate-400 font-mono" dir="ltr">{{ $diag['token_preview'] }}</p>
        </div>

        <!-- کارت ۲: سرویس و اندپوینت -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-2">
            <span class="text-xs text-slate-500 dark:text-slate-400 font-bold block">سرویس فعال</span>
            <div class="flex items-baseline gap-1.5">
                <span class="text-base font-black text-emerald-500">
                    {{ $diag['provider'] }}
                </span>
            </div>
            <p class="text-[11px] text-slate-400 font-mono" dir="ltr">POST /api/sw1/SmsOTP</p>
        </div>

        <!-- کارت ۳: شناسه قالب -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-2">
            <span class="text-xs text-slate-500 dark:text-slate-400 font-bold block">قالب اعتبارسنجی (OTP)</span>
            <div class="flex items-center gap-2">
                <span class="text-sm font-mono font-black text-indigo-600 dark:text-indigo-400" dir="ltr">
                    قالب شماره {{ $diag['template'] }}
                </span>
            </div>
            <p class="text-[11px] text-slate-400">
                ارسال آنی از خط خدماتی s.api.ir
            </p>
        </div>
    </div>

    <!-- فرم تست آنلاین ارسال پیامک -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
        <h2 class="text-sm font-black text-slate-800 dark:text-white flex items-center gap-2">
            <span>🧪</span>
            <span>تست زنده ارسال کد تأیید با درگاه s.api.ir</span>
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400">
            شماره موبایل مورد نظر را وارد کرده و بر روی «ارسال پیامک تستی» کلیک کنید تا ارسال کد تأیید زنده به همراه جزئیات بررسی شود.
        </p>

        <form method="GET" action="{{ route('admin.sms-status') }}" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="test" value="{{ request('test', '09187009064') }}" placeholder="09187009064"
                   class="flex-1 px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-mono text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500" dir="ltr">
            <button type="submit" class="px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-sm shadow-md shadow-amber-500/20 transition-all flex items-center justify-center gap-2 shrink-0">
                <span>🚀 ارسال پیامک تستی با s.api.ir</span>
            </button>
        </form>
    </div>
</div>
@endsection
