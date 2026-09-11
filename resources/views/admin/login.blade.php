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

    <title>ورود به پنل تابلوی زنده | طلالایو</title>
    <meta name="description" content="ورود به پنل مدیریت تابلوی اختصاصی هوشمند طلا و سکه طلالایو.">
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
<body class="bg-slate-50 dark:bg-[#020617] text-slate-800 dark:text-slate-100 flex flex-col justify-between min-h-screen p-4 sm:p-6 transition-colors duration-300">

    {{-- ۱. سربرگ در بالاترین نقطه صفحه (Top) --}}
    <header class="w-full max-w-md mx-auto pt-1 sm:pt-3 shrink-0">
        <div class="flex items-center justify-between gap-3 px-1">
            <a href="/" class="flex items-center gap-2.5 group shrink-0">
                <img src="{{ asset('images/logo.png') }}" class="h-10 w-10 object-contain rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-1.5 shadow-xs" alt="طلالایو">
                <div>
                    <span class="text-sm sm:text-base font-black text-slate-900 dark:text-amber-400 group-hover:text-amber-600 transition-colors">طلالایو &middot; TalaLive</span>
                    <span class="block text-[11px] text-slate-500 dark:text-slate-400">پنل مدیریت تابلوی اختصاصی</span>
                </div>
            </a>

            <div class="flex items-center gap-2">
                {{-- دکمه تغییر تم دارک/لایت --}}
                <button type="button" id="themeToggleBtn" aria-label="تغییر تم"
                        class="w-10 h-10 rounded-2xl flex items-center justify-center border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all shadow-xs cursor-pointer">
                    <svg id="moonIcon" class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg id="sunIcon" class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                <a href="/" class="text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-amber-600 dark:hover:text-amber-400 transition-colors flex items-center gap-1.5 px-3.5 py-2.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                    <span>صفحه اصلی</span>
                    <span>&larr;</span>
                </a>
            </div>
        </div>
    </header>

    {{-- ۲. کارت فرم در بخش میانی با ارتفاع بلند، پدینگ دلباز و کادرهای استاندارد ارگونومیک --}}
    <main class="w-full max-w-md mx-auto my-auto py-5 sm:py-8 flex-1 flex flex-col justify-center">
        <div class="bg-white dark:bg-slate-900/95 border border-slate-200/90 dark:border-slate-800/80 rounded-3xl p-7 sm:p-9 shadow-xl space-y-6 sm:space-y-7 transition-all min-h-[460px] sm:min-h-[490px] flex flex-col justify-between">

            <div>
                {{-- پیام‌های موفقیت یا خطا سمت سرور --}}
                @if (session('success'))
                    <div class="mb-4 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-2xl p-4 text-xs flex items-center gap-2.5">
                        <span class="text-emerald-500 font-bold text-sm">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800/80 text-rose-700 dark:text-rose-300 rounded-2xl p-4 text-xs flex items-center gap-2.5">
                        <span class="text-rose-500 font-bold text-sm">⚠️</span>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- کادرهای آلرت ایجکس پیامک --}}
                <div id="otpSuccessAlert" class="hidden mb-4 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-2xl p-3.5 text-xs items-center gap-2">
                    <span class="text-emerald-500 font-bold">✓</span>
                    <span id="otpSuccessText"></span>
                </div>

                <div id="otpErrorAlert" class="hidden mb-4 bg-rose-50 dark:bg-rose-950/50 border border-rose-300 dark:border-rose-800 text-rose-800 dark:text-rose-300 rounded-2xl p-3.5 text-xs items-center gap-2">
                    <span class="text-rose-500 font-bold">✕</span>
                    <span id="otpErrorText"></span>
                </div>

                @php
                    $initialMode = ($errors->has('otp') || old('otp') || (old('phone') && !$errors->has('email'))) ? 'otp' : 'password';
                @endphp

                {{-- ۲-۱. فرم اصلی: ورود با رمز عبور --}}
                <div id="passwordSection" class="space-y-5 {{ $initialMode === 'password' ? '' : 'hidden' }}">
                    <div class="pb-1">
                        <h1 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">ورود به پنل مدیریت</h1>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">شماره موبایل یا نام کاربری و رمز عبور خود را وارد نمایید.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.login') }}" class="space-y-4 sm:space-y-5" id="passwordLoginForm">
                        @csrf
                        
                        {{-- شماره موبایل یا نام کاربری --}}
                        <div class="space-y-2">
                            <label for="loginEmailInput" class="block text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200">
                                شماره موبایل یا نام کاربری
                            </label>
                            <input type="text" name="email" id="loginEmailInput" required
                                   style="height: 60px; min-height: 60px; font-size: 1.05rem;"
                                   class="w-full bg-white dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 rounded-2xl px-4 font-normal text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 transition-all text-left shadow-xs" dir="ltr"
                                   placeholder="09187009064 یا نام کاربری" value="{{ old('email') }}"
                                   autocomplete="username">
                        </div>

                        {{-- رمز عبور با آیکون چشم ثابت در سمت راست داخل کادر --}}
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="loginPasswordInput" class="block text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200">
                                    رمز عبور
                                </label>
                                <span class="text-[11px] text-slate-400 font-normal">حداقل ۴ کاراکتر</span>
                            </div>
                            <div class="relative w-full" style="position: relative; width: 100%;">
                                <input type="password" name="password" id="loginPasswordInput" required minlength="4"
                                       style="height: 60px; min-height: 60px; font-size: 1.05rem; padding-right: 50px; padding-left: 16px;"
                                       class="w-full bg-white dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 rounded-2xl font-normal text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 transition-all text-left font-mono shadow-xs" dir="ltr"
                                       placeholder="رمز عبور شما">
                                <button type="button" id="togglePasswordBtn" aria-label="نمایش یا پنهان‌سازی رمز"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); z-index: 20; background: transparent; border: none; display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; cursor: pointer;"
                                        class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                        </div>

                        {{-- لینک فراموشی رمز عبور --}}
                        <div class="flex items-center justify-between pt-1">
                            <button type="button" id="forgotPasswordLink"
                                    class="text-xs sm:text-sm font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 hover:underline cursor-pointer flex items-center gap-1.5 py-1">
                                <span>🔑</span>
                                <span>رمز عبور را فراموش کرده‌اید؟ (بازیابی با پیامک)</span>
                            </button>
                        </div>

                        {{-- دکمه ورود --}}
                        <button type="submit"
                                style="height: 58px; min-height: 58px;"
                                class="w-full rounded-2xl bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-base shadow-lg shadow-amber-500/25 active:scale-[0.99] transition-all cursor-pointer flex items-center justify-center gap-2 mt-3">
                            <span>ورود به پنل کاربری تابلو</span>
                            <span>&larr;</span>
                        </button>
                    </form>
                </div>

                {{-- ۲-۲. فرم فراموشی رمز عبور و تنظیم رمز جدید با تأیید پیامک --}}
                <div id="otpSection" class="space-y-5 {{ $initialMode === 'otp' ? '' : 'hidden' }}">
                    <div class="pb-1">
                        <h2 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <span>فراموشی و تغییر رمز عبور</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                            شماره موبایل حساب خود را وارد کنید تا کد تأیید ارسال شود و رمز عبور دلخواه جدیدتان را تعیین کنید.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('admin.login.otp') }}" id="otpLoginForm" class="space-y-4 sm:space-y-5">
                        @csrf
                        
                        {{-- شماره موبایل با ارتفاع زیاد و استاندارد (۶۲ پیکسل) و دکمه ارسال پیامک --}}
                        <div class="space-y-2">
                            <label for="loginPhoneInput" class="block text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200">
                                شماره موبایل
                            </label>
                            <div class="flex flex-col gap-3">
                                <input type="tel" name="phone" id="loginPhoneInput" required
                                       style="height: 62px; min-height: 62px; font-size: 1.15rem;"
                                       class="w-full bg-white dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 rounded-2xl px-5 text-slate-900 dark:text-white font-mono text-center placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 transition-all font-normal shadow-xs tracking-wider"
                                       dir="ltr" placeholder="09187009064" maxlength="11" value="{{ old('phone') }}"
                                       autocomplete="tel" inputmode="numeric">
                                
                                <button type="button" id="sendLoginOtpBtn"
                                        style="height: 56px; min-height: 56px;"
                                        class="w-full rounded-2xl text-sm font-black transition-all cursor-pointer bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md shadow-amber-500/20 flex items-center justify-center gap-1.5 active:scale-[0.99]">
                                    <span id="loginOtpBtnText">ارسال کد پیامکی</span>
                                </button>
                            </div>
                        </div>

                        {{-- کادر ورود کد ۵ رقمی و رمز جدید (پس از ارسال کد باز می‌شود) --}}
                        <div id="otpInputContainer" class="space-y-4 {{ (old('otp') || old('phone')) ? '' : 'hidden' }} pt-2">
                            
                            {{-- کد ۵ رقمی پیامک شده --}}
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="loginOtpInput" class="block text-xs sm:text-sm font-semibold text-amber-700 dark:text-amber-400">
                                        کد تأیید ۵ رقمی پیامک‌شده:
                                    </label>
                                    <span id="countdownTimer" class="text-xs font-mono font-bold text-amber-600 dark:text-amber-400"></span>
                                </div>
                                <input type="text" name="otp" id="loginOtpInput" maxlength="5" inputmode="numeric"
                                       style="height: 62px; min-height: 62px;"
                                       class="w-full bg-white dark:bg-slate-950 border-2 border-amber-500/80 rounded-2xl px-4 text-center text-2xl sm:text-3xl font-bold tracking-widest text-amber-600 dark:text-amber-400 font-mono placeholder-slate-300 focus:outline-none focus:ring-4 focus:ring-amber-500/20 shadow-xs"
                                       placeholder="-----" autocomplete="one-time-code" value="{{ old('otp') }}">
                            </div>

                            {{-- فیلد رمز عبور جدید --}}
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="newPasswordInput" class="block text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200">
                                        رمز عبور جدید دلخواه شما
                                    </label>
                                    <span class="text-[11px] text-slate-400 font-normal">شروع از ۴ کاراکتر</span>
                                </div>
                                <div class="relative w-full" style="position: relative; width: 100%;">
                                    <input type="password" name="password" id="newPasswordInput" required minlength="4"
                                           style="height: 60px; min-height: 60px; font-size: 1.05rem; padding-right: 50px; padding-left: 16px;"
                                           class="w-full bg-white dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 rounded-2xl font-normal text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 transition-all text-left font-mono shadow-xs" dir="ltr"
                                           placeholder="رمز جدید دلخواه شما">
                                    <button type="button" id="toggleNewPasswordBtn" aria-label="نمایش یا پنهان‌سازی رمز جدید"
                                            style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); z-index: 20; background: transparent; border: none; display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; cursor: pointer;"
                                            class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                        <svg id="newEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg id="newEyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                    </button>
                                </div>
                            </div>
                            
                            <button type="submit" id="loginOtpSubmitBtn"
                                    style="height: 58px; min-height: 58px;"
                                    class="w-full rounded-2xl bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-base shadow-xl shadow-amber-500/20 transition-all active:scale-[0.99] cursor-pointer mt-2 flex items-center justify-center gap-2">
                                <span>تغییر رمز عبور و ورود به پنل</span>
                                <span>&larr;</span>
                            </button>
                        </div>

                        {{-- دکمه بازگشت به ورود با رمز عبور --}}
                        <div class="pt-2 text-center">
                            <button type="button" id="backToPasswordBtn"
                                    class="text-xs sm:text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors cursor-pointer inline-flex items-center gap-1.5 py-1">
                                <span>&rarr;</span>
                                <span>بازگشت به فرم ورود با رمز عبور</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- لینک ثبت‌نام در انتهای کارت --}}
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800/80 text-center text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                <span>هنوز تابلوی خود را فعال نکرده‌اید؟</span>
                <a href="{{ route('admin.register') }}" class="font-bold text-amber-600 dark:text-amber-400 hover:underline mr-1">
                    ثبت‌نام و ۱۴ روز تست رایگان
                </a>
            </div>

        </div>
    </main>

    {{-- ۳. فوتر در پایین‌ترین نقطه صفحه (Bottom) --}}
    <footer class="w-full max-w-md mx-auto pb-1 sm:pb-3 shrink-0 space-y-2 text-center">
        <div class="flex items-center justify-center gap-3 text-xs text-slate-500 dark:text-slate-400 flex-wrap px-2">
            <span>پشتیبانی فنی:</span>
            <a href="tel:09187009064" class="inline-flex items-center gap-1 text-slate-700 dark:text-slate-200 hover:text-amber-600 dark:hover:text-amber-400 transition-colors font-bold">
                <span>📞</span>
                <span dir="ltr" class="font-mono text-sm">0918 700 9064</span>
            </a>
            <span class="text-slate-300 dark:text-slate-700">&bull;</span>
            <a href="https://rubika.ir/talalive" target="_blank" class="inline-flex items-center gap-1.5 text-indigo-600 dark:text-indigo-400 hover:underline font-bold">
                <img src="/images/logos/rubika.png" onerror="this.src='/icons/icon-72x72.png'" class="w-3.5 h-3.5 object-contain rounded-xs" alt="روبیکا">
                <span>پشتیبانی روبیکا</span>
            </a>
        </div>

        <div class="text-[11px] text-slate-400">
            سامانه ابری تابلوی هوشمند طلالایو &copy; {{ date('Y') }}
        </div>
    </footer>

    {{-- اسکریپت‌های تعاملی --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const otpSection = document.getElementById('otpSection');
            const passwordSection = document.getElementById('passwordSection');
            const forgotPasswordLink = document.getElementById('forgotPasswordLink');
            const backToPasswordBtn = document.getElementById('backToPasswordBtn');
            
            const sendLoginOtpBtn = document.getElementById('sendLoginOtpBtn');
            const loginPhoneInput = document.getElementById('loginPhoneInput');
            const loginEmailInput = document.getElementById('loginEmailInput');
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
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            const toggleNewPasswordBtn = document.getElementById('toggleNewPasswordBtn');
            const newPasswordInput = document.getElementById('newPasswordInput');
            const newEyeIcon = document.getElementById('newEyeIcon');
            const newEyeSlashIcon = document.getElementById('newEyeSlashIcon');

            // ۱. تم
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('talalive_theme', isDark ? 'dark' : 'light');
                });
            }

            // ۲. تغییر نما بین ورود با رمز و فراموشی رمز
            function showOtpSection() {
                if (passwordSection) passwordSection.classList.add('hidden');
                if (otpSection) otpSection.classList.remove('hidden');
                
                // در صورت وجود شماره در فرم قبلی، به فیلد موبایل انتقال می‌یابد
                if (loginEmailInput && loginEmailInput.value) {
                    const val = loginEmailInput.value.trim();
                    if (/^09\d{9}$/.test(val) && loginPhoneInput && !loginPhoneInput.value) {
                        loginPhoneInput.value = val;
                    }
                }
                if (loginPhoneInput && !loginPhoneInput.value) {
                    loginPhoneInput.focus();
                }
            }

            function showPasswordSection() {
                if (otpSection) otpSection.classList.add('hidden');
                if (passwordSection) passwordSection.classList.remove('hidden');
                
                if (loginPhoneInput && loginPhoneInput.value && loginEmailInput && !loginEmailInput.value) {
                    loginEmailInput.value = loginPhoneInput.value.trim();
                }
            }

            if (forgotPasswordLink) forgotPasswordLink.addEventListener('click', showOtpSection);
            if (backToPasswordBtn) backToPasswordBtn.addEventListener('click', showPasswordSection);

            // ۳. دکمه مشاهده رمز عبور اصلی
            if (togglePasswordBtn && loginPasswordInput) {
                togglePasswordBtn.addEventListener('click', () => {
                    const isPass = loginPasswordInput.type === 'password';
                    loginPasswordInput.type = isPass ? 'text' : 'password';
                    if (eyeIcon && eyeSlashIcon) {
                        eyeIcon.classList.toggle('hidden', isPass);
                        eyeSlashIcon.classList.toggle('hidden', !isPass);
                    }
                });
            }

            // ۴. دکمه مشاهده رمز عبور جدید
            if (toggleNewPasswordBtn && newPasswordInput) {
                toggleNewPasswordBtn.addEventListener('click', () => {
                    const isPass = newPasswordInput.type === 'password';
                    newPasswordInput.type = isPass ? 'text' : 'password';
                    if (newEyeIcon && newEyeSlashIcon) {
                        newEyeIcon.classList.toggle('hidden', isPass);
                        newEyeSlashIcon.classList.toggle('hidden', !isPass);
                    }
                });
            }

            // ۵. تایمر معکوس ارسال پیامک
            let timerInterval = null;
            function startCountdown(duration) {
                let timeLeft = duration;
                if (!sendLoginOtpBtn) return;
                sendLoginOtpBtn.disabled = true;
                sendLoginOtpBtn.classList.add('opacity-50', 'cursor-not-allowed');

                clearInterval(timerInterval);
                timerInterval = setInterval(() => {
                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        if (countdownTimer) countdownTimer.textContent = '';
                        if (loginOtpBtnText) loginOtpBtnText.textContent = 'ارسال مجدد کد';
                        sendLoginOtpBtn.disabled = false;
                        sendLoginOtpBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        if (countdownTimer) countdownTimer.textContent = `ارسال مجدد تا ${timeLeft} ثانیه`;
                        if (loginOtpBtnText) loginOtpBtnText.textContent = `${timeLeft} ثانیه`;
                        timeLeft--;
                    }
                }, 1000);
            }

            // ۶. درخواست ارسال پیامک OTP
            if (sendLoginOtpBtn) {
                sendLoginOtpBtn.addEventListener('click', async () => {
                    const phone = loginPhoneInput.value.trim();
                    if (otpSuccessAlert) otpSuccessAlert.classList.add('hidden');
                    if (otpErrorAlert) otpErrorAlert.classList.add('hidden');

                    if (!phone || phone.length < 10) {
                        if (otpErrorText) otpErrorText.textContent = 'لطفاً شماره موبایل ۱۱ رقمی خود را وارد فرمایید.';
                        if (otpErrorAlert) otpErrorAlert.classList.remove('hidden');
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
                            if (otpSuccessText) otpSuccessText.textContent = data.message;
                            if (otpSuccessAlert) otpSuccessAlert.classList.remove('hidden');
                            if (otpInputContainer) otpInputContainer.classList.remove('hidden');
                            if (loginOtpInput) loginOtpInput.focus();
                            startCountdown(60);
                        } else {
                            if (otpErrorText) otpErrorText.textContent = data.message || 'خطا در ارسال پیامک.';
                            if (otpErrorAlert) otpErrorAlert.classList.remove('hidden');
                            loginOtpBtnText.textContent = 'ارسال کد پیامکی';
                            sendLoginOtpBtn.disabled = false;
                        }
                    } catch (err) {
                        if (otpErrorText) otpErrorText.textContent = 'خطا در ارتباط با سرور. لطفاً مجدداً تلاش فرمایید.';
                        if (otpErrorAlert) otpErrorAlert.classList.remove('hidden');
                        loginOtpBtnText.textContent = 'ارسال کد پیامکی';
                        sendLoginOtpBtn.disabled = false;
                    }
                });
            }
        });
    </script>
</body>
</html>
