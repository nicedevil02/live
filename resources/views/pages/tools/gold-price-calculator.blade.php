@extends('layouts.public')

@section('title', 'ماشین حساب محاسبه قیمت طلا در مغازه طلا فروشی | محاسبه آنلاین طلا با اجرت | طلالایو')
@section('meta_description', 'ابزار محاسبه قیمت طلا در مغازه طلا فروشی بر اساس فرمول اتحادیه. محاسبه انلاین قیمت طلا، طلای دست دوم و کم اجرت، سود ۷٪ طلا فروشی و مالیات با نرخ لحظه ای طلالایو.')

@section('canonical', 'https://talalive.ir/tools/gold-price-calculator')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "ماشین حساب آنلاین قیمت طلا با اجرت و سود طلا فروشی",
      "alternateName": [
        "ماشین حساب طلا",
        "محاسبه قیمت طلا",
        "محاسبه انلاین طلا",
        "محاسبه طلای دست دوم",
        "محاسبه طلای کم اجرت",
        "فرمول قیمت طلا فروشی",
        "محاسبه فاکتور طلا فروشی"
      ],
      "url": "https://talalive.ir/tools/gold-price-calculator",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار محاسبه فاکتور خرید طلا با احتساب وزن، اجرت ساخت، طلای دست دوم و کم اجرت، سود ۷ درصد مغازه طلا فروشی و مالیات ۹ درصد طبق آخرین مصوبه اتحادیه طلا و جواهر."
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
          "name": "ابزارهای طلا",
          "item": "https://talalive.ir/gold-calculator"
        },
        {
          "@@type": "ListItem",
          "position": 3,
          "name": "محاسبه قیمت طلا با اجرت و مالیات",
          "item": "https://talalive.ir/tools/gold-price-calculator"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="relative py-8 sm:py-14 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-10 overflow-hidden">

    <div class="tl-ambient-gold absolute -top-8 left-1/2 -translate-x-1/2 w-[500px] h-[200px] rounded-full opacity-75" aria-hidden="true"></div>

    <div class="relative z-10">
        @include('partials.breadcrumb', [
            'items' => [
                ['title' => 'ابزارهای طلا', 'url' => route('public.gold-calculator')],
                ['title' => 'محاسبه قیمت طلا با اجرت و مالیات'],
            ]
        ])
    </div>

    <div class="relative z-10 text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full tl-glass-badge text-amber-800 dark:text-amber-300 text-xs font-bold">
            @include('partials.ui-icon', ['name' => 'receipt', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
            <span>فرمول رسمی مصوب اتحادیه طلا و جواهر کشور</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-stone-900 dark:text-stone-50 leading-tight">
            ماشین‌حساب آنلاین محاسبه قیمت طلا <br>
            <span class="text-amber-700 dark:text-amber-400">با اجرت ساخت، سود ۷٪ و مالیات ۹٪</span>
        </h1>
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl tl-neu-inset text-xs sm:text-sm text-stone-700 dark:text-stone-300">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <span>نرخ لحظه‌ای پایه: <strong class="text-amber-700 dark:text-amber-400 tabular-nums">{{ number_format($rates['gold18']) }}</strong> تومان (بروزرسانی: {{ $lastUpdated }})</span>
        </div>
    </div>

    {{-- شاسی نئومورفیک محاسبه‌گر آلپاین با نمایشگر OLED فاکتور --}}
    <div x-data="{
        weight: 4.5,
        ratePerGram: {{ $rates['gold18'] > 0 ? $rates['gold18'] : 4500000 }},
        ojratPercent: 18,
        profitPercent: 7,
        vatPercent: 9,
        get rawGoldPrice() { return (this.weight || 0) * (this.ratePerGram || 0); },
        get ojratAmount() { return this.rawGoldPrice * ((this.ojratPercent || 0) / 100); },
        get profitAmount() { return (this.rawGoldPrice + this.ojratAmount) * ((this.profitPercent || 0) / 100); },
        get vatAmount() { return (this.ojratAmount + this.profitAmount) * ((this.vatPercent || 0) / 100); },
        get finalPrice() { return this.rawGoldPrice + this.ojratAmount + this.profitAmount + this.vatAmount; }
    }" class="relative z-10 tl-neu-card rounded-3xl p-6 sm:p-10 space-y-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label for="input-weight" class="block text-xs font-bold text-stone-700 dark:text-stone-300">وزن طلا (گرم):</label>
                <input id="input-weight" type="number" step="0.01" x-model.number="weight" class="min-h-11 w-full px-4 py-3 rounded-2xl tl-neu-inset text-stone-900 dark:text-stone-50 font-bold text-base tabular-nums focus:outline-none">
            </div>
            <div class="space-y-2">
                <label for="input-rate" class="block text-xs font-bold text-stone-700 dark:text-stone-300">قیمت هر گرم طلای ۱۸ عیار (تومان):</label>
                <input id="input-rate" type="number" step="1000" x-model.number="ratePerGram" class="min-h-11 w-full px-4 py-3 rounded-2xl tl-neu-inset text-stone-900 dark:text-stone-50 font-bold text-base tabular-nums focus:outline-none">
            </div>
            <div class="space-y-2">
                <label for="input-ojrat" class="block text-xs font-bold text-stone-700 dark:text-stone-300">درصد اجرت ساخت (%):</label>
                <input id="input-ojrat" type="number" step="0.5" x-model.number="ojratPercent" class="min-h-11 w-full px-4 py-3 rounded-2xl tl-neu-inset text-stone-900 dark:text-stone-50 font-bold text-base tabular-nums focus:outline-none">
            </div>
            <div class="space-y-2">
                <label for="input-profit" class="block text-xs font-bold text-stone-700 dark:text-stone-300">سود مصوب فروشنده (قانوناً ۷٪):</label>
                <input id="input-profit" type="number" step="0.5" x-model.number="profitPercent" class="min-h-11 w-full px-4 py-3 rounded-2xl tl-neu-inset text-stone-900 dark:text-stone-50 font-bold text-base tabular-nums focus:outline-none">
            </div>
        </div>

        {{-- ریز اقلام فاکتور خرید در شیارهای نئومورفیک --}}
        <div class="space-y-3">
            <div class="text-xs font-bold text-stone-600 dark:text-stone-400">ریز اقلام فاکتور خرید:</div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 text-xs">
                <div class="p-4 rounded-2xl tl-neu-inset">
                    <span class="text-stone-600 dark:text-stone-400">طلای خام:</span>
                    <div class="font-black text-stone-900 dark:text-stone-100 mt-1 tabular-nums text-sm" x-text="Math.round(rawGoldPrice).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
                <div class="p-4 rounded-2xl tl-neu-inset">
                    <span class="text-stone-600 dark:text-stone-400">مبلغ اجرت:</span>
                    <div class="font-black text-stone-900 dark:text-stone-100 mt-1 tabular-nums text-sm" x-text="Math.round(ojratAmount).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
                <div class="p-4 rounded-2xl tl-neu-inset">
                    <span class="text-stone-600 dark:text-stone-400">سود فروشنده:</span>
                    <div class="font-black text-stone-900 dark:text-stone-100 mt-1 tabular-nums text-sm" x-text="Math.round(profitAmount).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
                <div class="p-4 rounded-2xl tl-neu-inset">
                    <span class="text-stone-600 dark:text-stone-400">مالیات ۹٪ (اجرت+سود):</span>
                    <div class="font-black text-rose-700 dark:text-rose-400 mt-1 tabular-nums text-sm" x-text="Math.round(vatAmount).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
            </div>
        </div>

        {{-- نمایشگر سخت‌افزاری OLED مبلغ کل فاکتور نهایی --}}
        <div class="tl-oled-readout rounded-3xl p-6 sm:p-7">
            <div class="tl-screen-glare absolute inset-0" aria-hidden="true"></div>
            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <span class="text-[11px] font-bold text-amber-400 block mb-0.5">خروجی دقیق اتحادیه</span>
                    <span class="font-black text-stone-50 text-base sm:text-lg">مبلغ کل فاکتور نهایی قابل پرداخت:</span>
                </div>
                <span class="text-2xl sm:text-3xl font-black text-amber-400 tabular-nums" x-text="Math.round(finalPrice).toLocaleString('fa-IR') + ' تومان'"></span>
            </div>
        </div>
    </div>

    {{-- بنر تبدیل به مشتری B2B --}}
    <div class="relative z-10 rounded-3xl tl-neu-card-gold p-8 text-center space-y-4">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 mx-auto">
            @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-6 h-6'])
        </div>
        <h3 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-50">آیا صاحب گالری یا طلافروشی هستید؟</h3>
        <p class="text-stone-600 dark:text-stone-300 text-sm max-w-2xl mx-auto leading-relaxed">
            همین فرمول‌ها و سود فروش را به صورت خودکار روی تلویزیون مغازه خود بدون نیاز به کیس نمایش دهید.
        </p>
        <div class="pt-2">
            <a href="{{ route('admin.register') }}" class="min-h-11 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl tl-btn-bullion font-black text-xs">
                <span>راه‌اندازی فوری تابلوی طلا مغازه (۱۴ روز رایگان)</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
            </a>
        </div>
    </div>

    {{-- بخش ابزارها و راهنماهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'سایر ابزارها و راهنماهای تخصصی طلا',
        'links' => [
            [
                'title' => 'ماشین‌حساب محاسبه اجرت طلا',
                'desc' => 'محاسبه درصدی و مبلغی اجرت ساخت به همراه جدول درصد اجرت انواع مصنوعات سال ۱۴۰۵.',
                'url' => route('public.tools.wage-calculator'),
            ],
            [
                'title' => 'سود قانونی طلافروشی چند درصد است؟',
                'desc' => 'راهنمای مصوبه رسمی اتحادیه پیرامون سقف سود ۷ درصدی و مالیات طلا.',
                'url' => route('public.guides.show', 'goldsmith-legal-profit'),
            ],
            [
                'title' => 'تابلوی هوشمند طلافروشی',
                'desc' => 'فرمول‌ساز خودکار سود و مالیات روی تلویزیون مغازه بدون نیاز به سخت‌افزار.',
                'url' => route('public.smart-gold-board'),
            ],
        ]
    ])

</div>
@endsection
