@extends('layouts.public')

@section('title', 'راهنمای اتصال تلویزیون به تابلوی طلافروشی و مغازه طلا فروشی | طلالایو')
@section('meta_description', 'آموزش گام‌به‌گام نحوه اتصال تلویزیون‌های هوشمند به سامانه تابلوی طلا فروشی و طلافروشی طلالایو بدون کابل و مینی‌کیس. تنظیمات مرورگر و جلوگیری از خاموشی خودکار تلویزیون.')
@section('canonical', 'https://talalive.ir/tv-setup-guide')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "TechArticle",
      "headline": "آموزش گام‌به‌گام راه‌اندازی و اتصال تلویزیون هوشمند به تابلوی زنده طلافروشی طلالایو",
      "description": "راهنمای کامل تصویری و متنی جهت اتصال انواع تلویزیون‌های هوشمند به سیستم تابلوی نرخ طلا بدون مینی‌کیس.",
      "author": {
        "@@type": "Organization",
        "name": "طلالایو"
      },
      "publisher": {
        "@@type": "Organization",
        "name": "طلالایو",
        "logo": {
          "@@type": "ImageObject",
          "url": "https://talalive.ir/images/logo.png"
        }
      }
    },
    {
      "@@type": "HowTo",
      "name": "نحوه راه‌اندازی تابلوی هوشمند طلافروشی روی تلویزیون",
      "step": [
        {
          "@@type": "HowToStep",
          "name": "گام اول: اتصال به اینترنت",
          "text": "تلویزیون هوشمند مغازه را به اینترنت وای‌فای (Wi-Fi) یا کابل شبکه متصل کنید."
        },
        {
          "@@type": "HowToStep",
          "name": "گام دوم: باز کردن مرورگر تلویزیون",
          "text": "برنامه مرورگر اینترنت (Web Browser / Internet) را در منوی تلویزیون باز کرده و آدرس talalive.ir را وارد کنید."
        },
        {
          "@@type": "HowToStep",
          "name": "گام سوم: اسکن بارکد با موبایل",
          "text": "پس از نمایش بارکد، با گوشی خود وارد پنل طلالایو شده و بارکد روی تلویزیون را اسکن کنید تا تابلوی شما فعال شود."
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-12 sm:space-y-16">

    {{-- بنر تفکیک راهنمای اتصال از خرید سخت‌افزار --}}
    <div class="bg-stone-100 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3 text-right">
            <span class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 flex items-center justify-center shrink-0 border border-amber-200 dark:border-amber-500/25">
                @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-5 h-5'])
            </span>
            <div class="text-xs sm:text-sm text-stone-700 dark:text-stone-300">
                <strong class="font-bold text-stone-900 dark:text-stone-100 block sm:inline">هنوز برای مغازه تلویزیون تهیه نکرده‌اید؟</strong>
                <span>این صفحه آموزش تخصصی چگونگی اتصال است. اگر در مرحله انتخاب نمایشگر هستید:</span>
            </div>
        </div>
        <a href="/guides/best-tv-for-jewelry-shop" class="min-h-11 w-full sm:w-auto px-4 py-2.5 rounded-xl bg-white hover:bg-stone-200 dark:bg-stone-800 dark:hover:bg-stone-700 text-stone-900 dark:text-stone-100 border border-stone-300 dark:border-stone-700 font-semibold text-xs transition-colors shadow-xs inline-flex items-center justify-center gap-1.5 shrink-0 text-center">
            <span>راهنمای خرید بهترین تلویزیون طلافروشی</span>
            @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
        </a>
    </div>

    {{-- هدر تحریری راهنما --}}
    <div class="text-center space-y-3 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-stone-100 dark:bg-stone-800 border border-stone-200 dark:border-stone-700 text-stone-700 dark:text-stone-300 text-xs font-semibold">
            @include('partials.ui-icon', ['name' => 'book', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
            <span>راهنمای فنی: اتصال تلویزیون به تابلو در ۳ دقیقه</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-bold text-stone-900 dark:text-stone-50 leading-tight">
            آموزش اتصال تلویزیون به تابلوی طلافروشی
        </h1>
        <p class="text-stone-600 dark:text-stone-400 text-xs sm:text-base leading-relaxed">
            این راهنما به شما آموزش می‌دهد چگونه در کمتر از ۳ دقیقه، بدون نیاز به خرید مینی‌کیس یا کابل‌کشی، با مرورگر وب داخلی انواع تلویزیون هوشمند به تابلوی اعلام نرخ زنده طلالایو متصل شوید.
        </p>
    </div>

    {{-- ۳ گام اصلی راه‌اندازی (بهینه‌شده برای موبایل و تبلت) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
        <div class="bg-white dark:bg-stone-900 p-5 sm:p-6 rounded-2xl space-y-3 border border-stone-200 dark:border-stone-800 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/25 flex items-center justify-center font-bold text-base tabular-nums">۱</div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">اتصال تلویزیون به وای‌فای مغازه</h3>
                <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                    وارد تنظیمات تلویزیون (Settings -> Network) شوید و تلویزیون را به وای‌فای گالری متصل کنید. پایداری سیگنال برای دریافت نرخ‌ها کافی است و نیازی به سرعت بالا نیست.
                </p>
            </div>
        </div>

        <div class="bg-white dark:bg-stone-900 p-5 sm:p-6 rounded-2xl space-y-3 border border-stone-200 dark:border-stone-800 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/25 flex items-center justify-center font-bold text-base tabular-nums">۲</div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">باز کردن مرورگر وب تلویزیون</h3>
                <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                    در منوی برنامه‌ها، آیکون <strong>Internet</strong> یا <strong>Web Browser</strong> را باز کرده و آدرس <code class="text-amber-700 dark:text-amber-400 font-mono font-bold select-all break-all">talalive.ir</code> را وارد فرمایید تا صفحه جفت‌سازی ظاهر شود.
                </p>
            </div>
        </div>

        <div class="bg-white dark:bg-stone-900 p-5 sm:p-6 rounded-2xl space-y-3 border border-stone-200 dark:border-stone-800 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/25 flex items-center justify-center font-bold text-base tabular-nums">۳</div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">اسکن بارکد با گوشی و پایان کار</h3>
                <p class="text-xs text-stone-600 dark:text-stone-400 leading-relaxed">
                    با گوشی خود وارد حساب کاربری طلالایو شده و بارکد روی تلویزیون را اسکن کنید. صفحه فوراً متصل شده و تابلوی مغازه با نرخ‌های زنده شروع به کار می‌کند.
                </p>
            </div>
        </div>
    </div>

    {{-- راهنمای تفکیکی بر اساس برند تلویزیون --}}
    <div class="space-y-6">
        <div class="text-center space-y-2">
            <h2 class="text-xl sm:text-2xl font-bold text-stone-900 dark:text-stone-50">راهنمای تفکیکی بر اساس برند تلویزیون</h2>
            <p class="text-stone-600 dark:text-stone-400 text-xs sm:text-sm">تنظیمات بهینه برای برندهای رایج در بازار طلا</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
            
            {{-- سامسونگ --}}
            <div class="bg-white dark:bg-stone-900 p-5 sm:p-6 rounded-2xl border border-stone-200 dark:border-stone-800 space-y-4 shadow-xs flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-2.5">
                        <span class="px-2.5 py-0.5 rounded-md bg-stone-100 dark:bg-stone-800 text-stone-800 dark:text-stone-200 font-bold text-xs font-mono">Tizen OS</span>
                        <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">تلویزیون‌های هوشمند سامسونگ</h3>
                    </div>
                    <ul class="text-xs text-stone-700 dark:text-stone-300 space-y-2 list-disc list-inside leading-relaxed">
                        <li>دکمه Home روی ریموت کنترل را بزنید و برنامه Internet را باز کنید.</li>
                        <li>آدرس <span class="text-amber-700 dark:text-amber-400 font-mono font-bold">talalive.ir</span> را در نوار بالای مرورگر وارد کنید.</li>
                        <li>روی علامت ستاره یا منوی سه‌نقطه کلیک کرده و گزینه <strong>Add to Bookmarks</strong> را انتخاب کنید.</li>
                        <li>در تنظیمات مرورگر، گزینه باز کردن صفحات قبلی در شروع را فعال کنید تا با روشن شدن تلویزیون، تابلو خودکار باز شود.</li>
                    </ul>
                </div>
                <div class="pt-2">
                    <a href="/guides/samsung-tizen-gold-board" class="min-h-11 inline-flex items-center gap-1 text-xs font-bold text-amber-700 dark:text-amber-400 hover:underline">
                        <span>راهنمای تخصصی راه‌اندازی سامسونگ تایزن</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </a>
                </div>
            </div>

            {{-- ال‌جی --}}
            <div class="bg-white dark:bg-stone-900 p-5 sm:p-6 rounded-2xl border border-stone-200 dark:border-stone-800 space-y-4 shadow-xs flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-2.5">
                        <span class="px-2.5 py-0.5 rounded-md bg-stone-100 dark:bg-stone-800 text-stone-800 dark:text-stone-200 font-bold text-xs font-mono">webOS</span>
                        <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">تلویزیون‌های هوشمند ال‌جی LG</h3>
                    </div>
                    <ul class="text-xs text-stone-700 dark:text-stone-300 space-y-2 list-disc list-inside leading-relaxed">
                        <li>با کنترل جادویی، برنامه <strong>Web Browser</strong> را از منوی لانچر اجرا نمایید.</li>
                        <li>آدرس سایت را جستجو کرده و پس از جفت‌سازی، آیکون تمام‌صفحه (Full Screen) را کلیک کنید.</li>
                        <li>در تنظیمات عمومی (General -> Eco Service)، گزینه خاموشی خودکار پس از چند ساعت را غیرفعال کنید.</li>
                    </ul>
                </div>
                <div class="pt-2">
                    <a href="/guides/lg-webos-gold-board" class="min-h-11 inline-flex items-center gap-1 text-xs font-bold text-amber-700 dark:text-amber-400 hover:underline">
                        <span>راهنمای تخصصی راه‌اندازی ال‌جی webOS</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </a>
                </div>
            </div>

            {{-- تلویزیون‌های اندرویدی --}}
            <div class="bg-white dark:bg-stone-900 p-5 sm:p-6 rounded-2xl border border-stone-200 dark:border-stone-800 space-y-4 md:col-span-2 shadow-xs">
                <div class="flex items-center gap-2.5">
                    <span class="px-2.5 py-0.5 rounded-md bg-stone-100 dark:bg-stone-800 text-stone-800 dark:text-stone-200 font-bold text-xs font-mono">Android TV</span>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">تلویزیون‌های سونی، اسنوا، دوو، تی‌سی‌ال، جی‌پلاس و شیائومی</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-stone-700 dark:text-stone-300 leading-relaxed">
                    <p>
                        در تلویزیون‌های مبتنی بر سیستم‌عامل اندروید، مرورگر Google Chrome یا مرورگر اختصاصی تلویزیون از پیش نصب است. کافی است مرورگر را باز کرده و آدرس سایت را وارد فرمایید.
                    </p>
                    <p>
                        همچنین می‌توانید اپلیکیشن رسمی تلویزیون طلالایو (فایل APK) را نصب کنید تا با روشن شدن مغازه، تابلو مستقیماً باز شود.
                    </p>
                </div>
                <div class="pt-2">
                    <a href="/android-tv-gold-board" class="min-h-11 inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-xs transition-colors shadow-xs">
                        <span>راهنمای راه‌اندازی روی اندروید تی‌وی و باکس</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- ۳ تنظیم مهم تلویزیون در ویترین طلافروشی --}}
    <div class="bg-white dark:bg-stone-900 p-5 sm:p-8 rounded-2xl border border-stone-200 dark:border-stone-800 space-y-6 shadow-xs">
        <h2 class="text-lg sm:text-xl font-bold text-stone-900 dark:text-stone-50 flex items-center gap-2.5">
            @include('partials.ui-icon', ['name' => 'sliders', 'class' => 'w-5 h-5 text-amber-700 dark:text-amber-400'])
            <span>۳ تنظیم مهم تلویزیون برای استفاده در ویترین طلافروشی</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 text-xs sm:text-sm text-stone-700 dark:text-stone-300">
            <div class="space-y-2 bg-stone-100/80 dark:bg-stone-800/60 p-4 sm:p-5 rounded-xl border border-stone-200 dark:border-stone-700">
                <div class="font-bold text-stone-900 dark:text-stone-100">۱. غیرفعال کردن تایمر خاموشی خودکار</div>
                <p class="text-stone-600 dark:text-stone-400 leading-relaxed text-xs">
                    بیشتر تلویزیون‌ها تنظیمی به نام «خاموشی پس از چند ساعت عدم لمس ریموت» دارند. در بخش تنظیمات مصرف انرژی، این گزینه را خاموش کنید تا تابلو مداوم روشن بماند.
                </p>
            </div>

            <div class="space-y-2 bg-stone-100/80 dark:bg-stone-800/60 p-4 sm:p-5 rounded-xl border border-stone-200 dark:border-stone-700">
                <div class="font-bold text-stone-900 dark:text-stone-100">۲. تنظیم نور و کنتراست تصویر (Picture Mode)</div>
                <p class="text-stone-600 dark:text-stone-400 leading-relaxed text-xs">
                    حالت تصویر را روی Dynamic یا Vivid قرار دهید. با توجه به نورپردازی قوی ویترین‌های طلا، کنتراست بالا باعث خوانایی عالی قیمت‌ها خواهد شد.
                </p>
            </div>

            <div class="space-y-2 bg-stone-100/80 dark:bg-stone-800/60 p-4 sm:p-5 rounded-xl border border-stone-200 dark:border-stone-700">
                <div class="font-bold text-stone-900 dark:text-stone-100">۳. انتخاب سایز و زاویه دید مناسب</div>
                <p class="text-stone-600 dark:text-stone-400 leading-relaxed text-xs">
                    برای ویترین‌های استاندارد، تلویزیون‌های ۴۳ تا ۵۵ اینچ بهترین بازدهی را دارند. پنل‌های دارای فناوری IPS یا OLED از تمام زوایا خوانایی بالایی ایجاد می‌کنند.
                </p>
            </div>
        </div>
    </div>

    {{-- بنر پشتیبانی و شروع --}}
    <div class="text-center space-y-4 pt-4">
        <p class="text-stone-600 dark:text-stone-400 text-xs sm:text-sm">به راهنمایی فنی یا نصب تلفنی نیاز دارید؟ تیم پشتیبانی طلالایو در کنار شماست.</p>
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="tel:09187009064" class="min-h-11 px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-xs transition-colors shadow-xs inline-flex items-center gap-2 cursor-pointer">
                <span>تماس با پشتیبانی فنی:</span>
                <span class="font-mono tabular-nums" dir="ltr">0918 700 9064</span>
            </a>
            <a href="{{ route('admin.register') }}" class="min-h-11 px-5 py-2.5 rounded-xl bg-white dark:bg-stone-900 border border-stone-300 dark:border-stone-700 hover:bg-stone-100 dark:hover:bg-stone-800 text-stone-800 dark:text-stone-200 font-bold text-xs transition-colors shadow-xs inline-flex items-center justify-center cursor-pointer">
                ثبت نام و اتصال اولین تلویزیون
            </a>
        </div>
    </div>

</div>
@endsection
