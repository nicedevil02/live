@extends('layouts.public')

@php
    $seo = config('seo.pages.digital-rate-board');
@endphp

@section('title', $seo['title'] ?? 'نرخ نامه دیجیتال طلافروشی: بدون تابلوی ۷ رقمه | طلالایو')
@section('meta_description', $seo['desc'] ?? 'نرخ‌نامه دیجیتال طلافروشی روی تلویزیون مغازه: نمایش زنده ۷ ردیف نرخ طلا و سکه بدون خرید سخت‌افزار و تابلوی ۷ رقمه. همین حالا با تست ۱۴ روزه رایگان شروع کنید.')
@section('canonical', 'https://talalive.ir/digital-rate-board')

@section('schema')
    {{-- اسکیمای خدمت Service بدون ریتینگ --}}
    @include('partials.schema-service', [
        'name' => 'نرخ نامه دیجیتال طلافروشی طلالایو',
        'serviceType' => 'نرخ نامه دیجیتالی و تابلو اعلام نرخ طلا و مسکوکات روی تلویزیون',
        'description' => 'سامانه ابری نمایش زنده هفت ردیف نرخ طلا، سکه و ارز روی تلویزیون معمولی طلافروشی بدون نیاز به خرید تابلوی ۷ رقمه سون سگمنت یا دستگاه جانبی.',
        'url' => 'https://talalive.ir/digital-rate-board',
    ])

    {{-- اسکیمای پرسش و پاسخ متداول FAQPage --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "FAQPage",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "تفاوت اصلی نرخ‌نامه دیجیتال تلویزیونی با تابلوی ۷ رقمه سون سگمنت چیست؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "تابلوهای سون سگمنت سنتی سخت‌افزارهایی سنگین با ردیف‌های محدود ال‌ای‌دی تک‌رنگ یا دورنگ هستند که برای هر تغییر باید ریموت دستی بزنید یا از کابل استفاده کنید. در مقابل، نرخ‌نامه دیجیتال طلالایو یک سامانه نرم‌افزاری ابری است که مستقیماً روی مرورگر تلویزیون هوشمند مغازه شما اجرا می‌شود، بیش از دوازده نرخ صنفی را با فونت‌های چشم‌نواز فارسی، لوگوی گالری و رنگ‌بندی لوکس نمایش می‌دهد و نرخ‌ها را خودکار به‌روزرسانی می‌کند."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا برای راه‌اندازی نرخ‌نامه دیجیتال به مینی‌کیس، کامپیوتر یا دانگل اختصاصی نیاز داریم؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "خیر. بزرگ‌ترین مزیت نرخ‌نامه دیجیتال طلالایو حذف صد درصدی سخت‌افزارهای واسط است. اگر تلویزیون شما هوشمند باشد، فقط با مرورگر پیش‌فرض آن وارد لینک اختصاصی گالری خود می‌شوید. برای تلویزیون‌های معمولی غیرهوشمند نیز تنها یک دانگل ارزان یا اندروید باکس ساده با کابل HDMI کافی است و نیازی به کیس‌های گران‌قیمت یا مینی‌کامپیوتر تک‌منظوره ندارید."
          }
        },
        {
          "@@type": "Question",
          "name": "نرخ‌ها چگونه به‌روزرسانی می‌شوند؟ آیا امکان تغییر دستی یا اعمال فرمول سود شخصی وجود دارد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "نرخ‌ها به‌صورت لحظه‌ای از منابع رسمی بازار، مظنه تهران و اتحادیه دریافت و همگام‌سازی می‌شوند. علاوه بر این، طلافروش از طریق پنل مدیریت ابری در تلفن همراه خود می‌تواند هر ردیف را به دلخواه قفل کند، نرخ دستی وارد نماید، یا فرمول تخفیف و فرمول اختصاصی خرید و فروش متفرقه خود را روی تابلو اعمال کند."
          }
        },
        {
          "@@type": "Question",
          "name": "در صورت قطعی اینترنت در بازار یا مغازه چه اتفاقی برای نمایشگر نرخ می‌افتد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "نرخ‌نامه دیجیتال مجهز به کش محلی آفلاین است. در صورت قطعی موقت اینترنت، آخرین نرخ‌های معتبر بدون کوچک‌ترین قطعی تصویر روی صفحه باقی می‌مانند و نشانگر وضعیت اتصال، شما را از وضعیت شبکه مطلع می‌سازد. به محض برقراری مجدد ارتباط، ردیف‌ها بلافاصله همگام می‌شوند."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا می‌توان لوگوی اختصاصی گالری، شماره تماس و پیام‌های مناسبتی را در نرخ‌نامه نمایش داد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "بله. برخلاف تابلوی ۷ رقمه خشک و بی‌روح، در نرخ‌نامه دیجیتال می‌توانید نام و لوگوی طلافروشی، پیام خوش‌آمدگویی، اطلاعیه‌های صنفی، ساعت و تقویم رسمی و حتی تصاویری از مصنوعات ویترین گالری را به زیبایی هرچه تمام‌تر در کنار نرخ‌های زنده به نمایش بگذارید."
          }
        },
        {
          "@@type": "Question",
          "name": "هزینه اشتراک نرخ‌نامه دیجیتال چقدر است و چطور می‌توان تست کرد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "هزینه اشتراک سالیانه طلالایو کسری ناچیز از بهای یک تابلوی ۷ رقمه دست دوم است. شما می‌توانید بدون پرداخت هیچ وجهی و بدون نیاز به ورود اطلاعات بانکی، ۱۴ روز به‌طور کاملاً رایگان سامانه را روی تلویزیون مغازه خود تست و راه‌اندازی نمایید."
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
            ['title' => 'نرخ نامه دیجیتال طلافروشی', 'url' => ''],
        ]
    ])

    {{-- سربرگ اصلی صفحه --}}
    <header class="text-center py-6 sm:py-10 space-y-6">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-800 dark:text-amber-300 text-xs font-semibold">
            @include('partials.ui-icon', ['name' => 'sparkles', 'class' => 'w-4 h-4 text-amber-600 dark:text-amber-400'])
            <span>نسل نو تابلوی اعلام قیمت طلا و جواهر بدون هزینه سخت‌افزار</span>
        </div>
        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-stone-900 dark:text-stone-100 leading-tight">
            نرخ نامه دیجیتال طلافروشی؛ اعلام قیمت روی تلویزیون
        </h1>
        <p class="text-base sm:text-lg text-stone-600 dark:text-stone-300 max-w-3xl mx-auto leading-relaxed">
            <strong>نرخ‌نامه دیجیتال طلافروشی</strong> سامانه‌ای نرم‌افزاری و ابری است که کارکرد سنتی تابلوهای ۷ رقمه سون سگمنت را بدون نیاز به دستگاه گران‌قیمت یا سیم‌کشی روی تلویزیون معمولی مغازه پیاده‌سازی می‌کند. با این راهکار نوآورانه، نمایش زنده نرخ‌های صنفی با بالاترین وضوح، بدون استهلاک و در کمتر از ۳ دقیقه در دسترس شماست.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
            <a href="{{ route('admin.register') }}" class="min-h-11 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm shadow-sm transition-colors inline-flex items-center justify-center">
                شروع تست ۱۴ روزه رایگان
            </a>
            <a href="{{ route('public.pricing') }}" class="min-h-11 px-6 py-3.5 rounded-xl bg-white dark:bg-stone-900 hover:bg-stone-50 dark:hover:bg-stone-850 text-stone-800 dark:text-stone-200 font-bold text-sm border border-stone-300 dark:border-stone-700 transition-colors shadow-sm inline-flex items-center justify-center">
                مشاهده تعرفه اشتراک
            </a>
        </div>
    </header>

    {{-- محتوای اصلی مقاله و راهنما --}}
    <article class="space-y-10 text-stone-700 dark:text-stone-300 leading-loose">

        {{-- بخش ۱: مقایسه مفهوم نرخ‌نامه دیجیتال با تابلوی ۷ رقمه --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                چرا تابلوی ۷ رقمه سون سگمنت جای خود را به نرخ‌نامه دیجیتالی داد؟
            </h2>
            <p>
                برای چندین دهه، ویترین و دیوار مغازه‌های طلافروشی تحت تسلط تابلوهای الکترونیکی معروف به <strong>تابلو ۷ رقمه طلافروشی</strong> و نمایشگرهای مبتنی بر سون سگمنت بود. این تابلوهای دیواری اگرچه در زمان خود کاربردی بودند، اما امروزه با محدودیت‌های فنی و هزینه‌های نگهداری سنگین روبه‌رو هستند. خرابی مداوم دیودهای نوری، سوختن ترانس برق، دشواری در تغییر نرخ‌ها با ریموت‌های مادون‌قرمز ضعیف و ظاهر صنعتی، سبب شده تا طلافروشان به سراغ <strong>نرخ نامه دیجیتالی</strong> تحت وب بروند.
            </p>
            <p>
                یک <strong>تابلو نرخ نامه</strong> دیجیتال، دقیقاً همان مأموریت حیاتی یعنی نمایش شفاف و رسمی مظنه و مسکوکات به مشتری را انجام می‌دهد، با این تفاوت بنیادین که هیچ قطعه سخت‌افزاری اختصاصی یا <strong>مینی‌کامپیوتر تک‌منظوره</strong> به شما تحمیل نمی‌کند. شما از صفحه‌نمایش باکیفیت تلویزیونی که از قبل در گالری خود نصب کرده‌اید استفاده می‌کنید و از طریق اتصال ابری، نرخ‌ها را با فونت‌های خوانای فارسی و گرافیک مناسب به معرض دید خریداران می‌گذارید.
            </p>
        </section>

        {{-- بخش ۲: جدول مقایسه جامع فنی و اقتصادی --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                جدول مقایسه: تابلوی ۷ رقمه سون سگمنت در برابر نرخ‌نامه دیجیتال تلویزیونی
            </h2>
            <p class="text-xs sm:text-sm text-stone-500 dark:text-stone-400">
                این جدول، تفاوت‌های واقعی، هزینه‌ای و کارکردی میان تابلوهای سنتی سخت‌افزاری و سامانه ابری طلالایو را مقایسه می‌کند:
            </p>

            <div class="overflow-x-auto rounded-2xl border border-stone-200 dark:border-stone-800">
                <table class="w-full text-right text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="border-b border-stone-200 dark:border-stone-800 bg-stone-100 dark:bg-stone-850 text-stone-900 dark:text-stone-100 font-bold">
                            <th class="p-4">معیار مقایسه</th>
                            <th class="p-4 text-stone-600 dark:text-stone-400">تابلوی سون سگمنت ۷ رقمه سنتی</th>
                            <th class="p-4 text-amber-600 dark:text-amber-400">نرخ‌نامه دیجیتال تلویزیونی طلالایو</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 dark:divide-stone-800">
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">هزینه اولیه و خرید</td>
                            <td class="p-4 text-red-600 dark:text-red-400">چندین میلیون تومان بابت قاب، برد و ال‌ای‌دی</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">صفر تومان (استفاده از همان تلویزیون مغازه)</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">تعداد ردیف‌های قابل نمایش</td>
                            <td class="p-4 text-stone-600 dark:text-stone-400">محدود و ثابت (معمولاً ۵ تا ۷ ردیف بدون امکان افزایش)</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">نامحدود (نمایش همزمان ۱۲+ ردیف طلا، سکه و ارز)</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">نحوه تغییر و به‌روزرسانی نرخ</td>
                            <td class="p-4 text-red-600 dark:text-red-400">تایپ دستی تک‌تک ارقام با ریموت یا کیبورد سیمی</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">به‌روزرسانی خودکار و لحظه‌ای + تنظیم آسان با گوشی</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">استهلاک و خرابی قطعات</td>
                            <td class="p-4 text-red-600 dark:text-red-400">سوختن مکرر سگمنت‌ها، پاور سوپلای و نیاز به ارسال به تعمیرگاه</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">بدون قطعه متحرک، بدون خرابی سخت‌افزاری اختصاصی</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">مصرف برق و حرارت</td>
                            <td class="p-4 text-stone-600 dark:text-stone-400">بالا به علت بردهای قدیمی و داغ کردن در تابستان</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">بهینه و منطبق با استاندارد مصرف انرژی تلویزیون</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">وضوح و زاویه دید</td>
                            <td class="p-4 text-red-600 dark:text-red-400">اعداد مات و تک‌رنگ با زاویه دید محدود</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">کیفیت 4K و Full HD با زاویه دید گسترده</td>
                        </tr>
                        <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40 transition-colors">
                            <td class="p-4 font-semibold text-stone-900 dark:text-stone-100">امکانات برندینگ و ویترین</td>
                            <td class="p-4 text-stone-400">غیرممکن (تنها اعداد قرمز یا سبز نمایش داده می‌شوند)</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">درج لوگوی طلافروشی، متن خوش‌آمدگویی و اسلایدر محصولات</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        {{-- بنر فراخوان میانی --}}
        @include('partials.cta-inline', [
            'title' => 'تلویزیون مغازه را به نرخ‌نامه دیجیتال تبدیل کنید',
            'subtitle' => 'تنها با وارد کردن یک آدرس کوتاه در مرورگر تلویزیون، تابلوی ۷ رقمه قدیمی را کنار بگذارید. ۱۴ روز تست رایگان بدون نیاز به کارت بانکی.',
            'buttonText' => 'تست رایگان نرخ‌نامه دیجیتال',
            'buttonUrl' => route('admin.register'),
            'secondaryText' => 'راهنمای راه‌اندازی تلویزیون',
            'secondaryUrl' => route('public.tv-setup-guide'),
        ])

        {{-- بخش ۳: ردیف‌های صنفی قابل نمایش بر اساس استانداردهای بازار طلا --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-6">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                چه ردیف‌هایی در نرخ‌نامه دیجیتال طلافروشی نمایش داده می‌شود؟
            </h2>
            <p>
                در صنف طلا و جواهر، اعلام نرخ صرفاً به قیمت هر گرم طلای ۱۸ عیار ختم نمی‌شود. یک طلافروش حرفه‌ای به عنوان یک <strong>دستگاه اعلام نرخ</strong> جامع نیاز دارد تا سبد کاملی از شاخص‌های معتبر بازار را به مشتریان و همکاران صنف عرضه کند. نرخ‌نامه دیجیتال طلالایو تمامی ردیف‌های زیر را با تفکیک و چینش دلخواه پشتیبانی می‌کند:
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'coins', 'class' => 'w-5 h-5 text-amber-500'])
                        <span>شاخص‌های مبنایی و مظنه بازار</span>
                    </h3>
                    <ul class="text-xs sm:text-sm space-y-2 text-stone-600 dark:text-stone-400 list-disc list-inside">
                        <li><strong>مظنه تهران (مظنه مثقال):</strong> قیمت رسمی یک مثقال طلای ۱۷ عیار (۷۰۵) که نرخ پایه معاملات کلیه بنکداران است.</li>
                        <li><strong>مظنه بازار و مظنه فردایی:</strong> رصد نوسانات انتظاری و تحلیل جهت‌گیری بازار برای مدیریت ریسک ویترین.</li>
                        <li><strong>گرم طلای ۱۸ عیار (۷۵۰):</strong> قیمت مبنای فروش طلا ساخته‌شده در کلیه ویترین‌های طلافروشی.</li>
                        <li><strong>طلای ۲۴ عیار (۹۹۹):</strong> نرخ طلای خام استاندارد شمش جهت سرمایه‌گذاری و محاسبات عیارسنجی.</li>
                        <li><strong>انس جهانی طلا:</strong> شاخص لحظه‌ای بازار بین‌المللی جهت شفاف‌سازی نوسانات داخلی.</li>
                    </ul>
                </div>

                <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'scale', 'class' => 'w-5 h-5 text-amber-500'])
                        <span>نرخ‌های تخصصی دادوستد و آبشده</span>
                    </h3>
                    <ul class="text-xs sm:text-sm space-y-2 text-stone-600 dark:text-stone-400 list-disc list-inside">
                        <li><strong>تعویض متفرقه ۱۸:</strong> نرخ اختصاصی تعویض طلای مستعمل مشتری با طلای نو طبق عرف بازار.</li>
                        <li><strong>خرید متفرقه ۱۸:</strong> قیمت خالص خرید طلای کارکرده از مشتری با رعایت حاشیه قانونی و آزمایش عیار.</li>
                        <li><strong>طلای آبشده نقدی:</strong> نرخ خرید و فروش شمش‌های آبشده کارگاهی همراه با شماره انگ و برگه ری‌گیری.</li>
                        <li><strong>عیارهای متداول صنف (۷۰۵، ۷۴۰، ۷۵۰):</strong> تبدیل خودکار و هوشمند عیارهای کارگاهی به عیار رسمی کشور.</li>
                    </ul>
                </div>

                <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'medal', 'class' => 'w-5 h-5 text-amber-500'])
                        <span>مسکوکات رسمی بانک مرکزی و سکه‌های کادویی</span>
                    </h3>
                    <ul class="text-xs sm:text-sm space-y-2 text-stone-600 dark:text-stone-400 list-disc list-inside">
                        <li><strong>سکه تمام بهار آزادی (طرح قدیم):</strong> عیار ۹۰۰ با وزن ۸.۱۳۳ گرم.</li>
                        <li><strong>سکه امامی (طرح جدید):</strong> پرمعامله‌ترین قطعه مسکوکات نقدی با محاسبه حباب لحظه‌ای.</li>
                        <li><strong>نیم سکه و ربع سکه بهار آزادی:</strong> قطعات پرطرفدار سرمایه‌گذاری خرد در بازار طلا.</li>
                        <li><strong>سکه گرمی بانک مرکزی:</strong> استاندارد بسته‌بندی امنیتی ویژه هدایا و پس‌انداز.</li>
                        <li><strong>سکه پارسیان:</strong> پلاک‌های طلای عیار ۷۵۰ در اوزان ۵۰ سوت تا ۲ گرم برای مشتریان خرد.</li>
                    </ul>
                </div>

                <div class="p-5 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100 flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'sparkles', 'class' => 'w-5 h-5 text-amber-500'])
                        <span>بازار نقره، شمش و ارزهای مرجع</span>
                    </h3>
                    <ul class="text-xs sm:text-sm space-y-2 text-stone-600 dark:text-stone-400 list-disc list-inside">
                        <li><strong>گرم نقره خام (عیار ۹۹۹ و ۹۹۵):</strong> مناسب برای سازندگان و متقاضیان شمش نقره.</li>
                        <li><strong>گرم نقره ساچمه و زیورآلات (عیار ۹۲۵):</strong> عیار استاندارد استرلینگ نقره در ویترین‌های جواهری.</li>
                        <li><strong>شمش طلا و شمش نقره:</strong> اوزان یک گرمی تا یک کیلوگرمی با برچسب اصالت.</li>
                        <li><strong>نرخ‌های جهانی و کریپتو:</strong> نمایش تتر (ارز دیجیتال)، نفت برنت، انس جهانی نقره و مظنه جهانی طلا.</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- بخش ۴: سهولت اتصال و رفع نیاز به مینی‌کیس و دانگل --}}
        <section class="bg-white dark:bg-stone-900 p-6 sm:p-10 rounded-3xl border border-stone-200 dark:border-stone-800 space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                بدون کابل‌کشی، بدون مینی‌کیس و بدون دردسرهای سخت‌افزاری
            </h2>
            <p>
                در گذشته برای نصب هرگونه <strong>تابلو آنلاین</strong> یا نمایشگر کامپیوتری در مغازه، طلافروش ناچار بود هزینه‌های گزافی بابت خرید کیس‌های کوچک مینی‌استوک، کیبورد بی‌سیم، کابل‌کشی طولانی HDMI و محافظ‌های برق اختصاصی بپردازد. سیستم‌های ویندوزی دائماً با مشکل آپدیت‌های ناخواسته، ویروسی شدن، داغ کردن منبع تغذیه و خاموش شدن ناگهانی روبه‌رو بودند.
            </p>
            <p>
                طلالایو با اتکا به فناوری وب مدرن، این معماری فرسوده را دگرگون کرده است. هر تلویزیون هوشمند دارای یک مرورگر اینترنت داخلی است. کافی است یک بار آدرس اختصاصی تابلوی خود را در آن وارد کنید و گزینه تمام‌صفحه را بزنید. تلویزیون مغازه به یک تابلوی تمام‌عیار تبدیل می‌شود که با روشن شدن تلویزیون به کار خود ادامه می‌دهد.
            </p>
            <div class="mt-4 flex flex-wrap gap-2 text-xs">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-stone-100 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 text-stone-700 dark:text-stone-300">
                    @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-3.5 h-3.5 text-emerald-500'])
                    سازگار با تمامی تلویزیون‌های هوشمند 4K و FHD
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-stone-100 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 text-stone-700 dark:text-stone-300">
                    @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-3.5 h-3.5 text-emerald-500'])
                    سازگار با اندروید تی‌وی و انواع اندروید باکس
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-stone-100 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 text-stone-700 dark:text-stone-300">
                    @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-3.5 h-3.5 text-emerald-500'])
                    قابلیت چرخش تصویر (افقی و عمودی)
                </span>
            </div>
        </section>

        {{-- بخش ۵: پرسش‌های متداول --}}
        <section class="space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-3">
                <span class="w-2 h-7 bg-amber-500 rounded-full inline-block"></span>
                سؤالات متداول طلافروشان درباره نرخ‌نامه دیجیتال
            </h2>

            <div class="space-y-3">
                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۱. تفاوت اصلی نرخ‌نامه دیجیتال تلویزیونی با تابلوی ۷ رقمه سون سگمنت چیست؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        تابلوهای سون سگمنت سخت‌افزارهایی سنگین و تک‌رنگ هستند که ردیف‌های محدودی دارند و برای هر بار تنظیم باید با ریموت‌های ضعیف کار کنید. نرخ‌نامه دیجیتال طلالایو روی تلویزیون هوشمند اجرا شده، بیش از دوازده نرخ را همزمان با لوگو و فونت اختصاصی نشان می‌دهد و خودکار آپدیت می‌شود.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۲. آیا برای راه‌اندازی نرخ‌نامه به مینی‌کیس یا دانگل اختصاصی نیاز است؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        خیر. با مرورگر وب تلویزیون‌های هوشمند مستقیماً اجرا می‌شود. برای تلویزیون‌های فاقد سیستم‌عامل، یک اندروید باکس اقتصادی چندصد هزار تومانی کافی است و نیازی به کیس‌های میلیونی ندارید.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۳. نرخ‌ها چگونه به‌روزرسانی می‌شوند؟ آیا می‌توان نرخ‌ها را دستی تغییر داد؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        نرخ‌ها خودکار از بازار و اتحادیه دریافت می‌شوند. با این حال، شما در پنل کاربری تلفن همراه خود می‌توانید هر ردیف را دستی ویرایش کنید، حباب دلخواه بگذارید یا برخی اقلام را پنهان کنید.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۴. اگر اینترنت مغازه یا پاساژ قطع شود چه اتفاقی برای نرخ‌نامه می‌افتد؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        صفحه سیاه نمی‌شود و تصویر نمی‌پرد؛ آخرین نرخ‌های دریافت شده به شکل کش محلی حفظ می‌شوند و به محض اتصال مجدد، ارقام بدون نیاز به رفرش دستی به‌روز می‌شوند.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۵. آیا می‌توان لوگوی اختصاصی طلافروشی و پیام تبریک را نمایش داد؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        بله. سیستم تابلوی هوشمند طلالایو به شما اجازه می‌دهد لوگوی باکیفیت، نشانی شبکه‌های اجتماعی، شماره تماس، نوار متحرک اطلاعیه‌ها و اسلاید محصولات گالری را نمایش دهید.
                    </div>
                </details>

                <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                    <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                        <span>۶. هزینه اشتراک چقدر است و چطور می‌توان تست کرد؟</span>
                        <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                        </span>
                    </summary>
                    <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                        هزینه اشتراک سالیانه کسری از بهای خرید یک تابلوی سنتی است. ضمناً می‌توانید به مدت ۱۴ روز رایگان و بدون هیچ تعهدی، کلیه امکانات را روی تلویزیون گالری خود ارزیابی کنید.
                    </div>
                </details>
            </div>
        </section>

    </article>

    {{-- بخش مطالب و ابزارهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'مطالب، ابزارها و راهنماهای مرتبط با تابلو نرخ طلا',
        'links' => [
            [
                'title' => 'تابلوی هوشمند طلافروشی و تلویزیون مغازه',
                'desc' => 'آشنایی جامع با ویژگی‌های مدرن تابلوی ابری طلالایو و حذف سخت‌افزارهای سنتی.',
                'url' => route('public.smart-gold-board'),
            ],
            [
                'title' => 'تابلو نرخ نقره و شمش',
                'desc' => 'پوشش تخصصی انواع عیارهای نقره و شمش‌های معتبر در کنار طلا.',
                'url' => route('public.silver-bullion-board'),
            ],
            [
                'title' => 'راهنمای راه‌اندازی تلویزیون طلافروشی',
                'desc' => 'آموزش گام‌به‌گام اتصال تلویزیون سامسونگ، ال‌جی و اندروید تی‌وی به تابلوی اعلام نرخ.',
                'url' => route('public.tv-setup-guide'),
            ],
            [
                'title' => 'تعرفه‌ها و پلن‌های اشتراک سالیانه',
                'desc' => 'مشاهده قیمت‌های شفاف و امکانات هر یک از پلن‌های کاربری طلالایو.',
                'url' => route('public.pricing'),
            ],
        ]
    ])

    {{-- فراخوان نهایی انتهای صفحه --}}
    <div class="text-center bg-stone-900 dark:bg-stone-850 p-8 sm:p-12 rounded-3xl border border-stone-800 shadow-sm space-y-6">
        <h2 class="text-2xl sm:text-3xl font-black text-white">
            تغییر ویترین طلافروشی شما فقط ۳ دقیقه زمان می‌برد
        </h2>
        <p class="text-stone-300 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
            همین الان بدون پرداخت وجه، در سامانه طلالایو ثبت‌نام کنید، آدرس تابلوی اختصاصی خود را در مرورگر تلویزیون باز کنید و از تحول فضای گالری خود لذت ببرید.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('admin.register') }}" class="min-h-11 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm transition-colors shadow-sm inline-flex items-center justify-center">
                ساخت تابلوی اختصاصی در ۳ دقیقه
            </a>
            <a href="{{ route('public.contact') }}" class="min-h-11 px-6 py-3.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-white font-bold text-sm border border-stone-700 transition-colors inline-flex items-center justify-center">
                مشاوره و پشتیبانی تلفنی
            </a>
        </div>
    </div>

</div>
@endsection
