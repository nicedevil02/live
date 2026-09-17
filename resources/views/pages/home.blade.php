@extends('layouts.public')

@section('title', 'طلالایو — سامانه ابری مدیریت تابلو و نرخ لحظه‌ای طلافروشی')
@section('meta_description', 'سامانه هوشمند و ابری تابلوی طلافروشی طلالایو: نمایش آنلاین نرخ طلا، سکه و ارز روی تلویزیون مغازه بدون مینی‌کیس در کمتر از ۳ دقیقه با تست رایگان ۱۴ روزه.')
@section('canonical', 'https://talalive.ir/')

@section('schema')
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
          "sameAs" => [
            "https://rubika.ir/talalive"
          ],
          "address" => [
            "@type" => "PostalAddress",
            "addressLocality" => "همدان",
            "addressRegion" => "همدان",
            "streetAddress" => "راسته مظفریه",
            "addressCountry" => "IR"
          ],
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
                "text" => "نرخ‌ها به صورت خودکار و لحظه‌ای از مراجع معتبر و منتخب بازار طلا و جواهر کشور، اتحادیه‌های طلا و سکه و مراجع رسمی انس جهانی دریافت می‌شوند و به صورت بلادرنگ روی تابلوی شما آپدیت می‌گردند."
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
              "name" => "آیا تابلوی طلالایو نرخ انواع مسکوکات نظیر سکه بهار آزادی، نیم سکه و ربع سکه را پوشش می‌دهد؟",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "بله، نرخ تمامی مسکوکات شامل سکه امامی، تمام بهار آزادی، نیم سکه، ربع سکه، سکه گرمی، طلای آب‌شده و مظنه مثقال به صورت لحظه‌ای و خودکار روی تابلو طلا فروشی آپدیت و نمایش داده می‌شوند."
              ]
            ]
          ]
        ]
      ]
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection

