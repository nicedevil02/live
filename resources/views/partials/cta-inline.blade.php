{{-- بلوک فراخوان به اقدام میانی (Inline Call To Action) --}}
<div class="my-10 relative rounded-2xl bg-stone-100 dark:bg-stone-900 p-6 sm:p-8 border border-stone-200 dark:border-stone-800 text-center sm:text-right">
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
            <a href="{{ $buttonUrl ?? route('admin.register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 min-h-11 px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-bold text-sm transition-colors duration-150">
                <span>{{ $buttonText ?? 'شروع تست رایگان ۱۴ روزه' }}</span>
                @include('partials.ui-icon', ['name' => 'arrow-left', 'class' => 'w-4 h-4'])
            </a>
            @if(!empty($secondaryText))
                <a href="{{ $secondaryUrl ?? route('public.smart-gold-board') }}" class="w-full sm:w-auto inline-flex items-center justify-center min-h-11 px-5 py-2.5 rounded-xl bg-white dark:bg-stone-800 hover:bg-stone-100 dark:hover:bg-stone-700 text-stone-800 dark:text-stone-200 border border-stone-300 dark:border-stone-700 font-semibold text-sm transition-colors duration-150">
                    {{ $secondaryText }}
                </a>
            @endif
        </div>
    </div>
</div>
