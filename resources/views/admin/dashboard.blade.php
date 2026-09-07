@extends('admin.layouts.app')

@section('title', 'داشبورد مدیریت')

@section('content')
<div x-data="dashboardPage()" x-init="init()" class="space-y-6">
    {{-- لینک صفحه نمایش اختصاصی طلا --}}
    <div class="bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900/60 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-4">
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
            <button onclick="navigator.clipboard.writeText(document.getElementById('displayUrlInput').value); alert('لینک کپی شد!');"
                    class="bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold px-4 py-2 rounded-xl text-sm whitespace-nowrap transition-colors cursor-pointer">
                کپی لینک
            </button>
            <a href="{{ url('/' . auth()->user()->username . '?key=' . auth()->user()->display_token) }}" target="_blank"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-xl text-sm whitespace-nowrap transition-colors flex items-center gap-1.5 cursor-pointer">
                مشاهده تابلو <i data-lucide="external-link" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    {{-- اتصال تلویزیون با کد فعال‌سازی --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 rounded-xl">
                <i data-lucide="key-round" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">اتصال دستی تلویزیون جدید</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">کد ۶ رقمی درج‌شده در تابلوی تلویزیون را وارد کنید تا فوراً به گالری شما متصل شود.</p>
            </div>
        </div>
        <div class="flex items-center gap-2.5 w-full md:w-auto" x-data="{ pairCode: '', isPairing: false }">
            <input type="text" maxlength="6" x-model="pairCode" placeholder="کد ۶ رقمی (مثال: ABC123)" dir="ltr"
                   class="bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-sm text-slate-850 dark:text-slate-100 w-full md:w-48 text-center font-mono font-bold uppercase placeholder:font-sans placeholder:font-normal focus:outline-none focus:ring-2 focus:ring-amber-500/40">
            <button @click="
                if(!pairCode || pairCode.length < 6) { alert('لطفا کد ۶ رقمی معتبر را وارد کنید.'); return; }
                isPairing = true;
                fetch('{{ route('admin.pair-code') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ activation_code: pairCode })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        alert(data.message);
                        pairCode = '';
                    } else {
                        alert(data.message || 'خطا در اتصال');
                    }
                })
                .catch(err => alert('خطا در برقراری ارتباط با سرور'))
                .finally(() => isPairing = false);
            " :disabled="isPairing"
                    class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-6 py-2 rounded-xl text-sm whitespace-nowrap transition-all hover:scale-[1.01] cursor-pointer disabled:opacity-50 flex items-center gap-1.5">
                <span x-text="isPairing ? 'در حال اتصال...' : 'اتصال دستگاه'"></span>
            </button>
        </div>
    </div>

    {{-- Header Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Status Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">وضعیت کلی سیستم</p>
                    <h3 class="text-lg font-bold mt-1"
                        :class="status.isHealthy ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'"
                        x-text="status.apiStatus"></h3>
                </div>
                <div class="p-3 rounded-full"
                     :class="status.isHealthy ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:text-rose-400'">
                    <i x-show="status.isHealthy" data-lucide="check-circle" class="w-6 h-6"></i>
                    <i x-show="!status.isHealthy" data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-1 text-sm text-slate-600 dark:text-slate-400">
                <span class="flex items-center gap-1.5" x-text="status.isHealthy ? '📡 تمامی سرویس‌ها متصل و پایدار' : '🚨 نیاز به بررسی مجدد منابع یا اتصال'"></span>
            </div>
        </div>

        {{-- Sync Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">آخرین همگام‌سازی تابلو</p>
                    <h3 class="text-3xl font-black mt-1 text-slate-800 dark:text-slate-100 tabular-nums"
                        x-text="isLoading ? '...' : status.updatedAt"></h3>
                </div>
                <button @click="loadData()" class="p-3 rounded-full bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                    <i data-lucide="refresh-cw" :class="isLoading ? 'animate-spin' : ''" class="w-6 h-6"></i>
                </button>
            </div>
            <div class="mt-4 flex flex-col gap-1 text-sm text-slate-600 dark:text-slate-400">
                <span class="flex items-center gap-1.5">💾 رفرش خودکار هر ۳۰ ثانیه</span>
            </div>
        </div>

        {{-- Alert Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">هشدارهای قیمت</p>
                    <h3 class="text-lg font-bold mt-1"
                        :class="status.staleCount > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-slate-800 dark:text-slate-100'"
                        x-text="status.alerts"></h3>
                </div>
                <div class="p-3 rounded-full"
                     :class="status.staleCount > 0 ? 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400'">
                    <i x-show="status.staleCount > 0" data-lucide="alert-circle" class="w-6 h-6"></i>
                    <i x-show="status.staleCount === 0" data-lucide="check-circle-2" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-1 text-sm text-slate-600 dark:text-slate-400">
                <span class="flex items-center gap-1.5">📈 عدم آپدیت ناشی از بسته بودن بازار است</span>
            </div>
        </div>

        {{-- Gold 18k Live Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">قیمت طلای ۱۸ عیار تابلو</p>
                    <h3 class="text-3xl font-black mt-1 text-amber-600 dark:text-amber-400 tabular-nums"
                        x-text="isLoading ? '...' : status.gold18Price"></h3>
                </div>
                <div class="p-3 rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                    <i data-lucide="trending-up" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-1 text-sm text-slate-600 dark:text-slate-400">
                <span class="flex items-center gap-1.5">قیمت پایه برای فرمول‌های خرید و پیش‌نمایش</span>
            </div>
        </div>

        {{-- Gold 18k Formula Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">قیمت محاسبه‌شده طلای ۱۸ عیار جهانی</p>
                    <h3 class="text-3xl font-black mt-1 text-blue-600 dark:text-blue-400 tabular-nums"
                        x-text="isLoading ? '...' : status.formula18Price"></h3>
                </div>
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                    <i data-lucide="calculator" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-1 text-sm text-slate-600 dark:text-slate-400">
                <span class="flex items-center gap-1.5">خروجی مستقیم بخش نحوه محاسبه اونس و دلار</span>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 pt-4">دسترسی سریع</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.formulas') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-blue-300 dark:hover:border-blue-700 hover:shadow-md transition-all">
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="variable" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">مدیریت فرمول‌ها</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-indigo-300 dark:hover:border-indigo-700 hover:shadow-md transition-all">
            <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="gem" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">تصاویر و اسلایدر</span>
        </a>
        <a href="{{ route('admin.display-control') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-emerald-300 dark:hover:border-emerald-700 hover:shadow-md transition-all">
            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="monitor" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">تنظیمات تابلو و پوسته</span>
        </a>
        @if(auth()->user()->is_super_admin)
        <a href="{{ route('admin.sources') }}" class="group flex flex-col items-center justify-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl hover:border-amber-300 dark:hover:border-amber-700 hover:shadow-md transition-all">
            <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="rss" class="w-6 h-6"></i>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">پیکربندی API</span>
        </a>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function dashboardPage() {
    return {
        status: {
            updatedAt: '-',
            apiStatus: 'در حال بررسی...',
            alerts: '0 هشدار فعال',
            staleCount: 0,
            isHealthy: true,
            gold18Price: '-',
            formula18Price: '-'
        },
        isLoading: true,

        async init() {
            await this.loadData();
            setInterval(() => this.loadData(), 30000);
        },

        async loadData() {
            this.isLoading = true;
            try {
                const username = '{{ $username }}';
                const displayToken = '{{ auth()->user()->display_token }}';
                const [snapshotRes, healthRes, previewRes] = await Promise.all([
                    fetch('/api/display/snapshot/' + username + '?key=' + displayToken),
                    fetch('/api/display/health/' + username + '?key=' + displayToken),
                    fetch('/admin/formulas/global-18k-preview', { headers: { 'Accept': 'application/json' } })
                ]);
                const snapshot = await snapshotRes.json();
                const health = await healthRes.json();
                const preview = await previewRes.json();

                const stales = snapshot.priceFeed.filter(item => item.is_stale).length;
                const gold18 = snapshot.priceFeed.find(item => item.symbol === 'gold18')?.value;

                // سیستم سالم است اگر API پاسخ بدهد، حتی اگر برخی قیمت‌ها به دلیل بسته بودن بازار استاتیک باشند
                const isHealthy = health.status === 'ok';

                this.status = {
                    updatedAt: snapshot.updatedAt ? new Date(snapshot.updatedAt).toLocaleTimeString('fa-IR') : '-',
                    apiStatus: isHealthy ? 'تمامی سرویس‌ها متصل و پایدار' : 'اختلال در دریافت قیمت‌ها',
                    alerts: stales > 0 ? `${stales} قیمت استاتیک (بدون آپدیت)` : 'بدون خطای همگام‌سازی',
                    staleCount: stales,
                    isHealthy: isHealthy,
                    gold18Price: gold18 ? new Intl.NumberFormat('fa-IR').format(Math.round(gold18)) + ' تومان' : 'نامشخص',
                    formula18Price: preview.gold18Real ? new Intl.NumberFormat('fa-IR').format(Math.round(preview.gold18Real)) + ' تومان' : 'نامشخص'
                };
            } catch (e) {
                this.status = {
                    updatedAt: '-',
                    apiStatus: 'ارتباط با سرور قطع شده است',
                    alerts: 'لطفا اتصال اینترنت را بررسی کنید',
                    staleCount: 1,
                    isHealthy: false,
                    gold18Price: 'نامشخص',
                    formula18Price: 'نامشخص'
                };
            } finally {
                this.isLoading = false;
            }
        }
    };
}
</script>
@endpush
