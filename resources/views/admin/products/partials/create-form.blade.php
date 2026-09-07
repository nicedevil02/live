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
    isCreating: false,
    get finalPrice() {
        const base = (this.form.base_gold_price * this.form.weight_gram);
        const profit = this.form.profit_type === 'percent' ? (base * (this.form.profit_value / 100)) : Number(this.form.profit_value);
        return Math.round(base + profit);
    }
}">
    <button @click="open = true" x-show="!open" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-all shadow-lg shadow-blue-500/20">
        <i data-lucide="plus" class="w-5 h-5"></i>
        افزودن محصول جدید به ویترین
    </button>

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
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">تصویر محصول <span class="text-xs font-normal text-slate-400">(حداکثر ۲ مگابایت)</span></label>
                    <div class="flex items-center gap-3">
                        <label class="flex-1 flex flex-col items-center justify-center border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-4 hover:border-blue-500 transition-colors cursor-pointer bg-slate-50 dark:bg-slate-800">
                            <span class="text-xs text-slate-500" x-text="imageFile ? imageFile.name : 'انتخاب فایل تصویر...'"></span>
                            <input type="file" class="hidden" x-ref="createFileInput" @change="
                                const file = $event.target.files[0];
                                if (file && file.size > 2 * 1024 * 1024) {
                                    alert('حداکثر حجم مجاز برای تصویر ۲ مگابایت می‌باشد.');
                                    $event.target.value = '';
                                    imageFile = null;
                                } else {
                                    imageFile = file;
                                }
                            ">
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
                            errors = result.errors;
                        } else {
                            alert('خطایی در سیستم رخ داده است');
                        }
                        return;
                    }
                    $dispatch('product-created', result);
                    form = { title: '', weight_gram: '', profit_value: '', profit_type: 'percent', base_gold_price: {{ $latestGoldPrice }} };
                    imageUrl = ''; imageFile = null; open = false;
                    if ($refs.createFileInput) $refs.createFileInput.value = '';
                } catch(e) { alert('خطا در ارتباط با سرور'); }
                finally { isCreating = false; }
            }" :disabled="isCreating" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-4 font-bold transition-all disabled:opacity-50 flex items-center justify-center gap-2 shadow-lg shadow-blue-500/25">
                <i x-show="!isCreating" data-lucide="check-circle" class="w-5 h-5"></i>
                <span x-text="isCreating ? 'در حال ثبت اطلاعات...' : 'تایید و افزودن به ویترین'"></span>
            </button>
            <button @click="open = false" class="px-8 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl py-4 font-bold hover:bg-slate-200 transition-all">انصراف</button>
        </div>
    </div>
</div>
