@extends('layouts.public')

@section('title', 'دانلود اپلیکیشن طلالایو — تابلوی طلافروشی برای اندروید و تلویزیون هوشمند')
@section('meta_desc', 'دانلود اپلیکیشن اندروید و اندروید تی‌وی طلالایو. مدیریت آنلاین تابلوی طلا، اتصال هوشمند به تلویزیون مغازه بدون کابل، و استعلام زنده مظنه و سکه در گوشی.')
@section('canonical', 'https://talalive.ir/app')

@push('styles')
<style>
    .app-badge-btn {
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .app-badge-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.2);
    }
</style>
@endpush

@section('content')
<div class="py-12 text-slate-800 dark:text-slate-100 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm text-slate-500 dark:text-slate-400 mb-8 space-x-2 space-x-reverse" aria-label="مسیر راهنما">
            <a href="/" class="hover:text-amber-500 dark:hover:text-amber-400 transition-colors">صفحه اصلی</a>
            <span>/</span>
            <span class="text-amber-600 dark:text-amber-400 font-medium">دانلود اپلیکیشن طلالایو</span>
        </nav>

        <!-- Hero Section -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center mb-16">
            <div class="lg:col-span-7 text-right">
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-500/30 mb-4">
                    نسخه همراه و تلویزیون هوشمند طلالایو
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-6 leading-tight">
                    دانلود اپلیکیشن هوشمند طلالایو | کنترل تابلوی طلا و مشاهده لحظه‌ای نرخ‌ها
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-300 mb-8 leading-relaxed">
                    با اپلیکیشن طلالایو، مدیریت کامل تابلوی قیمت طلافروشی و ویترین دیجیتال همیشه در دستان شماست. بدون نیاز به کامپیوتر یا کابل‌کشی، با گوشی خود تلویزیون مغازه را تنظیم کنید و در هر لحظه مظنه مثقال و قیمت سکه را به مشتریان نمایش دهید.
                </p>

                {{-- لینک‌های دانلود مستقیم و استورها --}}
                <div class="space-y-4">
                    <h2 class="text-base font-semibold text-slate-700 dark:text-slate-300">دریافت فایل نصبی رسمی تلویزیون و وب‌اپلیکیشن:</h2>
                    <div class="flex flex-wrap items-center gap-4">
                        <!-- دانلود مستقیم نسخه تلویزیون -->
                        <a href="/downloads/talalive-tv.apk?v=2.0.1" class="app-badge-btn flex items-center gap-4 px-6 py-4 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 rounded-2xl font-black shadow-xl text-right border border-amber-400/50">
                            <span class="text-3xl">📺</span>
                            <div>
                                <span class="block text-xs font-bold text-slate-900">دانلود مستقیم اپلیکیشن تلویزیون</span>
                                <span class="block text-base font-black">طلالایو TV (نسخه ۲.۰.۱)</span>
                                <span class="block text-[11px] text-slate-900 font-medium">حجم ۱.۰ مگابایت • ویژه اندروید تی‌وی و اندروید باکس</span>
                            </div>
                        </a>

                        <!-- وب اپلیکیشن PWA (سازگار با گوشی، آیفون و لپ‌تاپ) -->
                        <a href="/admin/login" class="app-badge-btn flex items-center gap-3 px-5 py-4 bg-white hover:bg-slate-50 dark:bg-slate-800 dark:hover:bg-slate-700/90 border border-slate-200 dark:border-slate-700 rounded-2xl text-slate-900 dark:text-white shadow-lg text-right">
                            <span class="text-2xl">⚡</span>
                            <div>
                                <span class="block text-[11px] text-slate-500 dark:text-slate-400 font-normal">نسخه بدون نیاز به نصب</span>
                                <span class="block text-sm font-black text-amber-600 dark:text-amber-400">پنل وب و PWA گوشی</span>
                                <span class="block text-[10px] text-emerald-600 dark:text-emerald-400">سازگار با اندروید و iOS</span>
                            </div>
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 pt-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="px-2.5 py-1 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">🔒 امضای دیجیتال رسمی ۳۰ ساله</span>
                        <span class="px-2.5 py-1 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">⚡ بدون وابستگی و بدون کندی</span>
                        <span class="px-2.5 py-1 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">🔄 مجهز به سیستم خودکار به‌روزرسانی</span>
                    </div>
                </div>
            </div>

            <!-- Visual / Mockup Preview -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-full max-w-sm">
                    <!-- Glow effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-amber-500 to-amber-700 rounded-3xl blur-xl opacity-20 dark:opacity-30"></div>
                    <!-- Mockup Phone Shell -->
                    <div class="relative bg-slate-100 dark:bg-slate-800 border-4 border-slate-300 dark:border-slate-700 rounded-[2.5rem] p-4 shadow-2xl overflow-hidden">
                        <div class="flex justify-center mb-4">
                            <div class="w-20 h-4 bg-slate-300 dark:bg-slate-900 rounded-full"></div>
                        </div>
                        <div class="bg-white dark:bg-slate-950 rounded-2xl p-4 text-center border border-slate-200 dark:border-slate-800 space-y-4 shadow-inner">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 text-xs">
                                <span class="text-emerald-600 dark:text-emerald-400 font-bold">● تابلوی متصل: سالن اصلی</span>
                                <span class="text-slate-500 dark:text-slate-400">طلالایو TV v2.0.1</span>
                            </div>
                            <div class="bg-amber-500/5 dark:bg-slate-900/90 rounded-xl p-3 border border-amber-500/20 text-right">
                                <span class="text-xs text-slate-500 dark:text-slate-400 block mb-1">نرخ هر گرم طلای ۱۸ عیار</span>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-black text-amber-600 dark:text-amber-400">{{ number_format($rates['gold18'] ?: 3650000) }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">تومان</span>
                                </div>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-900/90 rounded-xl p-3 border border-slate-200 dark:border-slate-800 text-right">
                                <span class="text-xs text-slate-500 dark:text-slate-400 block mb-1">مظنه مثقال ۱۷ عیار تهران</span>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-black text-slate-900 dark:text-white">{{ number_format($rates['mesghal'] ?: 15800000) }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">تومان</span>
                                </div>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-900/90 rounded-xl p-3 border border-slate-200 dark:border-slate-800 text-right">
                                <span class="text-xs text-slate-500 dark:text-slate-400 block mb-1">سکه تمام طرح جدید (امامی)</span>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-black text-slate-900 dark:text-white">{{ number_format($rates['coin_emami'] ?: 43500000) }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">تومان</span>
                                </div>
                            </div>
                            <div class="pt-2">
                                <a href="/demo" class="block w-full py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-black rounded-lg shadow">
                                    مشاهده دموی زنده تابلوی کامل
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6 Mandatory TV Installation Guides (U-04) -->
        <div class="space-y-8 mb-16">
            <div class="text-center max-w-3xl mx-auto">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-500/20 mb-3">
                    راهنمای جامع راه‌اندازی بدون نیاز به تکنسین
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">
                    آموزش گام‌به‌گام نصب و راه‌اندازی اپلیکیشن روی تلویزیون مغازه
                </h2>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">
                    برای اتصال پایدار و دائمی تابلوی طلالایو روی انواع تلویزیون هوشمند (Sony, TCL, Snowa, Daewoo, X.Vision) و اندروید باکس‌ها، مراحل زیر را طی کنید:
                </p>
            </div>

            <!-- گام ۱: فعال‌سازی منابع ناشناس -->
            <div class="bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-lg">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 font-black text-lg flex items-center justify-center flex-shrink-0 border border-amber-500/30 dark:border-amber-500/40">
                        ۱
                    </div>
                    <div class="space-y-3 flex-1">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">فعال‌سازی مجوز «نصب از منابع ناشناس» (Unknown Sources)</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            چون اپلیکیشن طلالایو به صورت مستقیم (APK) نصب می‌شود، سیستم‌عامل اندروید به صورت پیش‌فرض برای امنیت نصب برنامه‌ها را متوقف می‌کند. قبل از نصب باید این مجوز را فعال کنید:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60">
                                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 block mb-1">در تلویزیون‌های Android TV و Google TV:</span>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                    به <strong>تنظیمات (Settings)</strong> > <strong>برنامه‌ها (Apps)</strong> > <strong>امنیت و محدودیت‌ها (Security & Restrictions)</strong> بروید و گزینه <strong>نصب برنامه‌های ناشناس (Install Unknown Apps)</strong> را برای مرورگر یا فایل منیجر خود روی حالت <span class="text-emerald-600 dark:text-emerald-400 font-bold">مجاز (Allow)</span> بگذارید.
                                </p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60">
                                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 block mb-1">در اندروید باکس‌های معمولی:</span>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                    به <strong>تنظیمات (Settings)</strong> > <strong>امنیت (Security)</strong> رفته و تیک گزینه <strong>منابع ناشناخته (Unknown Sources)</strong> را فعال نمایید.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- گام ۲: روش‌های انتقال فایل به تلویزیون -->
            <div class="bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-lg">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 font-black text-lg flex items-center justify-center flex-shrink-0 border border-amber-500/30 dark:border-amber-500/40">
                        ۲
                    </div>
                    <div class="space-y-3 flex-1">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">روش‌های انتقال و دانلود فایل نصبی در تلویزیون</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            می‌توانید از یکی از سه روش سادهٔ زیر برای رساندن فایل نصبی به تلویزیون یا باکس مغازه استفاده کنید:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60 text-right">
                                <span class="text-2xl block mb-2">💾</span>
                                <strong class="text-sm font-bold text-slate-900 dark:text-white block mb-1">روش اول: فلش مموری</strong>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">فایل APK را با کامپیوتر یا گوشی دانلود کرده، داخل فلش بریزید و با فایل منیجر تلویزیون نصب کنید.</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60 text-right">
                                <span class="text-2xl block mb-2">🌐</span>
                                <strong class="text-sm font-bold text-slate-900 dark:text-white block mb-1">روش دوم: مرورگر تلویزیون</strong>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">مرورگر تلویزیون (Chrome یا TV Bro) را باز کنید، آدرس <code class="text-amber-600 dark:text-amber-400">talalive.ir/app</code> را وارد کرده و دکمه دانلود را بزنید.</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60 text-right">
                                <span class="text-2xl block mb-2">📲</span>
                                <strong class="text-sm font-bold text-slate-900 dark:text-white block mb-1">روش سوم: ارسال با وای‌فای</strong>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">با نصب اپلیکیشن رایگان <strong>Send Files to TV</strong> روی گوشی و تلویزیون، فایل را در ۱ ثانیه با وای‌فای منتقل کنید.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- گام ۳: مراحل جفت‌سازی -->
            <div class="bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-lg">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 font-black text-lg flex items-center justify-center flex-shrink-0 border border-amber-500/30 dark:border-amber-500/40">
                        ۳
                    </div>
                    <div class="space-y-3 flex-1">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">اتصال و جفت‌سازی تابلو با پنل مغازه (۳ روش)</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            پس از نصب، اپلیکیشن «طلالایو TV» را اجرا کنید. یک کد ۶ کاراکتری درشت همراه با QR Code روی صفحه ظاهر می‌شود. برای اتصال تابلو به حساب کاربری خود، یکی از ۳ راه زیر را انجام دهید:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60">
                                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 block mb-1">الف) ورود کد در پنل:</span>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                    در گوشی وارد پنل کاربری بخش <strong>تلویزیون‌های من</strong> شوید، دکمه «افزودن دستگاه» را بزنید و کد ۶ حرفی را وارد کنید.
                                </p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60">
                                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 block mb-1">ب) اسکن QR Code:</span>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                    دوربین گوشی خود را جلوی بارکد تلویزیون بگیرید؛ لینک باز می‌شود و با تایید در پنل، تابلو درجا فعال می‌گردد.
                                </p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60">
                                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 block mb-1">ج) ارسال پیامک:</span>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                    روی دکمه «ارسال پیامک به موبایلم» با ریموت بزنید، شمارهٔ خود را وارد کنید تا لینک اتصال مستقیم پیامک شود.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- گام ۴: حل مشکل بالا نیامدن پس از قطع برق -->
            <div class="bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-lg">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 font-black text-lg flex items-center justify-center flex-shrink-0 border border-amber-500/30 dark:border-amber-500/40">
                        ۴
                    </div>
                    <div class="space-y-3 flex-1">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">اگر تلویزیون شما پس از قطع برق خودش بالا نمی‌آید</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            اپلیکیشن طلالایو مجهز به گیرندهٔ خودکار روشن شدن با برق (Boot Receiver) است. با این حال در برخی تلویزیون‌های جدید با اندروید ۱۰ و بالاتر به دلیل سیاست‌های امنیتی گوگل، اجرای خودکار پس‌زمینه محدود شده است. برای حل دائمی این موضوع:
                        </p>
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60 space-y-2">
                            <strong class="text-sm font-bold text-amber-600 dark:text-amber-400 block">انتخاب طلالایو به عنوان صفحهٔ پیش‌فرض خانه (Home Launcher):</strong>
                            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                به <strong>تنظیمات تلویزیون</strong> > <strong>برنامه‌ها</strong> > <strong>برنامه‌های پیش‌فرض (Default Apps)</strong> > <strong>برنامه خانه (Home App)</strong> رفته و گزینه <strong>«طلالایو TV»</strong> را به عنوان برنامه پیش‌فرض انتخاب کنید. با این کار، تلویزیون بلافاصله پس از اتصال به برق و روشن شدن، مستقیماً تابلوی قیمت‌ها را نمایش می‌دهد.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- گام ۵: حل مشکل عدم به‌روزرسانی قیمت‌ها (آپدیت وب‌ویو) -->
            <div class="bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-lg">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 font-black text-lg flex items-center justify-center flex-shrink-0 border border-amber-500/30 dark:border-amber-500/40">
                        ۵
                    </div>
                    <div class="space-y-3 flex-1">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">اگر تابلو بالا می‌آید ولی قیمت‌ها عوض نمی‌شوند (آپدیت موتور نمایش)</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            سامانه مدرن طلالایو از فناوری نسل جدید جاوااسکریپت برای به‌روزرسانی ثانیه‌ای نرخ‌ها استفاده می‌کند که نیازمند موتور نمایش <strong>Android System WebView</strong> نسخهٔ ۸۰ یا بالاتر است. اگر تلویزیون شما پیام هشدار موتور قدیمی نمایش داد:
                        </p>
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60 text-xs text-slate-600 dark:text-slate-300 space-y-2">
                            <p>۱. فروشگاه <strong>Google Play Store</strong> یا <strong>بازار</strong> را در تلویزیون باز کنید.</p>
                            <p>۲. عبارت <strong>Android System WebView</strong> را جستجو کنید و دکمهٔ <strong>به‌روزرسانی (Update)</strong> را بزنید.</p>
                            <p>۳. پس از اتمام آپدیت، یک بار تلویزیون را خاموش و روشن کنید؛ تابلوی شما با حداکثر سرعت و بدون وقفه قیمت‌ها را تغییر خواهد داد.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- گام ۶: رفتار کلیدهای ریموت کنترل -->
            <div class="bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-lg">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 font-black text-lg flex items-center justify-center flex-shrink-0 border border-amber-500/30 dark:border-amber-500/40">
                        ۶
                    </div>
                    <div class="space-y-3 flex-1">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">کلیدهای میانبر ریموت کنترل در اپلیکیشن</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60">
                                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 block mb-1">دکمه MENU یا نگه‌داشتن OK:</span>
                                <p class="text-xs text-slate-500 dark:text-slate-400">باز شدن منوی تنظیمات شامل بارگذاری مجدد، اطلاعات نسخه دستگاه، و گزینهٔ قطع اتصال.</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60">
                                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 block mb-1">دکمه BACK (بازگشت):</span>
                                <p class="text-xs text-slate-500 dark:text-slate-400">برای جلوگیری از خروج ناخواسته شاگردان یا مشتریان، نیاز به دو بار فشردن دکمه در ۳ ثانیه دارد.</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-700/60">
                                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 block mb-1">قطع اینترنت:</span>
                                <p class="text-xs text-slate-500 dark:text-slate-400">نمایش خودکار لایهٔ آفلاین نیتیو با ساعت آخرین نرخ و اتصال مجدد هوشمند بدون نیاز به ریموت.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-white dark:bg-slate-800/70 border border-slate-200 dark:border-slate-700/60 rounded-2xl p-6 sm:p-8 mb-12 shadow-lg">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">سؤالات متداول درباره اپلیکیشن طلالایو</h2>
            <div class="space-y-6 text-slate-600 dark:text-slate-300">
                <div>
                    <h3 class="text-base font-semibold text-amber-600 dark:text-amber-400 mb-2">۱. آیا استفاده از اپلیکیشن هزینه جداگانه دارد؟</h3>
                    <p class="text-sm leading-relaxed">
                        خیر؛ با تهیه هر یک از پلن‌های اشتراک طلالایو، دسترسی به پنل اپلیکیشن موبایل، مدیریت تابلو و به‌روزرسانی‌ها کاملاً رایگان خواهد بود.
                    </p>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-amber-600 dark:text-amber-400 mb-2">۲. چگونه می‌توانم بدون استور، نسخه تحت وب را در گوشی ذخیره کنم؟</h3>
                    <p class="text-sm leading-relaxed">
                        کافیست با مرورگر گوشی وارد آدرس <a href="/admin/login" class="text-amber-600 dark:text-amber-400 underline font-semibold">talalive.ir/admin/login</a> شوید و گزینه «Add to Home screen» (افزودن به صفحه اصلی) را انتخاب فرمایید تا آیکون اپلیکیشن همانند برنامه‌های معمولی روی صفحه گوشی ظاهر شود.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function scrollToNotify(platform) {
    const notifySec = document.getElementById('notify-section');
    if (notifySec) {
        notifySec.scrollIntoView({ behavior: 'smooth' });
    }
    const sel = document.getElementById('wl-platform');
    if (sel && platform) {
        if (platform.includes('اندروید') || platform.includes('بازار') || platform.includes('مایکت')) {
            sel.value = 'android_phone';
        }
    }
}

function handleWaitlistSubmit(e) {
    e.preventDefault();
    document.getElementById('waitlist-form').classList.add('hidden');
    document.getElementById('waitlist-success').classList.remove('hidden');
}
</script>

<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "SoftwareApplication",
      "@@id": "https://talalive.ir/app#software",
      "name": "اپلیکیشن طلالایو",
      "operatingSystem": "Android, iOS, Web",
      "applicationCategory": "BusinessApplication",
      "description": "نرم‌افزار هوشمند مدیریت تابلوی طلافروشی و استعلام لحظه‌ای مظنه آبشده و سکه.",
      "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "IRR"
      },
      "publisher": {
        "@@type": "Organization",
        "name": "طلالایو",
        "url": "https://talalive.ir"
      }
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
          "name": "آیا برای تلویزیون مغازه به دانلود نرم‌افزار نیاز داریم؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "خیر، تلویزیون‌های هوشمند مستقیماً از طریق مرورگر اینترنت متصل می‌شوند."
          }
        }
      ]
    }
  ]
}
</script>
@endsection
