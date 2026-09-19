<!DOCTYPE html>
<html lang="fa" dir="rtl" x-data="adminThemeHandler()" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'پنل مدیریت') - Live Gold</title>

    <script>
        // منطق اجبار به حالت روشن در اولین بازدید و جداکردن از سیستم‌عامل
        (function() {
            // اگر برای اولین بار وارد پنل شده، تم را روی لایت ست کن
            if (!localStorage.getItem('admin_panel_initialized')) {
                localStorage.setItem('admin_panel_theme', 'light');
                localStorage.setItem('admin_panel_initialized', 'true');
            }

            const theme = localStorage.getItem('admin_panel_theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- PWA Settings & Apple Mobile Web App -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#020617">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="طلالایو">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    <script defer src="{{ asset('vendor/alpinejs.min.js') }}"></script>
    <script defer src="{{ asset('vendor/lucide.min.js') }}"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Vazirmatn', sans-serif; }
        .sidebar-transition { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        /* اطمینان از اینکه در حالت لایت، پس‌زمینه حتما سفید/روشن باشد */
        html:not(.dark) body { background-color: #f8fafc; color: #0f172a; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased transition-colors duration-300">

    <div class="flex h-screen overflow-hidden">
        {{-- Mobile Overlay --}}
        <div x-show="mobileMenu"
             x-cloak
             @click="mobileMenu = false"
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden"
             x-transition:enter="transition opacity-0 duration-300"
             x-transition:leave="transition opacity-0 duration-200">
        </div>

        {{-- Sidebar --}}
        <aside
            x-cloak
            class="fixed inset-y-0 right-0 z-50 w-72 flex flex-col border-l border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 sidebar-transition lg:static lg:translate-x-0"
            :class="mobileMenu ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'"
        >
            <div class="flex h-16 items-center justify-between px-6 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" class="h-9 w-9 object-contain rounded-xl bg-slate-100 dark:bg-slate-800 p-0.5" alt="Logo">
                    <h2 class="text-lg font-black">پنل مدیریت</h2>
                </div>
                <button @click="mobileMenu = false" class="lg:hidden text-slate-500 p-2 hover:text-rose-500 transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                @php
                    $links = [
                        ['r' => 'admin.dashboard', 'l' => 'داشبورد مدیریت', 'i' => 'layout-dashboard'],
                        ['r' => 'admin.shop-profile', 'l' => 'اطلاعات فروشگاه و QR', 'i' => 'store'],
                        ['r' => 'admin.products.index', 'l' => 'ویترین طلا (اسلایدر)', 'i' => 'gem'],
                        ['r' => 'admin.display-control', 'l' => 'تنظیمات پوسته و نمایش', 'i' => 'sliders-horizontal'],
                        ['r' => 'admin.formulas', 'l' => 'فرمول‌های محاسبه', 'i' => 'variable'],
                        ['r' => 'admin.devices.index', 'l' => 'تلویزیون‌های من', 'i' => 'tv'],
                        ['r' => 'admin.subscription.index', 'l' => 'خرید و تمدید اشتراک', 'i' => 'crown'],
                        ['r' => 'admin.transactions.index', 'l' => 'تراکنش‌ها و مالی', 'i' => 'wallet', 'super_only' => true],
                        ['r' => 'admin.users.index', 'l' => 'مدیریت کاربران', 'i' => 'users', 'super_only' => true],
                        ['r' => 'admin.sms-status', 'l' => 'درگاه پیامک (s.api.ir)', 'i' => 'message-square', 'super_only' => true],
                        ['r' => 'admin.sources', 'l' => 'منابع دریافت API', 'i' => 'rss', 'super_only' => true],
                        ['r' => 'admin.logs', 'l' => 'گزارشات سیستم', 'i' => 'file-text', 'super_only' => true],
                    ];
                @endphp
                @foreach($links as $link)
                    @if(!isset($link['super_only']) || auth()->user()->is_super_admin)
                        <a href="{{ route($link['r']) }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all
                                  {{ request()->routeIs($link['r'] . '*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                            <i data-lucide="{{ $link['i'] }}" class="w-5 h-5"></i>
                            <span>{{ $link['l'] }}</span>
                        </a>
                    @endif
                @endforeach
            </nav>

            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between gap-3 p-3 rounded-2xl bg-slate-100 dark:bg-slate-800/50">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                            {{ mb_substr(auth()->user()->name, 0, 1, 'UTF-8') }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] opacity-60 uppercase font-black tracking-wider text-slate-500 dark:text-slate-400">Administrator</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 self-end select-none">v2.1.4</span>
                </div>
            </div>
        </aside>

        {{-- Main Area --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            @if(session('impersonator_id'))
                <div class="bg-gradient-to-r from-amber-600 via-orange-600 to-amber-700 text-white px-4 py-2.5 flex flex-wrap items-center justify-between gap-2 text-xs font-bold shadow-md z-40">
                    <div class="flex items-center gap-2">
                        <span class="text-base">🛡️</span>
                        <span>شما هم‌اکنون در حال مدیریت و پشتیبانی پنل «{{ auth()->user()->name }}» هستید.</span>
                    </div>
                    <form method="POST" action="{{ Route::has('admin.impersonate.leave') ? route('admin.impersonate.leave') : (Route::has('impersonate.leave') ? route('impersonate.leave') : url('/admin/leave-impersonate')) }}" class="m-0">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-white text-slate-950 rounded-lg hover:bg-amber-100 transition-colors shadow-sm font-black flex items-center gap-1 cursor-pointer">
                            <span>بازگشت به پنل سوپرادمین</span>
                            <span>&larr;</span>
                        </button>
                    </form>
                </div>
            @endif

            <header class="h-16 shrink-0 flex items-center justify-between px-4 lg:px-8 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm z-30">
                <div class="flex items-center gap-4">
                    <button @click="mobileMenu = true" class="lg:hidden p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h1 class="text-sm font-black text-slate-800 dark:text-white">@yield('title', 'داشبورد')</h1>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="toggleTheme()"
                            class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm flex items-center justify-center">
                        <i x-show="!darkMode" data-lucide="moon" class="w-5 h-5 text-slate-600"></i>
                        <i x-show="darkMode" data-lucide="sun" class="w-5 h-5 text-amber-400"></i>
                    </button>

                    <div class="h-8 w-px bg-slate-200 dark:bg-slate-800 mx-1"></div>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="px-4 py-2 rounded-xl text-xs font-black text-rose-600 bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 transition-colors border border-rose-100 dark:border-rose-900/30">
                            خروج
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function adminThemeHandler() {
            return {
                darkMode: document.documentElement.classList.contains('dark'),
                mobileMenu: false,
                toggleTheme() {
                    this.darkMode = !this.darkMode;
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('admin_panel_theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('admin_panel_theme', 'light');
                    }
                }
            }
        }
    </script>
    @stack('scripts')
    <script>
        function renderLucideIcons() {
            if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                lucide.createIcons();
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', renderLucideIcons);
        } else {
            renderLucideIcons();
        }
        window.addEventListener('alpine:initialized', renderLucideIcons);
    </script>

    {{-- اعلان هوشمند و زیبا برای نصب وب‌اپلیکیشن PWA ویژه پنل حساب کاربری --}}
    <div x-data="pwaInstallHandler()"
         x-show="showPrompt"
         x-cloak
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 scale-95"
         class="fixed bottom-5 left-5 right-5 sm:right-auto sm:max-w-md z-50 bg-white/95 dark:bg-slate-900/95 border-2 border-amber-500/40 dark:border-amber-500/50 rounded-3xl p-4 sm:p-5 shadow-2xl backdrop-blur-xl">
        
        <div class="flex items-start gap-3.5">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-yellow-600 flex items-center justify-center text-slate-950 text-2xl shadow-lg shadow-amber-500/30 shrink-0">
                📱
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-2">
                    <h4 class="text-sm font-black text-slate-900 dark:text-white">نصب وب‌اپلیکیشن طلالایو (PWA)</h4>
                    <button @click="dismiss(1)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1 rounded-lg transition-colors cursor-pointer" title="بستن">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                    برای دسترسی سریع‌تر، کارکرد روان‌تر و مدیریت آسان تابلوی طلا بدون نیاز به باز کردن مرورگر، اپلیکیشن طلالایو را به صفحه اصلی خود اضافه کنید.
                </p>

                {{-- راهنمای مخصوص iOS در مرورگر Safari --}}
                <div x-show="isIos" class="mt-2.5 p-2 rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-500/20 text-[11px] text-amber-800 dark:text-amber-300 leading-normal">
                    <span>در مرورگر Safari دکمه <strong>Share (⎋)</strong> را بزنید و گزینه <strong>«Add to Home Screen» (➕)</strong> را انتخاب فرمایید.</span>
                </div>

                <div class="flex items-center gap-2 mt-3.5">
                    <button x-show="!isIos" @click="install()" type="button" class="flex-1 py-2 px-4 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-xs shadow-md shadow-amber-500/20 transition-all cursor-pointer flex items-center justify-center gap-1.5">
                        <span>نصب مستقیم اپلیکیشن</span>
                        <span>↓</span>
                    </button>
                    <button @click="dismiss(3)" type="button" class="py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs transition-colors cursor-pointer">
                        <span>بعداً</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pwaInstallHandler() {
            return {
                showPrompt: false,
                deferredPrompt: null,
                isIos: false,

                init() {
                    // اگر قبلاً در حالت PWA باز شده، نیازی به نمایش اعلان نیست
                    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || 
                                         window.navigator.standalone === true;
                    if (isStandalone) {
                        return;
                    }

                    // بررسی وضعیت رد موقت توسط کاربر
                    const dismissedUntil = localStorage.getItem('talalive_pwa_dismissed_until');
                    if (dismissedUntil && Date.now() < parseInt(dismissedUntil, 10)) {
                        return;
                    }

                    // تشخیص سیستم‌عامل iOS
                    const ua = window.navigator.userAgent.toLowerCase();
                    this.isIos = /iphone|ipad|ipod/.test(ua) && !window.MSStream;

                    // رویداد استاندارد مرورگرهای کروم و اج
                    window.addEventListener('beforeinstallprompt', (e) => {
                        e.preventDefault();
                        this.deferredPrompt = e;
                        this.showPrompt = true;
                    });

                    // نمایش با تاخیر ملایم برای ایجاد تجربه کاربری آرام
                    setTimeout(() => {
                        if (!this.showPrompt) {
                            this.showPrompt = true;
                        }
                    }, 2000);
                },

                install() {
                    if (this.deferredPrompt) {
                        this.deferredPrompt.prompt();
                        this.deferredPrompt.userChoice.then((choiceResult) => {
                            if (choiceResult.outcome === 'accepted') {
                                this.showPrompt = false;
                            }
                            this.deferredPrompt = null;
                        });
                    } else {
                        // در صورت عدم پشتیبانی پرامپت خودکار، انتقال به صفحه دانلود و راهنما
                        window.location.href = '/app';
                    }
                },

                dismiss(days = 3) {
                    this.showPrompt = false;
                    const expireTime = Date.now() + (days * 24 * 60 * 60 * 1000);
                    localStorage.setItem('talalive_pwa_dismissed_until', expireTime.toString());
                }
            };
        }

        // ثبت Service Worker در پنل ادمین
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').catch(function(err) {
                    console.warn('Admin PWA ServiceWorker registration failed:', err);
                });
            });
        }
    </script>
</body>
</html>
