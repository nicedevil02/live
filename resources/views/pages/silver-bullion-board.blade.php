@extends('layouts.public')

@section('title', 'تابلو نرخ نقره و شمش: گرم ۹۹۹، ۹۹۵ و ۹۲۵ | طلالایو')
@section('meta_description', 'تابلوی تخصصی نرخ انواع شمش طلا و نقره ساچمه و گرم‌های ۹۹۹، ۹۹۵ و ۹۲۵ با تفکیک خرید و فروش لحظه‌ای روی تلویزیون در سال ۱۴۰۵. همین حالا رایگان تست کنید.')
@section('canonical', 'https://talalive.ir/silver-bullion-board')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "Service",
      "name": "تابلو نرخ نقره و شمش طلا طلالایو",
      "serviceType": "سامانه ابری نمایشگر نرخ نقره ساچمه، شمش طلا و نقره",
      "provider": {
        "@@type": "Organization",
        "name": "طلالایو",
        "url": "https://talalive.ir"
      },
      "areaServed": {
        "@@type": "Country",
        "name": "ایران"
      },
      "description": "نرم‌افزار ابری نمایشگر زنده نرخ خرید و فروش انواع شمش طلا، شمش نقره، ساچمه نقره ۹۹۹، ۹۹۵ و عیار ۹۲۵ استرلینگ روی تلویزیون کارگاه‌ها و فروشگاه‌ها.",
      "hasOfferCatalog": {
        "@@type": "OfferCatalog",
        "name": "پلن‌های نمایشگر نقره و شمش",
        "itemListElement": [
          {
            "@@type": "Offer",
            "name": "تست رایگان ۱۴ روزه تابلو نقره و شمش",
            "price": "0",
            "priceCurrency": "IRR"
          }
        ]
      }
    },
    {
      "@@type": "BreadcrumbList",
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
          "name": "تابلو نرخ نقره و شمش",
          "item": "https://talalive.ir/silver-bullion-board"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16 sm:space-y-20">

    {{-- هیرو سکشن لندینگ نقره و شمش --}}
    <header class="text-center space-y-6 max-w-4xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 dark:bg-amber-500/15 border border-amber-500/30 text-amber-900 dark:text-amber-300 text-xs font-semibold">
            <span class="px-2 py-0.5 rounded-full bg-amber-500 text-stone-950 font-bold text-[11px]">به‌زودی</span>
            <span>ویژه فروشندگان نقره، کارگاه‌های ریخته‌گری و معامله‌گران شمش (در حال آماده‌سازی)</span>
        </div>
        
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-stone-900 dark:text-stone-100 leading-tight">
            تابلو نرخ نقره و شمش طلا؛ <br>
            <span class="text-amber-600 dark:text-amber-400">
                نمایشگر زنده عیارهای ۹۹۹، ۹۹۵ و ۹۲۵ روی تلویزیون
            </span>
        </h1>

        <p class="text-stone-600 dark:text-stone-300 text-sm sm:text-base leading-relaxed max-w-3xl mx-auto bg-stone-50 dark:bg-stone-900 p-5 rounded-2xl border border-stone-200 dark:border-stone-800 text-justify sm:text-center">
            <strong>تابلو نرخ نقره و شمش</strong> سامانه‌ای تخصصی و ابری برای نمایش زنده قیمت شمش طلا، ساچمه نقره خام، گرم‌های ۹۹۹، ۹۹۵ و عیار ۹۲۵ روی تلویزیون فروشگاه‌ها است که جایگزین تابلوهای سنتی شده و بدون نیاز به سخت‌افزار کار می‌کند.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
            <a href="{{ route('admin.register') }}" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm shadow-sm transition-colors inline-flex items-center justify-center">
                تست ۱۴ روزه رایگان تابلو نقره و شمش
            </a>
            <a href="{{ route('public.tv-setup-guide') }}" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl bg-white dark:bg-stone-900 border border-stone-300 dark:border-stone-700 hover:bg-stone-50 dark:hover:bg-stone-850 text-stone-800 dark:text-stone-200 font-bold text-sm transition-colors shadow-sm inline-flex items-center justify-center">
                راهنمای اتصال تلویزیون مغازه
            </a>
        </div>
    </header>

    {{-- جدول عیارهای نقره و شمش‌های استاندارد --}}
    <section class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-3xl p-6 sm:p-10 shadow-sm space-y-6">
        <div class="space-y-2">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-2">
                <span class="w-2.5 h-6 rounded-full bg-amber-500"></span>
                <span>جدول ردیف‌های تخصصی شمش و نقره خام در تابلوی طلالایو</span>
            </h2>
            <p class="text-xs sm:text-sm text-stone-500 dark:text-stone-400">
                پوشش انواع شمش‌های استاندارد ۲۴ عیار، ساچمه نقره و زیورآلات نقره با تفکیک مظنه خرید و فروش:
            </p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-stone-200 dark:border-stone-800">
            <table class="w-full text-right text-xs sm:text-sm border-collapse">
                <thead class="bg-stone-100 dark:bg-stone-850 text-stone-900 dark:text-stone-100 font-bold">
                    <tr>
                        <th class="p-3.5">عنوان دارایی</th>
                        <th class="p-3.5">عیار و خلوص</th>
                        <th class="p-3.5">واحد سنجش</th>
                        <th class="p-3.5">مبنای قیمت‌گذاری</th>
                        <th class="p-3.5">کاربرد در بازار</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200 dark:divide-stone-800 text-stone-700 dark:text-stone-300">
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-bold">قیمت گرم نقره ۹۹۹ (ساچمه خالص)</td>
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">۹۹۹.۹</td>
                        <td class="p-3.5">هر گرم</td>
                        <td class="p-3.5">انس جهانی نقره و تتر</td>
                        <td class="p-3.5">مبنای معاملات خام و ریخته‌گری</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-bold">نقره خام عیار ۹۹۵ (صنعتی)</td>
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">۹۹۵ از ۱۰۰۰</td>
                        <td class="p-3.5">هر گرم / کیلوگرم</td>
                        <td class="p-3.5">ضریب ۹۹۵ از نقره خالص</td>
                        <td class="p-3.5">صنایع الکترونیک و آلیاژسازی</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-bold">نقره استرلینگ عیار ۹۲۵ (زیورآلات)</td>
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">۹۲۵ از ۱۰۰۰</td>
                        <td class="p-3.5">هر گرم</td>
                        <td class="p-3.5">ضریب ۹۲۵ نقره + اجرت ساخت</td>
                        <td class="p-3.5">انگشتر، دستبند و ظروف نقره</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-bold">شمش نقره ۱ کیلوگرمی پلمپ</td>
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">۹۹۹.۹ فیزیکی</td>
                        <td class="p-3.5">هر کیلوگرم (۱۰۰۰ گرم)</td>
                        <td class="p-3.5">ارزش ذاتی ۱۰۰۰ گرم نقره + کارمزد بسته‌بندی</td>
                        <td class="p-3.5">سرمایه‌گذاری بلندمدت</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-bold">شمش طلای ۱ اونسی (۳۱.۱۰۳۵ گرم)</td>
                        <td class="p-3.5 font-mono text-amber-600 dark:text-amber-400 font-bold">۲۴ عیار (۹۹۹.۹)</td>
                        <td class="p-3.5">هر قطعه ۱ اونسی</td>
                        <td class="p-3.5">انس جهانی طلا + کارمزد ضرب</td>
                        <td class="p-3.5">شمش‌های معتبر بین‌المللی</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-bold">شمش طلا ۱۰۰ گرمی استاندارد</td>
                        <td class="p-3.5 font-mono text-amber-600 dark:text-amber-400 font-bold">۲۴ عیار (۹۹۹)</td>
                        <td class="p-3.5">قطعه ۱۰۰ گرمی</td>
                        <td class="p-3.5">۱۰۰ گرم طلای ۲۴ + هولوگرام ری‌گیری</td>
                        <td class="p-3.5">دادوستد بدون اجرت ساخت</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-bold">شمش طلا ۱ کیلوگرمی بانکی</td>
                        <td class="p-3.5 font-mono text-amber-600 dark:text-amber-400 font-bold">۲۴ عیار (۹۹۹.۹)</td>
                        <td class="p-3.5">هر کیلوگرم (۱۰۰۰ گرم)</td>
                        <td class="p-3.5">مظنه مرجع مرکز مبادله طلا و ارز</td>
                        <td class="p-3.5">معاملات کلان بین‌بانکی</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-xs text-stone-500">تمامی ردیف‌ها قابلیت نمایش هم‌زمان خرید و فروش، افزودن حاشیه سود یا کسر کارمزد به صورت درصدی را دارند.</p>
    </section>

    {{-- تفاوت‌های ساختاری نرخ‌گذاری نقره با طلا --}}
    <section class="rounded-3xl p-6 sm:p-10 bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-8">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">
                تفاوت‌های کلیدی نرخ‌گذاری نقره با طلا چیست؟
            </h2>
            <p class="text-stone-500 dark:text-stone-400 text-xs sm:text-sm">
                اصول محاسباتی و تفاوت‌های بنیادین بازار نقره که در تابلوی اعلام نرخ رعایت می‌شوند
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-sm">۱</div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">مبنای قیمت‌گذاری گرمی در برابر مثقال ۱۷ عیار</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    در بازار طلای ایران، عرف قیمت‌گذاری بر مبنای مظنه مثقال ۱۷ عیار است. اما در بازار نقره، هرگز واحد مثقال ملاک قرار نمی‌گیرد؛ بلکه مظنه بر حسب هر گرم ساچمه عیار ۹۹۹ یا عیار ۹۲۵ اعلام می‌شود. تابلوی طلالایو به صورت خودکار قیمت هر گرم نقره را محاسبه و روی تلویزیون درج می‌نماید.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-sm">۲</div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">انس مستقل و ماهیت دوگانه نقره</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    نقره دارای نماد معاملاتی مستقل در بازارهای بین‌المللی با کد XAG است و نوسانات آن همیشه هم‌جهت با طلای جهانی نیست. علاوه بر این، تقاضای بالای نقره در صنایع الکترونیکی سبب شده تا دینامیک قیمت نقره رفتاری صنعتی و سرمایه‌ای داشته باشد.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-sm">۳</div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">تفاوت عیار استاندارد نقره با طلای ۱۸ عیار</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    در حالی که عیار رسمی زیورآلات طلا در ایران ۷۵۰ از ۱۰۰۰ است، استاندارد نقره عیار ۹۲۵ (معروف به نقره استرلینگ) می‌باشد. تابلوی فروشگاه نقره می‌تواند تبدیل عیار ساچمه ۹۹۹ به کار ساخته ۹۲۵ را لحاظ کند. برای بررسی ضرایب عیار به <a href="{{ route('public.tools.karat-converter') }}" class="text-amber-600 dark:text-amber-400 font-bold hover:underline">ابزار تبدیل عیار طلا و نقره</a> مراجعه کنید.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-sm">۴</div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">کارمزد ضرب شمش در برابر اجرت ساخت</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    شمش‌های طلا و نقره برای مصارف سرمایه‌گذاری ضرب می‌شوند و بر خلاف سرویس‌های طلا، فاقد اجرت‌های سنگین ساخت هستند. در شمش‌ها تنها یک کارمزد ناچیز بسته‌بندی امنیتی لحاظ می‌شود و قیمت تابلو بسیار نزدیک به ارزش طلای خالص خام است.
                </p>
            </div>
        </div>
    </section>

    {{-- ویژگی‌های نرم‌افزار تابلوی نقره و شمش طلالایو --}}
    <section class="space-y-6">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">
                امکانات تابلو شمش و نقره طلالایو روی تلویزیون هوشمند
            </h2>
            <p class="text-stone-500 dark:text-stone-400 text-xs sm:text-sm">
                طراحی مناسب با فونت‌های خوانا ویژه نمایشگرهای مدرن
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-stone-900 p-6 rounded-2xl border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'chart-bar', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">تفکیک نرخ خرید و فروش شمش</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    امکان نمایش شفاف دو ستون خرید و فروش برای انواع شمش طلا و نقره تا خریداران سرمایه‌ای بتوانند با اطمینان کامل از حاشیه سود، تصمیم‌گیری کنند.
                </p>
            </div>

            <div class="bg-white dark:bg-stone-900 p-6 rounded-2xl border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">اجرا روی هر تلویزیون بدون مینی‌کیس</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    تنها با باز کردن مرورگر تلویزیون هوشمند کارگاه یا گالری، تابلوی زنده شروع به کار می‌کند. بدون هزینه خرید مینی‌کیس و بدون استهلاک بردهای قدیمی LED.
                </p>
            </div>

            <div class="bg-white dark:bg-stone-900 p-6 rounded-2xl border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'sparkles', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">اسلایدشوی محصولات و گواهی شمش‌ها</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    امکان نمایش اسلایدر کاتالوگ شمش‌های موجود، هولوگرام‌های امنیتی و مشخصات فنی ظروف و زیورآلات نقره در کنار نرخ‌های زنده.
                </p>
            </div>
        </div>
    </section>

    {{-- سوالات متداول نقره و شمش --}}
    <section class="space-y-4 max-w-4xl mx-auto">
        <h2 class="text-2xl font-black text-stone-900 dark:text-stone-100 text-center">
            پرسش‌های متداول فعالان بازار نقره و شمش
        </h2>

        <div class="space-y-3 pt-2">
            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>آیا نرخ هر گرم نقره ساچمه ۹۹۹ به صورت خودکار آپدیت می‌شود؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    بله؛ سامانه طلالایو نرخ مرجع نقره خام را از منابع رسمی بازار داخلی و انس جهانی نقره دریافت می‌کند. همچنین مدیر فروشگاه می‌تواند درصد یا مبلغ ثابتی را به عنوان کارمزد فروش به نرخ پایه اضافه نماید.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>آیا می‌توان در یک نمایشگر، هم‌زمان نرخ طلا، سکه، نقره، تتر و نفت برنت را نمایش داد؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    بله؛ در پنل کاربری طلالایو می‌توانید هر ترکیبی از ردیف‌ها را که تمایل دارید فعال سازید. برای مثال ردیف‌های شمش طلا و نقره را در کنار مظنه طلا، تتر (ارز دیجیتال)، نفت برنت، انس جهانی نقره و مظنه جهانی قرار دهید.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>آیا تابلوی نقره در صورت قطعی اینترنت خاموش می‌شود؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    خیر؛ فناوری ذخیره‌سازی محلی اجازه نمی‌دهد صفحه سیاه شود. آخرین مظنه معتبر ثبت‌شده همراه با نشانگر ساعت استعلام در طول قطعی شبکه روی نمایشگر نشان داده می‌شود.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>چگونه تلویزیون فروشگاه را به تابلوی شمش وصل کنیم؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    کافی است تلویزیون را به وای‌فای مغازه متصل نموده و مرورگر وب داخلی تلویزیون را باز کنید. مراحل تفکیکی برندهای سامسونگ، ال‌جی و سونی در صفحه <a href="{{ route('public.tv-setup-guide') }}" class="text-amber-600 dark:text-amber-400 font-bold hover:underline">راهنمای اتصال تلویزیون</a> توضیح داده شده است.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>هزینه استفاده از سامانه برای گالری‌های نقره چقدر است؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    طلالایو برای تمامی کاربران جدید ۱۴ روز تست رایگان بدون نیاز به ثبت کارت بانکی در نظر گرفته است. پس از آن می‌توانید از پلن‌های اقتصادی سالیانه مندرج در <a href="{{ route('public.pricing') }}" class="text-amber-600 dark:text-amber-400 font-bold hover:underline">صفحه تعرفه‌ها</a> استفاده فرمایید.
                </div>
            </details>
        </div>
    </section>

    {{-- CTA میانی --}}
    @include('partials.cta-inline', [
        'title' => 'تابلوی نرخ نقره و شمش مغازه خود را در ۳ دقیقه فعال کنید',
        'subtitle' => 'بدون نیاز به خرید تجهیزات سخت‌افزاری؛ همین حالا با تست ۱۴ روزه رایگان آغاز نمایید.',
        'buttonText' => 'تست رایگان تابلوی نقره و شمش',
        'buttonUrl' => route('admin.register')
    ])

    {{-- مطالب مرتبط --}}
    @include('partials.related-links', [
        'links' => [
            [
                'url' => route('public.smart-gold-board'),
                'title' => 'تابلوی هوشمند طلافروشی',
                'desc' => 'سامانه ابری نمایش زنده نرخ طلا و مسکوکات روی تلویزیون مغازه.'
            ],
            [
                'url' => route('public.digital-rate-board'),
                'title' => 'تابلوی دیجیتال نرخ طلا و سکه',
                'desc' => 'نمایشگر مدرن نرخ زنده طلا و مسکوکات بدون نیاز به مینی‌کیس.'
            ],
            [
                'url' => route('public.tools.karat-converter'),
                'title' => 'تبدیل عیار طلا و نقره',
                'desc' => 'فرمول و جدول آنلاین تبدیل عیارهای ۷۰۵ تا ۹۹۹ طلا و ۹۲۵ نقره.'
            ]
        ]
    ])

</div>
@endsection
