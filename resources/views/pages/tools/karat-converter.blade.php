@extends('layouts.public')

@section('title', 'تبدیل عیار طلا آنلاین (۷۵۰ به ۷۰۵، ۹۹۹ و...) | فرمول تبدیل عیار | طلالایو')
@section('meta_description', 'ابزار آنلاین و رایگان تبدیل انواع عیارهای طلا (۱۸ عیار ۷۵۰، عیار یزدی ۷۰۵، طلای ۲۴ عیار شمش ۹۹۹ و ۲۱ عیار) به همراه جدول مقایسه و فرمول ریاضی.')
@section('meta_keywords', 'تبدیل عیار طلا, عیار ۷۵۰ به ۷۰۵, طلای ۱۸ عیار به ۲۴ عیار, جدول عیارهای طلا, طلالایو')

@section('canonical', 'https://talalive.ir/tools/karat-converter')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "ابزار تبدیل عیار طلا",
      "url": "https://talalive.ir/tools/karat-converter",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار آنلاین محاسبه و تبدیل انواع عیارهای رسمی و سنتی طلا در بازار ایران."
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
          "name": "تبدیل عیار طلا",
          "item": "https://talalive.ir/tools/karat-converter"
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
            <span>استاندارد بین‌المللی خلوص طلا در هزار</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            ماشین‌حساب آنلاین تبدیل عیار طلا <br>
            <span class="text-amber-500">تبدیل عیار مبدأ به عیار مقصد</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm">
            محاسبه دقیق وزن معادل در عیارهای مختلف (۷۵۰، ۷۰۵، ۹۹۹، ۸۷۵ و...)
        </p>
    </div>

    {{-- ویجت آلپاین تبدیل عیار --}}
    <div x-data="{
        weight: 10,
        sourceKarat: 750,
        targetKarat: 999.9,
        get convertedWeight() { return (this.weight * this.sourceKarat) / this.targetKarat; }
    }" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-center">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">وزن طلای مبدأ (گرم):</label>
                <input type="number" step="0.01" x-model.number="weight" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">عیار اولیه (مبدأ):</label>
                <select x-model.number="sourceKarat" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-sm focus:outline-none focus:border-amber-500">
                    <option value="750">۱۸ عیار استاندارد (۷۵۰)</option>
                    <option value="705">عیار سنتی یزد (۷۰۵)</option>
                    <option value="999.9">۲۴ عیار خالص / شمش (۹۹۹.۹)</option>
                    <option value="875">۲۱ عیار خلیجی (۸۷۵)</option>
                    <option value="585">۱۴ عیار اروپایی (۵۸۵)</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">عیار مورد نظر (مقصد):</label>
                <select x-model.number="targetKarat" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-sm focus:outline-none focus:border-amber-500">
                    <option value="999.9">۲۴ عیار خالص / شمش (۹۹۹.۹)</option>
                    <option value="750">۱۸ عیار استاندارد (۷۵۰)</option>
                    <option value="705">عیار سنتی یزد (۷۰۵)</option>
                    <option value="875">۲۱ عیار خلیجی (۸۷۵)</option>
                    <option value="585">۱۴ عیار اروپایی (۵۸۵)</option>
                </select>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-center space-y-2">
            <span class="text-xs font-bold text-amber-700 dark:text-amber-300">وزن معادل در عیار مقصد:</span>
            <div class="text-3xl font-black text-amber-500">
                <span x-text="convertedWeight.toFixed(3)"></span> گرم
            </div>
        </div>
    </div>

</div>
@endsection
