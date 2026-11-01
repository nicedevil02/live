@extends('layouts.public')

@section('title', 'دانشنامه و مقالات تخصصی صنف طلا، تابلو طلا فروشی و تابلوی طلافروشی | طلالایو')
@section('meta_description', 'مجموعه مقالات و راهنماهای تخصصی درباره تابلو طلا فروشی، تابلوی هوشمند طلافروشی، راهنمای اتصال تلویزیون مغازه، فرمول‌های محاسبه طلای آب شده، مظنه و مالیات طلا.')
@section('canonical', 'https://talalive.ir/guides')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "CollectionPage",
      "name": "پایگاه دانش و مقالات طلالایو",
      "description": "راهنماهای جامع سخت‌افزاری، نرم‌افزاری و محاسباتی صنف طلا و جواهر.",
      "url": "https://talalive.ir/guides"
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
          "name": "دانشنامه و مقالات",
          "item": "https://talalive.ir/guides"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16">

    {{-- هدر صفحه --}}
    <header class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-800 dark:text-amber-300 text-xs font-semibold">
            @include('partials.ui-icon', ['name' => 'book-open', 'class' => 'w-4 h-4 text-amber-600 dark:text-amber-400'])
            <span>پایگاه دانش تخصصی طلالایو</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-stone-900 dark:text-stone-100 leading-tight">
            راهنماها و مقالات تخصصی صنف طلا و جواهر
        </h1>
        <p class="text-stone-600 dark:text-stone-400 text-xs sm:text-sm leading-relaxed">
            آموزش‌های کاربردی درباره تجهیزات تابلو طلا، فناوری‌های تابلوی ابری، فرمول‌های دقیق حسابداری طلای آبشده و تنظیمات تلویزیون طلافروشی.
        </p>
    </header>

    {{-- شبکه مقالات --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        
        {{-- کارت ۱: فرمول محاسبه قیمت طلا ۱۸ عیار --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">فرمول‌های طلا</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'gold-price-formula-18k') }}">
                        فرمول دقیق محاسبه قیمت طلا ۱۸ عیار با اجرت و سود اتحادیه در طلا فروشی
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    آموزش گام‌به‌گام نحوه محاسبه فاکتور طلا، درصد اجرت، سود ۷ درصد قانونی مغازه طلا فروشی و قانون جدید مالیات ارزش افزوده.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'gold-price-formula-18k') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۲: بهترین تلویزیون مغازه --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">سخت‌افزار و تلویزیون</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'best-tv-for-jewelry-shop') }}">
                        راهنمای انتخاب بهترین تلویزیون برای تابلو طلا فروشی و مغازه طلافروشی
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    مقایسه پنل‌های سامسونگ، ال‌جی، سونی و اسنوا برای تابلو طلا فروشی از نظر روشنایی، زاویه دید و دوام مداوم.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'best-tv-for-jewelry-shop') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۳: مالیات طلا و سامانه مودیان --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">قوانین و مالیات</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'gold-tax-regulations') }}">
                        قانون جدید مالیات طلا و اجرت در سامانه مودیان صنف طلا و مغازه طلا فروشی
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    بررسی تکالیف مالیاتی طلافروشان و مغازه طلا فروشی، معافیت اصل طلا و نحوه صدور صورتحساب الکترونیکی در پایانه فروشگاهی.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'gold-tax-regulations') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۴: فرمول حباب سکه --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">مسکوکات</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'how-to-calculate-coin-bubble') }}">
                        فرمول محاسبه حباب سکه امامی، بهار آزادی، نیم‌سکه و ربع‌سکه
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    نحوه محاسبه ارزش ذاتی انواع سکه، نیم‌سکه و ربع‌سکه بر اساس وزن، عیار ۹۰۰، حق ضرب بانک مرکزی و تشخیص حباب.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'how-to-calculate-coin-bubble') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۵: مقایسه با تابلو LED --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">مقایسه تجهیزات</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.led-vs-smart-board') }}">
                        مقایسه تابلو LED با تلویزیون تابلو طلا فروشی
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    چرا دوران تابلوهای پرمصرف و پرهزینه LED به سر آمده و چگونه تلویزیون موجود در مغازه بهترین جایگزین اقتصادی است؟
                </p>
            </div>
            <a href="{{ route('public.led-vs-smart-board') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مشاهده مقایسه</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۶: مظنه فردایی و نقدی --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">مظنه و بازار</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'mazaneh-fardaei') }}">
                        مظنه فردایی چیست و چه فرقی با مظنه نقدی دارد؟
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    بررسی عمیق تفاوت مظنه نقدی، فردایی و جهانی، نحوه تبدیل مظنه به گرم و اهمیت آن در تابلوی اعلام قیمت طلافروشی.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'mazaneh-fardaei') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۷: تعویض و خرید متفرقه ۱۸ --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">طلای کارکرده</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'motefareghe-18') }}">
                        تعویض و خرید متفرقه ۱۸ چیست؟ راهنمای طلافروش
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    تعریف متفرقه در صنف طلا، جدول تفاوت خرید و تعویض متفرقه، فاکتور نمونه و نحوه تنظیم این دو نرخ در تابلوی مغازه.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'motefareghe-18') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۸: سود قانونی طلافروشی --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">قوانین و صنف</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'goldsmith-legal-profit') }}">
                        سود قانونی طلافروشی چند درصد است؟ (۱۴۰۵)
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    تفکیک اجرت ساخت، سود ۷ درصد فروشنده و مالیات ارزش افزوده بر اساس مصوبه رسمی اتحادیه همراه با فرمول دقیق و مثال فاکتور.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'goldsmith-legal-profit') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت مقاله: استعلام انگ طلا و ری‌گیری --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">طلای آبشده و عیارسنجی</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'gold-hallmark-inquiry') }}">
                        استعلام انگ طلا و ری‌گیری: راهنمای کامل خواندن شماره پاکت و عیار
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    آموزش نحوه خواندن کد انگ، نحوه استعلام شماره پاکت از آزمایشگاه‌های ری‌گیری رسمی اتحادیه و نکات اعتبارسنجی طلای آبشده.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'gold-hallmark-inquiry') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۹: تبدیل مظنه به گرم --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">ابزارهای صنفی</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.tools.mesghal') }}">
                        تبدیل آنلاین مظنه مثقال به گرم ۱۸ عیار با ضریب ۴.۳۳۱۸
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    استفاده از ابزار تعاملی تبدیل مظنه به گرم و آموزش فرمول اصیل بنکداران بازار بزرگ تهران.
                </p>
            </div>
            <a href="{{ route('public.tools.mesghal') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>ورود به ابزار</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۱۰: سوختگی پنل --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">نگهداری تجهیزات</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100">
                    <a href="{{ route('public.tv-setup-guide') }}">
                        سوختگی پنل (Burn-In) چیست و طلالایو چگونه از آن جلوگیری می‌کند؟
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    وقتی تصویر ثابتی ساعت‌ها روی تلویزیون نمایش داده شود، پیکسل‌ها دچار سوختگی یا سایه می‌شوند. سیستم طلالایو با چرخش نرم تصویر مانع از این اتفاق می‌شود.
                </p>
            </div>
            <a href="{{ route('public.tv-setup-guide') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مشاهده راهنمای تلویزیون</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۱۱: تابلو طلا روی اندروید تی‌وی --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">اندروید تی‌وی و باکس</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.android-tv-gold-board') }}">
                        آموزش راه‌اندازی تابلو طلا روی اندروید تی‌وی و باکس اندروید
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    مراحل نصب مرورگر TV Bro، تمام‌صفحه بدون نوار آدرس، جلوگیری از خاموشی صفحه و راه‌اندازی خودکار پس از وصل برق.
                </p>
            </div>
            <a href="{{ route('public.android-tv-gold-board') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مشاهده آموزش تصویری</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۱۲: تابلو طلا روی سامسونگ (تایزن) --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">سامسونگ (Tizen OS)</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'samsung-tizen-gold-board') }}">
                        آموزش راه‌اندازی تابلو قیمت طلا سامسونگ روی سیستم‌عامل تایزن
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    تنظیمات مرورگر سامسونگ اینترنت، غیرفعال‌سازی خاموشی خودکار و باز شدن خودکار تابلو با روشن شدن تلویزیون.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'samsung-tizen-gold-board') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مشاهده راهنمای تایزن</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

        {{-- کارت ۱۳: تابلو طلا روی ال‌جی (webOS) --}}
        <article class="p-6 sm:p-7 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/40 transition-colors shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-2.5 py-1 rounded-md bg-stone-100 dark:bg-stone-850 text-stone-700 dark:text-stone-300 text-[11px] font-semibold border border-stone-200 dark:border-stone-750">ال‌جی (webOS)</span>
                <h2 class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-100 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'lg-webos-gold-board') }}">
                        آموزش تنظیم و اجرای تابلو قیمت طلا ال‌جی در سیستم‌عامل webOS
                    </a>
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    اتصال با مرورگر Web Browser، ثبت کلید میانبر ریموت کنترل جادویی، حالت تمام‌صفحه و غیرفعال‌سازی خاموشی خودکار.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'lg-webos-gold-board') }}" class="min-h-11 text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-500 inline-flex items-center gap-1.5 pt-2">
                <span>مشاهده راهنمای webOS</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </article>

    </div>

    {{-- بنر مشاوره و راه‌اندازی --}}
    <div class="rounded-3xl p-8 sm:p-12 bg-stone-900 dark:bg-stone-850 border border-stone-800 text-center space-y-6 shadow-sm">
        <h2 class="text-2xl sm:text-3xl font-black text-white">
            برای انتخاب یا راه‌اندازی تابلوی خود سوالی دارید؟
        </h2>
        <p class="text-stone-300 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
            کارشناسان طلالایو آماده ارائه مشاوره رایگان تلفنی جهت انتخاب بهترین سایز تلویزیون، تنظیمات مغازه و راه‌اندازی سامانه هستند.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="tel:09187009064" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm transition-colors shadow-sm inline-flex items-center justify-center">
                تماس مستقیم با مدیریت: ۰۹۱۸۷۰۰۹۰۶۴
            </a>
            <a href="{{ route('admin.register') }}" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl bg-stone-800 border border-stone-700 hover:bg-stone-700 text-white font-bold text-sm transition-colors shadow-sm inline-flex items-center justify-center">
                ثبت‌نام و آزمایش رایگان
            </a>
        </div>
    </div>

</div>
@endsection
