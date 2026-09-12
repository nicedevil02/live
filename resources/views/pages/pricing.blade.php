@extends('layouts.public')

@section('title', 'تعرفه و قیمت اشتراک تابلوی هوشمند طلافروشی | طلالایو')
@section('meta_description', 'تعرفه شفاف و منصفانه اشتراک تابلوی هوشمند طلافروشی طلالایو. امکان ۱۴ روز تست کاملاً رایگان بدون نیاز به پرداخت، به همراه پشتیبانی ۲۴ ساعته و به‌روزرسانی مداوم.')
@section('meta_keywords', 'قیمت تابلو طلافروشی, هزینه نرم افزار تابلو طلا, اشتراک تابلو نرخ, تعرفه طلالایو, خرید اشتراک تابلو طلا')

@section('canonical', 'https://talalive.ir/pricing')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "Product",
      "name": "اشتراک سامانه تابلوی هوشمند طلافروشی طلالایو",
      "description": "سامانه ابری نمایش زنده نرخ طلا و ویترین جواهرات روی تلویزیون بدون مینی‌کیس",
      "offers": {
        "@@type": "AggregateOffer",
        "priceCurrency": "IRR",
        "lowPrice": "0",
        "highPrice": "49000000",
        "offerCount": "3"
      }
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
          "name": "تعرفه‌ها و اشتراک",
          "item": "https://talalive.ir/pricing"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-20">

    <div class="text-center space-y-6 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-300 text-xs font-bold">
            <span>سرمایه‌گذاری هوشمند در پرستیژ و فروش گالری</span>
        </div>
        
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white leading-tight">
            پلن‌های تعرفه و اشتراک <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-yellow-500">
                تابلوی هوشمند طلالایو
            </span>
        </h1>

        <p class="text-slate-600 dark:text-slate-400 text-base sm:text-lg leading-relaxed">
            بدون هیچ هزینه سخت‌افزاری یا دستگاه‌های گران‌قیمت. با همان تلویزیون مغازه شروع کنید.
        </p>
    </div>

    {{-- پلن‌های اشتراک --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        {{-- پلن تستی --}}
        <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-8 space-y-6 relative flex flex-col justify-between shadow-lg">
            <div class="space-y-4">
                <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-black">شروع کاربری</span>
                <h3 class="text-xl font-black text-slate-900 dark:text-white">۱۴ روز تست رایگان</h3>
                <div class="text-3xl font-black text-slate-900 dark:text-white">رایگان <span class="text-xs text-slate-400 font-normal">/ بدون تعهد</span></div>
                <p class="text-slate-500 text-xs leading-relaxed">برای آشنایی با سامانه و اتصال آزمایشی به تلویزیون مغازه.</p>
                <ul class="space-y-3 text-xs text-slate-600 dark:text-slate-400 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <li class="flex items-center gap-2">✅ دسترسی کامل به تمامی تم‌های لوکس</li>
                    <li class="flex items-center gap-2">✅ بروزرسانی ۱۰ ثانیه‌ای قیمت‌ها</li>
                    <li class="flex items-center gap-2">✅ قابلیت اتصال به ۱ تلویزیون</li>
                    <li class="flex items-center gap-2">✅ بدون نیاز به ثبت کارت بانکی</li>
                </ul>
            </div>
            <a href="{{ route('admin.register') }}" class="w-full py-3.5 rounded-2xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-900 dark:text-white font-bold text-xs text-center transition-all cursor-pointer">
                شروع تست رایگان
            </a>
        </div>

        {{-- پلن سالانه VIP (برجسته) --}}
        <div class="rounded-3xl bg-gradient-to-b from-amber-500/10 via-amber-500/5 to-slate-900/40 border-2 border-amber-500 p-8 space-y-6 relative flex flex-col justify-between shadow-2xl shadow-amber-500/10 transform md:-translate-y-4">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-amber-500 text-slate-950 font-black text-xs shadow-md">
                محبوب‌ترین انتخاب گالری‌ها (تخفیف ویژه)
            </div>
            <div class="space-y-4 pt-2">
                <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-600 dark:text-amber-400 text-xs font-black">یک‌ساله طلایی</span>
                <h3 class="text-xl font-black text-slate-900 dark:text-white">اشتراک سالانه VIP</h3>
                <div class="text-3xl font-black text-amber-500">منصفانه و اقتصادی <span class="text-xs text-slate-400 font-normal">/ سالانه</span></div>
                <p class="text-slate-500 text-xs leading-relaxed">کامل‌ترین پکیج برای طلافروشان حرفه‌ای با ویترین محصولات و فرمول‌های پیشرفته.</p>
                <ul class="space-y-3 text-xs text-slate-700 dark:text-slate-300 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <li class="flex items-center gap-2 font-bold text-amber-500">✨ ویترین دیجیتال نامحدود عکس محصولات</li>
                    <li class="flex items-center gap-2">✅ بروزرسانی فوق سریع ۱۰ ثانیه‌ای تتر و طلا</li>
                    <li class="flex items-center gap-2">✅ فرمول‌ساز پیشرفته حباب و سود اختصاصی</li>
                    <li class="flex items-center gap-2">✅ پشتیبانی تلفنی VIP در تمام ایام سال</li>
                    <li class="flex items-center gap-2">✅ ضمانت بازگشت وجه در صورت عدم رضایت</li>
                </ul>
            </div>
            <a href="{{ route('admin.register') }}" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-black text-xs text-center shadow-lg shadow-amber-500/25 transition-all hover:scale-105 cursor-pointer">
                خرید و فعال‌سازی فوری
            </a>
        </div>

        {{-- پلن فصلی --}}
        <div class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-8 space-y-6 relative flex flex-col justify-between shadow-lg">
            <div class="space-y-4">
                <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-black">انعطاف‌پذیر</span>
                <h3 class="text-xl font-black text-slate-900 dark:text-white">اشتراک ۳ ماهه (فصلی)</h3>
                <div class="text-3xl font-black text-slate-900 dark:text-white">دوره‌ای <span class="text-xs text-slate-400 font-normal">/ هر ۳ ماه</span></div>
                <p class="text-slate-500 text-xs leading-relaxed">تمدید فصلی بدون تعهد بلندمدت با قابلیت ارتقا به سالانه.</p>
                <ul class="space-y-3 text-xs text-slate-600 dark:text-slate-400 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <li class="flex items-center gap-2">✅ تمام تم‌های ۸ گانه شیشه‌ای و کلاسیک</li>
                    <li class="flex items-center gap-2">✅ فرمول اختصاصی خرید و فروش طلا</li>
                    <li class="flex items-center gap-2">✅ ویترین محصولات تا ۲۰ تصویر</li>
                    <li class="flex items-center gap-2">✅ پشتیبانی تیکتی و تلفنی</li>
                </ul>
            </div>
            <a href="{{ route('admin.register') }}" class="w-full py-3.5 rounded-2xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-900 dark:text-white font-bold text-xs text-center transition-all cursor-pointer">
                انتخاب پلن فصلی
            </a>
        </div>
    </div>

</div>
@endsection
