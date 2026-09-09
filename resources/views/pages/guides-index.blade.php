@extends('layouts.public')

@section('title', 'دانشنامه و مقالات تخصصی صنف طلا و جواهر | طلالایو')
@section('meta_description', 'مجموعه مقالات و راهنماهای آموزشی تخصصی درباره تابلوی هوشمند طلافروشی، راهنمای اتصال تلویزیون، فرمول‌های محاسبه مظنه و قوانین مالیات طلا.')
@section('meta_keywords', 'مقالات طلافروشی, تابلوی هوشمند طلافروشی, آموزش اتصال تلویزیون به تابلوی طلا, فرمول مظنه طلا, مالیات طلا ۱۴۰۰')

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
            راهنماها و مقالات تخصصی صنف طلا و جواهر
        </h1>
        <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed">
            آموزش‌های کاربردی درباره تجهیزات نمایشگر، تکنولوژی‌های تابلوی ابری، فرمول‌های دقیق حسابداری طلا و تنظیمات تلویزیون طلافروشی.
        </p>
    </div>

    {{-- شبکه مقالات --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        {{-- کارت ۱ --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-amber-500/10 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-[11px] font-bold">تابلوی طلافروشی</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.smart-gold-board') }}">
                        چرا تابلوهای سنتی LED منسوخ شدند؟ مزایای تابلوی ابری
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    بررسی جامع هزینه‌ها، استهلاک، فونت‌های پیکسلی زشت تابلوهای قدیمی و چرایی مهاجرت صنف طلا به تلویزیون‌های هوشمند با کیفیت 4K.
                </p>
            </div>
            <a href="{{ route('public.smart-gold-board') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل راهنما</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۲ --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-blue-500/10 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 text-[11px] font-bold">سخت‌افزار و تلویزیون</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.tv-setup-guide') }}">
                        راهنمای اتصال تلویزیون سامسونگ، ال‌جی و اندروید به تابلوی طلا
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    آموزش مرحله‌به‌مرحله فعال‌سازی مرورگر وب، تنظیم صفحه خانه، جلوگیری از به خواب رفتن تلویزیون و اسکن بدون کابل در چند ثانیه.
                </p>
            </div>
            <a href="{{ route('public.tv-setup-guide') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>مطالعه کامل راهنما</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۳ --}}
        <article class="glass-card-gold p-7 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold">ابزار و محاسبات</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <a href="{{ route('public.gold-calculator') }}">
                        فرمول دقیق محاسبه قیمت طلا با اجرت، سود و قانون جدید مالیات
                    </a>
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    قانون معافیت مالیاتی اصل طلا مصوب ۱۴۰۰ چگونه کار می‌کند؟ محاسبه آنلاین قیمت فاکتور و تحلیل درصد حباب انواع مسکوکات بانکی.
                </p>
            </div>
            <a href="{{ route('public.gold-calculator') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 flex items-center gap-1.5 pt-2">
                <span>استفاده از ماشین‌حساب</span>
                <span>&larr;</span>
            </a>
        </article>

        {{-- کارت ۴ --}}
        <article class="glass-panel p-7 rounded-3xl space-y-4 flex flex-col justify-between border border-slate-200 dark:border-slate-800">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-lg bg-purple-500/10 dark:bg-purple-500/20 text-purple-700 dark:text-purple-300 text-[11px] font-bold">فرمول‌های صنفی</span>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    فرمول تبدیل مظنه (مثقال طلا) به گرم طلای ۱۸ عیار
                </h2>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    مظنه طلا بر اساس یک مثقال طلای ۱۷ عیار (عیار ۷۰۵) در بازار تهران قیمت‌گذاری می‌شود. با تقسیم عدد مظنه بر ۴.۳۳۱۸ (یا ضرب در ۷۵۰ تقسیم بر ۴.۶۰۸ ضرب در ۷۰۵)، نرخ هر گرم طلای ۱۸ عیار به دست می‌آید.
                </p>
            </div>
            <div class="text-[11px] text-slate-500 pt-2 font-mono">
                فرمول: قیمت هر گرم ۱۸ عیار = مظنه / ۴.۳۳۱۸
            </div>
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

    </div>

    {{-- بنر مشاوره و راه‌اندازی --}}
    <div class="rounded-3xl p-8 sm:p-12 bg-gradient-to-r from-amber-500/10 via-white to-blue-500/10 dark:from-slate-900/80 dark:via-slate-900/80 dark:to-slate-900/80 border border-slate-200 dark:border-slate-800 text-center space-y-6 shadow-sm">
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
            هنوز برای انتخاب تابلوی طلافروشی خود سوال دارید؟
        </h2>
        <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
            کارشناسان طلالایو آماده ارائه مشاوره رایگان تلفنی جهت انتخاب بهترین سایز تلویزیون، تنظیمات مغازه و نصب سامانه هستند.
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
