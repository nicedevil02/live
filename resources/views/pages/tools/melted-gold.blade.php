@extends('layouts.public')

@section('title', 'محاسبه طلای آب‌شده | محاسبه وزن شرطی و عیار انگ ری‌گیری | طلالایو')
@section('meta_description', 'ابزار آنلاین محاسبه طلای آب‌شده برای تبدیل وزن و عیار انگ ری‌گیری به وزن شرطی ۷۵۰ با نرخ لحظه‌ای به همراه تحلیل مفهوم آبشده نقدی و تفاوت با نرخ اتحادیه.')
@section('canonical', 'https://talalive.ir/tools/melted-gold')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "محاسبه‌گر تخصصی طلای آب شده و طلای آبشده",
      "alternateName": [
        "طلای آب شده",
        "طلای آبشده",
        "آبشده نقدی",
        "محاسبه طلای آب شده",
        "فرمول طلای آبشده",
        "محاسبه آنلاین طلای آب شده"
      ],
      "url": "https://talalive.ir/tools/melted-gold",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار محاسبه وزن شرطی و ارزش قطعات طلای آب شده بر اساس عیار ری‌گیری و نرخ روز طلای ۱۸ عیار و تابلوی آبشده نقدی."
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
          "name": "ابزارها",
          "item": "https://talalive.ir/gold-calculator"
        },
        {
          "@@type": "ListItem",
          "position": 3,
          "name": "محاسبه‌گر طلای آب شده",
          "item": "https://talalive.ir/tools/melted-gold"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-8 sm:py-14 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-10 relative">

    @include('partials.breadcrumb', [
        'items' => [
            ['title' => 'ابزارها', 'url' => route('public.gold-calculator')],
            ['title' => 'محاسبه‌گر طلای آب شده'],
        ]
    ])

    {{-- هدر صفحه با هاله نور طلایی --}}
    <div class="relative text-center space-y-4 max-w-2xl mx-auto">
        <div class="tl-ambient-gold -top-24 left-1/2 -translate-x-1/2 w-80 h-80 opacity-60"></div>
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full tl-glass-badge text-amber-700 dark:text-amber-400 text-xs font-bold">
            <x-ui-icon name="bullion" class="w-3.5 h-3.5" />
            <span>ابزار استاندارد معاملات بنکداری و کیفی‌های طلا • سال ۱۴۰۵</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-stone-900 dark:text-white leading-tight">
            محاسبه‌گر آنلاین طلای آب شده و آبشده نقدی <br>
            <span class="text-amber-700 dark:text-amber-400">تبدیل عیار انگ به وزن شرطی ۱۸ عیار (۷۵۰)</span>
        </h1>
        <p class="text-stone-600 dark:text-stone-400 text-sm">
            محاسبه آنی ارزش ریالی بر اساس نرخ روز طلای ۱۸ عیار و تابلوی بازار بنکداران
        </p>
        <div class="pt-2">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl tl-neu-inset text-xs text-stone-600 dark:text-stone-300">
                <span>نرخ تابلوی هر گرم طلای ۱۸ عیار:</span>
                <strong class="text-amber-700 dark:text-amber-400 font-mono font-bold">{{ number_format($rates['gold18']) }} تومان</strong>
                <span class="text-stone-400 text-[11px]">(بروزرسانی: {{ $lastUpdated }})</span>
            </span>
        </div>
    </div>

    {{-- ویجت آلپاین طلای آبشده با شاسی نئومورفیک --}}
    <div x-data="{
        rawWeight: 50.25,
        engKarat: 735,
        gold18Rate: {{ $rates['gold18'] > 0 ? $rates['gold18'] : 4500000 }},
        get conditionalWeight() {
            const w = parseFloat(this.rawWeight) || 0;
            const k = parseFloat(this.engKarat) || 750;
            return parseFloat(((w * k) / 750).toFixed(3));
        },
        get totalValue() {
            return Math.round(this.conditionalWeight * (parseFloat(this.gold18Rate) || 0));
        },
        formatNumber(num) {
            return (num || 0).toLocaleString('fa-IR');
        }
    }" class="tl-neu-card rounded-3xl p-6 sm:p-10 space-y-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="space-y-2">
                <label for="raw-weight-input" class="block text-xs font-bold text-stone-700 dark:text-stone-300">وزن ترازوی آبشده (گرم):</label>
                <input id="raw-weight-input" type="number" step="0.01" min="0.01" x-model.number="rawWeight" class="min-h-11 w-full px-4 py-2.5 rounded-2xl tl-neu-inset text-stone-900 dark:text-white font-mono font-bold text-base focus:outline-none focus:ring-2 focus:ring-amber-500/40 transition-all tabular-nums">
            </div>

            <div class="space-y-2">
                <label for="eng-karat-input" class="block text-xs font-bold text-stone-700 dark:text-stone-300">عیار انگ ری‌گیری (مثلاً ۷۳۵ یا ۷۶۰):</label>
                <input id="eng-karat-input" type="number" step="1" min="100" max="1000" x-model.number="engKarat" class="min-h-11 w-full px-4 py-2.5 rounded-2xl tl-neu-inset text-stone-900 dark:text-white font-mono font-bold text-base focus:outline-none focus:ring-2 focus:ring-amber-500/40 transition-all tabular-nums">
            </div>

            <div class="space-y-2">
                <label for="gold18-rate-input" class="block text-xs font-bold text-stone-700 dark:text-stone-300">قیمت هر گرم ۱۸ عیار (تومان):</label>
                <input id="gold18-rate-input" type="number" step="1000" min="10000" x-model.number="gold18Rate" class="min-h-11 w-full px-4 py-2.5 rounded-2xl tl-neu-inset text-stone-900 dark:text-white font-mono font-bold text-base focus:outline-none focus:ring-2 focus:ring-amber-500/40 transition-all tabular-nums">
            </div>
        </div>

        {{-- خروجی محاسبات آبشده با نمایشگر OLED و انعکاس نور --}}
        <div class="rounded-3xl tl-oled-readout p-6 sm:p-8 space-y-4 relative overflow-hidden">
            <div class="tl-screen-glare"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 relative z-10">
                <div class="p-5 rounded-2xl bg-white/5 border border-white/10">
                    <span class="text-xs text-stone-400">وزن شرطی (معادل طلای ۱۸ عیار ۷۵۰):</span>
                    <div class="text-2xl sm:text-3xl font-black text-amber-400 mt-2 font-mono tabular-nums">
                        <span x-text="conditionalWeight"></span> گرم
                    </div>
                </div>
                <div class="p-5 rounded-2xl bg-white/5 border border-white/10">
                    <span class="text-xs text-stone-400">ارزش کل قطعه آبشده:</span>
                    <div class="text-2xl sm:text-3xl font-black text-emerald-400 mt-2 font-mono tabular-nums">
                        <span x-text="formatNumber(totalValue)"></span> تومان
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- بخش تحلیلی: مفهوم آبشده نقدی و نسبتش با نرخ اتحادیه --}}
    <section class="space-y-6">
        <div class="text-center space-y-3">
            <h2 class="text-2xl font-black text-stone-900 dark:text-white">
                مفهوم «آبشده نقدی» و نسبتش با نرخ مصوب اتحادیه
            </h2>
            <p class="text-stone-600 dark:text-stone-400 text-xs sm:text-sm max-w-3xl mx-auto">
                در بازار طلا دو نرخ برای طلای آبشده مطرح است: نرخ تابلوی اعلامی اتحادیه و نرخ آبشده نقدی سبزه میدان؛ تفاوت این دو مفهوم در چیست؟
            </p>
        </div>

        <div class="grid sm:grid-cols-2 gap-6">
            <div class="p-6 rounded-3xl tl-neu-card space-y-3">
                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-700 dark:text-amber-400 text-[11px] font-bold">معاملات زنده سبزه میدان</span>
                <h3 class="text-base font-black text-stone-900 dark:text-white">آبشده نقدی چیست؟</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    <strong>آبشده نقدی</strong> به نرخ معامله لحظه‌ای و تسویه نقدی شمش‌های آبشده دارای انگ معتبر در بازار عمده‌فروشی (سبزه میدان و راسته زرگران) گفته می‌شود. این نرخ ثانیه‌ای و بر اساس نوسانات لحظه‌ای عرضه و تقاضا، نرخ تتر و اونس طلا نوسان می‌کند و معامله‌گران بزرگ بر مبنای آن حساب‌های خود را تسویه می‌کنند.
                </p>
            </div>

            <div class="p-6 rounded-3xl tl-neu-card space-y-3">
                <span class="px-2.5 py-1 rounded-full bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 text-[11px] font-bold">نرخ رسمی پایگاه اتحادیه</span>
                <h3 class="text-base font-black text-stone-900 dark:text-white">نسبت با نرخ اتحادیه</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    نرخ اتحادیه معمولاً یک بار در روز در ساعات ظهر کشف و منتشر می‌شود و به عنوان مرجع نظارتی اصناف کاربرد دارد. اما آبشده نقدی به دلیل تغییرات پیوسته بازار در طول روز می‌تواند بالاتر یا پایین‌تر از نرخ اتحادیه معامله شود. طلالایو در <a href="{{ route('public.online-gold-price-board') }}" class="text-amber-700 dark:text-amber-400 font-bold hover:underline">تابلو آنلاین قیمت طلا</a> هر دو نرخ را همزمان بروزرسانی می‌کند.
                </p>
            </div>
        </div>
    </section>

    {{-- جدول مقایسه آبشده نقدی، آبشده شرطی و شمش استاندارد --}}
    <section class="space-y-4">
        <h3 class="text-lg font-black text-stone-900 dark:text-white">
            جدول مقایسه آبشده نقدی، آبشده شرطی و شمش استاندارد
        </h3>
        <div class="overflow-x-auto rounded-3xl tl-neu-card">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead class="bg-stone-100 dark:bg-stone-800/80 text-stone-900 dark:text-white font-bold border-b border-stone-200 dark:border-stone-800">
                    <tr>
                        <th class="p-4 sm:p-5">نوع طلای خام</th>
                        <th class="p-4 sm:p-5 text-amber-700 dark:text-amber-400">وضعیت انگ و عیار</th>
                        <th class="p-4 sm:p-5">مبنای تسویه مالی</th>
                        <th class="p-4 sm:p-5">وضعیت اجرت و مالیات</th>
                        <th class="p-4 sm:p-5">کاربرد اصلی در صنف</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 dark:divide-stone-800 text-stone-700 dark:text-stone-300">
                    <tr class="hover:bg-stone-50 dark:hover:bg-stone-800/40">
                        <td class="p-4 sm:p-5 font-bold">آبشده نقدی</td>
                        <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-bold">دارای کد انگ رسمی و جواب قطعی</td>
                        <td class="p-4 sm:p-5 text-xs text-stone-500 dark:text-stone-400">تسویه آنی طبق نرخ زنده سبزه میدان</td>
                        <td class="p-4 sm:p-5 text-xs text-emerald-700 dark:text-emerald-400 font-bold">معاف از اجرت و ۹٪ ارزش افزوده</td>
                        <td class="p-4 sm:p-5 text-xs text-stone-500 dark:text-stone-400">پشتوانه ویترین و دادوستد بنکداری</td>
                    </tr>
                    <tr class="hover:bg-stone-50 dark:hover:bg-stone-800/40">
                        <td class="p-4 sm:p-5 font-bold">آبشده شرطی</td>
                        <td class="p-4 sm:p-5 text-amber-700 dark:text-amber-400 font-bold">فاقد انگ یا مشکوک به ناهمگنی</td>
                        <td class="p-4 sm:p-5 text-xs text-stone-500 dark:text-stone-400">تسویه موقت بر مبنای عیار ۷۵۰ تا دریافت جواب</td>
                        <td class="p-4 sm:p-5 text-xs text-emerald-700 dark:text-emerald-400 font-bold">معاف از اجرت و مالیات</td>
                        <td class="p-4 sm:p-5 text-xs text-stone-500 dark:text-stone-400">خرید طلای ضایعاتی از همکاران صنف</td>
                    </tr>
                    <tr class="hover:bg-stone-50 dark:hover:bg-stone-800/40">
                        <td class="p-4 sm:p-5 font-bold">شمش استاندارد ۲۴ عیار</td>
                        <td class="p-4 sm:p-5 text-stone-900 dark:text-stone-100 font-bold">شمش وکیوم ۹۹۹.۹ دارای سرتیفیکیت</td>
                        <td class="p-4 sm:p-5 text-xs text-stone-500 dark:text-stone-400">قیمت بر مبنای انس جهانی و دلار آزاد</td>
                        <td class="p-4 sm:p-5 text-xs text-emerald-700 dark:text-emerald-400 font-bold">معاف از ارزش افزوده اصل طلا</td>
                        <td class="p-4 sm:p-5 text-xs text-stone-500 dark:text-stone-400">سرمایه‌گذاری کلان و ذخیره دارایی</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- راهنمای فرمول و لینک‌ها با کارت نئومورفیک --}}
    <div class="p-6 sm:p-10 rounded-3xl tl-neu-card space-y-4 text-xs sm:text-sm text-stone-600 dark:text-stone-300 leading-relaxed">
        <h3 class="font-black text-stone-900 dark:text-white text-base flex items-center gap-2">
            <x-ui-icon name="calculator" class="w-5 h-5 text-amber-700 dark:text-amber-400 shrink-0" />
            <span>فرمول محاسبه آنلاین طلای آب‌شده و وزن شرطی</span>
        </h3>
        <p>
            فرمول تبدیل وزن ترازوی طلای آب شده به وزن شرطی ۷۵۰ (معادل ۱۸ عیار استاندارد) عبارت است از:
        </p>
        <div class="p-4 rounded-2xl tl-neu-inset font-mono text-center font-bold text-amber-700 dark:text-amber-400 dir-ltr">
            وزن شرطی ۱۸ عیار = (وزن ترازو × عیار انگ) ÷ ۷۵۰
        </div>
        <p>
            از آنجا که به معاملات طلای آب شده هیچ‌گونه اجرت ساخت یا مالیات تعلق نمی‌گیرد، این ابزار مطمئن‌ترین روش برای سرمایه‌گذاران بازار طلا، بنکداران و فعالان مغازه طلا فروشی است.
        </p>
        <p class="pt-2 border-t border-stone-200 dark:border-stone-700/60">
            اگر مشتری قصد تعویض یا فروش زیورآلات مستعمل خود را دارد، راهنمای <a href="{{ route('public.guides.show', 'motefareghe-18') }}" class="text-amber-700 dark:text-amber-400 font-bold underline hover:text-amber-600">تعویض و خرید متفرقه ۱۸ چیست؟</a> را برای یادگیری نحوه کسر افت و محاسبات فاکتور مطالعه فرمایید. همچنین با ابزار تخصصی <a href="{{ route('public.tools.second-hand-gold') }}" class="text-amber-700 dark:text-amber-400 font-bold underline hover:text-amber-600">قیمت‌گذاری طلای دست دوم</a> ارزش قطعات کارکرده را پیش از ارسال به کوره ری‌گیری محاسبه نمایید. جهت آشنایی با شماره پاکت و اعتبارسنجی کدها نیز راهنمای <a href="{{ route('public.guides.show', 'gold-hallmark-inquiry') }}" class="text-amber-700 dark:text-amber-400 font-bold underline hover:text-amber-600">استعلام انگ طلا و ری‌گیری</a> در دسترس شماست.
        </p>
    </div>

    {{-- بخش مطالب و ابزارهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'ابزارها و راهنماهای مرتبط با طلای آبشده و عیارسنجی',
        'links' => [
            [
                'title' => 'تبدیل آنلاین عیار طلا',
                'desc' => 'جدول و ابزار تبدیل انواع عیارهای ۷۵۰، ۷۰۵، ۷۴۰ و ۹۹۹ به یکدیگر.',
                'url' => route('public.tools.karat-converter'),
            ],
            [
                'title' => 'قیمت‌گذاری طلای دست دوم',
                'desc' => 'محاسبه‌گر ارزش خرید طلای مستعمل پیش از ذوب و ارسال به ری‌گیری.',
                'url' => route('public.tools.second-hand-gold'),
            ],
            [
                'title' => 'استعلام انگ طلا و ری‌گیری',
                'desc' => 'راهنمای کامل خواندن شماره پاکت و عیار روی شمش آبشده.',
                'url' => route('public.guides.show', 'gold-hallmark-inquiry'),
            ],
        ]
    ])

</div>
@endsection
