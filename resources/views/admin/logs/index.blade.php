@extends('admin.layouts.app')

@section('title', 'گزارشات سیستم')

@section('content')
<div x-data="logsPage()" x-init="init()">
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
        <div class="flex items-center gap-3 mb-1">
            <div class="p-2 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-lg">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">گزارش تغییرات</h2>
        </div>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-5 mr-11">آخرین فعالیت‌های انجام شده در پنل مدیریت</p>

        {{-- لیست لاگ‌ها --}}
        <div>
            <template x-if="logs.length > 0">
                <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                    <template x-for="log in logs" :key="log.id">
                        <li class="p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700 flex items-center gap-3">
                            <i data-lucide="history" class="w-4 h-4 text-slate-400"></i>
                            <div>
                                <span class="font-mono text-xs opacity-70" x-text="new Date(log.created_at).toLocaleTimeString('fa-IR')"></span>
                                <span class="mx-1 text-slate-300">|</span>
                                <span class="font-bold text-slate-700 dark:text-slate-300" x-text="log.action"></span>
                                <span class="mx-0.5">روی</span>
                                <span class="text-blue-600 dark:text-blue-400" x-text="log.entity_type"></span>
                            </div>
                        </li>
                    </template>
                </ul>
            </template>
            <template x-if="logs.length === 0">
                <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                    <i data-lucide="database-zap" class="w-12 h-12 mb-2 opacity-20"></i>
                    <p class="text-sm" x-text="message || 'هنوز لاگی ثبت نشده است.'"></p>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function logsPage() {
    return {
        logs: [],
        message: '',

        async init() {
            try {
                const res = await fetch('/admin/logs', { headers: { 'Accept': 'application/json' } });
                const data = await res.json();
                this.logs = Array.isArray(data) ? data : (data.logs || []);
            } catch (e) {
                this.message = 'خطا در بارگذاری لاگ‌ها';
            }
        }
    };
}
</script>
@endpush
