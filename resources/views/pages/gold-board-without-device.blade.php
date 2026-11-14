@extends('layouts.public')

@php
    $seo = config('seo.pages.gold-board-without-device');

    $faqs = [
        [
            'q' => 'آیا برای تابلو قیمت طلا حتماً باید دستگاه جداگانه بخرم؟',
            'a' => 'خیر. اگر تلویزیون شما مرورگر یا سیستم‌عامل سازگار با سرویس داشته باشد، ممکن است به دستگاه جداگانه نیاز نداشته باشید. در غیر این صورت، اندروید باکس یا دستگاه اختصاصی از گزینه‌های قابل بررسی است.',
        ],
        [
            'q' => 'آیا تابلو روی همه تلویزیون‌های هوشمند اجرا می‌شود؟',
            'a' => 'نمی‌توان چنین تضمینی داد. سیستم‌عامل، نسخه مرورگر، حافظه و مدل تلویزیون روی سازگاری اثر دارند. قبل از خرید اشتراک، نمونه زنده سرویس را روی دستگاه خودتان بررسی کنید.',
        ],
        [
            'q' => 'هنگام قطع اینترنت چه اتفاقی برای قیمت‌ها می‌افتد؟',
            'a' => 'به ساختار سرویس بستگی دارد. راهکار استاندارد باید آخرین نرخ معتبر را حفظ کند و هم‌زمان قدیمی‌بودن داده و زمان آخرین دریافت را با هشدار واضح نشان دهد تا نرخ ذخیره‌شده با قیمت لحظه‌ای اشتباه گرفته نشود.',
        ],
        [
            'q' => 'آیا نرخ روی تابلو همان مبلغ نهایی خرید طلاست؟',
            'a' => 'نه الزاماً. مبلغ نهایی مصنوعات طلا ممکن است شامل اجرت ساخت، سود قانونی و مالیات مرتبط طبق مقررات جاری باشد. بهتر است عنوان نرخ‌های تابلو و تفاوت آن‌ها با مبلغ فاکتور برای مشتری روشن باشد.',
        ],
        [
            'q' => 'آیا بدون اینترنت می‌توان نرخ لحظه‌ای داشت؟',
            'a' => 'برای دریافت نرخ تازه، یک مسیر ارتباطی فعال لازم است که معمولاً اتصال اینترنت مغازه است. نمایش داده ذخیره‌شده روی صفحه به معنی دریافت قیمت جدید نیست.',
        ],
        [
            'q' => 'برای انتخاب بین اپلیکیشن و مرورگر تلویزیون چه کار کنم؟',
            'a' => 'هر دو روش را در صورت پشتیبانی دستگاه، روی تلویزیون مغازه مقایسه کنید. معیار اصلی انتخاب باید خوانایی متن فارسی، پایداری طولانی‌مدت، کنترل آسان با ریموت و راحتی استفاده روزانه باشد.',
        ],
    ];

    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(static function (array $item): array {
            return [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['a'],
                ],
            ];
        }, $faqs),
    ];

    $criteriaList = [
        [
            'icon' => 'clock',
            'title' => '۱. منبع نرخ و زمان آخرین دریافت',
            'text' => 'بپرسید قیمت‌ها از چه منبعی دریافت می‌شوند و زمان آخرین دریافت موفق کجا نمایش داده می‌شود. تازه‌سازی صفحه به‌تنهایی به معنی دریافت نرخ جدید نیست. همچنین شفاف باشد نرخ نمایش‌داده‌شده، نرخ بازار است یا نرخ تنظیم‌شده فروشگاه؛ نمایش عنوان‌هایی مثل «نرخ رسمی اتحادیه» باید پشتوانه معتبر داشته باشد.',
        ],
        [
            'icon' => 'currency',
            'title' => '۲. نمایش واضح تومان، ریال و عیار',
            'text' => 'قیمت بدون واحد می‌تواند باعث سوءتفاهم شود. واحد پول، عیار طلا و عنوان هر ردیف باید کاملاً روشن باشد. قیمت هر گرم طلای ۱۸ عیار با مظنه مثقال یکی نیست و نباید با یک برچسب مبهم در کنار هم قرار گیرد.',
        ],
        [
            'icon' => 'tv',
            'title' => '۳. خوانایی از فاصله مشتری',
            'text' => 'تابلو را از همان نقطه‌ای ببینید که مشتری مقابل ویترین یا پیشخوان می‌ایستد، نه فقط از فاصله نزدیک. اندازه اعداد، کنتراست، بازتاب نور محیط و تعداد ردیف‌ها را بسنجید؛ برای بیشتر مغازه‌ها چند نرخ کلیدی با فونت درشت کاربردی‌تر از صفحه شلوغ با ده‌ها عدد ریز است.',
        ],
        [
            'icon' => 'wifi-off',
            'title' => '۴. رفتار صادقانه هنگام قطع اینترنت',
            'text' => 'هیچ سرویس آنلاینی نباید هنگام قطعی شبکه، قیمت قدیمی را بدون توضیح به‌عنوان نرخ تازه نمایش دهد. بررسی کنید آیا تابلو زمان آخرین به‌روزرسانی و هشدار قطع ارتباط را نشان می‌دهد و پس از وصل‌شدن اینترنت دوباره خودکار داده می‌گیرد یا نه.',
        ],
        [
            'icon' => 'sliders',
            'title' => '۵. کنترل با ریموت و کارکرد روزانه',
            'text' => 'کارکنان مغازه نباید برای استفاده روزمره مجبور به اتصال ماوس یا انجام تنظیمات پیچیده شوند. بازکردن تابلو، رفتن به حالت تمام‌صفحه یا جابه‌جایی اسلایدر باید با ریموت کنترل تلویزیون یا پنل موبایل عملی باشد.',
        ],
        [
            'icon' => 'bolt',
            'title' => '۶. وضعیت پس از قطع و وصل برق',
            'text' => 'روشن‌شدن تلویزیون، اجرای برنامه و بازشدن تابلوی نرخ سه مرحله جدا هستند. اگر بازگشت خودکار برای مغازه حیاتی است، عملکرد ترکیب مدل تلویزیون و نرم‌افزار را پیش از انتخاب نهایی عملاً آزمایش کنید.',
        ],
    ];

    $setupSteps = [
        [
            'step' => '۱',
            'title' => 'مدل و سیستم‌عامل تلویزیون را مشخص کنید',
            'desc' => 'نام دقیق مدل و سیستم‌عامل (Android TV، Google TV، Tizen یا webOS) را از تنظیمات دستگاه بخوانید؛ عنوان کلی «اسمارت‌تی‌وی» برای انتخاب روش اجرا کافی نیست.',
        ],
        [
            'step' => '۲',
            'title' => 'روش اجرای سازگار را انتخاب کنید',
            'desc' => 'بر اساس توان و سیستم‌عامل تلویزیون، استفاده مستقیم از مرورگر داخلی، نصب اپلیکیشن اندرویدی یا اتصال یک اندروید باکس از طریق ورودی HDMI را انتخاب کنید.',
        ],
        [
            'step' => '۳',
            'title' => 'نمونه تابلو را روی نمایشگر خودتان ببینید',
            'desc' => 'اندازه متن، حاشیه تصویر، درست‌نمایش‌دادن اعداد فارسی و عملکرد دکمه‌های ریموت را از فاصله واقعی ایستادن مشتری روی همان تلویزیون ارزیابی کنید.',
        ],
        [
            'step' => '۴',
            'title' => 'فقط نرخ‌های ضروری را فعال کنید',
            'desc' => 'ردیف‌های پرکاربرد مشتریان مغازه (مثل طلای ۱۸ عیار، سکه امامی و مثقال) را درشت و خوانا نگه دارید و از شلوغ‌کردن غیرضروری صفحه پرهیز کنید.',
        ],
        [
            'step' => '۵',
            'title' => 'شرایط غیرعادی را امتحان کنید',
            'desc' => 'قطع و وصل اینترنت، نمایش هشدار نرخ قدیمی و خاموش و روشن‌کردن تلویزیون را آزمایش کنید تا در شلوغی بازار دچار غافلگیری نشوید.',
        ],
        [
            'step' => '۶',
            'title' => 'پس از اطمینان از سازگاری تصمیم بگیرید',
            'desc' => 'وقتی از خوانایی و پایداری روی تلویزیون مغازه مطمئن شدید، پلن اشتراک متناسب با نیاز واقعی فروشگاه و شرایط پشتیبانی را انتخاب کنید.',
        ],
    ];
