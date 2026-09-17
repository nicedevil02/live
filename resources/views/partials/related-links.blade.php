{{-- بلوک پیوندهای مرتبط و درون‌محتوایی جهت ارتقای خزش و رتبه معنایی --}}
@if(!empty($links) && is_array($links))
<div class="my-10 p-6 sm:p-8 rounded-3xl bg-slate-50 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 shadow-lg shadow-slate-900/5">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-2.5 h-6 rounded-full bg-gradient-to-b from-amber-500 to-amber-600"></div>
        <h3 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">
            {{ $title ?? 'مطالب و ابزارهای مرتبط' }}
        </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($links as $link)
            <a href="{{ $link['url'] ?? '#' }}" class="group block p-5 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 hover:border-amber-500 dark:hover:border-amber-500 transition-all hover:shadow-md">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors line-clamp-2">
                        {{ $link['title'] ?? '' }}
                    </h4>
                    <span class="text-amber-500 group-hover:translate-x-1 transition-transform shrink-0 mt-0.5">←</span>
                </div>
                @if(!empty($link['desc']))
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                        {{ $link['desc'] }}
                    </p>
                @endif
            </a>
        @endforeach
    </div>
</div>
@endif
