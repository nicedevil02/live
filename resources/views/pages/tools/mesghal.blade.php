@extends('layouts.public')

@section('title', 'تبدیل مظنه طلا و مثقال به گرم ۱۸ عیار آنلاین | فرمول مظنه طلا ۴.۳۳۱۸ | طلالایو')
@section('meta_description', 'ابزار آنلاین تبدیل مظنه طلا و یک مثقال طلای ۱۷ عیار به قیمت هر گرم طلای ۱۸ عیار با ضریب استاندارد ۴.۳۳۱۸ به همراه جدول مقایسه مظنه نقدی، فردایی و جهانی صنف طلا.')
@section('canonical', 'https://talalive.ir/tools/mesghal')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "ابزار تبدیل مظنه مثقال طلا به گرم ۱۸ عیار",
      "alternateName": [
        "تبدیل مظنه به گرم",
        "محاسبه مثقال طلا",
        "فرمول مظنه ۴.۳۳۱۸",
        "مظنه نقدی و فردایی"
      ],
      "url": "https://talalive.ir/tools/mesghal",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار تعاملی تبدیل مظنه مثقال طلای ۱۷ به قیمت هر گرم طلای ۱۸ با ضریب ۴.۳۳۱۸ اتحادیه طلا و جواهر و جدول مقایسه انواع مظنه."
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
          "name": "تبدیل مظنه به گرم",
          "item": "https://talalive.ir/tools/mesghal"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-8 sm:py-14 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-10 relative">

    @include('partials.breadcrumb', [
        'items' => [
            ['title' => 'ابزارها', 'url' => route('public.gold-calculator')],
            ['title' => 'تبدیل مظنه به گرم'],
        ]
    ])

    {{-- هدر صفحه با هاله نور طلایی --}}
    <div class="relative text-center space-y-4 max-w-2xl mx-auto">
        <div class="tl-ambient-gold -top-24 left-1/2 -translate-x-1/2 w-80 h-80 opacity-60"></div>
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full tl-glass-badge text-amber-700 dark:text-amber-400 text-xs font-bold">
            <x-ui-icon name="scale" class="w-3.5 h-3.5" />
            <span>ضریب رسمی صنف طلا و جواهر: ۴.۳۳۱۸</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-stone-900 dark:text-white leading-tight">
            تبدیل مظنه مثقال به گرم ۱۸ عیار <br>
            <span class="text-amber-700 dark:text-amber-400">و تحلیل تفاوت مظنه نقدی، فردایی و جهانی</span>
        </h1>
        <p class="text-stone-600 dark:text-stone-400 text-sm">
            محاسبه دوطرفه آنی با نرخ لحظه‌ای اتحادیه و بازار بزرگ تهران
        </p>
        <div class="pt-2">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl tl-neu-inset text-xs text-stone-600 dark:text-stone-300">
                <span>مظنه پایه بازار در سامانه:</span>
                <strong class="text-amber-700 dark:text-amber-400 font-mono font-bold">{{ number_format($rates['mesghal']) }} تومان</strong>
                <span class="text-stone-400 text-[11px]">(بروزرسانی: {{ $lastUpdated }})</span>
            </span>
        </div>
    </div>

    {{-- ویجت آلپاین تبدیل مظنه با شاسی نئومورفیک و محاسبه تعاملی دوطرفه --}}
    <div x-data="{
        mesghal: {{ $rates['mesghal'] > 0 ? $rates['mesghal'] : 19500000 }},
        factor: 4.3318,
        get gram18() { return (this.mesghal || 0) > 0 ? Math.round(this.mesghal / this.factor) : 0; },
        setFromGram(val) { this.mesghal = Math.round((parseFloat(val) || 0) * this.factor); }
    }" class="tl-neu-card rounded-3xl p-6 sm:p-10 space-y-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
            <div class="space-y-2">
                <label for="mesghal-input" class="block text-xs font-bold text-stone-700 dark:text-stone-300">مظنه ۱ مثقال طلای ۱۷ عیار (تومان):</label>
                <input id="mesghal-input" type="number" step="1000" x-model.number="mesghal" class="min-h-11 w-full px-4 py-2.5 rounded-2xl tl-neu-inset text-stone-900 dark:text-white font-mono font-bold text-lg focus:outline-none focus:ring-2 focus:ring-amber-500/40 transition-all tabular-nums">
            </div>

            <div class="space-y-2">
                <label for="gram18-input" class="block text-xs font-bold text-stone-700 dark:text-stone-300">معادل ۱ گرم طلای ۱۸ عیار (تومان):</label>
                <input id="gram18-input" type="number" step="1000" :value="gram18" @input="setFromGram($event.target.value)" class="min-h-11 w-full px-4 py-2.5 rounded-2xl tl-neu-inset text-stone-900 dark:text-white font-mono font-bold text-lg focus:outline-none focus:ring-2 focus:ring-amber-500/40 transition-all tabular-nums" placeholder="مبلغ هر گرم ۱۸ عیار">
            </div>
        </div>

        {{-- نمایشگر OLED نتایج با انعکاس نور --}}
        <div class="rounded-3xl tl-oled-readout p-6 sm:p-8 relative overflow-hidden">
            <div class="tl-screen-glare"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 relative z-10 text-center sm:text-right">
                <div class="space-y-1">
                    <span class="text-xs text-stone-400 font-bold">مظنه ۱ مثقال ۱۷ عیار:</span>
                    <div class="text-2xl sm:text-3xl font-black text-white tabular-nums font-mono" x-text="(mesghal || 0).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
                <div class="space-y-1 sm:border-r sm:border-white/10 sm:pr-6">
                    <span class="text-xs text-amber-400 font-bold">معادل هر گرم ۱۸ عیار (۷۵۰):</span>
                    <div class="text-2xl sm:text-3xl font-black text-amber-400 tabular-nums font-mono" x-text="(gram18 || 0).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
            </div>
        </div>

        <div class="p-4 sm:p-5 rounded-2xl tl-neu-inset text-xs text-stone-600 dark:text-stone-300 space-y-2">
            <div class="font-bold text-stone-800 dark:text-stone-200">فرمول ریاضی زرگری:</div>
            <div>قیمت هر گرم ۱۸ عیار = قیمت یک مثقال ۱۷ عیار ÷ ۴.۳۳۱۸</div>
            <div>قیمت یک مثقال طلا = قیمت هر گرم ۱۸ عیار × ۴.۳۳۱۸</div>
            <div class="pt-2 border-t border-stone-200 dark:border-stone-700/60 text-stone-600 dark:text-stone-300">
                ضریب ۴.۳۳۱۸ از نسبت وزن مثقال (۴.۶۰۸ گرم) ضرب در نسبت عیار ۱۷ (۷۰۵) به ۱۸ (۷۵۰) به دست می‌آید: <code>۴.۶۰۸ × (۷۰۵ ÷ ۷۵۰) = ۴.۳۳۱۸</code>.
            </div>
        </div>
    </div>

    {{-- بخش آموزشی: تعریف مظنه نقدی، فردایی و جهانی با کارت‌های نئومورفیک --}}
    <section class="space-y-6">
        <div class="text-center space-y-3">
            <h2 class="text-2xl font-black text-stone-900 dark:text-white">
                تعریف مظنه نقدی، مظنه فردایی و مظنه جهانی در صنف طلا
            </h2>
            <p class="text-stone-600 dark:text-stone-400 text-xs sm:text-sm max-w-2xl mx-auto">
                در تابلوی طلافروشی و بازار عمده‌فروشی، سه نوع مظنه کاربرد دارد که در زمان تسویه و نحوه کشف قیمت تفاوت اساسی دارند:
            </p>
        </div>

        <div class="grid sm:grid-cols-3 gap-6">
            <div class="p-6 rounded-3xl tl-neu-card space-y-3">
                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 text-[11px] font-bold">تسویه در همان روز</span>
                <h3 class="text-base font-black text-stone-900 dark:text-white">۱. مظنه نقدی تهران</h3>
                <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                    <strong>مظنه نقدی</strong> قیمت یک مثقال طلای ۱۷ عیار برای دادوستد و تسویه فیزیکی شمش یا طلای آبشده در همان روز کاری بازار است. این نرخ مرجع رسمی قیمت‌گذاری فاکتورهای ویترین و مغازه طلافروشی است.
                </p>
            </div>

            <div class="p-6 rounded-3xl tl-neu-card space-y-3">
                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-700 dark:text-amber-400 text-[11px] font-bold">معاملات اعتباری و آتی</span>
                <h3 class="text-base font-black text-stone-900 dark:text-white">۲. مظنه فردایی</h3>
                <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                    <strong>مظنه فردایی</strong> قیمت توافقی مثقال طلا برای تحویل و تسویه ریالی در پایان روز کاری بعد است. این نرخ جهت‌گیری روانی و انتظارات تورمی معامله‌گران را منعکس می‌کند. برای بررسی کامل این مفهوم، راهنمای <a href="{{ route('public.guides.show', 'mazaneh-fardaei') }}" class="text-amber-700 dark:text-amber-400 font-bold hover:underline">مظنه فردایی چیست و چه فرقی با مظنه نقدی دارد؟</a> را بخوانید.
                </p>
            </div>

            <div class="p-6 rounded-3xl tl-neu-card space-y-3">
                <span class="px-2.5 py-1 rounded-full bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 text-[11px] font-bold">معیار طلای جهانی</span>
                <h3 class="text-base font-black text-stone-900 dark:text-white">۳. مظنه جهانی طلا</h3>
                <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                    <strong>مظنه جهانی</strong> از حاصل‌ضرب قیمت هر اونس تروا در بازار بین‌المللی در قیمت لحظه‌ای تتر دیجیتال تقسیم بر ۹.۵۷۴۲ به دست می‌آید و کف تئوریک قیمت طلای داخلی بدون حباب سیاسی است.
                </p>
            </div>
        </div>
    </section>

    {{-- جدول مقایسه سه گانه انواع مظنه --}}
    <section class="space-y-4">
        <h3 class="text-lg font-black text-stone-900 dark:text-white">
            جدول مقایسه سه گانه مظنه نقدی، فردایی و جهانی در بازار طلا
        </h3>
        <div class="overflow-x-auto rounded-3xl tl-neu-card">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead class="bg-stone-100 dark:bg-stone-800/80 text-stone-900 dark:text-white font-bold border-b border-stone-200 dark:border-stone-800">
                    <tr>
                        <th class="p-4">نوع مظنه طلا</th>
                        <th class="p-4 text-amber-700 dark:text-amber-400">ساعت و روز تسویه</th>
                        <th class="p-4">مبنای محاسباتی نرخ</th>
                        <th class="p-4">نحوه اثر بر تابلوی مغازه</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 dark:divide-stone-800 text-stone-700 dark:text-stone-300">
                    <tr class="hover:bg-stone-50 dark:hover:bg-stone-800/40">
                        <td class="p-4 font-bold">مظنه نقدی تهران</td>
                        <td class="p-4 text-emerald-700 dark:text-emerald-400 font-bold">همان روز (ساعت ۱۱ تا ۱۸)</td>
                        <td class="p-4 text-stone-500 dark:text-stone-400 text-xs">معاملات واقعی طلای آبشده در سبزه میدان تهران</td>
                        <td class="p-4 text-stone-500 dark:text-stone-400 text-xs">مبنای ۱۰۰٪ قیمت فروش طلای ۱۸ عیار ویترین</td>
                    </tr>
                    <tr class="hover:bg-stone-50 dark:hover:bg-stone-800/40">
                        <td class="p-4 font-bold">مظنه فردایی</td>
                        <td class="p-4 text-amber-700 dark:text-amber-400 font-bold">ساعت ۱۷ روز بعد</td>
                        <td class="p-4 text-stone-500 dark:text-stone-400 text-xs">پیش‌بینی بازاری معامله‌گران از نرخ ارز و اونس</td>
                        <td class="p-4 text-stone-500 dark:text-stone-400 text-xs">هشدار زودهنگام برای بنکداران در خرید و فروش عصر</td>
                    </tr>
                    <tr class="hover:bg-stone-50 dark:hover:bg-stone-800/40">
                        <td class="p-4 font-bold">مظنه جهانی (انس)</td>
                        <td class="p-4 text-stone-900 dark:text-stone-100 font-bold">پیوسته و ۲۴ ساعته</td>
                        <td class="p-4 text-stone-500 dark:text-stone-400 text-xs">(انس جهانی × تتر) ÷ ۹.۵۷۴۲</td>
                        <td class="p-4 text-stone-500 dark:text-stone-400 text-xs">محاسبه حباب طلا و مقایسه قاچاق ورودی/خروجی</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- بنر فراخوان میانی --}}
    @include('partials.cta-inline', [
        'title' => 'تابلوی هوشمند طلالایو؛ نمایش خودکار مظنه و گرم ۱۸ روی تلویزیون مغازه',
        'subtitle' => 'دیگر نیازی به ضرب و تقسیم دستی مظنه ندارید. با اتصال تابلوی ابری طلالایو به تلویزیون مغازه، مظنه تهران و هر گرم ۱۸ عیار همزمان و خودکار آپدیت می‌شوند.',
        'buttonText' => 'تست رایگان ۱۴ روزه تابلوی طلالایو',
        'buttonUrl' => route('admin.register'),
        'secondaryText' => 'محاسبه طلای آبشده',
        'secondaryUrl' => route('public.tools.melted-gold'),
    ])

    {{-- بخش مطالب و ابزارهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'ابزارها و مقالات مرتبط با مظنه و محاسبات بازار طلا',
        'links' => [
            [
                'title' => 'مظنه فردایی چیست و چه فرقی با مظنه نقدی دارد؟',
                'desc' => 'بررسی تفاوت مظنه فردایی و نقدی در بازار تهران و اثر آن بر فاکتور مغازه.',
                'url' => route('public.guides.show', 'mazaneh-fardaei'),
            ],
            [
                'title' => 'فرمول دقیق محاسبه قیمت طلا ۱۸ عیار',
                'desc' => 'آموزش گام‌به‌گام محاسبه فاکتور طلا با اجرت، سود ۷٪ و ارزش افزوده.',
                'url' => route('public.guides.show', 'gold-price-formula-18k'),
            ],
            [
                'title' => 'محاسبه‌گر طلای آبشده و عیار شرطی',
                'desc' => 'تبدیل عیار ری‌گیری به وزن خطی با مظنه مثقال و نرخ طلای ۱۸ عیار.',
                'url' => route('public.tools.melted-gold'),
            ],
        ]
    ])

</div>
@endsection