@endphp

@section('title', $seo['title'] ?? 'تابلو طلا بدون دستگاه؛ راهنمای اجرا روی تلویزیون | طلالایو')
@section('meta_description', $seo['desc'] ?? 'تابلو قیمت طلا بدون دستگاه روی تلویزیون مغازه: مقایسه مرورگر، اپ و اندروید باکس، هزینه‌های واقعی، رفتار هنگام قطعی اینترنت و شروع تست ۱۴ روزه طلالایو.')
@section('canonical', 'https://talalive.ir/gold-board-without-device')

@section('schema')
    @include('partials.schema-service', [
        'name' => 'تابلو طلا بدون دستگاه طلالایو',
        'serviceType' => 'نرم‌افزار تابلوی قیمت طلا روی تلویزیون بدون نیاز به خرید دستگاه اختصاصی',
        'description' => 'راهکار نمایش آنلاین و شفاف قیمت طلا، سکه و ارز روی تلویزیون مغازه با مرورگر، اپلیکیشن اندروید تی‌وی یا اندروید باکس بدون وابستگی به دستگاه اختصاصی.',
        'url' => 'https://talalive.ir/gold-board-without-device',
    ])

    <script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-10">

    {{-- مسیر راهنما --}}
    @include('partials.breadcrumb', [
        'items' => [
            ['title' => 'تابلوی هوشمند طلافروشی', 'url' => route('public.smart-gold-board')],
            ['title' => 'تابلو طلا بدون دستگاه', 'url' => ''],
        ]
    ])

    {{-- سربرگ اصلی صفحه --}}
    <header class="text-center py-4 sm:py-8 space-y-5">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-800 dark:text-amber-300 text-xs font-semibold">
            @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-4 h-4 text-amber-600 dark:text-amber-400'])
            <span>راهنمای عملی نمایش قیمت طلا روی تلویزیون مغازه بدون دستگاه اختصاصی</span>
        </div>

        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-stone-900 dark:text-stone-100 leading-tight">
            تابلو قیمت طلا روی تلویزیون؛ راهنمای راه‌اندازی بدون دستگاه اختصاصی
        </h1>

        <p class="text-base sm:text-lg text-stone-600 dark:text-stone-300 max-w-3xl mx-auto leading-relaxed">
            قیمت‌ها در بازار طلا ثابت نمی‌مانند؛ مشتری مقابل ویترین باید بتواند نرخ‌های نمایش‌داده‌شده را واضح بخواند و زمان آخرین به‌روزرسانی آن‌ها را بداند. <strong>تابلو قیمت طلا روی تلویزیون</strong> راهی برای نمایش منظم نرخ طلا، سکه و ارز در مغازه است؛ بدون اینکه همیشه لازم باشد یک دستگاه اختصاصی اعلام نرخ بخرید.
        </p>

        <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 max-w-3xl mx-auto leading-relaxed">
            البته «بدون دستگاه» به معنی بی‌نیازی از هر نوع تجهیزات نیست: برای این کار به نمایشگر، اتصال اینترنت و یک مسیر اجرای سازگار (مرورگر تلویزیون، اپلیکیشن اندروید TV یا اندروید باکس) نیاز دارید. در این صفحه روش‌های راه‌اندازی، هزینه‌های واقعی و معیارهای انتخاب یک تابلو آنلاین مطمئن را بررسی می‌کنیم.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
            <a href="{{ route('admin.register') }}" class="min-h-11 px-7 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm shadow-sm transition-colors inline-flex items-center justify-center">
                شروع تست ۱۴ روزه رایگان
            </a>
            <a href="{{ route('public.demo') }}" class="min-h-11 px-6 py-3 rounded-xl bg-white dark:bg-stone-900 hover:bg-stone-50 dark:hover:bg-stone-850 text-stone-800 dark:text-stone-200 font-bold text-sm border border-stone-300 dark:border-stone-700 transition-colors shadow-sm inline-flex items-center justify-center">
                مشاهده نمونه زنده تابلو
            </a>
        </div>
    </header>

    {{-- محتوای اصلی --}}
    <article class="space-y-10 text-stone-700 dark:text-stone-300 leading-loose">

        {{-- بخش ۱: چیستی و موارد قابل نمایش --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-5">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block shrink-0"></span>
                <span>تابلو قیمت طلافروشی چیست و چه اطلاعاتی را باید نمایش دهد؟</span>
            </h2>
            <p class="text-sm sm:text-base">
                تابلو قیمت طلافروشی، نرخ‌های موردنیاز مشتری و فروشنده را در قالبی خوانا نمایش می‌دهد. این تابلو می‌تواند یک نمایشگر <a href="{{ route('public.led-vs-smart-board') }}" class="font-semibold underline text-amber-700 dark:text-amber-400 hover:text-amber-600">LED یا سون‌سگمنت اختصاصی</a> باشد یا نرم‌افزاری تحت وب که روی تلویزیون مغازه اجرا می‌شود.
            </p>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm text-stone-700 dark:text-stone-300">
                <li class="p-3.5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                    <span>قیمت هر گرم طلای ۱۸ عیار (و ردیف‌های خرید یا تعویض متفرقه)</span>
                </li>
                <li class="p-3.5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                    <span>مظنه و مثقال ۱۷ عیار بازار طلا</span>
                </li>
                <li class="p-3.5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                    <span>قیمت سکه امامی، بهار آزادی، نیم‌سکه و ربع‌سکه</span>
                </li>
                <li class="p-3.5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                    <span>قیمت اونس جهانی طلا و نرخ ارزهای منتخب</span>
                </li>
                <li class="p-3.5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 flex items-center gap-2.5 sm:col-span-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                    <span>نام و نشان فروشگاه، بارکد (QR) برای مشاهده قیمت روی گوشی مشتری و پیام‌های اطلاع‌رسانی</span>
                </li>
            </ul>
            <p class="text-sm sm:text-base pt-1">
                نکته مهم، زیادبودن تعداد نرخ‌ها نیست؛ <strong>نمایش اطلاعات درست با واحد مشخص (تومان یا ریال) و زمان به‌روزرسانی قابل مشاهده</strong> اهمیت بیشتری دارد. تابلویی که از فاصله مشتری خوانده نشود یا نرخ قدیمی را بدون هشدار نمایش دهد، حتی با ظاهر زیبا هم انتخاب مناسبی نیست.
            </p>
        </section>

        {{-- بخش ۲: سه مسیر اجرا بدون خرید دستگاه اعلام نرخ --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-6">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block shrink-0"></span>
                <span>آیا می‌توان بدون خرید دستگاه اعلام نرخ، تابلو داشت؟</span>
            </h2>
            <p class="text-sm sm:text-base">
                بله؛ در صورتی که تجهیزات فعلی مغازه امکان اجرای سرویس را داشته باشند. سه مسیر رایج پیش روی شماست که هرکدام شرایط و محدودیت خود را دارند:
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-700 dark:text-amber-400 flex items-center justify-center">
                        @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-5 h-5'])
                    </div>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">۱. نمایش تابلو در مرورگر تلویزیون هوشمند</h3>
                    <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                        نشانی تابلوی آنلاین را در مرورگر تلویزیون باز می‌کنید و بدون خرید تجهیزات اضافه از نمایشگر فعلی استفاده می‌کنید. بااین‌حال همه تلویزیون‌های هوشمند مرورگر یکسانی ندارند؛ پیش از انتخاب سرویس، خوانایی متن فارسی، تمام‌صفحه شدن، تازه‌سازی نرخ‌ها و رفتار صفحه هنگام قطع اینترنت را روی همان مدل بررسی کنید.
                    </p>
                    <div class="pt-1 flex flex-wrap gap-2 text-xs font-semibold">
                        <a href="{{ route('public.tv-setup-guide') }}" class="text-amber-700 dark:text-amber-400 underline">راهنمای اتصال مرورگر</a>
                        <span class="text-stone-400">·</span>
                        <a href="{{ route('public.guides.show', 'samsung-tizen-gold-board') }}" class="text-amber-700 dark:text-amber-400 underline">سامسونگ (Tizen)</a>
                        <span class="text-stone-400">·</span>
                        <a href="{{ route('public.guides.show', 'lg-webos-gold-board') }}" class="text-amber-700 dark:text-amber-400 underline">ال‌جی (webOS)</a>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-700 dark:text-amber-400 flex items-center justify-center">
                        @include('partials.ui-icon', ['name' => 'smartphone', 'class' => 'w-5 h-5'])
                    </div>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">۲. نصب اپلیکیشن روی تلویزیون اندرویدی</h3>
                    <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                        اگر تلویزیون شما Android TV یا Google TV دارد، نصب اپلیکیشن سازگار می‌تواند کنترل با ریموت و ورود مجدد به تابلو را ساده‌تر کند. دقت کنید <strong>هوشمند بودن تلویزیون الزاماً به معنی اندرویدی بودن آن نیست</strong>؛ نصب فایل APK روی سیستم‌عامل‌هایی مانند Tizen یا webOS روش قابل اتکایی نیست.
                    </p>
                    <div class="pt-1 flex flex-wrap gap-2 text-xs font-semibold">
                        <a href="{{ route('public.android-tv-gold-board') }}" class="text-amber-700 dark:text-amber-400 underline">راه‌اندازی اندروید تی‌وی</a>
                        <span class="text-stone-400">·</span>
                        <a href="{{ route('public.app') }}" class="text-amber-700 dark:text-amber-400 underline">صفحه اپلیکیشن طلالایو</a>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-700 dark:text-amber-400 flex items-center justify-center">
                        @include('partials.ui-icon', ['name' => 'cpu', 'class' => 'w-5 h-5'])
                    </div>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">۳. اتصال اندروید باکس به تلویزیون</h3>
                    <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                        اگر تلویزیون ورودی HDMI دارد اما مرورگر یا سیستم‌عامل مناسبی ندارد، یک اندروید باکس امکان اجرای نرم‌افزار تابلو را می‌دهد. هرچند در این حالت سخت‌افزار اضافه می‌خرید، اما به دستگاه اختصاصی اعلام نرخ وابسته نیستید. پیش از خرید باکس، سازگاری با اپ و وضعیت روشن‌شدن پس از قطع برق را بسنجید.
                    </p>
                </div>
            </div>
        </section>

        {{-- بخش ۳: جدول مقایسه نرم‌افزار تابلو طلا در برابر دستگاه اختصاصی --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block shrink-0"></span>
                <span>نرم‌افزار تابلو طلا بهتر است یا دستگاه اختصاصی؟</span>
            </h2>
            <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400">
                پاسخ به تجهیزات موجود، شرایط اینترنت و سطح پشتیبانی موردنیاز مغازه بستگی دارد. مقایسه واقع‌بینانه این دو رویکرد:
            </p>

            <div class="overflow-x-auto rounded-2xl border border-stone-200 dark:border-stone-800">
                <table class="w-full text-right text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="border-b border-stone-200 dark:border-stone-800 bg-stone-100 dark:bg-stone-850 text-stone-900 dark:text-stone-100 font-bold">
                            <th class="p-4">معیار مقایسه</th>
                            <th class="p-4 text-amber-800 dark:text-amber-300">راهکار نرم‌افزاری روی تلویزیون</th>
                            <th class="p-4 text-stone-700 dark:text-stone-300">دستگاه اختصاصی اعلام نرخ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 dark:divide-stone-800">
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">تجهیزات اولیه</td>
                            <td class="p-4 text-stone-700 dark:text-stone-300">ممکن است از تلویزیون فعلی استفاده کند</td>
                            <td class="p-4 text-stone-600 dark:text-stone-400">معمولاً نیازمند خرید دستگاه یا کیس جداگانه است</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">سازگاری و انعطاف</td>
                            <td class="p-4 text-stone-700 dark:text-stone-300">به سیستم‌عامل، نسخه مرورگر و توان سخت‌افزاری تلویزیون بستگی دارد</td>
                            <td class="p-4 text-stone-600 dark:text-stone-400">به مدل، پورت خروجی و محدودیت‌های سخت‌افزار بستگی دارد</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">هزینه ادامه استفاده</td>
                            <td class="p-4 text-stone-700 dark:text-stone-300">تابع تعرفه اشتراک و خدمات پشتیبانی سرویس است</td>
                            <td class="p-4 text-stone-600 dark:text-stone-400">ممکن است شارژ سالانه خدمات، پشتیبانی یا تعمیر قطعه داشته باشد</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">نصب و نگهداری</td>
                            <td class="p-4 text-stone-700 dark:text-stone-300">توسط خود کاربر یا با راهنمایی از راه دور پشتیبانی انجام می‌شود</td>
                            <td class="p-4 text-stone-600 dark:text-stone-400">به خدمات نصب و تعمیرات تأمین‌کننده وابسته است</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">کارکرد هنگام قطعی اینترنت</td>
                            <td class="p-4 text-stone-700 dark:text-stone-300">باید برای هر سرویس بررسی شود؛ نیازمند کش محلی و هشدار نرخ قدیمی است</td>
                            <td class="p-4 text-stone-600 dark:text-stone-400">به روش دریافت داده (اینترنت، سیم‌کارت یا آفلاین) و مدل دستگاه بستگی دارد</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 pt-1">
                بهترین انتخاب، محصولی نیست که صرفاً «نرم‌افزاری» یا «سخت‌افزاری» باشد؛ محصولی است که در شرایط واقعی مغازه شما قابل استفاده و قابل پشتیبانی باشد. اگر میان نمایشگر LED و تلویزیون مردد هستید، صفحه <a href="{{ route('public.led-vs-smart-board') }}" class="font-semibold underline text-amber-700 dark:text-amber-400">مقایسه تابلو LED و تلویزیون هوشمند</a> و <a href="{{ route('public.digital-rate-board') }}" class="font-semibold underline text-amber-700 dark:text-amber-400">نرخ‌نامه دیجیتال طلافروشی</a> را هم ببینید.
            </p>
        </section>

        {{-- بنر فراخوان میانی --}}
        @include('partials.cta-inline', [
            'title' => 'اول نمونه زنده را روی تلویزیون مغازه تست کنید',
            'subtitle' => 'می‌توانید همین حالا پیش‌نمایش تابلوی طلالایو را ببینید یا با ۱۴ روز تست رایگان بدون ثبت کارت بانکی، خوانایی و سازگاری آن را روی نمایشگر واقعی فروشگاه بررسی کنید.',
            'buttonText' => 'مشاهده نمونه زنده تابلو',
            'buttonUrl' => route('public.demo'),
            'secondaryText' => 'شروع تست ۱۴ روزه رایگان',
            'secondaryUrl' => route('admin.register'),
        ])

        {{-- بخش ۴: ۷ معیار بررسی پیش از انتخاب --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-6">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block shrink-0"></span>
                <span>قبل از انتخاب تابلو آنلاین طلا، این ۷ مورد را بررسی کنید</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach($criteriaList as $criterion)
                    <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-2.5">
                        <div class="flex items-center gap-2.5">
                            <span class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-700 dark:text-amber-400 flex items-center justify-center shrink-0">
                                @include('partials.ui-icon', ['name' => $criterion['icon'], 'class' => 'w-4 h-4'])
                            </span>
                            <h3 class="text-sm sm:text-base font-bold text-stone-900 dark:text-stone-100">{{ $criterion['title'] }}</h3>
                        </div>
                        <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">{{ $criterion['text'] }}</p>
                    </div>
                @endforeach

                <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-2.5 md:col-span-2">
                    <div class="flex items-center gap-2.5">
                        <span class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-700 dark:text-amber-400 flex items-center justify-center shrink-0">
                            @include('partials.ui-icon', ['name' => 'shield', 'class' => 'w-4 h-4'])
                        </span>
                        <h3 class="text-sm sm:text-base font-bold text-stone-900 dark:text-stone-100">۷. پشتیبانی، هزینه تمدید و جابه‌جایی حساب</h3>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                        پیش از پرداخت، درباره ساعات پاسخ‌گویی، روش دریافت پشتیبانی، هزینه تمدید سالانه یا ماهانه، تعداد نمایشگرهای مجاز و امکان جابه‌جایی حساب به تلویزیون یا دستگاه دیگر سؤال کنید. جزئیات پلن‌های طلالایو به‌صورت شفاف در صفحه <a href="{{ route('public.pricing') }}" class="font-semibold underline text-amber-700 dark:text-amber-400">تعرفه تابلو طلافروشی</a> منتشر شده است.
                    </p>
                </div>
            </div>
        </section>

        {{-- بخش ۵: محاسبه هزینه واقعی --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-5">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block shrink-0"></span>
                <span>قیمت تابلو طلافروشی چگونه محاسبه می‌شود؟</span>
            </h2>
            <p class="text-sm sm:text-base">
                برای مقایسه قیمت تابلو طلافروشی، فقط مبلغ اولیه را نبینید. هزینه واقعی یک تابلو در طول زمان از چند بخش تشکیل می‌شود:
            </p>
            <div class="p-4 sm:p-5 rounded-2xl bg-amber-500/10 border border-amber-500/25 text-center text-xs sm:text-base font-black text-stone-900 dark:text-amber-200">
                هزینه کل استفاده = تجهیزات اولیه + اشتراک سرویس + نصب و راه‌اندازی + اینترنت + خدمات جانبی احتمالی
            </div>
            <p class="text-sm sm:text-base">
                اگر تلویزیون سازگار دارید، هزینه تجهیزات اولیه می‌تواند به صفر برسد؛ اما اگر به اندروید باکس یا نمایشگر جدید نیاز دارید، باید هزینه آن را هم در مقایسه وارد کنید. برای تصمیم دقیق‌تر، از هر ارائه‌دهنده هزینه کل یک دوره یکسان (مثلاً یک‌ساله) را بخواهید و بررسی کنید کدام خدمات در اشتراک لحاظ شده است.
            </p>
            <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                درباره تابلوهای با عنوان «رایگان» نیز همین دقت لازم است: رایگان‌بودن گاهی به معنی نسخه محدود، دوره آزمایشی یا نمایش تبلیغات روی صفحه ویترین است. در طلالایو به‌جای تبلیغات روی تابلوی مغازه، یک دوره <a href="{{ route('public.pricing') }}" class="font-semibold underline text-amber-700 dark:text-amber-400">تست رایگان ۱۴ روزه</a> در اختیار دارید تا پیش از انتخاب <a href="{{ route('public.pricing') }}" class="font-semibold underline text-amber-700 dark:text-amber-400">اشتراک مناسب</a>، عملکرد واقعی را بسنجید.
            </p>
        </section>

        {{-- بخش ۶: راه‌اندازی قدم‌به‌قدم --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-6">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block shrink-0"></span>
                <span>راه‌اندازی تابلو قیمت طلا روی تلویزیون؛ قدم‌به‌قدم</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($setupSteps as $item)
                    <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-2.5">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-700 dark:text-amber-400 font-black text-base flex items-center justify-center">
                            {{ $item['step'] }}
                        </div>
                        <h3 class="text-sm sm:text-base font-bold text-stone-900 dark:text-stone-100">{{ $item['title'] }}</h3>
                        <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-xs sm:text-sm text-stone-800 dark:text-stone-200 leading-relaxed flex items-center gap-2.5">
                @include('partials.ui-icon', ['name' => 'book', 'class' => 'w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0'])
                <span>
                    <strong>آموزش تکمیلی:</strong> اگر هنوز تلویزیون مغازه را انتخاب نکرده‌اید راهنمای <a href="{{ route('public.guides.show', 'best-tv-for-jewelry-shop') }}" class="font-bold underline text-amber-700 dark:text-amber-400">بهترین تلویزیون برای طلافروشی</a> را بخوانید و برای مراحل اتصال، صفحه <a href="{{ route('public.tv-setup-guide') }}" class="font-bold underline text-amber-700 dark:text-amber-400">آموزش اتصال تلویزیون به تابلو</a> را ببینید.
                </span>
            </div>
        </section>

        {{-- بخش ۷: نحوه بررسی طلالایو برای مغازه --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block shrink-0"></span>
                <span>طلالایو را چگونه برای مغازه خود بررسی کنیم؟</span>
            </h2>
            <p class="text-sm sm:text-base">
                اگر به دنبال راه‌اندازی تابلو قیمت طلا روی تلویزیون هستید، نقطه شروع منطقی مشاهده <a href="{{ route('public.demo') }}" class="font-semibold underline text-amber-700 dark:text-amber-400">نمونه زنده تابلوی طلالایو</a> و تطبیق روش اجرا (مرورگر تلویزیون یا اپلیکیشن اندروید) با نمایشگر فعلی مغازه است.
            </p>
            <p class="text-sm sm:text-base">
                پیشنهاد می‌کنیم پیش از تصمیم نهایی، مدل تلویزیون، نرخ‌های موردنیاز فروشگاه و شرایط اینترنت مغازه را با <a href="{{ route('public.contact') }}" class="font-semibold underline text-amber-700 dark:text-amber-400">پشتیبانی طلالایو</a> مطرح کنید، شرایط و <a href="{{ route('public.pricing') }}" class="font-semibold underline text-amber-700 dark:text-amber-400">تعرفه‌های جاری</a> را ببینید و با تست ۱۴ روزه رایگان عملکرد تابلو را روی نمایشگر خودتان بسنجید؛ نه صرفاً بر اساس ظاهر یک تصویر تبلیغاتی.
            </p>
        </section>

        {{-- بخش ۸: پرسش‌های متداول --}}
        <section class="space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block shrink-0"></span>
                <span>پرسش‌های متداول</span>
            </h2>

            <div class="space-y-3">
                @foreach($faqs as $idx => $faq)
                    <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                        <summary class="flex items-center justify-between gap-3 cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                            <span>{{ ($idx + 1) }}. {{ $faq['q'] }}</span>
                            <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200 shrink-0">
                                @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                            </span>
                        </summary>
                        <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                            {{ $faq['a'] }}
                        </div>
                    </details>
                @endforeach
            </div>
        </section>

        {{-- جمع‌بندی --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block shrink-0"></span>
                <span>جمع‌بندی</span>
            </h2>
            <p class="text-sm sm:text-base">
                برای داشتن تابلو قیمت طلافروشی، همیشه خرید دستگاه اختصاصی اولین قدم نیست. ابتدا امکانات تلویزیون فعلی مغازه را بررسی کنید؛ در بسیاری از موارد یک سرویس سازگار همان نیاز را با تجهیزات کمتر برآورده می‌کند.
            </p>
            <p class="text-sm sm:text-base">
                در انتخاب نهایی، تازگی داده، خوانایی نرخ‌ها از فاصله ویترین، نمایش روشن واحد پول و عیار، رفتار صادقانه هنگام قطعی اینترنت و کیفیت پشتیبانی را جدی بگیرید. <strong>تابلوی مناسب، تابلویی است که مشتری بتواند اطلاعاتش را روشن بخواند و شما بدانید در شرایط روزمره مغازه چطور کار می‌کند.</strong>
            </p>
        </section>

    </article>

    {{-- پیوندهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'مطالب و راهنماهای مرتبط',
        'links' => [
            [
                'title' => 'آموزش اتصال تلویزیون به تابلو',
                'desc' => 'مراحل تنظیم مرورگر تلویزیون‌های هوشمند، کنترل تمام‌صفحه و بررسی سازگاری.',
                'url' => route('public.tv-setup-guide'),
            ],
            [
                'title' => 'تابلو طلا روی اندروید تی‌وی و باکس',
                'desc' => 'راهنمای نصب و اجرای تابلوی طلالایو روی Android TV، Google TV و اندروید باکس.',
                'url' => route('public.android-tv-gold-board'),
            ],
            [
                'title' => 'تعرفه تابلو طلافروشی و شروع تست',
                'desc' => 'مشاهده پلن‌های اشتراک طلالایو، مقایسه امکانات و شروع تست ۱۴ روزه رایگان.',
                'url' => route('public.pricing'),
            ],
        ]
    ])

    {{-- فراخوان نهایی --}}
    <div class="text-center bg-stone-900 dark:bg-stone-850 p-8 sm:p-12 rounded-3xl border border-stone-800 shadow-sm space-y-6">
        <h2 class="text-2xl sm:text-3xl font-black text-white">
            آماده بررسی تابلو روی تلویزیون مغازه هستید؟
        </h2>
        <p class="text-stone-300 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
            همین حالا نمونه زنده تابلو را روی مرورگر تلویزیون یا موبایل ببینید و با ثبت‌نام رایگان، سازگاری صفحه را در شرایط واقعی فروشگاه آزمایش کنید.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('admin.register') }}" class="min-h-11 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm transition-colors shadow-sm inline-flex items-center justify-center">
                شروع تست ۱۴ روزه رایگان
            </a>
            <a href="{{ route('public.demo') }}" class="min-h-11 px-6 py-3.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-white font-bold text-sm border border-stone-700 transition-colors inline-flex items-center justify-center">
                مشاهده پیش‌نمایش زنده
            </a>
        </div>
    </div>

</div>
@endsection
