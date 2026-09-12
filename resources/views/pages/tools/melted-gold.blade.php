@extends('layouts.public')

@section('title', 'محاسبه‌گر آنلاین طلای آبشده، انگ و عیار شرطی ۷۵۰ | طلالایو')
@section('meta_description', 'ابزار تخصصی بنکداران و خریداران طلای آبشده برای تبدیل وزن و عیار انگ ری‌گیری به وزن شرطی ۷۵۰ و محاسبه ارزش ریالی دقیق با نرخ لحظه‌ای طلالایو.')
@section('meta_keywords', 'محاسبه طلای آبشده, عیار انگ طلا, طلای شرطی ۷۵۰, ری گیری طلا, فرمول طلای آبشده, طلالایو')

@section('canonical', 'https://talalive.ir/tools/melted-gold')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "محاسبه‌گر تخصصی طلای آبشده و عیار انگ",
      "url": "https://talalive.ir/tools/melted-gold",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار محاسبه وزن شرطی و ارزش قطعات طلای آبشده بر اساس عیار ری‌گیری و نرخ روز طلای ۱۸ عیار."
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
          "name": "محاسبه‌گر طلای آبشده",
          "item": "https://talalive.ir/tools/melted-gold"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-12">

    <div class="text-center space-y-4 max-w-2xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-bold">
            <span>ابزار استاندارد معاملات بنکداری و کیفی‌های طلا</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            محاسبه‌گر آنلاین طلای آبشده <br>
            <span class="text-amber-500">تبدیل عیار انگ به وزن شرطی ۱۸ عیار (۷۵۰)</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm">
            محاسبه آنی ارزش ریالی بر اساس نرخ روز طلای ۱۸ عیار
        </p>
    </div>

    {{-- ویجت آلپاین طلای آبشده --}}
    <div x-data="{
        rawWeight: 50.25,
        engKarat: 735,
        gold18Rate: {{ $rates['gold18'] > 0 ? $rates['gold18'] : 4500000 }},
        get conditionalWeight() { return (this.rawWeight * this.engKarat) / 750; },
        get totalValue() { return this.conditionalWeight * this.gold18Rate; }
    }" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">وزن ترازوی آبشده (گرم):</label>
                <input type="number" step="0.01" x-model.number="rawWeight" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">عیار انگ ری‌گیری (مثلاً ۷۳۵ یا ۷۶۰):</label>
                <input type="number" step="1" x-model.number="engKarat" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">قیمت هر گرم ۱۸ عیار (تومان):</label>
                <input type="number" step="1000" x-model.number="gold18Rate" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>
        </div>

        {{-- خروجی محاسبات آبشده --}}
        <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/60 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <span class="text-xs text-slate-500">وزن شرطی (معادل طلای ۱۸ عیار ۷۵۰):</span>
                    <div class="text-xl font-black text-amber-500 mt-1">
                        <span x-text="conditionalWeight.toFixed(3)"></span> گرم
                    </div>
                </div>
                <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <span class="text-xs text-slate-500">ارزش کل قطعه آبشده:</span>
                    <div class="text-xl font-black text-emerald-500 mt-1">
                        <span x-text="Math.round(totalValue).toLocaleString('fa-IR')"></span> تومان
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
