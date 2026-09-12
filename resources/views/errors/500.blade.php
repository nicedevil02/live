@extends('layouts.public')

@section('title', 'خطای موقت سرور (خطای ۵۰۰) | طلالایو')
@section('meta_description', 'خطای موقت در پردازش درخواست، تیم فنی طلالایو در حال بررسی و رفع موضوع است.')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-16 px-4">
    <div class="max-w-xl w-full text-center space-y-8 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl p-8 sm:p-12 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-2xl shadow-rose-500/5">
        <div class="relative inline-flex items-center justify-center">
            <span class="text-8xl sm:text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-amber-500 select-none">۵۰۰</span>
            <div class="absolute -bottom-2 px-4 py-1 rounded-full bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-xs font-black">
                خطای موقت سرور
            </div>
        </div>

        <div class="space-y-3">
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                در حال حاضر مشکلی در پردازش پیش آمده است
            </h1>
            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                گروه پشتیبانی فنی به صورت خودکار از بروز این خطا مطلع شده و در حال برطرف کردن آن هستند. لطفاً چند لحظه دیگر صفحه را تازه‌سازی فرمایید.
            </p>
        </div>

        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
            <button onclick="window.location.reload()" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-sm shadow-lg shadow-amber-500/20 transition-all cursor-pointer">
                بارگذاری مجدد صفحه
            </button>
            <a href="/" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-sm transition-all cursor-pointer">
                صفحه اصلی طلالایو
            </a>
        </div>
    </div>
</div>
@endsection
