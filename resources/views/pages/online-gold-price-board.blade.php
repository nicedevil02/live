@extends('layouts.public')

@php
    $seo = config('seo.pages.online-gold-price-board');
@endphp

@section('title', $seo['title'] ?? 'تابلو آنلاین قیمت طلا و مسکوکات: نرخ لحظه‌ای | طلالایو')
@section('meta_description', $seo['desc'] ?? 'تابلو آنلاین قیمت طلا و مسکوکات: نمایش لحظه‌ای بیش از ۱۲ نرخ معتبر بازار روی تلویزیون مغازه با اتصال ابری در ۳ دقیقه. تست رایگان ۱۴ روزه را شروع کنید.')
@section('canonical', 'https://talalive.ir/online-gold-price-board')

@section('schema')
    {{-- اسکیمای استاندارد Service بدون ریتینگ --}}
    @include('partials.schema-service', [
        'name' => 'تابلو آنلاین قیمت طلا و مسکوکات طلالایو',
        'serviceType' => 'نمایشگر آنلاین نرخ لحظه‌ای طلا، سکه و ارز روی تلویزیون مغازه',
        'description' => 'سامانه ابری نمایش زنده و ثانیه‌ای بیش از ۱۲ شاخص معتبر نرخ طلا، انواع سکه بانکی و ارز بدون نیاز به سخت‌افزار جانبی.',
        'url' => 'https://talalive.ir/online-gold-price-board',
    ])

    {{-- اسکیمای پرسش و پاسخ متداول FAQPage --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "FAQPage",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "سرعت به‌روزرسانی تابلو آنلاین قیمت طلا چگونه است؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "تابلو آنلاین طلالایو با معماری وب‌سوکت و اتصال ابری آنی کار می‌کند؛ هر نوسان جدید در مظنه تهران، اتحادیه یا بازار جهانی در کمتر از چند ثانیه به‌طور خودکار و بدون نیاز به رفرش صفحه روی تلویزیون اعمال می‌گردد."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا می‌توان تعداد ردیف‌ها و نوع اقلام نمایشی را در تابلو تغییر داد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "بله. شما در پنل کاربری موبایل خود آزادی کامل دارید تا از میان بیش از ۱۵ ردیف تخصصی طلا، سکه، نقره و ارز، اقلام دلخواه را انتخاب نمایید، ترتیب آن‌ها را جابه‌جا کنید یا ردیف‌های غیرمرتبط را مخفی سازید."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا تابلو آنلاین به سخت‌افزار خاصی مثل کیس یا دانگل نیاز دارد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "خیر. تابلو آنلاین طلالایو مستقیماً روی مرورگر پیش‌فرض هر تلویزیون هوشمند یا اندروید باکس معمولی اجرا می‌شود و به هیچ مینی‌کیس، کابل‌کشی یا قطعه اختصاصی نیاز ندارد."
          }
        },
        {
          "@@type": "Question",
          "name": "در صورت قطع شدن اینترنت، نمایش قیمت‌ها چه می‌شود؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "سامانه مجهز به کش هوشمند محلی است؛ به این معنی که تصویر تلویزیون سیاه نمی‌شود و آخرین نرخ‌های معتبر روی نمایشگر باقی می‌مانند و نشانگر اتصال وضعیت شبکه را گزارش می‌دهد."
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
            ['title' => 'تابلو آنلاین قیمت طلا و مسکوکات', 'url' => ''],
        ]
    ])

    {{-- سربرگ اصلی صفحه --}}
    <header class="text-center py-6 sm:py-10 space-y-6">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-800 dark:text-amber-300 text-xs font-semibold">
            @include('partials.ui-icon', ['name' => 'bolt', 'class' => 'w-4 h-4 text-amber-600 dark:text-amber-400'])
            <span>به‌روزرسانی خودکار و لحظه‌ای بدون تاخیر</span>
        </div>
        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-stone-900 dark:text-stone-100 leading-tight">
            تابلو آنلاین قیمت طلا و مسکوکات؛ نمایش نرخ‌های بازار روی تلویزیون
        </h1>
        <p class="text-base sm:text-lg text-stone-600 dark:text-stone-300 max-w-3xl mx-auto leading-relaxed">
            <strong>تابلو آنلاین قیمت طلا</strong> سامانه‌ای ابری برای پخش زنده و بدون وقفه نوسانات نرخ طلا، سکه و ارز روی نمایشگرهای مغازه است که سرعت به‌روزرسانی بالا را با تنوع ردیف‌های صنفی ترکیب می‌کند.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
            <a href="{{ route('admin.register') }}" class="min-h-11 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm shadow-sm transition-colors inline-flex items-center justify-center">
                شروع تست ۱۴ روزه تابلو آنلاین
            </a>
            <a href="{{ route('public.pricing') }}" class="min-h-11 px-6 py-3.5 rounded-xl bg-white dark:bg-stone-900 hover:bg-stone-50 dark:hover:bg-stone-850 text-stone-800 dark:text-stone-200 font-bold text-sm border border-stone-300 dark:border-stone-700 transition-colors shadow-sm inline-flex items-center justify-center">
                مشاهده تعرفه پلن‌ها
            </a>
        </div>
    </header>

    {{-- محتوای اصلی لندینگ --}}
    <article class="space-y-10 text-stone-700 dark:text-stone-300 leading-loose">

        {{-- بخش ۱: سرعت به‌روزرسانی و فناوری ابری --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                سرعت به‌روزرسانی ثانیه‌ای: پایان تاخیرهای سنتی اعلام قیمت
            </h2>
            <p>
                در بازارهای پرنوسان طلا، حتی چند دقیقه تاخیر در دریافت مظنه جدید می‌تواند موجب سردرگمی در معاملات شود. در تابلوهای فیزیکی قدیمی، طلافروش ناچار بود پس از شنیدن نرخ جدید، ریموت را بردارد و تک‌تک ارقام را به سختی تایپ کند.
            </p>
            <p>
                یک <strong>تابلو آنلاین طلا و مسکوکات</strong> مدرن، مستقیماً به فیدهای پردازش ابری متصل است. در طلالایو، به محض ثبت نوسان در مظنه بازار، تغییرات در کسری از ثانیه روی صفحه تلویزیون نقش می‌بندد. این یعنی <strong>تابلو قیمت طلا</strong> در مغازه شما همواره با مظنه زنده بازار همگام است.
            </p>
        </section>

        {{-- بخش ۲: چه نرخ‌هایی قابل نمایش است؟ --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-6">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                چه نرخ‌هایی در تابلو آنلاین طلالایو قابل نمایش است؟
            </h2>
            <p>
                تنوع ردیف‌های قابل نمایش در <strong>تابلو لحظه‌ای</strong> طلالایو، پاسخگوی تمام نیازهای بنکداران، کیفی‌ها، ویترین‌داران و صرافان است. شما می‌توانید چینش و فعال بودن هر یک از موارد زیر را تعیین کنید:
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                {{-- ستون ۱ --}}
                <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'sparkles', 'class' => 'w-5 h-5 text-amber-500'])
                        <span>شاخص‌های طلا و مظنه</span>
                    </h3>
                    <ul class="text-xs space-y-2 text-stone-600 dark:text-stone-400 list-disc list-inside">
                        <li><strong>مظنه تهران (مظنه مثقال):</strong> نرخ پایه یک مثقال طلای ۱۷ عیار (۷۰۵).</li>
                        <li><strong>مظنه بازار و مظنه فردایی:</strong> رصد جهت انتظاری بازار طلا.</li>
                        <li><strong>مظنه جهانی (انس طلا):</strong> نرخ لحظه‌ای اونس بین‌المللی طلا.</li>
                        <li><strong>گرم طلای ۱۸ عیار (۷۵۰):</strong> نرخ پایه ویترین‌های زرگری.</li>
                        <li><strong>طلای ۲۴ عیار (۹۹۹):</strong> نرخ طلای خالص شمش.</li>
                    </ul>
                </div>

                {{-- ستون ۲ --}}
                <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'scale', 'class' => 'w-5 h-5 text-amber-500'])
                        <span>نرخ‌های مبادلاتی و آبشده</span>
                    </h3>
                    <ul class="text-xs space-y-2 text-stone-600 dark:text-stone-400 list-disc list-inside">
                        <li><strong>تعویض متفرقه ۱۸:</strong> نرخ تبدیل طلای مستعمل مشتری به طلای نو.</li>
                        <li><strong>خرید متفرقه ۱۸:</strong> قیمت خرید قطعی طلای دست دوم.</li>
                        <li><strong>طلای آبشده نقدی:</strong> نرخ روز شمش‌های کارگاهی با شماره انگ.</li>
                        <li><strong>عیارهای متداول:</strong> عیارهای ۷۰۵، ۷۴۰ و ۷۵۰ با فرمول رسمی.</li>
                        <li><strong>نرخ مرجع اتحادیه:</strong> قیمت مصوب اتحادیه طلا و جواهر.</li>
                    </ul>
                </div>

                {{-- ستون ۳ --}}
                <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'coins', 'class' => 'w-5 h-5 text-amber-500'])
                        <span>مسکوکات، شمش و نقره</span>
                    </h3>
                    <ul class="text-xs space-y-2 text-stone-600 dark:text-stone-400 list-disc list-inside">
                        <li><strong>سکه امامی و بهار آزادی:</strong> طرح جدید و قدیم با حباب لحظه‌ای.</li>
                        <li><strong>نیم سکه و ربع سکه:</strong> پرمعامله‌ترین قطعات بازار.</li>
                        <li><strong>سکه گرمی و سکه پارسیان:</strong> اوزان خرد و کادویی.</li>
                        <li><strong>گرم نقره ۹۹۹، ۹۹۵ و ۹۲۵:</strong> نقره ساچمه و استرلینگ.</li>
                        <li><strong>شمش طلا و شمش نقره:</strong> اوزان استاندارد سرمایه‌گذاری.</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- بنر فراخوان میانی --}}
        @include('partials.cta-inline', [
            'title' => 'تابلوی آنلاین مغازه خود را در کمتر از ۳ دقیقه روشن کنید',
            'subtitle' => 'تنها با وارد کردن نشانی تابلوی گالری در مرورگر تلویزیون، نرخ‌های زنده را روی صفحه‌ای لوکس و شفاف به مشتریان نمایش دهید.',
            'buttonText' => 'تست رایگان تابلو آنلاین',
            'buttonUrl' => route('admin.register'),
            'secondaryText' => 'راهنمای تلویزیون طلافروشی',
            'secondaryUrl' => route('public.tv-setup-guide'),
        ])

        {{-- بخش ۳: مقایسه با سایر راه‌حل‌های بازار و لینک به صفحات مقایسه --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-6">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                مقایسه تابلو آنلاین طلالایو با سایر راهکارهای بازار
            </h2>
            <p>
                طلافروشان هنگام انتخاب سامانه اعلام نرخ گزینه‌های متعددی پیش روی خود می‌بینند؛ از دستگاه‌های سخت‌افزاری تا ابزارهای رایگان وب. برای راهنمایی دقیق‌تر شما، سه گزارش تحلیلی مجزا آماده کرده‌ایم:
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                <a href="{{ route('public.compare.tabangohar') }}" class="group block p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 hover:border-amber-500/50 transition-colors">
                    <div class="text-amber-600 dark:text-amber-400 font-bold text-sm mb-2 inline-flex items-center gap-1.5">
                        <span>تابان گوهر یا طلالایو؟</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </div>
                    <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                        مقایسه خرید دستگاه‌های سخت‌افزاری اسمارت و مینی اسمارت در برابر سامانه ابری بدون کیس طلالایو.
                    </p>
                </a>

                <a href="{{ route('public.compare.tgju-tv') }}" class="group block p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 hover:border-amber-500/50 transition-colors">
                    <div class="text-amber-600 dark:text-amber-400 font-bold text-sm mb-2 inline-flex items-center gap-1.5">
                        <span>تابلو هوشمند TGJU یا طلالایو؟</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </div>
                    <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                        بررسی تفاوت‌های تابلوی رایگان و عمومی شبکه اطلاع‌رسانی طلا با سامانه تخصصی و زرگری طلالایو.
                    </p>
                </a>

                <a href="{{ route('public.compare.tablotala') }}" class="group block p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 hover:border-amber-500/50 transition-colors">
                    <div class="text-amber-600 dark:text-amber-400 font-bold text-sm mb-2 inline-flex items-center gap-1.5">
                        <span>اپ تابلو طلا یا طلالایو؟</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </div>
                    <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                        مقایسه فایل‌های دانلودی و نصبی اندروید با اجرای سریع و پایدار تحت وب بر روی انواع تلویزیون‌ها.
                    </p>
                </a>
            </div>
        </section>

        {{-- بخش ۴: سوالات متداول --}}
        <section class="space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                سؤالات متداول درباره تابلو آنلاین قیمت طلا
            </h2>

            <div class="space-y-3">
                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۱. سرعت به‌روزرسانی تابلو آنلاین چقدر است؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        ارتباط به‌صورت لحظه‌ای برقرار است و نوسانات بازار در کمتر از چند ثانیه بدون لرزش تصویر روی تلویزیون گالری تغییر می‌کند.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۲. آیا می‌توان ردیف‌های نمایشی را شخصی‌سازی کرد؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        بله. بیش از دوازده شاخص مختلف در دسترس شماست و به راحتی می‌توانید اقلام دلخواه را فعال، جابه‌جا یا پنهان کنید.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۳. آیا برای تابلو آنلاین به کیس یا دستگاه واسط نیاز است؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        خیر. با مرورگر هر تلویزیون هوشمند یا اتصال یک اندروید باکس اقتصادی، بدون نیاز به کیس کار می‌کند.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۴. در صورت قطعی اینترنت چه اتفاقی می‌افتد؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        کش آفلاین محلی آخرین نرخ‌های معتبر را روی صفحه حفظ می‌کند تا اتصال اینترنت مجدداً برقرار شود.
                    </div>
                </details>
            </div>
        </section>

    </article>

    {{-- بخش مطالب مرتبط --}}
    @include('partials.related-links', [
        'title' => 'مطالب و راهنماهای مرتبط با تابلوی طلا',
        'links' => [
            [
                'title' => 'تابلوی هوشمند طلافروشی',
                'desc' => 'آشنایی جامع با فناوری ابری تابلوی مغازه و مزایای اقتصادی آن.',
                'url' => route('public.smart-gold-board'),
            ],
            [
                'title' => 'نرخ نامه دیجیتال طلافروشی',
                'desc' => 'بررسی جایگزینی تابلوی ۷ رقمه سنتی با نمایشگر تلویزیونی.',
                'url' => route('public.digital-rate-board'),
            ],
            [
                'title' => 'تعرفه‌های اشتراک سالیانه',
                'desc' => 'مشاهده قیمت‌های شفاف و امکانات هر یک از پلن‌های کاربری طلالایو.',
                'url' => route('public.pricing'),
            ],
        ]
    ])

    {{-- فراخوان نهایی انتهای صفحه --}}
    <div class="text-center bg-stone-900 dark:bg-stone-850 p-8 sm:p-12 rounded-3xl border border-stone-800 shadow-sm space-y-6">
        <h2 class="text-2xl sm:text-3xl font-black text-white">
            ویترین مغازه خود را همین امروز به تابلو آنلاین مجهز کنید
        </h2>
        <p class="text-stone-300 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
            ۱۴ روز تست کاملاً رایگان بدون نیاز به کارت بانکی. ثبت‌نام کنید و در کمتر از ۳ دقیقه تابلوی زنده خود را روی تلویزیون روشن نمایید.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('admin.register') }}" class="min-h-11 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm transition-colors shadow-sm inline-flex items-center justify-center">
                ساخت تابلوی آنلاین در ۳ دقیقه
            </a>
            <a href="{{ route('public.contact') }}" class="min-h-11 px-6 py-3.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-white font-bold text-sm border border-stone-700 transition-colors inline-flex items-center justify-center">
                مشاوره و پشتیبانی
            </a>
        </div>
    </div>

</div>
@endsection
