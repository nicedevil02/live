<!DOCTYPE html>
<html lang="fa" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#020617">

    {{-- اسکریپت اولیه تعیین تم: دیفالت روی حالت روشن است مگر اینکه کاربر قبلاً تم تاریک را انتخاب کرده باشد --}}
    <script>
        (function() {
            const savedTheme = localStorage.getItem('talalive_theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();

        function toggleAppTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('talalive_theme', isDark ? 'dark' : 'light');
            window.dispatchEvent(new CustomEvent('talalive-theme-changed', { detail: { isDark } }));
        }
    </script>

    <title>@yield('title', 'طلالایو | تابلوی هوشمند طلافروشی و نمایشگر نرخ مغازه طلا فروشی')</title>
    <meta name="description" content="@yield('meta_description', 'سامانه ابری تابلوی هوشمند طلافروشی و نمایشگر آنلاین نرخ لحظه ای طلا و سکه برای مغازه طلا فروشی. اتصال تلویزیون بدون نیاز به کیس، فرمول‌ساز سود و ویترین لوکس در طلالایو.')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1')">
    <meta name="author" content="طلالایو - TalaLive">
    <link rel="canonical" href="@yield('canonical', 'https://talalive.ir' . (request()->getPathInfo() === '/' ? '' : request()->getPathInfo()))">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'سامانه هوشمند تابلوی طلافروشی و نمایشگر طلا فروشی | طلالایو')">
    <meta property="og:description" content="@yield('meta_description', 'سامانه ابری تابلوی هوشمند نرخ لحظه ای طلا، سکه و ارز ویژه تلویزیون مغازه‌های طلافروشی و طلا فروشی‌ها.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="طلالایو">
    <meta property="og:image" content="@yield('og_image', asset('images/og-cover.png'))">
    <meta property="og:image:secure_url" content="@yield('og_image', asset('images/og-cover.png'))">
    <meta property="og:image:width" content="@yield('og_image_width', '1200')">
    <meta property="og:image:height" content="@yield('og_image_height', '630')">
    <meta property="og:image:type" content="@yield('og_image_type', 'image/png')">
    <meta property="og:image:alt" content="@yield('og_image_alt', 'سامانه ابری تابلوی هوشمند نرخ لحظه‌ای طلا و سکه طلالایو')">
    <meta property="og:locale" content="fa_IR">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'سامانه هوشمند تابلوی طلافروشی و نمایشگر طلا فروشی | طلالایو')">
    <meta name="twitter:description" content="@yield('meta_description', 'نمایش آنلاین و لحظه ای نرخ طلا و مسکوکات روی تلویزیون مغازه طلافروشی و طلا فروشی بدون مینی‌کیس.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-cover.png'))">
    <meta name="twitter:image:alt" content="@yield('og_image_alt', 'سامانه ابری تابلوی هوشمند نرخ لحظه‌ای طلا و سکه طلالایو')">

    <!-- Schema.org Global Graph (Organization + WebSite) -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "Organization",
          "@@id": "https://talalive.ir/#organization",
          "name": "طلالایو (TalaLive)",
          "alternateName": [
            "سامانه ابری تابلوی هوشمند طلافروشی",
            "تابلوی طلا فروشی",
            "تابلو طلا فروشی",
            "نرم افزار تابلوی طلا فروشی",
            "تابلو انلاین طلا فروشی",
            "نمایشگر نرخ طلا فروشی",
            "اعلام نرخ لحظه ای طلا و سکه"
          ],
          "url": "https://talalive.ir",
          "logo": "https://talalive.ir/images/logo.png",
          "sameAs": @json(config('app.organization.same_as', ['https://rubika.ir/talalive'])),
          "address": {
            "@@type": "PostalAddress",
            "addressLocality": "{{ config('app.organization.address.locality', 'همدان') }}",
            "addressRegion": "{{ config('app.organization.address.region', 'همدان') }}",
            "streetAddress": "{{ config('app.organization.address.street', 'راسته مظفریه') }}",
            "addressCountry": "{{ config('app.organization.address.country', 'IR') }}"
          },
          "foundingDate": "2024",
          "description": "سامانه ابری تابلوی هوشمند اعلام نرخ طلا، سکه و ارز و ویترین دیجیتال گالری‌های طلا و جواهر و مغازه طلا فروشی بدون نیاز به مینی‌کیس.",
          "contactPoint": [
            {
              "@@type": "ContactPoint",
              "telephone": "+989187009064",
              "contactType": "customer support",
              "areaServed": "IR",
              "availableLanguage": ["Persian"]
            },
            {
              "@@type": "ContactPoint",
              "telephone": "+988135223847",
              "contactType": "technical support",
              "areaServed": "IR",
              "availableLanguage": ["Persian"]
            }
          ]
        },
        {
          "@@type": "WebSite",
          "@@id": "https://talalive.ir/#website",
          "url": "https://talalive.ir",
          "name": "طلالایو | سامانه هوشمند تابلوی طلافروشی و طلا فروشی",
          "publisher": {
            "@@id": "https://talalive.ir/#organization"
          },
          "inLanguage": "fa-IR"
        }
      ]
    }
    </script>

    @yield('schema')

    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    @vite('resources/css/app.css')

    <!-- Alpine.js (Local) -->
    <script defer src="{{ asset('vendor/alpinejs.min.js') }}"></script>

    <style>
        html, body {
            max-width: 100%;
            overflow-x: clip;
        }
        @supports not (overflow-x: clip) {
            html, body {
                overflow-x: hidden;
            }
        }
        body {
            font-family: Vazirmatn, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f8fafc;
        }
        .dark body {
            background: #020617;
        }
        /* کنترل آیکون‌های تم به صورت خالص با CSS بدون باگ و بدون تاخیر */
        html.dark .theme-sun-icon { display: inline-block !important; }
        html.dark .theme-moon-icon { display: none !important; }
        html:not(.dark) .theme-sun-icon { display: none !important; }
        html:not(.dark) .theme-moon-icon { display: inline-block !important; }
        @keyframes pulse-glow {
            0%, 100% { transform: scale(1); opacity: 0.85; }
            50% { transform: scale(1.06); opacity: 1; }
        }
        .pulse-logo {
            animation: pulse-glow 3s ease-in-out infinite;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .dark .glass-panel {
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid rgba(51, 65, 85, 0.6);
        }
        .glass-card-gold {
            background: #ffffff;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04);
        }
        .dark .glass-card-gold {
            background: radial-gradient(circle at top right, rgba(245, 158, 11, 0.08), rgba(15, 23, 42, 0.7) 60%);
            border: 1px solid rgba(245, 158, 11, 0.2);
            box-shadow: none;
        }
        .glass-card-gold:hover {
            border-color: rgba(245, 158, 11, 0.45);
            box-shadow: 0 12px 35px -10px rgba(245, 158, 11, 0.15);
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#020617] text-slate-800 dark:text-slate-100 selection:bg-amber-500/30 selection:text-amber-700 dark:selection:text-amber-200 antialiased overflow-x-hidden min-h-screen flex flex-col justify-between transition-colors duration-300" x-data="publicLayoutHandler()">

    {{-- نوار ناوبری شیشه‌ای بالایی مدرن (Sticky Modern Header) --}}
    <header class="sticky top-0 z-50 w-full backdrop-blur-xl bg-white/85 dark:bg-slate-950/85 border-b border-slate-200/80 dark:border-slate-800/80 transition-all duration-300 shadow-sm dark:shadow-none">
        <div class="max-w-7xl mx-auto px-2.5 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-1.5 sm:gap-4">
            
            {{-- لوگو و نام برند --}}
            <a href="/" class="flex items-center gap-1.5 sm:gap-3 group shrink-0 min-w-0">
                <div class="relative shrink-0">
                    <img src="{{ asset('images/logo.png') }}" width="44" height="44" loading="eager" fetchpriority="high" decoding="async" class="h-8 w-8 sm:h-11 sm:w-11 object-contain pulse-logo rounded-xl sm:rounded-2xl shadow-md shadow-amber-500/10 bg-white dark:bg-slate-900/60 p-1 border border-slate-200 dark:border-slate-700/60" alt="لوگوی طلالایو">
                    <span class="absolute -bottom-0.5 -right-0.5 sm:-bottom-1 sm:-right-1 flex h-2.5 w-2.5 sm:h-3.5 sm:w-3.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 sm:h-3.5 sm:w-3.5 bg-amber-500"></span>
                    </span>
                </div>
                <div class="text-right">
                    <div class="text-sm sm:text-xl font-black text-slate-900 dark:text-transparent dark:bg-clip-text dark:bg-gradient-to-r dark:from-amber-200 dark:via-amber-400 dark:to-yellow-500 tracking-tight group-hover:text-amber-600 dark:group-hover:from-white dark:group-hover:to-amber-300 transition-all leading-tight">
                        <span>طلالایو</span><span class="hidden sm:inline"> &middot; <span class="font-bold text-amber-600 dark:text-amber-400">TalaLive</span></span>
                    </div>
                    <p class="hidden md:block text-[11px] text-slate-500 dark:text-slate-400 font-semibold tracking-wide">سامانه تابلوی هوشمند طلافروشی</p>
                </div>
            </a>

            {{-- نوار ناوبری کپسولی مدرن و جامع (Desktop Navigation) --}}
            <nav class="hidden lg:flex items-center gap-0.5 p-1 rounded-2xl bg-slate-100/90 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 text-xs font-bold text-slate-600 dark:text-slate-300">
                <a href="/" class="px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all {{ request()->is('/') ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                    صفحه اصلی
                </a>

                {{-- دراپ‌داون محصولات و تابلوها --}}
                <div class="relative" @mouseenter="productsDropdownOpen = true" @mouseleave="productsDropdownOpen = false">
                    <button type="button" @click="productsDropdownOpen = !productsDropdownOpen" class="flex items-center gap-1 px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all cursor-pointer {{ (request()->routeIs('public.smart-gold-board') || request()->routeIs('public.digital-rate-board') || request()->routeIs('public.gold-board-without-device') || request()->routeIs('public.online-gold-price-board') || request()->routeIs('public.currency-exchange-board') || request()->routeIs('public.silver-bullion-board') || request()->routeIs('public.demo') || request()->routeIs('public.app')) ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                        <span>سامانه‌ها</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="productsDropdownOpen ? 'rotate-180 text-amber-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="productsDropdownOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute right-0 mt-2 w-72 rounded-2xl bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl p-2 z-50 space-y-1">
                        
                        <a href="{{ route('public.smart-gold-board') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">💎</span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">تابلوی هوشمند طلافروشی</div>
                                <div class="text-[10px] text-slate-400">نمایش آنلاین نرخ روی تلویزیون مغازه</div>
                            </div>
                        </a>

                        <a href="{{ route('public.digital-rate-board') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">🖥️</span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">تابلو دیجیتال طلا و ارز</div>
                                <div class="text-[10px] text-slate-400">مانیتور نرخ لحظه‌ای طلا و صرافی</div>
                            </div>
                        </a>

                        <a href="{{ route('public.gold-board-without-device') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">☁️</span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">تابلو بدون نیاز به دستگاه</div>
                                <div class="text-[10px] text-slate-400">حذف کامل هزینه‌های سخت‌افزاری</div>
                            </div>
                        </a>

                        <a href="{{ route('public.online-gold-price-board') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">⚡</span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">تابلو آنلاین قیمت طلا</div>
                                <div class="text-[10px] text-slate-400">به‌روزرسانی خودکار نرخ‌های صنفی</div>
                            </div>
                        </a>

                        <a href="{{ route('public.currency-exchange-board') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">💱</span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">تابلو نرخ ارز صرافی</div>
                                <div class="text-[10px] text-slate-400">ویژه صرافی‌ها و مراکز ارزی</div>
                            </div>
                        </a>

                        <a href="{{ route('public.silver-bullion-board') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">🥈</span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">تابلو نقره و شمش</div>
                                <div class="text-[10px] text-slate-400">پوشش کامل شمش و گرم نقره</div>
                            </div>
                        </a>

                        <div class="pt-1 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between px-2">
                            <a href="{{ route('public.demo') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:underline">پیش‌نمایش زنده</a>
                            <a href="{{ route('public.app') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">دانلود اپلیکیشن</a>
                        </div>
                    </div>
                </div>

                {{-- دراپ‌داون مقایسه --}}
                <div class="relative" @mouseenter="compareDropdownOpen = true" @mouseleave="compareDropdownOpen = false">
                    <button type="button" @click="compareDropdownOpen = !compareDropdownOpen" class="flex items-center gap-1 px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all cursor-pointer {{ (request()->routeIs('public.led-vs-smart-board') || request()->routeIs('public.compare.*')) ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                        <span>مقایسه‌ها</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="compareDropdownOpen ? 'rotate-180 text-amber-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="compareDropdownOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute right-0 mt-2 w-64 rounded-2xl bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl p-2 z-50 space-y-1">
                        
                        <a href="{{ route('public.led-vs-smart-board') }}" class="block p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">مقایسه با تابلوهای LED روان</div>
                            <div class="text-[10px] text-slate-400">بررسی اقتصادی و هزینه‌ها</div>
                        </a>

                        <a href="{{ route('public.compare.tabangohar') }}" class="block p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">مقایسه با تابان گوهر</div>
                            <div class="text-[10px] text-slate-400">تفاوت سامانه ابری با مینی‌کیس</div>
                        </a>

                        <a href="{{ route('public.compare.tgju-tv') }}" class="block p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">مقایسه با TGJU TV</div>
                            <div class="text-[10px] text-slate-400">تخصصی بودن و پشتیبانی صنف طلا</div>
                        </a>

                        <a href="{{ route('public.compare.tablotala') }}" class="block p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">مقایسه با تابلوطلا</div>
                            <div class="text-[10px] text-slate-400">تحت وب در برابر نرم‌افزار نصبی</div>
                        </a>
                    </div>
                </div>

                {{-- دراپ‌داون ابزارها --}}
                <div class="relative" @mouseenter="toolsDropdownOpen = true" @mouseleave="toolsDropdownOpen = false">
                    <button type="button" @click="toolsDropdownOpen = !toolsDropdownOpen" class="flex items-center gap-1 px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all cursor-pointer {{ (request()->is('tools/*') || request()->routeIs('public.gold-calculator')) ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                        <span>ابزارها</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="toolsDropdownOpen ? 'rotate-180 text-amber-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="toolsDropdownOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute right-0 mt-2 w-72 rounded-2xl bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl p-2 z-50 space-y-1">
                        
                        <a href="{{ route('public.gold-calculator') }}" class="flex items-center gap-2.5 p-2 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 group transition-all font-bold text-amber-700 dark:text-amber-300">
                            <span class="text-sm">🧮</span>
                            <div class="text-xs font-bold">هاب جامع ماشین‌حساب‌های طلا</div>
                        </a>

                        <a href="{{ route('public.tools.gold-price') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">💰</span>
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">محاسبه قیمت طلا با اجرت و سود</div>
                        </a>

                        <a href="{{ route('public.tools.wage-calculator') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">🔨</span>
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">ماشین‌حساب اجرت ساخت طلا</div>
                        </a>

                        <a href="{{ route('public.tools.second-hand-gold') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">♻️</span>
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">محاسبه طلای دست دوم و متفرقه</div>
                        </a>

                        <a href="{{ route('public.tools.coin-bubble') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">🪙</span>
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">محاسبه‌گر حباب انواع سکه</div>
                        </a>

                        <a href="{{ route('public.tools.mesghal') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">⚖️</span>
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">تبدیل مظنه مثقال به گرم ۱۸ عیار</div>
                        </a>

                        <a href="{{ route('public.tools.melted-gold') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">🔥</span>
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">محاسبه طلای آبشده و عیار انگ</div>
                        </a>

                        <a href="{{ route('public.tools.karat-converter') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">🔄</span>
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">تبدیل عیارهای طلا (۷۵۰، ۷۰۵...)</div>
                        </a>
                    </div>
                </div>

                {{-- دراپ‌داون آموزش و شهرها --}}
                <div class="relative" @mouseenter="guidesDropdownOpen = true" @mouseleave="guidesDropdownOpen = false">
                    <button type="button" @click="guidesDropdownOpen = !guidesDropdownOpen" class="flex items-center gap-1 px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all cursor-pointer {{ (request()->routeIs('public.guides*') || request()->routeIs('public.tv-setup-guide') || request()->routeIs('public.android-tv-gold-board') || request()->routeIs('public.cities*')) ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                        <span>آموزش و شهرها</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="guidesDropdownOpen ? 'rotate-180 text-amber-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="guidesDropdownOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute right-0 mt-2 w-64 rounded-2xl bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl p-2 z-50 space-y-1">
                        
                        <a href="{{ route('public.guides') }}" class="block p-2 rounded-xl hover:bg-blue-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400">دانشنامه و مقالات تخصصی</div>
                            <div class="text-[10px] text-slate-400">قوانین مالیات، فاکتور و سود طلا</div>
                        </a>

                        <a href="{{ route('public.tv-setup-guide') }}" class="block p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">راهنمای اتصال تلویزیون</div>
                            <div class="text-[10px] text-slate-400">سامسونگ، ال‌جی، سونی و اسنوا</div>
                        </a>

                        <a href="{{ route('public.android-tv-gold-board') }}" class="block p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">راهنمای اندروید تی‌وی و باکس</div>
                            <div class="text-[10px] text-slate-400">نصب روی انواع باکس و تلویزیون</div>
                        </a>

                        <a href="{{ route('public.cities.index') }}" class="block p-2 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 group transition-all">
                            <div class="text-xs font-bold text-amber-700 dark:text-amber-300">شهرهای فعال بازار طلا</div>
                            <div class="text-[10px] text-slate-400">تهران، مشهد، اصفهان، همدان و...</div>
                        </a>
                    </div>
                </div>

                <a href="{{ route('public.pricing') }}" class="px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all {{ request()->routeIs('public.pricing') ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                    تعرفه‌ها
                </a>

                {{-- دراپ‌داون وب‌سرویس و ویجت --}}
                <div class="relative" @mouseenter="devDropdownOpen = true" @mouseleave="devDropdownOpen = false">
                    <button type="button" @click="devDropdownOpen = !devDropdownOpen" class="flex items-center gap-1 px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all cursor-pointer {{ (request()->routeIs('public.widget*') || request()->routeIs('public.api-docs')) ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                        <span>API و ویجت</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="devDropdownOpen ? 'rotate-180 text-amber-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="devDropdownOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute right-0 mt-2 w-64 rounded-2xl bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl p-2 z-50 space-y-1">
                        
                        <a href="{{ route('public.widget') }}" class="block p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">ویجت نرخ طلا برای سایت‌ها</div>
                            <div class="text-[10px] text-slate-400">تولید کد اختصاصی iframe</div>
                        </a>

                        <a href="{{ route('public.api-docs') }}" class="block p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">وب‌سرویس و API نرخ لحظه‌ای</div>
                            <div class="text-[10px] text-slate-400">مستندات REST API و نمونه کدها</div>
                        </a>
                    </div>
                </div>

                <a href="{{ route('public.contact') }}" class="px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all {{ request()->routeIs('public.contact') ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                    تماس
                </a>
            </nav>

            {{-- بخش دکمه‌های اقدام و سوئیچ تم --}}
            <div class="flex items-center gap-1 sm:gap-2.5 shrink-0">
                {{-- دکمه تغییر تم تاریک / روشن --}}
                <button onclick="toggleAppTheme()" 
                        type="button"
                        id="themeToggleBtn"
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-800 bg-slate-100/90 dark:bg-slate-900/80 text-slate-600 dark:text-amber-400 hover:bg-slate-200 dark:hover:bg-slate-800 transition-all shadow-sm cursor-pointer shrink-0"
                        title="تغییر تم تاریک / روشن">
                    {{-- آیکون خورشید برای حالت شب --}}
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400 theme-sun-icon transition-transform duration-300 rotate-0 hover:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    {{-- آیکون ماه برای حالت روز --}}
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-700 dark:text-slate-200 theme-moon-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                {{-- دکمه متمایز اتصال تلویزیون مغازه --}}
                <a href="{{ route('display.tv') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 sm:py-2.5 rounded-xl border-2 border-amber-500/40 bg-amber-500/10 hover:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-xs font-black transition-all shadow-sm cursor-pointer whitespace-nowrap">
                    <span class="text-sm">📺</span>
                    <span>اتصال تلویزیون<span class="hidden md:inline"> مغازه</span></span>
                </a>

                {{-- دکمه ورود --}}
                <a href="{{ route('admin.login') }}" class="hidden sm:inline-flex items-center gap-1 px-2 sm:px-4 py-1.5 sm:py-2.5 rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white/90 dark:bg-slate-900/60 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-bold transition-all shadow-sm cursor-pointer whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    <span>ورود<span class="hidden sm:inline"> طلافروشان</span></span>
                </a>

                {{-- دکمه ثبت‌نام --}}
                <a href="{{ route('admin.register') }}" class="inline-flex items-center gap-1 px-2.5 sm:px-4 md:px-5 py-1.5 sm:py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 text-xs font-black transition-all shadow-md shadow-amber-500/20 hover:scale-[1.02] cursor-pointer whitespace-nowrap">
                    <span>ثبت‌نام<span class="hidden sm:inline"> گالری</span></span>
                </a>

                {{-- دکمه همبرگری موبایل --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="lg:hidden w-8 h-8 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-800 bg-slate-100/90 dark:bg-slate-900/80 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-800 transition-all cursor-pointer shrink-0">
                    <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    <svg x-show="mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        {{-- منوی کشویی موبایل (Mobile Drawer) --}}
        <div x-show="mobileMenuOpen" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden border-b border-slate-200 dark:border-slate-800 bg-white/98 dark:bg-slate-950/98 backdrop-blur-2xl px-5 py-6 space-y-6 shadow-2xl max-h-[85vh] overflow-y-auto">
            
            {{-- سامانه‌ها و تابلوهای تخصصی --}}
            <div>
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-2.5">سامانه‌ها و تابلوها</div>
                <nav class="flex flex-col space-y-1 text-xs font-bold text-slate-700 dark:text-slate-200">
                    <a href="{{ route('public.smart-gold-board') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>💎</span>
                        <span>تابلوی هوشمند طلافروشی</span>
                    </a>
                    <a href="{{ route('public.digital-rate-board') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>🖥️</span>
                        <span>تابلو دیجیتال طلا و صرافی</span>
                    </a>
                    <a href="{{ route('public.gold-board-without-device') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>☁️</span>
                        <span>تابلو بدون نیاز به دستگاه</span>
                    </a>
                    <a href="{{ route('public.online-gold-price-board') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>⚡</span>
                        <span>تابلو آنلاین قیمت طلا</span>
                    </a>
                    <a href="{{ route('public.currency-exchange-board') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>💱</span>
                        <span>تابلو نرخ ارز صرافی</span>
                    </a>
                    <a href="{{ route('public.silver-bullion-board') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>🥈</span>
                        <span>تابلو نقره و شمش</span>
                    </a>
                    <a href="{{ route('public.demo') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2 text-amber-600 dark:text-amber-400">
                        <span>▶️</span>
                        <span>پیش‌نمایش زنده تابلو</span>
                    </a>
                    <a href="{{ route('public.app') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <span>📱</span>
                        <span>دانلود اپلیکیشن و PWA</span>
                    </a>
                </nav>
            </div>

            {{-- مقایسه‌ها و تعرفه --}}
            <div class="pt-2 border-t border-slate-100 dark:border-slate-800/80">
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-2.5">مقایسه راهکارها و قیمت</div>
                <nav class="flex flex-col space-y-1 text-xs font-semibold text-slate-700 dark:text-slate-300">
                    <a href="{{ route('public.pricing') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2 font-bold text-amber-600 dark:text-amber-400">
                        <span>🏷️</span>
                        <span>تعرفه‌ها و اشتراک (۱۴ روز رایگان)</span>
                    </a>
                    <a href="{{ route('public.led-vs-smart-board') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>⚡</span>
                        <span>مقایسه با تابلوهای LED روان</span>
                    </a>
                    <a href="{{ route('public.compare.tabangohar') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>⚖️</span>
                        <span>مقایسه با تابان گوهر</span>
                    </a>
                    <a href="{{ route('public.compare.tgju-tv') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>📊</span>
                        <span>مقایسه با TGJU TV</span>
                    </a>
                    <a href="{{ route('public.compare.tablotala') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>🌐</span>
                        <span>مقایسه با تابلوطلا دات‌کام</span>
                    </a>
                </nav>
            </div>

            {{-- ابزارهای آنلاین طلا --}}
            <div class="pt-2 border-t border-slate-100 dark:border-slate-800/80">
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-2.5">ماشین‌حساب‌های تخصصی طلا</div>
                <nav class="flex flex-col space-y-1 text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <a href="{{ route('public.gold-calculator') }}" class="p-2 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 flex items-center gap-2 font-bold text-amber-700 dark:text-amber-300">
                        <span>🧮</span>
                        <span>هاب جامع ماشین‌حساب‌های طلا</span>
                    </a>
                    <a href="{{ route('public.tools.gold-price') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>💰</span>
                        <span>محاسبه قیمت طلا با اجرت و سود</span>
                    </a>
                    <a href="{{ route('public.tools.wage-calculator') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>🔨</span>
                        <span>ماشین‌حساب اجرت ساخت طلا</span>
                    </a>
                    <a href="{{ route('public.tools.second-hand-gold') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>♻️</span>
                        <span>محاسبه طلای دست دوم و متفرقه</span>
                    </a>
                    <a href="{{ route('public.tools.coin-bubble') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>🪙</span>
                        <span>محاسبه‌گر حباب انواع سکه</span>
                    </a>
                    <a href="{{ route('public.tools.mesghal') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>⚖️</span>
                        <span>تبدیل مظنه مثقال به گرم ۱۸ عیار</span>
                    </a>
                    <a href="{{ route('public.tools.melted-gold') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>🔥</span>
                        <span>محاسبه طلای آبشده و عیار انگ</span>
                    </a>
                    <a href="{{ route('public.tools.karat-converter') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>🔄</span>
                        <span>تبدیل عیارهای طلا و نقره</span>
                    </a>
                </nav>
            </div>

            {{-- دانشنامه، شهرها و توسعه‌دهندگان --}}
            <div class="pt-2 border-t border-slate-100 dark:border-slate-800/80">
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-2.5">آموزش، شهرها و API</div>
                <nav class="flex flex-col space-y-1 text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <a href="{{ route('public.guides') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>📚</span>
                        <span>دانشنامه و مقالات تخصصی طلا</span>
                    </a>
                    <a href="{{ route('public.cities.index') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>🏙️</span>
                        <span>شهرهای فعال بازار طلا (۱۰ شهر)</span>
                    </a>
                    <a href="{{ route('public.tv-setup-guide') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>📺</span>
                        <span>راهنمای اتصال تلویزیون</span>
                    </a>
                    <a href="{{ route('public.android-tv-gold-board') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>🤖</span>
                        <span>راهنمای اندروید تی‌وی و باکس</span>
                    </a>
                    <a href="{{ route('public.widget') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>🧩</span>
                        <span>ویجت قیمت طلا برای سایت‌ها</span>
                    </a>
                    <a href="{{ route('public.api-docs') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>🔌</span>
                        <span>وب‌سرویس و API عمومی نرخ</span>
                    </a>
                </nav>
            </div>

            {{-- درباره و تماس --}}
            <div class="pt-2 border-t border-slate-200 dark:border-slate-800 flex items-center justify-around text-xs text-slate-500 dark:text-slate-400 font-medium">
                <a href="{{ route('public.about') }}" class="hover:text-amber-500">درباره ما</a>
                <span>&bull;</span>
                <a href="{{ route('public.contact') }}" class="hover:text-amber-500">تماس با ما</a>
                <span>&bull;</span>
                <a href="{{ route('public.terms') }}" class="hover:text-amber-500">قوانین و مقررات</a>
                <span>&bull;</span>
                <a href="{{ route('public.privacy') }}" class="hover:text-amber-500">حریم خصوصی</a>
            </div>

            <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-2.5">
                <a href="{{ route('admin.login') }}" class="w-full text-center py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-200 text-xs font-bold">
                    ورود طلافروشان به پنل
                </a>
                <a href="{{ route('admin.register') }}" class="w-full text-center py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 text-xs font-black shadow-md">
                    ثبت‌نام گالری طلا (۱۴ روز رایگان)
                </a>
            </div>
        </div>
    </header>

    {{-- محتوای اصلی صفحه --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- فوتر جامع سئو و شبکه ناوبری داخلی طلالایو --}}
    <footer class="border-t border-slate-800/80 bg-slate-950 text-slate-400 text-xs py-14 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 lg:gap-8">
            
            {{-- ستون ۱: معرفی برند و راه‌های ارتباطی --}}
            <div class="space-y-4 sm:col-span-2 md:col-span-1 lg:col-span-1">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" width="40" height="40" loading="lazy" decoding="async" class="h-10 w-10 object-contain rounded-xl bg-slate-900 border border-slate-800 p-1" alt="طلالایو">
                    <div>
                        <div class="text-base font-black text-amber-400">طلالایو &middot; TalaLive</div>
                        <p class="text-[11px] text-slate-500">سامانه ابری تابلوی هوشمند طلافروشی</p>
                    </div>
                </div>
                <p class="text-slate-400 text-xs leading-relaxed">
                    سامانه تخصصی نمایش آنلاین نرخ لحظه‌ای طلا، سکه و ارز روی انواع تلویزیون‌های هوشمند بدون نیاز به خرید کیس، مینی‌کامپیوتر یا دستگاه سخت‌افزاری واسط.
                </p>
                <div class="space-y-2 text-[11px] text-slate-400 border-t border-slate-900 pt-3">
                    <div class="flex items-center gap-2">
                        <span class="text-amber-400">📍</span>
                        <span>همدان، بازار مظفریه، راسته زرگرها</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-amber-400">📞</span>
                        <a href="tel:09187009064" class="hover:text-amber-300 font-mono" dir="ltr">0918 700 9064</a>
                    </div>
                </div>
                <div class="pt-1">
                    <a href="https://rubika.ir/talalive" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white text-xs font-bold shadow-sm transition-all">
                        <span>ارتباط در روبیکا: talalive@</span>
                    </a>
                </div>
            </div>

            {{-- ستون ۲: سامانه‌ها و نمایشگرها --}}
            <div class="space-y-3">
                <div class="font-bold text-white text-sm flex items-center gap-2">
                    <span class="text-amber-400">📺</span>
                    <span>سامانه‌ها و تابلوها</span>
                </div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('public.smart-gold-board') }}" class="hover:text-amber-400 transition-colors">تابلوی هوشمند طلافروشی</a></li>
                    <li><a href="{{ route('public.digital-rate-board') }}" class="hover:text-amber-400 transition-colors">تابلوی دیجیتال نرخ طلا و ارز</a></li>
                    <li><a href="{{ route('public.gold-board-without-device') }}" class="hover:text-amber-400 transition-colors">تابلو طلا بدون خرید دستگاه</a></li>
                    <li><a href="{{ route('public.online-gold-price-board') }}" class="hover:text-amber-400 transition-colors">تابلو آنلاین قیمت لحظه‌ای طلا</a></li>
                    <li><a href="{{ route('public.currency-exchange-board') }}" class="hover:text-amber-400 transition-colors">تابلو نرخ صرافی و ارزها</a></li>
                    <li><a href="{{ route('public.silver-bullion-board') }}" class="hover:text-amber-400 transition-colors">تابلوی شمش و آبشده نقره</a></li>
                    <li><a href="{{ route('public.demo') }}" class="hover:text-amber-400 transition-colors">دموی آنلاین تابلوی طلا</a></li>
                    <li><a href="{{ route('public.app') }}" class="hover:text-amber-400 transition-colors">اپلیکیشن اندروید تی‌وی و موبایل</a></li>
                </ul>
            </div>

            {{-- ستون ۳: ابزارهای محاسباتی طلا --}}
            <div class="space-y-3">
                <div class="font-bold text-white text-sm flex items-center gap-2">
                    <span class="text-amber-400">🧮</span>
                    <span>ابزارهای طلا و سکه</span>
                </div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('public.gold-calculator') }}" class="hover:text-amber-400 transition-colors font-medium text-slate-300">ماشین حساب جامع طلا</a></li>
                    <li><a href="{{ route('public.tools.gold-price') }}" class="hover:text-amber-400 transition-colors">محاسبه قیمت طلا با اجرت</a></li>
                    <li><a href="{{ route('public.tools.wage-calculator') }}" class="hover:text-amber-400 transition-colors">فرمول محاسبه اجرت ساخت طلا</a></li>
                    <li><a href="{{ route('public.tools.second-hand-gold') }}" class="hover:text-amber-400 transition-colors">محاسبه طلای مستعمل و کم‌اجرت</a></li>
                    <li><a href="{{ route('public.tools.coin-bubble') }}" class="hover:text-amber-400 transition-colors">محاسبه آنلاین حباب انواع سکه</a></li>
                    <li><a href="{{ route('public.tools.mesghal') }}" class="hover:text-amber-400 transition-colors">تبدیل مظنه مثقال به گرم ۱۸</a></li>
                    <li><a href="{{ route('public.tools.melted-gold') }}" class="hover:text-amber-400 transition-colors">محاسبه و تبدیل طلای آبشده</a></li>
                    <li><a href="{{ route('public.tools.karat-converter') }}" class="hover:text-amber-400 transition-colors">جدول و تبدیل عیار طلا</a></li>
                </ul>
            </div>

            {{-- ستون ۴: مقایسه‌ها و راهنماها --}}
            <div class="space-y-3">
                <div class="font-bold text-white text-sm flex items-center gap-2">
                    <span class="text-amber-400">⚖️</span>
                    <span>مقایسه و راهنما</span>
                </div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('public.led-vs-smart-board') }}" class="hover:text-amber-400 transition-colors">مقایسه تابلو LED با تلویزیون</a></li>
                    <li><a href="{{ route('public.compare.tabangohar') }}" class="hover:text-amber-400 transition-colors">مقایسه طلالایو با تابان گوهر</a></li>
                    <li><a href="{{ route('public.compare.tgju-tv') }}" class="hover:text-amber-400 transition-colors">مقایسه طلالایو با TGJU TV</a></li>
                    <li><a href="{{ route('public.compare.tablotala') }}" class="hover:text-amber-400 transition-colors">مقایسه با تابلوی سنتی طلا</a></li>
                    <li><a href="{{ route('public.tv-setup-guide') }}" class="hover:text-amber-400 transition-colors">راهنمای اتصال تلویزیون</a></li>
                    <li><a href="{{ route('public.android-tv-gold-board') }}" class="hover:text-amber-400 transition-colors">راهنمای اندروید باکس طلافروشی</a></li>
                    <li><a href="{{ route('public.pricing') }}" class="hover:text-amber-400 transition-colors">تعرفه‌ها و پلن‌های اشتراک</a></li>
                </ul>
            </div>

            {{-- ستون ۵: بازار شهرها، API و حقوقی --}}
            <div class="space-y-3">
                <div class="font-bold text-white text-sm flex items-center gap-2">
                    <span class="text-amber-400">🏛️</span>
                    <span>شهرها، وب‌سرویس و قوانین</span>
                </div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('public.cities.index') }}" class="hover:text-amber-400 transition-colors font-medium text-amber-300">تابلو طلا در شهرهای ایران</a></li>
                    <li><a href="{{ route('public.guides') }}" class="hover:text-amber-400 transition-colors">پایگاه دانش و مقالات طلا</a></li>
                    <li><a href="{{ route('public.widget') }}" class="hover:text-amber-400 transition-colors">ویجت نرخ طلا برای سایت‌ها</a></li>
                    <li><a href="{{ route('public.api-docs') }}" class="hover:text-amber-400 transition-colors">وب‌سرویس و API عمومی نرخ</a></li>
                    <li><a href="{{ route('public.about') }}" class="hover:text-amber-400 transition-colors">درباره سامانه طلالایو</a></li>
                    <li><a href="{{ route('public.contact') }}" class="hover:text-amber-400 transition-colors">تماس با ما و پشتیبانی</a></li>
                    <li><a href="{{ route('public.terms') }}" class="hover:text-amber-400 transition-colors">قوانین و مقررات استفاده</a></li>
                    <li><a href="{{ route('public.privacy') }}" class="hover:text-amber-400 transition-colors">حریم خصوصی کاربران</a></li>
                </ul>
            </div>

        </div>

        {{-- ردیف پیوندهای سریع قطب‌های بازار طلا در استان‌ها --}}
        <div class="max-w-7xl mx-auto border-t border-slate-900 mt-10 pt-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-xs">
                <div class="flex items-center gap-2 text-slate-300 font-bold">
                    <span>📍</span>
                    <span>تابلو طلا در قطب‌های بازار زرگری ایران:</span>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <a href="{{ route('public.cities.hub', 'tehran') }}" class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 hover:border-amber-500/50 hover:text-amber-400 text-slate-400 transition-all text-[11px]">تهران</a>
                    <a href="{{ route('public.cities.hub', 'mashhad') }}" class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 hover:border-amber-500/50 hover:text-amber-400 text-slate-400 transition-all text-[11px]">مشهد</a>
                    <a href="{{ route('public.cities.hub', 'isfahan') }}" class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 hover:border-amber-500/50 hover:text-amber-400 text-slate-400 transition-all text-[11px]">اصفهان</a>
                    <a href="{{ route('public.cities.hub', 'tabriz') }}" class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 hover:border-amber-500/50 hover:text-amber-400 text-slate-400 transition-all text-[11px]">تبریز</a>
                    <a href="{{ route('public.cities.hub', 'shiraz') }}" class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 hover:border-amber-500/50 hover:text-amber-400 text-slate-400 transition-all text-[11px]">شیراز</a>
                    <a href="{{ route('public.cities.hub', 'hamedan') }}" class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 hover:border-amber-500/50 hover:text-amber-400 text-slate-400 transition-all text-[11px]">همدان</a>
                    <a href="{{ route('public.cities.hub', 'yazd') }}" class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 hover:border-amber-500/50 hover:text-amber-400 text-slate-400 transition-all text-[11px]">یزد</a>
                    <a href="{{ route('public.cities.hub', 'qom') }}" class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 hover:border-amber-500/50 hover:text-amber-400 text-slate-400 transition-all text-[11px]">قم</a>
                    <a href="{{ route('public.cities.hub', 'ahvaz') }}" class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 hover:border-amber-500/50 hover:text-amber-400 text-slate-400 transition-all text-[11px]">اهواز</a>
                    <a href="{{ route('public.cities.hub', 'rasht') }}" class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 hover:border-amber-500/50 hover:text-amber-400 text-slate-400 transition-all text-[11px]">رشت</a>
                </div>
            </div>
        </div>

        {{-- حق کپی‌رایت و مالکیت معنوی --}}
        <div class="max-w-7xl mx-auto border-t border-slate-900 mt-6 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-right text-[11px] text-slate-500">
            <div>
                تمامی حقوق مادی و معنوی برای سامانه ابری تابلوی طلافروشی طلالایو (TalaLive.ir) محفوظ است &copy; ۱۴۰۵.
            </div>
            <div class="flex items-center gap-4 text-slate-400">
                <span>پشتیبانی فنی: <a href="tel:09187009064" class="hover:text-amber-400 font-mono" dir="ltr">0918 700 9064</a></span>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        function publicLayoutHandler() {
            return {
                darkMode: document.documentElement.classList.contains('dark'),
                mobileMenuOpen: false,
                productsDropdownOpen: false,
                compareDropdownOpen: false,
                toolsDropdownOpen: false,
                guidesDropdownOpen: false,
                devDropdownOpen: false,

                init() {
                    window.addEventListener('talalive-theme-changed', (e) => {
                        this.darkMode = e.detail.isDark;
                    });
                },

                toggleTheme() {
                    toggleAppTheme();
                    this.darkMode = document.documentElement.classList.contains('dark');
                }
            };
        }
    </script>
</body>
</html>
