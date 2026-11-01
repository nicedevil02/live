@extends('layouts.public')

@section('title', 'صفحه مورد نظر یافت نشد (خطای ۴۰۴) | طلالایو')
@section('meta_robots', 'noindex, nofollow')
@section('meta_description', 'صفحه‌ای که به دنبال آن بودید یافت نشد یا به آدرس جدیدی منتقل شده است.')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-16 px-4">
    <div class="max-w-xl w-full text-center space-y-8 bg-white dark:bg-stone-900 p-8 sm:p-12 rounded-3xl border border-stone-200 dark:border-stone-800 shadow-sm">
        <div class="relative inline-flex items-center justify-center">
            <span class="text-8xl sm:text-9xl font-black text-amber-600 dark:text-amber-400 select-none tabular-nums">۴۰۴</span>
            <div class="absolute -bottom-2 px-4 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-black">
                صفحه یافت نشد
            </div>
        </div>

        <div class="space-y-3">
            <h1 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-white">
                متأسفانه صفحه مورد نظر شما وجود ندارد!
            </h1>
            <p class="text-stone-600 dark:text-stone-400 text-sm leading-relaxed">
                ممکن است آدرس را اشتباه وارد کرده باشید یا این صفحه به نشانی جدیدی منتقل شده باشد. از طریق پیوندهای زیر می‌توانید به بخش‌های اصلی سامانه دسترسی پیدا کنید:
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 text-right">
            <a href="{{ route('public.smart-gold-board') }}" class="p-4 rounded-2xl bg-stone-50 dark:bg-stone-800/80 border border-stone-200 dark:border-stone-700/80 hover:border-amber-500 transition-all group flex flex-col justify-between min-h-11">
                <div class="text-amber-600 dark:text-amber-400 font-black text-sm mb-1 group-hover:translate-x-1 transition-transform flex items-center gap-1.5">
                    <x-ui-icon name="tv" class="w-4 h-4" />
                    <span>تابلوی هوشمند طلافروشی ←</span>
                </div>
                <div class="text-stone-500 dark:text-stone-400 text-xs">سامانه ابری نمایش زنده نرخ روی تلویزیون</div>
            </a>
            <a href="{{ route('public.gold-calculator') }}" class="p-4 rounded-2xl bg-stone-50 dark:bg-stone-800/80 border border-stone-200 dark:border-stone-700/80 hover:border-amber-500 transition-all group flex flex-col justify-between min-h-11">
                <div class="text-amber-600 dark:text-amber-400 font-black text-sm mb-1 group-hover:translate-x-1 transition-transform flex items-center gap-1.5">
                    <x-ui-icon name="calculator" class="w-4 h-4" />
                    <span>ماشین‌حساب طلا و سکه ←</span>
                </div>
                <div class="text-stone-500 dark:text-stone-400 text-xs">محاسبه آنلاین اجرت، سود و حباب سکه</div>
            </a>
            <a href="{{ route('public.tv-setup-guide') }}" class="p-4 rounded-2xl bg-stone-50 dark:bg-stone-800/80 border border-stone-200 dark:border-stone-700/80 hover:border-amber-500 transition-all group flex flex-col justify-between min-h-11">
                <div class="text-amber-600 dark:text-amber-400 font-black text-sm mb-1 group-hover:translate-x-1 transition-transform flex items-center gap-1.5">
                    <x-ui-icon name="wrench" class="w-4 h-4" />
                    <span>راهنمای اتصال تلویزیون ←</span>
                </div>
                <div class="text-stone-500 dark:text-stone-400 text-xs">آموزش اتصال تلویزیون سامسونگ، ال‌جی و سونی</div>
            </a>
            <a href="{{ route('admin.register') }}" class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 hover:border-amber-500 transition-all group flex flex-col justify-between min-h-11">
                <div class="text-amber-700 dark:text-amber-300 font-black text-sm mb-1 group-hover:translate-x-1 transition-transform flex items-center gap-1.5">
                    <x-ui-icon name="gift" class="w-4 h-4" />
                    <span>تست رایگان ۱۴ روزه ←</span>
                </div>
                <div class="text-stone-500 dark:text-stone-400 text-xs">ثبت‌نام گالری بدون نیاز به پرداخت</div>
            </a>
        </div>

        <div class="pt-4">
            <a href="/" class="min-h-11 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-stone-950 font-black text-sm transition-all cursor-pointer shadow-sm">
                <span>بازگشت به صفحه اصلی</span>
            </a>
        </div>
    </div>
</div>
@endsection
