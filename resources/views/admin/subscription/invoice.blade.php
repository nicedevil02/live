@extends('admin.layouts.app')

@section('title', 'فاکتور رسمی دیجیتال طلالایو - ' . $payment->invoice_no)

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-12">
    {{-- نوار ابزار بالا (تنها در صفحه نمایش - در چاپ مخفی می‌شود) --}}
    <div class="print:hidden flex flex-wrap items-center justify-between gap-4 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <a href="{{ route('admin.subscription.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-amber-500 transition-colors">
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
            <span>بازگشت به پرتال اشتراک</span>
        </a>

        <div class="flex items-center gap-2.5">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-all shadow-md shadow-amber-500/20 flex items-center gap-2 cursor-pointer">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>چاپ فاکتور رسمی (A4)</span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs transition-all flex items-center gap-2">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                <span>داشبورد مدیریت</span>
            </a>
        </div>
    </div>

    {{-- برگه فاکتور اصلی (طراحی تمیز، شیک و قابل چاپ استاندارد) --}}
    <div class="bg-white text-slate-900 rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-2xl relative overflow-hidden print:p-0 print:border-none print:shadow-none print:rounded-none" id="invoice-sheet">
        {{-- نوار و واترمارک رسمی --}}
        <div class="flex items-center justify-between border-b-2 border-amber-500 pb-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-amber-500 flex items-center justify-center text-slate-950 font-black text-2xl shadow-md">
                    TL
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-slate-950">سامانه طلالایو</h1>
                    <p class="text-xs text-slate-500 mt-0.5">پلتفرم تابلوی هوشمند نرخ طلا و مسکوکات</p>
                </div>
            </div>

            <div class="text-left" dir="ltr">
                <div class="inline-block px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                    {{ $payment->status === 'paid' ? 'PAID & VERIFIED' : strtoupper($payment->status) }}
                </div>
                <div class="text-xs font-mono font-bold text-slate-800 mt-1.5">
                    NO: {{ $payment->invoice_no }}
                </div>
                <div class="text-[11px] text-slate-500 font-sans mt-0.5">
                    {{ $jalaliPaidAt }}
                </div>
            </div>
        </div>

        {{-- مشخصات خریدار و فروشنده --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-slate-50 rounded-2xl p-6 border border-slate-200/80 mb-8 text-xs">
            <div class="space-y-2">
                <div class="font-black text-amber-600 text-sm mb-2 flex items-center gap-1.5">
                    <i data-lucide="building-2" class="w-4 h-4"></i>
                    <span>اطلاعات ارائه‌دهنده خدمت (فروشنده):</span>
                </div>
                <div><span class="text-slate-500">نام تجاری:</span> <strong class="text-slate-900">سامانه هوشمند طلالایو (TalaLive.ir)</strong></div>
                <div><span class="text-slate-500">تلفن پشتیبانی:</span> <strong class="text-slate-900" dir="ltr">۰۹۱۸۷۰۰۹۰۶۴</strong></div>
                <div><span class="text-slate-500">پشتیبانی برخط:</span> <strong class="text-slate-900">روبیکا (@talalive)</strong></div>
                <div><span class="text-slate-500">آدرس وب‌سایت:</span> <strong class="text-slate-900" dir="ltr">https://talalive.ir</strong></div>
            </div>

            <div class="space-y-2">
                <div class="font-black text-amber-600 text-sm mb-2 flex items-center gap-1.5">
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                    <span>مشخصات مشترک (خریدار):</span>
                </div>
                <div><span class="text-slate-500">نام مشتری / گالری:</span> <strong class="text-slate-900">{{ $payment->user?->name ?? 'مشتری گرامی' }}</strong></div>
                <div><span class="text-slate-500">شماره موبایل:</span> <strong class="text-slate-900 font-mono" dir="ltr">{{ $payment->user?->phone ?? '---' }}</strong></div>
                <div><span class="text-slate-500">شناسه حساب کاربری:</span> <strong class="text-slate-900 font-mono" dir="ltr">#{{ $payment->user?->id }}</strong></div>
                <div><span class="text-slate-500">آی‌پی پرداخت‌کننده:</span> <span class="text-slate-600 font-mono" dir="ltr">{{ $payment->ip_address ?? '127.0.0.1' }}</span></div>
            </div>
        </div>

        {{-- جدول شرح آیتم‌های فاکتور --}}
        <div class="overflow-x-auto mb-8">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 font-black border-y border-slate-200">
                        <th class="py-3 px-4">ردیف</th>
                        <th class="py-3 px-4">شرح خدمات / کالا</th>
                        <th class="py-3 px-4 text-center">مدت زمان</th>
                        <th class="py-3 px-4">مبلغ پایه (تومان)</th>
                        <th class="py-3 px-4">تخفیف (تومان)</th>
                        <th class="py-3 px-4 text-left">مبلغ خالص (تومان)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-4 px-4 font-bold">۱</td>
                        <td class="py-4 px-4">
                            <div class="font-black text-slate-900 text-sm">
                                {{ $payment->plan?->name ?? 'اشتراک تابلوی طلالایو' }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                شامل نرخ لحظه‌ای مظنه طلا و ارز، اتصال نامحدود تلویزیون مغازه، فرمول سود گالری و اسلایدر ویترین
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center font-bold">
                            {{ $payment->plan?->duration_days ?? 30 }} روز
                        </td>
                        <td class="py-4 px-4 font-mono font-bold text-slate-800">
                            {{ number_format(($payment->plan?->price) ?? $payment->amount) }}
                        </td>
                        <td class="py-4 px-4 font-mono font-bold text-emerald-600">
                            {{ number_format($payment->discount_amount) }}
                        </td>
                        <td class="py-4 px-4 text-left font-mono font-black text-slate-900 text-sm">
                            {{ number_format($payment->amount) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- کادر جمع مبالغ و اطلاعات شاپرک --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-end border-t border-slate-200 pt-6 mb-8 text-xs">
            {{-- اطلاعات تراکنش شاپرک --}}
            <div class="space-y-2 bg-slate-50 p-4 rounded-xl border border-slate-200/80">
                <div class="font-bold text-slate-700 flex items-center gap-1">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                    <span>مشخصات اعتبارسنجی بانکی:</span>
                </div>
                <div><span class="text-slate-500">درگاه پرداخت:</span> <strong class="text-slate-800">{{ $payment->gateway_name }}</strong></div>
                <div><span class="text-slate-500">کد پیگیری شاپرک (RefID):</span> <strong class="font-mono text-slate-900" dir="ltr">{{ $payment->reference_id ?? '---' }}</strong></div>
                <div><span class="text-slate-500">شناسه پیگیری سیستمی (Authority):</span> <span class="font-mono text-slate-600 text-[10px]" dir="ltr">{{ $payment->authority ?? '---' }}</span></div>
                <div><span class="text-slate-500">تاریخ اعتبار جدید حساب:</span> <strong class="text-emerald-700 font-bold">{{ $jalaliUserExpiry ?? 'فعال' }}</strong></div>
            </div>

            {{-- فاکتور جمع نهایی --}}
            <div class="space-y-2.5">
                <div class="flex justify-between items-center text-slate-600">
                    <span>جمع کل ناخالص:</span>
                    <span class="font-mono font-bold text-slate-900">{{ number_format(($payment->plan?->price) ?? $payment->amount) }} تومان</span>
                </div>
                <div class="flex justify-between items-center text-emerald-600 font-bold">
                    <span>تخفیف کوپن:</span>
                    <span class="font-mono">- {{ number_format($payment->discount_amount) }} تومان</span>
                </div>
                <div class="flex justify-between items-center text-slate-600">
                    <span>مالیات بر ارزش افزوده:</span>
                    <span class="font-mono font-bold text-slate-900">۰ تومان (معاف)</span>
                </div>
                <div class="border-t-2 border-slate-900 pt-2 flex justify-between items-baseline">
                    <span class="text-sm font-black text-slate-950">مبلغ نهایی پرداخت شده:</span>
                    <span class="text-xl font-black text-amber-600 font-mono">{{ number_format($payment->amount) }} تومان</span>
                </div>
            </div>
        </div>

        {{-- امضا و مهر دیجیتال سامانه --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 border-t border-slate-200 pt-8 mt-8">
            <div class="text-[11px] text-slate-500 max-w-md leading-relaxed">
                این فاکتور رسمی به صورت الکترونیکی و مطابق با قوانین تجارت الکترونیک کشور صادر شده است و دارای اصالت دیجیتال و اعتبار قانونی می‌باشد.
            </div>

            <div class="text-center">
                <div class="inline-block p-3 border-2 border-amber-500/40 rounded-2xl bg-amber-50/50 text-center">
                    <div class="text-xs font-black text-amber-600">مهر دیجیتال طلالایو</div>
                    <div class="text-[10px] text-slate-500 mt-1">تایید پرداخت و فعال‌سازی آنی</div>
                    <div class="text-[10px] font-mono text-emerald-700 font-bold mt-0.5">VERIFIED & ACTIVE</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
