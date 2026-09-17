@extends('layouts.public')

@section('title', 'تابلو صرافی و نرخ ارز روی تلویزیون — بدون LED | طلالایو')
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
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-20">

    {{-- هیرو سکشن لندینگ صرافی --}}
    <div class="text-center space-y-6 max-w-4xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/30 text-blue-700 dark:text-blue-300 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-blue-500 dark:bg-blue-400 animate-pulse"></span>
            <span>ویژه صرافی‌های مجاز نوع اول و دوم، دفاتر خدمات ارزی و کارگزاران حواله جات</span>
        </div>
        
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white leading-tight">
            تابلو صرافی و نرخ ارز دیجیتال؛ <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-500 to-amber-500 dark:from-blue-400 dark:via-indigo-300 dark:to-amber-300">
                سامانه ابری نمایش زنده قیمت اسکناس و حواله
            </span>
        </h1>

        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed max-w-3xl mx-auto bg-blue-50/50 dark:bg-slate-900/60 p-5 rounded-2xl border border-blue-200/50 dark:border-slate-800 text-justify sm:text-center">
            <strong>تابلو صرافی و نرخ ارز</strong> سامانه‌ای دیجیتال و ابری برای نمایش زنده و دو نرخه قیمت خرید و فروش انواع اسکناس و حواله ارزی روی تلویزیون صرافی‌ها است که جایگزین تابلوهای گران‌قیمت LED شده و بدون نیاز به سخت‌افزار کار می‌کند.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
            <a href="{{ route('admin.register') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-sm shadow-xl shadow-blue-500/25 transition-all hover:scale-105 cursor-pointer">
                تست ۱۴ روزه رایگان تابلو صرافی
            </a>
            <a href="/tv-setup-guide" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-white font-bold text-sm transition-all shadow-sm cursor-pointer">
                راهنمای راه‌اندازی روی تلویزیون صرافی
            </a>
        </div>
    </div>

    {{-- جدول ارزها و خدمات ارزی قابل نمایش --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6">
        <div class="space-y-2">
            <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                <span>فهرست نمادهای ارزی، اسپرد و خدمات حواله قابل پشتیبانی در تابلو</span>
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                پیکربندی اختصاصی صرافی‌ها: مدیریت مستقل هر نماد با ستون‌های خرید نقدی، فروش نقدی و حواله شرکتی
            </p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead class="bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold">
                    <tr>
                        <th class="p-3.5">کد ایزو</th>
                        <th class="p-3.5">عنوان ارز و اسکناس</th>
                        <th class="p-3.5">مبنای قیمت‌گذاری</th>
                        <th class="p-3.5">کانال حواله‌جات پشتیبانی‌شده</th>
                        <th class="p-3.5">تنظیم کارمزد</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-mono text-blue-600 dark:text-blue-400 font-bold">USD</td>
                        <td class="p-3.5 font-bold">دلار آمریکا (اسکناس نقدی طلاکوب)</td>
                        <td class="p-3.5">نرخ بازار آزاد / سامانه سنا</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله سوئیفت بانکی و صرافی دبی</td>
                        <td class="p-3.5">اسپرد درصدی خودکار</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-mono text-blue-600 dark:text-blue-400 font-bold">EUR</td>
                        <td class="p-3.5 font-bold">یورو اتحادیه اروپا (اسکناس ۵۰ و ۱۰۰)</td>
                        <td class="p-3.5">اسکناس مسافرتی و تجاری</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله شرکتی سپا (SEPA) آلمان و ایتالیا</td>
                        <td class="p-3.5">اسپرد درصدی خودکار</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-mono text-blue-600 dark:text-blue-400 font-bold">AED</td>
                        <td class="p-3.5 font-bold">درهم امارات متحده عربی</td>
                        <td class="p-3.5">نرخ مبنای تسویه بازرگانی</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله صرافی‌های دیره و دبی مکران</td>
                        <td class="p-3.5">تنظیم دقیق ریالی</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-mono text-blue-600 dark:text-blue-400 font-bold">TRY</td>
                        <td class="p-3.5 font-bold">لیر ترکیه (اسکناس ۲۰۰ لیر)</td>
                        <td class="p-3.5">اسکناس گردشگری و خرید ملک</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله بانکی زراعت و ایش بانک استانبول</td>
                        <td class="p-3.5">تنظیم دقیق ریالی</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-mono text-blue-600 dark:text-blue-400 font-bold">GBP</td>
                        <td class="p-3.5 font-bold">پوند بریتانیا (استرلینگ پلیمری)</td>
                        <td class="p-3.5">اسکناس نقدینگی و دانشجویی</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله صرافی لندن و بانک‌های انگلستان</td>
                        <td class="p-3.5">اسپرد درصدی خودکار</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-mono text-blue-600 dark:text-blue-400 font-bold">CNY</td>
                        <td class="p-3.5 font-bold">یوان چین (رنمینبی)</td>
                        <td class="p-3.5">واردات کالا و تهاتر تجاری</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله کونلون بانک، ای‌بی‌سی و وی‌چت</td>
                        <td class="p-3.5">تنظیم دقیق ریالی</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-mono text-blue-600 dark:text-blue-400 font-bold">IQD</td>
                        <td class="p-3.5 font-bold">دینار عراق (بسته ۲۵ هزار دیناری)</td>
                        <td class="p-3.5">زیارتی عتبات و صادرات مرزی</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">حواله بغداد، نجف، کربلا و سلیمانیه</td>
                        <td class="p-3.5">تنظیم به ازای هر هزار دینار</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-mono text-blue-600 dark:text-blue-400 font-bold">USDT</td>
                        <td class="p-3.5 font-bold">تتر دیجیتال (TRC20 / ERC20)</td>
                        <td class="p-3.5">تسویه رمزارزی بین‌المللی</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">انتقال آنی والت به والت با شناسه تراکنش</td>
                        <td class="p-3.5">پوشش شبانه‌روزی</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-[11px] text-slate-500">تمامی اسامی و ردیف‌های ارزی از طریق پنل مدیریت صرافی قابلیت فعال‌سازی، غیرفعال‌سازی یا جابه‌جایی اولویت دارند.</p>
    </div>

    {{-- بخش اختصاصی: تفاوت نیاز صرافی با طلافروشی --}}
    <div class="glass-panel rounded-3xl p-8 sm:p-12 border border-slate-200 dark:border-slate-800 space-y-8">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                تفاوت نیاز تابلوی صرافی با تابلوی طلافروشی چیست؟
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">
                بررسی معماری معاملاتی دفاتر ارزی در قیاس با فرمول‌های تک‌نرخه ویترین گالری‌های طلا
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black text-lg">۱</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">ساختار دو نرخه خرید و فروش (Bid/Ask Spread)</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    در مغازه‌های طلافروشی، تابلوی نرخ معمولاً تنها یک قیمت پایه برای هر گرم طلای ۱۸ عیار را نمایش می‌دهد و متغیرهایی چون اجرت ساخت و سود ۷ درصدی در پای فاکتور محاسبه می‌شوند. اما در معاملات ارزی صرافی، بنیاد کسب‌وکار بر مبنای شکاف قیمت خرید (Bid) و قیمت فروش (Ask) استوار است. تابلوی صرافی باید این دو ستون را به صورت شفاف و هم‌زمان در دید مراجعین قرار دهد.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black text-lg">۲</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">تفکیک نرخ اسکناس نقدی از حواله بانکی</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    مشتریان دفاتر صرافی دو جامعه کاملاً متفاوت هستند: متقاضیان ارز مسافرتی که اسکناس فیزیکی تحویل می‌گیرند و شرکت‌های تجاری و واردکنندگانی که نیازمند حواله درهم دبی، یوان چین یا لیر ترکیه به حساب ذی‌نفع خارجی هستند. تفاوت نرخ بین اسکناس و حواله گاه تا چند صد تومان در هر واحد ارز می‌رسد و تابلو باید توانایی نمایش مستقل این دو بازار را داشته باشد.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black text-lg">۳</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">بسامد نوسانات ارزی در تایم کاری بازار</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    در ساعات اوج معاملات بازار تهران، سبزه میدان و هرات، قیمت دلار و حواله‌جات ممکن است در کسری از دقیقه دستخوش تغییر شود. متصدی صرافی نیازمند ابزاری است که با یک فرمان از طریق اپ موبایل یا سیستم صندوق، تمامی نرخ‌های تابلو را در کسری از ثانیه به‌روزرسانی کند یا در دقایق نوسان غیرعادی، وضعیت نمایش را به حالت «در حال به‌روزرسانی» تغییر دهد.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black text-lg">۴</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">زیرنویس مقررات بانک مرکزی و الزامات مبارزه با پولشویی</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    بر اساس ضوابط نظارتی اداره مبارزه با پولشویی بانک مرکزی، کلیه کارگزاران و صرافی‌های تضامنی مکلف به اطلاع‌رسانی سقف قانونی تخصیص ارز به ازای هر کارت ملی، الزام تطابق حساب مبدا و مقصد و مدارک هویتی هستند. تابلوی صرافی طلالایو به یک نوار زیرنویس روان با فونت شفاف و خوانا مجهز است که این بخشنامه‌ها را به شکل پویا نمایش می‌دهد.
                </p>
            </div>
        </div>
    </div>

    {{-- مقایسه تابلوی ابری صرافی با تابلوهای سنتی LED --}}
    <div class="space-y-8">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                مزایای مهاجرت صرافی‌ها از تابلو LED به تلویزیون هوشمند
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">
                تحلیل فنی و اقتصادی استفاده از نمایشگرهای نسل جدید به جای بردهای قدیمی سون‌سگمنت
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-slate-50 dark:bg-slate-900/80 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black text-lg">💰</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">حذف هزینه‌های گزاف ۳۰ تا ۵۰ میلیون تومانی ساخت تابلو</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    ساخت فیزیکی یک تابلو نرخ ارز LED با قاب آلومینیومی و ماژول‌های دیجیتال، ده‌ها میلیون تومان سرمایه اولیه نیاز دارد. در سامانه طلالایو، از همان تلویزیون‌های موجود در سالن انتظار صرافی استفاده می‌شود و هیچ هزینه بردی پرداخت نخواهید کرد.
                </p>
            </div>

            <div class="bg-slate-50 dark:bg-slate-900/80 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black text-lg">📐</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">سازگاری با حالت استند عمودی (Portrait) و افقی</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    طراحی داخلی دفاتر صرافی مدرن اغلب از مانیتورهای ایستاده عمودی (مشابه تابلوهای اعلانات سالن ترانزیت فرودگاه) بهره می‌برد. قالب‌های طلالایو با چرخش ۹۰ درجه صفحه به صورت هوشمند ساختار جدول را بدون به هم ریختگی چیدمان می‌نمایند.
                </p>
            </div>

            <div class="bg-slate-50 dark:bg-slate-900/80 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black text-lg">🛡️</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">تاب‌آوری در زمان نوسان اینترنت و قطعی اتصال</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    با فناوری معماری محلی ابری، در صورت افت کیفیت یا قطعی موقتی شبکه، صفحه مانیتور صرافی سیاه نمی‌شود و آخرین مظنه‌های تاییدشده توسط صراف به همراه ساعت ثبت معتبر در دیدرس مراجعین باقی می‌ماند.
                </p>
            </div>
        </div>
    </div>

    {{-- الزامات فنی باجه‌های صرافی و استانداردهای نمایش نرخ --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6">
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
            <span>استانداردهای چیدمان تابلوی دیجیتال در باجه‌های شیشه‌ای و سالن انتظار صرافی</span>
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-xs sm:text-sm text-slate-600 dark:text-slate-400">
            <div class="space-y-2 p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800">
                <strong class="text-slate-900 dark:text-white block font-bold">۱. زاویه دید پشت شیشه‌های ضدگلوله</strong>
                <p class="leading-relaxed">
                    باجه‌های تحویل اسکناس به شیشه‌های ضخیم مجهز هستند. استفاده از تلویزیون‌های با پنل IPS زاویه دید ۱۷۸ درجه بدون اعوجاج نوری برای مراجعین فراهم می‌سازد.
                </p>
            </div>
            <div class="space-y-2 p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800">
                <strong class="text-slate-900 dark:text-white block font-bold">۲. سطوح دسترسی اپراتور و مدیر صرافی</strong>
                <p class="leading-relaxed">
                    امکان تعریف چند کاربر با نقش‌های تفکیک‌شده وجود دارد تا اپراتور باجه مجاز به مشاهده نرخ‌ها باشد، اما تایید نهایی تغییر مظنه‌ها توسط مدیر صرافی انجام شود.
                </p>
            </div>
            <div class="space-y-2 p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800">
                <strong class="text-slate-900 dark:text-white block font-bold">۳. شبکه ایزوله و امنیت تابلوی نرخ</strong>
                <p class="leading-relaxed">
                    سامانه طلالایو بر بستر پروتکل رمزنگاری‌شده HTTPS و توکن اختصاصی یکتا فعالیت می‌کند و خطر مداخله یا هک شدن نمایشگرهای عمومی سالن را به صفر می‌رساند.
                </p>
            </div>
        </div>
    </div>

    {{-- هماهنگی با سامانه‌های نیما، سنا و بازار توافقی --}}
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-4">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
            <span>یکپارچه‌سازی و انطباق با سامانه‌های رسمی مبادلات ارزی (نیما، سنا و بازار توافقی)</span>
        </h3>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
            صرافی‌های عضو کانون صرافان ایران که در بازارهای حواله نیمایی و سامانه نظارت ارز (سنا) به معامله می‌پردازند، نیازمند سامانه‌ای چابک برای انعکاس دقیق نرخ‌های مصوب هستند. تابلوی ارزی طلالایو این امکان را فراهم ساخته تا صرافی‌ها علاوه بر نرخ بازار آزاد، ردیف‌های میانگین وزنی معاملات سنا و نرخ توافقی بازرگانان را با برچسب‌های تفکیک‌شده به عموم مراجعین عرضه نمایند تا ابهامی در تسویه‌حساب‌های صادراتی و وارداتی ایجاد نگردد.
        </p>
    </div>

    {{-- سوالات متداول صرافی‌ها --}}
    <div class="glass-panel p-8 sm:p-12 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-6">
        <h2 class="text-2xl font-black text-slate-900 dark:text-white text-center">
            پرسش‌های متداول کارگزاران ارزی پیرامون تابلو صرافی
        </h2>

        <div class="space-y-4 max-w-3xl mx-auto pt-4">
            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">چگونه می‌توان فاصله قیمتی (اسپرد) خرید و فروش اسکناس را مدیریت کرد؟</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    در پنل مدیریت اختصاصی طلالایو، می‌توانید برای هر جفت‌ارز یک فاصله درصدی یا عددی ثابت تعریف کنید تا با تغییر نرخ فروش، نرخ خرید نیز خودکار تنظیم شود یا هر دو ستون را به صورت دستی و آنی تعیین فرمایید.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">آیا اتصال تلویزیون صرافی به سامانه به سیم‌کشی یا دانگل نیاز دارد؟</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    خیر؛ تمامی مراحل در بستر شبکه وای‌فای صرافی و از طریق مرورگر پیش‌فرض سیستم‌عامل‌های تایزن، وب‌او‌اس و اندروید تی‌وی انجام می‌پذیرد. راهنمای مراحل در <a href="/tv-setup-guide" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">آموزش اتصال تلویزیون</a> در دسترس است.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">امکان نمایش هم‌زمان ردیف‌های مسکوکات بانکی و انس در تابلو صرافی هست؟</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    بله؛ صرافی‌هایی که دادوستد سکه تمام، نیم، ربع و انس طلا انجام می‌دهند می‌توانند ردیف‌های مسکوکات را ذیل ارزهای خارجی فعال سازند. برای کسب اطلاعات بیشتر می‌توانید به بخش <a href="/digital-rate-board" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">نرخ‌نامه دیجیتال</a> مراجعه کنید.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">آیا درج نام رسمی صرافی و لوگوی مجوز بانک مرکزی امکان‌پذیر است؟</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    بله؛ سربرگ تابلو به طور اختصاصی با نشان تجاری، نام ثبتی صرافی و شماره مجوز فعالیت بانک مرکزی قابل تنظیم بوده و فضای بصری حرفه‌ای به باجه‌های شما می‌بخشد.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">مدل اشتراک و هزینه نرم‌افزار صرافی به چه شکل است؟</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    اشتراک به صورت سالیانه با ۱۴ روز دوره آزمایشی کاملاً رایگان ارائه می‌شود و شامل کلیه به‌روزرسانی‌های نرم‌افزاری و پشتیبانی بدون اخذ هزینه بابت سخت‌افزار است. جزییات بیشتر در صفحه <a href="/pricing" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">تعرفه‌های اشتراک</a> درج شده است.
                </p>
            </div>
        </div>
    </div>

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
                'url' => '/smart-gold-board',
                'title' => 'تابلوی هوشمند طلافروشی',
                'desc' => 'سامانه ابری نمایش زنده نرخ طلا و مسکوکات روی تلویزیون مغازه.'
            ],
            [
                'url' => '/digital-rate-board',
                'title' => 'نرخ نامه دیجیتال طلافروشی',
                'desc' => 'جایگزین مدرن و تحت وب تابلوهای سنتی ۷ رقمه بدون سخت‌افزار.'
            ],
            [
                'url' => '/pricing',
                'title' => 'قیمت و تعرفه اشتراک طلالایو',
                'desc' => 'مشاهده پلن‌های اقتصادی بدون نیاز به مینی‌کیس و هزینه‌های نگهداری.'
            ]
        ]
    ])

</div>
@endsection
