{{-- بلوک فراخوان به اقدام میانی با متریال نئومورفیک طلایی و انیمیشن اسکرول (Inline Call To Action) --}}
<div class="my-10 relative overflow-hidden rounded-3xl tl-neu-card-gold p-6 sm:p-8 text-center sm:text-right tl-reveal">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="space-y-2 max-w-xl text-center sm:text-right">
            <h3 class="text-xl sm:text-2xl font-bold text-stone-900 dark:text-stone-50">
                {{ $title ?? 'تبدیل تلویزیون مغازه به تابلوی اعلام نرخ زنده طلا' }}
            </h3>
            <p class="text-stone-700 dark:text-stone-300 text-sm leading-relaxed">
                {{ $subtitle ?? 'بدون نیاز به خرید مینی‌کیس، کابل‌کشی یا قطعات گران‌قیمت LED. تست رایگان ۱۴ روزه را همین حالا فعال کنید.' }}
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0 w-full sm:w-auto">
            <a href="{{ $buttonUrl ?? route('admin.register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 min-h-11 px-5 py-2.5 rounded-xl tl-btn-bullion font-bold text-sm">
                <span>{{ $buttonText ?? 'شروع تست رایگان ۱۴ روزه' }}</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
            </a>
            @if(!empty($secondaryText))
                <a href="{{ $secondaryUrl ?? route('public.smart-gold-board') }}" class="w-full sm:w-auto inline-flex items-center justify-center min-h-11 px-5 py-2.5 rounded-xl tl-neu-btn text-stone-800 dark:text-stone-100 hover:text-amber-800 dark:hover:text-amber-300 font-semibold text-sm">
                    {{ $secondaryText }}
                </a>
            @endif
        </div>
    </div>
</div>
