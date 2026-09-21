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

    {{-- Empty Showcase Mode & Greeting Banner Settings Card --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-xl bg-purple-500/15 text-purple-600 dark:text-purple-400 border border-purple-500/20">
                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">حالت ویترین در صورت خالی بودن (بدون محصول)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">تعیین محتوای نمایش داده شده روی تلویزیون زمانی که هنوز محصولی اضافه نکرده‌اید</p>
                </div>
            </div>

            {{-- Mode Switch Buttons --}}
            <div class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800/80 p-1.5 rounded-2xl border border-slate-200 dark:border-slate-700/80">
                <button type="button"
                        @click="emptyShowcaseMode = 'guide'; saveEmptyShowcaseSettings()"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer"
                        :class="emptyShowcaseMode === 'guide'
                            ? 'bg-white dark:bg-slate-900 text-purple-600 dark:text-purple-400 shadow-sm border border-slate-200/60 dark:border-slate-700'
                            : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                    <i data-lucide="help-circle" class="w-4 h-4"></i>
                    <span>راهنمای هوشمند ویترین</span>
                </button>

                <button type="button"
                        @click="emptyShowcaseMode = 'custom_message'; saveEmptyShowcaseSettings()"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer"
                        :class="emptyShowcaseMode === 'custom_message'
                            ? 'bg-white dark:bg-slate-900 text-amber-600 dark:text-amber-400 shadow-sm border border-slate-200/60 dark:border-slate-700'
                            : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                    <i data-lucide="gift" class="w-4 h-4"></i>
                    <span>بنر تبریک و پیام اختصاصی</span>
                </button>
            </div>
        </div>

        {{-- Custom Message Config Panel (only shown when custom_message is active) --}}
        <div x-show="emptyShowcaseMode === 'custom_message'" x-transition class="pt-4 border-t border-slate-100 dark:border-slate-800/80 space-y-4">
            {{-- Quick Presets --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">قالب‌های آماده برای درج سریع مناسبت و تبریک:</label>
                <div class="flex items-center gap-2 flex-wrap">
                    <template x-for="preset in messagePresets" :key="preset.title">
                        <button type="button"
                                @click="applyPreset(preset)"
                                class="text-xs px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-amber-400 dark:hover:border-amber-500 bg-slate-50 dark:bg-slate-800/60 text-slate-700 dark:text-slate-300 transition-all font-medium flex items-center gap-1.5">
                            <span x-text="preset.icon"></span>
                            <span x-text="preset.title"></span>
                        </button>
                    </template>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Title --}}
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">عنوان بنر یا مناسبت</label>
                    <input type="text"
                           x-model="emptyShowcaseTitle"
                           placeholder="مثال: عید سعید فطر مبارک"
                           class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none">
                </div>

                {{-- Theme --}}
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">تم رنگی بنر</label>
                    <select x-model="emptyShowcaseTheme"
                            class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none">
                        <option value="gold">طلایی لوکس (پیش‌فرض)</option>
                        <option value="celebration">جشن و اعیاد (بنفش و سرخابی)</option>
                        <option value="royal">سرمه‌ای سلطنتی</option>
                        <option value="special_offer">پیشنهاد و فروش ویژه (زمردی)</option>
                    </select>
                </div>

                {{-- Save Button --}}
                <div class="md:col-span-1 flex items-end">
                    <button type="button"
                            @click="saveEmptyShowcaseSettings()"
                            :disabled="isSavingEmptyShowcase"
                            class="w-full flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-black text-sm shadow-md shadow-amber-500/20 transition-all disabled:opacity-50 cursor-pointer">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span x-text="isSavingEmptyShowcase ? 'در حال ذخیره...' : 'ذخیره پیام بنر روی تلویزیون'"></span>
                    </button>
                </div>

                {{-- Message Text --}}
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">متن پیام یا تبریک گالری</label>
                    <textarea x-model="emptyShowcaseText"
                              rows="2"
                              placeholder="متن دلخواه خود را برای نمایش به مشتریان بنویسید (مثال: به گالری ما خوش آمدید...)"
                              class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none resize-none"></textarea>
                </div>
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
        emptyShowcaseMode: @json(auth()->user()->displaySetting->empty_showcase_mode ?? 'guide'),
        emptyShowcaseTitle: @json(auth()->user()->displaySetting->empty_showcase_title ?? ''),
        emptyShowcaseText: @json(auth()->user()->displaySetting->empty_showcase_text ?? ''),
        emptyShowcaseTheme: @json(auth()->user()->displaySetting->empty_showcase_theme ?? 'gold'),
        isSavingEmptyShowcase: false,

        messagePresets: [
            { icon: '✨', title: 'خوش‌آمدگویی به گالری', text: 'به گالری طلا و جواهر ما خوش آمدید. افتخار ما همراهی با شما در انتخاب زیباترین زیورآلات با بهترین کیفیت و مناسب‌ترین اجرت است.', theme: 'gold' },
            { icon: '🌸', title: 'عید نوروز مبارک', text: 'فرارسیدن سال نو و بهار طبیعت بر شما و خانواده محترمتان مبارک باد. با آرزوی سالی سرشار از برکت و شادکامی.', theme: 'celebration' },
            { icon: '🌙', title: 'عید سعید فطر مبارک', text: 'عید سعید فطر، عید بندگی و پاداش یک ماه روزه‌داری بر تمام مسلمانان و همراهان گرامی مبارک باد.', theme: 'celebration' },
            { icon: '🌿', title: 'عید غدیر خم مبارک', text: 'فرارسیدن عید بزرگ امامت و ولایت، عید سعید غدیر خم بر عاشقان ولایت تهنیت و مبارک باد.', theme: 'royal' },
            { icon: '💎', title: 'شرایط ویژه تعویض طلا', text: 'تعویض طلای کهنه و دست‌دوم شما با جدیدترین کارهای لوکس و بدون اجرت با بهترین نرخ روز.', theme: 'special_offer' },
            { icon: '⭐', title: 'کالکشن جدید زیورآلات', text: 'جدیدترین کالکشن سرویس، دستبند و انگشتر لوکس رسید. از ویترین دیدن فرمایید.', theme: 'gold' },
        ],

        applyPreset(preset) {
            this.emptyShowcaseTitle = preset.title;
            this.emptyShowcaseText = preset.text;
            this.emptyShowcaseTheme = preset.theme;
        },

        async saveEmptyShowcaseSettings() {
            this.isSavingEmptyShowcase = true;
            try {
                const res = await fetch("{{ route('admin.empty-showcase.update') }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        empty_showcase_mode: this.emptyShowcaseMode,
                        empty_showcase_title: this.emptyShowcaseTitle,
                        empty_showcase_text: this.emptyShowcaseText,
                        empty_showcase_theme: this.emptyShowcaseTheme
                    })
                });
                if (!res.ok) {
                    const err = await res.json().catch(() => ({}));
                    throw new Error(err.message || 'خطا در ذخیره تنظیمات ویترین');
                }
                const data = await res.json();
                this.showToast(data.message || 'تنظیمات ویترین با موفقیت ذخیره شد.', 'success');
            } catch (e) {
                this.showToast(e.message || 'خطا در ذخیره', 'error');
            } finally {
                this.isSavingEmptyShowcase = false;
            }
        },
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
