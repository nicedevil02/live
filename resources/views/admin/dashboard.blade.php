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

    {{-- چک‌لیست هوشمند راه‌اندازی ۴ مرحله‌ای گالری طلا --}}
    @if(!auth()->user()->is_super_admin && isset($onboardingChecklist) && !$onboardingChecklist['is_all_done'])
        <div x-data="{ hideChecklist: localStorage.getItem('talalive_hide_checklist_{{ auth()->id() }}') === '1' }"
             x-show="!hideChecklist"
             x-cloak
             class="rounded-2xl sm:rounded-3xl p-4 sm:p-6 bg-white dark:bg-slate-900 border-2 border-amber-500/35 shadow-md space-y-4">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pb-3.5 border-b border-slate-100 dark:border-slate-800">
                <div class="space-y-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center gap-2 flex-wrap min-w-0">
                            <span class="text-base sm:text-lg shrink-0">🚀</span>
                            <h2 class="text-xs sm:text-base font-black text-slate-900 dark:text-white">
                                راهنمای شروع سریع و راه‌اندازی تابلوی گالری
                            </h2>
                            <span class="px-2.5 py-0.5 rounded-full text-[10.5px] sm:text-[11px] font-black bg-amber-500/15 text-amber-700 dark:text-amber-300 border border-amber-500/30">
                                {{ $onboardingChecklist['completed_count'] }} از {{ $onboardingChecklist['total_count'] }} تکمیل شده ({{ $onboardingChecklist['progress_percent'] }}٪)
                            </span>
                        </div>
                        <button type="button"
                                @click="hideChecklist = true; localStorage.setItem('talalive_hide_checklist_{{ auth()->id() }}', '1')"
                                title="مخفی کردن چک‌لیست"
                                class="md:hidden p-1.5 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer shrink-0">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <p class="text-[11.5px] sm:text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                        با تکمیل این ۴ گام کوتاه، بیشترین بازدهی و زیبایی را روی تلویزیون ویترین یا سالن مغازه خواهید داشت.
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:flex items-center gap-2 w-full md:w-auto shrink-0">
                    <button type="button"
                            onclick="window.startTalaliveSpotlightTour && window.startTalaliveSpotlightTour()"
                            class="px-3 py-2.5 sm:py-2 rounded-xl bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/30 text-indigo-700 dark:text-indigo-300 text-xs font-black transition-all cursor-pointer flex items-center justify-center gap-1.5 whitespace-nowrap">
                        <span>✨</span>
                        <span>تور نوری منوها</span>
                    </button>
                    <button type="button"
                            onclick="window.openTalaliveGuide && window.openTalaliveGuide('panel')"
                            class="px-3 py-2.5 sm:py-2 rounded-xl bg-amber-500/15 hover:bg-amber-500/25 border border-amber-500/30 text-amber-800 dark:text-amber-300 text-xs font-black transition-all cursor-pointer flex items-center justify-center gap-1.5 whitespace-nowrap">
                        <span>🎓</span>
                        <span>آموزش کامل پنل</span>
                    </button>
                    <button type="button"
                            @click="hideChecklist = true; localStorage.setItem('talalive_hide_checklist_{{ auth()->id() }}', '1')"
                            title="مخفی کردن چک‌لیست"
                            class="hidden md:inline-flex p-2 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            {{-- نوار پیشرفت --}}
            <div class="w-full h-2 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                <div class="h-full bg-gradient-to-l from-emerald-500 to-amber-500 rounded-full transition-all duration-500"
                     style="width: {{ $onboardingChecklist['progress_percent'] }}%;"></div>
            </div>

            {{-- کارت‌های ۴ گام راه‌اندازی --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-1">
                {{-- گام ۱: ساخت حساب --}}
                <div class="p-4 rounded-2xl border bg-emerald-50/60 dark:bg-emerald-950/25 border-emerald-200 dark:border-emerald-800/50 flex flex-col justify-between gap-3">
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="w-6 h-6 rounded-full bg-emerald-500 text-white text-xs font-black flex items-center justify-center">✓</span>
                            <span class="text-[10px] font-black text-emerald-700 dark:text-emerald-400">انجام شد</span>
                        </div>
                        <h3 class="text-xs font-black text-slate-900 dark:text-white">۱. ساخت تابلوی اختصاصی</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">تابلوی نرخ‌های زنده گالری شما فعال و آماده پخش است.</p>
                    </div>
                </div>

                {{-- گام ۲: اتصال تلویزیون مغازه --}}
                <div class="p-4 rounded-2xl border {{ $onboardingChecklist['tv_connected'] ? 'bg-emerald-50/60 dark:bg-emerald-950/25 border-emerald-200 dark:border-emerald-800/50' : 'bg-slate-50 dark:bg-slate-950/70 border-slate-200 dark:border-slate-800' }} flex flex-col justify-between gap-3">
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            @if($onboardingChecklist['tv_connected'])
                                <span class="w-6 h-6 rounded-full bg-emerald-500 text-white text-xs font-black flex items-center justify-center">✓</span>
                                <span class="text-[10px] font-black text-emerald-700 dark:text-emerald-400">متصل شد</span>
                            @else
                                <span class="w-6 h-6 rounded-full bg-amber-500 text-slate-950 text-xs font-black flex items-center justify-center">۲</span>
                                <span class="text-[10px] font-bold text-amber-600 dark:text-amber-400">گام مهم</span>
                            @endif
                        </div>
                        <h3 class="text-xs font-black text-slate-900 dark:text-white">۲. اتصال تلویزیون مغازه</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">اتصال تلویزیون هوشمند یا تی‌وی‌باکس با کد ۶ رقمی.</p>
                    </div>
                    @if(!$onboardingChecklist['tv_connected'])
                        <button type="button"
                                onclick="window.openTalaliveGuide && window.openTalaliveGuide('tv')"
                                class="w-full py-2 px-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-black transition-all cursor-pointer text-center shadow-xs">
                            📺 آموزش و اتصال تلویزیون
                        </button>
                    @endif
                </div>

                {{-- گام ۳: افزودن محصول به ویترین --}}
                <div class="p-4 rounded-2xl border {{ $onboardingChecklist['product_added'] ? 'bg-emerald-50/60 dark:bg-emerald-950/25 border-emerald-200 dark:border-emerald-800/50' : 'bg-slate-50 dark:bg-slate-950/70 border-slate-200 dark:border-slate-800' }} flex flex-col justify-between gap-3">
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            @if($onboardingChecklist['product_added'])
                                <span class="w-6 h-6 rounded-full bg-emerald-500 text-white text-xs font-black flex items-center justify-center">✓</span>
                                <span class="text-[10px] font-black text-emerald-700 dark:text-emerald-400">ثبت شد</span>
                            @else
                                <span class="w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-black flex items-center justify-center">۳</span>
                                <span class="text-[10px] font-bold text-slate-400">پیشنهادی</span>
                            @endif
                        </div>
                        <h3 class="text-xs font-black text-slate-900 dark:text-white">۳. افزودن طلا به ویترین</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">نمایش عکس و قیمت لحظه‌ای کارهای طلا در کنار نرخ‌ها.</p>
                    </div>
                    @if(!$onboardingChecklist['product_added'])
                        <a href="{{ route('admin.products.index') }}"
                           class="w-full py-2 px-3 rounded-xl bg-white dark:bg-slate-900 hover:border-amber-500 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold transition-all text-center">
                            💍 افزودن اولین محصول &larr;
                        </a>
                    @endif
                </div>

                {{-- گام ۴: تنظیم پروفایل و QR شبکه اجتماعی --}}
                <div class="p-4 rounded-2xl border {{ $onboardingChecklist['profile_customized'] ? 'bg-emerald-50/60 dark:bg-emerald-950/25 border-emerald-200 dark:border-emerald-800/50' : 'bg-slate-50 dark:bg-slate-950/70 border-slate-200 dark:border-slate-800' }} flex flex-col justify-between gap-3">
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            @if($onboardingChecklist['profile_customized'])
                                <span class="w-6 h-6 rounded-full bg-emerald-500 text-white text-xs font-black flex items-center justify-center">✓</span>
                                <span class="text-[10px] font-black text-emerald-700 dark:text-emerald-400">تنظیم شد</span>
                            @else
                                <span class="w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-black flex items-center justify-center">۴</span>
                                <span class="text-[10px] font-bold text-slate-400">برندینگ</span>
                            @endif
                        </div>
                        <h3 class="text-xs font-black text-slate-900 dark:text-white">۴. بارکد QR و پوسته گالری</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">ثبت اینستاگرام یا روبیکا جهت نمایش QR کد روی تلویزیون.</p>
                    </div>
                    @if(!$onboardingChecklist['profile_customized'])
                        <a href="{{ route('admin.shop-profile') }}"
                           class="w-full py-2 px-3 rounded-xl bg-white dark:bg-slate-900 hover:border-amber-500 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold transition-all text-center">
                            🏪 تنظیم پروفایل و QR &larr;
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
    {{-- نوار پیشنهاد ویژه ۴۸ ساعت اول ثبت‌نام --}}
    @if(!empty($isWelcomePeriod))
        <div class="rounded-2xl p-4 sm:p-5 border-2 border-amber-500/60 bg-gradient-to-r from-amber-500/15 via-slate-900 to-amber-950/30 text-white shadow-xl shadow-amber-500/10 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center font-black text-2xl shrink-0 shadow-md shadow-amber-500/30">
                    🔥
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-sm sm:text-base font-black text-amber-400">پیشنهاد طلایی راه‌اندازی گالری شما (محدود به ۴۸ ساعت اول)</h3>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-black bg-rose-500 text-white">
                            {{ $welcomeHoursLeft }} ساعت تا انقضا
                        </span>
                    </div>
                    <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                        اشتراک سالانه الماس طلالایو به جای <span class="line-through text-slate-400">۴,۷۰۰,۰۰۰ تومان</span>، فقط با <strong class="text-amber-300 text-sm font-black">۳,۹۶۰,۰۰۰ تومان</strong> برای شما محاسبه می‌شود (۷۴۰,۰۰۰ تومان تخفیف ویژه افتتاحیه).
                    </p>
                </div>
            </div>

            <div class="shrink-0 w-full md:w-auto">
                <a href="{{ route('admin.subscription.index') }}"
                   class="w-full md:w-auto px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-400 via-amber-500 to-amber-400 hover:from-amber-300 hover:to-amber-400 text-slate-950 font-black text-xs transition-all shadow-md shadow-amber-500/25 flex items-center justify-center gap-2">
                    <span>خرید با تخفیف ویژه (۳,۹۶۰,۰۰۰ ت)</span>
                    <span>&larr;</span>
                </a>
            </div>
        </div>
    @endif

    {{-- کارت اختصاصی درخواست تماس و نصب رایگان تلویزیون توسط کارشناس --}}
    @if(!empty($onboardingChecklist) && !$onboardingChecklist['tv_connected'])
        <div x-data="{ requested: false, loading: false, msg: '' }" class="rounded-2xl p-4 sm:p-5 border border-indigo-500/30 bg-gradient-to-r from-indigo-950/40 via-slate-900 to-slate-900 shadow-lg flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center font-black text-2xl shrink-0">
                    📺
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm sm:text-base font-black text-white">در اتصال تلویزیون مغازه نیاز به راهنمایی دارید؟</h3>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">۱۰۰٪ رایگان</span>
                    </div>
                    <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                        کارشناس فنی طلالایو در کمتر از ۳ دقیقه پشت تلفن، تابلوی زنده طلا را روی تلویزیون مغازه شما روشن می‌کند.
                    </p>
                    <div x-show="msg" x-text="msg" class="text-xs font-bold text-emerald-400 mt-1.5" x-cloak></div>
                </div>
            </div>

            <div class="shrink-0 w-full md:w-auto">
                <button type="button"
                        x-show="!requested"
                        :disabled="loading"
                        @click="
                            loading = true;
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
                                loading = false;
                                if(data.success) {
                                    requested = true;
                                    msg = data.message;
                                }
                            })
                            .catch(e => { loading = false; });
                        "
                        class="w-full md:w-auto px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-black text-xs transition-all shadow-md shadow-indigo-600/30 flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
                    <span x-show="!loading">📞 درخواست تماس و نصب رایگان</span>
                    <span x-show="loading" x-cloak>در حال ثبت درخواست...</span>
                </button>

                <div x-show="requested" x-cloak class="px-4 py-2.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 font-black text-xs flex items-center justify-center gap-1.5">
                    <span>✓</span>
                    <span>درخواست ثبت شد؛ به زودی تماس می‌گیریم</span>
                </div>
            </div>
        </div>
    @endif

    {{-- نوار وضعیت اشتراک / دوره آزمایشی (مخصوص گالری‌های غیر سوپرادمین) --}}
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
            <div class="rounded-2xl p-5 border {{ $isUrgent ? 'bg-gradient-to-r from-rose-50 via-rose-50/70 to-rose-100/60 dark:from-rose-950/40 dark:via-slate-900 dark:to-slate-900 border-rose-200 dark:border-rose-500/30' : 'bg-gradient-to-r from-amber-50 via-amber-50/70 to-amber-100/70 dark:from-amber-950/40 dark:via-slate-900 dark:to-slate-900 border-amber-200 dark:border-amber-500/30' }} flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl {{ $isUrgent ? 'bg-rose-100 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-500/30' : 'bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30' }} flex items-center justify-center font-black text-2xl shrink-0">
                        {{ $isUrgent ? '⚠️' : '🎁' }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">دوره آزمایشی رایگان فعال است</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-black {{ $isUrgent ? 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-300 border border-rose-200 dark:border-rose-500/30' : 'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300 border border-amber-200 dark:border-amber-500/30' }}">
                                {{ $daysLeft }} روز باقی مانده
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                            شما می‌توانید از تمامی امکانات تابلوی تلویزیون، فرمول‌ساز و اسلایدشوی محصولات بدون محدودیت استفاده نمایید. جهت خرید اشتراک سالانه با پشتیبانی فنی طلالایو تماس بگیرید.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 w-full md:w-auto shrink-0 flex-wrap">
                    <a href="{{ route('admin.subscription.index') }}" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-amber-500/20 cursor-pointer">
                        <i data-lucide="crown" class="w-4 h-4"></i>
                        <span>خرید آنلاین اشتراک</span>
                    </a>
                    <a href="tel:09187009064" class="flex-1 md:flex-none px-3.5 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs transition-all flex items-center justify-center gap-1.5">
                        <span>📞 تماس: ۰۹۱۸۷۰۰۹۰۶۴</span>
                    </a>
                    <a href="https://t.me/talalive" rel="noopener noreferrer" target="_blank"
                       class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-purple-600/20">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></svg>
                        <span>پشتیبانی تلگرام</span>
                    </a>
                </div>
            </div>
        @elseif($isWarning)
            {{-- ۲. اشتراک خریداری‌شده رو به پایان (کمتر یا مساوی ۷ روز مانده) --}}
            <div class="rounded-2xl p-5 border bg-gradient-to-r from-amber-50 via-rose-50/50 to-rose-100/60 dark:from-rose-950/40 dark:via-slate-900 dark:to-slate-900 border-rose-200 dark:border-rose-500/30 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-500/30 flex items-center justify-center font-black text-2xl shrink-0">
                        ⚠️
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">اعتبار اشتراک شما رو به پایان است</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-300 border border-rose-200 dark:border-rose-500/30">
                                {{ $daysLeft }} روز باقی مانده (انقضا: {{ $jalaliExpire }})
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                            اعتبار زمانی تابلوی اختصاصی شما به زودی به پایان می‌رسد. لطفاً جهت جلوگیری از قطع پخش تلویزیون مغازه، نسبت به تمدید اشتراک اقدام فرمایید.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 w-full md:w-auto shrink-0 flex-wrap">
                    <a href="{{ route('admin.subscription.index') }}" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-amber-500/20 cursor-pointer">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        <span>تمدید آنلاین اشتراک</span>
                    </a>
                    <a href="tel:09187009064" class="flex-1 md:flex-none px-3.5 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs transition-all flex items-center justify-center gap-1.5">
                        <span>📞 تماس: ۰۹۱۸۷۰۰۹۰۶۴</span>
                    </a>
                    <a href="https://t.me/talalive" rel="noopener noreferrer" target="_blank"
                       class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-purple-600/20">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></svg>
                        <span>پشتیبانی تلگرام</span>
                    </a>
                </div>
            </div>
        @else
            {{-- ۳. اشتراک رسمی و فعال (سبز زمردی / سرمه‌ای لوکس با آرامش خاطر برای مشتری) --}}
            <div class="rounded-2xl p-5 border bg-gradient-to-r from-emerald-50 via-teal-50/60 to-emerald-100/60 dark:from-emerald-950/40 dark:via-slate-900 dark:to-slate-900 border-emerald-200 dark:border-emerald-500/30 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30 flex items-center justify-center font-black text-2xl shrink-0">
                        💎
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">اشتراک رسمی طلالایو فعال است</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30">
                                {{ $daysLeft }} روز تا پایان اعتبار (تا {{ $jalaliExpire }})
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                            تمامی امکانات تابلوی هوشمند تلویزیون، فرمول‌ساز سود و ویترین طلا برای گالری <span class="font-bold text-slate-800 dark:text-slate-100">{{ auth()->user()->name }}</span> فعال و بدون محدودیت است.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 w-full md:w-auto shrink-0 flex-wrap">
                    <a href="{{ route('admin.subscription.index') }}" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-sm cursor-pointer">
                        <i data-lucide="crown" class="w-4 h-4 text-amber-400"></i>
                        <span>ارتقا / تمدید بسته</span>
                    </a>
                    <a href="https://t.me/talalive" rel="noopener noreferrer" target="_blank"
                       class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-purple-600/20">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></svg>
                        <span>پشتیبانی تلگرام</span>
                    </a>
                </div>
            </div>
        @endif
    @endif

    {{-- لینک صفحه نمایش اختصاصی طلا با استایل لوکس طلایی --}}
    <div class="rounded-3xl p-6 flex flex-col md:flex-row items-center justify-between gap-4 border border-amber-500/30 bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent dark:from-amber-950/40 dark:via-stone-900/80 dark:to-stone-900/80 shadow-lg shadow-amber-500/5">
        <div class="flex items-center gap-3.5">
            <div class="p-3.5 bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-2xl border border-amber-500/30 shadow-sm shrink-0">
                <i data-lucide="tv" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-base font-black text-slate-900 dark:text-amber-300">لینک تابلوی نمایشی اختصاصی شما</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-stone-300 mt-1">از این لینک امن یا اسکن QR کد در تلویزیون مغازه استفاده کنید تا تابلوی اختصاصی شما با نرخ‌های زنده پخش شود.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 w-full md:w-auto" dir="ltr">
            <input type="text" readonly value="{{ url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token) }}" id="displayUrlInput"
                   class="tl-neu-inset rounded-xl px-4 py-2.5 text-xs sm:text-sm text-slate-900 dark:text-amber-300 w-full md:w-80 select-all font-mono font-bold">
            <button onclick="navigator.clipboard.writeText(document.getElementById('displayUrlInput').value); alert('لینک اختصاصی کپی شد!');"
                    class="tl-neu-btn px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap cursor-pointer">
                کپی لینک
            </button>
            <a href="{{ url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token) }}" target="_blank"
               class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-xs sm:text-sm whitespace-nowrap shadow-md shadow-amber-500/25 transition-all flex items-center gap-1.5 cursor-pointer">
                <span>مشاهده تابلو</span> <i data-lucide="external-link" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    {{-- اتصال تلویزیون با کد فعال‌سازی یا اسکن بارکد QR --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col lg:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 rounded-xl shrink-0">
                <i data-lucide="tv-2" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">اتصال تلویزیون به تابلوی مغازه</h3>
                    <button @click="openWizard()" type="button" class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-amber-500/15 text-amber-700 dark:text-amber-400 border border-amber-500/30 hover:bg-amber-500/25 transition-colors cursor-pointer">
                        ✨ راهنمای مرحله‌ای (ویزارد)
                    </button>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">پین ۶ رقمی نمایش داده شده روی تلویزیون را وارد کنید یا با دوربین بارکد را اسکن نمایید.</p>
            </div>
        </div>
        
        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full lg:w-auto">
            {{-- دکمه اسکن بارکد QR با دوربین --}}
            <button @click="openScanner()" 
                    type="button"
                    class="qr-scan-btn flex-1 sm:flex-none font-bold px-4 py-2.5 rounded-xl text-sm whitespace-nowrap transition-all shadow-md hover:scale-[1.02] cursor-pointer flex items-center justify-center gap-2"
                    style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%) !important; color: #ffffff !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35) !important;">
                <svg class="w-4 h-4 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span style="color: #ffffff !important; font-weight: 800 !important;">اسکن بارکد (QR)</span>
            </button>

            <span class="hidden sm:inline text-xs text-slate-400 font-bold px-1">یا</span>

            {{-- ورودی کد دستی ۶ رقمی با پشتیبانی کامل از حروف انگلیسی و ارقام --}}
            <div class="flex items-center gap-1.5 w-full sm:w-auto">
                <input type="text" maxlength="8" x-model="pairCode" placeholder="کد ۶ رقمی (حروف/اعداد)" dir="ltr"
                       @keydown.enter.prevent="pairWithCodeManual()"
                       @input="
                           let val = pairCode.toString();
                           const p = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
                           const e = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
                           for(let i=0; i<p.length; i++) val = val.replaceAll(p[i], e[i]);
                           pairCode = val.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 6);
                       "
                       class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-850 dark:text-slate-100 w-full sm:w-40 text-center font-mono font-bold placeholder:font-sans placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                <button @click="pairWithCodeManual()" :disabled="isPairing || pairCode.length < 6"
                        class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-4 py-2 rounded-xl text-sm whitespace-nowrap transition-all hover:scale-[1.01] cursor-pointer disabled:opacity-50 flex items-center justify-center gap-1.5 shrink-0">
                    <span x-text="isPairing ? 'در حال اتصال...' : 'ثبت کد'"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- Header Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Status Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">وضعیت کلی سیستم</p>
                    <h3 class="text-lg font-bold mt-1"
                        :class="status.isHealthy ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'"
                        x-text="status.apiStatus"></h3>
                </div>
                <div class="p-3 rounded-full"
                     :class="status.isHealthy ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:text-rose-400'">
                    <i x-show="status.isHealthy" data-lucide="check-circle" class="w-6 h-6"></i>
                    <i x-show="!status.isHealthy" data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-1 text-sm text-slate-600 dark:text-slate-400">
                <span class="flex items-center gap-1.5" x-text="status.isHealthy ? '📡 تمامی سرویس‌ها متصل و پایدار' : '🚨 نیاز به بررسی مجدد منابع یا اتصال'"></span>
            </div>
        </div>

        {{-- Sync Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">آخرین همگام‌سازی تابلو</p>
                    <h3 class="text-3xl font-black mt-1 text-slate-800 dark:text-slate-100 tabular-nums"
                        x-text="isLoading ? '...' : status.updatedAt"></h3>
                </div>
                <button @click="loadData()" class="p-3 rounded-full bg-amber-500/15 text-amber-600 dark:text-amber-400 hover:bg-amber-500/25 border border-amber-500/20 transition-all cursor-pointer">
                    <i data-lucide="refresh-cw" :class="isLoading ? 'animate-spin' : ''" class="w-6 h-6"></i>
                </button>
            </div>
            <div class="mt-4 flex flex-col gap-1 text-sm text-slate-600 dark:text-slate-400">
                <span class="flex items-center gap-1.5">💾 رفرش خودکار هر ۳۰ ثانیه</span>
            </div>
        </div>

        {{-- Alert Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">هشدارهای قیمت</p>
                    <h3 class="text-lg font-bold mt-1"
                        :class="status.staleCount > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-slate-800 dark:text-slate-100'"
                        x-text="status.alerts"></h3>
                </div>
                <div class="p-3 rounded-full"
                     :class="status.staleCount > 0 ? 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400'">
                    <i x-show="status.staleCount > 0" data-lucide="alert-circle" class="w-6 h-6"></i>
                    <i x-show="status.staleCount === 0" data-lucide="check-circle-2" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-1 text-sm text-slate-600 dark:text-slate-400">
                <span class="flex items-center gap-1.5">📈 عدم آپدیت ناشی از بسته بودن بازار است</span>
            </div>
        </div>

        {{-- Gold 18k Live Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">قیمت طلای ۱۸ عیار تابلو</p>
                    <h3 class="text-3xl font-black mt-1 text-amber-600 dark:text-amber-400 tabular-nums"
                        x-text="isLoading ? '...' : status.gold18Price"></h3>
                </div>
                <div class="p-3 rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                    <i data-lucide="trending-up" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-1 text-sm text-slate-600 dark:text-slate-400">
                <span class="flex items-center gap-1.5">قیمت پایه برای فرمول‌های خرید و پیش‌نمایش</span>
            </div>
        </div>

        {{-- Gold 18k Formula Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">قیمت محاسبه‌شده طلای ۱۸ عیار جهانی</p>
                    <h3 class="text-3xl font-black mt-1 text-amber-600 dark:text-amber-400 tabular-nums"
                        x-text="isLoading ? '...' : status.formula18Price"></h3>
                </div>
                <div class="p-3 rounded-full bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/25">
                    <i data-lucide="calculator" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-1 text-sm text-slate-600 dark:text-slate-400">
                <span class="flex items-center gap-1.5">خروجی مستقیم بخش نحوه محاسبه اونس و دلار</span>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 pt-4">دسترسی سریع</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.formulas') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-amber-400/50 hover:shadow-xl hover:shadow-amber-500/10 hover:-translate-y-1 transition-all">
            <div class="w-12 h-12 bg-amber-500/15 border border-amber-500/25 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="variable" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">مدیریت فرمول‌ها</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-amber-400/50 hover:shadow-xl hover:shadow-amber-500/10 hover:-translate-y-1 transition-all">
            <div class="w-12 h-12 bg-amber-500/15 border border-amber-500/25 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="gem" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">تصاویر و اسلایدر</span>
        </a>
        <a href="{{ route('admin.display-control') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-emerald-400/50 hover:shadow-xl hover:shadow-emerald-500/10 hover:-translate-y-1 transition-all">
            <div class="w-12 h-12 bg-emerald-500/15 border border-emerald-500/25 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="monitor" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">تنظیمات تابلو و پوسته</span>
        </a>
        @if(auth()->user()->is_super_admin)
        <a href="{{ route('admin.sources') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-amber-400/50 hover:shadow-xl hover:shadow-amber-500/10 hover:-translate-y-1 transition-all">
            <div class="w-12 h-12 bg-amber-500/15 border border-amber-500/25 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="rss" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">پیکربندی API</span>
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
