@extends('layouts.public')

@section('title', 'راهنمای اتصال تلویزیون به تابلوی طلافروشی و مغازه طلا فروشی | طلالایو')
@section('meta_description', 'آموزش گام‌به‌گام نحوه اتصال تلویزیون‌های هوشمند به سامانه تابلوی طلا فروشی و طلافروشی طلالایو بدون کابل و مینی‌کیس. تنظیمات مرورگر و جلوگیری از خاموشی خودکار تلویزیون.')
@section('meta_keywords', 'اتصال تلویزیون به تابلوی طلا, تابلو قیمت طلا تلویزیون, تابلوی طلا فروشی, تنظیمات تلویزیون مغازه طلا فروشی, نرم افزار تلویزیون طلا, طلالایو')

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
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16">

    {{-- هدر راهنما --}}
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-300 text-xs font-bold">
            <span>راهنمای فنی و تجهیزات گالری</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white leading-tight">
            آموزش اتصال انواع تلویزیون هوشمند به تابلوی طلالایو
        </h1>
        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed">
            هیچ نیازی به خرید قطعه اضافه یا سیم‌کشی وجود ندارد. در ۳ مرحله ساده تلویزیون برند سامسونگ، ال‌جی، سونی یا اسنوای خود را به تابلوی زنده قیمت طلا و سکه متصل کنید.
        </p>
    </div>

    {{-- ۳ گام اصلی راه‌اندازی --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="glass-panel p-8 rounded-3xl space-y-4 relative overflow-hidden border border-slate-200 dark:border-slate-800">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-xl">۱</div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">اتصال تلویزیون به وای‌فای مغازه</h3>
            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                وارد تنظیمات تلویزیون (Settings -> Network) شوید و تلویزیون را به وای‌فای گالری متصل کنید. پایداری سیگنال برای دریافت نرخ‌ها کافی است و نیازی به سرعت بالا نیست.
            </p>
        </div>

        <div class="glass-panel p-8 rounded-3xl space-y-4 relative overflow-hidden border border-slate-200 dark:border-slate-800">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-xl">۲</div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">باز کردن مرورگر وب تلویزیون</h3>
            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                در لیست برنامه‌های تلویزیون، آیکون <strong>Internet</strong> یا <strong>Web Browser</strong> را باز کنید و آدرس <code class="text-amber-600 dark:text-amber-400 font-mono font-bold">talalive.ir</code> را جستجو نمایید تا صفحه جفت‌سازی و بارکد اختصاصی ظاهر شود.
            </p>
        </div>

        <div class="glass-panel p-8 rounded-3xl space-y-4 relative overflow-hidden border border-slate-200 dark:border-slate-800">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-xl">۳</div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">اسکن بارکد با گوشی و پایان کار</h3>
            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                با گوشی خود وارد حساب طلالایو شوید و بارکد روی تلویزیون را اسکن کنید. صفحه فوراً متصل شده و تابلوی شیک مغازه شما با نرخ‌های زنده و ویترین محصولات شروع به کار می‌کند.
            </p>
        </div>
    </div>

    {{-- راهنمای تخصصی برندهای مختلف تلویزیون --}}
    <div class="space-y-8">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">راهنمای تفکیکی بر اساس برند تلویزیون</h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">تنظیمات بهینه برای برندهای رایج در بازار طلا</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- سامسونگ --}}
            <div class="bg-white dark:bg-slate-900/60 p-7 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-xl bg-blue-500/10 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 font-black text-xs">سامسونگ (Tizen OS)</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">تلویزیون‌های هوشمند سامسونگ</h3>
                </div>
                <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-2.5 list-disc list-inside leading-relaxed">
                    <li>دکمه Home روی ریموت کنترل را بزنید و آیکون آبی رنگ کره زمین (Internet) را باز کنید.</li>
                    <li>آدرس <span class="text-amber-600 dark:text-amber-400 font-mono font-bold">talalive.ir</span> را در نوار بالای مرورگر وارد کنید.</li>
                    <li>روی علامت ستاره یا منوی سه‌نقطه کلیک کرده و گزینه <strong>Add to Bookmarks</strong> را بزنید.</li>
                    <li>در تنظیمات مرورگر، گزینه «Open previous pages upon startup» را تیک بزنید تا با هر بار روشن شدن تلویزیون، تابلو بدون فوت وقت باز شود.</li>
                </ul>
            </div>

            {{-- ال‌جی --}}
            <div class="bg-white dark:bg-slate-900/60 p-7 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-xl bg-pink-500/10 dark:bg-pink-500/20 text-pink-600 dark:text-pink-400 font-black text-xs">ال‌جی (webOS)</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">تلویزیون‌های هوشمند ال‌جی LG</h3>
                </div>
                <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-2.5 list-disc list-inside leading-relaxed">
                    <li>با ریموت کنترل جادویی، برنامه <strong>Web Browser</strong> را از منوی لانچر اجرا نمایید.</li>
                    <li>آدرس سایت را جستجو کرده و پس از جفت‌سازی، آیکون تمام‌صفحه (Full Screen) را در گوشه صفحه کلیک کنید.</li>
                    <li>پیشنهاد می‌شود در تنظیمات عمومی (General -> Eco Service)، گزینه خاموشی خودکار پس از چند ساعت بی‌حرکتی را غیرفعال کنید.</li>
                </ul>
            </div>

            {{-- تلویزیون‌های اندرویدی (سونی، اسنوا، دوو، تی‌سی‌ال، ایکس‌ویژن) --}}
            <div class="bg-white dark:bg-slate-900/60 p-7 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-4 md:col-span-2 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-xl bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-black text-xs">اندروید تی‌وی (Android TV)</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">تلویزیون‌های سونی، اسنوا، دوو، تی‌سی‌ال، جی‌پلاس و شیائومی</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    <p>
                        در تلویزیون‌های مبتنی بر سیستم‌عامل اندروید، مرورگر Google Chrome یا مرورگر اختصاصی تلویزیون (مانند TV Bro یا Puffin) از پیش نصب است. کافی است مرورگر را باز کرده و آدرس سایت را وارد نمایید.
                    </p>
                    <p>
                        می‌توانید میانبر صفحه تابلوی خود را روی صفحه اصلی (Home Screen) تلویزیون سنجاق کنید تا کارکنان مغازه با فشردن یک دکمه تابلو را فعال کنند.
                    </p>
                </div>
            </div>

        </div>
    </div>

    {{-- نکات طلایی و تنظیمات پیشنهادی طلالایو برای طلافروشی --}}
    <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-amber-500/20 space-y-6">
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white flex items-center gap-3">
            <span class="text-amber-500 dark:text-amber-400">💡</span>
            <span>۳ تنظیم مهم تلویزیون برای استفاده در ویترین طلافروشی</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs sm:text-sm text-slate-600 dark:text-slate-300">
            <div class="space-y-2 bg-slate-50 dark:bg-slate-950/40 p-5 rounded-2xl border border-slate-200 dark:border-slate-800">
                <div class="font-bold text-slate-900 dark:text-white">۱. غیرفعال کردن تایمر خاموشی (Sleep Timer)</div>
                <p class="text-slate-500 dark:text-slate-400 leading-relaxed text-xs">
                    بیشتر تلویزیون‌ها تنظیمی به نام «خاموشی پس از ۴ ساعت عدم لمس ریموت» دارند. وارد بخش تنظیمات زمان و مصرف انرژی شده و این گزینه را خاموش کنید تا تابلو در طول ساعت کاری مداوم روشن بماند.
                </p>
            </div>

            <div class="space-y-2 bg-slate-50 dark:bg-slate-950/40 p-5 rounded-2xl border border-slate-200 dark:border-slate-800">
                <div class="font-bold text-slate-900 dark:text-white">۲. تنظیم نور و کنتراست تصویر (Picture Mode)</div>
                <p class="text-slate-500 dark:text-slate-400 leading-relaxed text-xs">
                    حالت تصویر را روی Dynamic یا Vivid (درخشان) قرار دهید. با توجه به نورپردازی قوی ویترین‌های طلا، کنتراست بالا باعث جلب توجه فوق‌العاده مشتریان پشت شیشه مغازه خواهد شد.
                </p>
            </div>

            <div class="space-y-2 bg-slate-50 dark:bg-slate-950/40 p-5 rounded-2xl border border-slate-200 dark:border-slate-800">
                <div class="font-bold text-slate-900 dark:text-white">۳. انتخاب سایز و زاویه دید مناسب</div>
                <p class="text-slate-500 dark:text-slate-400 leading-relaxed text-xs">
                    برای ویترین‌های استاندارد، تلویزیون‌های ۴۳ تا ۵۵ اینچ بهترین بازدهی را دارند. پنل‌های دارای فناوری IPS یا OLED از تمام زوایا برای عابران پیاده خوانایی ۱۰۰ درصدی ایجاد می‌کنند.
                </p>
            </div>
        </div>
    </div>

    {{-- بنر شروع و پشتیبانی --}}
    <div class="text-center space-y-4 pt-6">
        <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">به راهنمایی فنی یا نصب تلفنی نیاز دارید؟ تیم پشتیبانی طلالایو در کنار شماست.</p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="tel:09187009064" class="px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs transition-all shadow-md shadow-amber-500/20 cursor-pointer">
                تماس با پشتیبانی فنی: ۰۹۱۸۷۰۰۹۰۶۴
            </a>
            <a href="{{ route('admin.register') }}" class="px-6 py-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-white font-bold text-xs transition-all shadow-sm cursor-pointer">
                ثبت نام و اتصال اولین تلویزیون
            </a>
        </div>
    </div>

</div>
@endsection
