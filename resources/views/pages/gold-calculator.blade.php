@extends('layouts.public')

@section('title', 'ماشین حساب طلا — ابزارهای آنلاین محاسبات طلا و سکه | طلالایو')
@section('meta_description', 'مجموعه تخصصی ماشین حساب طلا: ۷ ابزار آنلاین محاسبه فاکتور طلا، حباب سکه، اجرت ساخت، طلای دست دوم، آبشده و عیار با فرمول رسمی اتحادیه در سال ۱۴۰۵.')
@section('canonical', 'https://talalive.ir/gold-calculator')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "مجموعه تخصصی ماشین حساب طلا و ابزارهای صنف طلالایو",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "url": "https://talalive.ir/gold-calculator",
      "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "IRR"
      },
      "description": "۷ ابزار آنلاین و رایگان محاسبات طلا و سکه شامل محاسبه فاکتور طلا با اجرت و مالیات، حباب سنج سکه، طلای دست دوم، آبشده، مظنه و تبدیل عیار."
    },
    {
      "@@type": "ItemList",
      "name": "ابزارهای تخصصی ماشین حساب طلا طلالایو",
      "itemListElement": [
        {
          "@@type": "ListItem",
          "position": 1,
          "name": "محاسبه قیمت طلا با اجرت و مالیات",
          "url": "https://talalive.ir/tools/gold-price-calculator"
        },
        {
          "@@type": "ListItem",
          "position": 2,
          "name": "حباب سنج سکه",
          "url": "https://talalive.ir/tools/coin-bubble"
        },
        {
          "@@type": "ListItem",
          "position": 3,
          "name": "محاسبه اجرت طلا",
          "url": "https://talalive.ir/tools/wage-calculator"
        },
        {
          "@@type": "ListItem",
          "position": 4,
          "name": "قیمت‌گذاری طلای دست دوم",
          "url": "https://talalive.ir/tools/second-hand-gold"
        },
        {
          "@@type": "ListItem",
          "position": 5,
          "name": "تبدیل مظنه به گرم",
          "url": "https://talalive.ir/tools/mesghal"
        },
        {
          "@@type": "ListItem",
          "position": 6,
          "name": "محاسبه طلای آبشده",
          "url": "https://talalive.ir/tools/melted-gold"
        },
        {
          "@@type": "ListItem",
          "position": 7,
          "name": "تبدیل عیار طلا",
          "url": "https://talalive.ir/tools/karat-converter"
        }
      ]
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
          "name": "ماشین حساب طلا",
          "item": "https://talalive.ir/gold-calculator"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16">

    {{-- هدر صفحه و تعریف ۴۰ کلمه‌ای منبع حقیقت --}}
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-300 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
            <span>متصل به نرخ‌های زنده سامانه طلالایو (آخرین بروزرسانی: {{ $lastUpdated }})</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white leading-tight">
            ماشین حساب طلا و ابزارهای آنلاین محاسبات صنف طلا
        </h1>
        <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed p-4 rounded-2xl bg-amber-500/5 border border-amber-500/20 text-justify sm:text-center">
            <strong>ماشین حساب طلا</strong> مجموعه‌ای از ابزارهای آنلاین و تخصصی محاسباتی برای طلافروشان و خریداران است که بر مبنای فرمول‌های رسمی اتحادیه، نرخ طلای خام، سود ۷ درصد قانونی، اجرت ساخت، ارزش ذاتی و حباب سکه را شفاف و دقیق محاسبه می‌کند.
        </p>
    </div>

    {{-- نوار زنده نرخ‌های بازار --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3">
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm text-center">
            <div class="text-[11px] text-slate-500">طلای ۱۸ عیار (۷۵۰)</div>
            <div class="text-sm font-bold font-mono text-amber-600 dark:text-amber-400 mt-1">
                {{ number_format($rates['gold18']) }} <span class="text-[10px] text-slate-400">تومان</span>
            </div>
        </div>
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm text-center">
            <div class="text-[11px] text-slate-500">مظنه مثقال تهران</div>
            <div class="text-sm font-bold font-mono text-amber-600 dark:text-amber-400 mt-1">
                {{ number_format($rates['mesghal']) }} <span class="text-[10px] text-slate-400">تومان</span>
            </div>
        </div>
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm text-center">
            <div class="text-[11px] text-slate-500">سکه تمام امامی</div>
            <div class="text-sm font-bold font-mono text-slate-900 dark:text-white mt-1">
                {{ number_format($rates['coin_emami']) }} <span class="text-[10px] text-slate-400">تومان</span>
            </div>
        </div>
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm text-center">
            <div class="text-[11px] text-slate-500">سکه تمام بهار آزادی</div>
            <div class="text-sm font-bold font-mono text-slate-900 dark:text-white mt-1">
                {{ number_format($rates['coin_bahar']) }} <span class="text-[10px] text-slate-400">تومان</span>
            </div>
        </div>
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm text-center col-span-2 sm:col-span-4 lg:col-span-1">
            <div class="text-[11px] text-slate-500">طلای ۲۴ عیار (۹۹۹)</div>
            <div class="text-sm font-bold font-mono text-emerald-600 dark:text-emerald-400 mt-1">
                {{ number_format($rates['gold24']) }} <span class="text-[10px] text-slate-400">تومان</span>
            </div>
        </div>
    </div>

    {{-- کارت‌های هفت ابزار تخصصی (Hub Grid) --}}
    <div class="space-y-6">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                دسترسی به ۷ ابزار آنلاین محاسبات طلا و مسکوکات
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">
                ابزار مورد نظر خود را انتخاب کنید و محاسبات را به صورت تعاملی و متصل به نرخ‌های روز انجام دهید
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- ابزار ۱: فاکتور طلا --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg">🧮</span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-700 dark:text-amber-300">فرمول رسمی اتحادیه</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                        محاسبه قیمت طلا با اجرت و مالیات
                    </h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        محاسبه دقیق فاکتور خرید طلا با تفکیک سود ۷ درصد طلافروشی، اجرت ساخت کارگاه و اعمال مالیات ۹ درصدی ارزش افزوده فقط بر سود و اجرت.
                    </p>
                </div>
                <a href="/tools/gold-price-calculator" class="w-full py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs text-center transition-colors shadow-sm block">
                    محاسبه فاکتور رسمی طلا ←
                </a>
            </div>

            {{-- ابزار ۲: حباب سنج سکه --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg">🪙</span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-700 dark:text-emerald-300">۵ نوع سکه بانکی</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                        حباب سنج و حباب گیر انواع سکه
                    </h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        محاسبه بلادرنگ ارزش ذاتی بر اساس طلای ۹۰۰ و درصد حباب سکه تمام امامی، بهار آزادی، نیم سکه، ربع سکه و سکه گرمی به همراه هشدار ریسک.
                    </p>
                </div>
                <a href="/tools/coin-bubble" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs text-center transition-colors shadow-sm block">
                    آنالیز حباب انواع سکه ←
                </a>
            </div>

            {{-- ابزار ۳: محاسبه اجرت --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg">💎</span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-500/10 text-purple-700 dark:text-purple-300">جدول درصدهای ۱۴۰۵</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                        محاسبه اجرت ساخت و کارمزد طلا
                    </h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        محاسبه دستمزد ساخت النگو، سرویس، زنجیر و کارهای خارجی به تفکیک درصد و ریال به همراه جدول مرجع اجرت متداول مصنوعات در بازار.
                    </p>
                </div>
                <a href="/tools/wage-calculator" class="w-full py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs text-center transition-colors shadow-sm block">
                    محاسبه اجرت ساخت طلا ←
                </a>
            </div>

            {{-- ابزار ۴: طلای دست دوم --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-2xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg">♻️</span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-500/10 text-blue-700 dark:text-blue-300">طلای مستعمل و کم‌اجرت</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                        قیمت‌گذاری طلای دست دوم و مستعمل
                    </h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        محاسبه ارزش خرید طلای کارکرده بدون اجرت با احتساب کسر افت وزنی سنگ و نگین، سود مجاز ۵ الی ۷ درصدی و قیمت منصفانه خرید مغازه.
                    </p>
                </div>
                <a href="/tools/second-hand-gold" class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs text-center transition-colors shadow-sm block">
                    محاسبه قیمت طلای دست دوم ←
                </a>
            </div>

            {{-- ابزار ۵: مظنه به گرم --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg">⚖️</span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-700 dark:text-amber-300">مظنه ۱۷ به ۱۸ عیار</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                        تبدیل مظنه مثقال به گرم طلای ۱۸ عیار
                    </h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        تبدیل ریاضی یک مثقال طلای ۱۷ عیار (۴.۳۳۱۸ گرم) به قیمت یک گرم طلای ۱۸ عیار (۷۵۰) با فرمول دقیق تقسیم بر ۴.۳۳۱۸ و ۴.۶۰۸.
                    </p>
                </div>
                <a href="/tools/mesghal" class="w-full py-3 rounded-xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 text-white font-bold text-xs text-center transition-colors shadow-sm block">
                    تبدیل مثقال به گرم ←
                </a>
            </div>

            {{-- ابزار ۶: طلای آبشده --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-2xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center text-lg">🔥</span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-500/10 text-rose-700 dark:text-rose-300">انگ و ری‌گیری</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                        محاسبه طلای آبشده و خط آزمایشگاه
                    </h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        تبدیل وزن و عیار اعلامی آزمایشگاه ری‌گیری به طلای ۱۸ عیار استاندارد، محاسبه ارزش ریالی خط آبشده و استعلام شماره پاکت.
                    </p>
                </div>
                <a href="/tools/melted-gold" class="w-full py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs text-center transition-colors shadow-sm block">
                    محاسبه طلای آبشده ←
                </a>
            </div>

            {{-- ابزار ۷: تبدیل عیار --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4 md:col-span-2 lg:col-span-1">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-2xl bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center text-lg">🔄</span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-teal-500/10 text-teal-700 dark:text-teal-300">طلا و نقره</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                        تبدیل عیار طلا و نقره (۷۰۵ تا ۹۹۹)
                    </h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        فرمول استاندارد تبدیل وزن عیارهای مختلف طلا (۷۰۵، ۷۴۰، ۷۵۰، ۸۷۵، ۹۹۹) و عیارهای نقره ۹۲۵ و ۹۹۵ به معادل ۱۸ عیار استاندارد.
                    </p>
                </div>
                <a href="/tools/karat-converter" class="w-full py-3 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs text-center transition-colors shadow-sm block">
                    تبدیل عیارهای طلا و نقره ←
                </a>
            </div>

        </div>
    </div>

    {{-- جدول مقایسه و راهنمای جامع ابزارها --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
            <span>جدول راهنمای انتخاب ابزار مناسب در صنف طلا و جواهر</span>
        </h2>
        <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead class="bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold">
                    <tr>
                        <th class="p-3.5">عنوان ابزار</th>
                        <th class="p-3.5">پارامترهای ورودی</th>
                        <th class="p-3.5">خروجی محاسباتی</th>
                        <th class="p-3.5">کاربر اصلی</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold"><a href="/tools/gold-price-calculator" class="text-amber-600 dark:text-amber-400 hover:underline">محاسبه قیمت طلا با اجرت</a></td>
                        <td class="p-3.5">وزن، اجرت ساخت، نرخ روز ۱۸</td>
                        <td class="p-3.5">تفکیک طلای خام، سود، اجرت و مالیات</td>
                        <td class="p-3.5">خریدار زیورآلات و طلافروش ویترین</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold"><a href="/tools/coin-bubble" class="text-amber-600 dark:text-amber-400 hover:underline">حباب سنج انواع سکه</a></td>
                        <td class="p-3.5">نوع سکه، قیمت روز بازار، انس</td>
                        <td class="p-3.5">ارزش ذاتی، حباب تومانی و درصد حباب</td>
                        <td class="p-3.5">سرمایه‌گذاران سکه و صرافان</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold"><a href="/tools/wage-calculator" class="text-amber-600 dark:text-amber-400 hover:underline">محاسبه اجرت ساخت</a></td>
                        <td class="p-3.5">نوع مصنوع، وزن، درصد یا تومان اجرت</td>
                        <td class="p-3.5">اجرت کل، سود ۷ درصد و مالیات اجرت</td>
                        <td class="p-3.5">کارگاه‌های طلاسازی و خریداران</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold"><a href="/tools/second-hand-gold" class="text-amber-600 dark:text-amber-400 hover:underline">قیمت‌گذاری طلای دست دوم</a></td>
                        <td class="p-3.5">وزن ناخالص، کسر افت، نرخ خام</td>
                        <td class="p-3.5">مبلغ نهایی خرید منصفانه</td>
                        <td class="p-3.5">فروشندگان طلای کارکرده و طلافروش</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold"><a href="/tools/mesghal" class="text-amber-600 dark:text-amber-400 hover:underline">تبدیل مظنه به گرم</a></td>
                        <td class="p-3.5">مظنه روز مثقال ۱۷ عیار</td>
                        <td class="p-3.5">قیمت دقیق یک گرم طلای ۱۸ عیار</td>
                        <td class="p-3.5">بنکداران و مغازه‌داران</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold"><a href="/tools/melted-gold" class="text-amber-600 dark:text-amber-400 hover:underline">محاسبه طلای آبشده</a></td>
                        <td class="p-3.5">وزن ترازوی آبشده، عیار خط ری‌گیری</td>
                        <td class="p-3.5">وزن تبدیل‌شده به عیار ۷۵۰ و ارزش کل</td>
                        <td class="p-3.5">معامله‌گران آبشده و کیفی‌ها</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="p-3.5 font-bold"><a href="/tools/karat-converter" class="text-amber-600 dark:text-amber-400 hover:underline">تبدیل عیار طلا و نقره</a></td>
                        <td class="p-3.5">وزن اولیه، عیار مبدا، عیار مقصد</td>
                        <td class="p-3.5">وزن معادل در عیار مقصد</td>
                        <td class="p-3.5">ریخته‌گران، آزمایشگاه‌ها و کارگاه‌ها</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- محتوای آموزشی سئو درباره فرمول‌های ۴ گانه صنف طلا --}}
    <div class="glass-panel p-8 sm:p-12 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-6 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
            فرمول رسمی و قانونی محاسبه قیمت طلا در طلافروشی‌ها چیست؟
        </h2>
        <p>
            در بازار طلای کشور، فاکتور رسمی فروش طلا از جمع چهار بخش مشخص تشکیل می‌شود:
        </p>
        <ol class="list-decimal list-inside space-y-2 text-slate-700 dark:text-slate-300">
            <li><strong>ارزش طلای خام:</strong> حاصل‌ضرب وزن دقیق قطعه طلا (گرم) در قیمت روز هر گرم طلای ۱۸ عیار استاندارد (۷۵۰).</li>
            <li><strong>اجرت ساخت کارگاه:</strong> درصدی از ارزش طلای خام که به عنوان دستمزد طراحی و ساخت به کارگاه تعلق می‌گیرد (معمولاً بین ۸ تا ۲۵ درصد). برای بررسی جزئیات، مقاله <a href="/guides/goldsmith-legal-profit" class="text-amber-600 dark:text-amber-400 font-bold hover:underline">سود قانونی طلافروشی</a> را بخوانید.</li>
            <li><strong>سود طلافروش:</strong> طبق مصوبه مصوب صنف طلا و جواهر، دقیقاً معادل ۷ درصد از جمع طلای خام و اجرت ساخت است.</li>
            <li><strong>مالیات بر ارزش افزوده (VAT):</strong> مطابق ماده ۲۶ قانون مالیات مصوب دی‌ماه ۱۴۰۰، اصل طلای خام از مالیات معاف بوده و مالیات ۹ درصدی تنها به جمع «اجرت ساخت + سود طلافروش» تعلق می‌گیرد.</li>
        </ol>

        <div class="pt-6 border-t border-slate-200 dark:border-slate-800 space-y-3">
            <h3 class="text-base font-bold text-slate-900 dark:text-white">
                چرا طلالایو ابزارهای آنلاین را در اختیار عموم و طلافروشان قرار داده است؟
            </h3>
            <p>
                شفافیت قیمت‌گذاری، جلب اعتماد مشتریان گالری و جلوگیری از اشتباهات محاسباتی هدف اصلی توسعه ابزارهای طلالایو است. طلافروشان گرامی علاوه بر استفاده از این ابزارها، می‌توانند با راه‌اندازی <a href="/smart-gold-board" class="text-amber-600 dark:text-amber-400 font-bold hover:underline">تابلوی هوشمند طلافروشی</a> روی تلویزیون مغازه، تمامی این نرخ‌ها را به صورت خودکار و لحظه‌ای در معرض دید مراجعین قرار دهند.
            </p>
        </div>
    </div>

    {{-- CTA میانی --}}
    @include('partials.cta-inline', [
        'title' => 'تمامی نرخ‌های روز و ابزارها را روی تلویزیون مغازه داشته باشید',
        'subtitle' => 'با سامانه ابری طلالایو، بدون نیاز به مینی‌کیس، تلویزیون گالری خود را به تابلوی مدرن اعلام نرخ تبدیل کنید.',
        'buttonText' => '۱۴ روز تست کاملاً رایگان',
        'buttonUrl' => route('admin.register')
    ])

    {{-- مطالب مرتبط --}}
    @include('partials.related-links', [
        'links' => [
            [
                'url' => '/tools/gold-price-calculator',
                'title' => 'محاسبه قیمت طلا با اجرت و مالیات',
                'desc' => 'ماشین‌حساب آنلاین فاکتور رسمی طلا با سود ۷ درصد و مالیات ۹ درصد اجرت.'
            ],
            [
                'url' => '/tools/coin-bubble',
                'title' => 'حباب سنج سکه بانکی',
                'desc' => 'آنالیز ارزش ذاتی و حباب ۵ نوع سکه بهار آزادی، نیم، ربع و گرمی.'
            ],
            [
                'url' => '/smart-gold-board',
                'title' => 'تابلوی هوشمند طلافروشی روی تلویزیون',
                'desc' => 'نمایشگر دیجیتال قیمت طلا و سکه بدون نیاز به مینی‌کیس و کابل‌کشی.'
            ]
        ]
    ])

</div>
@endsection
