@extends('layouts.public')

@section('title', 'تابلوی هوشمند طلافروشی روی تلویزیون مغازه | طلالایو')
@section('meta_description', 'تابلوی هوشمند طلافروشی برای نمایش زنده نرخ طلا و مسکوکات روی انواع تلویزیون با اتصال وای‌فای و بدون نیاز به مینی‌کیس. ۱۴ روز تست کاملاً رایگان را آغاز کنید.')
@section('canonical', 'https://talalive.ir/smart-gold-board')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "SoftwareApplication",
      "name": "تابلوی هوشمند طلافروشی و طلا فروشی طلالایو",
      "alternateName": [
        "تابلوی طلا فروشی",
        "تابلو طلا فروشی",
        "نرم افزار تابلو طلا فروشی",
        "تابلو انلاین طلا فروشی",
        "نمایشگر مغازه طلا فروشی",
        "اعلام نرخ لحظه ای طلا و سکه"
      ],
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "Smart TV, Web Browser",
      "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "IRR"
      },
      "description": "سامانه ابری تابلوی نرخ طلا و سکه ویژه نمایشگرهای طلافروشی و مغازه طلا فروشی بدون نیاز به سخت‌افزار جانبی."
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
          "name": "تابلوی هوشمند طلافروشی و طلا فروشی",
          "item": "https://talalive.ir/smart-gold-board"
        }
      ]
    },
    {
      "@@type": "FAQPage",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "تابلوی هوشمند طلافروشی طلالایو چه تفاوتی با تابلوهای LED سنتی دارد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "تابلوهای سنتی LED نیازمند سخت‌افزار گران‌قیمت، بردهای الکترونیکی حساس به نوسان برق و سیم‌کشی اختصاصی هستند و فونت‌های تک‌رنگ و بی‌کیفیت دارند. تابلوی هوشمند طلالایو مستقیماً روی هر تلویزیون معمولی یا 4K در مغازه طلا فروشی اجرا می‌شود، گرافیک شفاف دارد، نرخ‌ها را خودکار بروزرسانی می‌کند و تصاویر محصولات ویترین مغازه را نیز به نمایش می‌گذارد."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا برای اجرای تابلوی طلا فروشی طلالایو باید کیس کامپیوتر یا دستگاه اضافه خریداری کنیم؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "خیر. بزرگترین مزیت مهندسی طلالایو حذف ۱۰۰ درصدی مینی‌کیس و کامپیوتر است. با مرورگر وب خود تلویزیون مغازه طلا فروشی به سامانه وصل می‌شوید و نیازی به هیچ هزینه سخت‌افزاری اضافه ندارید."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا تابلوی هوشمند نرخ‌ها را طبق سود و سیاست فروشگاه ما نمایش می‌دهد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "بله، در پنل مدیریت طلالایو می‌توانید فرمول سود فروش، درصد خرید، مالیات و تخفیف‌ها را به ازای هر نوع طلا یا سکه تنظیم کنید تا نرخ روی تابلو دقیقاً همان رقمی باشد که مشتری در فاکتور پرداخت می‌کند."
          }
        },
        {
          "@@type": "Question",
          "name": "هزینه راه‌اندازی تابلو طلا فروشی با تلویزیون چقدر است؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "در سامانه طلالایو نیاز به پرداخت ده‌ها میلیون تومان برای خرید تابلوهای فیزیکی طلا فروشی ندارید. با همان تلویزیون موجود در مغازه طلا فروشی و تست رایگان ۱۴ روزه، می‌توانید تابلوی نرخ لحظه‌ای طلا و سکه را فوراً فعال کنید."
          }
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="relative py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16 sm:space-y-20 overflow-hidden">

    {{-- هاله نور مخفی استودیویی پشت هیرو --}}
    <div class="tl-ambient-gold absolute -top-8 left-1/2 -translate-x-1/2 w-[600px] h-[250px] rounded-full opacity-80" aria-hidden="true"></div>

    {{-- هیرو سکشن لندینگ --}}
    <header class="relative z-10 text-center space-y-6 max-w-4xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full tl-glass-badge text-amber-800 dark:text-amber-300 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            <span>فناوری تابلوی دیجیتال گالری‌های طلا و جواهر</span>
        </div>
        
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-stone-900 dark:text-stone-100 leading-tight">
            تابلوی هوشمند طلافروشی روی تلویزیون مغازه؛ <br>
            <span class="text-amber-700 dark:text-amber-400">
                ابری، باکیفیت و بدون نیاز به مینی‌کیس
            </span>
        </h1>

        <p class="text-stone-600 dark:text-stone-300 text-base sm:text-lg leading-relaxed max-w-3xl mx-auto">
            با <strong>طلالایو</strong>، هر تلویزیون معمولی در ویترین مغازه طلافروشی را بدون نیاز به مینی‌کیس به یک تابلوی اعلانات تمیز با نرخ‌های لحظه‌ای و اسلایدشوی محصولات تبدیل کنید.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a href="{{ route('admin.register') }}" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl tl-btn-bullion font-bold text-sm inline-flex items-center justify-center gap-2">
                <span>تست رایگان و ثبت‌نام گالری</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
            </a>
            <a href="{{ url('/demo') }}" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl tl-neu-btn text-stone-800 dark:text-stone-100 font-bold text-sm inline-flex items-center justify-center gap-2">
                @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                <span>مشاهده پیش‌نمایش زنده تابلو</span>
            </a>
        </div>
    </header>

    {{-- چرا تابلوهای LED روان سنتی منسوخ شده‌اند؟ --}}
    <section class="tl-reveal relative z-10 tl-neu-card rounded-3xl p-6 sm:p-10 space-y-8">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">چرا تابلوهای LED و سنتی دیگر به صرفه نیستند؟</h2>
            <p class="text-stone-600 dark:text-stone-400 text-sm">چالش‌هایی که طلافروشان سال‌ها با تابلوهای قدیمی سخت‌افزاری تجربه کرده‌اند</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="tl-neu-inset p-6 rounded-2xl space-y-3">
                <div class="w-10 h-10 rounded-xl tl-neu-icon-orb text-red-700 dark:text-red-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'x', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">هزینه‌های گزاف سخت‌افزاری</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    خرید تابلوی LED ماتریسی با ابعاد مناسب بیش از ۲۰ تا ۵۰ میلیون تومان هزینه دارد و با هر نوسان برق، قطعات تغذیه و ماژول‌های آن دچار سوختگی می‌شوند.
                </p>
            </div>

            <div class="tl-neu-inset p-6 rounded-2xl space-y-3">
                <div class="w-10 h-10 rounded-xl tl-neu-icon-orb text-red-700 dark:text-red-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'x', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">ظاهر نامناسب و فونت‌های زشت</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    فونت‌های پیکسلی تک‌رنگ (قرمز یا سبز) جلوه دکوراسیون ویترین طلافروشی را کاهش می‌دهند و امکان نمایش عکس مدال، النگو یا تیزر تبلیغاتی ندارند.
                </p>
            </div>

            <div class="tl-neu-inset p-6 rounded-2xl space-y-3">
                <div class="w-10 h-10 rounded-xl tl-neu-icon-orb text-red-700 dark:text-red-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'x', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">دردسر بروزرسانی و کابل‌کشی</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    برای تغییر نرخ در تابلوهای قدیمی باید از ریموت‌های کند استفاده می‌کردید یا یک کامپیوتر با کابل سریال همیشه به تابلو متصل می‌ماند.
                </p>
            </div>
        </div>
    </section>

    {{-- جدول مقایسه کامل و جامع (Comparison Matrix) --}}
    <section class="tl-reveal relative z-10 space-y-6">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">مقایسه تخصصی: طلالایو در برابر تابلوی سنتی LED مغازه طلا فروشی</h2>
            <p class="text-stone-600 dark:text-stone-400 text-sm">چرا +۳۵۰ گالری معتبر طلا در سراسر کشور به تابلوی ابری مهاجرت کرده‌اند؟</p>
        </div>

        <div class="overflow-x-auto rounded-3xl tl-neu-card p-1.5 sm:p-2">
            <table class="w-full text-right text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="border-b border-stone-300/60 dark:border-stone-800 tl-neu-inset text-stone-700 dark:text-stone-200">
                        <th class="p-4 sm:p-5 font-bold rounded-tr-2xl">ویژگی و شاخص فنی</th>
                        <th class="p-4 sm:p-5 font-bold text-amber-700 dark:text-amber-400">سامانه ابری طلالایو (TalaLive)</th>
                        <th class="p-4 sm:p-5 font-bold text-stone-600 dark:text-stone-400 rounded-tl-2xl">تابلوهای ماتریسی LED قدیمی</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-300/50 dark:divide-stone-800/70">
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">نیاز به خرید مینی‌کیس یا کامپیوتر</td>
                        <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-bold">بدون نیاز (۱۰۰٪ ابری از طریق مرورگر تلویزیون)</td>
                        <td class="p-4 sm:p-5 text-red-700 dark:text-red-400">نیاز به برد کنترلر یا کیس اختصاصی</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">کیفیت تصویر و فونت فارسی</td>
                        <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-bold">شفاف (Full HD و 4K با فونت وزیرمتن)</td>
                        <td class="p-4 sm:p-5 text-stone-600 dark:text-stone-400">ماتریسی پیکسلی تک‌رنگ و بی‌کیفیت</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">نحوه بروزرسانی قیمت‌ها</td>
                        <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-bold">خودکار و آنی از مراجع منتخب بازار طلا</td>
                        <td class="p-4 sm:p-5 text-stone-600 dark:text-stone-400">دستی با ریموت یا نرم‌افزارهای پیچیده کامپیوتر</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">نمایش عکس و اسلایدشوی محصولات ویترین</td>
                        <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-bold">دارد (گالری تصاویر و بارکد اختصاصی اینستاگرام مغازه)</td>
                        <td class="p-4 sm:p-5 text-red-700 dark:text-red-400">غیرممکن</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">شخصی‌سازی حاشیه سود و اجرت فروش</td>
                        <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-bold">دارد (فرمول‌ساز پیشرفته خرید و فروش طلا و سکه)</td>
                        <td class="p-4 sm:p-5 text-red-700 dark:text-red-400">فقط نمایش اعداد خام و دستی</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">پایداری در زمان قطعی موقت اینترنت</td>
                        <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-bold">دارد (حالت آفلاین هوشمند با حفظ کامل ویترین و آخرین نرخ)</td>
                        <td class="p-4 sm:p-5 text-stone-600 dark:text-stone-400">وابسته به ارسال دستور دستی</td>
                    </tr>
                    <tr class="hover:bg-amber-500/5 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">هزینه راه‌اندازی اولیه</td>
                        <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-bold">صفر تومان (استفاده از تلویزیون موجود در گالری)</td>
                        <td class="p-4 sm:p-5 text-red-700 dark:text-red-400">۲۰ تا ۶۰ میلیون تومان خرید تابلو</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-5 sm:p-6 rounded-2xl tl-glass-deck text-xs sm:text-sm text-stone-700 dark:text-stone-200 leading-relaxed">
            <div class="font-bold text-stone-900 dark:text-stone-100 mb-2">راهنماهای تخصصی جایگزینی تابلو:</div>
            <p>
                اگر به دنبال جایگزینی تابلوی سنتی ۷ رقمه سون سگمنت هستید، راهنمای <a href="{{ route('public.digital-rate-board') }}" class="text-amber-700 dark:text-amber-400 font-bold underline hover:text-amber-600">نرخ نامه دیجیتال طلافروشی</a> را بخوانید. همچنین برای آشنایی با راه‌اندازی بدون خرید هرگونه کیس یا سخت‌افزار، به صفحه <a href="{{ route('public.gold-board-without-device') }}" class="text-amber-700 dark:text-amber-400 font-bold underline hover:text-amber-600">تابلو طلا بدون دستگاه</a> مراجعه فرمایید.
            </p>
        </div>
    </section>

    {{-- قابلیت‌های ویژه تابلوی طلالایو --}}
    <section class="tl-reveal relative z-10 space-y-8">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">امکانات تابلوی هوشمند طلالایو</h2>
            <p class="text-stone-600 dark:text-stone-400 text-sm">طراحی شده بر اساس نیازهای روز صنف طلا و جواهر</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-6 rounded-3xl tl-neu-card space-y-3.5">
                <div class="w-11 h-11 rounded-2xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'bolt', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">اتصال در ۶۰ ثانیه با بارکد QR</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    مرورگر تلویزیون را باز کنید، بارکد نمایش داده شده را با دوربین موبایل اسکن نمایید؛ صفحه فوراً متصل شده و نیاز به هیچ تنظیمات دیگری ندارد.
                </p>
            </div>

            <div class="p-6 rounded-3xl tl-neu-card space-y-3.5">
                <div class="w-11 h-11 rounded-2xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'gem', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">اسلایدشوی ویترین طلا</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    عکس النگوها، دستبندها و سرویس‌های خود را همراه با مشخصات و بارکد اینستاگرام گالری در کنار قیمت‌ها پخش کنید.
                </p>
            </div>

            <div class="p-6 rounded-3xl tl-neu-card space-y-3.5">
                <div class="w-11 h-11 rounded-2xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'calculator', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">فرمول‌ساز سود و اجرت فروشگاهی</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    اگر می‌خواهید نرخ طلای ۱۸ عیار با احتساب سود یا اجرت مشخصی روی تابلو برود، با سیستم فرمول‌ساز، محاسبات به صورت لحظه‌ای انجام می‌شود.
                </p>
            </div>

            <div class="p-6 rounded-3xl tl-neu-card space-y-3.5">
                <div class="w-11 h-11 rounded-2xl tl-neu-icon-orb text-emerald-700 dark:text-emerald-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'wifi-off', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">کارکرد آفلاین هوشمند</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    اگر اینترنت گالری برای ساعاتی قطع شود، صفحه تلویزیون سیاه نمی‌شود؛ بلکه آخرین نرخ‌های دریافتی را با ثبت ساعت دقیق بروزرسانی به همراه ویترین حفظ می‌کند.
                </p>
            </div>

            <div class="p-6 rounded-3xl tl-neu-card space-y-3.5">
                <div class="w-11 h-11 rounded-2xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'shield', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">حفاظت از پنل تلویزیون</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    الگوریتم‌های حرکتی ملایم و چرخش اسلایدها در طلالایو به نحوی طراحی شده‌اند که پیکسل‌های تلویزیون شما در کارکرد مداوم روزانه دچار ماندگاری تصویر نشوند.
                </p>
            </div>

            <div class="p-6 rounded-3xl tl-neu-card space-y-3.5">
                <div class="w-11 h-11 rounded-2xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'smartphone', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">مدیریت از گوشی یا رایانه</h3>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
                    هر تغییری در آیتم‌های نمایش، مخفی‌سازی قیمت ارز، تغییر ترتیب سکه‌ها یا افزودن محصول جدید را مستقیماً از گوشی همراه خود در چند ثانیه اعمال کنید.
                </p>
            </div>
        </div>

        {{-- پوشش ارز و نقره و شمش --}}
        <div class="p-6 sm:p-8 rounded-3xl tl-neu-card-gold flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-start gap-3.5 text-right">
                <div class="w-11 h-11 rounded-2xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center shrink-0">
                    @include('partials.ui-icon', ['name' => 'layers', 'class' => 'w-5 h-5'])
                </div>
                <div class="space-y-1.5">
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">
                        پشتیبانی چندمنظوره از تابلوهای صرافی، نقره و شمش
                    </h3>
                    <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-300 max-w-2xl leading-relaxed">
                        علاوه بر طلا و جواهر، امکان راه‌اندازی اختصاصی <a href="{{ route('public.currency-exchange-board') }}" class="text-amber-700 dark:text-amber-400 font-bold hover:underline">تابلو صرافی و نرخ ارز</a> و همچنین <a href="{{ route('public.silver-bullion-board') }}" class="text-amber-700 dark:text-amber-400 font-bold hover:underline">تابلو نرخ نقره و شمش</a> با ردیف‌های تفکیکی عیارهای ۹۹۹ و ۹۲۵ فراهم است.
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0 flex-wrap">
                <a href="{{ route('public.currency-exchange-board') }}" class="min-h-11 px-5 py-2.5 rounded-xl tl-btn-bullion font-bold text-xs inline-flex items-center justify-center">
                    مشاهده تابلوی صرافی
                </a>
                <a href="{{ route('public.silver-bullion-board') }}" class="min-h-11 px-5 py-2.5 rounded-xl tl-neu-btn text-stone-800 dark:text-stone-100 font-bold text-xs inline-flex items-center justify-center">
                    مشاهده تابلوی نقره
                </a>
            </div>
        </div>
    </section>

    {{-- سوالات متداول --}}
    <section class="tl-reveal relative z-10 space-y-6 max-w-4xl mx-auto">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-stone-100">سوالات متداول تابلوی هوشمند طلافروشی</h2>
        </div>

        <div class="space-y-3.5">
            <details class="group tl-neu-card rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>آیا تلویزیون مغازه طلا فروشی باید دائماً به اینترنت وصل باشد؟</span>
                    <span class="w-8 h-8 rounded-xl tl-neu-icon-orb flex items-center justify-center text-stone-600 dark:text-stone-300 group-open:rotate-180 transition-transform duration-200 shrink-0">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-4 h-4'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-300/60 dark:border-stone-800 mt-3">
                    برای دریافت تغییرات نرخ‌ها به اینترنت نیاز است، اما حجم مصرفی سامانه طلالایو بسیار ناچیز است (کمتر از چند مگابایت در روز). همچنین در صورت قطعی اینترنت، سیستم به شکل آفلاین کار خواهد کرد.
                </div>
            </details>

            <details class="group tl-neu-card rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>اگر برق مغازه قطع شود، بعد از روشن شدن تلویزیون چه می‌شود؟</span>
                    <span class="w-8 h-8 rounded-xl tl-neu-icon-orb flex items-center justify-center text-stone-600 dark:text-stone-300 group-open:rotate-180 transition-transform duration-200 shrink-0">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-4 h-4'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-300/60 dark:border-stone-800 mt-3">
                    اطلاعات اتصال تلویزیون در حافظه مرورگر آن ذخیره شده است. به محض روشن شدن تلویزیون و باز کردن مرورگر، بدون نیاز به اسکن مجدد بارکد، تابلوی گالری طلا فروشی شما بالا می‌آید.
                </div>
            </details>

            <details class="group tl-neu-card rounded-2xl p-5 open:pb-6 transition-all">
                <summary class="flex items-center justify-between cursor-pointer list-none font-bold text-stone-900 dark:text-stone-100 text-sm sm:text-base select-none">
                    <span>آیا می‌توانیم فونت و رنگ‌ها را طبق دکور مغازه طلا فروشی تغییر دهیم؟</span>
                    <span class="w-8 h-8 rounded-xl tl-neu-icon-orb flex items-center justify-center text-stone-600 dark:text-stone-300 group-open:rotate-180 transition-transform duration-200 shrink-0">
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-4 h-4'])
                    </span>
                </summary>
                <div class="pt-3 text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed border-t border-stone-300/60 dark:border-stone-800 mt-3">
                    قالب استاندارد طلالایو بر اساس بالاترین کنتراست نوری تنظیم شده تا از فاصله دور نیز ارقام کاملاً خوانا باشند. همچنین گزینه‌های سفارشی‌سازی رنگ در پنل تنظیمات در دسترس است.
                </div>
            </details>
        </div>
    </section>

    {{-- لینک به بازار مجاور: صرافی و نرخ ارز --}}
    <div class="relative z-10 p-6 sm:p-8 rounded-3xl tl-neu-card flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="space-y-1 text-center sm:text-right">
            <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">آیا در کنار طلا، معاملات ارزی و حواله نیز انجام می‌دهید؟</h3>
            <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400">سامانه طلالایو نسخه اختصاصی نمایشگر دو نرخه خرید و فروش انواع ارز و حواله را برای صرافی‌ها ارائه می‌دهد.</p>
        </div>
        <a href="{{ route('public.currency-exchange-board') }}" class="min-h-11 px-6 py-3 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 font-bold text-xs inline-flex items-center justify-center shrink-0">
            مشاهده تابلو صرافی و نرخ ارز
        </a>
    </div>

    {{-- لینک به بازار مجاور: نقره و شمش --}}
    <div class="relative z-10 p-6 sm:p-8 rounded-3xl tl-neu-card flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="space-y-1 text-center sm:text-right">
            <h3 class="text-base font-bold text-stone-900 dark:text-stone-100">فروشگاه نقره، کارگاه ساچمه یا مرکز معاملات شمش دارید؟</h3>
            <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400">نمایشگر زنده عیارهای ۹۹۹، ۹۹۵ و ۹۲۵ نقره به همراه شمش‌های طلا را روی تلویزیون مشاهده کنید.</p>
        </div>
        <a href="{{ route('public.silver-bullion-board') }}" class="min-h-11 px-6 py-3 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 font-bold text-xs inline-flex items-center justify-center shrink-0">
            مشاهده تابلو نرخ نقره و شمش
        </a>
    </div>

    {{-- بنر دعوت به اقدام نهایی با پنل OLED لوکس --}}
    <div class="tl-reveal tl-oled-readout rounded-3xl p-8 sm:p-12 text-center space-y-6">
        <div class="tl-screen-glare absolute inset-0" aria-hidden="true"></div>
        <div class="relative z-10 space-y-6">
            <h2 class="text-2xl sm:text-4xl font-black text-stone-50">
                تلویزیون ویترین مغازه خود را به تابلوی هوشمند طلا تبدیل کنید
            </h2>
            <p class="text-stone-300 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
                ثبت‌نام رایگان است. تابلوی اختصاصی خود را بسازید و جلوه بصری مغازه طلافروشی‌تان را ارتقا دهید.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('admin.register') }}" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl tl-btn-bullion font-bold text-sm inline-flex items-center justify-center gap-2">
                    <span>شروع فوری و ثبت‌نام گالری</span>
                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
                </a>
                <a href="tel:09187009064" class="w-full sm:w-auto min-h-11 px-8 py-3.5 rounded-xl bg-white/10 hover:bg-white/15 border border-white/20 text-stone-50 font-bold text-sm transition-colors inline-flex items-center justify-center gap-2">
                    @include('partials.ui-icon', ['name' => 'phone', 'class' => 'w-4 h-4 text-amber-400'])
                    <span>تماس با واحد پشتیبانی: ۰۹۱۸۷۰۰۹۰۶۴</span>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
