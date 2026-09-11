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

    <title>ثبت‌نام طلافروشی جدید و فعال‌سازی تست رایگان ۱۴ روزه | طلالایو</title>
    <meta name="description" content="ثبت‌نام و راه‌اندازی فوری تابلوی اختصاصی هوشمند نرخ طلا و سکه برای گالری طلافروشی در سامانه طلالایو. ۱۴ روز استفاده آزمایشی کاملاً رایگان بدون نیاز به پرداخت.">
    <meta name="robots" content="noindex, follow">

    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    @vite('resources/css/app.css')

    <style>
        body { font-family: Vazirmatn, ui-sans-serif, system-ui, sans-serif; }
        /* جلوگیری از پس‌زمینه زرد رنگ خودکار مرورگر کروم برای فیلدهای اتوفیل */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: inherit;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#020617] text-slate-800 dark:text-slate-100 flex flex-col justify-between min-h-screen py-8 sm:py-12 px-4 transition-colors duration-300">

    <div class="w-full max-w-lg mx-auto my-auto space-y-6">

        {{-- سربرگ بالا: لوگو، دکمه تغییر تم و بازگشت به صفحه اصلی --}}
        <div class="flex items-center justify-between gap-3 px-1">
            <a href="/" class="flex items-center gap-2.5 group shrink-0">
                <img src="{{ asset('images/logo.png') }}" class="h-9 w-9 object-contain rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700/60 p-1 shadow-sm" alt="طلالایو">
                <div>
                    <span class="text-sm font-black text-slate-900 dark:text-amber-400 group-hover:text-amber-600 transition-colors">طلالایو &middot; TalaLive</span>
                    <span class="block text-[10px] text-slate-500 dark:text-slate-400">سامانه تابلوی هوشمند طلافروشی</span>
                </div>
            </a>

            <div class="flex items-center gap-2">
                {{-- دکمه تغییر تم دارک/لایت --}}
                <button type="button" id="themeToggleBtn" aria-label="تغییر تم"
                        class="w-9 h-9 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all shadow-sm cursor-pointer">
                    {{-- آیکون ماه (برای لایت مود) --}}
                    <svg id="moonIcon" class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    {{-- آیکون خورشید (برای دارک مود) --}}
                    <svg id="sunIcon" class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                <a href="/" class="text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors flex items-center gap-1 px-2.5 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <span>صفحه اصلی</span>
                    <span>&larr;</span>
                </a>
            </div>
        </div>

        {{-- کارت شیشه‌ای فرم ثبت نام --}}
        <div class="bg-white dark:bg-slate-900/95 border border-slate-200/80 dark:border-slate-800/80 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6 transition-all">
            
            {{-- بنر برجسته دوره تست ۱۴ روزه رایگان --}}
            <div class="bg-gradient-to-r from-amber-500/15 via-amber-500/5 to-amber-500/10 dark:from-amber-500/20 dark:via-slate-900 dark:to-amber-500/10 border border-amber-500/30 rounded-2xl p-4 flex items-center gap-3.5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/30 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-lg shrink-0">
                    🎁
                </div>
                <div>
                    <h1 class="text-xs sm:text-sm font-black text-amber-700 dark:text-amber-300">۱۴ روز استفاده آزمایشی و کاملاً رایگان</h1>
                    <p class="text-[11px] text-slate-600 dark:text-slate-300 leading-relaxed mt-0.5">
                        بدون نیاز به پرداخت یا کارت بانکی، تابلوی گالری‌تان را بلافاصله روی تلویزیون فعال کرده و تست کنید.
                    </p>
                </div>
            </div>

            {{-- نمایش خطاهای اعتبارسنجی سمت سرور --}}
            @if ($errors->any())
                <div class="bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800/80 text-rose-700 dark:text-rose-300 rounded-2xl p-4 text-xs space-y-1">
                    <div class="font-bold flex items-center gap-1.5 text-rose-600 dark:text-rose-400">
                        <span>⚠️ لطفاً موارد زیر را بررسی فرمایید:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 pr-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- کادرهای هشدار وضعیت پیامک (ایجکس) --}}
            <div id="otpSuccessAlert" class="hidden bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl p-3 text-xs items-center gap-2">
                <span class="text-emerald-500 font-bold">✓</span>
                <span id="otpSuccessText"></span>
            </div>

            <div id="otpErrorAlert" class="hidden bg-rose-50 dark:bg-rose-950/50 border border-rose-300 dark:border-rose-800 text-rose-800 dark:text-rose-300 rounded-xl p-3 text-xs items-center gap-2">
                <span class="text-rose-500 font-bold">✕</span>
                <span id="otpErrorText"></span>
            </div>

            {{-- فرم اصلی ثبت نام (ساده‌سازی شده در ۲ مرحله بدون نیاز به اسلاگ انگلیسی و تکرار پسورد) --}}
            <form method="POST" action="{{ route('admin.register') }}" class="space-y-4" id="registerForm">
                @csrf

                {{-- مرحله ۱: شماره موبایل طلافروش و ارسال پیامک --}}
                <div class="space-y-1.5">
                    <label for="phoneInput" class="block text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        ۱. شماره موبایل طلافروش
                    </label>
                    <div class="flex flex-col sm:flex-row gap-2.5">
                        <div class="relative flex-1">
                            <input type="tel" name="phone" id="phoneInput" required
                                   class="w-full h-13 sm:h-14 bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-2xl px-4 text-base sm:text-lg text-slate-900 dark:text-white font-mono text-center sm:text-left placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all font-bold tracking-wider"
                                   dir="ltr" placeholder="09187009064" maxlength="11" value="{{ old('phone') }}"
                                   autocomplete="tel" inputmode="numeric">
                        </div>
                        
                        <button type="button" id="sendOtpBtn"
                                class="h-13 sm:h-14 px-5 rounded-2xl text-xs sm:text-sm font-black transition-all shrink-0 cursor-pointer bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md shadow-amber-500/20 flex items-center justify-center gap-1.5">
                            <span id="btnText">ارسال کد پیامکی</span>
                        </button>
                    </div>
                </div>

                {{-- مرحله ۲: کد تأیید ۵ رقمی پیامک --}}
                <div class="space-y-2 bg-amber-500/5 dark:bg-slate-950/40 p-4 rounded-2xl border border-amber-500/20 dark:border-slate-800">
                    <div class="flex items-center justify-between">
                        <label for="otpInput" class="block text-xs sm:text-sm font-bold text-amber-700 dark:text-amber-400">
                            ۲. کد ۵ رقمی پیامک‌شده:
                        </label>
                        <span id="otpStatusHint" class="text-[11px] text-slate-500 dark:text-slate-400">کد به موبایل شما پیامک می‌شود</span>
                    </div>
                    <input type="text" name="otp" id="otpInput" required maxlength="5" inputmode="numeric"
                           class="w-full h-14 bg-white dark:bg-slate-950 border-2 border-amber-500/50 rounded-2xl px-4 text-center text-3xl font-black tracking-widest text-amber-600 dark:text-amber-400 font-mono placeholder-slate-300 dark:placeholder-slate-700 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/30"
                           placeholder="-----" value="{{ old('otp') }}" autocomplete="one-time-code">
                </div>

                {{-- نام طلافروشی / گالری --}}
                <div class="space-y-1.5">
                    <label for="shopNameInput" class="block text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        ۳. نام گالری یا طلافروشی شما
                    </label>
                    <input type="text" name="name" id="shopNameInput" required
                           class="w-full h-13 sm:h-14 bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-2xl px-4 text-base sm:text-lg font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all"
                           placeholder="مثال: گالری طلای کیمیا" value="{{ old('name') }}" autocomplete="off">
                </div>

                {{-- رمز عبور ساده با آیکون چشم --}}
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="passwordInput" class="block text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                            ۴. رمز عبور انتخابی
                        </label>
                        <span class="text-[11px] text-slate-400 font-medium">حداقل ۴ رقم یا کاراکتر (مثلاً: 1234)</span>
                    </div>
                    <div class="relative w-full">
                        <input type="password" name="password" id="passwordInput" required minlength="4"
                               class="w-full h-14 bg-white dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 rounded-2xl pr-12 pl-4 text-base sm:text-lg font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 transition-all text-left font-mono shadow-xs" dir="ltr"
                               placeholder="رمز عبور دلخواه شما (حداقل ۴ رقم)">
                        <button type="button" id="toggleRegPasswordBtn" aria-label="نمایش رمز" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-2 cursor-pointer z-10 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                {{-- دکمه نهایی ثبت نام --}}
                <button type="submit" id="submitBtn"
                        class="w-full h-14 rounded-2xl bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-base shadow-xl shadow-amber-500/20 transition-all active:scale-[0.99] cursor-pointer mt-3 flex items-center justify-center gap-2">
                    <span>ایجاد تابلوی گالری و فعال‌سازی فوری تست ۱۴ روزه</span>
                    <span>&larr;</span>
                </button>
            </form>

            {{-- لینک ورود --}}
            <div class="pt-3.5 border-t border-slate-200 dark:border-slate-800 text-center text-xs text-slate-500 dark:text-slate-400">
                <span>قبلاً در طلالایو ثبت‌نام کرده‌اید؟</span>
                <a href="{{ route('admin.login') }}" class="font-bold text-amber-600 dark:text-amber-400 hover:underline mr-1">وارد شوید</a>
            </div>

            {{-- بخش پشتیبانی فنی طلالایو و روبیکا --}}
            <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl p-3 text-center space-y-2">
                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold">
                    ثبت‌نام یا تنظیمات براتون سخته؟ تلفنی در ۳ دقیقه وصل می‌کنیم:
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

    {{-- فوتر کپی‌رایت مینیمال --}}
    <div class="text-center text-[11px] text-slate-400 py-3">
        سامانه ابری تابلوی هوشمند طلالایو &copy; {{ date('Y') }}
    </div>

    {{-- اسکریپت جاوااسکریپت بومی و ۱۰۰٪ مستقل (بدون وابستگی به CDN خارجی) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nameInput = document.getElementById('shopNameInput');
            const phoneInput = document.getElementById('phoneInput');
            const sendOtpBtn = document.getElementById('sendOtpBtn');
            const btnText = document.getElementById('btnText');
            const otpInput = document.getElementById('otpInput');
            const otpStatusHint = document.getElementById('otpStatusHint');
            const successAlert = document.getElementById('otpSuccessAlert');
            const successText = document.getElementById('otpSuccessText');
            const errorAlert = document.getElementById('otpErrorAlert');
            const errorText = document.getElementById('otpErrorText');
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const toggleRegPasswordBtn = document.getElementById('toggleRegPasswordBtn');
            const passwordInput = document.getElementById('passwordInput');

            // ۱. تغییر تم روشن / تاریک
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('talalive_theme', isDark ? 'dark' : 'light');
                });
            }

            // ۲. تغییر نمایش رمز عبور
            if (toggleRegPasswordBtn && passwordInput) {
                toggleRegPasswordBtn.addEventListener('click', () => {
                    const isPass = passwordInput.type === 'password';
                    passwordInput.type = isPass ? 'text' : 'password';
                });
            }

            // ۳. تبدیل اعداد فارسی و عربی به انگلیسی
            function toEnglishDigits(str) {
                const fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
                const en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                let res = str;
                for (let i = 0; i < fa.length; i++) {
                    res = res.replaceAll(fa[i], en[i]);
                }
                return res;
            }

            // ۳. نرمال‌سازی شماره موبایل به صورت آنی هنگام تایپ
            phoneInput.addEventListener('input', () => {
                phoneInput.value = toEnglishDigits(phoneInput.value).replace(/[^\d]/g, '');
            });

            // ۴. سیستم ارسال پیامک و تایمر شمارش معکوس
            let countdown = 0;
            let timerInterval = null;
            let isSending = false;

            function showAlert(type, msg) {
                if (type === 'success') {
                    successText.innerText = msg;
                    successAlert.classList.remove('hidden');
                    successAlert.classList.add('flex');
                    errorAlert.classList.add('hidden');
                    errorAlert.classList.remove('flex');
                } else {
                    errorText.innerText = msg;
                    errorAlert.classList.remove('hidden');
                    errorAlert.classList.add('flex');
                    successAlert.classList.add('hidden');
                    successAlert.classList.remove('flex');
                }
            }

            function startTimer(seconds) {
                countdown = seconds;
                sendOtpBtn.disabled = true;
                sendOtpBtn.classList.add('opacity-70', 'cursor-not-allowed');

                if (timerInterval) clearInterval(timerInterval);

                timerInterval = setInterval(() => {
                    if (countdown > 0) {
                        btnText.innerText = 'ارسال مجدد (' + countdown + ')';
                        countdown--;
                    } else {
                        clearInterval(timerInterval);
                        sendOtpBtn.disabled = false;
                        sendOtpBtn.classList.remove('opacity-70', 'cursor-not-allowed');
                        btnText.innerText = 'ارسال مجدد کد';
                    }
                }, 1000);
            }

            sendOtpBtn.addEventListener('click', (e) => {
                e.preventDefault();

                const phone = phoneInput.value.trim();
                if (!phone || phone.length < 10) {
                    showAlert('error', 'لطفاً ابتدا شماره موبایل صحیح خود را وارد نمایید (مثال: ۰۹۱۸۷۰۰۹۰۶۴).');
                    phoneInput.focus();
                    return;
                }

                if (isSending || countdown > 0) return;

                isSending = true;
                sendOtpBtn.disabled = true;
                btnText.innerText = 'در حال ارسال...';
                successAlert.classList.add('hidden');
                errorAlert.classList.add('hidden');

                // کنترل تایم‌اوت در صورت کندی اینترنت (۸ ثانیه)
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 8000);

                fetch('{{ route('admin.register.send-otp') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ phone: phone }),
                    signal: controller.signal
                })
                .then(async response => {
                    clearTimeout(timeoutId);
                    isSending = false;
                    const data = await response.json().catch(() => null);

                    if (response.ok && data && data.success) {
                        showAlert('success', data.message || 'کد تأیید ۵ رقمی به شماره شما پیامک شد.');
                        otpStatusHint.innerText = 'کد به شماره شما پیامک شد';
                        otpStatusHint.classList.add('text-emerald-500', 'font-bold');
                        startTimer(data.ttl || 60);
                        otpInput.value = '';
                        otpInput.focus();
                    } else {
                        sendOtpBtn.disabled = false;
                        btnText.innerText = 'ارسال کد پیامکی';
                        const errMsg = (data && data.message) ? data.message : 'خطا در ارسال پیامک. لطفاً شماره را بررسی فرمایید.';
                        showAlert('error', errMsg);
                    }
                })
                .catch(err => {
                    clearTimeout(timeoutId);
                    isSending = false;
                    sendOtpBtn.disabled = false;
                    btnText.innerText = 'ارسال کد پیامکی';
                    if (err.name === 'AbortError') {
                        showAlert('error', 'پاسخ از درگاه پیامک با تاخیر مواجه شد. لطفاً چند لحظه دیگر مجدداً تلاش نمایید.');
                    } else {
                        showAlert('error', 'خطا در ارتباط با سرور. لطفاً اتصال اینترنت را بررسی فرمایید.');
                    }
                });
            });
        });
    </script>

</body>
</html>
