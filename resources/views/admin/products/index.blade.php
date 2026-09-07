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
                <span class="text-xs text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-lg" x-text="visibleCount + ' نمایان'"></span>
                <span class="text-xs text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-lg" x-text="hiddenCount + ' مخفی'"></span>
            </div>
        </div>
        @include('admin.products.partials.create-form')
    </div>

    {{-- Products Grid --}}
    <div x-show="isLoading" class="flex items-center justify-center py-20">
        <div class="w-8 h-8 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <div x-show="!isLoading && products.length === 0" class="flex flex-col items-center justify-center py-20 gap-4">
        <span class="text-6xl opacity-30">💍</span>
        <p class="text-slate-500 dark:text-slate-400">هیچ محصولی ثبت نشده است. اولین محصول را اضافه کنید.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5"
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
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('productsManager', () => ({
        products: [],
        editingProduct: null,
        isLoading: true,
        toast: { show: false, message: '', type: 'success' },

        get visibleCount() { return this.products.filter(p => p.is_visible).length; },
        get hiddenCount() { return this.products.length - this.visibleCount; },

        async init() {
            try {
                const res = await fetch('/admin/products', { headers: { 'Accept': 'application/json' } });
                this.products = await res.json();
                this.$nextTick(() => lucide.createIcons());
            } catch (e) {
                this.showToast(e.message, 'error');
            } finally {
                this.isLoading = false;
            }
        },

        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => this.toast.show = false, 3500);
        },

        async handleDelete(id) {
            if (!confirm('آیا مطمئن هستید؟')) return;
            try {
                await fetch(`/admin/products/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                this.products = this.products.filter(p => p.id !== id);
                this.showToast('محصول با موفقیت حذف شد.', 'success');
            } catch (e) {
                this.showToast('خطا در حذف محصول', 'error');
            }
        },

        async handleToggleVisible(id, visible) {
            try {
                const res = await fetch(`/admin/products/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ is_visible: visible })
                });
                const updated = await res.json();
                const index = this.products.findIndex(p => p.id === id);
                if (index !== -1) this.products[index] = updated;
                this.$nextTick(() => lucide.createIcons());
                this.showToast(visible ? 'محصول نمایش داده می‌شود.' : 'محصول مخفی شد.', 'success');
            } catch (e) {
                this.showToast('خطا در تغییر وضعیت', 'error');
            }
        },

        handleCreated(product) {
            this.products.unshift(product);
            this.$nextTick(() => lucide.createIcons());
            this.showToast('محصول با موفقیت ایجاد شد.', 'success');
        },

        handleEdited(product) {
            const index = this.products.findIndex(p => p.id === product.id);
            if (index !== -1) this.products[index] = product;
            this.editingProduct = null;
            this.$nextTick(() => lucide.createIcons());
            this.showToast('محصول با موفقیت ذخیره شد.', 'success');
        }
    }));
});
</script>
@endpush
