@extends('layouts.public')

@section('title', 'ماشین حساب طلا و حباب سنج سکه | محاسبه قیمت طلا در مغازه طلا فروشی | طلالایو')
@section('meta_description', 'محاسبه انلاین و دقیق قیمت طلا در طلا فروشی، طلای دست دوم، کم اجرت و بدون اجرت. محاسبه آنی حباب سکه امامی، بهار آزادی، بهار ازادی، نیم سکه و ربع سکه با نرخ لحظه ای طلالایو.')
@section('meta_keywords', 'ماشین حساب طلا, محاسبه قیمت طلا در طلا فروشی, محاسبه انلاین طلا, طلای دست دوم, طلا دست دوم, طلای دستدوم, طلای کم اجرت, طلای کماجرت, طلای بدون اجرت, حباب سنج سکه, حباب سکه بهار آزادی, حباب سکه بهار ازادی, بهارآزادی, بهارازادی, نیم سکه, ربع سکه, قیمت طلا ۱۸ عیار, نرخ لحظه ای طلا')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "ماشین حساب آنلاین قیمت طلا و حباب سنج سکه طلالایو",
      "alternateName": [
        "ماشین حساب طلا",
        "محاسبه انلاین طلا",
        "محاسبه قیمت طلا در طلا فروشی",
        "حباب سنج سکه",
        "محاسبه طلای دست دوم",
        "محاسبه طلای دستدوم",
        "محاسبه طلای کم اجرت",
        "حباب سکه بهار آزادی",
        "حباب سکه بهار ازادی",
        "حباب نیم سکه",
        "حباب ربع سکه"
      ],
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "IRR"
      },
      "description": "ابزار رایگان و تعاملی محاسبه فاکتور طلا با اجرت، طلای دست دوم و کم اجرت، سود ۷ درصد مغازه طلا فروشی و حباب سنج انواع سکه بهار آزادی، نیم سکه و ربع سکه."
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
          "name": "ماشین‌حساب آنلاین طلا و حباب سکه",
          "item": "https://talalive.ir/gold-calculator"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16" 
     x-data="{
        activeTab: 'gold',
        // متغیرهای طلا
        gramRate: {{ $rates['gold18'] }},
        weight: 4.5,
        ojratPercent: 12,
        profitPercent: 7,
        taxPercent: 9,

        // متغیرهای حباب سکه
        coinType: 'emami',
        marketCoinPrice: {{ $rates['coin_emami'] }},
        gold24Rate: {{ $rates['gold24'] }},

        // توابع محاسباتی طلا
        get rawGoldTotal() {
            return Math.round(this.gramRate * this.weight);
        },
        get ojratTotal() {
            return Math.round(this.rawGoldTotal * (this.ojratPercent / 100));
        },
        get profitTotal() {
            return Math.round((this.rawGoldTotal + this.ojratTotal) * (this.profitPercent / 100));
        },
        get taxTotal() {
            // بر اساس قانون جدید مالیات طلا: ۹ درصد فقط به سود و اجرت تعلق می‌گیرد
            return Math.round((this.ojratTotal + this.profitTotal) * (this.taxPercent / 100));
        },
        get grandTotal() {
            return this.rawGoldTotal + this.ojratTotal + this.profitTotal + this.taxTotal;
        },

        // محاسبات حباب سکه (وزن بر حسب گرم با عیار ۹۰۰ از ۲۴ عیار)
        get coinSpecs() {
            const specs = {
                emami: { weight: 8.133, purity: 0.900, name: 'سکه تمام طرح جدید (امامی)' },
                bahar: { weight: 8.133, purity: 0.900, name: 'سکه بهار آزادی' },
                half: { weight: 4.066, purity: 0.900, name: 'نیم سکه بهار آزادی' },
                quarter: { weight: 2.033, purity: 0.900, name: 'ربع سکه بهار آزادی' },
                gerami: { weight: 1.011, purity: 0.900, name: 'سکه گرمی' }
            };
            return specs[this.coinType] || specs.emami;
        },
        get intrinsicCoinValue() {
            // ارزش ذاتی = وزن * (عیار / ۲۴) * قیمت هر گرم ۲۴ عیار
            const pureWeight = this.coinSpecs.weight * (this.coinSpecs.purity / 1); // 90% طلا
            // تبدیل به طلای ۱۸ عیار یا ۲۴ عیار
            return Math.round(this.coinSpecs.weight * (900 / 750) * this.gramRate);
        },
        get coinBubbleToman() {
            return Math.round(this.marketCoinPrice - this.intrinsicCoinValue);
        },
        get coinBubblePercent() {
            if (this.marketCoinPrice <= 0) return 0;
            return ((this.coinBubbleToman / this.marketCoinPrice) * 100).toFixed(1);
        },

        changeCoin(type, price) {
            this.coinType = type;
            this.marketCoinPrice = price;
        },

        formatNumber(num) {
            return new Intl.NumberFormat('fa-IR').format(Math.round(num));
        }
     }">

    {{-- هدر صفحه --}}
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-300 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
            <span>متصل به نرخ‌های زنده سامانه طلالایو (آخرین بروزرسانی: {{ $lastUpdated }})</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white leading-tight">
            ماشین‌حساب آنلاین قیمت طلا و حباب انواع سکه
        </h1>
        <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed">
            محاسبه دقیق فاکتور خرید طلا مطابق فرمول رسمی اتحادیه و قانون جدید مالیات بر ارزش افزوده، به همراه آنالیز حباب سکه با نرخ‌های رسمی روز.
        </p>
    </div>

    {{-- نوار تب‌های انتخاب ابزار --}}
    <div class="flex justify-center">
        <div class="bg-slate-200/80 dark:bg-slate-900/80 p-1.5 rounded-2xl border border-slate-300 dark:border-slate-800 flex gap-2">
            <button @click="activeTab = 'gold'" 
                    :class="activeTab === 'gold' ? 'bg-amber-500 text-slate-950 font-black shadow-md shadow-amber-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                    class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer">
                محاسبه قیمت طلا و فاکتور
            </button>
            <button @click="activeTab = 'bubble'" 
                    :class="activeTab === 'bubble' ? 'bg-amber-500 text-slate-950 font-black shadow-md shadow-amber-500/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                    class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer">
                حباب‌سنج انواع سکه
            </button>
        </div>
    </div>

    {{-- بخش ۱: ماشین حساب طلا با اجرت و سود --}}
    <div x-show="activeTab === 'gold'" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- ورودی‌های کاربر --}}
        <div class="lg:col-span-7 glass-panel p-6 sm:p-8 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-6">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 dark:bg-amber-400"></span>
                <span>پارامترهای محاسبه فاکتور طلا</span>
            </h2>

            {{-- قیمت هر گرم طلای ۱۸ عیار --}}
            <div class="space-y-2">
                <div class="flex justify-between items-center text-xs">
                    <label class="text-slate-700 dark:text-slate-300 font-bold">نرخ پایه هر گرم طلای ۱۸ عیار خام (تومان):</label>
                    <span class="text-amber-600 dark:text-amber-400 font-mono font-bold" x-text="formatNumber(gramRate) + ' تومان'"></span>
                </div>
                <input type="number" x-model.number="gramRate" class="w-full bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-900 dark:text-white font-mono text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
            </div>

            {{-- وزن طلا به گرم --}}
            <div class="space-y-2">
                <div class="flex justify-between items-center text-xs">
                    <label class="text-slate-700 dark:text-slate-300 font-bold">وزن مصنوعات یا زیورآلات (گرم):</label>
                    <span class="text-amber-600 dark:text-amber-400 font-mono font-bold" x-text="weight + ' گرم'"></span>
                </div>
                <div class="flex items-center gap-3">
                    <input type="range" min="0.5" max="100" step="0.1" x-model.number="weight" class="w-full accent-amber-500 cursor-pointer">
                    <input type="number" step="0.01" x-model.number="weight" class="w-24 bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-center text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                </div>
            </div>

            {{-- اجرت ساخت طلا (درصد) --}}
            <div class="space-y-2">
                <div class="flex justify-between items-center text-xs">
                    <label class="text-slate-700 dark:text-slate-300 font-bold">اجرت ساخت (درصد):</label>
                    <span class="text-amber-600 dark:text-amber-400 font-mono font-bold" x-text="ojratPercent + ' ٪'"></span>
                </div>
                <div class="flex items-center gap-3">
                    <input type="range" min="0" max="40" step="1" x-model.number="ojratPercent" class="w-full accent-amber-500 cursor-pointer">
                    <input type="number" x-model.number="ojratPercent" class="w-24 bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-center text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                </div>
                <p class="text-[11px] text-slate-500">معمولاً النگو و طلای بدون نگین ۱۰ الی ۱۶ درصد و سرویس‌های خارجی ۱۸ تا ۲۸ درصد اجرت دارند.</p>
            </div>

            {{-- سود طلافروشی (درصد) --}}
            <div class="space-y-2">
                <div class="flex justify-between items-center text-xs">
                    <label class="text-slate-700 dark:text-slate-300 font-bold">سود قانونی طلافروشی (طبق مصوبه اتحادیه ۷٪):</label>
                    <span class="text-amber-600 dark:text-amber-400 font-mono font-bold" x-text="profitPercent + ' ٪'"></span>
                </div>
                <div class="flex items-center gap-3">
                    <input type="range" min="0" max="15" step="1" x-model.number="profitPercent" class="w-full accent-amber-500 cursor-pointer">
                    <input type="number" x-model.number="profitPercent" class="w-24 bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700 rounded-xl px-3 py-2 text-slate-900 dark:text-white font-mono text-center text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                </div>
            </div>

            {{-- مالیات بر ارزش افزوده --}}
            <div class="space-y-2">
                <div class="flex justify-between items-center text-xs">
                    <label class="text-slate-700 dark:text-slate-300 font-bold">مالیات بر ارزش افزوده (۹٪ طبق قانون فقط بر سود و اجرت):</label>
                    <span class="text-emerald-600 dark:text-emerald-400 font-mono font-bold">قانون مصوب ۱۴۰۰</span>
                </div>
            </div>

        </div>

        {{-- خروجی فاکتور نهایی --}}
        <div class="lg:col-span-5 glass-card-gold p-6 sm:p-8 rounded-3xl space-y-6">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">ریز محاسبات فاکتور رسمی طلا</h2>

            <div class="space-y-3.5 text-xs sm:text-sm border-b border-slate-200 dark:border-slate-800 pb-5">
                <div class="flex justify-between text-slate-600 dark:text-slate-300">
                    <span>ارزش طلای خام:</span>
                    <span class="font-mono text-slate-900 dark:text-white font-bold" x-text="formatNumber(rawGoldTotal) + ' تومان'"></span>
                </div>
                <div class="flex justify-between text-slate-600 dark:text-slate-300">
                    <span>اجرت ساخت کارگاه:</span>
                    <span class="font-mono text-amber-600 dark:text-amber-400 font-bold" x-text="'+ ' + formatNumber(ojratTotal) + ' تومان'"></span>
                </div>
                <div class="flex justify-between text-slate-600 dark:text-slate-300">
                    <span>سود مصوب فروشنده (۷٪):</span>
                    <span class="font-mono text-amber-600 dark:text-amber-400 font-bold" x-text="'+ ' + formatNumber(profitTotal) + ' تومان'"></span>
                </div>
                <div class="flex justify-between text-slate-600 dark:text-slate-300">
                    <span>مالیات ارزش افزوده (۹٪ سود و اجرت):</span>
                    <span class="font-mono text-emerald-600 dark:text-emerald-400 font-bold" x-text="'+ ' + formatNumber(taxTotal) + ' تومان'"></span>
                </div>
            </div>

            {{-- مبلغ نهایی پرداختی --}}
            <div class="bg-amber-500/10 dark:bg-slate-950/80 p-5 rounded-2xl border border-amber-500/30 text-center space-y-2">
                <p class="text-xs text-slate-600 dark:text-slate-400 font-bold">مبلغ نهایی قابل پرداخت مشتری:</p>
                <div class="text-2xl sm:text-3xl font-black text-amber-600 dark:text-transparent dark:bg-clip-text dark:bg-gradient-to-r dark:from-amber-300 dark:via-amber-400 dark:to-yellow-400 font-mono" x-text="formatNumber(grandTotal) + ' تومان'">
                </div>
            </div>

            {{-- یادداشت آموزشی --}}
            <div class="bg-slate-100 dark:bg-slate-900/60 p-4 rounded-xl text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed border border-slate-200 dark:border-slate-800">
                <strong class="text-amber-600 dark:text-amber-400">💡 نکته مهم حقوقی:</strong> بر اساس قانون جدید مصوب سال ۱۴۰۰ مجلس شورای اسلامی، اصل طلای خام از مالیات بر ارزش افزوده معاف است و مالیات ۹ درصد تنها باید بر سرجمع «اجرت ساخت + سود مغازه‌دار» اعمال شود.
            </div>
        </div>

    </div>

    {{-- بخش ۲: حباب‌سنج سکه --}}
    <div x-show="activeTab === 'bubble'" x-cloak class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- انتخاب سکه و قیمت --}}
        <div class="lg:col-span-7 glass-panel p-6 sm:p-8 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-6">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 dark:bg-amber-400"></span>
                <span>انتخاب نوع مسکوکات بانکی</span>
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <button @click="changeCoin('emami', {{ $rates['coin_emami'] }})" 
                        :class="coinType === 'emami' ? 'border-amber-500 bg-amber-500/10 text-amber-700 dark:text-amber-300' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-700'"
                        class="p-4 rounded-2xl border text-center transition-all cursor-pointer shadow-sm">
                    <div class="font-bold text-xs">سکه تمام امامی</div>
                    <div class="text-[11px] font-mono mt-1 text-slate-500 dark:text-slate-400" x-text="formatNumber({{ $rates['coin_emami'] }})"></div>
                </button>

                <button @click="changeCoin('bahar', {{ $rates['coin_bahar'] }})" 
                        :class="coinType === 'bahar' ? 'border-amber-500 bg-amber-500/10 text-amber-700 dark:text-amber-300' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-700'"
                        class="p-4 rounded-2xl border text-center transition-all cursor-pointer shadow-sm">
                    <div class="font-bold text-xs">تمام بهار آزادی</div>
                    <div class="text-[11px] font-mono mt-1 text-slate-500 dark:text-slate-400" x-text="formatNumber({{ $rates['coin_bahar'] }})"></div>
                </button>

                <button @click="changeCoin('half', {{ $rates['coin_half'] }})" 
                        :class="coinType === 'half' ? 'border-amber-500 bg-amber-500/10 text-amber-700 dark:text-amber-300' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-700'"
                        class="p-4 rounded-2xl border text-center transition-all cursor-pointer shadow-sm">
                    <div class="font-bold text-xs">نیم سکه</div>
                    <div class="text-[11px] font-mono mt-1 text-slate-500 dark:text-slate-400" x-text="formatNumber({{ $rates['coin_half'] }})"></div>
                </button>

                <button @click="changeCoin('quarter', {{ $rates['coin_quarter'] }})" 
                        :class="coinType === 'quarter' ? 'border-amber-500 bg-amber-500/10 text-amber-700 dark:text-amber-300' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-700'"
                        class="p-4 rounded-2xl border text-center transition-all cursor-pointer shadow-sm">
                    <div class="font-bold text-xs">ربع سکه</div>
                    <div class="text-[11px] font-mono mt-1 text-slate-500 dark:text-slate-400" x-text="formatNumber({{ $rates['coin_quarter'] }})"></div>
                </button>

                <button @click="changeCoin('gerami', {{ $rates['coin_gerami'] }})" 
                        :class="coinType === 'gerami' ? 'border-amber-500 bg-amber-500/10 text-amber-700 dark:text-amber-300' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950/60 text-slate-700 dark:text-slate-300 hover:border-slate-300 dark:hover:border-slate-700'"
                        class="p-4 rounded-2xl border text-center transition-all cursor-pointer shadow-sm">
                    <div class="font-bold text-xs">سکه گرمی</div>
                    <div class="text-[11px] font-mono mt-1 text-slate-500 dark:text-slate-400" x-text="formatNumber({{ $rates['coin_gerami'] }})"></div>
                </button>
            </div>

            {{-- قیمت بازاری سکه --}}
            <div class="space-y-2 pt-3">
                <div class="flex justify-between items-center text-xs">
                    <label class="text-slate-700 dark:text-slate-300 font-bold">قیمت معامله سکه در بازار (تومان):</label>
                    <span class="text-amber-600 dark:text-amber-400 font-mono font-bold" x-text="formatNumber(marketCoinPrice) + ' تومان'"></span>
                </div>
                <input type="number" x-model.number="marketCoinPrice" class="w-full bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-900 dark:text-white font-mono text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-center text-xs">
                    <label class="text-slate-700 dark:text-slate-300 font-bold">مبنای طلای خام (هر گرم ۱۸ عیار):</label>
                    <span class="text-amber-600 dark:text-amber-400 font-mono font-bold" x-text="formatNumber(gramRate) + ' تومان'"></span>
                </div>
                <input type="number" x-model.number="gramRate" class="w-full bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-900 dark:text-white font-mono text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
            </div>

        </div>

        {{-- نتایج تحلیل حباب سکه --}}
        <div class="lg:col-span-5 glass-card-gold p-6 sm:p-8 rounded-3xl space-y-6">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white" x-text="'آنالیز حباب ' + coinSpecs.name"></h2>

            <div class="space-y-3.5 text-xs sm:text-sm border-b border-slate-200 dark:border-slate-800 pb-5">
                <div class="flex justify-between text-slate-600 dark:text-slate-300">
                    <span>وزن دقیق سکه:</span>
                    <span class="font-mono text-slate-900 dark:text-white font-bold" x-text="coinSpecs.weight + ' گرم'"></span>
                </div>
                <div class="flex justify-between text-slate-600 dark:text-slate-300">
                    <span>عیار ضرب بانکی:</span>
                    <span class="font-mono text-slate-900 dark:text-white font-bold">۹۰۰ از ۱۰۰۰ (۲۱.۶ عیار)</span>
                </div>
                <div class="flex justify-between text-slate-600 dark:text-slate-300">
                    <span>ارزش طلای خالص درون سکه:</span>
                    <span class="font-mono text-emerald-600 dark:text-emerald-400 font-bold" x-text="formatNumber(intrinsicCoinValue) + ' تومان'"></span>
                </div>
                <div class="flex justify-between text-slate-600 dark:text-slate-300">
                    <span>حباب اسمی (اضافه‌بها):</span>
                    <span class="font-mono text-rose-600 dark:text-red-400 font-bold" x-text="formatNumber(coinBubbleToman) + ' تومان'"></span>
                </div>
            </div>

            {{-- درصد حباب --}}
            <div class="bg-amber-500/10 dark:bg-slate-950/80 p-5 rounded-2xl border border-amber-500/30 text-center space-y-2">
                <p class="text-xs text-slate-600 dark:text-slate-400 font-bold">درصد حباب نسبت به قیمت بازار:</p>
                <div class="text-3xl font-black font-mono" 
                     :class="coinBubblePercent > 20 ? 'text-rose-600 dark:text-red-400' : (coinBubblePercent > 10 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400')" 
                     x-text="coinBubblePercent + ' ٪'">
                </div>
                <p class="text-[11px]" :class="coinBubblePercent > 20 ? 'text-rose-600 dark:text-red-400' : 'text-slate-600 dark:text-slate-400'">
                    <span x-show="coinBubblePercent > 20">⚠️ حباب بسیار بالاست؛ خرید برای سرمایه‌گذاری پرریسک می‌باشد.</span>
                    <span x-show="coinBubblePercent <= 20 && coinBubblePercent > 10">⚡ حباب در وضعیت متوسط است.</span>
                    <span x-show="coinBubblePercent <= 10">✅ حباب منطقی است و قیمت نزدیک به طلای خام می‌باشد.</span>
                </p>
            </div>
        </div>

    </div>

    {{-- محتوای متنی غنی و سئو درباره فرمول‌های طلا --}}
    <div class="glass-panel p-8 sm:p-12 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-6 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">راهنمای محاسبه قیمت طلا در مغازه طلا فروشی و طلافروشی‌ها</h2>
        <p>
            شاید برای شما هم پیش آمده باشد که هنگام خرید از مغازه طلا فروشی، قیمت نهایی فاکتور با ضرب ساده وزن در نرخ روز متفاوت باشد. در بازار طلای ایران، ۴ عامل کلیدی قیمت نهایی را در طلا فروشی مشخص می‌کنند:
        </p>
        <ol class="list-decimal list-inside space-y-2 text-slate-700 dark:text-slate-300">
            <li><strong>ارزش طلای خام:</strong> وزن قطعه ضرب در قیمت روز طلای ۱۸ عیار (۷۵۰).</li>
            <li><strong>اجرت ساخت:</strong> دستمزد کارگاه طلاسازی که بسته به مدل، ظرافت و سنگ‌های به کار رفته از ۷ درصد تا ۳۰ درصد متغیر است.</li>
            <li><strong>سود طلا فروشی (طلافروش):</strong> طبق آیین‌نامه رسمی اتحادیه صنف طلا و جواهر، سود قانونی طلا فروشی معادل ۷ درصد از جمع طلای خام و اجرت می‌باشد.</li>
            <li><strong>مالیات بر ارزش افزوده (VAT):</strong> مطابق ماده ۲۶ قانون مالیات بر ارزش افزوده مصوب دی‌ماه ۱۴۰۰، طلای خام از مالیات معاف است و مالیات ۹ درصدی تنها به جمع اجرت ساخت و سود فروشنده در طلا فروشی تعلق می‌گیرد.</li>
        </ol>

        <div class="pt-6 border-t border-slate-200 dark:border-slate-800 space-y-4">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">فرمول محاسبه طلای دست دوم (دستدوم)، طلای کم اجرت و بدون اجرت</h3>
            <p>
                بسیاری از خریداران برای حفظ ارزش دارایی و سرمایه‌گذاری، به دنبال <strong>طلای دست دوم</strong> (که در جستجوها به شکل <strong>طلا دست دوم</strong> یا <strong>طلای دستدوم</strong> نوشته می‌شود) یا <strong>طلای کم اجرت</strong> (یا <strong>طلای کماجرت</strong>) هستند:
            </p>
            <ul class="list-disc list-inside space-y-1.5 text-slate-700 dark:text-slate-300">
                <li><strong>طلای دست دوم و بدون اجرت:</strong> اجرت ساخت در این طلاها صفر درصد است و تنها سود مغازه طلا فروشی (معمولاً ۵ تا ۷ درصد) به ارزش طلای خام افزوده می‌شود.</li>
                <li><strong>طلای کم اجرت:</strong> اجرت کارگاهی این کارها بسیار پایین است (بین ۳ تا ۷ درصد) و برای سرمایه‌گذاری زینتی گزینه‌ای ایده‌آل به حساب می‌آیند.</li>
                <li><strong>سکه تمام بهار آزادی و بهار ازادی:</strong> برخلاف طلاهای زینتی، سکه‌ها اجرت ساخت ندارند و ارزش ذاتی آن‌ها منحصراً بر مبنای طلای عیار ۹۰۰ به همراه حباب بازار آزاد تعیین می‌گردد.</li>
            </ul>
        </div>
    </div>

</div>
@endsection
