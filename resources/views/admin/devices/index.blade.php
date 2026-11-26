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

    @php
        $directBoardUrl = url('/' . auth()->user()->username);
        $directBoardDisplay = preg_replace('#^https?://#i', '', $directBoardUrl);
        $activeDevicesCount = $devices->whereNull('revoked_at')->count();
    @endphp
    {{-- هاب یکپارچه مدیریت و اتصال تلویزیون‌های گالری --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm">
        {{-- بخش بالایی: عنوان، اتصال سریع با کد ۶ رقمی و اسکنر QR --}}
        <div class="p-5 sm:p-6 flex flex-col xl:flex-row xl:items-center justify-between gap-5">
            <div class="flex items-start gap-3.5 min-w-0">
                <div class="p-3 bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/25 rounded-2xl shrink-0">
                    <i data-lucide="tv" class="w-6 h-6"></i>
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h2 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">تلویزیون‌های من</h2>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black {{ $activeDevicesCount > 0 ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/40' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                            {{ $activeDevicesCount }} نمایشگر فعال
                        </span>
                        <button @click="openWizard()" type="button" class="px-3 py-1 rounded-full text-[11px] font-bold bg-amber-500/10 hover:bg-amber-500/20 text-amber-700 dark:text-amber-300 border border-amber-500/30 transition-colors cursor-pointer">
                            راهنمای گام‌به‌گام اتصال
                        </button>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                        در مرورگر تلویزیون مغازه آدرس <strong class="font-mono text-amber-700 dark:text-amber-300" dir="ltr">talalive.ir/tv</strong> را باز کنید و کد ۶ رقمی را اینجا بزنید؛ یا مستقیماً آدرس <strong class="font-mono text-amber-700 dark:text-amber-300" dir="ltr">{{ $directBoardDisplay }}</strong> را در نوار آدرس مرورگر وارد نمایید.
                    </p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-start gap-2.5 shrink-0">
                <button @click="openScanner()"
                        type="button"
                        class="qr-scan-btn font-bold px-4 h-11 rounded-xl text-xs sm:text-sm whitespace-nowrap transition-all cursor-pointer flex items-center justify-center gap-2">
                    <i data-lucide="camera" class="w-4 h-4 shrink-0"></i>
                    <span>اسکن بارکد QR</span>
                </button>

                <div>
                    <div class="flex items-center gap-2">
                        <input type="text"
                               maxlength="8"
                               x-model="pairCode"
                               :inputmode="pairAlphaMode ? 'text' : 'numeric'"
                               autocomplete="one-time-code"
                               id="mainPairCodeInput"
                               placeholder="کد ۶ رقمی تلویزیون"
                               dir="ltr"
                               @keydown.enter.prevent="pairWithCodeManual()"
                               @input="handlePairCodeInput()"
                               class="h-11 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 text-sm text-slate-900 dark:text-white w-full sm:w-44 text-center font-mono font-bold tracking-widest placeholder:font-sans placeholder:font-normal placeholder:tracking-normal focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                        <button @click="pairWithCodeManual()" :disabled="isPairing || pairCode.length < 6"
                                class="h-11 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black px-4 rounded-xl text-xs sm:text-sm whitespace-nowrap transition-colors cursor-pointer disabled:opacity-50 flex items-center justify-center gap-1.5 shrink-0">
                            <span x-text="isPairing ? 'در حال اتصال...' : 'ثبت کد'"></span>
                        </button>
                    </div>
                    <button type="button"
                            @click="pairAlphaMode = !pairAlphaMode"
                            class="mt-1.5 text-[11px] font-semibold text-slate-500 dark:text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 cursor-pointer block"
                            x-text="pairAlphaMode ? 'بازگشت به صفحه‌کلید عددی' : 'کد شامل حروف انگلیسی است؟ تغییر صفحه‌کلید'"></button>
                </div>
            </div>
        </div>

        {{-- نوار فشرده آدرس مستقیم پخش تابلو --}}
        <div class="px-5 sm:px-6 py-3.5 bg-slate-50/80 dark:bg-slate-950/60 border-t border-slate-200/80 dark:border-slate-800/80 flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300 font-semibold shrink-0">
                <i data-lucide="link-2" class="w-4 h-4 text-amber-600 dark:text-amber-400"></i>
                <span>آدرس مستقیم تابلوی گالری (قابل وارد کردن در نوار آدرس مرورگر تلویزیون):</span>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 flex-1 md:max-w-xl min-w-0" dir="ltr">
                <input type="text" readonly value="{{ $directBoardUrl }}" id="displayUrlInput"
                       class="tl-neu-inset rounded-xl px-3.5 py-2 text-xs text-slate-800 dark:text-amber-300 flex-1 min-w-0 select-all font-mono font-bold">
                <div class="grid grid-cols-2 sm:flex items-center gap-2 shrink-0" dir="rtl">
                    <button @click="copyDisplayUrl()" type="button"
                            class="tl-neu-btn px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap cursor-pointer text-center">
                        <span x-text="copiedLink ? 'کپی شد ✓' : 'کپی آدرس'"></span>
                    </button>
                    <a href="{{ $directBoardUrl }}" target="_blank"
                       class="px-3.5 py-2 rounded-xl bg-stone-900 dark:bg-stone-100 hover:bg-stone-800 dark:hover:bg-white text-amber-400 dark:text-stone-950 font-black text-xs whitespace-nowrap transition-colors flex items-center justify-center gap-1.5 cursor-pointer">
                        <span>مشاهده تابلو</span> <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Device Cards / List --}}
    @if($devices->isEmpty())
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-8 sm:p-12 text-center shadow-sm">
            <div class="w-16 h-16 rounded-3xl bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="tv-minimal" class="w-8 h-8"></i>
            </div>
            <h3 class="text-base sm:text-lg font-black text-slate-800 dark:text-slate-100 mb-2">هنوز هیچ تلویزیونی متصل نشده است</h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 max-w-lg mx-auto mb-6 leading-relaxed">
                مرورگر تلویزیون مغازه (سامسونگ، ال‌جی، سونی، اسنوا، دوو یا اندروید) را باز کنید، نشانی <strong class="font-mono text-amber-700 dark:text-amber-300" dir="ltr">talalive.ir/tv</strong> را وارد نمایید و کد ۶ رقمی نمایش داده‌شده را در کادر بالا ثبت کنید؛ یا مستقیماً آدرس <strong class="font-mono text-amber-700 dark:text-amber-300" dir="ltr">{{ $directBoardDisplay }}</strong> را در نوار آدرس مرورگر تلویزیون وارد کنید.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <button @click="openWizard()" type="button" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs sm:text-sm font-black shadow-md shadow-amber-500/20 transition-all cursor-pointer">
                    <i data-lucide="scan-line" class="w-4 h-4"></i>
                    <span>مشاهده راهنمای گام‌به‌گام اتصال</span>
                </button>
                <a href="{{ config('tv.apk_url', url('/downloads/talalive-tv.apk')) }}" target="_blank"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold transition-colors">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>دانلود فایل نصبی ویژه اندروید تی‌وی (APK)</span>
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($devices as $dev)
                @php
                    $isRevoked = !is_null($dev->revoked_at);
                    $lastSeenParsed = $dev->last_seen_at ? ($dev->last_seen_at instanceof \DateTimeInterface ? $dev->last_seen_at : \Carbon\Carbon::parse($dev->last_seen_at)) : null;
                    $lastSeenText = $lastSeenParsed ? \App\Models\User::toJalali($lastSeenParsed) : 'نامشخص';
                    $isRecent = $lastSeenParsed && $lastSeenParsed->gt(now()->subMinutes(15));
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
                                <span>حالت نمایش:</span>
                                <span class="font-bold text-slate-700 dark:text-slate-200 text-[11px]">
                                    @if($dev->render_mode === 'native')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/40 font-mono" title="{{ $dev->fallback_reason ? 'دلیل: ' . $dev->fallback_reason : 'نیتیو مستقل' }}">
                                            نیتیو (مستقل)
                                            @if($dev->fallback_reason)
                                                <span class="text-[9px] text-slate-400 font-normal">({{ $dev->fallback_reason }})</span>
                                            @endif
                                        </span>
                                    @elseif($dev->render_mode === 'web')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800/40 font-mono">
                                            وب‌ویو (WebView)
                                        </span>
                                    @else
                                        <span class="text-slate-400">خودکار / نامشخص</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400">
                                <span>نسخه اپلیکیشن:</span>
                                <span class="font-bold text-slate-700 dark:text-slate-200 font-mono text-[11px]">{{ $dev->app_version ?: '1' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400">
                                <span>سیستم‌عامل / مرورگر:</span>
                                <span class="font-bold text-slate-700 dark:text-slate-200 font-mono text-[11px]">{{ $dev->android_release ? 'Android ' . $dev->android_release : ($dev->render_mode === 'web' ? 'مرورگر تلویزیون هوشمند' : '---') }}</span>
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
                <div class="w-10 h-10 rounded-2xl bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/25 flex items-center justify-center">
                    <i data-lucide="camera" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white">اسکن بارکد تلویزیون</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">دوربین را مقابل بارکد QR روی تلویزیون بگیرید</p>
                </div>
            </div>

            {{-- کادر دوربین / اسکنر --}}
            <div class="relative bg-black rounded-2xl overflow-hidden aspect-square flex items-center justify-center border-2 border-dashed border-amber-500/40">
                <div id="qr-reader" class="w-full h-full"></div>
                
                {{-- لودینگ وضعیت --}}
                <div x-show="!isCameraRunning && !cameraError" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-950/90 text-white gap-3 p-4 text-center">
                    <i data-lucide="loader-2" class="w-8 h-8 animate-spin text-amber-400"></i>
                    <span class="text-xs font-bold text-slate-300">در حال فعال‌سازی دوربین...</span>
                </div>

                {{-- خطا در دسترسی به دوربین --}}
                <div x-show="cameraError" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-950/95 text-white gap-3 p-6 text-center">
                    <i data-lucide="alert-triangle" class="w-10 h-10 text-amber-400"></i>
                    <p class="text-xs text-slate-300 leading-relaxed" x-text="cameraError"></p>
                    <div class="flex items-center gap-2 mt-2">
                        <button @click="retryCamera()" type="button" class="qr-scan-modal-btn px-4 py-2 rounded-xl text-xs font-bold transition-colors cursor-pointer">
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
                <button @click="closeScanner()" type="button" class="font-bold text-amber-700 dark:text-amber-400 hover:underline cursor-pointer">
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
                    <div class="pr-8 pt-1 space-y-2">
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="inline-block px-3.5 py-1.5 rounded-xl bg-amber-500/10 border border-amber-500/30 font-mono font-black text-sm text-amber-600 dark:text-amber-400" dir="ltr">
                                talalive.ir/tv
                            </span>
                            <a href="{{ url('/downloads/talalive-tv.apk?v=2') }}" target="_blank" class="text-xs font-bold text-amber-700 dark:text-amber-400 hover:underline">
                                دانلود فایل نصبی اندروید TV
                            </a>
                        </div>
                        <p class="text-[11px] text-slate-600 dark:text-slate-300 leading-relaxed">
                            یا بدون نیاز به کد، آدرس اختصاصی تابلوی خود یعنی
                            <span class="font-mono font-black text-amber-700 dark:text-amber-300" dir="ltr">{{ $directBoardDisplay }}</span>
                            را مستقیماً در نوار آدرس مرورگر تلویزیون وارد کنید.
                        </p>
                    </div>
                </div>

                {{-- گام ۲ --}}
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-3">
                    <div class="flex items-center gap-2 font-bold text-xs text-amber-600 dark:text-amber-400">
                        <span class="w-6 h-6 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center text-xs font-black">۲</span>
                        <span>وارد کردن کد ۶ رقمی نمایش داده شده روی تلویزیون</span>
                    </div>
                    <div class="pr-8 space-y-3">
                        <div>
                            <input type="text"
                                   maxlength="8"
                                   x-model="pairCode"
                                   :inputmode="pairAlphaMode ? 'text' : 'numeric'"
                                   autocomplete="one-time-code"
                                   placeholder="کد ۶ رقمی روی تلویزیون (مثلاً 584921)"
                                   dir="ltr"
                                   @keydown.enter.prevent="pairWithCodeManual()"
                                   @input="handlePairCodeInput()"
                                   class="w-full bg-white dark:bg-slate-900 border-2 border-amber-500/50 rounded-2xl py-3 px-4 text-center font-mono font-black text-2xl tracking-widest text-slate-900 dark:text-white placeholder:font-sans placeholder:text-sm placeholder:font-normal focus:outline-none focus:border-amber-500 shadow-inner">
                            <div class="mt-1.5 text-center">
                                <button type="button"
                                        @click="pairAlphaMode = !pairAlphaMode"
                                        class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 cursor-pointer"
                                        x-text="pairAlphaMode ? 'بازگشت به صفحه‌کلید عددی' : 'کد شامل حروف انگلیسی است؟ تغییر صفحه‌کلید'"></button>
                            </div>
                        </div>
                        <button @click="pairWithCodeManual()" :disabled="isPairing || pairCode.length < 6"
                                class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-sm shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
                            <i data-lucide="zap" class="w-4 h-4"></i>
                            <span x-text="isPairing ? 'در حال برقراری ارتباط...' : 'اتصال و روشن کردن تلویزیون مغازه'"></span>
                        </button>
                    </div>
                </div>

                {{-- گزینه اسکن با دوربین --}}
                <div class="text-center pt-2">
                    <button type="button" @click="isWizardOpen = false; openScanner();"
                            class="text-xs font-bold text-amber-700 dark:text-amber-400 hover:underline inline-flex items-center gap-1.5 cursor-pointer">
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
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25) !important;
    }
    .qr-scan-btn:hover {
        background: linear-gradient(135deg, #35302d 0%, #221f1d 100%) !important;
        border-color: rgba(251, 191, 36, 0.55) !important;
    }
    .qr-scan-modal-btn {
        background: #f59e0b !important;
        color: #09090b !important;
        font-weight: 800 !important;
    }
    .qr-scan-modal-btn:hover {
        background: #fbbf24 !important;
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
        pairAlphaMode: false,
        lastAutoPairCode: '',
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

        handlePairCodeInput(autoSubmit = true) {
            let val = String(this.pairCode || '');
            const p = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            const e = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
            for (let i = 0; i < p.length; i++) val = val.replaceAll(p[i], e[i]);
            const cleaned = val.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 6);
            this.pairCode = cleaned;
            if (cleaned.length < 6) {
                this.lastAutoPairCode = '';
            } else if (autoSubmit && !this.isPairing && this.lastAutoPairCode !== cleaned) {
                this.lastAutoPairCode = cleaned;
                this.$nextTick(() => this.pairWithCodeManual());
            }
        },

        async pairWithCodeManual() {
            this.handlePairCodeInput(false);
            const code = this.pairCode.trim();

            if (!code || code.length < 6) {
                window.showAdminToast ? window.showAdminToast('لطفاً کد ۶ رقمی نمایش داده شده در تلویزیون را با دقت وارد کنید.', 'error') : alert('لطفا کد ۶ رقمی نمایش داده شده در تلویزیون را با دقت وارد کنید.');
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
                    const okMsg = data.message || 'تلویزیون با موفقیت متصل شد!';
                    if (window.showAdminToast) window.showAdminToast(okMsg, 'success');
                    else alert(okMsg);
                    this.pairCode = '';
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    const errMsg = (data && data.message) ? data.message : 'کد فعال‌سازی نامعتبر است یا منقضی شده است. لطفا صفحه تلویزیون را رفرش فرمایید.';
                    window.showAdminToast ? window.showAdminToast(errMsg, 'error') : alert(errMsg);
                }
            } catch (err) {
                window.showAdminToast ? window.showAdminToast('خطا در برقراری ارتباط با سرور. لطفاً مجدداً امتحان کنید.', 'error') : alert('خطا در برقراری ارتباط با سرور. لطفاً مجدداً امتحان کنید.');
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
                    const m = 'بارکد اسکن‌شده نامعتبر است: ' + decodedText;
                    window.showAdminToast ? window.showAdminToast(m, 'error') : alert(m);
                    this.isProcessingPair = false;
                    await this.startCamera();
                    return;
                }

                if (data && data.success) {
                    this.isScannerOpen = false;
                    const okMsg = data.message || 'تلویزیون با موفقیت متصل شد! اکنون تابلوی طلای شما روی نمایشگر پخش می‌شود.';
                    if (window.showAdminToast) window.showAdminToast(okMsg, 'success');
                    else alert(okMsg);
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    const errMsg = (data && data.message) ? data.message : 'خطا در اتصال به تلویزیون.';
                    window.showAdminToast ? window.showAdminToast(errMsg, 'error') : alert(errMsg);
                    this.isProcessingPair = false;
                    await this.startCamera();
                }
            } catch (e) {
                console.error("Pairing error:", e);
                window.showAdminToast ? window.showAdminToast('خطا در اتصال با سرور. لطفاً مجدداً امتحان کنید.', 'error') : alert('خطا در اتصال با سرور. لطفاً مجدداً امتحان کنید.');
                this.isProcessingPair = false;
                await this.startCamera();
            }
        }
    };
}
</script>
@endpush
