@php
    $navGroups = collect(config('navigation.groups'))->keyBy('key');
@endphp

{{-- دراپ‌داون سامانه‌ها (مگامنوی دو ستونی) --}}
@if(isset($navGroups['products']))
@php
    $productsGroup = $navGroups['products'];
    $compareGroup = $navGroups['compare'] ?? null;
    $isProductsActive = false;
    $activeRoutes = array_merge($productsGroup['active_routes'] ?? [], $compareGroup['active_routes'] ?? []);
    foreach ($activeRoutes as $r) {
        if (request()->routeIs($r)) { $isProductsActive = true; break; }
    }
@endphp
<div class="relative"
     @mouseenter="openMenu('products')"
     @mouseleave="closeMenu('products')"
     @click.outside="closeMenu('products')"
     @keydown.escape.window="closeMenu('products')">
    <button type="button"
            @click="isOpen('products') ? closeMenu('products') : openMenu('products')"
            aria-haspopup="true"
            aria-controls="dropdown-products"
            :aria-expanded="isOpen('products') ? 'true' : 'false'"
            class="flex items-center gap-1 px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all cursor-pointer {{ $isProductsActive ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
        <span>{{ $productsGroup['label'] }}</span>
        <svg aria-hidden="true" class="w-3.5 h-3.5 transition-transform duration-200" :class="isOpen('products') ? 'rotate-180 text-amber-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>

    <div id="dropdown-products"
         x-show="isOpen('products')" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="absolute right-0 mt-2 w-[32rem] rounded-2xl bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl p-3 z-50">
        
        <div class="grid grid-cols-2 gap-1">
            {{-- ستون راست: تابلوها و سامانه‌ها --}}
            <div class="space-y-1">
                @foreach($productsGroup['items'] as $item)
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                        <span class="text-sm">{{ $item['icon'] }}</span>
                        <div>
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">{{ $item['title'] }}</div>
                            @if(!empty($item['desc']))
                                <div class="text-[10px] text-slate-400">{{ $item['desc'] }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- ستون چپ: مقایسه با رقبا --}}
            @if($compareGroup)
            <div class="space-y-1 border-r border-slate-100 dark:border-slate-800 pr-2">
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 mb-1 px-2">مقایسه با رقبا</div>
                @foreach($compareGroup['items'] as $item)
                    <a href="{{ route($item['route']) }}" class="block p-2 rounded-xl hover:bg-amber-50 dark:hover:bg-slate-800/60 group transition-all">
                        <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">{{ $item['title'] }}</div>
                        @if(!empty($item['desc']))
                            <div class="text-[10px] text-slate-400">{{ $item['desc'] }}</div>
                        @endif
                    </a>
                @endforeach
            </div>
            @endif
        </div>

        @if(!empty($productsGroup['footer_items']))
            <div class="mt-2 pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between px-2">
                @foreach($productsGroup['footer_items'] as $fItem)
                    <a href="{{ route($fItem['route']) }}" class="text-xs font-bold {{ $fItem['class'] }} hover:underline">{{ $fItem['title'] }}</a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endif

{{-- دراپ‌داون ابزارها --}}
@if(isset($navGroups['tools']))
@php
    $toolsGroup = $navGroups['tools'];
    $isToolsActive = false;
    if (!empty($toolsGroup['active_routes'])) {
        foreach ($toolsGroup['active_routes'] as $r) {
            if (request()->routeIs($r)) { $isToolsActive = true; break; }
        }
    }
    if (!$isToolsActive && !empty($toolsGroup['active_patterns'])) {
        foreach ($toolsGroup['active_patterns'] as $p) {
            if (request()->is($p)) { $isToolsActive = true; break; }
        }
    }
