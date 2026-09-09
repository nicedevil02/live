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

    <title>ثبت‌نام طلافروشی جدید و فعال‌سازی تست رایگان ۷ روزه | طلالایو</title>
    <meta name="description" content="ثبت‌نام و راه‌اندازی فوری تابلوی اختصاصی هوشمند نرخ طلا و سکه برای گالری طلافروشی در سامانه طلالایو. ۷ روز استفاده آزمایشی کاملاً رایگان بدون نیاز به پرداخت.">
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
<body class="bg-slate-50 dark:bg-[#020617] text-slate-800 dark:text-slate-100 flex flex-col justify-between min-h-screen py-6 sm:py-10 px-4 transition-colors duration-300">

    <div class="w-full max-w-md sm:max-w-lg mx-auto my-auto space-y-4 sm:space-y-5">

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
        <div class="bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800/80 rounded-3xl p-5 sm:p-8 shadow-xl dark:shadow-2xl space-y-5 transition-all">
            
            {{-- بنر برجسته دوره تست ۷ روزه رایگان --}}
            <div class="bg-gradient-to-r from-amber-500/15 via-amber-500/5 to-amber-500/10 dark:from-amber-500/20 dark:via-slate-900 dark:to-amber-500/10 border border-amber-500/30 rounded-2xl p-3.5 sm:p-4 flex items-center gap-3.5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/30 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-lg shrink-0">
                    🎁
                </div>
                <div>
                    <h1 class="text-xs sm:text-sm font-black text-amber-700 dark:text-amber-300">۷ روز استفاده آزمایشی و کاملاً رایگان</h1>
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

            {{-- فرم اصلی ثبت نام --}}
            <form method="POST" action="{{ route('admin.register') }}" class="space-y-4" id="registerForm">
                @csrf

                {{-- نام طلافروشی / گالری --}}
                <div class="space-y-1.5">
                    <label for="shopNameInput" class="block text-xs font-bold text-slate-700 dark:text-slate-300">نام طلافروشی / گالری</label>
                    <input type="text" name="name" id="shopNameInput" required
                           class="w-full h-11 bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-4 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all"
                           placeholder="مثال: گالری طلای پرنیا" value="{{ old('name') }}" autocomplete="off">
                </div>

                {{-- شناسه اختصاصی آدرس تابلوی تلویزیون (اسلاگ انگلیسی) --}}
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="shopSlugInput" class="block text-xs font-bold text-slate-700 dark:text-slate-300">شناسه اختصاصی آدرس تابلو (انگلیسی)</label>
                        <span class="text-[10px] text-slate-400">خودکار از نام مغازه ساخته می‌شود</span>
                    </div>
                    <div class="relative">
                        <input type="text" name="slug" id="shopSlugInput" required
                               class="w-full h-11 bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-4 text-sm text-slate-900 dark:text-white font-mono text-left placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all"
                               dir="ltr" placeholder="parnia-gold" value="{{ old('slug', old('username')) }}"
                               autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" data-lpignore="true">
                    </div>
                    {{-- پیش‌نمایش کاملاً پویا و زنده آدرس تلویزیون --}}
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 flex items-center gap-1 flex-wrap pt-0.5">
                        <span>آدرس تابلوی اختصاصی تلویزیون شما:</span>
                        <span class="font-mono font-bold text-amber-700 dark:text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded-lg border border-amber-500/20" dir="ltr">
                            talalive.ir/<span id="previewSlug">...</span>
                        </span>
                    </p>
                </div>

                {{-- شماره موبایل طلافروش و دکمه ارسال کد پیامکی --}}
                <div class="space-y-1.5">
                    <label for="phoneInput" class="block text-xs font-bold text-slate-700 dark:text-slate-300">شماره موبایل طلافروش (شناسه اصلی ورود به پنل)</label>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <div class="relative flex-1">
                            <input type="tel" name="phone" id="phoneInput" required
                                   class="w-full h-11 bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-4 text-sm text-slate-900 dark:text-white font-mono text-left placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all"
                                   dir="ltr" placeholder="09187009064" maxlength="11" value="{{ old('phone') }}"
                                   autocomplete="tel" inputmode="numeric">
                        </div>
                        
                        <button type="button" id="sendOtpBtn"
                                class="h-11 px-4 sm:px-5 rounded-xl text-xs font-bold transition-all shrink-0 cursor-pointer bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md shadow-amber-500/20 flex items-center justify-center gap-1.5">
                            <span id="btnText">ارسال کد پیامکی</span>
                        </button>
                    </div>
                </div>

                {{-- کادر کد تأیید ۵ رقمی پیامک --}}
                <div class="space-y-2 bg-amber-500/5 dark:bg-slate-950/40 p-4 rounded-2xl border border-amber-500/20 dark:border-slate-800">
                    <div class="flex items-center justify-between">
                        <label for="otpInput" class="block text-xs font-bold text-amber-700 dark:text-amber-400">کد تأیید ۵ رقمی پیامک‌شده:</label>
                        <span id="otpStatusHint" class="text-[10px] text-slate-500 dark:text-slate-400">پس از فشردن «ارسال کد»، کد به موبایل شما فرستاده می‌شود</span>
                    </div>
                    <input type="text" name="otp" id="otpInput" required maxlength="5" inputmode="numeric"
                           class="w-full h-12 bg-white dark:bg-slate-950 border border-amber-500/40 rounded-xl px-4 text-center text-xl font-black tracking-widest text-amber-600 dark:text-amber-400 font-mono placeholder-slate-300 dark:placeholder-slate-700 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500"
                           placeholder="-----" value="{{ old('otp') }}" autocomplete="one-time-code">
                </div>

                {{-- کلمات عبور --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label for="passwordInput" class="block text-xs font-bold text-slate-700 dark:text-slate-300">رمز عبور (حداقل ۶ کاراکتر)</label>
                        <input type="password" name="password" id="passwordInput" required
                               class="w-full h-11 bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-4 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 transition-all"
                               placeholder="******" autocomplete="new-password">
                    </div>
                    <div class="space-y-1.5">
                        <label for="passwordConfirmInput" class="block text-xs font-bold text-slate-700 dark:text-slate-300">تکرار رمز عبور</label>
                        <input type="password" name="password_confirmation" id="passwordConfirmInput" required
                               class="w-full h-11 bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-4 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 transition-all"
                               placeholder="******" autocomplete="new-password">
                    </div>
                </div>

                {{-- دکمه نهایی ثبت نام --}}
                <button type="submit" id="submitBtn"
                        class="w-full h-12 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/20 transition-all hover:scale-[1.01] cursor-pointer mt-3 flex items-center justify-center">
                    ایجاد مغازه و فعال‌سازی فوری تست ۷ روزه
                </button>
            </form>

            {{-- لینک ورود --}}
            <div class="pt-4 border-t border-slate-200 dark:border-slate-800 text-center text-xs text-slate-500 dark:text-slate-400">
                <span>قبلاً در طلالایو ثبت‌نام کرده‌اید؟</span>
                <a href="{{ route('admin.login') }}" class="font-bold text-amber-600 dark:text-amber-400 hover:underline mr-1">وارد شوید</a>
            </div>

            {{-- راهنمای تلفنی --}}
            <div class="text-center text-[11px] text-slate-500 pt-1">
                نیاز به راهنمایی دارید؟ <a href="tel:09187009064" class="text-slate-700 dark:text-slate-300 hover:text-amber-600 dark:hover:text-amber-400 font-bold" dir="ltr">0918 700 9064</a>
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
            const slugInput = document.getElementById('shopSlugInput');
            const previewSlug = document.getElementById('previewSlug');
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

            // ۱. تغییر تم روشن / تاریک
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('talalive_theme', isDark ? 'dark' : 'light');
                });
            }

            // ۲. جدول جامع تبدیل حروف فارسی به انگلیسی برای ساخت آدرس اختصاصی تابلو (Slug)
            function transliteratePersian(str) {
                const map = {
                    'آ': 'a', 'ا': 'a', 'ب': 'b', 'پ': 'p', 'ت': 't', 'ث': 's', 'ج': 'j', 'چ': 'ch', 'ح': 'h', 'خ': 'kh',
                    'د': 'd', 'ذ': 'z', 'ر': 'r', 'ز': 'z', 'ژ': 'zh', 'س': 's', 'ش': 'sh', 'ص': 's', 'ض': 'z', 'ط': 't',
                    'ظ': 'z', 'ع': 'a', 'غ': 'gh', 'ف': 'f', 'ق': 'gh', 'ک': 'k', 'گ': 'g', 'ل': 'l', 'م': 'm', 'ن': 'n',
                    'و': 'u', 'ه': 'h', 'ی': 'y', 'ي': 'y', 'ك': 'k', 'ئ': 'y', 'ء': '', 'أ': 'a', 'إ': 'e', 'ؤ': 'o',
                    'ة': 'h', ' ': '-', '‌': '-'
                };
                return str.toLowerCase().split('').map(char => {
                    if (map[char] !== undefined) return map[char];
                    if (/[a-z0-9\-]/.test(char)) return char;
                    return '';
                }).join('').replace(/-+/g, '-').replace(/^-|-$/g, '');
            }

            // تبدیل اعداد فارسی و عربی به انگلیسی
            function toEnglishDigits(str) {
                const fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
                const en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                let res = str;
                for (let i = 0; i < fa.length; i++) {
                    res = res.replaceAll(fa[i], en[i]);
                }
                return res;
            }

            // ردیابی اینکه آیا کاربر شناسه را به صورت دستی دستکاری کرده است یا خیر
            let userCustomizedSlug = false;

            // جلوگیری از اتوفیل ایمیل توسط کروم در فیلد اسلاگ
            if (slugInput.value && slugInput.value.includes('@')) {
                slugInput.value = '';
            }

            function updatePreview() {
                const currentSlug = slugInput.value.trim();
                if (currentSlug) {
                    previewSlug.innerText = currentSlug;
                } else {
                    previewSlug.innerText = '...';
                }
            }

            // با تایپ نام طلافروشی، آدرس تابلو به صورت خودکار ساخته می‌شود
            nameInput.addEventListener('input', () => {
                if (!userCustomizedSlug) {
                    const generated = transliteratePersian(nameInput.value);
                    slugInput.value = generated;
                    updatePreview();
                }
            });

            // در صورتی که کاربر مستقیماً اسلاگ را ویرایش کند
            slugInput.addEventListener('input', () => {
                userCustomizedSlug = true;
                // حذف کاراکترهای غیرمجاز و تبدیل به حروف کوچک
                slugInput.value = slugInput.value.toLowerCase().replace(/[^a-z0-9\-]/g, '');
                updatePreview();
            });

            // مقداردهی اولیه پیش‌نمایش در بارگذاری صفحه
            if (nameInput.value && !slugInput.value) {
                slugInput.value = transliteratePersian(nameInput.value);
            }
            updatePreview();

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
