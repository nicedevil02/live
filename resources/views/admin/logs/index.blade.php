@extends('admin.layouts.app')

@section('title', 'گزارشات سیستم')

@section('content')
<div x-data="logsPage(@js($logs))" class="space-y-6">
    {{-- بخش ویژه درخواست‌های تماس و راه‌اندازی رایگان کارشناس --}}
    <template x-if="setupCallRequests.length > 0">
        <div class="bg-amber-50/70 dark:bg-amber-950/20 border border-amber-500/35 rounded-2xl p-5 sm:p-6 shadow-sm space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-xl bg-amber-500/20 text-amber-700 dark:text-amber-300">
                        <i data-lucide="phone-incoming" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-white">درخواست‌های تماس و راه‌اندازی رایگان کارشناس</h2>
                        <p class="text-xs text-slate-600 dark:text-slate-400">این درخواست‌ها هم‌زمان به ربات‌های فعال بله و تلگرام هم ارسال می‌شوند.</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-500/15 text-amber-800 dark:text-amber-300 border border-amber-500/30"
                      x-text="setupCallRequests.length + ' درخواست اخیر'"></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <template x-for="req in setupCallRequests" :key="req.id">
                    <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex items-center justify-between gap-3">
                        <div class="min-w-0 space-y-1">
                            <p class="text-sm font-black text-slate-900 dark:text-white truncate" x-text="req.parsed.shop_name || req.parsed.name || req.actor || 'گالری طلا'"></p>
                            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                <span x-text="req.parsed.city || 'شهر ثبت‌نشده'"></span>
                                <span>·</span>
                                <span x-text="formatDate(req.created_at)"></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <template x-if="req.parsed.phone">
                                <a :href="'tel:' + req.parsed.phone" dir="ltr"
                                   class="min-h-[40px] inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 border border-emerald-500/30 font-mono text-xs font-black hover:bg-emerald-500/25">
                                    <span x-text="req.parsed.phone"></span>
                                </a>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </template>

    {{-- گزارش کامل فعالیت‌ها --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-lg">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">گزارش فعالیت‌ها و اعلان‌ها</h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">آخرین رویدادهای ثبت‌شده در سامانه</p>
                </div>
            </div>
            <button type="button" @click="refreshLogs()" :disabled="loading"
                    class="min-h-[40px] px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer disabled:opacity-50">
                <span x-text="loading ? 'در حال بروزرسانی...' : 'بروزرسانی لیست'"></span>
            </button>
        </div>

        <div>
            <template x-if="enrichedLogs.length > 0">
                <ul class="space-y-2.5 text-sm text-slate-600 dark:text-slate-300">
                    <template x-for="log in enrichedLogs" :key="log.id">
                        <li class="p-3.5 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="space-y-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black"
                                          :class="badgeClass(log.action)"
                                          x-text="actionLabel(log.action)"></span>
                                    <span class="font-bold text-slate-800 dark:text-slate-100 text-xs sm:text-sm" x-text="log.actor"></span>
                                    <template x-if="log.summaryText">
                                        <span class="text-xs text-slate-600 dark:text-slate-300" x-text="log.summaryText"></span>
                                    </template>
                                </div>
                            </div>
                            <span class="font-mono text-[11px] text-slate-500 dark:text-slate-400 shrink-0 tabular-nums"
                                  x-text="formatDate(log.created_at)"></span>
                        </li>
                    </template>
                </ul>
            </template>
            <template x-if="enrichedLogs.length === 0">
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
function logsPage(initialLogs) {
    return {
        logs: Array.isArray(initialLogs) ? initialLogs : [],
        loading: false,
        message: '',

        get enrichedLogs() {
            return this.logs.map((log) => {
                let parsed = {};
                try {
                    parsed = typeof log.payload === 'string' ? JSON.parse(log.payload) : (log.payload || {});
                } catch (e) {
                    parsed = {};
                }
                const parts = [];
                if (parsed.shop_name && parsed.shop_name !== log.actor) parts.push(parsed.shop_name);
                if (parsed.shop && parsed.shop !== log.actor) parts.push(parsed.shop);
                if (parsed.customer || parsed.phone) parts.push(parsed.customer || parsed.phone);
                if (parsed.city) parts.push(parsed.city);
                if (parsed.plan) parts.push(parsed.plan);
                if (parsed.amount) parts.push(parsed.amount + ' تومان');
                if (parsed.note) parts.push(parsed.note);

                return {
                    ...log,
                    parsed,
                    summaryText: parts.join(' · ')
                };
            });
        },

        get setupCallRequests() {
            return this.enrichedLogs.filter(l => l.action === 'request_setup_call');
        },

        actionLabel(action) {
            const labels = {
                request_setup_call: 'درخواست تماس کارشناس',
                admin_setup_call_request: 'ثبت اعلان تماس',
                admin_alert_event: 'ثبت‌نام طلافروشی جدید',
                admin_payment_notification: 'خرید اشتراک جدید',
                payment_success_sms: 'پیامک تایید پرداخت',
                customer_welcome_event: 'خوش‌آمدگویی ثبت‌نام',
                otp_s_api_ir: 'ارسال کد تایید پیامکی',
            };
            return labels[action] || action;
        },

        badgeClass(action) {
            if (action === 'request_setup_call') return 'bg-amber-500/20 text-amber-800 dark:text-amber-300 border border-amber-500/30';
            if (action === 'admin_alert_event' || action === 'admin_payment_notification') return 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 border border-emerald-500/25';
            return 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200';
        },

        formatDate(dt) {
            if (!dt) return '';
            try {
                return new Intl.DateTimeFormat('fa-IR', {
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                }).format(new Date(dt));
            } catch (e) {
                return dt;
            }
        },

        async refreshLogs() {
            this.loading = true;
            try {
                const res = await fetch('/admin/logs', { headers: { 'Accept': 'application/json' } });
                const data = await res.json();
                this.logs = Array.isArray(data) ? data : (data.logs || []);
            } catch (e) {
                this.message = 'خطا در بارگذاری لاگ‌ها';
            } finally {
                this.loading = false;
            }
        }
    };
}
</script>
@endpush
