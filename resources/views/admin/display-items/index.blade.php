@extends('admin.layouts.app')

@section('title', 'آیتم‌های تابلوی طلا')

@section('content')
<div x-data="displayItemsPage()" x-init="init()">
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
        <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-1">آیتم‌های نمایشگر</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-5">ترتیب و نمایش آیتم‌ها در تابلوی طلا را مدیریت کنید.</p>

        <div class="space-y-2">
            <template x-for="(item, index) in items" :key="item.key">
                <div class="flex items-center justify-between gap-3 p-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl">
                    <div class="flex items-center gap-2">
                        <button @click="moveItem(index, 'up')" :disabled="index === 0"
                                class="p-1 rounded hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 disabled:opacity-30">
                            ↑
                        </button>
                        <button @click="moveItem(index, 'down')" :disabled="index === items.length - 1"
                                class="p-1 rounded hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 disabled:opacity-30">
                            ↓
                        </button>
                        <span class="font-medium text-slate-800 dark:text-slate-200" x-text="item.label"></span>
                    </div>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" :checked="item.enabled"
                               @change="toggleItem(item.key, $event.target.checked)"
                               class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    </label>
                </div>
            </template>
        </div>

        <div class="mt-6">
            <button @click="save()" :disabled="isSaving"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-colors disabled:opacity-50">
                <span x-text="isSaving ? 'در حال ذخیره...' : 'ذخیره ترتیب'"></span>
            </button>
        </div>

        <div x-show="message" x-text="message" class="mt-3 text-sm text-slate-500 dark:text-slate-400"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function displayItemsPage() {
    return {
        items: [],
        message: '',
        isSaving: false,

        async init() {
            try {
                const res = await fetch('/admin/display-items', { headers: { 'Accept': 'application/json' } });
                let data = await res.json();
                // اطمینان از مرتب‌سازی بر اساس order
                this.items = data.sort((a, b) => a.order - b.order);
            } catch (e) {
                this.message = 'خطا در بارگذاری آیتم‌ها';
            }
        },

        toggleItem(key, checked) {
            this.items = this.items.map(item =>
                item.key === key ? { ...item, enabled: checked } : item
            );
        },

        moveItem(index, direction) {
            let next = [...this.items];
            const targetIndex = direction === 'up' ? index - 1 : index + 1;
            if (targetIndex < 0 || targetIndex >= next.length) return;
            [next[index], next[targetIndex]] = [next[targetIndex], next[index]];
            this.items = next.map((item, idx) => ({ ...item, order: idx + 1 }));
        },

        async save() {
            this.isSaving = true;
            try {
                const res = await fetch('/admin/display-items', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ items: this.items })
                });
                const saved = await res.json();
                this.items = saved.sort((a, b) => a.order - b.order);
                this.message = 'آیتم‌های نمایشگر ذخیره شد.';
                setTimeout(() => this.message = '', 3000);
            } catch (e) {
                this.message = e.message || 'خطا در ذخیره';
            } finally {
                this.isSaving = false;
            }
        }
    };
}
</script>
@endpush
