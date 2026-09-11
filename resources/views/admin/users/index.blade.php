@extends('admin.layouts.app')

@section('title', 'مدیریت کاربران و طلافروشان')

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

    @if(session('error'))
        <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/60 rounded-2xl p-4 flex items-center gap-3">
            <div class="p-2 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i>
            </div>
            <span class="text-sm font-bold text-rose-900 dark:text-rose-200">{{ session('error') }}</span>
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
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm gap-4">
        <div class="flex items-center gap-4">
            <div class="p-3.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl shadow-sm">
                <i data-lucide="users" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-800 dark:text-slate-100">مدیریت طلافروشان همکار</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">تأیید عضویت، مدیریت اشتراک و اعتبار، ورود کمکی و تنظیمات حساب</p>
            </div>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <a href="{{ route('admin.register') }}" class="flex-1 sm:flex-initial flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-5 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-500/20">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>ثبت طلافروش جدید</span>
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        {{-- Total Users --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 sm:p-5 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">کل طلافروشان</p>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 tabular-nums">{{ $users->count() }}</h3>
            </div>
            <div class="p-2.5 sm:p-3 bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400 rounded-2xl">
                <i data-lucide="users" class="w-6 h-6 sm:w-7 sm:h-7"></i>
            </div>
        </div>

        {{-- Active Subscriptions --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 sm:p-5 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">اشتراک‌های فعال</p>
                <h3 class="text-2xl sm:text-3xl font-black text-emerald-600 dark:text-emerald-400 tabular-nums">
                    {{ $users->filter(fn($u) => $u->is_approved && (!$u->expires_at || $u->expires_at->isFuture()))->count() }}
                </h3>
            </div>
            <div class="p-2.5 sm:p-3 bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 rounded-2xl">
                <i data-lucide="badge-check" class="w-6 h-6 sm:w-7 sm:h-7"></i>
            </div>
        </div>

        {{-- Pending Approvals --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 sm:p-5 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">در انتظار تأیید</p>
                <h3 class="text-2xl sm:text-3xl font-black text-amber-600 dark:text-amber-400 tabular-nums">
                    {{ $users->where('is_approved', false)->count() }}
                </h3>
            </div>
            <div class="p-2.5 sm:p-3 bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-400 rounded-2xl">
                <i data-lucide="clock-4" class="w-6 h-6 sm:w-7 sm:h-7"></i>
            </div>
        </div>

        {{-- Expired Subscriptions --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 sm:p-5 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">اشتراک منقضی</p>
                <h3 class="text-2xl sm:text-3xl font-black text-rose-600 dark:text-rose-400 tabular-nums">
                    {{ $users->filter(fn($u) => $u->expires_at && $u->expires_at->isPast())->count() }}
                </h3>
            </div>
            <div class="p-2.5 sm:p-3 bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 rounded-2xl">
                <i data-lucide="alert-octagon" class="w-6 h-6 sm:w-7 sm:h-7"></i>
            </div>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-sm space-y-4">
        <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            {{-- Search Box --}}
            <div class="relative flex-1">
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" x-model="searchQuery" placeholder="جستجو بر اساس نام طلافروشی، نام کاربری یا شماره موبایل..." 
                       class="w-full h-11 pr-10 pl-10 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all">
                <button x-show="searchQuery" @click="searchQuery = ''" class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            {{-- Filter Tabs --}}
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none text-xs font-bold">
                <button @click="activeTab = 'all'" 
                        class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5"
                        :class="activeTab === 'all' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700'">
                    <span>همه</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px]" :class="activeTab === 'all' ? 'bg-blue-700/60 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300'">{{ $users->count() }}</span>
                </button>

                <button @click="activeTab = 'active'" 
                        class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5"
                        :class="activeTab === 'active' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700'">
                    <span>فعال</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px]" :class="activeTab === 'active' ? 'bg-emerald-700/60 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300'">
                        {{ $users->filter(fn($u) => $u->is_approved && (!$u->expires_at || $u->expires_at->isFuture()))->count() }}
                    </span>
                </button>

                <button @click="activeTab = 'pending'" 
                        class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5"
                        :class="activeTab === 'pending' ? 'bg-amber-600 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700'">
                    <span>در انتظار تایید</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px]" :class="activeTab === 'pending' ? 'bg-amber-700/60 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300'">
                        {{ $users->where('is_approved', false)->count() }}
                    </span>
                </button>

                <button @click="activeTab = 'expired'" 
                        class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5"
                        :class="activeTab === 'expired' ? 'bg-rose-600 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700'">
                    <span>منقضی</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px]" :class="activeTab === 'expired' ? 'bg-rose-700/60 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300'">
                        {{ $users->filter(fn($u) => $u->expires_at && $u->expires_at->isPast())->count() }}
                    </span>
                </button>

                <button @click="activeTab = 'lifetime'" 
                        class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5"
                        :class="activeTab === 'lifetime' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700'">
                    <span>نامحدود (دائمی)</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px]" :class="activeTab === 'lifetime' ? 'bg-indigo-700/60 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300'">
                        {{ $users->filter(fn($u) => is_null($u->expires_at))->count() }}
                    </span>
                </button>
            </div>
        </div>
    </div>

    {{-- Desktop Table View (Hidden on Mobile) --}}
    <div class="hidden md:block bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-bold border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4">مشخصات طلافروشی</th>
                        <th class="px-6 py-4">اطلاعات تماس</th>
                        <th class="px-6 py-4">اعتبار اشتراک (شمسی)</th>
                        <th class="px-6 py-4">وضعیت حساب</th>
                        <th class="px-6 py-4 text-center">عملیات مدیریت</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                    @forelse($users as $user)
                        @php
                            $isPending = !$user->is_approved;
                            $isExpired = $user->expires_at && $user->expires_at->isPast();
                            $isLifetime = is_null($user->expires_at);
                            $isActive = $user->is_approved && ($isLifetime || !$isExpired);

                            if ($isPending) {
                                $statusCat = 'pending';
                            } elseif ($isExpired) {
                                $statusCat = 'expired';
                            } elseif ($isLifetime) {
                                $statusCat = 'lifetime';
                            } else {
                                $statusCat = 'active';
                            }
                        @endphp
                        <tr x-show="filterMatch('{{ addslashes(mb_strtolower($user->name)) }}', '{{ addslashes(mb_strtolower($user->username)) }}', '{{ $user->phone ?? '' }}', '{{ $statusCat }}')"
                            class="hover:bg-slate-50/70 dark:hover:bg-slate-800/30 transition-colors">
                            
                            {{-- ۱. مشخصات طلافروشی --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 font-black flex items-center justify-center shadow-sm shrink-0">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                                            <span>{{ $user->name }}</span>
                                            @if($isLifetime)
                                                <span class="px-1.5 py-0.5 rounded text-[10px] font-black bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300">VIP</span>
                                            @endif
                                        </div>
                                        <div class="text-xs font-mono text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-2">
                                            <span class="flex items-center gap-1">
                                                <i data-lucide="at-sign" class="w-3 h-3 text-slate-400"></i>
                                                <span>{{ $user->username }}</span>
                                            </span>
                                            <button @click="copyShopLink('{{ $user->username }}', {{ $user->id }})" 
                                                    title="کپی لینک مستقیم تابلوی زنده" 
                                                    class="text-slate-400 hover:text-blue-600 transition-colors">
                                                <i data-lucide="copy" class="w-3 h-3" x-show="copiedId !== {{ $user->id }}"></i>
                                                <i data-lucide="check" class="w-3 h-3 text-emerald-500" x-show="copiedId === {{ $user->id }}"></i>
                                            </button>
                                        </div>
                                    </div>
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
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1">
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
                                    @if($isLifetime)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/40">
                                            <i data-lucide="infinity" class="w-3 h-3"></i>
                                            <span>دسترسی دائمی</span>
                                        </span>
                                    @elseif($isExpired)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400">
                                            <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                            <span>منقضی شده</span>
                                        </span>
                                    @else
                                        @php $days = $user->trialDaysRemaining(); @endphp
                                        @if($days > 0)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/40">
                                                <i data-lucide="check" class="w-3 h-3"></i>
                                                <span>{{ $days }} روز مانده</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                                <span>پایان امروز</span>
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </td>

                            {{-- ۴. وضعیت حساب --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col items-start gap-1">
                                    @if($user->is_approved)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 dark:bg-emerald-400"></span>
                                            تایید شده و فعال
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 dark:bg-amber-400"></span>
                                            در انتظار تایید سوپرادمین
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- ۵. عملیات مدیریت --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    {{-- ۱. مشاهده زنده تابلوی مغازه --}}
                                    <a href="{{ url('/' . $user->username) }}" target="_blank" 
                                       title="مشاهده تابلوی زنده طلافروشی در تب جدید" 
                                       class="w-8 h-8 flex items-center justify-center rounded-xl bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white dark:bg-sky-950/40 dark:text-sky-400 dark:hover:bg-sky-600 dark:hover:text-white border border-sky-200 dark:border-sky-800/50 shadow-sm transition-all">
                                        <i data-lucide="tv" class="w-4 h-4"></i>
                                    </a>

                                    {{-- ۲. ورود کمکی به عنوان طلافروش (Impersonate) --}}
                                    <form action="{{ route('admin.users.impersonate', $user->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('آیا می‌خواهید به عنوان «{{ addslashes($user->name) }}» وارد پنل شوید؟ (جهت تست و پشتیبانی فنی)');">
                                        @csrf
                                        <button type="submit" title="ورود کمکی به پنل طلافروش جهت پشتیبانی فنی" 
                                                class="w-8 h-8 flex items-center justify-center rounded-xl bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white dark:bg-purple-950/40 dark:text-purple-400 dark:hover:bg-purple-600 dark:hover:text-white border border-purple-200 dark:border-purple-800/50 shadow-sm transition-all">
                                            <i data-lucide="log-in" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                    {{-- ۳. تمدید و مدیریت اعتبار اشتراک --}}
                                    <button @click="openExtendModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->shamsi_expires_at }}', '{{ $user->expires_at ? $user->expires_at->toISOString() : '' }}')" 
                                            title="مدیریت و تمدید اعتبار اشتراک" 
                                            class="w-8 h-8 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-blue-950/40 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white border border-blue-200 dark:border-blue-800/50 shadow-sm transition-all">
                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                    </button>

                                    {{-- ۴. تغییر رمز عبور --}}
                                    <button @click="openPasswordModal({{ $user->id }}, '{{ addslashes($user->name) }}')" 
                                            title="تنظیم رمز عبور جدید" 
                                            class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-700 hover:text-white dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-200 dark:hover:text-slate-900 border border-slate-200 dark:border-slate-700 shadow-sm transition-all">
                                        <i data-lucide="key-round" class="w-4 h-4"></i>
                                    </button>

                                    {{-- ۵. فعال‌سازی یا تعلیق موقت حساب --}}
                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('{{ $user->is_approved ? "آیا از تعلیق موقت حساب «" . addslashes($user->name) . "» اطمینان دارید؟" : "آیا از فعال‌سازی و تأیید حساب «" . addslashes($user->name) . "» اطمینان دارید؟" }}');">
                                        @csrf
                                        @if($user->is_approved)
                                            <button type="submit" title="تعلیق موقت دسترسی حساب" class="w-8 h-8 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white dark:bg-amber-950/40 dark:text-amber-400 dark:hover:bg-amber-600 dark:hover:text-white border border-amber-200 dark:border-amber-800/50 shadow-sm transition-all">
                                                <i data-lucide="pause-circle" class="w-4 h-4"></i>
                                            </button>
                                        @else
                                            <button type="submit" title="تأیید و فعال‌سازی فوری حساب" class="w-8 h-8 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white dark:bg-emerald-950/40 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white border border-emerald-200 dark:border-emerald-800/50 shadow-sm transition-all">
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            </button>
                                        @endif
                                    </form>

                                    {{-- ۶. حذف کامل حساب کاربری --}}
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('آیا از حذف کامل حساب کاربری «{{ addslashes($user->name) }}» و تمامی داده‌های مربوط به آن (پیکربندی‌ها، محصولات، فرمول‌ها) اطمینان صددرصد دارید؟ این عمل غیر قابل بازگشت است.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="حذف دائمی حساب کاربری" class="w-8 h-8 flex items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-950/40 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white border border-rose-200 dark:border-rose-800/50 shadow-sm transition-all">
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
                                    <span class="font-bold">هیچ کاربر طلافروشی در سیستم ثبت نشده است.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Mobile Responsive Card View (Visible on Mobile Only) --}}
    <div class="block md:hidden space-y-4">
        @forelse($users as $user)
            @php
                $isPending = !$user->is_approved;
                $isExpired = $user->expires_at && $user->expires_at->isPast();
                $isLifetime = is_null($user->expires_at);
                $isActive = $user->is_approved && ($isLifetime || !$isExpired);

                if ($isPending) {
                    $statusCat = 'pending';
                } elseif ($isExpired) {
                    $statusCat = 'expired';
                } elseif ($isLifetime) {
                    $statusCat = 'lifetime';
                } else {
                    $statusCat = 'active';
                }
            @endphp
            <div x-show="filterMatch('{{ addslashes(mb_strtolower($user->name)) }}', '{{ addslashes(mb_strtolower($user->username)) }}', '{{ $user->phone ?? '' }}', '{{ $statusCat }}')"
                 class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                
                {{-- Card Top: Name & Badges --}}
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 font-black flex items-center justify-center shadow-sm shrink-0 text-base">
                            {{ mb_substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-black text-slate-800 dark:text-slate-100 text-base">{{ $user->name }}</h4>
                            <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-slate-400 mt-0.5">
                                <span>{{ '@' . $user->username }}</span>
                                <button @click="copyShopLink('{{ $user->username }}', {{ $user->id }})" 
                                        title="کپی لینک مستقیم تابلوی زنده" 
                                        class="text-slate-400 hover:text-blue-600 transition-colors">
                                    <i data-lucide="copy" class="w-3 h-3" x-show="copiedId !== {{ $user->id }}"></i>
                                    <i data-lucide="check" class="w-3 h-3 text-emerald-500" x-show="copiedId === {{ $user->id }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- TV Link Button --}}
                    <a href="{{ url('/' . $user->username) }}" target="_blank" 
                       class="p-2.5 rounded-xl bg-sky-50 text-sky-600 dark:bg-sky-950/40 dark:text-sky-400 border border-sky-200 dark:border-sky-800/50 shadow-sm"
                       title="مشاهده تابلوی زنده">
                        <i data-lucide="tv" class="w-4 h-4"></i>
                    </a>
                </div>

                {{-- Status Badges --}}
                <div class="flex flex-wrap items-center gap-2">
                    @if($user->is_approved)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 dark:bg-emerald-400"></span>
                            فعال
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 animate-pulse">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 dark:bg-amber-400"></span>
                            در انتظار تایید
                        </span>
                    @endif

                    @if($isLifetime)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-200/50">
                            دسترسی نامحدود
                        </span>
                    @elseif($isExpired)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400">
                            اشتراک منقضی
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/50">
                            اشتراک فعال ({{ $user->trialDaysRemaining() }} روز)
                        </span>
                    @endif
                </div>

                {{-- Contact & Subscription Info --}}
                <div class="grid grid-cols-2 gap-2 text-xs bg-slate-50 dark:bg-slate-800/40 p-3 rounded-xl">
                    <div>
                        <span class="text-slate-400 block mb-0.5">شماره تماس:</span>
                        @if($user->phone)
                            <a href="tel:{{ $user->phone }}" class="font-mono font-bold text-slate-700 dark:text-slate-200 flex items-center gap-1" dir="ltr">
                                <i data-lucide="phone" class="w-3 h-3 text-blue-500"></i>
                                <span>{{ $user->phone }}</span>
                            </a>
                        @else
                            <span class="text-slate-400">ثبت نشده</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">تاریخ انقضا (شمسی):</span>
                        <span class="font-bold text-slate-700 dark:text-slate-200 flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3 h-3 text-slate-400"></i>
                            <span>{{ $user->shamsi_expires_at }}</span>
                        </span>
                    </div>
                </div>

                {{-- Card Action Buttons --}}
                <div class="grid grid-cols-4 gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                    {{-- ورود کمکی (Impersonate) --}}
                    <form action="{{ route('admin.users.impersonate', $user->id) }}" method="POST" class="col-span-1"
                          onsubmit="return confirm('ورود به عنوان «{{ addslashes($user->name) }}» جهت بررسی تنظیمات؟');">
                        @csrf
                        <button type="submit" title="ورود کمکی" class="w-full py-2.5 flex flex-col items-center justify-center gap-1 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-950/40 dark:text-purple-400 border border-purple-200 dark:border-purple-800/50 text-[10px] font-bold">
                            <i data-lucide="log-in" class="w-4 h-4"></i>
                            <span>ورود</span>
                        </button>
                    </form>

                    {{-- تمدید اعتبار (Subscription Modal) --}}
                    <button @click="openExtendModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->shamsi_expires_at }}', '{{ $user->expires_at ? $user->expires_at->toISOString() : '' }}')" 
                            class="col-span-1 py-2.5 flex flex-col items-center justify-center gap-1 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400 border border-blue-200 dark:border-blue-800/50 text-[10px] font-bold">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        <span>تمدید</span>
                    </button>

                    {{-- تغییر رمز (Password Modal) --}}
                    <button @click="openPasswordModal({{ $user->id }}, '{{ addslashes($user->name) }}')" 
                            class="col-span-1 py-2.5 flex flex-col items-center justify-center gap-1 rounded-xl bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border border-slate-200 dark:border-slate-700 text-[10px] font-bold">
                        <i data-lucide="key-round" class="w-4 h-4"></i>
                        <span>رمز</span>
                    </button>

                    {{-- تعلیق یا فعال‌سازی --}}
                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="col-span-1"
                          onsubmit="return confirm('تغییر وضعیت حساب «{{ addslashes($user->name) }}»؟');">
                        @csrf
                        @if($user->is_approved)
                            <button type="submit" title="تعلیق حساب" class="w-full py-2.5 flex flex-col items-center justify-center gap-1 rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50 text-[10px] font-bold">
                                <i data-lucide="pause-circle" class="w-4 h-4"></i>
                                <span>تعلیق</span>
                            </button>
                        @else
                            <button type="submit" title="فعال‌سازی حساب" class="w-full py-2.5 flex flex-col items-center justify-center gap-1 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50 text-[10px] font-bold">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>تایید</span>
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 text-center text-slate-400 dark:text-slate-600">
                <i data-lucide="users" class="w-10 h-10 mx-auto opacity-30 mb-2"></i>
                <span class="font-bold text-sm">هیچ کاربر طلافروشی در سیستم ثبت نشده است.</span>
            </div>
        @endforelse
    </div>

    {{-- Upgraded Flexible Subscription Modal --}}
    <div x-show="showExtendModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl"
             @click.away="showExtendModal = false">
            
            {{-- Modal Header --}}
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base">مدیریت اعتبار و اشتراک</h3>
                        <p class="text-xs text-slate-400">تخصیص دوره تست، تمدید اشتراک یا دسترسی دائمی</p>
                    </div>
                </div>
                <button @click="showExtendModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Modal Form --}}
            <form :action="'{{ url('/admin/users') }}/' + targetUserId + '/subscription'" method="POST" class="p-6 space-y-5">
                @csrf
                <input type="hidden" name="action_type" :value="subActionType">

                {{-- User Info Banner --}}
                <div class="p-3.5 bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-800 rounded-2xl flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 block">طلافروشی انتخاب‌شده:</span>
                        <span class="font-black text-slate-800 dark:text-slate-100 text-sm" x-text="targetUserName"></span>
                    </div>
                    <div class="text-left">
                        <span class="text-xs text-slate-400 block">اعتبار فعلی:</span>
                        <span class="font-bold text-blue-600 dark:text-blue-400 text-xs" x-text="targetUserExpiryText"></span>
                    </div>
                </div>

                {{-- Action Type Selector Tabs --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">انتخاب نحوه تمدید یا تغییر اعتبار:</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" @click="subActionType = 'add_days'"
                                class="py-2.5 px-3 rounded-xl border text-xs font-bold transition-all flex flex-col items-center gap-1"
                                :class="subActionType === 'add_days' ? 'bg-blue-600 border-blue-600 text-white shadow-sm' : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 hover:bg-slate-100'">
                            <i data-lucide="sun" class="w-4 h-4"></i>
                            <span>تمدید روزانه</span>
                        </button>
                        <button type="button" @click="subActionType = 'add_months'"
                                class="py-2.5 px-3 rounded-xl border text-xs font-bold transition-all flex flex-col items-center gap-1"
                                :class="subActionType === 'add_months' ? 'bg-blue-600 border-blue-600 text-white shadow-sm' : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 hover:bg-slate-100'">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>تمدید ماهانه</span>
                        </button>
                        <button type="button" @click="subActionType = 'exact_date'"
                                class="py-2.5 px-3 rounded-xl border text-xs font-bold transition-all flex flex-col items-center gap-1"
                                :class="subActionType === 'exact_date' ? 'bg-blue-600 border-blue-600 text-white shadow-sm' : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 hover:bg-slate-100'">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>تاریخ دلخواه</span>
                        </button>
                    </div>
                </div>

                {{-- Option 1: Days Presets & Custom --}}
                <div x-show="subActionType === 'add_days'" class="space-y-3">
                    <label class="block text-xs font-bold text-slate-500">گزینه‌های سریع روزانه:</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" @click="subDays = 7"
                                class="py-2 text-xs font-bold rounded-xl border transition-all"
                                :class="subDays == 7 ? 'bg-blue-600 border-blue-600 text-white' : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300'">
                            +۷ روز (۱ هفته)
                        </button>
                        <button type="button" @click="subDays = 14"
                                class="py-2 text-xs font-bold rounded-xl border transition-all"
                                :class="subDays == 14 ? 'bg-blue-600 border-blue-600 text-white' : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300'">
                            +۱۴ روز (تست رایگان)
                        </button>
                        <button type="button" @click="subDays = 30"
                                class="py-2 text-xs font-bold rounded-xl border transition-all"
                                :class="subDays == 30 ? 'bg-blue-600 border-blue-600 text-white' : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300'">
                            +۳۰ روز (۱ ماه)
                        </button>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">یا تعداد روز دلخواه:</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="days" min="1" max="365" x-model="subDays"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 tabular-nums">
                            <span class="text-xs text-slate-500 font-bold whitespace-nowrap">روز اضافه</span>
                        </div>
                    </div>
                </div>

                {{-- Option 2: Months Presets & Custom --}}
                <div x-show="subActionType === 'add_months'" class="space-y-3">
                    <label class="block text-xs font-bold text-slate-500">گزینه‌های متداول ماهانه:</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        <button type="button" @click="subMonths = 1"
                                class="py-2 text-xs font-bold rounded-xl border transition-all"
                                :class="subMonths == 1 ? 'bg-blue-600 border-blue-600 text-white' : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300'">
                            ۱ ماهه
                        </button>
                        <button type="button" @click="subMonths = 3"
                                class="py-2 text-xs font-bold rounded-xl border transition-all"
                                :class="subMonths == 3 ? 'bg-blue-600 border-blue-600 text-white' : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300'">
                            ۳ ماهه
                        </button>
                        <button type="button" @click="subMonths = 6"
                                class="py-2 text-xs font-bold rounded-xl border transition-all"
                                :class="subMonths == 6 ? 'bg-blue-600 border-blue-600 text-white' : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300'">
                            ۶ ماهه
                        </button>
                        <button type="button" @click="subMonths = 12"
                                class="py-2 text-xs font-bold rounded-xl border transition-all"
                                :class="subMonths == 12 ? 'bg-blue-600 border-blue-600 text-white' : 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300'">
                            ۱ ساله (۱۲ ماه)
                        </button>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">یا تعداد ماه دلخواه:</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="months" min="1" max="120" x-model="subMonths"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 tabular-nums">
                            <span class="text-xs text-slate-500 font-bold whitespace-nowrap">ماه اعتبار</span>
                        </div>
                    </div>
                </div>

                {{-- Option 3: Exact Date --}}
                <div x-show="subActionType === 'exact_date'" class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">انتخاب تاریخ پایان اعتبار (میلادی):</label>
                    <input type="date" name="exact_date" x-model="subExactDate"
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 text-left" dir="ltr">
                    <p class="text-[11px] text-slate-400">تاریخ انقضا تا پایان ساعت ۲۳:۵۹ روز انتخاب‌شده تنظیم خواهد شد.</p>
                </div>

                {{-- Special Quick Actions: Lifetime / Expire Now --}}
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                    <button type="button" @click="subActionType = 'lifetime'"
                            class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5"
                            :class="subActionType === 'lifetime' ? 'bg-indigo-600 text-white' : 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 hover:bg-indigo-100'">
                        <i data-lucide="infinity" class="w-4 h-4"></i>
                        <span>اعطای اشتراک دائمی (نامحدود)</span>
                    </button>

                    <button type="button" @click="subActionType = 'expire_now'"
                            class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5"
                            :class="subActionType === 'expire_now' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300 hover:bg-rose-100'">
                        <i data-lucide="alert-octagon" class="w-4 h-4"></i>
                        <span>منقضی کردن فوری</span>
                    </button>
                </div>

                {{-- Explanation of current selection --}}
                <div class="p-3 bg-blue-50/70 dark:bg-blue-950/30 rounded-xl text-xs text-blue-800 dark:text-blue-300 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 shrink-0 text-blue-500"></i>
                    <template x-if="subActionType === 'add_days'">
                        <span>اعتبار کاربر به میزان <b x-text="subDays"></b> روز تمدید خواهد شد.</span>
                    </template>
                    <template x-if="subActionType === 'add_months'">
                        <span>اعتبار کاربر به میزان <b x-text="subMonths"></b> ماه تمدید خواهد شد.</span>
                    </template>
                    <template x-if="subActionType === 'exact_date'">
                        <span>تاریخ انقضای کاربر بر روی روز انتخاب شده تنظیم خواهد شد.</span>
                    </template>
                    <template x-if="subActionType === 'lifetime'">
                        <span>کاربر دسترسی دائمی بدون محدودیت زمانی و بدون انقضا دریافت می‌کند.</span>
                    </template>
                    <template x-if="subActionType === 'expire_now'">
                        <span class="text-rose-600 font-bold">اشتراک کاربر بلافاصله منقضی و دسترسی پنل مسدود می‌شود.</span>
                    </template>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-500/20">
                        ثبت و اعمال تغییرات اشتراک
                    </button>
                    <button type="button" @click="showExtendModal = false" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-xl text-sm border border-slate-200 dark:border-slate-700">
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
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-md overflow-hidden shadow-2xl"
             @click.away="showPasswordModal = false">
            
            {{-- Modal Header --}}
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
                        <i data-lucide="key-round" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base">تخصیص رمز عبور جدید</h3>
                </div>
                <button @click="showPasswordModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
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
                    <input type="password" name="password" required minlength="4" placeholder="حداقل ۴ کاراکتر یا رقم (مثلاً ۱۲۳۴)"
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 text-left" dir="ltr">
                </div>

                {{-- Confirm Password Input --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">تکرار رمز عبور جدید:</label>
                    <input type="password" name="password_confirmation" required minlength="4" placeholder="تکرار رمز عبور"
                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 text-left" dir="ltr">
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-500/20">
                        ذخیره رمز عبور جدید
                    </button>
                    <button type="button" @click="showPasswordModal = false" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-xl text-sm border border-slate-200 dark:border-slate-700">
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
        searchQuery: '',
        activeTab: 'all',
        showExtendModal: false,
        showPasswordModal: false,
        targetUserId: null,
        targetUserName: '',
        targetUserExpiryText: '',
        copiedId: null,

        // Subscription State
        subActionType: 'add_months',
        subDays: 14,
        subMonths: 1,
        subExactDate: '',

        copyShopLink(username, id) {
            const url = window.location.origin + '/' + username;
            navigator.clipboard.writeText(url).then(() => {
                this.copiedId = id;
                setTimeout(() => { this.copiedId = null; }, 2000);
            });
        },

        openExtendModal(userId, name, expiryText, rawExpiry) {
            this.targetUserId = userId;
            this.targetUserName = name;
            this.targetUserExpiryText = expiryText;
            this.subActionType = 'add_months';
            this.subMonths = 1;
            this.subDays = 14;
            this.subExactDate = rawExpiry ? rawExpiry.split('T')[0] : '';
            this.showExtendModal = true;
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        },

        openPasswordModal(userId, name) {
            this.targetUserId = userId;
            this.targetUserName = name;
            this.showPasswordModal = true;
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        },

        filterMatch(name, username, phone, statusCat) {
            const q = this.searchQuery.trim().toLowerCase();
            const matchesSearch = !q || 
                name.includes(q) || 
                username.includes(q) || 
                phone.includes(q);

            let matchesTab = true;
            if (this.activeTab === 'active') {
                matchesTab = (statusCat === 'active' || statusCat === 'lifetime');
            } else if (this.activeTab === 'pending') {
                matchesTab = (statusCat === 'pending');
            } else if (this.activeTab === 'expired') {
                matchesTab = (statusCat === 'expired');
            } else if (this.activeTab === 'lifetime') {
                matchesCat = (statusCat === 'lifetime');
            }

            return matchesSearch && matchesTab;
        }
    }
}
</script>
@endpush
