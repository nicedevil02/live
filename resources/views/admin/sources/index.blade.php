@extends('admin.layouts.app')

@section('title', 'منابع دریافت API')

@section('content')
<div x-data="sourcesManager()" x-init="init()" class="space-y-6 max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl">
                <i data-lucide="rss" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">منابع و ارتباط API</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">مدیریت ارتباط با سرورهای ارائه‌دهنده قیمت</p>
            </div>
        </div>
        <button @click="loadData()" :disabled="isRefreshing"
                class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors disabled:opacity-50">
            <i data-lucide="refresh-cw" :class="isRefreshing ? 'animate-spin' : ''" class="w-4 h-4"></i> بروزرسانی وضعیت
        </button>
    </div>

    {{-- Stats Counter --}}
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold mb-1 opacity-90">میزان مصرف API شما امروز</h3>
            <p class="text-indigo-100 text-sm">این عدد بصورت خودکار هر شب (بامداد) صفر می‌شود.</p>
        </div>
        <div class="flex items-baseline gap-2 bg-black/20 rounded-xl px-5 py-3 backdrop-blur-md">
            <span class="text-4xl font-black tabular-nums" x-text="apiCalls.count"></span>
            <span class="text-sm opacity-80" x-text="'درخواست (' + (apiCalls.date || 'امروز') + ')'"></span>
        </div>
    </div>

    {{-- Message Toast --}}
    <div x-show="message.text" x-transition
         :class="message.type === 'success'
             ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50'
             : 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/50'"
         class="flex items-center gap-2 px-4 py-3 rounded-xl border text-sm font-semibold">
        <i x-show="message.type === 'success'" data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500"></i>
        <i x-show="message.type !== 'success'" data-lucide="alert-triangle" class="w-5 h-5 text-rose-500"></i>
        <span x-text="message.text"></span>
    </div>

    {{-- Source Cards --}}
    <template x-for="source in visibleSources" :key="source.key">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
            {{-- Card Header --}}
            <div class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 px-6 py-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/40 text-blue-600 rounded-lg">
                        <i data-lucide="link" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg" x-text="source.label"></h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-2 h-2 rounded-full" :class="source.last_status === 'ok' ? 'bg-emerald-500' : 'bg-rose-500'"></span>
                            <span class="text-xs text-slate-500" x-text="'آخرین وضعیت: ' + (source.last_status === 'ok' ? 'متصل (OK)' : 'خطا')"></span>
                            <span class="text-xs text-slate-400" x-text="'· پینگ: ' + source.last_latency_ms + 'ms'"></span>
                        </div>
                    </div>
                </div>
                <label class="flex items-center gap-2 cursor-pointer bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-4 py-2 rounded-xl">
                    <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700"
                           :checked="source.is_active"
                           @change="updateField(source.key, 'is_active', $event.target.checked)">
                    <span class="font-bold text-sm text-slate-700 dark:text-slate-300">دریافت فعال باشد؟</span>
                </label>
            </div>

            {{-- Card Body --}}
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">آدرس اصلی API</label>
                            <input type="text" dir="ltr" :value="source.base_url"
                                   @input="updateField(source.key, 'base_url', $event.target.value)"
                                   class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">فاصله زمانی بروزرسانی (ثانیه)</label>
                            <input type="number" min="10" dir="ltr" :value="source.interval_seconds"
                                   @input="updateField(source.key, 'interval_seconds', Number($event.target.value))"
                                   class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 tabular-nums">
                            <p class="text-xs text-slate-500 mt-1">زمان کمتر = بروزرسانی سریع‌تر اما مصرف API بیشتر.</p>
                        </div>
                    </div>
                    <div class="space-y-4 h-full flex flex-col">
                        <div class="flex-1">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5 flex justify-between">
                                <span>آدرس‌های رزرو (Fallback)</span>
                                <span class="text-xs font-normal text-slate-400">یک لینک در هر خط وارد کنید</span>
                            </label>
                            <textarea dir="ltr" :value="(source.fallback_urls || []).join('\n')"
                                      @input="updateField(source.key, 'fallback_urls', $event.target.value.split(/\\r?\\n/))"
                                      class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 resize-none h-[115px]"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button @click="saveSource(source)" :disabled="isSaving"
                            class="flex flex-1 items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3 font-bold text-sm transition-colors shadow-sm disabled:opacity-50">
                        <i x-show="!isSaving" data-lucide="save" class="w-5 h-5"></i>
                        <span x-text="isSaving ? 'در حال ذخیره...' : 'ذخیره تنظیمات منبع'"></span>
                    </button>
                    <button @click="testSource(source.key)" :disabled="isTesting"
                            class="flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl py-3 px-6 font-bold text-sm transition-colors border border-slate-200 dark:border-slate-700 disabled:opacity-50">
                        <i data-lucide="zap" :class="isTesting ? 'animate-spin' : ''" class="w-4 h-4"></i> تست ارتباط با سرور
                    </button>
                </div>
            </div>
        </div>
    </template>
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
                    fallback_urls: (source.fallback_urls || []).filter(u => u.trim()),
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
                this.showMessage(`تست اتصال موفقیت‌آمیز بود. پینگ: ${result.latency_ms}ms`, 'success');
                await this.loadData();
            } catch (e) {
                this.showMessage(e.message, 'error');
            } finally {
                this.isTesting = false;
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
