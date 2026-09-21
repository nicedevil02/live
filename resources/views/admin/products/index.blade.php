@extends('admin.layouts.app')

@section('title', 'مدیریت ویترین (اسلایدر)')

@section('content')
<div x-data="productsManager"
     @product-created.window="handleCreated($event.detail)"
     @product-edited.window="handleEdited($event.detail)"
     class="space-y-6">
    {{-- Toast Notification --}}
    <div x-show="toast.show" x-transition
         :class="toast.type === 'success'
             ? 'bg-emerald-950 text-emerald-300 border-emerald-800'
             : 'bg-rose-950 text-rose-300 border-rose-800'"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3 px-5 py-3 rounded-2xl shadow-2xl border text-sm font-semibold"
         x-init="setTimeout(() => toast.show = false, 3500)">
        <span x-text="toast.message"></span>
    </div>

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">مدیریت ویترین (اسلایدر)</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">تصاویر و اطلاعات محصولات نمایش‌داده‌شده در تابلو</p>
            <div class="flex items-center gap-4 mt-2">
                <span class="text-xs text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-lg font-medium" x-text="visibleCount + ' نمایان'"></span>
                <span class="text-xs text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-lg font-medium" x-text="hiddenCount + ' مخفی'"></span>
                <span class="text-xs px-2.5 py-0.5 rounded-lg font-bold"
                      :class="products.length >= 10 ? 'text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800' : 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20'"
                      x-text="products.length + ' از ۱۰ اسلایدر'"></span>
            </div>
        </div>
        @include('admin.products.partials.create-form')
    </div>

    {{-- Slider Timing Card --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-xl bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/20">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">زمان‌بندی چرخش اسلایدر ویترین</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">مدت زمان مکث و نمایش هر محصول در تلویزیون قبل از تعویض خودکار اسلاید</p>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <template x-for="opt in [{val:5, label:'۵ ثانیه', sub:'سریع'},{val:8, label:'۸ ثانیه', sub:'متوسط'},{val:12, label:'۱۲ ثانیه', sub:'آرام'},{val:20, label:'۲۰ ثانیه', sub:'خیلی آرام'}]" :key="opt.val">
                    <button @click="setSliderInterval(opt.val)" :disabled="isSavingTiming"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 transition-all text-xs sm:text-sm font-bold cursor-pointer disabled:opacity-50"
                            :class="sliderInterval === opt.val
                                ? 'border-amber-500 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 shadow-sm shadow-amber-500/10'
                                : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:border-amber-300 dark:hover:border-slate-600'">
                        <span x-text="opt.label"></span>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-md font-normal"
                              :class="sliderInterval === opt.val ? 'bg-amber-200/60 dark:bg-amber-800/40 text-amber-800 dark:text-amber-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400'"
                              x-text="opt.sub"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    {{-- Products Grid --}}
    <div x-show="isLoading" class="flex items-center justify-center py-20">
        <div class="w-8 h-8 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <div x-show="!isLoading && products.length === 0" class="flex flex-col items-center justify-center py-20 gap-4">
        <span class="text-6xl opacity-30">💍</span>
        <p class="text-slate-500 dark:text-slate-400">هیچ محصولی ثبت نشده است. اولین محصول را اضافه کنید.</p>
    </div>

    <div id="products-grid"
         class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5"
         x-show="!isLoading && products.length > 0">
        <template x-for="product in products" :key="product.id">
            @include('admin.products.partials.product-card')
        </template>
    </div>

    {{-- Edit Modal --}}
    <template x-if="editingProduct">
        <div class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
             @click.self="editingProduct = null">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
                 @click.stop>
                @include('admin.products.partials.edit-modal')
            </div>
        </div>
    </template>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
/**
 * تابع بهینه‌سازی و کاهش حجم تصویر در کلاینت بدون افت کیفیت محسوس
 * تصاویر بزرگ موبایل را به نسخه WebP با کیفیت بالا و حجم بسیار پایین تبدیل می‌کند
 */
window.compressImage = function(file, maxDim = 1600, quality = 0.85) {
    return new Promise((resolve) => {
        if (!file || !file.type || !file.type.startsWith('image/')) {
            return resolve(file);
        }
        if (file.type === 'image/gif') {
            return resolve(file);
        }
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = (event) => {
            const img = new Image();
            img.src = event.target.result;
            img.onload = () => {
                let width = img.width;
                let height = img.height;
                if (width > maxDim || height > maxDim) {
                    if (width > height) {
                        height = Math.round((height * maxDim) / width);
                        width = maxDim;
                    } else {
                        width = Math.round((width * maxDim) / height);
                        height = maxDim;
                    }
                }
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob((blob) => {
                    if (!blob) {
                        return resolve(file);
                    }
                    const cleanName = file.name.replace(/\.[^/.]+$/, "") + ".webp";
                    const newFile = new File([blob], cleanName, {
                        type: 'image/webp',
                        lastModified: Date.now()
                    });
                    resolve(newFile);
                }, 'image/webp', quality);
            };
            img.onerror = () => resolve(file);
        };
        reader.onerror = () => resolve(file);
    });
};

document.addEventListener('alpine:init', () => {
    Alpine.data('productsManager', () => ({
        products: [],
        editingProduct: null,
        isLoading: true,
        sortableInstance: null,
        sliderInterval: @json(auth()->user()->displaySetting->slider_interval_sec ?? 8),
        isSavingTiming: false,
        toast: { show: false, message: '', type: 'success' },

        get visibleCount() { return this.products.filter(p => p.is_visible).length; },
        get hiddenCount() { return this.products.length - this.visibleCount; },

        async setSliderInterval(val) {
            this.sliderInterval = val;
            this.isSavingTiming = true;
            try {
                const res = await fetch("{{ route('admin.slider-timing.update') }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ slider_interval_sec: val })
                });
                if (!res.ok) {
                    const err = await res.json().catch(() => ({}));
                    throw new Error(err.message || 'خطا در ذخیره زمان‌بندی اسلایدر');
                }
                this.showToast(`زمان‌بندی اسلایدر روی ${val} ثانیه تنظیم شد و بلافاصله در تلویزیون اعمال گردید.`, 'success');
            } catch (e) {
                this.showToast(e.message || 'خطا در ذخیره زمان‌بندی', 'error');
            } finally {
                this.isSavingTiming = false;
            }
        },

        async init() {
            try {
                const res = await fetch('/admin/products', { headers: { 'Accept': 'application/json' } });
                this.products = await res.json();
                this.$nextTick(() => {
                    lucide.createIcons();
                    this.initSortable();
                });
            } catch (e) {
                this.showToast(e.message, 'error');
            } finally {
                this.isLoading = false;
            }
        },

        initSortable() {
            const grid = document.getElementById('products-grid');
            if (!grid || typeof Sortable === 'undefined') return;
            if (this.sortableInstance) {
                try { this.sortableInstance.destroy(); } catch (e) {}
            }
            this.sortableInstance = new Sortable(grid, {
                handle: '.drag-handle',
                animation: 250,
                ghostClass: 'opacity-40',
                chosenClass: 'scale-[1.02]',
                dragClass: 'shadow-2xl',
                onEnd: async () => {
                    const itemEls = Array.from(grid.querySelectorAll('[data-product-id]'));
                    const newOrders = itemEls.map((el, index) => ({
                        id: el.getAttribute('data-product-id'),
                        sort_order: index + 1
                    }));

                    try {
                        const res = await fetch('/admin/products/reorder', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ orders: newOrders })
                        });
                        if (!res.ok) throw new Error();
                        this.showToast('ترتیب نمایش اسلایدرها در تابلو با موفقیت به‌روز شد.', 'success');
                    } catch (e) {
                        this.showToast('خطا در ذخیره ترتیب جدید اسلایدرها', 'error');
                    }
                }
            });
        },

        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => this.toast.show = false, 3500);
        },

        async handleDelete(id) {
            if (!confirm('آیا مطمئن هستید؟')) return;
            try {
                const res = await fetch(`/admin/products/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                if (!res.ok) {
                    const err = await res.json().catch(() => ({}));
                    throw new Error(err.message || 'خطا در حذف محصول از سرور');
                }
                this.products = this.products.filter(p => p.id !== id);
                this.showToast('محصول با موفقیت حذف شد.', 'success');
                this.$nextTick(() => this.initSortable());
            } catch (e) {
                this.showToast(e.message || 'خطا در حذف محصول', 'error');
            }
        },

        async handleToggleVisible(id, visible) {
            try {
                const res = await fetch(`/admin/products/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ is_visible: visible })
                });
                if (!res.ok) {
                    throw new Error('خطا در تغییر وضعیت نمایش محصول در سرور');
                }
                const updated = await res.json();
                const index = this.products.findIndex(p => p.id === id);
                if (index !== -1) this.products[index] = updated;
                this.$nextTick(() => lucide.createIcons());
                this.showToast(visible ? 'محصول نمایش داده می‌شود.' : 'محصول مخفی شد.', 'success');
            } catch (e) {
                this.showToast(e.message || 'خطا در تغییر وضعیت', 'error');
            }
        },

        handleCreated(product) {
            this.products.push(product);
            this.$nextTick(() => {
                lucide.createIcons();
                this.initSortable();
            });
            this.showToast('محصول با موفقیت ایجاد شد.', 'success');
        },

        handleEdited(product) {
            const index = this.products.findIndex(p => p.id === product.id);
            if (index !== -1) this.products[index] = product;
            this.editingProduct = null;
            this.$nextTick(() => {
                lucide.createIcons();
                this.initSortable();
            });
            this.showToast('محصول با موفقیت ذخیره شد.', 'success');
        }
    }));
});
</script>
@endpush
