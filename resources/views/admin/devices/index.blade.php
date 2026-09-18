@extends('admin.layouts.app')

@section('title', 'تلویزیون‌های من')

@section('content')
<div x-data="devicesPage()" class="space-y-6">

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-300 text-sm font-bold shadow-sm">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800/50 text-rose-800 dark:text-rose-300 text-sm font-bold shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- ۱. نوار نمایش لینک تابلوی اختصاصی طلافروشی --}}
    <div class="bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900/60 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
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
            <button @click="copyDisplayUrl()"
                    class="bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold px-4 py-2 rounded-xl text-sm whitespace-nowrap transition-colors cursor-pointer">
                <span x-text="copiedLink ? 'کپی شد! ✓' : 'کپی لینک'"></span>
            </button>
            <a href="{{ url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token) }}" target="_blank"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-xl text-sm whitespace-nowrap transition-colors flex items-center gap-1.5 cursor-pointer">
                مشاهده تابلو <i data-lucide="external-link" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    {{-- ۲. نوار اتصال تلویزیون به تابلوی مغازه (راهنمای مرحله‌ای ویزارد + ثبت کد + اسکن QR) --}}
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

            {{-- ورودی کد دستی ۶ رقمی --}}
            <div class="flex items-center gap-1.5 w-full sm:w-auto">
                <input type="text" maxlength="8" x-model="pairCode" id="mainPairCodeInput" placeholder="کد ۶ رقمی (حروف/اعداد)" dir="ltr"
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

    {{-- Header Card --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="p-3.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl shadow-inner">
                <i data-lucide="tv" class="w-7 h-7"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-800 dark:text-slate-100">تلویزیون‌های متصل به تابلو</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    مدیریت هوشمند، نام‌گذاری و نظارت بر دستگاه‌های تلویزیون و کیوسک‌های اختصاصی گالری
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 text-xs font-bold transition-all">
                <span>داشبورد</span>
            </a>
            <button @click="openWizard()" type="button" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-600/20 transition-all cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>اتصال تلویزیون جدید</span>
            </button>
        </div>
    </div>

    {{-- Device Cards / List --}}
    @if($devices->isEmpty())
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 rounded-3xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="tv-minimal" class="w-8 h-8"></i>
            </div>
            <h3 class="text-base font-black text-slate-700 dark:text-slate-200 mb-2">هنوز هیچ دستگاهی متصل نشده است</h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 max-w-md mx-auto mb-6 leading-relaxed">
                برای نمایش قیمت‌های زنده در ویترین مغازه، اپلیکیشن «طلالایو TV» را روی تلویزیون هوشمند یا اندروید باکس نصب کنید و کد ۶ رقمی را ثبت کنید.
            </p>
            <button @click="openWizard()" type="button" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-lg shadow-blue-600/30 transition-all cursor-pointer">
                <i data-lucide="scan-line" class="w-4 h-4"></i>
                <span>راه‌اندازی و دریافت کد اتصال</span>
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($devices as $dev)
                @php
                    $isRevoked = !is_null($dev->revoked_at);
                    $lastSeenParsed = $dev->last_seen_at ? ($dev->last_seen_at instanceof \DateTimeInterface ? $dev->last_seen_at : \Carbon\Carbon::parse($dev->last_seen_at)) : null;
                    $lastSeenText = $lastSeenParsed ? \App\Models\User::toJalali($lastSeenParsed) : 'نامشخص';
                    $isRecent = $lastSeenParsed && now()->diffInMinutes($lastSeenParsed) < 30;
                @endphp
                <div class="bg-white dark:bg-slate-900 border {{ $isRevoked ? 'border-rose-200 dark:border-rose-900/40 opacity-80' : 'border-slate-200 dark:border-slate-800' }} rounded-3xl p-6 shadow-sm flex flex-col justify-between transition-all hover:shadow-md">
                    <div>
                        {{-- Top status row --}}
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black {{ $isRevoked ? 'bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800/40' : ($isRecent ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/40' : 'bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800/40') }}">
                                <span class="w-2 h-2 rounded-full {{ $isRevoked ? 'bg-rose-500' : ($isRecent ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500') }}"></span>
                                {{ $isRevoked ? 'قطع اتصال شده' : ($isRecent ? 'برخط و متصل' : 'آماده به کار') }}
                            </span>

                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-slate-400 font-mono" title="شناسه دستگاه">
                                    ID: #{{ $dev->id }}
                                </span>
                                {{-- دکمه حذف دائمی دستگاه --}}
                                <form method="POST" action="{{ route('admin.devices.force-delete', $dev) }}" onsubmit="return confirm('آیا از حذف کامل دستگاه «{{ $dev->label ?: ('#' . $dev->id) }}» از سیستم اطمینان دارید؟ این عملیات غیرقابل بازگشت است.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="حذف کامل این تلویزیون" class="p-1.5 text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 rounded-lg transition-colors cursor-pointer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Editable Label Form --}}
                        <form method="POST" action="{{ route('admin.devices.update', $dev) }}" class="mb-4">
                            @csrf
                            @method('PUT')
                            <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1.5">نام / محل نصب تلویزیون</label>
                            <div class="flex items-center gap-2">
                                <input type="text" name="label" value="{{ $dev->label }}" placeholder="مثلاً: تلویزیون ویترین، نمایشگر سالن"
                                       class="flex-1 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-800 dark:text-white focus:outline-none focus:border-blue-500 transition-colors">
                                <button type="submit" title="ذخیره نام" class="p-2 bg-slate-100 dark:bg-slate-800 hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-blue-900/30 dark:hover:text-blue-400 rounded-xl text-slate-500 transition-colors">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </form>

                        {{-- Specs Grid --}}
                        <div class="space-y-2.5 pt-3 border-t border-slate-100 dark:border-slate-800 text-xs">
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400">
                                <span>آخرین بازدید / نبض:</span>
                                <span class="font-bold text-slate-700 dark:text-slate-200 font-mono text-[11px]">{{ $lastSeenText }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400">
                                <span>نسخه اپلیکیشن:</span>
                                <span class="font-bold text-slate-700 dark:text-slate-200 font-mono text-[11px]">{{ $dev->app_version ?: '1' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400">
                                <span>اندروید:</span>
                                <span class="font-bold text-slate-700 dark:text-slate-200 font-mono text-[11px]">{{ $dev->android_release ? 'android ' . $dev->android_release : '---' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400">
                                <span>موتور وب‌ویو:</span>
                                <span class="font-bold text-slate-700 dark:text-slate-200 font-mono text-[11px] truncate max-w-[140px]" title="{{ $dev->webview_version }}">{{ $dev->webview_version ?: '---' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Bottom --}}
                    <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-2">
                        @if(!$isRevoked)
                            <form method="POST" action="{{ route('admin.devices.destroy', $dev) }}" onsubmit="return confirm('آیا از قطع اتصال این تلویزیون اطمینان دارید؟ با قطع اتصال، صفحه تلویزیون متوقف می‌شود.')" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl border border-rose-200 dark:border-rose-900/40 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 text-xs font-bold transition-colors cursor-pointer">
                                    <i data-lucide="power-off" class="w-4 h-4"></i>
                                    <span>قطع اتصال این دستگاه</span>
                                </button>
                            </form>
                        @else
                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('admin.devices.restore', $dev) }}" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors shadow-sm cursor-pointer" title="فعال‌سازی مجدد در صورت باز بودن اپلیکیشن">
                                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                        <span>فعال‌سازی مجدد دستگاه</span>
                                    </button>
                                </form>
                                <button @click="openWizard()" type="button" class="px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold transition-colors cursor-pointer" title="اتصال با پین‌کد جدید">
                                    <span>کد جدید</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- مودال اسکنر بارکد QR با دوربین --}}
    <div x-show="isScannerOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="closeScanner()"
             class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl max-w-md w-full p-6 shadow-2xl text-right relative">
            
            {{-- دکمه بستن --}}
            <button @click="closeScanner()" class="absolute top-6 left-6 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-2xl bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl font-bold">
                    📷
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white">اسکن بارکد تلویزیون</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">دوربین را مقابل بارکد QR روی تلویزیون بگیرید</p>
                </div>
            </div>

            {{-- کادر دوربین / اسکنر --}}
            <div class="relative bg-black rounded-2xl overflow-hidden aspect-square flex items-center justify-center border-2 border-dashed border-indigo-500/40">
                <div id="qr-reader" class="w-full h-full"></div>
                
                {{-- لودینگ وضعیت --}}
                <div x-show="!isCameraRunning && !cameraError" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-950/90 text-white gap-3 p-4 text-center">
                    <i data-lucide="loader-2" class="w-8 h-8 animate-spin text-indigo-400"></i>
                    <span class="text-xs font-bold text-slate-300">در حال فعال‌سازی دوربین...</span>
                </div>

                {{-- خطا در دسترسی به دوربین --}}
                <div x-show="cameraError" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-950/95 text-white gap-3 p-6 text-center">
                    <i data-lucide="alert-triangle" class="w-10 h-10 text-amber-400"></i>
                    <p class="text-xs text-slate-300 leading-relaxed" x-text="cameraError"></p>
                    <div class="flex items-center gap-2 mt-2">
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
                        <span>باز کردن اپلیکیشن یا مرورگر تلویزیون هوشمند</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed pr-8">
                        اپلیکیشن <b class="text-slate-900 dark:text-white">طلالایو TV</b> را اجرا کنید یا مرورگر تلویزیون (سامسونگ: <b class="text-slate-900 dark:text-white">Internet</b> | ال‌جی: <b class="text-slate-900 dark:text-white">Web Browser</b> | اندروید: <b class="text-slate-900 dark:text-white">مرورگر</b>) را باز کرده و نشانی زیر را وارد فرمایید:
                    </p>
                    <div class="pr-8 pt-1 flex items-center gap-3">
                        <span class="inline-block px-3.5 py-1.5 rounded-xl bg-amber-500/10 border border-amber-500/30 font-mono font-black text-sm text-amber-600 dark:text-amber-400" dir="ltr">
                            talalive.ir/tv
                        </span>
                        <a href="{{ url('/downloads/talalive-tv.apk?v=2') }}" target="_blank" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                            ⬇️ دانلود فایل نصبی اندروید TV
                        </a>
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
function devicesPage() {
    return {
        pairCode: '',
        isPairing: false,
        isScannerOpen: false,
        isWizardOpen: false,
        isCameraRunning: false,
        isProcessingPair: false,
        cameraError: null,
        html5QrCodeScanner: null,
        copiedLink: false,

        init() {
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    lucide.createIcons();
                }
            });
        },

        copyDisplayUrl() {
            const input = document.getElementById('displayUrlInput');
            if (input) {
                navigator.clipboard.writeText(input.value);
                this.copiedLink = true;
                setTimeout(() => {
                    this.copiedLink = false;
                }, 2500);
            }
        },

        openWizard() {
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
                    alert((data && data.message) ? data.message : 'کد فعال‌سازی نامعتبر است یا منقضی شده است. لطفا صفحه تلویزیون را رفرش فرمایید.');
                }
            } catch (err) {
                alert('خطا در برقراری ارتباط با سرور. لطفاً مجدداً امتحان کنید.');
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
                    window.location.reload();
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
        }
    };
}
</script>
@endpush
