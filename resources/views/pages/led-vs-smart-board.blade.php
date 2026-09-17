@extends('layouts.public')

@section('title', 'تابلو ال ای دی طلا فروشی بخریم یا تلویزیون؟ مقایسه جامع | طلالایو')
@section('meta_description', 'مقایسه قیمت تابلو ال ای دی طلا فروشی (حدود ۸ تا ۳۰ میلیون تومان بر متر مربع) با تابلوی تلویزیونی طلالایو. همین حالا با تست ۱۴ روزه رایگان هوشمند شوید.')
@section('canonical', 'https://talalive.ir/led-vs-smart-board')

@section('schema')
    {{-- اسکیمای استاندارد Service طلالایو بدون ریتینگ --}}
    @include('partials.schema-service', [
        'name' => 'سامانه تابلوی هوشمند طلالایو — جایگزین تابلو ال ای دی طلا فروشی',
        'serviceType' => 'سامانه ابری نمایش آنلاین نرخ طلا و مسکوکات روی تلویزیون مغازه',
        'description' => 'جایگزین مدرن و ابری تابلوهای فیزیکی LED با قابلیت نمایش زنده نرخ طلا، سکه، تتر و ویترین عکس جواهرات روی تلویزیون مغازه بدون مینی‌کیس.',
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
            "text": "با باز کردن مرورگر اینترنت تلویزیون هوشمند یا اتصال یک اندروید باکس ارزان‌قیمت به پورت HDMI تلویزیون، در کمتر از ۳ دقیقه می‌توانید تابلوی آنلاین طلالایو را فعال نمایید."
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
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
            <span>بررسی فنی و مقایسه اقتصادی ویژه صنف طلا و جواهر (ویرایش ۱۴۰۵)</span>
        </div>
        
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white leading-tight">
            تابلو ال ای دی طلا فروشی بخریم یا <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 via-amber-400 to-yellow-500">
                تلویزیون مغازه را به تابلوی اعلام قیمت تبدیل کنیم؟
            </span>
        </h1>

        <p class="text-slate-600 dark:text-slate-300 text-base sm:text-lg leading-relaxed max-w-3xl mx-auto">
            آیا پرداخت هزینه‌های سنگین (برآورد تقریبی حدود ۸ تا ۳۰ میلیون تومان در هر متر مربع بسته به نوع ماژول) برای خرید <strong>تابلو ال ای دی طلا فروشی</strong> و جعبه‌های فلزی سنتی توجیه اقتصادی دارد؟ در این راهنما تفاوت‌های فنی، دوام قطعات و هزینه سه‌ساله مالکیت تابلوهای سخت‌افزاری را در برابر فناوری نوین تابلوی ابری <strong>طلالایو</strong> مقایسه می‌کنیم.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a href="{{ route('admin.register') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/25 transition-all hover:scale-105 cursor-pointer">
                تست ۱۴ روزه رایگان بدون دستگاه
            </a>
            <a href="{{ route('public.smart-gold-board') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-white font-bold text-sm transition-all shadow-sm cursor-pointer">
                امکانات تابلوی ابری طلالایو
            </a>
        </div>
    </header>

    {{-- بخش ۱: چرا تابلوهای LED خراب می‌شوند؟ --}}
    <section class="glass-panel rounded-3xl p-8 sm:p-12 border border-slate-200 dark:border-slate-800 space-y-6">
        <div class="flex items-center gap-3">
            <div class="w-2.5 h-7 rounded-full bg-rose-500"></div>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                چرا تابلوهای LED طلافروشی مدام خراب می‌شوند؟ کالبدشکافی فنی
            </h2>
        </div>
        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed">
            اکثر تابلوهای روان و ماتریسی موجود در بازار از ماژول‌های چینی موسوم به <strong>ماژول P10</strong> (تک‌رنگ قرمز، سبز یا ماژول‌های فول‌کالر RGB) ساخته می‌شوند. بررسی‌های میدانی صنف طلا نشان می‌دهد که بیش از ۸۰٪ خرابی این تابلوها ناشی از چهار عامل ساختاری زیر است:
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 space-y-3">
                <div class="text-rose-500 font-black text-lg">⚡ سوختن و فرسایش منبع تغذیه (پاور سوپلای)</div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    تابلوهای ال‌ای‌دی جریان بالایی در ولتاژ ۵ ولت مصرف می‌کنند. پاورهای سوئیچینگ ارزان‌قیمت در گرمای تابستان و کارکرد مداوم دچار افت ولتاژ، نوسان و در نهایت سوختگی ترانس می‌شوند که منجر به خاموشی کامل تابلو می‌گردد.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 space-y-3">
                <div class="text-rose-500 font-black text-lg">🔍 سوختگی موضعی پیکسل‌ها و چیپ‌های درایور</div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    آی‌سی‌های درایور خطوط در ماژول‌های LED به حرارت حساس هستند. سوختن یک چیپ کوچک باعث به وجود آمدن خطوط سیاه افقی یا عمودی در نمایش قیمت‌ها می‌شود و ارقام مظنه یا سکه را مخدوش می‌کند.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 space-y-3">
                <div class="text-rose-500 font-black text-lg">☀️ افت روشنایی و مشکل روز دید / سایه دید</div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    دیودهای ال‌ای‌دی پس از ۱۲ تا ۱۸ ماه کارکرد دچار افت نور (Lumen Depreciation) می‌شوند. در محیط‌های پرنور بازار و پاساژ، این افت باعث می‌شود ارقام تنها در زاویه روبرو خوانا باشند و از زوایای کناری به صورت تار یا سایه‌دار دیده شوند.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 space-y-3">
                <div class="text-rose-500 font-black text-lg">🛠️ دشواری و هزینه تعمیرات در محل</div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    برای رفع کوچک‌ترین نقص فنی، طلافروش ناچار است کل سازه فلزی سنگین تابلو را از دیوار یا ویترین پیاده کرده و به کارگاه تعمیرات بفرستد؛ روندی که ویترین مغازه را برای روزها بدون نمایشگر نرخ باقی می‌گذارد.
                </p>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-xs sm:text-sm text-amber-800 dark:text-amber-300 leading-relaxed mt-4">
            📌 <strong>راهنمای تفصیلی قیمت:</strong> برای بررسی کامل قیمت روز انواع ماژول‌ها و هزینه‌های جانبی ساخت تابلو، مقاله <a href="{{ route('public.guides.show', 'led-board-price-1405') }}" class="font-bold underline hover:text-amber-500">قیمت تابلو ال ای دی طلافروشی در ۱۴۰۵ — راهنمای کامل</a> را مطالعه فرمایید.
        </div>
    </section>

    {{-- بخش ۲: جدول هزینه سه‌ساله مالکیت (TCO) --}}
    <section class="glass-panel rounded-3xl p-8 sm:p-12 border border-slate-200 dark:border-slate-800 space-y-6">
        <div class="text-center space-y-3 max-w-3xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                جدول مقایسه هزینه سه‌ساله مالکیت (TCO)
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                مقایسه هزینه‌های واقعی خرید، نگهداری و مصرف انرژی در طول سه سال میان سه رویکرد متداول بازار طلا (تمامی مبالغ تقریبی و بر اساس میانگین برآوردهای بازار در شهریور ۱۴۰۵ است):
            </p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xl">
            <table class="w-full text-right text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-black border-b border-slate-200 dark:border-slate-700">
                        <th class="p-4">آیتم هزینه (دوره ۳ ساله)</th>
                        <th class="p-4 text-rose-600 dark:text-rose-400">تابلوی فیزیکی LED (ماژولار)</th>
                        <th class="p-4 text-slate-700 dark:text-slate-300">مینی‌کیس استوک + کابل HDMI</th>
                        <th class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">سامانه ابری طلالایو روی تلویزیون</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-850/60 transition-colors">
                        <td class="p-4 font-bold">هزینه اولیه خرید تجهیزات</td>
                        <td class="p-4 text-rose-500">حدود ۱۲ تا ۳۰ میلیون تومان (تقریبی)</td>
                        <td class="p-4">حدود ۷ تا ۱۵ میلیون تومان (تقریبی)</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">صفر تومان (استفاده از تلویزیون مغازه)</td>
                    </tr>
                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-850/60 transition-colors">
                        <td class="p-4 font-bold">هزینه نصب، قاب‌بندی و کابل‌کشی</td>
                        <td class="p-4 text-rose-500">حدود ۲ تا ۵ میلیون تومان (تقریبی)</td>
                        <td class="p-4">حدود ۱ تا ۳ میلیون تومان (تقریبی)</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">صفر تومان (راه‌اندازی فوری توسط کاربر)</td>
                    </tr>
                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-850/60 transition-colors">
                        <td class="p-4 font-bold">مصرف برق ۳ ساله (تخمینی)</td>
                        <td class="p-4 text-rose-500">بالا (مصرف پیوسته ماژول‌های پرتوان)</td>
                        <td class="p-4">متوسط (مصرف کیس و مینی‌پی‌سی)</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">بسیار بهینه (منطبق با رده انرژی تلویزیون)</td>
                    </tr>
                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-850/60 transition-colors">
                        <td class="p-4 font-bold">استهلاک و تعمیرات ۳ ساله</td>
                        <td class="p-4 text-rose-500">حدود ۳ تا ۸ میلیون تومان (تعویض ماژول/پاور)</td>
                        <td class="p-4">حدود ۲ تا ۶ میلیون تومان (فن، هارد، ویندوز)</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">صفر تومان (عدم استهلاک سخت‌افزار اختصاصی)</td>
                    </tr>
                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-850/60 transition-colors">
                        <td class="p-4 font-bold">هزینه ارتقا و تغییرات نمادها</td>
                        <td class="p-4 text-rose-500">مستلزم تغییر برد یا ارسال به سازنده</td>
                        <td class="p-4">نیازمند حضور پشتیبان یا آپدیت دستی</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold bg-amber-500/5">رایگان و خودکار از طریق سرور ابری</td>
                    </tr>
                    <tr class="bg-slate-50 dark:bg-slate-800/80 font-black text-slate-900 dark:text-white">
                        <td class="p-4">جمع برآورد هزینه ۳ ساله (تقریبی)</td>
                        <td class="p-4 text-rose-600 dark:text-rose-400">حدود ۱۸ تا ۴۵ میلیون تومان (تقریبی)</td>
                        <td class="p-4">حدود ۱۰ تا ۲۵ میلیون تومان (تقریبی)</td>
                        <td class="p-4 text-emerald-600 dark:text-emerald-400 bg-amber-500/10">فقط بهای ناچیز اشتراک نرم‌افزار</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-[11px] text-slate-500 dark:text-slate-400 text-center">
            * تاریخ آخرین بازبینی داده‌ها: شهریور ۱۴۰۵. کلیه اعداد و هزینه‌های سخت‌افزاری بر پایه میانگین مظنه بازار الکترونیک و تابلو‌سازان تهیه شده و تقریبی می‌باشند.
        </p>
    </section>

    {{-- بنر فراخوان میانی --}}
    @include('partials.cta-inline', [
        'title' => 'بدون خرید قطعات مستهلک، تابلوی ویترین خود را نو کنید',
        'subtitle' => 'تنها با باز کردن یک لینک در مرورگر تلویزیون، با تابلوهای پرمصرف و داغ قدیمی خداحافظی کنید. ۱۴ روز تست رایگان بدون نیاز به کارت بانکی.',
        'buttonText' => 'تست رایگان روی تلویزیون مغازه',
        'buttonUrl' => route('admin.register'),
        'secondaryText' => 'راهنمای راه‌اندازی تلویزیون',
        'secondaryUrl' => route('public.tv-setup-guide'),
    ])

    {{-- بخش ۳: مقایسه رودرروی قابلیت‌های نمایشگر --}}
    <section class="space-y-6">
        <div class="text-center space-y-3">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                مقایسه کیفی و کاربردی تابلوی سنتی در برابر سامانه ابری طلالایو
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">ویژگی‌هایی که دکوراسیون و ارزش برند گالری شما را ارتقا می‌دهد</p>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xl">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800/80 text-slate-900 dark:text-white font-black border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="p-4 sm:p-6">معیار ارزیابی</th>
                        <th class="p-4 sm:p-6 text-rose-500">تابلوهای سنتی LED</th>
                        <th class="p-4 sm:p-6 text-amber-500">سامانه هوشمند طلالایو (روی تلویزیون)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-slate-700 dark:text-slate-300">
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-6 font-bold">کیفیت و رزولوشن تصویر</td>
                        <td class="p-4 sm:p-6 text-rose-400">رزولوشن پایین ماتریسی (پیکسل‌های زبر P10)</td>
                        <td class="p-4 sm:p-6 text-emerald-500 font-bold">کیفیت 4K / Full HD با رنگ‌های زنده و فونت اصیل</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-6 font-bold">پخش عکس و اسلاید محصولات ویترین</td>
                        <td class="p-4 sm:p-6 text-slate-400">غیرممکن (فقط کاراکتر و ارقام تک‌رنگ)</td>
                        <td class="p-4 sm:p-6 text-emerald-500 font-bold">اسلایدر تصاویر باکیفیت النگو، سرویس و نیم‌ست مغازه</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-6 font-bold">افزودن نرخ‌های جدید (انس، نقره، مسکوکات)</td>
                        <td class="p-4 sm:p-6 text-rose-400">نیازمند تعویض فیزیکی استیکر یا برد</td>
                        <td class="p-4 sm:p-6 text-emerald-500 font-bold">فعال‌سازی لحظه‌ای با یک کلیک از پنل مدیریت گوشی</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-6 font-bold">فرمول‌ساز سود و مالیات اختصاصی</td>
                        <td class="p-4 sm:p-6 text-slate-400">بسیار محدود یا فاقد فرمول‌ساز</td>
                        <td class="p-4 sm:p-6 text-emerald-500 font-bold">فرمول‌ساز خودکار سود ۷٪، درصد اجرت، کسر افت و حباب سکه</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-6 font-bold">امکان تست قبل از خرید</td>
                        <td class="p-4 sm:p-6 text-rose-400">وجود ندارد (پرداخت کامل وجه قبل از تحویل)</td>
                        <td class="p-4 sm:p-6 text-emerald-500 font-bold">۱۴ روز تست کاملاً رایگان بدون پیش‌پرداخت</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- بخش ۴: پرسش‌های متداول --}}
    <section class="space-y-6 max-w-4xl mx-auto">
        <div class="text-center space-y-3">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                پاسخ به سؤالات پرتکرار طلافروشان درباره جایگزینی تابلو
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">پاسخ‌های شفاف و فنی به پرسش‌های رایج همکاران صنف</p>
        </div>

        <div class="space-y-4" x-data="{ open: null }">
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between text-right font-bold text-slate-900 dark:text-white cursor-pointer">
                    <span>آیا تلویزیون مغازه با روشن ماندن مداوم خراب یا داغ نمی‌شود؟</span>
                    <span class="text-amber-500 text-xl" x-text="open === 1 ? '−' : '+'"></span>
                </button>
                <div x-show="open === 1" x-collapse class="pt-4 text-slate-600 dark:text-slate-300 text-sm leading-relaxed border-t border-slate-100 dark:border-slate-800 mt-4">
                    سامانه طلالایو به طور اختصاصی با کدهای سبک توسعه یافته است. پردازش‌ها بهینه بوده و مصرف پردازنده در حداقل ممکن قرار دارد. همچنین تکنیک‌های محافظتی چرخش پیکسل مانع از سوختگی یا ماندگاری تصویر روی پنل تلویزیون می‌شود.
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between text-right font-bold text-slate-900 dark:text-white cursor-pointer">
                    <span>در صورت قطع موقت اینترنت در مغازه چه اتفاقی می‌افتد؟</span>
                    <span class="text-amber-500 text-xl" x-text="open === 2 ? '−' : '+'"></span>
                </button>
                <div x-show="open === 2" x-collapse class="pt-4 text-slate-600 dark:text-slate-300 text-sm leading-relaxed border-t border-slate-100 dark:border-slate-800 mt-4">
                    طلالایو مجهز به سیستم کش محلی آفلاین است. در صورت قطع موقت اینترنت، آخرین قیمت‌های معتبر ثبت‌شده بدون افتادن صفحه روی تلویزیون باقی می‌ماند و به محض اتصال مجدد، ارقام خودکار همگام‌سازی می‌شوند.
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between text-right font-bold text-slate-900 dark:text-white cursor-pointer">
                    <span>آیا برای کار با طلالایو به کامپیوتر یا مینی‌کیس نیاز داریم؟</span>
                    <span class="text-amber-500 text-xl" x-text="open === 3 ? '−' : '+'"></span>
                </button>
                <div x-show="open === 3" x-collapse class="pt-4 text-slate-600 dark:text-slate-300 text-sm leading-relaxed border-t border-slate-100 dark:border-slate-800 mt-4">
                    خیر. بزرگ‌ترین مزیت طلالایو حذف صد درصدی کیس، مینی‌استوک و کابل‌کشی است. همه تنظیمات از طریق تلفن همراه شما انجام می‌شود و تلویزیون مغازه مستقیماً صفحه تابلو را پخش می‌کند.
                </div>
            </div>
        </div>
    </section>

    {{-- بخش بررسی و مقایسه با سایر سامانه‌های نرم‌افزاری --}}
    <section class="space-y-6">
        <div class="text-center space-y-3">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                بررسی و مقایسه طلالایو با سایر نرم‌افزارهای تابلوی طلا
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">
                اگر قصد مقایسه نرم‌افزارهای نمایش نرخ طلا روی تلویزیون را دارید، مقایسه‌های تخصصی ما را مطالعه فرمایید:
            </p>
        </div>

        <div class="grid sm:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 hover:border-amber-500/50 transition-all">
                <span class="text-xs text-amber-500 font-bold">بررسی سخت‌افزاری و نرم‌افزاری</span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">مقایسه با تابان گوهر</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    بررسی نیاز به مینی‌کیس، کابل‌کشی و مقایسه هزینه راه‌اندازی و انعطاف تحت وب سامانه طلالایو در برابر تابان گوهر.
                </p>
                <div class="pt-2">
                    <a href="{{ route('public.compare.tabangohar') }}" class="text-xs font-bold text-amber-500 hover:text-amber-600 inline-flex items-center gap-1">
                        <span>مطالعه مقایسه تابان گوهر</span>
                        <span>←</span>
                    </a>
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 hover:border-amber-500/50 transition-all">
                <span class="text-xs text-amber-500 font-bold">سامانه صنفی در برابر وب‌سایت</span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">مقایسه با TGJU TV</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    چرا سامانه نمایش رایگان TGJU برای ویترین صنفی طلا طراحی نشده و تفاوت فرمول‌های محاسباتی سود و نرخ‌ها در چیست؟
                </p>
                <div class="pt-2">
                    <a href="{{ route('public.compare.tgju-tv') }}" class="text-xs font-bold text-amber-500 hover:text-amber-600 inline-flex items-center gap-1">
                        <span>مطالعه مقایسه TGJU TV</span>
                        <span>←</span>
                    </a>
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 hover:border-amber-500/50 transition-all">
                <span class="text-xs text-amber-500 font-bold">معماری ابری در برابر اپلیکیشن</span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">مقایسه با تابلوی نرخ طلا</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    مقایسه پایداری و عدم نیاز به آپدیت دستی در سامانه ابری طلالایو نسبت به نرم‌افزارهای نصبی اندروید بازار.
                </p>
                <div class="pt-2">
                    <a href="{{ route('public.compare.tablotala') }}" class="text-xs font-bold text-amber-500 hover:text-amber-600 inline-flex items-center gap-1">
                        <span>مطالعه مقایسه تابلوی نرخ طلا</span>
                        <span>←</span>
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
                'desc' => 'راهنمای کامل تحلیل قیمت انواع ماژول‌های تک‌رنگ و فول‌کالر و هزینه‌های جانبی ساخت تابلو.',
                'url' => route('public.guides.show', 'led-board-price-1405'),
            ],
            [
                'title' => 'تابلوی هوشمند طلافروشی',
                'desc' => 'بررسی جامع امکانات تابلوی ابری طلالایو برای مدیریت هوشمند ویترین طلافروشی.',
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
    <div class="rounded-3xl bg-gradient-to-r from-amber-500 via-amber-600 to-yellow-600 p-8 sm:p-12 text-center text-slate-950 space-y-6 shadow-2xl shadow-amber-500/20">
        <h2 class="text-2xl sm:text-4xl font-black">
            همین امروز ویترین گالری خود را مدرن و تماشایی کنید
        </h2>
        <p class="text-slate-900 font-medium text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
            ۱۴ روز استفاده آزمایشی رایگان، بدون نیاز به کارت بانکی، راه‌اندازی فوری در کمتر از ۳ دقیقه روی تلویزیون مغازه.
        </p>
        <div class="pt-2">
            <a href="{{ route('admin.register') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-slate-950 text-amber-400 hover:bg-slate-900 font-black text-sm shadow-xl transition-all hover:scale-105 cursor-pointer">
                <span>شروع تست رایگان ۱۴ روزه</span>
                <span>←</span>
            </a>
        </div>
    </div>

</div>
@endsection
