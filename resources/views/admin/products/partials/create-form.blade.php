<div x-data="{
    open: false,
    errors: {},
    form: {
        title: '',
        weight_gram: '',
        profit_value: '',
        profit_type: 'percent',
        base_gold_price: {{ $latestGoldPrice }}
    },
    imageUrl: '',
    imageFile: null,
    previewUrl: null,
    isCompressing: false,
    isCreating: false,
    get finalPrice() {
        const base = (this.form.base_gold_price * this.form.weight_gram);
        const profit = this.form.profit_type === 'percent' ? (base * (this.form.profit_value / 100)) : Number(this.form.profit_value);
        return Math.round(base + profit);
    }
}">
    <template x-if="products && products.length >= 10">
        <div class="flex items-center gap-2 bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800 px-4 py-2.5 rounded-xl text-xs font-bold shadow-sm">
            <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0 text-rose-500"></i>
            <span>سقف ۱۰ اسلایدر تکمیل شده است</span>
        </div>
    </template>

    <template x-if="!products || products.length < 10">
        <button @click="open = true" x-show="!open" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-all shadow-lg shadow-blue-500/20">
            <i data-lucide="plus" class="w-5 h-5"></i>
            افزودن محصول جدید به ویترین
        </button>
    </template>

    <div x-show="open" x-cloak x-transition class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xl mt-4">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                اطلاعات محصول جدید
            </h3>
            <button @click="open = false" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-400 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">نام محصول</label>
                <input type="text" x-model="form.title" :class="errors.title ? 'border-red-500 ring-red-500' : 'border-slate-200 dark:border-slate-700'" class="w-full bg-slate-50 dark:bg-slate-800 border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="مثال: مدال تراش خورده ۱۸ عیار">
                <template x-if="errors.title"><span class="text-red-500 text-xs mt-1" x-text="errors.title[0]"></span></template>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">وزن (گرم)</label>
                <input type="number" step="0.001" x-model="form.weight_gram" :class="errors.weight_gram ? 'border-red-500 ring-red-500' : 'border-slate-200 dark:border-slate-700'" class="w-full bg-slate-50 dark:bg-slate-800 border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="وارد کردن وزن الزامی است">
                <template x-if="errors.weight_gram"><span class="text-red-500 text-xs mt-1" x-text="errors.weight_gram[0]"></span></template>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">نوع سود و اجرت</label>
                <select x-model="form.profit_type" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    <option value="percent">درصد سود و اجرت (%)</option>
                    <option value="amount">مبلغ ثابت سود و اجرت (تومان)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">مقدار سود و اجرت</label>
                <input type="number" x-model="form.profit_value" :class="errors.profit_value ? 'border-red-500 ring-red-500' : 'border-slate-200 dark:border-slate-700'" class="w-full bg-slate-50 dark:bg-slate-800 border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="وارد کردن سود الزامی است">
                <template x-if="errors.profit_value"><span class="text-red-500 text-xs mt-1" x-text="errors.profit_value[0]"></span></template>
            </div>

            <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 rounded-2xl p-4 flex flex-col justify-center">
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-bold mb-1">قیمت نهایی (محاسبه بر اساس نرخ بازار)</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-blue-700 dark:text-blue-300" x-text="new Intl.NumberFormat('fa-IR').format(finalPrice)"></span>
                        <span class="text-xs text-blue-600/70">تومان</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">
                        تصویر محصول
                        <span class="text-xs font-normal text-emerald-600 dark:text-emerald-400 font-semibold mr-1">(کاهش حجم خودکار بدون افت کیفیت)</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <label class="flex-1 flex items-center justify-center gap-2 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-4 hover:border-blue-500 transition-all cursor-pointer bg-slate-50 dark:bg-slate-800 relative overflow-hidden min-h-[58px]">
                            <template x-if="isCompressing">
                                <div class="flex items-center gap-2 text-xs text-blue-600 dark:text-blue-400 font-bold">
                                    <span class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></span>
                                    <span>در حال کاهش حجم تصویر...</span>
                                </div>
                            </template>
                            <template x-if="!isCompressing && !previewUrl">
                                <div class="flex items-center gap-2 text-slate-500 text-xs font-medium">
                                    <i data-lucide="image-plus" class="w-4 h-4"></i>
                                    <span>انتخاب از گالری یا دوربین</span>
                                </div>
                            </template>
                            <template x-if="!isCompressing && previewUrl">
                                <div class="flex items-center gap-3 w-full">
                                    <img :src="previewUrl" class="w-10 h-10 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shrink-0">
                                    <div class="flex-1 min-w-0 text-right">
                                        <div class="text-xs font-bold text-slate-700 dark:text-slate-200 truncate" x-text="imageFile ? imageFile.name : ''"></div>
                                        <div class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold">بهینه‌سازی شده برای وب</div>
                                    </div>
                                    <button type="button" @click.stop.prevent="imageFile = null; previewUrl = null; if ($refs.createFileInput) $refs.createFileInput.value = ''; $nextTick(() => lucide.createIcons());" class="p-1.5 rounded-lg hover:bg-rose-100 dark:hover:bg-rose-900/30 text-rose-500 transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </template>
                            <input type="file" accept="image/*" class="hidden" x-ref="createFileInput" @change="async (e) => {
                                const file = e.target.files[0];
                                if (!file) return;
                                isCompressing = true;
                                try {
                                    const compressed = await window.compressImage(file, 1600, 0.85);
                                    imageFile = compressed;
                                    previewUrl = URL.createObjectURL(compressed);
                                } catch(err) {
                                    imageFile = file;
                                    previewUrl = URL.createObjectURL(file);
                                } finally {
                                    isCompressing = false;
                                    $nextTick(() => lucide.createIcons());
                                }
                            }">
                        </label>
                        <div class="text-slate-300 text-sm">یا</div>
                        <input type="text" x-model="imageUrl" placeholder="لینک مستقیم تصویر (URL)" class="flex-1 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <template x-if="errors.image_file"><span class="text-red-500 text-xs mt-1" x-text="errors.image_file[0]"></span></template>
                </div>
            </div>
        </div>

        <div class="flex gap-3 mt-8">
            <button @click="async () => {
                errors = {};
                isCreating = true;
                const fd = new FormData();
                for (let k in form) fd.append(k, form[k]);
                if (imageUrl) fd.append('image_url', imageUrl);
                if (imageFile) fd.append('image_file', imageFile);
                try {
                    const res = await fetch('/admin/products', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                        body: fd
                    });
                    const result = await res.json();
                    if (!res.ok) {
                        if (res.status === 422) {
                            errors = result.errors || {};
                            if (result.message) alert(result.message);
                        } else {
                            alert('خطایی در سیستم رخ داده است');
                        }
                        return;
                    }
                    $dispatch('product-created', result);
                    form = { title: '', weight_gram: '', profit_value: '', profit_type: 'percent', base_gold_price: {{ $latestGoldPrice }} };
                    imageUrl = ''; imageFile = null; previewUrl = null; open = false;
                    if ($refs.createFileInput) $refs.createFileInput.value = '';
                } catch(e) { alert('خطا در ارتباط با سرور'); }
                finally { isCreating = false; }
            }" :disabled="isCreating || isCompressing" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-4 font-bold transition-all disabled:opacity-50 flex items-center justify-center gap-2 shadow-lg shadow-blue-500/25">
                <i x-show="!isCreating" data-lucide="check-circle" class="w-5 h-5"></i>
                <span x-text="isCreating ? 'در حال ثبت اطلاعات...' : 'تایید و افزودن به ویترین'"></span>
            </button>
            <button @click="open = false; imageFile = null; previewUrl = null; if ($refs.createFileInput) $refs.createFileInput.value = '';" class="px-8 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl py-4 font-bold hover:bg-slate-200 transition-all">انصراف</button>
        </div>
    </div>
</div>
