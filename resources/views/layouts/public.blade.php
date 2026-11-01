<!DOCTYPE html>
<html lang="fa" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" id="appThemeColorMeta" content="#ffffff">
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
            var meta = document.getElementById('appThemeColorMeta');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
                if (meta) meta.setAttribute('content', '#141312');
            } else {
                document.documentElement.classList.remove('dark');
                if (meta) meta.setAttribute('content', '#ffffff');
            }
        })();

        function toggleAppTheme() {
            var isDark = document.documentElement.classList.toggle('dark');
            var meta = document.getElementById('appThemeColorMeta');
            if (meta) meta.setAttribute('content', isDark ? '#141312' : '#ffffff');
            try { localStorage.setItem('talalive_theme', isDark ? 'dark' : 'light'); } catch (e) { /* استوریج مسدود است */ }
            window.dispatchEvent(new CustomEvent('talalive-theme-changed', { detail: { isDark: isDark } }));
        }
    </script>

    <title>@yield('title', 'طلالایو | تابلوی هوشمند طلافروشی و نمایشگر نرخ مغازه طلا فروشی')</title>
    <meta name="description" content="@yield('meta_description', 'سامانه ابری تابلوی هوشمند طلافروشی و نمایشگر آنلاین نرخ لحظه ای طلا و سکه برای مغازه طلا فروشی. اتصال تلویزیون بدون نیاز به کیس در سامانه طلا لایو (طلالایو).')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1')">
    <meta name="author" content="طلالایو (TalaLive)">
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
          "name": "طلالایو",
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
            "addressLocality": "{{ config('app.organization.address.locality', 'کبودرآهنگ') }}",
            "addressRegion": "{{ config('app.organization.address.region', 'همدان') }}",
            "streetAddress": "{{ config('app.organization.address.street', 'خیابان مطهری، پاساژ علاءالدین') }}",
            "addressCountry": "IR"
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
              "telephone": "+988135229063",
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
          "name": "طلالایو",
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
        html { scroll-padding-top: 7.5rem; }
        body {
            font-family: var(--font-sans);
            background-color: var(--tl-bg);
            color: var(--tl-text);
        }
        body.menu-open { overflow: hidden; }
        html.dark .theme-sun-icon { display: inline-block !important; }
        html.dark .theme-moon-icon { display: none !important; }
        html:not(.dark) .theme-sun-icon { display: none !important; }
        html:not(.dark) .theme-moon-icon { display: inline-block !important; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="tl-public text-stone-900 dark:text-stone-50 selection:bg-amber-500/30 selection:text-amber-900 dark:selection:text-amber-200 antialiased min-h-screen flex flex-col transition-colors duration-200" x-data="publicLayoutHandler()">

    {{-- پرش به محتوای اصلی (Skip Link) --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:right-3 focus:z-[100] focus:px-4 focus:py-2.5 focus:rounded-xl focus:bg-amber-500 focus:text-stone-950 focus:text-xs focus:font-bold focus:shadow-lg">
        پرش به محتوای اصلی
    </a>

    {{-- هدر کپسولی شناور شیشه‌ای اپل (Apple HIG Liquid Frosted Glass Capsule) با مورفینگ اسکرول --}}
    <header class="fixed top-1.5 sm:top-3 inset-x-0 z-50 px-2 sm:px-4 lg:px-6 pointer-events-none">
        <div class="max-w-7xl mx-auto pointer-events-auto rounded-2xl sm:rounded-[24px] tl-glass-capsule px-3 sm:px-5 lg:px-6">
            
            {{-- ردیف ۱: نوار تیکر نرخ زنده بازار و ابزارهای سریع --}}
            @unless($isTv ?? false)
            <div class="h-10 flex items-center justify-between gap-3 text-xs select-none transition-colors duration-200"
                 :class="isScrolledDown ? 'border-b border-transparent' : 'border-b border-stone-300/55 dark:border-white/10'">
                {{-- نوار نرخ زنده لحظه‌ای --}}
                <div class="min-w-0 flex-1 overflow-x-auto snap-x scrollbar-none flex items-center">
                    @include('partials.rate-ticker')
                </div>

                {{-- ابزارهای سریع سربرگ --}}
                <div class="flex items-center gap-2 shrink-0">
                    {{-- شماره تماس پشتیبانی --}}
                    <a href="tel:09187009064"
                       aria-label="تماس تلفنی با پشتیبانی طلالایو"
                       dir="ltr"
                       class="hidden xl:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg hover:bg-white/60 dark:hover:bg-white/5 text-stone-700 dark:text-stone-300 hover:text-amber-800 dark:hover:text-amber-400 transition-colors text-xs font-semibold"
                       title="تماس تلفنی با پشتیبانی: ۰۹۱۸۷۰۰۹۰۶۴">
                        @include('partials.ui-icon', ['name' => 'phone', 'class' => 'w-3.5 h-3.5 text-emerald-700 dark:text-emerald-400 shrink-0'])
                        <bdi dir="ltr" class="tabular-nums">0918 700 9064</bdi>
                    </a>

                    {{-- دانلود اپ تلویزیون --}}
                    <a href="{{ route('public.app') }}" 
                       class="hidden md:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg tl-neu-btn text-stone-800 dark:text-stone-200 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-semibold whitespace-nowrap">
                        @include('partials.ui-icon', ['name' => 'smartphone', 'class' => 'w-3.5 h-3.5 text-amber-700 dark:text-amber-400'])
                        <span>دانلود اپ تلویزیون</span>
                    </a>

                    {{-- اتصال دستگاه --}}
                    <a href="{{ route('display.tv') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg tl-glass-badge text-amber-900 dark:text-amber-300 hover:brightness-105 text-xs font-semibold transition-all whitespace-nowrap"
                       title="اتصال تلویزیون مغازه به سامانه طلالایو">
                        @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-3.5 h-3.5 text-amber-700 dark:text-amber-400'])
                        <span>اتصال دستگاه</span>
                    </a>

                    {{-- دکمه نئومورفیک تغییر تم تاریک / روشن با ناحیه لمسی ۴۸×۴۸ پیکسل (R-03) --}}
                    <button onclick="toggleAppTheme()" 
                            type="button"
                            id="themeToggleBtn"
                            aria-label="تغییر تم تاریک و روشن"
                            class="relative w-8 h-8 rounded-xl tl-neu-btn flex items-center justify-center text-stone-700 dark:text-amber-400 cursor-pointer shrink-0 after:content-[''] after:absolute after:-inset-2"
                            title="تغییر تم تاریک / روشن">
                        <svg aria-hidden="true" class="w-4 h-4 text-amber-400 theme-sun-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg aria-hidden="true" class="w-4 h-4 text-stone-700 dark:text-stone-300 theme-moon-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>
            </div>
            @endunless

            {{-- ردیف ۲: نوار ناوبری اصلی و برند (جمع‌شونده نرم هنگام اسکرول به پایین) --}}
            <div class="tl-header-row2 h-16 sm:h-[4.25rem] flex items-center justify-between gap-3 xl:gap-5"
                 :class="isScrolledDown ? 'tl-header-row2-collapsed' : ''">
                {{-- لوگو و نام برند در گوی نئومورفیک --}}
                <a href="/" class="flex items-center gap-2.5 group shrink-0 min-w-0">
                    <span class="tl-neu-icon-orb h-9 w-9 sm:h-10 sm:w-10 rounded-xl p-1 flex items-center justify-center shrink-0">
                        <img src="{{ asset('images/logo.png') }}?v=2" width="36" height="36" loading="eager" decoding="async" class="h-full w-full object-contain" alt="طلالایو">
                    </span>
                    <div class="text-right">
                        <div class="text-base sm:text-lg font-bold text-stone-900 dark:text-stone-50 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors leading-tight">
                            <span>طلالایو</span><span class="hidden sm:inline"> &middot; <span class="font-semibold text-amber-700 dark:text-amber-400">TalaLive</span></span>
                        </div>
                        <p class="hidden md:block text-xs text-stone-600 dark:text-stone-400 font-medium">سامانه تابلوی هوشمند طلافروشی</p>
                    </div>
                </a>

                {{-- ریل سگمنت نئومورفیک منوی دسکتاپ (Cupertino Segmented Track) --}}
                <nav aria-label="ناوبری اصلی" class="hidden xl:flex items-center gap-1 p-1.5 rounded-2xl tl-neu-track text-xs font-semibold text-stone-700 dark:text-stone-300">
                    <a href="/" class="px-3 py-2 rounded-xl whitespace-nowrap transition-all {{ request()->is('/') ? 'tl-neu-pill-active text-amber-800 dark:text-amber-300 font-bold' : 'hover:text-amber-800 dark:hover:text-amber-300 hover:bg-white/60 dark:hover:bg-white/5' }}"{!! request()->is('/') ? ' aria-current="page"' : '' !!}>
                        صفحه اصلی
                    </a>

                    @include('partials.nav-desktop')

                    <a href="{{ route('public.contact') }}" class="px-3 py-2 rounded-xl whitespace-nowrap transition-all {{ request()->routeIs('public.contact') ? 'tl-neu-pill-active text-amber-800 dark:text-amber-300 font-bold' : 'hover:text-amber-800 dark:hover:text-amber-300 hover:bg-white/60 dark:hover:bg-white/5' }}"{!! request()->routeIs('public.contact') ? ' aria-current="page"' : '' !!}>
                        تماس
                    </a>
                </nav>

                {{-- دکمه‌های ورود نئومورفیک، ثبت‌نام شمش طلا و منوی موبایل --}}
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('admin.login') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 min-h-11 px-3.5 py-2 rounded-xl tl-neu-btn text-stone-800 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 font-semibold text-xs whitespace-nowrap">
                        @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-3.5 h-3.5 text-amber-700 dark:text-amber-400'])
                        <span>ورود طلافروشان</span>
                    </a>

                    <a href="{{ route('admin.register') }}" class="inline-flex items-center justify-center gap-1.5 min-h-11 px-4 py-2 rounded-xl tl-btn-bullion text-xs font-bold whitespace-nowrap shrink-0">
                        <span>ثبت‌نام<span class="hidden sm:inline"> گالری طلا</span></span>
                    </a>

                    {{-- دکمه همبرگری موبایل با ابعاد لمسی استاندارد ۴۴ پیکسل --}}
                    <button @click="toggleMobileMenu()" 
                            type="button" 
                            aria-label="منوی اصلی"
                            aria-controls="mobile-menu"
                            :aria-expanded="mobileMenuOpen ? 'true' : 'false'"
                            class="xl:hidden w-11 h-11 rounded-xl tl-neu-btn flex items-center justify-center text-stone-800 dark:text-stone-200 cursor-pointer shrink-0">
                        <svg aria-hidden="true" x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        <svg aria-hidden="true" x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- شیت شناور شیشه‌ای منوی موبایل (Apple Frosted Glass Sheet) --}}
        <div id="mobile-menu"
             x-show="mobileMenuOpen" 
             x-cloak
             @click.outside="closeMobileMenu()"
             @keydown.escape.window="closeMobileMenu()"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2 scale-[0.98]"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-2 scale-[0.98]"
             class="xl:hidden max-w-7xl mx-auto mt-2 pointer-events-auto rounded-2xl tl-glass-sheet px-5 py-6 space-y-6 max-h-[82dvh] overflow-y-auto">
            
            @include('partials.nav-mobile')

            <nav @click="closeMobileMenu()" aria-label="درباره و تماس" class="pt-3 border-t border-stone-300/60 dark:border-white/10 flex items-center justify-around text-xs text-stone-600 dark:text-stone-400 font-medium">
                <a href="{{ route('public.about') }}" class="hover:text-amber-700 dark:hover:text-amber-400 py-1">درباره ما</a>
                <span>&bull;</span>
                <a href="{{ route('public.contact') }}" class="hover:text-amber-700 dark:hover:text-amber-400 py-1">تماس با ما</a>
                <span>&bull;</span>
                <a href="{{ route('public.terms') }}" class="hover:text-amber-700 dark:hover:text-amber-400 py-1">قوانین</a>
                <span>&bull;</span>
                <a href="{{ route('public.privacy') }}" class="hover:text-amber-700 dark:hover:text-amber-400 py-1">حریم خصوصی</a>
            </nav>

            <div @click="closeMobileMenu()" class="pt-3 border-t border-stone-300/60 dark:border-white/10 flex flex-col gap-2.5">
                <a href="{{ route('display.tv') }}" class="w-full min-h-11 flex items-center justify-center gap-2 rounded-xl tl-glass-badge text-amber-900 dark:text-amber-300 text-xs font-semibold">
                    @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                    <span>اتصال به تلویزیون هوشمند</span>
                </a>
                <a href="{{ route('admin.login') }}" class="w-full min-h-11 flex items-center justify-center rounded-xl tl-neu-btn text-stone-800 dark:text-stone-100 text-xs font-semibold">
                    ورود طلافروشان به پنل
                </a>
                <a href="{{ route('admin.register') }}" class="w-full min-h-11 flex items-center justify-center rounded-xl tl-btn-bullion text-xs font-bold">
                    ثبت‌نام گالری طلا (۱۴ روز رایگان)
                </a>
            </div>
        </div>
    </header>

    {{-- نگهدارنده ثابت ارتفاع هدر شناور جهت جلوگیری از پرش چیدمان (Zero CLS) --}}
    <div class="{{ ($isTv ?? false) ? 'h-[78px] sm:h-[90px]' : 'h-[116px] sm:h-[128px]' }} pointer-events-none shrink-0" aria-hidden="true"></div>

    {{-- محتوای اصلی صفحه --}}
    <main id="main-content" tabindex="-1" class="flex-grow focus:outline-none">
        @yield('content')
    </main>

    {{-- فوتر جامع طلالایو با متریال نئومورفیک و دسترسی‌های لمسی استاندارد --}}
    <footer class="border-t border-stone-300/70 dark:border-white/10 bg-[#EAE5DA]/85 dark:bg-[#11100F] text-stone-600 dark:text-stone-400 text-xs py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            
            {{-- ستون ۱: معرفی برند و راه‌های ارتباطی --}}
            <div class="space-y-4 sm:col-span-2 md:col-span-1 lg:col-span-1">
                <div class="flex items-center gap-3">
                    <span class="tl-neu-icon-orb h-11 w-11 rounded-xl p-1.5 flex items-center justify-center shrink-0">
                        <img src="{{ asset('images/logo.png') }}?v=2" width="36" height="36" loading="lazy" decoding="async" class="h-full w-full object-contain" alt="طلالایو">
                    </span>
                    <div>
                        <div class="text-base font-bold text-stone-900 dark:text-stone-50">طلالایو &middot; TalaLive</div>
                        <p class="text-xs text-stone-600 dark:text-stone-400">سامانه ابری تابلوی هوشمند طلافروشی</p>
                    </div>
                </div>
                <p class="text-stone-700 dark:text-stone-300 text-xs leading-relaxed">
                    سامانه تخصصی طلالایو: نمایش آنلاین نرخ لحظه‌ای طلا، سکه و ارز روی انواع تلویزیون‌های هوشمند بدون نیاز به خرید کیس، مینی‌کامپیوتر یا دستگاه سخت‌افزاری واسط.
                </p>
                <div class="space-y-2 text-xs text-stone-600 dark:text-stone-400 border-t border-stone-300/60 dark:border-white/10 pt-3">
                    <div class="flex items-start gap-2">
                        @include('partials.ui-icon', ['name' => 'map-pin', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0 mt-0.5'])
                        <span>همدان، کبودرآهنگ، خیابان مطهری، پاساژ علاءالدین</span>
                    </div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <div class="flex items-center gap-1.5">
                            @include('partials.ui-icon', ['name' => 'phone', 'class' => 'w-3.5 h-3.5 text-amber-700 dark:text-amber-400 shrink-0'])
                            <a href="tel:09187009064" class="hover:text-amber-700 dark:hover:text-amber-400 tabular-nums font-semibold" dir="ltr">0918 700 9064</a>
                        </div>
                        <span class="text-stone-400">&middot;</span>
                        <div class="flex items-center gap-1.5">
                            <a href="tel:08135229063" class="hover:text-amber-700 dark:hover:text-amber-400 tabular-nums font-semibold" dir="ltr">081 3522 9063</a>
                        </div>
                    </div>
                </div>
                <div class="pt-1">
                    <a href="https://rubika.ir/talalive" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 min-h-11 px-4 py-2.5 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-semibold">
                        <span>ارتباط در روبیکا: talalive@</span>
                    </a>
                </div>
            </div>

            {{-- ستون ۲: سامانه‌ها و نمایشگرها --}}
            <div class="space-y-3">
                <div class="font-bold text-stone-900 dark:text-stone-100 text-sm flex items-center gap-2">
                    @include('partials.ui-icon', ['name' => 'monitor', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                    <span>سامانه‌ها و تابلوها</span>
                </div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('public.smart-gold-board') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">تابلوی هوشمند طلافروشی</a></li>
                    <li><a href="{{ route('public.digital-rate-board') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">تابلوی دیجیتال نرخ طلا و ارز</a></li>
                    <li><a href="{{ route('public.gold-board-without-device') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">تابلو طلا بدون خرید دستگاه</a></li>
                    <li><a href="{{ route('public.online-gold-price-board') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">تابلو آنلاین قیمت لحظه‌ای طلا</a></li>
                    <li><a href="{{ route('public.currency-exchange-board') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">تابلو نرخ صرافی و ارزها</a></li>
                    <li><a href="{{ route('public.silver-bullion-board') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">تابلوی شمش و آبشده نقره</a></li>
                    <li><a href="{{ route('public.demo') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">دموی آنلاین تابلوی طلا</a></li>
                    <li><a href="{{ route('public.app') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">اپلیکیشن اندروید تی‌وی و موبایل</a></li>
                </ul>
            </div>

            {{-- ستون ۳: ابزارهای محاسباتی طلا --}}
            <div class="space-y-3">
                <div class="font-bold text-stone-900 dark:text-stone-100 text-sm flex items-center gap-2">
                    @include('partials.ui-icon', ['name' => 'calculator', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                    <span>ابزارهای طلا و سکه</span>
                </div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('public.gold-calculator') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors font-semibold text-stone-800 dark:text-stone-200">ماشین حساب جامع طلا</a></li>
                    <li><a href="{{ route('public.tools.gold-price') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">محاسبه قیمت طلا با اجرت</a></li>
                    <li><a href="{{ route('public.tools.wage-calculator') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">فرمول محاسبه اجرت ساخت طلا</a></li>
                    <li><a href="{{ route('public.tools.second-hand-gold') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">محاسبه طلای مستعمل و کم‌اجرت</a></li>
                    <li><a href="{{ route('public.tools.coin-bubble') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">محاسبه آنلاین حباب انواع سکه</a></li>
                    <li><a href="{{ route('public.tools.mesghal') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">تبدیل مظنه مثقال به گرم ۱۸</a></li>
                    <li><a href="{{ route('public.tools.melted-gold') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">محاسبه و تبدیل طلای آبشده</a></li>
                    <li><a href="{{ route('public.tools.karat-converter') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">جدول و تبدیل عیار طلا</a></li>
                </ul>
            </div>

            {{-- ستون ۴: مقایسه‌ها و راهنماها --}}
            <div class="space-y-3">
                <div class="font-bold text-stone-900 dark:text-stone-100 text-sm flex items-center gap-2">
                    @include('partials.ui-icon', ['name' => 'scale', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                    <span>مقایسه و راهنما</span>
                </div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('public.led-vs-smart-board') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">مقایسه تابلو LED با تلویزیون</a></li>
                    <li><a href="{{ route('public.compare.tabangohar') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">مقایسه طلالایو با تابان گوهر</a></li>
                    <li><a href="{{ route('public.compare.tgju-tv') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">مقایسه طلالایو با TGJU TV</a></li>
                    <li><a href="{{ route('public.compare.tablotala') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">مقایسه با تابلوی سنتی طلا</a></li>
                    <li><a href="{{ route('public.tv-setup-guide') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">راهنمای اتصال تلویزیون</a></li>
                    <li><a href="{{ route('public.android-tv-gold-board') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">راهنمای اندروید باکس طلافروشی</a></li>
                    <li><a href="{{ route('public.pricing') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">تعرفه‌ها و پلن‌های اشتراک</a></li>
                </ul>
            </div>

            {{-- ستون ۵: بازار شهرها، API و حقوقی --}}
            <div class="space-y-3">
                <div class="font-bold text-stone-900 dark:text-stone-100 text-sm flex items-center gap-2">
                    @include('partials.ui-icon', ['name' => 'city', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                    <span>شهرها، وب‌سرویس و قوانین</span>
                </div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('public.cities.index') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors font-semibold text-stone-800 dark:text-stone-200">تابلو طلا در شهرهای ایران</a></li>
                    <li><a href="{{ route('public.guides') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">پایگاه دانش و مقالات طلا</a></li>
                    <li><a href="{{ route('public.widget') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">ویجت نرخ طلا برای سایت‌ها</a></li>
                    <li><a href="{{ route('public.api-docs') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">وب‌سرویس و API عمومی نرخ</a></li>
                    <li><a href="{{ route('public.about') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">درباره سامانه طلالایو</a></li>
                    <li><a href="{{ route('public.contact') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">تماس با ما و پشتیبانی</a></li>
                    <li><a href="{{ route('public.terms') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">قوانین و مقررات استفاده</a></li>
                    <li><a href="{{ route('public.privacy') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">حریم خصوصی کاربران</a></li>
                </ul>
            </div>

        </div>

        {{-- ردیف پیوندهای سریع قطب‌های بازار طلا در استان‌ها با هدف لمسی استاندارد --}}
        <div class="max-w-7xl mx-auto border-t border-stone-300/60 dark:border-white/10 mt-10 pt-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-xs">
                <div class="flex items-center gap-2 text-stone-800 dark:text-stone-200 font-semibold">
                    @include('partials.ui-icon', ['name' => 'map-pin', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                    <span>تابلو طلا در قطب‌های بازار زرگری ایران:</span>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    @foreach(['tehran' => 'تهران', 'mashhad' => 'مشهد', 'isfahan' => 'اصفهان', 'tabriz' => 'تبریز', 'shiraz' => 'شیراز', 'hamedan' => 'همدان', 'yazd' => 'یزد', 'qom' => 'قم', 'ahvaz' => 'اهواز', 'rasht' => 'رشت'] as $citySlug => $cityName)
                        <a href="{{ route('public.cities.hub', $citySlug) }}" class="min-h-11 px-3.5 py-2 inline-flex items-center rounded-xl tl-neu-btn text-stone-700 dark:text-stone-300 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-medium">{{ $cityName }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- حق کپی‌رایت و مالکیت معنوی --}}
        <div class="max-w-7xl mx-auto border-t border-stone-300/60 dark:border-white/10 mt-6 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-right text-xs text-stone-600 dark:text-stone-400">
            <div>
                تمامی حقوق مادی و معنوی برای سامانه ابری تابلوی طلافروشی طلالایو (TalaLive.ir) محفوظ است &copy; {{ \App\Models\User::jalaliYear() }}.
            </div>
            <div class="flex items-center gap-4 text-stone-600 dark:text-stone-400">
                <span>پشتیبانی فنی: <a href="tel:09187009064" class="hover:text-amber-700 dark:hover:text-amber-400 tabular-nums font-semibold" dir="ltr"><bdi dir="ltr">0918 700 9064</bdi></a></span>
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

                init() {
                    this.lastScrollY = window.scrollY || 0;
                    let ticking = false;
                    window.addEventListener('scroll', () => {
                        if (!ticking) {
                            window.requestAnimationFrame(() => {
                                const currentY = window.scrollY || 0;
                                const delta = currentY - this.lastScrollY;
                                if (currentY <= 80 || this.mobileMenuOpen) {
                                    this.isScrolledDown = false;
                                    this.lastScrollY = currentY;
                                } else if (Math.abs(delta) >= 12) {
                                    if (delta > 0 && currentY > 120) {
                                        this.isScrolledDown = true;
                                        this.closeAllMenus();
                                    } else if (delta < 0) {
                                        this.isScrolledDown = false;
                                    }
                                    this.lastScrollY = currentY;
                                }
                                ticking = false;
                            });
                            ticking = true;
                        }
                    }, { passive: true });
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
                    this.isScrolledDown = false;
                    this.mobileMenuOpen = true;
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

    {{-- موتور انیمیشن‌های تنبل اسکرول اپل (Apple Scroll Reveal Engine) --}}
    <script>
        (function() {
            function initScrollReveal() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    document.querySelectorAll('.tl-reveal, .tl-reveal-scale').forEach(function(el) {
                        el.classList.add('is-revealed');
                    });
                    return;
                }
                var observer = new IntersectionObserver(function(entries, obs) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            obs.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.08,
                    rootMargin: '0px 0px -36px 0px'
                });

                document.querySelectorAll('.tl-reveal, .tl-reveal-scale').forEach(function(el) {
                    observer.observe(el);
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initScrollReveal);
            } else {
                initScrollReveal();
            }
        })();
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
