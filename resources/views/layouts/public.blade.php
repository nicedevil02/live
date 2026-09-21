<!DOCTYPE html>
<html lang="fa" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#020617">
    @stack('head')

    <!-- Favicons & App Icons (Cache-Busted v=2) -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}?v=2">
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=2">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="طلالایو">

    {{-- ضبط زودهنگام رویداد نصب PWA برای جلوگیری از دست رفتن رویداد در تمامی صفحات --}}
    <script>
        window.__pwaDeferredPrompt = null;
        window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault();
            window.__pwaDeferredPrompt = e;
            window.dispatchEvent(new CustomEvent('talalive-pwa-ready'));
        });
    </script>

    {{-- اسکریپت اولیه تعیین تم: دیفالت روی حالت روشن است مگر اینکه کاربر قبلاً تم تاریک را انتخاب کرده باشد --}}
    <script>
        (function () {
            var savedTheme = null;
            try { savedTheme = localStorage.getItem('talalive_theme'); } catch (e) { savedTheme = null; }
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();

        function toggleAppTheme() {
            var isDark = document.documentElement.classList.toggle('dark');
            try { localStorage.setItem('talalive_theme', isDark ? 'dark' : 'light'); } catch (e) { /* استوریج مسدود است؛ تم فقط تا پایان همین صفحه می‌ماند */ }
            window.dispatchEvent(new CustomEvent('talalive-theme-changed', { detail: { isDark: isDark } }));
        }
    </script>

    <title>@yield('title', 'طلالایو (طلا لایو) | تابلوی هوشمند طلافروشی و نمایشگر نرخ مغازه طلا فروشی')</title>
    <meta name="description" content="@yield('meta_description', 'سامانه ابری تابلوی هوشمند طلافروشی و نمایشگر آنلاین نرخ لحظه ای طلا و سکه برای مغازه طلا فروشی. اتصال تلویزیون بدون نیاز به کیس در سامانه طلا لایو (طلالایو).')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1')">
    <meta name="author" content="طلالایو - طلا لایو (TalaLive)">
    <link rel="canonical" href="@yield('canonical', 'https://talalive.ir' . (request()->getPathInfo() === '/' ? '' : request()->getPathInfo()))">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'سامانه هوشمند تابلوی طلافروشی و نمایشگر طلا فروشی | طلالایو (طلا لایو)')">
    <meta property="og:description" content="@yield('meta_description', 'سامانه ابری تابلوی هوشمند نرخ لحظه ای طلا، سکه و ارز ویژه تلویزیون مغازه‌های طلافروشی و طلا فروشی‌ها.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="طلالایو - طلا لایو">
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
          "name": "طلالایو (طلا لایو)",
          "alternateName": [
            "طلا لایو",
            "طلالایو",
            "Tala Live",
            "TalaLive",
            "سامانه طلا لایو",
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
          "name": "طلالایو (طلا لایو)",
          "alternateName": [
            "طلا لایو",
            "طلالایو",
            "Tala Live",
            "TalaLive",
            "سامانه طلا لایو",
            "سامانه ابری تابلوی هوشمند طلافروشی"
          ],
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
    @stack('styles')

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
        html { scroll-padding-top: 4.5rem; }
        @media (min-width: 640px) {
            html { scroll-padding-top: 5.5rem; }
        }
        body {
            font-family: Vazirmatn, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f8fafc;
        }
        .dark body {
            background: #020617;
        }
        body.menu-open { overflow: hidden; }
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
        @media (prefers-reduced-motion: reduce) {
            .pulse-logo,
            .animate-ping,
            .animate-pulse {
                animation: none !important;
            }
            html { scroll-behavior: auto !important; }
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
        header a:focus-visible,
        header button:focus-visible,
        footer a:focus-visible {
            outline: 2px solid #f59e0b;
            outline-offset: 2px;
            border-radius: 0.75rem;
        }
        .backdrop-blur-md {
            -webkit-backdrop-filter: blur(12px);
            backdrop-filter: blur(12px);
        }
        .bg-white\/95 {
            background-color: rgb(255 255 255 / 0.95);
        }
        .dark .dark\:bg-slate-950\/95 {
            background-color: rgb(2 6 23 / 0.95);
        }
        /* متریال شیشه مایع و ماتریس اپل (Apple HIG Liquid Frosted Glass) */
        .apple-glass-capsule {
            background: rgba(255, 255, 255, 0.72) !important;
            backdrop-filter: blur(24px) saturate(190%) contrast(102%) !important;
            -webkit-backdrop-filter: blur(24px) saturate(190%) contrast(102%) !important;
            border: 1px solid rgba(255, 255, 255, 0.7) !important;
            box-shadow: 0 16px 36px -8px rgba(15, 23, 42, 0.08),
                        0 4px 12px -2px rgba(15, 23, 42, 0.04),
                        inset 0 1px 1px 0 rgba(255, 255, 255, 0.95),
                        inset 0 -1px 1px 0 rgba(0, 0, 0, 0.03) !important;
        }
        .dark .apple-glass-capsule {
            background: rgba(15, 23, 42, 0.74) !important;
            backdrop-filter: blur(24px) saturate(190%) contrast(102%) !important;
            -webkit-backdrop-filter: blur(24px) saturate(190%) contrast(102%) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            box-shadow: 0 16px 40px -8px rgba(0, 0, 0, 0.6),
                        0 4px 12px -2px rgba(0, 0, 0, 0.35),
                        inset 0 1px 1px 0 rgba(255, 255, 255, 0.2),
                        inset 0 -1px 1px 0 rgba(0, 0, 0, 0.3) !important;
        }
        /* کلاس‌های ترنزیشن فیزیک اپل مورفینگ گلس برای جمع‌شدن ردیف دوم در اسکرول به پایین */
        .header-row2-hidden {
            max-height: 0 !important;
            height: 0 !important;
            min-height: 0 !important;
            opacity: 0 !important;
            transform: translateY(-8px) scaleY(0.96) !important;
            overflow: hidden !important;
            pointer-events: none !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }
        .header-row2-visible {
            max-height: 5.5rem !important; /* 88px */
            opacity: 1 !important;
            transform: translateY(0) scaleY(1) !important;
            overflow: visible !important;
            pointer-events: auto !important;
        }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 dark:bg-[#020617] text-slate-800 dark:text-slate-100 selection:bg-amber-500/30 selection:text-amber-700 dark:selection:text-amber-200 antialiased min-h-screen flex flex-col transition-colors duration-300" x-data="publicLayoutHandler()">

    {{-- پرش به محتوای اصلی (Skip Link) --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:right-3 focus:z-[100] focus:px-4 focus:py-2 focus:rounded-xl focus:bg-amber-500 focus:text-slate-950 focus:text-xs focus:font-black focus:shadow-lg">
        پرش به محتوای اصلی
    </a>

    {{-- نوار ناوبری کپسولی شناور شیشه‌ای اپل (Apple HIG Liquid Glass Capsule Header) --}}
    <header class="fixed top-1.5 sm:top-3 inset-x-0 z-50 w-full px-2 sm:px-4 lg:px-6 pointer-events-none transition-all duration-300">
        <div class="max-w-7xl mx-auto pointer-events-auto rounded-2xl sm:rounded-3xl apple-glass-capsule transition-all duration-300 overflow-visible"
             :class="isScrolledDown ? 'shadow-lg ring-1 ring-slate-900/5 dark:ring-white/10' : 'shadow-xl'">
            
            {{-- ردیف ۱: نوار ترکیبی بالای هدر (نرخ زنده + ابزارهای کاربردی) --}}
            @unless($isTv ?? false)
            <div class="relative z-20 h-9 px-3 sm:px-5 flex items-center justify-between gap-2 sm:gap-4 border-slate-200/50 dark:border-white/10 bg-transparent text-xs select-none transition-all duration-300"
                 :class="isScrolledDown ? 'rounded-2xl sm:rounded-3xl border-b-0' : 'rounded-t-2xl sm:rounded-t-3xl border-b'">
                
                {{-- سمت راست / مرکز: نوار نرخ زنده لحظه‌ای بازار --}}
                <div class="min-w-0 flex-1 overflow-x-auto snap-x scrollbar-none flex items-center">
                    @include('partials.rate-ticker')
                </div>

                {{-- سمت چپ: ابزارهای کاربردی (تلفن، دانلود اپ، اتصال دستگاه، تم) --}}
                <div class="flex items-center gap-1.5 sm:gap-2.5 shrink-0 text-slate-600 dark:text-slate-300">
                    
                    {{-- شماره تماس پشتیبانی با جداسازی قطعی LTR برای جلوگیری از وارونگی ارقام --}}
                    <a href="tel:09187009064"
                       aria-label="تماس تلفنی با پشتیبانی طلالایو"
                       dir="ltr"
                       class="hidden xl:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg hover:bg-slate-200/70 dark:hover:bg-slate-800/70 text-slate-600 dark:text-slate-300 hover:text-amber-600 dark:hover:text-amber-400 transition-colors font-bold text-[11px]"
                       title="تماس تلفنی با پشتیبانی: ۰۹۱۸۷۰۰۹۰۶۴">
                        <svg aria-hidden="true" class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <bdi dir="ltr" class="font-mono text-[11px] tabular-nums tracking-wide">0918 700 9064</bdi>
                    </a>

                    {{-- دانلود اپ تلویزیون --}}
                    <a href="{{ route('public.app') }}" 
                       class="hidden md:inline-flex items-center gap-1 px-2.5 py-1 rounded-lg border border-slate-200/80 dark:border-slate-800 bg-slate-100/60 dark:bg-slate-900/60 hover:bg-slate-200/80 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-[11px] font-bold transition-all whitespace-nowrap">
                        <svg aria-hidden="true" class="w-3 h-3 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>دانلود اپ تلویزیون</span>
                    </a>

                    {{-- اتصال دستگاه --}}
                    <a href="{{ route('display.tv') }}"
                       class="hidden sm:inline-flex items-center gap-1 px-2.5 py-1 rounded-lg border border-amber-500/30 bg-amber-500/10 hover:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-[11px] font-bold transition-all whitespace-nowrap"
                       title="اتصال تلویزیون مغازه به سامانه طلالایو">
                        <span class="text-xs" aria-hidden="true">📺</span>
                        <span>اتصال دستگاه</span>
                    </a>

                    {{-- دکمه تغییر تم تاریک / روشن --}}
                    <button onclick="toggleAppTheme()" 
                            type="button"
                            id="themeToggleBtn"
                            aria-label="تغییر تم تاریک و روشن"
                            class="w-7 h-7 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-800 text-slate-600 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all shadow-sm cursor-pointer shrink-0"
                            title="تغییر تم تاریک / روشن">
                        <svg aria-hidden="true" class="w-3.5 h-3.5 text-amber-400 theme-sun-icon transition-transform duration-300 rotate-0 hover:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg aria-hidden="true" class="w-3.5 h-3.5 text-slate-700 dark:text-slate-200 theme-moon-icon transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>
            </div>
            @endunless

            {{-- ردیف ۲: نوار اصلی برندینگ و ناوبری (Main Navigation Bar) --}}
            <div class="relative z-10 h-16 sm:h-20 px-3 sm:px-5 flex items-center justify-between gap-3 xl:gap-6 rounded-b-2xl sm:rounded-b-3xl bg-transparent transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] will-change-transform will-change-[max-height,opacity]"
                 :class="isScrolledDown ? 'header-row2-hidden' : 'header-row2-visible'"
                 @focusin="isScrolledDown = false">
                
                {{-- لوگو و نام برند --}}
                <a href="/" class="flex items-center gap-1.5 sm:gap-3 group shrink-0 min-w-0">
                    <div class="relative shrink-0">
                        <img src="{{ asset('images/logo.png') }}?v=2" width="44" height="44" loading="eager" decoding="async" class="h-8 w-8 sm:h-11 sm:w-11 object-contain rounded-xl sm:rounded-2xl shadow-md shadow-amber-500/10 bg-white/90 dark:bg-slate-900/80 p-1 border border-slate-200/80 dark:border-slate-700/60" alt="طلالایو (طلا لایو)">
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

                {{-- نوار ناوبری کپسولی مدرن و مگامنو (Desktop Navigation - Apple Liquid Glass Capsule) --}}
                <nav aria-label="ناوبری اصلی" class="hidden xl:flex items-center gap-0.5 p-1 rounded-2xl bg-slate-100/70 dark:bg-slate-900/60 border border-slate-200/60 dark:border-white/10 backdrop-blur-md text-xs font-bold text-slate-600 dark:text-slate-300 shadow-sm overflow-visible">
                    <a href="/" class="px-2.5 py-2 rounded-xl whitespace-nowrap hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all {{ request()->is('/') ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}"{!! request()->is('/') ? ' aria-current="page"' : '' !!}>
                        صفحه اصلی
                    </a>

                    @include('partials.nav-desktop')

                    <a href="{{ route('public.contact') }}" class="px-2.5 py-2 rounded-xl whitespace-nowrap hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all {{ request()->routeIs('public.contact') ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}"{!! request()->routeIs('public.contact') ? ' aria-current="page"' : '' !!}>
                        تماس
                    </a>
                </nav>

                {{-- دکمه‌های اقدام اصلی (Conversion CTAs) --}}
                <div class="flex items-center gap-2 shrink-0">
                    {{-- دکمه ورود طلافروشان --}}
                    <a href="{{ route('admin.login') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 px-3.5 h-10 sm:h-11 rounded-xl border border-slate-200/90 dark:border-white/10 bg-slate-100/70 dark:bg-slate-900/70 hover:bg-slate-200/80 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 hover:text-amber-600 dark:hover:text-amber-400 font-bold text-xs transition-all shadow-sm whitespace-nowrap">
                        <svg aria-hidden="true" class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>ورود طلافروشان</span>
                    </a>

                    {{-- دکمه ثبت‌نام گالری طلا --}}
                    <a href="{{ route('admin.register') }}" class="inline-flex items-center justify-center gap-1 px-3.5 sm:px-4 h-10 sm:h-11 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 text-xs font-black transition-all shadow-md shadow-amber-500/20 hover:scale-[1.02] cursor-pointer whitespace-nowrap shrink-0">
                        <span>ثبت‌نام<span class="hidden sm:inline"> گالری طلا</span></span>
                    </a>

                    {{-- دکمه همبرگری موبایل --}}
                    <button @click="toggleMobileMenu()" 
                            type="button" 
                            aria-label="منوی اصلی"
                            aria-controls="mobile-menu"
                            :aria-expanded="mobileMenuOpen ? 'true' : 'false'"
                            class="xl:hidden w-10 h-10 sm:w-11 sm:h-11 rounded-xl flex items-center justify-center border border-slate-200 dark:border-white/10 bg-slate-100/90 dark:bg-slate-900/80 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-800 transition-all cursor-pointer shrink-0">
                        <svg aria-hidden="true" x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        <svg aria-hidden="true" x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            {{-- منوی کشویی موبایل (Mobile Drawer) --}}
            <div id="mobile-menu"
                 x-show="mobileMenuOpen" 
                 x-cloak
                 @click.outside="closeMobileMenu()"
                 @keydown.escape.window="closeMobileMenu()"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="xl:hidden rounded-b-2xl sm:rounded-b-3xl border-t border-slate-200/80 dark:border-white/10 bg-white/95 dark:bg-slate-950/95 backdrop-blur-2xl px-5 py-6 space-y-6 shadow-2xl max-h-[80dvh] overflow-y-auto">
                
                {{-- سامانه‌ها و تابلوهای تخصصی --}}
                @include('partials.nav-mobile')

                {{-- درباره و تماس --}}
                <nav @click="closeMobileMenu()" aria-label="درباره و تماس" class="pt-2 border-t border-slate-200 dark:border-slate-800 flex items-center justify-around text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <a href="{{ route('public.about') }}" class="hover:text-amber-500">درباره ما</a>
                    <span>&bull;</span>
                    <a href="{{ route('public.contact') }}" class="hover:text-amber-500">تماس با ما</a>
                    <span>&bull;</span>
                    <a href="{{ route('public.terms') }}" class="hover:text-amber-500">قوانین و مقررات</a>
                    <span>&bull;</span>
                    <a href="{{ route('public.privacy') }}" class="hover:text-amber-500">حریم خصوصی</a>
                </nav>

                <div @click="closeMobileMenu()" class="pt-3 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-2.5">
                    <a href="{{ route('display.tv') }}" class="w-full text-center py-2.5 rounded-xl border border-amber-500/40 bg-amber-500/10 text-amber-700 dark:text-amber-300 text-xs font-bold">
                        📺 اتصال به تلویزیون هوشمند
                    </a>
                    <a href="{{ route('admin.login') }}" class="w-full text-center py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-200 text-xs font-bold">
                        ورود طلافروشان به پنل
                    </a>
                    <a href="{{ route('admin.register') }}" class="w-full text-center py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 text-xs font-black shadow-md">
                        ثبت‌نام گالری طلا (۱۴ روز رایگان)
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- اسپیسر نامرئی با ارتفاع کاملاً ثابت برای حفظ موقعیت دقیق سند و جلوگیری از هرگونه لرزش اسکرول --}}
    <div class="h-[108px] sm:h-[130px] pointer-events-none shrink-0" aria-hidden="true"></div>

    {{-- محتوای اصلی صفحه --}}
    <main id="main-content" tabindex="-1" class="flex-grow focus:outline-none">
        @yield('content')
    </main>

    {{-- فوتر جامع سئو و شبکه ناوبری داخلی طلالایو --}}
    <footer class="border-t border-slate-800/80 bg-slate-950 text-slate-400 text-xs py-14 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 lg:gap-8">
            
            {{-- ستون ۱: معرفی برند و راه‌های ارتباطی --}}
            <div class="space-y-4 sm:col-span-2 md:col-span-1 lg:col-span-1">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}?v=2" width="40" height="40" loading="lazy" decoding="async" class="h-10 w-10 object-contain rounded-xl bg-slate-900 border border-slate-800 p-1" alt="طلالایو (طلا لایو)">
                    <div>
                        <div class="text-base font-black text-amber-400">طلالایو (طلا لایو) &middot; TalaLive</div>
                        <p class="text-[11px] text-slate-500">سامانه ابری تابلوی هوشمند طلافروشی</p>
                    </div>
                </div>
                <p class="text-slate-400 text-xs leading-relaxed">
                    سامانه تخصصی طلا لایو (طلالایو): نمایش آنلاین نرخ لحظه‌ای طلا، سکه و ارز روی انواع تلویزیون‌های هوشمند بدون نیاز به خرید کیس، مینی‌کامپیوتر یا دستگاه سخت‌افزاری واسط.
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
                تمامی حقوق مادی و معنوی برای سامانه ابری تابلوی طلافروشی طلالایو (TalaLive.ir) محفوظ است &copy; {{ \App\Models\User::jalaliYear() }}.
            </div>
            <div class="flex items-center gap-4 text-slate-400">
                <span>پشتیبانی فنی: <a href="tel:09187009064" class="hover:text-amber-400 font-mono tracking-wide" dir="ltr"><bdi dir="ltr">0918 700 9064</bdi></a></span>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        function publicLayoutHandler() {
            return {
                mobileMenuOpen: false,
                openDropdown: null,
                isScrolledDown: false,
                lastScrollY: 0,
                scrollThreshold: 12,
                topThreshold: 60,
                collapseThreshold: 110,
                ticking: false,

                init() {
                    this.lastScrollY = Math.max(0, window.pageYOffset || document.documentElement.scrollTop || 0);
                    window.addEventListener('scroll', () => this.onScroll(), { passive: true });
                },

                onScroll() {
                    if (this.ticking) return;
                    this.ticking = true;

                    requestAnimationFrame(() => {
                        const currentY = Math.max(0, window.pageYOffset || document.documentElement.scrollTop || 0);

                        // اگر منوی موبایل باز است، هدر به هیچ وجه پنهان نشود
                        if (this.mobileMenuOpen) {
                            if (this.isScrolledDown) this.isScrolledDown = false;
                            this.lastScrollY = currentY;
                            this.ticking = false;
                            return;
                        }

                        // در بالای صفحه همواره ردیف دوم هدر به صورت کامل نمایش داده شود
                        if (currentY <= this.topThreshold) {
                            if (this.isScrolledDown) this.isScrolledDown = false;
                            this.lastScrollY = currentY;
                            this.ticking = false;
                            return;
                        }

                        const delta = currentY - this.lastScrollY;

                        // فیلتر کردن لرزش‌های ریز زیر حد آستانه (میکرو-نویز تاچ‌پد و ماوس)
                        if (Math.abs(delta) < this.scrollThreshold) {
                            this.ticking = false;
                            return;
                        }

                        if (delta > 0 && currentY > this.collapseThreshold) {
                            // اسکرول عمدی به پایین: بستن هرگونه منوی باز و جمع شدن ردیف دوم
                            if (!this.isScrolledDown) {
                                this.closeAllMenus();
                                this.isScrolledDown = true;
                            }
                        } else if (delta < -14) {
                            // اسکرول عمدی به بالا: بازگشت سریع (Quick-Return) ردیف دوم
                            if (this.isScrolledDown) {
                                this.isScrolledDown = false;
                            }
                        }

                        this.lastScrollY = currentY;
                        this.ticking = false;
                    });
                },

                isOpen(name) {
                    return this.openDropdown === name;
                },
                openMenu(name) {
                    this.openDropdown = name;
                },
                closeMenu(name) {
                    if (this.openDropdown === name) this.openDropdown = null;
                },
                closeAllMenus() {
                    this.openDropdown = null;
                },

                toggleMobileMenu() {
                    this.mobileMenuOpen ? this.closeMobileMenu() : this.openMobileMenu();
                },
                openMobileMenu() {
                    this.mobileMenuOpen = true;
                    this.isScrolledDown = false;
                    document.body.classList.add('menu-open');
                },
                closeMobileMenu() {
                    if (!this.mobileMenuOpen) return;
                    this.mobileMenuOpen = false;
                    document.body.classList.remove('menu-open');
                },
            };
        }
    </script>

    {{-- ثبت Service Worker برای PWA --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js?v=7').catch(function(err) {
                    console.warn('PWA registration failed:', err);
                });
            });
        }
    </script>
</body>
</html>
