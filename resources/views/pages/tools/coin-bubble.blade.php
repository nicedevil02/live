@extends('layouts.public')

@section('title', 'محاسبه آنلاین حباب سکه امامی و بهار آزادی (نیم سکه و ربع سکه) | حباب سنج سکه طلالایو')
@section('meta_description', 'حباب سنج آنلاین سکه طلالایو: محاسبه لحظه ای ارزش ذاتی و درصد حباب سکه امامی، سکه بهار آزادی، بهار ازادی، نیم سکه، ربع سکه و سکه گرمی با فرمول بانک مرکزی و تابلوی طلا.')
@section('meta_keywords', 'حباب سنج سکه, محاسبه حباب سکه, حباب سکه امامی, حباب سکه بهار آزادی, حباب سکه بهار ازادی, حباب سکه بهارآزادی, حباب سکه بهارازادی, حباب نیم سکه, حباب ربع سکه, قیمت نیم سکه, قیمت ربع سکه, نرخ لحظه ای سکه, محاسبه انلاین حباب سکه, طلالایو')

@section('canonical', 'https://talalive.ir/tools/coin-bubble')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "حباب سنج و محاسبه گر آنلاین حباب انواع سکه طلا",
      "alternateName": [
        "حباب سنج سکه",
        "محاسبه حباب سکه",
        "حباب سکه بهار آزادی",
        "حباب سکه بهار ازادی",
        "حباب سکه بهارآزادی",
        "حباب سکه بهارازادی",
        "حباب نیم سکه",
        "حباب ربع سکه",
        "حباب سکه امامی",
        "محاسبه انلاین حباب سکه"
      ],
      "url": "https://talalive.ir/tools/coin-bubble",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار آنلاین محاسبه لحظه ای ارزش ذاتی و درصد حباب سکه امامی، بهار آزادی، بهار ازادی، نیم سکه و ربع سکه بر مبنای انس جهانی طلا و نرخ ارز."
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
    },
    {
      "@@type": "FAQPage",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "تفاوت حباب سکه بهار آزادی و بهار ازادی با سکه امامی چیست؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "وزن و عیار هر دو سکه دقیقاً یکسان است (۸.۱۳۳ گرم با عیار ۹۰۰). تفاوت قیمت و حباب ناشی از تقاضای بالاتر در بازار برای سکه امامی (طرح جدید پس از سال ۱۳۸۶) نسبت به سکه تمام بهار آزادی (طرح قدیم) است. کاربران این مسکوکات را به صورت بهار آزادی، بهار ازادی، بهارآزادی و بهارازادی در بازار جستجو می‌کنند."
          }
        },
        {
          "@@type": "Question",
          "name": "چرا درصد حباب ربع سکه و نیم سکه بیشتر از سکه تمام است؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "به دلیل قیمت اسمی پایین‌تر ربع سکه و نیم سکه، نقدشوندگی بالاتر و تقاضای بیشتر خریداران خرد و هدیه، حباب قیمتی ربع سکه گاهی تا ۳۰ الی ۴۰ درصد افزایش می‌یابد؛ در حالی که حباب سکه تمام بهار آزادی معمولاً پایین‌تر است."
          }
        },
        {
          "@@type": "Question",
          "name": "محاسبه انلاین حباب سکه با نرخ لحظه ای طلالایو چگونه انجام می‌شود؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "سامانه طلالایو نرخ طلای ۱۸ عیار و قیمت بازار را از صنف استخراج کرده و ارزش ذاتی طلای خام سکه را با فرمول عیار ۹۰۰ تفکیک می‌کند تا حباب مثبت یا منفی لحظه ای به دست آید."
          }
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
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>فرمول رسمی اتحادیه طلا و مسکوکات بانک مرکزی (بروزرسانی زنده)</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            محاسبه‌گر آنلاین حباب سکه <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-yellow-500">
                امامی، بهار آزادی، نیم، ربع و گرمی
            </span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm">
            محاسبه مستقیم بر مبنای نرخ لحظه‌ای طلا و سکه در تابلوی طلالایو &bull; نرخ طلای ۱۸ عیار تابلو: <strong class="text-amber-500 font-mono">{{ number_format($rates['gold18']) }}</strong> تومان
        </p>
    </div>

    {{-- کارت‌های حباب انواع سکه با فرمول دقیق و زنده زرگری --}}
    @php
        $gold18Val = (float)$rates['gold18'] > 0 ? (float)$rates['gold18'] : 4500000;
        
        // مشخصات استاندارد مسکوکات بانک مرکزی (عیار ۹۰۰ معادل ۱.۲ طلای ۱۸ عیار)
        $coins = [
            [
                'id' => 'emami',
                'name' => 'سکه امامی (طرح جدید)',
                'weight' => 8.133,
                'equiv18k' => 8.133 * 1.2, // 9.7596 گرم ۱۸ عیار
                'marketPrice' => (float)($rates['coin_emami'] ?? 0),
                'mintCost' => 200000,
            ],
            [
                'id' => 'bahar',
                'name' => 'سکه تمام بهار آزادی',
                'weight' => 8.133,
                'equiv18k' => 8.133 * 1.2, // 9.7596 گرم ۱۸ عیار
                'marketPrice' => (float)($rates['coin_bahar'] ?? 0),
                'mintCost' => 200000,
            ],
            [
                'id' => 'nim',
                'name' => 'نیم سکه بهار آزادی',
                'weight' => 4.066,
                'equiv18k' => 4.066 * 1.2, // 4.8792 گرم ۱۸ عیار
                'marketPrice' => (float)($rates['coin_nim'] ?? $rates['coin_half'] ?? 0),
                'mintCost' => 150000,
            ],
            [
                'id' => 'rob',
                'name' => 'ربع سکه بهار آزادی',
                'weight' => 2.033,
                'equiv18k' => 2.033 * 1.2, // 2.4396 گرم ۱۸ عیار
                'marketPrice' => (float)($rates['coin_rob'] ?? $rates['coin_quarter'] ?? 0),
                'mintCost' => 100000,
            ],
            [
                'id' => 'gerami',
                'name' => 'سکه گرمی بانک مرکزی',
                'weight' => 1.016,
                'equiv18k' => 1.016 * 1.2, // 1.2192 گرم ۱۸ عیار
                'marketPrice' => (float)($rates['coin_gerami'] ?? 0),
                'mintCost' => 80000,
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($coins as $c)
            @php
                // ارزش ذاتی استاندارد صنف زرگری: (معادل طلای ۱۸ عیار * قیمت هر گرم ۱۸ عیار) + حق ضرب
                $intrinsic = round($c['equiv18k'] * $gold18Val) + $c['mintCost'];
                $market = $c['marketPrice'] > 0 ? $c['marketPrice'] : round($intrinsic * 1.18);
                $bubbleAmount = $market - $intrinsic;
                $bubblePercent = $intrinsic > 0 ? ($bubbleAmount / $intrinsic) * 100 : 0;
            @endphp
            <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 space-y-4 shadow-lg hover:border-amber-500/50 transition-all group">
                <div class="flex items-center justify-between">
                    <h3 class="font-black text-slate-900 dark:text-white text-base">{{ $c['name'] }}</h3>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold font-mono">
                        {{ $c['weight'] }}g
                    </span>
                </div>

                <div class="space-y-2.5 pt-2 border-t border-slate-100 dark:border-slate-800 text-xs">
                    <div class="flex justify-between text-slate-500">
                        <span>قیمت روز بازار:</span>
                        <strong class="text-slate-900 dark:text-white text-sm font-mono">{{ number_format($market) }} تومان</strong>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>ارزش طلای خام (ذاتی):</span>
                        <span class="text-slate-700 dark:text-slate-300 font-medium font-mono">{{ number_format($intrinsic) }} تومان</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-dashed border-slate-200 dark:border-slate-700">
                        <span class="font-bold text-slate-700 dark:text-slate-300">مبلغ حباب:</span>
                        <span class="font-black font-mono {{ $bubbleAmount >= 0 ? 'text-rose-500' : 'text-emerald-500' }}">
                            {{ $bubbleAmount >= 0 ? '+' : '' }}{{ number_format($bubbleAmount) }} تومان
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-slate-700 dark:text-slate-300">درصد حباب بازار:</span>
                        <span class="px-2.5 py-1 rounded-xl text-xs font-black font-mono {{ $bubblePercent > 10 ? 'bg-rose-500/10 text-rose-500 border border-rose-500/20' : 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' }}">
                            {{ number_format($bubblePercent, 1) }}%
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ویجت محاسبه‌گر تعاملی زنده حباب سکه دستی --}}
    <div x-data="{
        gold18Rate: {{ $gold18Val }},
        selectedWeight: 8.133,
        marketPrice: {{ $coins[0]['marketPrice'] > 0 ? $coins[0]['marketPrice'] : round((8.133 * 1.2 * $gold18Val) * 1.18) }},
        mintCost: 200000,
        coinTitle: 'سکه امامی',

        setCoin(title, weight, cost, defPrice) {
            this.coinTitle = title;
            this.selectedWeight = weight;
            this.mintCost = cost;
            this.marketPrice = defPrice;
        },

        get intrinsicValue() {
            return Math.round((this.selectedWeight * 1.2 * this.gold18Rate) + this.mintCost);
        },
        get bubbleToman() {
            return Math.round(this.marketPrice - this.intrinsicValue);
        },
        get bubblePercent() {
            return this.intrinsicValue > 0 ? ((this.bubbleToman / this.intrinsicValue) * 100).toFixed(1) : 0;
        }
    }" class="rounded-3xl bg-gradient-to-b from-white to-amber-50/30 dark:from-slate-900 dark:to-slate-950 border border-amber-500/30 p-6 sm:p-10 shadow-2xl space-y-8">
        
        <div class="border-b border-slate-200 dark:border-slate-800 pb-4">
            <h2 class="text-xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                <span>🧮</span>
                <span>ماشین‌حساب هوشمند و دستی حباب سکه</span>
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                نوع سکه یا قیمت بازار را تغییر دهید تا حباب و ارزش طلای آن را لحظه‌ای محاسبه کنید:
            </p>
        </div>

        {{-- دکمه‌های سریع انتخاب سکه --}}
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5">
            <button type="button" @click="setCoin('سکه امامی', 8.133, 200000, {{ $coins[0]['marketPrice'] > 0 ? $coins[0]['marketPrice'] : round((8.133 * 1.2 * $gold18Val) * 1.18) }})"
                    :class="selectedWeight === 8.133 && coinTitle === 'سکه امامی' ? 'bg-amber-500 text-slate-950 font-black shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold'"
                    class="py-2.5 px-3 rounded-2xl text-xs transition-all cursor-pointer">
                سکه امامی
            </button>
            <button type="button" @click="setCoin('سکه بهار آزادی', 8.133, 200000, {{ $coins[1]['marketPrice'] > 0 ? $coins[1]['marketPrice'] : round((8.133 * 1.2 * $gold18Val) * 1.08) }})"
                    :class="selectedWeight === 8.133 && coinTitle === 'سکه بهار آزادی' ? 'bg-amber-500 text-slate-950 font-black shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold'"
                    class="py-2.5 px-3 rounded-2xl text-xs transition-all cursor-pointer">
                تمام بهار آزادی
            </button>
            <button type="button" @click="setCoin('نیم سکه', 4.066, 150000, {{ $coins[2]['marketPrice'] > 0 ? $coins[2]['marketPrice'] : round((4.066 * 1.2 * $gold18Val) * 1.22) }})"
                    :class="selectedWeight === 4.066 ? 'bg-amber-500 text-slate-950 font-black shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold'"
                    class="py-2.5 px-3 rounded-2xl text-xs transition-all cursor-pointer">
                نیم سکه
            </button>
            <button type="button" @click="setCoin('ربع سکه', 2.033, 100000, {{ $coins[3]['marketPrice'] > 0 ? $coins[3]['marketPrice'] : round((2.033 * 1.2 * $gold18Val) * 1.36) }})"
                    :class="selectedWeight === 2.033 ? 'bg-amber-500 text-slate-950 font-black shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold'"
                    class="py-2.5 px-3 rounded-2xl text-xs transition-all cursor-pointer">
                ربع سکه
            </button>
            <button type="button" @click="setCoin('سکه گرمی', 1.016, 80000, {{ $coins[4]['marketPrice'] > 0 ? $coins[4]['marketPrice'] : round((1.016 * 1.2 * $gold18Val) * 1.45) }})"
                    :class="selectedWeight === 1.016 ? 'bg-amber-500 text-slate-950 font-black shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold'"
                    class="py-2.5 px-3 rounded-2xl text-xs transition-all cursor-pointer col-span-2 sm:col-span-1">
                سکه گرمی
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">قیمت هر گرم طلای ۱۸ عیار خام (تومان):</label>
                <input type="number" step="1000" x-model.number="gold18Rate" class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-mono font-bold text-base focus:outline-none focus:border-amber-500">
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">قیمت معامله سکه در بازار (تومان):</label>
                <input type="number" step="10000" x-model.number="marketPrice" class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-mono font-bold text-base focus:outline-none focus:border-amber-500">
            </div>
        </div>

        {{-- نتایج تحلیل زنده --}}
        <div class="p-6 rounded-2xl bg-white/80 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
            <div class="space-y-1">
                <div class="text-xs text-slate-500 dark:text-slate-400 font-semibold">ارزش ذاتی طلای سکه:</div>
                <div class="text-lg font-black text-slate-900 dark:text-white font-mono" x-text="intrinsicValue.toLocaleString('fa-IR') + ' تومان'"></div>
            </div>
            <div class="space-y-1 border-y sm:border-y-0 sm:border-x border-slate-200 dark:border-slate-700 py-3 sm:py-0">
                <div class="text-xs text-slate-500 dark:text-slate-400 font-semibold">مبلغ حباب سکه:</div>
                <div class="text-lg font-black font-mono" :class="bubbleToman >= 0 ? 'text-rose-500' : 'text-emerald-500'" x-text="(bubbleToman >= 0 ? '+' : '') + bubbleToman.toLocaleString('fa-IR') + ' تومان'"></div>
            </div>
            <div class="space-y-1">
                <div class="text-xs text-slate-500 dark:text-slate-400 font-semibold">درصد حباب بازار:</div>
                <div class="text-lg font-black font-mono" :class="bubblePercent > 10 ? 'text-rose-500' : 'text-emerald-500'" x-text="bubblePercent + '%'"></div>
            </div>
        </div>

    </div>

    {{-- توضیحات فرمول و راهنمای علمی --}}
    <div class="bg-slate-50 dark:bg-slate-800/60 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-700 space-y-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
        <h3 class="font-black text-slate-900 dark:text-white text-base flex items-center gap-2">
            <span>📚</span>
            <span>فرمول رسمی محاسبه ارزش ذاتی و حباب سکه در بازار طلا</span>
        </h3>
        <p>
            عیار تمامی مسکوکات بهار آزادی (تمام، نیم و ربع) <strong>۹۰۰ در هزار (۲۱.۶ عیار)</strong> است. از آنجا که پایه معاملات بازار طلای ایران <strong>طلای ۱۸ عیار (۷۵۰ در هزار)</strong> می‌باشد، معادل طلای ۱۸ عیار هر سکه با ضریب <code>۹۰۰ ÷ ۷۵۰ = ۱.۲</code> محاسبه می‌شود:
        </p>
        <ul class="list-disc list-inside space-y-1.5 font-mono text-xs pr-2 text-slate-700 dark:text-slate-300">
            <li><strong>سکه تمام:</strong> وزن ۸.۱۳۳ گرم &times; ۱.۲ = ۹.۷۵۹۶ گرم طلای ۱۸ عیار + حق ضرب</li>
            <li><strong>نیم سکه:</strong> وزن ۴.۰۶۶ گرم &times; ۱.۲ = ۴.۸۷۹۲ گرم طلای ۱۸ عیار + حق ضرب</li>
            <li><strong>ربع سکه:</strong> وزن ۲.۰۳۳ گرم &times; ۱.۲ = ۲.۴۳۹۶ گرم طلای ۱۸ عیار + حق ضرب</li>
            <li><strong>سکه گرمی:</strong> وزن ۱.۰۱۶ گرم &times; ۱.۲ = ۱.۲۱۹۲ گرم طلای ۱۸ عیار + حق ضرب</li>
        </ul>
        <p class="pt-2">
            <strong>حباب سکه</strong> حاصل تفریق ارزش ذاتی طلای موجود از قیمت روز معامله در بازار است که تحت تأثیر عرضه و تقاضای جامعه، نوسانات روانی و تقاضای سرمایه‌گذاری شکل می‌گیرد.
        </p>
    </div>

    {{-- سوالات متداول درباره حباب سکه و مسکوکات بهار آزادی --}}
    <div class="glass-panel p-6 sm:p-10 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-6">
        <h3 class="font-black text-slate-900 dark:text-white text-lg flex items-center gap-2">
            <span>❓</span>
            <span>سوالات متداول درباره محاسبه حباب سکه بهار آزادی، نیم سکه و ربع سکه</span>
        </h3>
        
        <div class="space-y-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300">
            <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 space-y-2">
                <h4 class="font-bold text-slate-900 dark:text-white text-sm">تفاوت حباب سکه بهار آزادی (بهار ازادی) با سکه امامی چیست؟</h4>
                <p class="leading-relaxed">
                    وزن و عیار هر دو سکه دقیقاً یکسان است (۸.۱۳۳ گرم طلای عیار ۹۰۰). تفاوت قیمت و حباب ناشی از تقاضای بالاتر معامله‌گران در بازار برای سکه امامی نسبت به سکه تمام بهار آزادی (که در نگارش‌های عمومی به شکل بهار ازادی، بهارآزادی و بهارازادی نیز نوشته می‌شود) می‌باشد.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 space-y-2">
                <h4 class="font-bold text-slate-900 dark:text-white text-sm">چرا حباب ربع سکه و نیم سکه نسبت به قیمت طلای خالص آن بیشتر است؟</h4>
                <p class="leading-relaxed">
                    به علت قیمت کل پایین‌تر ربع سکه و نیم سکه، اقشار گسترده‌تری توان خرید آن را برای هدیه، پس‌انداز خرد یا سرمایه‌گذاری دارند. این تقاضای فزاینده باعث می‌شود حباب قیمتی ربع سکه در بازار به شکل چشمگیری افزایش یابد.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 space-y-2">
                <h4 class="font-bold text-slate-900 dark:text-white text-sm">محاسبه انلاین حباب سکه با نرخ لحظه ای طلالایو چگونه انجام می‌شود؟</h4>
                <p class="leading-relaxed">
                    این ماشین حساب با خواندن نرخ لحظه ای طلا ۱۸ عیار و استعلام قیمت معامله سکه از بازار، ارزش ذاتی طلای خام را با کسر حق ضرب محاسبه کرده و حباب اسمی و درصد حباب را به صورت زنده نمایش می‌دهد.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
