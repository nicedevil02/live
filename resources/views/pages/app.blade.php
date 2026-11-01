@extends('layouts.public')

@section('title', 'دانلود اپلیکیشن طلالایو | نرم‌افزار تابلوی طلافروشی و تلویزیون هوشمند Android TV')
@section('meta_description', 'دانلود مستقیم اپلیکیشن طلالایو نسخه ۱.۰.۸ ویژه تلویزیون هوشمند و اندروید باکس. مدیریت آنلاین تابلوی نرخ لحظه‌ای طلا، سکه و ارز مغازه بدون مینی‌کیس با راه‌اندازی در ۶۰ ثانیه.')
@section('canonical', 'https://talalive.ir/app')

{{-- استانداردهای سئوی تصویر پیش‌نمایش در شبکه‌های اجتماعی و پیام‌رسان‌ها (Open Graph / Twitter) --}}
@section('og_image', asset('images/tv-preview.png'))
@section('og_image_width', '1024')
@section('og_image_height', '577')
@section('og_image_type', 'image/png')
@section('og_image_alt', 'اسکرین‌شات واقعی نرم‌افزار تابلوی هوشمند طلافروشی طلالایو روی تلویزیون هوشمند Android TV با نرخ لحظه‌ای طلا و سکه')

@push('head')
    {{-- بهینه‌سازی سرعت لود تصویر اصلی هیرو (LCP Preload) جهت ارتقای رتبه سئو فنی و لایت‌هاوس --}}
    <link rel="preload" as="image" href="{{ asset('images/tv-preview.webp') }}?v=1.0.1" type="image/webp" fetchpriority="high">
@endpush

