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

    <title>تابلوی هوشمند طلافروشی و تابلو طلا فروشی | نرخ زنده طلالایو</title>
    <meta name="description" content="سامانه ابری تابلوی هوشمند نرخ لحظه‌ای طلا، سکه و ارز ویژه نمایشگر مغازه طلافروشی و طلا فروشی. اتصال سریع تلویزیون بدون نیاز به کیس، فرمول‌ساز سود و ویترین دیجیتال در طلالایو.">
    <meta name="keywords" content="تابلوی هوشمند طلافروشی, تابلوی طلا فروشی, تابلو طلا فروشی, نرم افزار تابلو طلا فروشی, تابلو قیمت طلا برای تلویزیون, سیستم تابلوی طلا, تابلو دیجیتال طلافروشی, نرخ لحظه ای طلا, طلالایو, talalive">
    <meta name="robots" content="index, follow">
    <meta name="author" content="طلالایو - TalaLive">
    <link rel="canonical" href="https://talalive.ir/">

    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="تابلوی هوشمند طلافروشی و نمایشگر نرخ مغازه طلا فروشی | طلالایو">
    <meta property="og:description" content="نمایش آنلاین و لحظه‌ای نرخ طلا و مسکوکات روی تلویزیون مغازه طلافروشی و طلا فروشی با طلالایو. اتصال آسان بدون کابل یا سخت‌افزار اضافه.">
    <meta property="og:url" content="https://talalive.ir/">
    <meta property="og:site_name" content="طلالایو">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:locale" content="fa_IR">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="تابلوی هوشمند طلافروشی و نمایشگر نرخ مغازه طلا فروشی | طلالایو">
    <meta name="twitter:description" content="نمایش آنلاین و لحظه‌ای نرخ طلا و مسکوکات روی تلویزیون مغازه طلافروشی و طلا فروشی با طلالایو. بدون نیاز به مینی‌کیس و کامپیوتر.">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">

    <!-- Schema.org JSON-LD Structured Data (4-in-1 Suite) -->
    <script type="application/ld+json">
    {!! json_encode([
      '@' . 'context' => "https://schema.org",
      "@graph" => [
        [
          "@type" => ["SoftwareApplication", "WebApplication"],
          "@id" => "https://talalive.ir/#software",
          "name" => "طلالایو - سامانه تابلوی طلافروشی و طلا فروشی",
          "alternateName" => [
            "TalaLive",
            "تابلوی طلا فروشی",
            "تابلو طلا فروشی",
            "نرم‌افزار تابلوی طلا فروشی",
            "سیستم نمایش نرخ مغازه طلا فروشی"
          ],
          "url" => "https://talalive.ir",
          "description" => "سامانه ابری هوشمند تابلوی نرخ لحظه‌ای طلا، سکه و ارز ویژه تلویزیون‌ها و نمایشگرهای طلافروشی، مغازه طلا فروشی و گالری‌های طلا و جواهر سراسر کشور.",
          "applicationCategory" => "BusinessApplication",
          "operatingSystem" => "Smart TV (Samsung Tizen, LG webOS, Android TV), Web Browser, Android, Windows",
          "screenshot" => "https://talalive.ir/images/logo.png",
          "softwareVersion" => "2.5",
          "aggregateRating" => [
            "@type" => "AggregateRating",
            "ratingValue" => "4.9",
            "ratingCount" => "135",
            "bestRating" => "5",
            "worstRating" => "1"
          ],
          "offers" => [
            "@type" => "Offer",
            "price" => "0",
            "priceCurrency" => "IRR",
            "category" => "Free Trial"
          ],
          "featureList" => [
            "اتصال بی‌سیم به انواع تلویزیون هوشمند با اسکن بارکد",
            "بروزرسانی خودکار و لحظه‌ای نرخ طلای ۱۸ عیار، ۲۴ عیار، مظنه، انس و سکه",
            "فرمول‌ساز و تنظیم حاشیه سود اختصاصی هر طلافروشی",
            "قابلیت کارکرد آفلاین هوشمند در صورت قطعی موقت اینترنت",
            "اسلایدشو و ویترین دیجیتال طلا و جواهر در کنار نرخ‌ها",
            "پشتیبانی از تمامی برندهای تلویزیون بدون نیاز به کیس یا کابل"
          ]
        ],
        [
          "@type" => "Organization",
          "@id" => "https://talalive.ir/#organization",
          "name" => "طلالایو (TalaLive)",
          "url" => "https://talalive.ir",
          "logo" => "https://talalive.ir/images/logo.png",
          "contactPoint" => [
            [
              "@type" => "ContactPoint",
              "telephone" => "+989187009064",
              "contactType" => "customer support",
              "areaServed" => "IR",
              "availableLanguage" => ["Persian"]
            ],
            [
              "@type" => "ContactPoint",
              "telephone" => "+988135223847",
              "contactType" => "technical support",
              "areaServed" => "IR",
              "availableLanguage" => ["Persian"]
            ]
          ]
        ],
        [
          "@type" => "BreadcrumbList",
          "@id" => "https://talalive.ir/#breadcrumb",
          "itemListElement" => [
            [
              "@type" => "ListItem",
              "position" => 1,
              "name" => "صفحه اصلی",
              "item" => "https://talalive.ir"
            ],
            [
              "@type" => "ListItem",
              "position" => 2,
              "name" => "تابلوی هوشمند طلافروشی",
              "item" => "https://talalive.ir/#features"
            ]
          ]
        ],
        [
          "@type" => "FAQPage",
          "@id" => "https://talalive.ir/#faq",
          "mainEntity" => [
            [
              "@type" => "Question",
              "name" => "آیا برای راه‌اندازی تابلوی طلالایو نیاز به خرید کامپیوتر یا دستگاه جداگانه در مغازه هست؟",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "خیر، هیچ نیازی به خرید مینی‌کیس، کامپیوتر یا دانگل اضافه نیست. شما می‌توانید تنها با استفاده از مرورگر وب داخلی هر نوع تلویزیون هوشمند (سامسونگ، ال‌جی، سونی، اسنوا، دوو یا اندروید تی‌وی) و اسکن یکبار QR کد، تابلوی اختصاصی طلافروشی خود را بدون سیم‌کشی راه‌اندازی کنید."
              ]
            ],
            [
              "@type" => "Question",
              "name" => "نرخ‌های طلا، سکه و ارز از چه مراجعی بروزرسانی می‌شوند؟",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "نرخ‌ها به صورت خودکار و لحظه‌ای از معتبرترین مراجع رسمی بازار طلا و جواهر کشور، اتحادیه‌های طلا و سکه و مراجع رسمی انس جهانی دریافت می‌شوند و به صورت بلادرنگ روی تابلوی شما آپدیت می‌گردند."
              ]
            ],
            [
              "@type" => "Question",
              "name" => "در صورت قطعی موقت اینترنت در طلافروشی چه اتفاقی می‌افتد؟",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "طلالایو مجهز به فناوری کش هوشمند آفلاین است. در صورت قطعی اینترنت، تابلوی شما هرگز سیاه یا متوقف نمی‌شود؛ بلکه آخرین نرخ‌های دریافتی معتبر را با برچسب ساعت آخرین بروزرسانی همراه با ویترین محصولات به نمایش مداوم ادامه می‌دهد."
              ]
            ],
            [
              "@type" => "Question",
              "name" => "چگونه می‌توان فرمول سود، اجرت یا مظنه را برای طلافروشی شخصی‌سازی کرد؟",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "از طریق پنل مدیریت موبایل یا کامپیوتر، بخش فرمول‌ساز هوشمند در اختیارتان قرار دارد که می‌توانید درصد سود فروش، حاشیه خرید، مالیات و تخفیف‌ها را به ازای هر گرم یا نوع سکه اختصاصی‌سازی کنید تا نرخ‌ها مطابق با سیاست مالی گالری شما محاسبه و نمایش یابند."
              ]
            ],
            [
              "@type" => "Question",
              "name" => "آیا امکان نمایش تصاویر محصولات و ویترین جواهرات در کنار نرخ‌ها وجود دارد؟",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "بله، در پنل مدیریت می‌توانید عکس‌های باکیفیت النگو، نیم‌ست، سرویس و مدل‌های روز طلا را به همراه مشخصات و QR کد اختصاصی اینستاگرام مغازه بارگذاری کنید تا در قالب اسلایدشوی لوکس در کنار نرخ‌های زنده طلا برای مشتریان پخش شوند."
              ]
            ],
            [
              "@type" => "Question",
              "name" => "آیا اتصال تلویزیون پس از هر بار خاموش و روشن شدن مغازه قطع می‌شود؟",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "خیر، اطلاعات اتصال تلویزیون شما در حافظه پایدار مرورگر تلویزیون به صورت خودکار ذخیره می‌شود و با روشن شدن تلویزیون، صفحه بدون نیاز به اسکن مجدد فوراً باز شده و به تابلوی زنده شما متصل می‌گردد."
              ]
            ]
          ]
        ]
      ]
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    @vite('resources/css/app.css')
    <script defer src="{{ asset('vendor/alpinejs.min.js') }}"></script>

    <style>
        body {
            font-family: Vazirmatn, ui-sans-serif, system-ui, sans-serif;
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
        [x-cloak] { display: none !important; }
        @keyframes pulse-glow {
            0%, 100% { transform: scale(1); opacity: 0.85; }
            50% { transform: scale(1.06); opacity: 1; }
        }
        .pulse-logo {
            animation: pulse-glow 3s ease-in-out infinite;
        }
        @keyframes subtle-shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-shimmer {
            animation: subtle-shimmer 3.5s infinite;
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
            border-color: rgba(245, 158, 11, 0.5);
            box-shadow: 0 14px 35px -10px rgba(245, 158, 11, 0.15);
        }
        details > summary::-webkit-details-marker {
            display: none;
        }
        details[open] summary .faq-icon {
            transform: rotate(180deg);
        }
    </style>
</head>
<body x-data="publicLandingHandler()" class="bg-slate-50 dark:bg-[#020617] text-slate-800 dark:text-slate-100 selection:bg-amber-500/30 selection:text-amber-700 dark:selection:text-amber-200 antialiased overflow-x-hidden min-h-screen transition-colors duration-300">

    {{-- بررسی اولیه در کلاینت برای ریدایرکت سریع در صورت جفت شدن قبلی تلویزیون یا پاکسازی اتصال با پارامتر reset --}}
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('reset') === '1' || urlParams.get('disconnect') === '1') {
            localStorage.removeItem('display_username');
            localStorage.removeItem('display_token');
        } else {
            const savedUsername = localStorage.getItem('display_username');
            const savedToken = localStorage.getItem('display_token');
            if (savedUsername && savedToken) {
                window.location.href = '/' + savedUsername + '?key=' + savedToken;
            }
        }
    </script>

    {{-- نوار ناوبری شیشه‌ای بالایی مدرن با پشتیبانی از تم تاریک و روشن (Sticky Modern Header) --}}
    <header class="sticky top-0 z-50 w-full backdrop-blur-xl bg-white/85 dark:bg-slate-950/85 border-b border-slate-200/80 dark:border-slate-800/80 transition-all duration-300 shadow-sm dark:shadow-none">
        <div class="max-w-7xl mx-auto px-2.5 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-1.5 sm:gap-4">
            
            {{-- لوگو و نام برند --}}
            <a href="/" class="flex items-center gap-1.5 sm:gap-3 group shrink-0 min-w-0">
                <div class="relative shrink-0">
                    <img src="{{ asset('images/logo.png') }}" class="h-8 w-8 sm:h-11 sm:w-11 object-contain pulse-logo rounded-xl sm:rounded-2xl shadow-md shadow-amber-500/10 bg-white dark:bg-slate-900/60 p-1 border border-slate-200 dark:border-slate-700/60" alt="لوگوی سامانه طلالایو">
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
                <a href="{{ route('public.smart-gold-board') }}" class="px-3.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all">
                    تابلوی هوشمند
                </a>
                <a href="{{ route('public.tv-setup-guide') }}" class="px-3.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all">
                    راهنمای تلویزیون
                </a>

                {{-- منوی دراپ‌داون ابزارها و آموزش --}}
                <div class="relative" @mouseenter="toolsDropdownOpen = true" @mouseleave="toolsDropdownOpen = false">
                    <button type="button" @click="toolsDropdownOpen = !toolsDropdownOpen" class="flex items-center gap-1 px-3.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all cursor-pointer">
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
                        
                        <a href="{{ route('public.gold-calculator') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">ماشین‌حساب زنده طلا و حباب</div>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">محاسبه قیمت طلا با اجرت و حباب سکه</p>
                            </div>
                        </a>

                        <a href="{{ route('public.guides') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400">دانشنامه و مقالات تخصصی</div>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">راهنماهای مظنه، عیار و استانداردهای طلا</p>
                            </div>
                        </a>

                        <a href="#comparison" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400">مقایسه با تابلوهای سنتی</div>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">بررسی مزایا نسبت به تابلوهای LED</p>
                            </div>
                        </a>
                    </div>
                </div>

                <a href="#pricing" class="px-3.5 py-2 rounded-xl text-amber-600 dark:text-amber-400 font-black hover:bg-white dark:hover:bg-slate-800/70 transition-all flex items-center gap-1">
                    <span>تعرفه‌ها و اشتراک</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-amber-500/20 text-amber-700 dark:text-amber-300 font-bold">آنلاین</span>
                </a>
                <a href="#faq" class="px-3.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all">
                    سوالات متداول
                </a>
                <a href="#contact" class="px-3.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all">
                    پشتیبانی و تماس
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
             class="lg:hidden border-b border-slate-200 dark:border-slate-800 bg-white/95 dark:bg-slate-950/95 backdrop-blur-2xl px-6 py-6 space-y-4 shadow-2xl">
            <nav class="flex flex-col space-y-1.5 text-sm font-bold text-slate-700 dark:text-slate-200">
                <a href="{{ route('public.smart-gold-board') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center gap-2">
                    <span>تابلوی هوشمند طلافروشی</span>
                </a>
                <a href="{{ route('public.tv-setup-guide') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center gap-2">
                    <span>راهنمای اتصال تلویزیون</span>
                </a>
                <a href="{{ route('public.gold-calculator') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center gap-2">
                    <span>ماشین‌حساب زنده طلا و حباب سکه</span>
                </a>
                <a href="{{ route('public.guides') }}" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center gap-2">
                    <span>دانشنامه و مقالات تخصصی</span>
                </a>
                <a href="#comparison" @click="mobileMenuOpen = false" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center gap-2">
                    <span>مقایسه با تابلوهای سنتی</span>
                </a>
                <a href="#pricing" @click="mobileMenuOpen = false" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center justify-between text-amber-600 dark:text-amber-400">
                    <span>تعرفه‌ها و خرید اشتراک</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-500/20 font-bold">ویژه</span>
                </a>
                <a href="#faq" @click="mobileMenuOpen = false" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center gap-2">
                    <span>سوالات متداول طلافروشان</span>
                </a>
                <a href="#contact" @click="mobileMenuOpen = false" class="p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center gap-2">
                    <span>پشتیبانی و تماس</span>
                </a>
            </nav>

            <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-2.5">
                <a href="{{ route('admin.login') }}" class="w-full text-center py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-200 text-xs font-bold">
                    ورود طلافروشان
                </a>
                <a href="{{ route('admin.register') }}" class="w-full text-center py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 text-xs font-black shadow-md">
                    ثبت‌نام گالری جدید
                </a>
            </div>
        </div>
    </header>

    {{-- بخش ۱: هیرو سکشن و جفت‌سازی تلویزیون هوشمند (Hero & Pairing Hub) --}}
    <section id="hero-pairing" class="relative min-h-[calc(100vh-80px)] flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-10 lg:py-16 overflow-hidden">
        
        {{-- افکت‌های گرادینت پس‌زمینه --}}
        <div class="absolute -top-40 right-1/4 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full max-w-6xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-10 lg:gap-14 z-10">
            
            {{-- ستون سمت راست: معرفی و راهنمای تلویزیون --}}
            <div class="flex-1 text-right space-y-6">
                
                {{-- بج نسخه جدید --}}
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-800 dark:text-amber-300 text-xs font-bold shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                    <span>نسخه نسل جدید سامانه ابری طلالایو ویژه تلویزیون هوشمند طلافروشی و مغازه طلا فروشی</span>
                </div>

                {{-- تیتر اصلی سئو و معرفی --}}
                <div class="space-y-4">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white leading-tight tracking-tight">
                        تابلوی هوشمند طلافروشی و مغازه طلا فروشی <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 via-amber-500 to-yellow-600 dark:from-amber-300 dark:via-amber-400 dark:to-yellow-500">
                            روی تلویزیون بدون نیاز به کیس و کابل
                        </span>
                    </h1>
                    <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base lg:text-lg leading-relaxed max-w-2xl">
                        تنها با باز کردن مرورگر تلویزیون هوشمند در مغازه طلا فروشی و اسکن بارکد، تابلوی اختصاصی طلا، سکه، ارز و ویترین جواهرات خود را با فرمول سود دلخواه به صورت زنده فعال کنید.
                    </p>
                </div>

                {{-- راهنمای ۳ گام اسکن و جفت‌سازی --}}
                <div class="bg-white/90 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3.5 backdrop-blur-md max-w-xl shadow-lg shadow-slate-200/50 dark:shadow-none">
                    <div class="text-xs font-bold text-amber-600 dark:text-amber-400 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>مراحل راه‌اندازی و اتصال تابلوی این تلویزیون:</span>
                    </div>
                    <ol class="space-y-2.5 text-xs sm:text-sm text-slate-700 dark:text-slate-300">
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/30 flex items-center justify-center font-bold text-xs shrink-0">۱</span>
                            <span>با گوشی خود وارد <a href="{{ route('admin.login') }}" class="text-amber-600 dark:text-amber-400 underline decoration-amber-500/50 hover:text-amber-700 dark:hover:text-amber-300 font-bold">پنل مدیریت طلالایو</a> شوید (یا ثبت نام کنید).</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/30 flex items-center justify-center font-bold text-xs shrink-0">۲</span>
                            <span>بارکد QR روبرو را با دوربین گوشی اسکن کرده و لینک تایید را باز کنید.</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/30 flex items-center justify-center font-bold text-xs shrink-0">۳</span>
                            <span>تلویزیون بلافاصله جفت شده و تابلوی زنده شما با نرخ‌های دقیق نمایش داده می‌شود.</span>
                        </li>
                    </ol>
                </div>

                {{-- دکمه اسکرول به سایر امکانات --}}
                <div class="pt-2 flex items-center gap-4">
                    <a href="#features" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors py-1">
                        <span>مشاهده امکانات، پیش‌نمایش و راهنمای کامل</span>
                        <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    </a>
                </div>
            </div>

            {{-- ستون سمت چپ: کارت QR Code و اتصال هوشمند تلویزیون --}}
            <div class="flex flex-col gap-5 w-full max-w-[360px] shrink-0">
                <div class="w-full bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-3xl p-7 shadow-2xl shadow-slate-300/60 dark:shadow-2xl backdrop-blur-xl flex flex-col items-center justify-center text-center gap-6 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-b from-amber-500/5 via-transparent to-blue-500/5 pointer-events-none"></div>

                    {{-- وضعیت اتصال زنده --}}
                    <div class="flex items-center gap-2 text-[11px] font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800/80 px-3.5 py-1 rounded-full border border-slate-200 dark:border-slate-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>آماده اتصال به تلویزیون هوشمند</span>
                    </div>

                    {{-- کادر تصویر QR Code --}}
                    <div class="relative bg-white p-3 rounded-2xl overflow-hidden shadow-xl border-2 border-amber-400/30">
                        <img id="qrImage" src="" alt="Pairing QR Code" class="w-56 h-56 object-contain">
                        <div id="qrLoader" class="absolute inset-0 bg-white flex items-center justify-center">
                            <div class="w-10 h-10 border-4 border-slate-200 border-t-amber-500 rounded-full animate-spin"></div>
                        </div>
                    </div>

                    {{-- کد فعال‌سازی دستی ۶ رقمی --}}
                    <div class="space-y-1.5 w-full">
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold">کد اتصال دستی ۶ رقمی:</p>
                        <div id="activationCode" class="text-2xl font-black tracking-widest text-amber-600 dark:text-amber-400 font-mono bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 py-2 rounded-xl shadow-inner">
                            ------
                        </div>
                        <p class="text-[10px] text-slate-500">قابل وارد کردن در منوی جفت‌سازی پنل مدیریت طلالایو</p>
                    </div>
                </div>

                {{-- کادر ارتباط مستقیم با پشتیبانی --}}
                <div class="w-full bg-white dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-4 text-center text-xs space-y-2 backdrop-blur-xl shadow-md">
                    <p class="text-slate-500 dark:text-slate-400 font-bold text-[11px]">پشتیبانی فنی و راه‌اندازی فوری تابلوی طلافروشی:</p>
                    <p class="text-amber-600 dark:text-amber-400 font-black text-sm tracking-wider" dir="ltr">
                        <a href="tel:09187009064" class="hover:underline">0918 700 9064</a>
                        &nbsp;&middot;&nbsp;
                        <a href="tel:08135223847" class="hover:underline">081 3522 3847</a>
                    </p>
                    <div class="pt-1 flex items-center justify-center gap-2 flex-wrap">
                        <span class="text-slate-700 dark:text-slate-300 font-bold text-[11px]">پشتیبانی فنی طلالایو</span>
                        <a href="https://rubika.ir/talalive" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white text-[10px] font-bold shadow-sm transition-all">
                            <img src="/images/logos/rubika.png" onerror="this.src='/icons/icon-72x72.png'" class="w-3.5 h-3.5 object-contain rounded-sm" alt="روبیکا">
                            <span>پشتیبانی روبیکا</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- بخش ۲: نوار شاخص‌های ارزش و اعتماد (Trust & Stats Highlight) --}}
    <section class="border-y border-slate-200 dark:border-slate-800/80 bg-white/80 dark:bg-slate-950/50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="space-y-1">
                <div class="text-2xl lg:text-3xl font-black text-amber-600 dark:text-amber-400 font-mono">۰ تومان</div>
                <div class="text-xs font-bold text-slate-700 dark:text-slate-300">هزینه سخت‌افزار یا مینی‌کیس</div>
                <div class="text-[11px] text-slate-500">راه‌اندازی با مرورگر انواع تلویزیون</div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl lg:text-3xl font-black text-amber-600 dark:text-amber-400 font-mono">۶۰ ثانیه</div>
                <div class="text-xs font-bold text-slate-700 dark:text-slate-300">سرعت نصب و راه‌اندازی</div>
                <div class="text-[11px] text-slate-500">فقط با یکبار اسکن بارکد QR</div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl lg:text-3xl font-black text-amber-600 dark:text-amber-400 font-mono">۱۰۰٪</div>
                <div class="text-xs font-bold text-slate-700 dark:text-slate-300">تاب‌آوری آفلاین هوشمند</div>
                <div class="text-[11px] text-slate-500">حفظ نمایش تابلو در قطعی موقت اینترنت</div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl lg:text-3xl font-black text-amber-600 dark:text-amber-400 font-mono">لحظه‌ای</div>
                <div class="text-xs font-bold text-slate-700 dark:text-slate-300">بروزرسانی خودکار نرخ‌ها</div>
                <div class="text-[11px] text-slate-500">اتصال به معتبرترین مراجع رسمی طلا</div>
            </div>
        </div>
    </section>

    {{-- بخش آموزش بصری سریع: چگونه مرورگر اینترنت تلویزیون مغازه را پیدا کنیم؟ --}}
    <section class="py-14 px-4 sm:px-6 lg:px-8 bg-slate-100/60 dark:bg-slate-900/40 border-b border-slate-200/80 dark:border-slate-800/80">
        <div class="max-w-6xl mx-auto space-y-10">
            <div class="text-center space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-400 text-xs font-bold">
                    <span>📺 راهنمای سریع ریموت کنترل</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                    مرورگر تلویزیون مغازه من کجاست؟
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    برای باز کردن تابلوی طلالایو، کافیست با کنترل تلویزیون خود وارد برنامه مرورگر اینترنت شوید. روی برند تلویزیون مغازه‌تان کلیک کنید:
                </p>
            </div>

            {{-- کارت‌های تصویری برندهای تلویزیون --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- سامسونگ --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3 shadow-sm hover:border-amber-500/50 transition-all">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-amber-600 dark:text-amber-400">سامسونگ (Samsung)</span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 font-bold">Tizen</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                        دکمه‌ی <span class="font-bold text-slate-900 dark:text-white">Home (عکس خانه)</span> روی ریموت را بزنید و آیکون کُره زمین آبی با نام <span class="font-bold text-amber-600 dark:text-amber-400">Internet</span> را انتخاب کنید.
                    </p>
                </div>

                {{-- ال‌جی --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3 shadow-sm hover:border-amber-500/50 transition-all">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-amber-600 dark:text-amber-400">ال‌جی (LG)</span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 font-bold">WebOS</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                        دکمه‌ی <span class="font-bold text-slate-900 dark:text-white">Home (علامت خانه)</span> کنترل جادویی را فشرده و آیکون بنفش <span class="font-bold text-amber-600 dark:text-amber-400">Web Browser</span> را باز کنید.
                    </p>
                </div>

                {{-- اندروید و سونی و اسنوا --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3 shadow-sm hover:border-amber-500/50 transition-all">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-amber-600 dark:text-amber-400">اسنوا، دوو، سونی، شیائومی</span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 font-bold">Android TV</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                        در منوی برنامه‌ها (Apps)، برنامه <span class="font-bold text-amber-600 dark:text-amber-400">مرورگر، کروم (Chrome)</span> یا Browser را باز کنید و آدرس را وارد فرمایید.
                    </p>
                </div>

                {{-- تلویزیون‌های ساده و غیر هوشمند --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3 shadow-sm hover:border-amber-500/50 transition-all">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black text-amber-600 dark:text-amber-400">تلویزیون معمولی (غیر هوشمند)</span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 font-bold">HDMI</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                        با اتصال یک <span class="font-bold text-amber-600 dark:text-amber-400">اندروید باکس</span> (مانند تسکو یا شیائومی) به پورت HDMI، هر تلویزیونی هوشمند و آماده پخش تابلو می‌شود.
                    </p>
                </div>
            </div>

            {{-- چتر نجات VIP Concierge --}}
            <div class="rounded-3xl p-6 sm:p-8 bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-purple-500/10 border border-amber-500/30 dark:border-amber-500/20 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-right">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">🤝</span>
                        <h3 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">
                            کنترل تلویزیون یا تنظیمات براتون سخته؟ اصلاً نگران نباشید!
                        </h3>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 max-w-2xl leading-relaxed">
                        کارشناسان پشتیبانی فنی طلالایو در تمام ساعات کاری پشت خط هستند تا به صورت تلفنی در کمتر از ۳ دقیقه تلویزیون گالری شما را روشن و به تابلوی زنده متصل کنند.
                    </p>
                </div>

                <div class="flex items-center gap-3 shrink-0 flex-wrap justify-center">
                    <a href="tel:09187009064" class="px-5 py-3 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all flex items-center gap-2 shadow-lg shadow-amber-500/20 cursor-pointer">
                        <span>📞 تماس مستقیم با پشتیبانی فنی:</span>
                        <span class="font-mono text-sm" dir="ltr">0918 700 9064</span>
                    </a>
                    <a href="https://rubika.ir/talalive" target="_blank" class="px-4 py-3 rounded-2xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white font-bold text-xs transition-all flex items-center gap-2 shadow-lg shadow-purple-500/20 cursor-pointer">
                        <img src="/images/logos/rubika.png" onerror="this.src='/icons/icon-72x72.png'" class="w-4 h-4 object-contain rounded-md" alt="روبیکا">
                        <span>پشتیبانی در روبیکا</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- بخش ۳: شبیه‌ساز و موکاپ زنده تابلوی تلویزیون (Live TV Preview Mockup) --}}
    <section id="tv-mockup" class="py-20 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-6xl mx-auto">
            
            <div class="text-center space-y-3 mb-12">
                <div class="inline-block px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-400 text-xs font-bold">
                    پیش‌نمایش زنده نمای تلویزیون هوشمند
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white">
                    تابلوی تلویزیون طلافروشی و مغازه طلا فروشی با طلالایو چگونه دیده می‌شود؟
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
                    طراحی فوق‌العاده مدرن شیشه‌ای، خوانایی بی‌نظیر از فواصل دور، رنگ‌بندی لوکس دارک/گلد و سازگار با ویترین و دکوراسیون طلافروشی‌های مدرن و گالری‌های طلا فروشی.
                </p>
            </div>

            {{-- فریم و ماکت فوق‌العاده تلویزیون (Smart TV Frame) --}}
            <div class="relative mx-auto max-w-5xl rounded-3xl p-3 md:p-4 bg-gradient-to-b from-slate-700 via-slate-800 to-slate-900 shadow-[0_25px_60px_-15px_rgba(245,158,11,0.2)] border border-slate-700">
                
                @php
                    $previewImage = null;
                    if (file_exists(public_path('images/tv-preview.png')) || file_exists(base_path('public_html/images/tv-preview.png'))) {
                        $previewImage = 'images/tv-preview.png';
                    } elseif (file_exists(public_path('images/tv-preview.jpg')) || file_exists(base_path('public_html/images/tv-preview.jpg'))) {
                        $previewImage = 'images/tv-preview.jpg';
                    } elseif (file_exists(public_path('images/tv-preview.webp')) || file_exists(base_path('public_html/images/tv-preview.webp'))) {
                        $previewImage = 'images/tv-preview.webp';
                    }
                @endphp

                @if($previewImage)
                    {{-- نمایش تصویر واقعی اسکرین‌شات تابلوی زنده --}}
                    <div class="relative rounded-2xl bg-black overflow-hidden border border-slate-800 aspect-[16/9] shadow-2xl group flex items-center justify-center">
                        <img src="{{ asset($previewImage) }}" 
                             alt="پیش‌نمایش تابلوی زنده طلا و سکه طلالایو روی تلویزیون هوشمند" 
                             class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-[1.01]">
                        
                        {{-- افکت انعکاس شیشه و نور ملایم تلویزیون --}}
                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/[0.04] to-transparent pointer-events-none"></div>
                    </div>
                @else
                    {{-- شبیه ساز نمایشگر تلویزیون --}}
                    <div class="relative rounded-2xl bg-black overflow-hidden border border-slate-800 p-4 md:p-6 text-white aspect-[16/9] flex flex-col justify-between">
                        
                        {{-- هدر تابلوی تلویزیون --}}
                        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center font-black text-amber-400 text-sm">
                                    زر
                                </div>
                                <div class="text-right">
                                    <div class="font-black text-sm md:text-base text-amber-300">گالری طلا و جواهر زرین</div>
                                    <div class="text-[10px] text-slate-400">تلفن گالری: ۰۲۱-۸۸۸۸۴۴۴۴ &bull; بازار بزرگ طلا</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="hidden sm:flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/30 px-3 py-1 rounded-lg text-emerald-400 text-xs font-bold">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span>متصل به اتحادیه طلا</span>
                                </div>
                                <div class="text-left font-mono">
                                    <div class="text-sm md:text-base font-bold text-slate-200">۱۲:۴۵:۳۰</div>
                                    <div class="text-[10px] text-slate-400">۱۶ شهریور ۱۴۰۵</div>
                                </div>
                            </div>
                        </div>

                        {{-- شبکه نرخ‌های زنده طلا و سکه --}}
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 md:gap-3.5 my-auto py-2">
                            
                            {{-- آیتم ۱: طلای ۱۸ عیار --}}
                            <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-2.5 md:p-3 text-right">
                                <div class="text-[10px] sm:text-xs text-slate-400 font-semibold">طلای ۱۸ عیار (گرم)</div>
                                <div class="text-base sm:text-lg md:text-xl font-black text-amber-400 font-mono tracking-tight mt-0.5">۳,۸۵۰,۰۰۰</div>
                                <div class="text-[10px] text-emerald-400 font-mono flex items-center justify-end gap-1 mt-0.5">
                                    <span>+۰.۴۵٪</span>
                                    <span>▲</span>
                                </div>
                            </div>

                            {{-- آیتم ۲: طلای ۲۴ عیار --}}
                            <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-2.5 md:p-3 text-right">
                                <div class="text-[10px] sm:text-xs text-slate-400 font-semibold">طلای ۲۴ عیار (گرم)</div>
                                <div class="text-base sm:text-lg md:text-xl font-black text-amber-400 font-mono tracking-tight mt-0.5">۵,۱۳۰,۰۰۰</div>
                                <div class="text-[10px] text-emerald-400 font-mono flex items-center justify-end gap-1 mt-0.5">
                                    <span>+۰.۴۲٪</span>
                                    <span>▲</span>
                                </div>
                            </div>

                            {{-- آیتم ۳: مظنه / آبشده --}}
                            <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-2.5 md:p-3 text-right">
                                <div class="text-[10px] sm:text-xs text-slate-400 font-semibold">مظنه / مثقال طلا</div>
                                <div class="text-base sm:text-lg md:text-xl font-black text-amber-400 font-mono tracking-tight mt-0.5">۱۶,۶۸۰,۰۰۰</div>
                                <div class="text-[10px] text-emerald-400 font-mono flex items-center justify-end gap-1 mt-0.5">
                                    <span>+۰.۳۸٪</span>
                                    <span>▲</span>
                                </div>
                            </div>

                            {{-- آیتم ۴: انس جهانی --}}
                            <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-2.5 md:p-3 text-right">
                                <div class="text-[10px] sm:text-xs text-slate-400 font-semibold">انس طلا (دلار)</div>
                                <div class="text-base sm:text-lg md:text-xl font-black text-blue-400 font-mono tracking-tight mt-0.5">۲,۵۱۴.۵۰ $</div>
                                <div class="text-[10px] text-rose-400 font-mono flex items-center justify-end gap-1 mt-0.5">
                                    <span>-۰.۱۵٪</span>
                                    <span>▼</span>
                                </div>
                            </div>

                            {{-- آیتم ۵: سکه امامی --}}
                            <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-2.5 md:p-3 text-right">
                                <div class="text-[10px] sm:text-xs text-slate-400 font-semibold">سکه طرح جدید (امامی)</div>
                                <div class="text-base sm:text-lg md:text-xl font-black text-yellow-300 font-mono tracking-tight mt-0.5">۴۴,۳۰۰,۰۰۰</div>
                                <div class="text-[10px] text-emerald-400 font-mono flex items-center justify-end gap-1 mt-0.5">
                                    <span>+۰.۶۰٪</span>
                                    <span>▲</span>
                                </div>
                            </div>

                            {{-- آیتم ۶: سکه بهار آزادی --}}
                            <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-2.5 md:p-3 text-right">
                                <div class="text-[10px] sm:text-xs text-slate-400 font-semibold">سکه بهار آزادی</div>
                                <div class="text-base sm:text-lg md:text-xl font-black text-yellow-300 font-mono tracking-tight mt-0.5">۳۹,۹۰۰,۰۰۰</div>
                                <div class="text-[10px] text-emerald-400 font-mono flex items-center justify-end gap-1 mt-0.5">
                                    <span>+۰.۳۵٪</span>
                                    <span>▲</span>
                                </div>
                            </div>

                            {{-- آیتم ۷: نیم سکه --}}
                            <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-2.5 md:p-3 text-right">
                                <div class="text-[10px] sm:text-xs text-slate-400 font-semibold">نیم سکه بهار آزادی</div>
                                <div class="text-base sm:text-lg md:text-xl font-black text-yellow-300 font-mono tracking-tight mt-0.5">۲۴,۱۵۰,۰۰۰</div>
                                <div class="text-[10px] text-emerald-400 font-mono flex items-center justify-end gap-1 mt-0.5">
                                    <span>+۰.۲۰٪</span>
                                    <span>▲</span>
                                </div>
                            </div>

                            {{-- آیتم ۸: ربع سکه --}}
                            <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-2.5 md:p-3 text-right">
                                <div class="text-[10px] sm:text-xs text-slate-400 font-semibold">ربع سکه بهار آزادی</div>
                                <div class="text-base sm:text-lg md:text-xl font-black text-yellow-300 font-mono tracking-tight mt-0.5">۱۶,۱۵۰,۰۰۰</div>
                                <div class="text-[10px] text-emerald-400 font-mono flex items-center justify-end gap-1 mt-0.5">
                                    <span>+۰.۱۰٪</span>
                                    <span>▲</span>
                                </div>
                            </div>
                        </div>

                        {{-- نوار پیام زیرین و ویترین کوتاه --}}
                        <div class="bg-slate-950/80 border border-slate-800 rounded-xl p-2 flex items-center justify-between text-[10px] sm:text-xs text-slate-300">
                            <div class="flex items-center gap-2 overflow-hidden text-ellipsis whitespace-nowrap">
                                <span class="bg-amber-500 text-slate-950 font-black px-1.5 py-0.5 rounded text-[9px]">اطلاعیه</span>
                                <span>خرید و تعویض طلای کم‌اجرت با بهترین نرخ روز &bull; ساخت انواع پلاک و النگو سفارشی در گالری زرین</span>
                            </div>
                            <div class="hidden sm:block text-slate-500 font-mono text-[10px]">
                                TalaLive Smart Engine
                            </div>
                        </div>
                    </div>
                @endif

                {{-- پایه شبیه‌ساز تلویزیون --}}
                <div class="w-32 h-3 bg-gradient-to-r from-slate-700 via-slate-500 to-slate-700 mx-auto rounded-b-md shadow-lg mt-1"></div>
            </div>
        </div>
    </section>

    {{-- بخش ۴: شش ستون امکانات محوری طلالایو (Core Features Grid) --}}
    <section id="features" class="py-20 px-4 sm:px-6 lg:px-8 border-t border-slate-200 dark:border-slate-800/80 bg-slate-100/70 dark:bg-slate-950/40">
        <div class="max-w-7xl mx-auto">
            
            <div class="text-center space-y-3 mb-16">
                <div class="inline-block px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-400 text-xs font-bold">
                    ویژگی‌ها و قابلیت‌های فنی
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white">
                    چرا طلالایو انتخاب اول طلافروشی‌ها و گالری‌های برتر کشور است؟
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
                    نرم‌افزاری کامل که تمام نیازهای بصری، محاسباتی و امنیتی تابلوی قیمت طلا فروشی و تابلوی طلافروشی شما را برطرف می‌سازد.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- کارت ۱: بدون کامپیوتر یا کابل --}}
                <div class="glass-card-gold rounded-3xl p-7 space-y-4 transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">حذف ۱۰۰٪ مینی‌کیس و دانگل</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                        بدون نیاز به خرید کیس ۱۰ الی ۲۰ میلیونی یا کابل‌کشی پردردسر. سامانه با مرورگر خود تلویزیون مغازه اجرا می‌شود.
                    </p>
                </div>

                {{-- کارت ۲: نرخ لحظه‌ای و هوشمند --}}
                <div class="glass-card-gold rounded-3xl p-7 space-y-4 transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">بروزرسانی زنده بدون تاخیر</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                        استعلام نرخ خودکار طلا ۱۸ و ۲۴ عیار، مظنه مثقال، سکه امامی و بهار آزادی با سوکت‌های اختصاصی Real-Time.
                    </p>
                </div>

                {{-- کارت ۳: فرمول‌ساز سود و اجرت --}}
                <div class="glass-card-gold rounded-3xl p-7 space-y-4 transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">فرمول‌ساز مالی اختصاصی</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                        تعیین درصد سود فروش، حاشیه خرید، مالیات ارزش افزوده و تخفیف‌ها به صورت کاملاً سفارشی در تابلوی مغازه.
                    </p>
                </div>

                {{-- کارت ۴: کش آفلاین و تاب‌آوری --}}
                <div class="glass-card-gold rounded-3xl p-7 space-y-4 transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">کارکرد پایدار در قطعی اینترنت</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                        سامانه در نوسانات اینترنت با کش هوشمند محلی صفحه را باز نگه داشته و با اتصال مجدد بلافاصله بروز می‌شود.
                    </p>
                </div>

                {{-- کارت ۵: اسلایدشوی ویترین جواهرات --}}
                <div class="glass-card-gold rounded-3xl p-7 space-y-4 transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">ویترین دیجیتال و معرفی کارها</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                        پخش اسلایدشوی عکس‌های جواهرات لوکس، مدل‌های جدید و QR کد پیج اینستاگرام در کنار جدول نرخ‌ها.
                    </p>
                </div>

                {{-- کارت ۶: سازگار با تمامی تلویزیون‌ها --}}
                <div class="glass-card-gold rounded-3xl p-7 space-y-4 transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">پشتیبانی از انواع نمایشگر</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                        سازگار با تمام سیستم‌عامل‌های هوشمند: Samsung Tizen، LG webOS، Android TV، سونی، اسنوا و حتی مانیتورهای ساده.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- بخش ۵: تعرفه‌ها و پلن‌های اشتراک طلالایو (Transparent B2B Pricing Plans) --}}
    <section id="pricing" class="py-16 px-4 sm:px-6 lg:px-8 border-t border-slate-200/80 dark:border-slate-800/80">
        <div class="max-w-6xl mx-auto space-y-12">
            
            <div class="text-center space-y-3 max-w-2xl mx-auto">
                <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-400 text-xs font-black">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>تعرفه‌های شفاف، اقتصادی و بدون هزینه پنهان</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                    پلن‌های اشتراک تابلوی هوشمند طلافروشی و نرم‌افزار طلا فروشی
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed px-2">
                    اتصال آنی به درگاه‌های پرداخت امن شاپرک (<strong class="text-slate-800 dark:text-slate-200">زرین‌پال و زیبال</strong>) با فعال‌سازی لحظه‌ای. کلیه طلافروشان و همکاران صنف طلا فروش از <strong class="text-amber-600 dark:text-amber-400 font-black">۱۴ روز مهلت تست رایگان</strong> بدون نیاز به پرداخت اولیه برخوردارند.
                </p>
            </div>

            {{-- ۱. نمای اختصاصی موبایل و تبلت‌های کوچک: سوئیچر کپسولی هوشمند (Mobile Segmented Switcher) --}}
            <div class="lg:hidden space-y-5">
                {{-- نوار تب‌های کپسولی انتخاب دوره --}}
                <div class="bg-white/90 dark:bg-slate-900/90 p-1.5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between gap-1 max-w-md mx-auto select-none">
                    <button type="button"
                            @click="mobilePlan = '1m'"
                            class="flex-1 py-2 px-1.5 rounded-xl text-xs font-bold transition-all text-center cursor-pointer"
                            :class="mobilePlan === '1m' ? 'bg-slate-900 text-white dark:bg-slate-700 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'">
                        <span>۱ ماهه</span>
                    </button>
                    <button type="button"
                            @click="mobilePlan = '3m'"
                            class="flex-1 py-2 px-1.5 rounded-xl text-xs font-bold transition-all text-center cursor-pointer relative"
                            :class="mobilePlan === '3m' ? 'bg-slate-900 text-white dark:bg-slate-700 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'">
                        <span>۳ ماهه</span>
                        <span class="text-[9px] block text-blue-400 font-mono -mt-0.5">۱۵٪ تخفیف</span>
                    </button>
                    <button type="button"
                            @click="mobilePlan = '6m'"
                            class="flex-1 py-2 px-1.5 rounded-xl text-xs font-bold transition-all text-center cursor-pointer relative"
                            :class="mobilePlan === '6m' ? 'bg-slate-900 text-white dark:bg-slate-700 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'">
                        <span>۶ ماهه</span>
                        <span class="text-[9px] block text-purple-400 font-mono -mt-0.5">۳۰٪ تخفیف</span>
                    </button>
                    <button type="button"
                            @click="mobilePlan = '12m'"
                            class="flex-1 py-2 px-1.5 rounded-xl text-xs font-black transition-all text-center cursor-pointer relative"
                            :class="mobilePlan === '12m' ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 shadow-md shadow-amber-500/25 ring-1 ring-amber-400' : 'text-amber-600 dark:text-amber-400 hover:text-amber-500'">
                        <span>★ ۱۲ ماهه</span>
                        <span class="text-[9px] block font-mono -mt-0.5" :class="mobilePlan === '12m' ? 'text-slate-950 font-bold' : 'text-amber-500'">۵۰٪ ویژه</span>
                    </button>
                </div>

                {{-- کارت فعال موبایل بر اساس تب انتخاب شده --}}
                <div class="max-w-md mx-auto">
                    {{-- تب ۱: ۱ ماهه --}}
                    <div x-show="mobilePlan === '1m'" x-cloak x-transition.opacity.duration.200ms class="rounded-3xl p-6 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-lg space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white">اشتراک ۱ ماهه استاندارد</h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">مناسب تست کوتاه‌مدت امکانات</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">۳۰ روز کامل</span>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 flex items-baseline justify-between">
                            <span class="text-xs text-slate-500">هزینه دوره:</span>
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-3xl font-black text-slate-900 dark:text-white font-mono">۶۹۰,۰۰۰</span>
                                <span class="text-xs font-bold text-slate-500">تومان</span>
                            </div>
                        </div>
                        <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-300">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>پخش زنده تلویزیون 4K بدون قطعی</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>فرمول‌ساز پیشرفته حاشیه سود و مظنه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>اسلایدشوی ویترین محصولات گالری</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>پشتیبانی اختصاصی روبیکا و تماس</span>
                            </li>
                        </ul>
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full py-3.5 px-4 rounded-2xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 text-white text-xs font-black transition-all flex items-center justify-center gap-1.5 shadow-md">
                                <span>انتخاب و خرید آنلاین</span>
                                <span>&larr;</span>
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full py-3.5 px-4 rounded-2xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 text-white text-xs font-black transition-all flex items-center justify-center gap-1.5 shadow-md">
                                <span>شروع ۱۴ روز تست رایگان</span>
                                <span>&larr;</span>
                            </a>
                        @endauth
                    </div>

                    {{-- تب ۲: ۳ ماهه --}}
                    <div x-show="mobilePlan === '3m'" x-cloak x-transition.opacity.duration.200ms class="rounded-3xl p-6 border border-blue-200 dark:border-blue-900/60 bg-white dark:bg-slate-900 shadow-lg space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white">اشتراک ۳ ماهه فصلی</h3>
                                <p class="text-[11px] text-blue-600 dark:text-blue-400 font-bold mt-0.5">۱۵٪ تخفیف اقتصادی</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800">۹۰ روز کامل</span>
                        </div>
                        <div class="bg-blue-50/50 dark:bg-slate-800/50 p-4 rounded-2xl border border-blue-100 dark:border-slate-800 flex items-baseline justify-between">
                            <div>
                                <div class="text-[10px] text-slate-400 line-through">۲,۰۷۰,۰۰۰ تومان</div>
                                <span class="text-xs text-slate-500">مبلغ ۳ ماه:</span>
                            </div>
                            <div class="text-left">
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-3xl font-black text-slate-900 dark:text-white font-mono">۱,۷۹۰,۰۰۰</span>
                                    <span class="text-xs font-bold text-slate-500">تومان</span>
                                </div>
                                <div class="text-[11px] text-blue-600 dark:text-blue-400 font-bold mt-0.5">ماهیانه ۵۹۶,۰۰۰ تومان</div>
                            </div>
                        </div>
                        <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-300">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>کلیه امکانات تابلو و فرمول‌ساز پیشرفته</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>پخش مداوم آفلاین هنگام قطعی نت</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>پشتیبانی مستقیم و بروزرسانی لحظه‌ای</span>
                            </li>
                        </ul>
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full py-3.5 px-4 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-black transition-all flex items-center justify-center gap-1.5 shadow-md shadow-blue-600/20">
                                <span>انتخاب و خرید آنلاین</span>
                                <span>&larr;</span>
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full py-3.5 px-4 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-black transition-all flex items-center justify-center gap-1.5 shadow-md shadow-blue-600/20">
                                <span>شروع ۱۴ روز تست رایگان</span>
                                <span>&larr;</span>
                            </a>
                        @endauth
                    </div>

                    {{-- تب ۳: ۶ ماهه --}}
                    <div x-show="mobilePlan === '6m'" x-cloak x-transition.opacity.duration.200ms class="rounded-3xl p-6 border border-purple-200 dark:border-purple-900/60 bg-white dark:bg-slate-900 shadow-lg space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white">اشتراک ۶ ماهه نیم‌سال</h3>
                                <p class="text-[11px] text-purple-600 dark:text-purple-400 font-bold mt-0.5">۳۰٪ صرفه‌جویی طلایی</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-800">۱۸۰ روز کامل</span>
                        </div>
                        <div class="bg-purple-50/50 dark:bg-slate-800/50 p-4 rounded-2xl border border-purple-100 dark:border-slate-800 flex items-baseline justify-between">
                            <div>
                                <div class="text-[10px] text-slate-400 line-through">۴,۱۴۰,۰۰۰ تومان</div>
                                <span class="text-xs text-slate-500">مبلغ ۶ ماه:</span>
                            </div>
                            <div class="text-left">
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-3xl font-black text-slate-900 dark:text-white font-mono">۲,۸۹۰,۰۰۰</span>
                                    <span class="text-xs font-bold text-slate-500">تومان</span>
                                </div>
                                <div class="text-[11px] text-purple-600 dark:text-purple-400 font-bold mt-0.5">ماهیانه ۴۸۱,۰۰۰ تومان</div>
                            </div>
                        </div>
                        <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-300">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>کلیه قابلیت‌های حرفه‌ای بدون محدودیت</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>ثبات کامل قیمت برای نیم‌سال</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>پشتیبانی VIP و پاسخگویی سریع</span>
                            </li>
                        </ul>
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full py-3.5 px-4 rounded-2xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-black transition-all flex items-center justify-center gap-1.5 shadow-md shadow-purple-600/20">
                                <span>انتخاب و خرید آنلاین</span>
                                <span>&larr;</span>
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full py-3.5 px-4 rounded-2xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-black transition-all flex items-center justify-center gap-1.5 shadow-md shadow-purple-600/20">
                                <span>شروع ۱۴ روز تست رایگان</span>
                                <span>&larr;</span>
                            </a>
                        @endauth
                    </div>

                    {{-- تب ۴: ۱۲ ماهه (پیشنهاد ویژه و قهرمان طلالایو) --}}
                    <div x-show="mobilePlan === '12m'" x-cloak x-transition.opacity.duration.200ms class="relative rounded-3xl p-6 border-2 border-amber-500 bg-gradient-to-b from-amber-500/15 via-amber-500/5 to-white dark:to-slate-900 shadow-2xl shadow-amber-500/20 space-y-6">
                        <div class="absolute -top-3.5 right-6 px-3.5 py-1 rounded-full text-[11px] font-black bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 shadow-md shadow-amber-500/30">
                            ★ محبوب‌ترین انتخاب و بیشترین تخفیف ★
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <div>
                                <h3 class="text-xl font-black text-slate-900 dark:text-white">اشتراک سالانه (۱۲ ماه)</h3>
                                <p class="text-xs text-amber-600 dark:text-amber-400 font-bold mt-0.5">بیش از ۵۰٪ صرفه‌جویی اقتصادی</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-500 text-slate-950">۳۶۵ روز کامل</span>
                        </div>
                        <div class="bg-white/80 dark:bg-slate-800/80 p-4 rounded-2xl border border-amber-500/30 flex items-baseline justify-between shadow-sm">
                            <div>
                                <div class="text-[10px] text-slate-400 line-through">۸,۲۸۰,۰۰۰ تومان</div>
                                <span class="text-xs text-slate-500">مبلغ یک سال کامل:</span>
                            </div>
                            <div class="text-left">
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-3xl font-black text-amber-500 font-mono">۳,۹۹۰,۰۰۰</span>
                                    <span class="text-xs font-bold text-slate-500">تومان</span>
                                </div>
                                <div class="text-[11px] text-emerald-600 dark:text-emerald-400 font-black mt-0.5">معادل فقط ۳۳۲,۵۰۰ تومان / ماه</div>
                            </div>
                        </div>
                        <ul class="space-y-2.5 text-xs text-slate-700 dark:text-slate-200 border-t border-amber-500/20 pt-4">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span class="font-bold">پخش نامحدود 4K بدون قطعی در طول سال</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>فرمول‌ساز پیشرفته محاسبه سود و مالیات</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>ویترین آنلاین و اسلایدر نامحدود عکس طلا</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>کارکرد هوشمند در قطعی اینترنت (آفلاین)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span class="font-bold text-amber-500">پشتیبانی ویژه روبیکا و تماس مستقیم VIP</span>
                            </li>
                        </ul>
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full py-4 px-4 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-black transition-all shadow-xl shadow-amber-500/25 flex items-center justify-center gap-1.5 cursor-pointer">
                                <span>خرید سالانه با ۵۰٪ تخفیف و فعال‌سازی آنی</span>
                                <span>&larr;</span>
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full py-4 px-4 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-black transition-all shadow-xl shadow-amber-500/25 flex items-center justify-center gap-1.5 cursor-pointer">
                                <span>ثبت‌نام و شروع ۱۴ روز تست رایگان</span>
                                <span>&larr;</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- ۲. نمای دسکتاپ: گرید ۴ ستونه جذاب با ماتریس کامل قیمت‌گذاری (Desktop 4-Column Matrix) --}}
            <div class="hidden lg:grid lg:grid-cols-4 gap-6 items-stretch pt-2">
                
                {{-- پلن ۱: ۱ ماهه --}}
                <div class="rounded-3xl p-6 sm:p-7 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/80 shadow-sm hover:border-slate-300 dark:hover:border-slate-700 transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white">اشتراک ۱ ماهه</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">کوتاه‌مدت</span>
                        </div>
                        <div class="mb-4">
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-3xl font-black text-slate-900 dark:text-white font-mono">۶۹۰,۰۰۰</span>
                                <span class="text-xs font-bold text-slate-500">تومان</span>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-1">ماهیانه ۶۹۰,۰۰۰ تومان</div>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 leading-relaxed">
                            مناسب جهت بررسی اولیه و تست امکانات تابلوی هوشمند تلویزیون در مغازه.
                        </p>
                        <ul class="space-y-3 text-xs text-slate-600 dark:text-slate-300 border-t border-slate-100 dark:border-slate-800 pt-5">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>پخش زنده تلویزیون 4K</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>فرمول‌ساز سود و مظنه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>ویترین و اسلایدر محصولات</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>پشتیبانی روبیکا و تلفنی</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4">
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-black transition-all flex items-center justify-center gap-1.5">
                                <span>انتخاب و تمدید آنلاین</span>
                                <span>&larr;</span>
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-black transition-all flex items-center justify-center gap-1.5">
                                <span>شروع با تست رایگان</span>
                                <span>&larr;</span>
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- پلن ۲: ۳ ماهه --}}
                <div class="rounded-3xl p-6 sm:p-7 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/80 shadow-sm hover:border-slate-300 dark:hover:border-slate-700 transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white">اشتراک ۳ ماهه</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-500/10 text-blue-600 dark:text-blue-400">۱۵٪ صرفه‌جویی</span>
                        </div>
                        <div class="mb-4">
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-3xl font-black text-slate-900 dark:text-white font-mono">۱,۷۹۰,۰۰۰</span>
                                <span class="text-xs font-bold text-slate-500">تومان</span>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-1">معادل ۵۹۶,۰۰۰ تومان / ماه</div>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 leading-relaxed">
                            انتخاب فصلی با ثبات نرخ و دسترسی کامل به کلیه قابلیت‌ها.
                        </p>
                        <ul class="space-y-3 text-xs text-slate-600 dark:text-slate-300 border-t border-slate-100 dark:border-slate-800 pt-5">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>پخش زنده تلویزیون 4K</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>فرمول‌ساز سود و مظنه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>ویترین و اسلایدر محصولات</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>پشتیبانی روبیکا و تلفنی</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4">
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-black transition-all flex items-center justify-center gap-1.5">
                                <span>انتخاب و تمدید آنلاین</span>
                                <span>&larr;</span>
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-black transition-all flex items-center justify-center gap-1.5">
                                <span>شروع با تست رایگان</span>
                                <span>&larr;</span>
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- پلن ۳: ۶ ماهه --}}
                <div class="rounded-3xl p-6 sm:p-7 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/80 shadow-sm hover:border-slate-300 dark:hover:border-slate-700 transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white">اشتراک ۶ ماهه</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-500/10 text-purple-600 dark:text-purple-400">۳۰٪ صرفه‌جویی</span>
                        </div>
                        <div class="mb-4">
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-3xl font-black text-slate-900 dark:text-white font-mono">۲,۸۹۰,۰۰۰</span>
                                <span class="text-xs font-bold text-slate-500">تومان</span>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-1">معادل ۴۸۱,۰۰۰ تومان / ماه</div>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 leading-relaxed">
                            پلن نیم‌سال با تخفیف طلایی و پایداری تضمین‌شده سرورها.
                        </p>
                        <ul class="space-y-3 text-xs text-slate-600 dark:text-slate-300 border-t border-slate-100 dark:border-slate-800 pt-5">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>پخش زنده تلویزیون 4K</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>فرمول‌ساز سود و مظنه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>ویترین و اسلایدر محصولات</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>پشتیبانی روبیکا و تلفنی</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4">
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-black transition-all flex items-center justify-center gap-1.5">
                                <span>انتخاب و تمدید آنلاین</span>
                                <span>&larr;</span>
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-black transition-all flex items-center justify-center gap-1.5">
                                <span>شروع با تست رایگان</span>
                                <span>&larr;</span>
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- پلن ۴: ۱۲ ماهه (پیشنهاد ویژه و محبوب‌ترین طلالایو - HERO PLAN) --}}
                <div class="relative rounded-3xl p-6 sm:p-7 border-2 border-amber-500 dark:border-amber-400 bg-gradient-to-b from-amber-500/10 via-amber-500/5 to-white dark:to-slate-900 shadow-2xl shadow-amber-500/20 flex flex-col justify-between -translate-y-2">
                    <div class="absolute -top-4 right-1/2 translate-x-1/2 px-4 py-1 rounded-full text-[11px] font-black tracking-wide bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 shadow-lg shadow-amber-500/30 whitespace-nowrap">
                        ★ محبوب‌ترین انتخاب طلافروشان ★
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-4 pt-2">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white">اشتراک سالانه (۱۲ ماه)</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-500 text-slate-950">بیش از ۵۰٪ تخفیف</span>
                        </div>
                        <div class="mb-4">
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-3xl font-black text-amber-500 font-mono">۳,۹۹۰,۰۰۰</span>
                                <span class="text-xs font-bold text-slate-500">تومان</span>
                            </div>
                            <div class="text-[11px] text-emerald-600 dark:text-emerald-400 font-bold mt-1">معادل فقط ۳۳۲,۵۰۰ تومان / ماه</div>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                            بیشترین صرفه اقتصادی برای یک سال کامل بدون دغدغه نوسان قیمت، همراه با اولویت پشتیبانی.
                        </p>
                        <ul class="space-y-3 text-xs text-slate-700 dark:text-slate-200 border-t border-amber-500/20 pt-5">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span class="font-bold">پخش زنده تلویزیون 4K نامحدود</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>فرمول‌ساز اختصاصی سود و مظنه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>ویترین و اسلایدر نامحدود محصولات</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>کارکرد هوشمند در قطعی اینترنت</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span class="font-bold text-amber-500">پشتیبانی VIP روبیکا و تلفنی مستقیم</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4">
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-black transition-all shadow-lg shadow-amber-500/25 flex items-center justify-center gap-1.5 cursor-pointer">
                                <span>خرید سالانه با تخفیف ۵۰٪</span>
                                <span>&larr;</span>
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-black transition-all shadow-lg shadow-amber-500/25 flex items-center justify-center gap-1.5 cursor-pointer">
                                <span>ثبت‌نام و شروع ۱۴ روز رایگان</span>
                                <span>&larr;</span>
                            </a>
                        @endauth
                    </div>
                </div>

            </div>

            {{-- بنر ضمانت و امنیت پرداخت --}}
            <div class="rounded-3xl bg-slate-100/80 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 p-5 sm:p-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <div class="font-black text-slate-900 dark:text-white">تضمین حفظ روزها (No Day Lost)</div>
                        <p class="text-slate-500 dark:text-slate-400 mt-0.5">در صورت تمدید پیش از موعد، کلیه روزهای باقیمانده حفظ شده و اشتراک جدید به پایان آن افزوده می‌شود.</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-slate-500 dark:text-slate-400 shrink-0 flex-wrap">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>اتصال شاپرک (زرین‌پال و زیبال)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <span>صدور فاکتور رسمی دیجیتال</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- بخش ۵: راهنمای گام‌به‌گام راه‌اندازی در ۳ دقیقه (How It Works) --}}
    <section id="how-it-works" class="py-20 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-6xl mx-auto">
            
            <div class="text-center space-y-3 mb-16">
                <div class="inline-block px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-400 text-xs font-bold">
                    راهنمای سریع راه‌اندازی
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white">
                    نحوه شروع کار با طلالایو در ۳ مرحله ساده
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm max-w-xl mx-auto">
                    از لحظه تصمیم تا نمایش تابلوی زنده روی تلویزیون مغازه کمتر از ۳ دقیقه زمان می‌برد.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- گام ۱ --}}
                <div class="bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-3xl p-8 text-center space-y-4 relative group hover:border-amber-500/40 transition-all shadow-lg shadow-slate-200/50 dark:shadow-none">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500 text-slate-950 font-black text-xl flex items-center justify-center mx-auto shadow-lg shadow-amber-500/20">
                        ۱
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">ثبت‌نام سریع گالری</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                        در صفحه <a href="{{ route('admin.register') }}" class="text-amber-600 dark:text-amber-400 font-bold hover:underline">ثبت‌نام طلالایو</a> تنها با شماره موبایل و نام مغازه خود در کمتر از یک دقیقه حساب کاربری بسازید.
                    </p>
                </div>

                {{-- گام ۲ --}}
                <div class="bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-3xl p-8 text-center space-y-4 relative group hover:border-amber-500/40 transition-all shadow-lg shadow-slate-200/50 dark:shadow-none">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500 text-slate-950 font-black text-xl flex items-center justify-center mx-auto shadow-lg shadow-amber-500/20">
                        ۲
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">باز کردن سایت و اسکن بارکد</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                        مرورگر تلویزیون مغازه را باز کرده و وارد آدرس <span class="text-amber-600 dark:text-amber-400 font-mono font-bold">talalive.ir</span> شوید. بارکد ظاهرشده را با دوربین گوشی اسکن کنید.
                    </p>
                </div>

                {{-- گام ۳ --}}
                <div class="bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-3xl p-8 text-center space-y-4 relative group hover:border-amber-500/40 transition-all shadow-lg shadow-slate-200/50 dark:shadow-none">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500 text-slate-950 font-black text-xl flex items-center justify-center mx-auto shadow-lg shadow-amber-500/20">
                        ۳
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">شروع به کار خودکار تابلو</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                        تلویزیون شما به طور آنی متصل شده و تابلوی شکیل قیمت طلا و سکه با تنظیمات گالری شما بدون نیاز به مداخله دست نمایش داده می‌شود.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- بخش ۶: ماتریس مقایسه طلالایو با روش‌های سنتی (Comparison Matrix) --}}
    <section id="comparison" class="py-20 px-4 sm:px-6 lg:px-8 border-t border-slate-200 dark:border-slate-800/80 bg-white/90 dark:bg-slate-950/60">
        <div class="max-w-6xl mx-auto">
            
            <div class="text-center space-y-3 mb-16">
                <div class="inline-block px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-400 text-xs font-bold">
                    مقایسه هوشمندانه
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white">
                    طلالایو در مقایسه با تابلوهای سنتی و روش‌های قدیمی
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm max-w-xl mx-auto">
                    چرا سرمایه‌گذاری روی نرم‌افزار ابری طلالایو نسبت به تابلوهای ال‌ای‌دی یا اتصال کیس کامپیوتر بسیار اقتصادی‌تر و زیباتر است؟
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse min-w-[650px]">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-800 text-xs text-slate-500 dark:text-slate-400">
                            <th class="py-4 px-4 font-bold">ویژگی و امکانات</th>
                            <th class="py-4 px-4 font-black text-amber-700 dark:text-amber-400 text-sm bg-amber-500/10 rounded-t-2xl border-x border-t border-amber-500/20">سامانه هوشمند طلالایو</th>
                            <th class="py-4 px-4 font-bold">تابلوهای LED و روان سنتی</th>
                            <th class="py-4 px-4 font-bold">اتصال کامپیوتر یا لپ‌تاپ با کابل</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60 text-xs sm:text-sm">
                        <tr>
                            <td class="py-4 px-4 font-bold text-slate-800 dark:text-slate-200">هزینه سخت‌افزار اولیه</td>
                            <td class="py-4 px-4 font-black text-emerald-600 dark:text-emerald-400 bg-amber-500/5 border-x border-amber-500/20">صفر (فقط تلویزیون موجود)</td>
                            <td class="py-4 px-4 text-slate-500 dark:text-slate-400">بیش از ۲۰ تا ۶۰ میلیون تومان</td>
                            <td class="py-4 px-4 text-slate-500 dark:text-slate-400">۱۰ تا ۳۰ میلیون خرید مینی‌کیس</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-4 font-bold text-slate-800 dark:text-slate-200">کیفیت بصری و پرستیژ مغازه</td>
                            <td class="py-4 px-4 font-bold text-amber-600 dark:text-amber-300 bg-amber-500/5 border-x border-amber-500/20">گرافیک لوکس 4K و Glassmorphism</td>
                            <td class="py-4 px-4 text-slate-500 dark:text-slate-400">پیکسلی و قدیمی و تک‌رنگ</td>
                            <td class="py-4 px-4 text-slate-500 dark:text-slate-400">نیازمند ویندوز و ظاهر نامنظم</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-4 font-bold text-slate-800 dark:text-slate-200">بروزرسانی خودکار نرخ‌ها</td>
                            <td class="py-4 px-4 font-black text-emerald-600 dark:text-emerald-400 bg-amber-500/5 border-x border-amber-500/20">کاملاً اتوماتیک و ثانیه‌ای</td>
                            <td class="py-4 px-4 text-slate-500 dark:text-slate-400">دستی یا با کنترلر سخت‌افزاری</td>
                            <td class="py-4 px-4 text-slate-500 dark:text-slate-400">نیازمند اپراتور و رفرش دستی</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-4 font-bold text-slate-800 dark:text-slate-200">ویترین دیجیتال و کاتالوگ طلا</td>
                            <td class="py-4 px-4 font-black text-emerald-600 dark:text-emerald-400 bg-amber-500/5 border-x border-amber-500/20">دارد (اسلایدشو با عکس و QR)</td>
                            <td class="py-4 px-4 text-rose-500">غیرقابل انجام</td>
                            <td class="py-4 px-4 text-slate-500 dark:text-slate-400">پیچیده و نیازمند نرم‌افزار جانبی</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-4 font-bold text-slate-800 dark:text-slate-200">فرمول‌ساز اختصاصی سود و مظنه</td>
                            <td class="py-4 px-4 font-black text-emerald-600 dark:text-emerald-400 bg-amber-500/5 border-x border-amber-500/20">دارد (تنظیم حاشیه خرید/فروش)</td>
                            <td class="py-4 px-4 text-rose-500">ندارد</td>
                            <td class="py-4 px-4 text-slate-500 dark:text-slate-400">نیازمند فرمول‌نویسی دستی</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-4 font-bold text-slate-800 dark:text-slate-200">کنترل از راه دور با موبایل</td>
                            <td class="py-4 px-4 font-black text-emerald-600 dark:text-emerald-400 bg-amber-500/5 border-x border-b border-amber-500/20 rounded-b-2xl">دارد (پنل تحت وب از هر نقطه)</td>
                            <td class="py-4 px-4 text-rose-500">ندارد</td>
                            <td class="py-4 px-4 text-slate-500 dark:text-slate-400">نیازمند نرم‌افزارهای ریموت پیچیده</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </section>

