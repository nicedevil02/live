<!DOCTYPE html>
<html lang="fa" dir="rtl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#141312">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <title>پیش‌نمایش زنده تابلوی طلافروشی | تست آنلاین بدون ثبت‌نام | طلالایو</title>
    <meta name="description" content="پیش‌نمایش زنده و آنلاین تابلوی هوشمند نرخ طلا و سکه روی تلویزیون. بدون نیاز به ثبت‌نام و خرید سخت‌افزار، تابلوی دیجیتال ویترین را همین حالا امتحان کنید.">
    <link rel="canonical" href="https://talalive.ir/demo">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    @vite('resources/css/app.css')
    <script defer src="{{ asset('vendor/alpinejs.min.js') }}"></script>

    {{-- اسکیما ساختاریافته نرم‌افزار ابری --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "پیش‌نمایش زنده تابلوی طلالایو",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "Smart TV, Web, Android TV, Tizen, webOS",
        "url": "https://talalive.ir/demo",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "IRR"
        },
        "publisher": {
            "@type": "Organization",
            "name": "طلالایو",
            "url": "https://talalive.ir"
        }
    }
    </script>
</head>
<body class="tl-public text-stone-100 min-h-screen flex flex-col antialiased selection:bg-amber-500 selection:text-stone-950" x-data="demoDisplayApp(@js($snapshot))">

    {{-- نوار فوقانی شیشه‌ای Apple HIG بنر تست زنده --}}
    <header class="sticky top-0 z-50 tl-glass-sheet border-b border-amber-500/25 px-4 py-3">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
            {{-- عنوان و نشان زنده --}}
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-xl tl-btn-bullion flex items-center justify-center font-black text-sm">TL</span>
                    <span class="font-black text-lg text-stone-100">طلا<span class="text-amber-400">لایو</span></span>
                </a>
                <div class="hidden sm:flex items-center gap-2 border-r border-stone-800 pr-3 mr-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 inline-block"></span>
                    <h1 class="text-xs lg:text-sm font-semibold text-stone-200">پیش‌نمایش زنده تابلوی هوشمند طلافروشی</h1>
                </div>
            </div>

            {{-- لینک‌های ناوبری سریع در ریل کوپرتینو --}}
            <div class="hidden md:flex items-center gap-1.5 p-1 rounded-xl tl-neu-track text-xs font-semibold text-stone-300">
                <a href="{{ url('/') }}" class="px-3 py-1.5 rounded-lg hover:text-amber-400 transition-colors">صفحه اصلی</a>
                <a href="{{ url('/smart-gold-board') }}" class="px-3 py-1.5 rounded-lg hover:text-amber-400 transition-colors">تابلو هوشمند طلا</a>
                <a href="{{ url('/pricing') }}" class="px-3 py-1.5 rounded-lg hover:text-amber-400 transition-colors">تعرفه و اشتراک</a>
            </div>

            {{-- دکمه اکشن اصلی شمش طلا --}}
            <div class="flex items-center gap-3">
                <span class="hidden lg:inline-block text-xs text-amber-300 font-bold">۱۴ روز تست رایگان</span>
                <a href="{{ route('admin.register') }}" 
                   class="min-h-11 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl tl-btn-bullion font-bold text-xs sm:text-sm">
                    <span>تابلوی مغازه خودم را بساز</span>
                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
                </a>
            </div>
        </div>
    </header>

    {{-- بدنه اصلی پیش‌نمایش تابلو --}}
    <main class="relative flex-1 flex flex-col p-3 md:p-6 max-w-7xl mx-auto w-full">

        {{-- هاله نور مخفی استودیویی --}}
        <div class="tl-ambient-gold absolute top-2 left-1/2 -translate-x-1/2 w-[560px] h-[180px] rounded-full opacity-70" aria-hidden="true"></div>

        {{-- کادر شیشه‌ای هدر معرفی داخل تابلو --}}
        <div class="relative z-10 mb-6 tl-glass-deck rounded-3xl p-5 md:p-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <div class="flex flex-wrap items-center gap-2.5 mb-1.5">
                    <span class="px-3 py-0.5 rounded-full text-[11px] font-bold tl-glass-badge text-amber-300">حالت دمو: نرخ‌های بازار واقعی</span>
                    <span class="text-xs text-stone-400 tabular-nums">آخرین بروزرسانی: {{ $lastUpdated ?? 'لحظه‌ای' }}</span>
                </div>
                <h2 class="text-xl md:text-2xl font-black text-stone-50">گالری نمونه طلالایو (پیش‌نمایش تلویزیون طلافروشی)</h2>
                <p class="text-xs md:text-sm text-stone-300 mt-1">این تابلو روی مرورگر تلویزیون هوشمند مغازه شما (سامسونگ، ال‌جی، اندروید) با کیفیت 4K و بدون نیاز به مینی‌کیس اجرا می‌شود.</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('admin.register') }}" class="min-h-11 inline-flex items-center px-4 py-2.5 rounded-xl tl-neu-btn text-amber-400 text-xs font-bold">
                    ثبت‌نام مغازه و دریافت بارکد
                </a>
            </div>
        </div>

        {{-- گرید کارت‌های نئومورفیک زنده قیمت --}}
        <div class="relative z-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
            <template x-for="item in feed" :key="item.symbol">
                <div class="relative overflow-hidden rounded-2xl p-4 sm:p-5"
                     :class="item.symbol === 'gold18' ? 'tl-neu-card-gold' : 'tl-neu-card'">
                    
                    {{-- هدر کارت --}}
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="text-xs font-bold text-stone-200" x-text="item.name"></span>
                        <span class="text-[10px] px-2.5 py-0.5 rounded-lg font-bold tabular-nums"
                              :class="item.symbol === 'gold18' ? 'tl-glass-badge text-amber-300' : 'tl-neu-inset text-stone-300'"
                              x-text="item.unit"></span>
                    </div>

                    {{-- عدد قیمت لحظه‌ای --}}
                    <div class="flex items-baseline justify-between mt-1">
                        <span class="text-2xl lg:text-3xl font-black tracking-tight tabular-nums"
                              :class="item.symbol === 'gold18' ? 'text-amber-400' : 'text-stone-50'"
                              x-text="formatNumber(item.value)"></span>
                    </div>

                    {{-- وضعیت زنده --}}
                    <div class="mt-3 flex items-center justify-between text-[11px] text-stone-400 pt-2.5 border-t border-white/10">
                        <span class="flex items-center gap-1.5 text-emerald-400 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>نرخ زنده تابلوی ابری</span>
                        </span>
                        <span class="text-[10px] text-stone-400 tabular-nums">TalaLive Cloud</span>
                    </div>
                </div>
            </template>
        </div>

        {{-- بخش راهنمای راه‌اندازی ۳ مرحله‌ای نئومورفیک --}}
        <div class="relative z-10 mt-auto tl-neu-card rounded-3xl p-5 sm:p-6 mb-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl tl-neu-icon-orb text-amber-400 flex items-center justify-center shrink-0">
                        @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-5 h-5'])
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-stone-50">چگونه این تابلو را روی تلویزیون مغازه اجرا کنیم؟</h3>
                        <p class="text-xs text-stone-400 mt-0.5">۱. ثبت‌نام رایگان • ۲. باز کردن talalive.ir/tv در تلویزیون • ۳. اسکن کد جفت‌سازی با موبایل</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ url('/tv-setup-guide') }}" class="min-h-11 inline-flex items-center px-4 py-2 rounded-xl tl-neu-btn text-xs font-bold text-stone-200">
                        راهنمای تصویری اتصال
                    </a>
                    <a href="{{ route('admin.register') }}" class="min-h-11 inline-flex items-center px-5 py-2.5 rounded-xl tl-btn-bullion font-bold text-xs">
                        ساخت تابلوی مغازه
                    </a>
                </div>
            </div>
        </div>

    </main>

    {{-- فوتر عمومی و لینک‌های سئو --}}
    <footer class="border-t border-white/10 py-5 px-4 text-center text-xs text-stone-400">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span>© ۱۴۰۵ تمامی حقوق محفوظ است:</span>
                <a href="{{ url('/') }}" class="text-amber-400 hover:underline font-semibold">سامانه تابلوی طلالایو</a>
            </div>
            <div class="flex items-center gap-4 text-stone-300 flex-wrap">
                <a href="{{ url('/smart-gold-board') }}" class="hover:text-amber-400 transition-colors">تابلو هوشمند طلا</a>
                <a href="{{ url('/led-vs-smart-board') }}" class="hover:text-amber-400 transition-colors">مقایسه با تابلو LED</a>
                <a href="{{ url('/pricing') }}" class="hover:text-amber-400 transition-colors">تعرفه و قیمت</a>
                <a href="{{ url('/about') }}" class="hover:text-amber-400 transition-colors">درباره ما</a>
                <a href="{{ url('/contact') }}" class="hover:text-amber-400 transition-colors">تماس با پشتیبانی</a>
            </div>
        </div>
    </footer>

    <script>
        function demoDisplayApp(initialSnapshot) {
            return {
                snapshot: initialSnapshot,
                feed: initialSnapshot.priceFeed || [],
                formatNumber(val) {
                    if (!val) return '---';
                    return new Intl.NumberFormat('fa-IR').format(Math.round(val));
                }
            };
        }
    </script>
</body>
</html>
