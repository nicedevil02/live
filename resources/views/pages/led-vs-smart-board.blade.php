@extends('layouts.public')

@section('title', 'تابلو ال ای دی طلا فروشی بخریم یا تلویزیون؟ مقایسه جامع | طلالایو')
@section('meta_description', 'مقایسه قیمت تابلو ال ای دی طلا فروشی (حدود ۸ تا ۳۰ میلیون تومان بر متر مربع) با تابلوی تلویزیونی طلالایو. همین حالا با تست ۱۴ روزه رایگان هوشمند شوید.')
@section('canonical', 'https://talalive.ir/led-vs-smart-board')

@section('schema')
    {{-- اسکیمای استاندارد Service طلالایو بدون ریتینگ --}}
    @include('partials.schema-service', [
        'name' => 'سامانه تابلوی هوشمند طلالایو: جایگزین تابلو ال ای دی طلا فروشی',
        'serviceType' => 'سامانه ابری نمایش آنلاین نرخ طلا و مسکوکات روی تلویزیون مغازه',
        'description' => 'جایگزین ابری تابلوهای فیزیکی LED با قابلیت نمایش زنده نرخ طلا، سکه، تتر و ویترین عکس جواهرات روی تلویزیون مغازه بدون مینی‌کیس.',
        'url' => 'https://talalive.ir/led-vs-smart-board',
    ])

    {{-- اسکیمای پرسش و پاسخ متداول FAQPage --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "FAQPage",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "هزینه خرید تابلو ال ای دی طلا فروشی در مقایسه با استفاده از تلویزیون چقدر است؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "قیمت تابلوهای فیزیکی LED در بازار بر اساس نوع ماژول حدود ۸ تا ۳۰ میلیون تومان در هر متر مربع برآورد می‌شود (قیمت‌ها تقریبی و متغیر است). در حالی که با سامانه ابری طلالایو نیازی به خرید تابلوی مجزا ندارید و از همان تلویزیون موجود در مغازه استفاده می‌کنید."
          }
        },
        {
          "@@type": "Question",
          "name": "چرا تابلوهای LED در گذر زمان دچار افت کیفیت و خرابی می‌شوند؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "ماژول‌های LED به دلیل کارکرد مداوم، حرارت بالای منبع تغذیه (پاور سوپلای) و نوسانات برق، دچار سوختگی دیودها، افت نور پیکسل‌ها و اختلال در آی‌سی‌های درایور می‌شوند و تعمیر آن‌ها مستلزم باز کردن کل قاب تابلو است."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا می‌توان روی تابلو ال ای دی طلا فروشی تصاویر ویترین را پخش کرد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "خیر. تابلوهای متداول LED رزولوشن پایینی دارند و فقط قادر به نمایش متن و اعداد تک‌رنگ هستند. در طلالایو تصاویر باکیفیت 4K از مصنوعات طلا و جواهر در قالب اسلایدشو در کنار نرخ‌ها پخش می‌شوند."
          }
        },
        {
          "@@type": "Question",
          "name": "چگونه می‌توان تلویزیون معمولی مغازه را به تابلوی هوشمند تبدیل کرد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "با باز کردن مرورگر اینترنت تلویزیون هوشمند یا اتصال یک اندروید باکس به پورت HDMI تلویزیون، در کمتر از ۳ دقیقه می‌توانید تابلوی آنلاین طلالایو را فعال نمایید."
          }
        }
      ]
    }
    </script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16">

    {{-- مسیر راهنما Breadcrumb --}}
    @include('partials.breadcrumb', [
        'items' => [
            ['title' => 'تابلوی هوشمند طلافروشی', 'url' => route('public.smart-gold-board')],
            ['title' => 'مقایسه تابلو LED و تلویزیون هوشمند', 'url' => ''],
        ]
    ])

    {{-- سربرگ اصلی صفحه --}}
    <header class="text-center space-y-6 max-w-4xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-stone-100 dark:bg-stone-850 border border-stone-200 dark:border-stone-750 text-stone-700 dark:text-stone-300 text-xs font-semibold">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            <span>بررسی فنی و مقایسه اقتصادی ویژه صنف طلا و جواهر (ویرایش ۱۴۰۵)</span>
        </div>
        
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-stone-900 dark:text-stone-100 leading-tight">
            تابلو ال ای دی طلا فروشی بخریم یا <br>
            <span class="text-amber-600 dark:text-amber-400">
                تلویزیون مغازه را به تابلوی اعلام قیمت تبدیل کنیم؟
            </span>
        </h1>

        <p class="text-stone-600 dark:text-stone-300 text-base sm:text-lg leading-relaxed max-w-3xl mx-auto">
            آیا پرداخت هزینه‌های سنگین (برآورد تقریبی حدود ۸ تا ۳۰ میلیون تومان در هر متر مربع بسته به نوع ماژول) برای خرید <strong>تابلو ال ای دی طلا فروشی</strong> و جعبه‌های فلزی سنتی توجیه اقتصادی دارد؟ در این راهنما تفاوت‌های فنی، دوام قطعات و هزینه سه‌ساله مالکیت تابلوهای سخت‌افزاری را در برابر تابلوی ابری <strong>طلالایو</strong> مقایسه می‌کنیم.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a href="{{ route('admin.register') }}" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm transition-colors shadow-sm inline-flex items-center justify-center">
                تست ۱۴ روزه رایگان بدون دستگاه
            </a>
            <a href="{{ route('public.smart-gold-board') }}" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl bg-white dark:bg-stone-900 border border-stone-300 dark:border-stone-700 hover:bg-stone-50 dark:hover:bg-stone-850 text-stone-800 dark:text-stone-200 font-bold text-sm transition-colors shadow-sm inline-flex items-center justify-center">
                امکانات تابلوی ابری طلالایو
            </a>
        </div>
    </header>

    {{-- بخش ۱: چرا تابلوهای LED خراب می‌شوند؟ --}}
    <section class="rounded-3xl p-6 sm:p-10 bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-6">
        <div class="flex items-center gap-3">
            <div class="w-2.5 h-7 rounded-full bg-amber-500"></div>
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">
                چرا تابلوهای LED طلافروشی مدام خراب می‌شوند؟ کالبدشکافی فنی
            </h2>
        </div>
        <p class="text-stone-600 dark:text-stone-300 text-sm sm:text-base leading-relaxed">
            اکثر تابلوهای روان و ماتریسی موجود در بازار از ماژول‌های موسوم به <strong>ماژول P10</strong> (تک‌رنگ قرمز، سبز یا ماژول‌های تمام‌رنگ RGB) ساخته می‌شوند. بررسی‌های میدانی صنف طلا نشان می‌دهد که بخش عمده خرابی این تابلوها ناشی از چهار عامل ساختاری زیر است:
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="flex items-center gap-2 text-stone-900 dark:text-stone-100 font-bold text-base">
                    @include('partials.ui-icon', ['name' => 'bolt', 'class' => 'w-5 h-5 text-amber-500'])
                    <span>سوختن و فرسایش منبع تغذیه (پاور سوپلای)</span>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    تابلوهای ال‌ای‌دی جریان بالایی در ولتاژ ۵ ولت مصرف می‌کنند. پاورهای سوئیچینگ ارزان‌قیمت در گرمای تابستان و کارکرد مداوم دچار افت ولتاژ، نوسان و در نهایت سوختگی ترانس می‌شوند که منجر به خاموشی کامل تابلو می‌گردد.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="flex items-center gap-2 text-stone-900 dark:text-stone-100 font-bold text-base">
                    @include('partials.ui-icon', ['name' => 'search', 'class' => 'w-5 h-5 text-amber-500'])
                    <span>سوختگی موضعی پیکسل‌ها و چیپ‌های درایور</span>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    آی‌سی‌های درایور خطوط در ماژول‌های LED به حرارت حساس هستند. سوختن یک چیپ کوچک باعث به وجود آمدن خطوط سیاه افقی یا عمودی در نمایش قیمت‌ها می‌شود و ارقام مظنه یا سکه را مخدوش می‌کند.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="flex items-center gap-2 text-stone-900 dark:text-stone-100 font-bold text-base">
                    @include('partials.ui-icon', ['name' => 'sun', 'class' => 'w-5 h-5 text-amber-500'])
                    <span>افت روشنایی و مشکل دید در روز</span>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    دیودهای ال‌ای‌دی پس از ۱۲ تا ۱۸ ماه کارکرد دچار افت نور می‌شوند. در محیط‌های پرنور بازار و پاساژ، این افت باعث می‌شود ارقام تنها در زاویه روبرو خوانا باشند و از زوایای کناری به صورت تار دیده شوند.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="flex items-center gap-2 text-stone-900 dark:text-stone-100 font-bold text-base">
                    @include('partials.ui-icon', ['name' => 'wrench', 'class' => 'w-5 h-5 text-amber-500'])
                    <span>دشواری و هزینه تعمیرات در محل</span>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    برای رفع کوچک‌ترین نقص فنی، طلافروش ناچار است کل سازه فلزی سنگین تابلو را از دیوار یا ویترین پیاده کرده و به کارگاه تعمیرات بفرستد؛ روندی که ویترین مغازه را برای روزها بدون نمایشگر نرخ باقی می‌گذارد.
                </p>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-xs sm:text-sm text-stone-800 dark:text-stone-200 leading-relaxed mt-4 flex items-center gap-2">
            @include('partials.ui-icon', ['name' => 'book-open', 'class' => 'w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0'])
            <span>
                <strong>راهنمای تفصیلی قیمت:</strong> برای بررسی کامل قیمت روز انواع ماژول‌ها و هزینه‌های جانبی ساخت تابلو، مقاله <a href="{{ route('public.guides.show', 'led-board-price-1405') }}" class="font-bold underline text-amber-600 dark:text-amber-400 hover:text-amber-500">قیمت تابلو ال ای دی طلافروشی در ۱۴۰۵ (راهنمای کامل)</a> را مطالعه فرمایید.
            </span>
        </div>
    </section>

    {{-- بخش ۲: جدول هزینه سه‌ساله مالکیت (TCO) --}}
    <section class="rounded-3xl p-6 sm:p-10 bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-6">
        <div class="text-center space-y-3 max-w-3xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">
                جدول مقایسه هزینه سه‌ساله مالکیت (TCO)
            </h2>
            <p class="text-stone-500 dark:text-stone-400 text-xs sm:text-sm leading-relaxed">
                مقایسه هزینه‌های واقعی خرید، نگهداری و مصرف انرژی در طول سه سال میان سه رویکرد متداول بازار طلا (تمامی مبالغ تقریبی و بر اساس میانگین برآوردهای بازار در شهریور ۱۴۰۵ است):
            </p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-stone-200 dark:border-stone-800 bg-white dark:bg-stone-900 shadow-sm">
            <table class="w-full text-right text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-stone-100 dark:bg-stone-850 text-stone-900 dark:text-stone-100 font-bold border-b border-stone-200 dark:border-stone-800">
                        <th class="p-4">آیتم هزینه (دوره ۳ ساله)</th>
                        <th class="p-4 text-red-600 dark:text-red-400">تابلوی فیزیکی LED (ماژولار)</th>
                        <th class="p-4 text-stone-700 dark:text-stone-300">مینی‌کیس کارکرده + کابل HDMI</th>
                        <th class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">سامانه ابری طلالایو روی تلویزیون</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 dark:divide-stone-800 text-stone-700 dark:text-stone-300">
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/60 transition-colors">
                        <td class="p-4 font-bold text-stone-900 dark:text-stone-100">هزینه اولیه خرید تجهیزات</td>
                        <td class="p-4 text-red-600 dark:text-red-400">حدود ۱۲ تا ۳۰ میلیون تومان (تقریبی)</td>
                        <td class="p-4">حدود ۷ تا ۱۵ میلیون تومان (تقریبی)</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">صفر تومان (استفاده از تلویزیون مغازه)</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/60 transition-colors">
                        <td class="p-4 font-bold text-stone-900 dark:text-stone-100">هزینه نصب، قاب‌بندی و کابل‌کشی</td>
                        <td class="p-4 text-red-600 dark:text-red-400">حدود ۲ تا ۵ میلیون تومان (تقریبی)</td>
                        <td class="p-4">حدود ۱ تا ۳ میلیون تومان (تقریبی)</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">صفر تومان (راه‌اندازی فوری توسط کاربر)</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/60 transition-colors">
                        <td class="p-4 font-bold text-stone-900 dark:text-stone-100">مصرف برق ۳ ساله (تخمینی)</td>
                        <td class="p-4 text-red-600 dark:text-red-400">بالا (مصرف پیوسته ماژول‌های پرتوان)</td>
                        <td class="p-4">متوسط (مصرف کیس و مینی‌پی‌سی)</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">بهینه (منطبق با رده انرژی تلویزیون)</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/60 transition-colors">
                        <td class="p-4 font-bold text-stone-900 dark:text-stone-100">استهلاک و تعمیرات ۳ ساله</td>
                        <td class="p-4 text-red-600 dark:text-red-400">حدود ۳ تا ۸ میلیون تومان (تعویض ماژول یا پاور)</td>
                        <td class="p-4">حدود ۲ تا ۶ میلیون تومان (فن، هارد، ویندوز)</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">صفر تومان (عدم استهلاک سخت‌افزار اختصاصی)</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/60 transition-colors">
                        <td class="p-4 font-bold text-stone-900 dark:text-stone-100">هزینه ارتقا و تغییرات نمادها</td>
                        <td class="p-4 text-red-600 dark:text-red-400">مستلزم تغییر برد یا ارسال به سازنده</td>
                        <td class="p-4">نیازمند حضور پشتیبان یا آپدیت دستی</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">رایگان و خودکار از طریق سرور ابری</td>
                    </tr>
                    <tr class="bg-stone-50 dark:bg-stone-850 font-bold text-stone-900 dark:text-stone-100">
                        <td class="p-4">جمع برآورد هزینه ۳ ساله (تقریبی)</td>
                        <td class="p-4 text-red-600 dark:text-red-400">حدود ۱۸ تا ۴۵ میلیون تومان (تقریبی)</td>
                        <td class="p-4">حدود ۱۰ تا ۲۵ میلیون تومان (تقریبی)</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 bg-amber-500/10">فقط بهای اشتراک نرم‌افزار</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-xs text-stone-500 dark:text-stone-400 text-center">
            * تاریخ آخرین بازبینی داده‌ها: شهریور ۱۴۰۵. کلیه اعداد و هزینه‌های سخت‌افزاری بر پایه میانگین برآوردهای بازار الکترونیک و تابلوسازان تهیه شده و تقریبی می‌باشند.
        </p>
    </section>

    {{-- بنر فراخوان میانی --}}
    @include('partials.cta-inline', [
        'title' => 'بدون خرید قطعات مستهلک، تابلوی ویترین خود را نو کنید',
        'subtitle' => 'تنها با باز کردن یک پیوند در مرورگر تلویزیون، با تابلوهای پرمصرف و داغ قدیمی خداحافظی کنید. ۱۴ روز تست رایگان بدون نیاز به کارت بانکی.',
        'buttonText' => 'تست رایگان روی تلویزیون مغازه',
        'buttonUrl' => route('admin.register'),
        'secondaryText' => 'راهنمای راه‌اندازی تلویزیون',
        'secondaryUrl' => route('public.tv-setup-guide'),
    ])

    {{-- بخش ۳: مقایسه رودرروی قابلیت‌های نمایشگر --}}
    <section class="space-y-6">
        <div class="text-center space-y-3">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">
                مقایسه کیفی و کاربردی تابلوی سنتی در برابر سامانه ابری طلالایو
            </h2>
            <p class="text-stone-500 dark:text-stone-400 text-xs sm:text-sm">ویژگی‌هایی که دکوراسیون و ارزش برند گالری شما را ارتقا می‌دهد</p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-stone-200 dark:border-stone-800 bg-white dark:bg-stone-900 shadow-sm">
            <table class="w-full text-right text-xs sm:text-sm border-collapse">
                <thead class="bg-stone-100 dark:bg-stone-850 text-stone-900 dark:text-stone-100 font-bold border-b border-stone-200 dark:border-stone-800">
                    <tr>
                        <th class="p-4 sm:p-5">معیار ارزیابی</th>
                        <th class="p-4 sm:p-5 text-red-600 dark:text-red-400">تابلوهای سنتی LED</th>
                        <th class="p-4 sm:p-5 text-amber-600 dark:text-amber-400">سامانه هوشمند طلالایو (روی تلویزیون)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 dark:divide-stone-800 text-stone-700 dark:text-stone-300">
                    <tr class="hover:bg-stone-50/50 dark:hover:bg-stone-850/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">کیفیت و رزولوشن تصویر</td>
                        <td class="p-4 sm:p-5 text-red-600 dark:text-red-400">رزولوشن پایین ماتریسی (پیکسل‌های زبر P10)</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">کیفیت 4K و Full HD با رنگ‌های دقیق و فونت فارسی خوانا</td>
                    </tr>
                    <tr class="hover:bg-stone-50/50 dark:hover:bg-stone-850/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">پخش عکس و اسلاید محصولات ویترین</td>
                        <td class="p-4 sm:p-5 text-stone-400">غیرممکن (فقط کاراکتر و ارقام تک‌رنگ)</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">اسلایدر تصاویر النگو، سرویس و نیم‌ست مغازه</td>
                    </tr>
                    <tr class="hover:bg-stone-50/50 dark:hover:bg-stone-850/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">افزودن نرخ‌های جدید (انس، نقره، مسکوکات)</td>
                        <td class="p-4 sm:p-5 text-red-600 dark:text-red-400">نیازمند تعویض فیزیکی برچسب یا برد</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">فعال‌سازی لحظه‌ای با یک کلیک از پنل مدیریت گوشی</td>
                    </tr>
                    <tr class="hover:bg-stone-50/50 dark:hover:bg-stone-850/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">فرمول‌ساز سود و مالیات اختصاصی</td>
                        <td class="p-4 sm:p-5 text-stone-400">بسیار محدود یا فاقد فرمول‌ساز</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">فرمول‌ساز خودکار سود، درصد اجرت، کسر افت و حباب سکه</td>
                    </tr>
                    <tr class="hover:bg-stone-50/50 dark:hover:bg-stone-850/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">امکان تست قبل از خرید</td>
                        <td class="p-4 sm:p-5 text-red-600 dark:text-red-400">وجود ندارد (پرداخت کامل وجه قبل از تحویل)</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">۱۴ روز تست کاملاً رایگان بدون پیش‌پرداخت</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- بخش ۴: پرسش‌های متداول --}}
    <section class="space-y-6 max-w-4xl mx-auto">
        <div class="text-center space-y-3">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">
                پاسخ به سؤالات پرتکرار طلافروشان درباره جایگزینی تابلو
            </h2>
            <p class="text-stone-500 dark:text-stone-400 text-xs sm:text-sm">پاسخ‌های شفاف و فنی به پرسش‌های رایج همکاران صنف</p>
        </div>

        <div class="space-y-3">
            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>آیا تلویزیون مغازه با روشن ماندن مداوم خراب یا داغ نمی‌شود؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    سامانه طلالایو به طور اختصاصی با کدهای بهینه توسعه یافته است. پردازش‌ها بهینه بوده و مصرف پردازنده در حداقل ممکن قرار دارد. همچنین تکنیک‌های محافظتی حرکت نرم تصویر مانع از ایجاد سایه یا ماندگاری تصویر روی پنل تلویزیون می‌شود.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>در صورت قطع موقت اینترنت در مغازه چه اتفاقی می‌افتد؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    طلالایو مجهز به سیستم کش محلی آفلاین است. در صورت قطع موقت اینترنت، آخرین قیمت‌های معتبر ثبت‌شده بدون افتادن صفحه روی تلویزیون باقی می‌ماند و به محض اتصال مجدد، ارقام خودکار همگام‌سازی می‌شوند.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>آیا برای کار با طلالایو به کامپیوتر یا مینی‌کیس نیاز داریم؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    خیر. بزرگ‌ترین مزیت طلالایو حذف صد درصدی کیس، مینی‌استوک و کابل‌کشی است. همه تنظیمات از طریق تلفن همراه شما انجام می‌شود و تلویزیون مغازه مستقیماً صفحه تابلو را پخش می‌کند.
                </div>
            </details>
        </div>
    </section>

    {{-- بخش بررسی و مقایسه با سایر سامانه‌های نرم‌افزاری --}}
    <section class="space-y-6">
        <div class="text-center space-y-3">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">
                بررسی و مقایسه طلالایو با سایر نرم‌افزارهای تابلوی طلا
            </h2>
            <p class="text-stone-500 dark:text-stone-400 text-xs sm:text-sm">
                اگر قصد مقایسه نرم‌افزارهای نمایش نرخ طلا روی تلویزیون را دارید، مقایسه‌های تخصصی ما را مطالعه فرمایید:
            </p>
        </div>

        <div class="grid sm:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-3 hover:border-amber-500/50 transition-colors">
                <span class="text-xs text-amber-600 dark:text-amber-400 font-bold">بررسی سخت‌افزاری و نرم‌افزاری</span>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">مقایسه با تابان گوهر</h3>
                <p class="text-xs text-stone-500 dark:text-stone-400 leading-relaxed">
                    بررسی نیاز به مینی‌کیس، کابل‌کشی و مقایسه هزینه راه‌اندازی و انعطاف تحت وب سامانه طلالایو در برابر تابان گوهر.
                </p>
                <div class="pt-2">
                    <a href="{{ route('public.compare.tabangohar') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5">
                        <span>مطالعه مقایسه تابان گوهر</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </a>
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-3 hover:border-amber-500/50 transition-colors">
                <span class="text-xs text-amber-600 dark:text-amber-400 font-bold">سامانه صنفی در برابر وب‌سایت</span>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">مقایسه با TGJU TV</h3>
                <p class="text-xs text-stone-500 dark:text-stone-400 leading-relaxed">
                    چرا سامانه نمایش رایگان TGJU برای ویترین صنفی طلا طراحی نشده و تفاوت فرمول‌های محاسباتی سود و نرخ‌ها در چیست؟
                </p>
                <div class="pt-2">
                    <a href="{{ route('public.compare.tgju-tv') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5">
                        <span>مطالعه مقایسه TGJU TV</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </a>
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-3 hover:border-amber-500/50 transition-colors">
                <span class="text-xs text-amber-600 dark:text-amber-400 font-bold">معماری ابری در برابر اپلیکیشن</span>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">مقایسه با تابلوی نرخ طلا</h3>
                <p class="text-xs text-stone-500 dark:text-stone-400 leading-relaxed">
                    مقایسه پایداری و عدم نیاز به آپدیت دستی در سامانه ابری طلالایو نسبت به نرم‌افزارهای نصبی اندروید بازار.
                </p>
                <div class="pt-2">
                    <a href="{{ route('public.compare.tablotala') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5">
                        <span>مطالعه مقایسه تابلوی نرخ طلا</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- بخش مطالب و ابزارهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'مطالب و راهنماهای مرتبط با تابلو و تجهیزات طلافروشی',
        'links' => [
            [
                'title' => 'قیمت تابلو ال ای دی طلافروشی در ۱۴۰۵',
                'desc' => 'راهنمای تحلیل قیمت انواع ماژول‌های تک‌رنگ و چندرنگ و هزینه‌های جانبی ساخت تابلو.',
                'url' => route('public.guides.show', 'led-board-price-1405'),
            ],
            [
                'title' => 'تابلوی هوشمند طلافروشی',
                'desc' => 'امکانات تابلوی ابری طلالایو برای مدیریت ویترین طلافروشی روی تلویزیون.',
                'url' => route('public.smart-gold-board'),
            ],
            [
                'title' => 'تعرفه‌های اشتراک سالیانه',
                'desc' => 'مشاهده قیمت‌های شفاف و مقایسه پلن‌های اشتراک نرم‌افزار طلالایو.',
                'url' => route('public.pricing'),
            ],
        ]
    ])

    {{-- بنر نهایی اقدام به عمل (CTA) --}}
    <div class="rounded-3xl bg-amber-500 text-stone-950 p-8 sm:p-12 text-center space-y-6 shadow-sm">
        <h2 class="text-2xl sm:text-4xl font-black">
            ویترین گالری خود را با تابلوی دیجیتال طلالایو نوسازی کنید
        </h2>
        <p class="text-stone-900 font-medium text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
            ۱۴ روز استفاده آزمایشی رایگان، بدون نیاز به کارت بانکی، راه‌اندازی فوری در کمتر از ۳ دقیقه روی تلویزیون مغازه.
        </p>
        <div class="pt-2">
            <a href="{{ route('admin.register') }}" class="inline-flex items-center justify-center gap-2 min-h-11 px-8 py-3.5 rounded-xl bg-stone-950 text-amber-400 hover:bg-stone-900 font-bold text-sm shadow-sm transition-colors cursor-pointer">
                <span>شروع تست رایگان ۱۴ روزه</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4 text-amber-400'])
            </a>
        </div>
    </div>

</div>
@endsection
