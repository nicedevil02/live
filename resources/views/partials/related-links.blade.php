{{-- بلوک پیوندهای مرتبط با کارت‌های تعاملی نئومورفیک جهت ارتقای خزش و رتبه معنایی با انیمیشن اسکرول --}}
@if(!empty($links) && is_array($links))
<div class="my-10 p-6 sm:p-8 rounded-3xl tl-neu-card tl-reveal">
    <div class="flex items-center gap-3 mb-5">
        <span class="tl-neu-icon-orb w-10 h-10 rounded-xl flex items-center justify-center shrink-0">
            @include('partials.ui-icon', ['name' => 'book', 'class' => 'w-5 h-5 text-amber-700 dark:text-amber-400'])
        </span>
        <h3 class="text-lg sm:text-xl font-bold text-stone-900 dark:text-stone-50">
            {{ $title ?? 'مطالب و ابزارهای مرتبط' }}
        </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($links as $link)
            <a href="{{ $link['url'] ?? '#' }}" class="group block p-4 rounded-2xl tl-neu-card-interactive">
                <h4 class="text-sm font-semibold text-stone-900 dark:text-stone-100 group-hover:text-amber-800 dark:group-hover:text-amber-300 transition-colors line-clamp-2 mb-1.5">
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
