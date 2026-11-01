{{-- بلوک پیوندهای مرتبط و درون‌محتوایی جهت ارتقای خزش و رتبه معنایی --}}
@if(!empty($links) && is_array($links))
<div class="my-10 p-6 sm:p-8 rounded-2xl bg-stone-100/70 dark:bg-stone-900/70 border border-stone-200 dark:border-stone-800">
    <div class="flex items-center gap-2.5 mb-5">
        @include('partials.ui-icon', ['name' => 'book', 'class' => 'w-5 h-5 text-amber-700 dark:text-amber-400'])
        <h3 class="text-lg sm:text-xl font-bold text-stone-900 dark:text-stone-50">
            {{ $title ?? 'مطالب و ابزارهای مرتبط' }}
        </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
        @foreach($links as $link)
            <a href="{{ $link['url'] ?? '#' }}" class="group block p-4 rounded-xl bg-white dark:bg-stone-800 border border-stone-200 dark:border-stone-700 hover:border-amber-600/50 dark:hover:border-amber-400/50 transition-colors duration-150">
                <h4 class="text-sm font-semibold text-stone-900 dark:text-stone-100 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors line-clamp-2 mb-1.5">
                    {{ $link['title'] ?? '' }}
                </h4>
                @if(!empty($link['desc']))
                    <p class="text-xs text-stone-600 dark:text-stone-400 line-clamp-2 leading-relaxed">
                        {{ $link['desc'] }}
                    </p>
                @endif
            </a>
        @endforeach
    </div>
</div>
@endif
