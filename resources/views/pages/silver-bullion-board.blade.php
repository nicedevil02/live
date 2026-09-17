@extends('layouts.public')

@section('title', 'تابلو نرخ نقره و شمش — گرم ۹۹۹، ۹۹۵ و ۹۲۵ | طلالایو')
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
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-20">

    {{-- هیرو سکشن لندینگ نقره و شمش --}}
    <div class="text-center space-y-6 max-w-4xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-200 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse"></span>
            <span>ویژه فروشندگان نقره، کارگاه‌های ریخته‌گری، معامله‌گران ساچمه و شمش</span>
        </div>
        
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white leading-tight">
            تابلو نرخ نقره و شمش طلا؛ <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-400 via-cyan-500 to-amber-500 dark:from-slate-200 dark:via-cyan-300 dark:to-yellow-400">
                نمایشگر زنده عیارهای ۹۹۹، ۹۹۵ و ۹۲۵ روی تلویزیون
            </span>
        </h1>

        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed max-w-3xl mx-auto bg-slate-100/70 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 text-justify sm:text-center">
            <strong>تابلو نرخ نقره و شمش</strong> سامانه‌ای تخصصی و ابری برای نمایش زنده قیمت شمش طلا، ساچمه نقره خام، گرم‌های ۹۹۹، ۹۹۵ و عیار ۹۲۵ روی تلویزیون فروشگاه‌ها است که جایگزین تابلوهای سنتی شده و بدون نیاز به سخت‌افزار کار می‌کند.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
            <a href="{{ route('admin.register') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-slate-800 to-slate-950 dark:from-cyan-500 dark:to-blue-600 hover:from-slate-900 hover:to-black text-white font-black text-sm shadow-xl shadow-slate-500/25 transition-all hover:scale-105 cursor-pointer">
                تست ۱۴ روزه رایگان تابلو نقره و شمش
            </a>
            <a href="/tv-setup-guide" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-white font-bold text-sm transition-all shadow-sm cursor-pointer">
                راهنمای اتصال تلویزیون مغازه
            </a>
        </div>
    </div>

    {{-- جدول عیارهای نقره و شمش‌های استاندارد --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6">
        <div class="space-y-2">
            <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-cyan-500"></span>
                <span>جدول ردیف‌های تخصصی شمش و نقره خام در تابلوی طلالایو</span>
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                پوشش جامع انواع شمش‌های استاندارد ۲۴ عیار، ساچمه نقره و زیورآلات نقره با تفکیک مظنه خرید و فروش:
            </p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead class="bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold">
                    <tr>
                        <th class="p-3.5">عنوان دارایی</th>
                        <th class="p-3.5">عیار و خلوص</th>
                        <th class="p-3.5">واحد سنجش</th>
                        <th class="p-3.5">مبنای قیمت‌گذاری</th>
                        <th class="p-3.5">کاربرد در بازار</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold">قیمت گرم نقره ۹۹۹ (ساچمه خالص)</td>
                        <td class="p-3.5 font-mono text-cyan-600 dark:text-cyan-400 font-bold">۹۹۹.۹ (۲۴ نقره)</td>
                        <td class="p-3.5">هر گرم</td>
                        <td class="p-3.5">انس جهانی نقره (XAG) + دلار آزاد</td>
                        <td class="p-3.5">مبنای معاملات خام، آبکاری و ریخته‌گری</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold">نقره خام عیار ۹۹۵ (صنعتی)</td>
                        <td class="p-3.5 font-mono text-cyan-600 dark:text-cyan-400 font-bold">۹۹۵ از ۱۰۰۰</td>
                        <td class="p-3.5">هر گرم / کیلوگرم</td>
                        <td class="p-3.5">ضریب ۹۹۵ از نقره خالص</td>
                        <td class="p-3.5">صنایع الکترونیک، کاتالیزور و آلیاژسازی</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold">نقره استرلینگ عیار ۹۲۵ (زیورآلات)</td>
                        <td class="p-3.5 font-mono text-cyan-600 dark:text-cyan-400 font-bold">۹۲۵ از ۱۰۰۰</td>
                        <td class="p-3.5">هر گرم</td>
                        <td class="p-3.5">ضریب ۹۲۵ نقره + اجرت ساخت</td>
                        <td class="p-3.5">انگشتر، دستبند، زنجیر و ظروف نقره</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold">شمش نقره ۱ کیلوگرمی پلمپ</td>
                        <td class="p-3.5 font-mono text-cyan-600 dark:text-cyan-400 font-bold">۹۹۹.۹ فیزیکی</td>
                        <td class="p-3.5">هر کیلوگرم (۱۰۰۰ گرم)</td>
                        <td class="p-3.5">ارزش ذاتی ۱۰۰۰ گرم نقره + پرمیوم پکینگ</td>
                        <td class="p-3.5">سرمایه‌گذاری امن بلندمدت و حفظ ارزش دارایی</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold">شمش طلای ۱ اونسی (۳۱.۱۰۳۵ گرم)</td>
                        <td class="p-3.5 font-mono text-amber-600 dark:text-amber-400 font-bold">۲۴ عیار (۹۹۹.۹)</td>
                        <td class="p-3.5">هر قطعه ۱ اونسی</td>
                        <td class="p-3.5">انس جهانی طلا (XAU) + کارمزد ضرب</td>
                        <td class="p-3.5">شمش‌های سوئیسی پمپ، والکامبی و معتبر</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold">شمش طلا ۱۰۰ گرمی استاندارد</td>
                        <td class="p-3.5 font-mono text-amber-600 dark:text-amber-400 font-bold">۲۴ عیار (۹۹۹)</td>
                        <td class="p-3.5">قطعه ۱۰۰ گرمی</td>
                        <td class="p-3.5">۱۰۰ گرم طلای ۲۴ + هولوگرام ری‌گیری</td>
                        <td class="p-3.5">دادوستد شرکتی، سرمایه‌گذاری بدون اجرت ساخت</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold">شمش طلا ۱ کیلوگرمی بانکی</td>
                        <td class="p-3.5 font-mono text-amber-600 dark:text-amber-400 font-bold">۲۴ عیار (۹۹۹.۹)</td>
                        <td class="p-3.5">هر کیلوگرم (۱۰۰۰ گرم)</td>
                        <td class="p-3.5">مظنه مرجع مرکز مبادله طلا و ارز</td>
                        <td class="p-3.5">معاملات کلان بین‌بانکی و پشتوانه ارزی</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-[11px] text-slate-500">تمامی ردیف‌ها قابلیت نمایش هم‌زمان خرید و فروش، افزودن حاشیه سود یا کسر کارمزد به صورت درصدی را دارا می‌باشند.</p>
    </div>

    {{-- تفاوت‌های ساختاری نرخ‌گذاری نقره با طلا --}}
    <div class="glass-panel rounded-3xl p-8 sm:p-12 border border-slate-200 dark:border-slate-800 space-y-8">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                تفاوت‌های کلیدی نرخ‌گذاری نقره با طلا چیست؟
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">
                اصول محاسباتی و تفاوت‌های بنیادین بازار نقره که در تابلوی اعلام نرخ باید رعایت شوند
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center font-black text-lg">۱</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">مبنای قیمت‌گذاری گرمی در برابر مثقال ۱۷ عیار</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    در بازار طلای ایران، عرف قیمت‌گذاری بر مبنای «مظنه مثقال ۱۷ عیار» (معادل ۴.۳۳۱۸ گرم طلای ۷۰۵) است. اما در بازار نقره، هرگز واحد مثقال ملاک قرار نمی‌گیرد؛ بلکه مظنه بر حسب هر گرم ساچمه عیار ۹۹۹ یا عیار ۹۲۵ اعلام می‌شود. تابلوی طلالایو به صورت خودکار قیمت هر گرم نقره را محاسبه و روی تلویزیون درج می‌نماید.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center font-black text-lg">۲</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">نسبت طلا به نقره (Gold-to-Silver Ratio) و انس مجزا</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    نقره دارای نماد معاملاتی مستقل در بازارهای بین‌المللی با کد XAG/USD است و نوسانات آن همیشه هم‌جهت با طلای جهانی (XAU) نیست. علاوه بر این، تقاضای بالای نقره در صنایع پنل‌های خورشیدی، باتری و تراشه‌های الکترونیکی سبب شده تا دینامیک قیمت نقره رفتاری دوگانه (صنعتی-سرمایه‌ای) داشته باشد.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center font-black text-lg">۳</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">تفاوت عیار استاندارد نقره (۹۲۵ استرلینگ) با طلای ۱۸ عیار (۷۵۰)</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    در حالی که عیار رسمی زیورآلات طلا در ایران ۷۵۰ از ۱۰۰۰ است، استاندارد نقره عیار ۹۲۵ (معروف به نقره استرلینگ با ۷.۵ درصد مس برای افزایش استحکام) می‌باشد. تابلوی فروشگاه نقره باید بتواند تبدیل عیار ساچمه ۹۹۹ به کار ساخته ۹۲۵ را مطابق فرمول استاندارد در پای فاکتور لحاظ کند. برای بررسی ضرایب عیار به <a href="/tools/karat-converter" class="text-cyan-600 dark:text-cyan-400 font-bold hover:underline">ابزار تبدیل عیار طلا و نقره</a> مراجعه کنید.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center font-black text-lg">۴</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">کارمزد ریخته‌گری شمش در برابر اجرت ساخت زیورآلات</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    شمش‌های طلا و نقره برای مصارف سرمایه‌گذاری ضرب می‌شوند و بر خلاف النگو یا سرویس‌های طلا، فاقد اجرت‌های سنگین ساخت (۱۵ تا ۲۵ درصد) هستند. در شمش‌ها تنها یک کارمزد ناچیز بسته‌بندی امنیتی و هولوگرام لحاظ می‌شود و قیمت تابلو بسیار نزدیک به ارزش طلای خالص خام است.
                </p>
            </div>
        </div>
    </div>

    {{-- ویژگی‌های نرم‌افزار تابلوی نقره و شمش طلالایو --}}
    <div class="space-y-8">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                امکانات تابلو شمش و نقره طلالایو روی تلویزیون هوشمند
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">
                طراحی چشم‌نواز با تم‌های نقره‌ای، متالیک و طلایی ویژه ویترین‌های مدرن
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-slate-50 dark:bg-slate-900/80 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center font-black text-lg">📊</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">تفکیک نرخ خرید و فروش شمش</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    امکان نمایش شفاف دو ستون خرید و فروش برای انواع شمش طلا و نقره تا خریداران سرمایه‌ای بتوانند با اطمینان کامل از حاشیه سود و نرخ بازخرید، تصمیم‌گیری کنند.
                </p>
            </div>

            <div class="bg-slate-50 dark:bg-slate-900/80 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center font-black text-lg">📺</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">اجرا روی هر تلویزیون بدون مینی‌کیس</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    تنها با باز کردن مرورگر تلویزیون هوشمند کارگاه یا گالری، تابلوی زنده شروع به کار می‌کند. بدون هزینه خرید مینی‌کیس و بدون استهلاک بردهای قدیمی LED.
                </p>
            </div>

            <div class="bg-slate-50 dark:bg-slate-900/80 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center font-black text-lg">💎</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">اسلایدشوی محصولات و گواهی شمش‌ها</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    امکان نمایش اسلایدر کاتالوگ شمش‌های موجود، هولوگرام‌های امنیتی، استانداردهای آزمایشگاهی و مشخصات فنی ظروف و زیورآلات نقره در کنار نرخ‌های زنده.
                </p>
            </div>
        </div>
    </div>

    {{-- سوالات متداول نقره و شمش --}}
    <div class="glass-panel p-8 sm:p-12 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-6">
        <h2 class="text-2xl font-black text-slate-900 dark:text-white text-center">
            پرسش‌های متداول فعالان بازار نقره و شمش
        </h2>

        <div class="space-y-4 max-w-3xl mx-auto pt-4">
            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">آیا نرخ هر گرم نقره ساچمه ۹۹۹ به صورت خودکار آپدیت می‌شود؟</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    بله؛ سامانه طلالایو نرخ مرجع نقره خام را از منابع رسمی بازار داخلی و انس جهانی نقره دریافت می‌کند. همچنین مدیر فروشگاه می‌تواند درصد یا مبلغ ثابتی را به عنوان کارمزد فروش به نرخ پایه اضافه نماید.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">آیا می‌توان در یک نمایشگر، هم‌زمان نرخ طلا، سکه، نقره و ارز را نمایش داد؟</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    بله؛ در پنل کاربری طلالایو می‌توانید هر ترکیبی از ردیف‌ها را که تمایل دارید فعال سازید. برای مثال ردیف‌های شمش طلا و نقره را در کنار مظنه طلا و ارزهایی نظیر درهم یا دلار قرار دهید. برای بررسی راهکار ارزی، صفحه <a href="/currency-exchange-board" class="text-cyan-600 dark:text-cyan-400 font-bold hover:underline">تابلو صرافی و نرخ ارز</a> را ببینید.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">آیا تابلوی نقره در صورت قطعی اینترنت خاموش می‌شود؟</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    خیر؛ فناوری ذخیره‌سازی محلی هوشمند اجازه نمی‌دهد صفحه سیاه شود. آخرین مظنه معتبر ثبت‌شده همراه با نشانگر ساعت استعلام در طول قطعی شبکه روی نمایشگر نشان داده می‌شود.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">چگونه تلویزیون فروشگاه را به تابلوی شمش وصل کنیم؟</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    کافی است تلویزیون را به وای‌فای مغازه متصل نموده و مرورگر وب داخلی تلویزیون را باز کنید. مراحل تفکیکی برندهای سامسونگ، ال‌جی و سونی در صفحه <a href="/tv-setup-guide" class="text-cyan-600 dark:text-cyan-400 font-bold hover:underline">راهنمای اتصال تلویزیون</a> توضیح داده شده است.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">هزینه استفاده از سامانه برای گالری‌های نقره چقدر است؟</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    طلالایو برای تمامی کاربران جدید ۱۴ روز تست رایگان و کامل بدون نیاز به ثبت کارت بانکی در نظر گرفته است. پس از آن می‌توانید از پلن‌های اقتصادی سالیانه مندرج در <a href="/pricing" class="text-cyan-600 dark:text-cyan-400 font-bold hover:underline">صفحه تعرفه‌ها</a> استفاده فرمایید.
                </p>
            </div>
        </div>
    </div>

    {{-- CTA میانی --}}
    @include('partials.cta-inline', [
        'title' => 'تابلوی نرخ نقره و شمش مغازه خود را در ۳ دقیقه فعال کنید',
        'subtitle' => 'بدون نیاز به خرید تجهیزات سخت‌افزاری گران‌قیمت؛ همین حالا با تست ۱۴ روزه رایگان آغاز نمایید.',
        'buttonText' => 'تست رایگان تابلوی نقره و شمش',
        'buttonUrl' => route('admin.register')
    ])

    {{-- مطالب مرتبط --}}
    @include('partials.related-links', [
        'links' => [
            [
                'url' => '/smart-gold-board',
                'title' => 'تابلوی هوشمند طلافروشی',
                'desc' => 'سامانه ابری نمایش زنده نرخ طلا و مسکوکات روی تلویزیون مغازه.'
            ],
            [
                'url' => '/currency-exchange-board',
                'title' => 'تابلو صرافی و نرخ ارز',
                'desc' => 'نمایشگر دیجیتال دو نرخه قیمت انواع ارز، اسکناس و حواله.'
            ],
            [
                'url' => '/tools/karat-converter',
                'title' => 'تبدیل عیار طلا و نقره',
                'desc' => 'فرمول و جدول آنلاین تبدیل عیارهای ۷۰۵ تا ۹۹۹ طلا و ۹۲۵ نقره.'
            ]
        ]
    ])

</div>
@endsection
