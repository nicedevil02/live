@auth
@php
    $guideUser = auth()->user();
    $guideBoardUrl = url('/' . $guideUser->username . '?key=' . $guideUser->display_token);
    $guideAutoOpen = (bool) session('show_onboarding_tour', false);
    $tvApkUrl = config('tv.apk_url', url('/downloads/talalive-tv.apk'));
    $tvApkVersion = config('tv.latest_version', '1.0.8');
@endphp

<div x-data="talaliveOnboardingGuide()"
     @talalive-open-guide.window="openGuide($event.detail?.tab || 1, $event.detail?.tvSubTab || null)"
     @talalive-start-tour.window="startSpotlightTour()"
     @keydown.escape.window="handleEscape()">

    {{-- ===================================================================== --}}
    {{-- ۱. ویزارد تصویری ۳ گام راه‌اندازی سریع تلویزیون مغازه (بدون متن اضافه)  --}}
    {{--    (طراحی مدرن استوری‌محور، کاملاً واکنش‌گرا در موبایل و دسکتاپ)          --}}
    {{-- ===================================================================== --}}
    <div x-show="isOpen"
         x-cloak
         @click.self="closeGuide()"
         class="fixed inset-0 z-[80] flex items-end sm:items-center justify-center p-0 sm:p-5 bg-slate-950/85 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div @click.stop
             class="talalive-guide-panel relative w-full sm:max-w-xl bg-white dark:bg-slate-900 border-t sm:border border-slate-200 dark:border-slate-800 rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[92vh] sm:max-h-[85vh]">

            {{-- دستگیره ظریف شیت در موبایل --}}
            <div class="sm:hidden flex justify-center pt-2.5 pb-1 bg-slate-50 dark:bg-slate-950/60 shrink-0">
                <span class="w-12 h-1.5 rounded-full bg-slate-300 dark:bg-slate-700"></span>
            </div>

            {{-- سربرگ ویزارد: نوار پیشرفت ۳ مرحله‌ای و دکمه بستن --}}
            <div class="px-5 sm:px-7 pt-3.5 sm:pt-5 pb-3 bg-gradient-to-l from-amber-500/10 via-slate-50 to-white dark:from-amber-500/10 dark:via-slate-900 dark:to-slate-900 border-b border-slate-200/80 dark:border-slate-800 shrink-0">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center text-sm font-black shadow-sm shrink-0">
                            📺
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white truncate">
                                راه‌اندازی تابلوی تلویزیون مغازه
                            </h2>
                            <span class="text-[10.5px] text-amber-700 dark:text-amber-400 font-bold block"
                                  x-text="`گام ${currentStep} از ۳: ${stepTitles[currentStep - 1]}`"></span>
                        </div>
                    </div>

                    <button type="button"
                            @click="closeGuide()"
                            aria-label="بستن راهنما"
                            class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-rose-50 dark:hover:bg-rose-500/15 text-slate-500 hover:text-rose-600 dark:hover:text-rose-400 flex items-center justify-center transition-colors cursor-pointer shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- خط پیشرفت ۳ مرحله‌ای بصری --}}
                <div class="grid grid-cols-3 gap-1.5 mt-3 pt-1">
                    <template x-for="s in [1, 2, 3]" :key="s">
                        <div class="h-1.5 rounded-full transition-all duration-300"
                             :class="currentStep >= s ? 'bg-amber-500' : 'bg-slate-200 dark:bg-slate-800'"></div>
                    </template>
                </div>
            </div>

            {{-- بدنه اصلی اسلایدهای ویزارد --}}
            <div x-ref="guideBody" class="p-5 sm:p-7 overflow-y-auto overscroll-contain flex-1 min-h-0 space-y-4">

                {{-- ========================================================= --}}
                {{-- گام ۱: باز کردن آدرس در تلویزیون                             --}}
                {{-- ========================================================= --}}
                <div x-show="currentStep === 1" class="space-y-4 text-center">
                    {{-- تصویر شماتیک تلویزیون مغازه --}}
                    <div class="mx-auto w-24 h-16 sm:w-28 sm:h-20 rounded-2xl bg-gradient-to-b from-slate-800 to-slate-950 border-2 border-slate-700 p-2 shadow-lg flex flex-col items-center justify-center text-amber-400 gap-1">
                        <div class="font-mono text-[11px] sm:text-xs font-black tracking-wider text-amber-300">talalive.ir/tv</div>
                        <span class="text-[9px] text-slate-400">مرورگر تلویزیون</span>
                    </div>

                    <div class="space-y-1.5">
                        <h3 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">
                            ۱. مرورگر تلویزیون مغازه را باز کنید
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed max-w-md mx-auto">
                            کنترل تلویزیون را بردارید و برنامه اینترنت را باز کنید:
                        </p>
                    </div>

                    {{-- راهنمای کوتاه برندهای تلویزیون --}}
                    <div class="grid grid-cols-3 gap-2 text-right">
                        <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 text-center">
                            <span class="text-[11px] font-black text-slate-900 dark:text-white block">سامسونگ</span>
                            <span class="text-[10px] text-slate-500 dark:text-slate-400">برنامه Internet</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 text-center">
                            <span class="text-[11px] font-black text-slate-900 dark:text-white block">ال‌جی</span>
                            <span class="text-[10px] text-slate-500 dark:text-slate-400">برنامه Web Browser</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 text-center">
                            <span class="text-[11px] font-black text-slate-900 dark:text-white block">اندروید تی‌وی</span>
                            <span class="text-[10px] text-slate-500 dark:text-slate-400">کروم یا اپلیکیشن</span>
                        </div>
                    </div>

                    {{-- کادر آدرس کوتاه --}}
                    <div class="p-3.5 rounded-2xl bg-amber-500/10 border-2 border-dashed border-amber-500/40 text-center space-y-1">
                        <span class="text-[11px] text-slate-600 dark:text-slate-300 block">در نوار آدرس تلویزیون این نشانی را بنویسید:</span>
                        <span class="inline-block px-4 py-1.5 rounded-xl bg-amber-500/20 font-mono font-black text-base text-amber-700 dark:text-amber-300" dir="ltr">
                            talalive.ir/tv
                        </span>
                    </div>

                    {{-- لینک کمکی برای دانلود اپ اندروید --}}
                    <div class="pt-1 flex items-center justify-center gap-2 text-[11px] text-slate-500 dark:text-slate-400">
                        <span>تلویزیون اندروید دارید؟</span>
                        <a href="{{ $tvApkUrl }}" target="_blank" class="text-amber-600 dark:text-amber-400 font-bold hover:underline">
                            دانلود فایل نصبی (APK) &larr;
                        </a>
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- گام ۲: ثبت کد ۶ رقمی یا اسکن بارکد                          --}}
                {{-- ========================================================= --}}
                <div x-show="currentStep === 2" class="space-y-4">
                    <div class="text-center space-y-1">
                        <h3 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">
                            ۲. کد ۶ رقمی روی تلویزیون را بنویسید
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            کدی که روی صفحه تلویزیون مغازه نمایش داده شده را اینجا وارد کنید:
                        </p>
                    </div>

                    {{-- پیام فیدبک اتصال --}}
                    <div x-show="pairFeedback" x-cloak
                         :class="pairFeedbackType === 'success'
                            ? 'bg-emerald-50 dark:bg-emerald-950/60 border-emerald-300 dark:border-emerald-700 text-emerald-800 dark:text-emerald-300'
                            : 'bg-rose-50 dark:bg-rose-950/60 border-rose-300 dark:border-rose-700 text-rose-800 dark:text-rose-300'"
                         class="p-3 rounded-xl border text-xs font-bold flex items-center gap-2">
                        <span x-text="pairFeedbackType === 'success' ? '🎉' : '⚠️'"></span>
                        <span class="leading-relaxed" x-text="pairFeedback"></span>
                    </div>

                    {{-- کادر ورودی پین کد --}}
                    <div class="space-y-3">
                        <input type="text"
                               maxlength="8"
                               x-model="guidePairCode"
                               @input="normalizePairInput()"
                               @keydown.enter.prevent="submitGuidePairCode()"
                               dir="ltr"
                               placeholder="کد ۶ رقمی (مثلاً 548291)"
                               class="w-full h-14 bg-slate-50 dark:bg-slate-950 border-2 border-amber-500/50 rounded-2xl px-4 text-center font-mono font-black text-2xl tracking-[0.25em] text-slate-900 dark:text-white placeholder:font-sans placeholder:text-xs placeholder:font-normal placeholder:tracking-normal focus:outline-none focus:border-amber-500 shadow-inner">

                        <button type="button"
                                @click="submitGuidePairCode()"
                                :disabled="isGuidePairing || guidePairCode.length < 6"
                                class="w-full h-12 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-sm shadow-md shadow-amber-500/25 transition-all cursor-pointer disabled:opacity-50 flex items-center justify-center gap-2">
                            <span x-text="isGuidePairing ? 'در حال برقراری اتصال...' : '🚀 اتصال و روشن کردن تلویزیون مغازه'"></span>
                        </button>
                    </div>

                    {{-- دکمه اسکن دوربین --}}
                    <div class="pt-1 text-center">
                        <button type="button"
                                @click="toggleGuideScanner()"
                                class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-1.5 cursor-pointer">
                            <span>📷</span>
                            <span x-text="isGuideScannerOpen ? 'بستن دوربین گوشی' : 'یا ترجیح می‌دهید بارکد QR تلویزیون را اسکن کنید؟'"></span>
                        </button>
                    </div>

                    {{-- کادر بازشونده دوربین --}}
                    <div x-show="isGuideScannerOpen" x-cloak class="pt-2">
                        <div class="relative mx-auto max-w-[240px] aspect-square rounded-2xl overflow-hidden bg-slate-950 border-2 border-dashed border-indigo-500/60 flex items-center justify-center">
                            <div id="onboarding-qr-reader" class="w-full h-full"></div>

                            <div x-show="!isGuideCameraRunning && !guideCameraError" class="absolute inset-0 bg-slate-950/90 flex flex-col items-center justify-center text-white gap-2 p-4 text-center">
                                <div class="w-8 h-8 border-2 border-indigo-400 border-t-transparent rounded-full animate-spin"></div>
                                <span class="text-xs font-bold text-slate-300">در حال فعال‌سازی دوربین...</span>
                            </div>

                            <div x-show="guideCameraError" class="absolute inset-0 bg-slate-950/95 flex flex-col items-center justify-center text-white gap-2.5 p-4 text-center">
                                <span class="text-2xl">⚠️</span>
                                <p class="text-[11px] text-slate-300 leading-relaxed" x-text="guideCameraError"></p>
                                <button type="button" @click="startGuideCamera()" class="px-3.5 py-1.5 rounded-lg bg-indigo-600 text-white text-xs font-bold cursor-pointer">
                                    تلاش مجدد
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- گام ۳: تبریک و پایان                                       --}}
                {{-- ========================================================= --}}
                <div x-show="currentStep === 3" class="space-y-4 text-center">
                    <div class="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-500 border border-emerald-500/30 flex items-center justify-center text-3xl font-black mx-auto">
                        🎉
                    </div>

                    <div class="space-y-1.5">
                        <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white">
                            تبریک! تلویزیون مغازه شما متصل شد
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed max-w-md mx-auto">
                            اکنون نرخ‌های لحظه‌ای طلا، سکه و ارز به‌صورت خودکار و تمام‌صفحه روی تلویزیون مغازه در حال پخش است.
                        </p>
                    </div>

                    {{-- لینک مشاهده زنده تابلو --}}
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-2">
                        <span class="text-xs text-slate-500 dark:text-slate-400 block">مشاهده خروجی تابلوی زنده:</span>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ $guideBoardUrl }}" target="_blank"
                               class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black transition-all flex items-center gap-1.5 shadow-sm">
                                <span>مشاهده زنده تابلوی مغازه</span>
                                <span>↗</span>
                            </a>
                            <button type="button" @click="copyBoardLink(@js($guideBoardUrl))"
                                    class="px-3 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition-colors cursor-pointer">
                                <span x-text="copiedBoardUrl ? 'کپی شد ✓' : 'کپی لینک'"></span>
                            </button>
                        </div>
                    </div>

                    <button type="button"
                            @click="closeGuide()"
                            class="w-full py-3 rounded-xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 text-white text-xs font-black transition-colors cursor-pointer">
                        ورود به پنل مدیریت گالری &larr;
                    </button>
                </div>

            </div>

            {{-- نوار پایین مودال (Sticky Footer): دکمه‌های ناوبری + تماس فوری با پشتیبان --}}
            <div class="px-5 sm:px-7 py-3 bg-slate-50 dark:bg-slate-950/90 border-t border-slate-200/80 dark:border-slate-800 flex items-center justify-between gap-2 shrink-0">
                <div>
                    <button type="button"
                            x-show="currentStep > 1 && currentStep < 3"
                            @click="prevStep()"
                            class="px-3.5 py-2 rounded-xl bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition-colors cursor-pointer">
                        &rarr; قبلی
                    </button>
                    <button type="button"
                            x-show="currentStep === 1"
                            @click="closeGuide()"
                            class="px-3 py-2 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-xs font-bold transition-colors cursor-pointer">
                        بستن
                    </button>
                </div>

                {{-- میانبر درخواست تماس تلفنی در صورت نیاز --}}
                <div class="flex items-center gap-2">
                    <button type="button"
                            x-show="currentStep < 3"
                            @click="requestCallFromGuide()"
                            :disabled="guideCallLoading"
                            class="text-[11px] text-amber-700 dark:text-amber-400 hover:underline font-bold inline-flex items-center gap-1 cursor-pointer disabled:opacity-50">
                        <span>📞</span>
                        <span x-text="guideCallDone ? 'درخواست تماس ثبت شد ✓' : (guideCallLoading ? 'در حال ثبت...' : 'نیاز به راهنمایی تلفنی؟')"></span>
                    </button>

                    <button type="button"
                            x-show="currentStep === 1"
                            @click="nextStep()"
                            class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-black shadow-sm transition-all cursor-pointer flex items-center gap-1">
                        <span>کد روی تلویزیون ظاهر شد</span>
                        <span>&larr;</span>
                    </button>

                    <button type="button"
                            x-show="currentStep === 3"
                            @click="closeGuide()"
                            class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black shadow-sm transition-all cursor-pointer">
                        تکمیل شد ✓
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- ۲. موتور تور نوری تعاملی روی منوهای پنل (Spotlight Menu Tour)          --}}
    {{-- ===================================================================== --}}
    <div x-show="tourActive" x-cloak>
        <div @click="stopSpotlightTour()" class="fixed inset-0 z-[89] cursor-pointer"></div>

        <div class="fixed z-[90] pointer-events-none rounded-2xl border-2 border-amber-400 transition-all duration-250 ease-out"
             :style="`top: ${tourRect.top}px; left: ${tourRect.left}px; width: ${tourRect.width}px; height: ${tourRect.height}px; box-shadow: 0 0 0 9999px rgba(2, 6, 23, 0.78), 0 0 24px rgba(245, 158, 11, 0.7);`">
        </div>

        <div x-ref="tourTooltip"
             @click.stop
             class="talalive-tour-card fixed z-[95] bg-white dark:bg-slate-900 border-2 border-amber-500/80 rounded-2xl sm:rounded-3xl p-4 sm:p-5 shadow-2xl transition-all duration-250 ease-out space-y-2.5 sm:space-y-3.5"
             :style="tourTooltipStyle">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-amber-500/15 text-amber-700 dark:text-amber-300 border border-amber-500/30"
                          x-text="`گام ${tourIndex + 1} از ${tourSteps.length}`"></span>
                    <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white"
                        x-text="currentTourStep ? currentTourStep.title : ''"></h3>
                </div>
                <button type="button" @click="stopSpotlightTour()" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed"
               x-text="currentTourStep ? currentTourStep.desc : ''"></p>

            <div class="flex items-center justify-between gap-2 pt-1 border-t border-slate-100 dark:border-slate-800">
                <button type="button" x-show="tourIndex > 0" @click="prevTourStep()" class="text-xs font-bold text-slate-500 hover:text-slate-800 dark:hover:text-slate-200">
                    &rarr; قبلی
                </button>
                <span x-show="tourIndex === 0"></span>

                <div class="flex items-center gap-2">
                    <button type="button" @click="stopSpotlightTour()" class="text-xs text-slate-400 hover:text-slate-600">
                        پایان تور
                    </button>
                    <button type="button" @click="nextTourStep()" class="px-3.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-black">
                        <span x-text="tourIndex + 1 < tourSteps.length ? 'بعدی &larr;' : 'متوجه شدم ✓'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .talalive-guide-panel { animation: modalIn 0.2s cubic-bezier(0.16, 1, 0.3, 1); }
    @keyframes modalIn {
        from { transform: translateY(12px) scale(0.98); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }
    #onboarding-qr-reader { border: none !important; }
    #onboarding-qr-reader video { border-radius: 0.875rem; object-fit: cover; width: 100% !important; height: 100% !important; }
    #onboarding-qr-reader__scan_region { border: none !important; }
    #onboarding-qr-reader__dashboard { display: none !important; }
</style>

<script>
    window.__TALALIVE_SHOW_ONBOARDING = @json($guideAutoOpen);
    window.__TALALIVE_GUIDE_ACTIVE = @json($guideAutoOpen);

    window.openTalaliveGuide = function(tab, tvSubTab) {
        window.dispatchEvent(new CustomEvent('talalive-open-guide', {
            detail: { tab: tab || 1, tvSubTab: tvSubTab || null }
        }));
    };

    window.startTalaliveSpotlightTour = function() {
        window.dispatchEvent(new CustomEvent('talalive-start-tour'));
    };

    function talaliveOnboardingGuide() {
        return {
            isOpen: @json($guideAutoOpen),
            currentStep: 1,
            stepTitles: ['آماده‌سازی تلویزیون', 'ثبت کد و اتصال', 'پخش زنده'],
            copiedBoardUrl: false,

            // وضعیت درخواست تماس سریع
            guideCallLoading: false,
            guideCallDone: false,

            // وضعیت جفت‌سازی مستقیم داخل ویزارد
            guidePairCode: '',
            isGuidePairing: false,
            pairFeedback: '',
            pairFeedbackType: 'success',
            isGuideScannerOpen: false,
            isGuideCameraRunning: false,
            isProcessingGuideQr: false,
            guideCameraError: null,
            guideQrInstance: null,

            // وضعیت تور نوری منوها
            tourActive: false,
            tourIndex: 0,
            tourSteps: [],
            tourRect: { top: -100, left: -100, width: 0, height: 0 },
            tourTooltipStyle: 'bottom: 12px; left: 12px; right: 12px;',
            boundReposition: null,
            paddedNavEl: null,

            allTourDefinitions: [
                {
                    id: 'dashboard',
                    title: '۱. داشبورد مدیریت',
                    desc: 'نمای کلی وضعیت تابلوی گالری، لینک مستقیم پخش، اتصال سریع تلویزیون و آخرین نرخ طلای ۱۸ عیار را در این صفحه می‌بینید.'
                },
                {
                    id: 'shop-profile',
                    title: '۲. اطلاعات فروشگاه و بارکد QR',
                    desc: 'نام گالری، تلفن و آدرس پیج اینستاگرام یا روبیکای خود را اینجا وارد کنید تا بارکد QR گالری روی تلویزیون نمایش داده شود.'
                },
                {
                    id: 'products',
                    title: '۳. ویترین طلا (اسلایدر محصولات)',
                    desc: 'تصاویر کارهای طلا را همراه با وزن، اجرت و سود بارگذاری کنید تا قیمت لحظه‌ای هر محصول خودکار روی تلویزیون محاسبه شود.'
                },
                {
                    id: 'display-control',
                    title: '۴. تنظیمات پوسته و آیتم‌های تابلو',
                    desc: 'قالب رنگی تابلو (روشن مدرن، تیره یا طلایی) را انتخاب کنید و مشخص نمایید کدام نرخ‌ها روی تلویزیون نمایش داده شوند.'
                },
                {
                    id: 'formulas',
                    title: '۵. فرمول‌های محاسبه',
                    desc: 'ضریب محاسبه «گرم خرید طلای ۱۸ عیار» (مثلاً ۷۴۰ تقسیم بر ۷۵۰) را دقیقاً مطابق عرف بازار شهر و مغازه خود تنظیم فرمایید.'
                },
                {
                    id: 'devices',
                    title: '۶. تلویزیون‌های من',
                    desc: 'وضعیت آنلاین بودن تلویزیون‌های متصل مغازه را رصد کنید، برای هر تلویزیون نام بگذارید یا تلویزیون جدیدی متصل نمایید.'
                },
                {
                    id: 'subscription',
                    title: '۷. خرید و تمدید اشتراک',
                    desc: 'اعتبار باقی‌مانده از ۱۴ روز تست رایگان گالری را مشاهده کنید و هر زمان مایل بودید، اشتراک خود را آنلاین تمدید فرمایید.'
                }
            ],

            get currentTourStep() {
                return this.tourSteps[this.tourIndex] || null;
            },

            init() {
                if (this.isOpen) {
                    window.__TALALIVE_GUIDE_ACTIVE = true;
                    try {
                        localStorage.setItem('talalive_onboarding_seen_{{ $guideUser->id }}', '1');
                    } catch (e) {}
                }

                this.boundReposition = () => {
                    if (this.tourActive) {
                        this.updateTourPosition(false);
                    }
                };
                window.addEventListener('resize', this.boundReposition);
                window.addEventListener('scroll', this.boundReposition, true);
            },

            handleEscape() {
                if (this.tourActive) {
                    this.stopSpotlightTour();
                } else if (this.isOpen) {
                    this.closeGuide();
                }
            },

            openGuide(step = 1) {
                if (this.tourActive) {
                    this.stopSpotlightTour();
                }
                if (typeof step === 'string') {
                    if (step === 'tv' || step === 'pair') this.currentStep = 2;
                    else this.currentStep = 1;
                } else {
                    this.currentStep = Number(step) || 1;
                }
                this.pairFeedback = '';
                this.isOpen = true;
                window.__TALALIVE_GUIDE_ACTIVE = true;
            },

            async closeGuide() {
                await this.stopGuideCamera();
                this.isGuideScannerOpen = false;
                this.isOpen = false;
                if (!this.tourActive) {
                    window.__TALALIVE_GUIDE_ACTIVE = false;
                }
            },

            nextStep() {
                if (this.currentStep < 3) {
                    this.currentStep++;
                }
            },

            prevStep() {
                if (this.currentStep > 1) {
                    this.currentStep--;
                }
            },

            copyBoardLink(url) {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url);
                }
                this.copiedBoardUrl = true;
                setTimeout(() => { this.copiedBoardUrl = false; }, 2500);
            },

            async requestCallFromGuide() {
                if (this.guideCallDone || this.guideCallLoading) return;
                this.guideCallLoading = true;
                try {
                    const res = await fetch('{{ route('admin.request-setup-call') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json();
                    if (data && data.success) {
                        this.guideCallDone = true;
                    }
                } catch (e) {
                } finally {
                    this.guideCallLoading = false;
                }
            },

            normalizePairInput() {
                let val = String(this.guidePairCode || '');
                const p = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
                const e = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
                for (let i = 0; i < p.length; i++) {
                    val = val.replaceAll(p[i], e[i]);
                }
                this.guidePairCode = val.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 6);
            },

            async submitGuidePairCode() {
                this.normalizePairInput();
                const code = this.guidePairCode.trim();
                if (code.length < 6) {
                    this.pairFeedbackType = 'error';
                    this.pairFeedback = 'لطفاً کد ۶ رقمی روی تلویزیون را کامل وارد فرمایید.';
                    return;
                }

                this.isGuidePairing = true;
                this.pairFeedback = '';

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
                    const data = await res.json().catch(() => ({}));

                    if (res.ok && data && data.success) {
                        this.pairFeedbackType = 'success';
                        this.pairFeedback = data.message || 'تلویزیون مغازه متصل شد!';
                        this.guidePairCode = '';
                        this.currentStep = 3;
                        setTimeout(() => { window.location.reload(); }, 2200);
                    } else {
                        this.pairFeedbackType = 'error';
                        this.pairFeedback = (data && data.message)
                            ? data.message
                            : 'کد فعال‌سازی نامعتبر یا منقضی شده است. لطفاً تلویزیون را رفرش فرمایید.';
                    }
                } catch (err) {
                    this.pairFeedbackType = 'error';
                    this.pairFeedback = 'خطا در ارتباط با سرور. لطفاً اینترنت را بررسی کنید.';
                } finally {
                    this.isGuidePairing = false;
                }
            },

            async ensureQrScriptLoaded() {
                if (typeof Html5Qrcode !== 'undefined') return true;
                return new Promise((resolve) => {
                    const existing = document.querySelector('script[data-talalive-qr-lib]');
                    if (existing) {
                        existing.addEventListener('load', () => resolve(typeof Html5Qrcode !== 'undefined'));
                        existing.addEventListener('error', () => resolve(false));
                        return;
                    }
                    const script = document.createElement('script');
                    script.src = '{{ asset('vendor/html5-qrcode.min.js') }}';
                    script.setAttribute('data-talalive-qr-lib', '1');
                    script.onload = () => resolve(typeof Html5Qrcode !== 'undefined');
                    script.onerror = () => resolve(false);
                    document.head.appendChild(script);
                });
            },

            async toggleGuideScanner() {
                if (this.isGuideScannerOpen) {
                    await this.stopGuideCamera();
                    this.isGuideScannerOpen = false;
                    return;
                }
                this.isGuideScannerOpen = true;
                this.guideCameraError = null;
                this.pairFeedback = '';
                this.$nextTick(() => {
                    this.startGuideCamera();
                });
            },

            async startGuideCamera() {
                this.guideCameraError = null;
                this.isProcessingGuideQr = false;
                await this.stopGuideCamera();

                const loaded = await this.ensureQrScriptLoaded();
                if (!loaded) {
                    this.guideCameraError = 'کتابخانه اسکنر بارگذاری نشد. لطفاً کد ۶ رقمی را دستی وارد فرمایید.';
                    return;
                }

                try {
                    this.guideQrInstance = new Html5Qrcode('onboarding-qr-reader');
                    await this.guideQrInstance.start(
                        { facingMode: 'environment' },
                        {
                            fps: 10,
                            qrbox: (vw, vh) => {
                                const edge = Math.floor(Math.min(vw, vh) * 0.75);
                                return { width: Math.max(130, edge), height: Math.max(130, edge) };
                            },
                            aspectRatio: 1.0
                        },
                        (decodedText) => this.onGuideQrDetected(decodedText),
                        () => {}
                    );
                    this.isGuideCameraRunning = true;
                } catch (e) {
                    this.isGuideCameraRunning = false;
                    this.guideCameraError = 'دسترسی به دوربین داده نشد یا این دستگاه دوربین ندارد.';
                }
            },

            async stopGuideCamera() {
                if (this.guideQrInstance) {
                    try {
                        if (this.guideQrInstance.isScanning) {
                            await this.guideQrInstance.stop();
                        }
                        await this.guideQrInstance.clear();
                    } catch (e) {}
                    this.guideQrInstance = null;
                }
                this.isGuideCameraRunning = false;
            },

            async onGuideQrDetected(decodedText) {
                if (this.isProcessingGuideQr) return;
                this.isProcessingGuideQr = true;
                await this.stopGuideCamera();

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
                    let res;
                    if (sessionCode) {
                        res = await fetch('/admin/pair/' + encodeURIComponent(sessionCode), {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
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
                    } else {
                        this.pairFeedbackType = 'error';
                        this.pairFeedback = 'بارکد اسکن‌شده مربوط به تلویزیون طلالایو نیست.';
                        this.isGuideScannerOpen = false;
                        this.isProcessingGuideQr = false;
                        return;
                    }

                    const data = await res.json().catch(() => ({}));
                    if (res.ok && data && data.success) {
                        this.isGuideScannerOpen = false;
                        this.pairFeedbackType = 'success';
                        this.pairFeedback = data.message || 'تلویزیون متصل شد! 🎉';
                        this.currentStep = 3;
                        setTimeout(() => { window.location.reload(); }, 1800);
                    } else {
                        this.isGuideScannerOpen = false;
                        this.pairFeedbackType = 'error';
                        this.pairFeedback = (data && data.message) ? data.message : 'خطا در اتصال تلویزیون.';
                    }
                } catch (e) {
                    this.isGuideScannerOpen = false;
                    this.pairFeedbackType = 'error';
                    this.pairFeedback = 'خطا در برقراری ارتباط با سرور.';
                } finally {
                    this.isProcessingGuideQr = false;
                }
            },

            // متدهای Spotlight Tour
            clearNavTourPadding() {
                if (this.paddedNavEl) {
                    this.paddedNavEl.style.paddingBottom = '';
                    this.paddedNavEl = null;
                }
            },

            async startSpotlightTour() {
                await this.stopGuideCamera();
                this.isGuideScannerOpen = false;
                this.isOpen = false;

                this.tourSteps = this.allTourDefinitions.filter(step =>
                    Boolean(document.querySelector(`[data-tour-id="${step.id}"]`))
                );

                if (this.tourSteps.length === 0) return;

                this.tourIndex = 0;
                window.__TALALIVE_GUIDE_ACTIVE = true;

                const isMobile = window.innerWidth < 1024;
                if (isMobile) {
                    window.dispatchEvent(new CustomEvent('talalive-toggle-sidebar', { detail: { open: true } }));
                    setTimeout(() => {
                        this.tourActive = true;
                        this.$nextTick(() => this.focusCurrentTourStep());
                    }, 340);
                } else {
                    this.tourActive = true;
                    this.$nextTick(() => this.focusCurrentTourStep());
                }
            },

            stopSpotlightTour() {
                this.tourActive = false;
                window.__TALALIVE_GUIDE_ACTIVE = false;
                this.clearNavTourPadding();
                if (window.innerWidth < 1024) {
                    window.dispatchEvent(new CustomEvent('talalive-toggle-sidebar', { detail: { open: false } }));
                }
            },

            nextTourStep() {
                if (this.tourIndex + 1 < this.tourSteps.length) {
                    this.tourIndex++;
                    this.focusCurrentTourStep();
                } else {
                    this.stopSpotlightTour();
                }
            },

            prevTourStep() {
                if (this.tourIndex > 0) {
                    this.tourIndex--;
                    this.focusCurrentTourStep();
                }
            },

            focusCurrentTourStep() {
                this.updateTourPosition(true);
                setTimeout(() => this.updateTourPosition(true), 90);
                setTimeout(() => this.updateTourPosition(false), 240);
            },

            updateTourPosition(shouldScroll = false) {
                const step = this.currentTourStep;
                if (!step) return;
                const el = document.querySelector(`[data-tour-id="${step.id}"]`);
                if (!el) return;

                const vw = window.innerWidth;
                const vh = window.visualViewport ? window.visualViewport.height : window.innerHeight;
                const navEl = el.closest('nav');
                const tooltipEl = this.$refs.tourTooltip;
                const measuredCardH = (tooltipEl && tooltipEl.offsetHeight > 40) ? tooltipEl.offsetHeight : 180;

                if (vw < 1024) {
                    if (navEl) {
                        this.paddedNavEl = navEl;
                        navEl.style.paddingBottom = (measuredCardH + 56) + 'px';
                    }

                    if (shouldScroll && navEl) {
                        const preRect = el.getBoundingClientRect();
                        const safeTop = 72;
                        const safeBottom = Math.max(140, vh - measuredCardH - 28);
                        const idealCenterY = (safeTop + safeBottom) / 2;
                        const currentCenterY = preRect.top + (preRect.height / 2);
                        const delta = currentCenterY - idealCenterY;
                        if (Math.abs(delta) > 8) {
                            navEl.scrollTop = Math.max(0, navEl.scrollTop + delta);
                        }
                    }

                    const rect = el.getBoundingClientRect();
                    const pad = 4;
                    const left = Math.max(6, rect.left - pad);
                    const rightEdge = Math.min(vw - 6, rect.right + pad);

                    this.tourRect = {
                        top: Math.max(6, rect.top - pad),
                        left: left,
                        width: Math.max(40, rightEdge - left),
                        height: rect.height + pad * 2
                    };

                    this.tourTooltipStyle = 'bottom: max(12px, env(safe-area-inset-bottom)); left: 12px; right: 12px; top: auto; width: auto;';
                } else {
                    this.clearNavTourPadding();
                    if (shouldScroll) {
                        el.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                    }

                    const rect = el.getBoundingClientRect();
                    const pad = 4;
                    this.tourRect = {
                        top: Math.max(6, rect.top - pad),
                        left: Math.max(6, rect.left - pad),
                        width: rect.width + pad * 2,
                        height: rect.height + pad * 2
                    };

                    const tooltipW = Math.min(340, vw - 32);
                    let left = rect.left - tooltipW - 20;
                    if (left < 16) left = 16;
                    let top = rect.top - 8;
                    if (top + measuredCardH > vh - 16) {
                        top = Math.max(16, vh - measuredCardH - 16);
                    }
                    if (top < 16) top = 16;
                    this.tourTooltipStyle = `top: ${top}px; left: ${left}px; right: auto; bottom: auto; width: ${tooltipW}px;`;
                }
            }
        };
    }
</script>
@endauth
