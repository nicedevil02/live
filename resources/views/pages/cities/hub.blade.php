@extends('layouts.public')

@section('title', $info['title'] . ' | طلالایو')
@section('meta_description', 'سامانه ابری تابلوی هوشمند طلافروشی ویژه گالری‌های طلا و جواهر در شهر ' . $info['name'] . ' و ' . $info['bazaar'] . '. نمایش لحظه‌ای نرخ طلا، سکه و ویترین روی تلویزیون بدون مینی‌کیس.')
@section('meta_keywords', 'تابلو طلافروشی ' . $info['name'] . ', تابلو دیجیتال طلا ' . $info['name'] . ', تابلو قیمت طلا ' . $info['bazaar'] . ', طلالایو')

@section('canonical', 'https://talalive.ir/cities/' . $city)

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
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
          "name": "تابلو طلافروشی در {{ $info['name'] }}",
          "item": "https://talalive.ir/cities/{{ $city }}"
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
            <span>سامانه اختصاصی صنف طلا و جواهر {{ $info['name'] }}</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white leading-tight">
            تابلوی هوشمند طلافروشی در <br>
            <span class="text-amber-500">{{ $info['name'] }} ({{ $info['bazaar'] }})</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-base sm:text-lg leading-relaxed">
            گالری‌های طلا در شهر {{ $info['name'] }} می‌توانند بدون نیاز به خرید تابلوهای پرهزینه LED یا مینی‌کیس، تلویزیون مغازه را در کمتر از ۶۰ ثانیه به یک تابلوی اعلانات فوق‌العاده شیک با تم‌های شیشه‌ای تبدیل کنند.
        </p>
    </div>

    {{-- ویژگی‌های بومی و صنفی --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg space-y-3">
            <span class="text-2xl">⚡</span>
            <h3 class="font-bold text-slate-900 dark:text-white text-base">همگام با نوسانات بازار</h3>
            <p class="text-xs text-slate-500 leading-relaxed">بروزرسانی مداوم نرخ‌های مظنه، گرم ۱۸ و مسکوکات مطابق با معاملات بازار طلا در {{ $info['name'] }}.</p>
        </div>
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg space-y-3">
            <span class="text-2xl">📱</span>
            <h3 class="font-bold text-slate-900 dark:text-white text-base">کنترل آسان با موبایل</h3>
            <p class="text-xs text-slate-500 leading-relaxed">اعمال فرمول سود فروش، تخفیف‌ها و نرخ خرید طلا از مشتری مستقیماً از گوشی همراه بدون نیاز به ایستادن پشت کامپیوتر.</p>
        </div>
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg space-y-3">
            <span class="text-2xl">💎</span>
            <h3 class="font-bold text-slate-900 dark:text-white text-base">ویترین دیجیتال جواهرات</h3>
            <p class="text-xs text-slate-500 leading-relaxed">نمایش اسلایدر باکیفیت النگو، سرویس و کارهای خاص گالری شما روی تلویزیون جهت جذب مشتریان پیاده‌رو.</p>
        </div>
    </div>

    {{-- اقدام به ثبت‌نام برای طلافروشان این شهر --}}
    <div class="rounded-3xl bg-gradient-to-r from-amber-500 to-amber-600 p-8 sm:p-10 text-center text-slate-950 space-y-4 shadow-xl">
        <h2 class="text-2xl sm:text-3xl font-black">طلافروشان محترم {{ $info['name'] }}؛ تست ۱۴ روزه رایگان</h2>
        <p class="text-slate-900 text-sm max-w-xl mx-auto">
            همین امروز تابلوی گالری خود را با ۱۴ روز استفاده کاملاً رایگان راه‌اندازی کنید و از دکوراسیون چشم‌نواز مغازه خود لذت ببرید.
        </p>
        <div class="pt-2">
            <a href="{{ route('admin.register') }}" class="inline-block px-8 py-4 rounded-2xl bg-slate-950 text-amber-400 font-black text-xs hover:scale-105 transition-all cursor-pointer">
                ثبت‌نام و راه‌اندازی گالری در ۶۰ ثانیه ←
            </a>
        </div>
    </div>

</div>
@endsection
