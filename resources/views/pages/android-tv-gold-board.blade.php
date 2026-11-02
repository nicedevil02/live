@extends('layouts.public')

@section('title', 'تابلو طلا روی اندروید تی‌وی: راه‌اندازی ۳ دقیقه‌ای | طلالایو')
@section('meta_description', 'آموزش تصویری راه‌اندازی تابلوی نرخ طلالایو روی تلویزیون هوشمند اندرویدی و اندروید باکس در کمتر از ۳ دقیقه با تست رایگان. همین حالا آنلاین اجرا کنید.')
@section('canonical', 'https://talalive.ir/android-tv-gold-board')
@section('og_image', asset('images/guides/android-tv-gold-board.webp'))
@section('og_image_alt', 'آموزش راه‌اندازی تابلو طلا روی اندروید تی‌وی طلالایو')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "TechArticle",
      "headline": "آموزش راه‌اندازی تابلو طلا روی اندروید تی‌وی و اندروید باکس",
      "description": "راهنمای گام‌به‌گام و تصویری اجرای تابلوی نرخ لحظه‌ای طلالایو روی تلویزیون‌های مجهز به Android TV و باکس اندروید بدون نیاز به مینی‌کیس.",
      "image": [
        "https://talalive.ir/images/guides/android-tv-gold-board.webp"
      ],
      "datePublished": "2025-10-01",
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
      "name": "مراحل راه‌اندازی تابلو طلا روی اندروید تی‌وی",
      "step": [
        {
          "@@type": "HowToStep",
          "name": "گام اول: اتصال تلویزیون به اینترنت",
          "text": "تلویزیون یا اندروید باکس را از منوی تنظیمات به وای‌فای مغازه متصل نمایید."
        },
        {
          "@@type": "HowToStep",
          "name": "گام دوم: نصب مرورگر TV Bro",
          "text": "از فروشگاه Google Play Store یا بازار اندروید تی‌وی، مرورگر رایگان TV Bro را نصب کنید."
        },
        {
          "@@type": "HowToStep",
          "name": "گام سوم: باز کردن سامانه طلالایو",
          "text": "آدرس talalive.ir را وارد کرده و بارکد تابلو را با موبایل اسکن کنید."
        },
        {
          "@@type": "HowToStep",
          "name": "گام چهارم: فعال‌سازی تمام‌صفحه و جلوگیری از Sleep",
          "text": "کلید تمام‌صفحه را فشرده و زمان اسکرین‌سیور تلویزیون را روی Never بگذارید."
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
          "name": "تابلو طلا روی اندروید تی‌وی",
          "item": "https://talalive.ir/android-tv-gold-board"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-12">

    {{-- مسیر راهنما Breadcrumb --}}
    @include('partials.breadcrumb', [
        'items' => [
            ['title' => 'پایگاه دانش', 'url' => route('public.guides')],
            ['title' => 'تابلو طلا روی اندروید تی‌وی', 'url' => ''],
        ]
    ])

    {{-- هدر و تعریف --}}
    <div class="space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-stone-100 dark:bg-stone-850 border border-stone-200 dark:border-stone-750 text-stone-700 dark:text-stone-300 text-xs font-semibold">
            <span>راهنمای سیستم‌عامل Android TV و Google TV</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-black text-stone-900 dark:text-stone-100 leading-tight">
            آموزش راه‌اندازی تابلو طلا روی اندروید تی‌وی و اندروید باکس
        </h1>
        <p class="text-stone-700 dark:text-stone-300 text-sm sm:text-base leading-relaxed bg-white dark:bg-stone-900 p-5 rounded-2xl border border-stone-200 dark:border-stone-800">
            <strong>تابلو طلا روی اندروید تی‌وی</strong> راهکاری نرم‌افزاری و ابری برای نمایش زنده نرخ طلا و سکه روی تلویزیون‌ها و باکس‌های مجهز به سیستم‌عامل Android TV است که بدون نیاز به کیس، با مرورگر وب یا اپلیکیشن اختصاصی در ۳ دقیقه راه‌اندازی می‌شود.
        </p>
    </div>

    {{-- تصویر شاخص راهنما --}}
    <figure class="relative rounded-3xl overflow-hidden border border-stone-200 dark:border-stone-800 shadow-sm aspect-[16/9] bg-stone-100 dark:bg-stone-900">
        <img src="{{ asset('images/guides/android-tv-gold-board.webp') }}" 
             alt="آموزش راه‌اندازی تابلو طلا روی اندروید تی‌وی و اندروید باکس" 
             width="1200" height="675" 
             loading="eager" fetchpriority="high" decoding="async"
             class="w-full h-full object-cover">
    </figure>

    {{-- بنر ویژه اپلیکیشن نیتیو تلویزیون --}}
    <div class="p-6 sm:p-8 rounded-3xl bg-amber-500/10 border border-amber-500/20 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="space-y-2 text-right">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-amber-500 text-stone-950">نسخه اختصاصی تلویزیون (پیشنهاد اول طلالایو)</span>
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-stone-100">دانلود اپلیکیشن اختصاصی برای تلویزیون و باکس</h2>
            <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-300">بدون نیاز به باز کردن مرورگر و بدون تنظیمات دستی؛ اپلیکیشن را نصب کرده و با یک کد تابلوی خود را متصل کنید.</p>
        </div>
        <a href="{{ route('public.app') }}" class="min-h-11 px-6 py-3 bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold rounded-xl text-sm shadow-sm transition-colors shrink-0 inline-flex items-center justify-center">
            دانلود مستقیم فایل نصبی تلویزیون
        </a>
    </div>

    {{-- مقایسه مرورگرهای مخصوص تلویزیون اندروید --}}
    <section class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-3xl p-6 sm:p-10 shadow-sm space-y-6">
        <h2 class="text-xl font-bold text-stone-900 dark:text-stone-100 flex items-center gap-2">
            <span class="w-2.5 h-6 rounded-full bg-amber-500"></span>
            <span>جدول مقایسه مرورگرهای مناسب اندروید تی‌وی برای اجرای تابلو</span>
        </h2>
        <div class="overflow-x-auto rounded-2xl border border-stone-200 dark:border-stone-800">
            <table class="w-full text-right text-xs sm:text-sm border-collapse">
                <thead class="bg-stone-100 dark:bg-stone-850 text-stone-900 dark:text-stone-100 font-bold">
                    <tr>
                        <th class="p-3.5">نام مرورگر</th>
                        <th class="p-3.5">پشتیبانی از ریموت کنترل</th>
                        <th class="p-3.5">حالت تمام‌صفحه</th>
                        <th class="p-3.5">مصرف حافظه RAM</th>
                        <th class="p-3.5">وضعیت سازگاری</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200 dark:divide-stone-800 text-stone-700 dark:text-stone-300">
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-bold text-emerald-600 dark:text-emerald-400">TV Bro (پیشنهاد اصلی)</td>
                        <td class="p-3.5">سازگار با کلیدهای جهتی</td>
                        <td class="p-3.5 text-emerald-600 dark:text-emerald-400 font-bold">بله (حذف خودکار نوار آدرس)</td>
                        <td class="p-3.5">بسیار سبک (زیر ۸۰ مگابایت)</td>
                        <td class="p-3.5 font-bold text-emerald-600 dark:text-emerald-400">عالی</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-bold">Google Chrome</td>
                        <td class="p-3.5">نیازمند ماوس یا ایرماوس</td>
                        <td class="p-3.5">با کلید F11 کیبورد</td>
                        <td class="p-3.5">متوسط تا بالا</td>
                        <td class="p-3.5">خوب</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-bold">Puffin TV Browser</td>
                        <td class="p-3.5">سازگار با ریموت</td>
                        <td class="p-3.5">بله</td>
                        <td class="p-3.5">ابری و سبک</td>
                        <td class="p-3.5 text-amber-600 dark:text-amber-400">محدودیت زمانی</td>
                    </tr>
                    <tr class="hover:bg-stone-50/60 dark:hover:bg-stone-850/40">
                        <td class="p-3.5 font-bold">JioPages TV</td>
                        <td class="p-3.5">سازگار با ریموت</td>
                        <td class="p-3.5">بله</td>
                        <td class="p-3.5">متوسط</td>
                        <td class="p-3.5">قابل قبول</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-xs text-stone-500">مرورگر TV Bro رایگان و بدون تبلیغات بوده و به صورت مستقیم از گوگل پلی استور تلویزیون قابل دریافت است.</p>
    </section>

    {{-- مراحل ۵ گانه راه‌اندازی --}}
    <section class="space-y-6">
        <h2 class="text-2xl font-black text-stone-900 dark:text-stone-100">
            مراحل گام‌به‌گام راه‌اندازی تابلو طلا روی اندروید تی‌وی
        </h2>

        <div class="space-y-4">
            {{-- گام ۱ --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-amber-500 text-stone-950 font-bold flex items-center justify-center text-sm">۱</span>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">اتصال تلویزیون یا اندروید باکس به اینترنت وای‌فای</h3>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed pr-11">
                    ریموت کنترل را بردارید و وارد بخش <strong>تنظیمات (Settings)</strong> تلویزیون شوید. به مسیر <strong>شبکه و اینترنت (Network & Internet)</strong> رفته و به وای‌فای گالری متصل شوید. نیازی به اینترنت پرسرعت نیست؛ پایداری ارتباط برای آپدیت نرخ‌ها کفایت می‌کند.
                </p>
            </div>

            {{-- گام ۲ --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-amber-500 text-stone-950 font-bold flex items-center justify-center text-sm">۲</span>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">نصب مرورگر تلویزیون TV Bro از Google Play Store</h3>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed pr-11">
                    وارد برنامه <strong>Google Play Store</strong> در منوی تلویزیون شوید. در بخش جستجو نام مرورگر <code class="font-mono text-amber-600 dark:text-amber-400 font-bold">TV Bro</code> را تایپ کرده و دکمه نصب را بزنید. (اگر به گوگل پلی دسترسی ندارید، از بازار یا مایکت اندروید تی‌وی نیز قابل نصب است).
                </p>
            </div>

            {{-- گام ۳ --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-amber-500 text-stone-950 font-bold flex items-center justify-center text-sm">۳</span>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">ورود به نشانی talalive.ir و جفت‌سازی با موبایل</h3>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed pr-11">
                    مرورگر TV Bro را باز کنید و در نوار آدرس نشانی <strong class="font-mono text-amber-600 dark:text-amber-400">talalive.ir</strong> را وارد نمایید. صفحه اتصال سریع تلویزیون ظاهر می‌شود. کافی است بارکد روی تلویزیون را با دوربین موبایل خود اسکن نمایید تا تابلوی زنده گالری شما فعال شود.
                </p>
            </div>

            {{-- گام ۴ --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-amber-500 text-stone-950 font-bold flex items-center justify-center text-sm">۴</span>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">تنظیم حالت تمام‌صفحه بدون نوار اضافه</h3>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed pr-11">
                    در مرورگر TV Bro، دکمه منو روی ریموت را بزنید و گزینه <strong>تمام‌صفحه (Fullscreen)</strong> را انتخاب کنید. نوار ابزار و آدرس مخفی شده و تلویزیون شما به شکل یک تابلوی یکپارچه نمایش داده می‌شود.
                </p>
            </div>

            {{-- گام ۵ --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-amber-500 text-stone-950 font-bold flex items-center justify-center text-sm">۵</span>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">جلوگیری از خاموش شدن خودکار صفحه</h3>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed pr-11">
                    به تنظیمات تلویزیون بروید: مسیر محافظ صفحه (Screen saver) را باز کنید و زمان شروع آن را روی <strong>هرگز (Never)</strong> تنظیم کنید. همچنین گزینه خاموشی خودکار پس از بی‌کاری را غیرفعال سازید تا صفحه در طول روز روشن بماند.
                </p>
            </div>

            {{-- گام ۶ --}}
            <div class="p-6 rounded-3xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 space-y-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-amber-500 text-stone-950 font-bold flex items-center justify-center text-sm">۶</span>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">راه‌اندازی خودکار پس از وصل برق</h3>
                </div>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed pr-11">
                    اگر در مغازه با قطع و وصل برق مواجه شدید، برای اینکه تلویزیون بدون نیاز به دست زدن به ریموت فوراً به تابلو برگردد، برنامه رایگان <strong>Launch on Boot</strong> را از گوگل پلی نصب نموده و مرورگر TV Bro را به عنوان برنامه شروع خودکار انتخاب کنید.
                </p>
            </div>
        </div>
    </section>

    {{-- راهکار باکس اندروید و دانگل برای تلویزیون‌های معمولی --}}
    <section class="p-6 sm:p-10 rounded-3xl bg-stone-100/80 dark:bg-stone-850/80 border border-stone-200 dark:border-stone-800 space-y-4">
        <h2 class="text-xl font-bold text-stone-900 dark:text-stone-100 flex items-center gap-2">
            <span class="w-2.5 h-6 rounded-full bg-amber-500"></span>
            <span>آیا تلویزیون مغازه هوشمند نیست؟ راهکار باکس اندروید و دانگل</span>
        </h2>
        <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
            اگر در مغازه یک تلویزیون LCD یا LED معمولی دارید که هوشمند نیست یا وای‌فای ندارد، نیازی به تعویض تلویزیون ندارید. با خرید یک <strong>اندروید باکس (Android Box)</strong> یا <strong>دانگل HDMI</strong> اقتصادی و اتصال آن با کابل HDMI به تلویزیون، تلویزیون شما فوراً به سیستم‌عامل اندروید تی‌وی مجهز شده و تابلوی طلالایو روی آن فعال می‌گردد.
        </p>
        <div class="pt-2 flex flex-wrap gap-4 text-xs">
            <a href="{{ route('public.guides.show', 'samsung-tizen-gold-board') }}" class="text-amber-600 dark:text-amber-400 font-bold hover:underline inline-flex items-center gap-1">
                <span>راهنمای تلویزیون سامسونگ (تایزن)</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
            <a href="{{ route('public.guides.show', 'lg-webos-gold-board') }}" class="text-amber-600 dark:text-amber-400 font-bold hover:underline inline-flex items-center gap-1">
                <span>راهنمای تلویزیون ال‌جی (webOS)</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
            <a href="{{ route('public.tv-setup-guide') }}" class="text-amber-600 dark:text-amber-400 font-bold hover:underline inline-flex items-center gap-1">
                <span>راهنمای اتصال به تلویزیون طلالایو</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </div>
    </section>

    {{-- پرسش‌های متداول --}}
    <section class="space-y-4 max-w-4xl mx-auto">
        <h2 class="text-xl font-bold text-stone-900 dark:text-stone-100">پرسش‌های متداول طلافروشان درباره اندروید تی‌وی</h2>
        <div class="space-y-3">
            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>آیا بعد از خاموش و روشن شدن تلویزیون نیاز به اسکن مجدد بارکد هست؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    خیر؛ مشخصات اتصال در حافظه مرورگر ذخیره شده و با هر بار باز شدن مرورگر، تابلوی شما به صورت خودکار متصل می‌گردد.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>کدام برندهای تلویزیون از سیستم‌عامل اندروید تی‌وی استفاده می‌کنند؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    تلویزیون‌های سونی، اسنوا، دوو، ایکس‌ویژن، جی‌پلاس و تی‌سی‌ال از پلتفرم اندروید تی‌وی استفاده می‌کنند و با این راهنما کاملاً سازگارند.
                </div>
            </details>

            <details class="group bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>آیا به موس و کیبورد نیاز داریم؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform duration-200">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-100 dark:border-stone-800/80 mt-3">
                    خیر؛ مرورگر TV Bro با کلیدهای جهتی ریموت کنترل استاندارد تلویزیون سازگار است و نیازی به ماوس نخواهید داشت.
                </div>
            </details>
        </div>
    </section>

    {{-- CTA میانی --}}
    @include('partials.cta-inline', [
        'title' => 'همین حالا تلویزیون اندرویدی مغازه را به تابلوی طلا تبدیل کنید',
        'subtitle' => 'بدون نیاز به خرید مینی‌کیس و بدون کابل‌کشی؛ با تست ۱۴ روزه کاملاً رایگان طلالایو آغاز نمایید.',
        'buttonText' => 'تست رایگان تابلو طلا',
        'buttonUrl' => route('admin.register')
    ])

    {{-- مطالب مرتبط --}}
    @include('partials.related-links', [
        'links' => [
            [
                'url' => route('public.tv-setup-guide'),
                'title' => 'آموزش اتصال تلویزیون به تابلوی طلافروشی',
                'desc' => 'راهنمای گام‌به‌گام اتصال مرورگر انواع تلویزیون به تابلوی زنده در کمتر از ۳ دقیقه.'
            ],
            [
                'url' => route('public.guides.show', 'best-tv-for-jewelry-shop'),
                'title' => 'بهترین تلویزیون برای مغازه طلافروشی',
                'desc' => 'راهنمای خرید تلویزیون با روشنایی بالا و پنل ضد انعکاس مناسب ویترین.'
            ],
            [
                'url' => route('public.smart-gold-board'),
                'title' => 'تابلوی هوشمند طلافروشی روی تلویزیون',
                'desc' => 'سامانه ابری نمایش زنده نرخ طلا و مسکوکات با قالب‌های ویترین.'
            ]
        ]
    ])

</div>
@endsection
