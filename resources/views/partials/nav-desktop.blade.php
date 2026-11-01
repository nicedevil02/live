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
            class="flex items-center gap-1 px-2.5 py-2 rounded-xl whitespace-nowrap hover:text-amber-700 dark:hover:text-amber-400 hover:bg-stone-100 dark:hover:bg-stone-800/70 transition-colors cursor-pointer {{ $isProductsActive ? 'text-amber-700 dark:text-amber-400 bg-stone-100 dark:bg-stone-800/70 shadow-xs' : '' }}">
        <span>{{ $productsGroup['label'] }}</span>
        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-3.5 h-3.5 transition-transform duration-200'])
    </button>

    <div id="dropdown-products"
         x-show="isOpen('products')" 
         x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-1"
         class="absolute right-0 mt-2 w-[32rem] rounded-xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 shadow-lg p-3 z-50">
        
        <div class="grid grid-cols-2 gap-1">
            {{-- ستون راست: تابلوها و سامانه‌ها --}}
            <div class="space-y-1">
                @foreach($productsGroup['items'] as $item)
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-stone-100 dark:hover:bg-stone-800/70 group transition-colors">
                        @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                        <div>
                            <div class="text-xs font-semibold text-stone-800 dark:text-stone-200 group-hover:text-amber-700 dark:group-hover:text-amber-400">{{ $item['title'] }}</div>
                            @if(!empty($item['desc']))
                                <div class="text-[12px] text-stone-600 dark:text-stone-400">{{ $item['desc'] }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- ستون چپ: مقایسه با رقبا --}}
            @if($compareGroup)
            <div class="space-y-1 border-r border-stone-200 dark:border-stone-800 pr-2">
                <div class="text-xs font-semibold text-stone-600 dark:text-stone-400 mb-1 px-2">مقایسه با رقبا</div>
                @foreach($compareGroup['items'] as $item)
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-stone-100 dark:hover:bg-stone-800/70 group transition-colors">
                        @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-3.5 h-3.5 text-stone-500 dark:text-stone-400 group-hover:text-amber-700 dark:group-hover:text-amber-400'])
                        <div>
                            <div class="text-xs font-semibold text-stone-800 dark:text-stone-200 group-hover:text-amber-700 dark:group-hover:text-amber-400">{{ $item['title'] }}</div>
                            @if(!empty($item['desc']))
                                <div class="text-[12px] text-stone-600 dark:text-stone-400">{{ $item['desc'] }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            @endif
        </div>

        @if(!empty($productsGroup['footer_items']))
            <div class="mt-2 pt-2 border-t border-stone-200 dark:border-stone-800 flex items-center justify-between px-2">
                @foreach($productsGroup['footer_items'] as $fItem)
                    <a href="{{ route($fItem['route']) }}" class="flex items-center gap-1.5 text-xs font-semibold {{ $fItem['class'] ?? 'text-stone-700 dark:text-stone-300' }} hover:underline">
                        @include('partials.ui-icon', ['name' => $fItem['icon'], 'class' => 'w-3.5 h-3.5'])
                        <span>{{ $fItem['title'] }}</span>
                    </a>
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
            class="flex items-center gap-1 px-2.5 py-2 rounded-xl whitespace-nowrap hover:text-amber-700 dark:hover:text-amber-400 hover:bg-stone-100 dark:hover:bg-stone-800/70 transition-colors cursor-pointer {{ $isToolsActive ? 'text-amber-700 dark:text-amber-400 bg-stone-100 dark:bg-stone-800/70 shadow-xs' : '' }}">
        <span>{{ $toolsGroup['label'] }}</span>
        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-3.5 h-3.5 transition-transform duration-200'])
    </button>

    <div id="dropdown-tools"
         x-show="isOpen('tools')" 
         x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-1"
         class="absolute right-0 mt-2 w-72 rounded-xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 shadow-lg p-2 z-50 space-y-1">
        @foreach($toolsGroup['items'] as $item)
            <a href="{{ route($item['route']) }}" class="flex items-center gap-2.5 p-2 rounded-lg {{ !empty($item['highlight']) ? 'bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/25' : 'hover:bg-stone-100 dark:hover:bg-stone-800/70' }} group transition-colors">
                @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                <div>
                    <div class="text-xs font-semibold {{ !empty($item['highlight']) ? 'text-amber-800 dark:text-amber-300' : 'text-stone-800 dark:text-stone-200 group-hover:text-amber-700 dark:group-hover:text-amber-400' }}">{{ $item['title'] }}</div>
                    @if(!empty($item['desc']))
                        <div class="text-[12px] text-stone-600 dark:text-stone-400">{{ $item['desc'] }}</div>
                    @endif
                </div>
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
            class="flex items-center gap-1 px-2.5 py-2 rounded-xl whitespace-nowrap hover:text-amber-700 dark:hover:text-amber-400 hover:bg-stone-100 dark:hover:bg-stone-800/70 transition-colors cursor-pointer {{ $isGuidesActive ? 'text-amber-700 dark:text-amber-400 bg-stone-100 dark:bg-stone-800/70 shadow-xs' : '' }}">
        <span>{{ $guidesGroup['label'] }}</span>
        @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-3.5 h-3.5 transition-transform duration-200'])
    </button>

    <div id="dropdown-guides"
         x-show="isOpen('guides')" 
         x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-1"
         class="absolute right-0 mt-2 w-64 rounded-xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 shadow-lg p-2 z-50 space-y-1">
        @foreach($guidesGroup['items'] as $item)
            <a href="{{ route($item['route']) }}" class="flex items-center gap-2 p-2 rounded-lg {{ !empty($item['highlight']) ? 'bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/25' : 'hover:bg-stone-100 dark:hover:bg-stone-800/70' }} group transition-colors">
                @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                <div>
                    <div class="text-xs font-semibold text-stone-800 dark:text-stone-200 group-hover:text-amber-700 dark:group-hover:text-amber-400">{{ $item['title'] }}</div>
                    @if(!empty($item['desc']))
                        <div class="text-[12px] text-stone-600 dark:text-stone-400">{{ $item['desc'] }}</div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- تعرفه‌ها --}}
<a href="{{ route('public.pricing') }}" class="px-2.5 py-2 rounded-xl whitespace-nowrap hover:text-amber-700 dark:hover:text-amber-400 hover:bg-stone-100 dark:hover:bg-stone-800/70 transition-colors {{ request()->routeIs('public.pricing') ? 'text-amber-700 dark:text-amber-400 bg-stone-100 dark:bg-stone-800/70 shadow-xs' : '' }}"{!! request()->routeIs('public.pricing') ? ' aria-current="page"' : '' !!}>
    تعرفه‌ها
</a>
