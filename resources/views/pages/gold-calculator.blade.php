@extends('layouts.public')

@section('title', 'ماشین حساب طلا: ابزارهای آنلاین محاسبات طلا و سکه | طلالایو')
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
<div class="relative py-8 sm:py-14 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-12 overflow-hidden">

    {{-- هاله نور مخفی استودیویی پشت هدر ماشین‌حساب --}}
    <div class="tl-ambient-gold absolute -top-8 left-1/2 -translate-x-1/2 w-[560px] h-[220px] rounded-full opacity-75" aria-hidden="true"></div>

    <div class="relative z-10">
        @include('partials.breadcrumb', [
            'items' => [
                ['title' => 'ماشین حساب طلا'],
            ]
        ])
    </div>

    {{-- هدر صفحه و تعریف ۴۰ کلمه‌ای منبع حقیقت --}}
    <div class="relative z-10 text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full tl-glass-badge text-amber-800 dark:text-amber-300 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
            <span>متصل به نرخ‌های زنده سامانه طلالایو (آخرین بروزرسانی: {{ $lastUpdated }})</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-stone-900 dark:text-stone-50 leading-tight">
            ماشین حساب طلا و ابزارهای آنلاین محاسبات صنف طلا
        </h1>
        <p class="text-stone-700 dark:text-stone-300 text-xs sm:text-sm leading-relaxed p-5 rounded-3xl tl-glass-deck text-justify sm:text-center">
            <strong>ماشین حساب طلا</strong> مجموعه‌ای از ابزارهای آنلاین و تخصصی محاسباتی برای طلافروشان و خریداران است که بر مبنای فرمول‌های رسمی اتحادیه، نرخ طلای خام، سود ۷ درصد قانونی، اجرت ساخت، ارزش ذاتی و حباب سکه را شفاف و دقیق محاسبه می‌کند.
        </p>
    </div>

    {{-- نوار زنده نرخ‌های بازار نئومورفیک --}}
    <div class="relative z-10 grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3.5">
        <div class="p-4 rounded-2xl tl-neu-card-gold text-center">
            <div class="text-[11px] font-semibold text-stone-600 dark:text-stone-300">طلای ۱۸ عیار (۷۵۰)</div>
            <div class="text-sm font-black tabular-nums text-amber-700 dark:text-amber-400 mt-1">
                {{ number_format($rates['gold18']) }} <span class="text-[10px] font-semibold text-stone-600 dark:text-stone-400">تومان</span>
            </div>
        </div>
        <div class="p-4 rounded-2xl tl-neu-card text-center">
            <div class="text-[11px] font-semibold text-stone-600 dark:text-stone-400">مظنه مثقال تهران</div>
            <div class="text-sm font-black tabular-nums text-amber-700 dark:text-amber-400 mt-1">
                {{ number_format($rates['mesghal']) }} <span class="text-[10px] font-semibold text-stone-600 dark:text-stone-400">تومان</span>
            </div>
        </div>
        <div class="p-4 rounded-2xl tl-neu-card text-center">
            <div class="text-[11px] font-semibold text-stone-600 dark:text-stone-400">سکه تمام امامی</div>
            <div class="text-sm font-black tabular-nums text-stone-900 dark:text-stone-50 mt-1">
                {{ number_format($rates['coin_emami']) }} <span class="text-[10px] font-semibold text-stone-600 dark:text-stone-400">تومان</span>
            </div>
        </div>
        <div class="p-4 rounded-2xl tl-neu-card text-center">
            <div class="text-[11px] font-semibold text-stone-600 dark:text-stone-400">سکه تمام بهار آزادی</div>
            <div class="text-sm font-black tabular-nums text-stone-900 dark:text-stone-50 mt-1">
                {{ number_format($rates['coin_bahar']) }} <span class="text-[10px] font-semibold text-stone-600 dark:text-stone-400">تومان</span>
            </div>
        </div>
        <div class="p-4 rounded-2xl tl-neu-card text-center col-span-2 sm:col-span-4 lg:col-span-1">
            <div class="text-[11px] font-semibold text-stone-600 dark:text-stone-400">طلای ۲۴ عیار (۹۹۹)</div>
            <div class="text-sm font-black tabular-nums text-emerald-700 dark:text-emerald-400 mt-1">
                {{ number_format($rates['gold24']) }} <span class="text-[10px] font-semibold text-stone-600 dark:text-stone-400">تومان</span>
            </div>
        </div>
    </div>

    {{-- کارت‌های هفت ابزار تخصصی (Hub Grid) --}}
    <div class="relative z-10 space-y-6">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-50">
                دسترسی به ۷ ابزار آنلاین محاسبات طلا و مسکوکات
            </h2>
            <p class="text-stone-600 dark:text-stone-400 text-xs sm:text-sm">
                ابزار مورد نظر خود را انتخاب کنید و محاسبات را به صورت تعاملی و متصل به نرخ‌های روز انجام دهید
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- ابزار ۱: فاکتور طلا (پیشنهاد ویژه) --}}
            <div class="tl-neu-card-gold rounded-3xl p-6 sm:p-7 flex flex-col justify-between space-y-5">
                <div class="space-y-3.5">
                    <div class="flex items-center justify-between">
                        <span class="w-11 h-11 rounded-2xl tl-neu-icon-orb flex items-center justify-center text-amber-700 dark:text-amber-400">
                            @include('partials.ui-icon', ['name' => 'calculator', 'class' => 'w-5 h-5'])
                        </span>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold tl-glass-badge text-amber-800 dark:text-amber-300">فرمول رسمی اتحادیه</span>
                    </div>
                    <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">
                        محاسبه قیمت طلا با اجرت و مالیات
                    </h3>
                    <p class="text-xs text-stone-600 dark:text-stone-300 leading-relaxed">
                        محاسبه دقیق فاکتور خرید طلا با تفکیک سود ۷ درصد طلافروشی، اجرت ساخت کارگاه و اعمال مالیات ۹ درصدی ارزش افزوده فقط بر سود و اجرت.
                    </p>
                </div>
                <a href="/tools/gold-price-calculator" class="min-h-11 w-full py-3 rounded-xl tl-btn-bullion font-bold text-xs inline-flex items-center justify-center gap-1.5">
                    <span>محاسبه فاکتور رسمی طلا</span>
                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                </a>
            </div>

            {{-- ابزار ۲: حباب سنج سکه --}}
            <div class="tl-neu-card rounded-3xl p-6 sm:p-7 flex flex-col justify-between space-y-5">
                <div class="space-y-3.5">
                    <div class="flex items-center justify-between">
                        <span class="w-11 h-11 rounded-2xl tl-neu-icon-orb flex items-center justify-center text-amber-700 dark:text-amber-400">
                            @include('partials.ui-icon', ['name' => 'coin', 'class' => 'w-5 h-5'])
                        </span>
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tl-neu-inset text-amber-800 dark:text-amber-300">۵ نوع سکه بانکی</span>
                    </div>
                    <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">
                        حباب سنج و حباب گیر انواع سکه
                    </h3>
                    <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                        محاسبه بلادرنگ ارزش ذاتی بر اساس طلای ۹۰۰ و درصد حباب سکه تمام امامی، بهار آزادی، نیم سکه، ربع سکه و سکه گرمی به همراه هشدار ریسک.
                    </p>
                </div>
                <a href="/tools/coin-bubble" class="min-h-11 w-full py-3 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 font-bold text-xs inline-flex items-center justify-center">
                    آنالیز حباب انواع سکه
                </a>
            </div>

            {{-- ابزار ۳: محاسبه اجرت --}}
            <div class="tl-neu-card rounded-3xl p-6 sm:p-7 flex flex-col justify-between space-y-5">
                <div class="space-y-3.5">
                    <div class="flex items-center justify-between">
                        <span class="w-11 h-11 rounded-2xl tl-neu-icon-orb flex items-center justify-center text-amber-700 dark:text-amber-400">
                            @include('partials.ui-icon', ['name' => 'hammer', 'class' => 'w-5 h-5'])
                        </span>
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tl-neu-inset text-amber-800 dark:text-amber-300">جدول درصدهای ۱۴۰۵</span>
                    </div>
                    <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">
                        محاسبه اجرت ساخت و کارمزد طلا
                    </h3>
                    <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                        محاسبه دستمزد ساخت النگو، سرویس، زنجیر و کارهای خارجی به تفکیک درصد و ریال به همراه جدول مرجع اجرت متداول مصنوعات در بازار.
                    </p>
                </div>
                <a href="/tools/wage-calculator" class="min-h-11 w-full py-3 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 font-bold text-xs inline-flex items-center justify-center">
                    محاسبه اجرت ساخت طلا
                </a>
            </div>

            {{-- ابزار ۴: طلای دست دوم --}}
            <div class="tl-neu-card rounded-3xl p-6 sm:p-7 flex flex-col justify-between space-y-5">
                <div class="space-y-3.5">
                    <div class="flex items-center justify-between">
                        <span class="w-11 h-11 rounded-2xl tl-neu-icon-orb flex items-center justify-center text-amber-700 dark:text-amber-400">
                            @include('partials.ui-icon', ['name' => 'refresh', 'class' => 'w-5 h-5'])
                        </span>
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tl-neu-inset text-amber-800 dark:text-amber-300">طلای مستعمل و کم‌اجرت</span>
                    </div>
                    <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">
                        قیمت‌گذاری طلای دست دوم و مستعمل
                    </h3>
                    <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                        محاسبه ارزش خرید طلای کارکرده بدون اجرت با احتساب کسر افت وزنی سنگ و نگین، سود مجاز ۵ الی ۷ درصدی و قیمت منصفانه خرید مغازه.
                    </p>
                </div>
                <a href="/tools/second-hand-gold" class="min-h-11 w-full py-3 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 font-bold text-xs inline-flex items-center justify-center">
                    محاسبه قیمت طلای دست دوم
                </a>
            </div>

            {{-- ابزار ۵: مظنه به گرم --}}
            <div class="tl-neu-card rounded-3xl p-6 sm:p-7 flex flex-col justify-between space-y-5">
                <div class="space-y-3.5">
                    <div class="flex items-center justify-between">
                        <span class="w-11 h-11 rounded-2xl tl-neu-icon-orb flex items-center justify-center text-amber-700 dark:text-amber-400">
                            @include('partials.ui-icon', ['name' => 'scale', 'class' => 'w-5 h-5'])
                        </span>
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tl-neu-inset text-amber-800 dark:text-amber-300">مظنه ۱۷ به ۱۸ عیار</span>
                    </div>
                    <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">
                        تبدیل مظنه مثقال به گرم طلای ۱۸ عیار
                    </h3>
                    <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                        تبدیل ریاضی یک مثقال طلای ۱۷ عیار (۴.۳۳۱۸ گرم) به قیمت یک گرم طلای ۱۸ عیار (۷۵۰) با فرمول دقیق تقسیم بر ۴.۳۳۱۸ و ۴.۶۰۸.
                    </p>
                </div>
                <a href="/tools/mesghal" class="min-h-11 w-full py-3 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 font-bold text-xs inline-flex items-center justify-center">
                    تبدیل مثقال به گرم
                </a>
            </div>

            {{-- ابزار ۶: طلای آبشده --}}
            <div class="tl-neu-card rounded-3xl p-6 sm:p-7 flex flex-col justify-between space-y-5">
                <div class="space-y-3.5">
                    <div class="flex items-center justify-between">
                        <span class="w-11 h-11 rounded-2xl tl-neu-icon-orb flex items-center justify-center text-amber-700 dark:text-amber-400">
                            @include('partials.ui-icon', ['name' => 'bullion', 'class' => 'w-5 h-5'])
                        </span>
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tl-neu-inset text-amber-800 dark:text-amber-300">انگ و ری‌گیری</span>
                    </div>
                    <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">
                        محاسبه طلای آبشده و خط آزمایشگاه
                    </h3>
                    <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                        تبدیل وزن و عیار اعلامی آزمایشگاه ری‌گیری به طلای ۱۸ عیار استاندارد، محاسبه ارزش ریالی خط آبشده و استعلام شماره پاکت.
                    </p>
                </div>
                <a href="/tools/melted-gold" class="min-h-11 w-full py-3 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 font-bold text-xs inline-flex items-center justify-center">
                    محاسبه طلای آبشده
                </a>
            </div>

            {{-- ابزار ۷: تبدیل عیار --}}
            <div class="tl-neu-card rounded-3xl p-6 sm:p-7 flex flex-col justify-between space-y-5 md:col-span-2 lg:col-span-1">
                <div class="space-y-3.5">
                    <div class="flex items-center justify-between">
                        <span class="w-11 h-11 rounded-2xl tl-neu-icon-orb flex items-center justify-center text-amber-700 dark:text-amber-400">
                            @include('partials.ui-icon', ['name' => 'exchange', 'class' => 'w-5 h-5'])
                        </span>
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tl-neu-inset text-amber-800 dark:text-amber-300">طلا و نقره</span>
                    </div>
                    <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">
                        تبدیل عیار طلا و نقره (۷۰۵ تا ۹۹۹)
                    </h3>
                    <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                        فرمول استاندارد تبدیل وزن عیارهای مختلف طلا (۷۰۵، ۷۴۰، ۷۵۰، ۸۷۵، ۹۹۹) و عیارهای نقره ۹۲۵ و ۹۹۵ به معادل ۱۸ عیار استاندارد.
                    </p>
                </div>
                <a href="/tools/karat-converter" class="min-h-11 w-full py-3 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 font-bold text-xs inline-flex items-center justify-center">
                    تبدیل عیارهای طلا و نقره
                </a>
            </div>

        </div>
    </div>

    {{-- جدول مقایسه و راهنمای جامع ابزارها --}}
    <div class="relative z-10 tl-neu-card rounded-3xl p-6 sm:p-10 space-y-6">
        <h2 class="text-xl font-bold text-stone-900 dark:text-stone-50 flex items-center gap-2.5">
            <span class="w-9 h-9 rounded-xl tl-neu-icon-orb flex items-center justify-center text-amber-700 dark:text-amber-400">
                @include('partials.ui-icon', ['name' => 'sliders', 'class' => 'w-4 h-4'])
            </span>
            <span>جدول راهنمای انتخاب ابزار مناسب در صنف طلا و جواهر</span>
        </h2>
        <div class="overflow-x-auto rounded-2xl tl-neu-inset p-1.5">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead class="text-stone-900 dark:text-stone-100 font-bold border-b border-stone-300/60 dark:border-stone-800">
                    <tr>
                        <th class="p-3.5">عنوان ابزار</th>
                        <th class="p-3.5">پارامترهای ورودی</th>
                        <th class="p-3.5">خروجی محاسباتی</th>
                        <th class="p-3.5">کاربر اصلی</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-300/50 dark:divide-stone-800/70 text-stone-700 dark:text-stone-300">
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-3.5 font-bold"><a href="/tools/gold-price-calculator" class="text-amber-700 dark:text-amber-400 hover:underline">محاسبه قیمت طلا با اجرت</a></td>
                        <td class="p-3.5">وزن، اجرت ساخت، نرخ روز ۱۸</td>
                        <td class="p-3.5">تفکیک طلای خام، سود، اجرت و مالیات</td>
                        <td class="p-3.5">خریدار زیورآلات و طلافروش ویترین</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-3.5 font-bold"><a href="/tools/coin-bubble" class="text-amber-700 dark:text-amber-400 hover:underline">حباب سنج انواع سکه</a></td>
                        <td class="p-3.5">نوع سکه، قیمت روز بازار، انس</td>
                        <td class="p-3.5">ارزش ذاتی، حباب تومانی و درصد حباب</td>
                        <td class="p-3.5">سرمایه‌گذاران سکه و صرافان</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-3.5 font-bold"><a href="/tools/wage-calculator" class="text-amber-700 dark:text-amber-400 hover:underline">محاسبه اجرت ساخت</a></td>
                        <td class="p-3.5">نوع مصنوع، وزن، درصد یا تومان اجرت</td>
                        <td class="p-3.5">اجرت کل، سود ۷ درصد و مالیات اجرت</td>
                        <td class="p-3.5">کارگاه‌های طلاسازی و خریداران</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-3.5 font-bold"><a href="/tools/second-hand-gold" class="text-amber-700 dark:text-amber-400 hover:underline">قیمت‌گذاری طلای دست دوم</a></td>
                        <td class="p-3.5">وزن ناخالص، کسر افت، نرخ خام</td>
                        <td class="p-3.5">مبلغ نهایی خرید منصفانه</td>
                        <td class="p-3.5">فروشندگان طلای کارکرده و طلافروش</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-3.5 font-bold"><a href="/tools/mesghal" class="text-amber-700 dark:text-amber-400 hover:underline">تبدیل مظنه به گرم</a></td>
                        <td class="p-3.5">مظنه روز مثقال ۱۷ عیار</td>
                        <td class="p-3.5">قیمت دقیق یک گرم طلای ۱۸ عیار</td>
                        <td class="p-3.5">بنکداران و مغازه‌داران</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-3.5 font-bold"><a href="/tools/melted-gold" class="text-amber-700 dark:text-amber-400 hover:underline">محاسبه طلای آبشده</a></td>
                        <td class="p-3.5">وزن ترازوی آبشده، عیار خط ری‌گیری</td>
                        <td class="p-3.5">وزن تبدیل‌شده به عیار ۷۵۰ و ارزش کل</td>
                        <td class="p-3.5">معامله‌گران آبشده و کیفی‌ها</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-3.5 font-bold"><a href="/tools/karat-converter" class="text-amber-700 dark:text-amber-400 hover:underline">تبدیل عیار طلا و نقره</a></td>
                        <td class="p-3.5">وزن اولیه، عیار مبدا، عیار مقصد</td>
                        <td class="p-3.5">وزن معادل در عیار مقصد</td>
                        <td class="p-3.5">ریخته‌گران، آزمایشگاه‌ها و کارگاه‌ها</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- محتوای آموزشی سئو درباره فرمول‌های ۴ گانه صنف طلا --}}
    <div class="relative z-10 tl-neu-card p-8 sm:p-12 rounded-3xl space-y-6 text-xs sm:text-sm text-stone-600 dark:text-stone-300 leading-relaxed">
        <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-50">
            فرمول رسمی و قانونی محاسبه قیمت طلا در طلافروشی‌ها چیست؟
        </h2>
        <p>
            در بازار طلای کشور، فاکتور رسمی فروش طلا از جمع چهار بخش مشخص تشکیل می‌شود:
        </p>
        <ol class="list-decimal list-inside space-y-2.5 text-stone-700 dark:text-stone-300 p-5 rounded-2xl tl-neu-inset">
            <li><strong>ارزش طلای خام:</strong> حاصل‌ضرب وزن دقیق قطعه طلا (گرم) در قیمت روز هر گرم طلای ۱۸ عیار استاندارد (۷۵۰).</li>
            <li><strong>اجرت ساخت کارگاه:</strong> درصدی از ارزش طلای خام که به عنوان دستمزد طراحی و ساخت به کارگاه تعلق می‌گیرد (معمولاً بین ۸ تا ۲۵ درصد). برای بررسی جزئیات، مقاله <a href="/guides/goldsmith-legal-profit" class="text-amber-700 dark:text-amber-400 font-bold hover:underline">سود قانونی طلافروشی</a> را بخوانید.</li>
            <li><strong>سود طلافروش:</strong> طبق مصوبه مصوب صنف طلا و جواهر، دقیقاً معادل ۷ درصد از جمع طلای خام و اجرت ساخت است.</li>
            <li><strong>مالیات بر ارزش افزوده (VAT):</strong> مطابق ماده ۲۶ قانون مالیات مصوب دی‌ماه ۱۴۰۰، اصل طلای خام از مالیات معاف بوده و مالیات ۹ درصدی تنها به جمع «اجرت ساخت + سود طلافروش» تعلق می‌گیرد.</li>
        </ol>

        <div class="pt-6 border-t border-stone-300/60 dark:border-stone-800 space-y-3">
            <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">
                چرا طلالایو ابزارهای آنلاین را در اختیار عموم و طلافروشان قرار داده است؟
            </h3>
            <p>
                شفافیت قیمت‌گذاری، جلب اعتماد مشتریان گالری و جلوگیری از اشتباهات محاسباتی هدف اصلی توسعه ابزارهای طلالایو است. طلافروشان گرامی علاوه بر استفاده از این ابزارها، می‌توانند با راه‌اندازی <a href="/smart-gold-board" class="text-amber-700 dark:text-amber-400 font-bold hover:underline">تابلوی هوشمند طلافروشی</a> روی تلویزیون مغازه، تمامی این نرخ‌ها را به صورت خودکار و لحظه‌ای در معرض دید مراجعین قرار دهند.
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
