@extends('layouts.public')

@php
    $seo = config('seo.pages.gold-board-without-device');
@endphp

@section('title', $seo['title'] ?? 'تابلو طلا بدون دستگاه: فقط تلویزیون و اینترنت | طلالایو')
@section('meta_description', $seo['desc'] ?? 'تابلو طلا بدون دستگاه برای تلویزیون مغازه: اعلام لحظه‌ای نرخ طلا و سکه بدون خرید مینی‌کیس و کابل‌کشی در کمتر از ۳ دقیقه. تست رایگان ۱۴ روزه را شروع کنید.')
@section('canonical', 'https://talalive.ir/gold-board-without-device')

@section('schema')
    {{-- اسکیمای استاندارد Service بدون ریتینگ --}}
    @include('partials.schema-service', [
        'name' => 'تابلو طلا بدون دستگاه طلالایو',
        'serviceType' => 'سامانه تابلوی هوشمند نرخ طلا بدون نیاز به کیس و سخت‌افزار جانبی',
        'description' => 'سامانه ابری اعلام لحظه‌ای نرخ طلا، سکه و ارز روی تلویزیون مغازه بدون نیاز به خرید مینی‌کیس، دستگاه واسط یا کابل‌کشی سخت‌افزاری.',
        'url' => 'https://talalive.ir/gold-board-without-device',
    ])

    {{-- اسکیمای پرسش و پاسخ متداول FAQPage --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "FAQPage",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "منظور از تابلو طلا بدون دستگاه چیست؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "تابلو طلا بدون دستگاه یعنی شما برای نمایش نرخ‌های لحظه‌ای در طلافروشی هیچ سخت‌افزار جداگانه‌ای مانند مینی‌کیس، دانگل انحصاری، کیس استوک یا تابلوی سنگین LED خریداری نمی‌کنید؛ بلکه با همان تلویزیونی که از قبل در مغازه دارید و با یک مرورگر وب، تابلوی حرفه‌ای خود را راه‌اندازی می‌نمایید."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا تلویزیون‌های معمولی و قدیمی هم قابل استفاده هستند؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "بله. اگر تلویزیون شما هوشمند نباشد، کافی است یک اندروید باکس اقتصادی یا دانگل ساده با ورودی HDMI به پشت تلویزیون متصل کنید تا به اینترنت وصل شده و بدون نیاز به خرید مینی‌کامپیوتر تک‌منظوره، تابلو روی آن اجرا شود."
          }
        },
        {
          "@@type": "Question",
          "name": "در صورت قطع شدن اینترنت، نمایش قیمت‌ها چه می‌شود؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "طلالایو مجهز به سیستم کش آفلاین پیشرفته است. در زمان نوسان یا قطعی موقت اینترنت، آخرین نرخ‌های معتبر روی صفحه تلویزیون مغازه باقی می‌مانند و تصویر سیاه یا قطع نمی‌شود. با اتصال مجدد اینترنت، نرخ‌ها خودکار به‌روزرسانی می‌شوند."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا کنترل و تغییر نرخ‌ها از روی موبایل امکان‌پذیر است؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "بله. شما یک پنل ابری در اختیار دارید که با گوشی هوشمندتان باز می‌شود. در هر لحظه می‌توانید نرخ‌ها را دستی ویرایش کنید، ردیف‌ها را جابه‌جا کنید، حباب یا درصد سود اختصاصی اعمال نمایید و پیام تبریک یا اطلاعیه به زیرنویس تابلو اضافه کنید."
          }
        },
        {
          "@@type": "Question",
          "name": "چگونه می‌توانم این سامانه را در مغازه خودم تست کنم؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "ثبت‌نام در طلالایو کاملاً رایگان است. پس از ثبت‌نام، لینک اختصاصی تابلو در اختیار شما قرار می‌گیرد و به مدت ۱۴ روز بدون نیاز به پرداخت وجه، می‌توانید تمام امکانات سامانه را روی تلویزیون مغازه بررسی فرمایید."
          }
        }
      ]
    }
    </script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-12">

    {{-- مسیر راهنما Breadcrumb --}}
    @include('partials.breadcrumb', [
        'items' => [
            ['title' => 'تابلوی هوشمند طلافروشی', 'url' => route('public.smart-gold-board')],
            ['title' => 'تابلو طلا بدون دستگاه', 'url' => ''],
        ]
    ])

    {{-- سربرگ اصلی صفحه --}}
    <header class="text-center py-6 sm:py-10 space-y-6">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-800 dark:text-amber-300 text-xs font-semibold">
            @include('partials.ui-icon', ['name' => 'bolt', 'class' => 'w-4 h-4 text-amber-600 dark:text-amber-400'])
            <span>فناوری ابری بدون مینی‌کیس، بدون کابل‌کشی و بدون قطعات مستهلک</span>
        </div>
        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-stone-900 dark:text-stone-100 leading-tight">
            تابلو طلا بدون دستگاه؛ اعلام قیمت با تلویزیون
        </h1>
        <p class="text-base sm:text-lg text-stone-600 dark:text-stone-300 max-w-3xl mx-auto leading-relaxed">
            <strong>تابلو طلا بدون دستگاه</strong> روشی نوین و کاملاً ابری برای نمایش زنده و رسمی قیمت طلا و سکه است که بدون نیاز به خرید مینی‌کیس، کامپیوتر یا دانگل اختصاصی، مستقیماً روی تلویزیون معمولی طلافروشی اجرا می‌شود. این راهکار، دردسرهای نگهداری و هزینه‌های تجهیزات را حذف می‌کند.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
            <a href="{{ route('admin.register') }}" class="min-h-11 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm shadow-sm transition-colors inline-flex items-center justify-center">
                شروع تست ۱۴ روزه بدون دستگاه
            </a>
            <a href="{{ route('public.tv-setup-guide') }}" class="min-h-11 px-6 py-3.5 rounded-xl bg-white dark:bg-stone-900 hover:bg-stone-50 dark:hover:bg-stone-850 text-stone-800 dark:text-stone-200 font-bold text-sm border border-stone-300 dark:border-stone-700 transition-colors shadow-sm inline-flex items-center justify-center">
                راهنمای اتصال انواع تلویزیون
            </a>
        </div>
    </header>

    {{-- محتوای اصلی مقاله و راهنما --}}
    <article class="space-y-10 text-stone-700 dark:text-stone-300 leading-loose">

        {{-- بخش ۱: توضیح مفهوم و چرایی حذف دستگاه --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                چرا خرید کیس، مینی‌استوک و قطعات سخت‌افزاری دیگر توجیهی ندارد؟
            </h2>
            <p>
                سال‌ها طلافروشان برای داشتن یک <strong>تابلو آنلاین</strong> مجبور بودند دستگاه‌های سخت‌افزاری گوناگونی را به گالری خود بیاورند؛ از تابلوهای حجیم ال‌ای‌دی و <strong>سون سگمنت</strong> گرفته تا کیس‌های کوچک ویندوزی کارکرده یا کامپیوترهای فن‌دار. هر یک از این تجهیزات با خود کابل‌کشی طولانی برق، کابل HDMI، آداپتورهای حساس به نوسان شبکه و خطر خرابی برد را به همراه داشت.
            </p>
            <p>
                مفهوم <strong>تابلو طلا بدون نصب</strong> و <strong>بدون سخت‌افزار</strong> به این معناست که مغازه‌دار تنها از تلویزیونی که برای دکوراسیون و رفاه مشتریان نصب کرده بهره می‌برد. تمامی پردازش‌ها، محاسبات حباب، دریافت مظنه تهران و تبدیل عیارها در فضای ابری طلالایو انجام می‌گیرد و خروجی با بالاترین کیفیت گرافیکی روی صفحه تلویزیون طلافروشی پخش می‌شود.
            </p>
        </section>

        {{-- بخش ۲: راه‌اندازی سه‌مرحله‌ای --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-6">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                راه‌اندازی ۳ مرحله‌ای تابلوی طلا در کمتر از ۳ دقیقه
            </h2>
            <p class="text-xs sm:text-sm text-stone-500 dark:text-stone-400">
                برای راه‌اندازی نیازی به هیچ تکنسین یا ابزار خاصی ندارید؛ همه‌چیز در سه گام سریع انجام می‌شود:
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 font-bold text-lg flex items-center justify-center mb-4">
                        ۱
                    </div>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 mb-2">ثبت‌نام رایگان در سامانه</h3>
                    <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                        در کمتر از ۱ دقیقه نام گالری و شهر خود را وارد کنید تا لینک اختصاصی تابلوی آنلاین شما بلافاصله ساخته شود.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 font-bold text-lg flex items-center justify-center mb-4">
                        ۲
                    </div>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 mb-2">باز کردن مرورگر تلویزیون</h3>
                    <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                        با کنترل تلویزیون هوشمند مغازه (سامسونگ، ال‌جی یا اندروید) مرورگر پیش‌فرض اینترنت را باز کنید.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 font-bold text-lg flex items-center justify-center mb-4">
                        ۳
                    </div>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 mb-2">ورود آدرس و تمام‌صفحه</h3>
                    <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                        آدرس تابلوی خود را وارد کرده و دکمه تمام‌صفحه را بزنید. نرخ‌های زنده با فونت لوکس روی نمایشگر نقش می‌بندد.
                    </p>
                </div>
            </div>
        </section>

        {{-- بخش ۳: جدول مقایسه سامانه با دستگاه در برابر بدون دستگاه --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                جدول مقایسه: سامانه‌های سخت‌افزاری (با دستگاه) در برابر تابلوی ابری (بدون دستگاه)
            </h2>
            <p class="text-xs sm:text-sm text-stone-500 dark:text-stone-400">
                این جدول بررسی عینی مزیت‌های حذف تجهیزات واسط برای صاحبان گالری‌های طلا و جواهر است:
            </p>

            <div class="overflow-x-auto rounded-2xl border border-stone-200 dark:border-stone-800">
                <table class="w-full text-right text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="border-b border-stone-200 dark:border-stone-800 bg-stone-100 dark:bg-stone-850 text-stone-900 dark:text-stone-100 font-bold">
                            <th class="p-4">معیار مقایسه</th>
                            <th class="p-4 text-stone-600 dark:text-stone-400">سامانه‌های سخت‌افزاری (با دستگاه)</th>
                            <th class="p-4 text-amber-600 dark:text-amber-400">سامانه ابری طلالایو (بدون دستگاه)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 dark:divide-stone-800">
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">هزینه اولیه خرید تجهیزات</td>
                            <td class="p-4 text-red-600 dark:text-red-400">چندین میلیون تومان بابت کیس، دانگل و اکسسوری</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">صفر تومان (کاملاً نرم‌افزاری بر بستر وب)</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">وابستگی سخت‌افزاری و استهلاک</td>
                            <td class="p-4 text-red-600 dark:text-red-400">خرابی فن، هارد، آداپتور، هنگ کردن سیستم‌عامل</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">بدون قطعه مکانیکی و استهلاک؛ پایداری ابری دائم</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">زمان و تخصص لازم برای راه‌اندازی</td>
                            <td class="p-4 text-stone-600 dark:text-stone-400">نیازمند تکنسین، نصب ویندوز، درایور و کابل‌کشی</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">زیر ۳ دقیقه توسط خود صاحب گالری با یک کلیک</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">نحوه به‌روزرسانی نرم‌افزار</td>
                            <td class="p-4 text-red-600 dark:text-red-400">فلش زدن دستی، حضور کارشناس یا آپدیت‌های سنگین</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">به‌روزرسانی خودکار از سرور مرکزی</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">جابه‌جایی و تغییر دکوراسیون مغازه</td>
                            <td class="p-4 text-red-600 dark:text-red-400">باز کردن سیم‌ها، داکت‌کشی دوباره و پیچیدگی جابه‌جایی</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">بدون سیم‌کشی مجدد؛ فقط باز کردن لینک روی هر تلویزیون دیگر</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">مدیریت تابلو از راه دور</td>
                            <td class="p-4 text-stone-600 dark:text-stone-400">محدود به کیبورد یا ریموت داخل مغازه</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">کنترل کامل از خانه یا سفر با گوشی هوشمند</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        {{-- بنر فراخوان میانی --}}
        @include('partials.cta-inline', [
            'title' => 'تابلوی ویترین خود را در ۳ دقیقه روشن کنید',
            'subtitle' => 'همین حالا بدون هیچ هزینه اولیه‌ای، تلویزیون گالری را به پیشرفته‌ترین نرخ‌نامه دیجیتال متصل کنید. ۱۴ روز تست رایگان بدون نیاز به کارت بانکی.',
            'buttonText' => 'شروع رایگان بدون دستگاه',
            'buttonUrl' => route('admin.register'),
            'secondaryText' => 'مشاهده نرخ‌نامه دیجیتال',
            'secondaryUrl' => route('public.digital-rate-board'),
        ])

        {{-- بخش ۴: چه تلویزیونی لازم است؟ --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                چه تلویزیونی برای اجرای تابلوی بدون دستگاه لازم است؟
            </h2>
            <p>
                یکی از بزرگ‌ترین دغدغه‌های طلافروشان هنگام ارتقای تابلوی مغازه این است که آیا تلویزیون موجود در مغازه‌شان پاسخگوی این سیستم خواهد بود یا نیاز به خرید نمایشگرهای گران‌قیمت دارند. پاسخ ساده است: <strong>تقریباً هر تلویزیونی که ورودی تصویر یا وای‌فای داشته باشد!</strong>
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800">
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 mb-2">۱. تلویزیون‌های هوشمند (Smart TV)</h3>
                    <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                        اگر تلویزیون شما از برندهای سامسونگ (سیستم‌عامل تایزن Tizen)، ال‌جی (webOS)، سونی، هایسنس، اسنوا، جی‌پلاس یا دوو است که به وای‌فای وصل می‌شوند، نیازمند هیچ وسیله دیگری نیستید. مرورگر داخلی تلویزیون به‌صورت اختصاصی برای اجرای طلالایو بهینه‌سازی شده است.
                    </p>
                </div>

                <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800">
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 mb-2">۲. تلویزیون‌های معمولی</h3>
                    <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                        اگر تلویزیون شما فاقد مرورگر یا سیستم‌عامل هوشمند است، کافی است یک اندروید باکس اقتصادی را با کابل HDMI به پشت آن وصل کنید تا تلویزیون معمولی شما به یک مانیتور هوشمند تبدیل شود.
                    </p>
                </div>
            </div>

            <div class="mt-4 p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-xs sm:text-sm text-stone-800 dark:text-stone-200 leading-relaxed flex items-center gap-2">
                @include('partials.ui-icon', ['name' => 'book-open', 'class' => 'w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0'])
                <span>
                    <strong>راهنمای کامل نصب:</strong> برای مشاهده آموزش تصویری و گام‌به‌گام اتصال مرورگر انواع تلویزیون‌ها به سامانه، به صفحه <a href="{{ route('public.tv-setup-guide') }}" class="font-bold underline text-amber-600 dark:text-amber-400 hover:text-amber-500">راهنمای راه‌اندازی تلویزیون طلافروشی</a> مراجعه فرمایید.
                </span>
            </div>
        </section>

        {{-- بخش ۵: قطعی اینترنت و امنیت داده --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                اگر اینترنت مغازه یا پاساژ قطع شود چه اتفاقی می‌افتد؟
            </h2>
            <p>
                نوسان اینترنت یکی از چالش‌های روزمره بازارهای سنتی و پاساژهای طلا است. معماری سامانه طلالایو دقیقاً با در نظر گرفتن همین شرایط طراحی شده است:
            </p>
            <ul class="text-xs sm:text-sm space-y-2 text-stone-600 dark:text-stone-400 list-disc list-inside mt-3">
                <li><strong>تصویر هرگز سیاه یا خاموش نمی‌شود:</strong> صفحه تابلو بدون هیچ لرزشی به نمایش خود ادامه می‌دهد.</li>
                <li><strong>آخرین نرخ‌های معتبر پایدار می‌مانند:</strong> ارقام روی صفحه باقی مانده و نرخ‌های ثبت‌شده حفظ می‌شوند.</li>
                <li><strong>نشانگر وضعیت نامحسوس:</strong> یک نشانگر کوچک وضعیت ارتباط را نشان می‌دهد تا فروشنده از اتصال شبکه باخبر باشد.</li>
                <li><strong>اتصال مجدد خودکار:</strong> به محض برقراری اینترنت، بدون نیاز به رفرش یا دخالت دست، آخرین نرخ‌ها همگام‌سازی می‌شوند.</li>
            </ul>
        </section>

        {{-- بخش ۶: پرسش‌های متداول --}}
        <section class="space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                سؤالات متداول طلافروشان
            </h2>

            <div class="space-y-3">
                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۱. منظور از تابلو طلا بدون دستگاه چیست؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        یعنی شما هیچ هزینه جداگانه‌ای بابت خرید کیس، مینی‌کیس، دانگل سخت‌افزاری یا تابلوی سنگین ال‌ای‌دی نمی‌پردازید. با همان تلویزیون و مرورگر اینترنت، تابلوی آنلاین در اختیار شماست.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۲. آیا تلویزیون‌های قدیمی هم پشتیبانی می‌شوند؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        بله. با تهیه یک اندروید باکس اقتصادی و اتصال آن به پورت HDMI تلویزیون، می‌توانید بدون مشکل از تمامی امکانات طلالایو استفاده کنید.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۳. در صورت قطعی اینترنت، نمایشگر چه وضعیتی دارد؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        به لطف کش محلی، تصویر هرگز قطع نمی‌شود و آخرین نرخ‌ها تا زمان برقراری مجدد شبکه روی نمایشگر مغازه پایدار می‌مانند.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۴. آیا می‌توانم نرخ‌ها را با موبایل خودم کنترل کنم؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        بله. پنل مدیریت طلالایو کاملاً واکنش‌گرا است و از هر نقطه‌ای حتی بیرون از مغازه می‌توانید نرخ‌ها، پیام‌ها و فرمول سود را با گوشی خود مدیریت کنید.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۵. شرایط تست رایگان چگونه است؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        ثبت‌نام بدون نیاز به پرداخت و بدون اطلاعات کارت بانکی انجام می‌شود و به مدت ۱۴ روز کامل، تمام امکانات به‌صورت رایگان فعال است.
                    </div>
                </details>
            </div>
        </section>

    </article>

    {{-- بخش مطالب و ابزارهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'مطالب، ابزارها و راهنماهای مرتبط',
        'links' => [
            [
                'title' => 'تابلوی هوشمند طلافروشی',
                'desc' => 'معرفی جامع راهکار ابری تابلوی مغازه و تسخیر بازار سنتی طلافروشی.',
                'url' => route('public.smart-gold-board'),
            ],
            [
                'title' => 'نرخ نامه دیجیتال طلافروشی',
                'desc' => 'بررسی جایگزینی تابلوی سون سگمنت ۷ رقمه با نرخ‌نامه دیجیتال تلویزیونی.',
                'url' => route('public.digital-rate-board'),
            ],
            [
                'title' => 'راهنمای اتصال تلویزیون مغازه',
                'desc' => 'آموزش گام‌به‌گام اتصال و تنظیم مرورگر تلویزیون‌های سامسونگ، ال‌جی و اندروید.',
                'url' => route('public.tv-setup-guide'),
            ],
        ]
    ])

    {{-- فراخوان نهایی انتهای صفحه --}}
    <div class="text-center bg-stone-900 dark:bg-stone-850 p-8 sm:p-12 rounded-3xl border border-stone-800 shadow-sm space-y-6">
        <h2 class="text-2xl sm:text-3xl font-black text-white">
            بدون هزینه سخت‌افزار، تابلوی گالری خود را راه‌اندازی کنید
        </h2>
        <p class="text-stone-300 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
            همین حالا ثبت‌نام کنید، لینک تابلوی مغازه را در تلویزیون باز کنید و از نمای مدرن، فونت‌های خوانا و نرخ لحظه‌ای بهره‌مند شوید.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('admin.register') }}" class="min-h-11 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm transition-colors shadow-sm inline-flex items-center justify-center">
                ساخت تابلوی اختصاصی در ۳ دقیقه
            </a>
            <a href="{{ route('public.pricing') }}" class="min-h-11 px-6 py-3.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-white font-bold text-sm border border-stone-700 transition-colors inline-flex items-center justify-center">
                مشاهده تعرفه و پلن‌ها
            </a>
        </div>
    </div>

</div>
@endsection
