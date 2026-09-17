@extends('layouts.public')

@php
    $seo = config('seo.pages.online-gold-price-board');
@endphp

@section('title', $seo['title'] ?? 'تابلو آنلاین قیمت طلا و مسکوکات — نرخ لحظه‌ای | طلالایو')
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
<div class="min-h-screen bg-slate-900 text-slate-100 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- مسیر راهنما Breadcrumb --}}
        @include('partials.breadcrumb', [
            'items' => [
                ['title' => 'تابلوی هوشمند طلافروشی', 'url' => route('public.smart-gold-board')],
                ['title' => 'تابلو آنلاین قیمت طلا و مسکوکات', 'url' => ''],
            ]
        ])

        {{-- سربرگ اصلی صفحه --}}
        <header class="text-center py-10 sm:py-14">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs sm:text-sm font-bold mb-6">
                <span>⚡</span>
                <span>به‌روزرسانی ثانیه‌ای بدون وقفه و بدون افت فریم</span>
            </div>
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white leading-tight mb-6">
                تابلو آنلاین قیمت طلا و مسکوکات؛ نمایش لحظه‌ای نرخ‌های بازار روی تلویزیون
            </h1>
            <p class="text-base sm:text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">
                <strong>تابلو آنلاین قیمت طلا</strong> سامانه‌ای ابری و هوشمند برای پخش زنده و بدون وقفه نوسانات نرخ طلا، سکه و ارز روی نمایشگرهای مغازه است که سرعت به‌روزرسانی ثانیه‌ای را با بالاترین تنوع ردیف‌های صنفی ترکیب می‌کند. با این ابزار مدرن، ویترین گالری شما به یک مرکز داده معتبر، شفاف و لوکس تبدیل می‌شود.
            </p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('admin.register') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-black text-base shadow-xl shadow-amber-500/25 hover:scale-105 transition-all">
                    شروع تست ۱۴ روزه تابلو آنلاین
                </a>
                <a href="{{ route('public.pricing') }}" class="px-6 py-4 rounded-2xl bg-slate-800 hover:bg-slate-750 text-white font-bold text-base border border-slate-700 transition-colors">
                    مشاهده تعرفه پلن‌ها
                </a>
            </div>
        </header>

        {{-- محتوای اصلی لندینگ --}}
        <article class="prose prose-invert max-w-none space-y-12 text-slate-200 leading-loose">

            {{-- بخش ۱: سرعت به‌روزرسانی و فناوری ابری --}}
            <section class="bg-slate-850 p-6 sm:p-10 rounded-3xl border border-slate-800">
                <h2 class="text-xl sm:text-2xl font-black text-amber-400 mb-6 flex items-center gap-3">
                    <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                    سرعت به‌روزرسانی ثانیه‌ای: پایان تاخیرهای سنتی اعلام قیمت
                </h2>
                <p>
                    در بازارهای پرنوسان طلا، حتی چند دقیقه تاخیر در دریافت مظنه جدید می‌تواند موجب ضرر و زیان در معاملات یا بی‌اعتمادی مشتریان ویترین شود. در تابلوهای فیزیکی قدیمی، طلافروش ناچار بود پس از شنیدن نرخ جدید، ریموت را بردارد و تک‌تک ارقام را به سختی تایپ کند.
                </p>
                <p>
                    یک <strong>تابلو آنلاین طلا و مسکوکات</strong> واقعی، مستقیماً به فیدهای پردازش ابری متصل است. در طلالایو، به محض ثبت نوسان در مظنه بازار تهران، تغییرات در کسری از ثانیه با انیمیشن‌های نرم و جلوه‌های بصری مایع (Liquid Glass) روی صفحه تلویزیون نقش می‌بندد. این یعنی <strong>تابلو قیمت طلا</strong> در مغازه شما همواره با نبض زنده بازار تپش دارد.
                </p>
            </section>

            {{-- بخش ۲: چه نرخ‌هایی قابل نمایش است؟ --}}
            <section class="bg-slate-850 p-6 sm:p-10 rounded-3xl border border-slate-800">
                <h2 class="text-xl sm:text-2xl font-black text-amber-400 mb-6 flex items-center gap-3">
                    <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                    چه نرخ‌هایی در تابلو آنلاین طلالایو قابل نمایش است؟
                </h2>
                <p>
                    تنوع ردیف‌های قابل نمایش در <strong>تابلو لحظه‌ای</strong> طلالایو، پاسخگوی تمام نیازهای بنکداران، کیفی‌ها، ویترین‌داران و صرافان است. شما می‌توانید چینش و فعال بودن هر یک از موارد زیر را تعیین کنید:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    {{-- ستون ۱ --}}
                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 space-y-3">
                        <h3 class="text-base font-bold text-amber-300 flex items-center gap-2">
                            <span>👑</span>
                            <span>شاخص‌های طلا و مظنه</span>
                        </h3>
                        <ul class="text-xs space-y-2 text-slate-300 list-disc list-inside">
                            <li><strong>مظنه تهران (مظنه مثقال):</strong> نرخ پایه یک مثقال طلای ۱۷ عیار (۷۰۵).</li>
                            <li><strong>مظنه بازار و مظنه فردایی:</strong> رصد جهت انتظاری بازار طلا.</li>
                            <li><strong>مظنه جهانی (انس طلا):</strong> نرخ لحظه‌ای اونس بین‌المللی طلا.</li>
                            <li><strong>گرم طلای ۱۸ عیار (۷۵۰):</strong> نرخ پایه ویترین‌های زرگری.</li>
                            <li><strong>طلای ۲۴ عیار (۹۹۹):</strong> نرخ طلای خالص شمش.</li>
                        </ul>
                    </div>

                    {{-- ستون ۲ --}}
                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 space-y-3">
                        <h3 class="text-base font-bold text-amber-300 flex items-center gap-2">
                            <span>⚖️</span>
                            <span>نرخ‌های مبادلاتی و آبشده</span>
                        </h3>
                        <ul class="text-xs space-y-2 text-slate-300 list-disc list-inside">
                            <li><strong>تعویض متفرقه ۱۸:</strong> نرخ تبدیل طلای مستعمل مشتری به طلای نو.</li>
                            <li><strong>خرید متفرقه ۱۸:</strong> قیمت خرید قطعی طلای دست دوم.</li>
                            <li><strong>طلای آبشده نقدی:</strong> نرخ روز شمش‌های کارگاهی با شماره انگ.</li>
                            <li><strong>عیارهای متداول:</strong> عیارهای ۷۰۵، ۷۴۰ و ۷۵۰ با فرمول رسمی.</li>
                            <li><strong>نرخ مرجع اتحادیه:</strong> قیمت مصوب اتحادیه طلا و جواهر.</li>
                        </ul>
                    </div>

                    {{-- ستون ۳ --}}
                    <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 space-y-3">
                        <h3 class="text-base font-bold text-amber-300 flex items-center gap-2">
                            <span>🪙</span>
                            <span>مسکوکات، شمش و نقره</span>
                        </h3>
                        <ul class="text-xs space-y-2 text-slate-300 list-disc list-inside">
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
            <section class="bg-slate-850 p-6 sm:p-10 rounded-3xl border border-slate-800">
                <h2 class="text-xl sm:text-2xl font-black text-amber-400 mb-6 flex items-center gap-3">
                    <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                    مقایسه تابلو آنلاین طلالایو با سایر راهکارهای بازار
                </h2>
                <p>
                    طلافروشان هنگام انتخاب سامانه اعلام نرخ گزینه‌های متعددی پیش روی خود می‌بینند؛ از دستگاه‌های سخت‌افزاری تا ابزارهای رایگان وب. برای راهنمایی دقیق‌تر شما، سه گزارش تحلیلی مجزا آماده کرده‌ایم:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <a href="{{ route('public.compare.tabangohar') }}" class="group block p-5 rounded-2xl bg-slate-800/90 border border-slate-700/80 hover:border-amber-500 transition-all">
                        <div class="text-amber-400 font-black text-sm mb-2 group-hover:translate-x-1 transition-transform">
                            ← تابان گوهر یا طلالایو؟
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            مقایسه خرید دستگاه‌های سخت‌افزاری اسمارت و مینی اسمارت در برابر سامانه ابری بدون کیس طلالایو.
                        </p>
                    </a>

                    <a href="{{ route('public.compare.tgju-tv') }}" class="group block p-5 rounded-2xl bg-slate-800/90 border border-slate-700/80 hover:border-amber-500 transition-all">
                        <div class="text-amber-400 font-black text-sm mb-2 group-hover:translate-x-1 transition-transform">
                            ← تابلو هوشمند TGJU یا طلالایو؟
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            بررسی تفاوت‌های تابلوی رایگان و عمومی شبکه اطلاع‌رسانی طلا با سامانه تخصصی و زرگری طلالایو.
                        </p>
                    </a>

                    <a href="{{ route('public.compare.tablotala') }}" class="group block p-5 rounded-2xl bg-slate-800/90 border border-slate-700/80 hover:border-amber-500 transition-all">
                        <div class="text-amber-400 font-black text-sm mb-2 group-hover:translate-x-1 transition-transform">
                            ← اپ تابلو طلا یا طلالایو؟
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            مقایسه فایل‌های دانلودی و نصبی اندروید (APK) با اجرای سریع و پایدار تحت وب بر روی انواع تلویزیون‌ها.
                        </p>
                    </a>
                </div>
            </section>

            {{-- بخش ۴: سوالات متداول --}}
            <section class="bg-slate-850 p-6 sm:p-10 rounded-3xl border border-slate-800">
                <h2 class="text-xl sm:text-2xl font-black text-amber-400 mb-6 flex items-center gap-3">
                    <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                    سؤالات متداول درباره تابلو آنلاین قیمت طلا
                </h2>

                <div class="space-y-6">
                    <div class="p-5 rounded-2xl bg-slate-800/60 border border-slate-700/60">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-2">
                            ۱. سرعت به‌روزرسانی تابلو آنلاین چقدر است؟
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            ارتباط به‌صورت بلادرنگ (Real-time) برقرار است و نوسانات بازار در کمتر از چند ثانیه بدون لرزش تصویر روی تلویزیون گالری تغییر می‌کند.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-800/60 border border-slate-700/60">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-2">
                            ۲. آیا می‌توان ردیف‌های نمایشی را شخصی‌سازی کرد؟
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            بله. بیش از دوازده شاخص مختلف در دسترس شماست و به راحتی می‌توانید اقلام دلخواه را فعال، جابه‌جا یا پنهان کنید.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-800/60 border border-slate-700/60">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-2">
                            ۳. آیا برای تابلو آنلاین به کیس یا دستگاه واسط نیاز است؟
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            خیر. با مرورگر هر تلویزیون هوشمند یا اتصال یک اندروید باکس اقتصادی، بدون نیاز به کیس کار می‌کند.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-800/60 border border-slate-700/60">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-2">
                            ۴. در صورت قطعی اینترنت چه اتفاقی می‌افتد؟
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            کش آفلاین محلی آخرین نرخ‌های معتبر را روی صفحه حفظ می‌کند تا اتصال اینترنت مجدداً برقرار شود.
                        </p>
                    </div>
                </div>
            </section>

        </article>

        {{-- بخش مطالب مرتبط --}}
        <div class="mt-12">
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
        </div>

        {{-- فراخوان نهایی انتهای صفحه --}}
        <div class="my-16 text-center bg-gradient-to-b from-slate-850 to-slate-900 p-8 sm:p-12 rounded-3xl border border-amber-500/20 shadow-2xl">
            <h2 class="text-2xl sm:text-3xl font-black text-white mb-4">
                ویترین مغازه خود را همین امروز به تابلو آنلاین مجهز کنید
            </h2>
            <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto mb-8 leading-relaxed">
                ۱۴ روز تست کاملاً رایگان بدون نیاز به کارت بانکی. ثبت‌نام کنید و در کمتر از ۳ دقیقه تابلوی زنده خود را روی تلویزیون روشن نمایید.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('admin.register') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-black text-base shadow-xl shadow-amber-500/25 hover:scale-105 transition-all">
                    ساخت تابلوی آنلاین در ۳ دقیقه
                </a>
                <a href="{{ route('public.contact') }}" class="px-6 py-4 rounded-2xl bg-slate-800 hover:bg-slate-750 text-white font-bold text-base border border-slate-700 transition-colors">
                    مشاوره و پشتیبانی
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
