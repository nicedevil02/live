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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    <script defer src="{{ asset('vendor/alpinejs.min.js') }}"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
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
                        ['r' => 'admin.users.index', 'l' => 'مدیریت کاربران', 'i' => 'users', 'super_only' => true],
                        ['r' => 'admin.sources', 'l' => 'منابع دریافت API', 'i' => 'rss', 'super_only' => true],
                        ['r' => 'admin.formulas', 'l' => 'فرمول‌های محاسبه', 'i' => 'variable'],
                        ['r' => 'admin.products.index', 'l' => 'ویترین طلا (اسلایدر)', 'i' => 'gem'],
                        ['r' => 'admin.display-control', 'l' => 'تنظیمات پوسته و نمایش', 'i' => 'sliders-horizontal'],
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
        lucide.createIcons();
    </script>
</body>
</html>
