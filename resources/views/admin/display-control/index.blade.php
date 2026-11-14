@extends('admin.layouts.app')

@section('title', 'تنظیمات پوسته و نمایش')

@section('content')
<div x-data="displayControlPage()" x-init="init(@js($settings), @js($items))" class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl">
                <i data-lucide="monitor" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">تنظیمات تابلو نمایش</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    انتخاب پوسته بصری، نحوه نمایش اجزا و چیدمان کاشی‌های قیمت
                    <span x-show="settings.published_at" class="mr-3 text-emerald-600 dark:text-emerald-400">
                        · آخرین انتشار: <span x-text="new Date(settings.published_at).toLocaleString('fa-IR')"></span>
                    </span>
                </p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button type="button"
                    @click="openThemePreview(settings.theme_mode, currentThemeName)"
                    class="flex items-center gap-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 px-3.5 py-2.5 rounded-xl font-bold transition-colors text-xs sm:text-sm cursor-pointer">
                <i data-lucide="eye" class="w-4 h-4 text-amber-600 dark:text-amber-400"></i>
                <span>پیش‌نمایش تابلو</span>
            </button>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 px-4 py-2.5 rounded-xl font-semibold transition-colors text-xs sm:text-sm cursor-pointer">
                بازگشت
            </a>
            <button type="button"
                    @click="saveAndApply()"
                    :disabled="isSaving"
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-black transition-all disabled:opacity-50 shadow-sm shadow-blue-500/20 text-xs sm:text-sm cursor-pointer">
                <i x-show="!isSaving" data-lucide="check-circle-2" class="w-4 h-4"></i>
                <span x-text="isSaving ? 'در حال ذخیره و اعمال...' : 'ذخیره و اعمال روی تابلو'"></span>
            </button>
        </div>
    </div>

    {{-- Feedback --}}
    <div x-show="message.text" x-transition
         :class="message.type === 'success' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50' : 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/50'"
         class="flex items-center gap-2 px-4 py-3 rounded-xl border text-sm font-semibold">
        <i x-show="message.type === 'success'" data-lucide="check-circle-2" class="w-5 h-5"></i>
        <i x-show="message.type !== 'success'" data-lucide="alert-circle" class="w-5 h-5"></i>
        <span x-text="message.text"></span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full">
        {{-- Left Column: Theme & Settings --}}
        <div class="lg:col-span-7 space-y-6">
            {{-- Theme Selector --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-5">
                    <i data-lucide="palette" class="w-5 h-5 text-violet-500"></i>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">انتخاب پوسته نمایشگر</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <template x-for="theme in THEME_OPTIONS" :key="theme.id">
                        <div class="relative flex flex-col justify-between gap-2 p-3.5 rounded-2xl border-2 cursor-pointer transition-all duration-200"
                             role="radio"
                             :aria-checked="settings.theme_mode === theme.id"
                             tabindex="0"
                             @click="settings.theme_mode = theme.id"
                             @keydown.enter.prevent="settings.theme_mode = theme.id"
                             @keydown.space.prevent="settings.theme_mode = theme.id"
                             :class="settings.theme_mode === theme.id
                                 ? 'border-amber-500 ring-2 ring-amber-500/20 bg-amber-50/70 dark:bg-amber-500/10'
                                 : 'border-slate-200 dark:border-slate-700 hover:border-amber-400/60 dark:hover:border-amber-600/60 hover:bg-slate-50 dark:hover:bg-slate-800/50'">
                            <div>
                                <div class="w-full h-12 rounded-xl border-2 flex items-center justify-center gap-2 relative overflow-hidden" :class="theme.preview">
                                    <div class="w-3 h-3 rounded-full" :class="theme.dot"></div>
                                    <div class="w-8 h-1.5 rounded-full opacity-50" :class="theme.dot"></div>
                                    <div class="w-2 h-2 rounded-full opacity-35" :class="theme.dot"></div>
                                    <span x-show="settings.theme_mode === theme.id"
                                          class="absolute top-1.5 left-1.5 px-2 py-0.5 rounded-md text-[10px] font-black bg-amber-500 text-slate-950 shadow-xs">
                                        فعال
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 mt-2.5">
                                    <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center shrink-0"
                                         :class="settings.theme_mode === theme.id ? 'border-amber-600 dark:border-amber-400' : 'border-slate-300 dark:border-slate-600'">
                                        <div x-show="settings.theme_mode === theme.id" class="w-2 h-2 rounded-full bg-amber-600 dark:bg-amber-400"></div>
                                    </div>
                                    <span class="font-bold text-sm text-slate-800 dark:text-slate-200 truncate" x-text="theme.name"></span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed pr-6 mt-0.5" x-text="theme.desc"></p>
                            </div>
                            <div class="pt-1 pr-6 flex items-center justify-end">
                                <button type="button"
                                        @click.stop="openThemePreview(theme.id, theme.name)"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[11px] font-bold bg-slate-100 dark:bg-slate-800 hover:bg-amber-500/15 text-slate-700 dark:text-slate-300 hover:text-amber-700 dark:hover:text-amber-300 transition-colors cursor-pointer">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <span>پیش‌نمایش زنده</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- ویجت‌های هوشمند سرصفحه تابلو --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="cloud-sun" class="w-5 h-5 text-amber-500"></i>
                        <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">ویجت هوشمند آب و هوای تابلو</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-500/20">زنده و برخط</span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    با فعال‌سازی این گزینه، دمای لحظه‌ای و وضعیت جوی شهر مغازه شما به‌صورت کپسول شیشه‌ای شیک در کنار ساعت هدر تابلو نمایش داده می‌شود.
                </p>
                <label class="flex items-center justify-between p-3.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-slate-50 dark:bg-slate-800/40 cursor-pointer transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                            <i data-lucide="sun" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">نمایش دما و وضعیت آب‌وهوا</span>
                            <div class="text-[11px] text-slate-500 mt-0.5">به‌روزرسانی خودکار بر اساس شهر ثبت‌شده گالری</div>
                        </div>
                    </div>
                    <div class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none"
                         @click.prevent="settings.show_weather = !Boolean(settings.show_weather ?? true)">
                        <div class="h-6 w-11 rounded-full transition-colors" :class="(settings.show_weather ?? true) ? 'bg-amber-500' : 'bg-slate-300 dark:bg-slate-700'"></div>
                        <div class="absolute left-[3px] top-[3px] h-4.5 w-4.5 rounded-full bg-white transition-transform shadow-xs" :class="(settings.show_weather ?? true) ? 'translate-x-5' : ''"></div>
                    </div>
                </label>

                {{-- تاگل جلوه متحرک وضعیت آب‌وهوا در هدر --}}
                <label class="flex items-center justify-between p-3.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-slate-50 dark:bg-slate-800/40 cursor-pointer transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-sky-500/15 text-sky-600 dark:text-sky-400 flex items-center justify-center shrink-0">
                            <i data-lucide="sparkles" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">جلوه متحرک وضعیت هوا در هدر تابلو</span>
                            <div class="text-[11px] text-slate-500 mt-0.5">بارش واضح باران، برف، حرکت ابرها و تابش آفتاب در نوار بالایی تابلو</div>
                        </div>
                    </div>
                    <div class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none"
                         @click.prevent="settings.show_weather_bg = !Boolean(settings.show_weather_bg ?? true)">
                        <div class="h-6 w-11 rounded-full transition-colors" :class="(settings.show_weather_bg ?? true) ? 'bg-sky-500' : 'bg-slate-300 dark:bg-slate-700'"></div>
                        <div class="absolute left-[3px] top-[3px] h-4.5 w-4.5 rounded-full bg-white transition-transform shadow-xs" :class="(settings.show_weather_bg ?? true) ? 'translate-x-5' : ''"></div>
                    </div>
                </label>
            </div>
        </div>

        {{-- Right Column: Display Items Toggles --}}
        <div class="lg:col-span-5">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm h-full flex flex-col">
                <div class="p-6 border-b border-slate-200 dark:border-slate-800">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i data-lucide="layout-grid" class="w-5 h-5 text-emerald-500"></i>
                            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">کاشی‌های قیمت (نمایشگر)</h3>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-xs font-semibold text-slate-500"
                              x-text="items.filter(i => i.enabled).length + ' فعال'"></span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 leading-relaxed">
                        اقلام نمایشی روی تابلو را فعال یا غیرفعال کنید و با کشیدن دستگیره یا دکمه‌های بالا و پایین، ترتیب نمایش آن‌ها را بچینید.
                    </p>
                </div>
                <div class="p-4 flex-1 overflow-y-auto max-h-[640px] custom-scrollbar">
                    <div id="display-items-sortable" class="space-y-2">
                        <template x-for="(item, index) in items" :key="item.key">
                            <div :data-item-key="item.key"
                                 class="flex items-center justify-between gap-2 p-2.5 sm:p-3 rounded-xl border transition-colors select-none"
                                 :class="item.enabled
                                     ? 'bg-slate-50 dark:bg-slate-800/60 border-slate-300 dark:border-slate-600'
                                     : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 opacity-65 hover:opacity-100'">
                                <div class="flex items-center gap-2 min-w-0">
                                    <button type="button"
                                            class="tile-drag-handle p-1.5 rounded-lg text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-slate-200/70 dark:hover:bg-slate-700/70 cursor-grab active:cursor-grabbing shrink-0"
                                            title="برای جابجایی بکشید"
                                            aria-label="جابجایی با کشیدن">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="19" r="1"/></svg>
                                    </button>
                                    <span class="text-xs font-mono font-bold text-slate-400 w-5 text-center shrink-0 tabular-nums" x-text="index + 1"></span>
                                    <span class="text-xs sm:text-sm font-bold truncate"
                                          :class="item.enabled ? 'text-slate-800 dark:text-slate-200' : 'text-slate-500'"
                                          x-text="item.label"></span>
                                </div>
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <button type="button"
                                            @click.stop="moveItem(index, -1)"
                                            :disabled="index === 0"
                                            aria-label="انتقال به بالا"
                                            title="انتقال به بالا"
                                            class="min-w-[32px] min-h-[32px] rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:border-amber-400 hover:text-amber-600 disabled:opacity-30 disabled:cursor-not-allowed flex items-center justify-center transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m18 15-6-6-6 6"/></svg>
                                    </button>
                                    <button type="button"
                                            @click.stop="moveItem(index, 1)"
                                            :disabled="index === items.length - 1"
                                            aria-label="انتقال به پایین"
                                            title="انتقال به پایین"
                                            class="min-w-[32px] min-h-[32px] rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:border-amber-400 hover:text-amber-600 disabled:opacity-30 disabled:cursor-not-allowed flex items-center justify-center transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m6 9 6 6 6-6"/></svg>
                                    </button>
                                    <button type="button"
                                            role="switch"
                                            :aria-checked="Boolean(item.enabled)"
                                            :aria-label="'فعال‌سازی ' + item.label"
                                            @click.stop="item.enabled = !item.enabled"
                                            class="relative inline-flex h-6 w-10 shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-amber-500/40 mr-1">
                                        <span class="h-5 w-9 rounded-full transition-colors" :class="item.enabled ? 'bg-emerald-500' : 'bg-slate-200 dark:bg-slate-700'"></span>
                                        <span class="absolute left-[4px] top-[4px] h-4 w-4 rounded-full bg-white transition-transform shadow-xs" :class="item.enabled ? 'translate-x-4' : ''"></span>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Actions --}}
    <div class="flex flex-wrap justify-between items-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
        <p class="text-xs text-slate-500 dark:text-slate-400">
            با زدن دکمه «ذخیره و اعمال روی تابلو»، تنظیمات پوسته و ترتیب کاشی‌ها هم‌زمان روی تلویزیون گالری اعمال می‌شود.
        </p>
        <div class="flex items-center gap-2.5 mr-auto">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 px-5 py-3 rounded-xl font-bold transition-colors text-sm cursor-pointer">
                بازگشت
            </a>
            <button type="button" @click="saveAndApply()" :disabled="isSaving"
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-black transition-all disabled:opacity-50 shadow-md shadow-blue-500/20 text-sm cursor-pointer">
                <i x-show="!isSaving" data-lucide="check-circle-2" class="w-4 h-4"></i>
                <span x-text="isSaving ? 'در حال ذخیره و اعمال...' : 'ذخیره و اعمال روی تابلو'"></span>
            </button>
        </div>
    </div>

    {{-- نوار شناور تغییرات ذخیره‌نشده --}}
    <div x-show="isDirty"
         x-cloak
         x-transition
         class="fixed bottom-20 lg:bottom-5 left-4 right-4 lg:right-80 lg:left-8 z-30">
        <div class="max-w-3xl mx-auto rounded-2xl bg-stone-950/95 dark:bg-stone-900/95 text-white border border-amber-500/40 shadow-2xl backdrop-blur-xl px-4 py-3 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-xs sm:text-sm font-bold">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse shrink-0"></span>
                <span>تغییرات جدید آماده اعمال روی تابلوی مغازه است</span>
            </div>
            <div class="flex items-center gap-2 mr-auto">
                <button type="button" @click="resetChanges()" :disabled="isSaving"
                        class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-stone-200 text-xs font-bold transition-colors cursor-pointer">
                    بازگردانی
                </button>
                <button type="button" @click="saveAndApply()" :disabled="isSaving"
                        class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-black transition-colors cursor-pointer disabled:opacity-50">
                    <span x-text="isSaving ? 'در حال اعمال...' : 'ذخیره و اعمال روی تابلو'"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- مودال پیش‌نمایش زنده پوسته تابلو --}}
    <div x-show="previewModal.open"
         x-cloak
         @keydown.window.escape="closeThemePreview()"
         class="fixed inset-0 z-[80] flex items-center justify-center p-3 sm:p-6 bg-slate-950/80 backdrop-blur-sm"
         role="dialog"
         aria-modal="true"
         aria-label="پیش‌نمایش زنده پوسته تابلوی تلویزیون">
        <div @click.away="closeThemePreview()"
             class="w-full max-w-5xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-3xl shadow-2xl overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">
                        پیش‌نمایش زنده پوسته: <span class="text-amber-700 dark:text-amber-400" x-text="previewModal.themeName"></span>
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">نمای واقعی تابلو با نرخ‌ها و محصولات فعلی گالری شما (بدون تغییر تا زمان ذخیره)</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="applyPreviewTheme()"
                            class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition-colors cursor-pointer">
                        انتخاب این پوسته
                    </button>
                    <button type="button" @click="closeThemePreview()"
                            aria-label="بستن پیش‌نمایش"
                            class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center transition-colors cursor-pointer">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
            </div>

            <div class="p-3 sm:p-5 bg-slate-950 flex-1">
                <div x-ref="previewStage" dir="ltr" class="relative w-full aspect-video rounded-2xl overflow-hidden border border-slate-800 bg-black">
                    <div x-show="previewModal.loading"
                         class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-2 bg-slate-950 text-slate-300 text-xs font-bold">
                        <div class="w-8 h-8 border-2 border-amber-500 border-t-transparent rounded-full animate-spin"></div>
                        <span>در حال بارگذاری پیش‌نمایش زنده...</span>
                    </div>
                    <template x-if="previewModal.open">
                        <iframe :src="previewModal.url"
                                @load="previewModal.loading = false"
                                title="پیش‌نمایش زنده تابلو"
                                class="border-0 bg-black"
                                :style="`position:absolute; top:0; left:0; width:1280px; height:720px; transform-origin:top left; transform:scale(${previewModal.scale}); pointer-events:none;`"></iframe>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/sortable.min.js') }}"></script>