@endphp
<div class="relative"
     @mouseenter="openMenu('tools')"
     @mouseleave="closeMenu('tools')"
     @click.outside="closeMenu('tools')"
     @keydown.escape.window="closeMenu('tools')">
    <button type="button"
            @click="isOpen('tools') ? closeMenu('tools') : openMenu('tools')"
            aria-haspopup="true"
            aria-controls="dropdown-tools"
            :aria-expanded="isOpen('tools') ? 'true' : 'false'"
            class="flex items-center gap-1 px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all cursor-pointer {{ $isToolsActive ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
        <span>{{ $toolsGroup['label'] }}</span>
        <svg aria-hidden="true" class="w-3.5 h-3.5 transition-transform duration-200" :class="isOpen('tools') ? 'rotate-180 text-amber-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>

    <div id="dropdown-tools"
         x-show="isOpen('tools')" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="absolute right-0 mt-2 w-72 rounded-2xl bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl p-2 z-50 space-y-1">
        @foreach($toolsGroup['items'] as $item)
            <a href="{{ route($item['route']) }}" class="flex items-center gap-2.5 p-2 rounded-xl {{ !empty($item['highlight']) ? 'bg-amber-500/10 hover:bg-amber-500/20' : 'hover:bg-amber-50 dark:hover:bg-slate-800/60' }} group transition-all">
                <span class="text-sm">{{ $item['icon'] }}</span>
                @if(!empty($item['desc']))
                    <div>
                        <div class="text-xs {{ !empty($item['highlight']) ? 'font-black text-amber-700 dark:text-amber-300' : 'font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400' }}">{{ $item['title'] }}</div>
                        <div class="text-[10px] text-slate-400">{{ $item['desc'] }}</div>
                    </div>
                @else
                    <div class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400">{{ $item['title'] }}</div>
                @endif
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- دراپ‌داون آموزش و شهرها --}}
@if(isset($navGroups['guides']))
@php
    $guidesGroup = $navGroups['guides'];
    $isGuidesActive = false;
    if (!empty($guidesGroup['active_routes'])) {
        foreach ($guidesGroup['active_routes'] as $r) {
            if (request()->routeIs($r)) { $isGuidesActive = true; break; }
        }
    }
@endphp
<div class="relative"
     @mouseenter="openMenu('guides')"
     @mouseleave="closeMenu('guides')"
     @click.outside="closeMenu('guides')"
     @keydown.escape.window="closeMenu('guides')">
    <button type="button"
            @click="isOpen('guides') ? closeMenu('guides') : openMenu('guides')"
            aria-haspopup="true"
            aria-controls="dropdown-guides"
            :aria-expanded="isOpen('guides') ? 'true' : 'false'"
            class="flex items-center gap-1 px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all cursor-pointer {{ $isGuidesActive ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}">
        <span>{{ $guidesGroup['label'] }}</span>
        <svg aria-hidden="true" class="w-3.5 h-3.5 transition-transform duration-200" :class="isOpen('guides') ? 'rotate-180 text-amber-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>

    <div id="dropdown-guides"
         x-show="isOpen('guides')" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="absolute right-0 mt-2 w-64 rounded-2xl bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-xl p-2 z-50 space-y-1">
        @foreach($guidesGroup['items'] as $item)
            <a href="{{ route($item['route']) }}" class="block p-2 rounded-xl {{ !empty($item['highlight']) ? 'bg-amber-500/10 hover:bg-amber-500/20' : (!empty($item['color_type']) && $item['color_type'] === 'blue' ? 'hover:bg-blue-50 dark:hover:bg-slate-800/60' : 'hover:bg-amber-50 dark:hover:bg-slate-800/60') }} group transition-all">
                <div class="text-xs font-bold {{ !empty($item['highlight']) ? 'text-amber-700 dark:text-amber-300' : (!empty($item['color_type']) && $item['color_type'] === 'blue' ? 'text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400' : 'text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400') }}">{{ $item['title'] }}</div>
                @if(!empty($item['desc']))
                    <div class="text-[10px] text-slate-400">{{ $item['desc'] }}</div>
                @endif
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- تعرفه‌ها --}}
<a href="{{ route('public.pricing') }}" class="px-2.5 py-2 rounded-xl hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white dark:hover:bg-slate-800/70 transition-all {{ request()->routeIs('public.pricing') ? 'text-amber-600 dark:text-amber-400 bg-white dark:bg-slate-800/70 shadow-sm' : '' }}"{!! request()->routeIs('public.pricing') ? ' aria-current="page"' : '' !!}>
    تعرفه‌ها
</a>
