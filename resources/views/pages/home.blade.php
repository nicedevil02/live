@extends('layouts.public')

@section('title', 'طلالایو (طلا لایو) | سامانه ابری مدیریت تابلو و نرخ لحظه‌ای طلافروشی')
@section('meta_description', 'سامانه هوشمند و ابری طلا لایو (طلالایو): نمایش آنلاین نرخ لحظه‌ای طلا، سکه و ارز روی تلویزیون مغازه بدون مینی‌کیس در کمتر از ۳ دقیقه با تست رایگان ۱۴ روزه.')
@section('canonical', 'https://talalive.ir/')

@section('schema')
    <script type="application/ld+json">
    {!! json_encode([
      '@' . 'context' => "https://schema.org",
      "@graph" => [
        [
          "@type" => ["SoftwareApplication", "WebApplication"],
          "@id" => "https://talalive.ir/#software",
          "name" => "طلالایو (طلا لایو) - سامانه تابلوی طلافروشی و طلا فروشی",
          "alternateName" => [
            "طلا لایو",
            "طلالایو",
            "TalaLive",
            "Tala Live",
            "سامانه طلا لایو",
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
          "name" => "طلالایو (طلا لایو)",
          "alternateName" => [
            "طلا لایو",
            "طلالایو",
            "Tala Live",
            "TalaLive",
            "سامانه طلا لایو"
          ],
          "url" => "https://talalive.ir",
          "logo" => "https://talalive.ir/images/logo.png",
          "sameAs" => [
            "https://rubika.ir/talalive"
          ],
          "address" => [
            "@type" => "PostalAddress",
            "addressLocality" => "کبودرآهنگ",
            "addressRegion" => "همدان",
            "streetAddress" => "خیابان مطهری، پاساژ علاءالدین",
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
              "telephone" => "+988135229063",
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
              "name" => "سامانه طلا لایو (طلالایو) چیست و چه کاربردی برای مغازه طلافروشی دارد؟",
              "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "سامانه طلا لایو (طلالایو - TalaLive) پلتفرم ابری هوشمند مدیریت و نمایش آنلاین نرخ لحظه‌ای طلا، سکه و ارز ویژه تلویزیون‌های مغازه طلافروشی است که بدون نیاز به خرید مینی‌کیس، کامپیوتر یا دانگل واسط، تابلوی نرخ رسمی، فرمول‌ساز سود قانونی و ویترین دیجیتال گالری را فعال می‌کند."
              ]
            ],
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
    {{-- کانتینر پویا جهت نمایش اعلان دستگاه متصل / تایمر انتقال هوشمند تلویزیون --}}
    <div id="paired-device-root" class="relative z-50"></div>

    {{-- مدیریت هوشمند اتصال تلویزیون و تابلوی جفت‌شده --}}
    <script>
        (function() {
            try {
                const urlParams = new URLSearchParams(window.location.search);
                const isReset = urlParams.get('reset') === '1' || urlParams.get('disconnect') === '1';
                const isHomeParam = urlParams.get('home') === '1' || urlParams.get('skip_redirect') === '1';

                if (isReset) {
                    localStorage.removeItem('display_username');
                    localStorage.removeItem('display_token');
                    document.cookie = "display_token=; path=/; max-age=0;";
                    try { sessionStorage.removeItem('skip_redirect'); } catch(e) {}
                    return;
                }

                if (isHomeParam) {
                    try { sessionStorage.setItem('skip_redirect', '1'); } catch(e) {}
                }

                const savedUsername = localStorage.getItem('display_username');
                const savedToken = localStorage.getItem('display_token');
                const isTv = /SmartTV|Tizen|Web0S|NetCast|HbbTV|CrKey|Android TV|BRAVIA|Hisense/i.test(navigator.userAgent);
                const skipRedirect = (function() {
                    try { return sessionStorage.getItem('skip_redirect') === '1'; } catch(e) { return false; }
                })();

                if (!savedUsername || !savedToken) {
                    if (isTv && window.location.pathname === '/' && !isHomeParam && !skipRedirect) {
                        window.location.href = '/tv';
                    }
                    return;
                }

                const targetBoardUrl = '/' + encodeURIComponent(savedUsername) + '?key=' + encodeURIComponent(savedToken);
                const safeShopName = savedUsername.replace(/</g, '&lt;').replace(/>/g, '&gt;');

                // ۱. سناریوی تلویزیون: شمارش معکوس ۳ ثانیه‌ای با امکان انصراف
                if (isTv && !skipRedirect && !isHomeParam) {
                    let secondsLeft = 3;
                    let countdownTimer = null;

                    const mountTvCountdown = function() {
                        const root = document.getElementById('paired-device-root');
                        if (!root) return;

                        root.innerHTML = `
                            <div id="tv-countdown-banner" class="fixed top-4 inset-x-3 sm:inset-x-auto sm:left-1/2 sm:-translate-x-1/2 z-[100] max-w-2xl w-full mx-auto p-4 sm:p-5 rounded-2xl bg-stone-900 text-stone-50 border border-amber-500/40 shadow-xl font-sans" dir="rtl">
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center text-amber-400 shrink-0">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="13" rx="2"/><path d="M8 21h8"/><path d="M12 17v4"/></svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm text-amber-300 flex items-center gap-2">
                                                <span>انتقال خودکار به تابلوی طلای ${safeShopName}</span>
                                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                            </div>
                                            <p class="text-xs text-stone-300 mt-0.5">
                                                تا <span id="tv-countdown-num" class="font-bold text-amber-400 font-mono text-sm px-1.5 py-0.5 rounded bg-stone-800 border border-stone-700 tabular-nums">${secondsLeft}</span> ثانیه دیگر به تابلوی زنده هدایت می‌شوید...
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 w-full sm:w-auto shrink-0 justify-end">
                                        <button type="button" id="tv-cancel-redirect-btn" class="min-h-11 px-4 py-2 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-200 text-xs font-semibold border border-stone-700 transition-colors cursor-pointer">
                                            انصراف و مشاهده سایت
                                        </button>
                                        <a href="${targetBoardUrl}" class="min-h-11 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 text-xs font-bold transition-colors inline-flex items-center gap-1.5">
                                            <span>ورود فوری</span>
                                            <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;

                        const cancelBtn = document.getElementById('tv-cancel-redirect-btn');
                        if (cancelBtn) {
                            cancelBtn.focus();
                            cancelBtn.addEventListener('click', function() {
                                if (countdownTimer) clearInterval(countdownTimer);
                                try { sessionStorage.setItem('skip_redirect', '1'); } catch(e) {}
                                const banner = document.getElementById('tv-countdown-banner');
                                if (banner) {
                                    banner.style.transition = 'opacity 0.2s, transform 0.2s';
                                    banner.style.opacity = '0';
                                    banner.style.transform = 'translateY(-10px)';
                                    setTimeout(() => banner.remove(), 200);
                                }
                                mountDesktopPill();
                            });
                        }

                        countdownTimer = setInterval(function() {
                            secondsLeft--;
                            const numElem = document.getElementById('tv-countdown-num');
                            if (numElem) numElem.textContent = secondsLeft;
                            if (secondsLeft <= 0) {
                                clearInterval(countdownTimer);
                                window.location.href = targetBoardUrl;
                            }
                        }, 1000);
                    };

                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', mountTvCountdown);
                    } else {
                        mountTvCountdown();
                    }
                    return;
                }

                // ۲. سناریوی دستگاه متصل: نمایش نوار شیک و تمیز بالای صفحه
                const mountDesktopPill = function() {
                    const root = document.getElementById('paired-device-root');
                    if (!root) return;

                    root.innerHTML = `
                        <div id="paired-quick-bar" class="relative z-40 bg-stone-100 dark:bg-stone-900 border-b border-amber-500/30 text-stone-900 dark:text-stone-100 px-4 py-2.5 transition-colors" dir="rtl">
                            <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3 text-xs">
                                <div class="flex items-center gap-2.5 font-semibold">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                                    <span>دستگاه به تابلوی طلا متصل است:</span>
                                    <span class="px-2.5 py-0.5 rounded-md bg-amber-50 dark:bg-amber-500/10 text-amber-800 dark:text-amber-300 font-bold border border-amber-200 dark:border-amber-500/30 font-mono">${safeShopName}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="${targetBoardUrl}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold shadow-xs transition-colors">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="4" width="20" height="13" rx="2"/><path d="M8 21h8"/><path d="M12 17v4"/></svg>
                                        <span>ورود به تابلوی فعال</span>
                                    </a>
                                    <button type="button" id="paired-disconnect-btn" class="px-3 py-1.5 rounded-lg bg-white dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-700 dark:text-stone-300 font-semibold transition-colors border border-stone-300 dark:border-stone-700 cursor-pointer" title="قطع اتصال این دستگاه">
                                        قطع اتصال
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;

                    const disBtn = document.getElementById('paired-disconnect-btn');
                    if (disBtn) {
                        disBtn.addEventListener('click', function() {
                            if (confirm('آیا می‌خواهید اتصال این دستگاه به تابلوی طلا قطع شود؟')) {
                                localStorage.removeItem('display_username');
                                localStorage.removeItem('display_token');
                                document.cookie = "display_token=; path=/; max-age=0;";
                                try { sessionStorage.removeItem('skip_redirect'); } catch(e) {}
                                const bar = document.getElementById('paired-quick-bar');
                                if (bar) bar.remove();
                            }
                        });
                    }
                };

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', mountDesktopPill);
                } else {
                    mountDesktopPill();
                }

            } catch (err) {
                console.warn('Paired device handler error:', err);
            }
        })();
    </script>

    {{-- بخش ۱: هیرو سکشن لندینگ تجاری طلالایو با متریال شیشه‌ای اپل و ویترین سخت‌افزاری --}}
    <section class="relative min-h-[calc(100vh-116px)] flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-8 lg:py-14 overflow-hidden">
        {{-- هاله نوری استودیویی ۱۸ عیار پس‌زمینه جهت شکست نور طبیعی در شیشه اپل --}}
        <div class="tl-ambient-gold absolute top-8 right-1/4 w-[26rem] h-[20rem] rounded-full opacity-65" aria-hidden="true"></div>

        <div class="w-full max-w-7xl mx-auto flex flex-col z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center w-full">
                
                {{-- ستون سمت راست: ارزش محصول، تیتر و پنل شیشه‌ای تبدیل یکپارچه (۷ ستون) --}}
                <div class="lg:col-span-7 text-right space-y-6 w-full">
                    
                    {{-- برچسب شیشه‌ای دسته‌بندی محصول --}}
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full tl-glass-badge text-amber-900 dark:text-amber-300 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>سامانه ابری نمایش نرخ لحظه‌ای و ویترین طلا</span>
                    </div>

                    {{-- تیتر اصلی و توضیح صنفی --}}
                    <div class="space-y-4">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-stone-900 dark:text-stone-50 leading-tight tracking-tight">
                            <span class="block text-base sm:text-xl lg:text-2xl text-amber-700 dark:text-amber-400 font-semibold mb-2 leading-snug">
                                سامانه هوشمند طلالایو (طلا لایو)
                            </span>
                            مدیریت ابری تابلو و نرخ لحظه‌ای <br>
                            <span class="text-stone-900 dark:text-stone-50">
                                روی تلویزیون مغازه طلافروشی
                            </span>
                        </h1>
                        <p class="text-stone-700 dark:text-stone-300 text-sm sm:text-base lg:text-lg leading-relaxed max-w-2xl">
                            جایگزین مدرن و اقتصادی تابلوهای سنتی روان LED. با سامانه طلالایو بدون نیاز به مینی‌کیس، کامپیوتر یا کابل‌کشی؛ تابلوی اختصاصی نرخ لحظه‌ای طلا، سکه و ویترین دیجیتال جواهرات خود را تنها در چند ثانیه با ریموت تلویزیون مغازه روشن کنید.
                        </p>
                    </div>

                    {{-- دک شیشه‌ای تبدیل و ثبت‌نام سریع (Apple Liquid Glass Deck + Neumorphic Inset Well) --}}
                    <div class="tl-glass-deck rounded-3xl p-5 sm:p-7 space-y-4">
                        <div class="flex items-center justify-between flex-wrap gap-2">
                            <div class="flex items-center gap-2.5">
                                <span class="tl-neu-icon-orb w-9 h-9 rounded-xl flex items-center justify-center shrink-0">
                                    @include('partials.ui-icon', ['name' => 'gift', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                                </span>
                                <span class="text-xs sm:text-sm font-bold text-stone-900 dark:text-stone-100">
                                    شروع تست رایگان ۱۴ روزه طلالایو (ویژه طلافروشان)
                                </span>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-xl tl-neu-inset text-stone-700 dark:text-stone-300">
                                بدون نیاز به کارت بانکی یا پیش‌پرداخت
                            </span>
                        </div>

                        {{-- فرم ورود شماره همراه با شیار حکاکی‌شده نئومورفیک --}}
                        <form action="{{ route('admin.register') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full">
                            <div class="relative flex-1 w-full" dir="ltr">
                                <label for="heroPhoneInput" class="sr-only">شماره موبایل طلافروش</label>
                                <input id="heroPhoneInput" type="tel" name="phone" maxlength="11" placeholder="شماره موبایل: 09xxxxxxxxx" required
                                       class="w-full min-h-12 tl-neu-inset rounded-xl px-4 py-2.5 text-base text-center font-mono font-bold tracking-wider text-stone-900 dark:text-stone-50 placeholder:font-sans placeholder:text-xs placeholder:text-stone-500 dark:placeholder:text-stone-400 focus:outline-none">
                            </div>
                            <button type="submit" 
                                    class="w-full sm:w-auto min-h-12 px-7 py-2.5 rounded-xl tl-btn-bullion font-bold text-sm flex items-center justify-center gap-2 cursor-pointer shrink-0">
                                <span>دریافت کد و شروع رایگان</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
                            </button>
                        </form>

                        {{-- نوار هدایت به دموی زنده و اتصال تلویزیون --}}
                        <div class="pt-3.5 border-t border-stone-300/60 dark:border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2 text-stone-700 dark:text-stone-300 font-medium">
                                @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                                <span>می‌خواهید تابلوی زنده را بدون ثبت‌نام مشاهده کنید؟</span>
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <a href="{{ url('/demo') }}" class="min-h-11 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 font-semibold shrink-0">
                                    <span>مشاهده دموی زنده تابلو (/demo)</span>
                                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                                </a>
                                <a href="{{ route('display.tv') }}" class="min-h-11 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl tl-neu-btn text-stone-800 dark:text-stone-200 hover:text-amber-800 dark:hover:text-amber-300 font-semibold shrink-0">
                                    <span>اتصال تلویزیون (/tv)</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- نوار شاخص‌های اعتماد صنفی نئومورفیک --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1 text-xs text-stone-800 dark:text-stone-200 font-semibold">
                        <div class="flex items-center gap-2.5 tl-neu-card px-3.5 py-2.5 rounded-2xl">
                            @include('partials.ui-icon', ['name' => 'bolt', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                            <span class="truncate">راه‌اندازی در کمتر از ۳ دقیقه</span>
                        </div>
                        <div class="flex items-center gap-2.5 tl-neu-card px-3.5 py-2.5 rounded-2xl">
                            @include('partials.ui-icon', ['name' => 'shield', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                            <span class="truncate">پایداری کامل در حالت آفلاین</span>
                        </div>
                        <div class="flex items-center gap-2.5 tl-neu-card px-3.5 py-2.5 rounded-2xl">
                            @include('partials.ui-icon', ['name' => 'sliders', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                            <span class="truncate">فرمول سود و اجرت دلخواه</span>
                        </div>
                    </div>
                </div>

                {{-- ستون سمت چپ: شاسی تیتانیومی تلویزیون هوشمند با نور مخفی استودیویی ۱۸ عیار (۵ ستون) --}}
                <div class="lg:col-span-5 flex flex-col gap-4 w-full max-w-[460px] mx-auto lg:mr-auto lg:ml-0" style="max-width: 460px; width: 100%;">
                    <div class="relative w-full">
                        {{-- نور مخفی طلایی پشت تلویزیون (Studio Bias Backlight) --}}
                        <div class="tl-ambient-gold absolute -inset-5 rounded-[40px]" aria-hidden="true"></div>

                        {{-- قاب تیتانیومی برس‌خورده تلویزیون هوشمند --}}
                        <div class="relative rounded-[26px] p-2.5 sm:p-3 tl-tv-titanium">
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
                                <div class="relative rounded-2xl bg-stone-950 overflow-hidden border border-white/10 aspect-[16/10] flex items-center justify-center select-none">
                                    <div class="tl-screen-glare absolute inset-0 z-10" aria-hidden="true"></div>
                                    <img src="{{ asset($previewImage) }}" 
                                         alt="اسکرین‌شات تابلوی هوشمند نرخ لحظه‌ای طلا و سکه طلالایو روی تلویزیون مغازه" 
                                         width="1600" height="1000"
                                         loading="eager" fetchpriority="high" decoding="async"
                                         class="w-full h-full object-cover object-center">
                                </div>
                            @else
                                <div class="relative rounded-2xl bg-stone-950 overflow-hidden border border-white/10 text-stone-50 aspect-[16/10] flex flex-col justify-between p-3 sm:p-4 select-none">
                                    <div class="tl-screen-glare absolute inset-0 z-10" aria-hidden="true"></div>
                                    {{-- هدر تابلوی تلویزیون --}}
                                    <div class="relative z-20 flex items-center justify-between border-b border-stone-800 pb-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-amber-500 text-stone-950 font-bold text-xs flex items-center justify-center">
                                                زر
                                            </div>
                                            <div class="text-right">
                                                <div class="font-bold text-xs text-amber-300">گالری طلا و جواهر زرین</div>
                                                <div class="text-[9px] text-stone-400">تابلوی رسمی نرخ لحظه‌ای و مسکوکات</div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <div class="flex items-center gap-1.5 bg-stone-900 border border-emerald-500/30 px-2 py-0.5 rounded-full text-emerald-400 text-[10px] font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                                <span>نرخ زنده</span>
                                            </div>
                                            <div class="text-left font-mono text-xs text-amber-400 font-bold tabular-nums" dir="ltr">
                                                {{ date('H:i') }}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ۴ کارت نرخ در صفحه نمایشگر --}}
                                    <div class="relative z-20 grid grid-cols-2 gap-2 my-auto">
                                        <div class="bg-stone-900/95 border border-amber-500/40 rounded-xl p-2 text-right space-y-0.5">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[10px] text-amber-300 font-semibold">طلای ۱۸ عیار (گرم)</span>
                                                <span class="text-[8px] px-1 rounded bg-amber-500/20 text-amber-300 font-semibold">شاخص</span>
                                            </div>
                                            <div class="text-sm sm:text-base font-bold text-amber-400 font-mono tracking-wider tabular-nums" dir="ltr">
                                                {{ !empty($rates['gold18']) && $rates['gold18'] > 0 ? number_format($rates['gold18']) : '۴,۶۵۰,۰۰۰' }}
                                            </div>
                                            <div class="text-[9px] text-stone-400 flex items-center justify-between">
                                                <span>تومان</span>
                                                <span class="font-mono text-[8px] text-stone-400">۱۸K</span>
                                            </div>
                                        </div>

                                        <div class="bg-stone-900/95 border border-stone-800 rounded-xl p-2 text-right space-y-0.5">
                                            <div class="text-[10px] text-stone-300 font-semibold">سکه بهار آزادی (امامی)</div>
                                            <div class="text-sm sm:text-base font-bold text-stone-100 font-mono tracking-wider tabular-nums" dir="ltr">
                                                {{ !empty($rates['coin_emami']) && $rates['coin_emami'] > 0 ? number_format($rates['coin_emami']) : '۵۲,۸۰۰,۰۰۰' }}
                                            </div>
                                            <div class="text-[9px] text-stone-400">تومان</div>
                                        </div>

                                        <div class="bg-stone-900/95 border border-stone-800 rounded-xl p-2 text-right space-y-0.5">
                                            <div class="text-[10px] text-stone-300 font-semibold">نیم سکه بهار آزادی</div>
                                            <div class="text-xs sm:text-sm font-bold text-stone-100 font-mono tracking-wider tabular-nums" dir="ltr">
                                                {{ !empty($rates['coin_nim']) && $rates['coin_nim'] > 0 ? number_format($rates['coin_nim']) : '۲۸,۴۰۰,۰۰۰' }}
                                            </div>
                                            <div class="text-[9px] text-stone-400">تومان</div>
                                        </div>

                                        <div class="bg-stone-900/95 border border-stone-800 rounded-xl p-2 text-right space-y-0.5">
                                            <div class="text-[10px] text-stone-300 font-semibold">انس جهانی طلا</div>
                                            <div class="text-xs sm:text-sm font-bold text-stone-100 font-mono tracking-wider tabular-nums" dir="ltr">
                                                {{ !empty($rates['ons']) && $rates['ons'] > 0 ? '$ ' . number_format($rates['ons'], 1) : '$ ۲,۷۳۵.۵' }}
                                            </div>
                                            <div class="text-[9px] text-stone-400">دلار</div>
                                        </div>
                                    </div>

                                    {{-- نوار متحرک ویترین در زیر صفحه --}}
                                    <div class="relative z-20 border-t border-stone-800 pt-1.5 flex items-center justify-between text-[9px] text-stone-400">
                                        <span class="truncate text-stone-300">جدیدترین کالکشن النگو و سرویس‌های طلا</span>
                                        <span class="font-mono text-amber-400 shrink-0 font-semibold">TalaLive.ir</span>
                                    </div>
                                </div>
                            @endif

                            {{-- نشانگر استندبای تلویزیون --}}
                            <div class="flex items-center justify-center gap-1.5 mt-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.75)]"></span>
                                <span class="text-[9px] font-mono text-stone-300 tracking-widest">OLED 4K STUDIO DISPLAY</span>
                            </div>
                        </div>
                    </div>

                    {{-- برچسب سازگاری تلویزیون --}}
                    <div class="text-center space-y-1 relative z-10">
                        <p class="text-xs font-semibold text-stone-800 dark:text-stone-200">
                            سازگار با انواع تلویزیون هوشمند
                        </p>
                        <p class="text-[11px] text-stone-600 dark:text-stone-400">
                            سامسونگ، ال‌جی، سونی، اسنوا، دوو، شیائومی و انواع اندروید باکس
                        </p>
                    </div>

                    {{-- کادر شیشه‌ای ارتباط با پشتیبانی فنی --}}
                    <div class="relative z-10 w-full tl-glass-deck rounded-2xl p-4 text-center text-xs space-y-2">
                        <p class="text-stone-700 dark:text-stone-300 font-semibold text-[11px]">پشتیبانی و راه‌اندازی فوری تابلوی طلافروشی:</p>
                        <p class="text-amber-800 dark:text-amber-400 font-bold text-sm tracking-wider font-mono tabular-nums" dir="ltr">
                            <a href="tel:09187009064" class="hover:underline">0918 700 9064</a>
                            &nbsp;&middot;&nbsp;
                            <a href="tel:08135229063" class="hover:underline">081 3522 9063</a>
                        </p>
                        <div class="pt-1 flex items-center justify-center gap-2 flex-wrap">
                            <span class="text-stone-700 dark:text-stone-300 font-semibold text-[11px]">پشتیبانی در تلگرام، روبیکا و بله:</span>
                            @include('partials.messenger-links')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- بخش ۲: نوار شاخص‌های ارزش و اعتماد نئومورفیک با انیمیشن اسکرول --}}
    <section class="py-8 px-4 sm:px-6 lg:px-8 tl-reveal">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 text-center">
            <div class="tl-neu-card rounded-2xl p-5 space-y-1">
                <div class="text-2xl lg:text-3xl font-bold text-amber-700 dark:text-amber-400 font-mono tabular-nums">۰ تومان</div>
                <div class="text-xs font-semibold text-stone-900 dark:text-stone-100">هزینه سخت‌افزار یا مینی‌کیس</div>
                <div class="text-[11px] text-stone-600 dark:text-stone-400">راه‌اندازی با مرورگر انواع تلویزیون</div>
            </div>
            <div class="tl-neu-card rounded-2xl p-5 space-y-1">
                <div class="text-2xl lg:text-3xl font-bold text-amber-700 dark:text-amber-400 font-mono tabular-nums">۶۰ ثانیه</div>
                <div class="text-xs font-semibold text-stone-900 dark:text-stone-100">سرعت نصب و راه‌اندازی</div>
                <div class="text-[11px] text-stone-600 dark:text-stone-400">فقط با یکبار اسکن بارکد QR</div>
            </div>
            <div class="tl-neu-card rounded-2xl p-5 space-y-1">
                <div class="text-2xl lg:text-3xl font-bold text-amber-700 dark:text-amber-400 font-mono tabular-nums">۱۰۰٪</div>
                <div class="text-xs font-semibold text-stone-900 dark:text-stone-100">تاب‌آوری آفلاین هوشمند</div>
                <div class="text-[11px] text-stone-600 dark:text-stone-400">حفظ نمایش تابلو در قطعی موقت اینترنت</div>
            </div>
            <div class="tl-neu-card rounded-2xl p-5 space-y-1">
                <div class="text-2xl lg:text-3xl font-bold text-amber-700 dark:text-amber-400 font-mono">لحظه‌ای</div>
                <div class="text-xs font-semibold text-stone-900 dark:text-stone-100">بروزرسانی خودکار نرخ‌ها</div>
                <div class="text-[11px] text-stone-600 dark:text-stone-400">اتصال به مراجع معتبر بازار طلا</div>
            </div>
        </div>
    </section>

    {{-- بخش ۳: آموزش سریع پیدا کردن مرورگر تلویزیون با انیمیشن اسکرول --}}
    <section class="py-14 px-4 sm:px-6 lg:px-8 border-b border-stone-300/60 dark:border-white/10 tl-reveal">
        <div class="max-w-6xl mx-auto space-y-10">
            <div class="text-center space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full tl-glass-badge text-amber-900 dark:text-amber-300 text-xs font-semibold">
                    @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                    <span>راهنمای سریع ریموت کنترل تلویزیون</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-stone-900 dark:text-stone-50">
                    مرورگر اینترنت تلویزیون مغازه کجاست؟
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 max-w-2xl mx-auto leading-relaxed">
                    برای باز کردن تابلوی طلالایو، کافیست با کنترل تلویزیون خود وارد برنامه مرورگر اینترنت شوید و آدرس <span class="font-mono font-bold text-amber-700 dark:text-amber-400">talalive.ir/tv</span> را وارد نمایید. روی برند تلویزیون مغازه کلیک کنید:
                </p>
            </div>

            {{-- کارت‌های پیونددار برندهای تلویزیون --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- سامسونگ --}}
                <a href="{{ route('public.guides.show', 'samsung-tizen-gold-board') }}" class="tl-neu-card-interactive rounded-2xl p-5 space-y-3 block group">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-bold text-stone-900 dark:text-stone-100 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors">سامسونگ (Samsung)</span>
                        <span class="text-[10px] px-2.5 py-0.5 rounded-lg tl-neu-inset text-stone-700 dark:text-stone-300 font-mono">Tizen</span>
                    </div>
                    <p class="text-xs text-stone-600 dark:text-stone-300 leading-relaxed">
                        دکمه Home روی ریموت را بزنید و برنامه Internet را باز کنید.
                    </p>
                    <div class="pt-2 text-xs font-semibold text-amber-700 dark:text-amber-400 flex items-center gap-1">
                        <span>راهنمای راه‌اندازی سامسونگ</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </div>
                </a>

                {{-- ال‌جی --}}
                <a href="{{ route('public.guides.show', 'lg-webos-gold-board') }}" class="tl-neu-card-interactive rounded-2xl p-5 space-y-3 block group">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-bold text-stone-900 dark:text-stone-100 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors">ال‌جی (LG)</span>
                        <span class="text-[10px] px-2.5 py-0.5 rounded-lg tl-neu-inset text-stone-700 dark:text-stone-300 font-mono">webOS</span>
                    </div>
                    <p class="text-xs text-stone-600 dark:text-stone-300 leading-relaxed">
                        دکمه Home کنترل جادویی را بزنید و برنامه Web Browser را باز کنید.
                    </p>
                    <div class="pt-2 text-xs font-semibold text-amber-700 dark:text-amber-400 flex items-center gap-1">
                        <span>راهنمای راه‌اندازی ال‌جی</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </div>
                </a>

                {{-- اندروید تی‌وی و سونی --}}
                <a href="{{ route('public.android-tv-gold-board') }}" class="tl-neu-card-interactive rounded-2xl p-5 space-y-3 block group">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-bold text-stone-900 dark:text-stone-100 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors">سونی، اسنوا، دوو، شیائومی</span>
                        <span class="text-[10px] px-2.5 py-0.5 rounded-lg tl-neu-inset text-stone-700 dark:text-stone-300 font-mono">Android TV</span>
                    </div>
                    <p class="text-xs text-stone-600 dark:text-stone-300 leading-relaxed">
                        در منوی برنامه‌ها، مرورگر Chrome یا Browser اختصاصی را باز کنید.
                    </p>
                    <div class="pt-2 text-xs font-semibold text-amber-700 dark:text-amber-400 flex items-center gap-1">
                        <span>راهنمای اندروید تی‌وی</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </div>
                </a>

                {{-- راهنمای عمومی اتصال --}}
                <a href="{{ route('public.tv-setup-guide') }}" class="tl-neu-card-interactive rounded-2xl p-5 space-y-3 block group">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-bold text-stone-900 dark:text-stone-100 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors">انواع تلویزیون و اندروید باکس</span>
                        <span class="text-[10px] px-2.5 py-0.5 rounded-lg tl-neu-inset text-stone-700 dark:text-stone-300 font-mono">HDMI / باکس</span>
                    </div>
                    <p class="text-xs text-stone-600 dark:text-stone-300 leading-relaxed">
                        با اتصال اندروید باکس یا باز کردن مرورگر، هر تلویزیونی آماده پخش است.
                    </p>
                    <div class="pt-2 text-xs font-semibold text-amber-700 dark:text-amber-400 flex items-center gap-1">
                        <span>آموزش گام‌به‌گام اتصال</span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </div>
                </a>
            </div>

            {{-- بنر پشتیبانی و راهنمایی تلفنی با کارت طلایی نئومورفیک --}}
            <div class="rounded-3xl p-6 sm:p-8 tl-neu-card-gold flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-right">
                    <div class="flex items-center gap-2.5">
                        <span class="tl-neu-icon-orb w-10 h-10 rounded-xl flex items-center justify-center shrink-0">
                            @include('partials.ui-icon', ['name' => 'phone', 'class' => 'w-5 h-5 text-amber-700 dark:text-amber-400'])
                        </span>
                        <h3 class="text-sm sm:text-base font-bold text-stone-900 dark:text-stone-50">
                            به راهنمایی برای تنظیم تلویزیون نیاز دارید؟
                        </h3>
                    </div>
                    <p class="text-xs text-stone-700 dark:text-stone-300 max-w-2xl leading-relaxed">
                        کارشناسان پشتیبانی فنی طلالایو در تمام ساعات کاری پشت خط هستند تا به صورت تلفنی در کمتر از ۳ دقیقه تلویزیون گالری شما را به تابلوی زنده متصل کنند.
                    </p>
                </div>

                <div class="flex items-center gap-3 shrink-0 flex-wrap justify-center">
                    <a href="tel:09187009064" class="min-h-11 px-5 py-2.5 rounded-xl tl-btn-bullion font-bold text-xs flex items-center gap-2 cursor-pointer">
                        <span>تماس مستقیم با پشتیبانی:</span>
                        <span class="font-mono text-sm tabular-nums" dir="ltr">0918 700 9064</span>
                    </a>
                    <a href="https://t.me/talalive" target="_blank" rel="noopener noreferrer" class="min-h-11 px-4 py-2.5 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 font-semibold text-xs flex items-center gap-2 cursor-pointer">
                        @include('partials.ui-icon', ['name' => 'send', 'class' => 'w-4 h-4 shrink-0'])
                        <span>پشتیبانی در تلگرام</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- بخش ۴: امکانات و ویژگی‌های تخصصی طلالایو با کارت‌ها و گوی‌های نئومورفیک --}}
    <section id="features" class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto tl-reveal">
        <div class="text-center space-y-3 mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full tl-glass-badge text-amber-900 dark:text-amber-300 text-xs font-semibold">
                @include('partials.ui-icon', ['name' => 'gem', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                <span>مزایای فنی تابلوی هوشمند طلالایو</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-stone-900 dark:text-stone-50 tracking-tight">
                چرا طلالایو انتخاب اول طلافروشان کشور است؟
            </h2>
            <p class="text-stone-600 dark:text-stone-400 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
                ترکیب فناوری پایدار ابری، طراحی تمیز و اصیل ویترین طلا و حذف هزینه‌های سنگین کابل‌کشی و تعمیرات سخت‌افزاری.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            <div class="tl-neu-card rounded-3xl p-6 sm:p-7 space-y-4">
                <div class="w-12 h-12 rounded-2xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'bolt', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اتصال فوری بدون کیس و سیم‌کشی</h3>
                <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                    دیگر نیازی به خرید مینی‌کیس، فن‌های پرسروصدا یا سیم‌کشی‌های نامناسب در دکور مغازه نیست. تلویزیون هوشمند مغازه به تنهایی کافی است.
                </p>
            </div>

            <div class="tl-neu-card rounded-3xl p-6 sm:p-7 space-y-4">
                <div class="w-12 h-12 rounded-2xl tl-neu-icon-orb text-emerald-700 dark:text-emerald-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'shield', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">فناوری ضد قطعی اینترنت (آفلاین)</h3>
                <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                    در صورت قطعی مقطعی اینترنت، صفحه تلویزیون متوقف نمی‌شود؛ آخرین نرخ‌های دریافتی معتبر همراه با اسلایدشوی ویترین به نمایش پایدار ادامه می‌دهند.
                </p>
            </div>

            <div class="tl-neu-card rounded-3xl p-6 sm:p-7 space-y-4">
                <div class="w-12 h-12 rounded-2xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'sliders', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">فرمول‌ساز سود و اجرت شخصی</h3>
                <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed">
                    در پنل مدیریت موبایل، درصد سود فروش، حاشیه خرید، مالیات و تخفیف‌ها را به ازای هر گرم طلا یا نوع سکه مطابق سیاست گالری خود تنظیم فرمایید.
                </p>
            </div>
        </div>

        {{-- پنل پشتیبانی از نرخ تتر، نفت برنت، شمش و نقره --}}
        <div class="mt-8 p-6 sm:p-8 rounded-3xl tl-neu-card flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-right">
                <div class="flex items-center gap-2.5">
                    <span class="tl-neu-icon-orb w-10 h-10 rounded-xl flex items-center justify-center shrink-0">
                        @include('partials.ui-icon', ['name' => 'bolt', 'class' => 'w-5 h-5 text-amber-700 dark:text-amber-400'])
                    </span>
                    <h3 class="text-base font-bold text-stone-900 dark:text-stone-50">
                        پوشش نرخ تتر دیجیتال، نفت برنت، نقره و بازارهای جهانی در کنار طلا و سکه
                    </h3>
                </div>
                <p class="text-xs sm:text-sm text-stone-700 dark:text-stone-300 max-w-2xl leading-relaxed">
                    علاوه بر طلا و مسکوکات، تابلوی طلالایو ردیف‌های تتر (ارز دیجیتال)، نفت برنت، انس جهانی نقره، مظنه جهانی طلا و نرخ‌های شمش و نقره (گرم ۹۹۹ و ۹۲۵) را با قابلیت فعال‌سازی یا مخفی‌سازی مستقل در اختیار گالری‌ها قرار می‌دهد.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0 flex-wrap">
                <a href="/silver-bullion-board" class="min-h-11 px-4 py-2.5 rounded-xl tl-neu-btn text-stone-800 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 font-semibold text-xs inline-flex items-center gap-1.5">
                    <span>تابلو نقره و شمش</span>
                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                </a>
            </div>
        </div>
    </section>

    {{-- بخش ۵: مقایسه جامع تابلوی هوشمند با تابلوهای سنتی روان LED --}}
    <section id="comparison" class="py-16 px-4 sm:px-6 lg:px-8 border-y border-stone-300/60 dark:border-white/10 tl-reveal">
        <div class="max-w-5xl mx-auto space-y-10">
            <div class="text-center space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full tl-glass-badge text-amber-900 dark:text-amber-300 text-xs font-semibold">
                    <span>مقایسه فناوری و هزینه</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-stone-900 dark:text-stone-50">
                    مقایسه تابلوی هوشمند طلالایو با تابلوهای سنتی روان LED
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 max-w-xl mx-auto">
                    چرا دوره تابلوهای LED تک‌رنگ و هزینه‌بر به پایان رسیده است؟
                </p>
            </div>

            {{-- کانتینر اسکرول استاندارد موبایل برای جدول با سطح نئومورفیک --}}
            <div class="overflow-x-auto rounded-3xl tl-neu-card">
                <table class="w-full text-right text-xs sm:text-sm">
                    <thead class="bg-stone-200/55 dark:bg-white/[0.04] border-b border-stone-300/60 dark:border-white/10 text-stone-900 dark:text-stone-50 font-bold">
                        <tr>
                            <th class="p-4 sm:p-5">ویژگی و امکانات</th>
                            <th class="p-4 sm:p-5 text-amber-700 dark:text-amber-400">سامانه ابری طلالایو (تلویزیون هوشمند)</th>
                            <th class="p-4 sm:p-5 text-stone-500">تابلوهای سنتی روان LED</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-300/50 dark:divide-white/10 text-stone-700 dark:text-stone-300">
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">کیفیت و جذابیت بصری</td>
                            <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-semibold">وضوح بالا با کیفیت 4K و خوانایی عالی در ویترین</td>
                            <td class="p-4 sm:p-5 text-stone-500">پیکسل‌های درشت و ظاهر قدیمی</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">پخش اسلایدشو و ویترین جواهرات</td>
                            <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-semibold">پخش تصاویر باکیفیت و QR اختصاصی گالری</td>
                            <td class="p-4 sm:p-5 text-stone-500">غیرممکن (فقط متن ساده تک‌رنگ)</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">بروزرسانی خودکار نرخ‌ها</td>
                            <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-semibold">خودکار و بلادرنگ بدون دخالت دست</td>
                            <td class="p-4 sm:p-5 text-stone-500">نیاز به وارد کردن دستی قیمت با کیبورد یا فلش</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">هزینه اولیه سخت‌افزار</td>
                            <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-semibold">۰ تومان (استفاده از تلویزیون موجود مغازه)</td>
                            <td class="p-4 sm:p-5 text-stone-500">هزینه سنگین خرید ماژول LED و قاب اختصاصی</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-stone-900 dark:text-stone-100">هزینه تعمیر و نگهداری</td>
                            <td class="p-4 sm:p-5 text-emerald-700 dark:text-emerald-400 font-semibold">صفر؛ بروزرسانی ابری خودکار</td>
                            <td class="p-4 sm:p-5 text-stone-500">سوختن مداوم پاور، ماژول و لامپ‌های LED</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('public.led-vs-smart-board') }}" class="min-h-11 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl tl-neu-btn text-stone-800 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 font-semibold text-xs sm:text-sm">
                    <span>مشاهده بررسی کامل و مقایسه جامع طلالایو با تابلوهای LED روان</span>
                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
                </a>
            </div>
        </div>
    </section>

    {{-- بخش ۶: تعرفه‌ها و بسته‌های اشتراک با سگمنت اپل و کارت‌های نئومورفیک (Pricing Table) --}}
    <section id="pricing" x-data="{ mobilePlan: '12m' }" class="py-16 px-4 sm:px-6 lg:px-8 tl-reveal">
        <div class="max-w-6xl mx-auto space-y-12">
            
            <div class="text-center space-y-3 max-w-2xl mx-auto">
                <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full tl-glass-badge text-amber-900 dark:text-amber-300 text-xs font-semibold">
                    @include('partials.ui-icon', ['name' => 'receipt', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                    <span>تعرفه‌های شفاف و بدون هزینه پنهان</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-stone-900 dark:text-stone-50 tracking-tight">
                    پلن‌های اشتراک تابلوی هوشمند طلافروشی طلالایو
                </h2>
                <p class="text-stone-600 dark:text-stone-400 text-xs sm:text-sm leading-relaxed px-2">
                    اتصال آنی به درگاه‌های پرداخت امن شاپرک با فعال‌سازی لحظه‌ای. کلیه طلافروشان از <strong class="text-amber-700 dark:text-amber-400 font-bold">۱۴ روز مهلت تست رایگان</strong> بدون نیاز به پرداخت اولیه برخوردارند.
                </p>
            </div>

            {{-- ۱. نمای موبایل: سوئیچر سگمنت نئومورفیک اپل --}}
            <div class="md:hidden space-y-6">
                <div class="tl-neu-track p-1.5 rounded-2xl flex items-center justify-between gap-1 max-w-md mx-auto select-none">
                    <button type="button"
                            @click="mobilePlan = '1m'"
                            class="flex-1 min-h-11 py-2 px-1 rounded-xl text-xs font-semibold transition-all text-center cursor-pointer"
                            :class="mobilePlan === '1m' ? 'tl-neu-pill-active text-stone-900 dark:text-stone-50 font-bold' : 'text-stone-600 dark:text-stone-400'">
                        <span>۱ ماهه</span>
                    </button>
                    <button type="button"
                            @click="mobilePlan = '3m'"
                            class="flex-1 min-h-11 py-2 px-1 rounded-xl text-xs font-semibold transition-all text-center cursor-pointer"
                            :class="mobilePlan === '3m' ? 'tl-neu-pill-active text-stone-900 dark:text-stone-50 font-bold' : 'text-stone-600 dark:text-stone-400'">
                        <span>۳ ماهه</span>
                    </button>
                    <button type="button"
                            @click="mobilePlan = '6m'"
                            class="flex-1 min-h-11 py-2 px-1 rounded-xl text-xs font-semibold transition-all text-center cursor-pointer"
                            :class="mobilePlan === '6m' ? 'tl-neu-pill-active text-stone-900 dark:text-stone-50 font-bold' : 'text-stone-600 dark:text-stone-400'">
                        <span>۶ ماهه</span>
                    </button>
                    <button type="button"
                            @click="mobilePlan = '12m'"
                            class="flex-1 min-h-11 py-2 px-1 rounded-xl text-xs font-bold transition-all text-center cursor-pointer"
                            :class="mobilePlan === '12m' ? 'tl-btn-bullion' : 'text-amber-700 dark:text-amber-400'">
                        <span>۱ ساله ★</span>
                    </button>
                </div>

                <div class="max-w-md mx-auto">
                    {{-- تب ۱: ۱ ماهه --}}
                    <div x-show="mobilePlan === '1m'" x-cloak x-transition.opacity.duration.150ms class="rounded-3xl p-6 tl-neu-card space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اشتراک ۱ ماهه</h3>
                                <p class="text-[11px] text-stone-600 dark:text-stone-400 mt-0.5">مناسب بررسی اولیه امکانات</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-semibold tl-neu-inset text-stone-700 dark:text-stone-300">۳۰ روز</span>
                        </div>
                        <div class="tl-neu-inset p-4 rounded-2xl flex items-baseline justify-between">
                            <span class="text-xs text-stone-600 dark:text-stone-400">هزینه دوره:</span>
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-3xl font-bold text-stone-900 dark:text-stone-50 font-mono tabular-nums">۶۹۰,۰۰۰</span>
                                <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                            </div>
                        </div>
                        <ul class="space-y-2.5 text-xs text-stone-700 dark:text-stone-300">
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>پخش زنده تلویزیون با کیفیت 4K</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>فرمول‌ساز پیشرفته حاشیه سود و مظنه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>اسلایدشوی ویترین محصولات گالری</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>پشتیبانی فنی در تلگرام و تلفنی</span>
                            </li>
                        </ul>
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>انتخاب و خرید آنلاین</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>شروع ۱۴ روز تست رایگان</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @endauth
                    </div>

                    {{-- تب ۲: ۳ ماهه --}}
                    <div x-show="mobilePlan === '3m'" x-cloak x-transition.opacity.duration.150ms class="rounded-3xl p-6 tl-neu-card space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اشتراک ۳ ماهه</h3>
                                <p class="text-[11px] text-stone-600 dark:text-stone-400 mt-0.5">پلن فصلی با ثبات نرخ</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-semibold tl-neu-inset text-stone-700 dark:text-stone-300">۹۰ روز</span>
                        </div>
                        <div class="tl-neu-inset p-4 rounded-2xl flex items-baseline justify-between">
                            <span class="text-xs text-stone-600 dark:text-stone-400">مبلغ ۳ ماه:</span>
                            <div class="text-left">
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-3xl font-bold text-stone-900 dark:text-stone-50 font-mono tabular-nums">۱,۷۹۰,۰۰۰</span>
                                    <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                                </div>
                                <div class="text-[11px] text-stone-600 dark:text-stone-400 mt-0.5 font-mono tabular-nums">ماهیانه ۵۹۶,۰۰۰ تومان</div>
                            </div>
                        </div>
                        <ul class="space-y-2.5 text-xs text-stone-700 dark:text-stone-300">
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>کلیه امکانات تابلو و فرمول‌ساز پیشرفته</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>پخش مداوم آفلاین در قطعی اینترنت</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>پشتیبانی مستقیم و بروزرسانی خودکار</span>
                            </li>
                        </ul>
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>انتخاب و خرید آنلاین</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>شروع ۱۴ روز تست رایگان</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @endauth
                    </div>

                    {{-- تب ۳: ۶ ماهه --}}
                    <div x-show="mobilePlan === '6m'" x-cloak x-transition.opacity.duration.150ms class="rounded-3xl p-6 tl-neu-card space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اشتراک ۶ ماهه</h3>
                                <p class="text-[11px] text-stone-600 dark:text-stone-400 mt-0.5">پلن نیم‌سال با تخفیف ویژه</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-semibold tl-neu-inset text-stone-700 dark:text-stone-300">۱۸۰ روز</span>
                        </div>
                        <div class="tl-neu-inset p-4 rounded-2xl flex items-baseline justify-between">
                            <span class="text-xs text-stone-600 dark:text-stone-400">مبلغ ۶ ماه:</span>
                            <div class="text-left">
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-3xl font-bold text-stone-900 dark:text-stone-50 font-mono tabular-nums">۲,۸۹۰,۰۰۰</span>
                                    <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                                </div>
                                <div class="text-[11px] text-stone-600 dark:text-stone-400 mt-0.5 font-mono tabular-nums">ماهیانه ۴۸۱,۰۰۰ تومان</div>
                            </div>
                        </div>
                        <ul class="space-y-2.5 text-xs text-stone-700 dark:text-stone-300">
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>کلیه قابلیت‌های حرفه‌ای بدون محدودیت</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>ثبات کامل قیمت برای ۶ ماه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>پشتیبانی و پاسخگویی سریع</span>
                            </li>
                        </ul>
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>انتخاب و خرید آنلاین</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>شروع ۱۴ روز تست رایگان</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @endauth
                    </div>

                    {{-- تب ۴: ۱۲ ماهه (پیشنهاد برگزیده طلالایو) --}}
                    <div x-show="mobilePlan === '12m'" x-transition.opacity.duration.150ms class="relative rounded-3xl p-6 tl-neu-card-gold space-y-6">
                        <div class="absolute -top-3.5 right-6 px-3.5 py-0.5 rounded-full text-xs font-bold tl-btn-bullion">
                            محبوب‌ترین انتخاب طلافروشان ★
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <div>
                                <h3 class="text-xl font-bold text-stone-900 dark:text-stone-50">اشتراک سالانه (۱۲ ماه)</h3>
                                <p class="text-xs text-amber-700 dark:text-amber-400 font-semibold mt-0.5">بیشترین صرفه‌جویی اقتصادی</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tl-glass-badge text-amber-900 dark:text-amber-300">۳۶۵ روز</span>
                        </div>
                        <div class="tl-neu-inset p-4 rounded-2xl flex items-baseline justify-between">
                            <span class="text-xs text-stone-600 dark:text-stone-400">مبلغ یک سال کامل:</span>
                            <div class="text-left">
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-3xl font-bold text-amber-700 dark:text-amber-400 font-mono tabular-nums">۴,۷۰۰,۰۰۰</span>
                                    <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                                </div>
                                <div class="text-[11px] text-emerald-700 dark:text-emerald-400 font-semibold mt-0.5 font-mono tabular-nums">تخفیف ۷۲ ساعت اول: ۳,۹۶۰,۰۰۰ ت</div>
                            </div>
                        </div>
                        <ul class="space-y-2.5 text-xs text-stone-700 dark:text-stone-300 border-t border-stone-300/60 dark:border-white/10 pt-4">
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                                <span class="font-bold text-stone-900 dark:text-stone-100">پخش نامحدود 4K بدون قطعی در طول سال</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                                <span>فرمول‌ساز پیشرفته محاسبه سود و مالیات</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                                <span>ویترین آنلاین و اسلایدر نامحدود عکس طلا</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                                <span>کارکرد هوشمند در قطعی اینترنت (آفلاین)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                                <span class="font-bold text-amber-700 dark:text-amber-400">اولویت پشتیبانی اختصاصی</span>
                            </li>
                        </ul>
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full min-h-11 py-3.5 px-4 rounded-xl tl-btn-bullion text-xs font-bold flex items-center justify-center gap-1.5 cursor-pointer">
                                <span>خرید سالانه و فعال‌سازی آنی</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3.5 px-4 rounded-xl tl-btn-bullion text-xs font-bold flex items-center justify-center gap-1.5 cursor-pointer">
                                <span>ثبت‌نام و شروع ۱۴ روز تست رایگان</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- ۲. نمای دسکتاپ و تبلت: گرید ۴ پلن نئومورفیک هم‌تراز --}}
            <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch pt-2">
                
                {{-- پلن ۱: ۱ ماهه --}}
                <div class="rounded-3xl p-6 sm:p-7 tl-neu-card flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اشتراک ۱ ماهه</h3>
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-semibold tl-neu-inset text-stone-700 dark:text-stone-300">کوتاه‌مدت</span>
                        </div>
                        <div class="mb-4">
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-3xl font-bold text-stone-900 dark:text-stone-50 font-mono tabular-nums">۶۹۰,۰۰۰</span>
                                <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                            </div>
                            <div class="text-[11px] text-stone-500 dark:text-stone-400 mt-1 font-mono tabular-nums">ماهیانه ۶۹۰,۰۰۰ تومان</div>
                        </div>
                        <p class="text-xs text-stone-600 dark:text-stone-400 mb-6 leading-relaxed">
                            مناسب جهت بررسی اولیه و تست امکانات تابلوی هوشمند مغازه.
                        </p>
                        <ul class="space-y-3 text-xs text-stone-700 dark:text-stone-300 border-t border-stone-300/60 dark:border-white/10 pt-5">
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>پخش زنده تلویزیون 4K</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>فرمول‌ساز سود و مظنه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>ویترین و اسلایدر محصولات</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>پشتیبانی تلگرام و تلفنی</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4">
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>انتخاب و تمدید آنلاین</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>شروع با تست رایگان</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- پلن ۲: ۳ ماهه --}}
                <div class="rounded-3xl p-6 sm:p-7 tl-neu-card flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اشتراک ۳ ماهه</h3>
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-semibold tl-neu-inset text-stone-700 dark:text-stone-300">۱۵٪ صرفه‌جویی</span>
                        </div>
                        <div class="mb-4">
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-3xl font-bold text-stone-900 dark:text-stone-50 font-mono tabular-nums">۱,۷۹۰,۰۰۰</span>
                                <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                            </div>
                            <div class="text-[11px] text-stone-500 dark:text-stone-400 mt-1 font-mono tabular-nums">معادل ۵۹۶,۰۰۰ تومان / ماه</div>
                        </div>
                        <p class="text-xs text-stone-600 dark:text-stone-400 mb-6 leading-relaxed">
                            انتخاب فصلی با ثبات نرخ و دسترسی کامل به کلیه قابلیت‌ها.
                        </p>
                        <ul class="space-y-3 text-xs text-stone-700 dark:text-stone-300 border-t border-stone-300/60 dark:border-white/10 pt-5">
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>پخش زنده تلویزیون 4K</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>فرمول‌ساز سود و مظنه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>ویترین و اسلایدر محصولات</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>پشتیبانی تلگرام و تلفنی</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4">
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>انتخاب و تمدید آنلاین</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>شروع با تست رایگان</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- پلن ۳: ۶ ماهه --}}
                <div class="rounded-3xl p-6 sm:p-7 tl-neu-card flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اشتراک ۶ ماهه</h3>
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-semibold tl-neu-inset text-stone-700 dark:text-stone-300">۳۰٪ صرفه‌جویی</span>
                        </div>
                        <div class="mb-4">
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-3xl font-bold text-stone-900 dark:text-stone-50 font-mono tabular-nums">۲,۸۹۰,۰۰۰</span>
                                <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                            </div>
                            <div class="text-[11px] text-stone-500 dark:text-stone-400 mt-1 font-mono tabular-nums">معادل ۴۸۱,۰۰۰ تومان / ماه</div>
                        </div>
                        <p class="text-xs text-stone-600 dark:text-stone-400 mb-6 leading-relaxed">
                            پلن نیم‌سال با تخفیف ویژه و پایداری تضمین‌شده سرورها.
                        </p>
                        <ul class="space-y-3 text-xs text-stone-700 dark:text-stone-300 border-t border-stone-300/60 dark:border-white/10 pt-5">
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>پخش زنده تلویزیون 4K</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>فرمول‌ساز سود و مظنه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>ویترین و اسلایدر محصولات</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                                <span>پشتیبانی تلگرام و تلفنی</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4">
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>انتخاب و تمدید آنلاین</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-neu-btn text-stone-900 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 text-xs font-bold flex items-center justify-center gap-1.5">
                                <span>شروع با تست رایگان</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- پلن ۴: ۱۲ ماهه (پیشنهاد برگزیده طلایی - HERO PLAN) --}}
                <div class="relative rounded-3xl p-6 sm:p-7 tl-neu-card-gold flex flex-col justify-between -translate-y-2">
                    <div class="absolute -top-3.5 right-1/2 translate-x-1/2 px-3.5 py-1 rounded-full text-xs font-bold tl-btn-bullion whitespace-nowrap">
                        محبوب‌ترین انتخاب طلافروشان ★
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-4 pt-2">
                            <h3 class="text-lg font-bold text-stone-900 dark:text-stone-50">اشتراک سالانه (۱۲ ماه)</h3>
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold tl-glass-badge text-amber-900 dark:text-amber-300">بیش از ۵۰٪ تخفیف</span>
                        </div>
                        <div class="mb-4">
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-3xl font-bold text-amber-700 dark:text-amber-400 font-mono tabular-nums">۴,۷۰۰,۰۰۰</span>
                                <span class="text-xs font-semibold text-stone-600 dark:text-stone-400">تومان</span>
                            </div>
                            <div class="inline-flex items-center gap-1 mt-1.5 px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold">
                                <span>تخفیف ۷۲ ساعت اول: ۳,۹۶۰,۰۰۰ تومان</span>
                            </div>
                        </div>
                        <p class="text-xs text-stone-600 dark:text-stone-400 mb-6 leading-relaxed">
                            بیشترین صرفه اقتصادی برای یک سال کامل بدون دغدغه نوسان قیمت، همراه با اولویت پشتیبانی.
                        </p>
                        <ul class="space-y-3 text-xs text-stone-700 dark:text-stone-300 border-t border-stone-300/60 dark:border-white/10 pt-5">
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                                <span class="font-bold text-stone-900 dark:text-stone-100">پخش زنده تلویزیون 4K نامحدود</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                                <span>فرمول‌ساز اختصاصی سود و مظنه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                                <span>ویترین و اسلایدر نامحدود محصولات</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                                <span>کارکرد هوشمند در قطعی اینترنت</span>
                            </li>
                            <li class="flex items-center gap-2">
                                @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400 shrink-0'])
                                <span class="font-bold text-amber-700 dark:text-amber-400">اولویت پشتیبانی اختصاصی</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8 pt-4">
                        @auth
                            <a href="{{ route('admin.subscription.index') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-btn-bullion text-xs font-bold flex items-center justify-center gap-1.5 cursor-pointer">
                                <span>خرید سالانه و فعال‌سازی آنی</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @else
                            <a href="{{ route('admin.register') }}" class="w-full min-h-11 py-3 px-4 rounded-xl tl-btn-bullion text-xs font-bold flex items-center justify-center gap-1.5 cursor-pointer">
                                <span>ثبت‌نام و شروع ۱۴ روز تست رایگان</span>
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                            </a>
                        @endauth
                    </div>
                </div>

            </div>

            {{-- بنر ضمانت و امنیت پرداخت نئومورفیک --}}
            <div class="rounded-3xl tl-neu-card p-5 sm:p-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl tl-neu-icon-orb text-emerald-700 dark:text-emerald-400 flex items-center justify-center shrink-0">
                        @include('partials.ui-icon', ['name' => 'shield', 'class' => 'w-5 h-5'])
                    </div>
                    <div>
                        <div class="font-bold text-stone-900 dark:text-stone-50">تضمین حفظ روزها (No Day Lost)</div>
                        <p class="text-stone-600 dark:text-stone-400 mt-0.5">در صورت تمدید پیش از موعد، کلیه روزهای باقیمانده حفظ شده و اشتراک جدید به پایان آن افزوده می‌شود.</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-stone-600 dark:text-stone-400 shrink-0 flex-wrap">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>اتصال شاپرک (زرین‌پال و زیبال)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>صدور فاکتور رسمی دیجیتال</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- بخش ۷: سوالات متداول طلافروشان (FAQ با details بومی و سطح نئومورفیک) --}}
    <section id="faq" class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 border-t border-stone-300/60 dark:border-white/10 tl-reveal">
        <div class="max-w-4xl mx-auto space-y-8">
            <div class="text-center space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full tl-glass-badge text-amber-900 dark:text-amber-300 text-xs font-semibold">
                    <span>پاسخ به ابهامات متداول</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-stone-900 dark:text-stone-50">
                    سوالات متداول طلافروشان و همکاران محترم
                </h2>
            </div>

            <div class="divide-y divide-stone-300/60 dark:divide-white/10 rounded-3xl tl-neu-card overflow-hidden">
                <details class="group p-5 sm:p-6">
                    <summary class="flex items-center justify-between gap-4 cursor-pointer font-bold text-sm text-stone-900 dark:text-stone-50 list-none">
                        <span>سامانه طلا لایو (طلالایو) چیست و چه کاربردی برای مغازه طلافروشی دارد؟</span>
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5 text-stone-500 transition-transform duration-150 group-open:rotate-180 shrink-0'])
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed border-t border-stone-300/50 dark:border-white/10 pt-3">
                        سامانه طلا لایو (طلالایو - TalaLive) پلتفرم ابری هوشمند مدیریت و نمایش آنلاین نرخ لحظه‌ای طلا، سکه و ارز ویژه تلویزیون‌های مغازه طلافروشی است که بدون نیاز به خرید مینی‌کیس، کامپیوتر یا دانگل واسط، تابلوی نرخ رسمی، فرمول‌ساز سود قانونی و ویترین دیجیتال گالری را فعال می‌کند.
                    </p>
                </details>

                <details class="group p-5 sm:p-6">
                    <summary class="flex items-center justify-between gap-4 cursor-pointer font-bold text-sm text-stone-900 dark:text-stone-50 list-none">
                        <span>آیا برای راه‌اندازی تابلوی طلالایو نیاز به خرید کامپیوتر یا دستگاه جداگانه در مغازه هست؟</span>
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5 text-stone-500 transition-transform duration-150 group-open:rotate-180 shrink-0'])
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed border-t border-stone-300/50 dark:border-white/10 pt-3">
                        خیر، هیچ نیازی به خرید مینی‌کیس، کامپیوتر یا دانگل اضافه نیست. شما می‌توانید تنها با استفاده از مرورگر وب داخلی هر نوع تلویزیون هوشمند (سامسونگ، ال‌جی، سونی، اسنوا، دوو یا اندروید تی‌وی) و اسکن یکبار QR کد، تابلوی اختصاصی طلافروشی خود را بدون سیم‌کشی راه‌اندازی کنید.
                    </p>
                </details>

                <details class="group p-5 sm:p-6">
                    <summary class="flex items-center justify-between gap-4 cursor-pointer font-bold text-sm text-stone-900 dark:text-stone-50 list-none">
                        <span>نرخ‌های طلا، سکه و ارز از چه مراجعی بروزرسانی می‌شوند؟</span>
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5 text-stone-500 transition-transform duration-150 group-open:rotate-180 shrink-0'])
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed border-t border-stone-300/50 dark:border-white/10 pt-3">
                        نرخ‌ها به صورت خودکار و لحظه‌ای از مراجع معتبر و منتخب بازار طلا و جواهر کشور، اتحادیه‌های طلا و سکه و مراجع رسمی انس جهانی دریافت می‌شوند و به صورت بلادرنگ روی تابلوی شما آپدیت می‌گردند.
                    </p>
                </details>

                <details class="group p-5 sm:p-6">
                    <summary class="flex items-center justify-between gap-4 cursor-pointer font-bold text-sm text-stone-900 dark:text-stone-50 list-none">
                        <span>در صورت قطعی موقت اینترنت در طلافروشی چه اتفاقی می‌افتد؟</span>
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5 text-stone-500 transition-transform duration-150 group-open:rotate-180 shrink-0'])
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed border-t border-stone-300/50 dark:border-white/10 pt-3">
                        طلالایو مجهز به فناوری کش هوشمند آفلاین است. در صورت قطعی اینترنت، تابلوی شما هرگز متوقف نمی‌شود؛ بلکه آخرین نرخ‌های دریافتی معتبر را با برچسب ساعت آخرین بروزرسانی همراه با ویترین محصولات به نمایش مداوم ادامه می‌دهد.
                    </p>
                </details>

                <details class="group p-5 sm:p-6">
                    <summary class="flex items-center justify-between gap-4 cursor-pointer font-bold text-sm text-stone-900 dark:text-stone-50 list-none">
                        <span>چگونه می‌توان فرمول سود، اجرت یا مظنه را برای طلافروشی شخصی‌سازی کرد؟</span>
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5 text-stone-500 transition-transform duration-150 group-open:rotate-180 shrink-0'])
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed border-t border-stone-300/50 dark:border-white/10 pt-3">
                        از طریق پنل مدیریت موبایل یا کامپیوتر، بخش فرمول‌ساز هوشمند در اختیارتان قرار دارد که می‌توانید درصد سود فروش، حاشیه خرید، مالیات و تخفیف‌ها را به ازای هر گرم یا نوع سکه اختصاصی‌سازی کنید تا نرخ‌ها مطابق با سیاست مالی گالری شما محاسبه و نمایش یابند.
                    </p>
                </details>

                <details class="group p-5 sm:p-6">
                    <summary class="flex items-center justify-between gap-4 cursor-pointer font-bold text-sm text-stone-900 dark:text-stone-50 list-none">
                        <span>آیا اتصال تلویزیون پس از هر بار خاموش و روشن شدن مغازه قطع می‌شود؟</span>
                        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-5 h-5 text-stone-500 transition-transform duration-150 group-open:rotate-180 shrink-0'])
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-stone-700 dark:text-stone-300 leading-relaxed border-t border-stone-300/50 dark:border-white/10 pt-3">
                        خیر، اطلاعات اتصال تلویزیون شما در حافظه پایدار مرورگر تلویزیون به صورت خودکار ذخیره می‌شود و با روشن شدن تلویزیون، صفحه بدون نیاز به اسکن مجدد فوراً باز شده و به تابلوی زنده شما متصل می‌گردد.
                    </p>
                </details>
            </div>
        </div>
    </section>

    {{-- بخش ۸: پایگاه دانش و راهنماهای تخصصی طلا و سکه --}}
    <section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto tl-reveal">
        <div class="flex items-center justify-between flex-wrap gap-4 mb-10">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-stone-900 dark:text-stone-50">
                    دانشنامه، ابزارها و راهنماهای صنف طلا و جواهر
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 mt-1">
                    مقالات تخصصی نحوه محاسبه اجرت، عیار، سود مغازه و حباب انواع سکه
                </p>
            </div>
            <a href="{{ route('public.guides') }}" class="min-h-11 px-4 py-2 rounded-xl tl-neu-btn inline-flex items-center gap-1.5 text-xs font-bold text-amber-800 dark:text-amber-300">
                <span>مشاهده تمام مقالات و آموزش‌ها</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('public.guides.show', 'gold-price-formula-18k') }}" class="tl-neu-card-interactive rounded-3xl p-5 space-y-3.5 group block">
                <div class="w-10 h-10 rounded-xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'calculator', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-stone-900 dark:text-stone-50 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors leading-snug">
                    فرمول دقیق محاسبه قیمت طلا ۱۸ عیار با اجرت و سود مغازه طلافروشی
                </h3>
                <p class="text-[11px] text-stone-600 dark:text-stone-400 leading-relaxed line-clamp-2">
                    آموزش نحوه محاسبه فاکتور طلا، طلای دست دوم، کم اجرت و سود قانونی اتحادیه طلا.
                </p>
            </a>

            <a href="{{ route('public.guides.show', 'how-to-calculate-coin-bubble') }}" class="tl-neu-card-interactive rounded-3xl p-5 space-y-3.5 group block">
                <div class="w-10 h-10 rounded-xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'coin', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-stone-900 dark:text-stone-50 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors leading-snug">
                    فرمول محاسبه حباب سکه امامی، بهار آزادی، نیم سکه و ربع سکه
                </h3>
                <p class="text-[11px] text-stone-600 dark:text-stone-400 leading-relaxed line-clamp-2">
                    نحوه محاسبه ارزش ذاتی و حباب سکه بهار آزادی، نیم سکه و ربع سکه بر مبنای انس جهانی طلا.
                </p>
            </a>

            <a href="{{ route('public.guides.show', 'best-tv-for-jewelry-shop') }}" class="tl-neu-card-interactive rounded-3xl p-5 space-y-3.5 group block">
                <div class="w-10 h-10 rounded-xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-stone-900 dark:text-stone-50 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors leading-snug">
                    راهنمای انتخاب بهترین تلویزیون برای تابلو طلافروشی و مغازه طلا
                </h3>
                <p class="text-[11px] text-stone-600 dark:text-stone-400 leading-relaxed line-clamp-2">
                    مقایسه تلویزیون‌های سامسونگ، ال‌جی و اسنوا از نظر طول عمر پنل و وضوح در نور ویترین.
                </p>
            </a>

            <a href="{{ route('public.guides.show', 'gold-tax-regulations') }}" class="tl-neu-card-interactive rounded-3xl p-5 space-y-3.5 group block">
                <div class="w-10 h-10 rounded-xl tl-neu-icon-orb text-amber-700 dark:text-amber-400 flex items-center justify-center">
                    @include('partials.ui-icon', ['name' => 'book', 'class' => 'w-5 h-5'])
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-stone-900 dark:text-stone-50 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors leading-snug">
                    قانون جدید مالیات طلا و اجرت در سامانه مودیان صنف طلا
                </h3>
                <p class="text-[11px] text-stone-600 dark:text-stone-400 leading-relaxed line-clamp-2">
                    بررسی تکالیف مالیاتی طلافروشان، معافیت اصل طلا و محاسبه مالیات روی اجرت و سود.
                </p>
            </a>
        </div>
    </section>
@endsection
