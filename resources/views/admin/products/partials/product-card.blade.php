<div class="relative group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm transition-all hover:shadow-md"
     :class="{ 'opacity-60': !product.is_visible }">
    {{-- Image --}}
    <div class="relative h-48 bg-slate-100 dark:bg-slate-800">
        <template x-if="product.images && product.images.length > 0">
            <img :src="product.images[0].url" :alt="product.title" class="absolute inset-0 w-full h-full object-cover">
        </template>
        <div class="flex h-full items-center justify-center" x-show="!product.images || product.images.length === 0">
            <i data-lucide="image" class="w-12 h-12 text-slate-300 dark:text-slate-600"></i>
        </div>
        <div x-show="!product.is_visible" class="absolute inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <span class="text-white font-bold text-xs bg-black/50 px-3 py-1 rounded-full border border-white/20">مخفی شده</span>
        </div>
    </div>

    {{-- Info --}}
    <div class="p-5">
        <h3 class="font-bold text-slate-900 dark:text-white text-base truncate mb-3" x-text="product.title"></h3>

        <div class="grid grid-cols-2 gap-y-2 text-xs border-b border-slate-100 dark:border-slate-800 pb-3 mb-3">
            <div class="text-slate-500 dark:text-slate-400">وزن:</div>
            <div class="text-left font-bold" x-text="product.weight_gram + ' گرم'"></div>

            <div class="text-slate-500 dark:text-slate-400">سود و اجرت:</div>
            <div class="text-left font-bold" :class="product.profit_type === 'percent' ? 'text-blue-600' : 'text-emerald-600'"
                 x-text="product.profit_value + (product.profit_type === 'percent' ? '%' : ' ت')"></div>
        </div>

        <div class="flex flex-col gap-1">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black text-slate-400 uppercase">قیمت نهایی فعلی</span>
                <span class="font-black text-lg text-blue-600 dark:text-blue-400" x-text="new Intl.NumberFormat('fa-IR').format(product.final_price)"></span>
            </div>
            <div class="text-[9px] text-slate-400 text-left">محاسبه بر اساس نرخ لحظه‌ای بازار</div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="px-5 pb-5 flex gap-2">
        <button @click="editingProduct = product" class="flex-1 flex items-center justify-center gap-2 bg-slate-100 dark:bg-slate-800 hover:bg-blue-600 hover:text-white dark:text-slate-300 rounded-xl py-2.5 text-xs font-bold transition-all">
            <i data-lucide="pencil" class="w-4 h-4 shrink-0"></i>
            <span>ویرایش</span>
        </button>
        <button @click="handleToggleVisible(product.id, !product.is_visible)"
                title="تغییر وضعیت نمایش"
                class="flex items-center justify-center w-10 h-10 shrink-0 rounded-xl transition-colors bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400">
            <i x-show="product.is_visible" data-lucide="eye" class="w-5 h-5"></i>
            <i x-show="!product.is_visible" data-lucide="eye-off" class="w-5 h-5"></i>
        </button>
        <button @click="handleDelete(product.id)"
                title="حذف محصول"
                class="flex items-center justify-center w-10 h-10 shrink-0 rounded-xl transition-colors bg-slate-100 dark:bg-slate-800 hover:bg-rose-500 hover:text-white text-rose-500">
            <i data-lucide="trash-2" class="w-5 h-5"></i>
        </button>
    </div>
</div>
