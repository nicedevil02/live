<!DOCTYPE html>
<html lang="fa" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#020617">

    {{-- اسکریپت اولیه تعیین تم --}}
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

        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.log('Error attempting to enable full-screen mode:', err.message);
                });
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }
    </script>

    <title>اتصال تلویزیون مغازه به تابلوی طلالایو | TalaLive TV</title>
    <meta name="description" content="صفحه اختصاصی اتصال و جفت‌سازی بی‌سیم تلویزیون هوشمند به سامانه تابلوی طلالایو.">
    <meta name="robots" content="noindex, nofollow">

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
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#020617] text-slate-800 dark:text-slate-100 selection:bg-amber-500/30 selection:text-amber-700 dark:selection:text-amber-200 antialiased overflow-x-hidden min-h-screen flex flex-col justify-between transition-colors duration-300">

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
            }
        }
    </script>

    {{-- پنجره تمام‌صفحه جشن و تبریک اتصال موفقیت‌آمیز تلویزیون --}}
    <div id="celebrationOverlay" style="display: none;" class="fixed inset-0 z-[100] bg-slate-950/95 backdrop-blur-2xl flex items-center justify-center p-4 text-center">
        <div class="max-w-md w-full bg-slate-900 border-2 border-amber-500/60 rounded-3xl p-8 shadow-2xl space-y-5">
            <div class="text-6xl animate-bounce">🎉</div>
            <h2 class="text-2xl sm:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-amber-400 to-yellow-500">
                اتصال با موفقیت انجام شد!
            </h2>
            <p class="text-sm text-slate-300 leading-relaxed">
                تلویزیون مغازه به تابلوی هوشمند گالری شما متصل گردید.<br>
                در حال بارگذاری نرخ‌های زنده طلا و سکه...
            </p>
            <div class="w-12 h-12 border-4 border-amber-500/20 border-t-amber-500 rounded-full animate-spin mx-auto"></div>
        </div>
    </div>

    {{-- نوار بالای صفحه تلویزیون (Minimal Top Bar) --}}
    <header class="w-full px-4 sm:px-8 py-4 sm:py-6 flex items-center justify-between gap-4 border-b border-slate-200/60 dark:border-slate-800/60 bg-white/60 dark:bg-slate-950/60 backdrop-blur-xl">
        {{-- برند طلالایو --}}
        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" class="h-9 w-9 sm:h-11 sm:w-11 object-contain pulse-logo rounded-2xl p-1 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700/60 shadow-md" alt="طلالایو">
            <div class="text-right">
                <div class="text-base sm:text-xl font-black text-slate-900 dark:text-amber-400">
                    طلالایو &middot; TalaLive
                </div>
                <div class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold">
                    پایانه اتصال تلویزیون هوشمند مغازه طلا فروشی
                </div>
            </div>
        </a>

        {{-- وضعیت زنده و دکمه‌های کنترل تلویزیون --}}
        <div class="flex items-center gap-2 sm:gap-3">
            <div class="hidden sm:flex items-center gap-2 text-xs font-bold text-slate-700 dark:text-slate-300 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-2 rounded-xl">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>آماده اتصال به تابلوی طلافروشی</span>
            </div>

            {{-- دکمه تمام‌صفحه سازی برای مخفی کردن نوار آدرس تلویزیون --}}
            <button onclick="toggleFullScreen()" type="button"
                    class="px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition-all cursor-pointer flex items-center gap-1.5 shadow-sm"
                    title="تمام‌صفحه">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                <span class="hidden md:inline">تمام‌صفحه</span>
            </button>

            {{-- دکمه تم شب/روز --}}
            <button onclick="toggleAppTheme()" type="button"
                    class="w-10 h-10 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-700 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all cursor-pointer shadow-sm"
                    title="تغییر تم">
                <svg class="w-4 h-4 text-amber-400 theme-sun-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg class="w-4 h-4 text-slate-700 dark:text-slate-200 theme-moon-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>
        </div>
    </header>

    {{-- بخش اصلی جفت‌سازی تمام‌صفحه و متمرکز تلویزیون --}}
    <main class="flex-1 flex flex-col justify-center items-center px-4 py-8 sm:py-12 max-w-5xl mx-auto w-full">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center w-full">
            
            {{-- ستون راست: راهنمای گام‌به‌گام اتصال برای طلافروش (۷ ستون) --}}
            <div class="lg:col-span-7 text-right space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-800 dark:text-amber-300 text-xs font-bold">
                    <span>📺 صفحه اتصال نمایشگر تلویزیون</span>
                </div>

                <div class="space-y-3">
                    <h1 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
                        اتصال این تلویزیون به تابلوی گالری طلا
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl">
                        این صفحه را روی مرورگر تلویزیون باز نگه دارید. به یکی از دو روش زیر می‌توانید این نمایشگر را به تابلوی اختصاصی مغازه خود متصل کنید:
                    </p>
                </div>

                {{-- مراحل ساده اتصال --}}
                <div class="bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 space-y-4 shadow-xl backdrop-blur-xl">
                    <div class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-2xl bg-amber-500 text-slate-950 font-black text-sm flex items-center justify-center shrink-0 shadow-md shadow-amber-500/30">
                            ۱
                        </div>
                        <div class="space-y-1">
                            <h2 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">روش اول: اسکن بارکد QR با گوشی</h2>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                دوربین تلفن همراه خود را مقابل بارکد روبرو بگیرید و لینک نمایش‌داده‌شده را باز فرمایید تا تلویزیون فوراً روشن شود.
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 dark:border-slate-800/80 pt-4 flex items-start gap-4">
                        <div class="w-9 h-9 rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-800 dark:text-slate-200 font-black text-sm flex items-center justify-center shrink-0">
                            ۲
                        </div>
                        <div class="space-y-1">
                            <h2 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">روش دوم: وارد کردن پین ۶ رقمی در پنل مدیریت</h2>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                در گوشی یا کامپیوتر وارد <a href="{{ route('admin.login') }}" target="_blank" class="text-amber-600 dark:text-amber-400 font-bold underline">پنل مدیریت طلالایو</a> شوید و پین ۶ رقمی درشت روبرو را در بخش اتصال تلویزیون ثبت فرمایید.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- یادآوری برای کاربران جدید --}}
                <div class="p-4 rounded-2xl bg-slate-100 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-300 flex items-center justify-between flex-wrap gap-2">
                    <div class="flex items-center gap-2">
                        <span class="text-amber-500 font-bold">💡 هنوز در طلالایو حساب باز نکرده‌اید؟</span>
                        <span>با گوشی وارد <b class="font-mono text-amber-600 dark:text-amber-400">talalive.ir</b> شده و در ۳۰ ثانیه تست رایگان ۱۴ روزه را فعال کنید.</span>
                    </div>
                    <a href="{{ route('admin.register') }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs shrink-0 transition-all">
                        ثبت‌نام رایگان ←
                    </a>
                </div>
            </div>

            {{-- ستون چپ: کارت بزرگ QR، پین ۶ رقمی درشت و ارسال پیامک جادویی (۵ ستون) --}}
            <div class="lg:col-span-5 flex flex-col gap-5 w-full max-w-[420px] mx-auto lg:mr-auto lg:ml-0" style="max-width: 420px; width: 100%;">
                
                <div class="w-full bg-white dark:bg-slate-900/95 border-2 border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-7 shadow-2xl backdrop-blur-xl flex flex-col items-center justify-center text-center gap-5 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-b from-amber-500/5 via-transparent to-blue-500/5 pointer-events-none"></div>

                    {{-- وضعیت زنده --}}
                    <div class="flex items-center gap-2 text-[11px] font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800/90 px-4 py-1.5 rounded-full border border-slate-200 dark:border-slate-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>آماده اتصال به تلویزیون هوشمند</span>
                    </div>

                    {{-- کادر تصویر QR Code با کنتراست بالا --}}
                    <div class="relative bg-white p-3 rounded-2xl overflow-hidden shadow-xl border-2 border-amber-400/40">
                        <img id="qrImage" src="" alt="بارکد هوشمند اتصال تلویزیون" class="w-52 h-52 sm:w-56 sm:h-56 object-contain">
                        <div id="qrLoader" class="absolute inset-0 bg-white flex items-center justify-center">
                            <div class="w-10 h-10 border-4 border-slate-200 border-t-amber-500 rounded-full animate-spin"></div>
                        </div>
                    </div>

                    {{-- پین اتصال ۶ رقمی عددی درشت --}}
                    <div class="space-y-1.5 w-full">
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold">پین عددی اتصال تلویزیون مغازه:</p>
                        <div id="activationCode" class="text-3xl sm:text-4xl font-black tracking-widest text-amber-600 dark:text-amber-400 font-mono bg-slate-50 dark:bg-slate-950/80 border-2 border-amber-500/30 py-3 rounded-2xl shadow-inner select-all">
                            --- ---
                        </div>
                        <p class="text-[11px] text-slate-500">کد را در پنل مدیریت وارد کنید یا با گوشی اسکن نمایید</p>
                    </div>

                    {{-- ارسال پیامک به موبایل طلافروش دارای حساب (Magic SMS Box) --}}
                    <div class="w-full pt-4 border-t border-slate-200 dark:border-slate-800/80 space-y-2 text-right"
                         x-data="{ phone: '', sending: false, smsMsg: '', isError: false }">
                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300">
                            📱 همکاران دارای حساب: ارسال این کد به موبایل شما:
                        </label>
                        <div class="flex items-center gap-1.5" dir="ltr">
                            <input type="tel" x-model="phone" maxlength="11" placeholder="09xxxxxxxxx"
                                   @input="phone = phone.replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d)).replace(/[^0-9]/g, '')"
                                   class="flex-1 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-center font-mono focus:outline-none focus:border-amber-500 text-slate-800 dark:text-slate-100">
                            <button type="button" :disabled="sending || phone.length < 11"
                                    @click="
                                        sending = true; smsMsg = ''; isError = false;
                                        fetch('/api/tv/magic-sms', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json' },
                                            body: JSON.stringify({ phone: phone, activation_code: window.currentActivationCode || '' })
                                        }).then(r => r.json()).then(data => {
                                            sending = false;
                                            if (data.success) {
                                                smsMsg = data.message;
                                                isError = false;
                                            } else {
                                                smsMsg = data.message || 'خطا در ارسال پیامک';
                                                isError = true;
                                            }
                                        }).catch(err => { sending = false; smsMsg = 'خطا در شبکه'; isError = true; });
                                    "
                                    class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 text-white font-bold text-xs disabled:opacity-50 transition-colors whitespace-nowrap cursor-pointer">
                                <span x-text="sending ? '...' : 'ارسال پیامک'"></span>
                            </button>
                        </div>
                        <p x-show="smsMsg" x-text="smsMsg" :class="isError ? 'text-rose-500' : 'text-emerald-500'" class="text-[10px] font-bold text-center leading-normal"></p>
                    </div>
                </div>

                {{-- پشتیبانی فنی فوری و تماس --}}
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

    </main>

    {{-- فوتر حداقلی تلویزیون --}}
    <footer class="w-full py-4 px-4 text-center text-[11px] text-slate-500 dark:text-slate-500 border-t border-slate-200/50 dark:border-slate-800/50">
        سامانه ابری تابلوی هوشمند طلالایو (TalaLive.ir) &copy; {{ date('Y') }} &middot; نسخه اختصاصی نمایشگر هوشمند تلویزیون
    </footer>

    {{-- اسکریپت جفت‌سازی هوشمند تلویزیون با پین عددی، چایم صوتی و ذخیره دائمی --}}
    <script>
        // پخش ملودی دلنشین موفقیت (Success Chime) با Web Audio API
        function playSuccessChime() {
            try {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                if (!AudioContext) return;
                const ctx = new AudioContext();
                const notes = [523.25, 659.25, 783.99, 1046.50]; // نوت‌های C5, E5, G5, C6
                notes.forEach((freq, idx) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.value = freq;
                    gain.gain.setValueAtTime(0.12, ctx.currentTime + idx * 0.12);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + idx * 0.12 + 0.38);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start(ctx.currentTime + idx * 0.12);
                    osc.stop(ctx.currentTime + idx * 0.12 + 0.4);
                });
            } catch (e) {
                console.log('Audio chime error:', e);
            }
        }

        document.addEventListener('DOMContentLoaded', async () => {
            // ۱. تولید شناسه سشن موقت
            const sessionCode = 'sess-' + Math.random().toString(36).substring(2, 10) + Math.random().toString(36).substring(2, 10);
            window.currentSessionCode = sessionCode;

            const activationCodeEl = document.getElementById('activationCode');
            const qrImage = document.getElementById('qrImage');
            const qrLoader = document.getElementById('qrLoader');

            // ۲. ثبت سشن در سرور و دریافت پین ۶ رقمی کاملاً عددی
            let activationCode = '';
            try {
                const regRes = await fetch('/api/tv/register-session', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ session_code: sessionCode })
                });
                const regData = await regRes.json();
                if (regData && regData.activation_code) {
                    activationCode = regData.activation_code;
                    window.currentActivationCode = activationCode;

                    // نمایش کد ۶ رقمی عددی با فاصله خوانا
                    if (activationCodeEl) {
                        activationCodeEl.innerText = activationCode.substring(0, 3) + ' ' + activationCode.substring(3, 6);
                    }

                    // ۳. ساخت لینک آدرس نهایی QR Code بر مبنای مسیر کوتاه جادویی /p/{code}
                    const magicPairUrl = window.location.origin + '/p/' + activationCode;
                    if (qrImage) {
                        qrImage.src = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&color=020617&data=' + encodeURIComponent(magicPairUrl);
                        qrImage.onload = () => {
                            if (qrLoader) qrLoader.style.display = 'none';
                        };
                    }
                }
            } catch (err) {
                console.error('Failed to register TV session:', err);
                const fallbackUrl = window.location.origin + '/admin/pair/' + sessionCode;
                if (qrImage) {
                    qrImage.src = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&color=020617&data=' + encodeURIComponent(fallbackUrl);
                    qrImage.onload = () => { if (qrLoader) qrLoader.style.display = 'none'; };
                }
            }

            // ۴. پولینگ وضعیت اتصال تلویزیون هر ۳ ثانیه
            let checkInterval = setInterval(async () => {
                try {
                    const res = await fetch('/api/tv/check/' + sessionCode);
                    if (!res.ok) return;
                    const data = await res.json();
                    
                    if (data.paired && data.username && data.display_token) {
                        clearInterval(checkInterval);
                        
                        // پخش چایم صوتی و نمایش پنجره جشن اتصال
                        playSuccessChime();
                        const overlay = document.getElementById('celebrationOverlay');
                        if (overlay) overlay.style.display = 'flex';
                        
                        // ذخیره پایدار در LocalStorage و Cookie تلویزیون
                        localStorage.setItem('display_username', data.username);
                        localStorage.setItem('display_token', data.display_token);
                        document.cookie = `display_token=${encodeURIComponent(data.display_token)}; path=/; max-age=31536000`;
                        
                        // انتقال نرم و مطمئن به تابلوی طلای زنده بعد از ۱.۶ ثانیه
                        setTimeout(() => {
                            window.location.href = '/' + data.username + '?key=' + data.display_token;
                        }, 1600);
                    }
                } catch (e) {
                    console.error('Pairing check error:', e);
                }
            }, 3000);
        });
    </script>
</body>
</html>
