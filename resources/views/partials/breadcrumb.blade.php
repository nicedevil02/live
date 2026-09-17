{{-- بردکرامب دیداری و اسکیمای ساخت‌یافته BreadcrumbList گوگل --}}
@if(!empty($items) && is_array($items))
<nav aria-label="مسیر راهنما" class="py-3 px-4 my-4 rounded-2xl bg-slate-100/80 dark:bg-slate-850/80 border border-slate-200/60 dark:border-slate-800/80 text-xs text-slate-600 dark:text-slate-400 backdrop-blur-md">
    <ol class="flex items-center flex-wrap gap-2">
        <li class="inline-flex items-center gap-1.5">
            <a href="{{ url('/') }}" class="hover:text-amber-500 transition-colors">
                <span>🏠 صفحه اصلی</span>
            </a>
            <span class="text-slate-400 dark:text-slate-600">/</span>
        </li>
        @foreach($items as $index => $item)
            @php $isLast = ($index === count($items) - 1); @endphp
            <li class="inline-flex items-center gap-1.5">
                @if(!$isLast && !empty($item['url']))
                    <a href="{{ $item['url'] }}" class="hover:text-amber-500 transition-colors">
                        {{ $item['title'] }}
                    </a>
                    <span class="text-slate-400 dark:text-slate-600">/</span>
                @else
                    <span class="text-slate-900 dark:text-white font-bold" aria-current="page">
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
