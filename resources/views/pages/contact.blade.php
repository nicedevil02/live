@extends('layouts.public')

@section('title', 'تماس با ما و پشتیبانی | مشاوره تابلو طلا فروشی و تابلوی هوشمند | طلالایو')
@section('meta_description', 'ارتباط مستقیم با تیم پشتیبانی فنی سامانه طلالایو جهت مشاوره خرید و راه‌اندازی تابلو طلا فروشی و تابلوی هوشمند طلافروشی برای گالری‌های سراسر کشور.')

@section('canonical', 'https://talalive.ir/contact')

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-12">

    <div class="text-center space-y-4">
        <h1 class="text-3xl sm:text-5xl font-black text-stone-900 dark:text-white leading-tight">
            تماس با <span class="text-amber-600 dark:text-amber-400">طلالایو</span>
        </h1>
        <p class="text-stone-600 dark:text-stone-400 text-base max-w-xl mx-auto">
            تیم کارشناسان ما در تمامی ایام کاری آماده پاسخگویی و راهنمایی گالری‌های محترم طلا و جواهر هستند.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="p-8 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400">
                <x-ui-icon name="phone" class="w-6 h-6" />
            </div>
            <h2 class="font-black text-stone-900 dark:text-white text-lg">پشتیبانی و امور مشترکین</h2>
            <p class="text-xs text-stone-500">پاسخگویی روزهای کاری از ساعت ۹ الی ۲۱</p>
            <div class="space-y-2 pt-2 text-sm font-bold">
                <div>موبایل: <a href="tel:09187009064" class="text-amber-600 dark:text-amber-400 dir-ltr inline-block hover:underline min-h-11 inline-flex items-center">۰۹۱۸ ۷۰۰ ۹۰۶۴</a></div>
                <div>تلفن ثابت: <a href="tel:08135229063" class="text-amber-600 dark:text-amber-400 dir-ltr inline-block hover:underline min-h-11 inline-flex items-center">۰۸۱-۳۵۲۲۹۰۶۳</a></div>
            </div>
        </div>

        <div class="p-8 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400">
                <x-ui-icon name="smartphone" class="w-6 h-6" />
            </div>
            <h2 class="font-black text-stone-900 dark:text-white text-lg">ارتباط مستقیم در پیام‌رسان‌ها</h2>
            <p class="text-xs text-stone-500">مشاوره آنلاین و ارسال راهنماها</p>
            <div class="space-y-2 pt-2 text-sm font-bold">
                <div>ایتا و پیام‌رسان‌ها: <span class="text-amber-600 dark:text-amber-400 dir-ltr inline-block min-h-11 inline-flex items-center">۰۹۱۸ ۷۰۰ ۹۰۶۴</span></div>
                <div>وبسایت: <span class="text-stone-700 dark:text-stone-300">talalive.ir</span></div>
            </div>
        </div>

        <div class="p-8 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 shadow-sm space-y-4 sm:col-span-2">
            <div class="w-12 h-12 rounded-2xl bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-stone-700 dark:text-stone-300">
                <x-ui-icon name="map-pin" class="w-6 h-6 text-amber-600 dark:text-amber-400" />
            </div>
            <h2 class="font-black text-stone-900 dark:text-white text-lg">نشانی و دفتر</h2>
            <p class="text-xs text-stone-500">پذیرش حضوری با هماهنگی قبلی</p>
            <div class="pt-2 text-sm font-bold text-stone-700 dark:text-stone-300">
                همدان، کبودرآهنگ، خیابان مطهری، پاساژ علاءالدین
            </div>
        </div>
    </div>

</div>
@endsection
