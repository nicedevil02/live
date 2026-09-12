@extends('layouts.public')

@section('title', 'ماشین حساب محاسبه قیمت طلا در مغازه طلا فروشی | محاسبه آنلاین طلا با اجرت | طلالایو')
@section('meta_description', 'ابزار آنلاین محاسبه قیمت طلا در مغازه طلا فروشی بر اساس فرمول اتحادیه طلا. محاسبه اجرت، سود ۷٪ طلا فروشی و مالیات با نرخ لحظه‌ای طلالایو.')
@section('meta_keywords', 'محاسبه آنلاین قیمت طلا, ماشین حساب طلا فروشی, ماشین‌حساب طلا, سود طلا فروشی, فرمول طلا با اجرت, سود طلافروشی, فاکتور طلا آنلاین')

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
        "ماشین‌حساب طلا",
        "فرمول قیمت طلا فروشی",
        "محاسبه فاکتور طلا فروشی"
      ],
      "url": "https://talalive.ir/tools/gold-price-calculator",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار محاسبه فاکتور خرید طلا با احتساب وزن، اجرت ساخت، سود ۷ درصد مغازه طلا فروشی و مالیات ۹ درصد طبق آخرین مصوبه اتحادیه طلا و جواهر."
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
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-12">

    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-bold">
            <span>فرمول رسمی مصوب اتحادیه طلا و جواهر کشور</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            ماشین‌حساب آنلاین محاسبه قیمت طلا <br>
            <span class="text-amber-500">با اجرت ساخت، سود ۷٪ و مالیات ۹٪</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base">
            نرخ لحظه‌ای پایه: <strong class="text-amber-500">{{ number_format($rates['gold18']) }}</strong> تومان (بروزرسانی: {{ $lastUpdated }})
        </p>
    </div>

    {{-- ویجت محاسبه‌گر آلپاین --}}
    <div x-data="{
        weight: 4.5,
        ratePerGram: {{ $rates['gold18'] > 0 ? $rates['gold18'] : 4500000 }},
        ojratPercent: 18,
        profitPercent: 7,
        vatPercent: 9,
        get rawGoldPrice() { return this.weight * this.ratePerGram; },
        get ojratAmount() { return this.rawGoldPrice * (this.ojratPercent / 100); },
        get profitAmount() { return (this.rawGoldPrice + this.ojratAmount) * (this.profitPercent / 100); },
        get vatAmount() { return (this.ojratAmount + this.profitAmount) * (this.vatPercent / 100); },
        get finalPrice() { return this.rawGoldPrice + this.ojratAmount + this.profitAmount + this.vatAmount; }
    }" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">وزن طلا (گرم):</label>
                <input type="number" step="0.01" x-model.number="weight" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">قیمت هر گرم طلای ۱۸ عیار (تومان):</label>
                <input type="number" step="1000" x-model.number="ratePerGram" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">درصد اجرت ساخت (%):</label>
                <input type="number" step="0.5" x-model.number="ojratPercent" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">سود مصوب فروشنده (قانوناً ۷٪):</label>
                <input type="number" step="0.5" x-model.number="profitPercent" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>
        </div>

        {{-- تفکیک فاکتور نهایی --}}
        <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/60 space-y-4">
            <div class="text-xs font-bold text-slate-400">ریز اقلام فاکتور خرید:</div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                <div>
                    <span class="text-slate-500">طلای خام:</span>
                    <div class="font-black text-slate-800 dark:text-slate-200 mt-1" x-text="Math.round(rawGoldPrice).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
                <div>
                    <span class="text-slate-500">مبلغ اجرت:</span>
                    <div class="font-black text-slate-800 dark:text-slate-200 mt-1" x-text="Math.round(ojratAmount).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
                <div>
                    <span class="text-slate-500">سود ۷ درصد:</span>
                    <div class="font-black text-slate-800 dark:text-slate-200 mt-1" x-text="Math.round(profitAmount).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
                <div>
                    <span class="text-slate-500">مالیات ۹٪ (روی اجرت+سود):</span>
                    <div class="font-black text-rose-500 mt-1" x-text="Math.round(vatAmount).toLocaleString('fa-IR') + ' تومان'"></div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="font-black text-slate-900 dark:text-white text-base">مبلغ کل فاکتور نهایی:</span>
                <span class="text-2xl sm:text-3xl font-black text-amber-500" x-text="Math.round(finalPrice).toLocaleString('fa-IR') + ' تومان'"></span>
            </div>
        </div>
    </div>

    {{-- بنر تبدیل به مشتری B2B --}}
    <div class="rounded-3xl bg-slate-900 border border-amber-500/30 p-8 text-center text-white space-y-4 shadow-xl">
        <span class="text-3xl">💎</span>
        <h3 class="text-xl sm:text-2xl font-black text-amber-400">آیا صاحب گالری یا طلافروشی هستید؟</h3>
        <p class="text-slate-300 text-sm max-w-2xl mx-auto leading-relaxed">
            همین فرمول‌ها و سود فروش را به صورت خودکار روی تلویزیون مغازه خود بدون نیاز به کیس نمایش دهید.
        </p>
        <div class="pt-2">
            <a href="{{ route('admin.register') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-black text-xs hover:scale-105 transition-all cursor-pointer">
                راه‌اندازی فوری تابلوی طلا مغازه (۱۴ روز رایگان) ←
            </a>
        </div>
    </div>

</div>
@endsection