{{-- بخش ۷: آکاردئون سوالات متداول طلافروشان (FAQ Section) --}}
    <section id="faq" class="py-20 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-4xl mx-auto space-y-12">
            
            <div class="text-center space-y-3">
                <div class="inline-block px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-400 text-xs font-bold">
                    پاسخ به ابهامات
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white">
                    سوالات متداول همکاران و طلافروشان گرامی
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm">
                    پاسخ به سوالاتی که پیش از راه‌اندازی تابلوی طلالایو ممکن است برای شما مطرح باشد.
                </p>
            </div>

            <div class="space-y-4">
                
                {{-- سوال ۱ --}}
                <details class="group bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 [&_summary::-webkit-details-marker]:hidden transition-all duration-300 open:border-amber-400/40 open:bg-amber-50/30 dark:open:bg-slate-900/90 shadow-sm">
                    <summary class="flex items-center justify-between cursor-pointer font-black text-sm sm:text-base text-slate-800 dark:text-slate-100 group-hover:text-amber-600 dark:group-hover:text-amber-300">
                        <span>آیا برای راه‌اندازی تابلوی طلالایو نیاز به خرید کامپیوتر یا دستگاه جداگانه در مغازه هست؟</span>
                        <span class="faq-icon text-amber-500 transition-transform duration-300 shrink-0 mr-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 pt-4">
                        خیر، به هیچ وجه نیازی به مینی‌کیس، کامپیوتر، یا دانگل اضافه نیست. شما می‌توانید تنها با مرورگر اینترنت هر نوع تلویزیون هوشمند (سامسونگ، ال‌جی، سونی، اسنوا، دوو یا اندروید تی‌وی) و اسکن یکبار QR کد، تابلوی اختصاصی طلافروشی خود را بدون سیم‌کشی راه‌اندازی نمایید.
                    </p>
                </details>

                {{-- سوال ۲ --}}
                <details class="group bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 [&_summary::-webkit-details-marker]:hidden transition-all duration-300 open:border-amber-400/40 open:bg-amber-50/30 dark:open:bg-slate-900/90 shadow-sm">
                    <summary class="flex items-center justify-between cursor-pointer font-black text-sm sm:text-base text-slate-800 dark:text-slate-100 group-hover:text-amber-600 dark:group-hover:text-amber-300">
                        <span>نرخ‌های طلا، سکه و ارز از چه مراجعی بروزرسانی می‌شوند؟</span>
                        <span class="faq-icon text-amber-500 transition-transform duration-300 shrink-0 mr-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 pt-4">
                        نرخ‌ها به صورت خودکار و لحظه‌ای از معتبرترین مراجع رسمی بازار طلا و جواهر کشور، اتحادیه‌های طلا و سکه و مراجع رسمی انس جهانی دریافت می‌شوند و به صورت بلادرنگ روی تابلوی شما آپدیت می‌گردند.
                    </p>
                </details>

                {{-- سوال ۳ --}}
                <details class="group bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 [&_summary::-webkit-details-marker]:hidden transition-all duration-300 open:border-amber-400/40 open:bg-amber-50/30 dark:open:bg-slate-900/90 shadow-sm">
                    <summary class="flex items-center justify-between cursor-pointer font-black text-sm sm:text-base text-slate-800 dark:text-slate-100 group-hover:text-amber-600 dark:group-hover:text-amber-300">
                        <span>در صورت قطعی موقت اینترنت در طلافروشی چه اتفاقی می‌افتد؟</span>
                        <span class="faq-icon text-amber-500 transition-transform duration-300 shrink-0 mr-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 pt-4">
                        طلالایو مجهز به فناوری کش هوشمند آفلاین است. در صورت قطعی اینترنت، تابلوی شما هرگز سیاه یا متوقف نمی‌شود؛ بلکه آخرین نرخ‌های دریافتی معتبر را با برچسب ساعت آخرین بروزرسانی همراه با ویترین محصولات به نمایش مداوم ادامه می‌دهد.
                    </p>
                </details>

                {{-- سوال ۴ --}}
                <details class="group bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 [&_summary::-webkit-details-marker]:hidden transition-all duration-300 open:border-amber-400/40 open:bg-amber-50/30 dark:open:bg-slate-900/90 shadow-sm">
                    <summary class="flex items-center justify-between cursor-pointer font-black text-sm sm:text-base text-slate-800 dark:text-slate-100 group-hover:text-amber-600 dark:group-hover:text-amber-300">
                        <span>چگونه می‌توان فرمول سود، اجرت یا مظنه را برای طلافروشی شخصی‌سازی کرد؟</span>
                        <span class="faq-icon text-amber-500 transition-transform duration-300 shrink-0 mr-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 pt-4">
                        از طریق پنل مدیریت موبایل یا کامپیوتر، بخش فرمول‌ساز هوشمند در اختیارتان قرار دارد که می‌توانید درصد سود فروش، حاشیه خرید، مالیات و تخفیف‌ها را به ازای هر گرم یا نوع سکه اختصاصی‌سازی کنید تا نرخ‌ها مطابق با سیاست مالی گالری شما محاسبه و نمایش یابند.
                    </p>
                </details>

                {{-- سوال ۵ --}}
                <details class="group bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 [&_summary::-webkit-details-marker]:hidden transition-all duration-300 open:border-amber-400/40 open:bg-amber-50/30 dark:open:bg-slate-900/90 shadow-sm">
                    <summary class="flex items-center justify-between cursor-pointer font-black text-sm sm:text-base text-slate-800 dark:text-slate-100 group-hover:text-amber-600 dark:group-hover:text-amber-300">
                        <span>آیا امکان نمایش تصاویر محصولات و ویترین جواهرات در کنار نرخ‌ها وجود دارد؟</span>
                        <span class="faq-icon text-amber-500 transition-transform duration-300 shrink-0 mr-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 pt-4">
                        بله، در پنل مدیریت می‌توانید عکس‌های باکیفیت النگو، نیم‌ست، سرویس و مدل‌های روز طلا را به همراه مشخصات و QR کد اختصاصی اینستاگرام مغازه بارگذاری کنید تا در قالب اسلایدشوی لوکس در کنار نرخ‌های زنده طلا برای مشتریان پخش شوند.
                    </p>
                </details>

                {{-- سوال ۶ --}}
                <details class="group bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 [&_summary::-webkit-details-marker]:hidden transition-all duration-300 open:border-amber-400/40 open:bg-amber-50/30 dark:open:bg-slate-900/90 shadow-sm">
                    <summary class="flex items-center justify-between cursor-pointer font-black text-sm sm:text-base text-slate-800 dark:text-slate-100 group-hover:text-amber-600 dark:group-hover:text-amber-300">
                        <span>آیا اتصال تلویزیون پس از هر بار خاموش و روشن شدن مغازه قطع می‌شود؟</span>
                        <span class="faq-icon text-amber-500 transition-transform duration-300 shrink-0 mr-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 pt-4">
                        خیر، اطلاعات اتصال تلویزیون شما در حافظه پایدار مرورگر تلویزیون به صورت خودکار ذخیره می‌شود و با روشن شدن تلویزیون، صفحه بدون نیاز به اسکن مجدد فوراً باز شده و به تابلوی زنده شما متصل می‌گردد.
                    </p>
                </details>

            </div>
        </div>
    </section>

    {{-- بخش ۸: دعوت به اقدام نهایی (High-Conversion Call To Action) --}}
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto rounded-3xl p-8 sm:p-12 bg-gradient-to-r from-amber-500/15 via-white dark:via-slate-900/90 to-blue-500/15 border border-amber-500/30 text-center space-y-6 shadow-xl dark:shadow-2xl relative overflow-hidden">
            <div class="absolute -top-20 -right-20 w-60 h-60 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>
            
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white leading-tight">
                همین حالا تابلوی تلویزیون طلافروشی و مغازه طلا فروشی خود را راه‌اندازی کنید
            </h2>
            <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
                بدون نیاز به کارت اعتباری یا تجهیزات جانبی. ثبت‌نام کنید و در کمتر از یک دقیقه تابلوی زنده و درخشان مغازه طلا فروشی‌تان را فعال نمایید.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="{{ route('admin.register') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/25 transition-all hover:scale-[1.03]">
                    شروع رایگان و ثبت‌نام گالری
                </a>
                <a href="tel:09187009064" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-white dark:bg-slate-900/80 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-white font-bold text-sm transition-all shadow-sm">
                    مشاوره تلفنی با کارشناس
                </a>
            </div>
        </div>
    </section>

    {{-- بخش ۹: فوتر جامع معنایی و سئو (Semantic Rich Footer) --}}
    <footer id="contact" class="border-t border-slate-200 dark:border-slate-800/80 bg-slate-900 dark:bg-slate-950 text-slate-400 text-xs py-14 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">
            
            {{-- ستون ۱: معرفی طلالایو --}}
            <div class="space-y-4 md:col-span-2">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" class="h-10 w-10 object-contain rounded-xl bg-slate-800 border border-slate-700 p-1" alt="طلالایو">
                    <div>
                        <div class="text-base font-black text-amber-400">طلالایو &middot; TalaLive</div>
                        <p class="text-[11px] text-slate-400">نرم‌افزار تابلوی هوشمند نرخ طلا و سکه ویژه تلویزیون‌های طلافروشی و مغازه طلا فروشی</p>
                    </div>
                </div>
                <p class="text-slate-300 text-xs leading-relaxed max-w-lg">
                    طلالایو مدرن‌ترین سامانه ابری ارائه تابلوی زنده قیمت طلا، سکه و ارز است که با هدف ارتقای پرستیژ بصری، دقت نرخ‌گذاری، حذف کامل هزینه‌های سخت‌افزاری و هوشمندسازی گالری‌های طلا و جواهر و مغازه‌های طلا فروشی در سراسر کشور طراحی و توسعه یافته است.
                </p>
            </div>

            {{-- ستون ۲: لینک‌های مفید --}}
            <div class="space-y-3">
                <div class="font-bold text-white text-sm">دسترسی سریع و صفحات سامانه</div>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('public.smart-gold-board') }}" class="hover:text-amber-400 transition-colors">تابلوی هوشمند طلافروشی و طلا فروشی</a></li>
                    <li><a href="{{ route('public.tv-setup-guide') }}" class="hover:text-amber-400 transition-colors">راهنمای اتصال تلویزیون مغازه</a></li>
                    <li><a href="{{ route('public.gold-calculator') }}" class="hover:text-amber-400 transition-colors">ماشین‌حساب آنلاین طلا و حباب سکه</a></li>
                    <li><a href="{{ route('public.guides') }}" class="hover:text-amber-400 transition-colors">دانشنامه و مقالات تخصصی طلا</a></li>
                    <li><a href="{{ route('admin.login') }}" class="hover:text-amber-400 transition-colors">ورود به پنل مدیریت</a></li>
                    <li><a href="{{ route('admin.register') }}" class="hover:text-amber-400 transition-colors">ثبت‌نام گالری جدید</a></li>
                    <li><a href="#faq" class="hover:text-amber-400 transition-colors">سوالات متداول طلافروشان</a></li>
                </ul>
            </div>

            {{-- ستون ۳: اطلاعات تماس و پشتیبانی --}}
            <div class="space-y-3">
                <div class="font-bold text-white text-sm">ارتباط و پشتیبانی</div>
                <div class="space-y-2 text-xs">
                    <p class="text-slate-300">
                        <span class="text-slate-400">مرکز ارتباط:</span>
                        <span class="font-bold text-amber-400">پشتیبانی فنی طلالایو</span>
                    </p>
                    <p class="text-slate-300">
                        <span class="text-slate-400">تلفن همراه و روبیکا:</span>
                        <a href="tel:09187009064" class="font-mono font-bold text-slate-200 hover:text-amber-400" dir="ltr">0918 700 9064</a>
                    </p>
                    <p class="text-slate-300">
                        <span class="text-slate-400">تلفن ثابت دفتر:</span>
                        <a href="tel:08135223847" class="font-mono font-bold text-slate-200 hover:text-amber-400" dir="ltr">081 3522 3847</a>
                    </p>
                    <div class="pt-1">
                        <a href="https://rubika.ir/talalive" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white text-xs font-bold shadow-sm transition-all">
                            <img src="/images/logos/rubika.png" onerror="this.src='/icons/icon-72x72.png'" class="w-4 h-4 object-contain rounded-md" alt="روبیکا">
                            <span>ارتباط در پیام‌رسان روبیکا</span>
                        </a>
                    </div>
                    <p class="text-slate-400 text-[11px] leading-relaxed pt-1">
                        پاسخگویی شنبه تا پنج‌شنبه از ساعت ۹ الی ۲۱
                    </p>
                </div>
            </div>

        </div>

        {{-- دسترسی سریع به کلاسترها و ابزارهای تخصصی طلالایو --}}
        <div class="max-w-7xl mx-auto border-t border-slate-800 mt-10 pt-6 space-y-4">
            <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-xs text-slate-400">
                <a href="{{ route('public.smart-gold-board') }}" class="text-slate-300 hover:text-amber-400">تابلوی هوشمند طلافروشی</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('public.smart-gold-board') }}" class="text-slate-300 hover:text-amber-400">تابلو طلا فروشی</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('public.led-vs-smart-board') }}" class="text-slate-300 hover:text-amber-400">مقایسه با تابلو LED</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('public.pricing') }}" class="text-slate-300 hover:text-amber-400">تعرفه‌ها و اشتراک</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('public.tv-setup-guide') }}" class="text-slate-300 hover:text-amber-400">راهنمای اتصال تلویزیون</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('public.tools.gold-price') }}" class="text-slate-300 hover:text-amber-400">محاسبه قیمت طلا با اجرت</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('public.tools.coin-bubble') }}" class="text-slate-300 hover:text-amber-400">محاسبه حباب سکه</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('public.tools.mesghal') }}" class="text-slate-300 hover:text-amber-400">تبدیل مظنه مثقال به گرم</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('public.tools.melted-gold') }}" class="text-slate-300 hover:text-amber-400">طلای آب شده و عیار خطی</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('public.guides') }}" class="text-slate-300 hover:text-amber-400">پایگاه دانش و مقالات</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('public.about') }}" class="text-slate-300 hover:text-amber-400">درباره ما</a>
                <span class="text-slate-700">&bull;</span>
                <a href="{{ route('public.contact') }}" class="text-slate-300 hover:text-amber-400">تماس با ما</a>
            </div>
            
            <div class="text-center text-[11px] text-slate-500">
                تمامی حقوق مادی و معنوی متعلق به سامانه طلالایو (TalaLive.ir) می‌باشد &copy; {{ date('Y') }}.
            </div>
        </div>
    </footer>

    {{-- اسکریپت کنترل تم و متغیرهای Alpine --}}
    <script>
        function publicLandingHandler() {
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
            }
        }
    </script>

    {{-- اسکریپت جفت‌سازی تلویزیون هوشمند (۱۰۰٪ حفظ شده و بدون تغییر منطقی) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ۱. تولید شناسه سشن موقت تصادفی
            const sessionCode = 'sess-' + Math.random().toString(36).substring(2, 10) + Math.random().toString(36).substring(2, 10);
            
            // نمایش کد فعال‌سازی خلاصه روی تلویزیون
            const activationCode = sessionCode.substring(5, 11).toUpperCase();
            const activationCodeEl = document.getElementById('activationCode');
            if (activationCodeEl) {
                activationCodeEl.innerText = activationCode;
            }

            // ثبت سشن در سرور جهت امکان فعال‌سازی دستی با کد ۶ رقمی
            fetch('/api/tv/register-session', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ session_code: sessionCode, activation_code: activationCode })
            }).catch(err => console.error('Failed to register session:', err));

            // ۲. ساخت لینک آدرس نهایی اسکن
            const pairingUrl = window.location.origin + '/admin/pair/' + sessionCode;

            // ۳. لود کردن عکس بارکد
            const qrImage = document.getElementById('qrImage');
            if (qrImage) {
                qrImage.src = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&color=020617&data=' + encodeURIComponent(pairingUrl);
                qrImage.onload = () => {
                    const loader = document.getElementById('qrLoader');
                    if (loader) loader.style.display = 'none';
                };
            }

            // ۴. شروع پولینگ دوره‌ای چک کردن وضعیت جفت‌سازی از سرور
            let checkInterval = setInterval(async () => {
                try {
                    const res = await fetch('/api/tv/check/' + sessionCode);
                    if (!res.ok) return;
                    const data = await res.json();
                    
                    if (data.paired && data.username && data.display_token) {
                        // متوقف کردن پولینگ
                        clearInterval(checkInterval);
                        
                        // ذخیره در LocalStorage تلویزیون
                        localStorage.setItem('display_username', data.username);
                        localStorage.setItem('display_token', data.display_token);
                        
                        // انتقال تلویزیون به تابلوی طلا
                        window.location.href = '/' + data.username + '?key=' + data.display_token;
                    }
                } catch (e) {
                    console.error('Pairing check error:', e);
                }
            }, 3000); // هر ۳ ثانیه
        });
    </script>
</body>
</html>

