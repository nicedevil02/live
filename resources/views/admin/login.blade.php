<!DOCTYPE html>
<html lang="fa" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- اسکریپت تشخیص آنی تم روشن (پیش‌فرض) و تاریک --}}
    <script>
        (function() {
            const savedTheme = localStorage.getItem('talalive_theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <title>ورود طلافروشان به پنل تابلوی زنده | طلالایو</title>
    <meta name="description" content="ورود به پنل مدیریت تابلوی اختصاصی هوشمند طلا و سکه طلالایو با شماره موبایل یا رمز عبور.">
    <meta name="robots" content="noindex, follow">

    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    @vite('resources/css/app.css')

    <style>
        body { font-family: Vazirmatn, ui-sans-serif, system-ui, sans-serif; }
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: inherit;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#020617] text-slate-800 dark:text-slate-100 flex flex-col justify-between min-h-screen py-6 sm:py-10 px-4 transition-colors duration-300">

    <div class="w-full max-w-md mx-auto my-auto space-y-4 sm:space-y-5">

        {{-- سربرگ بالا: لوگو، دکمه تغییر تم و بازگشت به صفحه اصلی --}}
        <div class="flex items-center justify-between gap-3 px-1">
            <a href="/" class="flex items-center gap-2.5 group shrink-0">
                <img src="{{ asset('images/logo.png') }}" class="h-9 w-9 object-contain rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700/60 p-1 shadow-sm" alt="طلالایو">
                <div>
                    <span class="text-sm font-black text-slate-900 dark:text-amber-400 group-hover:text-amber-600 transition-colors">طلالایو &middot; TalaLive</span>
                    <span class="block text-[10px] text-slate-500 dark:text-slate-400">ورود طلافروشان به پنل تابلوی زنده</span>
                </div>
            </a>

            <div class="flex items-center gap-2">
                {{-- دکمه تغییر تم دارک/لایت --}}
                <button type="button" id="themeToggleBtn" aria-label="تغییر تم"
                        class="w-9 h-9 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all shadow-sm cursor-pointer">
                    <svg id="moonIcon" class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg id="sunIcon" class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                <a href="/" class="text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors flex items-center gap-1 px-2.5 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <span>صفحه اصلی</span>
                    <span>&larr;</span>
                </a>
            </div>
        </div>

        {{-- کارت فرم ورود --}}
        <div class="bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800/80 rounded-3xl p-5 sm:p-7 shadow-xl dark:shadow-2xl space-y-4 transition-all">

            {{-- نمایش پیام‌های موفقیت یا خطا سمت سرور --}}
            @if (session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-2xl p-3.5 text-xs flex items-center gap-2">
                    <span class="text-emerald-500 font-bold">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800/80 text-rose-700 dark:text-rose-300 rounded-2xl p-3.5 text-xs flex items-center gap-2">
                    <span class="text-rose-500 font-bold">⚠️</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- کادرهای آلرت ایجکس پیامک --}}
            <div id="otpSuccessAlert" class="hidden bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl p-3 text-xs items-center gap-2">
                <span class="text-emerald-500 font-bold">✓</span>
                <span id="otpSuccessText"></span>
            </div>

            <div id="otpErrorAlert" class="hidden bg-rose-50 dark:bg-rose-950/50 border border-rose-300 dark:border-rose-800 text-rose-800 dark:text-rose-300 rounded-xl p-3 text-xs items-center gap-2">
                <span class="text-rose-500 font-bold">✕</span>
                <span id="otpErrorText"></span>
            </div>

            {{-- تب‌های انتخاب روش ورود (دوگانه) --}}
            <div class="flex items-center p-1 rounded-2xl bg-slate-100 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800">
                <button type="button" id="tabOtpBtn"
                        class="flex-1 py-2 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center justify-center gap-1.5 bg-white dark:bg-slate-800 text-amber-700 dark:text-amber-400 shadow-sm">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <span>ورود سریع با پیامک</span>
                </button>
                <button type="button" id="tabPasswordBtn"
                        class="flex-1 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    <span>ورود با رمز عبور</span>
                </button>
            </div>

            {{-- ۱. فرم ورود با کد پیامکی (روش پیش‌فرض و ساده بدون نیاز به حفظ رمز) --}}
            <div id="otpSection" class="space-y-3.5">
                <form method="POST" action="{{ route('admin.login.otp') }}" id="otpLoginForm" class="space-y-3.5">
                    @csrf
                    
                    {{-- مرحله ۱: شماره موبایل --}}
                    <div class="space-y-1.5">
                        <label for="loginPhoneInput" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                            شماره موبایل طلافروش
                        </label>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <input type="tel" name="phone" id="loginPhoneInput" required
                                   class="flex-1 h-11 bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-4 text-sm text-slate-900 dark:text-white font-mono text-left placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all"
                                   dir="ltr" placeholder="09187009064" maxlength="11" value="{{ old('phone') }}"
                                   autocomplete="tel" inputmode="numeric">
                            
                            <button type="button" id="sendLoginOtpBtn"
                                    class="h-11 px-4 rounded-xl text-xs font-black transition-all shrink-0 cursor-pointer bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md shadow-amber-500/20 flex items-center justify-center gap-1.5">
                                <span id="loginOtpBtnText">ارسال کد پیامکی</span>
                            </button>
                        </div>
                    </div>

                    {{-- مرحله ۲: کادر کد ۵ رقمی (پس از زدن دکمه فعال می‌شود) --}}
                    <div id="otpInputContainer" class="space-y-1.5 hidden">
                        <div class="flex items-center justify-between">
                            <label for="loginOtpInput" class="block text-xs font-bold text-amber-700 dark:text-amber-400">
                                کد ۵ رقمی پیامک‌شده:
                            </label>
                            <span id="countdownTimer" class="text-[11px] font-mono font-bold text-amber-600 dark:text-amber-400"></span>
                        </div>
                        <input type="text" name="otp" id="loginOtpInput" maxlength="5" inputmode="numeric"
                               class="w-full h-12 bg-white dark:bg-slate-950 border border-amber-500/50 rounded-xl px-4 text-center text-2xl font-black tracking-widest text-amber-600 dark:text-amber-400 font-mono placeholder-slate-300 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500"
                               placeholder="-----" autocomplete="one-time-code">
                        
                        <button type="submit" id="loginOtpSubmitBtn"
                                class="w-full h-12 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/20 transition-all hover:scale-[1.01] cursor-pointer mt-2 flex items-center justify-center gap-1.5">
                            <span>تأیید و ورود به پنل تابلو</span>
                            <span>&larr;</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- ۲. فرم ورود با رمز عبور (کلاسیک) --}}
            <div id="passwordSection" class="space-y-3.5 hidden">
                <form method="POST" action="{{ route('admin.login') }}" class="space-y-3.5">
                    @csrf
                    <div>
                        <label for="loginEmailInput" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            شماره موبایل یا نام کاربری
                        </label>
                        <input type="text" name="email" id="loginEmailInput" required
                               class="w-full h-11 bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-4 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all"
                               placeholder="مثال: 09187009064 یا نام کاربری" value="{{ old('email') }}">
                    </div>

                    <div class="space-y-1.5">
                        <label for="loginPasswordInput" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                            رمز عبور
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="loginPasswordInput" required
                                   class="w-full h-11 bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-4 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all"
                                   placeholder="رمز عبور شما">
                            <button type="button" id="togglePasswordBtn" class="absolute left-3 top-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full h-11 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-sm shadow-md shadow-amber-500/20 transition-all cursor-pointer mt-1">
                        ورود به پنل با رمز عبور
                    </button>
                </form>
            </div>

            {{-- لینک ثبت‌نام --}}
            <div class="pt-3.5 border-t border-slate-200 dark:border-slate-800 text-center text-xs text-slate-600 dark:text-slate-400">
                <span>هنوز تابلوی گالری‌تان را فعال نکرده‌اید؟</span>
                <a href="{{ route('admin.register') }}" class="font-bold text-amber-600 dark:text-amber-400 hover:underline mr-1">
                    ثبت‌نام و ۷ روز تست رایگان
                </a>
            </div>

            {{-- بخش پشتیبانی فنی طلالایو و روبیکا --}}
            <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-3 text-center space-y-2">
                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold">
                    ورود یا تنظیمات براتون سخته؟ با ما در ارتباط باشید:
                </p>
                <div class="flex items-center justify-center gap-2 flex-wrap">
                    <a href="tel:09187009064" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold hover:border-amber-500 transition-all">
                        <span>📞 پشتیبانی فنی طلالایو:</span>
                        <span class="font-mono text-amber-600 dark:text-amber-400" dir="ltr">0918 700 9064</span>
                    </a>
                    <a href="https://rubika.ir/talalive" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white text-xs font-bold shadow-sm transition-all">
                        <img src="/images/logos/rubika.png" onerror="this.src='/icons/icon-72x72.png'" class="w-4 h-4 object-contain rounded-md" alt="روبیکا">
                        <span>پشتیبانی روبیکا</span>
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- فوتر کپی‌رایت --}}
    <div class="text-center text-[11px] text-slate-400 py-3">
        سامانه ابری تابلوی هوشمند طلالایو &copy; {{ date('Y') }}
    </div>

    {{-- اسکریپت تعاملی --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const tabOtpBtn = document.getElementById('tabOtpBtn');
            const tabPasswordBtn = document.getElementById('tabPasswordBtn');
            const otpSection = document.getElementById('otpSection');
            const passwordSection = document.getElementById('passwordSection');
            
            const sendLoginOtpBtn = document.getElementById('sendLoginOtpBtn');
            const loginPhoneInput = document.getElementById('loginPhoneInput');
            const loginOtpBtnText = document.getElementById('loginOtpBtnText');
            const otpInputContainer = document.getElementById('otpInputContainer');
            const loginOtpInput = document.getElementById('loginOtpInput');
            const countdownTimer = document.getElementById('countdownTimer');
            
            const otpSuccessAlert = document.getElementById('otpSuccessAlert');
            const otpSuccessText = document.getElementById('otpSuccessText');
            const otpErrorAlert = document.getElementById('otpErrorAlert');
            const otpErrorText = document.getElementById('otpErrorText');
            
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const loginPasswordInput = document.getElementById('loginPasswordInput');

            // ۱. تم
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('talalive_theme', isDark ? 'dark' : 'light');
                });
            }

            // ۲. تب‌های ورود
            function switchTab(mode) {
                if (mode === 'otp') {
                    tabOtpBtn.className = "flex-1 py-2 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center justify-center gap-1.5 bg-white dark:bg-slate-800 text-amber-700 dark:text-amber-400 shadow-sm";
                    tabPasswordBtn.className = "flex-1 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200";
                    otpSection.classList.remove('hidden');
                    passwordSection.classList.add('hidden');
                } else {
                    tabPasswordBtn.className = "flex-1 py-2 rounded-xl text-xs font-black transition-all cursor-pointer flex items-center justify-center gap-1.5 bg-white dark:bg-slate-800 text-amber-700 dark:text-amber-400 shadow-sm";
                    tabOtpBtn.className = "flex-1 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center justify-center gap-1.5 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200";
                    passwordSection.classList.remove('hidden');
                    otpSection.classList.add('hidden');
                }
            }

            tabOtpBtn.addEventListener('click', () => switchTab('otp'));
            tabPasswordBtn.addEventListener('click', () => switchTab('password'));

            // ۳. مشاهده رمز عبور
            if (togglePasswordBtn) {
                togglePasswordBtn.addEventListener('click', () => {
                    const isPass = loginPasswordInput.type === 'password';
                    loginPasswordInput.type = isPass ? 'text' : 'password';
                });
            }

            // ۴. ارسال کد ورود پیامکی
            let timerInterval = null;
            function startCountdown(duration) {
                let timeLeft = duration;
                sendLoginOtpBtn.disabled = true;
                sendLoginOtpBtn.classList.add('opacity-50', 'cursor-not-allowed');

                clearInterval(timerInterval);
                timerInterval = setInterval(() => {
                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        countdownTimer.textContent = '';
                        loginOtpBtnText.textContent = 'ارسال مجدد کد';
                        sendLoginOtpBtn.disabled = false;
                        sendLoginOtpBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        countdownTimer.textContent = `ارسال مجدد تا ${timeLeft} ثانیه`;
                        loginOtpBtnText.textContent = `${timeLeft} ثانیه`;
                        timeLeft--;
                    }
                }, 1000);
            }

            sendLoginOtpBtn.addEventListener('click', async () => {
                const phone = loginPhoneInput.value.trim();
                otpSuccessAlert.classList.add('hidden');
                otpErrorAlert.classList.add('hidden');

                if (!phone || phone.length < 10) {
                    otpErrorText.textContent = 'لطفاً شماره موبایل ۱۱ رقمی خود را وارد فرمایید.';
                    otpErrorAlert.classList.remove('hidden');
                    loginPhoneInput.focus();
                    return;
                }

                loginOtpBtnText.textContent = 'در حال ارسال...';
                sendLoginOtpBtn.disabled = true;

                try {
                    const response = await fetch("{{ route('admin.login.send-otp') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ phone })
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        otpSuccessText.textContent = data.message;
                        otpSuccessAlert.classList.remove('hidden');
                        otpInputContainer.classList.remove('hidden');
                        loginOtpInput.focus();
                        startCountdown(60);
                    } else {
                        otpErrorText.textContent = data.message || 'خطا در ارسال پیامک.';
                        otpErrorAlert.classList.remove('hidden');
                        loginOtpBtnText.textContent = 'ارسال کد پیامکی';
                        sendLoginOtpBtn.disabled = false;
                    }
                } catch (err) {
                    otpErrorText.textContent = 'خطا در ارتباط با سرور. لطفاً مجدداً تلاش فرمایید.';
                    otpErrorAlert.classList.remove('hidden');
                    loginOtpBtnText.textContent = 'ارسال کد پیامکی';
                    sendLoginOtpBtn.disabled = false;
                }
            });
        });
    </script>
</body>
</html>
