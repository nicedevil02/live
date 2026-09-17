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
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-300 text-xs font-bold">
            <span>پایگاه دانش تخصصی طلالایو</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white leading-tight">
            راهنماها و مقالات تخصصی صنف طلا و طلا فروشی
        </h1>
        <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed">
            آموزش‌های کاربردی درباره تجهیزات تابلو طلا فروشی، تکنولوژی‌های تابلوی ابری، فرمول‌های دقیق حسابداری طلای آب شده و تنظیمات تلویزیون طلافروشی.
        </p>
    </div>

    {{-- شبکه مقالات --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        {{-- کارت ۱: فرمول محاسبه قیمت طلا ۱۸ عیار --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-amber-500/10 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-[11px] font-bold">فرمول‌های طلا</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'gold-price-formula-18k') }}">
                        فرمول دقیق محاسبه قیمت طلا ۱۸ عیار با اجرت و سود اتحادیه در طلا فروشی
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    آموزش گام‌به‌گام نحوه محاسبه فاکتور طلا، درصد اجرت، سود ۷ درصد قانونی مغازه طلا فروشی و قانون جدید مالیات ارزش افزوده.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'gold-price-formula-18k') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۲: بهترین تلویزیون مغازه --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-blue-500/10 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 text-[11px] font-bold">سخت‌افزار و تلویزیون</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'best-tv-for-jewelry-shop') }}">
                        راهنمای انتخاب بهترین تلویزیون برای تابلو طلا فروشی و مغازه طلافروشی
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    مقایسه پنل‌های سامسونگ، ال‌جی، سونی و اسنوا برای تابلو طلا فروشی از نظر روشنایی، زاویه دید و دوام مداوم.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'best-tv-for-jewelry-shop') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۳: مالیات طلا و سامانه مودیان --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold">قوانین و مالیات</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'gold-tax-regulations') }}">
                        قانون جدید مالیات طلا و اجرت در سامانه مودیان صنف طلا و مغازه طلا فروشی
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    بررسی تکالیف مالیاتی طلافروشان و مغازه طلا فروشی، معافیت اصل طلا و نحوه صدور صورتحساب الکترونیکی در پایانه فروشگاهی.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'gold-tax-regulations') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۴: فرمول حباب سکه --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-purple-500/10 dark:bg-purple-500/20 text-purple-700 dark:text-purple-300 text-[11px] font-bold">مسکوکات</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'how-to-calculate-coin-bubble') }}">
                        فرمول محاسبه حباب سکه امامی، بهار آزادی، نیم‌سکه و ربع‌سکه
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    نحوه محاسبه ارزش ذاتی انواع سکه، نیم سکه، نیم‌سکه، ربع سکه و ربع‌سکه بر اساس وزن، عیار ۹۰۰، حق ضرب بانک مرکزی و تشخیص حباب.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'how-to-calculate-coin-bubble') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۵: مقایسه با تابلو LED --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-rose-500/10 dark:bg-rose-500/20 text-rose-700 dark:text-rose-300 text-[11px] font-bold">مقایسه تجهیزات</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.led-vs-smart-board') }}">
                        مقایسه تابلو LED با تلویزیون تابلو طلا فروشی
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    چرا دوران تابلوهای پرمصرف و پرهزینه LED به سر آمده و چگونه تلویزیون موجود در مغازه بهترین جایگزین اقتصادی است؟
                </p>
            </div>
            <a href="{{ route('public.led-vs-smart-board') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>مشاهده مقایسه</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۶: مظنه فردایی و نقدی --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-amber-500/10 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-[11px] font-bold">مظنه و بازار</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'mazaneh-fardaei') }}">
                        مظنه فردایی چیست و چه فرقی با مظنه نقدی دارد؟
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    بررسی عمیق تفاوت مظنه نقدی، فردایی و جهانی، نحوه تبدیل مظنه به گرم و اهمیت آن در تابلوی اعلام قیمت طلافروشی.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'mazaneh-fardaei') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۷: تعویض و خرید متفرقه ۱۸ --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-300 text-[11px] font-bold">طلای کارکرده</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'motefareghe-18') }}">
                        تعویض و خرید متفرقه ۱۸ چیست؟ راهنمای طلافروش
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    تعریف متفرقه در صنف طلا، جدول تفاوت خرید و تعویض متفرقه، فاکتور نمونه و نحوه تنظیم این دو نرخ در تابلوی مغازه.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'motefareghe-18') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۸: سود قانونی طلافروشی --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-teal-500/10 dark:bg-teal-500/20 text-teal-700 dark:text-teal-300 text-[11px] font-bold">قوانین و صنف</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'goldsmith-legal-profit') }}">
                        سود قانونی طلافروشی چند درصد است؟ (۱۴۰۵)
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    تفکیک اجرت ساخت، سود ۷ درصد فروشنده و مالیات ارزش افزوده بر اساس مصوبه رسمی اتحادیه همراه با فرمول دقیق و مثال فاکتور.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'goldsmith-legal-profit') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت مقاله: استعلام انگ طلا و ری‌گیری --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-amber-500/10 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-[11px] font-bold">طلای آبشده و عیارسنجی</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.guides.show', 'gold-hallmark-inquiry') }}">
                        استعلام انگ طلا و ری‌گیری — راهنمای کامل خواندن شماره پاکت و عیار
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    آموزش نحوه خواندن کد انگ، نحوه استعلام شماره پاکت از آزمایشگاه‌های ری‌گیری رسمی اتحادیه و نکات اعتبارسنجی طلای آبشده.
                </p>
            </div>
            <a href="{{ route('public.guides.show', 'gold-hallmark-inquiry') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل مقاله</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۹: تبدیل مظنه به گرم --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-cyan-500/10 dark:bg-cyan-500/20 text-cyan-700 dark:text-cyan-300 text-[11px] font-bold">ابزارهای صنفی</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.tools.mesghal') }}">
                        تبدیل آنلاین مظنه مثقال به گرم ۱۸ عیار با ضریب ۴.۳۳۱۸
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    استفاده از ابزار تعاملی تبدیل مظنه به گرم و آموزش فرمول اصیل بنکداران بازار بزرگ تهران.
                </p>
            </div>
            <a href="{{ route('public.tools.mesghal') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>ورود به ابزار</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۵ --}}
        <article class="glass-panel p-7 rounded-3xl space-y-4 flex flex-col justify-between border border-slate-200 dark:border-slate-800">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-cyan-500/10 dark:bg-cyan-500/20 text-cyan-700 dark:text-cyan-300 text-[11px] font-bold">نگهداری تجهیزات</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    سوختگی پنل (Burn-In) چیست و طلالایو چگونه از آن جلوگیری می‌کند؟
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    وقتی تصویر ثابتی ساعت‌ها روی تلویزیون نمایش داده شود، پیکسل‌ها دچار سوختگی یا سایه می‌شوند. سیستم طلالایو با تغییرات موقعیتی جزئی و چرخش دوره‌ای اسلایدهای ویترین، سلامت ۱۰۰٪ پنل شما را تضمین می‌کند.
                </p>
            </div>
            <div class="text-[11px] text-emerald-600 dark:text-emerald-400 pt-2 font-bold">
                ✓ مجهز به فناوری ضدسوختگی پنل تلویزیون
            </div>
        </article>

        {{-- کارت ۶ --}}
        <article class="glass-panel p-7 rounded-3xl space-y-4 flex flex-col justify-between border border-slate-200 dark:border-slate-800">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-amber-500/10 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-[11px] font-bold">معماری ابری</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    تفاوت سامانه ابری (SaaS) با نرم‌افزارهای نصبی ویندوزی
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    نرم‌افزارهای نصبی نیازمند خرید دانگل، قفل سخت‌افزاری، ویندوز اختصاصی و پشتیبان‌گیری دستی هستند. در سامانه ابری، همه چیز خودکار به‌روزرسانی شده و از هر دستگاهی در دسترس است.
                </p>
            </div>
            <div class="text-[11px] text-amber-600 dark:text-amber-400 pt-2 font-bold">
                ✓ دسترسی ۲۴ ساعته از موبایل و لپ‌تاپ
            </div>
        </article>

        {{-- کارت جدید: تابلو طلا روی اندروید تی‌وی --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold">اندروید تی‌وی و باکس</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    <a href="/android-tv-gold-board">
                        آموزش راه‌اندازی تابلو طلا روی اندروید تی‌وی و باکس اندروید
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    مراحل نصب مرورگر TV Bro، تمام‌صفحه بدون نوار آدرس، جلوگیری از خاموشی صفحه و راه‌اندازی خودکار پس از وصل برق.
                </p>
            </div>
            <a href="/android-tv-gold-board" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 flex items-center gap-1.5 pt-2">
                <span>مشاهده آموزش تصویری</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت جدید: تابلو طلا روی سامسونگ (تایزن) --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-blue-500/10 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 text-[11px] font-bold">سامسونگ (Tizen OS)</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    <a href="/guides/samsung-tizen-gold-board">
                        آموزش راه‌اندازی تابلو قیمت طلا سامسونگ روی سیستم‌عامل تایزن
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    تنظیمات مرورگر سامسونگ اینترنت، غیرفعال‌سازی خاموشی خودکار Eco Solution و باز شدن خودکار تابلو با روشن شدن تلویزیون.
                </p>
            </div>
            <a href="/guides/samsung-tizen-gold-board" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 flex items-center gap-1.5 pt-2">
                <span>مشاهده راهنمای تایزن</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت جدید: تابلو طلا روی ال‌جی (webOS) --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-pink-500/10 dark:bg-pink-500/20 text-pink-700 dark:text-pink-300 text-[11px] font-bold">ال‌جی (webOS)</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-pink-600 dark:hover:text-pink-400 transition-colors">
                    <a href="/guides/lg-webos-gold-board">
                        آموزش تنظیم و اجرای تابلو قیمت طلا ال‌جی در سیستم‌عامل webOS
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    اتصال با مرورگر Web Browser، ثبت کلید میانبر ۱ ریموت کنترل جادویی، حالت تمام‌صفحه و غیرفعال‌سازی خاموشی خودکار.
                </p>
            </div>
            <a href="/guides/lg-webos-gold-board" class="text-xs font-bold text-pink-600 dark:text-pink-400 hover:text-pink-700 flex items-center gap-1.5 pt-2">
                <span>مشاهده راهنمای webOS</span>
                <span>&larr;</span>
            </a>
        </article>

    </div>

    {{-- بنر مشاوره و راه‌اندازی --}}
    <div class="rounded-3xl p-8 sm:p-12 bg-gradient-to-r from-amber-500/10 via-white to-blue-500/10 dark:from-slate-900/80 dark:via-slate-900/80 dark:to-slate-900/80 border border-slate-200 dark:border-slate-800 text-center space-y-6 shadow-sm">
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
            هنوز برای انتخاب تابلو طلا فروشی یا تابلوی طلافروشی خود سوال دارید؟
        </h2>
        <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
            کارشناسان طلالایو آماده ارائه مشاوره رایگان تلفنی جهت انتخاب بهترین سایز تلویزیون، تنظیمات مغازه طلا فروشی و نصب سامانه هستند.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="tel:09187009064" class="px-8 py-3.5 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all shadow-md shadow-amber-500/20 cursor-pointer">
                تماس مستقیم با مدیریت: ۰۹۱۸۷۰۰۹۰۶۴
            </a>
            <a href="{{ route('admin.register') }}" class="px-8 py-3.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-800 dark:text-white font-bold text-xs transition-all shadow-sm cursor-pointer">
                ثبت‌نام و آزمایش رایگان
            </a>
        </div>
    </div>

</div>
@endsection
