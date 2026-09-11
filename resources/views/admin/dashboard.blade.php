@extends('admin.layouts.app')

@section('title', 'داشبورد مدیریت')

@section('content')
<div x-data="dashboardPage()" class="space-y-6">
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

                <div class="flex items-center gap-2.5 w-full md:w-auto shrink-0">
                    <a href="tel:09187009064" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-amber-500/20">
                        <span>📞 خرید اشتراک: ۰۹۱۸۷۰۰۹۰۶۴</span>
                    </a>
                    <a href="https://rubika.ir/talalive" target="_blank"
                       class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-purple-600/20">
                        <img src="/images/logos/rubika.png" onerror="this.src='/icons/icon-72x72.png'" class="w-4 h-4 object-contain rounded-md" alt="روبیکا">
                        <span>روبیکا</span>
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

                <div class="flex items-center gap-2.5 w-full md:w-auto shrink-0">
                    <a href="tel:09187009064" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-amber-500/20">
                        <span>📞 تمدید اشتراک: ۰۹۱۸۷۰۰۹۰۶۴</span>
                    </a>
                    <a href="https://rubika.ir/talalive" target="_blank"
                       class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-purple-600/20">
                        <img src="/images/logos/rubika.png" onerror="this.src='/icons/icon-72x72.png'" class="w-4 h-4 object-contain rounded-md" alt="روبیکا">
                        <span>روبیکا</span>
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

                <div class="flex items-center gap-2.5 w-full md:w-auto shrink-0">
                    <a href="https://rubika.ir/talalive" target="_blank"
                       class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-purple-600/20">
                        <img src="/images/logos/rubika.png" onerror="this.src='/icons/icon-72x72.png'" class="w-4 h-4 object-contain rounded-md" alt="روبیکا">
                        <span>پشتیبانی روبیکا</span>
                    </a>
                </div>
            </div>
        @endif
    @endif

    {{-- لینک صفحه نمایش اختصاصی طلا --}}
    <div class="bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900/60 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
                <i data-lucide="tv" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-blue-900 dark:text-blue-200">لینک تابلوی نمایشی طلافروشی شما</h3>
                <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">از این لینک امن یا اسکن QR کد در تلویزیون مغازه استفاده کنید تا تابلوی اختصاصی شما به نمایش درآید.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 w-full md:w-auto" dir="ltr">
            <input type="text" readonly value="{{ url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token) }}" id="displayUrlInput"
                   class="bg-white dark:bg-slate-900 border border-blue-200 dark:border-blue-900 rounded-xl px-4 py-2 text-sm text-blue-900 dark:text-blue-300 w-full md:w-80 select-all font-mono">
            <button onclick="navigator.clipboard.writeText(document.getElementById('displayUrlInput').value); alert('لینک کپی شد!');"
                    class="bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold px-4 py-2 rounded-xl text-sm whitespace-nowrap transition-colors cursor-pointer">
                کپی لینک
            </button>
            <a href="{{ url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token) }}" target="_blank"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-xl text-sm whitespace-nowrap transition-colors flex items-center gap-1.5 cursor-pointer">
                مشاهده تابلو <i data-lucide="external-link" class="w-4 h-4"></i>
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
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">اتصال تلویزیون به تابلوی مغازه</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">با دوربین گوشی بارکد (QR Code) تلویزیون را اسکن کنید یا کد ۶ رقمی را دستی وارد نمایید.</p>
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
                <span style="color: #ffffff !important; font-weight: 800 !important;">اسکن بارکد تلویزیون (QR)</span>
            </button>

            <span class="hidden sm:inline text-xs text-slate-400 font-bold px-1">یا</span>

            {{-- ورودی کد دستی ۶ رقمی --}}
            <div class="flex items-center gap-1.5 w-full sm:w-auto">
                <input type="text" maxlength="6" x-model="pairCode" placeholder="کد ۶ رقمی" dir="ltr"
                       class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-850 dark:text-slate-100 w-full sm:w-36 text-center font-mono font-bold uppercase placeholder:font-sans placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                <button @click="pairWithCodeManual()" :disabled="isPairing"
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
                <button @click="loadData()" class="p-3 rounded-full bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
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
                    <h3 class="text-3xl font-black mt-1 text-blue-600 dark:text-blue-400 tabular-nums"
                        x-text="isLoading ? '...' : status.formula18Price"></h3>
                </div>
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
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
        <a href="{{ route('admin.formulas') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-blue-300 dark:hover:border-blue-700 hover:shadow-md transition-all">
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="variable" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">مدیریت فرمول‌ها</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-indigo-300 dark:hover:border-indigo-700 hover:shadow-md transition-all">
            <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="gem" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">تصاویر و اسلایدر</span>
        </a>
        <a href="{{ route('admin.display-control') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-emerald-300 dark:hover:border-emerald-700 hover:shadow-md transition-all">
            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="monitor" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">تنظیمات تابلو و پوسته</span>
        </a>
        @if(auth()->user()->is_super_admin)
        <a href="{{ route('admin.sources') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-amber-300 dark:hover:border-amber-700 hover:shadow-md transition-all">
            <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
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
</div>
@endsection

@push('styles')
<style>
    .qr-scan-btn {
        background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35) !important;
    }
    .qr-scan-btn:hover {
        background: linear-gradient(135deg, #4338ca 0%, #312e81 100%) !important;
        box-shadow: 0 6px 18px rgba(79, 70, 229, 0.5) !important;
        transform: translateY(-1px);
    }
    .qr-scan-modal-btn {
        background: #4f46e5 !important;
        color: #ffffff !important;
    }
    .qr-scan-modal-btn:hover {
        background: #4338ca !important;
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
        isCameraRunning: false,
        isProcessingPair: false,
        cameraError: null,
        html5QrCodeScanner: null,

        async init() {
            await this.loadData();
            setInterval(() => this.loadData(), 30000);
        },

        async pairWithCodeManual() {
            const code = this.pairCode.trim().toUpperCase();
            if (!code || code.length < 6) {
                alert('لطفا کد ۶ رقمی معتبر را وارد کنید.');
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
                    alert(data.message || 'تلویزیون با موفقیت متصل شد.');
                    this.pairCode = '';
                    await this.loadData();
                } else {
                    alert((data && data.message) ? data.message : 'خطا در اتصال');
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
            if (sessMatch) {
                sessionCode = sessMatch[0];
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
