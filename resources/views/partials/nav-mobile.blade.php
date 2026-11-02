@php
    $navGroups = collect(config('navigation.groups'))->keyBy('key');
@endphp

{{-- سامانه‌ها و تابلوهای تخصصی --}}
@if(isset($navGroups['products']))
    <div>
        <div class="text-xs font-semibold text-stone-600 dark:text-stone-400 mb-2 px-2.5">{{ $navGroups['products']['mobile_heading'] }}</div>
        <nav @click="closeMobileMenu()" aria-label="ناوبری موبایل" class="flex flex-col space-y-1.5 text-xs font-semibold text-stone-800 dark:text-stone-200">
            @foreach($navGroups['products']['items'] as $item)
            <a href="{{ route($item['route']) }}" class="min-h-11 px-3 py-2 rounded-xl hover:bg-white/60 dark:hover:bg-white/[0.06] flex items-center gap-2.5 transition-colors">
                <span class="tl-neu-icon-orb w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                    @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                </span>
                <span>{{ $item['mobile_title'] ?? $item['title'] }}</span>
                @if(!empty($item['badge']))
                <span class="mr-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold {{ $item['badge'] === 'به‌زودی' ? 'bg-amber-500/15 text-amber-800 dark:text-amber-300 border border-amber-500/30' : 'bg-emerald-500/15 text-emerald-800 dark:text-emerald-300 border border-emerald-500/30' }}">{{ $item['badge'] }}</span>
                @endif
            </a>
            @endforeach

            @if(!empty($navGroups['products']['web_tools']))
            <div class="pt-2 mt-2 border-t border-stone-200/60 dark:border-white/10">
                <div class="text-[11px] font-semibold text-stone-500 dark:text-stone-400 mb-1.5 px-2.5">{{ $navGroups['products']['tools_heading'] ?? 'وب‌سرویس و ابزارهای اتصال' }}</div>
                @foreach($navGroups['products']['web_tools'] as $toolItem)
                <a href="{{ route($toolItem['route']) }}" class="min-h-11 px-3 py-2 rounded-xl {{ !empty($toolItem['highlight']) ? 'tl-glass-badge font-bold text-amber-900 dark:text-amber-300' : 'hover:bg-white/60 dark:hover:bg-white/[0.06]' }} flex items-center gap-2.5 transition-colors">
                    <span class="tl-neu-icon-orb w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                        @include('partials.ui-icon', ['name' => $toolItem['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                    </span>
                    <span>{{ $toolItem['mobile_title'] ?? $toolItem['title'] }}</span>
                    @if(!empty($toolItem['badge']))
                    <span class="mr-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold {{ $toolItem['badge'] === 'به‌زودی' ? 'bg-amber-500/15 text-amber-800 dark:text-amber-300 border border-amber-500/30' : 'bg-emerald-500/15 text-emerald-800 dark:text-emerald-300 border border-emerald-500/30' }}">{{ $toolItem['badge'] }}</span>
                    @endif
                </a>
                @endforeach
            </div>
            @endif

            @if(!empty($navGroups['products']['footer_items']))
            <div class="pt-2 mt-2 border-t border-stone-200/60 dark:border-white/10 flex flex-col space-y-1">
                @foreach($navGroups['products']['footer_items'] as $fItem)
                <a href="{{ route($fItem['route']) }}" class="min-h-11 px-3 py-2 rounded-xl hover:bg-white/60 dark:hover:bg-white/[0.06] flex items-center gap-2.5 {{ !empty($fItem['highlight']) ? 'text-amber-800 dark:text-amber-300 font-bold' : 'text-stone-700 dark:text-stone-300' }} transition-colors">
                    <span class="tl-neu-icon-orb w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                        @include('partials.ui-icon', ['name' => $fItem['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                    </span>
                    <span>{{ $fItem['title'] }}</span>
                </a>
                @endforeach
            </div>
            @endif
        </nav>
    </div>
@endif

