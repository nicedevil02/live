{{-- بلوک فراخوان به اقدام میانی (Inline Call To Action) --}}
<div class="my-12 relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-900 to-amber-950 p-8 sm:p-10 border border-amber-500/20 shadow-2xl text-center sm:text-right">
    <div class="absolute -top-24 -left-24 w-72 h-72 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-amber-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="space-y-2 max-w-xl text-center sm:text-right">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-bold mb-1">
                <span>⚡</span>
                <span>راه‌اندازی زیر ۳ دقیقه</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-black text-white">
                {{ $title ?? 'تبدیل تلویزیون مغازه به تابلوی اعلام نرخ زنده طلا' }}
            </h3>
            <p class="text-slate-300 text-sm leading-relaxed">
                {{ $subtitle ?? 'بدون نیاز به خرید مینی‌کیس، کابل‌کشی یا قطعات گران‌قیمت LED. تست رایگان ۱۴ روزه را همین حالا فعال کنید.' }}
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0 w-full sm:w-auto">
            <a href="{{ $buttonUrl ?? route('admin.register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/20 hover:scale-105 transition-all">
                <span>{{ $buttonText ?? 'شروع تست رایگان ۱۴ روزه' }}</span>
                <span>←</span>
            </a>
            @if(!empty($secondaryText))
                <a href="{{ $secondaryUrl ?? route('public.smart-gold-board') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3.5 rounded-2xl bg-white/10 hover:bg-white/15 text-white font-bold text-sm border border-white/10 transition-colors">
                    {{ $secondaryText }}
                </a>
            @endif
        </div>
    </div>
</div>