<script>
function displayControlPage() {
    return {
        settings: { theme_mode: 'light-modern', slider_interval_sec: 8, show_weight: true, show_labor: true, show_profit: true, show_weather: true, show_weather_bg: true, shop_name: '', phone: '', instagram: '', rubika: '', qr_link: '', qr_label: '', qr_desc: '', published_at: null },
        items: [],
        message: { text: '', type: '' },
        isSaving: false,
        initialSnapshot: '',
        initialSettings: null,
        initialItems: [],
        sortableInstance: null,
        previewObserver: null,
        previewModal: {
            open: false,
            loading: false,
            themeId: 'light-modern',
            themeName: '',
            url: '',
            scale: 0.65
        },

        THEME_OPTIONS: [
            { id: 'dark-glass', name: 'تاریک شیشه‌ای', desc: 'پس‌زمینه تیره با افکت بلور', preview: 'bg-slate-900 border-slate-700', dot: 'bg-blue-500' },
            { id: 'light-modern', name: 'روشن مدرن', desc: 'سفید و پاکیزه با کنتراست بالا', preview: 'bg-white border-slate-200', dot: 'bg-blue-600' },
            { id: 'gold-royal', name: 'طلایی سلطنتی', desc: 'پس‌زمینه قهوه‌ای با رنگ طلایی', preview: 'bg-amber-950 border-amber-800', dot: 'bg-amber-400' },
            { id: 'blue-ocean', name: 'آبی اقیانوسی', desc: 'آبی تیره، درخشش فیروزه‌ای', preview: 'bg-indigo-950 border-blue-800', dot: 'bg-cyan-400' },
            { id: 'purple-haze', name: 'بنفش مه‌آلود', desc: 'بنفش تیره با تأثیر رمزآلود', preview: 'bg-purple-950 border-purple-800', dot: 'bg-violet-400' },
            { id: 'emerald-night', name: 'سبز شب', desc: 'سبز تیره، حس فناوری', preview: 'bg-emerald-950 border-emerald-800', dot: 'bg-emerald-400' },
            { id: 'rose-dark', name: 'رز تیره', desc: 'قرمز تیره، زیبایی خاص', preview: 'bg-rose-950 border-rose-900', dot: 'bg-rose-400' },
            { id: 'imperial-onyx', name: 'اونیکس شاهنشاهی ۲۴ عیار (تاریک VIP)', desc: 'شیشه کریستال تیره اپل، لبه‌های طلای ۲۴ عیار، کپسول‌های نئومورفیک و گوی‌های شناور', preview: 'bg-gradient-to-br from-slate-950 via-zinc-950 to-amber-950 border-amber-400 shadow-md', dot: 'bg-amber-400' },
            { id: 'imperial-pearl', name: 'مروارید و طلای شاهنشاهی (روشن VIP)', desc: 'شیشه کریستال شفاف، سرامیک عاجی لوکس، کپسول‌های نئومورفیک برجسته و گوی‌های درخشان', preview: 'bg-gradient-to-br from-slate-50 via-amber-50/70 to-slate-100 border-amber-400 shadow-md', dot: 'bg-amber-500' },
            { id: 'pure-black', name: 'خالص مشکی', desc: 'پس‌زمینه کاملا مشکی و مینیمال', preview: 'bg-black border-slate-800', dot: 'bg-zinc-400' },
            { id: 'bing-daily', name: 'عکس بینگ: شیشه ابسیدین (پیشنهادی)', desc: 'شیشه دودی تیتانیوم اپل با لبه طلایی ۲۴ عیار', preview: 'bg-gradient-to-br from-slate-950 via-slate-900 to-amber-950 border-amber-500/50', dot: 'bg-amber-400' },
            { id: 'bing-studio', name: 'عکس بینگ: استودیو شیشه‌ای', desc: 'استیج یکپارچه مات اپل با وقار و خوانایی بالا', preview: 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 border-indigo-500/40', dot: 'bg-indigo-400' },
            { id: 'bing-ceramic', name: 'عکس بینگ: پرسلین سفید', desc: 'سرامیک سفید براق اپل، بدون شلوغی پس‌زمینه', preview: 'bg-gradient-to-br from-white via-slate-100 to-slate-200 border-slate-300', dot: 'bg-slate-700' },
        ],

        init(settingsData, itemsData) {
            if (settingsData) this.settings = { ...this.settings, ...settingsData };
            if (itemsData) this.items = [...itemsData].sort((a, b) => a.order - b.order);
            this.normalizeItemOrder();
            this.captureBaseline();
            this.$nextTick(() => {
                this.initSortable();
                this.initPreviewResizeObserver();
            });
        },

        get currentThemeName() {
            const match = this.THEME_OPTIONS.find(t => t.id === this.settings.theme_mode);
            return match ? match.name : 'روشن مدرن';
        },

        buildStateSignature() {
            return JSON.stringify({
                theme_mode: this.settings.theme_mode,
                slider_interval_sec: Number(this.settings.slider_interval_sec || 8),
                show_weather: Boolean(this.settings.show_weather ?? true),
                show_weather_bg: Boolean(this.settings.show_weather_bg ?? true),
                items: this.items.map(i => ({
                    key: i.key,
                    enabled: Boolean(i.enabled),
                    order: Number(i.order)
                }))
            });
        },

        captureBaseline() {
            this.initialSettings = JSON.parse(JSON.stringify(this.settings));
            this.initialItems = JSON.parse(JSON.stringify(this.items));
            this.initialSnapshot = this.buildStateSignature();
        },

        get isDirty() {
            if (!this.initialSnapshot) return false;
            return this.buildStateSignature() !== this.initialSnapshot;
        },

        resetChanges() {
            if (this.initialSettings) this.settings = JSON.parse(JSON.stringify(this.initialSettings));
            if (this.initialItems) this.items = JSON.parse(JSON.stringify(this.initialItems));
            this.showMessage('تغییرات ذخیره نشده بازگردانی شد.', 'success');
        },

        normalizeItemOrder() {
            this.items.forEach((item, idx) => {
                item.order = idx + 1;
            });
        },

        moveItem(index, delta) {
            const targetIndex = index + delta;
            if (targetIndex < 0 || targetIndex >= this.items.length) return;
            const list = [...this.items];
            const [moved] = list.splice(index, 1);
            list.splice(targetIndex, 0, moved);
            this.items = list;
            this.normalizeItemOrder();
        },

        initSortable() {
            const listEl = document.getElementById('display-items-sortable');
            if (!listEl || typeof Sortable === 'undefined') return;
            if (this.sortableInstance) {
                try { this.sortableInstance.destroy(); } catch (e) {}
            }
            this.sortableInstance = new Sortable(listEl, {
                handle: '.tile-drag-handle',
                draggable: '[data-item-key]',
                animation: 180,
                ghostClass: 'opacity-40',
                onEnd: (evt) => {
                    if (evt.oldIndex == null || evt.newIndex == null || evt.oldIndex === evt.newIndex) return;
                    // برگرداندن جابجایی موقت DOM تا آرایه Alpine تداخل کلید پیدا نکند
                    const parent = evt.from;
                    const itemsOnly = Array.from(parent.children).filter(el => el.hasAttribute && el.hasAttribute('data-item-key'));
                    const refNode = itemsOnly[evt.oldIndex > evt.newIndex ? evt.oldIndex + 1 : evt.oldIndex] || null;
                    parent.insertBefore(evt.item, refNode);

                    const list = [...this.items];
                    const [moved] = list.splice(evt.oldIndex, 1);
                    list.splice(evt.newIndex, 0, moved);
                    this.items = list;
                    this.normalizeItemOrder();
                }
            });
        },

        initPreviewResizeObserver() {
            const updateScale = () => {
                if (!this.$refs.previewStage) return;
                const width = this.$refs.previewStage.clientWidth || 640;
                this.previewModal.scale = Math.min(width / 1280, 1);
            };
            if (typeof ResizeObserver !== 'undefined') {
                this.previewObserver = new ResizeObserver(updateScale);
                if (this.$refs.previewStage) this.previewObserver.observe(this.$refs.previewStage);
            }
            window.addEventListener('resize', updateScale);
        },

        openThemePreview(themeId, themeName) {
            const chosenTheme = themeId || 'light-modern';
            this.previewModal.themeId = chosenTheme;
            this.previewModal.themeName = themeName || this.currentThemeName;
            this.previewModal.loading = true;
            this.previewModal.url = @js(url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token)) + '&preview_theme=' + encodeURIComponent(chosenTheme);
            this.previewModal.open = true;
            this.$nextTick(() => {
                requestAnimationFrame(() => {
                    if (this.$refs.previewStage && this.$refs.previewStage.clientWidth > 0) {
                        this.previewModal.scale = Math.min(this.$refs.previewStage.clientWidth / 1280, 1);
                    }
                });
            });
        },

        closeThemePreview() {
            this.previewModal.open = false;
            this.previewModal.url = '';
        },

        applyPreviewTheme() {
            this.settings.theme_mode = this.previewModal.themeId;
            this.closeThemePreview();
            if (window.showAdminToast) {
                window.showAdminToast('پوسته انتخاب شد؛ برای اعمال روی تلویزیون دکمه ذخیره را بزنید.', 'info');
            }
        },

        showMessage(text, type = 'success') {
            this.message = { text, type };
            if (window.showAdminToast) {
                window.showAdminToast(text, type === 'success' ? 'success' : 'error');
            }
            setTimeout(() => this.message = { text: '', type: '' }, 3500);
        },

        async saveAndApply() {
            this.isSaving = true;
            this.normalizeItemOrder();
            try {
                const [settingsRes, itemsRes] = await Promise.all([
                    fetch('/admin/display-settings', {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify(this.settings)
                    }),
                    fetch('/admin/display-items', {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ items: this.items })
                    })
                ]);

                if (!settingsRes.ok) {
                    const err = await settingsRes.json().catch(() => ({}));
                    throw new Error(err.message || 'خطا در ذخیره تنظیمات پوسته');
                }
                if (!itemsRes.ok) {
                    const err = await itemsRes.json().catch(() => ({}));
                    throw new Error(err.message || 'خطا در ذخیره چیدمان کاشی‌ها');
                }

                const publishRes = await fetch('/admin/publish', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                if (!publishRes.ok) {
                    const err = await publishRes.json().catch(() => ({}));
                    throw new Error(err.message || 'خطا در ارسال فرمان انتشار به تابلو');
                }

                const savedSettings = await settingsRes.json();
                const savedItems = await itemsRes.json();
                const publishData = await publishRes.json();

                this.settings = { ...this.settings, ...savedSettings, published_at: publishData.published_at || savedSettings.published_at };
                this.items = [...savedItems].sort((a, b) => a.order - b.order);
                this.normalizeItemOrder();
                this.captureBaseline();
                this.showMessage('تنظیمات با موفقیت ذخیره شد و روی تابلوی مغازه اعمال گردید.', 'success');
            } catch (e) {
                this.showMessage(e.message || 'خطا در ذخیره و اعمال تنظیمات', 'error');
            } finally {
                this.isSaving = false;
            }
        }
    };
}
</script>
@endpush
