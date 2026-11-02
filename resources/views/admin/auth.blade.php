<!DOCTYPE html>
<html lang="fa" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- تشخیص آنی تم روشن و تاریک --}}
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

    @php
        $resolvedInitialTab = $initialTab ?? 'login';
        if ($errors->has('name') || $errors->has('city') || (old('name') !== null && !$errors->has('email'))) {
            $resolvedInitialTab = 'register';
        } elseif ($errors->has('email')) {
            $resolvedInitialTab = 'login';
        }

        $initialRegStep = 1;
        $initialRegOtpSent = false;
        if ($resolvedInitialTab === 'register') {
            if (($errors->has('name') || $errors->has('city') || $errors->has('password')) && !$errors->has('phone') && !$errors->has('otp') && old('phone') && old('otp')) {
                $initialRegStep = 2;
                $initialRegOtpSent = true;
            } elseif ($errors->has('otp') && old('phone')) {
                $initialRegStep = 1;
                $initialRegOtpSent = true;
            }
        }

        $initialLoginMode = 'password';
        $initialLoginOtpSent = false;
        if ($resolvedInitialTab === 'login' && ($errors->has('otp') || (old('phone') && !$errors->has('email')))) {
            $initialLoginMode = 'otp';
            $initialLoginOtpSent = (bool) old('phone');
        }

        $rawCities = \App\Http\Controllers\Admin\DisplaySettingController::getCitiesConfig();
        $provincesData = [];
        foreach ($rawCities as $s => $c) {
            $prov = $c['province'] ?? 'ایران';
            if (!isset($provincesData[$prov])) {
                $provincesData[$prov] = [];
            }
            $provincesData[$prov][] = [
                'slug'       => $s,
                'name'       => $c['name'],
                'is_capital' => !empty($c['is_capital']),
            ];
        }

        $prefillPhone = old('phone', request('phone', request('mobile', '')));
    @endphp

    <title>{{ $resolvedInitialTab === 'register' ? 'ثبت‌نام طلافروشی جدید (۱۴ روز تست رایگان) | طلالایو' : 'ورود به پنل تابلوی زنده | طلالایو' }}</title>
    <meta name="description" content="ورود و ثبت‌نام فوری تابلوی اختصاصی هوشمند نرخ طلا و سکه برای گالری طلافروشی در سامانه طلالایو همراه با ۱۴ روز تست رایگان.">
    <meta name="robots" content="noindex, follow">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    @vite('resources/css/app.css')
    <script defer src="{{ asset('vendor/alpinejs.min.js') }}"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: var(--font-sans); }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: inherit;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="tl-public text-stone-900 dark:text-stone-100 flex flex-col justify-between min-h-screen p-4 sm:p-6 transition-colors duration-200"
      x-data="unifiedAuthApp()">

    {{-- ۱. سربرگ بالا با دکمه‌های نئومورفیک --}}
    <header class="w-full max-w-md mx-auto pt-1 sm:pt-2 shrink-0 relative z-20">
        <div class="flex items-center justify-between gap-3 px-1">
            <a href="/" class="flex items-center gap-2.5 group shrink-0">
                <span class="tl-neu-icon-orb h-10 w-10 rounded-xl p-1.5 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/logo.png') }}?v=2" width="36" height="36" class="h-full w-full object-contain" alt="طلالایو">
                </span>
                <div>
                    <span class="text-sm sm:text-base font-bold text-stone-900 dark:text-stone-50 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors">طلالایو &middot; TalaLive</span>
                    <span class="block text-xs text-stone-600 dark:text-stone-400">سامانه تابلوی هوشمند طلافروشی</span>
                </div>
            </a>

            <div class="flex items-center gap-2">
                <button type="button" @click="toggleTheme()" aria-label="تغییر تم"
                        class="w-11 h-11 rounded-xl tl-neu-btn flex items-center justify-center text-stone-700 dark:text-amber-400 cursor-pointer">
                    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                <a href="/" class="text-xs font-semibold text-stone-800 dark:text-stone-200 hover:text-amber-800 dark:hover:text-amber-300 flex items-center gap-1.5 min-h-11 px-3.5 py-2 rounded-xl tl-neu-btn">
                    <span>صفحه اصلی</span>
                    @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                </a>
            </div>
        </div>
    </header>

    {{-- ۲. کارت شیشه‌ای اپل یکپارچه ورود و ثبت‌نام ۲ مرحله‌ای --}}
    <main class="relative w-full max-w-md mx-auto my-auto py-4 sm:py-6 flex-1 flex flex-col justify-center">
        {{-- هاله نور استودیویی ۱۸ عیار پشت دک شیشه‌ای --}}
        <div class="tl-ambient-gold absolute -inset-4 rounded-[44px] opacity-80" aria-hidden="true"></div>

        <div class="relative z-10 tl-glass-deck rounded-3xl p-6 sm:p-7 space-y-5 overflow-visible">

            {{-- اعلان جفت‌سازی خودکار تلویزیون در صورت اسکن QR قبل از ورود --}}
            @if (session('pending_pair_code'))
                <div class="bg-emerald-50/90 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-800 rounded-2xl p-3.5 text-xs flex items-center gap-2.5">
                    @include('partials.ui-icon', ['name' => 'tv', 'class' => 'w-5 h-5 text-emerald-700 dark:text-emerald-400 shrink-0'])
                    <div class="leading-relaxed text-emerald-900 dark:text-emerald-200">
                        آماده اتصال تلویزیون با کد <strong class="font-mono px-1.5 py-0.5 rounded bg-emerald-500/20" dir="ltr">{{ session('pending_pair_code') }}</strong>؛ کافیست وارد شوید یا ثبت‌نام کنید.
                    </div>
                </div>
            @endif

            {{-- ریل سگمنت نئومورفیک اپل: ورود به پنل | ثبت‌نام گالری جدید --}}
            <div class="tl-neu-track p-1.5 rounded-2xl grid grid-cols-2 gap-1.5">
                <button type="button"
                        @click="switchTab('login')"
                        :class="activeTab === 'login'
                            ? 'tl-neu-pill-active text-stone-900 dark:text-white font-bold'
                            : 'text-stone-600 dark:text-stone-400 hover:text-stone-900 dark:hover:text-stone-200 font-semibold'"
                        class="min-h-11 rounded-xl text-xs sm:text-sm transition-all flex items-center justify-center gap-1.5 cursor-pointer whitespace-nowrap">
                    <span>ورود به پنل</span>
                </button>

                <button type="button"
                        @click="switchTab('register')"
                        :class="activeTab === 'register'
                            ? 'tl-btn-bullion font-bold'
                            : 'text-stone-600 dark:text-stone-400 hover:text-stone-900 dark:hover:text-stone-200 font-semibold'"
                        class="min-h-11 rounded-xl text-xs sm:text-sm transition-all flex items-center justify-center gap-1.5 cursor-pointer whitespace-nowrap">
                    <span>ثبت‌نام گالری</span>
                    <span :class="activeTab === 'register' ? 'bg-white/20 text-white' : 'bg-stone-200 dark:bg-stone-800 text-stone-700 dark:text-stone-300'"
                          class="text-xs font-bold px-1.5 py-0.5 rounded-md">رایگان</span>
                </button>
            </div>

            {{-- پیام‌های سرور --}}
            @if (session('success'))
                <div x-show="showServerAlerts" class="bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl p-3.5 text-xs flex items-center gap-2.5">
                    @include('partials.ui-icon', ['name' => 'check', 'class' => 'w-4 h-4 text-emerald-700 dark:text-emerald-400 shrink-0'])
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div x-show="showServerAlerts" class="bg-rose-50 dark:bg-rose-950/50 border border-rose-300 dark:border-rose-800 text-rose-800 dark:text-rose-300 rounded-xl p-3.5 text-xs space-y-1">
                    <div class="font-semibold flex items-center gap-1.5 text-rose-700 dark:text-rose-400">
                        @include('partials.ui-icon', ['name' => 'alert', 'class' => 'w-4 h-4 shrink-0'])
                        <span>{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            {{-- پیام‌های ایجکس پویا --}}
            <div x-show="alertMessage" x-cloak
                 :class="alertType === 'success'
                    ? 'bg-emerald-50 dark:bg-emerald-950/50 border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300'
                    : 'bg-rose-50 dark:bg-rose-950/50 border-rose-300 dark:border-rose-800 text-rose-800 dark:text-rose-300'"
                 class="border rounded-xl p-3.5 text-xs space-y-2.5 transition-colors">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-sm" x-text="alertType === 'success' ? '✓' : '✕'"></span>
                    <span class="leading-relaxed font-semibold" x-text="alertMessage"></span>
                </div>

                {{-- دکمه هوشمند انتقال به تب ورود --}}
                <div x-show="alreadyRegisteredPhone" x-cloak class="pt-1">
                    <button type="button" @click="jumpToLoginWithPhone()"
                            class="w-full min-h-11 py-2.5 px-3.5 rounded-xl bg-stone-900 dark:bg-amber-500 text-white dark:text-stone-950 font-bold text-xs flex items-center justify-center gap-1.5 hover:opacity-90 transition-opacity cursor-pointer shadow-xs">
                        <span>انتقال به تب ورود با شماره</span>
                        <span class="font-mono tabular-nums" dir="ltr" x-text="alreadyRegisteredPhone"></span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </button>
                </div>

                {{-- دکمه هوشمند انتقال به تب ثبت‌نام --}}
                <div x-show="notRegisteredPhone" x-cloak class="pt-1">
                    <button type="button" @click="jumpToRegisterWithPhone()"
                            class="w-full min-h-11 py-2.5 px-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-xs flex items-center justify-center gap-1.5 transition-colors cursor-pointer shadow-xs">
                        <span>ثبت‌نام رایگان (۱۴ روز تست) با</span>
                        <span class="font-mono tabular-nums" dir="ltr" x-text="notRegisteredPhone"></span>
                        @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-3.5 h-3.5'])
                    </button>
                </div>
            </div>

            {{-- ================================================================= --}}
            {{-- تب اول: ثبت‌نام ویزاردی ۲ مرحله‌ای (گام ۱: موبایل | گام ۲: گالری) --}}
            {{-- ================================================================= --}}
            <div x-show="activeTab === 'register'" x-cloak class="space-y-5">

                {{-- نوار پیشرفت ۲ مرحله‌ای ظریف --}}
                <div class="flex items-center gap-2 px-1">
                    <div class="flex items-center gap-2">
                        <span :class="regStep === 2
                                ? 'bg-emerald-600 text-white'
                                : 'bg-amber-500 text-stone-950 ring-4 ring-amber-500/20'"
                              class="w-6 h-6 rounded-full text-xs font-bold flex items-center justify-center transition-colors shrink-0">
                            <span x-show="regStep === 1">۱</span>
                            <span x-show="regStep === 2">✓</span>
                        </span>
                        <span :class="regStep === 1 ? 'text-stone-900 dark:text-white font-bold' : 'text-emerald-700 dark:text-emerald-400 font-semibold'"
                              class="text-xs whitespace-nowrap">تأیید شماره تماس</span>
                    </div>

                    <div class="flex-1 h-0.5 rounded-full bg-stone-200 dark:bg-stone-800 overflow-hidden">
                        <div class="h-full bg-emerald-600 transition-all duration-300" :style="regStep === 2 ? 'width: 100%' : 'width: 0%'"></div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span :class="regStep === 2
                                ? 'bg-amber-500 text-stone-950 ring-4 ring-amber-500/20'
                                : 'bg-stone-200 dark:bg-stone-800 text-stone-600 dark:text-stone-400'"
                              class="w-6 h-6 rounded-full text-xs font-bold flex items-center justify-center transition-colors shrink-0">۲</span>
                        <span :class="regStep === 2 ? 'text-stone-900 dark:text-white font-bold' : 'text-stone-600 dark:text-stone-400 font-medium'"
                              class="text-xs whitespace-nowrap">مشخصات گالری طلا</span>
                    </div>
                </div>

                {{-- گام ۱ ثبت‌نام: شماره تماس و کد تأیید پیامکی --}}
                <div x-show="regStep === 1" class="space-y-4">

                    {{-- بنر شیشه‌ای هدیه ۱۴ روز تست رایگان --}}
                    <div class="tl-glass-badge rounded-2xl p-3.5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl tl-neu-icon-orb text-amber-800 dark:text-amber-300 flex items-center justify-center text-base shrink-0">
                            @include('partials.ui-icon', ['name' => 'gift', 'class' => 'w-5 h-5'])
                        </div>
                        <div>
                            <h2 class="text-xs font-bold text-amber-900 dark:text-amber-300">۱۴ روز استفاده آزمایشی کاملاً رایگان</h2>
                            <p class="text-xs text-stone-700 dark:text-stone-300 leading-relaxed mt-0.5">
                                بدون نیاز به پرداخت، تابلوی زنده گالری خود را در کمتر از ۱ دقیقه روی تلویزیون روشن کنید.
                            </p>
                        </div>
                    </div>

                    {{-- وضعیت ۱-الف: ورود شماره موبایل --}}
                    <div x-show="!regOtpSent" class="space-y-4 pt-1">
                        <div class="space-y-2">
                            <label for="regPhoneInput" class="block text-xs sm:text-sm font-semibold text-stone-800 dark:text-stone-200">
                                شماره موبایل طلافروش
                            </label>
                            <input type="tel"
                                   id="regPhoneInput"
                                   x-ref="regPhoneInput"
                                   x-model="regPhone"
                                   @input="regPhone = cleanDigits(regPhone).slice(0, 11)"
                                   @keydown.enter.prevent="sendRegOtp()"
                                   maxlength="11"
                                   dir="ltr"
                                   inputmode="numeric"
                                   autocomplete="tel"
                                   placeholder="09123456789"
                                   class="w-full min-h-12 tl-neu-inset rounded-xl px-4 text-lg text-stone-900 dark:text-white font-mono text-center font-bold tracking-widest placeholder:text-stone-400 focus:outline-none">
                        </div>

                        <button type="button"
                                @click="sendRegOtp()"
                                :disabled="isSendingRegOtp"
                                class="w-full min-h-12 rounded-xl tl-btn-bullion font-bold text-sm sm:text-base cursor-pointer disabled:opacity-60 flex items-center justify-center gap-2">
                            <span x-text="isSendingRegOtp ? 'در حال ارسال کد پیامکی...' : 'دریافت کد تأیید پیامکی'"></span>
                            <span x-show="!isSendingRegOtp">
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
                            </span>
                        </button>
                    </div>

                    {{-- وضعیت ۱-ب: ورود کد ۵ رقمی پیامک‌شده --}}
                    <div x-show="regOtpSent" x-cloak class="space-y-4 pt-1">
                        <div class="flex items-center justify-between tl-neu-inset rounded-xl px-3.5 py-2.5 text-xs">
                            <div class="flex items-center gap-1.5 text-stone-700 dark:text-stone-300">
                                <span>کد پیامک‌شده به</span>
                                <strong class="font-mono text-stone-900 dark:text-white text-sm tabular-nums" dir="ltr" x-text="regPhone"></strong>
                            </div>
                            <button type="button" @click="editRegPhone()"
                                    class="text-amber-700 dark:text-amber-400 hover:underline font-bold cursor-pointer">
                                ویرایش شماره
                            </button>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="regOtpInput" class="block text-xs sm:text-sm font-semibold text-amber-800 dark:text-amber-300">
                                    کد تأیید ۵ رقمی
                                </label>
                                <button type="button"
                                        @click="sendRegOtp()"
                                        :disabled="regCountdown > 0 || isSendingRegOtp"
                                        :class="regCountdown > 0 ? 'text-stone-400 cursor-not-allowed' : 'text-amber-700 dark:text-amber-400 hover:underline cursor-pointer font-semibold'"
                                        class="text-xs">
                                    <span x-text="regCountdown > 0 ? ('ارسال مجدد تا ' + regCountdown + ' ثانیه') : 'ارسال مجدد کد'"></span>
                                </button>
                            </div>

                            <input type="text"
                                   id="regOtpInput"
                                   x-ref="regOtpInput"
                                   x-model="regOtp"
                                   @input="onRegOtpInput()"
                                   @keydown.enter.prevent="verifyRegOtp()"
                                   maxlength="5"
                                   dir="ltr"
                                   inputmode="numeric"
                                   autocomplete="one-time-code"
                                   placeholder="-----"
                                   class="w-full min-h-14 tl-neu-inset rounded-xl px-4 text-center text-3xl font-bold tracking-[0.35em] text-amber-700 dark:text-amber-300 font-mono placeholder:text-stone-400 dark:placeholder:text-stone-600 focus:outline-none">
                        </div>

                        <button type="button"
                                @click="verifyRegOtp()"
                                :disabled="isVerifyingRegOtp || regOtp.length !== 5"
                                class="w-full min-h-12 rounded-xl tl-btn-bullion font-bold text-sm sm:text-base cursor-pointer disabled:opacity-50 flex items-center justify-center gap-2">
                            <span x-text="isVerifyingRegOtp ? 'در حال بررسی کد...' : 'تأیید و ادامه به مشخصات گالری'"></span>
                            <span x-show="!isVerifyingRegOtp">
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
                            </span>
                        </button>
                    </div>
                </div>

                {{-- گام ۲ ثبت‌نام: نام گالری طلا، شهر و رمز عبور --}}
                <form x-show="regStep === 2" x-cloak
                      method="POST"
                      action="{{ route('admin.register') }}"
                      @submit="isSubmittingReg = true"
                      class="space-y-4">
                    @csrf
                    <input type="hidden" name="phone" :value="regPhone">
                    <input type="hidden" name="otp" :value="regOtp">

                    {{-- نشان تأیید شماره همراه --}}
                    <div class="flex items-center justify-between bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 rounded-xl px-3.5 py-2.5 text-xs">
                        <div class="flex items-center gap-2 text-emerald-800 dark:text-emerald-300 font-semibold">
                            <span class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shrink-0">✓</span>
                            <span>شماره تأیید شده:</span>
                            <span class="font-mono text-sm font-bold tabular-nums" dir="ltr" x-text="regPhone"></span>
                        </div>
                        <button type="button" @click="editRegPhone()"
                                class="text-stone-600 dark:text-stone-400 hover:text-amber-700 dark:hover:text-amber-400 font-semibold cursor-pointer">
                            تغییر شماره
                        </button>
                    </div>

                    {{-- ۱. نام گالری طلا --}}
                    <div class="space-y-1.5">
                        <label for="shopNameInput" class="block text-xs sm:text-sm font-semibold text-stone-800 dark:text-stone-200">
                            نام گالری یا طلافروشی شما
                        </label>
                        <input type="text"
                               name="name"
                               id="shopNameInput"
                               x-ref="shopNameInput"
                               required
                               value="{{ old('name') }}"
                               autocomplete="organization"
                               placeholder="مثال: گالری طلای کیمیا"
                               class="w-full min-h-12 bg-white dark:bg-stone-950 border border-stone-300 dark:border-stone-700 rounded-xl px-4 text-base font-semibold text-stone-900 dark:text-white placeholder:text-stone-400 focus:outline-none focus:border-amber-600 dark:focus:border-amber-400 focus-visible:ring-2 focus-visible:ring-amber-600/30 transition-colors">
                    </div>

                    {{-- ۲. شهر گالری طلا با جستجوی ۳۱ استان --}}
                    <div class="space-y-1.5" x-data="cityPicker('{{ old('city', 'tehran') }}', @js($provincesData))">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs sm:text-sm font-semibold text-stone-800 dark:text-stone-200">
                                شهر گالری طلا
                            </label>
                            <span class="text-xs text-stone-600 dark:text-stone-400">جستجو از ۳۱ استان کشور</span>
                        </div>

                        <input type="hidden" name="city" :value="selected">

                        <div class="relative w-full">
                            <button type="button" @click="toggleDropdown()"
                                    class="w-full min-h-12 tl-neu-inset rounded-xl px-4 text-sm sm:text-base font-semibold text-stone-900 dark:text-white focus:outline-none flex items-center justify-between gap-2 cursor-pointer">
                                <div class="flex items-center gap-2.5 truncate">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></span>
                                    <span class="truncate" x-text="selectedLabel"></span>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="text-xs px-2.5 py-0.5 rounded-lg tl-neu-btn text-stone-700 dark:text-stone-300 font-medium" x-text="selectedProvinceNameOnly"></span>
                                    @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-4 h-4 text-stone-500 transition-transform duration-150'])
                                </div>
                            </button>

                            <div x-show="open"
                                 x-cloak
                                 @click.outside="open = false"
                                 @keydown.escape.window="open = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="absolute right-0 left-0 top-full mt-2 z-50 tl-neu-card rounded-2xl overflow-hidden">

                                <div class="p-2.5 bg-stone-50 dark:bg-stone-950 border-b border-stone-200 dark:border-stone-800">
                                    <div class="relative flex items-center">
                                        <div class="absolute right-3 pointer-events-none">
                                            @include('partials.ui-icon', ['name' => 'search', 'class' => 'w-4 h-4 text-stone-400'])
                                        </div>
                                        <input type="text"
                                               x-ref="searchInput"
                                               x-model="search"
                                               @keydown.enter.prevent=""
                                               placeholder="نام شهر یا استان را بنویسید..."
                                               class="w-full bg-white dark:bg-stone-900 border border-stone-300 dark:border-stone-700 rounded-lg pr-9 pl-8 py-2 text-xs sm:text-sm font-semibold text-stone-900 dark:text-white placeholder:text-stone-400 focus:outline-none focus:border-amber-600">
                                        <button type="button" x-show="search" @click="clearSearch()" class="absolute left-2 text-stone-400 hover:text-stone-600 p-1 cursor-pointer">&times;</button>
                                    </div>
                                </div>

                                <div class="max-h-60 overflow-y-auto divide-y divide-stone-100 dark:divide-stone-800">
                                    <template x-for="prov in filteredProvinces" :key="prov.name">
                                        <div>
                                            <button type="button"
                                                    @click="toggleProvince(prov.name)"
                                                    class="w-full px-3.5 py-2.5 flex items-center justify-between text-right bg-stone-50 hover:bg-stone-100 dark:bg-stone-900 dark:hover:bg-stone-800 transition-colors cursor-pointer">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-3.5 h-3.5 text-amber-600 transition-transform duration-200" :class="isProvinceExpanded(prov) ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                                                    <span class="text-xs font-bold text-stone-800 dark:text-stone-200" x-text="'استان ' + prov.name"></span>
                                                </div>
                                                <span class="text-xs font-semibold px-2 py-0.5 rounded bg-stone-200 dark:bg-stone-800 text-stone-700 dark:text-stone-300" x-text="prov.matchCount + ' شهر'"></span>
                                            </button>

                                            <div x-show="isProvinceExpanded(prov)"
                                                 class="bg-white dark:bg-stone-900 py-1 grid grid-cols-2 gap-0.5 border-t border-stone-100 dark:border-stone-800">
                                                <template x-for="c in prov.cities" :key="c.slug">
                                                    <button type="button"
                                                            @click="selectCity(c.slug)"
                                                            :class="selected === c.slug
                                                                ? 'bg-amber-50 dark:bg-amber-500/15 text-amber-800 dark:text-amber-300 font-bold border-r-4 border-amber-500'
                                                                : 'text-stone-700 dark:text-stone-300 hover:bg-stone-100 dark:hover:bg-stone-800 font-medium'"
                                                            class="px-3.5 py-2 text-right text-xs flex items-center justify-between transition-colors cursor-pointer">
                                                        <span class="truncate" x-text="c.name"></span>
                                                        <template x-if="c.is_capital">
                                                            <span class="text-xs px-1.5 py-0.5 rounded bg-amber-100 dark:bg-amber-500/20 text-amber-800 dark:text-amber-300 font-semibold shrink-0">مرکز</span>
                                                        </template>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <div x-show="filteredProvinces.length === 0" class="p-4 text-center text-xs text-stone-500">
                                        شهری با عبارت «<span class="text-amber-700 dark:text-amber-400 font-bold" x-text="search"></span>» یافت نشد.
                                    </div>

                                    <div class="p-2 bg-stone-50 dark:bg-stone-950">
                                        <button type="button"
                                                @click="selectCity('other')"
                                                :class="selected === 'other' ? 'bg-amber-50 dark:bg-amber-500/15 text-amber-800 dark:text-amber-300 font-bold' : 'text-stone-600 dark:text-stone-400 hover:bg-stone-100 dark:hover:bg-stone-800 font-semibold'"
                                                class="w-full px-3 py-2 rounded-lg text-right text-xs flex items-center justify-between cursor-pointer">
                                            <span>سایر شهرهای ایران</span>
                                            <span class="text-xs text-stone-500">سراسر کشور</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ۳. رمز عبور انتخابی --}}
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="regPasswordInput" class="block text-xs sm:text-sm font-semibold text-stone-800 dark:text-stone-200">
                                رمز عبور دلخواه برای ورود
                            </label>
                            <span class="text-xs text-stone-600 dark:text-stone-400">حداقل ۴ کاراکتر</span>
                        </div>
                        <div class="relative w-full">
                            <input :type="showRegPass ? 'text' : 'password'"
                                   name="password"
                                   id="regPasswordInput"
                                   required
                                   minlength="4"
                                   dir="ltr"
                                   autocomplete="new-password"
                                   placeholder="حداقل ۴ رقم یا حرف (مثلاً 1234)"
                                   style="padding-right: 48px;"
                                   class="w-full min-h-12 bg-white dark:bg-stone-950 border border-stone-300 dark:border-stone-700 rounded-xl pl-4 text-base font-semibold text-stone-900 dark:text-white placeholder:text-stone-400 focus:outline-none focus:border-amber-600 dark:focus:border-amber-400 focus-visible:ring-2 focus-visible:ring-amber-600/30 transition-colors text-left font-mono">
                            <button type="button" @click="showRegPass = !showRegPass" aria-label="نمایش رمز"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 dark:hover:text-stone-200 p-2 cursor-pointer">
                                <svg x-show="!showRegPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showRegPass" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                            :disabled="isSubmittingReg"
                            class="w-full min-h-12 rounded-xl tl-btn-bullion font-bold text-sm sm:text-base cursor-pointer disabled:opacity-60 mt-2 flex items-center justify-center gap-2">
                        <span x-text="isSubmittingReg ? 'در حال ساخت تابلوی گالری شما...' : 'تکمیل ثبت‌نام و ورود فوری به پنل'"></span>
                        <span x-show="!isSubmittingReg">
                            @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
                        </span>
                    </button>
                </form>
            </div>

            {{-- ================================================================= --}}
            {{-- تب دوم: ورود به پنل مدیریت (با رمز عبور + بازیابی پیامکی)          --}}
            {{-- ================================================================= --}}
            <div x-show="activeTab === 'login'" x-cloak class="space-y-5">

                {{-- حالت ۲-الف: ورود با رمز عبور --}}
                <form x-show="loginMode === 'password'"
                      method="POST"
                      action="{{ route('admin.login') }}"
                      @submit="isSubmittingLogin = true"
                      class="space-y-4">
                    @csrf

                    <div class="space-y-1.5">
                        <label for="loginEmailInput" class="block text-xs sm:text-sm font-semibold text-stone-800 dark:text-stone-200">
                            شماره موبایل یا نام کاربری
                        </label>
                        <input type="text"
                               name="email"
                               id="loginEmailInput"
                               x-ref="loginEmailInput"
                               x-model="loginIdentifier"
                               required
                               dir="ltr"
                               autocomplete="username"
                               placeholder="09123456789 یا نام کاربری"
                               class="w-full min-h-12 tl-neu-inset rounded-xl px-4 text-base font-semibold text-stone-900 dark:text-white placeholder:text-stone-400 focus:outline-none text-left">
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="loginPasswordInput" class="block text-xs sm:text-sm font-semibold text-stone-800 dark:text-stone-200">
                                رمز عبور
                            </label>
                            <button type="button" @click="openForgotOtpMode()"
                                    class="text-xs font-semibold text-amber-700 dark:text-amber-400 hover:underline cursor-pointer">
                                فراموشی رمز / ورود پیامکی
                            </button>
                        </div>
                        <div class="relative w-full">
                            <input :type="showLoginPass ? 'text' : 'password'"
                                   name="password"
                                   id="loginPasswordInput"
                                   x-ref="loginPasswordInput"
                                   required
                                   minlength="4"
                                   dir="ltr"
                                   autocomplete="current-password"
                                   placeholder="رمز عبور شما"
                                   style="padding-right: 48px;"
                                   class="w-full min-h-12 tl-neu-inset rounded-xl pl-4 text-base font-semibold text-stone-900 dark:text-white placeholder:text-stone-400 focus:outline-none text-left font-mono">
                            <button type="button" @click="showLoginPass = !showLoginPass" aria-label="نمایش رمز"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 dark:hover:text-stone-200 p-2 cursor-pointer">
                                <svg x-show="!showLoginPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showLoginPass" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                            :disabled="isSubmittingLogin"
                            class="w-full min-h-12 rounded-xl tl-btn-bullion font-bold text-sm sm:text-base cursor-pointer disabled:opacity-60 flex items-center justify-center gap-2 mt-2">
                        <span x-text="isSubmittingLogin ? 'در حال ورود...' : 'ورود به پنل کاربری تابلو'"></span>
                        <span x-show="!isSubmittingLogin">
                            @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
                        </span>
                    </button>
                </form>

                {{-- حالت ۲-ب: بازیابی رمز و ورود پیامکی --}}
                <form x-show="loginMode === 'otp'" x-cloak
                      method="POST"
                      action="{{ route('admin.login.otp') }}"
                      @submit="isSubmittingOtpLogin = true"
                      class="space-y-4">
                    @csrf

                    <div class="flex items-center justify-between">
                        <h2 class="text-sm sm:text-base font-bold text-stone-900 dark:text-white">بازیابی رمز و ورود پیامکی</h2>
                        <button type="button" @click="backToPasswordMode()"
                                class="text-xs font-semibold text-stone-600 hover:text-amber-700 dark:hover:text-amber-400 cursor-pointer">
                            بازگشت &larr;
                        </button>
                    </div>

                    <div class="space-y-2">
                        <label for="loginPhoneInput" class="block text-xs font-semibold text-stone-800 dark:text-stone-200">
                            شماره موبایل ثبت‌شده
                        </label>
                        <div class="flex gap-2">
                            <input type="tel"
                                   name="phone"
                                   id="loginPhoneInput"
                                   x-ref="loginPhoneInput"
                                   x-model="loginOtpPhone"
                                   @input="loginOtpPhone = cleanDigits(loginOtpPhone).slice(0, 11)"
                                   @keydown.enter.prevent="if(!loginOtpSent) sendLoginOtpRequest()"
                                   required
                                   maxlength="11"
                                   dir="ltr"
                                   inputmode="numeric"
                                   placeholder="09123456789"
                                   class="flex-1 min-h-12 bg-white dark:bg-stone-950 border border-stone-300 dark:border-stone-700 rounded-xl px-4 text-base text-stone-900 dark:text-white font-mono text-center font-bold tracking-wider placeholder:text-stone-400 focus:outline-none focus:border-amber-600">
                            <button type="button"
                                    @click="sendLoginOtpRequest()"
                                    :disabled="isSendingLoginOtp || loginCountdown > 0"
                                    class="min-h-12 px-4 rounded-xl tl-btn-bullion font-bold text-xs whitespace-nowrap cursor-pointer disabled:opacity-50 shrink-0">
                                <span x-text="isSendingLoginOtp ? 'ارسال...' : (loginCountdown > 0 ? (loginCountdown + ' ثانیه') : (loginOtpSent ? 'ارسال مجدد' : 'ارسال کد'))"></span>
                            </button>
                        </div>
                    </div>

                    <div x-show="loginOtpSent" x-cloak class="space-y-4 pt-1">
                        <div class="space-y-1.5">
                            <label for="loginOtpCodeInput" class="block text-xs font-semibold text-amber-800 dark:text-amber-300">
                                کد ۵ رقمی پیامک‌شده
                            </label>
                            <input type="text"
                                   name="otp"
                                   id="loginOtpCodeInput"
                                   x-ref="loginOtpCodeInput"
                                   x-model="loginOtpCode"
                                   @input="loginOtpCode = cleanDigits(loginOtpCode).slice(0, 5)"
                                   maxlength="5"
                                   dir="ltr"
                                   inputmode="numeric"
                                   autocomplete="one-time-code"
                                   placeholder="-----"
                                   class="w-full min-h-14 tl-neu-inset rounded-xl px-4 text-center text-2xl font-bold tracking-[0.35em] text-amber-700 dark:text-amber-300 font-mono focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label for="newPasswordInput" class="block text-xs font-semibold text-stone-800 dark:text-stone-200">
                                رمز عبور جدید دلخواه
                            </label>
                            <div class="relative w-full">
                                <input :type="showNewPass ? 'text' : 'password'"
                                       name="password"
                                       id="newPasswordInput"
                                       :required="loginMode === 'otp'"
                                       minlength="4"
                                       dir="ltr"
                                       autocomplete="new-password"
                                       placeholder="رمز جدید (حداقل ۴ کاراکتر)"
                                       style="padding-right: 48px;"
                                       class="w-full min-h-12 tl-neu-inset rounded-xl pl-4 text-base font-semibold text-stone-900 dark:text-white placeholder:text-stone-400 text-left font-mono focus:outline-none">
                                <button type="button" @click="showNewPass = !showNewPass"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 p-2 cursor-pointer">
                                    <svg x-show="!showNewPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showNewPass" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                                :disabled="isSubmittingOtpLogin"
                                class="w-full min-h-12 rounded-xl tl-btn-bullion font-bold text-sm sm:text-base cursor-pointer flex items-center justify-center gap-2">
                            <span x-text="isSubmittingOtpLogin ? 'در حال ثبت رمز جدید...' : 'تغییر رمز عبور و ورود به پنل'"></span>
                            <span x-show="!isSubmittingOtpLogin">
                                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    {{-- ۳. فوتر مینیمال پشتیبانی --}}
    <footer class="w-full max-w-md mx-auto pb-1 sm:pb-2 shrink-0 space-y-2 text-center">
        <div class="flex items-center justify-center gap-3 text-xs text-stone-600 dark:text-stone-400 flex-wrap px-2">
            <span>نیاز به راهنمایی تلفنی دارید؟</span>
            <a href="tel:09187009064" class="inline-flex items-center gap-1 text-stone-800 dark:text-stone-200 hover:text-amber-700 dark:hover:text-amber-400 transition-colors font-bold">
                @include('partials.ui-icon', ['name' => 'phone', 'class' => 'w-3.5 h-3.5 text-amber-700 dark:text-amber-400'])
                <span dir="ltr" class="font-mono text-xs tabular-nums">0918 700 9064</span>
            </a>
            <span class="text-stone-400 dark:text-stone-700">&bull;</span>
            <a href="https://t.me/talalive" rel="noopener noreferrer" target="_blank" class="inline-flex items-center gap-1.5 text-stone-700 dark:text-stone-300 hover:text-amber-700 dark:hover:text-amber-400 transition-colors font-semibold">
                <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></svg>
                <span>پشتیبانی تلگرام</span>
            </a>
        </div>

        <div class="text-xs text-stone-500">
            سامانه ابری تابلوی هوشمند طلالایو &copy; {{ date('Y') }}
        </div>
    </footer>

    <script>
        function unifiedAuthApp() {
            return {
                activeTab: @js($resolvedInitialTab),
                showServerAlerts: true,
                alertType: 'error',
                alertMessage: '',
                alreadyRegisteredPhone: '',
                notRegisteredPhone: '',

                // وضعیت‌های تب ثبت‌نام ۲ مرحله‌ای
                regStep: @js($initialRegStep),
                regPhone: @js((string) $prefillPhone),
                regOtp: @js((string) old('otp', '')),
                regOtpSent: @js($initialRegOtpSent),
                isSendingRegOtp: false,
                isVerifyingRegOtp: false,
                isSubmittingReg: false,
                regCountdown: 0,
                regTimer: null,
                showRegPass: false,

                // وضعیت‌های تب ورود
                loginMode: @js($initialLoginMode),
                loginIdentifier: @js((string) old('email', '')),
                loginOtpPhone: @js((string) old('phone', '')),
                loginOtpCode: @js((string) old('otp', '')),
                loginOtpSent: @js($initialLoginOtpSent),
                isSendingLoginOtp: false,
                isSubmittingLogin: false,
                isSubmittingOtpLogin: false,
                loginCountdown: 0,
                loginTimer: null,
                showLoginPass: false,
                showNewPass: false,

                toggleTheme() {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('talalive_theme', isDark ? 'dark' : 'light');
                },

                cleanDigits(str) {
                    if (!str) return '';
                    const fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
                    const en = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
                    let res = String(str);
                    for (let i = 0; i < fa.length; i++) {
                        res = res.replaceAll(fa[i], en[i]);
                    }
                    return res.replace(/[^\d]/g, '');
                },

                clearAlerts() {
                    this.alertMessage = '';
                    this.alreadyRegisteredPhone = '';
                    this.notRegisteredPhone = '';
                    this.showServerAlerts = false;
                },

                setAlert(type, msg) {
                    this.showServerAlerts = false;
                    this.alertType = type;
                    this.alertMessage = msg;
                },

                switchTab(tab) {
                    if (this.activeTab === tab) return;
                    this.activeTab = tab;
                    this.clearAlerts();

                    const targetUrl = tab === 'register' ? '{{ route('admin.register') }}' : '{{ route('admin.login') }}';
                    if (window.history && window.history.replaceState) {
                        window.history.replaceState({}, '', targetUrl);
                    }
                    document.title = tab === 'register'
                        ? 'ثبت‌نام طلافروشی جدید (۱۴ روز تست رایگان) | طلالایو'
                        : 'ورود به پنل تابلوی زنده | طلالایو';
                },

                jumpToLoginWithPhone() {
                    const phone = this.alreadyRegisteredPhone || this.regPhone;
                    this.switchTab('login');
                    this.loginMode = 'password';
                    this.loginIdentifier = phone;
                    this.$nextTick(() => {
                        if (this.$refs.loginPasswordInput) this.$refs.loginPasswordInput.focus();
                    });
                },

                jumpToRegisterWithPhone() {
                    const phone = this.notRegisteredPhone || this.loginOtpPhone;
                    this.switchTab('register');
                    this.regStep = 1;
                    this.regOtpSent = false;
                    this.regPhone = phone;
                    this.$nextTick(() => {
                        if (this.$refs.regPhoneInput) this.$refs.regPhoneInput.focus();
                    });
                },

                startRegTimer(sec) {
                    this.regCountdown = sec;
                    if (this.regTimer) clearInterval(this.regTimer);
                    this.regTimer = setInterval(() => {
                        if (this.regCountdown > 0) {
                            this.regCountdown--;
                        } else {
                            clearInterval(this.regTimer);
                        }
                    }, 1000);
                },

                editRegPhone() {
                    this.clearAlerts();
                    this.regStep = 1;
                    this.regOtpSent = false;
                    this.regOtp = '';
                    this.$nextTick(() => {
                        if (this.$refs.regPhoneInput) this.$refs.regPhoneInput.focus();
                    });
                },

                async sendRegOtp() {
                    this.clearAlerts();
                    const phone = this.cleanDigits(this.regPhone);
                    this.regPhone = phone;

                    if (!/^09\d{9}$/.test(phone)) {
                        this.setAlert('error', 'لطفاً شماره موبایل ۱۱ رقمی معتبر وارد فرمایید (مثال: 09123456789).');
                        if (this.$refs.regPhoneInput) this.$refs.regPhoneInput.focus();
                        return;
                    }

                    if (this.isSendingRegOtp || this.regCountdown > 0) return;
                    this.isSendingRegOtp = true;

                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 10000);

                    try {
                        const res = await fetch('{{ route('admin.register.send-otp') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ phone }),
                            signal: controller.signal
                        });
                        clearTimeout(timeoutId);
                        const data = await res.json().catch(() => ({}));

                        if (res.ok && data.success) {
                            this.regOtpSent = true;
                            this.regOtp = '';
                            this.setAlert('success', data.message || 'کد تأیید ۵ رقمی به موبایل شما پیامک شد.');
                            this.startRegTimer(60);
                            this.$nextTick(() => {
                                if (this.$refs.regOtpInput) this.$refs.regOtpInput.focus();
                            });
                        } else {
                            if (data.already_registered) {
                                this.alreadyRegisteredPhone = data.phone || phone;
                            }
                            this.setAlert('error', data.message || 'خطا در ارسال کد پیامکی.');
                        }
                    } catch (err) {
                        clearTimeout(timeoutId);
                        this.setAlert('error', err.name === 'AbortError'
                            ? 'پاسخ درگاه پیامک با تأخیر مواجه شد. لطفاً مجدداً تلاش کنید.'
                            : 'خطا در ارتباط با سرور. اتصال اینترنت خود را بررسی فرمایید.');
                    } finally {
                        this.isSendingRegOtp = false;
                    }
                },

                onRegOtpInput() {
                    this.regOtp = this.cleanDigits(this.regOtp).slice(0, 5);
                    if (this.regOtp.length === 5 && !this.isVerifyingRegOtp) {
                        this.verifyRegOtp();
                    }
                },

                async verifyRegOtp() {
                    this.clearAlerts();
                    const phone = this.cleanDigits(this.regPhone);
                    const otp = this.cleanDigits(this.regOtp);

                    if (otp.length !== 5) {
                        this.setAlert('error', 'لطفاً کد ۵ رقمی پیامک‌شده را کامل وارد نمایید.');
                        return;
                    }

                    if (this.isVerifyingRegOtp) return;
                    this.isVerifyingRegOtp = true;

                    try {
                        const res = await fetch('{{ route('admin.register.verify-otp') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ phone, otp })
                        });
                        const data = await res.json().catch(() => ({}));

                        if (res.ok && data.success) {
                            this.clearAlerts();
                            this.regStep = 2;
                            this.$nextTick(() => {
                                if (this.$refs.shopNameInput) this.$refs.shopNameInput.focus();
                            });
                        } else {
                            if (data.already_registered) {
                                this.alreadyRegisteredPhone = data.phone || phone;
                            }
                            this.setAlert('error', data.message || 'کد تأیید واردشده اشتباه است.');
                        }
                    } catch (e) {
                        this.setAlert('error', 'خطا در ارتباط با سرور. لطفاً دوباره تلاش کنید.');
                    } finally {
                        this.isVerifyingRegOtp = false;
                    }
                },

                openForgotOtpMode() {
                    this.clearAlerts();
                    this.loginMode = 'otp';
                    const cleaned = this.cleanDigits(this.loginIdentifier);
                    if (/^09\d{9}$/.test(cleaned) && !this.loginOtpPhone) {
                        this.loginOtpPhone = cleaned;
                    }
                    this.$nextTick(() => {
                        if (this.$refs.loginPhoneInput) this.$refs.loginPhoneInput.focus();
                    });
                },

                backToPasswordMode() {
                    this.clearAlerts();
                    this.loginMode = 'password';
                    if (this.loginOtpPhone && !this.loginIdentifier) {
                        this.loginIdentifier = this.loginOtpPhone;
                    }
                },

                startLoginTimer(sec) {
                    this.loginCountdown = sec;
                    if (this.loginTimer) clearInterval(this.loginTimer);
                    this.loginTimer = setInterval(() => {
                        if (this.loginCountdown > 0) {
                            this.loginCountdown--;
                        } else {
                            clearInterval(this.loginTimer);
                        }
                    }, 1000);
                },

                async sendLoginOtpRequest() {
                    this.clearAlerts();
                    const phone = this.cleanDigits(this.loginOtpPhone);
                    this.loginOtpPhone = phone;

                    if (!/^09\d{9}$/.test(phone)) {
                        this.setAlert('error', 'لطفاً شماره موبایل ۱۱ رقمی معتبر وارد نمایید.');
                        if (this.$refs.loginPhoneInput) this.$refs.loginPhoneInput.focus();
                        return;
                    }

                    if (this.isSendingLoginOtp || this.loginCountdown > 0) return;
                    this.isSendingLoginOtp = true;

                    try {
                        const res = await fetch('{{ route('admin.login.send-otp') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ phone })
                        });
                        const data = await res.json().catch(() => ({}));

                        if (res.ok && data.success) {
                            this.loginOtpSent = true;
                            this.setAlert('success', data.message || 'کد بازیابی پیامک شد.');
                            this.startLoginTimer(60);
                            this.$nextTick(() => {
                                if (this.$refs.loginOtpCodeInput) this.$refs.loginOtpCodeInput.focus();
                            });
                        } else {
                            if (data.not_registered) {
                                this.notRegisteredPhone = phone;
                            }
                            this.setAlert('error', data.message || 'خطا در ارسال پیامک.');
                        }
                    } catch (e) {
                        this.setAlert('error', 'خطا در ارتباط با سرور. لطفاً دوباره تلاش کنید.');
                    } finally {
                        this.isSendingLoginOtp = false;
                    }
                }
            };
        }

        function cityPicker(initialSlug, provincesData) {
            return {
                open: false,
                search: '',
                selected: initialSlug || 'tehran',
                provinces: provincesData || {},
                expandedProvinces: {},

                init() {
                    this.autoExpandSelectedProvince();
                    this.$watch('selected', () => this.autoExpandSelectedProvince());
                },

                autoExpandSelectedProvince() {
                    for (const [prov, cities] of Object.entries(this.provinces)) {
                        if (cities.some(c => c.slug === this.selected)) {
                            this.expandedProvinces[prov] = true;
                            break;
                        }
                    }
                },

                normalize(str) {
                    if (!str) return '';
                    return String(str)
                        .replace(/[\u064B-\u065F\u0670]/g, '')
                        .replace(/[يى]/g, 'ی')
                        .replace(/[ك]/g, 'ک')
                        .replace(/[آأإ]/g, 'ا')
                        .replace(/[\u200c\u200b]/g, '')
                        .replace(/\s+/g, ' ')
                        .trim()
                        .toLowerCase();
                },

                get selectedLabel() {
                    if (this.selected === 'other') return 'سایر شهرهای ایران';
                    for (const [prov, cities] of Object.entries(this.provinces)) {
                        const match = cities.find(c => c.slug === this.selected);
                        if (match) {
                            if (match.name === prov || match.is_capital) {
                                return `${match.name} (مرکز استان)`;
                            }
                            return `${match.name} (استان ${prov})`;
                        }
                    }
                    return 'انتخاب شهر...';
                },

                get selectedProvinceNameOnly() {
                    if (this.selected === 'other') return 'ایران';
                    for (const [prov, cities] of Object.entries(this.provinces)) {
                        const match = cities.find(c => c.slug === this.selected);
                        if (match) return prov;
                    }
                    return '';
                },

                get filteredProvinces() {
                    const q = this.normalize(this.search);
                    if (!q) {
                        return Object.entries(this.provinces).map(([name, cities]) => ({
                            name,
                            cities,
                            matchCount: cities.length
                        }));
                    }
                    const results = [];
                    for (const [name, cities] of Object.entries(this.provinces)) {
                        const provMatches = this.normalize(name).includes(q);
                        const matchedCities = provMatches
                            ? cities
                            : cities.filter(c => this.normalize(c.name).includes(q) || this.normalize(c.slug).includes(q));
                        if (matchedCities.length > 0) {
                            results.push({
                                name,
                                cities: matchedCities,
                                matchCount: matchedCities.length
                            });
                        }
                    }
                    return results;
                },

                toggleProvince(provName) {
                    this.expandedProvinces[provName] = !this.expandedProvinces[provName];
                },

                isProvinceExpanded(prov) {
                    if (this.search.trim()) return true;
                    return !!this.expandedProvinces[prov.name];
                },

                selectCity(slug) {
                    this.selected = slug;
                    this.open = false;
                    this.search = '';
                    this.autoExpandSelectedProvince();
                },

                toggleDropdown() {
                    this.open = !this.open;
                    if (this.open) {
                        this.search = '';
                        this.autoExpandSelectedProvince();
                        this.$nextTick(() => {
                            if (this.$refs.searchInput) this.$refs.searchInput.focus();
                        });
                    }
                },

                clearSearch() {
                    this.search = '';
                    if (this.$refs.searchInput) this.$refs.searchInput.focus();
                }
            };
        }
    </script>
</body>
</html>
