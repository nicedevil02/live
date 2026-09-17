@extends('layouts.public')

@section('title', 'دانلود اپلیکیشن طلالایو — تابلوی طلافروشی برای اندروید و تلویزیون هوشمند')
@section('meta_desc', 'دانلود اپلیکیشن اندروید و اندروید تی‌وی طلالایو. مدیریت آنلاین تابلوی طلا، اتصال هوشمند به تلویزیون مغازه بدون کابل، و استعلام زنده مظنه و سکه در گوشی.')
@section('canonical', 'https://talalive.ir/app')

@push('styles')
<style>
    .app-badge-btn {
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .app-badge-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.2);
    }
</style>
@endpush

@section('content')
<div class="py-12 bg-slate-900 text-slate-100 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm text-slate-400 mb-8 space-x-2 space-x-reverse" aria-label="مسیر راهنما">
            <a href="/" class="hover:text-amber-400 transition-colors">صفحه اصلی</a>
            <span>/</span>
            <span class="text-amber-400">دانلود اپلیکیشن طلالایو</span>
        </nav>

        <!-- Hero Section -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center mb-16">
            <div class="lg:col-span-7 text-right">
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30 mb-4">
                    نسخه همراه و تلویزیون هوشمند طلالایو
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-6 leading-tight">
                    دانلود اپلیکیشن هوشمند طلالایو | کنترل تابلوی طلا و مشاهده لحظه‌ای نرخ‌ها
                </h1>
                <p class="text-lg text-slate-300 mb-8 leading-relaxed">
                    با اپلیکیشن طلالایو، مدیریت کامل تابلوی قیمت طلافروشی و ویترین دیجیتال همیشه در دستان شماست. بدون نیاز به کامپیوتر یا کابل‌کشی، با گوشی خود تلویزیون مغازه را تنظیم کنید و در هر لحظه مظنه مثقال و قیمت سکه را به مشتریان نمایش دهید.
                </p>

                <!-- <!-- TODO(data): لینک استورها --> -->
                <!-- Download Badges / Store Links -->
                <div class="space-y-4">
                    <h2 class="text-base font-semibold text-slate-300">دریافت مستقیم و استورهای معتبر:</h2>
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- بازار (Bazaar) -->
                        <button onclick="scrollToNotify('کافه بازار')" class="app-badge-btn flex items-center gap-3 px-5 py-3 bg-slate-800 hover:bg-slate-700/90 border border-slate-700 rounded-xl text-white shadow-lg text-right">
                            <span class="text-2xl">🟢</span>
                            <div>
                                <span class="block text-[11px] text-slate-400">دانلود از</span>
                                <span class="block text-sm font-bold text-emerald-400">کافه بازار</span>
                            </div>
                            <span class="mr-2 text-[10px] px-2 py-0.5 bg-emerald-500/20 text-emerald-300 rounded">به‌زودی</span>
                        </button>

                        <!-- مایکت (Myket) -->
                        <button onclick="scrollToNotify('مایکت')" class="app-badge-btn flex items-center gap-3 px-5 py-3 bg-slate-800 hover:bg-slate-700/90 border border-slate-700 rounded-xl text-white shadow-lg text-right">
                            <span class="text-2xl">🔵</span>
                            <div>
                                <span class="block text-[11px] text-slate-400">دانلود از</span>
                                <span class="block text-sm font-bold text-sky-400">مایکت</span>
                            </div>
                            <span class="mr-2 text-[10px] px-2 py-0.5 bg-sky-500/20 text-sky-300 rounded">به‌زودی</span>
                        </button>

                        <!-- دانلود مستقیم APK -->
                        <button onclick="scrollToNotify('دانلود مستقیم APK')" class="app-badge-btn flex items-center gap-3 px-5 py-3 bg-slate-800 hover:bg-slate-700/90 border border-slate-700 rounded-xl text-white shadow-lg text-right">
                            <span class="text-2xl">🤖</span>
                            <div>
                                <span class="block text-[11px] text-slate-400">دریافت مستقیم</span>
                                <span class="block text-sm font-bold text-amber-400">فایل APK اندروید</span>
                            </div>
                            <span class="mr-2 text-[10px] px-2 py-0.5 bg-amber-500/20 text-amber-300 rounded">به‌زودی</span>
                        </button>

                        <!-- وب اپلیکیشن PWA (سازگار با آیفون و ویندوز) -->
                        <a href="/admin/login" class="app-badge-btn flex items-center gap-3 px-5 py-3 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl font-bold shadow-lg text-right">
                            <span class="text-2xl">⚡</span>
                            <div>
                                <span class="block text-[11px] text-slate-900 font-normal">نسخه بدون نصب</span>
                                <span class="block text-sm font-black">وب‌اپلیکیشن (PWA)</span>
                            </div>
                            <span class="mr-1 text-[10px] px-2 py-0.5 bg-slate-950 text-amber-400 rounded">فعال</span>
                        </a>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">
                        * نسخه‌های استور در حال دریافت تاییدیه‌های نهایی هستند. جهت دریافت به محض انتشار رسمی، شماره خود را در فرم زیر ثبت فرمایید.
                    </p>
                </div>
            </div>

            <!-- Visual / Mockup Preview -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-full max-w-sm">
                    <!-- Glow effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-amber-500 to-amber-700 rounded-3xl blur-xl opacity-30"></div>
                    <!-- Mockup Phone Shell -->
                    <div class="relative bg-slate-800 border-4 border-slate-700 rounded-[2.5rem] p-4 shadow-2xl overflow-hidden">
                        <div class="flex justify-center mb-4">
                            <div class="w-20 h-4 bg-slate-900 rounded-full"></div>
                        </div>
                        <div class="bg-slate-950 rounded-2xl p-4 text-center border border-slate-800 space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-800 text-xs">
                                <span class="text-emerald-400 font-bold">● تابلوی متصل: سالن اصلی</span>
                                <span class="text-slate-400">طلالایو v2.4</span>
                            </div>
                            <div class="bg-slate-900/90 rounded-xl p-3 border border-amber-500/20 text-right">
                                <span class="text-xs text-slate-400 block mb-1">نرخ هر گرم طلای ۱۸ عیار</span>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-black text-amber-400">{{ number_format($rates['gold18'] ?: 3650000) }}</span>
                                    <span class="text-xs text-slate-400">تومان</span>
                                </div>
                            </div>
                            <div class="bg-slate-900/90 rounded-xl p-3 border border-slate-800 text-right">
                                <span class="text-xs text-slate-400 block mb-1">مظنه مثقال ۱۷ عیار تهران</span>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-black text-white">{{ number_format($rates['mesghal'] ?: 15800000) }}</span>
                                    <span class="text-xs text-slate-400">تومان</span>
                                </div>
                            </div>
                            <div class="bg-slate-900/90 rounded-xl p-3 border border-slate-800 text-right">
                                <span class="text-xs text-slate-400 block mb-1">سکه تمام طرح جدید (امامی)</span>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-black text-white">{{ number_format($rates['coin_emami'] ?: 43500000) }}</span>
                                    <span class="text-xs text-slate-400">تومان</span>
                                </div>
                            </div>
                            <div class="pt-2">
                                <a href="/demo" class="block w-full py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 text-xs font-black rounded-lg shadow">
                                    مشاهده دموی زنده تابلوی کامل
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key App Features -->
        <div class="mb-16">
            <h2 class="text-2xl sm:text-3xl font-bold text-center text-white mb-4">ویژگی‌های برجسته اپلیکیشن طلالایو</h2>
            <p class="text-center text-slate-300 max-w-2xl mx-auto mb-10 text-sm leading-relaxed">
                طراحی شده اختصاصی برای نیازهای روزمره طلافروشان و بنکداران سراسر کشور:
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-slate-800/80 border border-slate-700/70 rounded-2xl p-6 shadow-lg">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center text-2xl mb-4 border border-amber-500/20">
                        📺
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">جفت‌سازی فوری با تلویزیون</h3>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        کافیست کد چندرقمی نمایش‌یافته روی صفحه تلویزیون را در اپلیکیشن موبایل وارد کنید؛ صفحه تلویزیون بدون هیچ سیم و کابل متصل خواهد شد.
                    </p>
                </div>

                <div class="bg-slate-800/80 border border-slate-700/70 rounded-2xl p-6 shadow-lg">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-2xl mb-4 border border-blue-500/20">
                        📴
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">تاب‌آوری قطعی اینترنت</h3>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        در صورت اختلال مقطعی در اینترنت مغازه، تابلو خاموش نمی‌شود؛ آخرین نرخ معتبر با برچسب ساعت تا اتصال مجدد پایدار باقی می‌ماند.
                    </p>
                </div>

                <div class="bg-slate-800/80 border border-slate-700/70 rounded-2xl p-6 shadow-lg">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-2xl mb-4 border border-emerald-500/20">
                        💎
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">مدیریت ویترین و عکس جواهرات</h3>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        عکس النگوها و سرویس‌های طلا را همراه با درصد سود و اجرت از دوربین گوشی آپلود کنید تا در اسلایدر مجلل تلویزیون مغازه بدرخشند.
                    </p>
                </div>
            </div>
        </div>

        <!-- Waitlist / Notification Form Section -->
        <div id="notify-section" class="bg-gradient-to-br from-slate-800 via-slate-800/95 to-slate-900 border-2 border-amber-500/40 rounded-3xl p-8 sm:p-12 mb-16 shadow-2xl relative overflow-hidden">
            <div class="max-w-2xl mx-auto text-center">
                <span class="inline-block px-3.5 py-1 rounded-full text-xs font-bold bg-amber-400 text-slate-950 mb-4">
                    فرم پیش‌ثبت‌نام و اطلاع‌رسانی
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">
                    اولین نفری باشید که نسخه جدید را نصب می‌کند!
                </h2>
                <p class="text-slate-300 text-sm leading-relaxed mb-8">
                    شماره موبایل خود را ثبت کنید تا به محض تایید نهایی در استورها (بازار، مایکت و گوگل‌پلی) یا انتشار فایل APK، لینک مستقیم برایتان پیامک شود.
                </p>

                <form id="waitlist-form" onsubmit="handleWaitlistSubmit(event)" class="space-y-4 text-right">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="wl-name" class="block text-xs font-semibold text-slate-300 mb-1">نام یا نام گالری طلا</label>
                            <input type="text" id="wl-name" required placeholder="مثال: گالری کیان" class="w-full px-4 py-3 bg-slate-950 border border-slate-700 rounded-xl text-white placeholder-slate-500 text-sm focus:border-amber-400 focus:outline-none">
                        </div>
                        <div>
                            <label for="wl-mobile" class="block text-xs font-semibold text-slate-300 mb-1">شماره همراه (جهت ارسال پیامک لینک)</label>
                            <input type="tel" id="wl-mobile" required pattern="09[0-9]{9}" placeholder="۰۹۱۲۳۴۵۶۷۸۹" class="w-full px-4 py-3 bg-slate-950 border border-slate-700 rounded-xl text-white placeholder-slate-500 text-sm focus:border-amber-400 focus:outline-none direction-ltr text-right">
                        </div>
                    </div>

                    <div>
                        <label for="wl-platform" class="block text-xs font-semibold text-slate-300 mb-1">سیستم‌عامل یا دستگاه مورد استفاده</label>
                        <select id="wl-platform" class="w-full px-4 py-3 bg-slate-950 border border-slate-700 rounded-xl text-white text-sm focus:border-amber-400 focus:outline-none">
                            <option value="android_phone">گوشی اندروید (کافه بازار / مایکت)</option>
                            <option value="android_tv">تلویزیون هوشمند اندروید (Android TV / Mi Box)</option>
                            <option value="ios">گوشی آیفون (iOS / PWA)</option>
                            <option value="all">همه پلتفرم‌ها</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl text-base transition-colors shadow-lg">
                            ثبت در صف انتظار و ارسال لینک به محض انتشار
                        </button>
                    </div>
                </form>

                <div id="waitlist-success" class="hidden mt-6 p-4 bg-emerald-500/20 border border-emerald-500/40 rounded-xl text-emerald-300 text-sm text-center">
                    ✓ مشخصات شما با موفقیت ثبت شد. به محض انتشار در استورها، پیامک اطلاع‌رسانی برای شما ارسال خواهد شد.
                </div>
            </div>
        </div>

        <!-- TV App Dedicated Guide -->
        <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 sm:p-8 mb-12 shadow-xl">
            <h2 class="text-xl font-bold text-amber-400 mb-4">آیا برای تلویزیون مغازه به دانلود نرم‌افزار خاصی نیاز داریم؟</h2>
            <p class="text-slate-300 leading-relaxed text-sm mb-4">
                خیر! بزرگترین مزیت فناوری تحت‌وب طلالایو این است که تلویزیون‌های هوشمند سونی، تی‌سی‌ال، دوو، اسنوا، سامسونگ و ال‌جی بدون نیاز به نصب هیچ فایل یا نرم‌افزار خارجی، تنها از طریق مرورگر داخلی تلویزیون متصل می‌شوند.
            </p>
            <p class="text-slate-300 leading-relaxed text-sm mb-6">
                برای مطالعه آموزش گام به گام تنظیم مرورگر تلویزیون و اجرای دائمی در حالت فول‌اسکرین، به راهنماهای تخصصی زیر مراجعه فرمایید:
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="/tv-setup-guide" class="text-xs px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">
                    راهنمای جامع اتصال تلویزیون
                </a>
                <a href="/android-tv-gold-board" class="text-xs px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">
                    تنظیمات اندروید باکس و اندروید تی‌وی
                </a>
                <a href="/smart-gold-board" class="text-xs px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">
                    معرفی کامل تابلوی هوشمند طلا
                </a>
                <a href="/pricing" class="text-xs px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-colors">
                    تعرفه‌های اشتراک سالانه
                </a>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-slate-800/70 border border-slate-700/60 rounded-2xl p-6 sm:p-8 mb-12 shadow-xl">
            <h2 class="text-2xl font-bold text-white mb-6">سؤالات متداول درباره اپلیکیشن طلالایو</h2>
            <div class="space-y-6 text-slate-300">
                <div>
                    <h3 class="text-base font-semibold text-amber-400 mb-2">۱. آیا استفاده از اپلیکیشن هزینه جداگانه دارد؟</h3>
                    <p class="text-sm leading-relaxed">
                        خیر؛ با تهیه هر یک از پلن‌های اشتراک طلالایو، دسترسی به پنل اپلیکیشن موبایل، مدیریت تابلو و به‌روزرسانی‌ها کاملاً رایگان خواهد بود.
                    </p>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-amber-400 mb-2">۲. چگونه می‌توانم بدون استور، نسخه تحت وب را در گوشی ذخیره کنم؟</h3>
                    <p class="text-sm leading-relaxed">
                        کافیست با مرورگر گوشی وارد آدرس <a href="/admin/login" class="text-amber-400 underline">talalive.ir/admin/login</a> شوید و گزینه «Add to Home screen» (افزودن به صفحه اصلی) را انتخاب فرمایید تا آیکون اپلیکیشن همانند برنامه‌های معمولی روی صفحه گوشی ظاهر شود.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function scrollToNotify(platform) {
    const notifySec = document.getElementById('notify-section');
    if (notifySec) {
        notifySec.scrollIntoView({ behavior: 'smooth' });
    }
    const sel = document.getElementById('wl-platform');
    if (sel && platform) {
        if (platform.includes('اندروید') || platform.includes('بازار') || platform.includes('مایکت')) {
            sel.value = 'android_phone';
        }
    }
}