@push('styles')
<style>
    .app-badge-btn {
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .app-badge-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px -6px rgba(245, 158, 11, 0.25);
    }
    .tv-mockup-shadow {
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.15), 0 0 35px -5px rgba(245, 158, 11, 0.15);
    }
    .dark .tv-mockup-shadow {
        box-shadow: 0 30px 80px -20px rgba(0, 0, 0, 0.8), 0 0 45px -5px rgba(245, 158, 11, 0.25);
    }
    /* استایل‌های قطعی و لوکس مودال نصب PWA با لایه پس‌زمینه تیره و z-index بالا */
    #pwa-install-modal {
        position: fixed !important;
        top: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        z-index: 9999999 !important;
        background-color: rgba(2, 6, 23, 0.82) !important;
        -webkit-backdrop-filter: blur(14px) !important;
        backdrop-filter: blur(14px) !important;
        display: none;
        align-items: center !important;
        justify-content: center !important;
        padding: 1rem !important;
        box-sizing: border-box !important;
        opacity: 0;
        transition: opacity 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    #pwa-install-modal.modal-active {
        display: flex !important;
    }
    .pwa-modal-box {
        position: relative !important;
        width: 100% !important;
        max-width: 28rem !important;
        background-color: #ffffff !important;
        border-radius: 1.5rem !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45) !important;
        padding: 1.5rem !important;
        color: #0f172a !important;
        text-align: right !important;
        z-index: 10000000 !important;
        animation: pwaModalScaleUp 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
    }
    .dark .pwa-modal-box {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.85) !important;
        color: #f8fafc !important;
    }
    @keyframes pwaModalScaleUp {
        from {
            transform: scale(0.95) translateY(10px);
            opacity: 0.8;
        }
        to {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    }
</style>
@endpush

@section('content')
<div class="relative w-full overflow-hidden text-stone-800 dark:text-stone-100 transition-colors duration-150">

    {{-- ۱. بخش هیرو تمام‌صفحه --}}
    <section class="relative min-h-[calc(100vh-120px)] flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 xl:px-12 py-8 lg:py-14 z-10">
        <div class="w-full max-w-7xl mx-auto flex flex-col">

            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-xs sm:text-sm text-stone-600 dark:text-stone-400 mb-6 space-x-2 space-x-reverse" aria-label="مسیر راهنما">
                <a href="/" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors font-medium">صفحه اصلی</a>
                <span class="text-stone-400 dark:text-stone-600">/</span>
                <span class="text-amber-700 dark:text-amber-400 font-semibold">دانلود اپلیکیشن تابلوی طلافروشی</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center w-full">
                
                {{-- ستون راست: معرفی سئو، ارزش نرم‌افزار و کارت‌های دانلود (۷ ستون) --}}
                <div class="lg:col-span-7 text-right space-y-6">
                    
                    {{-- بج نسخه جدید --}}
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-stone-100 dark:bg-stone-800 border border-stone-200 dark:border-stone-700 text-stone-700 dark:text-stone-300 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>نسخه ۱.۰.۸ • مجهز به سیستم بروزرسانی آنلاین (OTA) و کنترل ریموت</span>
                    </div>

                    {{-- تیتر اصلی H1 --}}
                    <div class="space-y-4">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-stone-900 dark:text-stone-50 leading-[1.2] tracking-tight">
                            دانلود مستقیم اپلیکیشن طلالایو
                            <span class="block text-amber-700 dark:text-amber-400 text-2xl sm:text-3xl lg:text-4xl mt-1.5 font-bold">
                                نرم‌افزار هوشمند تابلوی طلافروشی و تلویزیون
                            </span>
                        </h1>
                        <p class="text-stone-700 dark:text-stone-300 text-base sm:text-lg leading-relaxed max-w-2xl">
                            با اپلیکیشن رسمی طلالایو، هر تلویزیون هوشمند یا اندروید باکس را بدون نیاز به کامپیوتر یا مینی‌کیس به تابلوی دیجیتال لوکس طلا و جواهر تبدیل کنید. قیمت لحظه‌ای طلا، سکه و ویترین محصولات را تنها در چند ثانیه با موبایل خود از راه دور تنظیم و مدیریت نمایید.
                        </p>
                    </div>

                    {{-- پنل دانلود و راه‌اندازی سریع --}}
                    <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 sm:p-7 shadow-xs space-y-5">
                        
                        <div class="flex items-center justify-between flex-wrap gap-2 pb-2 border-b border-stone-200 dark:border-stone-800">
                            <span class="text-xs sm:text-sm font-bold text-stone-900 dark:text-stone-100 flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                                <span>دریافت فایل نصبی رسمی تلویزیون و پنل تحت وب:</span>
                            </span>
                            <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-md bg-stone-100 dark:bg-stone-800 text-emerald-700 dark:text-emerald-400 border border-stone-200 dark:border-stone-700">
                                نسخه رسمی و تایید شده
                            </span>
                        </div>

                        {{-- دکمه‌های دانلود --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- دانلود مستقیم APK برای تلویزیون -->
                            <a href="/downloads/talalive-tv.apk?v=1.0.8" 
                                class="app-badge-btn min-h-11 flex items-center gap-3.5 px-5 py-4 bg-amber-500 hover:bg-amber-400 text-stone-950 rounded-xl font-bold shadow-xs text-right transition-colors group">
                                <span class="text-stone-950 shrink-0">
                                    @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-7 h-7'])
                                </span>
                                <div class="min-w-0 flex-1">
                                    <span class="block text-[11px] font-semibold text-stone-900">دانلود مستقیم اپلیکیشن تلویزیون</span>
                                    <span class="block text-base font-bold truncate">طلالایو TV (نسخه ۱.۰.۸)</span>
                                    <span class="block text-[10px] text-stone-800 font-medium">حجم ۴۶ مگابایت • اندروید تی‌وی و باکس</span>
                                </div>
                            </a>

                            <!-- دکمه نصب اپلیکیشن PWA و پنل وب -->
                            <button type="button"
                                 id="pwa-app-card" 
                                 onclick="handlePwaClick(event)"
                                 class="app-badge-btn min-h-11 w-full flex items-center gap-3.5 px-5 py-4 bg-stone-100 hover:bg-stone-200 dark:bg-stone-800 dark:hover:bg-stone-700 border border-stone-300 dark:border-stone-700 rounded-xl text-stone-900 dark:text-stone-50 shadow-xs text-right cursor-pointer select-none transition-colors">
                                <span class="text-amber-700 dark:text-amber-400 shrink-0">
                                    @include('partials.ui-icon', ['name' => 'smartphone', 'class' => 'w-7 h-7'])
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="block text-[11px] text-stone-600 dark:text-stone-400 font-medium">وب‌اپلیکیشن پیش‌رونده (PWA)</span>
                                        <span id="pwa-status-badge" class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-amber-50 dark:bg-amber-500/10 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-500/25">
                                            نصب مستقیم
                                        </span>
                                    </div>
                                    <span class="block text-base font-bold text-amber-700 dark:text-amber-400 truncate">نصب PWA و پنل وب</span>
                                    <span class="block text-[10px] text-stone-600 dark:text-stone-400 font-medium">سازگار با اندروید، آیفون و ویندوز</span>
                                </div>
                            </button>
                        </div>

                        {{-- لینک‌های کمکی: اتصال سریع و دموی زنده --}}
                        <div class="pt-2 flex flex-wrap items-center justify-between gap-3 text-xs">
                            <span class="text-stone-600 dark:text-stone-400">نیاز به تست سریع یا اتصال تلویزیون دارید؟</span>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('display.tv') }}" class="min-h-11 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-stone-100 hover:bg-stone-200 dark:bg-stone-800 dark:hover:bg-stone-700 text-stone-900 dark:text-stone-100 font-semibold border border-stone-300 dark:border-stone-700 transition-colors">
                                    <span>اتصال با کد ۶ رقمی (/tv)</span>
                                </a>
                                <a href="{{ url('/demo') }}" class="min-h-11 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-stone-100 dark:bg-stone-900 dark:hover:bg-stone-800 text-stone-800 dark:text-stone-200 font-semibold border border-stone-300 dark:border-stone-700 transition-colors">
                                    <span>مشاهده دموی زنده</span>
                                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- نوار شاخص‌های اعتماد ۴‌گانه --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1 text-xs text-stone-700 dark:text-stone-300 font-semibold">
                        <div class="flex items-center gap-2 bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-800 px-3 py-2 rounded-xl">
                            @include('partials.ui-icon', ['name' => 'bolt', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                            <span class="truncate">راه‌اندازی در ۶۰ ثانیه</span>
                        </div>
                        <div class="flex items-center gap-2 bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-800 px-3 py-2 rounded-xl">
                            @include('partials.ui-icon', ['name' => 'shield', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400'])
                            <span class="truncate">پایداری ۱۰۰٪ آفلاین</span>
                        </div>
                        <div class="flex items-center gap-2 bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-800 px-3 py-2 rounded-xl">
                            @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-4 h-4 text-stone-600 dark:text-stone-300'])
                            <span class="truncate">انواع تلویزیون هوشمند</span>
                        </div>
                        <div class="flex items-center gap-2 bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-800 px-3 py-2 rounded-xl">
                            @include('partials.ui-icon', ['name' => 'shield', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                            <span class="truncate">امضای دیجیتال ۳۰ ساله</span>
                        </div>
                    </div>
                </div>

                {{-- ستون چپ: شو روم بصری تلویزیون هوشمند (۵ ستون) --}}
                <div class="lg:col-span-5 flex flex-col justify-center items-center relative w-full">
                    <div class="relative w-full rounded-2xl p-2 bg-stone-900 border border-stone-800 shadow-xl group">
                        <figure class="relative rounded-xl overflow-hidden bg-stone-950 border border-stone-800 shadow-lg m-0">
                            <picture>
                                <source srcset="{{ asset('images/tv-preview.webp') }}?v=1.0.1" type="image/webp">
                                <img src="{{ asset('images/tv-preview.png') }}?v=1.0.1" 
                                     alt="اسکرین‌شات واقعی تابلوی طلافروشی طلالایو روی تلویزیون هوشمند Android TV با نمایش لحظه‌ای قیمت طلا، سکه و ویترین طلا" 
                                     title="پیش‌نمایش زنده اپلیکیشن تابلوی طلافروشی طلالایو روی تلویزیون مغازه"
                                     class="w-full h-auto object-cover block select-none"
                                     width="1024" 
                                     height="577" 
                                     loading="eager"
                                     fetchpriority="high"
                                     decoding="async">
                            </picture>

                            <figcaption class="sr-only">اسکرین‌شات واقعی تابلوی هوشمند نرخ لحظه‌ای طلا و سکه طلالایو روی تلویزیون هوشمند طلافروشی</figcaption>

                            {{-- برچسب زنده بودن و اتصال در گوشه تصویر --}}
                            <div class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-stone-950/90 border border-stone-700 text-[10px] font-semibold text-stone-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span>پیش‌نمایش زنده اپلیکیشن (v1.0.8)</span>
                            </div>
                        </figure>
                    </div>

                    {{-- کادر راهنمای ریموت کنترل تلویزیون --}}
                    <div class="mt-4 w-full bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-xl p-3 text-xs text-stone-700 dark:text-stone-300 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            @include('partials.ui-icon', ['name' => 'sliders', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                            <span>کنترل کامل بزرگ‌نمایی و تنظیمات با ریموت تلویزیون</span>
                        </div>
                        <span class="font-mono text-stone-500 font-bold tabular-nums">v1.0.8</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ۲. شبکه ۴‌ستونه قابلیت‌های تخصصی اپلیکیشن طلالایو --}}
    <section class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 my-12 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 border border-stone-200 dark:border-stone-700 mb-3">
                ویژگی‌های مهندسی‌شده اپلیکیشن
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold text-stone-900 dark:text-stone-50">
                ویژگی‌های ویژه استفاده دائمی روی تلویزیون مغازه
            </h2>
            <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 mt-2">
                برخلاف روش‌های قدیمی که نیازمند کامپیوتر یا مینی‌کیس بودند، اپلیکیشن طلالایو مستقیماً برای کارکرد بی‌وقفه طراحی شده است:
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- کارت ۱ --}}
            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 shadow-xs hover:border-amber-500/50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 flex items-center justify-center mb-4 border border-amber-200 dark:border-amber-500/25">
                    @include('partials.ui-icon', ['name' => 'bolt', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-50 mb-2">روشن شدن خودکار با برق مغازه</h3>
                <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                    مجهز به سرویس بومی Boot Receiver؛ هنگام باز کردن مغازه و اتصال برق، تلویزیون مستقیماً تابلوی قیمت‌ها را باز می‌کند.
                </p>
            </div>

            {{-- کارت ۲ --}}
            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 shadow-xs hover:border-amber-500/50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-stone-100 dark:bg-stone-800 text-emerald-700 dark:text-emerald-400 flex items-center justify-center mb-4 border border-stone-200 dark:border-stone-700">
                    @include('partials.ui-icon', ['name' => 'shield', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-50 mb-2">کارکرد پایدار آفلاین</h3>
                <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                    در زمان قطعی اینترنت، تابلوی شما هرگز متوقف نمی‌شود؛ بلکه آخرین نرخ‌های معتبر همراه با برچسب ساعت مداوم نمایش می‌یابند.
                </p>
            </div>

            {{-- کارت ۳ --}}
            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 shadow-xs hover:border-amber-500/50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 flex items-center justify-center mb-4 border border-stone-200 dark:border-stone-700">
                    @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-50 mb-2">محافظت از پنل و ضد سایه</h3>
                <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                    بهینه‌سازی مصرف پردازنده و جابه‌جایی ظریف اجزای ثابت برای حفظ سلامت دائمی پیکسل‌های تلویزیون‌های LED و OLED.
                </p>
            </div>

            {{-- کارت ۴ --}}
            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 shadow-xs hover:border-amber-500/50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 flex items-center justify-center mb-4 border border-stone-200 dark:border-stone-700">
                    @include('partials.ui-icon', ['name' => 'smartphone', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-50 mb-2">کنترل بی‌سیم با گوشی موبایل</h3>
                <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                    حتی زمانی که در مغازه حضور ندارید، با گوشی موبایل خود می‌توانید فرمول سود، اسلایدشوی محصولات و نحوه نمایش تابلو را تنظیم کنید.
                </p>
            </div>
        </div>
    </section>

    {{-- ۳. آموزش گام‌به‌گام نصب و راه‌اندازی --}}
    <section class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 my-16 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 border border-stone-200 dark:border-stone-700 mb-3">
                راهنمای راه‌اندازی
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold text-stone-900 dark:text-stone-50">
                آموزش گام‌به‌گام نصب اپلیکیشن روی تلویزیون طلافروشی
            </h2>
            <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 mt-2">
                برای اتصال پایدار تابلوی طلالایو روی انواع تلویزیون اندروید تی‌وی و باکس‌ها، مراحل زیر را طی کنید:
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            
            <!-- گام ۱: فعال‌سازی منابع ناشناس -->
            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 font-bold text-base flex items-center justify-center shrink-0 border border-amber-200 dark:border-amber-500/25">
                            ۱
                        </div>
                        <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">
                            فعال‌سازی مجوز «نصب از منابع ناشناس» (Unknown Sources)
                        </h3>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                        چون اپلیکیشن طلالایو به صورت مستقیم (APK) نصب می‌شود، این مجوز را در تنظیمات فعال کنید:
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        <div class="p-3.5 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 block mb-1">تلویزیون‌های Android TV:</span>
                            <p class="text-xs text-stone-700 dark:text-stone-300 leading-relaxed">
                                تنظیمات > برنامه‌ها > امنیت > <strong>نصب برنامه‌های ناشناس</strong> را برای مرورگر روی <span class="text-emerald-700 dark:text-emerald-400 font-bold">مجاز (Allow)</span> بگذارید.
                            </p>
                        </div>
                        <div class="p-3.5 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 block mb-1">اندروید باکس‌ها:</span>
                            <p class="text-xs text-stone-700 dark:text-stone-300 leading-relaxed">
                                تنظیمات (Settings) > امنیت (Security) > تیک گزینه <strong>منابع ناشناخته (Unknown Sources)</strong> را فعال نمایید.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- گام ۲: روش‌های انتقال فایل به تلویزیون -->
            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 font-bold text-base flex items-center justify-center shrink-0 border border-amber-200 dark:border-amber-500/25">
                            ۲
                        </div>
                        <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">
                            روش‌های انتقال و دانلود فایل نصبی در تلویزیون
                        </h3>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                        می‌توانید از یکی از روش‌های ساده زیر برای رساندن فایل نصبی به تلویزیون یا باکس استفاده کنید:
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-1">
                        <div class="p-3 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700 text-right">
                            <strong class="text-xs font-bold text-stone-900 dark:text-stone-50 block mb-0.5">روش اول: فلش مموری</strong>
                            <p class="text-[11px] text-stone-600 dark:text-stone-400 leading-relaxed">دانلود فایل با کامپیوتر، انتقال به فلش و نصب با فایل‌منیجر.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700 text-right">
                            <strong class="text-xs font-bold text-stone-900 dark:text-stone-50 block mb-0.5">روش دوم: مرورگر تلویزیون</strong>
                            <p class="text-[11px] text-stone-600 dark:text-stone-400 leading-relaxed">ورود به <code class="text-amber-700 dark:text-amber-400 font-mono">talalive.ir/app</code> با مرورگر و دانلود مستقیم.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700 text-right">
                            <strong class="text-xs font-bold text-stone-900 dark:text-stone-50 block mb-0.5">روش سوم: با وای‌فای</strong>
                            <p class="text-[11px] text-stone-600 dark:text-stone-400 leading-relaxed">با نرم‌افزار Send Files to TV فایل را بی‌سیم منتقل کنید.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- گام ۳: مراحل جفت‌سازی -->
            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 font-bold text-base flex items-center justify-center shrink-0 border border-amber-200 dark:border-amber-500/25">
                            ۳
                        </div>
                        <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">
                            اتصال و جفت‌سازی تابلو با پنل مغازه
                        </h3>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                        پس از نصب، اپلیکیشن را باز کنید. یک کد ۶ رقمی همراه با بارکد QR ظاهر می‌شود؛ یکی از راه‌های زیر را انجام دهید:
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-1">
                        <div class="p-3 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 block mb-1">الف) ورود کد در پنل:</span>
                            <p class="text-[11px] text-stone-700 dark:text-stone-300 leading-relaxed">در بخش تلویزیون‌های من در پنل، دکمه افزودن دستگاه را بزنید و کد را وارد کنید.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 block mb-1">ب) اسکن QR Code:</span>
                            <p class="text-[11px] text-stone-700 dark:text-stone-300 leading-relaxed">دوربین موبایل را جلوی بارکد تلویزیون بگیرید تا درجا فعال شود.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 block mb-1">ج) پیامک لینک:</span>
                            <p class="text-[11px] text-stone-700 dark:text-stone-300 leading-relaxed">دکمه ارسال پیامک را با ریموت بزنید و شماره موبایل را وارد نمایید.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- گام ۴: حل مشکل بالا نیامدن پس از قطع برق -->
            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 font-bold text-base flex items-center justify-center shrink-0 border border-amber-200 dark:border-amber-500/25">
                            ۴
                        </div>
                        <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">
                            اگر تلویزیون پس از قطع برق خودش بالا نمی‌آید
                        </h3>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                        اپلیکیشن طلالایو مجهز به گیرنده خودکار روشن شدن با برق (Boot Receiver) است. با این حال در برخی تلویزیون‌ها:
                    </p>
                    <div class="p-3.5 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700 space-y-1.5">
                        <strong class="text-xs font-bold text-amber-700 dark:text-amber-400 block">انتخاب طلالایو به عنوان برنامه پیش‌فرض خانه (Home App):</strong>
                        <p class="text-xs text-stone-700 dark:text-stone-300 leading-relaxed">
                            به <strong>تنظیمات تلویزیون</strong> > <strong>برنامه‌ها</strong> > <strong>برنامه‌های پیش‌فرض</strong> > <strong>برنامه خانه</strong> رفته و گزینه <strong>«طلالایو TV»</strong> را انتخاب کنید.
                        </p>
                    </div>
                </div>
            </div>

            <!-- گام ۵: حل مشکل عدم به‌روزرسانی قیمت‌ها -->
            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 font-bold text-base flex items-center justify-center shrink-0 border border-amber-200 dark:border-amber-500/25">
                            ۵
                        </div>
                        <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">
                            به‌روزرسانی موتور نمایش قیمت‌ها (Android System WebView)
                        </h3>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                        سامانه طلالایو از فناوری نسل جدید جاوااسکریپت برای به‌روزرسانی ثانیه‌ای نرخ‌ها استفاده می‌کند که نیازمند <strong>Android System WebView</strong> نسخه ۸۰ به بالاست:
                    </p>
                    <div class="p-3.5 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700 text-xs text-stone-700 dark:text-stone-300 space-y-1.5">
                        <p>۱. فروشگاه <strong>Google Play Store</strong> یا <strong>بازار</strong> را در تلویزیون باز کنید.</p>
                        <p>۲. عبارت <strong>Android System WebView</strong> را جستجو کرده و دکمه <strong>به‌روزرسانی (Update)</strong> را بزنید.</p>
                        <p>۳. پس از آپدیت، یک‌بار تلویزیون را خاموش و روشن کنید تا قیمت‌ها با حداکثر سرعت به‌روزرسانی شوند.</p>
                    </div>
                </div>
            </div>

            <!-- گام ۶: رفتار کلیدهای ریموت کنترل -->
            <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 font-bold text-base flex items-center justify-center shrink-0 border border-amber-200 dark:border-amber-500/25">
                            ۶
                        </div>
                        <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">
                            کلیدهای میانبر ریموت کنترل و امکانات نسخه جدید
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 pt-1">
                        <div class="p-3 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 block mb-1">کلیدهای جهت‌نما:</span>
                            <p class="text-[11px] text-stone-600 dark:text-stone-400">بزرگ‌نمایی و کوچک‌نمایی سریع مقیاس تابلو جهت تطابق بی‌نقص با انواع سایز تلویزیون.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 block mb-1">MENU یا نگه‌داشتن OK:</span>
                            <p class="text-[11px] text-stone-600 dark:text-stone-400">باز شدن منوی تنظیمات سریع، سوئیچ بین حالت وب و نیتیو و بررسی آپدیت آنلاین.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 block mb-1">دکمه BACK:</span>
                            <p class="text-[11px] text-stone-600 dark:text-stone-400">برای جلوگیری از بسته‌شدن تصادفی تابلو در مغازه، نیازمند دو بار فشردن سریع است.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 block mb-1">سیستم آپدیت آنلاین:</span>
                            <p class="text-[11px] text-stone-600 dark:text-stone-400">دریافت خودکار قابلیت‌های جدید بدون نیاز به فلش‌مموری یا تنظیمات دستی.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ۴. بخش سوالات متداول (FAQ) --}}
    <section class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 my-16 relative z-10">
        <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-6 sm:p-10 shadow-xs">
            <div class="text-center max-w-2xl mx-auto mb-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-stone-900 dark:text-stone-50">
                    سؤالات متداول درباره اپلیکیشن تابلوی طلالایو
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 mt-2">
                    پاسخ به سوالات متداول طلافروشان درباره نحوه دانلود، نصب و پشتیبانی اپلیکیشن
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-right">
                <div class="p-5 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                    <h3 class="text-sm sm:text-base font-bold text-amber-700 dark:text-amber-400 mb-2">۱. آیا استفاده از اپلیکیشن هزینه جداگانه دارد؟</h3>
                    <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                        خیر؛ با تهیه هر یک از پلن‌های اشتراک طلالایو، دسترسی به پنل اپلیکیشن موبایل، مدیریت تابلو و تمامی به‌روزرسانی‌های نسخه تلویزیون کاملاً رایگان خواهد بود.
                    </p>
                </div>

                <div class="p-5 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                    <h3 class="text-sm sm:text-base font-bold text-amber-700 dark:text-amber-400 mb-2">۲. اگر تلویزیون مغازه اندروید نباشد چه کنیم؟</h3>
                    <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                        تلویزیون‌های سامسونگ (Tizen) و ال‌جی (webOS) بدون نیاز به نصب هیچ نرم‌افزاری، مستقیماً از طریق مرورگر داخلی تلویزیون با آدرس <a href="{{ route('display.tv') }}" class="text-amber-700 dark:text-amber-400 underline font-bold">talalive.ir/tv</a> متصل می‌شوند. همچنین می‌توانید یک اندروید باکس ساده به تلویزیون وصل کنید.
                    </p>
                </div>

                <div class="p-5 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                    <h3 class="text-sm sm:text-base font-bold text-amber-700 dark:text-amber-400 mb-2">۳. چگونه نسخه وب را در گوشی ذخیره کنیم؟</h3>
                    <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                        با مرورگر گوشی به آدرس <a href="/admin/login" class="text-amber-700 dark:text-amber-400 underline font-bold">talalive.ir/admin/login</a> بروید و گزینه «Add to Home screen» (افزودن به صفحه اصلی) را بزنید تا همانند یک اپلیکیشن روی صفحه ظاهر شود.
                    </p>
                </div>

                <div class="p-5 rounded-xl bg-stone-100/80 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700">
                    <h3 class="text-sm sm:text-base font-bold text-amber-700 dark:text-amber-400 mb-2">۴. در صورت قطعی اینترنت، نمایشگر خاموش می‌شود؟</h3>
                    <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                        خیر؛ اپلیکیشن به صورت خودکار آخرین نرخ‌های معتبر را به همراه ساعت دقیق آخرین استعلام حفظ کرده و به مشتریان نمایش می‌دهد و به محض اتصال مجدد اینترنت، بدون دخالت دست آپدیت می‌شود.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ۵. بنر تبدیل پایانی --}}
    <section class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 mb-16 relative z-10">
        <div class="relative rounded-2xl p-8 sm:p-10 bg-stone-100 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 text-center sm:text-right flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-2 max-w-xl">
                <h3 class="text-2xl sm:text-3xl font-bold text-stone-900 dark:text-stone-50">
                    آماده‌اید تابلوی مدرن طلافروشی خود را روشن کنید؟
                </h3>
                <p class="text-sm text-stone-600 dark:text-stone-400">
                    همین حالا ثبت‌نام کنید و از ۱۴ روز تست کاملاً رایگان سامانه طلالایو روی تلویزیون مغازه بدون نیاز به پیش‌پرداخت بهره‌مند شوید.
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap justify-center shrink-0">
                <a href="{{ route('admin.register') }}" class="min-h-11 px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-xs transition-colors shadow-xs inline-flex items-center gap-1.5">
                    <span>ثبت‌نام گالری طلا (۱۴ روز رایگان)</span>
                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
                </a>
                <a href="{{ url('/demo') }}" class="min-h-11 px-5 py-2.5 rounded-xl bg-white hover:bg-stone-100 dark:bg-stone-800 dark:hover:bg-stone-700 text-stone-800 dark:text-stone-200 font-semibold text-xs border border-stone-300 dark:border-stone-700 transition-colors inline-flex items-center gap-1.5">
                    <span>مشاهده دموی زنده تابلو</span>
                </a>
            </div>
        </div>
    </section>

</div>

{{-- داده‌های ساختاریافته موتورهای جستجو (Schema.org JSON-LD) --}}
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "SoftwareApplication",
      "@@id": "https://talalive.ir/app#software",
      "name": "اپلیکیشن طلالایو TV",
      "operatingSystem": "Android TV, Google TV, Android Box, Web Browser",
      "applicationCategory": "BusinessApplication",
      "description": "نرم‌افزار هوشمند مدیریت تابلوی طلافروشی، نمایش لحظه‌ای نرخ طلا و سکه روی تلویزیون مغازه بدون نیاز به کامپیوتر یا مینی‌کیس.",
      "softwareVersion": "1.0.8",
      "fileSize": "48683203",
      "downloadUrl": "https://talalive.ir/downloads/talalive-tv.apk",
      "image": {
        "@@type": "ImageObject",
        "url": "https://talalive.ir/images/tv-preview.png",
        "contentUrl": "https://talalive.ir/images/tv-preview.webp",
        "caption": "اسکرین‌شات واقعی اپلیکیشن تابلوی هوشمند طلافروشی طلالایو روی تلویزیون",
        "width": 1024,
        "height": 577
      },
      "screenshot": [
        {
          "@@type": "ImageObject",
          "url": "https://talalive.ir/images/tv-preview.png",
          "contentUrl": "https://talalive.ir/images/tv-preview.webp",
          "caption": "نمای واقعی تابلوی هوشمند نرخ لحظه‌ای طلا، سکه و ویترین آنلاین روی تلویزیون مغازه",
          "width": 1024,
          "height": 577
        }
      ],
      "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "IRR",
        "category": "Free Trial"
      },
      "publisher": {
        "@@type": "Organization",
        "name": "طلالایو",
        "url": "https://talalive.ir"
      }
    },
    {
      "@@type": "BreadcrumbList",
      "@@id": "https://talalive.ir/app#breadcrumb",
      "itemListElement": [
        {
          "@@type": "ListItem",
          "position": 1,
          "name": "صفحه اصلی",
          "item": "https://talalive.ir"
        },
        {
          "@@type": "ListItem",
          "position": 2,
          "name": "دانلود اپلیکیشن تابلوی طلافروشی",
          "item": "https://talalive.ir/app"
        }
      ]
    },
    {
      "@@type": "HowTo",
      "@@id": "https://talalive.ir/app#howto",
      "name": "آموزش نصب و اتصال اپلیکیشن طلالایو روی تلویزیون مغازه",
      "description": "راهنمای گام‌به‌گام نصب نرم‌افزار طلالایو روی انواع تلویزیون اندروید تی‌وی و اتصال آن به پنل مغازه بدون کابل‌کشی.",
      "step": [
        {
          "@@type": "HowToStep",
          "position": 1,
          "name": "فعال‌سازی مجوز نصب از منابع ناشناس",
          "text": "در تنظیمات تلویزیون به بخش امنیت رفته و مجوز Install Unknown Apps را فعال کنید."
        },
        {
          "@@type": "HowToStep",
          "position": 2,
          "name": "انتقال فایل APK به تلویزیون",
          "text": "فایل نصبی talalive-tv.apk را با فلش مموری یا مرورگر تلویزیون باز کنید."
        },
        {
          "@@type": "HowToStep",
          "position": 3,
          "name": "جفت‌سازی با کد ۶ رقمی یا اسکن بارکد",
          "text": "کد ۶ رقمی نمایش داده شده روی تلویزیون را در پنل موبایل خود وارد کنید."
        }
      ]
    },
    {
      "@@type": "FAQPage",
      "@@id": "https://talalive.ir/app#faq",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "آیا استفاده از اپلیکیشن هزینه جداگانه دارد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "خیر؛ دسترسی به اپلیکیشن همراه با اشتراک تابلوی طلالایو کاملاً رایگان است."
          }
        },
        {
          "@@type": "Question",
          "name": "اگر تلویزیون مغازه اندروید نباشد چه کنیم؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "تلویزیون‌های سامسونگ و ال‌جی مستقیماً از طریق مرورگر اینترنت بدون نیاز به نرم‌افزار متصل می‌شوند."
          }
        }
      ]
    }
  ]
}
</script>

    {{-- مودال هوشمند و زیبای راهنمای نصب وب‌اپلیکیشن PWA --}}
    <div id="pwa-install-modal" 
         style="display: none; position: fixed; top: 0; right: 0; bottom: 0; left: 0; width: 100vw; height: 100vh; z-index: 9999999; background-color: rgba(2, 6, 23, 0.82); -webkit-backdrop-filter: blur(14px); backdrop-filter: blur(14px); align-items: center; justify-content: center; padding: 1rem; box-sizing: border-box; opacity: 0; transition: opacity 0.25s ease-in-out;"
         class="pwa-modal-overlay">
        <div style="position: relative; width: 100%; max-width: 28rem; background-color: #ffffff; border-radius: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45); padding: 1.5rem; color: #0f172a; text-align: right; z-index: 10000000;"
             class="pwa-modal-box">
            
            <!-- هدر مودال -->
            <div class="flex items-center justify-between pb-3.5 border-b border-stone-200 dark:border-stone-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 flex items-center justify-center text-xl shrink-0 border border-amber-200 dark:border-amber-500/25">
                        @include('partials.ui-icon', ['name' => 'smartphone', 'class' => 'w-5 h-5'])
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-stone-900 dark:text-stone-50">نصب وب‌اپلیکیشن طلالایو (PWA)</h3>
                        <p class="text-[10px] sm:text-[11px] text-stone-600 dark:text-stone-400">نرم‌افزار مستقل، سبک و همیشه به‌روز</p>
                    </div>
                </div>
                <button onclick="closePwaModal()" class="w-8 h-8 rounded-lg bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-600 dark:text-stone-300 flex items-center justify-center text-lg transition-colors cursor-pointer" title="بستن">&times;</button>
            </div>

            <!-- محتوای وابسته به سیستم‌عامل -->
            <div class="py-4 space-y-3.5">
                
                {{-- راهنمای مخصوص iOS در مرورگر Safari --}}
                <div id="pwa-modal-ios-content" style="display: none;" class="space-y-3">
                    <div class="p-3.5 rounded-xl bg-stone-100 dark:bg-stone-800 border border-stone-200 dark:border-stone-700 text-xs text-stone-800 dark:text-stone-200 space-y-2 leading-relaxed">
                        <div class="font-bold flex items-center gap-1.5 text-xs sm:text-sm text-stone-900 dark:text-stone-50">
                            <span>راهنمای نصب روی آیفون و آیپد (سافاری):</span>
                        </div>
                        <ol class="list-decimal list-inside space-y-1.5 pr-1 font-medium text-[11px] sm:text-xs text-stone-700 dark:text-stone-300">
                            <li>در نوار پایین مرورگر <strong>Safari</strong> دکمه اشتراک‌گذاری <strong>Share</strong> را لمس کنید.</li>
                            <li>منو را کمی به پایین اسکرول کرده و گزینه <strong>«Add to Home Screen» (افزودن به صفحه اصلی)</strong> را انتخاب کنید.</li>
                            <li>در گوشه بالا، روی دکمه <strong>«Add»</strong> بزنید تا آیکون طلالایو به صفحه اصلی گوشی اضافه شود.</li>
                        </ol>
                    </div>
                </div>

                {{-- راهنمای عمومی / اندروید و دسکتاپ --}}
                <div id="pwa-modal-general-content" class="space-y-3">
                    <p class="text-xs text-stone-700 dark:text-stone-300 leading-relaxed">
                        نرم‌افزار طلالایو بدون نیاز به دانلود فایل‌های حجیم مستقیماً روی گوشی یا رایانه شما نصب شده و همواره آخرین نسخه را دریافت می‌کند.
                    </p>

                    <div id="pwa-native-install-section" style="display: none;">
                        <button onclick="triggerPwaPromptFromModal()" type="button" class="w-full min-h-11 py-2.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 cursor-pointer transition-colors shadow-xs">
                            @include('partials.ui-icon', ['name' => 'smartphone', 'class' => 'w-4 h-4'])
                            <span>نصب مستقیم اپلیکیشن روی دستگاه</span>
                        </button>
                    </div>

                    <div id="pwa-browser-manual-guide" class="p-3 rounded-xl bg-stone-100 dark:bg-stone-800/80 border border-stone-200 dark:border-stone-700 text-xs text-stone-700 dark:text-stone-300 space-y-1">
                        <div class="font-bold flex items-center gap-1.5 text-amber-700 dark:text-amber-400 text-xs">
                            <span>نصب از طریق منوی مرورگر:</span>
                        </div>
                        <p class="text-[11px] leading-relaxed text-stone-600 dark:text-stone-400">
                            در مرورگر کروم یا اج، روی <strong>آیکون نصب</strong> در نوار آدرس یا از منوی سه‌نقطه گزینه <strong>«Install TalaLive»</strong> را انتخاب کنید.
                        </p>
                    </div>
                </div>

                {{-- حالت اپلیکیشن نصب‌شده --}}
                <div id="pwa-modal-installed-content" style="display: none;" class="p-3.5 rounded-xl bg-stone-100 dark:bg-stone-800 border border-stone-200 dark:border-stone-700 text-xs text-stone-800 dark:text-stone-200 space-y-1">
                    <div class="font-bold flex items-center gap-1.5 text-xs sm:text-sm text-emerald-700 dark:text-emerald-400">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4'])
                        <span>اپلیکیشن طلالایو روی دستگاه شما نصب است!</span>
                    </div>
                    <p class="text-[11px] text-stone-600 dark:text-stone-400">می‌توانید مستقیماً وارد پنل مدیریت تابلوی طلا شوید.</p>
                </div>
            </div>

            <!-- دکمه‌های فوتر مودال -->
            <div class="pt-3 border-t border-stone-200 dark:border-stone-800 flex items-center justify-between gap-2.5">
                <a href="/admin/login" class="flex-1 min-h-11 py-2.5 px-3 rounded-xl bg-stone-100 hover:bg-stone-200 dark:bg-stone-800 dark:hover:bg-stone-700 text-stone-900 dark:text-stone-100 font-bold text-xs border border-stone-300 dark:border-stone-700 text-center transition-colors inline-flex items-center justify-center">
                    ورود به پنل وب (/admin)
                </a>
                <button onclick="closePwaModal()" type="button" class="min-h-11 py-2.5 px-4 rounded-xl bg-white hover:bg-stone-100 dark:bg-stone-900 dark:hover:bg-stone-800 text-stone-700 dark:text-stone-300 font-semibold text-xs border border-stone-300 dark:border-stone-700 transition-colors cursor-pointer">
                    بستن
                </button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
            const isIos = /iphone|ipad|ipod/.test(navigator.userAgent.toLowerCase()) && !window.MSStream;

            function updatePwaUi() {
                const badge = document.getElementById('pwa-status-badge');
                if (isStandalone && badge) {
                    badge.innerText = 'نصب شده';
                    badge.className = 'text-[10px] font-black px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border border-emerald-500/25';
                }
                const promptEvent = window.__pwaDeferredPrompt;
                const nativeSec = document.getElementById('pwa-native-install-section');
                const manualSec = document.getElementById('pwa-browser-manual-guide');
                if (nativeSec && promptEvent) {
                    nativeSec.style.display = 'block';
                    if (manualSec) manualSec.style.display = 'none';
                }
            }

            window.addEventListener('load', updatePwaUi);
            window.addEventListener('talalive-pwa-ready', updatePwaUi);

            window.handlePwaClick = function(e) {
                if (e) e.preventDefault();

                // اگر از قبل در حالت PWA نصب شده باز است
                if (isStandalone) {
                    window.location.href = '/admin/login';
                    return;
                }

                // اگر رویداد مستقیم نصب مرورگر موجود است، مستقیماً پرامپت شود
                const promptEvent = window.__pwaDeferredPrompt;
                if (promptEvent) {
                    promptEvent.prompt();
                    promptEvent.userChoice.then(function(choiceResult) {
                        if (choiceResult.outcome === 'accepted') {
                            const badge = document.getElementById('pwa-status-badge');
                            if (badge) {
                                badge.innerText = 'نصب شد';
                                badge.className = 'text-[10px] font-black px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border border-emerald-500/25';
                            }
                        }
                        window.__pwaDeferredPrompt = null;
                    });
                    return;
                }

                // در غیر این صورت، مودال هوشمند باز شود
                openPwaModal();
            };

            window.openPwaModal = function() {
                const modal = document.getElementById('pwa-install-modal');
                if (!modal) return;

                const iosContent = document.getElementById('pwa-modal-ios-content');
                const generalContent = document.getElementById('pwa-modal-general-content');
                const installedContent = document.getElementById('pwa-modal-installed-content');

                if (isStandalone) {
                    if (installedContent) installedContent.style.display = 'block';
                    if (generalContent) generalContent.style.display = 'none';
                    if (iosContent) iosContent.style.display = 'none';
                } else if (isIos) {
                    if (iosContent) iosContent.style.display = 'block';
                    if (generalContent) generalContent.style.display = 'none';
                    if (installedContent) installedContent.style.display = 'none';
                } else {
                    if (generalContent) generalContent.style.display = 'block';
                    if (iosContent) iosContent.style.display = 'none';
                    if (installedContent) installedContent.style.display = 'none';

                    const promptEvent = window.__pwaDeferredPrompt;
                    const nativeSec = document.getElementById('pwa-native-install-section');
                    const manualSec = document.getElementById('pwa-browser-manual-guide');
                    if (promptEvent) {
                        if (nativeSec) nativeSec.style.display = 'block';
                        if (manualSec) manualSec.style.display = 'none';
                    } else {
                        if (nativeSec) nativeSec.style.display = 'none';
                        if (manualSec) manualSec.style.display = 'block';
                    }
                }

                modal.style.display = 'flex';
                modal.classList.add('modal-active');
                document.body.style.overflow = 'hidden';
                setTimeout(function() { modal.style.opacity = '1'; }, 10);
            };

            window.closePwaModal = function() {
                const modal = document.getElementById('pwa-install-modal');
                if (!modal) return;
                modal.style.opacity = '0';
                document.body.style.overflow = '';
                setTimeout(function() { 
                    modal.style.display = 'none';
                    modal.classList.remove('modal-active');
                }, 250);
            };

            window.triggerPwaPromptFromModal = function() {
                const promptEvent = window.__pwaDeferredPrompt;
                if (promptEvent) {
                    promptEvent.prompt();
                    promptEvent.userChoice.then(function(choiceResult) {
                        window.__pwaDeferredPrompt = null;
                        closePwaModal();
                    });
                } else {
                    window.location.href = '/admin/login';
                }
            };

            // بستن با کلید Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closePwaModal();
            });

            // بستن با کلیک روی بک‌دراپ
            const modal = document.getElementById('pwa-install-modal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) closePwaModal();
                });
            }
        })();
    </script>
@endsection
