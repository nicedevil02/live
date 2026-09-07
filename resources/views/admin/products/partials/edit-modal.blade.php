<div x-data="editProductForm()" x-init="init(editingProduct)" @product-saved.window="if ($event.detail.id === id) close()">
    <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
            ویرایش اطلاعات محصول
        </h3>
        <button @click="editingProduct = null" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 transition-colors">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
    </div>

    <div class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">نام محصول</label>
                <input type="text" x-model="form.title" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">وزن (گرم)</label>
                <input type="number" step="0.001" x-model="form.weight_gram" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">نوع سود و اجرت</label>
                <select x-model="form.profit_type" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="percent">درصد سود و اجرت (%)</option>
                    <option value="amount">مبلغ ثابت سود و اجرت (تومان)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">مقدار سود و اجرت</label>
                <input type="number" x-model="form.profit_value" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>

        {{-- Live Price Preview --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 rounded-2xl p-5 flex items-center justify-between shadow-inner">
            <div>
                <span class="text-xs text-blue-600 dark:text-blue-400 font-bold block mb-1">قیمت نهایی با نرخ فعلی بازار</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-blue-700 dark:text-blue-300" x-text="new Intl.NumberFormat('fa-IR').format(finalPrice)"></span>
                    <span class="text-sm font-bold text-blue-600/70">تومان</span>
                </div>
            </div>
            <div class="text-left">
                <div class="text-[10px] text-slate-400 font-bold uppercase">نرخ مبنا (۱۸ عیار)</div>
                <div class="text-sm font-black text-slate-600 dark:text-slate-300" x-text="new Intl.NumberFormat('fa-IR').format(form.base_gold_price) + ' ت'"></div>
            </div>
        </div>

        {{-- Image Management --}}
        <div class="space-y-4">
            <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                <i data-lucide="image" class="w-4 h-4"></i>
                مدیریت تصاویر
            </h4>

            <div class="flex flex-wrap gap-3">
                <template x-for="img in localProduct.images" :key="img.id">
                    <div class="relative group w-24 h-24 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm">
                        <img :src="img.url" class="absolute inset-0 w-full h-full object-cover" x-on:error="$el.src='/placeholder.png'">
                        <button @click="handleDeleteImage(img.id)" class="absolute inset-0 flex items-center justify-center bg-rose-600/80 opacity-0 group-hover:opacity-100 transition-all text-white">
                            <i data-lucide="trash-2" class="w-6 h-6"></i>
                        </button>
                    </div>
                </template>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="flex gap-2">
                    <input type="text" x-model="imageUrl" class="flex-1 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500" placeholder="لینک تصویر جدید (URL)">
                    <button @click="handleAddImageUrl" class="px-4 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-xl text-xs font-bold hover:bg-slate-300 transition-colors">افزودن</button>
                </div>
                <div class="flex gap-2">
                    <label class="flex-1 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2 text-[10px] text-slate-500 cursor-pointer flex items-center truncate">
                        <span x-text="imageFile ? imageFile.name : 'انتخاب فایل تصویر...'"></span>
                        <input type="file" class="hidden" x-ref="fileInput" @change="
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
                    <button @click="handleUploadFile" :disabled="!imageFile" class="px-4 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 disabled:opacity-50 transition-colors">آپلود</button>
                </div>
            </div>
        </div>
    </div>

    <div class="flex gap-3 p-6 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
        <button @click="handleSave" :disabled="isSaving" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3.5 font-bold shadow-lg shadow-blue-500/20 transition-all disabled:opacity-50 flex items-center justify-center gap-2">
            <i x-show="!isSaving" data-lucide="check" class="w-5 h-5"></i>
            <span x-text="isSaving ? 'در حال ذخیره...' : 'ذخیره تغییرات محصول'"></span>
        </button>
        <button @click="editingProduct = null" class="px-8 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-xl py-3.5 font-bold hover:bg-slate-50 transition-all">لغو</button>
    </div>
</div>

<script>
function editProductForm() {
    return {
        id: '',
        form: { title: '', weight_gram: 0, profit_value: 0, profit_type: 'percent', base_gold_price: {{ $latestGoldPrice }} },
        localProduct: { images: [] },
        imageUrl: '',
        imageFile: null,
        isSaving: false,

        get finalPrice() {
            const base = (this.form.base_gold_price * this.form.weight_gram);
            const profit = this.form.profit_type === 'percent' ? (base * (this.form.profit_value / 100)) : Number(this.form.profit_value);
            return Math.round(base + profit);
        },

        init(product) {
            if (!product) return;
            this.id = product.id;
            this.form = {
                title: product.title,
                weight_gram: product.weight_gram,
                profit_value: product.profit_value,
                profit_type: product.profit_type,
                base_gold_price: {{ $latestGoldPrice }},
            };
            this.localProduct = JSON.parse(JSON.stringify(product));
        },

        async handleSave() {
            this.isSaving = true;
            try {
                const res = await fetch(`/admin/products/${this.id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(this.form)
                });
                const updated = await res.json();
                this.$dispatch('product-edited', updated);
            } catch(e) {
                alert('خطا در بروزرسانی');
            } finally {
                this.isSaving = false;
            }
        },

        async handleAddImageUrl() {
            if (!this.imageUrl.trim()) return;
            try {
                const res = await fetch(`/admin/products/${this.id}/images`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ url: this.imageUrl })
                });
                const img = await res.json();
                this.localProduct.images.push(img);
                this.imageUrl = '';
            } catch(e) { alert('خطا در افزودن لینک'); }
        },

        async handleUploadFile() {
            if (!this.imageFile) return;
            const fd = new FormData();
            fd.append('image', this.imageFile);
            try {
                const res = await fetch(`/admin/products/${this.id}/images/upload`, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: fd
                });
                if (!res.ok) {
                    const result = await res.json();
                    if (res.status === 422) {
                        alert(result.message || 'فایل نامعتبر است (حداکثر ۲ مگابایت)');
                    } else {
                        alert('خطا در سرور');
                    }
                    return;
                }
                const img = await res.json();
                this.localProduct.images.push(img);
                this.imageFile = null;
                if (this.$refs.fileInput) this.$refs.fileInput.value = '';
            } catch(e) { alert('خطا در آپلود'); }
        },

        async handleDeleteImage(imageId) {
            if(!confirm('تصویر حذف شود؟')) return;
            try {
                await fetch(`/admin/products/${this.id}/images/${imageId}`, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                this.localProduct.images = this.localProduct.images.filter(i => i.id !== imageId);
            } catch(e) { alert('خطا در حذف تصویر'); }
        }
    };
}
</script>
