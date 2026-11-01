<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0c0a09">
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
<body class="tl-public bg-stone-950 text-stone-100 min-h-screen flex flex-col antialiased selection:bg-amber-500 selection:text-stone-950" x-data="demoDisplayApp(@js($snapshot))">

    {{-- نوار فوقانی بنر تست زنده --}}
    <header class="sticky top-0 z-50 bg-stone-900 border-b border-amber-500/30 px-4 py-3 shadow-md">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
            {{-- عنوان و نشان زنده --}}
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-amber-500 flex items-center justify-center text-stone-950 font-bold text-sm">TL</span>
                    <span class="font-bold text-lg text-stone-100">طلا<span class="text-amber-400">لایو</span></span>
                </a>
                <div class="hidden sm:flex items-center gap-2 border-r border-stone-800 pr-3 mr-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                    <h1 class="text-xs lg:text-sm font-semibold text-stone-200">پیش‌نمایش زنده تابلوی هوشمند طلافروشی</h1>
                </div>
            </div>

            {{-- لینک‌های ناوبری سریع --}}
            <div class="hidden md:flex items-center gap-4 text-xs font-semibold text-stone-300">
                <a href="{{ url('/') }}" class="hover:text-amber-400 transition-colors">صفحه اصلی</a>
                <a href="{{ url('/smart-gold-board') }}" class="hover:text-amber-400 transition-colors">تابلو هوشمند طلا</a>
                <a href="{{ url('/pricing') }}" class="hover:text-amber-400 transition-colors">تعرفه و اشتراک</a>
            </div>

            {{-- دکمه اکشن اصلی --}}
            <div class="flex items-center gap-3">
                <span class="hidden lg:inline-block text-xs text-amber-300 font-semibold">۱۴ روز تست رایگان</span>
                <a href="{{ route('admin.register') }}" 
                   class="min-h-11 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-xs sm:text-sm transition-colors shadow-xs">
                    <span>تابلوی مغازه خودم را بساز</span>
                    <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </header>

    {{-- بدنه اصلی پیش‌نمایش تابلو --}}
    <main class="flex-1 flex flex-col p-3 md:p-6 max-w-7xl mx-auto w-full">

        {{-- کادر هدر معرفی داخل تابلو --}}
        <div class="mb-5 bg-stone-900 border border-stone-800 rounded-2xl p-4 md:p-6 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-amber-500/20 text-amber-300 border border-amber-500/30">حالت دمو: نرخ‌های بازار واقعی</span>
                    <span class="text-xs text-stone-400 font-mono tabular-nums">آخرین بروزرسانی: {{ $lastUpdated ?? 'لحظه‌ای' }}</span>
                </div>
                <h2 class="text-xl md:text-2xl font-bold text-stone-50">گالری نمونه طلالایو (پیش‌نمایش تلویزیون طلافروشی)</h2>
                <p class="text-xs md:text-sm text-stone-300 mt-1">این تابلو روی مرورگر تلویزیون هوشمند مغازه شما (سامسونگ، ال‌جی، اندروید) با کیفیت 4K و بدون نیاز به مینی‌کیس اجرا می‌شود.</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('admin.register') }}" class="min-h-11 inline-flex items-center px-4 py-2 rounded-xl bg-stone-800 hover:bg-stone-700 text-amber-400 border border-stone-700 text-xs font-semibold transition-colors">
                    ثبت‌نام مغازه و دریافت بارکد
                </a>
            </div>
        </div>

        {{-- گرید کارت‌های زنده قیمت --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3.5 mb-6">
            <template x-for="item in feed" :key="item.symbol">
                <div class="relative overflow-hidden rounded-2xl p-4 border transition-colors duration-150"
                     :class="item.symbol === 'gold18' ? 'bg-stone-900 border-amber-500/50 shadow-xs' : 'bg-stone-900 border-stone-800 shadow-xs'">
                    
                    {{-- هدر کارت --}}
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-stone-300" x-text="item.name"></span>
                        <span class="text-[10px] px-2 py-0.5 rounded-md font-mono font-bold"
                              :class="item.symbol === 'gold18' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-stone-800 text-stone-400'"
                              x-text="item.unit"></span>
                    </div>

                    {{-- عدد قیمت لحظه‌ای --}}
                    <div class="flex items-baseline justify-between mt-1">
                        <span class="font-mono text-2xl lg:text-3xl font-bold tracking-tight tabular-nums"
                              :class="item.symbol === 'gold18' ? 'text-amber-400' : 'text-stone-50'"
                              x-text="formatNumber(item.value)"></span>
                    </div>

                    {{-- وضعیت زنده --}}
                    <div class="mt-2.5 flex items-center justify-between text-[11px] text-stone-400 pt-2 border-t border-stone-800">
                        <span class="flex items-center gap-1.5 text-emerald-400 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>نرخ زنده تابلوی ابری</span>
                        </span>
                        <span class="font-mono text-[10px] text-stone-400">TalaLive Cloud</span>
                    </div>
                </div>
            </template>
        </div>

        {{-- بخش راهنمای راه‌اندازی ۳ مرحله‌ای --}}
        <div class="mt-auto bg-stone-900 border border-stone-800 rounded-2xl p-5 mb-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-lg border border-amber-500/30">
                        @include('partials.ui-icon', ['name' => 'bolt', 'class' => 'w-5 h-5'])
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-stone-50">چگونه این تابلو را روی تلویزیون مغازه اجرا کنیم؟</h3>
                        <p class="text-xs text-stone-400">۱. ثبت‌نام رایگان • ۲. باز کردن talalive.ir در تلویزیون • ۳. اسکن کد جفت‌سازی با موبایل</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ url('/tv-setup-guide') }}" class="min-h-11 inline-flex items-center px-4 py-2 text-xs text-stone-300 hover:text-white underline underline-offset-4 transition-colors">
                        راهنمای تصویری اتصال
                    </a>
                    <a href="{{ route('admin.register') }}" class="min-h-11 inline-flex items-center px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-xs transition-colors shadow-xs">
                        ساخت تابلوی مغازه
                    </a>
                </div>
            </div>
        </div>

    </main>

    {{-- فوتر عمومی و لینک‌های سئو --}}
    <footer class="bg-stone-950 border-t border-stone-800 py-5 px-4 text-center text-xs text-stone-400">
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
