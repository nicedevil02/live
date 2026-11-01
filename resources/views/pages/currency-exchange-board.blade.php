@extends('layouts.public')

@section('title', 'تابلو صرافی و نرخ ارز روی تلویزیون: بدون LED | طلالایو')
@section('meta_description', 'نمایشگر دیجیتال قیمت انواع ارز، اسکناس و حواله روی تلویزیون هوشمند صرافی‌ها با امکان به‌روزرسانی آنی و بدون قطعی در سال ۱۴۰۵. همین حالا رایگان تست کنید.')
@section('canonical', 'https://talalive.ir/currency-exchange-board')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "Service",
      "name": "تابلو صرافی و نرخ ارز دیجیتال طلالایو",
      "serviceType": "نرم‌افزار ابری نمایشگر نرخ ارز و اسکناس صرافی",
      "provider": {
        "@@type": "Organization",
        "name": "طلالایو",
        "url": "https://talalive.ir"
      },
      "areaServed": {
        "@@type": "Country",
        "name": "ایران"
      },
      "description": "سامانه ابری مدیریت تابلو صرافی و نمایش لحظه‌ای نرخ خرید و فروش انواع ارز، حواله و مسکوکات روی تلویزیون‌های هوشمند بدون نیاز به مینی‌کیس و تابلوهای گران‌قیمت LED.",
      "hasOfferCatalog": {
        "@@type": "OfferCatalog",
        "name": "پلن‌های نمایشگر صرافی",
        "itemListElement": [
          {
            "@@type": "Offer",
            "name": "تست رایگان ۱۴ روزه تابلو صرافی",
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
          "name": "تابلو صرافی و نرخ ارز",
          "item": "https://talalive.ir/currency-exchange-board"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16 sm:space-y-20">

    {{-- هیرو سکشن لندینگ صرافی --}}
    <header class="text-center space-y-6 max-w-4xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-stone-100 dark:bg-stone-850 border border-stone-200 dark:border-stone-750 text-stone-700 dark:text-stone-300 text-xs font-semibold">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            <span>ویژه صرافی‌های مجاز، دفاتر خدمات ارزی و کارگزاران حواله‌جات</span>
        </div>
        
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-stone-900 dark:text-stone-100 leading-tight">
            تابلو صرافی و نرخ ارز دیجیتال؛ <br>
            <span class="text-amber-600 dark:text-amber-400">
                سامانه ابری نمایش زنده قیمت اسکناس و حواله
            </span>
        </h1>

        <p class="text-stone-600 dark:text-stone-300 text-sm sm:text-base leading-relaxed max-w-3xl mx-auto bg-stone-50 dark:bg-stone-900 p-5 rounded-2xl border border-stone-200 dark:border-stone-800 text-justify sm:text-center">
            <strong>تابلو صرافی و نرخ ارز</strong> سامانه‌ای دیجیتال و ابری برای نمایش زنده و دو نرخه قیمت خرید و فروش انواع اسکناس و حواله ارزی روی تلویزیون صرافی‌ها است که جایگزین تابلوهای گران‌قیمت LED شده و بدون نیاز به سخت‌افزار کار می‌کند.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
            <a href="{{ route('admin.register') }}" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm shadow-sm transition-colors inline-flex items-center justify-center">
                تست ۱۴ روزه رایگان تابلو صرافی
            </a>
            <a href="{{ route('public.tv-setup-guide') }}" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl bg-white dark:bg-stone-900 border border-stone-300 dark:border-stone-700 hover:bg-stone-50 dark:hover:bg-stone-850 text-stone-800 dark:text-stone-200 font-bold text-sm transition-colors shadow-sm inline-flex items-center justify-center">
                راهنمای راه‌اندازی روی تلویزیون صرافی
            </a>
        </div>
    </header>

    {{-- جدول ارزها و خدمات ارزی قابل نمایش --}}
    <section class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-3xl p-6 sm:p-10 shadow-sm space-y-6">
        <div class="space-y-2">
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-2">
                <span class="w-2.5 h-6 rounded-full bg-amber-500"></span>
                <span>فهرست نمادهای ارزی، کارمزد و خدمات حواله قابل پشتیبانی در تابلو</span>
            </h2>
            <p class="text-xs sm:text-sm text-stone-500 dark:text-stone-400">
                پیکربندی اختصاصی صرافی‌ها: مدیریت مستقل هر نماد با ستون‌های خرید نقدی، فروش نقدی و حواله شرکتی
            </p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-stone-200 dark:border-stone-800">
            <table class="w-full text-right text-xs sm:text-sm border-collapse">
                <thead class="bg-stone-100 dark:bg-stone-850 text-stone-900 dark:text-stone-100 font-bold">
                    <tr>
                        <th class="p-3.5">کد ایزو</th>
                        <th class="p-3.5">عنوان ارز و اسکناس</th>
                        <th class="p-3.5">مبنای قیمت‌گذاری</th>
                        <th class="p-3.5">کانال حواله‌جات پشتیبانی‌شده</th>
                        <th class="p-3.5">تنظیم کارمزد</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200 dark:divide-stone-800 text-stone-700 dark:text-stone-300">
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">USD</td>
                        <td class="p-3.5 font-bold">دلار آمریکا (اسکناس نقدی)</td>
                        <td class="p-3.5">نرخ بازار آزاد یا سامانه سنا</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله بانکی و صرافی دبی</td>
                        <td class="p-3.5">اسپرد درصدی خودکار</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">EUR</td>
                        <td class="p-3.5 font-bold">یورو اتحادیه اروپا</td>
                        <td class="p-3.5">اسکناس مسافرتی و تجاری</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله شرکتی سپا (SEPA) اروپا</td>
                        <td class="p-3.5">اسپرد درصدی خودکار</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">AED</td>
                        <td class="p-3.5 font-bold">درهم امارات متحده عربی</td>
                        <td class="p-3.5">نرخ مبنای تسویه بازرگانی</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله صرافی‌های دبی</td>
                        <td class="p-3.5">تنظیم دقیق ریالی</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">TRY</td>
                        <td class="p-3.5 font-bold">لیر ترکیه</td>
                        <td class="p-3.5">اسکناس گردشگری و تجاری</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله بانکی ترکیه</td>
                        <td class="p-3.5">تنظیم دقیق ریالی</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">GBP</td>
                        <td class="p-3.5 font-bold">پوند بریتانیا</td>
                        <td class="p-3.5">اسکناس نقدینگی و دانشجویی</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله صرافی لندن و بانک‌های انگلستان</td>
                        <td class="p-3.5">اسپرد درصدی خودکار</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">CNY</td>
                        <td class="p-3.5 font-bold">یوان چین</td>
                        <td class="p-3.5">واردات کالا و تهاتر تجاری</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله بانکی و شرکتی چین</td>
                        <td class="p-3.5">تنظیم دقیق ریالی</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">IQD</td>
                        <td class="p-3.5 font-bold">دینار عراق</td>
                        <td class="p-3.5">زیارتی عتبات و صادرات مرزی</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله بغداد، نجف و سلیمانیه</td>
                        <td class="p-3.5">تنظیم به ازای هر هزار دینار</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-mono text-stone-900 dark:text-stone-100 font-bold">USDT</td>
                        <td class="p-3.5 font-bold">تتر دیجیتال (USDT)</td>
                        <td class="p-3.5">تسویه رمزارزی بین‌المللی</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">انتقال آنی با شناسه تراکنش</td>
                        <td class="p-3.5">پوشش شبانه‌روزی</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-xs text-stone-500">تمامی اسامی و ردیف‌های ارزی از طریق پنل مدیریت صرافی قابلیت فعال‌سازی، غیرفعال‌سازی یا جابه‌جایی اولویت دارند.</p>
    </section>

    {{-- بخش اختصاصی: تفاوت نیاز صرافی با طلافروشی --}}
    <section class="rounded-3xl p-6 sm:p-10 bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-8">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">
                تفاوت نیاز تابلوی صرافی با تابلوی طلافروشی چیست؟
            </h2>
            <p class="text-stone-500 dark:text-stone-400 text-xs sm:text-sm">
                بررسی ساختار معاملاتی دفاتر ارزی در قیاس با فرمول‌های ویترین گالری‌های طلا
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-sm">۱</div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">ساختار دو نرخه خرید و فروش (Bid و Ask)</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    در مغازه‌های طلافروشی، تابلوی نرخ معمولاً یک قیمت پایه برای هر گرم طلای ۱۸ عیار را نمایش می‌دهد. اما در معاملات ارزی صرافی، بنیاد کار بر مبنای شکاف قیمت خرید و قیمت فروش استوار است. تابلوی صرافی این دو ستون را به صورت شفاف و هم‌زمان در دید مراجعین قرار می‌دهد.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-sm">۲</div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">تفکیک نرخ اسکناس نقدی از حواله بانکی</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    مشتریان دفاتر صرافی دو جامعه متفاوت هستند: متقاضیان ارز مسافرتی که اسکناس فیزیکی دریافت می‌کنند و شرکت‌های تجاری که نیازمند حواله بانکی هستند. تفاوت نرخ بین اسکناس و حواله در جدول به صورت تفکیک‌شده نمایش داده می‌شود.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-sm">۳</div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">بسامد نوسانات ارزی در تایم کاری بازار</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    در ساعات اوج معاملات، قیمت ارزها ممکن است به سرعت دستخوش تغییر شود. متصدی صرافی با گوشی یا سیستم صندوق، تمامی نرخ‌های تابلو را در کسری از ثانیه به‌روزرسانی می‌کند.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800 space-y-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-sm">۴</div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">زیرنویس مقررات و الزامات قانونی</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    صرافی‌ها مکلف به اطلاع‌رسانی سقف قانونی تخصیص ارز به ازای هر کارت ملی و مدارک هویتی هستند. تابلوی صرافی طلالایو به یک نوار زیرنویس با فونت خوانا مجهز است که این موارد را نمایش می‌دهد.
                </p>
            </div>
        </div>
    </section>

    {{-- مقایسه تابلوی ابری صرافی با تابلوهای سنتی LED --}}
    <section class="space-y-6">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">
                مزایای استفاده از تلویزیون هوشمند در صرافی‌ها
            </h2>
            <p class="text-stone-500 dark:text-stone-400 text-xs sm:text-sm">
                تحلیل فنی و اقتصادی استفاده از نمایشگرهای دیجیتال به جای بردهای قدیمی سون‌سگمنت
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-stone-900 p-6 rounded-2xl border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'coins', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">حذف هزینه‌های ساخت تابلو فیزیکی</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    ساخت فیزیکی یک تابلو نرخ ارز LED ده‌ها میلیون تومان سرمایه اولیه نیاز دارد. در سامانه طلالایو، از همان تلویزیون‌های موجود در سالن انتظار صرافی استفاده می‌شود.
                </p>
            </div>

            <div class="bg-white dark:bg-stone-900 p-6 rounded-2xl border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'scale', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">سازگاری با حالت عمودی و افقی</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    طراحی داخلی دفاتر صرافی اغلب از مانیتورهای ایستاده عمودی بهره می‌برد. قالب‌های طلالایو با چرخش ۹۰ درجه ساختار جدول را بدون به‌هم‌ریختگی چیدمان می‌کنند.
                </p>
            </div>

            <div class="bg-white dark:bg-stone-900 p-6 rounded-2xl border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'shield', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">پایداری در زمان قطعی موقت اینترنت</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    در صورت افت کیفیت یا قطعی موقتی شبکه، صفحه مانیتور صرافی سیاه نمی‌شود و آخرین مظنه‌های تاییدشده به همراه ساعت ثبت معتبر در دیدرس مراجعین باقی می‌ماند.
                </p>
            </div>
        </div>
    </section>

    {{-- الزامات فنی باجه‌های صرافی و استانداردهای نمایش نرخ --}}
    <section class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-3xl p-6 sm:p-10 shadow-sm space-y-6">
        <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100 flex items-center gap-2">
            <span class="w-2.5 h-6 rounded-full bg-amber-500"></span>
            <span>استانداردهای چیدمان تابلوی دیجیتال در باجه‌ها و سالن انتظار صرافی</span>
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-xs sm:text-sm text-stone-600 dark:text-stone-400">
            <div class="space-y-2 p-4 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800">
                <strong class="text-stone-900 dark:text-stone-100 block font-bold">۱. زاویه دید پشت شیشه‌ها</strong>
                <p class="leading-relaxed">
                    باجه‌های تحویل اسکناس به شیشه‌های ضخیم مجهز هستند. استفاده از تلویزیون‌های با پنل IPS زاویه دید مناسبی را برای مراجعین فراهم می‌سازد.
                </p>
            </div>
            <div class="space-y-2 p-4 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800">
                <strong class="text-stone-900 dark:text-stone-100 block font-bold">۲. سطوح دسترسی اپراتور و مدیر</strong>
                <p class="leading-relaxed">
                    امکان تعریف چند کاربر با نقش‌های تفکیک‌شده وجود دارد تا اپراتور مجاز به مشاهده نرخ‌ها باشد، اما تایید تغییر مظنه‌ها توسط مدیر انجام شود.
                </p>
            </div>
            <div class="space-y-2 p-4 rounded-2xl bg-stone-50 dark:bg-stone-850 border border-stone-200 dark:border-stone-800">
                <strong class="text-stone-900 dark:text-stone-100 block font-bold">۳. شبکه ایمن و استاندارد</strong>
                <p class="leading-relaxed">
                    سامانه طلالایو بر بستر پروتکل رمزنگاری‌شده HTTPS و توکن اختصاصی یکتا فعالیت می‌کند و امنیت نمایشگرها را تضمین می‌نماید.
                </p>
            </div>
        </div>
    </section>

    {{-- هماهنگی با سامانه‌های نیما، سنا و بازار توافقی --}}
    <section class="p-6 sm:p-8 rounded-3xl bg-stone-100/80 dark:bg-stone-850/80 border border-stone-200 dark:border-stone-800 space-y-4">
        <h3 class="text-lg font-bold text-stone-900 dark:text-stone-100 flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
            <span>انطباق با سامانه‌های رسمی مبادلات ارزی (نیما، سنا و بازار توافقی)</span>
        </h3>
        <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
            صرافی‌هایی که در بازارهای حواله نیمایی و سامانه نظارت ارز (سنا) به معامله می‌پردازند، نیازمند سامانه‌ای چابک برای انعکاس دقیق نرخ‌های مصوب هستند. تابلوی ارزی طلالایو این امکان را فراهم ساخته تا صرافی‌ها علاوه بر نرخ بازار آزاد، ردیف‌های میانگین وزنی معاملات سنا و نرخ توافقی بازرگانان را با برچسب‌های تفکیک‌شده به عموم مراجعین عرضه نمایند.
        </p>
    </section>

    {{-- سوالات متداول صرافی‌ها --}}
    <section class="space-y-4 max-w-4xl mx-auto">
        <h2 class="text-2xl font-black text-stone-900 dark:text-stone-100 text-center">
            پرسش‌های متداول کارگزاران ارزی پیرامون تابلو صرافی
        </h2>

        <div class="space-y-3 pt-2">
            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>چگونه می‌توان فاصله قیمتی (اسپرد) خرید و فروش اسکناس را مدیریت کرد؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    در پنل مدیریت اختصاصی طلالایو، می‌توانید برای هر جفت‌ارز یک فاصله درصدی یا عددی ثابت تعریف کنید تا با تغییر نرخ فروش، نرخ خرید نیز خودکار تنظیم شود یا هر دو ستون را به صورت دستی و آنی تعیین فرمایید.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>آیا اتصال تلویزیون صرافی به سامانه به سیم‌کشی یا دانگل نیاز دارد؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    خیر؛ تمامی مراحل در بستر شبکه وای‌فای صرافی و از طریق مرورگر پیش‌فرض سیستم‌عامل‌های تایزن، وب‌او‌اس و اندروید تی‌وی انجام می‌پذیرد. راهنمای مراحل در <a href="{{ route('public.tv-setup-guide') }}" class="text-amber-600 dark:text-amber-400 font-bold hover:underline">آموزش اتصال تلویزیون</a> در دسترس است.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>امکان نمایش هم‌زمان ردیف‌های مسکوکات بانکی و انس در تابلو صرافی هست؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    بله؛ صرافی‌هایی که دادوستد سکه تمام، نیم، ربع و انس طلا انجام می‌دهند می‌توانند ردیف‌های مسکوکات را ذیل ارزهای خارجی فعال سازند. برای کسب اطلاعات بیشتر می‌توانید به بخش <a href="{{ route('public.digital-rate-board') }}" class="text-amber-600 dark:text-amber-400 font-bold hover:underline">نرخ‌نامه دیجیتال</a> مراجعه کنید.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>آیا درج نام رسمی صرافی و لوگوی مجوز بانک مرکزی امکان‌پذیر است؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    بله؛ سربرگ تابلو با نشان تجاری، نام ثبتی صرافی و شماره مجوز فعالیت بانک مرکزی قابل تنظیم بوده و فضای بصری حرفه‌ای به باجه‌های شما می‌بخشد.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>مدل اشتراک و هزینه نرم‌افزار صرافی به چه شکل است؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    اشتراک به صورت سالیانه با ۱۴ روز دوره آزمایشی کاملاً رایگان ارائه می‌شود و شامل کلیه به‌روزرسانی‌های نرم‌افزاری و پشتیبانی است. جزییات بیشتر در صفحه <a href="{{ route('public.pricing') }}" class="text-amber-600 dark:text-amber-400 font-bold hover:underline">تعرفه‌های اشتراک</a> درج شده است.
                </div>
            </details>
        </div>
    </section>

    {{-- CTA میانی --}}
    @include('partials.cta-inline', [
        'title' => 'تابلوی نرخ ارز صرافی خود را در کمتر از ۳ دقیقه روشن کنید',
        'subtitle' => 'بدون نیاز به خرید تابلوی LED و بدون کابل؛ با ۱۴ روز تست کاملاً رایگان صرافی آغاز کنید.',
        'buttonText' => 'تست رایگان تابلو صرافی',
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
                'title' => 'نرخ نامه دیجیتال طلافروشی',
                'desc' => 'جایگزین مدرن و تحت وب تابلوهای سنتی ۷ رقمه بدون سخت‌افزار.'
            ],
            [
                'url' => route('public.pricing'),
                'title' => 'قیمت و تعرفه اشتراک طلالایو',
                'desc' => 'مشاهده پلن‌های اقتصادی بدون نیاز به مینی‌کیس و هزینه‌های نگهداری.'
            ]
        ]
    ])

</div>
@endsection
