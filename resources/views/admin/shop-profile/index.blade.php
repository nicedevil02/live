@extends('admin.layouts.app')

@section('title', 'اطلاعات فروشگاه و QR اختصاصی')

@section('content')
<div x-data="shopProfileManager()" class="space-y-6 max-w-6xl mx-auto pb-12">

    {{-- Toast Notification --}}
    <div x-show="toast.show" x-transition
         :class="toast.type === 'success'
             ? 'bg-emerald-950 text-emerald-300 border-emerald-800'
             : 'bg-rose-950 text-rose-300 border-rose-800'"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3 px-5 py-3 rounded-2xl shadow-2xl border text-sm font-semibold"
         style="display: none;">
        <span x-text="toast.message"></span>
    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black">
                    <i data-lucide="store" class="w-5 h-5"></i>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-900 dark:text-white">اطلاعات فروشگاه و QR اختصاصی</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">مدیریت نام گالری، شهر، راه‌های ارتباطی و تنظیم بارکد اسکن تلویزیون</p>
                </div>
            </div>
        </div>

        <button @click="saveProfile()" :disabled="isSaving"
                class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/20 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
            <template x-if="isSaving">
                <div class="w-4 h-4 border-2 border-slate-950 border-t-transparent rounded-full animate-spin"></div>
            </template>
            <template x-if="!isSaving">
                <i data-lucide="check" class="w-4 h-4"></i>
            </template>
            <span x-text="isSaving ? 'در حال ذخیره‌سازی...' : 'ذخیره و انتشار روی تابلو'"></span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- ستون راست: اطلاعات فروشگاه و انتخاب شهر --}}
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm space-y-5">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <i data-lucide="building-2" class="w-5 h-5 text-amber-500"></i>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">مشخصات و هویت گالری</h3>
                </div>

                {{-- نام طلافروشی --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <i data-lucide="type" class="w-4 h-4 text-slate-400"></i>
                        <span>نام گالری / طلافروشی (نمایش در هدر تابلو)</span>
                    </label>
                    <input type="text" x-model="form.shop_name" placeholder="مثال: گالری طلای بهمن"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 transition-shadow">
                </div>

                {{-- شهر گالری با قابلیت جستجوی زنده و دسته‌بندی آکاردئونی استان‌ها --}}
                @php
                    $rawCities = \App\Http\Controllers\Admin\DisplaySettingController::getCitiesConfig();
                    $provincesData = [];
                    foreach ($rawCities as $s => $c) {
                        $prov = $c['province'] ?? 'ایران';
                        if (!isset($provincesData[$prov])) {
                            $provincesData[$prov] = [];
                        }
                        $provincesData[$prov][] = [
                            'slug' => $s,
                            'name' => $c['name'],
                            'is_capital' => !empty($c['is_capital']),
                        ];
                    }
                @endphp

                <div class="space-y-1.5" 
                     x-data="cityPicker(form.city, @js($provincesData))"
                     x-init="$watch('selected', val => { form.city = val; }); $watch('form.city', val => { if (selected !== val) selected = val; })">
                    <label class="flex items-center justify-between text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-rose-500"></i>
                            <span>شهر گالری (جهت سئوی محلی در گوگل و فوتر تابلو)</span>
                        </div>
                        <span class="text-[11px] font-normal text-slate-400">جستجو و انتخاب از ۳۱ استان</span>
                    </label>

                    {{-- Dropdown Trigger Button --}}
                    <div class="relative">
                        <button type="button" @click="toggleDropdown()" 
                                class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 transition-all flex items-center justify-between gap-2 cursor-pointer shadow-xs hover:border-slate-300 dark:hover:border-slate-600">
                            <div class="flex items-center gap-2.5 truncate">
                                <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                                <span class="text-slate-900 dark:text-white font-bold" x-text="selectedLabel"></span>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-[11px] px-2 py-0.5 rounded-full bg-slate-200/70 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-medium" x-text="selectedProvinceNameOnly"></span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180 text-amber-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </button>

                        {{-- Dropdown Popover --}}
                        <div x-show="open" 
                             x-cloak
                             @click.outside="open = false"
                             @keydown.escape.window="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-98"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-98"
                             class="absolute right-0 left-0 top-full mt-2 z-50 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl overflow-hidden backdrop-blur-xl">
                            
                            {{-- Search Input (Sticky at top) --}}
                            <div class="p-3 bg-slate-50/90 dark:bg-slate-950/80 border-b border-slate-100 dark:border-slate-800 sticky top-0 z-20">
                                <div class="relative">
                                    <input type="text" 
                                           x-ref="searchInput"
                                           x-model="search" 
                                           placeholder="🔍 جستجوی شهر یا استان (مثال: ملایر، کاشان، تبریز)..." 
                                           class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl pr-9 pl-8 py-2.5 text-xs sm:text-sm font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 transition-all">
                                    <svg class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    <button type="button" x-show="search" @click="clearSearch()" class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between mt-2 px-1 text-[11px] text-slate-400">
                                    <span x-show="!search">برای مشاهده شهرها، روی نام استان کلیک کنید</span>
                                    <span x-show="search" x-text="totalMatchesCount + ' شهر مطابق با جستجو پیدا شد'"></span>
                                    <span class="font-mono text-[10px]" x-text="Object.keys(provinces).length + ' استان'"></span>
                                </div>
                            </div>

                            {{-- Accordion List of Provinces and Cities --}}
                            <div class="max-h-72 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800/60 custom-scrollbar">
                                
                                <template x-for="prov in filteredProvinces" :key="prov.name">
                                    <div class="group/prov">
                                        {{-- Province Header (Click to toggle expansion) --}}
                                        <button type="button" 
                                                @click="toggleProvince(prov.name)"
                                                class="w-full px-4 py-2.5 flex items-center justify-between text-right bg-slate-50/70 hover:bg-slate-100/90 dark:bg-slate-800/30 dark:hover:bg-slate-800/70 transition-colors select-none">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-amber-500 transition-transform duration-200" :class="isProvinceExpanded(prov) ? 'rotate-90' : 'rotate-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                                                <span class="text-xs sm:text-sm font-black text-slate-800 dark:text-slate-200" x-text="'استان ' + prov.name"></span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-slate-200/80 dark:bg-slate-700/80 text-slate-600 dark:text-slate-300" x-text="prov.matchCount + ' شهر'"></span>
                                            </div>
                                        </button>

                                        {{-- Cities in this Province --}}
                                        <div x-show="isProvinceExpanded(prov)" 
                                             class="bg-white dark:bg-slate-900/60 py-1 grid grid-cols-1 sm:grid-cols-2 gap-0.5 border-t border-slate-100/50 dark:border-slate-800/40">
                                            <template x-for="c in prov.cities" :key="c.slug">
                                                <button type="button" 
                                                        @click="selectCity(c.slug)"
                                                        :class="selected === c.slug 
                                                            ? 'bg-amber-500/15 text-amber-700 dark:text-amber-300 font-black border-r-4 border-amber-500' 
                                                            : 'text-slate-700 dark:text-slate-300 hover:bg-amber-500/10 hover:text-amber-600 dark:hover:text-amber-400 font-medium'"
                                                        class="px-5 py-2 text-right text-xs sm:text-sm flex items-center justify-between transition-colors">
                                                    <span x-text="c.name"></span>
                                                    <template x-if="c.is_capital">
                                                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold">مرکز استان</span>
                                                    </template>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                {{-- Empty state if no cities match --}}
                                <div x-show="filteredProvinces.length === 0" class="p-6 text-center text-slate-400 space-y-2">
                                    <p class="text-sm font-bold">هیچ شهری مطابق با «<span class="text-amber-500" x-text="search"></span>» پیدا نشد.</p>
                                    <p class="text-xs">می‌توانید گزینه «سایر شهرهای ایران» را انتخاب فرمایید.</p>
                                </div>

                                {{-- Option for Other Cities --}}
                                <div class="p-2 bg-slate-50 dark:bg-slate-950/50">
                                    <button type="button" 
                                            @click="selectCity('other')"
                                            :class="selected === 'other' ? 'bg-amber-500/15 text-amber-700 dark:text-amber-300 font-black border-r-4 border-amber-500' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 font-bold'"
                                            class="w-full px-4 py-2 rounded-xl text-right text-xs sm:text-sm flex items-center justify-between transition-colors">
                                        <span>سایر شهرهای ایران (ثبت عمومی)</span>
                                        <span class="text-[10px] text-slate-400">سراسر کشور</span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-400">این شهر در هدر و فوتر تابلو (مثلاً «همدان (ملایر)») و لینک‌های سئوی محلی گوگل نمایش داده می‌شود.</p>
                </div>

                {{-- شماره تلفن --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <i data-lucide="phone" class="w-4 h-4 text-emerald-500"></i>
                        <span>شماره تلفن / همراه</span>
                    </label>
                    <input type="text" dir="ltr" x-model="form.phone" placeholder="09187009064"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 text-left font-mono">
                </div>

                {{-- شبکه‌های اجتماعی --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                            <i data-lucide="instagram" class="w-4 h-4 text-pink-500"></i>
                            <span>اینستاگرام</span>
                        </label>
                        <input type="text" dir="ltr" x-model="form.instagram" placeholder="@my_gold_gallery"
                               class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/40 text-left font-mono">
                    </div>
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                            <i data-lucide="message-circle" class="w-4 h-4 text-indigo-500"></i>
                            <span>روبیکا / ایتا / تلگرام</span>
                        </label>
                        <input type="text" dir="ltr" x-model="form.rubika" placeholder="@channel_id"
                               class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/40 text-left font-mono">
                    </div>
                </div>
            </div>
        </div>

        {{-- ستون چپ: تنظیم کد QR اختصاصی --}}
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm space-y-5">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <i data-lucide="qr-code" class="w-5 h-5 text-indigo-500"></i>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">تنظیم کد QR اختصاصی تلویزیون</h3>
                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    با وارد کردن لینک کانال یا پیج خود، کد QR اختصاصی در گوشه بالای تابلوی تلویزیون قرار می‌گیرد تا مشتریان با دوربین گوشی آن را اسکن کنند.
                </p>

                {{-- آدرس لینک QR --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <i data-lucide="link" class="w-4 h-4 text-slate-400"></i>
                        <span>لینک مقصد (URL کامل)</span>
                    </label>
                    <input type="text" dir="ltr" x-model="form.qr_link" placeholder="https://rubika.ir/my_channel"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40 text-left font-mono">
                </div>

                {{-- عنوان بالای QR --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <i data-lucide="tag" class="w-4 h-4 text-slate-400"></i>
                        <span>متن بالای کد QR</span>
                    </label>
                    <input type="text" x-model="form.qr_label" placeholder="مثال: کانال روبیکا / عضویت باشگاه مشتریان"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                </div>

                {{-- توضیح زیر QR --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <i data-lucide="align-right" class="w-4 h-4 text-slate-400"></i>
                        <span>توضیح زیر کد QR</span>
                    </label>
                    <input type="text" x-model="form.qr_desc" placeholder="مثال: اسکن جهت عضویت در کانال قیمت‌ها"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                </div>

                {{-- پیش‌نمایش زنده در کارت تلویزیون --}}
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <span class="text-[10px] text-amber-500 font-bold uppercase tracking-wider block">پیش‌نمایش در تابلوی تلویزیون</span>
                        <p class="text-xs font-black text-slate-800 dark:text-slate-100 truncate mt-1" x-text="form.qr_label || 'عضویت در شبکه‌های اجتماعی'"></p>
                        <p class="text-[11px] text-slate-400 truncate mt-0.5" x-text="form.qr_desc || 'اسکن جهت مشاهده در موبایل'"></p>
                    </div>
                    <div class="w-14 h-14 bg-white p-1 rounded-xl shadow-xs shrink-0 flex items-center justify-center">
                        <img src="{{ asset('images/sample-qr.png') }}" onerror="this.src='/icons/icon-72x72.png'" class="w-full h-full object-contain" alt="QR">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function cityPicker(initialSlug, provincesData) {
    return {
        open: false,
        search: '',
        selected: initialSlug || 'tehran',
        provinces: provincesData || {},
        expandedProvinces: {},

        init() {
            this.autoExpandSelectedProvince();
            this.$watch('selected', () => {
                this.autoExpandSelectedProvince();
            });
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
            return 'شهر خود را انتخاب کنید...';
        },

        get selectedCityNameOnly() {
            if (this.selected === 'other') return 'سایر شهرها';
            for (const [prov, cities] of Object.entries(this.provinces)) {
                const match = cities.find(c => c.slug === this.selected);
                if (match) return match.name;
            }
            return 'انتخاب شهر';
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
                    matchCount: cities.length,
                    isExpanded: !!this.expandedProvinces[name]
                }));
            }

            const results = [];
            for (const [name, cities] of Object.entries(this.provinces)) {
                const normProv = this.normalize(name);
                const provMatches = normProv.includes(q);

                let matchedCities = cities;
                if (!provMatches) {
                    matchedCities = cities.filter(c => this.normalize(c.name).includes(q) || this.normalize(c.slug).includes(q));
                }

                if (matchedCities.length > 0) {
                    results.push({
                        name,
                        cities: matchedCities,
                        matchCount: matchedCities.length,
                        isExpanded: true
                    });
                }
            }
            return results;
        },

        get totalMatchesCount() {
            return this.filteredProvinces.reduce((acc, p) => acc + p.cities.length, 0);
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
            this.$dispatch('city-selected', { slug });
        },

        toggleDropdown() {
            this.open = !this.open;
            if (this.open) {
                this.search = '';
                this.autoExpandSelectedProvince();
                this.$nextTick(() => {
                    const el = this.$refs.searchInput;
                    if (el) el.focus();
                });
            }
        },

        clearSearch() {
            this.search = '';
            if (this.$refs.searchInput) {
                this.$refs.searchInput.focus();
            }
        }
    };
}

function shopProfileManager() {
    return {
        isSaving: false,
        toast: { show: false, message: '', type: 'success' },
        form: {
            shop_name: @json($settings->shop_name ?? $user->name ?? ''),
            city: @json(!empty($user->city_slug) ? $user->city_slug : ($settings->city_slug ?? 'tehran')),
            phone: @json($settings->phone ?? $user->phone ?? ''),
            instagram: @json($settings->instagram ?? ''),
            rubika: @json($settings->rubika ?? ''),
            qr_link: @json($settings->qr_link ?? ''),
            qr_label: @json($settings->qr_label ?? ''),
            qr_desc: @json($settings->qr_desc ?? '')
        },

        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => this.toast.show = false, 3500);
        },

        async saveProfile() {
            this.isSaving = true;
            try {
                const res = await fetch("{{ route('admin.shop-profile.update') }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.form)
                });

                if (!res.ok) {
                    const err = await res.json().catch(() => ({}));
                    throw new Error(err.message || 'خطا در ذخیره‌سازی اطلاعات');
                }

                const data = await res.json();
                if (data.city_slug) {
                    this.form.city = data.city_slug;
                } else if (data.user && data.user.city_slug) {
                    this.form.city = data.user.city_slug;
                }
                this.showToast(data.message || 'اطلاعات فروشگاه با موفقیت ذخیره شد.', 'success');
            } catch (err) {
                this.showToast(err.message, 'error');
            } finally {
                this.isSaving = false;
            }
        }
    };
}
</script>
@endpush
