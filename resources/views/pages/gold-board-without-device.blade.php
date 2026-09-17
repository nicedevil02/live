@extends('layouts.public')

@php
    $seo = config('seo.pages.gold-board-without-device');
@endphp

@section('title', $seo['title'] ?? 'تابلو طلا بدون دستگاه — فقط تلویزیون و اینترنت | طلالایو')
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
<div class="min-h-screen bg-slate-900 text-slate-100 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- مسیر راهنما Breadcrumb --}}
        @include('partials.breadcrumb', [
            'items' => [
                ['title' => 'تابلوی هوشمند طلافروشی', 'url' => route('public.smart-gold-board')],
                ['title' => 'تابلو طلا بدون دستگاه', 'url' => ''],
            ]
        ])

        {{-- سربرگ اصلی صفحه --}}
        <header class="text-center py-10 sm:py-14">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs sm:text-sm font-bold mb-6">
                <span>🚀</span>
                <span>فناوری ابری بدون مینی‌کیس، بدون کابل‌کشی و بدون قطعات مستهلک</span>
            </div>
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white leading-tight mb-6">
                تابلو طلا بدون دستگاه؛ راه‌اندازی تابلوی اعلام قیمت فقط با تلویزیون
            </h1>
            <p class="text-base sm:text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">
                <strong>تابلو طلا بدون دستگاه</strong> روشی نوین و کاملاً ابری برای نمایش زنده و رسمی قیمت طلا و سکه است که بدون نیاز به خرید مینی‌کیس، کامپیوتر یا دانگل اختصاصی، مستقیماً روی تلویزیون معمولی طلافروشی اجرا می‌شود. این راهکار، دردسرهای نگهداری و هزینه‌های گزاف تجهیزات را حذف کرده و ویترین مغازه شما را به مدرن‌ترین شکل ممکن مجهز می‌سازد.
            </p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('admin.register') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-black text-base shadow-xl shadow-amber-500/25 hover:scale-105 transition-all">
                    شروع تست ۱۴ روزه بدون دستگاه
                </a>
                <a href="{{ route('public.tv-setup-guide') }}" class="px-6 py-4 rounded-2xl bg-slate-800 hover:bg-slate-750 text-white font-bold text-base border border-slate-700 transition-colors">
                    راهنمای اتصال انواع تلویزیون
                </a>
            </div>
        </header>

        {{-- محتوای اصلی مقاله و راهنما --}}
        <article class="prose prose-invert max-w-none space-y-12 text-slate-200 leading-loose">

            {{-- بخش ۱: توضیح مفهوم و چرایی حذف دستگاه --}}
            <section class="bg-slate-850 p-6 sm:p-10 rounded-3xl border border-slate-800">
                <h2 class="text-xl sm:text-2xl font-black text-amber-400 mb-6 flex items-center gap-3">
                    <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                    چرا خرید کیس، مینی‌استوک و قطعات سخت‌افزاری دیگر توجیهی ندارد؟
                </h2>
                <p>
                    سال‌ها طلافروشان برای داشتن یک <strong>تابلو آنلاین</strong> مجبور بودند دستگاه‌های سخت‌افزاری گوناگونی را به گالری خود بیاورند؛ از تابلوهای حجیم ال‌ای‌دی و <strong>سون سگمنت</strong> گرفته تا کیس‌های کوچک ویندوزی استوک موسوم به <strong>مینی اسمارت</strong> یا کامپیوترهای فن‌دار. هر یک از این تجهیزات با خود کابل‌کشی طولانی برق، کابل HDMI، آداپتورهای حساس به نوسان شبکه و خطر خرابی برد در تابستان‌ها را به همراه داشت.
                </p>
                <p>
                    مفهوم <strong>تابلو طلا بدون نصب</strong> و <strong>بدون سخت‌افزار</strong> به این معناست که مغازه‌دار تنها از تلویزیونی که برای زیبایی دکوراسیون و رفاه مشتریان نصب کرده بهره می‌برد. تمامی پردازش‌ها، محاسبات حباب، دریافت مظنه تهران و تبدیل عیارها در فضای ابری طلالایو انجام می‌گیرد و خروجی با بالاترین کیفیت گرافیکی روی صفحه تلویزیون طلافروشی پخش می‌شود. بدین ترتیب عبارت <strong>بدون کیس</strong> دیگر یک رویا نیست، بلکه استاندارد مدرن صنف طلا در سال ۱۴۰۵ است.
                </p>
            </section>

            {{-- بخش ۲: راه‌اندازی سه‌مرحله‌ای --}}
            <section class="bg-slate-850 p-6 sm:p-10 rounded-3xl border border-slate-800">
                <h2 class="text-xl sm:text-2xl font-black text-amber-400 mb-6 flex items-center gap-3">
                    <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                    راه‌اندازی ۳ مرحله‌ای تابلوی طلا در کمتر از ۳ دقیقه
                </h2>
                <p class="text-sm text-slate-400 mb-8">
                    برای راه‌اندازی نیازی به هیچ تکنسین یا ابزار خاصی ندارید؛ همه‌چیز در سه گام فوق‌العاده سریع و آسان انجام می‌شود:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700/80 relative">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/40 text-amber-400 font-black text-lg flex items-center justify-center mb-4">
                            ۱
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">ثبت‌نام رایگان در سامانه</h3>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            در کمتر از ۱ دقیقه نام گالری و شهر خود را وارد کنید تا لینک اختصاصی تابلوی آنلاین شما بلافاصله ساخته شود.
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700/80 relative">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/40 text-amber-400 font-black text-lg flex items-center justify-center mb-4">
                            ۲
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">باز کردن مرورگر تلویزیون</h3>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            با کنترل تلویزیون هوشمند مغازه (سامسونگ، ال‌جی یا اندروید) مرورگر پیش‌فرض اینترنت را باز کنید.
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700/80 relative">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/40 text-amber-400 font-black text-lg flex items-center justify-center mb-4">
                            ۳
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">ورود آدرس و تمام‌صفحه</h3>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            آدرس تابلوی خود را وارد کرده و دکمه تمام‌صفحه را بزنید. نرخ‌های زنده با فونت لوکس روی نمایشگر نقش می‌بندد.
                        </p>
                    </div>
                </div>
            </section>

            {{-- بخش ۳: جدول مقایسه سامانه با دستگاه در برابر بدون دستگاه --}}
            <section class="bg-slate-850 p-6 sm:p-10 rounded-3xl border border-slate-800">
                <h2 class="text-xl sm:text-2xl font-black text-amber-400 mb-4 flex items-center gap-3">
                    <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                    جدول مقایسه: سامانه‌های سخت‌افزاری (با دستگاه) در برابر تابلوی ابری (بدون دستگاه)
                </h2>
                <p class="text-sm text-slate-400 mb-6">
                    این جدول بررسی عینی مزیت‌های حذف تجهیزات واسط برای صاحبان گالری‌های طلا و جواهر است:
                </p>

                <div class="overflow-x-auto">
                    <table class="w-full text-right text-sm border-collapse">
                        <thead>
                            <tr class="border-b border-slate-700 bg-slate-800/80 text-white font-bold">
                                <th class="p-4 rounded-tr-xl">معیار مقایسه</th>
                                <th class="p-4">سامانه‌های سخت‌افزاری (با دستگاه)</th>
                                <th class="p-4 rounded-tl-xl text-amber-400">سامانه ابری طلالایو (بدون دستگاه)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            <tr class="hover:bg-slate-800/40 transition-colors">
                                <td class="p-4 font-semibold text-slate-300">هزینه اولیه خرید تجهیزات</td>
                                <td class="p-4 text-rose-300">چندین میلیون تومان بابت کیس، دانگل و اکسسوری</td>
                                <td class="p-4 text-emerald-400 font-bold">صفر تومان (کاملاً نرم‌افزاری بر بستر وب)</td>
                            </tr>
                            <tr class="hover:bg-slate-800/40 transition-colors">
                                <td class="p-4 font-semibold text-slate-300">وابستگی سخت‌افزاری و استهلاک</td>
                                <td class="p-4 text-rose-300">خرابی فن، هارد، آداپتور، هنگ کردن سیستم‌عامل</td>
                                <td class="p-4 text-emerald-400 font-bold">بدون قطعه مکانیکی و استهلاک؛ پایداری ابری دائم</td>
                            </tr>
                            <tr class="hover:bg-slate-800/40 transition-colors">
                                <td class="p-4 font-semibold text-slate-300">زمان و تخصص لازم برای راه‌اندازی</td>
                                <td class="p-4 text-slate-300">نیازمند تکنسین، نصب ویندوز، درایور و کابل‌کشی</td>
                                <td class="p-4 text-emerald-400 font-bold">زیر ۳ دقیقه توسط خود صاحب گالری با یک کلیک</td>
                            </tr>
                            <tr class="hover:bg-slate-800/40 transition-colors">
                                <td class="p-4 font-semibold text-slate-300">نحوه به‌روزرسانی نرم‌افزار</td>
                                <td class="p-4 text-rose-300">فلش زدن دستی، حضور کارشناس یا آپدیت‌های سنگین</td>
                                <td class="p-4 text-emerald-400 font-bold">به‌روزرسانی نامحسوس و خودکار از سرور مرکزی</td>
                            </tr>
                            <tr class="hover:bg-slate-800/40 transition-colors">
                                <td class="p-4 font-semibold text-slate-300">جابه‌جایی و تغییر دکوراسیون مغازه</td>
                                <td class="p-4 text-rose-300">باز کردن سیم‌ها، داکت‌کشی دوباره و پیچیدگی جابه‌جایی</td>
                                <td class="p-4 text-emerald-400 font-bold">بدون سیم‌کشی مجدد؛ فقط باز کردن لینک روی هر تلویزیون دیگر</td>
                            </tr>
                            <tr class="hover:bg-slate-800/40 transition-colors">
                                <td class="p-4 font-semibold text-slate-300">مدیریت تابلو از راه دور</td>
                                <td class="p-4 text-slate-300">محدود به کیبورد یا ریموت داخل مغازه</td>
                                <td class="p-4 text-emerald-400 font-bold">کنترل کامل از خانه یا سفر با گوشی هوشمند</td>
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
            <section class="bg-slate-850 p-6 sm:p-10 rounded-3xl border border-slate-800">
                <h2 class="text-xl sm:text-2xl font-black text-amber-400 mb-6 flex items-center gap-3">
                    <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                    چه تلویزیونی برای اجرای تابلوی بدون دستگاه لازم است؟
                </h2>
                <p>
                    یکی از بزرگ‌ترین دغدغه‌های طلافروشان هنگام ارتقای تابلوی مغازه این است که آیا تلویزیون موجود در مغازه‌شان پاسخگوی این سیستم خواهد بود یا نیاز به خرید نمایشگرهای گران‌قیمت دارند. پاسخ خوشبختانه بسیار ساده است: <strong>تقریباً هر تلویزیونی که قابلیت پخش تصویر داشته باشد!</strong>
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                        <h3 class="text-base font-bold text-amber-300 mb-2">۱. تلویزیون‌های هوشمند (Smart TV)</h3>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            اگر تلویزیون شما از برندهای سامسونگ (با سیستم‌عامل تایزن Tizen)، ال‌جی (webOS)، سونی، هایسنس، اسنوا، جی‌پلاس یا تی‌سی‌ال است که قابلیت اتصال به وای‌فای دارند، نیازمند هیچ وسیله دیگری نیستید. مرورگر داخلی تلویزیون به‌صورت اختصاصی برای اجرای طلالایو بهینه‌سازی شده است.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80">
                        <h3 class="text-base font-bold text-amber-300 mb-2">۲. تلویزیون‌های معمولی و قدیمی</h3>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            اگر تلویزیون شما فاقد مرورگر یا سیستم‌عامل هوشمند است، کافی است یک اندروید باکس کوچک و اقتصادی را با کابل کوتاه HDMI به پشت آن وصل کنید. این دستگاه کوچک تلویزیون معمولی شما را به یک مانیتور فوق‌هوشمند تبدیل می‌کند.
                        </p>
                    </div>
                </div>

                <div class="mt-6 p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-xs sm:text-sm text-amber-200 leading-relaxed">
                    💡 <strong>راهنمای کامل نصب:</strong> برای مشاهده آموزش تصویری و گام‌به‌گام اتصال مرورگر انواع تلویزیون‌ها به سامانه، می‌توانید به صفحه <a href="{{ route('public.tv-setup-guide') }}" class="font-bold underline hover:text-white transition-colors">راهنمای راه‌اندازی تلویزیون طلافروشی</a> مراجعه فرمایید.
                </div>
            </section>

            {{-- بخش ۵: قطعی اینترنت و امنیت داده --}}
            <section class="bg-slate-850 p-6 sm:p-10 rounded-3xl border border-slate-800">
                <h2 class="text-xl sm:text-2xl font-black text-amber-400 mb-6 flex items-center gap-3">
                    <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                    اگر اینترنت مغازه یا پاساژ قطع شود چه اتفاقی می‌افتد؟
                </h2>
                <p>
                    نوسان و قطعی اینترنت یکی از واقعیت‌های روزمره بازارهای سنتی و پاساژهای طلا در ایران است. معماری سامانه طلالایو دقیقاً با در نظر گرفتن همین شرایط بحرانی طراحی شده است. زمانی که شما یک بار صفحه اختصاصی تابلوی خود را روی مرورگر تلویزیون باز می‌کنید، هسته سبک سامانه از طریق فناوری Service Worker در حافظه محلی دستگاه ذخیره می‌شود.
                </p>
                <p>
                    در صورت قطعی ارتباط با شبکه:
                </p>
                <ul class="text-sm space-y-2 text-slate-300 list-disc list-inside mt-3">
                    <li><strong>تصویر هرگز سیاه یا خاموش نمی‌شود:</strong> صفحه تابلو بدون هیچ لرزشی به نمایش خود ادامه می‌دهد.</li>
                    <li><strong>آخرین نرخ‌های معتبر پایدار می‌مانند:</strong> ارقام روی صفحه باقی مانده و نرخ‌های ثبت‌شده توسط اتحادیه و مظنه معتبر حفظ می‌شوند.</li>
                    <li><strong>نمایشگر وضعیت نامحسوس:</strong> یک نشانگر کوچک و محرمانه وضعیت ارتباط را نشان می‌دهد تا فروشنده از اتصال شبکه باخبر باشد.</li>
                    <li><strong>اتصال مجدد خودکار:</strong> به محض برقراری اینترنت، بدون نیاز به رفرش یا دخالت دست، آخرین نرخ‌ها بلافاصله همگام‌سازی می‌شوند.</li>
                </ul>
            </section>

            {{-- بخش ۶: پرسش‌های متداول --}}
            <section class="bg-slate-850 p-6 sm:p-10 rounded-3xl border border-slate-800">
                <h2 class="text-xl sm:text-2xl font-black text-amber-400 mb-6 flex items-center gap-3">
                    <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                    سؤالات متداول طلافروشان
                </h2>

                <div class="space-y-6">
                    <div class="p-5 rounded-2xl bg-slate-800/60 border border-slate-700/60">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-2">
                            ۱. منظور از تابلو طلا بدون دستگاه چیست؟
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            یعنی شما هیچ هزینه جداگانه‌ای بابت خرید کیس، مینی‌کیس، دانگل سخت‌افزاری یا تابلوی سنگین ال‌ای‌دی نمی‌پردازید. با همان تلویزیون و مرورگر اینترنت، تابلوی آنلاین در اختیار شماست.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-800/60 border border-slate-700/60">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-2">
                            ۲. آیا تلویزیون‌های قدیمی هم پشتیبانی می‌شوند؟
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            بله. با تهیه یک اندروید باکس ارزان‌قیمت و اتصال آن به پورت HDMI تلویزیون، می‌توانید بدون هیچ مشکلی از تمامی امکانات طلالایو استفاده کنید.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-800/60 border border-slate-700/60">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-2">
                            ۳. در صورت قطعی اینترنت، نمایشگر چه وضعیتی دارد؟
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            به لطف کش محلی، تصویر هرگز قطع نمی‌شود و آخرین نرخ‌ها تا زمان برقراری مجدد شبکه روی نمایشگر مغازه پایدار می‌مانند.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-800/60 border border-slate-700/60">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-2">
                            ۴. آیا می‌توانم نرخ‌ها را با موبایل خودم کنترل کنم؟
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            بله. پنل مدیریت طلالایو کاملاً ریسپانسیو است و از هر نقطه‌ای حتی بیرون از مغازه می‌توانید نرخ‌ها، پیام‌ها و فرمول سود را با گوشی خود مدیریت کنید.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-800/60 border border-slate-700/60">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-2">
                            ۵. شرایط تست رایگان چگونه است؟
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            ثبت‌نام بدون نیاز به پرداخت و بدون اطلاعات کارت بانکی انجام می‌شود و به مدت ۱۴ روز کامل، تمام امکانات به‌صورت رایگان فعال است.
                        </p>
                    </div>
                </div>
            </section>

        </article>

        {{-- بخش مطالب و ابزارهای مرتبط --}}
        <div class="mt-12">
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
        </div>

        {{-- فراخوان نهایی انتهای صفحه --}}
        <div class="my-16 text-center bg-gradient-to-b from-slate-850 to-slate-900 p-8 sm:p-12 rounded-3xl border border-amber-500/20 shadow-2xl">
            <h2 class="text-2xl sm:text-3xl font-black text-white mb-4">
                بدون هزینه سخت‌افزار، تابلوی گالری خود را راه‌اندازی کنید
            </h2>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto mb-8 leading-relaxed">
                همین حالا ثبت‌نام کنید، لینک تابلوی مغازه را در تلویزیون باز کنید و از نمای مدرن، فونت‌های زیبا و نرخ لحظه‌ای لذت ببرید.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('admin.register') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-black text-base shadow-xl shadow-amber-500/25 hover:scale-105 transition-all">
                    ساخت تابلوی اختصاصی در ۳ دقیقه
                </a>
                <a href="{{ route('public.pricing') }}" class="px-6 py-4 rounded-2xl bg-slate-800 hover:bg-slate-750 text-white font-bold text-base border border-slate-700 transition-colors">
                    مشاهده تعرفه و پلن‌ها
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
