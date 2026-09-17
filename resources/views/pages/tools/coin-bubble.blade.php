@extends('layouts.public')

@section('title', config('seo.pages.tools/coin-bubble.title'))
@section('meta_description', config('seo.pages.tools/coin-bubble.desc'))
@section('canonical', 'https://talalive.ir/tools/coin-bubble')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "حباب سنج و محاسبه‌گر آنلاین ارزش ذاتی سکه طلا",
      "alternateName": [
        "حباب سنج سکه",
        "حباب گیر سکه",
        "ارزش ذاتی سکه",
        "محاسبه حباب سکه",
        "حباب سکه امامی",
        "حباب سکه بهار آزادی",
        "حباب ربع سکه"
      ],
      "url": "https://talalive.ir/tools/coin-bubble",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار تخصصی حباب سنج سکه و محاسبه‌گر لحظه‌ای ارزش ذاتی و حباب مثبت و منفی مسکوکات بهار آزادی بر اساس فرمول رسمی بانک مرکزی و نرخ روز طلا."
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
          "name": "حباب سنج سکه",
          "item": "https://talalive.ir/tools/coin-bubble"
        }
      ]
    },
    {
      "@@type": "FAQPage",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "ارزش ذاتی سکه چیست و چگونه با حباب سنج سکه محاسبه می‌شود؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "ارزش ذاتی سکه بهای طلای خام موجود در سکه بر اساس وزن دقیق، عیار ۹۰۰ (معادل ۲۱.۶ عیار) و نرخ روز طلای ۱۸ عیار بعلاوه هزینه حق ضرب مصوب بانک مرکزی است."
          }
        },
        {
          "@@type": "Question",
          "name": "تفاوت حباب سکه بهار آزادی طرح قدیم با سکه امامی چیست؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "وزن و عیار هر دو سکه دقیقاً یکسان است (۸.۱۳۳ گرم با عیار ۹۰۰). تفاوت قیمت و حباب ناشی از تقاضای بالاتر در بازار برای سکه امامی (طرح جدید) نسبت به سکه تمام بهار آزادی (طرح قدیم) است."
          }
        },
        {
          "@@type": "Question",
          "name": "چرا حباب ربع سکه همیشه از سکه تمام بالاتر است؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "به دلیل قیمت اسمی پایین‌تر ربع سکه و تقاضای گسترده خریداران خرد و هدیه، حباب قیمتی ربع سکه در بازار بیشتر شده و گاهی به ۳۰ تا ۴۰ درصد قیمت کل آن می‌رسد."
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

    {{-- هدر صفحه با تعریف صریح موضوع در ۴۰ کلمه اول --}}
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>فرمول رسمی اتحادیه طلا و مسکوکات بانک مرکزی • سال ۱۴۰۵</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            حباب سنج سکه و محاسبه‌گر هوشمند ارزش ذاتی انواع سکه طلا
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed text-justify sm:text-center">
            حباب سنج سکه ابزاری برای محاسبه مابه‌التفاوت قیمت معامله‌شده مسکوکات در بازار با ارزش ذاتی طلای خام موجود در آن‌ها بر اساس وزن، عیار ۹۰۰ و نرخ لحظه‌ای طلای ۱۸ عیار است.
        </p>
        <p class="text-slate-500 dark:text-slate-400 text-xs">
            نرخ مبنای طلای ۱۸ عیار در تابلوی طلالایو: <strong class="text-amber-500 font-mono">{{ number_format($rates['gold18']) }}</strong> تومان (بروزرسانی: {{ $lastUpdated }})
        </p>
    </div>

    {{-- داده‌های محاسباتی سکه‌ها --}}
    @php
        $gold18Val = (float)$rates['gold18'] > 0 ? (float)$rates['gold18'] : 4500000;
        
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
                'name' => 'سکه تمام بهار آزادی (طرح قدیم)',
                'weight' => 8.133,
                'equiv18k' => 8.133 * 1.2,
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

    {{-- کارت‌های ۵ گانه حباب سنج انواع سکه --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($coins as $c)
            @php
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
                        <span>قیمت روز معامله در بازار:</span>
                        <strong class="text-slate-900 dark:text-white text-sm font-mono">{{ number_format($market) }} تومان</strong>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>ارزش ذاتی طلای خالص:</span>
                        <span class="text-slate-700 dark:text-slate-300 font-medium font-mono">{{ number_format($intrinsic) }} تومان</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-dashed border-slate-200 dark:border-slate-700">
                        <span class="font-bold text-slate-700 dark:text-slate-300">مبلغ حباب سکه:</span>
                        <span class="font-black font-mono {{ $bubbleAmount >= 0 ? 'text-rose-500' : 'text-emerald-500' }}">
                            {{ $bubbleAmount >= 0 ? '+' : '' }}{{ number_format($bubbleAmount) }} تومان
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-slate-700 dark:text-slate-300">درصد حباب قیمتی:</span>
                        <span class="px-2.5 py-1 rounded-xl text-xs font-black font-mono {{ $bubblePercent > 10 ? 'bg-rose-500/10 text-rose-500 border border-rose-500/20' : 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' }}">
                            {{ number_format($bubblePercent, 1) }}%
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ویجت محاسبه‌گر تعاملی حباب گیر دستی با آلپاین --}}
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
            const w = parseFloat(this.selectedWeight) || 0;
            const r = parseFloat(this.gold18Rate) || 0;
            const c = parseFloat(this.mintCost) || 0;
            return Math.round((w * 1.2 * r) + c);
        },
        get bubbleToman() {
            const m = parseFloat(this.marketPrice) || 0;
            return Math.round(m - this.intrinsicValue);
        },
        get bubblePercent() {
            return this.intrinsicValue > 0 ? ((this.bubbleToman / this.intrinsicValue) * 100).toFixed(1) : 0;
        },
        formatNumber(num) {
            return (num || 0).toLocaleString('fa-IR');
        }
    }" class="rounded-3xl bg-gradient-to-b from-white to-amber-50/30 dark:from-slate-900 dark:to-slate-950 border border-amber-500/30 p-6 sm:p-10 shadow-2xl space-y-8">
        
        <div class="border-b border-slate-200 dark:border-slate-800 pb-4">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                <span>🧮</span>
                <span>ماشین‌حساب هوشمند و حباب گیر دستی انواع سکه طلا</span>
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                سکه مورد نظر خود را انتخاب کرده یا ارقام قیمت بازار را به‌دلخواه تغییر دهید تا کارکرد حباب گیر آنلاین را تجربه کنید:
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

        {{-- نتایج تحلیل زنده حباب گیر --}}
        <div class="p-6 rounded-2xl bg-white/80 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
            <div class="space-y-1">
                <div class="text-xs text-slate-500 dark:text-slate-400 font-semibold">ارزش ذاتی طلای سکه:</div>
                <div class="text-lg font-black text-slate-900 dark:text-white font-mono" x-text="formatNumber(intrinsicValue) + ' تومان'"></div>
            </div>
            <div class="space-y-1 border-y sm:border-y-0 sm:border-x border-slate-200 dark:border-slate-700 py-3 sm:py-0">
                <div class="text-xs text-slate-500 dark:text-slate-400 font-semibold">مبلغ حباب سکه:</div>
                <div class="text-lg font-black font-mono" :class="bubbleToman >= 0 ? 'text-rose-500' : 'text-emerald-500'" x-text="(bubbleToman >= 0 ? '+' : '') + formatNumber(bubbleToman) + ' تومان'"></div>
            </div>
            <div class="space-y-1">
                <div class="text-xs text-slate-500 dark:text-slate-400 font-semibold">درصد حباب بازار:</div>
                <div class="text-lg font-black font-mono" :class="bubblePercent > 10 ? 'text-rose-500' : 'text-emerald-500'" x-text="bubblePercent + '%'"></div>
            </div>
        </div>

    </div>

    {{-- ۵ زیربخش تحلیلی برای هر نوع سکه --}}
    <section class="space-y-6">
        <div class="text-center space-y-3">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                ارزش ذاتی و حباب ۵ نوع سکه معتبر بازار طلا در سال ۱۴۰۵
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm max-w-3xl mx-auto">
                بررسی ویژگی‌های فنی، وزن، عیار و دلایل تشکیل حباب در هر یک از انواع مسکوکات قانونی ضرب بانک مرکزی:
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- ۱. سکه امامی --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-md">
                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[11px] font-bold">بیشترین نقدشوندگی</span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">۱. سکه امامی (طرح جدید)</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    سکه تمام بهار آزادی طرح جدید (امامی) با وزن دقیق <strong>۸.۱۳۳ گرم</strong> و عیار <strong>۹۰۰ در هزار</strong> ضرب می‌شود. به دلیل رتبه اول نقدشوندگی و مبنا بودن در معاملات آتی بورس کالا، تقاضای سوداگری بالایی دارد و حباب آن در دوره‌های نوسان ارز به سرعت افزایش می‌یابد.
                </p>
                <div class="pt-2 text-[11px] text-slate-400 font-mono border-t border-slate-100 dark:border-slate-800">
                    معادل ۱۸ عیار: ۹.۷۵۹۶ گرم طلای خام
                </div>
            </div>

            {{-- ۲. سکه بهار آزادی طرح قدیم --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-md">
                <span class="px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">حباب کمتر و منطقی</span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">۲. سکه بهار آزادی (طرح قدیم)</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    وزن و عیار سکه طرح قدیم دقیقاً مطابق سکه امامی (۸.۱۳۳ گرم با عیار ۹۰۰) است. اما به دلیل عدم پذیرش در قراردادهای آتی و تقاضای کمتر صرافی‌ها، حباب قیمتی بسیار پایین‌تری نسبت به سکه امامی دارد و برای سرمایه‌گذاران بلندمدت طلای فیزیکی انتخابی اقتصادی‌تر است.
                </p>
                <div class="pt-2 text-[11px] text-slate-400 font-mono border-t border-slate-100 dark:border-slate-800">
                    معادل ۱۸ عیار: ۹.۷۵۹۶ گرم طلای خام
                </div>
            </div>

            {{-- ۳. نیم سکه بهار آزادی --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-md">
                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[11px] font-bold">تقاضای نیمه‌سنگین</span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">۳. نیم سکه بهار آزادی</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    وزن نیم سکه <strong>۴.۰۶۶ گرم</strong> با عیار ۹۰۰ است. به دلیل قیمت کل متعادل‌تر نسبت به سکه تمام، خریداران خانوادگی برای پس‌انداز یا پرداخت مهریه و دیون از آن استفاده می‌کنند. درصد حباب آن معمولاً در محدوده متوسط بازار قرار دارد.
                </p>
                <div class="pt-2 text-[11px] text-slate-400 font-mono border-t border-slate-100 dark:border-slate-800">
                    معادل ۱۸ عیار: ۴.۸۷۹۲ گرم طلای خام
                </div>
            </div>

            {{-- ۴. ربع سکه بهار آزادی --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-md">
                <span class="px-2.5 py-1 rounded-full bg-rose-500/10 text-rose-500 text-[11px] font-bold">بیشترین درصد حباب</span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">۴. ربع سکه بهار آزادی</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    با وزن <strong>۲.۰۳۳ گرم</strong> و عیار ۹۰۰، پرطرفدارترین سکه برای هدیه و خرید اقشار متوسط به شمار می‌رود. به دلیل قیمت ورودی پایین، در تکانه‌های تورمی حباب آن گاهی از ۳۵٪ ارزش ذاتی نیز فراتر می‌رود که استفاده از یک <strong>حباب گیر دقیق</strong> را ضروری می‌کند.
                </p>
                <div class="pt-2 text-[11px] text-slate-400 font-mono border-t border-slate-100 dark:border-slate-800">
                    معادل ۱۸ عیار: ۲.۴۳۹۶ گرم طلای خام
                </div>
            </div>

            {{-- ۵. سکه گرمی بانک مرکزی --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-md sm:col-span-2 lg:col-span-1">
                <span class="px-2.5 py-1 rounded-full bg-purple-500/10 text-purple-600 dark:text-purple-400 text-[11px] font-bold">بسته‌بندی امنیتی</span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">۵. سکه گرمی بانک مرکزی</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    سبک‌ترین مسکوک رسمی کشور با وزن <strong>۱.۰۱۶ گرم</strong> و عیار ۲۱.۶ (۹۰۰). این سکه در بسته‌بندی هولوگرام‌دار وکیوم ضرب می‌شود و نسبت به وزن ناچیز خود، حباب درصدی قابل‌توجهی را به دلیل هزینه بسته‌بندی و تقاضای کادویی ثبت می‌کند.
                </p>
                <div class="pt-2 text-[11px] text-slate-400 font-mono border-t border-slate-100 dark:border-slate-800">
                    معادل ۱۸ عیار: ۱.۲۱۹۲ گرم طلای خام
                </div>
            </div>
        </div>
    </section>

    {{-- بنر فراخوان میانی --}}
    @include('partials.cta-inline', [
        'title' => 'نمایش لحظه‌ای نرخ سکه و حباب بازار روی تلویزیون مغازه',
        'subtitle' => 'دیگر نیاز به چک کردن دستی قیمت‌ها نیست. با اتصال تابلوی هوشمند طلالایو به تلویزیون ویترین، نرخ زنده ۵ سکه به همراه قیمت طلا خودکار بروزرسانی می‌شود.',
        'buttonText' => 'تست رایگان ۱۴ روزه تابلوی طلالایو',
        'buttonUrl' => route('admin.register'),
        'secondaryText' => 'بررسی امکانات تابلوی هوشمند',
        'secondaryUrl' => route('public.smart-gold-board'),
    ])

    {{-- توضیحات فرمول و راهنمای علمی --}}
    <div class="bg-slate-50 dark:bg-slate-800/60 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-700 space-y-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
        <h2 class="font-black text-slate-900 dark:text-white text-lg flex items-center gap-2">
            <span>📚</span>
            <span>فرمول رسمی محاسبه ارزش ذاتی سکه در بازار زرگران</span>
        </h2>
        <p>
            عیار تمامی مسکوکات بهار آزادی (تمام، نیم، ربع و گرمی) <strong>۹۰۰ در هزار (۲۱.۶ عیار)</strong> است. از آنجا که پایه نرخ‌گذاری روز در بازار طلا <strong>طلای ۱۸ عیار (۷۵۰ در هزار)</strong> می‌باشد، معادل طلای ۱۸ عیار هر سکه با ضریب تبدیل <code>۹۰۰ ÷ ۷۵۰ = ۱.۲</code> محاسبه می‌شود:
        </p>
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-mono text-xs text-amber-600 dark:text-amber-400 leading-loose" dir="ltr">
            ارزش ذاتی سکه = (وزن سکه × ۱.۲ × نرخ روز طلای ۱۸ عیار) + حق ضرب بانک مرکزی
        </div>
        <p class="pt-2">
            برای مطالعه راهنمای جامع فرمول و نحوه تفکیک محاسبات با انس جهانی، مقاله تخصصی <a href="{{ route('public.guides.show', 'how-to-calculate-coin-bubble') }}" class="text-amber-500 font-bold hover:underline">فرمول محاسبه حباب سکه امامی و بهار آزادی</a> را مطالعه نمایید.
        </p>
    </div>

    {{-- سوالات متداول درباره حباب سنج --}}
    <div class="glass-panel p-6 sm:p-10 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-6">
        <h2 class="font-black text-slate-900 dark:text-white text-lg flex items-center gap-2">
            <span>❓</span>
            <span>پرسش‌های متداول درباره حباب سنج و حباب مسکوکات</span>
        </h2>
        
        <div class="space-y-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300">
            <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">حباب گیر سکه دقیقاً چه کاری انجام می‌دهد؟</h3>
                <p class="leading-relaxed">
                    یک حباب گیر آنلاین ارزش واقعی طلای موجود در سکه را بر اساس وزن و عیار از قیمت بازاری آن تفکیک می‌کند تا خریدار بداند چه مبلغی بابت طلای واقعی و چه مبلغی صرفاً بابت هیجان و ریسک تقاضا پرداخت می‌کند.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">آیا خرید سکه با حباب منفی امکان‌پذیر است؟</h3>
                <p class="leading-relaxed">
                    در مواقع رکود شدید یا افت ناگهانی تقاضا، ممکن است قیمت معامله سکه به زیر ارزش ذاتی طلای خام آن برسد که در این حالت حباب منفی شکل می‌گیرد و نشان‌دهنده ارزندگی بالای خرید نسبت به طلای خام است.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 space-y-2">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm">چگونه نرخ‌های زنده سکه را روی تلویزیون مغازه نمایش دهیم؟</h3>
                <p class="leading-relaxed">
                    با عضویت در سامانه <a href="{{ route('public.smart-gold-board') }}" class="text-amber-500 font-bold hover:underline">تابلوی هوشمند طلالایو</a>، بدون نیاز به کامپیوتر یا دستگاه اضافه، می‌توانید آدرس اینترنتی اختصاصی تابلوی خود را در مرورگر تلویزیون باز کرده و نرخ‌های آنی را نمایش دهید.
                </p>
            </div>
        </div>
    </div>

    {{-- بخش مطالب و ابزارهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'سایر ابزارها و راهنماهای تخصصی طلا و سکه',
        'links' => [
            [
                'title' => 'فرمول محاسبه حباب انواع سکه',
                'desc' => 'راهنمای تحلیلی محاسبه حباب سکه امامی و بهار آزادی با انس طلا و دلار.',
                'url' => route('public.guides.show', 'how-to-calculate-coin-bubble'),
            ],
            [
                'title' => 'تبدیل آنلاین مظنه مثقال به گرم ۱۸ عیار',
                'desc' => 'محاسبه‌گر تبدیل مظنه نقدی و فردایی بازار به قیمت یک گرم طلای خام.',
                'url' => route('public.tools.mesghal'),
            ],
            [
                'title' => 'تابلو آنلاین قیمت طلا و مسکوکات',
                'desc' => 'نمایشگر دیجیتال قیمت زنده طلا، سکه و ارز روی تلویزیون مغازه.',
                'url' => route('public.online-gold-price-board'),
            ],
        ]
    ])

</div>
@endsection
