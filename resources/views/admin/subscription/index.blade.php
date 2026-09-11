@extends('admin.layouts.app')

@section('title', 'خرید و تمدید اشتراک سامانه طلالایو')

@section('content')
<div x-data="subscriptionPage()" class="space-y-8 pb-12">
    {{-- هدر صفحه و وضعیت جاری اشتراک --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-850 to-slate-950 border border-slate-800/80 p-6 sm:p-8 shadow-2xl">
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-black">
                    <i data-lucide="crown" class="w-3.5 h-3.5"></i>
                    <span>سامانه هوشمند اشتراک و تمدید طلالایو</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    ارتقا و تمدید اشتراک تابلو هوشمند طلافروشی
                </h1>
                <p class="text-sm text-slate-400 max-w-2xl leading-relaxed">
                    با انتخاب یکی از بسته‌های ویژه، تابلوی اختصاصی تلویزیون، قیمت‌گذاری خودکار مظنه و ویترین آنلاین مغازه خود را فعال و پایدار نگه دارید.
                </p>
            </div>

            {{-- کارت خلاصه وضعیت فعلی کاربر --}}
            <div class="w-full lg:w-auto bg-slate-800/80 backdrop-blur-md rounded-2xl border border-slate-700/60 p-4 sm:p-5 flex items-center gap-4 shrink-0 shadow-lg">
                <div class="w-14 h-14 rounded-2xl {{ $daysRemaining > 0 ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/15 text-rose-400 border border-rose-500/30' }} flex items-center justify-center font-black text-2xl shrink-0">
                    @if($daysRemaining > 0)
                        <i data-lucide="shield-check" class="w-7 h-7"></i>
                    @else
                        <i data-lucide="alert-triangle" class="w-7 h-7"></i>
                    @endif
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">وضعیت اشتراک تابلوی شما:</div>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-base font-black {{ $daysRemaining > 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                            {{ $daysRemaining > 0 ? 'فعال و متصل' : 'منقضی شده' }}
                        </span>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $daysRemaining > 0 ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300' }} font-bold">
                            {{ $daysRemaining }} روز باقی‌مانده
                        </span>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1">
                        تاریخ انقضا: <span class="font-bold text-slate-200">{{ $jalaliExpiry ?? 'نامشخص' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- تضمین عدم سوختن روزها (No Day Lost) --}}
        <div class="mt-6 pt-5 border-t border-slate-800/80 flex items-center gap-2.5 text-xs text-amber-300/90">
            <i data-lucide="sparkles" class="w-4 h-4 text-amber-400 shrink-0"></i>
            <span class="font-medium">
                <strong>تضمین طلایی حفظ روزها:</strong> در صورت تمدید در هر زمان، تمامی روزهای باقیمانده کنونی شما حفظ شده و مدت زمان بسته جدید به انتهای آن افزوده خواهد شد.
            </span>
        </div>
    </div>

    {{-- پیام‌های سیستم (فلش مسیج‌ها) --}}
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

    {{-- فرم سفارش و خرید اشتراک --}}
    <form action="{{ route('admin.subscription.checkout') }}" method="POST" @submit="isSubmitting = true">
        @csrf
        <input type="hidden" name="plan_id" :value="selectedPlanId">
        <input type="hidden" name="coupon_code" :value="appliedCouponCode">
        <input type="hidden" name="gateway" :value="selectedGateway">

        <div class="space-y-6">
            {{-- انتخاب پکیج (Decoy Pricing Matrix) --}}
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i data-lucide="package" class="w-5 h-5 text-amber-500"></i>
                            <span>۱. انتخاب بسته اشتراک تابلو طلالایو</span>
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            تمامی بسته‌ها شامل کلیه امکانات حرفه‌ای بدون هیچ‌گونه محدودیت فنی هستند.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($plans as $plan)
                        @php
                            $isYearly = $plan->duration_days >= 365;
                            $monthlyEquivalent = round($plan->price / ($plan->duration_days / 30));
                        @endphp
                        <div @click="selectPlan({{ $plan->id }}, {{ $plan->price }})"
                             class="relative cursor-pointer rounded-3xl p-6 transition-all duration-300 flex flex-col justify-between border select-none"
                             :class="selectedPlanId == {{ $plan->id }} 
                                ? 'bg-gradient-to-b from-amber-500/10 via-amber-500/5 to-transparent border-amber-500 dark:border-amber-400 shadow-xl shadow-amber-500/15 ring-2 ring-amber-500/50 -translate-y-1' 
                                : 'bg-white dark:bg-slate-900/90 border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 hover:shadow-md'">
                            
                            {{-- برچسب ویژه --}}
                            @if($plan->badge)
                                <div class="absolute -top-3.5 right-6 px-3.5 py-1 rounded-full text-[11px] font-black tracking-wide shadow-md {{ $plan->is_popular ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 shadow-amber-500/30' : 'bg-blue-600 text-white shadow-blue-600/30' }}">
                                    {{ $plan->badge }}
                                </div>
                            @endif

                            <div>
                                {{-- سربرگ پکیج --}}
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-base font-black text-slate-900 dark:text-white">{{ $plan->name }}</h3>
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center border transition-all"
                                         :class="selectedPlanId == {{ $plan->id }} ? 'border-amber-500 bg-amber-500 text-slate-950 font-bold' : 'border-slate-300 dark:border-slate-600'">
                                        <i data-lucide="check" class="w-3.5 h-3.5" x-show="selectedPlanId == {{ $plan->id }}"></i>
                                    </div>
                                </div>

                                {{-- قیمت اصلی پکیج --}}
                                <div class="mt-4 mb-3">
                                    <div class="flex items-baseline gap-1.5">
                                        <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-amber-400 tracking-tight">
                                            {{ number_format($plan->price) }}
                                        </span>
                                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400">تومان</span>
                                    </div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 font-medium">
                                        معادل <span class="font-bold text-slate-700 dark:text-slate-200">{{ number_format($monthlyEquivalent) }}</span> تومان / ماه
                                    </div>
                                </div>

                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-4">
                                    {{ $plan->description ?? 'دسترسی کامل به مظنه لحظه‌ای، فرمول محاسبه سود و اتصال به تلویزیون هوشمند.' }}
                                </p>

                                {{-- امکانات --}}
                                <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-300 border-t border-slate-100 dark:border-slate-800/80 pt-4">
                                    <li class="flex items-center gap-2">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                                        <span>پخش زنده تابلوی تلویزیون</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                                        <span>فرمول‌ساز پیشرفته مظنه طلا</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                                        <span>ویترین و اسلایدر محصولات مغازه</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                                        <span>پشتیبانی اختصاصی در روبیکا و تماس</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800/80">
                                <button type="button" 
                                        class="w-full py-2.5 px-4 rounded-xl text-xs font-black transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                                        :class="selectedPlanId == {{ $plan->id }} 
                                            ? 'bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md shadow-amber-500/25 font-black' 
                                            : 'bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300'">
                                    <span x-text="selectedPlanId == {{ $plan->id }} ? 'انتخاب شده ✓' : 'انتخاب این بسته'"></span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- مرحله ۲ و ۳: کد تخفیف، درگاه پرداخت و تسویه حساب --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pt-4">
                {{-- کد تخفیف و درگاه پرداخت --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- بخش کد تخفیف --}}
                    <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                        <h2 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2 mb-3">
                            <i data-lucide="ticket-percent" class="w-5 h-5 text-amber-500"></i>
                            <span>۲. کد تخفیف دارید؟</span>
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                            در صورت داشتن کوپن یا کد تخفیف سازمانی، آن را وارد کرده و دکمه اعمال را بزنید.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="relative flex-1">
                                <input type="text"
                                       x-model="inputCouponCode"
                                       :disabled="couponApplied"
                                       placeholder="کد تخفیف (مثلاً TALALIVE10)"
                                       dir="ltr"
                                       class="w-full uppercase font-mono tracking-wider px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-amber-500 dark:focus:border-amber-400 disabled:opacity-60 transition-all">
                            </div>

                            <button type="button"
                                    @click="applyCoupon()"
                                    :disabled="couponLoading || couponApplied || !inputCouponCode.trim()"
                                    class="px-6 py-3 rounded-2xl bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-bold text-xs transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 shrink-0 cursor-pointer">
                                <span x-show="!couponLoading && !couponApplied">اعمال کد</span>
                                <span x-show="couponLoading">در حال بررسی...</span>
                                <span x-show="couponApplied">اعمال شد ✓</span>
                            </button>

                            <button type="button"
                                    x-show="couponApplied"
                                    @click="removeCoupon()"
                                    class="px-4 py-3 rounded-2xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-500 font-bold text-xs transition-all flex items-center justify-center gap-1 shrink-0 cursor-pointer">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                <span>حذف تخفیف</span>
                            </button>
                        </div>

                        {{-- پیام نتیجه تخفیف --}}
                        <div x-show="couponMessage" 
                             class="mt-3 text-xs font-bold p-3 rounded-xl flex items-center gap-2"
                             :class="couponSuccess ? 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-500 border border-rose-500/20'"
                             x-cloak>
                            <i :data-lucide="couponSuccess ? 'check-circle' : 'alert-circle'" class="w-4 h-4 shrink-0"></i>
                            <span x-text="couponMessage"></span>
                        </div>
                    </div>

                    {{-- بخش انتخاب درگاه پرداخت --}}
                    <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                        <h2 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2 mb-3">
                            <i data-lucide="credit-card" class="w-5 h-5 text-amber-500"></i>
                            <span>۳. درگاه پرداخت اینترنتی شاپرک</span>
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                            پرداخت توسط تمامی کارت‌های عضو شتاب از طریق درگاه‌های شاپرکی مجاز پشتیبانی می‌شود.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- زرین‌پال --}}
                            <div @click="selectedGateway = 'zarinpal'"
                                 class="cursor-pointer rounded-2xl p-4 border transition-all flex items-center justify-between select-none"
                                 :class="selectedGateway == 'zarinpal' 
                                    ? 'bg-amber-500/10 border-amber-500 dark:border-amber-400 ring-2 ring-amber-500/30' 
                                    : 'bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-500 flex items-center justify-center font-black text-sm">
                                        ZP
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-900 dark:text-white">درگاه زرین‌پال</div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400">پرداخت امن شاپرک / زرین‌گیت</div>
                                    </div>
                                </div>
                                <div class="w-5 h-5 rounded-full flex items-center justify-center border"
                                     :class="selectedGateway == 'zarinpal' ? 'border-amber-500 bg-amber-500 text-slate-950' : 'border-slate-400'">
                                    <i data-lucide="check" class="w-3 h-3" x-show="selectedGateway == 'zarinpal'"></i>
                                </div>
                            </div>

                            {{-- زیبال --}}
                            <div @click="selectedGateway = 'zibal'"
                                 class="cursor-pointer rounded-2xl p-4 border transition-all flex items-center justify-between select-none"
                                 :class="selectedGateway == 'zibal' 
                                    ? 'bg-blue-500/10 border-blue-500 dark:border-blue-400 ring-2 ring-blue-500/30' 
                                    : 'bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-500 flex items-center justify-center font-black text-sm">
                                        ZB
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-900 dark:text-white">درگاه زیبال</div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400">اتصال پایدار و تایید آنی شتاب</div>
                                    </div>
                                </div>
                                <div class="w-5 h-5 rounded-full flex items-center justify-center border"
                                     :class="selectedGateway == 'zibal' ? 'border-blue-500 bg-blue-500 text-white' : 'border-slate-400'">
                                    <i data-lucide="check" class="w-3 h-3" x-show="selectedGateway == 'zibal'"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- فاکتور نهایی و دکمه پرداخت --}}
                <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-xl flex flex-col justify-between h-full">
                    <div>
                        <h2 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2 mb-4">
                            <i data-lucide="file-check" class="w-5 h-5 text-amber-500"></i>
                            <span>خلاصه فاکتور پرداخت</span>
                        </h2>

                        <div class="space-y-3 text-xs border-b border-slate-100 dark:border-slate-800 pb-4">
                            <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                                <span>بسته انتخابی:</span>
                                <span class="font-bold text-slate-800 dark:text-slate-200" x-text="selectedPlanName"></span>
                            </div>
                            <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                                <span>مبلغ بسته:</span>
                                <div>
                                    <span class="font-bold text-slate-800 dark:text-slate-200 text-sm" x-text="formatNumber(basePrice)"></span>
                                    <span class="text-[10px]">تومان</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center text-emerald-600 dark:text-emerald-400 font-bold" x-show="discountAmount > 0">
                                <span>تخفیف اعمال شده:</span>
                                <div>
                                    <span>-</span>
                                    <span x-text="formatNumber(discountAmount)"></span>
                                    <span class="text-[10px]">تومان</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                                <span>درگاه انتخابی:</span>
                                <span class="font-bold text-slate-800 dark:text-slate-200" x-text="selectedGateway == 'zarinpal' ? 'زرین‌پال' : 'زیبال'"></span>
                            </div>
                        </div>

                        <div class="py-4">
                            <div class="flex justify-between items-baseline mb-1">
                                <span class="text-sm font-black text-slate-900 dark:text-white">مبلغ نهایی پرداختی:</span>
                                <div class="text-left">
                                    <span class="text-2xl sm:text-3xl font-black text-amber-500 tracking-tight" x-text="formatNumber(finalPrice)"></span>
                                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">تومان</span>
                                </div>
                            </div>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500 leading-relaxed">
                                پس از پرداخت موفق، بلافاصله به سایت برگشته و فاکتور رسمی صادر خواهد شد.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3 pt-4">
                        <button type="submit"
                                :disabled="isSubmitting"
                                class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 hover:from-amber-400 hover:to-amber-400 text-slate-950 font-black text-sm transition-all shadow-xl shadow-amber-500/25 flex items-center justify-center gap-2 cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed">
                            <i data-lucide="shield-check" class="w-5 h-5 text-slate-950" x-show="!isSubmitting"></i>
                            <i data-lucide="loader-2" class="w-5 h-5 animate-spin" x-show="isSubmitting" x-cloak></i>
                            <span x-text="isSubmitting ? 'در حال انتقال به درگاه شاپرک...' : 'پرداخت امن شاپرک و تمدید آنی'"></span>
                        </button>

                        <div class="flex items-center justify-center gap-2 text-[11px] text-slate-400">
                            <i data-lucide="lock" class="w-3.5 h-3.5 text-emerald-500"></i>
                            <span>تراکنش در بستر شاپرک با پروتکل رمزنگاری SSL</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- راهنمای کارت‌به‌کارت و پشتیبانی روبیکا --}}
    <div class="rounded-3xl bg-slate-100 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 p-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center shrink-0">
                <i data-lucide="phone-call" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-slate-900 dark:text-white">امکان پرداخت کارت‌به‌کارت و انتقال مستقیم بانکی</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    در صورت تمایل به واریز فیش کارت‌به‌کارت و دریافت فاکتور رسمی، همکاران ما در روبیکا یا تماس تلفنی در خدمت شما هستند.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
            <a href="tel:09187009064" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-900 dark:text-white text-xs font-bold border border-slate-200 dark:border-slate-700 transition-all flex items-center justify-center gap-1.5 shadow-sm">
                <i data-lucide="phone" class="w-4 h-4 text-amber-500"></i>
                <span>۰۹۱۸۷۰۰۹۰۶۴</span>
            </a>
            <a href="https://rubika.ir/talalive" target="_blank" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-amber-500 hover:opacity-90 text-white text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-md shadow-purple-600/20">
                <img src="/images/logos/rubika.png" onerror="this.src='/icons/icon-72x72.png'" class="w-4 h-4 object-contain rounded-md" alt="روبیکا">
                <span>پشتیبانی روبیکا</span>
            </a>
        </div>
    </div>

    {{-- جدول سوابق پرداخت و فاکتورها --}}
    <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                <i data-lucide="history" class="w-5 h-5 text-amber-500"></i>
                <span>سوابق تراکنش‌ها و فاکتورهای دیجیتال شما</span>
            </h2>
            <span class="text-xs text-slate-400">تعداد کل: {{ $payments->total() }} تراکنش</span>
        </div>

        @if($payments->isEmpty())
            <div class="py-12 text-center text-slate-400">
                <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                <p class="text-sm font-bold">تاکنون هیچ تراکنشی در حساب شما ثبت نشده است.</p>
                <p class="text-xs mt-1 opacity-70">پس از اولین خرید، سوابق و فاکتورهای رسمی شما در این قسمت آرشیو خواهد شد.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400">
                            <th class="py-3 px-3">شماره فاکتور</th>
                            <th class="py-3 px-3">بسته اشتراک</th>
                            <th class="py-3 px-3">مبلغ پرداختی</th>
                            <th class="py-3 px-3">تخفیف</th>
                            <th class="py-3 px-3">درگاه</th>
                            <th class="py-3 px-3">کد پیگیری شاپرک</th>
                            <th class="py-3 px-3">تاریخ پرداخت</th>
                            <th class="py-3 px-3 text-center">وضعیت</th>
                            <th class="py-3 px-3 text-center">فاکتور</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3.5 px-3 font-mono font-bold text-slate-900 dark:text-slate-200" dir="ltr">
                                    {{ $payment->invoice_no }}
                                </td>
                                <td class="py-3.5 px-3 font-bold text-slate-800 dark:text-slate-200">
                                    {{ $payment->plan?->name ?? 'اشتراک طلالایو' }}
                                </td>
                                <td class="py-3.5 px-3 font-bold text-amber-500 text-sm">
                                    {{ number_format($payment->amount) }} <span class="text-[10px] text-slate-400">تومان</span>
                                </td>
                                <td class="py-3.5 px-3 text-slate-500">
                                    @if($payment->discount_amount > 0)
                                        <span class="text-emerald-500 font-bold">{{ number_format($payment->discount_amount) }}</span>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                        {{ $payment->gateway_name }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-3 font-mono text-slate-600 dark:text-slate-400" dir="ltr">
                                    {{ $payment->reference_id ?? '---' }}
                                </td>
                                <td class="py-3.5 px-3 text-slate-500">
                                    {{ $payment->paid_at ? \App\Models\User::toJalali($payment->paid_at) : 'ثبت نشده' }}
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black border {{ $payment->status_badge_class }}">
                                        {{ $payment->status_name }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <a href="{{ route('admin.subscription.invoice', $payment->id) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition-all">
                                        <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                                        <span>مشاهده</span>
                                    </a>
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
</div>

<script>
function subscriptionPage() {
    return {
        plans: @json($plans),
        selectedPlanId: {{ $plans->firstWhere('is_popular', true)?->id ?? $plans->first()?->id ?? 1 }},
        basePrice: {{ $plans->firstWhere('is_popular', true)?->price ?? $plans->first()?->price ?? 3990000 }},
        selectedPlanName: '{{ $plans->firstWhere('is_popular', true)?->name ?? $plans->first()?->name ?? "اشتراک سالانه" }}',
        selectedGateway: 'zarinpal',
        
        // تخفیف
        inputCouponCode: '',
        appliedCouponCode: '',
        discountAmount: 0,
        couponApplied: false,
        couponLoading: false,
        couponSuccess: false,
        couponMessage: '',

        isSubmitting: false,

        init() {
            this.$nextTick(() => {
                if (window.lucide) { window.lucide.createIcons(); }
            });
        },

        get finalPrice() {
            return Math.max(1000, this.basePrice - this.discountAmount);
        },

        selectPlan(id, price) {
            this.selectedPlanId = id;
            this.basePrice = price;
            const p = this.plans.find(item => item.id === id);
            if (p) {
                this.selectedPlanName = p.name;
            }
            if (this.couponApplied && this.appliedCouponCode) {
                this.applyCoupon(true);
            }
            this.$nextTick(() => {
                if (window.lucide) { window.lucide.createIcons(); }
            });
        },

        async applyCoupon(silent = false) {
            const code = this.inputCouponCode.trim();
            if (!code) return;

            if (!silent) {
                this.couponLoading = true;
                this.couponMessage = '';
            }

            try {
                const response = await fetch('{{ route("admin.subscription.apply-coupon") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        code: code,
                        plan_id: this.selectedPlanId
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.discountAmount = data.discount_amount;
                    this.appliedCouponCode = code;
                    this.couponApplied = true;
                    this.couponSuccess = true;
                    this.couponMessage = data.message || `کد تخفیف با موفقیت اعمال شد (${this.formatNumber(data.discount_amount)} تومان کسر شد).`;
                } else {
                    this.discountAmount = 0;
                    this.appliedCouponCode = '';
                    this.couponApplied = false;
                    this.couponSuccess = false;
                    this.couponMessage = data.message || 'کد تخفیف وارد شده نامعتبر یا منقضی است.';
                }
            } catch (err) {
                this.couponSuccess = false;
                this.couponMessage = 'خطا در برقراری ارتباط با سرور. لطفاً مجدداً تلاش فرمایید.';
            } finally {
                this.couponLoading = false;
                this.$nextTick(() => {
                    if (window.lucide) { window.lucide.createIcons(); }
                });
            }
        },

        removeCoupon() {
            this.inputCouponCode = '';
            this.appliedCouponCode = '';
            this.discountAmount = 0;
            this.couponApplied = false;
            this.couponSuccess = false;
            this.couponMessage = '';
        },

        formatNumber(num) {
            return new Intl.NumberFormat('fa-IR').format(num);
        }
    }
}
</script>
@endsection
