@extends('layouts.public')

@section('title', 'صفحه مورد نظر یافت نشد (خطای ۴۰۴) | طلالایو')
@section('meta_description', 'صفحه‌ای که به دنبال آن بودید یافت نشد یا به آدرس جدیدی منتقل شده است.')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-16 px-4">
    <div class="max-w-xl w-full text-center space-y-8 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl p-8 sm:p-12 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-2xl shadow-amber-500/5">
        <div class="relative inline-flex items-center justify-center">
            <span class="text-8xl sm:text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-amber-600 select-none">۴۰۴</span>
            <div class="absolute -bottom-2 px-4 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-black">
                صفحه یافت نشد
            </div>
        </div>

        <div class="space-y-3">
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                متأسفانه صفحه مورد نظر شما وجود ندارد!
            </h1>
            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                ممکن است آدرس را اشتباه وارد کرده باشید یا این صفحه به نشانی جدیدی منتقل شده باشد. از طریق پیوندهای زیر می‌توانید به بخش‌های اصلی سامانه دسترسی پیدا کنید:
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 text-right">
            <a href="{{ route('public.smart-gold-board') }}" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 hover:border-amber-500 transition-all group">
                <div class="text-amber-500 font-black text-sm mb-1 group-hover:translate-x-1 transition-transform">📺 تابلوی هوشمند طلافروشی ←</div>
                <div class="text-slate-500 dark:text-slate-400 text-xs">سامانه ابری نمایش زنده نرخ روی تلویزیون</div>
            </a>
            <a href="{{ route('public.gold-calculator') }}" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 hover:border-amber-500 transition-all group">
                <div class="text-amber-500 font-black text-sm mb-1 group-hover:translate-x-1 transition-transform">🧮 ماشین‌حساب طلا و سکه ←</div>
                <div class="text-slate-500 dark:text-slate-400 text-xs">محاسبه آنلاین اجرت، سود و حباب سکه</div>
            </a>
            <a href="{{ route('public.tv-setup-guide') }}" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 hover:border-amber-500 transition-all group">
                <div class="text-amber-500 font-black text-sm mb-1 group-hover:translate-x-1 transition-transform">⚙️ راهنمای اتصال تلویزیون ←</div>
                <div class="text-slate-500 dark:text-slate-400 text-xs">آموزش اتصال تلویزیون سامسونگ، ال‌جی و سونی</div>
            </a>
            <a href="{{ route('admin.register') }}" class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 hover:border-amber-500 transition-all group">
                <div class="text-amber-600 dark:text-amber-400 font-black text-sm mb-1 group-hover:translate-x-1 transition-transform">✨ تست رایگان ۱۴ روزه ←</div>
                <div class="text-slate-500 dark:text-slate-400 text-xs">ثبت‌نام گالری بدون نیاز به پرداخت</div>
            </a>
        </div>

        <div class="pt-4">
            <a href="/" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-black text-sm shadow-lg shadow-amber-500/20 hover:scale-105 transition-all cursor-pointer">
                <span>بازگشت به صفحه اصلی</span>
            </a>
        </div>
    </div>
</div>
@endsection
