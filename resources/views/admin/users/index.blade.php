@extends('admin.layouts.app')

@section('title', 'مدیریت کاربران')

@section('content')
<div x-data="usersPage()" class="space-y-6">

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900/60 rounded-2xl p-4 flex items-center gap-3">
            <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
            </div>
            <span class="text-sm font-bold text-emerald-900 dark:text-emerald-200">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/60 rounded-2xl p-4 space-y-2">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                </div>
                <span class="text-sm font-bold text-rose-900 dark:text-rose-200">خطاهای زیر رخ داده است:</span>
            </div>
            <ul class="list-disc list-inside text-xs pr-10 space-y-1 text-rose-800 dark:text-rose-300">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm gap-4">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl">
                <i data-lucide="users" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-800 dark:text-slate-100">مدیریت طلافروشان همکار</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">تأیید عضویت مغازه‌ها، تمدید اشتراک و مدیریت رمز عبور</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.register') }}" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2.5 rounded-xl text-sm transition-colors shadow-lg shadow-blue-500/20">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>ثبت‌نام کاربر جدید</span>
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Total Users --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">تعداد کل طلافروشان</p>
                <h3 class="text-3xl font-black text-slate-800 dark:text-slate-100 tabular-nums">{{ $users->count() }}</h3>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 dark:bg-indigo-950/30 dark:text-indigo-400 rounded-2xl">
                <i data-lucide="users" class="w-8 h-8"></i>
            </div>
        </div>

        {{-- Pending Approvals --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">در انتظار تأیید سیستم</p>
                <h3 class="text-3xl font-black text-amber-600 dark:text-amber-400 tabular-nums">{{ $users->where('is_approved', false)->count() }}</h3>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 dark:bg-amber-950/30 dark:text-amber-400 rounded-2xl">
                <i data-lucide="user-check" class="w-8 h-8"></i>
            </div>
        </div>

        {{-- Expired Subscriptions --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">اشتراک‌های منقضی شده</p>
                <h3 class="text-3xl font-black text-rose-600 dark:text-rose-400 tabular-nums">
                    {{ $users->filter(fn($u) => $u->expires_at && $u->expires_at->isPast())->count() }}
                </h3>
            </div>
            <div class="p-3 bg-rose-50 text-rose-600 dark:bg-rose-950/30 dark:text-rose-400 rounded-2xl">
                <i data-lucide="clock" class="w-8 h-8"></i>
            </div>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800">
            <h3 class="font-bold text-slate-800 dark:text-slate-100">فهرست کل همکاران ثبت شده</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 text-slate-500 dark:text-slate-400 text-xs font-bold border-b border-slate-100 dark:border-slate-800">
                        <th class="px-6 py-4">نام طلافروشی</th>
                        <th class="px-6 py-4">نام کاربری (مغازه)</th>
                        <th class="px-6 py-4">تاریخ انقضای اشتراک</th>
                        <th class="px-6 py-4">وضعیت تایید</th>
                        <th class="px-6 py-4">وضعیت اشتراک</th>
                        <th class="px-6 py-4 text-center">عملیات مدیریت</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800 dark:text-slate-200">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-600 dark:text-slate-400">
                                {{ $user->username }}
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400 tabular-nums">
                                {{ $user->expires_at ? $user->expires_at->format('Y/m/d H:i') : 'نامحدود' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_approved)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 dark:bg-emerald-400"></span>
                                        تایید شده
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600 dark:bg-amber-400"></span>
                                        در انتظار تایید
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->expires_at && $user->expires_at->isPast())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400">
                                        منقضی شده
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        فعال / معتبر
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Approve Button --}}
                                    @if(!$user->is_approved)
                                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm shadow-emerald-500/10">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                                <span>تأیید عضویت</span>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Extend Subscription Button --}}
                                    <button @click="openExtendModal({{ $user->id }}, '{{ $user->name }}')" 
                                            class="flex items-center gap-1 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm shadow-blue-500/10">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                        <span>تمدید اعتبار</span>
                                    </button>

                                    {{-- Change Password Button --}}
                                    <button @click="openPasswordModal({{ $user->id }}, '{{ $user->name }}')" 
                                            class="flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold transition-all border border-slate-200 dark:border-slate-700">
                                        <i data-lucide="key-round" class="w-3.5 h-3.5"></i>
                                        <span>رمز جدید</span>
                                    </button>

                                    {{-- Delete User Button --}}
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('آیا از حذف کامل حساب کاربری «{{ $user->name }}» و تمامی داده‌های مربوط به آن (پیکربندی‌ها، محصولات، فرمول‌ها) اطمینان صددرصد دارید؟ این عمل غیر قابل بازگشت است.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center gap-1 px-3 py-1.5 bg-rose-500/10 hover:bg-rose-600 hover:text-white text-rose-600 rounded-xl text-xs font-bold transition-all border border-rose-500/20">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            <span>حذف</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 dark:text-slate-600">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i data-lucide="users" class="w-10 h-10 opacity-30"></i>
                                    <span class="font-bold">هیچ کاربر طلافروشی دیگری در سیستم ثبت نشده است.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Extend subscription Modal --}}
    <div x-show="showExtendModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl"
             @click.away="showExtendModal = false">
            
            {{-- Modal Header --}}
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i>
                    <span>تمدید اعتبار اشتراک</span>
                </h3>
                <button @click="showExtendModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Modal Form --}}
            <form :action="'{{ url('/admin/users') }}/' + targetUserId + '/extend'" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        شما در حال تمدید اعتبار زمانی حساب طلافروشی <span class="font-black text-slate-800 dark:text-slate-100" x-text="targetUserName"></span> هستید.
                    </p>
                </div>

                {{-- Fast Buttons --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-500">گزینه‌های سریع تمدید:</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" @click="customMonths = 1" 
                                class="py-2 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 transition-all text-slate-700 dark:text-slate-300"
                                :class="customMonths == 1 ? 'bg-blue-600! text-white!' : ''">
                            تمدید ۱ ماهه
                        </button>
                        <button type="button" @click="customMonths = 3" 
                                class="py-2 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 transition-all text-slate-700 dark:text-slate-300"
                                :class="customMonths == 3 ? 'bg-blue-600! text-white!' : ''">
                            تمدید ۳ ماهه
                        </button>
                        <button type="button" @click="customMonths = 6" 
                                class="py-2 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 transition-all text-slate-700 dark:text-slate-300"
                                :class="customMonths == 6 ? 'bg-blue-600! text-white!' : ''">
                            تمدید ۶ ماهه
                        </button>
                        <button type="button" @click="customMonths = 12" 
                                class="py-2 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 transition-all text-slate-700 dark:text-slate-300"
                                :class="customMonths == 12 ? 'bg-blue-600! text-white!' : ''">
                            تمدید ۱ ساله (۱۲ ماه)
                        </button>
                    </div>
                </div>

                {{-- Custom Input --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">تعداد ماه دلخواه جهت تمدید:</label>
                    <div class="flex items-center gap-2">
                        <input type="number" name="months" min="1" max="120" required x-model="customMonths"
                               class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 tabular-nums">
                        <span class="text-xs text-slate-500 font-bold whitespace-nowrap">ماه اعتبار</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                        ثبت تمدید اعتبار
                    </button>
                    <button type="button" @click="showExtendModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-xl text-sm border border-slate-200 dark:border-slate-700">
                        انصراف
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Reset Password Modal --}}
    <div x-show="showPasswordModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl"
             @click.away="showPasswordModal = false">
            
            {{-- Modal Header --}}
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <i data-lucide="key-round" class="w-5 h-5 text-blue-600"></i>
                    <span>تخصیص رمز عبور جدید</span>
                </h3>
                <button @click="showPasswordModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Modal Form --}}
            <form :action="'{{ url('/admin/users') }}/' + targetUserId + '/change-password'" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        شما در حال تغییر رمز عبور طلافروشی <span class="font-black text-slate-800 dark:text-slate-100" x-text="targetUserName"></span> هستید. رمز جدید بلافاصله اعمال می‌شود.
                    </p>
                </div>

                {{-- Password Input --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">رمز عبور جدید:</label>
                    <input type="password" name="password" required minlength="6" placeholder="حداقل ۶ کاراکتر"
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 text-left" dir="ltr">
                </div>

                {{-- Confirm Password Input --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">تکرار رمز عبور جدید:</label>
                    <input type="password" name="password_confirmation" required minlength="6" placeholder="تکرار رمز عبور"
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 text-left" dir="ltr">
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                        ذخیره رمز عبور جدید
                    </button>
                    <button type="button" @click="showPasswordModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-xl text-sm border border-slate-200 dark:border-slate-700">
                        انصراف
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function usersPage() {
    return {
        showExtendModal: false,
        showPasswordModal: false,
        targetUserId: null,
        targetUserName: '',
        customMonths: 12,

        openExtendModal(userId, name) {
            this.targetUserId = userId;
            this.targetUserName = name;
            this.customMonths = 12; // default to 1 year
            this.showExtendModal = true;
        },

        openPasswordModal(userId, name) {
            this.targetUserId = userId;
            this.targetUserName = name;
            this.showPasswordModal = true;
        }
    }
}
</script>
@endpush
