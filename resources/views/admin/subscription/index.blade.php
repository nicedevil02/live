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
                    با انتخاب بسته مورد نظر، تابلوی اختصاصی تلویزیون، قیمت‌گذاری خودکار مظنه و ویترین آنلاین مغازه خود را همواره فعال، پایدار و بروز نگه دارید.
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

        {{-- تضمین عدم سوختن روزها (No Day Lost Guarantee) --}}
        <div class="mt-6 pt-5 border-t border-slate-800/80 flex items-center gap-2.5 text-xs text-amber-300/90">
            <i data-lucide="sparkles" class="w-4 h-4 text-amber-400 shrink-0"></i>
            <span class="font-medium">
                <strong>تضمین طلایی حفظ روزها:</strong> در صورت تمدید در هر زمان، تمامی روزهای باقیمانده کنونی شما محفوظ مانده و مدت بسته جدید به انتهای اشتراک فعلی شما افزوده خواهد شد.
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

    {{-- مرحله ۱: انتخاب بسته اشتراک --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="w-7 h-7 rounded-xl bg-amber-500/20 text-amber-500 flex items-center justify-center text-xs font-black">۱</span>
                    <span>انتخاب بسته اشتراک تابلو طلالایو</span>
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    تمامی بسته‌ها شامل کلیه امکانات تابلو، فرمول‌ساز، اسلایدشو و اتصال تلویزیون بدون محدودیت هستند.
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
                    
                    {{-- برچسب نشان بسته --}}
                    @if($plan->badge_text)
                        <div class="absolute -top-3.5 right-6 px-3.5 py-1 rounded-full text-[11px] font-black tracking-wide shadow-md {{ $plan->is_popular ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 shadow-amber-500/30' : 'bg-blue-600 text-white shadow-blue-600/30' }}">
                            {{ $plan->badge_text }}
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
                            @if($plan->original_price && $plan->original_price > $plan->price)
                                <div class="text-xs text-slate-400 line-through mb-0.5">
                                    {{ number_format($plan->original_price) }} تومان
                                </div>
                            @endif
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
                            دسترسی کامل به مظنه لحظه‌ای، فرمول محاسبه سود و اتصال نامحدود به تلویزیون هوشمند.
                        </p>

                        {{-- امکانات پکیج --}}
                        <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-300 border-t border-slate-100 dark:border-slate-800/80 pt-4">
                            <li class="flex items-center gap-2">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                                <span>پخش زنده تابلوی تلویزیون گالری</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                                <span>فرمول‌ساز پیشرفته محاسبه مظنه و سود</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                                <span>ویترین و اسلایدر لوکس محصولات</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 shrink-0"></i>
                                <span>پشتیبانی فنی و اولویت‌دار اختصاصی</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800/80">
                        <button type="button" 
                                class="w-full py-2.5 px-4 rounded-xl text-xs font-black transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                                :class="selectedPlanId == {{ $plan->id }} 
                                    ? 'bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md shadow-amber-500/25 font-black' 
                                    : 'bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300'">
                            <span x-text="selectedPlanId == {{ $plan->id }} ? 'بسته انتخابی شما ✓' : 'انتخاب این بسته'"></span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- فرم اصلی ثبت فیش واریزی و کارت‌به‌کارت --}}
    <form action="{{ route('admin.subscription.submit-receipt') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          @submit="isSubmitting = true">
        @csrf
        <input type="hidden" name="plan_id" :value="selectedPlanId">
        <input type="hidden" name="coupon_code" :value="appliedCouponCode">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- ستون راست: کارت بانکی شکیل بهمن شاکری و کد تخفیف --}}
            <div class="lg:col-span-7 space-y-6">
                
                {{-- مرحله ۲: کارت بانکی VIP بانک ملی ایران --}}
                <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-7 shadow-sm space-y-5">
                    <div>
                        <h2 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="w-7 h-7 rounded-xl bg-amber-500/20 text-amber-500 flex items-center justify-center text-xs font-black">۲</span>
                            <span>انتقال وجه کارت به کارت به حساب طلالایو</span>
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            لطفاً مبلغ فاکتور را به شماره کارت رسمی زیر واریز فرمایید:
                        </p>
                    </div>

                    {{-- کامپوننت کارت بانکی طلایی VIP (Luxury Gold Bank Card) --}}
                    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-500 via-amber-600 to-yellow-600 text-slate-950 p-6 sm:p-8 shadow-2xl shadow-amber-500/25 border border-amber-300/40 select-none">
                        {{-- بافت دکوراتیو زمینه --}}
                        <div class="absolute -right-12 -top-12 w-48 h-48 bg-white/15 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute -left-12 -bottom-12 w-48 h-48 bg-black/15 rounded-full blur-2xl pointer-events-none"></div>

                        {{-- ردیف بالای کارت: بانک ملی ایران و نشان VIP --}}
                        <div class="relative z-10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-950/15 backdrop-blur-md flex items-center justify-center font-black text-base border border-white/20">
                                    <i data-lucide="landmark" class="w-5 h-5 text-slate-950"></i>
                                </div>
                                <div>
                                    <div class="text-base font-black text-slate-950 leading-tight">بانک ملی ایران</div>
                                    <div class="text-[10px] font-bold text-slate-900/80">حساب رسمی سامانه طلالایو</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="wifi" class="w-5 h-5 text-slate-950/70 rotate-90"></i>
                                <span class="px-2.5 py-0.5 rounded-full bg-slate-950 text-amber-400 text-[10px] font-black tracking-wider">
                                    VIP GOLD
                                </span>
                            </div>
                        </div>

                        {{-- چیپ کارت هوشمند EMV --}}
                        <div class="relative z-10 my-6 flex items-center gap-4">
                            <div class="w-12 h-9 rounded-lg bg-gradient-to-br from-yellow-200 via-amber-300 to-yellow-500 border border-amber-600/30 shadow-inner flex items-center justify-center relative overflow-hidden">
                                <div class="w-full h-[1px] bg-amber-700/40 absolute top-3"></div>
                                <div class="w-full h-[1px] bg-amber-700/40 absolute bottom-3"></div>
                                <div class="h-full w-[1px] bg-amber-700/40 absolute left-4"></div>
                                <div class="h-full w-[1px] bg-amber-700/40 absolute right-4"></div>
                            </div>
                            <span class="text-[11px] font-bold text-slate-900/70">انتقال شتابی / همراه بانک / عابربانک</span>
                        </div>

                        {{-- شماره کارت با فونت مونو اسپیس درشت و خوانا --}}
                        <div class="relative z-10 my-4 text-center">
                            <div class="text-xl sm:text-2xl lg:text-3xl font-mono font-black tracking-widest text-slate-950 ltr py-1 drop-shadow-sm" dir="ltr">
                                6037 - 9972 - 0569 - 3782
                            </div>
                        </div>

                        {{-- ردیف پایین کارت: صاحب حساب و دکمه کپی هوشمند --}}
                        <div class="relative z-10 pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-t border-slate-950/15">
                            <div>
                                <div class="text-[10px] font-medium text-slate-900/80">صاحب حساب:</div>
                                <div class="text-base font-black text-slate-950">بهمن شاکری</div>
                            </div>

                            <button type="button"
                                    @click="copyCardNumber()"
                                    class="px-4 py-2.5 rounded-xl bg-slate-950 hover:bg-slate-900 active:scale-95 text-amber-400 hover:text-amber-300 font-black text-xs transition-all shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                                <i data-lucide="copy" class="w-4 h-4" x-show="!cardCopied"></i>
                                <i data-lucide="check" class="w-4 h-4 text-emerald-400" x-show="cardCopied"></i>
                                <span x-text="cardCopied ? 'شماره کارت کپی شد ✓' : 'کپی شماره کارت'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- اطلاعیه کپی شدن شماره کارت --}}
                    <div x-show="cardCopied" 
                         x-transition
                         class="rounded-xl bg-emerald-500/10 border border-emerald-500/30 p-3 text-emerald-600 dark:text-emerald-400 text-xs font-bold flex items-center gap-2" 
                         x-cloak>
                        <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
                        <span>شماره کارت ۱۶ رقمی (۶۰۳۷۹۹۷۲۰۵۶۹۳۷۸۲ - بهمن شاکری) در کلیپ‌بورد کپی شد.</span>
                    </div>

                    {{-- راهنمای ۳ مرحله‌ای واریز و تایید --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-xs">
                        <div class="rounded-2xl bg-slate-50 dark:bg-slate-800/60 p-3.5 border border-slate-200 dark:border-slate-700/60 space-y-1">
                            <div class="font-bold text-amber-500 flex items-center gap-1.5">
                                <span class="w-5 h-5 rounded-full bg-amber-500/20 flex items-center justify-center text-[10px]">۱</span>
                                <span>محاسبه مبلغ</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                                مبلغ نهایی بسته را مشاهده کرده و در صورت داشتن کد تخفیف آن را اعمال کنید.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 dark:bg-slate-800/60 p-3.5 border border-slate-200 dark:border-slate-700/60 space-y-1">
                            <div class="font-bold text-amber-500 flex items-center gap-1.5">
                                <span class="w-5 h-5 rounded-full bg-amber-500/20 flex items-center justify-center text-[10px]">۲</span>
                                <span>انتقال کارت به کارت</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                                مبلغ را به شماره کارت بهمن شاکری انتقال داده و از رسید آن اسکرین‌شات بگیرید.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 dark:bg-slate-800/60 p-3.5 border border-slate-200 dark:border-slate-700/60 space-y-1">
                            <div class="font-bold text-amber-500 flex items-center gap-1.5">
                                <span class="w-5 h-5 rounded-full bg-amber-500/20 flex items-center justify-center text-[10px]">۳</span>
                                <span>آپلود و فعال‌سازی</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                                تصویر فیش را در کادر روبرو بارگذاری نمایید تا اشتراک شما فوراً تایید شود.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- بخش اعمال کد تخفیف --}}
                <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                    <h2 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2 mb-2">
                        <i data-lucide="ticket-percent" class="w-5 h-5 text-amber-500"></i>
                        <span>کد تخفیف دارید؟</span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                        در صورت داشتن کد تخفیف یا کوپن افتتاحیه، آن را وارد کرده و دکمه اعمال را بزنید تا از مبلغ واریزی کسر گردد.
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
            </div>

            {{-- ستون چپ: باکس آپلود تصویر فیش، فیلدهای تطبیق و دکمه تایید نهایی --}}
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white dark:bg-slate-900/90 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-7 shadow-xl space-y-6">
                    <div>
                        <h2 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="w-7 h-7 rounded-xl bg-amber-500/20 text-amber-500 flex items-center justify-center text-xs font-black">۳</span>
                            <span>بارگذاری تصویر رسید واریزی</span>
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            تصویر فیش، رسید عابربانک یا اسکرین‌شات همراه بانک را پیوست نمایید.
                        </p>
                    </div>

                    {{-- منطقه درگ اند دراپ و پیش‌نمایش تصویر رسید --}}
                    <div>
                        <input type="file" 
                               name="receipt_image" 
                               id="receipt_image_input"
                               accept="image/jpeg,image/png,image/webp,application/pdf"
                               @change="handleFileChange($event)"
                               class="hidden"
                               required>

                        <div x-show="!receiptPreview"
                             @click="document.getElementById('receipt_image_input').click()"
                             @dragover.prevent="dragOver = true"
                             @dragleave.prevent="dragOver = false"
                             @drop.prevent="handleFileDrop($event)"
                             class="border-2 border-dashed rounded-3xl p-6 sm:p-8 text-center cursor-pointer transition-all flex flex-col items-center justify-center gap-3"
                             :class="dragOver 
                                ? 'border-amber-500 bg-amber-500/10 dark:bg-amber-500/5' 
                                : 'border-slate-300 dark:border-slate-700 bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/40 dark:hover:bg-slate-800/70'">
                            
                            <div class="w-14 h-14 rounded-2xl bg-amber-500/15 text-amber-500 flex items-center justify-center font-black">
                                <i data-lucide="upload-cloud" class="w-7 h-7"></i>
                            </div>
                            <div>
                                <div class="text-sm font-black text-slate-800 dark:text-slate-200">
                                    کلیک کنید یا تصویر فیش را به اینجا بکشید
                                </div>
                                <div class="text-[11px] text-slate-400 mt-1">
                                    فرمت‌های مجاز: JPG, PNG, WEBP (حداکثر ۵ مگابایت)
                                </div>
                            </div>
                        </div>

                        {{-- پیش‌نمایش فایل انتخاب شده --}}
                        <div x-show="receiptPreview" class="relative rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 p-3" x-cloak>
                            <div class="flex items-center gap-3">
                                <template x-if="isImage">
                                    <img :src="receiptPreview" class="w-16 h-16 object-cover rounded-xl border border-slate-200 dark:border-slate-700 shrink-0" alt="پیش‌نمایش فیش">
                                </template>
                                <template x-if="!isImage">
                                    <div class="w-16 h-16 rounded-xl bg-amber-500/15 text-amber-500 flex items-center justify-center shrink-0">
                                        <i data-lucide="file-text" class="w-8 h-8"></i>
                                    </div>
                                </template>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-black text-slate-900 dark:text-white truncate" x-text="receiptFileName"></div>
                                    <div class="text-[11px] text-slate-400 mt-0.5" x-text="receiptFileSize"></div>
                                    <div class="text-[10px] text-emerald-500 font-bold mt-1">آماده ارسال ✓</div>
                                </div>
                                <button type="button" 
                                        @click="removeReceiptFile()"
                                        class="p-2 rounded-xl text-rose-500 hover:bg-rose-500/10 transition-all shrink-0 cursor-pointer"
                                        title="حذف و انتخاب مجدد">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- فیلدهای تکمیلی جهت تطبیق حسابداری --}}
                    <div class="space-y-3 pt-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                                شماره پیگیری / ارجاع فیش (اختیاری):
                            </label>
                            <input type="text"
                                   name="reference_id"
                                   placeholder="مثلاً: 9876543210"
                                   dir="ltr"
                                   class="w-full font-mono text-xs px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:border-amber-500">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                    ۴ رقم آخر کارت شما:
                                </label>
                                <input type="text"
                                       name="card_pan"
                                       maxlength="4"
                                       placeholder="مثلاً: 1234"
                                       dir="ltr"
                                       class="w-full font-mono text-center text-xs px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:border-amber-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
                                    نام واریزکننده:
                                </label>
                                <input type="text"
                                       name="description"
                                       value="{{ $user->name }}"
                                       placeholder="نام پرداخت‌کننده"
                                       class="w-full text-xs px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:border-amber-500">
                            </div>
                        </div>
                    </div>

                    {{-- خلاصه فاکتور نهایی --}}
                    <div class="rounded-2xl bg-slate-50 dark:bg-slate-800/60 p-4 border border-slate-200 dark:border-slate-700/60 space-y-2.5 text-xs">
                        <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                            <span>بسته انتخابی:</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200" x-text="selectedPlanName"></span>
                        </div>
                        <div class="flex justify-between items-center text-slate-500 dark:text-slate-400">
                            <span>مبلغ پایه:</span>
                            <div>
                                <span class="font-bold text-slate-800 dark:text-slate-200" x-text="formatNumber(basePrice)"></span>
                                <span class="text-[10px]">تومان</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center text-emerald-600 dark:text-emerald-400 font-bold" x-show="discountAmount > 0">
                            <span>تخفیف کسر شده:</span>
                            <div>
                                <span>-</span>
                                <span x-text="formatNumber(discountAmount)"></span>
                                <span class="text-[10px]">تومان</span>
                            </div>
                        </div>
                        <div class="pt-2 border-t border-slate-200 dark:border-slate-700 flex justify-between items-baseline">
                            <span class="text-xs font-black text-slate-900 dark:text-white">مبلغ قابل واریز:</span>
                            <div class="text-left">
                                <span class="text-2xl font-black text-amber-500" x-text="formatNumber(finalPrice)"></span>
                                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">تومان</span>
                            </div>
                        </div>
                    </div>

                    {{-- دکمه ثبت و ارسال فیش --}}
                    <div class="space-y-3 pt-2">
                        <button type="submit"
                                :disabled="isSubmitting || !hasReceiptFile"
                                class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 hover:from-amber-400 hover:to-amber-400 text-slate-950 font-black text-sm transition-all shadow-xl shadow-amber-500/25 flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                            <i data-lucide="check-circle" class="w-5 h-5 text-slate-950" x-show="!isSubmitting"></i>
                            <i data-lucide="loader-2" class="w-5 h-5 animate-spin" x-show="isSubmitting" x-cloak></i>
                            <span x-text="isSubmitting ? 'در حال ارسال فیش واریزی...' : 'ثبت فیش واریزی و ارسال جهت تایید مدیریت'"></span>
                        </button>

                        <div class="flex items-center justify-center gap-2 text-[11px] text-slate-400 text-center">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-500 shrink-0"></i>
                            <span>اشتراک شما پس از بررسی فیش توسط مدیریت بلافاصله فعال می‌گردد.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- راهنمای تماس تلفنی و پشتیبانی روبیکا --}}
    <div class="rounded-3xl bg-slate-100 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 p-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center shrink-0">
                <i data-lucide="phone-call" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-slate-900 dark:text-white">نیاز به راهنمایی یا هماهنگی فوری واریز دارید؟</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    در صورت داشتن هرگونه سوال در خصوص پرداخت کارت‌به‌کارت و فعال‌سازی فوری، در روبیکا یا تماس تلفنی در خدمت شما هستیم.
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
                <p class="text-xs mt-1 opacity-70">پس از اولین خرید یا ارسال فیش، سوابق و فاکتورهای رسمی شما در این قسمت آرشیو خواهد شد.</p>
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
                            <th class="py-3 px-3">روش پرداخت</th>
                            <th class="py-3 px-3">تصویر فیش</th>
                            <th class="py-3 px-3">تاریخ ثبت</th>
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
                                                @click="viewReceiptModal('{{ $payment->receipt_url }}', '{{ $payment->invoice_no }}')"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 text-[11px] font-bold transition-all cursor-pointer">
                                            <i data-lucide="image" class="w-3.5 h-3.5"></i>
                                            <span>مشاهده رسید</span>
                                        </button>
                                    @else
                                        <span class="text-slate-400 text-[11px]">بدون تصویر</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3 text-slate-500 font-mono">
                                    {{ $payment->created_at ? \App\Models\User::toJalali($payment->created_at) : '---' }}
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black border {{ $payment->status_badge_class }}">
                                        {{ $payment->status_label }}
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

    {{-- لایت‌باکس پاپ‌آپ پیش‌نمایش فیش واریزی --}}
    <div x-show="showReceiptLightbox" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4"
         x-cloak>
        <div @click.away="showReceiptLightbox = false" 
             class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 max-w-xl w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="file-check" class="w-5 h-5 text-amber-500"></i>
                    <h3 class="text-sm font-black text-slate-900 dark:text-white">
                        تصویر فیش فاکتور: <span class="font-mono text-amber-500" x-text="lightboxInvoice"></span>
                    </h3>
                </div>
                <button type="button" @click="showReceiptLightbox = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="rounded-2xl overflow-hidden bg-slate-950 flex items-center justify-center max-h-[70vh]">
                <img :src="lightboxImageUrl" class="max-w-full max-h-[65vh] object-contain rounded-xl" alt="تصویر فیش واریزی">
            </div>

            <div class="flex items-center justify-between pt-2">
                <a :href="lightboxImageUrl" download target="_blank" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>دانلود تصویر اصلی</span>
                </a>
                <button type="button" @click="showReceiptLightbox = false" class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs">
                    بستن پنجره
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
        basePrice: {{ $plans->firstWhere('is_popular', true)?->price ?? $plans->first()?->price ?? 3990000 }},
        selectedPlanName: '{{ $plans->firstWhere('is_popular', true)?->name ?? $plans->first()?->name ?? "اشتراک سالانه" }}',
        cardNumberRaw: '6037997205693782',
        cardCopied: false,

        // فایل رسید
        receiptPreview: null,
        receiptFileName: '',
        receiptFileSize: '',
        isImage: true,
        hasReceiptFile: false,
        dragOver: false,

        // تخفیف
        inputCouponCode: '',
        appliedCouponCode: '',
        discountAmount: 0,
        couponApplied: false,
        couponLoading: false,
        couponSuccess: false,
        couponMessage: '',

        isSubmitting: false,

        // پاپ‌آپ مشاهده فیش
        showReceiptLightbox: false,
        lightboxImageUrl: '',
        lightboxInvoice: '',

        init() {
            this.$nextTick(() => {
                if (window.lucide) { window.lucide.createIcons(); }
            });
        },

        get finalPrice() {
            return Math.max(0, this.basePrice - this.discountAmount);
        },

        copyCardNumber() {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(this.cardNumberRaw).then(() => {
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
                }).catch(err => {
                    this.fallbackCopy();
                });
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
            this.cardCopied = true;
            setTimeout(() => { this.cardCopied = false; }, 3000);
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

        handleFileChange(event) {
            const file = event.target.files[0];
            this.processFile(file);
        },

        handleFileDrop(event) {
            this.dragOver = false;
            const file = event.dataTransfer.files[0];
            if (file) {
                const input = document.getElementById('receipt_image_input');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
                this.processFile(file);
            }
        },

        processFile(file) {
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
            const input = document.getElementById('receipt_image_input');
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
