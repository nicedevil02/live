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
<div class="py-8 sm:py-14 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-10">

    @include('partials.breadcrumb', [
        'items' => [
            ['title' => 'ابزارهای طلا', 'url' => route('public.gold-calculator')],
            ['title' => 'محاسبه قیمت طلا با اجرت و مالیات'],
        ]
    ])

    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-700 dark:text-amber-300 text-xs font-bold">
            <span>فرمول رسمی مصوب اتحادیه طلا و جواهر کشور</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-stone-900 dark:text-white leading-tight">
            ماشین‌حساب آنلاین محاسبه قیمت طلا <br>
            <span class="text-amber-600 dark:text-amber-400">با اجرت ساخت، سود ۷٪ و مالیات ۹٪</span>
        </h1>
        <p class="text-stone-600 dark:text-stone-400 text-sm sm:text-base">
            نرخ لحظه‌ای پایه: <strong class="text-amber-700 dark:text-amber-400 font-mono">{{ number_format($rates['gold18']) }}</strong> تومان (بروزرسانی: {{ $lastUpdated }})
        </p>
    </div>

    {{-- ویجت محاسبه‌گر آلپاین --}}
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
    }" class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-3xl p-6 sm:p-10 shadow-sm space-y-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label for="input-weight" class="block text-xs font-bold text-stone-700 dark:text-stone-300">وزن طلا (گرم):</label>
                <input id="input-weight" type="number" step="0.01" x-model.number="weight" class="min-h-11 w-full px-4 py-2.5 rounded-2xl bg-stone-50 dark:bg-stone-800 border border-stone-200 dark:border-stone-700 text-stone-900 dark:text-white font-mono font-bold text-base focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
            </div>
            <div class="space-y-2">
                <label for="input-rate" class="block text-xs font-bold text-stone-700 dark:text-stone-300">قیمت هر گرم طلای ۱۸ عیار (تومان):</label>
                <input id="input-rate" type="number" step="1000" x-model.number="ratePerGram" class="min-h-11 w-full px-4 py-2.5 rounded-2xl bg-stone-50 dark:bg-stone-800 border border-stone-200 dark:border-stone-700 text-stone-900 dark:text-white font-mono font-bold text-base focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
            </div>
            <div class="space-y-2">
                <label for="input-ojrat" class="block text-xs font-bold text-stone-700 dark:text-stone-300">درصد اجرت ساخت (%):</label>
                <input id="input-ojrat" type="number" step="0.5" x-model.number="ojratPercent" class="min-h-11 w-full px-4 py-2.5 rounded-2xl bg-stone-50 dark:bg-stone-800 border border-stone-200 dark:border-stone-700 text-stone-900 dark:text-white font-mono font-bold text-base focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
            </div>
            <div class="space-y-2">
                <label for="input-profit" class="block text-xs font-bold text-stone-700 dark:text-stone-300">سود مصوب فروشنده (قانوناً ۷٪):</label>
                <input id="input-profit" type="number" step="0.5" x-model.number="profitPercent" class="min-h-11 w-full px-4 py-2.5 rounded-2xl bg-stone-50 dark:bg-stone-800 border border-stone-200 dark:border-stone-700 text-stone-900 dark:text-white font-mono font-bold text-base focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
            </div>
        </div>

        {{-- تفکیک فاکتور نهایی --}}
        <div class="p-6 rounded-2xl bg-stone-50 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-700/60 space-y-4">
            <div class="text-xs font-bold text-stone-400">ریز اقلام فاکتور خرید:</div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                <div>
                    <span class="text-stone-500">طلای خام:</span>
                    <div class="font-black text-stone-800 dark:text-stone-200 mt-1 font-mono tabular-nums" x-text="Math.round(rawGoldPrice).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
                <div>
                    <span class="text-stone-500">مبلغ اجرت:</span>
                    <div class="font-black text-stone-800 dark:text-stone-200 mt-1 font-mono tabular-nums" x-text="Math.round(ojratAmount).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
                <div>
                    <span class="text-stone-500">سود ۷ درصد:</span>
                    <div class="font-black text-stone-800 dark:text-stone-200 mt-1 font-mono tabular-nums" x-text="Math.round(profitAmount).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
                <div>
                    <span class="text-stone-500">مالیات ۹٪ (روی اجرت+سود):</span>
                    <div class="font-black text-rose-600 dark:text-rose-400 mt-1 font-mono tabular-nums" x-text="Math.round(vatAmount).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
            </div>

            <div class="pt-4 border-t border-stone-200 dark:border-stone-700 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <span class="font-black text-stone-900 dark:text-white text-base">مبلغ کل فاکتور نهایی:</span>
                <span class="text-2xl sm:text-3xl font-black text-amber-700 dark:text-amber-400 font-mono tabular-nums" x-text="Math.round(finalPrice).toLocaleString('fa-IR') + ' تومان'"></span>
            </div>
        </div>
    </div>

    {{-- بنر تبدیل به مشتری B2B --}}
    <div class="rounded-3xl bg-stone-900 dark:bg-stone-800 border border-amber-500/30 p-8 text-center text-white space-y-4 shadow-sm">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-400 mx-auto">
            <x-ui-icon name="tv" class="w-6 h-6 text-amber-400" />
        </div>
        <h3 class="text-xl sm:text-2xl font-black text-amber-400">آیا صاحب گالری یا طلافروشی هستید؟</h3>
        <p class="text-stone-300 text-sm max-w-2xl mx-auto leading-relaxed">
            همین فرمول‌ها و سود فروش را به صورت خودکار روی تلویزیون مغازه خود بدون نیاز به کیس نمایش دهید.
        </p>
        <div class="pt-2">
            <a href="{{ route('admin.register') }}" class="min-h-11 inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-stone-950 font-black text-xs transition-colors shadow-sm">
                راه‌اندازی فوری تابلوی طلا مغازه (۱۴ روز رایگان)
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
