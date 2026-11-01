@extends('layouts.public')

@section('title', 'تعرفه و قیمت تابلو طلا فروشی | هزینه اشتراک تابلوی هوشمند طلافروشی | طلالایو')
@section('meta_description', 'تعرفه شفاف و قیمت تابلو طلا فروشی با سامانه ابری طلالایو. مقایسه هزینه تابلو هوشمند با تابلوهای سنتی، ۱۴ روز تست رایگان برای مغازه طلا فروشی بدون نیاز به پیش‌پرداخت.')
@section('canonical', 'https://talalive.ir/pricing')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "Product",
      "name": "اشتراک سامانه تابلوی هوشمند طلافروشی و طلا فروشی طلالایو",
      "description": "سامانه ابری نمایش زنده نرخ طلا و ویترین جواهرات روی تلویزیون مغازه طلا فروشی بدون مینی‌کیس",
      "offers": {
        "@@type": "AggregateOffer",
        "priceCurrency": "IRR",
        "lowPrice": "0",
        "highPrice": "49000000",
        "offerCount": "4"
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
          "name": "تعرفه‌ها و قیمت تابلو طلا فروشی",
          "item": "https://talalive.ir/pricing"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="relative py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16 overflow-hidden">

    {{-- هاله نور مخفی استودیویی پشت هدر تعرفه --}}
    <div class="tl-ambient-gold absolute -top-10 left-1/2 -translate-x-1/2 w-[560px] h-[220px] rounded-full opacity-80" aria-hidden="true"></div>

    {{-- هدر صفحه --}}
    <div class="relative z-10 text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full tl-glass-badge text-amber-800 dark:text-amber-300 text-xs font-bold">
            @include('partials.ui-icon', ['name' => 'receipt', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
            <span>تعرفه‌های شفاف و اقتصادی طلالایو</span>
        </div>
        
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-stone-900 dark:text-stone-50 leading-tight">
            تعرفه و قیمت تابلو طلا فروشی <br>
            <span class="text-amber-700 dark:text-amber-400">
                سامانه هوشمند تابلوی طلالایو
            </span>
        </h1>

        <p class="text-stone-600 dark:text-stone-400 text-base sm:text-lg leading-relaxed">
            بدون هیچ هزینه سخت‌افزاری یا دستگاه‌های اضافه. با همان تلویزیون مغازه شروع کنید.
        </p>

        <div class="pt-2 flex items-center justify-center gap-3">
            <a href="{{ url('/demo') }}" class="min-h-11 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 font-bold text-xs">
                @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                <span>مشاهده پیش‌نمایش زنده تابلو بدون نیاز به ثبت‌نام (/demo)</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </div>
    </div>

    {{-- بنر افقی شیشه‌ای تست رایگان ۱۴ روزه --}}
    <div class="tl-reveal relative z-10 max-w-6xl mx-auto rounded-3xl p-6 sm:p-8 tl-glass-deck flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-start gap-4 text-right">
            <div class="w-12 h-12 rounded-2xl tl-neu-icon-orb flex items-center justify-center shrink-0 text-amber-700 dark:text-amber-400">
                @include('partials.ui-icon', ['name' => 'gift', 'class' => 'w-6 h-6'])
            </div>
            <div class="space-y-2">
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-50">
                        ۱۴ روز مهلت تست ۱۰۰٪ رایگان برای کلیه طلافروشان
                    </h2>
                    <span class="px-2.5 py-0.5 rounded-lg text-[11px] font-bold tl-glass-badge text-emerald-800 dark:text-emerald-300">
                        بدون نیاز به کارت بانکی
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-300 leading-relaxed max-w-2xl">
                    همین حالا تابلوی اختصاصی گالری خود را با تمام امکانات لوکس، فرمول‌ساز سود و اسلایدشو روی تلویزیون مغازه راه‌اندازی کنید و به مدت ۱۴ روز رایگان ارزیابی فرمایید.
                </p>
            </div>
        </div>

        <div class="shrink-0 w-full md:w-auto">
            <a href="{{ route('admin.register') }}" class="w-full md:w-auto min-h-11 px-6 py-3 rounded-xl tl-btn-bullion font-bold text-xs inline-flex items-center justify-center gap-2">
                <span>شروع تست رایگان ۱۴ روزه</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
            </a>
        </div>
    </div>

    {{-- گرید ۴ پلن اشتراک واقعی و هم‌تراز نئومورفیک --}}
    <div class="tl-reveal relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch max-w-6xl mx-auto">
        
        {{-- پلن ۱: ۱ ماهه --}}
        <div class="tl-neu-card rounded-3xl p-6 sm:p-7 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اشتراک ۱ ماهه</h3>
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tl-neu-inset text-stone-700 dark:text-stone-300">۳۰ روز</span>
                </div>
                <div class="mb-4">
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-3xl font-black text-stone-900 dark:text-stone-50 tabular-nums">۶۹۰,۰۰۰</span>
                        <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                    </div>
                    <div class="text-[11px] text-stone-600 dark:text-stone-400 mt-1 tabular-nums">ماهیانه ۶۹۰,۰۰۰ تومان</div>
                </div>
                <p class="text-xs text-stone-600 dark:text-stone-400 mb-6 leading-relaxed">
                    مناسب بررسی و تست میدانی امکانات تابلوی هوشمند در مغازه.
                </p>
                <ul class="space-y-3 text-xs text-stone-700 dark:text-stone-300 border-t border-stone-300/60 dark:border-stone-800 pt-5">
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>پخش زنده تلویزیون 4K</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>فرمول‌ساز سود و مظنه</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>ویترین و اسلایدر محصولات</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>پشتیبانی روبیکا و تلفنی</span>
                    </li>
                </ul>
            </div>
            <div class="mt-8 pt-4">
                <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 text-xs font-bold flex items-center justify-center gap-1.5">
                    <span>شروع با تست رایگان</span>
                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                </a>
            </div>
        </div>

        {{-- پلن ۲: ۳ ماهه --}}
        <div class="tl-neu-card rounded-3xl p-6 sm:p-7 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اشتراک ۳ ماهه</h3>
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tl-neu-inset text-stone-700 dark:text-stone-300">۱۵٪ صرفه‌جویی</span>
                </div>
                <div class="mb-4">
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-3xl font-black text-stone-900 dark:text-stone-50 tabular-nums">۱,۷۹۰,۰۰۰</span>
                        <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                    </div>
                    <div class="text-[11px] text-stone-600 dark:text-stone-400 mt-1 tabular-nums">معادل ۵۹۶,۰۰۰ تومان / ماه</div>
                </div>
                <p class="text-xs text-stone-600 dark:text-stone-400 mb-6 leading-relaxed">
                    انتخاب فصلی با ثبات نرخ و دسترسی کامل به کلیه قابلیت‌ها.
                </p>
                <ul class="space-y-3 text-xs text-stone-700 dark:text-stone-300 border-t border-stone-300/60 dark:border-stone-800 pt-5">
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>پخش زنده تلویزیون 4K</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>فرمول‌ساز سود و مظنه</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>ویترین و اسلایدر محصولات</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>پشتیبانی روبیکا و تلفنی</span>
                    </li>
                </ul>
            </div>
            <div class="mt-8 pt-4">
                <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 text-xs font-bold flex items-center justify-center gap-1.5">
                    <span>شروع با تست رایگان</span>
                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                </a>
            </div>
        </div>

        {{-- پلن ۳: ۶ ماهه --}}
        <div class="tl-neu-card rounded-3xl p-6 sm:p-7 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اشتراک ۶ ماهه</h3>
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tl-neu-inset text-stone-700 dark:text-stone-300">۳۰٪ صرفه‌جویی</span>
                </div>
                <div class="mb-4">
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-3xl font-black text-stone-900 dark:text-stone-50 tabular-nums">۲,۸۹۰,۰۰۰</span>
                        <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                    </div>
                    <div class="text-[11px] text-stone-600 dark:text-stone-400 mt-1 tabular-nums">معادل ۴۸۱,۰۰۰ تومان / ماه</div>
                </div>
                <p class="text-xs text-stone-600 dark:text-stone-400 mb-6 leading-relaxed">
                    پلن نیم‌سال با تخفیف ویژه و پایداری تضمین‌شده سرورها.
                </p>
                <ul class="space-y-3 text-xs text-stone-700 dark:text-stone-300 border-t border-stone-300/60 dark:border-stone-800 pt-5">
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>پخش زنده تلویزیون 4K</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>فرمول‌ساز سود و مظنه</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>ویترین و اسلایدر محصولات</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <span>پشتیبانی روبیکا و تلفنی</span>
                    </li>
                </ul>
            </div>
            <div class="mt-8 pt-4">
                <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 text-xs font-bold flex items-center justify-center gap-1.5">
                    <span>شروع با تست رایگان</span>
                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                </a>
            </div>
        </div>

        {{-- پلن ۴: ۱۲ ماهه (پیشنهاد برگزیده طلایی - HERO PLAN) --}}
        <div class="relative tl-neu-card-gold rounded-3xl p-6 sm:p-7 flex flex-col justify-between lg:-translate-y-2">
            <div class="absolute -top-3.5 right-1/2 translate-x-1/2 px-4 py-1 rounded-full text-xs font-bold tl-btn-bullion whitespace-nowrap inline-flex items-center gap-1.5">
                @include('partials.ui-icon', ['name' => 'gem', 'class' => 'w-3.5 h-3.5'])
                <span>محبوب‌ترین انتخاب طلافروشان</span>
            </div>

            <div>
                <div class="flex items-center justify-between mb-4 pt-2">
                    <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اشتراک سالانه (۱۲ ماه)</h3>
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tl-glass-badge text-amber-800 dark:text-amber-300">بیش از ۵۰٪ تخفیف</span>
                </div>
                <div class="mb-4">
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-3xl font-black text-amber-700 dark:text-amber-400 tabular-nums">۳,۹۹۰,۰۰۰</span>
                        <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                    </div>
                    <div class="text-[11px] text-emerald-700 dark:text-emerald-400 font-bold mt-1 tabular-nums">معادل فقط ۳۳۲,۵۰۰ تومان / ماه</div>
                </div>
                <p class="text-xs text-stone-600 dark:text-stone-400 mb-6 leading-relaxed">
                    بیشترین صرفه اقتصادی برای یک سال کامل بدون دغدغه نوسان قیمت، همراه با اولویت پشتیبانی.
                </p>
                <ul class="space-y-3 text-xs text-stone-700 dark:text-stone-300 border-t border-amber-500/25 pt-5">
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                        <span class="font-bold text-stone-900 dark:text-stone-100">پخش زنده تلویزیون 4K نامحدود</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                        <span>فرمول‌ساز اختصاصی سود و مظنه</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                        <span>ویترین و اسلایدر نامحدود محصولات</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                        <span>کارکرد هوشمند در قطعی اینترنت</span>
                    </li>
                    <li class="flex items-center gap-2">
                        @include('partials.ui-icon', ['name' => 'shield', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                        <span class="font-bold text-amber-700 dark:text-amber-400">ضمانت بازگشت وجه در صورت عدم رضایت</span>
                    </li>
                </ul>
            </div>
            <div class="mt-8 pt-4">
                <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-btn-bullion text-xs font-bold flex items-center justify-center gap-1.5">
                    <span>ثبت‌نام و شروع ۱۴ روز تست رایگان</span>
                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                </a>
            </div>
        </div>

    </div>

    {{-- بخش مقایسه با سایر راه‌حل‌ها و رقبا --}}
    <div class="tl-reveal relative z-10 pt-10 border-t border-stone-300/60 dark:border-stone-800 space-y-8 max-w-6xl mx-auto">
        <div class="text-center space-y-3">
            <h2 class="text-xl sm:text-2xl font-bold text-stone-900 dark:text-stone-50">
                مقایسه شفاف طلالایو با سایر گزینه‌ها و نرم‌افزارهای بازار
            </h2>
            <p class="text-stone-600 dark:text-stone-400 text-xs sm:text-sm max-w-2xl mx-auto">
                قبل از تصمیم‌گیری، بررسی و مقایسه مستقل ویژگی‌ها، هزینه‌ها و معماری نرم‌افزارهای صنف طلا را مطالعه فرمایید:
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('public.compare.tabangohar') }}" class="p-5 rounded-3xl tl-neu-card-interactive group block">
                <div class="text-xs text-amber-700 dark:text-amber-400 font-bold mb-1">مقایسه نرم‌افزار</div>
                <h3 class="text-sm font-bold text-stone-900 dark:text-stone-50 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors">مقایسه با تابان گوهر</h3>
                <p class="text-[11px] text-stone-600 dark:text-stone-400 mt-2 line-clamp-2">بررسی نیاز به مینی‌کیس، هزینه اولیه و امکانات تحت وب در برابر تابان گوهر.</p>
            </a>

            <a href="{{ route('public.compare.tgju-tv') }}" class="p-5 rounded-3xl tl-neu-card-interactive group block">
                <div class="text-xs text-amber-700 dark:text-amber-400 font-bold mb-1">مقایسه تلویزیون نرخ</div>
                <h3 class="text-sm font-bold text-stone-900 dark:text-stone-50 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors">مقایسه با TGJU TV</h3>
                <p class="text-[11px] text-stone-600 dark:text-stone-400 mt-2 line-clamp-2">تفاوت سامانه ابری تخصصی طلافروشی با نسخه نمایش عمومی و رایگان شبکه اطلاع‌رسانی طلا.</p>
            </a>

            <a href="{{ route('public.compare.tablotala') }}" class="p-5 rounded-3xl tl-neu-card-interactive group block">
                <div class="text-xs text-amber-700 dark:text-amber-400 font-bold mb-1">مقایسه اپلیکیشن</div>
                <h3 class="text-sm font-bold text-stone-900 dark:text-stone-50 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors">مقایسه با تابلوی نرخ طلا</h3>
                <p class="text-[11px] text-stone-600 dark:text-stone-400 mt-2 line-clamp-2">سامانه ابری تحت وب در برابر اپلیکیشن‌های اندرویدی نیازمند نصب و آپدیت دستی.</p>
            </a>

            <a href="{{ route('public.led-vs-smart-board') }}" class="p-5 rounded-3xl tl-neu-card-interactive group block">
                <div class="text-xs text-amber-700 dark:text-amber-400 font-bold mb-1">تحلیل اقتصادی TCO</div>
                <h3 class="text-sm font-bold text-stone-900 dark:text-stone-50 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors">مقایسه هزینه با تابلوی LED</h3>
                <p class="text-[11px] text-stone-600 dark:text-stone-400 mt-2 line-clamp-2">محاسبه هزینه‌های خرید ماژول، استهلاک، پاور و تعمیرات در افق ۳ ساله.</p>
            </a>
        </div>
    </div>

</div>
@endsection
