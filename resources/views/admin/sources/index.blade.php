@extends('admin.layouts.app')

@section('title', 'منابع دریافت API')

@section('content')
<div x-data="sourcesManager()" x-init="init()" class="space-y-6 max-w-5xl mx-auto" x-cloak>

    {{-- Toast Notification --}}
    <div class="fixed top-6 left-6 z-50 space-y-3 max-w-sm w-full pointer-events-none">
        <template x-if="message.text">
            <div x-show="message.text" 
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                 x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 :class="message.type === 'success' 
                     ? 'bg-emerald-500 text-white shadow-emerald-500/20' 
                     : 'bg-rose-500 text-white shadow-rose-500/20'"
                 class="pointer-events-auto flex items-center gap-3 px-5 py-4 rounded-2xl shadow-2xl border border-white/10 backdrop-blur-xl">
                <div class="p-1 bg-white/20 rounded-lg">
                    <template x-if="message.type === 'success'">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    </template>
                    <template x-if="message.type !== 'success'">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    </template>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold" x-text="message.text"></p>
                </div>
            </div>
        </template>
    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-3xl p-6 shadow-sm gap-4 transition-all duration-300 hover:shadow-md">
        <div class="flex items-center gap-4">
            <div class="p-3.5 bg-indigo-500/10 text-indigo-500 dark:text-indigo-400 rounded-2xl relative overflow-hidden group">
                <div class="absolute inset-0 bg-indigo-500/20 scale-0 group-hover:scale-100 transition-transform duration-500 rounded-2xl"></div>
                <svg class="w-7 h-7 relative z-10 animate-pulse text-indigo-600 dark:text-indigo-450" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.3 12h5.4M9.3 15.6h5.4M9.3 8.4h5.4M3 6.6A1.6 1.6 0 014.6 5h14.8A1.6 1.6 0 0121 6.6v10.8a1.6 1.6 0 01-1.6 1.6H4.6A1.6 1.6 0 013 17.4V6.6z"/></svg>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight">منابع و ارتباط API</h2>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 font-semibold">پیکربندی و نظارت زنده بر اتصال به ارائه‌دهندگان نرخ ارز و طلا</p>
            </div>
        </div>
        <button @click="loadData()" :disabled="isRefreshing"
                class="inline-flex items-center justify-center gap-2 bg-slate-50 dark:bg-slate-800/40 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 px-5 py-3 rounded-2xl text-xs font-black transition-all border border-slate-200 dark:border-slate-700/60 disabled:opacity-50 shadow-sm cursor-pointer shrink-0">
            <svg :class="isRefreshing ? 'animate-spin' : ''" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
            <span>بروزرسانی وضعیت</span>
        </button>
    </div>

    {{-- Stats Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        {{-- Card 1: Requests today --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-500 via-indigo-600 to-indigo-700 rounded-3xl p-6 text-white shadow-lg shadow-indigo-500/10 group">
            <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:scale-110 transition-transform duration-700">
                <svg class="w-36 h-36" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
            </div>
            <div class="relative z-10 flex flex-col justify-between h-full min-h-[90px]">
                <div class="flex justify-between items-start">
                    <span class="text-xs font-black uppercase tracking-wider text-indigo-100/80">مصرف API امروز</span>
                    <span class="px-2 py-0.5 rounded-full bg-white/20 text-[9px] font-black uppercase tracking-wider text-white" x-text="apiCalls.date || 'امروز'"></span>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-4xl font-black tabular-nums tracking-tight" x-text="apiCalls.count"></span>
                    <span class="text-xs font-bold opacity-80">درخواست</span>
                </div>
            </div>
        </div>

        {{-- Card 2: Active Connections --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm group border-slate-200 dark:border-slate-800">
            <div class="absolute -right-6 -bottom-6 text-slate-100 dark:text-slate-800/30 opacity-60 group-hover:scale-110 transition-transform duration-700">
                <svg class="w-36 h-36 animate-[pulse_3s_infinite]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            </div>
            <div class="relative z-10 flex flex-col justify-between h-full min-h-[90px]">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-slate-500">ارتباطات فعال</span>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-4xl font-black text-slate-800 dark:text-slate-100 tabular-nums tracking-tight" x-text="activeCount"></span>
                    <span class="text-xs font-bold text-slate-400 dark:text-slate-500" x-text="'منبع فعال از ' + visibleSources.length"></span>
                </div>
            </div>
        </div>

        {{-- Card 3: Avg Latency --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm group border-slate-200 dark:border-slate-800">
            <div class="absolute -right-6 -bottom-6 text-slate-100 dark:text-slate-800/30 opacity-60 group-hover:scale-110 transition-transform duration-700">
                <svg class="w-36 h-36" fill="currentColor" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 2 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
            </div>
            <div class="relative z-10 flex flex-col justify-between h-full min-h-[90px]">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-slate-500">میانگین تأخیر (Ping)</span>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-4xl font-black text-slate-800 dark:text-slate-100 tabular-nums tracking-tight" x-text="averageLatency"></span>
                    <span class="text-xs font-bold text-slate-400 dark:text-slate-500">میلی‌ثانیه</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Sources Cards Grid --}}
    <div class="space-y-6">
        <template x-for="source in visibleSources" :key="source.key">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/70 rounded-[2rem] shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md hover:border-slate-300 dark:hover:border-slate-700">
                
                {{-- Card Header --}}
                <div class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-slate-200/80 dark:border-slate-800/80 px-6 py-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div :class="source.is_active ? 'bg-blue-500/10 text-blue-600 dark:text-blue-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-400'" 
                             class="p-2.5 rounded-2xl transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 dark:text-slate-100 text-lg tracking-tight" x-text="source.label"></h3>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5 mt-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="relative flex h-2 w-2">
                                        <span :class="source.last_status === 'ok' ? 'bg-emerald-400' : 'bg-rose-400'" class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75"></span>
                                        <span :class="source.last_status === 'ok' ? 'bg-emerald-500' : 'bg-rose-500'" class="relative inline-flex rounded-full h-2 w-2"></span>
                                    </span>
                                    <span class="text-xs font-bold" :class="source.last_status === 'ok' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'" 
                                          x-text="source.last_status === 'ok' ? 'ارتباط برقرار (OK)' : 'خطا در ارتباط'"></span>
                                </div>
                                <span class="text-[10px] text-slate-300 dark:text-slate-700">|</span>
                                <span class="text-xs font-bold text-slate-400 dark:text-slate-500" x-text="'پینگ: ' + (source.last_latency_ms || '---') + 'ms'"></span>
                                <span class="text-[10px] text-slate-300 dark:text-slate-700">|</span>
                                <span class="text-xs font-semibold text-slate-400 dark:text-slate-500" x-text="source.key === 'bale_backup' ? 'بروزرسانی: پشتیبان اضطراری (در صورت قطعی درگاه اصلی)' : 'بروزرسانی: هر ' + source.interval_seconds + ' ثانیه'"></span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Toggle Switch --}}
                    <div class="flex items-center gap-3 bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-slate-800 px-4 py-2.5 rounded-2xl shadow-sm shrink-0">
                        <span class="font-bold text-xs text-slate-600 dark:text-slate-400">دریافت خودکار فعال باشد؟</span>
                        <button type="button" 
                                dir="ltr"
                                @click="toggleActive(source)"
                                :class="source.is_active ? 'bg-blue-600' : 'bg-slate-200 dark:bg-slate-700'"
                                class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                            <span :class="source.is_active ? 'translate-x-5' : 'translate-x-0'"
                                  class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-6 space-y-5" x-show="source.is_active" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1.5">آدرس اصلی API (URL)</label>
                                <input type="text" dir="ltr" :value="source.base_url"
                                       @input="updateField(source.key, 'base_url', $event.target.value)"
                                       class="w-full bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/45 dark:focus:ring-blue-500/20 text-left font-mono text-slate-700 dark:text-slate-300">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1.5">بروزرسانی (ثانیه)</label>
                                    <input type="number" min="10" dir="ltr" :value="source.interval_seconds"
                                           @input="updateField(source.key, 'interval_seconds', Number($event.target.value))"
                                           class="w-full bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/45 dark:focus:ring-blue-500/20 text-left font-mono text-slate-700 dark:text-slate-300 tabular-nums">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1.5">توکن امنیتی / کلید API</label>
                                    <input type="text" dir="ltr" :value="source.auth_token"
                                           @input="updateField(source.key, 'auth_token', $event.target.value)"
                                           class="w-full bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/45 dark:focus:ring-blue-500/20 text-left font-mono text-slate-700 dark:text-slate-300">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1.5 flex justify-between">
                                <span>آدرس‌های رزرو و پشتیبان (Fallback URLs)</span>
                                <span class="text-[10px] font-normal text-slate-400">هر خط یک لینک</span>
                            </label>
                            <textarea dir="ltr" :value="(Array.isArray(source.fallback_urls) ? source.fallback_urls : (typeof source.fallback_urls === 'string' && source.fallback_urls.startsWith('[') ? JSON.parse(source.fallback_urls) : [])).join('\n')"
                                      @input="updateField(source.key, 'fallback_urls', $event.target.value.split(/\r?\n/))"
                                      class="flex-1 w-full bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/45 dark:focus:ring-blue-500/20 resize-none h-[125px] font-mono text-slate-700 dark:text-slate-300 leading-relaxed"></textarea>
                        </div>
                    </div>

                    {{-- Activity logs history (last 3 logs) --}}
                    <div class="mt-4 space-y-2">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1.5">گزارش فعالیت اخیر (۳ مورد آخر)</label>
                        <div class="border border-slate-100 dark:border-slate-800/80 rounded-2xl overflow-hidden bg-slate-50/20 dark:bg-slate-950/20">
                            <template x-if="!source.last_logs || source.last_logs.length === 0">
                                <div class="p-4 text-center text-xs text-slate-400 dark:text-slate-500">هنوز گزارشی ثبت نشده است.</div>
                            </template>
                            <template x-if="source.last_logs && source.last_logs.length > 0">
                                <div class="divide-y divide-slate-100 dark:divide-slate-800/60">
                                    <template x-for="log in source.last_logs">
                                        <div class="flex items-center justify-between p-3 text-xs gap-3">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <span :class="log.status === 'ok' ? 'bg-emerald-500' : 'bg-rose-500'" class="w-2.5 h-2.5 rounded-full shrink-0 animate-pulse"></span>
                                                <span class="font-medium text-slate-700 dark:text-slate-300 truncate" x-text="log.message"></span>
                                            </div>
                                            <span class="font-mono text-slate-400 dark:text-slate-500 shrink-0 text-[10px]" x-text="log.time"></span>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-slate-100 dark:border-slate-800/80">
                        <button @click="saveSource(source)" :disabled="isSaving"
                                class="flex flex-1 items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl py-3 font-bold text-sm transition-colors shadow-sm disabled:opacity-50 cursor-pointer">
                            <svg x-show="!isSaving" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 12m0 0l-4.5 4.5M12 12V3.75m9 13.5H3"/></svg>
                            <span x-text="isSaving ? 'در حال ذخیره...' : 'ذخیره تنظیمات منبع'"></span>
                        </button>
                        <button @click="testSource(source.key)" :disabled="isTesting"
                                class="flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-2xl py-3 px-6 font-bold text-sm transition-all border border-slate-200 dark:border-slate-700/60 disabled:opacity-50 cursor-pointer">
                            <svg :class="isTesting ? 'animate-spin' : ''" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                            <span>تست ارتباط با سرور</span>
                        </button>
                    </div>
                </div>

                {{-- Disabled State Notice --}}
                <div class="p-6 text-center bg-slate-50/20 dark:bg-slate-900/40 text-slate-400 dark:text-slate-600 text-sm font-semibold" 
                     x-show="!source.is_active">
                    منبع جهت واکشی غیرفعال است. جهت ویرایش یا بررسی، آن را روشن کنید.
                </div>
            </div>
        </template>
    </div>
</div>
@endsection

@push('scripts')
<script>
function sourcesManager() {
    return {
        sources: [],
        apiCalls: { count: 0, date: '' },
        message: { text: '', type: 'success' },
        isSaving: false,
        isTesting: false,
        isRefreshing: false,

        get visibleSources() {
            return this.sources.filter(s => s.key !== 'exchange_gold' && !s.label.includes('گرم تعویض'));
        },

        get averageLatency() {
            const active = this.sources.filter(s => s.is_active && s.last_latency_ms > 0);
            if (active.length === 0) return 0;
            const sum = active.reduce((acc, s) => acc + s.last_latency_ms, 0);
            return Math.round(sum / active.length);
        },

        get activeCount() {
            return this.sources.filter(s => s.is_active).length;
        },

        async init() {
            await this.loadData();
        },

        async loadData() {
            this.isRefreshing = true;
            try {
                const res = await fetch('/admin/sources', { headers: { 'Accept': 'application/json' } });
                const data = await res.json();
                this.sources = data.sources || [];
                this.apiCalls = data.api_calls || { count: 0, date: '' };
            } catch (e) {
                this.showMessage(e.message, 'error');
            } finally {
                this.isRefreshing = false;
            }
        },

        updateField(key, field, value) {
            this.sources = this.sources.map(s => s.key === key ? { ...s, [field]: value } : s);
        },

        async saveSource(source) {
            this.isSaving = true;
            try {
                const payload = {
                    base_url: source.base_url,
                    interval_seconds: source.interval_seconds,
                    fallback_urls: (Array.isArray(source.fallback_urls) ? source.fallback_urls : (typeof source.fallback_urls === 'string' && source.fallback_urls.startsWith('[') ? JSON.parse(source.fallback_urls) : [])).filter(u => u.trim()),
                    auth_token: source.auth_token || '',
                    is_active: source.is_active,
                };
                const res = await fetch(`/admin/sources/${source.key}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(payload)
                });
                const updated = await res.json();
                this.sources = this.sources.map(s => s.key === updated.key ? updated : s);
                this.showMessage('تنظیمات منبع API ذخیره شد.', 'success');
            } catch (e) {
                this.showMessage(e.message, 'error');
            } finally {
                this.isSaving = false;
            }
        },

        async testSource(key) {
            this.isTesting = true;
            try {
                const res = await fetch(`/admin/sources/${key}/test`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const result = await res.json();
                if (res.ok && result.success) {
                    this.showMessage(`تست اتصال موفقیت‌آمیز بود. پینگ: ${result.latency_ms || 0}ms`, 'success');
                } else {
                    this.showMessage(result.error || result.message || 'خطا در برقراری ارتباط با منبع نرخ', 'error');
                }
                await this.loadData();
            } catch (e) {
                this.showMessage(e.message, 'error');
            } finally {
                this.isTesting = false;
            }
        },

        async toggleActive(source) {
            source.is_active = !source.is_active;
            try {
                const payload = {
                    base_url: source.base_url,
                    interval_seconds: source.interval_seconds,
                    fallback_urls: Array.isArray(source.fallback_urls) ? source.fallback_urls : [],
                    auth_token: source.auth_token || '',
                    is_active: source.is_active,
                };
                const res = await fetch(`/admin/sources/${source.key}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(payload)
                });
                const updated = await res.json();
                this.sources = this.sources.map(s => s.key === updated.key ? updated : s);
                this.showMessage(`دریافت خودکار منبع "${source.label}" ${source.is_active ? 'فعال' : 'غیرفعال'} شد.`, 'success');
            } catch (e) {
                this.showMessage(e.message, 'error');
            }
        },

        showMessage(text, type = 'success') {
            this.message = { text, type };
            setTimeout(() => this.message = { text: '', type: '' }, 4000);
        }
    };
}
</script>
@endpush
