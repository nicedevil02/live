{{-- بردکرامب دیداری و اسکیمای ساخت‌یافته BreadcrumbList گوگل --}}
@if(!empty($items) && is_array($items))
<nav aria-label="مسیر راهنما" class="py-2.5 px-4 my-4 rounded-xl bg-stone-100/80 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 text-xs text-stone-600 dark:text-stone-400">
    <ol class="flex items-center flex-wrap gap-2">
        <li class="inline-flex items-center gap-1.5">
            <a href="{{ url('/') }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">
                <span>صفحه اصلی</span>
            </a>
            <span class="text-stone-400 dark:text-stone-600">/</span>
        </li>
        @foreach($items as $index => $item)
            @php $isLast = ($index === count($items) - 1); @endphp
            <li class="inline-flex items-center gap-1.5">
                @if(!$isLast && !empty($item['url']))
                    <a href="{{ $item['url'] }}" class="hover:text-amber-700 dark:hover:text-amber-400 transition-colors">
                        {{ $item['title'] }}
                    </a>
                    <span class="text-stone-400 dark:text-stone-600">/</span>
                @else
                    <span class="text-stone-900 dark:text-stone-100 font-semibold" aria-current="page">
                        {{ $item['title'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@@type": "ListItem",
      "position": 1,
      "name": "صفحه اصلی",
      "item": "https://talalive.ir"
    }
    @foreach($items as $idx => $it)
    ,{
      "@@type": "ListItem",
      "position": {{ $idx + 2 }},
      "name": "{{ $it['title'] }}"@if(!empty($it['url'])),
      "item": "{{ $it['url'] }}"
      @endif
    }
    @endforeach
  ]
}
</script>
@endif