{{-- مقایسه‌ها و تعرفه --}}
@if(isset($navGroups['compare']))
    <div class="pt-3 border-t border-stone-300/60 dark:border-white/10">
        <div class="text-xs font-semibold text-stone-600 dark:text-stone-400 mb-2 px-2.5">{{ $navGroups['compare']['mobile_heading'] }}</div>
        <nav @click="closeMobileMenu()" aria-label="مقایسه راهکارها و قیمت" class="flex flex-col space-y-1.5 text-xs font-semibold text-stone-800 dark:text-stone-200">
            <a href="{{ route('public.pricing') }}" class="min-h-11 px-3 py-2 rounded-xl tl-glass-badge flex items-center gap-2.5 font-bold text-amber-900 dark:text-amber-300 transition-colors">
                <span class="tl-neu-icon-orb w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                    @include('partials.ui-icon', ['name' => 'receipt', 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                </span>
                <span>تعرفه‌ها و اشتراک (۱۴ روز رایگان)</span>
            </a>
            @foreach($navGroups['compare']['items'] as $item)
            <a href="{{ route($item['route']) }}" class="min-h-11 px-3 py-2 rounded-xl hover:bg-white/60 dark:hover:bg-white/[0.06] flex items-center gap-2.5 transition-colors">
                <span class="tl-neu-icon-orb w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                    @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-stone-600 dark:text-stone-300'])
                </span>
                <span>{{ $item['mobile_title'] ?? $item['title'] }}</span>
            </a>
            @endforeach
        </nav>
    </div>
@endif

{{-- ابزارهای آنلاین طلا --}}
@if(isset($navGroups['tools']))
    <div class="pt-3 border-t border-stone-300/60 dark:border-white/10">
        <div class="text-xs font-semibold text-stone-600 dark:text-stone-400 mb-2 px-2.5">{{ $navGroups['tools']['mobile_heading'] }}</div>
        <nav @click="closeMobileMenu()" aria-label="ماشین‌حساب‌های تخصصی طلا" class="flex flex-col space-y-1.5 text-xs font-semibold text-stone-800 dark:text-stone-200">
            @foreach($navGroups['tools']['items'] as $item)
            <a href="{{ route($item['route']) }}" class="min-h-11 px-3 py-2 rounded-xl {{ !empty($item['highlight']) ? 'tl-glass-badge font-bold text-amber-900 dark:text-amber-300' : 'hover:bg-white/60 dark:hover:bg-white/[0.06]' }} flex items-center gap-2.5 transition-colors">
                <span class="tl-neu-icon-orb w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                    @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                </span>
                <span>{{ $item['mobile_title'] ?? $item['title'] }}</span>
            </a>
            @endforeach
        </nav>
    </div>
@endif

{{-- دانشنامه، شهرها و توسعه‌دهندگان --}}
@if(isset($navGroups['guides']) || isset($navGroups['dev']))
@php
    $combinedGuides = collect();
    if (isset($navGroups['guides']['items'])) {
        $combinedGuides = $combinedGuides->merge($navGroups['guides']['items']);
    }
    if (isset($navGroups['dev']['items'])) {
        $combinedGuides = $combinedGuides->merge($navGroups['dev']['items']);
    }
    $combinedGuides = $combinedGuides->sortBy(function($item) {
        return $item['mobile_order'] ?? 99;
    });
@endphp
    <div class="pt-3 border-t border-stone-300/60 dark:border-white/10">
        <div class="text-xs font-semibold text-stone-600 dark:text-stone-400 mb-2 px-2.5">{{ $navGroups['guides']['mobile_heading'] ?? 'آموزش، شهرها و API' }}</div>
        <nav @click="closeMobileMenu()" aria-label="آموزش، شهرها و API" class="flex flex-col space-y-1.5 text-xs font-semibold text-stone-800 dark:text-stone-200">
            @foreach($combinedGuides as $item)
            <a href="{{ route($item['route']) }}" class="min-h-11 px-3 py-2 rounded-xl hover:bg-white/60 dark:hover:bg-white/[0.06] flex items-center gap-2.5 transition-colors">
                <span class="tl-neu-icon-orb w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                    @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                </span>
                <span>{{ $item['mobile_title'] ?? $item['title'] }}</span>
            </a>
            @endforeach
        </nav>
    </div>
@endif
