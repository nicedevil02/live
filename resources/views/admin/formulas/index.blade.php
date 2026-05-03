@extends('admin.layouts.app')

@section('title', 'مدیریت فرمول‌های قیمت')

@section('content')
<div x-data="formulasPage()" x-init="init()" class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
                <i data-lucide="variable" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">مدیریت فرمول‌های قیمت</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">تنظیم ضرایب محاسبه قیمت خرید طلای ۱۸ عیار</p>
            </div>
        </div>
        <button @click="loadData()" :disabled="isRefreshing"
                class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors disabled:opacity-50">
            <i data-lucide="refresh-cw" :class="isRefreshing ? 'animate-spin' : ''" class="w-4 h-4"></i> بروزرسانی
        </button>
    </div>

    {{-- Feedback Message --}}
    <div x-show="message.text" x-transition
         :class="message.type === 'success' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50' : 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/50'"
         class="flex items-center gap-2 px-4 py-3 rounded-xl border text-sm font-semibold">
        <i x-show="message.type === 'success'" data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500"></i>
        <i x-show="message.type !== 'success'" data-lucide="alert-circle" class="w-5 h-5 text-rose-500"></i>
        <span x-text="message.text"></span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Formula Editor --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mb-1">فرمول قیمت خرید طلا</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-5">
                <span class="font-mono bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-lg text-blue-600 dark:text-blue-400">
                    قیمت خرید = قیمت طلای ۱۸ عیار × A ÷ B
                </span>
            </p>

            <div class="flex items-center gap-4 mb-6">
                {{-- A --}}
                <div class="flex-1">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        ضریب A <span class="text-xs font-normal text-amber-600 dark:text-amber-400">(قابل تغییر)</span>
                    </label>
                    <input type="number" min="1" x-model.number="a"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border-2 border-amber-300 dark:border-amber-600 rounded-xl px-4 py-3 text-xl font-black text-center focus:outline-none focus:ring-2 focus:ring-amber-500/40 transition-shadow text-amber-700 dark:text-amber-400">
                </div>
                <div class="text-2xl font-black text-slate-400 dark:text-slate-500 mt-5">÷</div>
                {{-- B --}}
                <div class="flex-1">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">مقسوم‌علیه B</label>
                    <input type="number" min="1" x-model.number="b"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xl font-black text-center focus:outline-none focus:ring-2 focus:ring-blue-500/40 transition-shadow">
                </div>
            </div>

            {{-- Info box --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 rounded-xl p-4 mb-5">
                <div class="flex items-start gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-blue-500 shrink-0"></i>
                    <div class="text-sm text-blue-700 dark:text-blue-300">
                        <p class="font-semibold mb-1">نحوه عملکرد</p>
                        <p>مقدار A (پیش‌فرض ۷۴۰) ضریب اصلی تعیین قیمت خرید است. مثلاً A=740 یعنی قیمت خرید نسبت به قیمت بازار حدود ۱.۳٪ کمتر است.</p>
                    </div>
                </div>
            </div>

            <button @click="saveFormula()" :disabled="isSaving || a <= 0 || b <= 0"
                    class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3 font-bold text-base transition-colors disabled:opacity-50 shadow-sm shadow-blue-500/20">
                <i x-show="!isSaving" data-lucide="save" class="w-5 h-5"></i>
                <span x-text="isSaving ? 'در حال ذخیره...' : 'ذخیره فرمول'"></span>
            </button>
        </div>

        {{-- Live Preview --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex flex-col">
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mb-4">پیش‌نمایش زنده</h3>

            {{-- Live API price --}}
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-5 mb-4 text-white">
                <p class="text-sm text-slate-400 mb-1">قیمت طلای ۱۸ عیار پایه (دریافتی تابلو)</p>
                <p class="text-3xl font-black tabular-nums text-amber-400">
                    <span x-text="preview ? formatNumber(preview.gold18Tablo) : '---'"></span>
                    <span class="text-base font-normal text-slate-400 mr-2">تومان</span>
                </p>
                <div class="flex flex-col gap-1 mt-2">
                    <p class="text-xs text-slate-500">
                        اونس: <span x-text="preview ? formatNumber(preview.ouncePrice) : '-'"></span> $ · دلار: <span x-text="preview ? formatNumber(preview.usdRate) : '-'"></span> تومان
                    </p>
                </div>
            </div>

            {{-- Buy price with current formula --}}
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 rounded-xl p-5 mb-4">
                <p class="text-sm text-emerald-600 dark:text-emerald-400 mb-1">گرم خرید ۱۸ عیار (محاسباتی)</p>
                <p class="text-3xl font-black tabular-nums text-emerald-700 dark:text-emerald-300">
                    <span x-text="preview ? formatNumber(preview.buyGold) : '---'"></span>
                    <span class="text-base font-normal text-emerald-500 mr-2">تومان</span>
                </p>
                <p class="text-xs text-emerald-600 dark:text-emerald-500 mt-1" x-text="'فرمول: (طلای تابلو × ' + a + ') ÷ ' + b"></p>
            </div>

            <div class="text-xs text-slate-400 dark:text-slate-500 text-center mt-auto">
                این مقادیر با هر بروزرسانی API به‌صورت خودکار در تابلو اعمال می‌شوند
            </div>
        </div>
    </div>

    {{-- Global 18K Calculation Info --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
        <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mb-4">نحوه محاسبه طلای ۱۸ عیار جهانی</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4">
                <p class="text-xs text-slate-500 mb-1">قیمت اونس جهانی (USD)</p>
                <p class="text-2xl font-black text-slate-800 dark:text-white" x-text="preview ? formatNumber(preview.ouncePrice) : '---'"></p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4">
                <p class="text-xs text-slate-500 mb-1">نرخ دلار (تومان)</p>
                <p class="text-2xl font-black text-slate-800 dark:text-white" x-text="preview ? formatNumber(preview.usdRate) : '---'"></p>
            </div>
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/50 rounded-xl p-4">
                <p class="text-xs text-amber-600 mb-1">قیمت واقعی طلای ۱۸ عیار</p>
                <p class="text-2xl font-black text-amber-700 dark:text-amber-400" x-text="preview ? formatNumber(preview.gold18Real) : '---'"></p>
            </div>
        </div>
        <p class="text-xs text-slate-400 mt-4 font-mono text-center">
            (اونس × دلار × 0.75) ÷ 31.1035 = قیمت طلای ۱۸ عیار
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
function formulasPage() {
    return {
        a: 740,
        b: 750,
        preview: null,
        message: { text: '', type: '' },
        isSaving: false,
        isRefreshing: false,

        async init() {
            await this.loadData();
        },

        async loadData() {
            this.isRefreshing = true;
            try {
                const [formulasRes, previewRes] = await Promise.all([
                    fetch('/admin/formulas', { headers: { 'Accept': 'application/json' } }),
                    fetch('/admin/formulas/global-18k-preview', { headers: { 'Accept': 'application/json' } })
                ]);
                const formulas = await formulasRes.json();
                this.a = formulas.buy_multiplier_a;
                this.b = formulas.buy_divisor_b;
                this.preview = await previewRes.json();
            } catch (e) {
                this.showMessage(e.message, 'error');
            } finally {
                this.isRefreshing = false;
            }
        },

        livePreviewPrice() {
            if (this.preview && this.preview.gold18Real) {
                return Math.round((this.preview.gold18Real * this.a) / this.b);
            }
            return Math.round((6940000 * this.a) / this.b);
        },

        async saveFormula() {
            if (this.b <= 0 || this.a <= 0) {
                this.showMessage('A و B باید بزرگتر از صفر باشند.', 'error');
                return;
            }
            this.isSaving = true;
            try {
                await fetch('/admin/formulas/buy', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ buy_multiplier_a: this.a, buy_divisor_b: this.b })
                });
                const previewRes = await fetch('/admin/formulas/global-18k-preview', { headers: { 'Accept': 'application/json' } });
                this.preview = await previewRes.json();
                this.showMessage('فرمول خرید با موفقیت ذخیره شد.', 'success');
            } catch (e) {
                this.showMessage(e.message, 'error');
            } finally {
                this.isSaving = false;
            }
        },

        showMessage(text, type = 'success') {
            this.message = { text, type };
            setTimeout(() => this.message = { text: '', type: '' }, 3500);
        },

        formatNumber(value) {
            return new Intl.NumberFormat('fa-IR').format(Math.round(value));
        }
    };
}
</script>
@endpush
