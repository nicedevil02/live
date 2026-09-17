@extends('layouts.public')

@section('title', 'ویجت قیمت لحظه‌ای طلا و سکه — ابزار امبد رایگان برای سایت | طلالایو')
@section('meta_description', 'کد امبد رایگان ویجت قیمت لحظه‌ای طلا ۱۸ عیار، سکه و ارز برای وب‌سایت‌ها و وبلاگ‌ها. نمایش خودکار نرخ‌های روز بازار در ۲ تم و ۲ سایز متنوع.')
@section('canonical', 'https://talalive.ir/widget')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebPage",
      "@@id": "https://talalive.ir/widget#webpage",
      "url": "https://talalive.ir/widget",
      "name": "ویجت قیمت لحظه‌ای طلا و سکه — ابزار امبد رایگان برای سایت | طلالایو",
      "description": "کد امبد رایگان ویجت قیمت لحظه‌ای طلا ۱۸ عیار، سکه و ارز برای وب‌سایت‌ها و وبلاگ‌ها.",
      "breadcrumb": {
        "@@id": "https://talalive.ir/widget#breadcrumb"
      }
    },
    {
      "@@type": "BreadcrumbList",
      "@@id": "https://talalive.ir/widget#breadcrumb",
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
          "name": "ویجت امبد نرخ طلا",
          "item": "https://talalive.ir/widget"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16" x-data="widgetGenerator()">

    {{-- هدر صفحه --}}
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-300 text-xs font-bold">
            <span>⚡ ابزار توسعه‌دهندگان و وب‌مسترها</span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white leading-tight">
            ویجت آنلاین قیمت لحظه‌ای طلا و سکه <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-yellow-500 dark:from-amber-400 dark:to-yellow-300">
                ویژه وب‌سایت‌ها و وبلاگ‌ها
            </span>
        </h1>
        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed">
            با قرار دادن این قطعه کد رایگان در وب‌سایت، فروشگاه اینترنتی یا وبلاگ خود، آخرین نرخ‌های لحظه‌ای طلای ۱۸ عیار، مظنه مثقال، سکه امامی، دلار و انس جهانی را به صورت زنده و با طراحی مدرن به مخاطبان خود نمایش دهید.
        </p>
    </div>

    {{-- بخش سفارشی‌ساز آنلاین و پیش‌نمایش زنده --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- پنل تنظیمات ویجت (سمت راست - ۵ ستون) --}}
        <div class="lg:col-span-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-xl space-y-6">
            <h2 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                <span>🎨</span>
                <span>تنظیمات و سفارشی‌سازی ویجت</span>
            </h2>

            {{-- انتخاب تم --}}
            <div class="space-y-2.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">انتخاب پالت رنگ (تم):</label>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" @click="theme = 'dark'" 
                            :class="theme === 'dark' ? 'border-amber-500 bg-amber-500/10 text-amber-600 dark:text-amber-400 font-black' : 'border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400'"
                            class="py-2.5 px-3 rounded-xl border text-xs font-bold transition-all text-center">
                        🌙 تیره شیشه‌ای
                    </button>
                    <button type="button" @click="theme = 'light'" 
                            :class="theme === 'light' ? 'border-amber-500 bg-amber-500/10 text-amber-600 dark:text-amber-400 font-black' : 'border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400'"
                            class="py-2.5 px-3 rounded-xl border text-xs font-bold transition-all text-center">
                        ☀️ روشن مدرن
                    </button>
                    <button type="button" @click="theme = 'gold'" 
                            :class="theme === 'gold' ? 'border-amber-500 bg-amber-500/10 text-amber-600 dark:text-amber-400 font-black' : 'border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400'"
                            class="py-2.5 px-3 rounded-xl border text-xs font-bold transition-all text-center">
                        👑 طلایی لوکس
                    </button>
                </div>
            </div>

            {{-- انتخاب اندازه و قالب --}}
            <div class="space-y-2.5">
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">اندازه و نوع چیدمان:</label>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" @click="size = 'box'" 
                            :class="size === 'box' ? 'border-amber-500 bg-amber-500/10 text-amber-600 dark:text-amber-400 font-black' : 'border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400'"
                            class="py-3 px-3 rounded-xl border text-xs font-bold transition-all text-center">
                        📦 کادر ستونی (۳۲۰ × ۴۰۰)
                    </button>
                    <button type="button" @click="size = 'ticker'" 
                            :class="size === 'ticker' ? 'border-amber-500 bg-amber-500/10 text-amber-600 dark:text-amber-400 font-black' : 'border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400'"
                            class="py-3 px-3 rounded-xl border text-xs font-bold transition-all text-center">
                        📏 نوار افقی هدر (۱۰۰٪ × ۷۰)
                    </button>
                </div>
            </div>

            {{-- کادر کد امبد نهایی --}}
            <div class="space-y-2 pt-2 border-t border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-bold text-slate-700 dark:text-slate-300">کد HTML جهت قرار دادن در سایت:</label>
                    <button type="button" @click="copyCode()" class="text-xs text-amber-600 dark:text-amber-400 hover:underline font-bold flex items-center gap-1">
                        <span x-text="copied ? 'کپی شد! ✅' : 'کپی کد'"></span>
                    </button>
                </div>
                <div class="relative">
                    <textarea readonly dir="ltr" rows="4" 
                              class="w-full bg-slate-100 dark:bg-slate-950 border border-slate-300 dark:border-slate-800 rounded-2xl p-3 font-mono text-[11px] text-slate-800 dark:text-slate-200 resize-none focus:outline-none select-all" 
                              x-text="embedCode"></textarea>
                </div>
                <p class="text-[11px] text-slate-500 leading-relaxed">این کد را در هر بخش از صفحه HTML، ابزارک متنی وردپرس یا قالب سایت خود جای‌گذاری نمایید.</p>
            </div>
        </div>

        {{-- پیش‌نمایش زنده در زمان واقعی (سمت چپ - ۷ ستون) --}}
        <div class="lg:col-span-7 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-xl space-y-4">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>پیش‌نمایش زنده عملکرد ویجت</span>
                </h3>
                <span class="text-xs text-slate-400 font-mono" x-text="size === 'box' ? '320 × 400 px' : '100% × 70 px'"></span>
            </div>

            <div class="flex items-center justify-center p-4 bg-slate-50 dark:bg-slate-950/60 rounded-2xl border border-dashed border-slate-300 dark:border-slate-800 min-h-[420px] overflow-hidden">
                <iframe :src="previewUrl" 
                        :style="size === 'box' ? 'width: 320px; height: 400px;' : 'width: 100%; height: 70px;'"
                        frameborder="0" 
                        style="border: none; border-radius: 16px; overflow: hidden; transition: all 0.3s ease;"
                        title="پیش‌نمایش ویجت قیمت طلا"></iframe>
            </div>
        </div>

    </div>

    {{-- راهنمای جامع نحوه نصب در انواع CMS و فریمورک‌ها --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-lg space-y-8">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mb-3">
                راهنمای نصب ویجت قیمت طلا در انواع سایت‌ها
            </h2>
            <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed">
                ویجت طلالایو به گونه‌ای مهندسی شده است که بدون نیاز به نصب هرگونه افزونه سنگین، فایل‌های سنگین جاوااسکریپت یا تداخل با استایل‌های سایت شما، به صورت کاملاً سبک و سریع در تمامی پلتفرم‌های تحت وب بارگذاری شود.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- وردپرس --}}
            <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3">
                <div class="text-2xl">🌐</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">نصب در وردپرس (WordPress)</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    وارد پیشخوان وردپرس شوید. از بخش نمایش > ابزارک‌ها (یا در ویرایشگر گوتنبرگ / المنتور)، یک بلوک <strong>HTML سفارشی</strong> اضافه کنید و کد بالا را درون آن پیست نمایید.
                </p>
            </div>

            {{-- قالب‌های HTML و فروشگاه‌ها --}}
            <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3">
                <div class="text-2xl">💻</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">سایت‌های اختصاصی و HTML</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    کد iframe تولیدشده را در سایدبار، فوتر یا بالای هدر فایل قالب خود قرار دهید. با تغییر مقادیر عرض و ارتفاع می‌توانید آن را با قالب خود هماهنگ کنید.
                </p>
            </div>

            {{-- فریمورک‌های React و Vue --}}
            <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3">
                <div class="text-2xl">⚛️</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">فریمورک‌های React و Vue</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    کافی است کد را در قالب یک کامپوننت ساده JSX رندر کنید. از آنجا که ویجت در لایه ایزوله iframe اجرا می‌شود، هیچ مشکلی با Hydration سرورساید نخواهد داشت.
                </p>
            </div>
        </div>

        {{-- شرایط استفاده و اتریبیوشن --}}
        <div class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-5 text-xs sm:text-sm text-slate-700 dark:text-amber-200 space-y-2">
            <h4 class="font-bold text-amber-800 dark:text-amber-300">شرایط استفاده و کپی‌رایت:</h4>
            <p class="leading-relaxed">
                استفاده از این ویجت برای تمامی وب‌سایت‌های شخصی، تجاری و خبری کاملاً رایگان است. تنها شرط فعال بودن سرویس، حفظ خط اتریبیوشن («ارائه‌شده توسط طلالایو») و لینک فعال به نشانی talalive.ir درون ویجت می‌باشد. حذف یا پنهان‌سازی لینک خروجی مغایر با شرایط استفاده است.
            </p>
        </div>
    </div>

</div>

<script>
function widgetGenerator() {
    return {
        theme: 'dark',
        size: 'box',
        copied: false,
        get previewUrl() {
            return '/widget/embed?theme=' + this.theme + '&size=' + this.size;
        },
        get embedCode() {
            if (this.size === 'box') {
                return '<iframe src="https://talalive.ir/widget/embed?theme=' + this.theme + '&size=box" width="320" height="400" frameborder="0" style="border:none; border-radius:16px; overflow:hidden;" title="قیمت لحظه‌ای طلا و سکه طلالایو"></iframe>';
            } else {
                return '<iframe src="https://talalive.ir/widget/embed?theme=' + this.theme + '&size=ticker" width="100%" height="70" frameborder="0" style="border:none; border-radius:12px; overflow:hidden;" title="قیمت لحظه‌ای طلا و سکه طلالایو"></iframe>';
            }
        },
        copyCode() {
            navigator.clipboard.writeText(this.embedCode).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2500);
            });
        }
    };
}
</script>
@endsection
