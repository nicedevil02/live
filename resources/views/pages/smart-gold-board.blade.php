@extends('layouts.public')

@section('title', 'تابلوی هوشمند طلافروشی | جایگزین مدرن تابلوهای LED و سنتی | طلالایو')
@section('meta_description', 'سامانه ابری تابلوی هوشمند طلافروشی برای نمایش زنده نرخ طلا، سکه و ویترین جواهرات روی تلویزیون. بدون نیاز به مینی‌کیس، مقایسه با تابلوهای سنتی LED و فرمول‌ساز سود اختصاصی.')
@section('meta_keywords', 'تابلوی هوشمند طلافروشی, نرم افزار تابلوی طلا, تابلو ال ای دی طلافروشی, تابلو دیجیتال طلا, تابلو قیمت طلا مغازه, تابلوی طلا تلویزیون')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "SoftwareApplication",
      "name": "تابلوی هوشمند طلافروشی طلالایو",
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "Smart TV, Web Browser",
      "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "IRR"
      },
      "description": "سامانه ابری پیشرفته تابلوی نرخ طلا و سکه ویژه نمایشگرهای طلافروشی بدون نیاز به سخت‌افزار جانبی."
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
          "name": "تابلوی هوشمند طلافروشی",
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
            "text": "تابلوهای سنتی LED نیازمند سخت‌افزار گران‌قیمت، بردهای الکترونیکی حساس به نوسان برق و سیم‌کشی اختصاصی هستند و فونت‌های تک‌رنگ و بی‌کیفیت دارند. تابلوی هوشمند طلالایو مستقیماً روی هر تلویزیون معمولی یا 4K اجرا می‌شود، گرافیک فوق‌العاده مدرن شیشه‌ای دارد، نرخ‌ها را خودکار بروزرسانی می‌کند و تصاویر محصولات ویترین مغازه را نیز به نمایش می‌گذارد."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا برای اجرای تابلوی طلالایو باید کیس کامپیوتر یا دستگاه اضافه خریداری کنیم؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "خیر. بزرگترین مزیت مهندسی طلالایو حذف ۱۰۰ درصدی مینی‌کیس و کامپیوتر است. با مرورگر وب خود تلویزیون به سامانه وصل می‌شوید و نیازی به هیچ هزینه سخت‌افزاری اضافه ندارید."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا تابلوی هوشمند نرخ‌ها را طبق سود و سیاست فروشگاه ما نمایش می‌دهد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "بله، در پنل مدیریت طلالایو می‌توانید فرمول سود فروش، درصد خرید، مالیات و تخفیف‌ها را به ازای هر نوع طلا یا سکه تنظیم کنید تا نرخ روی تابلو دقیقاً همان رقمی باشد که مشتری در فاکتور پرداخت می‌کند."
          }
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-20">

    {{-- هیرو سکشن لندینگ --}}
    <div class="text-center space-y-6 max-w-4xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-300 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-amber-500 dark:bg-amber-400 animate-ping"></span>
            <span>انقلاب در دکوراسیون و فناوری گالری‌های طلا و جواهر</span>
        </div>
        
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white leading-tight">
            تابلوی هوشمند طلافروشی؛ <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 via-amber-500 to-yellow-600 dark:from-amber-300 dark:via-amber-400 dark:to-yellow-500">
                لوکس، ابری و بدون نیاز به مینی‌کیس
            </span>
        </h1>

        <p class="text-slate-600 dark:text-slate-300 text-base sm:text-lg leading-relaxed max-w-3xl mx-auto">
            دوران تابلوهای گران‌قیمت، زشت و پرمصرف LED سنتی به سر آمده است. با <strong>طلالایو</strong>، هر تلویزیون معمولی در ویترین مغازه را تنها در ۶۰ ثانیه به یک تابلوی اعلانات فوق‌العاده شیک با نرخ‌های لحظه‌ای و اسلایدشوی جواهرات تبدیل کنید.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a href="{{ route('admin.register') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/25 transition-all hover:scale-105 cursor-pointer">
                تست رایگان و ثبت‌نام گالری
            </a>
            <a href="/" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-white font-bold text-sm transition-all shadow-sm cursor-pointer">
                مشاهده پیش‌نمایش روی تلویزیون
            </a>
        </div>
    </div>

    {{-- چرا تابلوهای LED روان سنتی منسوخ شده‌اند؟ --}}
    <div class="glass-panel rounded-3xl p-8 sm:p-12 border border-slate-200 dark:border-slate-800 space-y-8">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">چرا تابلوهای LED و سنتی دیگر به صرفه نیستند؟</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">چالش‌هایی که طلافروشان سال‌ها با تابلوهای قدیمی سخت‌افزاری تجربه کرده‌اند</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-red-50/70 dark:bg-slate-950/60 p-6 rounded-2xl border border-red-200 dark:border-red-900/30 space-y-3">
                <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/20 text-red-500 dark:text-red-400 flex items-center justify-center text-xl font-black">✕</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">هزینه‌های گزاف سخت‌افزاری</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    خرید تابلوی LED ماتریسی با ابعاد مناسب بیش از ۲۰ تا ۵۰ میلیون تومان هزینه دارد و با هر نوسان برق، قطعات تغذیه و ماژول‌های آن دچار سوختگی می‌شوند.
                </p>
            </div>

            <div class="bg-red-50/70 dark:bg-slate-950/60 p-6 rounded-2xl border border-red-200 dark:border-red-900/30 space-y-3">
                <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/20 text-red-500 dark:text-red-400 flex items-center justify-center text-xl font-black">✕</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">ظاهر نامناسب و فونت‌های زشت</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    فونت‌های پیکسلی تک‌رنگ (قرمز یا سبز) جلوه لوکس ویترین طلافروشی را تخریب می‌کنند و هیچ امکانی برای نمایش عکس مدال، النگو یا تیزر تبلیغاتی ندارند.
                </p>
            </div>

            <div class="bg-red-50/70 dark:bg-slate-950/60 p-6 rounded-2xl border border-red-200 dark:border-red-900/30 space-y-3">
                <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/20 text-red-500 dark:text-red-400 flex items-center justify-center text-xl font-black">✕</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">دردسر بروزرسانی و کابل‌کشی</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    برای تغییر نرخ در تابلوهای قدیمی باید از ریموت‌های کند استفاده می‌کردید یا یک کامپیوتر با کابل سریال طولانی همیشه به تابلو متصل می‌ماند.
                </p>
            </div>
        </div>
    </div>

    {{-- جدول مقایسه کامل و جامع (Comparison Matrix) --}}
    <div class="space-y-6">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">مقایسه تخصصی: طلالایو در برابر تابلوی سنتی LED</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">چرا ۹۸٪ گالری‌های طلا در حال مهاجرت به تابلوی ابری هستند؟</p>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950/60 shadow-xl dark:shadow-2xl">
            <table class="w-full text-right text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-100/80 dark:bg-slate-900/80 text-slate-700 dark:text-slate-300">
                        <th class="p-4 sm:p-5 font-bold">ویژگی و شاخص فنی</th>
                        <th class="p-4 sm:p-5 font-bold text-amber-600 dark:text-amber-400">سامانه ابری طلالایو (TalaLive)</th>
                        <th class="p-4 sm:p-5 font-bold text-slate-500 dark:text-slate-400">تابلوهای ماتریسی LED قدیمی</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60">
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">نیاز به خرید مینی‌کیس / کامپیوتر</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">بدون نیاز (۱۰۰٪ ابری از طریق مرورگر تلویزیون)</td>
                        <td class="p-4 sm:p-5 text-rose-600 dark:text-red-400">نیاز به برد کنترلر یا کیس اختصاصی</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">کیفیت تصویر و فونت فارسی</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">فوق‌العاده شفاف (Full HD و 4K با فونت وزیرمتن)</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400">ماتریسی پیکسلی تک‌رنگ و بی‌کیفیت</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">نحوه بروزرسانی قیمت‌ها</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">کاملاً خودکار و آنی از معتبرترین مراجع رسمی طلا</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400">دستی با ریموت یا نرم‌افزارهای پیچیده کامپیوتر</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">نمایش عکس و اسلایدشوی محصولات ویترین</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">دارد (گالری تصاویر و بارکد اختصاصی اینستاگرام مغازه)</td>
                        <td class="p-4 sm:p-5 text-rose-600 dark:text-red-400">غیرممکن</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">شخصی‌سازی حاشیه سود و اجرت فروش</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">دارد (فرمول‌ساز پیشرفته خرید و فروش طلا و سکه)</td>
                        <td class="p-4 sm:p-5 text-rose-600 dark:text-red-400">فقط نمایش اعداد خام و دستی</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">پایداری در زمان قطعی موقت اینترنت</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">دارد (حالت آفلاین هوشمند با حفظ کامل ویترین و آخرین نرخ)</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400">وابسته به ارسال دستور دستی</td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">هزینه راه‌اندازی اولیه</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">صفر تومان (استفاده از تلویزیون موجود در گالری)</td>
                        <td class="p-4 sm:p-5 text-rose-600 dark:text-red-400">۲۰ تا ۶۰ میلیون تومان خرید تابلو</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- قابلیت‌های ویژه تابلوی طلالایو --}}
    <div class="space-y-8">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">امکانات منحصر‌به‌فرد تابلوی هوشمند طلالایو</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">طراحی شده بر اساس استانداردهای روز بازارهای بین‌المللی و صنف طلا و جواهر ایران</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="glass-card-gold p-7 rounded-3xl space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-lg">⚡</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">اتصال در ۶۰ ثانیه با بارکد QR</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    مرورگر تلویزیون را باز کنید، بارکد نمایش داده شده را با دوربین موبایل اسکن نمایید؛ صفحه فوراً متصل شده و نیاز به هیچ تنظیمات دیگری ندارد.
                </p>
            </div>

            <div class="glass-card-gold p-7 rounded-3xl space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-lg">💎</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">اسلایدشوی لوکس ویترین طلا</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    عکس النگوها، دستبندها و سرویس‌های خاص خود را همراه با مشخصات و بارکد پیج اینستاگرام گالری در کنار قیمت‌ها پخش کنید تا مشتریان در مغازه مجذوب محصولات شوند.
                </p>
            </div>

            <div class="glass-card-gold p-7 rounded-3xl space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-lg">🧮</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">فرمول‌ساز سود و اجرت فروشگاهی</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    آیا می‌خواهید نرخ طلای ۱۸ عیار با احتساب سود یا اجرت مشخصی روی تابلو برود؟ با سیستم فرمول‌ساز، محاسبات به صورت بلادرنگ و خودکار انجام می‌شود.
                </p>
            </div>

            <div class="glass-card-gold p-7 rounded-3xl space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-lg">📡</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">کارکرد آفلاین هوشمند (Offline Shield)</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    اگر اینترنت گالری برای چند ساعت قطع شود، صفحه تلویزیون سیاه نمی‌شود؛ بلکه آخرین نرخ‌های دریافتی را با ثبت ساعت دقیق بروزرسانی به همراه ویترین حفظ می‌کند.
                </p>
            </div>

            <div class="glass-card-gold p-7 rounded-3xl space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-lg">🛡️</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">جلوگیری از ماندگاری تصویر (Burn-In Protection)</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    الگوریتم‌های حرکتی ملایم و چرخش اسلایدها در طلالایو به نحوی طراحی شده‌اند که پیکسل‌های تلویزیون شما حتی در کارکرد مداوم ۱۰ ساعته روزانه دچار سوختگی یا سایه نشوند.
                </p>
            </div>

            <div class="glass-card-gold p-7 rounded-3xl space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-lg">📱</div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">مدیریت کامل از گوشی یا لپ‌تاپ</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    هر تغییری در آیتم‌های نمایش، مخفی‌سازی قیمت ارز، تغییر ترتیب سکه‌ها یا افزودن محصول جدید را مستقیماً از گوشی همراه خود در چند ثانیه اعمال کنید.
                </p>
            </div>
        </div>
    </div>

    {{-- سوالات متداول --}}
    <div class="space-y-6 max-w-4xl mx-auto">
        <div class="text-center space-y-2">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">سوالات متداول درباره تابلوی هوشمند طلافروشی</h2>
        </div>

        <div class="space-y-4">
            <div class="glass-panel p-6 rounded-2xl space-y-2 border border-slate-200 dark:border-slate-800">
                <h3 class="font-bold text-amber-600 dark:text-amber-400 text-sm sm:text-base">آیا تلویزیون باید دائماً به اینترنت وصل باشد؟</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    برای دریافت تغییرات نرخ‌ها به اینترنت نیاز است، اما حجم مصرفی سامانه طلالایو بسیار ناچیز است (کمتر از چند مگابایت در روز). همچنین در صورت قطعی اینترنت، سیستم به شکل آفلاین کار خواهد کرد.
                </p>
            </div>

            <div class="glass-panel p-6 rounded-2xl space-y-2 border border-slate-200 dark:border-slate-800">
                <h3 class="font-bold text-amber-600 dark:text-amber-400 text-sm sm:text-base">اگر برق مغازه قطع شود، بعد از روشن شدن تلویزیون چه می‌شود؟</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    اطلاعات اتصال تلویزیون در حافظه مرورگر آن ذخیره شده است. به محض روشن شدن تلویزیون و باز کردن مرورگر، بدون نیاز به اسکن مجدد بارکد، تابلوی گالری شما بالا می‌آید.
                </p>
            </div>

            <div class="glass-panel p-6 rounded-2xl space-y-2 border border-slate-200 dark:border-slate-800">
                <h3 class="font-bold text-amber-600 dark:text-amber-400 text-sm sm:text-base">آیا می‌توانیم فونت و رنگ‌ها را طبق سلیقه خود تغییر دهیم؟</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    قالب استاندارد طلالایو بر اساس بالاترین کنتراست نوری تنظیم شده تا از فاصله دور نیز ارقام کاملاً خوانا باشند. همچنین گزینه‌های سفارشی‌سازی رنگ در پنل تنظیمات در دسترس است.
                </p>
            </div>
        </div>
    </div>

    {{-- بنر دعوت به اقدام نهایی --}}
    <div class="rounded-3xl p-8 sm:p-12 bg-gradient-to-r from-amber-500/15 via-amber-500/5 to-blue-500/10 dark:from-amber-500/20 dark:via-slate-900 dark:to-blue-600/20 border border-amber-500/30 text-center space-y-6">
        <h2 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white">
            تلویزیون ویترین خود را به مدرن‌ترین تابلوی طلا تبدیل کنید
        </h2>
        <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
            ثبت‌نام رایگان است. تابلوی اختصاصی خود را بسازید و اعتبار و جلوه بصری مغازه طلافروشی‌تان را متحول نمایید.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('admin.register') }}" class="px-8 py-3.5 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-sm transition-all hover:scale-105 shadow-xl shadow-amber-500/20">
                شروع فوری و ثبت‌نام گالری
            </a>
            <a href="tel:09187009064" class="px-8 py-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-white font-bold text-sm transition-all shadow-sm">
                تماس با واحد پشتیبانی: ۰۹۱۸۷۰۰۹۰۶۴
            </a>
        </div>
    </div>

</div>
@endsection
