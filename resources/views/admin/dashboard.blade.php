@extends('admin.layouts.app')

@section('title', 'داشبورد مدیریت')

@section('content')
<div x-data="dashboardPage()" class="space-y-6">
    {{-- بنر جشن و تبریک در صورت جفت‌سازی موفقیت‌آمیز تلویزیون --}}
    @if(session('success_pair'))
        <div class="rounded-3xl p-6 border-2 border-emerald-500/60 bg-gradient-to-r from-emerald-500/20 via-teal-500/15 to-emerald-500/20 dark:from-emerald-950/80 dark:via-slate-900 dark:to-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
            <div class="flex items-center gap-4 text-right">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500 text-slate-950 flex items-center justify-center text-3xl font-black shrink-0 shadow-lg shadow-emerald-500/30">
                    🎉
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-black text-emerald-900 dark:text-emerald-300">اتصال تلویزیون مغازه با موفقیت انجام شد!</h3>
                    <p class="text-xs sm:text-sm text-emerald-800 dark:text-emerald-400 mt-1 leading-relaxed">{{ session('success_pair') }}</p>
                </div>
            </div>
            <a href="{{ url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token) }}" target="_blank"
               class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs transition-all shadow-md shrink-0 flex items-center justify-center gap-2">
                <span>مشاهده تابلوی زنده</span>
                <i data-lucide="external-link" class="w-4 h-4"></i>
            </a>
        </div>
    @endif

    @if(session('success'))
        <div class="rounded-2xl px-4 sm:px-5 py-3.5 border border-emerald-300 dark:border-emerald-800/70 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-900 dark:text-emerald-200 text-xs sm:text-sm font-bold flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-start sm:items-center gap-2.5 min-w-0">
                <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-black shrink-0 mt-0.5 sm:mt-0">✓</span>
                <span class="leading-relaxed">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="window.openTalaliveGuide && window.openTalaliveGuide('welcome')"
                    class="w-full sm:w-auto px-3.5 py-2 sm:py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black whitespace-nowrap cursor-pointer shrink-0 text-center">
                🎓 مشاهده راهنما
            </button>
        </div>
    @endif

    @php
        $tvConnected = !empty($onboardingChecklist['tv_connected']);
        $productAdded = !empty($onboardingChecklist['product_added']);
        $profileCustomized = !empty($onboardingChecklist['profile_customized']);
    @endphp

    {{-- ۱. هاب هوشمند راه‌اندازی و اتصال تلویزیون مغازه (فاز ۱ و ۲: تک‌مقصدی، بدون شلوغی و متن اضافه) --}}
    @if(!auth()->user()->is_super_admin && !$tvConnected)
        <div x-data="{
                callRequested: false,
                callLoading: false,
                callMsg: ''
             }"
             class="rounded-2xl sm:rounded-3xl p-5 sm:p-7 bg-white dark:bg-slate-900 border-2 border-amber-500/40 shadow-xl shadow-amber-500/5 space-y-4 sm:space-y-5">

            {{-- سربرگ هاب: عنوان و گام‌ها --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center text-xl sm:text-2xl font-black shadow-md shadow-amber-500/20 shrink-0">
                        📺
                    </div>
                    <div>
                        <h2 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">
                            راه‌اندازی تابلوی طلا روی تلویزیون مغازه (۳۰ ثانیه)
                        </h2>
                        <p class="text-[11.5px] sm:text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            در مرورگر تلویزیون آدرس <span class="font-mono font-bold text-amber-700 dark:text-amber-400" dir="ltr">talalive.ir/tv</span> را باز کنید و کد ۶ رقمی را اینجا بزنید:
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 self-end sm:self-auto shrink-0 flex-wrap">
                    <button type="button"
                            @click="openWizard()"
                            class="px-3 py-1.5 rounded-xl bg-amber-500/15 hover:bg-amber-500/25 border border-amber-500/30 text-amber-800 dark:text-amber-300 text-xs font-black transition-all cursor-pointer flex items-center gap-1.5">
                        <span>✨</span>
                        <span>راهنمای مرحله‌ای (۳ گام)</span>
                    </button>
                </div>
            </div>

            {{-- فرم ورودی کد ۶ رقمی و اسکن QR --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                <div class="flex-1 relative">
                    <input type="text"
                           maxlength="8"
                           x-model="pairCode"
                           dir="ltr"
                           placeholder="کد ۶ رقمی تلویزیون (مثلاً 548291)"
                           @keydown.enter.prevent="pairWithCodeManual()"
                           @input="
                               let val = pairCode.toString();
                               const p = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
                               const e = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
                               for(let i=0; i<p.length; i++) val = val.replaceAll(p[i], e[i]);
                               pairCode = val.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 6);
                           "
                           class="w-full h-12 sm:h-13 bg-slate-50 dark:bg-slate-950 border-2 border-amber-500/40 rounded-2xl px-4 text-center font-mono font-black text-lg sm:text-xl tracking-[0.25em] text-slate-900 dark:text-white placeholder:font-sans placeholder:text-xs placeholder:font-normal placeholder:tracking-normal focus:outline-none focus:border-amber-500 shadow-inner">
                </div>

                <div class="grid grid-cols-2 sm:flex items-center gap-2 shrink-0">
                    <button type="button"
                            @click="pairWithCodeManual()"
                            :disabled="isPairing || pairCode.length < 6"
                            class="h-12 sm:h-13 px-4 sm:px-6 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-xs sm:text-sm shadow-md shadow-amber-500/20 transition-all cursor-pointer disabled:opacity-50 flex items-center justify-center gap-1.5 whitespace-nowrap">
                        <span x-text="isPairing ? 'در حال اتصال...' : '🚀 اتصال تلویزیون'"></span>
                    </button>

                    <button type="button"
                            @click="openScanner()"
                            class="h-12 sm:h-13 px-3.5 sm:px-4 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-black text-xs whitespace-nowrap shadow-md shadow-indigo-600/20 transition-all cursor-pointer flex items-center justify-center gap-1.5">
                        <span>📷</span>
                        <span>اسکن با دوربین</span>
                    </button>
                </div>
            </div>

            {{-- نوار ابزار کمکی پایین: لینک مستقیم + درخواست تماس رایگان --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-2 text-xs">
                <div class="flex items-center gap-2 flex-wrap">
                    <button type="button"
                            x-show="!callRequested"
                            :disabled="callLoading"
                            @click="
                                callLoading = true;
                                fetch('{{ route('admin.request-setup-call') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(r => r.json())
                                .then(data => {
                                    callLoading = false;
                                    if(data.success) {
                                        callRequested = true;
                                        callMsg = data.message;
                                    }
                                })
                                .catch(e => { callLoading = false; });
                            "
                            class="text-[11.5px] font-bold text-indigo-700 dark:text-indigo-400 hover:underline flex items-center gap-1 cursor-pointer disabled:opacity-50">
                        <span>📞</span>
                        <span x-text="callLoading ? 'در حال ثبت درخواست...' : 'فرصت ندارید؟ درخواست تماس و راه‌اندازی تلفنی توسط کارشناس'"></span>
                    </button>
                    <span x-show="callRequested" x-cloak class="text-[11.5px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                        <span>✓</span>
                        <span>درخواست تماس با موفقیت ثبت شد؛ کارشناس فنی به زودی تماس می‌گیرد.</span>
                    </span>
                </div>

                <div class="flex items-center gap-2 shrink-0 self-end sm:self-auto">
                    <span class="text-[11px] text-slate-400">لینک پخش:</span>
                    <button type="button"
                            onclick="navigator.clipboard.writeText('{{ url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token) }}'); alert('لینک اختصاصی کپی شد!');"
                            class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-[11px] font-bold transition-colors cursor-pointer">
                        کپی لینک
                    </button>
                    <a href="{{ url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token) }}" target="_blank"
                       class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-[11px] font-bold transition-colors flex items-center gap-1">
                        <span>پیش‌نمایش</span>
                        <span>↗</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- ۲. افشای تدریجی (Progressive Disclosure - پیشنهاد ۳): گام‌های پس از اتصال موفق تلویزیون --}}
    @if(!auth()->user()->is_super_admin && $tvConnected)
        @if(!$productAdded)
            {{-- گام ۲: معرفی ویترین طلا (اسلایدر محصولات) --}}
            <div x-data="{ dismissed: localStorage.getItem('talalive_dismiss_step2_{{ auth()->id() }}') === '1' }"
                 x-show="!dismissed"
                 x-cloak
                 class="rounded-2xl sm:rounded-3xl p-4 sm:p-5 border-2 border-indigo-500/35 bg-white dark:bg-slate-900 shadow-md flex flex-col md:flex-row items-start md:items-center justify-between gap-3 sm:gap-4">
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 border border-indigo-500/30 flex items-center justify-center text-xl shrink-0">
                        💍
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 border border-indigo-500/30">
                                گام بعدی: ویترین طلا
                            </span>
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white">
                                نمایش تصاویر و قیمت لحظه‌ای زیورآلات شما روی تلویزیون
                            </h3>
                        </div>
                        <p class="text-[11.5px] sm:text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                            عکس کارهای طلا را با وزن و اجرت ثبت کنید تا قیمت تمام‌شده هر کار لحظه‌ای و خودکار در کنار نرخ‌ها نمایش داده شود.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto shrink-0">
                    <a href="{{ route('admin.products.index') }}"
                       class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-black text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-indigo-600/20">
                        <span>افزودن اولین محصول طلا</span>
                        <span>&larr;</span>
                    </a>
                    <button type="button"
                            @click="dismissed = true; localStorage.setItem('talalive_dismiss_step2_{{ auth()->id() }}', '1')"
                            class="px-3 py-2.5 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-xs font-bold transition-colors cursor-pointer">
                        بعداً
                    </button>
                </div>
            </div>
        @elseif(!$profileCustomized)
            {{-- گام ۳: تنظیم برندینگ و QR اختصاصی پیج اینستاگرام روی تلویزیون --}}
            <div x-data="{ dismissed: localStorage.getItem('talalive_dismiss_step3_{{ auth()->id() }}') === '1' }"
                 x-show="!dismissed"
                 x-cloak
                 class="rounded-2xl sm:rounded-3xl p-4 sm:p-5 border-2 border-amber-500/35 bg-white dark:bg-slate-900 shadow-md flex flex-col md:flex-row items-start md:items-center justify-between gap-3 sm:gap-4">
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30 flex items-center justify-center text-xl shrink-0">
                        🏪
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-500/15 text-amber-700 dark:text-amber-300 border border-amber-500/30">
                                گام پایانی: برندینگ گالری
                            </span>
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white">
                                ساخت بارکد QR پیج اینستاگرام روی تلویزیون مغازه
                            </h3>
                        </div>
                        <p class="text-[11.5px] sm:text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                            با ثبت آدرس اینستاگرام یا روبیکا، بارکد پیج شما در گوشه تلویزیون قرار می‌گیرد تا مشتریان با گوشی وارد پیج شما شوند.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto shrink-0">
                    <a href="{{ route('admin.shop-profile') }}"
                       class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-amber-500/20">
                        <span>تنظیم نام و QR گالری</span>
                        <span>&larr;</span>
                    </a>
                    <button type="button"
                            @click="dismissed = true; localStorage.setItem('talalive_dismiss_step3_{{ auth()->id() }}', '1')"
                            class="px-3 py-2.5 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-xs font-bold transition-colors cursor-pointer">
                        بعداً
                    </button>
                </div>
            </div>
        @endif
    @endif
    {{-- نوار پیشنهاد ویژه ۷۲ ساعت اول ثبت‌نام --}}
    @if(!empty($isWelcomePeriod))
        <div class="rounded-2xl p-3.5 sm:p-4.5 border-2 border-amber-500/60 bg-gradient-to-r from-amber-500/15 via-slate-900 to-amber-950/30 text-white shadow-xl shadow-amber-500/10 flex flex-col md:flex-row items-center justify-between gap-3 sm:gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center font-black text-xl shrink-0 shadow-md shadow-amber-500/30">
                    🔥
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-xs sm:text-sm font-black text-amber-400">پیشنهاد طلایی راه‌اندازی گالری شما (محدود به ۷۲ ساعت اول)</h3>
                        <span class="px-2 py-0.5 rounded-full text-[10.5px] font-black bg-rose-500 text-white">
                            {{ $welcomeHoursLeft }} ساعت تا انقضا
                        </span>
                    </div>
                    <p class="text-[11px] sm:text-xs text-slate-300 mt-0.5 leading-relaxed">
                        اشتراک سالانه الماس طلالایو به جای <span class="line-through text-slate-400">۴,۷۰۰,۰۰۰ تومان</span>، فقط با <strong class="text-amber-300 font-black">۳,۹۶۰,۰۰۰ تومان</strong> محاسبه می‌شود (۷۴۰,۰۰۰ تومان تخفیف افتتاحیه).
                    </p>
                </div>
            </div>

            <div class="shrink-0 w-full md:w-auto">
                <a href="{{ route('admin.subscription.index') }}"
                   class="w-full md:w-auto px-4 py-2 sm:py-2.5 rounded-xl bg-gradient-to-r from-amber-400 via-amber-500 to-amber-400 hover:from-amber-300 hover:to-amber-400 text-slate-950 font-black text-xs transition-all shadow-md shadow-amber-500/25 flex items-center justify-center gap-1.5 cursor-pointer">
                    <span>خرید با تخفیف ویژه (۳,۹۶۰,۰۰۰ ت)</span>
                    <span>&larr;</span>
                </a>
            </div>
        </div>
    @endif

    {{-- نوار وضعیت اشتراک / دوره آزمایشی (مخصوص گالری‌های غیر سوپرادمین - نسخه جمع‌وجور) --}}
    @if(!auth()->user()->is_super_admin && auth()->user()->expires_at)
        @php
            $daysLeft = auth()->user()->trialDaysRemaining();
            $isSubscribed = auth()->user()->isSubscribed();
            $jalaliExpire = \App\Models\User::toJalali(auth()->user()->expires_at, false);
            $isUrgent = $daysLeft <= 2;
            $isWarning = $daysLeft <= 7;
        @endphp

        @if(!$isSubscribed)
            {{-- ۱. دوره آزمایشی رایگان ۱۴ روزه --}}
            <div class="rounded-2xl p-3.5 sm:p-4 border {{ $isUrgent ? 'bg-gradient-to-r from-rose-500/10 via-rose-500/5 to-transparent border-rose-500/30' : 'bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent border-amber-500/30' }} bg-white dark:bg-slate-900 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl {{ $isUrgent ? 'bg-rose-500/20 text-rose-500 border border-rose-500/30' : 'bg-amber-500/20 text-amber-500 border border-amber-500/30' }} flex items-center justify-center font-black text-xl shrink-0">
                        {{ $isUrgent ? '⚠️' : '🎁' }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white">دوره آزمایشی رایگان فعال است</h3>
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-black {{ $isUrgent ? 'bg-rose-500/20 text-rose-700 dark:text-rose-300 border border-rose-500/30' : 'bg-amber-500/20 text-amber-800 dark:text-amber-300 border border-amber-500/30' }}">
                                {{ $daysLeft }} روز باقی مانده
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed hidden sm:block">
                            تمامی امکانات تابلوی تلویزیون، فرمول‌ساز و اسلایدشوی محصولات بدون محدودیت فعال است.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto shrink-0 flex-wrap">
                    <a href="{{ route('admin.subscription.index') }}" class="flex-1 md:flex-none px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all flex items-center justify-center gap-1.5 shadow-sm cursor-pointer">
                        <i data-lucide="crown" class="w-3.5 h-3.5"></i>
                        <span>خرید آنلاین اشتراک</span>
                    </a>
                    <a href="https://t.me/talalive" rel="noopener noreferrer" target="_blank"
                       class="px-3.5 py-2 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:opacity-95 text-white font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-xs">
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></svg>
                        <span>پشتیبانی تلگرام</span>
                    </a>
                    <a href="tel:09187009064" class="px-2.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs transition-all flex items-center justify-center gap-1" title="تماس: ۰۹۱۸۷۰۰۹۰۶۴">
                        <span>📞</span>
                    </a>
                </div>
            </div>
        @elseif($isWarning)
            {{-- ۲. اشتراک خریداری‌شده رو به پایان --}}
            <div class="rounded-2xl p-3.5 sm:p-4 border bg-gradient-to-r from-rose-500/10 via-rose-500/5 to-transparent border-rose-500/30 bg-white dark:bg-slate-900 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-500/20 text-rose-500 border border-rose-500/30 flex items-center justify-center font-black text-xl shrink-0">
                        ⚠️
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white">اعتبار اشتراک رو به پایان است</h3>
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-black bg-rose-500/20 text-rose-700 dark:text-rose-300 border border-rose-500/30">
                                {{ $daysLeft }} روز باقی مانده (تا {{ $jalaliExpire }})
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed hidden sm:block">
                            جهت جلوگیری از قطع پخش تلویزیون مغازه، نسبت به تمدید اشتراک اقدام فرمایید.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto shrink-0 flex-wrap">
                    <a href="{{ route('admin.subscription.index') }}" class="flex-1 md:flex-none px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all flex items-center justify-center gap-1.5 shadow-sm cursor-pointer">
                        <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                        <span>تمدید آنلاین اشتراک</span>
                    </a>
                    <a href="https://t.me/talalive" rel="noopener noreferrer" target="_blank"
                       class="px-3.5 py-2 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:opacity-95 text-white font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-xs">
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></svg>
                        <span>پشتیبانی تلگرام</span>
                    </a>
                    <a href="tel:09187009064" class="px-2.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs transition-all flex items-center justify-center gap-1" title="تماس: ۰۹۱۸۷۰۰۹۰۶۴">
                        <span>📞</span>
                    </a>
                </div>
            </div>
        @else
            {{-- ۳. اشتراک رسمی و فعال --}}
            <div class="rounded-2xl p-3 sm:p-3.5 border bg-gradient-to-r from-emerald-500/10 via-emerald-500/5 to-transparent border-emerald-500/30 bg-white dark:bg-slate-900 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-500 border border-emerald-500/30 flex items-center justify-center font-black text-lg shrink-0">
                        💎
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white">اشتراک رسمی طلالایو فعال است</h3>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-black bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 border border-emerald-500/30">
                            {{ $daysLeft }} روز تا {{ $jalaliExpire }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto shrink-0">
                    <a href="{{ route('admin.subscription.index') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs transition-all flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="crown" class="w-3.5 h-3.5 text-amber-500"></i>
                        <span>ارتقا / تمدید</span>
                    </a>
                    <a href="https://t.me/talalive" rel="noopener noreferrer" target="_blank"
                       class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs transition-all flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 shrink-0 text-indigo-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></svg>
                        <span>پشتیبانی</span>
                    </a>
                </div>
            </div>
        @endif
    @endif

    {{-- مرکز تابلوی هوشمند و تلویزیون مغازه (در صورت اتصال قبلی تلویزیون) --}}
    @if($tvConnected)
    <div x-data="{
            showPairingBox: false,
            callRequested: false,
            callLoading: false,
            callMsg: ''
         }"
         class="rounded-2xl sm:rounded-3xl border border-emerald-500/30 bg-white dark:bg-slate-900 shadow-md p-4 sm:p-5 space-y-3.5">

        {{-- سربرگ هاب تلویزیون: وضعیت اتصال و ابزارهای سریع --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2.5 flex-wrap">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 flex items-center justify-center shrink-0">
                    <i data-lucide="tv" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-sm sm:text-base font-black text-slate-900 dark:text-emerald-300">تلویزیون و تابلوی مغازه</h3>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border border-emerald-500/30">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            متصل و فعال
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 self-end sm:self-auto flex-wrap">
                <button @click="openWizard()" type="button"
                        class="px-2.5 py-1.5 rounded-xl text-xs font-bold bg-amber-500/10 hover:bg-amber-500/20 text-amber-700 dark:text-amber-400 border border-amber-500/30 transition-colors cursor-pointer flex items-center gap-1">
                    <span>✨</span>
                    <span>راهنمای مرحله‌ای (۳ گام)</span>
                </button>
            </div>
        </div>

        {{-- بخش ۱: لینک پخش مستقیم تابلوی اختصاصی --}}
        <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-2.5">
            <div class="flex-1 flex items-center gap-2 bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 rounded-xl p-1.5 pl-2" dir="ltr">
                <input type="text" readonly
                       value="{{ url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token) }}"
                       id="displayUrlInput"
                       class="bg-transparent border-none text-xs text-slate-800 dark:text-amber-300 w-full select-all font-mono font-bold focus:outline-none px-2 py-1">
                <button type="button"
                        onclick="navigator.clipboard.writeText(document.getElementById('displayUrlInput').value); alert('لینک اختصاصی کپی شد!');"
                        class="px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold whitespace-nowrap cursor-pointer transition-colors shadow-xs">
                    کپی لینک
                </button>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token) }}" target="_blank"
                   class="flex-1 md:flex-none px-3.5 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-xs whitespace-nowrap shadow-sm shadow-emerald-600/20 transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                    <span>مشاهده تابلو</span>
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                </a>

                <button type="button"
                        @click="showPairingBox = !showPairingBox"
                        class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold whitespace-nowrap transition-colors cursor-pointer flex items-center gap-1">
                    <span x-text="showPairingBox ? 'بستن فرم اتصال' : 'اتصال تلویزیون دیگر'"></span>
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform" :class="showPairingBox ? 'rotate-180' : ''"></i>
                </button>
            </div>
        </div>

        {{-- بخش ۲: فرم اتصال تلویزیون دوم در صورت نیاز --}}
        <div x-show="showPairingBox"
             x-transition
             class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5">
            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                <i data-lucide="info" class="w-4 h-4 text-amber-500 shrink-0"></i>
                <span>پین ۶ رقمی نمایش داده شده روی تلویزیون دوم را وارد کنید یا بارکد را اسکن نمایید:</span>
            </div>

            <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                <button @click="openScanner()"
                        type="button"
                        class="qr-scan-btn font-black px-3.5 py-2 rounded-xl text-xs whitespace-nowrap transition-all shadow-sm hover:scale-[1.01] cursor-pointer flex items-center justify-center gap-1.5 flex-1 sm:flex-none"
                        style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%) !important; color: #ffffff !important; border: 1px solid rgba(255, 255, 255, 0.2) !important;">
                    <svg class="w-3.5 h-3.5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>اسکن QR با دوربین</span>
                </button>

                <div class="flex items-center gap-1.5 flex-1 sm:flex-none">
                    <input type="text" maxlength="8" x-model="pairCode" placeholder="کد ۶ رقمی" dir="ltr"
                           @keydown.enter.prevent="pairWithCodeManual()"
                           @input="
                               let val = pairCode.toString();
                               const p = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
                               const e = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
                               for(let i=0; i<p.length; i++) val = val.replaceAll(p[i], e[i]);
                               pairCode = val.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 6);
                           "
                           class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-850 dark:text-slate-100 w-full sm:w-32 text-center font-mono font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                    <button @click="pairWithCodeManual()" :disabled="isPairing || pairCode.length < 6"
                            class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-black px-3.5 py-2 rounded-xl text-xs whitespace-nowrap transition-all cursor-pointer disabled:opacity-50 shrink-0">
                        <span x-text="isPairing ? 'اتصال...' : 'ثبت'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- کارت‌های شاخص‌های کلیدی (شبکه ۲ در ۲ موبایل-فرست بدون فضای مرده) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-4">
        {{-- ۱. قیمت طلای ۱۸ عیار زنده تابلو --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-3.5 sm:p-5 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] sm:text-xs font-bold text-slate-500 dark:text-slate-400">قیمت طلای ۱۸ عیار تابلو</span>
                <div class="w-8 h-8 rounded-xl bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-2.5">
                <h3 class="text-base sm:text-2xl font-black text-amber-600 dark:text-amber-400 tabular-nums tracking-tight"
                    x-text="isLoading ? '...' : status.gold18Price"></h3>
                <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 mt-1 truncate">قیمت پایه فرمول‌های خرید</p>
            </div>
        </div>

        {{-- ۲. قیمت محاسبه‌شده طلای ۱۸ عیار جهانی (فرمول اونس و دلار) --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-3.5 sm:p-5 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] sm:text-xs font-bold text-slate-500 dark:text-slate-400">طلای ۱۸ جهانی (فرمول)</span>
                <div class="w-8 h-8 rounded-xl bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <i data-lucide="calculator" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-2.5">
                <h3 class="text-base sm:text-2xl font-black text-amber-600 dark:text-amber-400 tabular-nums tracking-tight"
                    x-text="isLoading ? '...' : status.formula18Price"></h3>
                <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 mt-1 truncate">محاسبه بر اساس اونس و تتر</p>
            </div>
        </div>

        {{-- ۳. آخرین همگام‌سازی تابلو --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-3.5 sm:p-5 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] sm:text-xs font-bold text-slate-500 dark:text-slate-400">آخرین همگام‌سازی تابلو</span>
                <button type="button" @click="loadData()" title="به‌روزرسانی دستی"
                        class="w-8 h-8 rounded-xl bg-amber-500/15 text-amber-600 dark:text-amber-400 hover:bg-amber-500/25 flex items-center justify-center transition-all cursor-pointer shrink-0">
                    <i data-lucide="refresh-cw" :class="isLoading ? 'animate-spin' : ''" class="w-4 h-4"></i>
                </button>
            </div>
            <div class="mt-2.5">
                <h3 class="text-base sm:text-2xl font-black text-slate-800 dark:text-slate-100 tabular-nums tracking-tight"
                    x-text="isLoading ? '...' : status.updatedAt"></h3>
                <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 mt-1 truncate">رفرش خودکار هر ۳۰ ثانیه</p>
            </div>
        </div>

        {{-- ۴. وضعیت سرویس‌ها و هشدارها --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-3.5 sm:p-5 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between gap-2">
                <span class="text-[11px] sm:text-xs font-bold text-slate-500 dark:text-slate-400">وضعیت سرویس‌ها</span>
                <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                     :class="status.isHealthy ? 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400' : 'bg-rose-500/15 text-rose-600 dark:text-rose-400'">
                    <i x-show="status.isHealthy" data-lucide="check-circle" class="w-4 h-4"></i>
                    <i x-show="!status.isHealthy" data-lucide="alert-triangle" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-2.5">
                <h3 class="text-xs sm:text-base font-black truncate"
                    :class="status.isHealthy ? (status.staleCount > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400') : 'text-rose-600 dark:text-rose-400'"
                    x-text="status.apiStatus"></h3>
                <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500 mt-1 truncate"
                   x-text="status.alerts"></p>
            </div>
        </div>

    </div>

    {{-- Quick Actions --}}
    <h3 class="text-sm sm:text-base font-bold text-slate-800 dark:text-slate-100 pt-2">دسترسی سریع</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-2.5 sm:gap-4">
        <a href="{{ route('admin.formulas') }}" class="group flex flex-col items-center justify-center gap-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-4 sm:p-5 rounded-2xl hover:border-amber-400/50 hover:shadow-xl hover:shadow-amber-500/10 hover:-translate-y-0.5 transition-all">
            <div class="w-10 h-10 sm:w-11 sm:h-11 bg-amber-500/15 border border-amber-500/25 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="variable" class="w-5 h-5"></i>
            </div>
            <span class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300">مدیریت فرمول‌ها</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="group flex flex-col items-center justify-center gap-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-4 sm:p-5 rounded-2xl hover:border-amber-400/50 hover:shadow-xl hover:shadow-amber-500/10 hover:-translate-y-0.5 transition-all">
            <div class="w-10 h-10 sm:w-11 sm:h-11 bg-amber-500/15 border border-amber-500/25 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="gem" class="w-5 h-5"></i>
            </div>
            <span class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300">تصاویر و اسلایدر</span>
        </a>
        <a href="{{ route('admin.display-control') }}" class="group flex flex-col items-center justify-center gap-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-4 sm:p-5 rounded-2xl hover:border-emerald-400/50 hover:shadow-xl hover:shadow-emerald-500/10 hover:-translate-y-0.5 transition-all">
            <div class="w-10 h-10 sm:w-11 sm:h-11 bg-emerald-500/15 border border-emerald-500/25 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="monitor" class="w-5 h-5"></i>
            </div>
            <span class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300">تنظیمات تابلو و پوسته</span>
        </a>
        @if(auth()->user()->is_super_admin)
        <a href="{{ route('admin.sources') }}" class="group flex flex-col items-center justify-center gap-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-4 sm:p-5 rounded-2xl hover:border-amber-400/50 hover:shadow-xl hover:shadow-amber-500/10 hover:-translate-y-0.5 transition-all">
            <div class="w-10 h-10 sm:w-11 sm:h-11 bg-amber-500/15 border border-amber-500/25 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="rss" class="w-5 h-5"></i>
            </div>
            <span class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300">پیکربندی API</span>
        </a>
        @endif
    </div>
    {{-- مودال اسکن بارکد تلویزیون با دوربین --}}
    <div x-show="isScannerOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div @click.away="closeScanner()" 
             class="relative w-full max-w-md bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-2xl overflow-hidden">
            
            {{-- Header --}}
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: #e0e7ff; color: #4338ca;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">اسکن بارکد تلویزیون</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">دوربین را به سمت QR Code تلویزیون بگیرید</p>
                    </div>
                </div>
                <button @click="closeScanner()" type="button" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Scanner Viewport --}}
            <div class="mt-4 relative rounded-2xl overflow-hidden bg-slate-950 border border-slate-800 aspect-square flex items-center justify-center">
                <div id="qr-reader" class="w-full h-full"></div>

                {{-- Scanning Overlay animation --}}
                <div x-show="isCameraRunning && !isProcessingPair" class="pointer-events-none absolute inset-0 flex items-center justify-center">
                    <div class="w-52 h-52 border-2 border-dashed border-amber-400/90 rounded-2xl relative">
                        <div class="absolute inset-x-0 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent shadow-lg shadow-amber-400/80 animate-pulse"></div>
                    </div>
                </div>

                {{-- Loading / Processing State --}}
                <div x-show="isProcessingPair" class="absolute inset-0 bg-slate-950/90 backdrop-blur-xs flex flex-col items-center justify-center gap-3 p-4 text-center">
                    <div class="w-10 h-10 border-3 border-amber-500 border-t-transparent rounded-full animate-spin"></div>
                    <span class="text-sm font-bold text-amber-400">در حال جفت‌سازی و اتصال تلویزیون...</span>
                </div>

                {{-- Camera Error State --}}
                <div x-show="cameraError" class="absolute inset-0 bg-slate-950/95 flex flex-col items-center justify-center p-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-rose-500/20 text-rose-400 flex items-center justify-center mb-3">
                        <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-sm font-bold text-white mb-1">عدم امکان دسترسی به دوربین</h4>
                    <p class="text-xs text-slate-300 leading-relaxed mb-4" x-text="cameraError"></p>
                    <div class="flex items-center gap-2">
                        <button @click="retryCamera()" type="button" class="qr-scan-modal-btn px-4 py-2 rounded-xl text-xs font-bold transition-colors cursor-pointer" style="background-color: #4f46e5 !important; color: #ffffff !important;">
                            تلاش مجدد
                        </button>
                        <button @click="closeScanner()" type="button" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition-colors cursor-pointer">
                            ورود دستی کد
                        </button>
                    </div>
                </div>
            </div>

            {{-- Footer Guidance --}}
            <div class="mt-4 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                <span>پس از شناسایی، اتصال فوری انجام می‌شود.</span>
                <button @click="closeScanner()" type="button" class="font-bold hover:underline cursor-pointer" style="color: #4f46e5;">
                    انصراف و بستن
                </button>
            </div>
        </div>
    </div>

    {{-- مودال ویزارد هدایت‌شونده اتصال تلویزیون مغازه (Interactive Onboarding Wizard) --}}
    <div x-show="isWizardOpen"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="isWizardOpen = false"
             class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl space-y-6 text-right relative">
            
            {{-- دکمه بستن --}}
            <button @click="isWizardOpen = false" class="absolute top-6 left-6 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30 flex items-center justify-center text-2xl font-black">
                    📺
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">راه‌اندازی و اتصال تلویزیون مغازه</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">در ۲ مرحله ساده تابلوی نرخ‌های زنده را روی تلویزیون روشن کنید</p>
                </div>
            </div>

            <div class="space-y-4">
                {{-- گام ۱ --}}
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center gap-2 font-bold text-xs text-amber-600 dark:text-amber-400">
                        <span class="w-6 h-6 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center text-xs font-black">۱</span>
                        <span>باز کردن مرورگر تلویزیون هوشمند</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed pr-8">
                        کنترل تلویزیون را بردارید، برنامه مرورگر اینترنت (سامسونگ: <b class="text-slate-900 dark:text-white">Internet</b> | ال‌جی: <b class="text-slate-900 dark:text-white">Web Browser</b> | اندروید: <b class="text-slate-900 dark:text-white">کروم یا مرورگر</b>) را باز کرده و نشانی زیر را وارد فرمایید:
                    </p>
                    <div class="pr-8 pt-1">
                        <span class="inline-block px-3.5 py-1.5 rounded-xl bg-amber-500/10 border border-amber-500/30 font-mono font-black text-sm text-amber-600 dark:text-amber-400" dir="ltr">
                            talalive.ir/tv
                        </span>
                    </div>
                </div>

                {{-- گام ۲ --}}
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-3">
                    <div class="flex items-center gap-2 font-bold text-xs text-amber-600 dark:text-amber-400">
                        <span class="w-6 h-6 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center text-xs font-black">۲</span>
                        <span>وارد کردن کد ۶ رقمی نمایش داده شده روی تلویزیون</span>
                    </div>
                    <div class="pr-8 space-y-3">
                        <input type="text" maxlength="8" x-model="pairCode" placeholder="کد ۶ رقمی (حروف/اعداد)" dir="ltr"
                               @keydown.enter.prevent="pairWithCodeManual()"
                               @input="
                                   let val = pairCode.toString();
                                   const p = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
                                   const e = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
                                   for(let i=0; i<p.length; i++) val = val.replaceAll(p[i], e[i]);
                                   pairCode = val.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 6);
                               "
                               class="w-full bg-white dark:bg-slate-900 border-2 border-amber-500/50 rounded-2xl py-3 px-4 text-center font-mono font-black text-2xl tracking-widest text-slate-900 dark:text-white placeholder:font-sans placeholder:text-sm placeholder:font-normal focus:outline-none focus:border-amber-500 shadow-inner">
                        <button @click="pairWithCodeManual()" :disabled="isPairing || pairCode.length < 6"
                                class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-sm shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
                            <i data-lucide="zap" class="w-4 h-4"></i>
                            <span x-text="isPairing ? 'در حال برقراری ارتباط...' : '🚀 اتصال و روشن کردن تلویزیون مغازه'"></span>
                        </button>
                    </div>
                </div>

                {{-- گزینه اسکن با دوربین --}}
                <div class="text-center pt-2">
                    <button type="button" @click="isWizardOpen = false; openScanner();"
                            class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="camera" class="w-4 h-4"></i>
                        <span>یا ترجیح می‌دهید بارکد تلویزیون را با دوربین گوشی اسکن کنید؟</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .qr-scan-btn {
        background: linear-gradient(135deg, #292524 0%, #1c1917 100%) !important;
        color: #fbbf24 !important;
        border: 1px solid rgba(251, 191, 36, 0.35) !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
    }
    .qr-scan-btn:hover {
        background: linear-gradient(135deg, #35302d 0%, #221f1d 100%) !important;
        box-shadow: 0 6px 18px rgba(245, 158, 11, 0.25) !important;
        border-color: rgba(251, 191, 36, 0.5) !important;
        transform: translateY(-1px);
    }
    .qr-scan-modal-btn {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: #1c1917 !important;
        font-weight: 800 !important;
    }
    .qr-scan-modal-btn:hover {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%) !important;
    }
    #qr-reader { border: none !important; }
    #qr-reader video { border-radius: 1rem; object-fit: cover; width: 100% !important; height: 100% !important; }
    #qr-reader__scan_region { border: none !important; }
    #qr-reader__dashboard { display: none !important; }
</style>
@endpush

@push('scripts')
<script src="{{ asset('vendor/html5-qrcode.min.js') }}"></script>
<script>
function dashboardPage() {
    return {
        status: {
            updatedAt: '-',
            apiStatus: 'در حال بررسی...',
            alerts: '0 هشدار فعال',
            staleCount: 0,
            isHealthy: true,
            gold18Price: '-',
            formula18Price: '-'
        },
        isLoading: true,
        pairCode: '',
        isPairing: false,
        isScannerOpen: false,
        isWizardOpen: false,
        isCameraRunning: false,
        isProcessingPair: false,
        cameraError: null,
        html5QrCodeScanner: null,

        async init() {
            await this.loadData();
            setInterval(() => this.loadData(), 30000);
        },

        openWizard() {
            if (typeof window.openTalaliveGuide === 'function') {
                window.openTalaliveGuide('tv');
                return;
            }
            this.isWizardOpen = true;
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    lucide.createIcons();
                }
            });
        },

        async pairWithCodeManual() {
            let code = this.pairCode.toString();
            const p = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            const e = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
            for(let i=0; i<p.length; i++) code = code.replaceAll(p[i], e[i]);
            code = code.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().trim();

            if (!code || code.length < 6) {
                alert('لطفا کد ۶ رقمی نمایش داده شده در تلویزیون را با دقت وارد کنید.');
                return;
            }
            this.isPairing = true;
            try {
                const res = await fetch('{{ route('admin.pair-code') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ activation_code: code })
                });
                const data = await res.json();
                if (data && data.success) {
                    this.isWizardOpen = false;
                    alert('🎉 ' + (data.message || 'تلویزیون با موفقیت متصل شد!'));
                    this.pairCode = '';
                    window.location.reload();
                } else {
                    alert((data && data.message) ? data.message : 'کد فعال‌سازی نامعتبر است یا منقضی شده است. لطفا تلویزیون را رفرش فرمایید.');
                }
            } catch (err) {
                alert('خطا در برقراری ارتباط با سرور');
            } finally {
                this.isPairing = false;
            }
        },

        openScanner() {
            this.isScannerOpen = true;
            this.cameraError = null;
            this.isProcessingPair = false;
            this.$nextTick(() => {
                if (window.lucide) window.lucide.createIcons();
                this.startCamera();
            });
        },

        async startCamera() {
            if (typeof Html5Qrcode === 'undefined') {
                this.cameraError = 'کتابخانه اسکنر بارگذاری نشده است. لطفاً صفحه را رفرش فرمایید.';
                return;
            }
            try {
                if (!this.html5QrCodeScanner) {
                    this.html5QrCodeScanner = new Html5Qrcode("qr-reader");
                }
                const config = {
                    fps: 10,
                    qrbox: (viewfinderWidth, viewfinderHeight) => {
                        const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                        const edgeSize = Math.floor(minEdge * 0.75);
                        return { width: edgeSize, height: edgeSize };
                    },
                    aspectRatio: 1.0
                };
                await this.html5QrCodeScanner.start(
                    { facingMode: "environment" },
                    config,
                    (decodedText) => this.onQrCodeDetected(decodedText),
                    (errorMessage) => { /* Ignore frame scan misses */ }
                );
                this.isCameraRunning = true;
            } catch (err) {
                console.error("Camera error:", err);
                this.isCameraRunning = false;
                this.cameraError = 'دسترسی به دوربین داده نشد یا دستگاه شما دوربین ندارد. می‌توانید کد ۶ رقمی را دستی وارد نمایید.';
            }
        },

        async stopCamera() {
            if (this.html5QrCodeScanner) {
                try {
                    if (this.html5QrCodeScanner.isScanning) {
                        await this.html5QrCodeScanner.stop();
                    }
                    await this.html5QrCodeScanner.clear();
                } catch (e) {
                    console.error("Error stopping scanner:", e);
                }
            }
            this.isCameraRunning = false;
        },

        async closeScanner() {
            await this.stopCamera();
            this.isScannerOpen = false;
            this.isProcessingPair = false;
            this.cameraError = null;
        },

        async retryCamera() {
            this.cameraError = null;
            await this.stopCamera();
            await this.startCamera();
        },

        async onQrCodeDetected(decodedText) {
            if (this.isProcessingPair) return;
            this.isProcessingPair = true;

            // Pause/stop camera immediately
            await this.stopCamera();

            let sessionCode = null;
            let activationCode = null;

            const sessMatch = decodedText.match(/sess-[a-zA-Z0-9_\-]+/i);
            const pMatch = decodedText.match(/\/p\/([a-zA-Z0-9]+)/i);
            if (sessMatch) {
                sessionCode = sessMatch[0];
            } else if (pMatch) {
                activationCode = pMatch[1].toUpperCase();
            } else if (/^[A-Z0-9]{6}$/i.test(decodedText.trim())) {
                activationCode = decodedText.trim().toUpperCase();
            }

            try {
                let res, data;
                if (sessionCode) {
                    res = await fetch('/admin/pair/' + encodeURIComponent(sessionCode), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    data = await res.json();
                } else if (activationCode) {
                    res = await fetch('{{ route('admin.pair-code') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ activation_code: activationCode })
                    });
                    data = await res.json();
                } else {
                    alert('بارکد اسکن‌شده نامعتبر است: ' + decodedText);
                    this.isProcessingPair = false;
                    await this.startCamera();
                    return;
                }

                if (data && data.success) {
                    this.isScannerOpen = false;
                    alert('🎉 ' + (data.message || 'تلویزیون با موفقیت متصل شد! اکنون تابلوی طلای شما روی نمایشگر پخش می‌شود.'));
                    await this.loadData();
                } else {
                    alert((data && data.message) ? data.message : 'خطا در اتصال به تلویزیون.');
                    this.isProcessingPair = false;
                    await this.startCamera();
                }
            } catch (e) {
                console.error("Pairing error:", e);
                alert('خطا در اتصال با سرور. لطفاً مجدداً امتحان کنید.');
                this.isProcessingPair = false;
                await this.startCamera();
            }
        },

        async loadData() {
            this.isLoading = true;
            try {
                const username = '{{ $username }}';
                const displayToken = '{{ auth()->user()->display_token }}';

                const fetchWithTimeout = (url, options = {}, timeoutMs = 4000) => {
                    const controller = new AbortController();
                    const timer = setTimeout(() => controller.abort(), timeoutMs);
                    return fetch(url, { ...options, signal: controller.signal })
                        .finally(() => clearTimeout(timer));
                };

                const [snapshotRes, healthRes, previewRes] = await Promise.all([
                    fetchWithTimeout('/api/display/snapshot/' + username + '?key=' + displayToken),
                    fetchWithTimeout('/api/display/health/' + username + '?key=' + displayToken),
                    fetchWithTimeout('/admin/formulas/global-18k-preview', { headers: { 'Accept': 'application/json' } })
                ]);
                const snapshot = await snapshotRes.json();
                const health = await healthRes.json();
                const preview = await previewRes.json();

                const stales = snapshot.priceFeed ? snapshot.priceFeed.filter(item => item.is_stale).length : 0;
                const gold18 = snapshot.priceFeed ? snapshot.priceFeed.find(item => item.symbol === 'gold18')?.value : null;

                // سیستم سالم است اگر API پاسخ بدهد، حتی اگر برخی قیمت‌ها به دلیل بسته بودن بازار استاتیک باشند
                const isHealthy = health && health.status === 'ok';

                this.status = {
                    updatedAt: snapshot.updatedAt ? new Date(snapshot.updatedAt).toLocaleTimeString('fa-IR') : '-',
                    apiStatus: isHealthy ? 'تمامی سرویس‌ها متصل و پایدار' : 'اختلال در دریافت قیمت‌ها',
                    alerts: stales > 0 ? `${stales} قیمت استاتیک (بدون آپدیت)` : 'بدون خطای همگام‌سازی',
                    staleCount: stales,
                    isHealthy: isHealthy,
                    gold18Price: gold18 ? new Intl.NumberFormat('fa-IR').format(Math.round(gold18)) + ' تومان' : 'نامشخص',
                    formula18Price: (preview && preview.gold18Real) ? new Intl.NumberFormat('fa-IR').format(Math.round(preview.gold18Real)) + ' تومان' : 'نامشخص'
                };
            } catch (e) {
                this.status = {
                    updatedAt: '-',
                    apiStatus: 'ارتباط با سرور قطع شده است',
                    alerts: 'لطفا اتصال اینترنت را بررسی کنید',
                    staleCount: 1,
                    isHealthy: false,
                    gold18Price: 'نامشخص',
                    formula18Price: 'نامشخص'
                };
            } finally {
                this.isLoading = false;
                this.$nextTick(() => {
                    if (typeof lucide !== 'undefined' && lucide.createIcons) {
                        lucide.createIcons();
                    }
                });
            }
        }
    };
}
</script>
@endpush
