@extends('layouts.public')

@section('title', 'تبدیل مظنه طلا و مثقال به گرم ۱۸ عیار آنلاین | فرمول مظنه طلا ۴.۳۳۱۸ | طلالایو')
@section('meta_description', 'ابزار آنلاین تبدیل مظنه طلا و یک مثقال طلای ۱۷ عیار به قیمت هر گرم طلای ۱۸ عیار با ضریب استاندارد ۴.۳۳۱۸ به همراه آموزش کامل فرمول مظنه طلا در بازار طلا فروشی.')
@section('meta_keywords', 'مظنه طلا, مظنه‌ی طلا, تبدیل مظنه به گرم, فرمول مظنه طلا, تبدیل مثقال به گرم ۱۸ عیار, ضریب ۴.۳۳۱۸, طلالایو')

@section('canonical', 'https://talalive.ir/tools/mesghal')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "ابزار تبدیل مظنه مثقال طلا به گرم ۱۸ عیار",
      "url": "https://talalive.ir/tools/mesghal",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار تعاملی تبدیل مظنه مثقال طلای ۱۷ به قیمت هر گرم طلای ۱۸ با ضریب ۴.۳۳۱۸ اتحادیه طلا و جواهر."
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
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-12">

    <div class="text-center space-y-4 max-w-2xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-bold">
            <span>ضریب رسمی صنف طلا و جواهر: ۴.۳۳۱۸</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            تبدیل مظنه مثقال به گرم ۱۸ عیار <br>
            <span class="text-amber-500">و تبدیل گرم به مظنه بازار</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm">
            محاسبه دوطرفه آنی با نرخ لحظه‌ای اتحادیه
        </p>
    </div>

    {{-- ویجت آلپاین تبدیل مظنه --}}
    <div x-data="{
        mesghal: {{ $rates['mesghal'] > 0 ? $rates['mesghal'] : 19500000 }},
        factor: 4.3318,
        get gram18() { return this.mesghal > 0 ? this.mesghal / this.factor : 0; },
        setFromGram(val) { this.mesghal = val * this.factor; }
    }" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">مظنه ۱ مثقال طلای ۱۷ عیار (تومان):</label>
                <input type="number" step="1000" x-model.number="mesghal" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-black text-lg focus:outline-none focus:border-amber-500">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">معادل ۱ گرم طلای ۱۸ عیار (تومان):</label>
                <div class="w-full px-4 py-3 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 font-black text-lg" x-text="Math.round(gram18).toLocaleString('fa-IR') + ' تومان'">
                </div>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-xs text-slate-500 dark:text-slate-400 space-y-2">
            <div class="font-bold text-slate-700 dark:text-slate-300">فرمول ریاضی محاسبه:</div>
            <div>قیمت هر گرم ۱۸ عیار = قیمت یک مثقال تقسیم بر ۴.۳۳۱۸</div>
            <div>قیمت یک مثقال طلا = قیمت یک گرم ۱۸ عیار ضرب در ۴.۳۳۱۸</div>
        </div>
    </div>

    {{-- بنر هدایت به تابلوی طلا --}}
    <div class="rounded-3xl bg-slate-900 border border-amber-500/30 p-8 text-center text-white space-y-4">
        <h3 class="text-xl font-black text-amber-400">می‌خواهید مظنه و گرم ۱۸ عیار خودکار روی تلویزیون مغازه آپدیت شود؟</h3>
        <p class="text-slate-300 text-xs max-w-xl mx-auto">
            با سامانه تابلوی طلالایو، هر نوسان مظنه بازار تهران ثانیه‌ای روی تلویزیون ویترین شما اعمال می‌شود.
        </p>
        <a href="{{ route('admin.register') }}" class="inline-block px-6 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs transition-all">
            تست رایگان ۱۴ روزه طلالایو ←
        </a>
    </div>

</div>
@endsection
