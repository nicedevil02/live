@extends('layouts.public')

@section('title', 'محاسبه‌گر آنلاین حباب سکه امامی، بهار آزادی، نیم و ربع سکه | طلالایو')
@section('meta_description', 'محاسبه آنلاین و دقیق ارزش ذاتی و حباب انواع سکه بهار آزادی، امامی، نیم، ربع و سکه گرمی بر اساس نرخ لحظه‌ای انس طلا و دلار آزاد با فرمول رسمی بانک مرکزی.')
@section('meta_keywords', 'محاسبه حباب سکه, حباب سکه امامی امروز, حباب ربع سکه, ارزش ذاتی سکه, فرمول محاسبه حباب سکه, طلالایو')

@section('canonical', 'https://talalive.ir/tools/coin-bubble')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "محاسبه‌گر حباب انواع سکه طلا",
      "url": "https://talalive.ir/tools/coin-bubble",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار محاسبه لحظه‌ای ارزش ذاتی و درصد حباب سکه امامی، بهار آزادی، نیم سکه و ربع سکه بر مبنای انس جهانی طلا و نرخ ارز."
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
          "name": "محاسبه‌گر حباب سکه",
          "item": "https://talalive.ir/tools/coin-bubble"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-12">

    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-bold">
            <span>فرمول رسمی استخراج ارزش ذاتی و حباب مسکوکات</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            محاسبه‌گر آنلاین حباب سکه <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-yellow-500">
                امامی، بهار آزادی، نیم، ربع و گرمی
            </span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm">
            محاسبه بر اساس نرخ انس جهانی (<strong class="text-amber-500">{{ $rates['ons'] > 0 ? '$' . number_format($rates['ons'], 1) : 'لحظه‌ای' }}</strong>) و دلار آزاد.
        </p>
    </div>

    {{-- کارت‌های حباب انواع سکه --}}
    @php
        $onsVal = (float)$rates['ons'] > 0 ? (float)$rates['ons'] : 2650;
        $usdVal = (float)$rates['dollar'] > 0 ? (float)$rates['dollar'] : 60000;
        
        // وزن سکه‌ها بر حسب گرم با عیار ۹۰۰ (۲۱.۶)
        $coins = [
            [
                'name' => 'سکه امامی (طرح جدید)',
                'weight' => 8.133,
                'marketPrice' => (float)$rates['coin_emami'],
                'mintCost' => 150000,
            ],
            [
                'name' => 'سکه تمام بهار آزادی',
                'weight' => 8.133,
                'marketPrice' => (float)$rates['coin_bahar'],
                'mintCost' => 150000,
            ],
            [
                'name' => 'نیم سکه بهار آزادی',
                'weight' => 4.066,
                'marketPrice' => (float)$rates['coin_half'],
                'mintCost' => 120000,
            ],
            [
                'name' => 'ربع سکه بهار آزادی',
                'weight' => 2.033,
                'marketPrice' => (float)$rates['coin_quarter'],
                'mintCost' => 100000,
            ],
            [
                'name' => 'سکه گرمی بانک مرکزی',
                'weight' => 1.016,
                'marketPrice' => (float)$rates['coin_gerami'],
                'mintCost' => 80000,
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($coins as $c)
            @php
                // فرمول ارزش ذاتی: (وزن * عیار ۰.۹۰۰ * انس * دلار) / ۳۱.۱۰۳۴۳ + حق ضرب
                $goldContent = ($c['weight'] * 0.900);
                $intrinsic = (($goldContent * $onsVal * $usdVal) / 31.10343) + $c['mintCost'];
                $market = $c['marketPrice'] > 0 ? $c['marketPrice'] : ($intrinsic * 1.15);
                $bubbleAmount = $market - $intrinsic;
                $bubblePercent = $intrinsic > 0 ? ($bubbleAmount / $intrinsic) * 100 : 0;
            @endphp
            <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 space-y-4 shadow-lg hover:border-amber-500/50 transition-all">
                <div class="flex items-center justify-between">
                    <h3 class="font-black text-slate-900 dark:text-white text-base">{{ $c['name'] }}</h3>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold">
                        وزن: {{ $c['weight'] }}g
                    </span>
                </div>

                <div class="space-y-2 pt-2 border-t border-slate-100 dark:border-slate-800 text-xs">
                    <div class="flex justify-between text-slate-500">
                        <span>قیمت روز بازار:</span>
                        <strong class="text-slate-900 dark:text-white text-sm">{{ number_format($market) }} ت</strong>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>ارزش ذاتی طلا:</span>
                        <span class="text-slate-700 dark:text-slate-300 font-medium">{{ number_format($intrinsic) }} ت</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-dashed border-slate-200 dark:border-slate-700">
                        <span class="font-bold text-slate-700 dark:text-slate-300">مبلغ حباب:</span>
                        <span class="font-black {{ $bubbleAmount > 0 ? 'text-rose-500' : 'text-emerald-500' }}">
                            {{ $bubbleAmount > 0 ? '+' : '' }}{{ number_format($bubbleAmount) }} تومان
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-slate-700 dark:text-slate-300">درصد حباب:</span>
                        <span class="px-2 py-0.5 rounded-lg text-xs font-black {{ $bubblePercent > 15 ? 'bg-rose-500/10 text-rose-500' : 'bg-emerald-500/10 text-emerald-500' }}">
                            {{ number_format($bubblePercent, 1) }}%
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- توضیحات فرمول و راهنما --}}
    <div class="bg-slate-50 dark:bg-slate-800/60 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-700 space-y-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
        <h3 class="font-black text-slate-900 dark:text-white text-base">فرمول محاسبه حباب سکه چگونه کار می‌کند؟</h3>
        <p>
            ارزش ذاتی سکه برابر است با وزن خالص طلای موجود در سکه ضرب در قیمت جهانی انس طلا و نرخ برابری ارز آزاد، تقسیم بر وزن یک تروی انس (۳۱.۱۰۳۴۳ گرم). اختلاف بین قیمت معاملاتی در بازار و ارزش طلای خالص سکه را <strong>«حباب سکه»</strong> می‌نامند.
        </p>
    </div>

</div>
@endsection
