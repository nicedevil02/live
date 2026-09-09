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
                        <th class="px-6 py-4">مشخصات طلافروشی</th>
                        <th class="px-6 py-4">اطلاعات تماس</th>
                        <th class="px-6 py-4">تاریخ انقضا (شمسی)</th>
                        <th class="px-6 py-4">وضعیت حساب</th>
                        <th class="px-6 py-4 text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            {{-- ۱. مشخصات طلافروشی --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 dark:text-slate-200">
                                    {{ $user->name }}
                                </div>
                                <div class="text-xs font-mono text-slate-500 dark:text-slate-400 mt-0.5 flex items-center gap-1">
                                    <i data-lucide="at-sign" class="w-3 h-3 text-slate-400"></i>
                                    <span>{{ $user->username }}</span>
                                </div>
                            </td>

                            {{-- ۲. اطلاعات تماس --}}
                            <td class="px-6 py-4">
                                @if($user->phone)
                                    <a href="tel:{{ $user->phone }}" class="inline-flex items-center gap-1.5 font-mono font-bold text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors text-xs" dir="ltr">
                                        <i data-lucide="phone" class="w-3.5 h-3.5 text-blue-500"></i>
                                        <span>{{ $user->phone }}</span>
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400">بدون شماره تماس</span>
                                @endif
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 flex items-center gap-1">
                                    @if($user->email)
                                        <a href="mailto:{{ $user->email }}" class="hover:underline text-slate-500 dark:text-slate-400 flex items-center gap-1 truncate max-w-[180px]" title="{{ $user->email }}">
                                            <i data-lucide="mail" class="w-3 h-3 text-slate-400 shrink-0"></i>
                                            <span class="truncate">{{ $user->email }}</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400 flex items-center gap-1">
                                            <i data-lucide="mail" class="w-3 h-3 text-slate-400 shrink-0"></i>
                                            <span>بدون ایمیل</span>
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- ۳. تاریخ انقضای اشتراک (شمسی) --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700 dark:text-slate-300 tabular-nums flex items-center gap-1.5 text-xs">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                    <span>{{ $user->shamsi_expires_at }}</span>
                                </div>
                                <div class="mt-1">
                                    @if(!$user->expires_at)
                                        <span class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">دسترسی دائمی</span>
                                    @elseif($user->expires_at->isPast())
                                        <span class="text-xs text-rose-600 dark:text-rose-400 font-bold">منقضی شده</span>
                                    @else
                                        @php $days = $user->trialDaysRemaining(); @endphp
                                        @if($days > 0)
                                            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">({{ $days }} روز مانده)</span>
                                        @else
                                            <span class="text-xs text-amber-600 dark:text-amber-400 font-bold">(پایان امروز)</span>
                                        @endif
                                    @endif
                                </div>
                            </td>

                            {{-- ۴. وضعیت حساب --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col items-start gap-1">
                                    @if($user->is_approved)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 dark:bg-emerald-400"></span>
                                            تایید شده
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 dark:bg-amber-400"></span>
                                            در انتظار تایید
                                        </span>
                                    @endif

                                    @if(!$user->expires_at)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300 border border-blue-200/50 dark:border-blue-800/30">
                                            اشتراک نامحدود
                                        </span>
                                    @elseif($user->expires_at->isPast())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400">
                                            اشتراک منقضی
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/50 dark:border-emerald-800/30">
                                            اشتراک فعال
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- ۵. عملیات مدیریت (طرح ۱: آیکون‌باتن‌های مدرن و فشرده) --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    {{-- Approve Button --}}
                                    @if(!$user->is_approved)
                                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" title="تأیید عضویت و فعال‌سازی حساب" class="w-8 h-8 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-950/40 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white border border-emerald-200 dark:border-emerald-800/50 shadow-sm transition-all">
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Extend Subscription Button --}}
                                    <button @click="openExtendModal({{ $user->id }}, '{{ addslashes($user->name) }}')" 
                                            title="تمدید اعتبار اشتراک" 
                                            class="w-8 h-8 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-blue-950/40 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white border border-blue-200 dark:border-blue-800/50 shadow-sm transition-all">
                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                    </button>

                                    {{-- Change Password Button --}}
                                    <button @click="openPasswordModal({{ $user->id }}, '{{ addslashes($user->name) }}')" 
                                            title="تنظیم رمز عبور جدید" 
                                            class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-700 hover:text-white dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-200 dark:hover:text-slate-900 border border-slate-200 dark:border-slate-700 shadow-sm transition-all">
                                        <i data-lucide="key-round" class="w-4 h-4"></i>
                                    </button>

                                    {{-- Delete User Button --}}
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('آیا از حذف کامل حساب کاربری «{{ addslashes($user->name) }}» و تمامی داده‌های مربوط به آن (پیکربندی‌ها، محصولات، فرمول‌ها) اطمینان صددرصد دارید؟ این عمل غیر قابل بازگشت است.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="حذف حساب کاربری" class="w-8 h-8 flex items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-950/40 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white border border-rose-200 dark:border-rose-800/50 shadow-sm transition-all">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 dark:text-slate-600">
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
