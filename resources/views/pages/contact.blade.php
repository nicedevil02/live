@extends('layouts.public')

@section('title', 'تماس با ما و پشتیبانی | طلالایو')
@section('meta_description', 'ارتباط مستقیم با تیم پشتیبانی فنی و امور مشتریان سامانه طلالایو. شماره تماس، فرم پیام و راهنمای راه‌اندازی تابلوی هوشمند برای گالری‌های طلا.')
@section('meta_keywords', 'تماس با طلالایو, پشتیبانی طلالایو, شماره تماس تابلو طلا, پشتیبانی تابلوی هوشمند')

@section('canonical', 'https://talalive.ir/contact')

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-12">

    <div class="text-center space-y-4">
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white leading-tight">
            تماس با <span class="text-amber-500">طلالایو</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-base max-w-xl mx-auto">
            تیم کارشناسان ما در تمامی ایام کاری آماده پاسخگویی و راهنمایی گالری‌های محترم طلا و جواهر هستند.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xl space-y-4">
            <span class="text-3xl">📞</span>
            <h3 class="font-black text-slate-900 dark:text-white text-lg">پشتیبانی و امور مشترکین</h3>
            <p class="text-xs text-slate-500">پاسخگویی روزهای کاری از ساعت ۹ الی ۲۱</p>
            <div class="space-y-2 pt-2 text-sm font-bold">
                <div>موبایل: <a href="tel:09187009064" class="text-amber-500 dir-ltr inline-block">۰۹۱۸ ۷۰۰ ۹۰۶۴</a></div>
                <div>تلفن ثابت: <a href="tel:08135223847" class="text-amber-500 dir-ltr inline-block">۰۸۱-۳۵۲۲۳۸۴۷</a></div>
            </div>
        </div>

        <div class="p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xl space-y-4">
            <span class="text-3xl">💬</span>
            <h3 class="font-black text-slate-900 dark:text-white text-lg">ارتباط مستقیم در شبکه‌های اجتماعی</h3>
            <p class="text-xs text-slate-500">مشاوره آنلاین و ارسال آموزش‌های ویدیویی</p>
            <div class="space-y-2 pt-2 text-sm font-bold">
                <div>واتساپ و ایتا: <span class="text-amber-500 dir-ltr inline-block">۰۹۱۸ ۷۰۰ ۹۰۶۴</span></div>
                <div>وبسایت: <span class="text-amber-500">talalive.ir</span></div>
            </div>
        </div>
    </div>

</div>
@endsection
