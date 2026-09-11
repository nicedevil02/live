@extends('admin.layouts.app')

@section('title', 'مدیریت مالی، تراکنش‌ها و کدهای تخفیف')

@section('content')
<div x-data="transactionsPage()" class="space-y-8 pb-12">
    {{-- هدر صفحه و دکمه‌های اقدام سریع --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white flex items-center gap-3">
                <i data-lucide="wallet" class="w-8 h-8 text-amber-500"></i>
                <span>پرتال جامع مالی و تراکنش‌های طلالایو</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                گزارش بلادرنگ درآمدها، تراکنش‌های بانکی شاپرک، ثبت پرداخت‌های دستی کارت‌به‌کارت و مدیریت کدهای تخفیف.
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <button @click="openManualModal = true" class="px-4 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all shadow-md shadow-amber-500/20 flex items-center gap-2 cursor-pointer">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>ثبت فیش کارت‌به‌کارت (دستی)</span>
            </button>

            <button @click="openCouponModal = true" class="px-4 py-2.5 rounded-2xl bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-bold text-xs transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                <i data-lucide="ticket-percent" class="w-4 h-4 text-amber-400"></i>
                <span>مدیریت کدهای تخفیف ({{ $coupons->count() }})</span>
            </button>
        </div>
    </div>

    {{-- پیام‌های سیستم --}}
    @if(session('success'))
        <div class="rounded-2xl bg-emerald-500/15 border border-emerald-500/30 p-4 text-emerald-200 text-sm flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-2xl bg-rose-500/15 border border-rose-500/30 p-4 text-rose-200 text-sm flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-400 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="rounded-2xl bg-rose-500/15 border border-rose-500/30 p-4 text-rose-200 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- کارت‌های آمار و شاخص‌های مالی (KPIs) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- درآمد کل --}}
        <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">مجموع درآمد کل</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center font-black">
                    <i data-lucide="coins" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ number_format($totalIncome) }}
                    <span class="text-xs font-bold text-slate-400 font-sans">تومان</span>
                </div>
                <div class="text-[11px] text-slate-400 mt-1">
                    از ابتدای راه‌اندازی سامانه
                </div>
            </div>
        </div>

        {{-- درآمد ماه جاری --}}
        <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">درآمد ماه جاری</span>
                <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center font-black">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-black text-amber-500 tracking-tight">
                    {{ number_format($thisMonthIncome) }}
                    <span class="text-xs font-bold text-slate-400 font-sans">تومان</span>
                </div>
                <div class="text-[11px] text-slate-400 mt-1">
                    در ۳۰ روز اخیر
                </div>
            </div>
        </div>

        {{-- تعداد پرداخت‌های موفق --}}
        <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">تراکنش‌های موفق</span>
                <div class="w-10 h-10 rounded-2xl bg-blue-500/10 text-blue-500 flex items-center justify-center font-black">
                    <i data-lucide="check-check" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ number_format($paidCount) }}
                    <span class="text-xs font-bold text-slate-400 font-sans">تراکنش</span>
                </div>
                <div class="text-[11px] text-slate-400 mt-1">
                    پرداخت تایید شده در شاپرک
                </div>
            </div>
        </div>

        {{-- مشترکین فعال --}}
        <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">مشترکین فعال سامانه</span>
                <div class="w-10 h-10 rounded-2xl bg-purple-500/10 text-purple-500 flex items-center justify-center font-black">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    {{ number_format($activeSubscribersCount) }}
                    <span class="text-xs font-bold text-slate-400 font-sans">طلافروشی</span>
                </div>
                <div class="text-[11px] text-emerald-500 font-bold mt-1">
                    دارای اشتراک یا دوره آزمایشی فعال
                </div>
            </div>
        </div>
    </div>

    {{-- نوار فیلتر و جستجوی پیشرفته --}}
    <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.transactions.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5">جستجو در فاکتور یا مشتری:</label>
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="شماره فاکتور، پیگیری، نام یا موبایل..."
                           class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-amber-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5">وضعیت پرداخت:</label>
                <select name="status" class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-amber-500">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>پرداخت شده (موفق)</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>در انتظار پرداخت</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>ناموفق / لغو شده</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5">درگاه یا روش پرداخت:</label>
                <select name="gateway" class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-amber-500">
                    <option value="">همه روش‌ها</option>
                    <option value="card_to_card" {{ request('gateway') === 'card_to_card' ? 'selected' : '' }}>کارت‌به‌کارت (فیش کاربران)</option>
                    <option value="manual" {{ request('gateway') === 'manual' ? 'selected' : '' }}>ثبت دستی توسط مدیریت</option>
                    <option value="zarinpal" {{ request('gateway') === 'zarinpal' ? 'selected' : '' }}>زرین‌پال</option>
                    <option value="zibal" {{ request('gateway') === 'zibal' ? 'selected' : '' }}>زیبال</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer shadow-sm">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>اعمال فیلتر</span>
                </button>
                @if(request()->anyFilled(['search', 'status', 'gateway']))
                    <a href="{{ route('admin.transactions.index') }}" class="py-2.5 px-3 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold transition-all flex items-center justify-center">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- جدول لیست کلیه تراکنش‌ها --}}
    <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                <i data-lucide="list-ordered" class="w-5 h-5 text-amber-500"></i>
                <span>فهرست تراکنش‌های ثبت شده در سیستم</span>
            </h2>
            <span class="text-xs text-slate-400">تعداد نتایج: {{ $payments->total() }} مورد</span>
        </div>

        @if($payments->isEmpty())
            <div class="py-12 text-center text-slate-400">
                <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                <p class="text-sm font-bold">هیچ تراکنشی مطابق با فیلترهای انتخابی یافت نشد.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400">
                            <th class="py-3 px-3">فاکتور</th>
                            <th class="py-3 px-3">مشتری / طلافروشی</th>
                            <th class="py-3 px-3">بسته</th>
                            <th class="py-3 px-3">مبلغ دریافتی</th>
                            <th class="py-3 px-3">تخفیف</th>
                            <th class="py-3 px-3">درگاه</th>
                            <th class="py-3 px-3">شماره پیگیری / فیش</th>
                            <th class="py-3 px-3">تاریخ پرداخت</th>
                            <th class="py-3 px-3 text-center">وضعیت</th>
                            <th class="py-3 px-3 text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3.5 px-3 font-mono font-bold text-slate-900 dark:text-slate-200" dir="ltr">
                                    {{ $payment->invoice_no }}
                                </td>
                                <td class="py-3.5 px-3">
                                    <div class="font-bold text-slate-800 dark:text-slate-200">{{ $payment->user?->name ?? 'کاربر حذف شده' }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono" dir="ltr">{{ $payment->user?->phone ?? '---' }}</div>
                                </td>
                                <td class="py-3.5 px-3 font-bold text-slate-700 dark:text-slate-300">
                                    {{ $payment->plan?->name ?? 'سفارشی' }}
                                </td>
                                <td class="py-3.5 px-3 font-bold text-amber-500 text-sm">
                                    {{ number_format($payment->amount) }} <span class="text-[10px] text-slate-400">تومان</span>
                                </td>
                                <td class="py-3.5 px-3 text-slate-500">
                                    @if($payment->discount_amount > 0)
                                        <span class="text-emerald-500 font-bold">-{{ number_format($payment->discount_amount) }}</span>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                        {{ $payment->gateway_name }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-3">
                                    @if($payment->receipt_url)
                                        <button type="button"
                                                @click="viewReceipt('{{ $payment->receipt_url }}', '{{ $payment->invoice_no }}', '{{ $payment->user?->name }}', '{{ number_format($payment->amount) }}')"
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 text-xs font-bold transition-all cursor-pointer">
                                            <i data-lucide="image" class="w-3.5 h-3.5"></i>
                                            <span>مشاهده فیش</span>
                                        </button>
                                    @endif
                                    <div class="font-mono text-[11px] text-slate-600 dark:text-slate-400 mt-1" dir="ltr">
                                        {{ $payment->reference_id ?? '---' }}
                                        @if($payment->card_pan)
                                            <span class="text-[10px] text-slate-400">({{ $payment->card_pan }}****)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-3 text-slate-500 font-mono text-[11px]">
                                    {{ $payment->paid_at ? \App\Models\User::toJalali($payment->paid_at) : ($payment->created_at ? \App\Models\User::toJalali($payment->created_at) : 'ثبت نشده') }}
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black border {{ $payment->status_badge_class }}">
                                        {{ $payment->status_label }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        @if($payment->status === 'pending')
                                            {{-- دکمه تایید فیش و فعال‌سازی آنی اشتراک --}}
                                            <form action="{{ route('admin.transactions.approve', $payment->id) }}" method="POST" onsubmit="return confirm('آیا از تایید این فیش و فعال‌سازی اشتراک {{ $payment->plan?->name ?? 'کاربر' }} برای {{ $payment->user?->name }} اطمینان دارید؟');">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-600 dark:text-emerald-400 font-black text-xs transition-all cursor-pointer"
                                                        title="تایید فیش و فعال‌سازی اشتراک">
                                                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                                    <span>تایید</span>
                                                </button>
                                            </form>

                                            {{-- دکمه رد فیش --}}
                                            <form action="{{ route('admin.transactions.reject', $payment->id) }}" method="POST" onsubmit="return confirm('آیا از رد این فیش واریزی اطمینان دارید؟');">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-xl bg-rose-500/15 hover:bg-rose-500/25 text-rose-600 dark:text-rose-400 font-bold text-xs transition-all cursor-pointer"
                                                        title="رد فیش">
                                                    <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                                    <span>رد</span>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.subscription.invoice', $payment->id) }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition-all">
                                            <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                            <span>فاکتور</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

    {{-- مودال ثبت پرداخت کارت‌به‌کارت (دستی) --}}
    <div x-show="openManualModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4"
         x-cloak>
        <div @click.away="openManualModal = false" class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 max-w-lg w-full p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center font-bold">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">ثبت پرداخت کارت‌به‌کارت</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">تمدید فوری اعتبار و ارسال پیامک تایید برای مشتری</p>
                    </div>
                </div>
                <button @click="openManualModal = false" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.transactions.manual') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">انتخاب طلافروشی (کاربر):</label>
                    <select name="user_id" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-amber-500">
                        <option value="">-- انتخاب کاربر --</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->phone }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">بسته اشتراک خریداری‌شده:</label>
                    <select name="plan_id" @change="updateManualAmount($event.target.value)" required class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-amber-500">
                        <option value="">-- انتخاب بسته --</option>
                        @foreach($plans as $p)
                            <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }} - {{ number_format($p->price) }} تومان</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">مبلغ واریز شده (تومان):</label>
                    <input type="number"
                           name="amount"
                           x-model="manualAmount"
                           required
                           class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs font-mono focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">کد رهگیری / شماره فیش کارت‌به‌کارت:</label>
                    <input type="text"
                           name="reference_id"
                           placeholder="مثال: 982143 یا 14030911002"
                           dir="ltr"
                           required
                           class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs font-mono focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">توضیحات (اختیاری):</label>
                    <textarea name="description" rows="2" placeholder="واریز به حساب سپه / بانک ملی..." class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-amber-500"></textarea>
                </div>

                <div class="pt-2 flex items-center justify-end gap-3">
                    <button type="button" @click="openManualModal = false" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition-all">
                        انصراف
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all shadow-md shadow-amber-500/20">
                        ثبت و فعال‌سازی اشتراک
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- مودال مدیریت و ایجاد کدهای تخفیف --}}
    <div x-show="openCouponModal"
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4"
         x-cloak>
        <div @click.away="openCouponModal = false" class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 max-w-2xl w-full p-6 sm:p-8 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center font-bold">
                        <i data-lucide="ticket-percent" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">مدیریت کدهای تخفیف سامانه</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">ایجاد کوپن جدید و نظارت بر کدهای موجود</p>
                    </div>
                </div>
                <button @click="openCouponModal = false" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- فرم ایجاد کد تخفیف جدید --}}
            <form action="{{ route('admin.transactions.coupons.store') }}" method="POST" class="bg-slate-50 dark:bg-slate-800/60 p-5 rounded-2xl border border-slate-200 dark:border-slate-700/60 space-y-4">
                @csrf
                <div class="text-xs font-black text-slate-900 dark:text-white mb-2">ایجاد کد تخفیف جدید:</div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">کد کوپن (لاتین):</label>
                        <input type="text" name="code" placeholder="مثلاً TALALIVE20" dir="ltr" required class="w-full uppercase font-mono px-3.5 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">عنوان / مناسبت (اختیاری):</label>
                        <input type="text" name="title" placeholder="تخفیف ویژه نوروز..." class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">نوع تخفیف:</label>
                        <select name="type" required class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                            <option value="percent">درصدی (%)</option>
                            <option value="fixed">مبلغ ثابت (تومان)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">مقدار تخفیف:</label>
                        <input type="number" name="value" placeholder="مثلاً 15 یا 200000" required class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs font-mono">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">سقف تخفیف درصدی (تومان، اختیاری):</label>
                        <input type="number" name="max_discount" placeholder="مثلاً 500000" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs font-mono">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">حداکثر دفعات استفاده (اختیاری):</label>
                        <input type="number" name="usage_limit" placeholder="مثلاً 50" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs font-mono">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all shadow-sm">
                        افزودن کد تخفیف
                    </button>
                </div>
            </form>

            {{-- لیست کدهای تخفیف موجود --}}
            <div class="space-y-3">
                <div class="text-xs font-black text-slate-900 dark:text-white">کدهای تخفیف تعریف شده:</div>
                <div class="overflow-x-auto">
                    <table class="w-full text-right text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-500">
                                <th class="py-2 px-2">کد</th>
                                <th class="py-2 px-2">نوع</th>
                                <th class="py-2 px-2">مقدار</th>
                                <th class="py-2 px-2">استفاده شده</th>
                                <th class="py-2 px-2 text-center">وضعیت</th>
                                <th class="py-2 px-2 text-center">تغییر</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            @foreach($coupons as $c)
                                <tr>
                                    <td class="py-2.5 px-2 font-mono font-bold text-slate-900 dark:text-white" dir="ltr">
                                        {{ $c->code }}
                                    </td>
                                    <td class="py-2.5 px-2">
                                        {{ $c->type === 'percent' ? 'درصدی' : 'مبلغ ثابت' }}
                                    </td>
                                    <td class="py-2.5 px-2 font-bold text-amber-500">
                                        {{ $c->type === 'percent' ? $c->value . '%' : number_format($c->value) . ' تومان' }}
                                    </td>
                                    <td class="py-2.5 px-2 font-mono">
                                        {{ $c->used_count }} {{ $c->usage_limit ? 'از ' . $c->usage_limit : '' }}
                                    </td>
                                    <td class="py-2.5 px-2 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $c->is_active ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }}">
                                            {{ $c->is_active ? 'فعال' : 'غیرفعال' }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-2 text-center">
                                        <form action="{{ route('admin.transactions.coupons.toggle', $c->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[11px] px-2 py-1 rounded bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-colors">
                                                {{ $c->is_active ? 'غیرفعال‌سازی' : 'فعال‌سازی' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- مودال مشاهده فیش واریزی کاربر در سایز بزرگ --}}
    <div x-show="showReceiptModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/85 backdrop-blur-sm flex items-center justify-center p-4"
         x-cloak>
        <div @click.away="showReceiptModal = false" class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 max-w-xl w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="file-check" class="w-5 h-5 text-amber-500"></i>
                    <div>
                        <h3 class="text-sm font-black text-slate-900 dark:text-white">
                            تصویر فیش واریزی: <span class="font-mono text-amber-500" x-text="receiptModalInvoice"></span>
                        </h3>
                        <div class="text-[11px] text-slate-400 mt-0.5">
                            مشتری: <span class="font-bold text-slate-700 dark:text-slate-200" x-text="receiptModalUser"></span> | مبلغ: <span class="font-bold text-amber-500" x-text="receiptModalAmount"></span> تومان
                        </div>
                    </div>
                </div>
                <button type="button" @click="showReceiptModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="rounded-2xl overflow-hidden bg-slate-950 flex items-center justify-center max-h-[70vh] border border-slate-800">
                <img :src="receiptModalImage" class="max-w-full max-h-[65vh] object-contain rounded-xl" alt="تصویر فیش">
            </div>

            <div class="flex items-center justify-between pt-2">
                <a :href="receiptModalImage" download target="_blank" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>دانلود تصویر فیش</span>
                </a>
                <button type="button" @click="showReceiptModal = false" class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs">
                    بستن پنجره
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function transactionsPage() {
    return {
        openManualModal: false,
        openCouponModal: false,
        manualAmount: 3990000,

        // لایت‌باکس فیش
        showReceiptModal: false,
        receiptModalImage: '',
        receiptModalInvoice: '',
        receiptModalUser: '',
        receiptModalAmount: '',

        init() {
            this.$nextTick(() => {
                if (window.lucide) { window.lucide.createIcons(); }
            });
        },

        viewReceipt(url, invoice, user, amount) {
            this.receiptModalImage = url;
            this.receiptModalInvoice = invoice;
            this.receiptModalUser = user;
            this.receiptModalAmount = amount;
            this.showReceiptModal = true;
            this.$nextTick(() => {
                if (window.lucide) { window.lucide.createIcons(); }
            });
        },

        updateManualAmount(planId) {
            const selectEl = document.querySelector('select[name="plan_id"]');
            const selectedOption = selectEl.options[selectEl.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            if (price) {
                this.manualAmount = parseInt(price);
            }
        }
    }
}
</script>
@endsection
