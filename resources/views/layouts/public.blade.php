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
    <meta name="description" content="@yield('meta_description', 'سامانه ابری تابلوی هوشمند طلافروشی و نمایشگر آنلاین نرخ طلا و سکه برای مغازه طلا فروشی. اتصال تلویزیون بدون نیاز به کیس، فرمول‌ساز سود و ویترین لوکس در طلالایو.')">
    <meta name="keywords" content="@yield('meta_keywords', 'تابلوی هوشمند طلافروشی, تابلوی طلا فروشی, تابلو طلا فروشی, نرم افزار تابلوی طلا, تابلو قیمت طلا برای تلویزیون, تابلو دیجیتال طلافروشی, نرم افزار طلا فروشی, محاسبه قیمت طلا, طلالایو')">
    <meta name="robots" content="index, follow">
    <meta name="author" content="طلالایو - TalaLive">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'سامانه هوشمند تابلوی طلافروشی و نمایشگر طلا فروشی | طلالایو')">
    <meta property="og:description" content="@yield('meta_description', 'سامانه ابری تابلوی هوشمند نرخ لحظه‌ای طلا، سکه و ارز ویژه تلویزیون مغازه‌های طلافروشی و طلا فروشی‌ها.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="طلالایو">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:locale" content="fa_IR">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'سامانه هوشمند تابلوی طلافروشی و نمایشگر طلا فروشی | طلالایو')">
    <meta name="twitter:description" content="@yield('meta_description', 'نمایش آنلاین و لحظه‌ای نرخ طلا و مسکوکات روی تلویزیون مغازه طلافروشی و طلا فروشی بدون مینی‌کیس.')">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">

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
            "نمایشگر نرخ طلا فروشی"
          ],
          "url": "https://talalive.ir",
          "logo": "https://talalive.ir/images/logo.png",
          "foundingDate": "2024",
          "description": "نخستین و پیشرفته‌ترین سامانه ابری تابلوی هوشمند اعلام نرخ طلا، سکه و ارز و ویترین دیجیتال گالری‌های طلا و جواهر و مغازه طلا فروشی بدون نیاز به مینی‌کیس.",
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
                    <img src="{{ asset('images/logo.png') }}" class="h-8 w-8 sm:h-11 sm:w-11 object-contain pulse-logo rounded-xl sm:rounded-2xl shadow-md shadow-amber-500/10 bg-white dark:bg-slate-900/60 p-1 border border-slate-200 dark:border-slate-700/60" alt="لوگوی طلالایو">
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

            {{-- نوار ناوبری کپسولی مدرن (Desktop Navigation) --}}
            <nav class="hidden lg:flex items-center gap-1 p-1 rounded-2xl bg-slate-100/90 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800/80 text-xs font-bold text-slate-600 dark:text-slate-300">
                <a href="/" class="px-3 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all {{ request()->is('/') ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                    صفحه اصلی
                </a>
                <a href="{{ route('public.smart-gold-board') }}" class="px-3 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all {{ request()->routeIs('public.smart-gold-board') ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                    تابلوی هوشمند
                </a>
                <a href="{{ route('public.led-vs-smart-board') }}" class="px-3 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all {{ request()->routeIs('public.led-vs-smart-board') ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                    مقایسه با تابلو LED
                </a>
                <a href="{{ route('public.pricing') }}" class="px-3 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all {{ request()->routeIs('public.pricing') ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                    تعرفه‌ها
                </a>
                <a href="{{ route('public.tv-setup-guide') }}" class="px-3 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all {{ request()->routeIs('public.tv-setup-guide') ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                    راهنمای تلویزیون
                </a>

                {{-- منوی دراپ‌داون ابزارها و آموزش --}}
                <div class="relative" @mouseenter="toolsDropdownOpen = true" @mouseleave="toolsDropdownOpen = false">
                    <button type="button" @click="toolsDropdownOpen = !toolsDropdownOpen" class="flex items-center gap-1 px-3 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all cursor-pointer {{ (request()->is('tools/*') || request()->routeIs('public.gold-calculator') || request()->routeIs('public.guides*')) ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
                        <span>ابزارها و آموزش</span>
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
                        
                        <a href="{{ route('public.tools.gold-price') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">🧮</span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">محاسبه قیمت طلا با اجرت و سود</div>
                            </div>
                        </a>

                        <a href="{{ route('public.tools.coin-bubble') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">🪙</span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">محاسبه‌گر حباب انواع سکه</div>
                            </div>
                        </a>

                        <a href="{{ route('public.tools.mesghal') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">⚖️</span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">تبدیل مظنه مثقال به گرم ۱۸ عیار</div>
                            </div>
                        </a>

                        <a href="{{ route('public.tools.melted-gold') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">🔥</span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">محاسبه طلای آبشده و عیار انگ</div>
                            </div>
                        </a>

                        <a href="{{ route('public.tools.karat-converter') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <span class="text-sm">🔄</span>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">تبدیل عیارهای طلا (۷۵۰ به ۷۰۵...)</div>
                            </div>
                        </a>

                        <div class="pt-1 border-t border-slate-100 dark:border-slate-800">
                            <a href="{{ route('public.guides') }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-blue-50 dark:hover:bg-slate-800/60 group transition-all">
                                <span class="text-sm">📚</span>
                                <div>
                                    <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400">دانشنامه و مقالات تخصصی طلا</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="/#faq" class="px-3 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all">
                    سوالات متداول
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

                {{-- دکمه ورود --}}
                <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1 px-2 sm:px-4 py-1.5 sm:py-2.5 rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white/90 dark:bg-slate-900/60 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-bold transition-all shadow-sm cursor-pointer whitespace-nowrap">
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
             class="lg:hidden border-b border-slate-200 dark:border-slate-800 bg-white/98 dark:bg-slate-950/98 backdrop-blur-2xl px-5 py-6 space-y-5 shadow-2xl max-h-[85vh] overflow-y-auto">
            
            {{-- خدمات اصلی --}}
            <div>
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-2.5">سامانه و خدمات</div>
                <nav class="flex flex-col space-y-1 text-sm font-bold text-slate-700 dark:text-slate-200">
                    <a href="/" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2.5 {{ request()->is('/') ? 'text-amber-600 dark:text-amber-400 bg-amber-50/50 dark:bg-slate-800/60' : '' }}">
                        <span class="text-base">📺</span>
                        <span>صفحه اصلی و اتصال تلویزیون</span>
                    </a>
                    <a href="{{ route('public.smart-gold-board') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2.5 {{ request()->routeIs('public.smart-gold-board') ? 'text-amber-600 dark:text-amber-400 bg-amber-50/50 dark:bg-slate-800/60' : '' }}">
                        <span class="text-base">💎</span>
                        <span>تابلوی هوشمند طلافروشی</span>
                    </a>
                    <a href="{{ route('public.led-vs-smart-board') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2.5 {{ request()->routeIs('public.led-vs-smart-board') ? 'text-amber-600 dark:text-amber-400 bg-amber-50/50 dark:bg-slate-800/60' : '' }}">
                        <span class="text-base">⚡</span>
                        <span>مقایسه با تابلو LED</span>
                    </a>
                    <a href="{{ route('public.pricing') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2.5 {{ request()->routeIs('public.pricing') ? 'text-amber-600 dark:text-amber-400 bg-amber-50/50 dark:bg-slate-800/60' : '' }}">
                        <span class="text-base">🏷️</span>
                        <span>تعرفه‌ها و اشتراک</span>
                    </a>
                    <a href="{{ route('public.tv-setup-guide') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2.5 {{ request()->routeIs('public.tv-setup-guide') ? 'text-amber-600 dark:text-amber-400 bg-amber-50/50 dark:bg-slate-800/60' : '' }}">
                        <span class="text-base">📖</span>
                        <span>راهنمای اتصال تلویزیون</span>
                    </a>
                </nav>
            </div>

            {{-- ابزارهای تخصصی طلا --}}
            <div>
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-2.5">ابزارهای آنلاین و محاسبه‌گرها</div>
                <nav class="flex flex-col space-y-1 text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <a href="{{ route('public.tools.gold-price') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2.5 {{ request()->routeIs('public.tools.gold-price') ? 'text-amber-600 dark:text-amber-400 bg-amber-50/50 dark:bg-slate-800/60 font-bold' : '' }}">
                        <span>🧮</span>
                        <span>محاسبه قیمت طلا با اجرت و سود</span>
                    </a>
                    <a href="{{ route('public.tools.coin-bubble') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2.5 {{ request()->routeIs('public.tools.coin-bubble') ? 'text-amber-600 dark:text-amber-400 bg-amber-50/50 dark:bg-slate-800/60 font-bold' : '' }}">
                        <span>🪙</span>
                        <span>محاسبه‌گر حباب انواع سکه</span>
                    </a>
                    <a href="{{ route('public.tools.mesghal') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2.5 {{ request()->routeIs('public.tools.mesghal') ? 'text-amber-600 dark:text-amber-400 bg-amber-50/50 dark:bg-slate-800/60 font-bold' : '' }}">
                        <span>⚖️</span>
                        <span>تبدیل مظنه مثقال به گرم ۱۸ عیار</span>
                    </a>
                    <a href="{{ route('public.tools.melted-gold') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2.5 {{ request()->routeIs('public.tools.melted-gold') ? 'text-amber-600 dark:text-amber-400 bg-amber-50/50 dark:bg-slate-800/60 font-bold' : '' }}">
                        <span>🔥</span>
                        <span>محاسبه طلای آبشده و عیار خطی</span>
                    </a>
                    <a href="{{ route('public.tools.karat-converter') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2.5 {{ request()->routeIs('public.tools.karat-converter') ? 'text-amber-600 dark:text-amber-400 bg-amber-50/50 dark:bg-slate-800/60 font-bold' : '' }}">
                        <span>🔄</span>
                        <span>تبدیل عیار طلا (۷۵۰ به سایر عیارها)</span>
                    </a>
                    <a href="{{ route('public.guides') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2.5 {{ request()->routeIs('public.guides*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50/50 dark:bg-slate-800/60 font-bold' : '' }}">
                        <span>📚</span>
                        <span>دانشنامه و مقالات تخصصی طلا</span>
                    </a>
                </nav>
            </div>

            {{-- درباره و تماس --}}
            <div class="pt-2 border-t border-slate-200 dark:border-slate-800 flex items-center justify-around text-xs text-slate-500 dark:text-slate-400 font-medium">
                <a href="{{ route('public.about') }}" class="hover:text-amber-500">درباره ما</a>
                <span>&bull;</span>
                <a href="{{ route('public.contact') }}" class="hover:text-amber-500">تماس با ما</a>
                <span>&bull;</span>
                <a href="{{ route('public.terms') }}" class="hover:text-amber-500">قوانین و حریم خصوصی</a>
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

    {{-- فوتر معنایی و جامع سئو --}}
    <footer class="border-t border-slate-800/80 bg-slate-950 text-slate-400 text-xs py-14 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
            
            {{-- ستون ۱: معرفی طلالایو و اعتماد --}}
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" class="h-10 w-10 object-contain rounded-xl bg-slate-900 border border-slate-800 p-1" alt="طلالایو">
                    <div>
                        <div class="text-base font-black text-amber-400">طلالایو &middot; TalaLive</div>
                        <p class="text-[11px] text-slate-500">سامانه ابری تابلوی هوشمند نرخ طلا و سکه</p>
                    </div>
                </div>
                <p class="text-slate-400 text-xs leading-relaxed">
                    طلالایو پیشرفته‌ترین سامانه تابلوی طلافروشی مبتنی بر فناوری ابری در ایران است. بدون نیاز به کامپیوتر یا دانگل مجزا، هر نوع تلویزیون در مغازه طلا فروشی را به تابلوی اختصاصی نرخ لحظه‌ای طلا، سکه، حباب بازار و ویترین جواهرات بدل کنید.
                </p>
                <div class="flex items-center gap-3 text-xs text-slate-500 pt-1">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>آپ‌تایم ۹۹.۹٪</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span>۱۴ روز تست رایگان</span>
                    </span>
                </div>
            </div>

            {{-- ستون ۲: خدمات و مقایسه‌ها --}}
            <div class="space-y-3">
                <div class="font-bold text-white text-sm">سامانه و تابلوی هوشمند</div>
                <ul class="space-y-2 text-xs">
                    <li><a href="/" class="hover:text-amber-400 transition-colors">صفحه اصلی و اتصال تلویزیون</a></li>
                    <li><a href="{{ route('public.smart-gold-board') }}" class="hover:text-amber-400 transition-colors">تابلوی هوشمند طلافروشی و طلا فروشی</a></li>
                    <li><a href="{{ route('public.led-vs-smart-board') }}" class="hover:text-amber-400 transition-colors font-bold text-amber-300">مقایسه تابلوی هوشمند با تابلو LED</a></li>
                    <li><a href="{{ route('public.pricing') }}" class="hover:text-amber-400 transition-colors">تعرفه‌ها و قیمت تابلو طلا فروشی</a></li>
                    <li><a href="{{ route('public.tv-setup-guide') }}" class="hover:text-amber-400 transition-colors">راهنمای اتصال تلویزیون مغازه</a></li>
                    <li><a href="{{ route('admin.login') }}" class="hover:text-amber-400 transition-colors">ورود به پنل مدیریت گالری</a></li>
                    <li><a href="{{ route('admin.register') }}" class="hover:text-amber-400 transition-colors">ثبت‌نام گالری جدید</a></li>
                </ul>
            </div>

            {{-- ستون ۳: ابزارهای زرگری و محاسباتی --}}
            <div class="space-y-3">
                <div class="font-bold text-white text-sm">ابزارهای آنلاین زرگری</div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('public.tools.gold-price') }}" class="hover:text-amber-400 transition-colors">محاسبه قیمت طلا با سود و اجرت</a></li>
                    <li><a href="{{ route('public.tools.coin-bubble') }}" class="hover:text-amber-400 transition-colors">محاسبه‌گر آنلاین حباب انواع سکه</a></li>
                    <li><a href="{{ route('public.tools.mesghal') }}" class="hover:text-amber-400 transition-colors">فرمول تبدیل مظنه مثقال به گرم</a></li>
                    <li><a href="{{ route('public.tools.melted-gold') }}" class="hover:text-amber-400 transition-colors">محاسبه طلای آب شده و عیار خطی</a></li>
                    <li><a href="{{ route('public.tools.karat-converter') }}" class="hover:text-amber-400 transition-colors">تبدیل عیار طلا (۷۵۰ به سایر عیارها)</a></li>
                    <li><a href="{{ route('public.guides') }}" class="hover:text-blue-400 transition-colors">دانشنامه تخصصی و مقالات صنف طلا</a></li>
                </ul>
            </div>

            {{-- ستون ۴: اطلاعات تماس و اعتماد صنف --}}
            <div class="space-y-3">
                <div class="font-bold text-white text-sm">ارتباط و اعتماد قانونی</div>
                <div class="space-y-2 text-xs">
                    <p class="text-slate-300">
                        <span class="text-slate-500">پشتیبانی تلفنی و روبیکا:</span>
                        <a href="tel:09187009064" class="font-mono font-bold text-slate-200 hover:text-amber-400 block" dir="ltr">0918 700 9064</a>
                    </p>
                    <p class="text-slate-300">
                        <span class="text-slate-500">تلفن دفتر پشتیبانی:</span>
                        <a href="tel:08135223847" class="font-mono font-bold text-slate-200 hover:text-amber-400 block" dir="ltr">081 3522 3847</a>
                    </p>
                    <div class="pt-1">
                        <a href="https://rubika.ir/talalive" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white text-xs font-bold shadow-sm transition-all">
                            <img src="/images/logos/rubika.png" onerror="this.src='/icons/icon-72x72.png'" class="w-4 h-4 object-contain rounded-md" alt="روبیکا">
                            <span>ارتباط در پیام‌رسان روبیکا</span>
                        </a>
                    </div>
                    <ul class="space-y-1 text-[11px] text-slate-400 pt-2">
                        <li><a href="{{ route('public.about') }}" class="hover:text-amber-400 transition-colors">&larr; درباره سامانه طلالایو</a></li>
                        <li><a href="{{ route('public.contact') }}" class="hover:text-amber-400 transition-colors">&larr; تماس با تیم پشتیبانی و نشانی</a></li>
                        <li><a href="{{ route('public.terms') }}" class="hover:text-amber-400 transition-colors">&larr; شرایط استفاده از خدمات</a></li>
                        <li><a href="{{ route('public.privacy') }}" class="hover:text-amber-400 transition-colors">&larr; حریم خصوصی و امنیت داده‌ها</a></li>
                    </ul>
                </div>
            </div>

        </div>

        {{-- ابر کلمات کلیدی سئو و کپی‌رایت --}}
        <div class="max-w-7xl mx-auto border-t border-slate-800/80 mt-10 pt-6 space-y-4">
            <div class="flex flex-wrap items-center justify-center gap-2 text-[11px] text-slate-500">
                <span class="text-slate-400 font-bold">دسترسی سریع کلمات کلیدی:</span>
                <a href="{{ route('public.smart-gold-board') }}" class="text-slate-400 hover:text-amber-400">تابلوی هوشمند طلافروشی</a>
                <span>&bull;</span>
                <a href="{{ route('public.smart-gold-board') }}" class="text-slate-400 hover:text-amber-400">تابلو طلا فروشی</a>
                <span>&bull;</span>
                <a href="{{ route('public.smart-gold-board') }}" class="text-slate-400 hover:text-amber-400">تابلوی طلا فروشی</a>
                <span>&bull;</span>
                <a href="{{ route('public.led-vs-smart-board') }}" class="text-slate-400 hover:text-amber-400">تابلو ال ای دی طلا فروشی</a>
                <span>&bull;</span>
                <a href="{{ route('public.smart-gold-board') }}" class="text-slate-400 hover:text-amber-400">نرم‌افزار تابلوی زنده طلا</a>
                <span>&bull;</span>
                <a href="{{ route('public.tv-setup-guide') }}" class="text-slate-400 hover:text-amber-400">تابلو قیمت طلا برای تلویزیون</a>
                <span>&bull;</span>
                <a href="{{ route('public.tools.gold-price') }}" class="text-slate-400 hover:text-amber-400">محاسبه آنلاین قیمت طلا با اجرت</a>
                <span>&bull;</span>
                <a href="{{ route('public.tools.coin-bubble') }}" class="text-slate-400 hover:text-amber-400">حباب‌سنج سکه امامی و نیم‌سکه</a>
                <span>&bull;</span>
                <a href="{{ route('public.tools.mesghal') }}" class="text-slate-400 hover:text-amber-400">فرمول مظنه مثقال طلا به گرم</a>
                <span>&bull;</span>
                <a href="{{ route('public.tools.melted-gold') }}" class="text-slate-400 hover:text-amber-400">محاسبه آنلاین طلای آب شده</a>
                <span>&bull;</span>
                <a href="{{ route('public.pricing') }}" class="text-slate-400 hover:text-amber-400">قیمت تابلو طلا فروشی</a>
            </div>
            
            <div class="text-center text-[11px] text-slate-500">
                تمامی حقوق مادی و معنوی متعلق به سامانه طلالایو (TalaLive.ir) می‌باشد &copy; {{ date('Y') }}. طراحی شده با بالاترین استانداردهای امنیتی ابری ویژه اتحادیه و صنف طلا و جواهر کشور.
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        function publicLayoutHandler() {
            return {
                darkMode: document.documentElement.classList.contains('dark'),
                mobileMenuOpen: false,
                toolsDropdownOpen: false,

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
