@php
    $navGroups = collect(config('navigation.groups'))->keyBy('key');
@endphp

{{-- دراپ‌داون سامانه‌ها (مگامنوی دو ستونی شیشه‌ای اپل) --}}
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
            class="flex items-center gap-1 px-3 py-2 rounded-xl whitespace-nowrap transition-all cursor-pointer {{ $isProductsActive ? 'tl-neu-pill-active text-amber-800 dark:text-amber-300 font-bold' : 'hover:text-amber-800 dark:hover:text-amber-300 hover:bg-white/60 dark:hover:bg-white/5' }}">
        <span>{{ $productsGroup['label'] }}</span>
        <span class="transition-transform duration-200" :class="isOpen('products') ? 'rotate-180' : ''">
            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-3.5 h-3.5'])
        </span>
    </button>

    <div id="dropdown-products"
         x-show="isOpen('products')" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1.5 scale-[0.98]"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-1 scale-[0.98]"
         class="absolute right-0 mt-2.5 w-[33rem] rounded-2xl tl-glass-sheet p-3.5 z-50 before:content-[''] before:absolute before:-top-3 before:inset-x-0 before:h-3">
        
        <div class="grid grid-cols-2 gap-2">
            {{-- ستون راست: تابلوها و سامانه‌ها --}}
            <div class="space-y-1">
                @foreach($productsGroup['items'] as $item)
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-white/65 dark:hover:bg-white/[0.06] group transition-colors">
                        <span class="tl-neu-icon-orb w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                            @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                        </span>
                        <div class="min-w-0">
                            <div class="text-xs font-semibold text-stone-900 dark:text-stone-100 group-hover:text-amber-800 dark:group-hover:text-amber-300 transition-colors">{{ $item['title'] }}</div>
                            @if(!empty($item['desc']))
                                <div class="text-[12px] text-stone-600 dark:text-stone-400 truncate">{{ $item['desc'] }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- ستون چپ: مقایسه با رقبا --}}
            @if($compareGroup)
            <div class="space-y-1 border-r border-stone-300/60 dark:border-white/10 pr-2.5">
                <div class="text-xs font-semibold text-stone-600 dark:text-stone-400 mb-1.5 px-2">مقایسه با رقبا</div>
                @foreach($compareGroup['items'] as $item)
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-white/65 dark:hover:bg-white/[0.06] group transition-colors">
                        <span class="tl-neu-icon-orb w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                            @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-3.5 h-3.5 text-stone-600 dark:text-stone-300 group-hover:text-amber-700 dark:group-hover:text-amber-400'])
                        </span>
                        <div class="min-w-0">
                            <div class="text-xs font-semibold text-stone-900 dark:text-stone-100 group-hover:text-amber-800 dark:group-hover:text-amber-300 transition-colors">{{ $item['title'] }}</div>
                            @if(!empty($item['desc']))
                                <div class="text-[12px] text-stone-600 dark:text-stone-400 truncate">{{ $item['desc'] }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            @endif
        </div>

        @if(!empty($productsGroup['footer_items']))
            <div class="mt-2.5 pt-2.5 border-t border-stone-300/60 dark:border-white/10 flex items-center justify-between px-2">
                @foreach($productsGroup['footer_items'] as $fItem)
                    <a href="{{ route($fItem['route']) }}" class="flex items-center gap-1.5 text-xs font-semibold {{ $fItem['class'] ?? 'text-stone-800 dark:text-stone-200' }} hover:underline">
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
            class="flex items-center gap-1 px-3 py-2 rounded-xl whitespace-nowrap transition-all cursor-pointer {{ $isToolsActive ? 'tl-neu-pill-active text-amber-800 dark:text-amber-300 font-bold' : 'hover:text-amber-800 dark:hover:text-amber-300 hover:bg-white/60 dark:hover:bg-white/5' }}">
        <span>{{ $toolsGroup['label'] }}</span>
        <span class="transition-transform duration-200" :class="isOpen('tools') ? 'rotate-180' : ''">
            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-3.5 h-3.5'])
        </span>
    </button>

    <div id="dropdown-tools"
         x-show="isOpen('tools')" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1.5 scale-[0.98]"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-1 scale-[0.98]"
         class="absolute right-0 mt-2.5 w-80 rounded-2xl tl-glass-sheet p-2.5 z-50 space-y-1 before:content-[''] before:absolute before:-top-3 before:inset-x-0 before:h-3">
        @foreach($toolsGroup['items'] as $item)
            <a href="{{ route($item['route']) }}" class="flex items-center gap-2.5 p-2 rounded-xl {{ !empty($item['highlight']) ? 'tl-glass-badge' : 'hover:bg-white/65 dark:hover:bg-white/[0.06]' }} group transition-colors">
                <span class="tl-neu-icon-orb w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                    @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                </span>
                <div class="min-w-0">
                    <div class="text-xs font-semibold {{ !empty($item['highlight']) ? 'text-amber-900 dark:text-amber-300' : 'text-stone-900 dark:text-stone-100 group-hover:text-amber-800 dark:group-hover:text-amber-300' }}">{{ $item['title'] }}</div>
                    @if(!empty($item['desc']))
                        <div class="text-[12px] text-stone-600 dark:text-stone-400 truncate">{{ $item['desc'] }}</div>
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
            class="flex items-center gap-1 px-3 py-2 rounded-xl whitespace-nowrap transition-all cursor-pointer {{ $isGuidesActive ? 'tl-neu-pill-active text-amber-800 dark:text-amber-300 font-bold' : 'hover:text-amber-800 dark:hover:text-amber-300 hover:bg-white/60 dark:hover:bg-white/5' }}">
        <span>{{ $guidesGroup['label'] }}</span>
        <span class="transition-transform duration-200" :class="isOpen('guides') ? 'rotate-180' : ''">
            @include('partials.ui-icon', ['name' => 'chevron-down', 'class' => 'w-3.5 h-3.5'])
        </span>
    </button>

    <div id="dropdown-guides"
         x-show="isOpen('guides')" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1.5 scale-[0.98]"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-1 scale-[0.98]"
         class="absolute right-0 mt-2.5 w-72 rounded-2xl tl-glass-sheet p-2.5 z-50 space-y-1 before:content-[''] before:absolute before:-top-3 before:inset-x-0 before:h-3">
        @foreach($guidesGroup['items'] as $item)
            <a href="{{ route($item['route']) }}" class="flex items-center gap-2.5 p-2 rounded-xl {{ !empty($item['highlight']) ? 'tl-glass-badge' : 'hover:bg-white/65 dark:hover:bg-white/[0.06]' }} group transition-colors">
                <span class="tl-neu-icon-orb w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                    @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                </span>
                <div class="min-w-0">
                    <div class="text-xs font-semibold text-stone-900 dark:text-stone-100 group-hover:text-amber-800 dark:group-hover:text-amber-300">{{ $item['title'] }}</div>
                    @if(!empty($item['desc']))
                        <div class="text-[12px] text-stone-600 dark:text-stone-400 truncate">{{ $item['desc'] }}</div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- تعرفه‌ها --}}
<a href="{{ route('public.pricing') }}" class="px-3 py-2 rounded-xl whitespace-nowrap transition-all {{ request()->routeIs('public.pricing') ? 'tl-neu-pill-active text-amber-800 dark:text-amber-300 font-bold' : 'hover:text-amber-800 dark:hover:text-amber-300 hover:bg-white/60 dark:hover:bg-white/5' }}"{!! request()->routeIs('public.pricing') ? ' aria-current="page"' : '' !!}>
    تعرفه‌ها
</a>