@section('content')
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


        {{-- بخش ۱: هیرو سکشن لندینگ تجاری طلالایو (Apple Luxury Studio Hero) --}}
    <section class="relative min-h-[calc(100vh-80px)] flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-10 lg:py-16 overflow-hidden">
        
        {{-- افکت‌های گرادینت پس‌زمینه و نور امبیانت کلی --}}
        <div class="absolute -top-40 right-1/4 w-[500px] h-[500px] bg-gradient-to-br from-amber-500/15 via-yellow-500/10 to-transparent rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 left-1/4 w-[500px] h-[500px] bg-gradient-to-tr from-blue-600/10 via-amber-500/5 to-transparent rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full max-w-7xl mx-auto flex flex-col z-10">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center w-full">
                
                {{-- ستون سمت راست: ارزش محصول، تیتر سئو و پنل تبدیل یکپارچه (۷ ستون) --}}
                <div class="lg:col-span-7 text-right space-y-6 w-full">
                    
                    {{-- بج نسخه نسل جدید --}}
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-gradient-to-r from-amber-500/15 via-amber-500/10 to-yellow-500/15 border border-amber-500/30 text-amber-900 dark:text-amber-300 text-xs font-black shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981] animate-pulse"></span>
                        <span>✨ نسل نوین سامانه‌های نمایش نرخ لحظه‌ای و ویترین طلا</span>
                    </div>

                    {{-- تیتر اصلی سئو و معرفی باشکوه --}}
                    <div class="space-y-4">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white leading-tight tracking-tight">
                            <span class="block text-base sm:text-xl lg:text-2xl text-amber-600 dark:text-amber-400 font-extrabold tracking-normal mb-2 leading-snug">
                                سامانه هوشمند طلالایو
                            </span>
                            مدیریت ابری تابلو و نرخ لحظه‌ای <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 via-amber-500 to-yellow-500 dark:from-amber-300 dark:via-amber-400 dark:to-yellow-400">
                                روی تلویزیون مغازه طلافروشی
                            </span>
                        </h1>
                        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base lg:text-lg leading-relaxed max-w-2xl">
                            خداحافظی همیشگی با تابلوهای سنتی، زشت و گران‌قیمت LED. بدون نیاز به مینی‌کیس، کامپیوتر یا کابل‌کشی؛ تابلوی اختصاصی نرخ لحظه‌ای طلا، سکه و ویترین دیجیتال جواهرات خود را تنها در ۶۰ ثانیه با ریموت تلویزیون مغازه روشن کنید.
                        </p>
                    </div>

                    {{-- پنل یکپارچه تبدیل (Unified Conversion Card) --}}
                    <div class="bg-white/95 dark:bg-slate-900/85 border border-slate-200/90 dark:border-amber-500/30 rounded-3xl p-5 sm:p-7 shadow-2xl shadow-slate-200/60 dark:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.7)] backdrop-blur-2xl space-y-5 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 via-transparent to-yellow-500/5 pointer-events-none"></div>

                        <div class="flex items-center justify-between flex-wrap gap-2 relative z-10">
                            <div class="flex items-center gap-2">
                                <span class="text-xl">🎁</span>
                                <span class="text-xs sm:text-sm font-black text-slate-900 dark:text-amber-300">
                                    شروع تست رایگان ۱۴ روزه طلالایو (ویژه طلافروشان)
                                </span>
                            </div>
                            <span class="text-[11px] font-bold px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border border-emerald-500/30 shadow-sm">
                                بدون نیاز به کارت بانکی یا پیش‌پرداخت
                            </span>
                        </div>

                        {{-- فرم ورود شماره همراه برای ورود سریع به ثبت‌نام --}}
                        <form action="{{ route('admin.register') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full relative z-10">
                            <div class="relative flex-1 w-full" dir="ltr">
                                <input type="tel" name="phone" maxlength="11" placeholder="شماره موبایل: 09xxxxxxxxx" required
                                       class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-3.5 text-base text-center font-mono font-black tracking-wider text-slate-900 dark:text-white placeholder:font-sans placeholder:text-xs placeholder:font-normal focus:outline-none focus:border-amber-500 dark:focus:border-amber-400 shadow-inner transition-colors">
                            </div>
                            <button type="submit" 
                                    class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 via-amber-500 to-yellow-500 hover:from-amber-400 hover:to-yellow-400 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/30 hover:shadow-amber-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0">
                                <span>دریافت کد و شروع فوری</span>
                                <span>🚀</span>
                            </button>
                        </form>

                        {{-- نوار هدایت شفاف به پیش‌نمایش دموی زنده و اتصال تلویزیون --}}
                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs relative z-10">
                            <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                <span class="text-base">📺</span>
                                <span>می‌خواهید تابلوی زنده را بدون ثبت‌نام تست کنید؟</span>
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <a href="{{ url('/demo') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-amber-500/20 hover:bg-amber-500/30 text-amber-800 dark:text-amber-300 font-black text-xs transition-colors shadow-sm shrink-0 border border-amber-500/30">
                                    <span>مشاهده دموی زنده تابلو (/demo)</span>
                                    <span>←</span>
                                </a>
                                <a href="{{ route('display.tv') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs transition-colors shadow-sm shrink-0">
                                    <span>اتصال تلویزیون (/tv)</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- نوار شاخص‌های اعتماد ویژه طلافروشان --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 pt-1 text-xs text-slate-600 dark:text-slate-400 font-bold">
                        <div class="flex items-center gap-2 bg-slate-100/70 dark:bg-slate-900/50 border border-slate-200/80 dark:border-slate-800 px-3 py-2 rounded-xl">
                            <span class="text-amber-500 text-sm">⚡</span>
                            <span class="truncate">راه‌اندازی در ۶۰ ثانیه</span>
                        </div>
                        <div class="flex items-center gap-2 bg-slate-100/70 dark:bg-slate-900/50 border border-slate-200/80 dark:border-slate-800 px-3 py-2 rounded-xl">
                            <span class="text-emerald-500 text-sm">🛡️</span>
                            <span class="truncate">پایداری کامل آفلاین</span>
                        </div>
                        <div class="flex items-center gap-2 bg-slate-100/70 dark:bg-slate-900/50 border border-slate-200/80 dark:border-slate-800 px-3 py-2 rounded-xl">
                            <span class="text-blue-500 text-sm">🎛️</span>
                            <span class="truncate">فرمول سود دلخواه</span>
                        </div>
                    </div>
                </div>

                {{-- ستون سمت چپ: تلویزیون ۶۵ اینچ شناور با نور مخفی طلایی (۵ ستون) --}}
                <div class="lg:col-span-5 flex flex-col gap-4 w-full max-w-[460px] mx-auto lg:mr-auto lg:ml-0" style="max-width: 460px; width: 100%;">
                    
                    <div class="relative w-full">
                        {{-- هاله نور مخفی پشت تلویزیون روی دیوار گالری (Bias Ambient Lighting) --}}
                        <div class="absolute -inset-4 bg-gradient-to-r from-amber-500/25 via-yellow-500/30 to-amber-600/20 blur-3xl rounded-[40px] opacity-75 dark:opacity-90 pointer-events-none"></div>

                        {{-- فریم و قاب تیتانیومی تلویزیون هوشمند ۶۵ اینچ دیواری --}}
                        <div class="relative rounded-[28px] p-2 sm:p-2.5 bg-gradient-to-b from-slate-600 via-slate-800 to-slate-950 shadow-[0_30px_80px_-15px_rgba(0,0,0,0.7),0_0_40px_rgba(245,158,11,0.2)] border border-slate-500/40 transform transition-transform hover:scale-[1.01] duration-500">
                            
                            @php
                                $previewImage = null;
                                $potentialPreviewPaths = [
                                    'images/tv-preview.png',
                                    'images/tv-preview.jpg',
                                    'images/tv-preview.webp',
                                    'images/preview.png',
                                    'images/preview.jpg',
                                    'images/tv.png',
                                    'images/tv.jpg',
                                    'images/board.png',
                                    'images/board.jpg',
                                ];
                                foreach ($potentialPreviewPaths as $path) {
                                    if (file_exists(public_path($path)) || file_exists(base_path('public_html/' . $path))) {
                                        $previewImage = $path;
                                        break;
                                    }
                                }
                            @endphp

                            @if($previewImage)
                                {{-- نمایش اسکرین‌شات واقعی و فوق‌العاده باکیفیت تابلوی نرخ طلا روی تلویزیون --}}
                                <div class="relative rounded-2xl bg-[#020617] overflow-hidden border border-amber-500/30 aspect-[16/10] shadow-2xl group flex items-center justify-center select-none">
                                    <img src="{{ asset($previewImage) }}" 
                                         alt="اسکرین‌شات تابلوی هوشمند نرخ لحظه‌ای طلا و سکه طلالایو روی تلویزیون مغازه" 
                                         class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-[1.02]">
                                    
                                    {{-- بازتاب فوتوریالیستیک شیشه و نور ملایم نمایشگر OLED --}}
                                    <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/[0.05] to-transparent pointer-events-none"></div>
                                </div>
                            @else
                                {{-- صفحه نمایشگر زنده تلویزیون با تم مشکی سلطنتی Imperial Onyx 24K --}}
                                <div class="relative rounded-2xl bg-[#020617] overflow-hidden border border-amber-500/30 text-white aspect-[16/10] flex flex-col justify-between p-3 sm:p-4 shadow-2xl select-none">
                                    
                                    {{-- هدر تابلوی تلویزیون با پرستیژ زرین --}}
                                    <div class="flex items-center justify-between border-b border-amber-500/20 pb-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-xl bg-gradient-to-br from-amber-400 to-yellow-600 text-slate-950 font-black text-xs flex items-center justify-center shadow-md shadow-amber-500/30">
                                                زر
                                            </div>
                                            <div class="text-right">
                                                <div class="font-black text-xs text-amber-300 tracking-tight">گالری طلا و جواهر زرین</div>
                                                <div class="text-[9px] text-slate-400">تابلوی رسمی نرخ لحظه‌ای و مسکوکات</div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <div class="flex items-center gap-1.5 bg-emerald-500/15 border border-emerald-500/40 px-2 py-0.5 rounded-full text-emerald-400 text-[10px] font-black shadow-sm">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                                <span>نرخ زنده</span>
                                            </div>
                                            <div class="text-left font-mono text-xs text-amber-400/90 font-black" dir="ltr">
                                                {{ date('H:i') }}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ۴ کارت نرخ‌های واقعی لوکس نئومورفیک شیشه‌ای --}}
                                    <div class="grid grid-cols-2 gap-2 my-auto">
                                        {{-- طلای ۱۸ عیار (کارت هیرو و پادشاه تابلو) --}}
                                        <div class="relative bg-gradient-to-b from-amber-500/15 via-slate-900/90 to-slate-950 border border-amber-400/50 rounded-xl p-2 text-right space-y-0.5 shadow-lg shadow-amber-500/10">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[10px] text-amber-300 font-black">طلای ۱۸ عیار (گرم)</span>
                                                <span class="text-[8px] px-1 py-0.2 rounded bg-amber-500/20 text-amber-300 font-bold">شاخص</span>
                                            </div>
                                            <div class="text-sm sm:text-base font-black text-amber-400 font-mono tracking-wider drop-shadow-[0_2px_8px_rgba(251,191,36,0.3)]" dir="ltr">
                                                {{ !empty($rates['gold18']) && $rates['gold18'] > 0 ? number_format($rates['gold18']) : '۴,۶۵۰,۰۰۰' }}
                                            </div>
                                            <div class="text-[9px] text-emerald-400 font-bold flex items-center justify-between">
                                                <span>تومان</span>
                                                <span class="font-mono text-[8px] text-slate-400">۱۸K</span>
                                            </div>
                                        </div>

                                        {{-- سکه تمام بهار آزادی / امامی --}}
                                        <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-2 text-right space-y-0.5">
                                            <div class="text-[10px] text-slate-300 font-bold">سکه بهار آزادی (امامی)</div>
                                            <div class="text-sm sm:text-base font-black text-amber-300 font-mono tracking-wider" dir="ltr">
                                                {{ !empty($rates['coin_emami']) && $rates['coin_emami'] > 0 ? number_format($rates['coin_emami']) : '۵۲,۸۰۰,۰۰۰' }}
                                            </div>
                                            <div class="text-[9px] text-emerald-400 font-bold">تومان</div>
                                        </div>

                                        {{-- نیم سکه بهار آزادی --}}
                                        <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-2 text-right space-y-0.5">
                                            <div class="text-[10px] text-slate-300 font-bold">نیم سکه بهار آزادی</div>
                                            <div class="text-xs sm:text-sm font-black text-slate-100 font-mono tracking-wider" dir="ltr">
                                                {{ !empty($rates['coin_nim']) && $rates['coin_nim'] > 0 ? number_format($rates['coin_nim']) : '۲۸,۴۰۰,۰۰۰' }}
                                            </div>
                                            <div class="text-[9px] text-slate-400">تومان</div>
                                        </div>

                                        {{-- انس جهانی طلا --}}
                                        <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-2 text-right space-y-0.5">
                                            <div class="text-[10px] text-slate-300 font-bold">انس جهانی طلا</div>
                                            <div class="text-xs sm:text-sm font-black text-slate-100 font-mono tracking-wider" dir="ltr">
                                                {{ !empty($rates['ons']) && $rates['ons'] > 0 ? '$ ' . number_format($rates['ons'], 1) : '$ ۲,۷۳۵.۵' }}
                                            </div>
                                            <div class="text-[9px] text-slate-400">دلار</div>
                                        </div>
                                    </div>

                                    {{-- نوار متحرک ویترین در زیر صفحه --}}
                                    <div class="border-t border-amber-500/20 pt-1.5 flex items-center justify-between text-[9px] text-slate-400">
                                        <span class="truncate text-amber-200/80">✨ جدیدترین کالکشن النگو و سرویس‌های لوکس بدون اجرت</span>
                                        <span class="font-mono text-amber-400 shrink-0 font-bold">TalaLive.ir</span>
                                    </div>

                                    {{-- انعکاس شیشه فوتوریالیستیک اپل --}}
                                    <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/[0.04] to-transparent pointer-events-none"></div>
                                </div>
                            @endif

                            {{-- دکمه پاور و چراغ استندبای تلویزیون --}}
                            <div class="flex items-center justify-center gap-1.5 mt-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399] animate-pulse"></div>
                                <span class="text-[9px] font-mono text-slate-400 tracking-widest uppercase">OLED 4K HDR</span>
                            </div>
                        </div>
                    </div>

                    {{-- کپسول سازگاری تلویزیون --}}
                    <div class="text-center space-y-1">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300">
                            📺 سازگار با انواع تلویزیون هوشمند
                        </p>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">
                            سامسونگ، ال‌جی، سونی، اسنوا، دوو، شیائومی و انواع اندروید باکس
                        </p>
                    </div>

                    {{-- کادر ارتباط فوری با پشتیبانی فنی --}}
                    <div class="w-full bg-white dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-3 text-center text-xs space-y-1.5 backdrop-blur-xl shadow-md">
                        <p class="text-slate-500 dark:text-slate-400 font-bold text-[11px]">پشتیبانی و راه‌اندازی فوری تابلوی طلافروشی:</p>
                        <p class="text-amber-600 dark:text-amber-400 font-black text-sm tracking-wider" dir="ltr">
                            <a href="tel:09187009064" class="hover:underline">0918 700 9064</a>
                            &nbsp;&middot;&nbsp;
                            <a href="tel:08135223847" class="hover:underline">081 3522 3847</a>
                        </p>
                        <div class="pt-0.5 flex items-center justify-center gap-2 flex-wrap">
                            <span class="text-slate-700 dark:text-slate-300 font-bold text-[11px]">پشتیبانی در پیام‌رسان:</span>
                            <a href="https://rubika.ir/talalive" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white text-[10px] font-bold shadow-sm transition-all">
                                <img src="/images/logos/rubika.png" onerror="this.src='/icons/icon-72x72.png'" class="w-3.5 h-3.5 object-contain rounded-sm" alt="روبیکا">
                                <span>پشتیبانی روبیکا</span>
                            </a>
                        </div>
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
                <div class="text-[11px] text-slate-500">اتصال به مراجع معتبر و منتخب بازار طلا</div>
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

        {{-- قابلیت ویژه: پشتیبانی از نرخ ارز و تابلوی نقره و شمش --}}
        <div class="mt-8 p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-emerald-500/10 via-slate-50 dark:via-slate-900/60 to-cyan-500/10 border border-slate-200 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-right">
                <div class="flex items-center gap-2">
                    <span class="text-xl">💱</span>
                    <h3 class="text-base font-black text-slate-900 dark:text-white">
                        پوشش کامل نرخ انواع ارز، نقره و شمش در کنار طلا و سکه
                    </h3>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-2xl leading-relaxed">
                    علاوه بر طلا و مسکوکات، تابلوی طلالایو ردیف‌های دلار، یورو، درهم، تتر و نرخ‌های شمش و نقره (گرم ۹۹۹ و ۹۲۵) را با قابلیت فعال‌سازی یا مخفی‌سازی مستقل در اختیار گالری‌ها و صرافی‌ها قرار می‌دهد.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0 flex-wrap">
                <a href="/currency-exchange-board" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs transition-colors shadow-sm">
                    تابلو صرافی و نرخ ارز ←
                </a>
                <a href="/silver-bullion-board" class="px-4 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs transition-colors shadow-sm">
                    تابلو نقره و شمش ←
                </a>
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

            <div class="mt-8 text-center">
                <a href="{{ route('public.led-vs-smart-board') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-amber-500/30 bg-amber-500/10 hover:bg-amber-500/20 text-amber-700 dark:text-amber-400 font-bold text-xs sm:text-sm transition-all shadow-sm">
                    <span>مشاهده بررسی کامل و مقایسه جامع طلالایو با تابلوهای LED روان</span>
                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- بخش ۶: تعرفه‌ها و بسته‌های اشتراک (Pricing Table) --}}
    <section id="pricing" x-data="{ mobilePlan: '12m' }" class="py-16 px-4 sm:px-6 lg:px-8 border-t border-slate-200/80 dark:border-slate-800/80">
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

            {{-- ۱. نمای اختصاصی موبایل: سوئیچر کپسولی هوشمند (Mobile Segmented Switcher) --}}
            <div class="md:hidden space-y-5">
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

                    {{-- تب ۴: ۱۲ ماهه (پیشنهاد ویژه و قهرمان طلالایو - نمایش پیش‌فرض) --}}
                    <div x-show="mobilePlan === '12m'" x-transition.opacity.duration.200ms class="relative rounded-3xl p-6 border-2 border-amber-500 bg-gradient-to-b from-amber-500/15 via-amber-500/5 to-white dark:to-slate-900 shadow-2xl shadow-amber-500/20 space-y-6">
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

            {{-- ۲. نمای دسکتاپ و تبلت: گرید کامل قیمت‌گذاری (Desktop & Tablet Matrix) --}}
            <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch pt-2">
                
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
                        نرخ‌ها به صورت خودکار و لحظه‌ای از مراجع معتبر و منتخب بازار طلا و جواهر کشور، اتحادیه‌های طلا و سکه و مراجع رسمی انس جهانی دریافت می‌شوند و به صورت بلادرنگ روی تابلوی شما آپدیت می‌گردند.
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
                    نحوه محاسبه ارزش ذاتی و حباب سکه بهار آزادی، نیم سکه و ربع سکه بر مبنای انس جهانی طلا.
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
@endsection
