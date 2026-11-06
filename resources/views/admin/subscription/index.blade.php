@extends('admin.layouts.app')

@section('title', 'خرید و تمدید اشتراک سامانه طلالایو')

@section('content')
<div x-data="subscriptionPage()" class="max-w-5xl mx-auto space-y-5 pb-12">
    {{-- هدر فشرده و وضعیت اشتراک --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-slate-850 to-slate-950 border border-slate-800/80 p-4 sm:p-5 shadow-xl">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl {{ $daysRemaining > 0 ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/15 text-rose-400 border border-rose-500/30' }} flex items-center justify-center font-black text-lg shrink-0">
                    <i data-lucide="{{ $daysRemaining > 0 ? 'shield-check' : 'alert-triangle' }}" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-base sm:text-lg font-black text-white">تمدید اشتراک تابلو طلالایو</h1>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-black {{ $daysRemaining > 0 ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300' }}">
                            {{ $daysRemaining }} روز باقی‌مانده
                        </span>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-0.5">
                        انقضا: <span class="font-bold text-slate-200">{{ $jalaliExpiry ?? 'نامشخص' }}</span>
                        <span class="mx-1 text-slate-600">•</span>
                        <span class="text-amber-400/90 font-medium">حفظ کامل روزها: مدت بسته جدید به انتهای اشتراک فعلی شما افزوده می‌شود.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- پیشنهاد ویژه ۴۸ ساعت اول ثبت‌نام --}}
    @if(!empty($isWelcomePeriod))
        <div class="rounded-2xl p-4 sm:p-5 border-2 border-amber-500/60 bg-gradient-to-r from-amber-500/15 via-slate-900 to-amber-950/30 text-white shadow-xl shadow-amber-500/10 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center font-black text-2xl shrink-0 shadow-md shadow-amber-500/30">
                    🔥
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-sm sm:text-base font-black text-amber-400">پیشنهاد طلایی راه‌اندازی گالری شما (محدود به ۴۸ ساعت اول)</h3>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-black bg-rose-500 text-white">
                            {{ $welcomeHoursLeft }} ساعت تا پایان فرصت
                        </span>
                    </div>
                    <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                        اشتراک سالانه طلالایو به جای <span class="line-through text-slate-400">۴,۷۰۰,۰۰۰ تومان</span> فقط با <strong class="text-amber-300 text-sm font-black">۳,۹۶۰,۰۰۰ تومان</strong> برای شما محاسبه می‌شود. کد تخفیف <code class="px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 font-mono font-bold">WELCOME48</code> برای شما اعمال شده است.
                    </p>
                </div>
            </div>
            <div class="shrink-0 text-left">
                <div class="text-[11px] text-slate-400">مبلغ نهایی با تخفیف:</div>
                <div class="text-xl font-black text-amber-400 font-mono">۳,۹۶۰,۰۰۰ تومان</div>
            </div>
        </div>
    @endif

    {{-- پیام‌های سیستم --}}
    @if(session('success'))
        <div class="rounded-xl bg-emerald-500/15 border border-emerald-500/30 p-3 text-emerald-200 text-xs flex items-center gap-2.5">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-xl bg-rose-500/15 border border-rose-500/30 p-3 text-rose-200 text-xs flex items-center gap-2.5">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- گام ۱: سوییچر تب‌های پلن‌ها (Segmented Switcher) --}}
    <div class="bg-white dark:bg-slate-900/90 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 shadow-sm space-y-3">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-black text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                <span class="w-5 h-5 rounded-lg bg-amber-500/20 text-amber-500 flex items-center justify-center text-[11px] font-black">۱</span>
                <span>انتخاب دوره اشتراک:</span>
            </h2>
            <span class="text-[11px] text-amber-500 font-bold" x-show="selectedPlanOriginalPrice > selectedPlanPrice">
                تخفیف ویژه اعمال شد ✓
            </span>
        </div>

        {{-- نوار سوییچر قطعه‌ای پلن‌ها (iOS Style Segmented Control) --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 p-1 bg-slate-100 dark:bg-slate-800/70 rounded-xl">
            @foreach($plans as $plan)
                <button type="button"
                        @click="selectPlan({{ $plan->id }}, {{ $plan->price }}, '{{ $plan->name }}', {{ $plan->original_price ?? $plan->price }}, {{ $plan->duration_days }})"
                        class="relative py-2.5 px-3 rounded-lg text-xs font-black transition-all flex flex-col items-center justify-center gap-0.5 cursor-pointer select-none"
                        :class="selectedPlanId == {{ $plan->id }} 
                            ? 'bg-gradient-to-r from-amber-500 to-amber-400 text-slate-950 shadow-md shadow-amber-500/20 font-black' 
                            : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white'">
                    
                    @if($plan->badge_text)
                        <span class="absolute -top-2.5 right-2 px-1.5 py-0.2 rounded-full text-[9px] font-black {{ $plan->is_popular ? 'bg-rose-500 text-white' : 'bg-amber-500 text-slate-950 font-black shadow-xs' }}">
                            {{ $plan->badge_text }}
                        </span>
                    @endif

                    <span>{{ $plan->name }}</span>
                    <span class="text-[11px] font-bold" :class="selectedPlanId == {{ $plan->id }} ? 'text-slate-900' : 'text-slate-500 dark:text-slate-400'">
                        {{ number_format($plan->price) }} ت
                    </span>
                </button>
            @endforeach
        </div>

        {{-- کارت خلاصه وضعیت پلن فعال (بسیار کامپکت) --}}
        <div class="rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/60 p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-500/15 text-amber-500 flex items-center justify-center shrink-0">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-black text-slate-900 dark:text-white" x-text="selectedPlanName"></span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400" x-text="'(معادل ماهانه ' + formatNumber(monthlyRate) + ' تومان)'"></span>
                    </div>
                    <div class="text-[11px] text-emerald-600 dark:text-emerald-400 mt-0.5">
                        دسترسی کامل به تابلوی تلویزیون، مظنه‌های لحظه‌ای و فرمول‌ساز سود
                    </div>
                </div>
            </div>

            <div class="text-left shrink-0">
                <template x-if="selectedPlanOriginalPrice > selectedPlanPrice">
                    <div class="text-[10px] text-slate-400 line-through" x-text="formatNumber(selectedPlanOriginalPrice) + ' تومان'"></div>
                </template>
                <div class="flex items-baseline gap-1">
                    <span class="text-lg font-black text-amber-500" x-text="formatNumber(selectedPlanPrice)"></span>
                    <span class="text-[10px] text-slate-500">تومان</span>
                </div>
            </div>
        </div>
    </div>

    {{-- گام ۲: انتخاب روش پرداخت (پرداخت آنلاین شاپرک / کارت به کارت) --}}
    <div class="bg-white dark:bg-slate-900/90 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 shadow-sm space-y-3">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-black text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                <span class="w-5 h-5 rounded-lg bg-amber-500/20 text-amber-500 flex items-center justify-center text-[11px] font-black">۲</span>
                <span>انتخاب شیوه پرداخت:</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            <button type="button" 
                    @click="paymentMethod = 'online'"
                    :class="paymentMethod === 'online' 
                        ? 'bg-gradient-to-r from-amber-500 to-amber-400 text-slate-950 font-black shadow-md shadow-amber-500/20 border-amber-500 ring-2 ring-amber-500/30' 
                        : 'bg-slate-100 dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-amber-500/50'"
                    class="p-3.5 rounded-xl border flex items-center justify-between text-right cursor-pointer transition-all">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">⚡</span>
                    <div>
                        <div class="text-xs font-black">پرداخت اینترنتی شتاب (زرین‌پال)</div>
                        <div class="text-[10px] opacity-80 mt-0.5">فعال‌سازی آنی، فاکتور دیجیتال رسمی</div>
                    </div>
                </div>
                <span class="text-[10px] px-2 py-0.5 rounded-full {{ $onlineGatewaysEnabled ? 'bg-emerald-500 text-white font-bold' : 'bg-slate-900 text-amber-400 font-bold' }}">
                    {{ $onlineGatewaysEnabled ? 'فعال شاپرک ✓' : 'در انتظار شاپرک' }}
                </span>
            </button>

            <button type="button" 
                    @click="paymentMethod = 'card'"
                    :class="paymentMethod === 'card' 
                        ? 'bg-gradient-to-r from-amber-500 to-amber-400 text-slate-950 font-black shadow-md shadow-amber-500/20 border-amber-500 ring-2 ring-amber-500/30' 
                        : 'bg-slate-100 dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-amber-500/50'"
                    class="p-3.5 rounded-xl border flex items-center justify-between text-right cursor-pointer transition-all">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">💳</span>
                    <div>
                        <div class="text-xs font-black">واریز کارت به کارت (بانک ملی)</div>
                        <div class="text-[10px] opacity-80 mt-0.5">واریز شتابی، ثبت فیش، تایید مدیریت</div>
                    </div>
                </div>
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-900 text-amber-400 font-bold">بهمن شاکری</span>
            </button>
        </div>
    </div>

    {{-- گزینه الف: پرداخت اینترنتی زرین‌پال --}}
    <div x-show="paymentMethod === 'online'" x-cloak class="space-y-4">
        @if($onlineGatewaysEnabled)
            <form action="{{ route('admin.subscription.checkout') }}" method="POST" class="bg-white dark:bg-slate-900/90 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 sm:p-5 shadow-sm space-y-4">
                @csrf
                <input type="hidden" name="plan_id" :value="selectedPlanId">
                <input type="hidden" name="gateway" value="zarinpal">
                <input type="hidden" name="coupon_code" :value="appliedCouponCode">

                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-500/15 text-amber-500 flex items-center justify-center font-bold">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </span>
                        <div>
                            <h3 class="text-xs font-black text-slate-900 dark:text-white">درگاه پرداخت امن بانکی شاپرک (زرین‌پال)</h3>
                            <p class="text-[10px] text-slate-400">اتصال مستقیم به کلیه کارت‌های عضو شبکه شتاب</p>
                        </div>
                    </div>

                    {{-- لینک بازشونده کد تخفیف --}}
                    <button type="button" 
                            @click="showCoupon = !showCoupon"
                            class="text-xs text-amber-500 hover:text-amber-400 font-bold flex items-center gap-1 cursor-pointer">
                        <i data-lucide="ticket-percent" class="w-3.5 h-3.5"></i>
                        <span x-text="showCoupon ? 'بستن کد تخفیف' : 'کد تخفیف دارید؟'"></span>
                    </button>
                </div>

                {{-- بخش جمع‌وجور کد تخفیف --}}
                <div x-show="showCoupon" x-transition class="rounded-xl bg-slate-50 dark:bg-slate-800/60 p-3 border border-slate-200 dark:border-slate-700/60 space-y-2">
                    <div class="flex gap-2">
                        <input type="text"
                               x-model="inputCouponCode"
                               :disabled="couponApplied"
                               placeholder="کد تخفیف (مثلاً TALALIVE10 یا WELCOME48)"
                               dir="ltr"
                               class="flex-1 uppercase font-mono text-xs px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:border-amber-500">

                        <button type="button"
                                @click="applyCoupon()"
                                :disabled="couponLoading || couponApplied || !inputCouponCode.trim()"
                                class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs disabled:opacity-50 cursor-pointer shrink-0">
                            <span x-show="!couponLoading && !couponApplied">اعمال</span>
                            <span x-show="couponLoading">بررسی...</span>
                            <span x-show="couponApplied">اعمال شد ✓</span>
                        </button>

                        <button type="button"
                                x-show="couponApplied"
                                @click="removeCoupon()"
                                class="px-2.5 py-2 rounded-xl bg-rose-500/10 text-rose-500 hover:bg-rose-500/20 text-xs font-bold cursor-pointer shrink-0">
                            حذف
                        </button>
                    </div>
                    <div x-show="couponMessage" class="text-[11px] font-bold" :class="couponSuccess ? 'text-emerald-500' : 'text-rose-500'" x-text="couponMessage"></div>
                </div>

                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="text-[11px] text-slate-400 font-medium">مبلغ نهایی پرداختی:</div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-2xl font-black text-amber-500" x-text="formatNumber(finalPrice)"></span>
                            <span class="text-xs font-bold text-slate-500">تومان</span>
                            <span class="text-[10px] text-emerald-500 font-bold mr-1" x-show="discountAmount > 0" x-text="'(' + formatNumber(discountAmount) + ' تومان تخفیف)'"></span>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full sm:w-auto px-7 py-3 rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 hover:from-amber-400 hover:to-amber-400 text-slate-950 font-black text-xs transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="zap" class="w-4 h-4 text-slate-950"></i>
                        <span>پرداخت آنلاین و فعال‌سازی فوری در شاپرک &larr;</span>
                    </button>
                </div>
            </form>
        @else
            <div class="rounded-2xl border border-amber-500/30 bg-amber-500/10 dark:bg-amber-950/20 p-5 space-y-3">
                <div class="flex items-center gap-2.5 text-amber-700 dark:text-amber-400 font-black text-sm">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                    <span>درگاه پرداخت آنلاین شاپرک زرین‌پال در حال انجام مراحل اداری است</span>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    درخواست فعال‌سازی درگاه پرداخت مستقیم شاپرک ارسال شده و به زودی به صورت ۱ کلیک فعال می‌شود. در حال حاضر می‌توانید از طریق <strong>«واریز کارت به کارت (بانک ملی)»</strong> اشتراک گالری خود را با تایید فوق‌سریع فعال نمایید.
                </p>
                <button type="button" @click="paymentMethod = 'card'" class="px-4 py-2.5 rounded-xl bg-amber-500 text-slate-950 font-black text-xs cursor-pointer shadow-md shadow-amber-500/20 flex items-center gap-1.5">
                    <span>انتقال به بخش واریز کارت به کارت</span>
                    <span>&larr;</span>
                </button>
            </div>
        @endif
    </div>

    {{-- گزینه ب: واریز کارت به کارت و ثبت فیش --}}
    <div x-show="paymentMethod === 'card'" x-cloak class="space-y-4">
        {{-- مینی‌کارت لوکس بانکی بهمن شاکری --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-amber-500 via-amber-600 to-yellow-600 text-slate-950 p-4 sm:p-5 shadow-xl shadow-amber-500/20 border border-amber-300/40 select-none">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-950/15 backdrop-blur-md flex items-center justify-center font-black text-slate-950 shrink-0 border border-white/20">
                        <i data-lucide="landmark" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-black text-slate-950">بانک ملی ایران</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-950 text-amber-400 font-bold">بهمن شاکری</span>
                        </div>
                        <div class="text-base sm:text-lg font-mono font-black tracking-widest text-slate-950 mt-0.5" dir="ltr">
                            6037 - 9972 - 0569 - 3782
                        </div>
                    </div>
                </div>

                <button type="button"
                        @click="copyCardNumber()"
                        class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-slate-950 hover:bg-slate-900 active:scale-95 text-amber-400 hover:text-amber-300 font-black text-xs transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer shrink-0">
                    <i data-lucide="copy" class="w-4 h-4" x-show="!cardCopied"></i>
                    <i data-lucide="check" class="w-4 h-4 text-emerald-400" x-show="cardCopied"></i>
                    <span x-text="cardCopied ? 'شماره کارت کپی شد ✓' : 'کپی شماره کارت'"></span>
                </button>
            </div>

            <div x-show="cardCopied" x-transition class="text-[11px] text-slate-950 font-bold flex items-center gap-1.5 mt-2 pt-2 border-t border-slate-950/15" x-cloak>
                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                <span>شماره کارت ۱۶ رقمی بانک ملی (بهمن شاکری) در کلیپ‌بورد کپی شد.</span>
            </div>
        </div>

        {{-- کارت ثبت فیش واریزی --}}
        <form action="{{ route('admin.subscription.submit-receipt') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              @submit="isSubmitting = true"
              class="bg-white dark:bg-slate-900/90 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 sm:p-5 shadow-sm space-y-4">
            @csrf
            <input type="hidden" name="plan_id" :value="selectedPlanId">
            <input type="hidden" name="coupon_code" :value="appliedCouponCode">

            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-xs font-black text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                    <span class="w-5 h-5 rounded-lg bg-amber-500/20 text-amber-500 flex items-center justify-center text-[11px] font-black">۳</span>
                    <span>بارگذاری تصویر فیش واریزی:</span>
                </h2>

                <button type="button" 
                        @click="showCoupon = !showCoupon"
                        class="text-xs text-amber-500 hover:text-amber-400 font-bold flex items-center gap-1 cursor-pointer">
                    <i data-lucide="ticket-percent" class="w-3.5 h-3.5"></i>
                    <span x-text="showCoupon ? 'بستن کد تخفیف' : 'کد تخفیف دارید؟'"></span>
                </button>
            </div>

            <div x-show="showCoupon" x-transition class="rounded-xl bg-slate-50 dark:bg-slate-800/60 p-3 border border-slate-200 dark:border-slate-700/60 space-y-2" x-cloak>
                <div class="flex gap-2">
                    <input type="text"
                           x-model="inputCouponCode"
                           :disabled="couponApplied"
                           placeholder="کد تخفیف (مثلاً TALALIVE10 یا WELCOME48)"
                           dir="ltr"
                           class="flex-1 uppercase font-mono text-xs px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:border-amber-500">

                    <button type="button"
                            @click="applyCoupon()"
                            :disabled="couponLoading || couponApplied || !inputCouponCode.trim()"
                            class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs disabled:opacity-50 cursor-pointer shrink-0">
                        <span x-show="!couponLoading && !couponApplied">اعمال</span>
                        <span x-show="couponLoading">بررسی...</span>
                        <span x-show="couponApplied">اعمال شد ✓</span>
                    </button>

                    <button type="button"
                            x-show="couponApplied"
                            @click="removeCoupon()"
                            class="px-2.5 py-2 rounded-xl bg-rose-500/10 text-rose-500 hover:bg-rose-500/20 text-xs font-bold cursor-pointer shrink-0">
                        حذف
                    </button>
                </div>
                <div x-show="couponMessage" class="text-[11px] font-bold" :class="couponSuccess ? 'text-emerald-500' : 'text-rose-500'" x-text="couponMessage"></div>
            </div>

            <div>
                <input type="file" 
                       name="receipt_image" 
                       id="receipt_file_input"
                       accept="image/*,application/pdf"
                       @change="handleFileChange($event)"
                       class="hidden"
                       required>

                <div x-show="!receiptPreview"
                     @click="document.getElementById('receipt_file_input').click()"
                     class="border border-dashed border-slate-300 dark:border-slate-700 hover:border-amber-500 bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/40 dark:hover:bg-slate-800/80 rounded-xl p-4 text-center cursor-pointer transition-all flex items-center justify-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-amber-500/15 text-amber-500 flex items-center justify-center font-bold shrink-0">
                        <i data-lucide="camera" class="w-5 h-5"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-black text-slate-800 dark:text-slate-200">
                            انتخاب تصویر فیش یا اسکرین‌شات رسید
                        </div>
                        <div class="text-[10px] text-slate-400">
                            کلیک کنید یا عکس رسید واریز را بارگذاری نمایید (JPG, PNG)
                        </div>
                    </div>
                </div>

                <div x-show="receiptPreview" class="rounded-xl border border-emerald-500/30 bg-emerald-500/5 p-2.5 flex items-center justify-between gap-3" x-cloak>
                    <div class="flex items-center gap-2.5 min-w-0">
                        <template x-if="isImage">
                            <img :src="receiptPreview" class="w-12 h-12 object-cover rounded-lg border border-emerald-500/40 shrink-0" alt="پیش‌نمایش رسید">
                        </template>
                        <template x-if="!isImage">
                            <div class="w-12 h-12 rounded-lg bg-amber-500/15 text-amber-500 flex items-center justify-center shrink-0">
                                <i data-lucide="file-text" class="w-6 h-6"></i>
                            </div>
                        </template>
                        <div class="min-w-0">
                            <div class="text-xs font-black text-slate-900 dark:text-white truncate" x-text="receiptFileName"></div>
                            <div class="text-[10px] text-slate-400 mt-0.5" x-text="receiptFileSize + ' • آماده ارسال ✓'"></div>
                        </div>
                    </div>

                    <button type="button" 
                            @click="removeReceiptFile()"
                            class="px-2 py-1 rounded-lg text-rose-500 hover:bg-rose-500/10 text-xs font-bold transition-all shrink-0 cursor-pointer">
                        تغییر عکس
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-1">
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">
                        شماره پیگیری فیش (اختیاری):
                    </label>
                    <input type="text"
                           name="reference_id"
                           placeholder="مثلاً: 123456"
                           dir="ltr"
                           class="w-full font-mono text-xs px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">
                        ۴ رقم آخر کارت شما (اختیاری):
                    </label>
                    <input type="text"
                           name="card_pan"
                           maxlength="4"
                           placeholder="مثلاً: 6037"
                           dir="ltr"
                           class="w-full font-mono text-center text-xs px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:border-amber-500">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <div class="text-[11px] text-slate-400 font-medium">مبلغ نهایی قابل واریز:</div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-2xl font-black text-amber-500" x-text="formatNumber(finalPrice)"></span>
                        <span class="text-xs font-bold text-slate-500">تومان</span>
                        <span class="text-[10px] text-emerald-500 font-bold mr-1" x-show="discountAmount > 0" x-text="'(' + formatNumber(discountAmount) + ' تومان تخفیف)'"></span>
                    </div>
                </div>

                <button type="submit"
                        :disabled="isSubmitting || !hasReceiptFile"
                        class="w-full sm:w-auto px-6 py-3 rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 hover:from-amber-400 hover:to-amber-400 text-slate-950 font-black text-xs transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-slate-950" x-show="!isSubmitting"></i>
                    <i data-lucide="loader-2" class="w-4 h-4 animate-spin" x-show="isSubmitting" x-cloak></i>
                    <span x-text="isSubmitting ? 'در حال ارسال فیش...' : 'ثبت فیش و ارسال جهت تایید مدیریت'"></span>
                </button>
            </div>
        </form>
    </div>

    {{-- کادر تضمین بازگشت ۱۰۰٪ وجه و امنیت اشتراک --}}
    <div class="rounded-2xl p-4 sm:p-5 border border-emerald-500/30 bg-gradient-to-r from-emerald-500/10 via-emerald-950/20 to-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-right shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center text-2xl font-black shrink-0">
                🛡️
            </div>
            <div>
                <h4 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white">ضمانت ۱۰۰٪ بازگشت وجه تا ۳۰ روز (بدون قید و شرط)</h4>
                <p class="text-[11px] text-slate-600 dark:text-slate-300 mt-0.5 leading-relaxed">
                    در صورت هرگونه عدم رضایت در ماه اول، تمام وجه پرداختی بدون پرسیدن سوال به حساب بانکی شما عودت داده می‌شود.
                </p>
            </div>
        </div>
        <div class="shrink-0 flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-lg bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 font-black text-xs">
                پایداری ۹۹.۹٪ نرخ‌های اتحادیه ✓
            </span>
        </div>
    </div>

    {{-- پشتیبانی سریع تلفنی و تلگرام (فشرده) --}}
    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-100/80 dark:bg-slate-800/40 text-xs">
        <span class="text-slate-500 dark:text-slate-400 text-[11px]">پشتیبانی و هماهنگی واریز:</span>
        <div class="flex items-center gap-2">
            <a href="tel:09187009064" class="px-2.5 py-1 rounded-lg bg-white dark:bg-slate-800 hover:bg-slate-200 text-slate-800 dark:text-slate-200 font-bold text-[11px] flex items-center gap-1 border border-slate-200 dark:border-slate-700">
                <i data-lucide="phone" class="w-3 h-3 text-amber-500"></i>
                <span>۰۹۱۸۷۰۰۹۰۶۴</span>
            </a>
            <a href="https://t.me/talalive" rel="noopener noreferrer" target="_blank" class="px-2.5 py-1 rounded-lg bg-purple-600 hover:bg-purple-500 text-white font-bold text-[11px] flex items-center gap-1">
                <span>پشتیبانی تلگرام</span>
            </a>
        </div>
    </div>

    {{-- سوابق پرداخت و فاکتورها (آکاردئون بازشونده) --}}
    <div class="bg-white dark:bg-slate-900/90 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <button type="button"
                @click="showHistory = !showHistory"
                class="w-full p-4 flex items-center justify-between text-xs font-black text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors cursor-pointer">
            <div class="flex items-center gap-2">
                <i data-lucide="history" class="w-4 h-4 text-amber-500"></i>
                <span>سوابق تراکنش‌ها و فاکتورهای شما ({{ $payments->total() }} مورد)</span>
            </div>
            <div class="flex items-center gap-1 text-slate-400 text-[11px]">
                <span x-text="showHistory ? 'بستن' : 'مشاهده'"></span>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="showHistory ? 'rotate-180' : ''"></i>
            </div>
        </button>

        <div x-show="showHistory" x-transition class="p-4 pt-0 border-t border-slate-100 dark:border-slate-800 space-y-3" x-cloak>
            @if($payments->isEmpty())
                <div class="py-6 text-center text-slate-400 text-xs">
                    تاکنون هیچ تراکنشی ثبت نشده است.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-right text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 text-[11px]">
                                <th class="py-2.5 px-2">فاکتور</th>
                                <th class="py-2.5 px-2">بسته</th>
                                <th class="py-2.5 px-2">مبلغ</th>
                                <th class="py-2.5 px-2">رسید</th>
                                <th class="py-2.5 px-2">تاریخ</th>
                                <th class="py-2.5 px-2 text-center">وضعیت</th>
                                <th class="py-2.5 px-2 text-center">فاکتور</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            @foreach($payments as $payment)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="py-2.5 px-2 font-mono font-bold" dir="ltr">{{ $payment->invoice_no }}</td>
                                    <td class="py-2.5 px-2 font-bold">{{ $payment->plan?->name ?? 'اشتراک طلالایو' }}</td>
                                    <td class="py-2.5 px-2 font-bold text-amber-500">{{ number_format($payment->amount) }} ت</td>
                                    <td class="py-2.5 px-2">
                                        @if($payment->receipt_url)
                                            <button type="button"
                                                    @click="viewReceiptModal('{{ $payment->receipt_url }}', '{{ $payment->invoice_no }}')"
                                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-amber-500/10 hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 text-[10px] font-bold cursor-pointer">
                                                <i data-lucide="image" class="w-3 h-3"></i>
                                                <span>فیش</span>
                                            </button>
                                        @else
                                            <span class="text-slate-400 text-[10px]">-</span>
                                        @endif
                                    </td>
                                    <td class="py-2.5 px-2 text-slate-400 font-mono text-[11px]">
                                        {{ $payment->created_at ? \App\Models\User::toJalali($payment->created_at) : '---' }}
                                    </td>
                                    <td class="py-2.5 px-2 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black border {{ $payment->status_badge_class }}">
                                            {{ $payment->status_label }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-2 text-center">
                                        <a href="{{ route('admin.subscription.invoice', $payment->id) }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-[11px] font-bold">
                                            <i data-lucide="printer" class="w-3 h-3"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- لایت‌باکس پاپ‌آپ پیش‌نمایش فیش --}}
    <div x-show="showReceiptLightbox" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4"
         x-cloak>
        <div @click.away="showReceiptLightbox = false" 
             class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 max-w-lg w-full p-4 shadow-2xl space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                <span class="text-xs font-black text-slate-900 dark:text-white">
                    تصویر فیش: <span class="font-mono text-amber-500" x-text="lightboxInvoice"></span>
                </span>
                <button type="button" @click="showReceiptLightbox = false" class="text-slate-400 hover:text-slate-600 p-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <div class="rounded-xl overflow-hidden bg-slate-950 flex items-center justify-center max-h-[65vh]">
                <img :src="lightboxImageUrl" class="max-w-full max-h-[60vh] object-contain rounded-lg" alt="فیش">
            </div>

            <div class="flex items-center justify-between pt-1">
                <a :href="lightboxImageUrl" download target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    <span>دانلود تصویر</span>
                </a>
                <button type="button" @click="showReceiptLightbox = false" class="px-4 py-1.5 rounded-lg bg-amber-500 text-slate-950 font-black text-xs">
                    بستن
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function subscriptionPage() {
    return {
        plans: @json($plans),
        selectedPlanId: {{ $plans->firstWhere('is_popular', true)?->id ?? $plans->first()?->id ?? 1 }},
        selectedPlanPrice: {{ $plans->firstWhere('is_popular', true)?->price ?? $plans->first()?->price ?? 4700000 }},
        selectedPlanOriginalPrice: {{ $plans->firstWhere('is_popular', true)?->original_price ?? 8280000 }},
        selectedPlanName: '{{ $plans->firstWhere('is_popular', true)?->name ?? $plans->first()?->name ?? "اشتراک ۱ ساله الماس" }}',
        selectedPlanDays: {{ $plans->firstWhere('is_popular', true)?->duration_days ?? 365 }},
        paymentMethod: '{{ $onlineGatewaysEnabled ? "online" : "card" }}',
        isWelcomePeriod: {{ !empty($isWelcomePeriod) ? "true" : "false" }},
        
        cardNumberRaw: '6037997205693782',
        cardCopied: false,

        // تخفیف
        showCoupon: false,
        inputCouponCode: '',
        appliedCouponCode: '',
        discountAmount: 0,
        couponApplied: false,
        couponLoading: false,
        couponSuccess: false,
        couponMessage: '',

        // آپلود فیش
        receiptPreview: null,
        receiptFileName: '',
        receiptFileSize: '',
        isImage: true,
        hasReceiptFile: false,

        // سوابق
        showHistory: false,
        showReceiptLightbox: false,
        lightboxImageUrl: '',
        lightboxInvoice: '',

        isSubmitting: false,

        init() {
            if (this.isWelcomePeriod) {
                this.inputCouponCode = 'WELCOME48';
                this.showCoupon = true;
                this.applyCoupon(true);
            }
            this.$nextTick(() => {
                if (window.lucide) { window.lucide.createIcons(); }
            });
        },

        get monthlyRate() {
            return Math.round(this.selectedPlanPrice / (this.selectedPlanDays / 30));
        },

        get finalPrice() {
            return Math.max(0, this.selectedPlanPrice - this.discountAmount);
        },

        selectPlan(id, price, name, originalPrice, days) {
            this.selectedPlanId = id;
            this.selectedPlanPrice = price;
            this.selectedPlanName = name;
            this.selectedPlanOriginalPrice = originalPrice;
            this.selectedPlanDays = days;

            if (this.couponApplied && this.appliedCouponCode) {
                this.applyCoupon(true);
            }

            this.$nextTick(() => {
                if (window.lucide) { window.lucide.createIcons(); }
            });
        },

        copyCardNumber() {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(this.cardNumberRaw).then(() => {
                    this.showCopiedState();
                }).catch(() => this.fallbackCopy());
            } else {
                this.fallbackCopy();
            }
        },

        fallbackCopy() {
            const el = document.createElement('textarea');
            el.value = this.cardNumberRaw;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            this.showCopiedState();
        },

        showCopiedState() {
            this.cardCopied = true;
            this.$nextTick(() => {
                if (window.lucide) { window.lucide.createIcons(); }
            });
            setTimeout(() => {
                this.cardCopied = false;
                this.$nextTick(() => {
                    if (window.lucide) { window.lucide.createIcons(); }
                });
            }, 3000);
        },

        handleFileChange(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.receiptFileName = file.name;
            this.receiptFileSize = (file.size / (1024 * 1024)).toFixed(2) + ' مگابایت';
            this.isImage = file.type.startsWith('image/');
            this.hasReceiptFile = true;

            if (this.isImage) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.receiptPreview = e.target.result;
                    this.$nextTick(() => {
                        if (window.lucide) { window.lucide.createIcons(); }
                    });
                };
                reader.readAsDataURL(file);
            } else {
                this.receiptPreview = 'file';
                this.$nextTick(() => {
                    if (window.lucide) { window.lucide.createIcons(); }
                });
            }
        },

        removeReceiptFile() {
            this.receiptPreview = null;
            this.receiptFileName = '';
            this.receiptFileSize = '';
            this.hasReceiptFile = false;
            const input = document.getElementById('receipt_file_input');
            if (input) input.value = '';
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
                    this.couponMessage = data.message || `کد تخفیف اعمال شد (${this.formatNumber(data.discount_amount)} تومان کسر شد).`;
                } else {
                    this.discountAmount = 0;
                    this.appliedCouponCode = '';
                    this.couponApplied = false;
                    this.couponSuccess = false;
                    this.couponMessage = data.message || 'کد تخفیف نامعتبر یا منقضی است.';
                }
            } catch (err) {
                this.couponSuccess = false;
                this.couponMessage = 'خطا در ارتباط با سرور.';
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

        viewReceiptModal(url, invoice) {
            this.lightboxImageUrl = url;
            this.lightboxInvoice = invoice;
            this.showReceiptLightbox = true;
            this.$nextTick(() => {
                if (window.lucide) { window.lucide.createIcons(); }
            });
        },

        formatNumber(num) {
            return new Intl.NumberFormat('fa-IR').format(num);
        }
    }
}
</script>
@endsection