function handleWaitlistSubmit(e) {
    e.preventDefault();
    document.getElementById('waitlist-form').classList.add('hidden');
    document.getElementById('waitlist-success').classList.remove('hidden');
}
</script>

<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "SoftwareApplication",
      "@@id": "https://talalive.ir/app#software",
      "name": "اپلیکیشن طلالایو",
      "operatingSystem": "Android, iOS, Web",
      "applicationCategory": "BusinessApplication",
      "description": "نرم‌افزار هوشمند مدیریت تابلوی طلافروشی و استعلام لحظه‌ای مظنه آبشده و سکه.",
      "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "IRR"
      },
      "publisher": {
        "@@type": "Organization",
        "name": "طلالایو",
        "url": "https://talalive.ir"
      }
    },
    {
      "@@type": "FAQPage",
      "@@id": "https://talalive.ir/app#faq",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "آیا استفاده از اپلیکیشن هزینه جداگانه دارد؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "خیر؛ دسترسی به اپلیکیشن همراه با اشتراک تابلوی طلالایو کاملاً رایگان است."
          }
        },
        {
          "@@type": "Question",
          "name": "آیا برای تلویزیون مغازه به دانلود نرم‌افزار نیاز داریم؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "خیر، تلویزیون‌های هوشمند مستقیماً از طریق مرورگر اینترنت متصل می‌شوند."
          }
        }
      ]
    }
  ]
}
</script>
@endsection
