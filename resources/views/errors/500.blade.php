@extends('layouts.public')

@section('title', 'خطای موقت سرور (خطای ۵۰۰) | طلالایو')
@section('meta_robots', 'noindex, nofollow')
@section('meta_description', 'خطای موقت در پردازش درخواست، تیم فنی طلالایو در حال بررسی و رفع موضوع است.')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-16 px-4">
    <div class="max-w-xl w-full text-center space-y-8 bg-white dark:bg-stone-900 p-8 sm:p-12 rounded-3xl border border-stone-200 dark:border-stone-800 shadow-sm">
        <div class="relative inline-flex items-center justify-center">
            <span class="text-8xl sm:text-9xl font-black text-rose-600 dark:text-rose-400 select-none tabular-nums">۵۰۰</span>
            <div class="absolute -bottom-2 px-4 py-1 rounded-full bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-xs font-black">
                خطای موقت سرور
            </div>
        </div>

        <div class="space-y-3">
            <h1 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-white">
                در حال حاضر مشکلی در پردازش پیش آمده است
            </h1>
            <p class="text-stone-600 dark:text-stone-400 text-sm leading-relaxed">
                گروه پشتیبانی فنی به صورت خودکار از بروز این خطا مطلع شده و در حال برطرف کردن آن هستند. لطفاً چند لحظه دیگر صفحه را تازه‌سازی فرمایید.
            </p>
        </div>

        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
            <button onclick="window.location.reload()" class="min-h-11 w-full sm:w-auto px-6 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-stone-950 font-black text-sm transition-all cursor-pointer shadow-sm">
                بارگذاری مجدد صفحه
            </button>
            <a href="{{ route('public.smart-gold-board') }}" class="min-h-11 inline-flex items-center justify-center w-full sm:w-auto px-6 py-2.5 rounded-2xl bg-amber-500/10 border border-amber-500/30 hover:border-amber-500 text-amber-700 dark:text-amber-300 font-bold text-sm transition-all cursor-pointer">
                تابلوی هوشمند طلافروشی
            </a>
            <a href="/" class="min-h-11 inline-flex items-center justify-center w-full sm:w-auto px-6 py-2.5 bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-800 dark:text-stone-200 font-bold text-sm transition-all cursor-pointer">
                صفحه اصلی
            </a>
        </div>
    </div>
</div>
@endsection
