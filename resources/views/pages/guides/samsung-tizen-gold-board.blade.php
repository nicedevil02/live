@extends('layouts.public')

@section('title', 'تابلو قیمت طلا روی تلویزیون سامسونگ (Tizen) | طلالایو')
@section('meta_description', 'راهنمای گام‌به‌گام اتصال مرورگر تایزن تلویزیون‌های سامسونگ به سامانه تابلوی طلالایو بدون نیاز به دانگل در سال ۱۴۰۵. همین حالا تابلوی مغازه را رایگان فعال کنید.')
@section('canonical', 'https://talalive.ir/guides/samsung-tizen-gold-board')
@section('og_image', asset('images/guides/samsung-tizen-gold-board.webp'))
@section('og_image_alt', 'راهنمای راه‌اندازی تابلو قیمت طلا روی تلویزیون سامسونگ تایزن')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "TechArticle",
      "headline": "آموزش راه‌اندازی تابلو قیمت طلا سامسونگ روی سیستم‌عامل تایزن",
      "description": "راهنمای تخصصی اتصال مرورگر تلویزیون هوشمند سامسونگ با سیستم‌عامل Tizen به سامانه تابلوی زرگری طلالایو بدون نیاز به قطعه جانبی.",
      "image": [
        "https://talalive.ir/images/guides/samsung-tizen-gold-board.webp"
      ],
      "datePublished": "2026-04-12",
      "dateModified": "2026-09-16",
      "author": {
        "@@type": "Organization",
        "name": "تیم فنی طلالایو"
      },
      "publisher": {
        "@@id": "https://talalive.ir/#organization"
      }
    },
    {
      "@@type": "HowTo",
      "name": "مراحل تنظیم تلویزیون سامسونگ برای تابلو قیمت طلا",
      "step": [
        {
          "@@type": "HowToStep",
          "name": "گام اول: اتصال تلویزیون به اینترنت",
          "text": "از مسیر Settings > General > Network تلویزیون سامسونگ را به مودم وای‌فای مغازه وصل کنید."
        },
        {
          "@@type": "HowToStep",
          "name": "گام دوم: اجرای مرورگر سامسونگ اینترنت",
          "text": "در اسمارت هاب آیکون Samsung Internet را باز نموده و آدرس talalive.ir را وارد فرمایید."
        },
        {
          "@@type": "HowToStep",
          "name": "گام سوم: جفت‌سازی تابلو با بارکد",
          "text": "با تلفن همراه وارد پنل مدیریت طلالایو شده و بارکد روی تلویزیون را اسکن کنید."
        },
        {
          "@@type": "HowToStep",
          "name": "گام چهارم: بهینه‌سازی تنظیمات Eco Solution و تمام‌صفحه",
          "text": "خاموشی خودکار را از منوی اکو غیرفعال کنید و دکمه Fullscreen مرورگر را فشار دهید."
        }
      ]
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
          "name": "پایگاه دانش",
          "item": "https://talalive.ir/guides"
        },
        {
          "@@type": "ListItem",
          "position": 3,
          "name": "تابلو قیمت طلا سامسونگ",
          "item": "https://talalive.ir/guides/samsung-tizen-gold-board"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-12">

    {{-- هدر و تعریف ۴۰ کلمه‌ای موضوع --}}
    <div class="space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/30 text-blue-700 dark:text-blue-300 text-xs font-bold">
            <span>راهنمای سیستم‌عامل Samsung Tizen OS</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            آموزش راه‌اندازی تابلو قیمت طلا سامسونگ روی سیستم‌عامل تایزن
        </h1>
        <p class="text-slate-700 dark:text-slate-300 text-sm sm:text-base leading-relaxed bg-slate-50 dark:bg-slate-900/60 p-5 rounded-2xl border border-slate-200 dark:border-slate-800">
            اجرای <strong>تابلو قیمت طلا سامسونگ</strong> روی تلویزیون‌های مجهز به سیستم‌عامل تایزن (Tizen OS) بدون نیاز به کامپیوتر یا دانگل، از طریق <strong>مرورگر تلویزیون سامسونگ</strong> (Samsung Internet) با اتصال وای‌فای در کمتر از ۳ دقیقه امکان‌پذیر است.
        </p>
    </div>

    {{-- تصویر شاخص راهنما با کیفیت عالی سئو و استانداردهای Core Web Vitals --}}
    <figure class="relative rounded-3xl overflow-hidden border border-blue-500/25 dark:border-slate-800 shadow-2xl aspect-[16/9] bg-slate-900 group">
        <img src="{{ asset('images/guides/samsung-tizen-gold-board.webp') }}" 
             alt="آموزش راه‌اندازی تابلو قیمت طلا سامسونگ روی سیستم‌عامل تایزن" 
             width="1200" height="675" 
             loading="eager" fetchpriority="high" decoding="async"
             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.01]">
    </figure>

    {{-- ۵ مرحله گام‌به‌گام راه‌اندازی در تایزن --}}
    <div class="space-y-6">
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2.5">
            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
            <span>۵ مرحله راه‌اندازی تابلوی طلالایو روی تلویزیون سامسونگ</span>
        </h2>
        
        <div class="space-y-4">
            {{-- مرحله ۱ --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-500/10 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 font-black text-sm flex items-center justify-center">۱</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">اتصال به شبکه وای‌فای طلافروشی</h3>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed pr-11">
                    دکمه Settings یا منو را روی ریموت کنترل سامسونگ فشار دهید. به مسیر <strong class="text-slate-900 dark:text-white">General & Privacy &gt; Network &gt; Open Network Settings</strong> بروید و شبکه Wi-Fi مغازه را انتخاب کنید. اتصال پایدار اینترنت با حداقل سرعت ۵۱۲ کیلوبیت برای دریافت آنی نرخ‌ها کفایت می‌کند.
                </p>
            </div>

            {{-- مرحله ۲ --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-500/10 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 font-black text-sm flex items-center justify-center">۲</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">باز کردن مرورگر سامسونگ اینترنت (Samsung Internet)</h3>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed pr-11">
                    دکمه Home (نماد خانه) را فشار دهید تا نوار Smart Hub باز شود. روی آیکون آبی‌رنگ کره زمین با عنوان <strong>Internet</strong> کلیک کنید. در نوار آدرس بالای صفحه، نشانی <code class="text-blue-600 dark:text-blue-400 font-mono font-bold bg-blue-50 dark:bg-blue-950/40 px-2 py-0.5 rounded">talalive.ir</code> را بنویسید و کلید Enter را بزنید.
                </p>
            </div>

            {{-- مرحله ۳ --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-500/10 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 font-black text-sm flex items-center justify-center">۳</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">اسکن بارکد جفت‌سازی و اتصال به پنل</h3>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed pr-11">
                    صفحه اختصاصی جفت‌سازی تلویزیون باز می‌شود که دارای یک کد ۶ رقمی و یک بارکد QR اختصاصی است. دوربین گوشی همراه یا بخش اتصال دستگاه در پنل طلالایو را باز کنید و بارکد روی تلویزیون را اسکن نمایید. تابلوی نرخ طلا، سکه و ویترین شما در کسری از ثانیه روی سامسونگ پدیدار می‌شود.
                </p>
            </div>

            {{-- مرحله ۴ --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-500/10 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 font-black text-sm flex items-center justify-center">۴</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">ذخیره در بوک‌مارک و صفحه شروع (Bookmarks)</h3>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed pr-11">
                    برای اینکه هر روز نیازی به تایپ آدرس نباشد، نشانگر کنترل را به گوشه بالای مرورگر ببرید و روی آیکون ستاره (نشانه‌گذاری) کلیک کرده و گزینه <strong>Add to Bookmarks</strong> را انتخاب کنید. همچنین می‌توانید با زدن گزینه <em>Add to Home Screen</em> میانبر تابلو را مستقیماً به نوار اسمارت هاب اضافه نمایید.
                </p>
            </div>

            {{-- مرحله ۵ --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-500/10 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 font-black text-sm flex items-center justify-center">۵</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">تمام‌صفحه کردن و حذف نوارهای حاشیه</h3>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed pr-11">
                    در گوشه بالا سمت راست مرورگر اینترنت سامسونگ، روی آیکون چهار فلش (Full Screen) کلیک کنید. با این کار تمام نوارهای آدرس، تب‌ها و کنترل‌های تایزن مخفی شده و صفحه تلویزیون دقیقاً شبیه یک تابلوی صنعتی گران‌قیمت ال‌ای‌دی یا سون‌سگمنت نرخ طلا درمی‌آید.
                </p>
            </div>
        </div>
    </div>

    {{-- تنظیمات اختصاصی تایزن برای جلوگیری از خاموش شدن صفحه در ویترین --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6">
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2.5">
            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
            <span>تنظیمات حیاتی تایزن: جلوگیری از خاموشی خودکار و بهینه‌سازی ویترین</span>
        </h2>
        
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
            تلویزیون‌های سامسونگ به صورت پیش‌فرض با قابلیت‌های حفظ محیط‌زیست (Eco Solution) عرضه می‌شوند که اگر در طول روز دست به کنترل نزنید، پس از ۴ ساعت تلویزیون را خاموش می‌کنند. برای جلوگیری از این اتفاق در طول ساعات کاری طلافروشی، این تنظیمات را در <strong>تایزن</strong> اعمال کنید:
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-2">
                <div class="flex items-center gap-2 text-amber-600 dark:text-amber-400 font-bold text-xs sm:text-sm">
                    <span>⚡ غیرفعال‌سازی خاموشی خودکار (Auto Power Off)</span>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    به مسیر <span class="font-mono text-xs font-bold text-slate-800 dark:text-slate-200">Settings &gt; General &gt; Eco Solution &gt; Auto Power Off</span> بروید و آن را روی حالت <strong>Off</strong> قرار دهید تا تابلو در تمام شیفت کاری روشن بماند.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-2">
                <div class="flex items-center gap-2 text-amber-600 dark:text-amber-400 font-bold text-xs sm:text-sm">
                    <span>💡 تثبیت نور صفحه (Ambient Light Detection)</span>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    در همان منوی اکو، گزینه <span class="font-mono text-xs font-bold text-slate-800 dark:text-slate-200">Ambient Light Detection</span> را خاموش کنید تا با تغییر زاویه نور خورشید یا چراغ‌های هالوژن ویترین، روشنایی تابلو کم و زیاد نشود.
                </p>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-2 sm:col-span-2">
                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold text-xs sm:text-sm">
                    <span>🔄 باز شدن خودکار تابلو با روشن شدن تلویزیون (Autorun Last App)</span>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    به مسیر <span class="font-mono text-xs font-bold text-slate-800 dark:text-slate-200">Settings &gt; General &gt; Smart Features &gt; Autorun Smart Hub</span> بروید و آن را فعال کنید. همچنین در تنظیمات مرورگر سامسونگ، تیک گزینه <strong class="text-slate-900 dark:text-white">Open previous pages upon startup</strong> را فعال بگذارید تا با فشردن دکمه روشن شدن تلویزیون توسط شاگرد مغازه، تابلوی طلا خودبه‌خود بالا بیاید.
                </p>
            </div>
        </div>
    </div>

    {{-- جدول سازگاری مدل‌های مختلف سامسونگ --}}
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
            <span>جدول بررسی پایداری نسخه‌های تایزن (Tizen) در مدل‌های سامسونگ</span>
        </h2>
        <div class="overflow-x-auto border border-slate-200 dark:border-slate-800 rounded-2xl">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 font-bold border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="p-3.5">سری تلویزیون سامسونگ</th>
                        <th class="p-3.5">نسخه سیستم‌عامل تایزن</th>
                        <th class="p-3.5">کیفیت اجرای مرورگر</th>
                        <th class="p-3.5">وضعیت ماندگاری کش و حافظه</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-600 dark:text-slate-400">
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                        <td class="p-3.5 font-bold text-slate-900 dark:text-white">سری Crystal UHD (مانند CU7000 / CU8000 / DU8000)</td>
                        <td class="p-3.5 font-mono">Tizen 7.0 / 8.0</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">بسیار روان و سریع (۶۰ فریم)</td>
                        <td class="p-3.5">عالی؛ ذخیره خودکار بدون قطعی</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                        <td class="p-3.5 font-bold text-slate-900 dark:text-white">سری QLED (مانند Q60C / Q70C / Q80C)</td>
                        <td class="p-3.5 font-mono">Tizen 6.5 / 7.0</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">فوق‌العاده با پنل Quantum Dot</td>
                        <td class="p-3.5">عالی؛ نور خیره‌کننده برای ویترین</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                        <td class="p-3.5 font-bold text-slate-900 dark:text-white">مدل‌های سری TU / AU (سال‌های ۲۰۲۰ تا ۲۰۲۲)</td>
                        <td class="p-3.5 font-mono">Tizen 5.5 / 6.0</td>
                        <td class="p-3.5 text-blue-600 dark:text-blue-400 font-bold">روان و استاندارد</td>
                        <td class="p-3.5">خوب؛ حفظ کوکی اتصال تا ماه‌ها</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                        <td class="p-3.5 font-bold text-slate-900 dark:text-white">سامسونگ‌های قدیمی‌تر (سری N و M قبل از ۲۰۱۹)</td>
                        <td class="p-3.5 font-mono">Tizen 3.0 / 4.0</td>
                        <td class="p-3.5 text-amber-600 dark:text-amber-400 font-bold">قابل قبول</td>
                        <td class="p-3.5">در صورت کندی رم، استفاده از دانگل اندروید توصیه می‌شود</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- مقایسه با سایر پلتفرم‌ها و لینک‌های بین‌پلتفرمی --}}
    <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 space-y-4">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
            <span>راهنمای راه‌اندازی روی تلویزیون‌های دیگر</span>
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
            اگر در کنار تلویزیون سامسونگ، در شعبه دیگر یا بخش دیگری از گالری از تلویزیون‌های ال‌جی یا اندرویدی استفاده می‌کنید، راهنماهای تفکیکی زیر را مشاهده فرمایید:
        </p>
        <div class="pt-2 flex flex-wrap gap-3">
            <a href="/guides/lg-webos-gold-board" class="text-xs text-pink-600 dark:text-pink-400 font-bold hover:underline">
                راهنمای تلویزیون ال‌جی (webOS) ←
            </a>
            <a href="/android-tv-gold-board" class="text-xs text-emerald-600 dark:text-emerald-400 font-bold hover:underline">
                راهنمای اندروید تی‌وی و باکس (Sony, Snowa, Xiaomi) ←
            </a>
            <a href="/tv-setup-guide" class="text-xs text-amber-600 dark:text-amber-400 font-bold hover:underline">
                راهنمای جامع اتصال به انواع تلویزیون ←
            </a>
        </div>
    </div>

    {{-- پرسش‌های متداول طلافروشان درباره سامسونگ --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xl space-y-4">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">پرسش‌های متداول درباره تابلوی طلا روی سامسونگ</h2>
        <div class="space-y-3 pt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">
            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-1">
                <strong class="text-slate-900 dark:text-white font-bold block">آیا بعد از قطع و وصل برق مغازه، اتصال سامسونگ می‌پرد؟</strong>
                <p>خیر؛ سیستم‌عامل تایزن کوکی و نشست اتصال طلالایو را در حافظه فلش تلویزیون ذخیره می‌کند و با باز شدن مرورگر، تابلو فوراً بدون نیاز به اسکن مجدد نرخ‌ها را نمایش می‌دهد.</p>
            </div>
            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-1">
                <strong class="text-slate-900 dark:text-white font-bold block">اگر ریموت کنترل تلویزیون سامسونگ من خورشیدی یا اسمارت باشد چطور آدرس را وارد کنم؟</strong>
                <p>با زدن دکمه 123 یا میکروفون روی ریموت‌های اسمارت سامسونگ، کیبورد مجازی روی صفحه باز می‌شود. همچنین می‌توانید از طریق برنامه SmartThings سامسونگ روی گوشی، آدرس را مستقیماً از موبایل روی تلویزیون Paste کنید.</p>
            </div>
            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-1">
                <strong class="text-slate-900 dark:text-white font-bold block">آیا مرورگر سامسونگ فونت‌های فارسی اعداد را درست نشان می‌دهد؟</strong>
                <p>بله؛ قالب‌های طلالایو مجهز به فونت استاندارد وزیرمتن با اعداد کاملاً فارسی هستند و روی مرورگر تایزن بدون به‌هم‌ریختگی رندر می‌شوند.</p>
            </div>
        </div>
    </div>

    {{-- فراخوان میانی --}}
    @include('partials.cta-inline', [
        'title' => 'همین حالا تلویزیون سامسونگ مغازه را به تابلوی طلا تبدیل کنید',
        'subtitle' => 'بدون نیاز به خرید کیس و کابل‌کشی؛ با تست ۱۴ روزه کاملاً رایگان طلالایو نرخ‌های طلا و سکه را روی سامسونگ نمایش دهید.',
        'buttonText' => 'فعال‌سازی رایگان تابلو طلا',
        'buttonUrl' => route('admin.register')
    ])

    {{-- مطالب مرتبط --}}
    @include('partials.related-links', [
        'links' => [
            [
                'url' => '/tv-setup-guide',
                'title' => 'آموزش اتصال تلویزیون به تابلوی طلافروشی',
                'desc' => 'راهنمای گام‌به‌گام اتصال مرورگر انواع تلویزیون به تابلوی زنده در کمتر از ۳ دقیقه.'
            ],
            [
                'url' => '/guides/best-tv-for-jewelry-shop',
                'title' => 'بهترین تلویزیون برای مغازه طلافروشی',
                'desc' => 'مقایسه تلویزیون‌های سامسونگ و ال‌جی از نظر روشنایی پنل و مقاومت در ویترین.'
            ],
            [
                'url' => '/smart-gold-board',
                'title' => 'تابلوی هوشمند طلافروشی روی تلویزیون',
                'desc' => 'سامانه ابری مدیریت تابلو و اعلام نرخ لحظه‌ای طلا و ارز ویژه صنف زرگری.'
            ]
        ]
    ])

</div>
@endsection
