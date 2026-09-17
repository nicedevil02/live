<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#020617">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <title>پیش‌نمایش زنده تابلوی طلافروشی — تست آنلاین بدون ثبت‌نام | طلالایو</title>
    <meta name="description" content="پیش‌نمایش زنده و آنلاین تابلوی هوشمند نرخ طلا و سکه روی تلویزیون. بدون نیاز به ثبت‌نام و خرید سخت‌افزار، تابلوی دیجیتال ویترین را همین حالا امتحان کنید.">
    <link rel="canonical" href="https://talalive.ir/demo">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    @vite('resources/css/app.css')
    <script defer src="{{ asset('vendor/alpinejs.min.js') }}"></script>

    {{-- اسکیما ساختاریافته نرم‌افزار ابری --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "SoftwareApplication",
        "name": "پیش‌نمایش زنده تابلوی طلالایو",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "Smart TV, Web, Android TV, Tizen, webOS",
        "url": "https://talalive.ir/demo",
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
    }
    </script>
    <style>
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 15px rgba(245, 158, 11, 0.3); }
            50% { box-shadow: 0 0 30px rgba(245, 158, 11, 0.6); }
        }
        .glow-cta {
            animation: pulseGlow 2.5s infinite;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 font-['Vazirmatn'] min-h-screen flex flex-col antialiased selection:bg-amber-500 selection:text-slate-950" x-data="demoDisplayApp(@js($snapshot))">

    {{-- نوار فوقانی بنر تست زنده و دکمه اصلی ساخت تابلو --}}
    <header class="sticky top-0 z-50 bg-slate-900/95 border-b border-amber-500/30 backdrop-blur-xl px-4 py-3 shadow-2xl">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
            {{-- عنوان و نشان زنده --}}
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <span class="w-8 h-8 rounded-xl bg-gradient-to-tr from-amber-500 to-yellow-400 flex items-center justify-center text-slate-950 font-black text-sm shadow-md group-hover:scale-105 transition-transform">TL</span>
                    <span class="font-black text-lg text-white group-hover:text-amber-400 transition-colors">طلا<span class="text-amber-400">لایو</span></span>
                </a>
                <div class="hidden sm:flex items-center gap-2 border-r border-slate-700 pr-3 mr-1">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    <h1 class="text-xs lg:text-sm font-bold text-slate-200">پیش‌نمایش زنده تابلوی هوشمند طلافروشی</h1>
                </div>
            </div>

            {{-- لینک‌های سریع و راهنما --}}
            <div class="hidden md:flex items-center gap-4 text-xs font-semibold text-slate-300">
                <a href="{{ url('/') }}" class="hover:text-amber-400 transition-colors">صفحه اصلی</a>
                <a href="{{ url('/smart-gold-board') }}" class="hover:text-amber-400 transition-colors">تابلو هوشمند طلا</a>
                <a href="{{ url('/pricing') }}" class="hover:text-amber-400 transition-colors">تعرفه و اشتراک</a>
            </div>

            {{-- دکمه اکشن اصلی: تابلوی مغازه خودم را بساز --}}
            <div class="flex items-center gap-3">
                <span class="hidden lg:inline-block text-xs text-amber-300/90 font-medium">۱۴ روز تست ۱۰۰٪ رایگان</span>
                <a href="{{ route('admin.register') }}" 
                   class="glow-cta inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-yellow-500 text-slate-950 font-black text-xs sm:text-sm shadow-lg hover:brightness-110 active:scale-95 transition-all">
                    <span>تابلوی مغازه خودم را بساز</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                </a>
            </div>
        </div>
    </header>

    {{-- بدنه اصلی پیش‌نمایش تابلو --}}
    <main class="flex-1 flex flex-col p-3 md:p-6 max-w-7xl mx-auto w-full">

        {{-- کادر هدر معرفی داخل تابلو --}}
        <div class="mb-5 bg-gradient-to-r from-slate-900 via-slate-800/80 to-slate-900 border border-slate-700/60 rounded-2xl p-4 md:p-6 shadow-xl flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">حالت دمو — نرخ‌های بازار واقعی</span>
                    <span class="text-xs text-slate-400">آخرین بروزرسانی: {{ $lastUpdated ?? 'لحظه‌ای' }}</span>
                </div>
                <h2 class="text-xl md:text-2xl font-black text-white">گالری نمونه طلالایو (پیش‌نمایش تلویزیون طلافروشی)</h2>
                <p class="text-xs md:text-sm text-slate-300 mt-1">این تابلو روی مرورگر تلویزیون هوشمند مغازه شما (سامسونگ، ال‌جی، اندروید) با کیفیت ۴K و بدون نیاز به مینی‌کیس یا کابل‌کشی اجرا می‌شود.</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('admin.register') }}" class="px-4 py-2 rounded-xl bg-amber-500/20 text-amber-300 hover:bg-amber-500/30 border border-amber-500/40 text-xs font-bold transition-all">
                    ثبت‌نام مغازه و دریافت بارکد اختصاصی
                </a>
            </div>
        </div>

        {{-- گرید کارت‌های زنده قیمت --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3.5 mb-6">
            <template x-for="item in feed" :key="item.symbol">
                <div class="relative overflow-hidden rounded-2xl p-4 border transition-all duration-300 hover:scale-[1.02]"
                     :class="item.symbol === 'gold18' ? 'bg-gradient-to-br from-amber-950/60 via-slate-900 to-slate-900 border-amber-500/50 shadow-[0_0_20px_rgba(245,158,11,0.2)]' : 'bg-slate-900/90 border-slate-800 hover:border-slate-700 shadow-md'">
                    
                    {{-- هدر کارت --}}
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-300" x-text="item.name"></span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-mono font-bold"
                              :class="item.symbol === 'gold18' ? 'bg-amber-400/20 text-amber-300 border border-amber-400/30' : 'bg-slate-800 text-slate-400'"
                              x-text="item.unit"></span>
                    </div>

                    {{-- عدد قیمت لحظه‌ای --}}
                    <div class="flex items-baseline justify-between mt-1">
                        <span class="font-mono text-2xl lg:text-3xl font-black tracking-tight"
                              :class="item.symbol === 'gold18' ? 'text-amber-300' : 'text-white'"
                              x-text="formatNumber(item.value)"></span>
                    </div>

                    {{-- وضعیت زنده --}}
                    <div class="mt-2.5 flex items-center justify-between text-[11px] text-slate-400 pt-2 border-t border-slate-800/80">
                        <span class="flex items-center gap-1.5 text-emerald-400 font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                            <span>نرخ زنده تابلوی ابری</span>
                        </span>
                        <span class="font-mono text-[10px] text-slate-400">TalaLive Cloud</span>
                    </div>
                </div>
            </template>
        </div>

        {{-- بخش راهنمای راه‌اندازی سریع ۳ مرحله‌ای --}}
        <div class="mt-auto bg-slate-900/60 border border-slate-800 rounded-2xl p-5 mb-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-black text-lg border border-amber-500/30">⚡</div>
                    <div>
                        <h3 class="text-sm font-bold text-white">چگونه این تابلو را روی تلویزیون مغازه خود بالا بیاورید؟</h3>
                        <p class="text-xs text-slate-400">۱. ثبت‌نام رایگان در ۱ دقیقه • ۲. باز کردن talalive.ir در تلویزیون • ۳. اسکن کد جفت‌سازی با موبایل</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ url('/tv-setup-guide') }}" class="text-xs text-slate-300 hover:text-white underline underline-offset-4 transition-colors">
                        مشاهده راهنمای تصویری
                    </a>
                    <a href="{{ route('admin.register') }}" class="px-5 py-2.5 rounded-xl bg-amber-500 text-slate-950 font-black text-xs hover:bg-amber-400 transition-colors shadow-md">
                        ساخت تابلوی مغازه خودم
                    </a>
                </div>
            </div>
        </div>

    </main>

    {{-- فوتر عمومی و لینک‌های سئو --}}
    <footer class="bg-slate-950 border-t border-slate-800/80 py-5 px-4 text-center text-xs text-slate-400">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span>© ۱۴۰۵ تمامی حقوق محفوظ است —</span>
                <a href="{{ url('/') }}" class="text-amber-400 hover:underline font-bold">سامانه تابلوی طلالایو</a>
            </div>
            <div class="flex items-center gap-4 text-slate-300">
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
