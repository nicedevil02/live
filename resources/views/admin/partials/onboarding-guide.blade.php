@auth
@php
    $guideUser = auth()->user();
    $guideBoardUrl = url('/' . $guideUser->username . '?key=' . $guideUser->display_token);
    $guideAutoOpen = (bool) session('show_onboarding_tour', false);
    $tvApkUrl = config('tv.apk_url', url('/downloads/talalive-tv.apk'));
    $tvApkVersion = config('tv.latest_version', '1.0.8');
@endphp

<div x-data="talaliveOnboardingGuide()"
     @talalive-open-guide.window="openGuide($event.detail?.tab || 'welcome', $event.detail?.tvSubTab || null)"
     @talalive-start-tour.window="startSpotlightTour()"
     @keydown.escape.window="handleEscape()">

    {{-- ===================================================================== --}}
    {{-- ۱. مودال جامع خوش‌آمدگویی، آموزش پنل کاربری و راهنمای اتصال تلویزیون   --}}
    {{--    (بهینه‌سازی شده به‌صورت Bottom-Sheet تمام‌واکنش‌گرا در موبایل)       --}}
    {{-- ===================================================================== --}}
    <div x-show="isOpen"
         x-cloak
         @click.self="closeGuide()"
         class="fixed inset-0 z-[80] flex items-end sm:items-center justify-center p-0 sm:p-5 bg-slate-950/80 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div @click.stop
             class="talalive-guide-panel relative w-full sm:max-w-3xl bg-white dark:bg-slate-900 border-t sm:border border-slate-200 dark:border-slate-800 rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col">

            {{-- دستگیره ظریف بالای شیت در موبایل --}}
            <div class="sm:hidden flex justify-center pt-2 pb-0.5 bg-slate-50/80 dark:bg-slate-900 shrink-0">
                <span class="w-10 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
            </div>

            {{-- سربرگ فشرده و هوشمند مودال --}}
            <div class="px-3.5 sm:px-7 pt-2.5 sm:pt-5 pb-3 sm:pb-4 bg-gradient-to-l from-amber-500/10 via-slate-50 to-white dark:from-amber-500/10 dark:via-slate-900 dark:to-slate-900 border-b border-slate-200/80 dark:border-slate-800 shrink-0">
                <div class="flex items-center justify-between gap-2.5">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center text-base sm:text-xl font-black shadow-md shadow-amber-500/20 shrink-0">
                            🎓
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <h2 class="text-xs sm:text-lg font-black text-slate-900 dark:text-white truncate">
                                    آموزش و راه‌اندازی تابلوی «{{ $guideUser->name }}»
                                </h2>
                                <span class="hidden md:inline-flex px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 border border-emerald-500/30 shrink-0">
                                    گام‌به‌گام
                                </span>
                            </div>
                            <p class="hidden sm:block text-xs text-slate-500 dark:text-slate-400 mt-0.5 truncate">
                                آشنایی سریع با امکانات پنل مدیریت، اتصال تلویزیون مغازه و نصب اپ موبایل
                            </p>
                        </div>
                    </div>

                    <button type="button"
                            @click="closeGuide()"
                            aria-label="بستن راهنما"
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-rose-50 dark:hover:bg-rose-500/15 text-slate-500 hover:text-rose-600 dark:hover:text-rose-400 flex items-center justify-center transition-colors cursor-pointer shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- نوار تب ۴ ستونه یک‌خطی (بدون اشغال ارتفاع اضافه در موبایل) --}}
                <div class="mt-2.5 sm:mt-4 grid grid-cols-4 gap-1 sm:gap-1.5 bg-slate-100 dark:bg-slate-950/90 p-1 sm:p-1.5 rounded-2xl border border-slate-200/70 dark:border-slate-800">
                    <button type="button"
                            @click="switchGuideTab('welcome')"
                            :class="activeTab === 'welcome'
                                ? 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm font-black border border-slate-200/60 dark:border-slate-700'
                                : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 font-bold'"
                            class="min-w-0 py-1.5 sm:py-2 px-1 sm:px-2.5 rounded-xl text-[10.5px] sm:text-xs transition-all flex flex-col sm:flex-row items-center justify-center gap-0.5 sm:gap-1.5 cursor-pointer leading-tight">
                        <span class="text-sm sm:text-xs shrink-0">✨</span>
                        <span class="sm:hidden whitespace-nowrap truncate max-w-full">خوش‌آمد</span>
                        <span class="hidden sm:inline whitespace-nowrap">خوش‌آمدگویی</span>
                    </button>

                    <button type="button"
                            @click="switchGuideTab('panel')"
                            :class="activeTab === 'panel'
                                ? 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm font-black border border-slate-200/60 dark:border-slate-700'
                                : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 font-bold'"
                            class="min-w-0 py-1.5 sm:py-2 px-1 sm:px-2.5 rounded-xl text-[10.5px] sm:text-xs transition-all flex flex-col sm:flex-row items-center justify-center gap-0.5 sm:gap-1.5 cursor-pointer leading-tight">
                        <span class="text-sm sm:text-xs shrink-0">🧭</span>
                        <span class="sm:hidden whitespace-nowrap truncate max-w-full">آموزش پنل</span>
                        <span class="hidden sm:inline whitespace-nowrap">آشنایی با پنل</span>
                    </button>

                    <button type="button"
                            @click="switchGuideTab('tv')"
                            :class="activeTab === 'tv'
                                ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 shadow-sm font-black'
                                : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 font-bold'"
                            class="min-w-0 py-1.5 sm:py-2 px-1 sm:px-2.5 rounded-xl text-[10.5px] sm:text-xs transition-all flex flex-col sm:flex-row items-center justify-center gap-0.5 sm:gap-1.5 cursor-pointer leading-tight">
                        <span class="text-sm sm:text-xs shrink-0">📺</span>
                        <span class="sm:hidden whitespace-nowrap truncate max-w-full">تلویزیون</span>
                        <span class="hidden sm:inline whitespace-nowrap">اتصال تلویزیون</span>
                    </button>

                    <button type="button"
                            @click="switchGuideTab('mobile')"
                            :class="activeTab === 'mobile'
                                ? 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm font-black border border-slate-200/60 dark:border-slate-700'
                                : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 font-bold'"
                            class="min-w-0 py-1.5 sm:py-2 px-1 sm:px-2.5 rounded-xl text-[10.5px] sm:text-xs transition-all flex flex-col sm:flex-row items-center justify-center gap-0.5 sm:gap-1.5 cursor-pointer leading-tight">
                        <span class="text-sm sm:text-xs shrink-0">📱</span>
                        <span class="sm:hidden whitespace-nowrap truncate max-w-full">اپ موبایل</span>
                        <span class="hidden sm:inline whitespace-nowrap">اپ موبایل و پشتیبانی</span>
                    </button>
                </div>
            </div>

            {{-- بدنه اسکرول‌شونده مودال --}}
            <div x-ref="guideBody" class="p-3.5 sm:p-7 overflow-y-auto overscroll-contain flex-1 min-h-0 space-y-4 sm:space-y-5">

                {{-- ========================================================= --}}
                {{-- تب ۱: خوش‌آمدگویی و لینک زنده تابلوی گالری                  --}}
                {{-- ========================================================= --}}
                <div x-show="activeTab === 'welcome'" class="space-y-3.5 sm:space-y-5">
                    <div class="rounded-2xl p-3.5 sm:p-5 bg-gradient-to-l from-emerald-500/15 via-teal-500/10 to-amber-500/10 border border-emerald-500/30 flex items-start gap-3">
                        <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-lg sm:text-xl font-black shrink-0 shadow-md shadow-emerald-500/20">
                            🎉
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-xs sm:text-base font-black text-slate-900 dark:text-white leading-snug">
                                تابلوی هوشمند گالری شما ساخته شد و فعال است!
                            </h3>
                            <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                                نرخ‌های طلای ۱۸ عیار، سکه، انس جهانی و ارز به‌صورت پیش‌فرض فعال شده‌اند و هر لحظه به‌طور خودکار بروز می‌شوند.
                            </p>
                        </div>
                    </div>

                    {{-- ۳ مزیت کلیدی برای شروع کار --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3">
                        <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 flex sm:block items-start gap-3 sm:space-y-1.5">
                            <div class="text-lg shrink-0">⚡</div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-black text-slate-900 dark:text-white">۱. نرخ‌های زنده و خودکار</h4>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed mt-0.5">
                                    بدون ورود دستی قیمت، نرخ بازار لحظه‌ای روی تلویزیون مغازه نمایش داده می‌شود.
                                </p>
                            </div>
                        </div>

                        <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 flex sm:block items-start gap-3 sm:space-y-1.5">
                            <div class="text-lg shrink-0">💎</div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-black text-slate-900 dark:text-white">۲. ویترین طلا با قیمت روز</h4>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed mt-0.5">
                                    عکس کارهای طلا را با وزن و اجرت ثبت کنید تا قیمت نهایی هر کار لحظه‌ای محاسبه شود.
                                </p>
                            </div>
                        </div>

                        <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 flex sm:block items-start gap-3 sm:space-y-1.5">
                            <div class="text-lg shrink-0">📺</div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-black text-slate-900 dark:text-white">۳. اتصال با کد ۶ رقمی</h4>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed mt-0.5">
                                    بدون تایپ لینک‌های طولانی روی تلویزیون، فقط با پین ۶ رقمی یا اسکن QR وصل شوید.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- کادر پیش‌نمایش و کپی لینک اختصاصی تابلو --}}
                    <div class="p-3.5 sm:p-5 rounded-2xl bg-blue-50/80 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-900/60 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                            <div class="min-w-0">
                                <h4 class="text-xs sm:text-sm font-black text-blue-950 dark:text-blue-200">لینک مستقیم تابلوی نمایشی گالری شما</h4>
                                <p class="text-[11px] text-blue-700 dark:text-blue-400 mt-0.5">همین الان می‌توانید ظاهر تابلوی زنده خود را مشاهده کنید:</p>
                            </div>
                            <a href="{{ $guideBoardUrl }}" target="_blank"
                               class="w-full sm:w-auto px-3.5 py-2.5 sm:py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition-all flex items-center justify-center gap-1.5 shadow-sm shrink-0">
                                <span>مشاهده زنده تابلو</span>
                                <span>↗</span>
                            </a>
                        </div>

                        <div class="flex items-center gap-2 min-w-0" dir="ltr">
                            <input type="text" readonly value="{{ $guideBoardUrl }}"
                                   class="flex-1 min-w-0 bg-white dark:bg-slate-900 border border-blue-200 dark:border-blue-800 rounded-xl px-2.5 sm:px-3 py-2 text-[11px] sm:text-xs font-mono text-blue-900 dark:text-blue-300 select-all">
                            <button type="button" @click="copyBoardLink(@js($guideBoardUrl))"
                                    class="px-3 sm:px-3.5 py-2 rounded-xl bg-slate-900 dark:bg-slate-800 hover:opacity-90 text-white text-xs font-bold whitespace-nowrap cursor-pointer shrink-0">
                                <span x-text="copiedBoardUrl ? 'کپی شد ✓' : 'کپی لینک'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- میانبر سریع اتصال تلویزیون --}}
                    <button type="button"
                            @click="switchGuideTab('tv')"
                            class="w-full p-3 rounded-2xl bg-amber-500/10 hover:bg-amber-500/15 border border-amber-500/30 text-amber-800 dark:text-amber-300 text-xs font-black transition-all cursor-pointer flex items-center justify-center gap-2">
                        <span>📺</span>
                        <span>می‌خواهید همین الان تلویزیون مغازه را وصل کنید؟ کلیک کنید</span>
                    </button>
                </div>

                {{-- ========================================================= --}}
                {{-- تب ۲: آشنایی کامل با بخش‌های پنل کاربری + تور نوری منوها   --}}
                {{-- ========================================================= --}}
                <div x-show="activeTab === 'panel'" x-cloak class="space-y-3.5 sm:space-y-5">

                    {{-- بنر اجرای تور نوری تعاملی روی منوها --}}
                    <div class="p-3.5 sm:p-4 rounded-2xl bg-gradient-to-l from-indigo-600/15 via-blue-600/10 to-amber-500/15 border border-indigo-500/30 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                        <div class="space-y-1 min-w-0">
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white flex items-center gap-1.5">
                                <span>✨</span>
                                <span>تور نوری مرحله‌به‌مرحله روی منوها</span>
                            </h3>
                            <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                با زدن این دکمه، منوی پنل باز شده و تمام بخش‌ها یکی‌به‌یکی با کادر نورانی روی صفحه به شما معرفی می‌شوند.
                            </p>
                        </div>
                        <button type="button"
                                @click="startSpotlightTour()"
                                class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-black shadow-md shadow-indigo-600/25 transition-all cursor-pointer whitespace-nowrap shrink-0 flex items-center justify-center gap-1.5">
                            <span>اجرای تور نوری منوها</span>
                            <span>&larr;</span>
                        </button>
                    </div>

                    {{-- نقشه ۶ بخش اصلی پنل کاربری --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3">
                        <a href="{{ route('admin.shop-profile') }}" class="group p-3.5 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 hover:border-amber-500/60 transition-all flex items-start gap-3">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center text-base sm:text-lg shrink-0">🏪</div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 truncate">اطلاعات فروشگاه و QR</h4>
                                    <span class="text-[10.5px] text-amber-600 dark:text-amber-400 font-bold shrink-0">ورود &larr;</span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                    ثبت نام گالری، تلفن و پیج اینستاگرام یا روبیکا جهت ساخت خودکار بارکد QR روی تلویزیون.
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('admin.products.index') }}" class="group p-3.5 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 hover:border-amber-500/60 transition-all flex items-start gap-3">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-base sm:text-lg shrink-0">💍</div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 truncate">ویترین طلا (اسلایدر)</h4>
                                    <span class="text-[10.5px] text-amber-600 dark:text-amber-400 font-bold shrink-0">ورود &larr;</span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                    افزودن عکس مصنوعات طلا با وزن و اجرت؛ محاسبه خودکار قیمت لحظه‌ای هر کار در کنار نرخ‌ها.
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('admin.display-control') }}" class="group p-3.5 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 hover:border-amber-500/60 transition-all flex items-start gap-3">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base sm:text-lg shrink-0">🎨</div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 truncate">تنظیمات پوسته و نمایش</h4>
                                    <span class="text-[10.5px] text-amber-600 dark:text-amber-400 font-bold shrink-0">ورود &larr;</span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                    تغییر تم ظاهری تابلو (روشن، تیره، طلایی) و فعال/غیرفعال کردن نرخ‌های دلخواه.
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('admin.formulas') }}" class="group p-3.5 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 hover:border-amber-500/60 transition-all flex items-start gap-3">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center text-base sm:text-lg shrink-0">🧮</div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 truncate">فرمول‌های محاسبه</h4>
                                    <span class="text-[10.5px] text-amber-600 dark:text-amber-400 font-bold shrink-0">ورود &larr;</span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                    تنظیم فرمول «گرم خرید ۱۸ عیار» (مثلاً ۷۴۰ تقسیم بر ۷۵۰) متناسب با عرف بازار شهر شما.
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('admin.devices.index') }}" class="group p-3.5 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 hover:border-amber-500/60 transition-all flex items-start gap-3">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-purple-500/15 text-purple-600 dark:text-purple-400 flex items-center justify-center text-base sm:text-lg shrink-0">📺</div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 truncate">تلویزیون‌های من</h4>
                                    <span class="text-[10.5px] text-amber-600 dark:text-amber-400 font-bold shrink-0">ورود &larr;</span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                    مشاهده وضعیت آنلاین بودن تلویزیون‌های متصل، نام‌گذاری نمایشگرها و اتصال دستگاه جدید.
                                </p>
                            </div>
                        </a>

                        <a href="{{ route('admin.subscription.index') }}" class="group p-3.5 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 hover:border-amber-500/60 transition-all flex items-start gap-3">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-rose-500/15 text-rose-600 dark:text-rose-400 flex items-center justify-center text-base sm:text-lg shrink-0">👑</div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 truncate">خرید و تمدید اشتراک</h4>
                                    <span class="text-[10.5px] text-amber-600 dark:text-amber-400 font-bold shrink-0">ورود &larr;</span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                    بررسی اعتبار باقی‌مانده از ۱۴ روز تست رایگان و تمدید آنی از درگاه بانکی یا ثبت فیش.
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- تب ۳: آموزش کامل اتصال تلویزیون بر اساس مدل + اتصال زنده   --}}
                {{-- ========================================================= --}}
                <div x-show="activeTab === 'tv'" x-cloak class="space-y-3.5 sm:space-y-5">

                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-200">
                            ۱. مدل تلویزیون داخل گالری خود را انتخاب کنید:
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <button type="button"
                                    @click="tvSubTab = 'android'"
                                    :class="tvSubTab === 'android'
                                        ? 'border-amber-500 bg-amber-500/10 text-slate-900 dark:text-white ring-2 ring-amber-500/25'
                                        : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950/60 text-slate-600 dark:text-slate-400 hover:border-slate-300'"
                                    class="p-3 rounded-2xl border text-right transition-all cursor-pointer">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-xs font-black">تلویزیون اندروید / باکس</span>
                                    <span class="text-[10px] px-1.5 py-0.5 rounded-md bg-amber-500 text-slate-950 font-black shrink-0">پیشنهادی ⭐</span>
                                </div>
                                <span class="block text-[10.5px] opacity-80 mt-1">سونی، تی‌سی‌ال، ایکس‌ویژن، شیائومی، تی‌وی‌باکس</span>
                            </button>

                            <button type="button"
                                    @click="tvSubTab = 'browser'"
                                    :class="tvSubTab === 'browser'
                                        ? 'border-amber-500 bg-amber-500/10 text-slate-900 dark:text-white ring-2 ring-amber-500/25'
                                        : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950/60 text-slate-600 dark:text-slate-400 hover:border-slate-300'"
                                    class="p-3 rounded-2xl border text-right transition-all cursor-pointer">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-xs font-black">سامسونگ، ال‌جی و مرورگر</span>
                                    <span class="text-xs shrink-0">🌐</span>
                                </div>
                                <span class="block text-[10.5px] opacity-80 mt-1">بدون نصب برنامه از طریق مرورگر تلویزیون</span>
                            </button>

                            <button type="button"
                                    @click="tvSubTab = 'nonsmart'"
                                    :class="tvSubTab === 'nonsmart'
                                        ? 'border-amber-500 bg-amber-500/10 text-slate-900 dark:text-white ring-2 ring-amber-500/25'
                                        : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950/60 text-slate-600 dark:text-slate-400 hover:border-slate-300'"
                                    class="p-3 rounded-2xl border text-right transition-all cursor-pointer">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-xs font-black">تلویزیون معمولی (غیرهوشمند)</span>
                                    <span class="text-xs shrink-0">🔌</span>
                                </div>
                                <span class="block text-[10.5px] opacity-80 mt-1">اتصال با اندروید باکس یا کابل HDMI</span>
                            </button>
                        </div>
                    </div>

                    {{-- زیرتب الف: تلویزیون اندرویدی / اندروید باکس --}}
                    <div x-show="tvSubTab === 'android'" class="p-3.5 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 space-y-3">
                        <div class="flex items-start gap-2.5">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-amber-500 text-slate-950 text-[11px] sm:text-xs font-black flex items-center justify-center shrink-0 mt-0.5">۱</span>
                            <div class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed space-y-2 flex-1 min-w-0">
                                <p>
                                    اپلیکیشن رسمی <strong>«طلالایو TV»</strong> (نسخه {{ $tvApkVersion }}) را دانلود و روی تلویزیون نصب کنید (یا در مرورگر تلویزیون آدرس <strong class="font-mono text-amber-600 dark:text-amber-400" dir="ltr">talalive.ir/app</strong> را باز کنید):
                                </p>
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                    <a href="{{ $tvApkUrl }}" target="_blank"
                                       class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 sm:py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black shadow-sm transition-all text-center">
                                        <span>⬇️ دانلود فایل نصبی تلویزیون (APK)</span>
                                    </a>
                                    <a href="{{ route('public.app') }}" target="_blank"
                                       class="inline-flex items-center justify-center gap-1 px-3 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold hover:border-amber-500 transition-all text-center">
                                        <span>صفحه راهنمای دانلود (/app)</span>
                                        <span>↗</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-2.5">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-amber-500 text-slate-950 text-[11px] sm:text-xs font-black flex items-center justify-center shrink-0 mt-0.5">۲</span>
                            <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed">
                                برنامه <strong>طلالایو TV</strong> را روی تلویزیون اجرا کنید؛ یک <strong>کد ۶ رقمی</strong> و یک <strong>بارکد QR</strong> روی صفحه تلویزیون نمایش داده می‌شود.
                            </p>
                        </div>

                        <div class="flex items-start gap-2.5">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-amber-500 text-slate-950 text-[11px] sm:text-xs font-black flex items-center justify-center shrink-0 mt-0.5">۳</span>
                            <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed">
                                همان کد ۶ رقمی را در <strong>کادر اتصال فوری زیر</strong> وارد کنید تا تابلوی گالری شما تمام‌صفحه روی تلویزیون پخش شود!
                            </p>
                        </div>
                    </div>

                    {{-- زیرتب ب: سامسونگ، ال‌جی و مرورگر تلویزیون --}}
                    <div x-show="tvSubTab === 'browser'" x-cloak class="p-3.5 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 space-y-3">
                        <div class="flex items-start gap-2.5">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-amber-500 text-slate-950 text-[11px] sm:text-xs font-black flex items-center justify-center shrink-0 mt-0.5">۱</span>
                            <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed">
                                تلویزیون هوشمند را به اینترنت وصل کنید و مرورگر تلویزیون (سامسونگ: <strong>Internet</strong> | ال‌جی: <strong>Web Browser</strong>) را باز نمایید.
                            </p>
                        </div>

                        <div class="flex items-start gap-2.5">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-amber-500 text-slate-950 text-[11px] sm:text-xs font-black flex items-center justify-center shrink-0 mt-0.5">۲</span>
                            <div class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed space-y-1.5 min-w-0">
                                <p>در نوار آدرس بالای مرورگر تلویزیون، نشانی کوتاه زیر را وارد کنید:</p>
                                <span class="inline-block px-3.5 py-1.5 rounded-xl bg-amber-500/15 border border-amber-500/40 font-mono font-black text-sm text-amber-700 dark:text-amber-300" dir="ltr">
                                    talalive.ir/tv
                                </span>
                            </div>
                        </div>

                        <div class="flex items-start gap-2.5">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-amber-500 text-slate-950 text-[11px] sm:text-xs font-black flex items-center justify-center shrink-0 mt-0.5">۳</span>
                            <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed">
                                کد ۶ رقمی روی تلویزیون را در کادر زیر وارد کنید یا QR روی تلویزیون را با دوربین گوشی اسکن فرمایید.
                            </p>
                        </div>
                    </div>

                    {{-- زیرتب ج: تلویزیون غیرهوشمند --}}
                    <div x-show="tvSubTab === 'nonsmart'" x-cloak class="p-3.5 sm:p-4 rounded-2xl bg-slate-50 dark:bg-slate-950/80 border border-slate-200 dark:border-slate-800 space-y-2.5 text-xs text-slate-700 dark:text-slate-300 leading-relaxed">
                        <p class="font-black text-slate-900 dark:text-white">اگر تلویزیون مغازه هوشمند نیست، از یکی از ۲ روش زیر استفاده کنید:</p>
                        <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-1">
                            <div class="font-black text-amber-600 dark:text-amber-400">روش اول (پیشنهادی): اتصال اندروید باکس</div>
                            <p class="text-[11px]">یک دستگاه Android TV Box را با کابل HDMI به تلویزیون وصل کنید و اپلیکیشن <strong>«طلالایو TV»</strong> را روی آن نصب نمایید.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-1">
                            <div class="font-black text-blue-600 dark:text-blue-400">روش دوم: اتصال کامپیوتر یا لپ‌تاپ با کابل HDMI</div>
                            <p class="text-[11px]">کابل HDMI را از کیس یا لپ‌تاپ به تلویزیون وصل کنید، لینک اختصاصی تابلوی خود را در کروم باز کرده و کلید <kbd class="px-1.5 py-0.5 rounded bg-slate-200 dark:bg-slate-800 font-mono">F11</kbd> را بزنید.</p>
                        </div>
                    </div>

                    {{-- کادر جفت‌سازی زنده تلویزیون (کاملاً بهینه برای صفحه‌نمایش موبایل بدون بیرون‌زدگی) --}}
                    <div class="p-3.5 sm:p-5 rounded-2xl bg-gradient-to-l from-amber-500/10 via-white to-indigo-500/5 dark:from-amber-500/10 dark:via-slate-900 dark:to-indigo-500/10 border-2 border-amber-500/40 space-y-3">
                        <div>
                            <h4 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white">۲. اتصال فوری تلویزیون</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">کد ۶ رقمی نمایش داده شده روی تلویزیون را وارد کنید یا بارکد را اسکن نمایید:</p>
                        </div>

                        {{-- پیام وضعیت جفت‌سازی --}}
                        <div x-show="pairFeedback" x-cloak
                             :class="pairFeedbackType === 'success'
                                ? 'bg-emerald-50 dark:bg-emerald-950/60 border-emerald-300 dark:border-emerald-700 text-emerald-800 dark:text-emerald-300'
                                : 'bg-rose-50 dark:bg-rose-950/60 border-rose-300 dark:border-rose-700 text-rose-800 dark:text-rose-300'"
                             class="p-3 rounded-xl border text-xs font-bold flex items-center gap-2">
                            <span x-text="pairFeedbackType === 'success' ? '🎉' : '⚠️'"></span>
                            <span class="leading-relaxed" x-text="pairFeedback"></span>
                        </div>

                        {{-- چیدمان واکنش‌گرا: در موبایل ورودی تمام‌عرض + دو دکمه ۵۰/۵۰ زیر آن؛ در دسکتاپ یک‌خطی --}}
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                            <input type="text"
                                   maxlength="8"
                                   x-model="guidePairCode"
                                   @focus="$el.scrollIntoView({ block: 'center', behavior: 'smooth' })"
                                   @input="normalizePairInput()"
                                   @keydown.enter.prevent="submitGuidePairCode()"
                                   dir="ltr"
                                   placeholder="کد ۶ رقمی تلویزیون"
                                   class="w-full sm:flex-1 min-w-0 h-12 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl px-3 text-center font-mono font-black text-base tracking-[0.25em] text-slate-900 dark:text-white placeholder:font-sans placeholder:text-xs placeholder:font-normal placeholder:tracking-normal focus:outline-none focus:border-amber-500">

                            <div class="grid grid-cols-2 sm:flex items-center gap-2 shrink-0">
                                <button type="button"
                                        @click="submitGuidePairCode()"
                                        :disabled="isGuidePairing || guidePairCode.length < 6"
                                        class="h-11 sm:h-12 px-3 sm:px-5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs whitespace-nowrap shadow-md shadow-amber-500/20 transition-all cursor-pointer disabled:opacity-50 flex items-center justify-center gap-1">
                                    <span x-text="isGuidePairing ? 'در حال اتصال...' : '🚀 ثبت کد'"></span>
                                </button>

                                <button type="button"
                                        @click="toggleGuideScanner()"
                                        class="h-11 sm:h-12 px-3 sm:px-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-black text-xs whitespace-nowrap shadow-md shadow-indigo-600/25 transition-all cursor-pointer flex items-center justify-center gap-1.5">
                                    <span>📷</span>
                                    <span x-text="isGuideScannerOpen ? 'بستن دوربین' : 'اسکن QR'"></span>
                                </button>
                            </div>
                        </div>

                        {{-- کادر بازشونده دوربین برای اسکن QR بدون خروج از راهنما --}}
                        <div x-show="isGuideScannerOpen" x-cloak class="pt-1">
                            <div class="relative mx-auto max-w-[250px] sm:max-w-xs aspect-square rounded-2xl overflow-hidden bg-slate-950 border-2 border-dashed border-indigo-500/60 flex items-center justify-center">
                                <div id="onboarding-qr-reader" class="w-full h-full"></div>

                                <div x-show="!isGuideCameraRunning && !guideCameraError" class="absolute inset-0 bg-slate-950/90 flex flex-col items-center justify-center text-white gap-2 p-4 text-center">
                                    <div class="w-8 h-8 border-2 border-indigo-400 border-t-transparent rounded-full animate-spin"></div>
                                    <span class="text-xs font-bold text-slate-300">در حال آماده‌سازی دوربین گوشی...</span>
                                </div>

                                <div x-show="guideCameraError" class="absolute inset-0 bg-slate-950/95 flex flex-col items-center justify-center text-white gap-2.5 p-4 text-center">
                                    <span class="text-2xl">⚠️</span>
                                    <p class="text-[11px] sm:text-xs text-slate-300 leading-relaxed" x-text="guideCameraError"></p>
                                    <button type="button" @click="startGuideCamera()" class="px-3.5 py-1.5 rounded-lg bg-indigo-600 text-white text-xs font-bold cursor-pointer">
                                        تلاش مجدد
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- تب ۴: نصب وب‌اپلیکیشن موبایل (PWA) و ارتباط با پشتیبانی     --}}
                {{-- ========================================================= --}}
                <div x-show="activeTab === 'mobile'" x-cloak class="space-y-3.5 sm:space-y-5">

                    <div class="p-3.5 sm:p-5 rounded-2xl bg-gradient-to-l from-amber-500/15 via-amber-500/5 to-transparent border border-amber-500/30 space-y-3">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-start justify-between gap-3">
                            <div class="flex items-start gap-3 min-w-0">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center text-xl sm:text-2xl shrink-0 shadow-md shadow-amber-500/20">
                                    📱
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white">نصب اپلیکیشن پنل مدیریت روی گوشی (PWA)</h3>
                                    <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                                        با افزودن وب‌اپلیکیشن طلالایو به صفحه اصلی گوشی، هر زمان عکس طلای جدیدی گرفتید یا خواستید تنظیمات تابلو را تغییر دهید، با یک لمس وارد پنل می‌شوید.
                                    </p>
                                </div>
                            </div>

                            <button type="button"
                                    @click="installPwaFromGuide()"
                                    class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs shadow-md shadow-amber-500/20 transition-all cursor-pointer shrink-0 text-center">
                                📲 نصب مستقیم روی این گوشی
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3 pt-1">
                            <div class="p-3 sm:p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-1">
                                <div class="text-xs font-black text-emerald-700 dark:text-emerald-400">🤖 گوشی‌های اندروید (Chrome)</div>
                                <p class="text-[11px] text-slate-600 dark:text-slate-300 leading-relaxed">
                                    دکمه «نصب مستقیم» بالا را بزنید، یا از منوی سه‌نقطه بالای کروم گزینه <strong>Add to Home screen / Install App</strong> را انتخاب کنید.
                                </p>
                            </div>
                            <div class="p-3 sm:p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-1">
                                <div class="text-xs font-black text-blue-700 dark:text-blue-400">🍎 گوشی‌های آیفون (Safari)</div>
                                <p class="text-[11px] text-slate-600 dark:text-slate-300 leading-relaxed">
                                    در نوار پایین مرورگر سافاری دکمه <strong>Share (⎋)</strong> را لمس کرده و گزینه <strong>Add to Home Screen (➕)</strong> را بزنید.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- پشتیبانی تلفنی و آنلاین --}}
                    <div class="p-3.5 sm:p-5 rounded-2xl bg-slate-50 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 space-y-3">
                        <div>
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white">نیاز به راهنمایی تلفنی یا راه‌اندازی تلویزیون دارید؟</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 mt-1">
                                تیم پشتیبانی فنی طلالایو آماده راهنمایی گام‌به‌گام شما برای اتصال تلویزیون و تنظیم فرمول‌های گالری است:
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:flex sm:flex-wrap items-stretch sm:items-center gap-2">
                            <a href="tel:09187009064"
                               class="px-4 py-2.5 rounded-xl bg-slate-900 dark:bg-slate-800 hover:opacity-90 text-white text-xs font-black flex items-center justify-center gap-2 transition-all">
                                <span>📞 تماس مستقیم:</span>
                                <span dir="ltr" class="font-mono">0918 700 9064</span>
                            </a>

                            <a href="https://t.me/talalive" rel="noopener noreferrer" target="_blank"
                               class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white text-xs font-black flex items-center justify-center gap-2 shadow-sm transition-all">
                                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></svg>
                                <span>گفتگو در پشتیبانی تلگرام</span>
                            </a>

                            <a href="{{ route('public.tv-setup-guide') }}" target="_blank"
                               class="px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-amber-500 text-slate-700 dark:text-slate-300 text-xs font-bold flex items-center justify-center gap-1.5 transition-all">
                                <span>📖 مقاله راهنمای کامل تلویزیون‌ها</span>
                                <span>↗</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- فوتر چسبان (Sticky Footer) برای جابه‌جایی روان با یک دست در موبایل --}}
            <div class="talalive-guide-footer px-3.5 sm:px-7 py-3 bg-white/95 dark:bg-slate-900/95 border-t border-slate-200/80 dark:border-slate-800 flex items-center justify-between gap-2 shrink-0">
                <div>
                    <button type="button"
                            x-show="activeTab !== 'welcome'"
                            @click="prevGuideTab()"
                            class="px-3 sm:px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition-colors cursor-pointer">
                        &rarr; قبلی
                    </button>
                    <button type="button"
                            x-show="activeTab === 'welcome'"
                            @click="closeGuide()"
                            class="px-3 py-2.5 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-xs font-bold transition-colors cursor-pointer">
                        رد کردن راهنما
                    </button>
                </div>

                {{-- نقاط نشانگر ۴ گام راهنما --}}
                <div class="flex items-center gap-1.5" dir="rtl">
                    <template x-for="t in tabOrder" :key="t">
                        <button type="button"
                                @click="switchGuideTab(t)"
                                :class="activeTab === t ? 'w-5 bg-amber-500' : 'w-2 bg-slate-300 dark:bg-slate-700'"
                                class="h-2 rounded-full transition-all duration-200 cursor-pointer"></button>
                    </template>
                </div>

                <div>
                    <button type="button"
                            x-show="activeTab !== 'mobile'"
                            @click="nextGuideTab()"
                            class="px-4 sm:px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-black shadow-md shadow-amber-500/20 transition-all cursor-pointer flex items-center gap-1.5 whitespace-nowrap">
                        <span x-text="nextGuideLabel"></span>
                        <span>&larr;</span>
                    </button>

                    <button type="button"
                            x-show="activeTab === 'mobile'"
                            x-cloak
                            @click="closeGuide()"
                            class="px-4 sm:px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black shadow-md shadow-emerald-600/20 transition-all cursor-pointer whitespace-nowrap">
                        شروع کار با پنل ✓
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- ۲. موتور تور نوری تعاملی روی منوهای پنل (Spotlight Menu Tour)          --}}
    {{--    در موبایل کارت توضیحات پایین صفحه فیکس شده و منو به بالا اسکرول     --}}
    {{--    می‌شود تا هرگز روی گزینه روشن‌شده را نپوشاند.                      --}}
    {{-- ===================================================================== --}}
    <div x-show="tourActive" x-cloak>
        {{-- لایه محافظ کلیک پس‌زمینه --}}
        <div @click="stopSpotlightTour()" class="fixed inset-0 z-[89] cursor-pointer"></div>

        {{-- کادر نورانی Spotlight دور آیتم فعال منو --}}
        <div class="fixed z-[90] pointer-events-none rounded-2xl border-2 border-amber-400 transition-all duration-250 ease-out"
             :style="`top: ${tourRect.top}px; left: ${tourRect.left}px; width: ${tourRect.width}px; height: ${tourRect.height}px; box-shadow: 0 0 0 9999px rgba(2, 6, 23, 0.78), 0 0 24px rgba(245, 158, 11, 0.7);`">
        </div>

        {{-- کارت توضیحات گام فعلی (در موبایل: Bottom-Sheet ثابت | در دسکتاپ: شناور کنار منو) --}}
        <div x-ref="tourTooltip"
             @click.stop
             class="talalive-tour-card fixed z-[95] bg-white dark:bg-slate-900 border-2 border-amber-500/80 rounded-2xl sm:rounded-3xl p-4 sm:p-5 shadow-2xl transition-all duration-250 ease-out space-y-2.5 sm:space-y-3.5"
             :style="tourTooltipStyle">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-amber-500/15 text-amber-700 dark:text-amber-300 border border-amber-500/30"
                          x-text="`گام ${tourIndex + 1} از ${tourSteps.length}`"></span>
                </div>
                <button type="button" @click="stopSpotlightTour()"
                        class="px-2 py-0.5 rounded-lg text-xs font-bold text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 cursor-pointer">
                    بستن تور &times;
                </button>
            </div>

            <div class="space-y-1">
                <h4 class="text-xs sm:text-base font-black text-slate-900 dark:text-white"
                    x-text="currentTourStep?.title || ''"></h4>
                <p class="text-[11.5px] sm:text-xs text-slate-600 dark:text-slate-300 leading-relaxed"
                   x-text="currentTourStep?.desc || ''"></p>
            </div>

            <div class="flex items-center justify-between gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button"
                        @click="prevTourStep()"
                        :disabled="tourIndex === 0"
                        class="min-h-[40px] px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold disabled:opacity-40 cursor-pointer">
                    قبلی
                </button>

                <div class="flex items-center gap-1.5">
                    <template x-for="(s, idx) in tourSteps" :key="s.id">
                        <span :class="idx === tourIndex ? 'w-3.5 bg-amber-500' : 'w-1.5 bg-slate-300 dark:bg-slate-700'"
                              class="h-1.5 rounded-full transition-all"></span>
                    </template>
                </div>

                <button type="button"
                        @click="nextTourStep()"
                        class="min-h-[40px] px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-black shadow-md shadow-amber-500/20 cursor-pointer whitespace-nowrap">
                    <span x-text="tourIndex + 1 < tourSteps.length ? 'بعدی ←' : 'پایان تور ✓'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .talalive-guide-panel {
        height: 92vh;
        height: 92dvh;
        max-height: 92vh;
        max-height: 92dvh;
    }
    @media (min-width: 640px) {
        .talalive-guide-panel {
            height: auto;
            max-height: 88vh;
            max-height: 88dvh;
        }
    }
    @media (max-height: 520px) {
        .talalive-guide-panel {
            height: 98vh;
            height: 98dvh;
            max-height: 98vh;
            max-height: 98dvh;
        }
        .talalive-guide-footer {
            padding-top: 0.5rem;
            padding-bottom: max(0.5rem, env(safe-area-inset-bottom));
        }
    }
    .talalive-guide-footer {
        padding-bottom: max(0.75rem, env(safe-area-inset-bottom));
    }
    .talalive-tour-card {
        max-height: 46vh;
        max-height: 46dvh;
        overflow-y: auto;
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
            detail: { tab: tab || 'welcome', tvSubTab: tvSubTab || null }
        }));
    };

    window.startTalaliveSpotlightTour = function() {
        window.dispatchEvent(new CustomEvent('talalive-start-tour'));
    };

    function talaliveOnboardingGuide() {
        return {
            isOpen: @json($guideAutoOpen),
            activeTab: 'welcome',
            tabOrder: ['welcome', 'panel', 'tv', 'mobile'],
            tvSubTab: 'android',
            copiedBoardUrl: false,

            // وضعیت جفت‌سازی مستقیم داخل مودال
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

            get nextGuideLabel() {
                if (this.activeTab === 'welcome') return 'آشنایی با پنل';
                if (this.activeTab === 'panel') return 'آموزش تلویزیون';
                if (this.activeTab === 'tv') return 'اپ موبایل';
                return 'بعدی';
            },

            init() {
                if (this.isOpen) {
                    window.__TALALIVE_GUIDE_ACTIVE = true;
                    this.hideFloatingPwaToast();
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

            hideFloatingPwaToast() {
                const toast = document.getElementById('pwa-install-toast');
                if (toast) {
                    toast.style.display = 'none';
                }
            },

            handleEscape() {
                if (this.tourActive) {
                    this.stopSpotlightTour();
                } else if (this.isOpen) {
                    this.closeGuide();
                }
            },

            scrollBodyToTop() {
                this.$nextTick(() => {
                    if (this.$refs.guideBody) {
                        this.$refs.guideBody.scrollTop = 0;
                    }
                });
            },

            openGuide(tab = 'welcome', tvSubTab = null) {
                if (this.tourActive) {
                    this.stopSpotlightTour();
                }
                this.hideFloatingPwaToast();
                this.activeTab = tab || 'welcome';
                if (tvSubTab) {
                    this.tvSubTab = tvSubTab;
                }
                this.pairFeedback = '';
                this.isOpen = true;
                window.__TALALIVE_GUIDE_ACTIVE = true;
                this.scrollBodyToTop();
            },

            async closeGuide() {
                await this.stopGuideCamera();
                this.isGuideScannerOpen = false;
                this.isOpen = false;
                if (!this.tourActive) {
                    window.__TALALIVE_GUIDE_ACTIVE = false;
                }
            },

            async switchGuideTab(tab) {
                if (this.activeTab === 'tv' && tab !== 'tv') {
                    await this.stopGuideCamera();
                    this.isGuideScannerOpen = false;
                }
                this.activeTab = tab;
                this.scrollBodyToTop();
            },

            nextGuideTab() {
                const idx = this.tabOrder.indexOf(this.activeTab);
                if (idx >= 0 && idx + 1 < this.tabOrder.length) {
                    this.switchGuideTab(this.tabOrder[idx + 1]);
                }
            },

            prevGuideTab() {
                const idx = this.tabOrder.indexOf(this.activeTab);
                if (idx > 0) {
                    this.switchGuideTab(this.tabOrder[idx - 1]);
                }
            },

            copyBoardLink(url) {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url);
                }
                this.copiedBoardUrl = true;
                setTimeout(() => { this.copiedBoardUrl = false; }, 2500);
            },

            async installPwaFromGuide() {
                await this.closeGuide();
                if (typeof window.triggerPwaInstall === 'function') {
                    window.triggerPwaInstall();
                } else {
                    window.location.href = '/app';
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
                    this.pairFeedback = 'لطفاً کد ۶ رقمی نمایش داده شده روی تلویزیون را کامل وارد فرمایید.';
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
                        this.pairFeedback = data.message || 'تلویزیون مغازه با موفقیت متصل شد! تابلوی شما هم‌اکنون روی نمایشگر پخش می‌شود.';
                        this.guidePairCode = '';
                        setTimeout(() => { window.location.reload(); }, 1400);
                    } else {
                        this.pairFeedbackType = 'error';
                        this.pairFeedback = (data && data.message)
                            ? data.message
                            : 'کد فعال‌سازی نامعتبر یا منقضی شده است. لطفاً صفحه تلویزیون را رفرش فرمایید.';
                    }
                } catch (err) {
                    this.pairFeedbackType = 'error';
                    this.pairFeedback = 'خطا در برقراری ارتباط با سرور. لطفاً اتصال اینترنت را بررسی کنید.';
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
                    const readerEl = document.getElementById('onboarding-qr-reader');
                    if (readerEl) {
                        readerEl.scrollIntoView({ block: 'center', behavior: 'smooth' });
                    }
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
                    this.guideCameraError = 'دسترسی به دوربین مجاز نشد یا این دستگاه دوربین ندارد. می‌توانید کد ۶ رقمی را در کادر بالا وارد نمایید.';
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
                        this.pairFeedback = data.message || 'تلویزیون مغازه با موفقیت متصل شد! 🎉';
                        setTimeout(() => { window.location.reload(); }, 1400);
                    } else {
                        this.isGuideScannerOpen = false;
                        this.pairFeedbackType = 'error';
                        this.pairFeedback = (data && data.message) ? data.message : 'خطا در اتصال تلویزیون. لطفاً مجدداً تلاش کنید.';
                    }
                } catch (e) {
                    this.isGuideScannerOpen = false;
                    this.pairFeedbackType = 'error';
                    this.pairFeedback = 'خطا در ارتباط با سرور هنگام ثبت بارکد.';
                } finally {
                    this.isProcessingGuideQr = false;
                }
            },

            // =========================================================
            // متدهای تور نوری مرحله‌به‌مرحله منوها (Spotlight Tour)
            // =========================================================
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
                this.hideFloatingPwaToast();

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
                const measuredCardH = (tooltipEl && tooltipEl.offsetHeight > 40) ? tooltipEl.offsetHeight : 195;

                if (vw < 1024) {
                    // موبایل: کارت توضیحات پایین صفحه فیکس است؛ به nav پدینگ موقت می‌دهیم
                    // تا آیتم‌های پایانی منو هم به نیمه بالایی صفحه (بالای کارت) اسکرول شوند
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
                    // دسکتاپ: منو سمت راست است و کارت توضیحات سمت چپ آیتم قرار می‌گیرد
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

                    const tooltipW = Math.min(350, vw - 32);
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
