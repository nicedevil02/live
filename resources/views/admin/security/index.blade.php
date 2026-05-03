@extends('admin.layouts.app')

@section('title', 'تنظیمات امنیتی و ورود')

@section('content')
<div x-data="securityPage()" class="space-y-6 max-w-2xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
        <div class="p-3 bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl shrink-0">
            <i data-lucide="shield-check" class="w-8 h-8"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">تنظیمات امنیتی پنل</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">تغییر نام کاربری و رمز عبور ورود به سیستم مدیریت</p>
        </div>
    </div>

    {{-- Feedback --}}
    <div x-show="message.text" x-transition
         :class="message.type === 'success' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50' : 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/50'"
         class="flex items-start gap-2 px-4 py-3 rounded-xl border text-sm font-semibold">
        <i x-show="message.type === 'success'" data-lucide="check-circle-2" class="w-5 h-5 shrink-0"></i>
        <i x-show="message.type !== 'success'" data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
        <p class="leading-relaxed" x-text="message.text"></p>
    </div>

    {{-- Form --}}
    <form @submit.prevent="handleSave" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-6">

        {{-- Current Password --}}
        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-5 border border-slate-200 dark:border-slate-700">
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">رمز عبور فعلی (جهت احراز هویت) *</label>
            <input type="password" required dir="ltr" placeholder="••••••••"
                   x-model="currentPassword"
                   class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-rose-500/40 transition-shadow text-left">
        </div>

        <hr class="border-slate-200 dark:border-slate-800">

        {{-- New Credentials --}}
        <div class="space-y-4">
            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 mb-4">فیلدهای زیر را در صورت تمایل به تغییر پر کنید:</p>

            <div>
                <label class="flex items-center gap-1.5 text-sm font-bold text-slate-700 dark:text-slate-300 mb-2"><i data-lucide="user" class="w-4 h-4 text-slate-400"></i> نام کاربری جدید</label>
                <input type="text" dir="ltr" placeholder="admin"
                       x-model="newUsername"
                       class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition-shadow text-left">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="flex items-center gap-1.5 text-sm font-bold text-slate-700 dark:text-slate-300 mb-2"><i data-lucide="lock" class="w-4 h-4 text-slate-400"></i> رمز عبور جدید</label>
                    <input type="password" dir="ltr" placeholder="حداقل ۶ کاراکتر"
                           x-model="newPassword"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition-shadow text-left">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">تکرار رمز عبور جدید</label>
                    <input type="password" dir="ltr" placeholder="تکرار رمز عبور"
                           x-model="confirmPassword"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition-shadow text-left">
                </div>
            </div>
        </div>

        <button type="submit" :disabled="isSaving || !currentPassword"
                class="w-full mt-6 bg-rose-600 hover:bg-rose-700 text-white rounded-xl py-3.5 font-bold text-base transition-colors disabled:opacity-50 shadow-sm shadow-rose-500/20 flex items-center justify-center gap-2">
            <i x-show="!isSaving" data-lucide="save" class="w-5 h-5"></i>
            <span x-text="isSaving ? 'در حال ثبت تغییرات...' : 'ثبت و ذخیره تغییرات'"></span>
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
function securityPage() {
    return {
        currentPassword: '',
        newUsername: '',
        newPassword: '',
        confirmPassword: '',
        message: { text: '', type: '' },
        isSaving: false,

        showMessage(text, type = 'success') {
            this.message = { text, type };
            setTimeout(() => this.message = { text: '', type: '' }, 5000);
        },

        async handleSave() {
            if (!this.currentPassword) {
                return this.showMessage('رمز عبور فعلی برای تایید هویت الزامی است.', 'error');
            }
            if (this.newPassword && this.newPassword !== this.confirmPassword) {
                return this.showMessage('رمز عبور جدید و تکرار آن یکسان نیستند.', 'error');
            }
            if (this.newPassword && this.newPassword.length < 6) {
                return this.showMessage('رمز عبور جدید باید حداقل ۶ کاراکتر باشد.', 'error');
            }

            this.isSaving = true;
            try {
                const res = await fetch('/admin/security', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        currentPassword: this.currentPassword,
                        newUsername: this.newUsername || undefined,
                        newPassword: this.newPassword || undefined,
                        newPassword_confirmation: this.confirmPassword || undefined,
                    })
                });

                const data = await res.json();

                if (!res.ok) {
                    throw new Error(data.message || 'خطا در ذخیره تغییرات');
                }

                this.showMessage(data.message || 'اطلاعات با موفقیت ذخیره شد.', 'success');
                this.currentPassword = '';
                this.newUsername = '';
                this.newPassword = '';
                this.confirmPassword = '';
            } catch (e) {
                this.showMessage(e.message, 'error');
            } finally {
                this.isSaving = false;
            }
        }
    };
}
</script>
@endpush
