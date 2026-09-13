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

    <title>تابلوی هوشمند طلافروشی و تابلو طلا فروشی | نرخ لحظه ای طلا و سکه | طلالایو</title>
    <meta name="description" content="سامانه ابری تابلوی هوشمند نرخ لحظه ای طلا، قیمت سکه بهار آزادی، بهار ازادی، نیم سکه و ربع سکه ویژه تلویزیون مغازه طلا فروشی و طلافروشی‌ها بدون نیاز به کیس.">
    <meta name="keywords" content="تابلوی هوشمند طلافروشی, تابلوی طلا فروشی, تابلو طلا فروشی, نرم افزار تابلو طلا فروشی, قیمت انلاین طلا, نرخ لحظه ای طلا, سکه بهار آزادی, بهار ازادی, بهارآزادی, بهارازادی, نیم سکه, ربع سکه, طلای آب شده, طلای اب شده, طلای دست دوم, دستدوم, کم اجرت, کماجرت, طلالایو, talalive">
    <meta name="robots" content="index, follow">
    <meta name="author" content="طلالایو - TalaLive">
    <link rel="canonical" href="https://talalive.ir/">

    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="تابلوی هوشمند طلافروشی و نمایشگر نرخ مغازه طلا فروشی | طلالایو">
    <meta property="og:description" content="نمایش آنلاین و لحظه ای نرخ طلا و مسکوکات روی تلویزیون مغازه طلافروشی و طلا فروشی با طلالایو. اتصال آسان بدون کابل یا سخت‌افزار اضافه.">
    <meta property="og:url" content="https://talalive.ir/">
    <meta property="og:site_name" content="طلالایو">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:locale" content="fa_IR">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="تابلوی هوشمند طلافروشی و نمایشگر نرخ مغازه طلا فروشی | طلالایو">
    <meta name="twitter:description" content="نمایش آنلاین و لحظه ای نرخ طلا و مسکوکات روی تلویزیون مغازه طلافروشی و طلا فروشی با طلالایو. بدون نیاز به مینی‌کیس و کامپیوتر.">
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
            "نرم افزار تابلوی طلا فروشی",
            "تابلو انلاین طلا فروشی",
            "سیستم نمایش نرخ مغازه طلا فروشی",
            "اعلام نرخ لحظه ای طلا و سکه"
          ],
          "url" => "https://talalive.ir",
          "description" => "سامانه ابری هوشمند تابلوی نرخ لحظه ای طلا، سکه و ارز ویژه تلویزیون‌ها و نمایشگرهای طلافروشی، مغازه طلا فروشی و گالری‌های طلا و جواهر سراسر کشور.",
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
            ],
            [
              "@type" => "Question",
              "name" => "آیا تابلوی طلالایو نرخ انواع مسکوکات نظیر سکه بهار آزادی، بهار ازادی، نیم سکه و ربع سکه را پوشش می‌دهد؟",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "بله، نرخ تمامی مسکوکات شامل سکه امامی، تمام بهار آزادی (بهار ازادی)، نیم سکه، ربع سکه، سکه گرمی، طلای آب شده (طلای اب شده) و مظنه مثقال به صورت لحظه ای و خودکار روی تابلو طلا فروشی آپدیت و نمایش داده می‌شوند."
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
        details > summary::-webkit-details-marker {
            display: none;
        }
        details[open] summary .faq-icon {
            transform: rotate(180deg);
        }
    </style>
</head>
<body x-data="publicLandingHandler()" class="bg-slate-50 dark:bg-[#020617] text-slate-800 dark:text-slate-100 selection:bg-amber-500/30 selection:text-amber-700 dark:selection:text-amber-200 antialiased overflow-x-hidden min-h-screen transition-colors duration-300">

    {{-- بررسی اولیه در کلاینت برای ریدایرکت سریع در صورت جفت شدن قبلی تلویزیون --}}
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
            } else {
                // اگر دستگاه یک تلویزیون هوشمند باشد، برای راه‌اندازی راحت‌تر به /tv هدایت شود
                const isTv = /SmartTV|Tizen|Web0S|NetCast|HbbTV|CrKey|Android TV/i.test(navigator.userAgent);
                if (isTv && window.location.pathname === '/') {
                    window.location.href = '/tv';
                }
            }
        }
    </script>

    {{-- نوار ناوبری شیشه‌ای بالایی مدرن با تم تاریک و روشن --}}
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
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-amber-500/20 text-amber-700 dark:text-amber-300 font-bold">تست رایگان</span>
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
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400 theme-sun-icon transition-transform duration-300 rotate-0 hover:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
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
                <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1 px-2 sm:px-3.5 py-1.5 sm:py-2.5 rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white/90 dark:bg-slate-900/60 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-bold transition-all shadow-sm cursor-pointer whitespace-nowrap">
                    <span>ورود<span class="hidden sm:inline"> همکاران</span></span>
                </a>

                {{-- دکمه ثبت‌نام تست رایگان --}}
                <a href="{{ route('admin.register') }}" class="inline-flex items-center gap-1 px-2.5 sm:px-4 py-1.5 sm:py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 text-xs font-black transition-all shadow-md shadow-amber-500/20 hover:scale-[1.02] cursor-pointer whitespace-nowrap">
                    <span>ثبت‌نام<span class="hidden sm:inline"> رایگان</span></span>
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
                <a href="{{ route('display.tv') }}" class="p-2.5 rounded-xl bg-amber-500/10 text-amber-700 dark:text-amber-400 flex items-center gap-2 border border-amber-500/20">
                    <span>📺 اتصال تلویزیون مغازه (talalive.ir/tv)</span>
                </a>
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
                    <span>تعرفه‌ها و تست رایگان</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-500/20 font-bold">۱۴ روز هدیه</span>
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
                    ثبت‌نام و شروع تست ۱۴ روزه
                </a>
            </div>
        </div>
    </header>

    {{-- بخش ۱: هیرو سکشن لندینگ تجاری طلالایو (B2B High-Converting Hero) --}}
    <section class="relative min-h-[calc(100vh-80px)] flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-10 lg:py-16 overflow-hidden">
        
        {{-- افکت‌های گرادینت پس‌زمینه --}}
        <div class="absolute -top-40 right-1/4 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full max-w-6xl mx-auto flex flex-col z-10">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center w-full">
                
                {{-- ستون سمت راست: ارزش محصول، تیتر سئو و کادر ثبت‌نام سریع با شماره موبایل (۷ ستون) --}}
                <div class="lg:col-span-7 text-right space-y-6 w-full">
                    
                    {{-- بج نسخه نسل جدید --}}
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-800 dark:text-amber-300 text-xs font-bold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                        <span>سامانه نسل جدید تابلوی طلافروشی و مغازه طلا فروشی بدون نیاز به کامپیوتر یا کابل</span>
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
                            تنها با باز کردن مرورگر انواع تلویزیون هوشمند در مغازه طلا فروشی، تابلوی اختصاصی طلا، سکه، ارز و ویترین جواهرات خود را با فرمول سود دلخواه به صورت زنده فعال کنید.
                        </p>
                    </div>

                    {{-- کادر ویژه ثبت‌نام آنی و تست رایگان ۱۴ روزه طلالایو (حل قطعی سردرگمی کاربر جدید) --}}
                    <div class="bg-white dark:bg-slate-900/90 border-2 border-amber-500/50 rounded-3xl p-5 sm:p-6 shadow-2xl backdrop-blur-xl space-y-4">
                        <div class="flex items-center justify-between flex-wrap gap-2">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">🎁</span>
                                <span class="text-xs sm:text-sm font-black text-slate-900 dark:text-amber-300">
                                    شروع تست رایگان ۱۴ روزه طلالایو (ویژه طلافروشان)
                                </span>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border border-emerald-500/30">
                                بدون نیاز به کارت بانکی
                            </span>
                        </div>

                        {{-- فرم ورود شماره همراه برای شروع آنی تست --}}
                        <form action="{{ route('admin.register') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2.5 w-full">
                            <div class="relative flex-1 w-full" dir="ltr">
                                <input type="tel" name="phone" maxlength="11" placeholder="شماره موبایل: 09xxxxxxxxx" required
                                       class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3.5 text-sm sm:text-base text-center font-mono font-black tracking-wider text-slate-900 dark:text-white placeholder:font-sans placeholder:text-xs placeholder:font-normal focus:outline-none focus:border-amber-500 shadow-inner">
                            </div>
                            <button type="submit" 
                                    class="w-full sm:w-auto px-7 py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-xs sm:text-sm shadow-lg shadow-amber-500/30 transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0">
                                <span>دریافت کد و شروع رایگان</span>
                                <span>🚀</span>
                            </button>
                        </form>

                        <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400 pt-1 flex-wrap gap-2">
                            <span class="flex items-center gap-1">
                                <span class="text-amber-500 font-bold">✓</span>
                                <span>راه‌اندازی فوری در کمتر از ۶۰ ثانیه</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="text-amber-500 font-bold">✓</span>
                                <span>تنظیم فرمول سود و اجرت اختصاصی</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="text-amber-500 font-bold">✓</span>
                                <span>پشتیبانی تلفنی و آموزشی رایگان</span>
                            </span>
                        </div>
                    </div>

                    {{-- کارت هدایت شفاف به صفحه اتصال تلویزیون مغازه (/tv) --}}
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-100/90 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800/80 backdrop-blur-md">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl sm:text-3xl">📺</span>
                            <div>
                                <div class="text-xs sm:text-sm font-black text-slate-800 dark:text-slate-100">
                                    می‌خواهید تلویزیون داخل مغازه را به تابلو وصل کنید؟
                                </div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400">
                                    کافیست در مرورگر تلویزیون به آدرس <b class="font-mono text-amber-600 dark:text-amber-400 font-black" dir="ltr">talalive.ir/tv</b> بروید.
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('display.tv') }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 text-white text-xs font-bold shrink-0 transition-colors flex items-center gap-1.5 shadow-sm">
                            <span>صفحه اتصال تلویزیون</span>
                            <span>←</span>
                        </a>
                    </div>
                </div>

                {{-- ستون سمت چپ: ماک‌آپ فوق‌العاده شیک و واقعی تلویزیون هوشمند دیواری با نرخ‌های زنده (۵ ستون) --}}
                <div class="lg:col-span-5 flex flex-col gap-4 w-full max-w-[440px] mx-auto lg:mr-auto lg:ml-0" style="max-width: 440px; width: 100%;">
                    
                    {{-- فریم و قاب دیواری فوق‌العاده مدرن تلویزیون هوشمند --}}
                    <div class="relative rounded-3xl p-3 sm:p-4 bg-gradient-to-b from-slate-700 via-slate-800 to-slate-900 shadow-[0_25px_60px_-15px_rgba(245,158,11,0.25)] border-2 border-slate-600">
                        
                        {{-- صفحه نمایشگر زنده تلویزیون --}}
                        <div class="relative rounded-2xl bg-[#030712] overflow-hidden border border-slate-800 p-3 sm:p-4 text-white aspect-[16/10] flex flex-col justify-between shadow-2xl">
                            
                            {{-- هدر تابلوی تلویزیون --}}
                            <div class="flex items-center justify-between border-b border-slate-800/80 pb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-amber-500/20 border border-amber-500/40 flex items-center justify-center font-black text-amber-400 text-xs">
                                        زر
                                    </div>
                                    <div class="text-right">
                                        <div class="font-black text-xs text-amber-300">گالری طلا و جواهر زرین</div>
                                        <div class="text-[9px] text-slate-400">تابلوی آنلاین نرخ طلا و مسکوکات</div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-1.5 bg-emerald-500/10 border border-emerald-500/30 px-2 py-0.5 rounded-md text-emerald-400 text-[10px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        <span>لحظه‌ای</span>
                                    </div>
                                    <div class="text-left font-mono text-[11px] text-slate-300 font-bold" dir="ltr">
                                        {{ date('H:i') }}
                                    </div>
                                </div>
                            </div>

                            {{-- ۴ کارت نرخ‌های واقعی زنده طلا و مسکوکات در تلویزیون --}}
                            <div class="grid grid-cols-2 gap-2 my-auto">
                                {{-- طلای ۱۸ عیار --}}
                                <div class="bg-slate-900/90 border border-amber-500/30 rounded-xl p-2 text-right space-y-0.5">
                                    <div class="text-[10px] text-slate-400 font-bold">طلای ۱۸ عیار (گرم)</div>
                                    <div class="text-sm sm:text-base font-black text-amber-400 font-mono" dir="ltr">
                                        {{ !empty($rates['gold18']) && $rates['gold18'] > 0 ? number_format($rates['gold18']) : '---' }}
                                    </div>
                                    <div class="text-[9px] text-emerald-400 font-bold">تومان</div>
                                </div>

                                {{-- سکه تمام بهار آزادی / امامی --}}
                                <div class="bg-slate-900/90 border border-amber-500/30 rounded-xl p-2 text-right space-y-0.5">
                                    <div class="text-[10px] text-slate-400 font-bold">سکه بهار آزادی (امامی)</div>
                                    <div class="text-sm sm:text-base font-black text-amber-400 font-mono" dir="ltr">
                                        {{ !empty($rates['coin_emami']) && $rates['coin_emami'] > 0 ? number_format($rates['coin_emami']) : '---' }}
                                    </div>
                                    <div class="text-[9px] text-emerald-400 font-bold">تومان</div>
                                </div>

                                {{-- طلای آبشده --}}
                                <div class="bg-slate-900/90 border border-slate-800 rounded-xl p-2 text-right space-y-0.5">
                                    <div class="text-[10px] text-slate-400 font-bold">طلای آب شده (مظنه ۱۷)</div>
                                    <div class="text-xs sm:text-sm font-bold text-slate-100 font-mono" dir="ltr">
                                        {{ !empty($rates['mesghal']) && $rates['mesghal'] > 0 ? number_format($rates['mesghal']) : '---' }}
                                    </div>
                                    <div class="text-[9px] text-slate-400">تومان</div>
                                </div>

                                {{-- انس جهانی طلا --}}
                                <div class="bg-slate-900/90 border border-slate-800 rounded-xl p-2 text-right space-y-0.5">
                                    <div class="text-[10px] text-slate-400 font-bold">انس جهانی طلا</div>
                                    <div class="text-xs sm:text-sm font-bold text-slate-100 font-mono" dir="ltr">
                                        {{ !empty($rates['ons']) && $rates['ons'] > 0 ? '$ ' . number_format($rates['ons'], 1) : '---' }}
                                    </div>
                                    <div class="text-[9px] text-slate-400">دلار</div>
                                </div>
                            </div>

                            {{-- نوار زیرین: ویترین و زیرنویس روان --}}
                            <div class="border-t border-slate-800/80 pt-1.5 flex items-center justify-between text-[9px] text-slate-400">
                                <span class="truncate">خرید و فروش انواع طلا و سکه با بهترین نرخ بازار</span>
                                <span class="font-mono text-amber-400 shrink-0">TalaLive.ir</span>
                            </div>

                            {{-- انعکاس شیشه و نور ملایم تلویزیون --}}
                            <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/[0.03] to-transparent pointer-events-none"></div>
                        </div>

                        {{-- دکمه پاور و چراغ استندبای تلویزیون در زیر فریم --}}
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse mx-auto mt-2 shadow-sm shadow-emerald-500"></div>
                    </div>

                    {{-- زیرنویس اعتمادساز زیر ماک‌آپ --}}
                    <div class="text-center space-y-1">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300">
                            ✨ قابل اجرا روی تمامی تلویزیون‌های هوشمند و معمولی
                        </p>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">
                            سامسونگ، ال‌جی، سونی، اسنوا، دوو و شیائومی بدون نیاز به خرید مینی‌کیس
                        </p>
                    </div>

                    {{-- کادر ارتباط فوری با پشتیبانی فنی --}}
                    <div class="w-full bg-white dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-3.5 text-center text-xs space-y-1.5 backdrop-blur-xl shadow-md">
                        <p class="text-slate-500 dark:text-slate-400 font-bold text-[11px]">مشاوره رایگان و راه‌اندازی فوری تابلوی طلافروشی:</p>
                        <p class="text-amber-600 dark:text-amber-400 font-black text-sm tracking-wider" dir="ltr">
                            <a href="tel:09187009064" class="hover:underline">0918 700 9064</a>
                            &nbsp;&middot;&nbsp;
                            <a href="tel:08135223847" class="hover:underline">081 3522 3847</a>
                        </p>
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
                    برای باز کردن تابلوی طلالایو، کافیست با کنترل تلویزیون خود وارد برنامه مرورگر اینترنت شوید و آدرس <b class="font-mono text-amber-500">talalive.ir/tv</b> را وارد نمایید. روی برند تلویزیون مغازه‌تان کلیک کنید:
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

    {{-- بخش ۴: امکانات و ویژگی‌های اختصاصی طلالایو --}}
    <section id="features" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="text-center space-y-4 mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-400 text-xs font-bold">
                <span>مزایای رقابتی تابلوی طلالایو</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                چرا طلالایو انتخاب اول مدرن‌ترین طلافروشی‌های کشور است؟
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
                ترکیب فناوری پیشرفته ابری، بالاترین استانداردهای بصری و حذف هزینه‌های سنگین کابل‌کشی و تعمیرات سخت‌افزاری.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            <div class="bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-3xl p-7 space-y-4 shadow-xl hover:border-amber-500/50 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-2xl font-black">
                    ⚡
                </div>
                <h3 class="text-lg font-black text-slate-900 dark:text-white">اتصال فوری بدون سیم و مینی‌کیس</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    دیگر نیازی به خرید کامپیوتر چند ده میلیونی، فن‌های پر سر و صدا یا سیم‌کشی‌های زشت در دکور مغازه نیست. تلویزیون مغازه به تنهایی کافیست.
                </p>
            </div>

            <div class="bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-3xl p-7 space-y-4 shadow-xl hover:border-amber-500/50 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl font-black">
                    🛡️
                </div>
                <h3 class="text-lg font-black text-slate-900 dark:text-white">فناوری ضد قطعی اینترنت (آفلاین)</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    در صورت قطعی مقطعی اینترنت یا فیلترینگ، صفحه تلویزیون سیاه نمی‌شود! آخرین نرخ‌های معتبر همراه با اسلایدشوی ویترین به نمایش پایدار ادامه می‌دهند.
                </p>
            </div>

            <div class="bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-3xl p-7 space-y-4 shadow-xl hover:border-amber-500/50 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl font-black">
                    🎛️
                </div>
                <h3 class="text-lg font-black text-slate-900 dark:text-white">فرمول‌ساز سود و اجرت شخصی</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    در پنل مدیریت موبایل، درصد سود فروش، حاشیه خرید، مالیات و تخفیف‌ها را به ازای هر گرم طلا یا نوع سکه مطابق سیاست گالری خود تنظیم فرمایید.
                </p>
            </div>
        </div>
    </section>

    {{-- بخش ۵: مقایسه جامع تابلوی تلویزیون هوشمند با تابلوهای سنتی LED --}}
    <section id="comparison" class="py-16 px-4 sm:px-6 lg:px-8 bg-slate-100/60 dark:bg-slate-900/30 border-y border-slate-200/80 dark:border-slate-800/80">
        <div class="max-w-5xl mx-auto space-y-10">
            <div class="text-center space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-400 text-xs font-bold">
                    <span>تحول فناوری در طلافروشی</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                    مقایسه تابلوی هوشمند طلالایو با تابلوهای سنتی LED روان
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-xl mx-auto">
                    چرا دوره تابلوهای LED تک‌رنگ و هزینه‌بر به پایان رسیده است؟
                </p>
            </div>

            <div class="overflow-x-auto rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl bg-white dark:bg-slate-900">
                <table class="w-full text-right text-xs sm:text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-950/80 border-b border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-200 font-black">
                        <tr>
                            <th class="p-4 sm:p-5">ویژگی و امکانات</th>
                            <th class="p-4 sm:p-5 text-amber-600 dark:text-amber-400">سامانه ابری طلالایو (تلویزیون هوشمند)</th>
                            <th class="p-4 sm:p-5 text-slate-500">تابلوهای سنتی روان LED</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-slate-600 dark:text-slate-300">
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">کیفیت و جذابیت بصری</td>
                            <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">فوق‌العاده لوکس و مدرن با کیفیت 4K / Full HD</td>
                            <td class="p-4 sm:p-5 text-rose-500">پیکسل‌های درشت، نامناسب برای گالری‌های لوکس</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">پخش اسلایدشو و ویترین جواهرات</td>
                            <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">پخش تصاویر باکیفیت و QR اینستاگرام گالری</td>
                            <td class="p-4 sm:p-5 text-rose-500">غیرممکن (فقط متن ساده تک‌رنگ)</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">بروزرسانی خودکار نرخ‌ها</td>
                            <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">خودکار و بلادرنگ بدون دخالت دست</td>
                            <td class="p-4 sm:p-5 text-rose-500">نیاز به وارد کردن دستی قیمت با کیبورد یا فلش</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">هزینه اولیه سخت‌افزار</td>
                            <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">۰ تومان (استفاده از تلویزیون موجود مغازه)</td>
                            <td class="p-4 sm:p-5 text-rose-500">هزینه سنگین خرید ماژول LED و قاب اختصاصی</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 dark:text-white">هزینه تعمیر و نگهداری</td>
                            <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">صفر &middot; بروزرسانی ابری خودکار</td>
                            <td class="p-4 sm:p-5 text-rose-500">سوختن مداوم پاور، ماژول و لامپ‌های LED</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- بخش ۶: تعرفه‌ها و بسته‌های اشتراک (Pricing Table) --}}
    <section id="pricing" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="text-center space-y-4 mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-400 text-xs font-bold">
                <span>شفافیت کامل تعرفه‌ها</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                پلن‌های اشتراک تابلوی طلالایو
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
                شروع با ۱۴ روز تست کاملاً رایگان بدون هیچ پیش‌شرط، با امکان تمدید آنلاین و فوری در هر زمان.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto items-stretch">
            
            {{-- پلن تستی رایگان --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-7 flex flex-col justify-between space-y-6 shadow-sm">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-base font-black text-slate-900 dark:text-white">تست آزمایشی گالری</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] bg-slate-100 dark:bg-slate-800 font-bold text-slate-600 dark:text-slate-300">هدیه عضویت</span>
                    </div>
                    <div class="space-y-1">
                        <div class="text-3xl font-black text-amber-600 dark:text-amber-400 font-mono">رایگان</div>
                        <div class="text-xs text-slate-500">۱۴ روز استفاده کامل بدون محدودیت</div>
                    </div>
                    <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-300 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <li class="flex items-center gap-2"><span>✓</span><span>اتصال بی‌سیم به ۱ تلویزیون مغازه</span></li>
                        <li class="flex items-center gap-2"><span>✓</span><span>بروزرسانی لحظه‌ای نرخ‌های رسمی طلا و سکه</span></li>
                        <li class="flex items-center gap-2"><span>✓</span><span>تنظیم فرمول سود و اجرت شخصی</span></li>
                        <li class="flex items-center gap-2"><span>✓</span><span>پشتیبانی تلفنی و راه‌اندازی</span></li>
                    </ul>
                </div>
                <a href="{{ route('admin.register') }}" class="w-full text-center py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-black text-xs transition-colors">
                    شروع تست رایگان ۱۴ روزه
                </a>
            </div>

            {{-- پلن اقتصادی ۶ ماهه --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-7 flex flex-col justify-between space-y-6 shadow-sm">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-base font-black text-slate-900 dark:text-white">اشتراک ۶ ماهه</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] bg-blue-500/10 text-blue-600 dark:text-blue-400 font-bold">اقتصادی</span>
                    </div>
                    <div class="space-y-1">
                        <div class="text-3xl font-black text-slate-900 dark:text-white font-mono">۱,۴۹۰,۰۰۰ <span class="text-xs font-normal">تومان</span></div>
                        <div class="text-xs text-slate-500">معادل ماهانه کمتر از ۲۵۰ هزار تومان</div>
                    </div>
                    <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-300 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <li class="flex items-center gap-2"><span>✓</span><span>تمام امکانات پلن آزمایشی</span></li>
                        <li class="flex items-center gap-2"><span>✓</span><span>اسلایدشو و ویترین دیجیتال جواهرات</span></li>
                        <li class="flex items-center gap-2"><span>✓</span><span>پایداری ۱۰۰٪ در قطعی اینترنت</span></li>
                        <li class="flex items-center gap-2"><span>✓</span><span>پشتیبانی فنی و اولویت بروزرسانی</span></li>
                    </ul>
                </div>
                <a href="{{ route('admin.register') }}" class="w-full text-center py-3 rounded-2xl border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200 font-bold text-xs transition-colors">
                    ثبت‌نام و خرید اشتراک
                </a>
            </div>

            {{-- پلن ویژه ۱ ساله VIP (پیشنهادی) --}}
            <div class="bg-gradient-to-b from-amber-500/15 via-white dark:via-slate-900 to-amber-500/10 border-2 border-amber-500/60 rounded-3xl p-7 flex flex-col justify-between space-y-6 shadow-2xl relative">
                <div class="absolute -top-3.5 right-1/2 translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-black text-[10px] shadow-md">
                    محبوب‌ترین انتخاب طلافروشان
                </div>
                <div class="space-y-4 pt-2">
                    <div class="flex items-center justify-between">
                        <span class="text-base font-black text-amber-600 dark:text-amber-400">اشتراک ۱ ساله VIP</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] bg-amber-500/20 text-amber-700 dark:text-amber-300 font-bold">بیشترین تخفیف</span>
                    </div>
                    <div class="space-y-1">
                        <div class="text-3xl font-black text-amber-600 dark:text-amber-400 font-mono">۲,۴۹۰,۰۰۰ <span class="text-xs font-normal">تومان</span></div>
                        <div class="text-xs text-slate-500">۲ ماه اشتراک رایگان هدیه (سالانه)</div>
                    </div>
                    <ul class="space-y-2.5 text-xs text-slate-700 dark:text-slate-200 pt-3 border-t border-amber-500/20">
                        <li class="flex items-center gap-2 font-bold"><span class="text-amber-500">✓</span><span>پشتیبانی اختصاصی VIP در تمام روزهای هفته</span></li>
                        <li class="flex items-center gap-2"><span class="text-amber-500">✓</span><span>ویترین هوشمند نامحدود برای نمایش محصولات</span></li>
                        <li class="flex items-center gap-2"><span class="text-amber-500">✓</span><span>شخصی‌سازی کامل تم و فونت تابلوی تلویزیون</span></li>
                        <li class="flex items-center gap-2"><span class="text-amber-500">✓</span><span>نصب و تنظیم فرمول‌ها توسط کارشناس</span></li>
                    </ul>
                </div>
                <a href="{{ route('admin.register') }}" class="w-full text-center py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-xs shadow-lg shadow-amber-500/25 transition-all">
                    انتخاب پلن ۱ ساله VIP
                </a>
            </div>

        </div>
    </section>

    {{-- بخش ۷: سوالات متداول طلافروشان (FAQ Accordion) --}}
    <section id="faq" class="py-20 px-4 sm:px-6 lg:px-8 bg-slate-100/60 dark:bg-slate-900/40 border-t border-slate-200/80 dark:border-slate-800/80">
        <div class="max-w-4xl mx-auto space-y-8">
            <div class="text-center space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-400 text-xs font-bold">
                    <span>پاسخ به ابهامات متداول</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                    سوالات متداول طلافروشان و همکاران محترم
                </h2>
            </div>

            <div class="space-y-3">
                <details class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-sm text-slate-900 dark:text-white">
                        <span>آیا برای راه‌اندازی تابلوی طلالایو نیاز به خرید کامپیوتر یا دستگاه جداگانه در مغازه هست؟</span>
                        <span class="faq-icon transition-transform duration-200 text-amber-500">▼</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 pt-3">
                        خیر، هیچ نیازی به خرید مینی‌کیس، کامپیوتر یا دانگل اضافه نیست. شما می‌توانید تنها با استفاده از مرورگر وب داخلی هر نوع تلویزیون هوشمند (سامسونگ، ال‌جی، سونی، اسنوا، دوو یا اندروید تی‌وی) و اسکن یکبار QR کد، تابلوی اختصاصی طلافروشی خود را بدون سیم‌کشی راه‌اندازی کنید.
                    </p>
                </details>

                <details class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-sm text-slate-900 dark:text-white">
                        <span>نرخ‌های طلا، سکه و ارز از چه مراجعی بروزرسانی می‌شوند؟</span>
                        <span class="faq-icon transition-transform duration-200 text-amber-500">▼</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 pt-3">
                        نرخ‌ها به صورت خودکار و لحظه‌ای از معتبرترین مراجع رسمی بازار طلا و جواهر کشور، اتحادیه‌های طلا و سکه و مراجع رسمی انس جهانی دریافت می‌شوند و به صورت بلادرنگ روی تابلوی شما آپدیت می‌گردند.
                    </p>
                </details>

                <details class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-sm text-slate-900 dark:text-white">
                        <span>در صورت قطعی موقت اینترنت در طلافروشی چه اتفاقی می‌افتد؟</span>
                        <span class="faq-icon transition-transform duration-200 text-amber-500">▼</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 pt-3">
                        طلالایو مجهز به فناوری کش هوشمند آفلاین است. در صورت قطعی اینترنت، تابلوی شما هرگز سیاه یا متوقف نمی‌شود؛ بلکه آخرین نرخ‌های دریافتی معتبر را با برچسب ساعت آخرین بروزرسانی همراه با ویترین محصولات به نمایش مداوم ادامه می‌دهد.
                    </p>
                </details>

                <details class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-sm text-slate-900 dark:text-white">
                        <span>چگونه می‌توان فرمول سود، اجرت یا مظنه را برای طلافروشی شخصی‌سازی کرد؟</span>
                        <span class="faq-icon transition-transform duration-200 text-amber-500">▼</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 pt-3">
                        از طریق پنل مدیریت موبایل یا کامپیوتر، بخش فرمول‌ساز هوشمند در اختیارتان قرار دارد که می‌توانید درصد سود فروش، حاشیه خرید، مالیات و تخفیف‌ها را به ازای هر گرم یا نوع سکه اختصاصی‌سازی کنید تا نرخ‌ها مطابق با سیاست مالی گالری شما محاسبه و نمایش یابند.
                    </p>
                </details>

                <details class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-sm text-slate-900 dark:text-white">
                        <span>آیا اتصال تلویزیون پس از هر بار خاموش و روشن شدن مغازه قطع می‌شود؟</span>
                        <span class="faq-icon transition-transform duration-200 text-amber-500">▼</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/80 pt-3">
                        خیر، اطلاعات اتصال تلویزیون شما در حافظه پایدار مرورگر تلویزیون به صورت خودکار ذخیره می‌شود و با روشن شدن تلویزیون، صفحه بدون نیاز به اسکن مجدد فوراً باز شده و به تابلوی زنده شما متصل می‌گردد.
                    </p>
                </details>
            </div>
        </div>
    </section>

    {{-- بخش ۸: پایگاه دانش و راهنماهای تخصصی طلا و سکه --}}
    <section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="flex items-center justify-between flex-wrap gap-4 mb-10">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                    دانشنامه، ابزارها و راهنماهای صنف طلا و جواهر
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    مقالات تخصصی نحوه محاسبه اجرت، عیار، سود مغازه و حباب انواع سکه
                </p>
            </div>
            <a href="{{ route('public.guides') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:underline flex items-center gap-1">
                <span>مشاهده تمام مقالات و آموزش‌ها</span>
                <span>←</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('public.guides.show', 'gold-price-formula-18k') }}" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3 hover:border-amber-500/50 transition-all shadow-sm group">
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-sm">
                    📐
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 leading-snug">
                    فرمول دقیق محاسبه قیمت طلا ۱۸ عیار با اجرت و سود مغازه طلا فروشی
                </h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2">
                    آموزش نحوه محاسبه فاکتور طلا، طلای دست دوم، کم اجرت و سود قانونی اتحادیه طلا.
                </p>
            </a>

            <a href="{{ route('public.guides.show', 'how-to-calculate-coin-bubble') }}" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3 hover:border-amber-500/50 transition-all shadow-sm group">
                <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black text-sm">
                    🫧
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 leading-snug">
                    فرمول محاسبه حباب سکه امامی، بهار آزادی، نیم سکه و ربع سکه
                </h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2">
                    نحوه محاسبه ارزش ذاتی و حباب سکه بهار آزادی، بهار ازادی، نیم سکه و ربع سکه با انس طلا.
                </p>
            </a>

            <a href="{{ route('public.guides.show', 'best-tv-for-jewelry-shop') }}" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3 hover:border-amber-500/50 transition-all shadow-sm group">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-black text-sm">
                    📺
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 leading-snug">
                    راهنمای انتخاب بهترین تلویزیون برای تابلو طلا فروشی و مغازه طلافروشی
                </h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2">
                    مقایسه تلویزیون‌های سامسونگ، ال‌جی و اسنوا از نظر طول عمر پنل و وضوح در نور ویترین.
                </p>
            </a>

            <a href="{{ route('public.guides.show', 'gold-tax-regulations') }}" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3 hover:border-amber-500/50 transition-all shadow-sm group">
                <div class="w-9 h-9 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-black text-sm">
                    📑
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 leading-snug">
                    قانون جدید مالیات طلا و اجرت در سامانه مودیان صنف طلا
                </h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2">
                    بررسی تکالیف مالیاتی طلافروشان، معافیت اصل طلا و محاسبه مالیات روی اجرت و سود.
                </p>
            </a>
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
                    <li><a href="{{ route('display.tv') }}" class="text-amber-400 font-bold hover:underline">📺 صفحه اتصال تلویزیون مغازه</a></li>
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
</body>
</html>
