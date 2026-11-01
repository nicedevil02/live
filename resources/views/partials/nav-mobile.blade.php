@php
    $navGroups = collect(config('navigation.groups'))->keyBy('key');
@endphp

{{-- سامانه‌ها و تابلوهای تخصصی --}}
@if(isset($navGroups['products']))
    <div>
        <div class="text-xs font-semibold text-stone-600 dark:text-stone-400 mb-2 px-2.5">{{ $navGroups['products']['mobile_heading'] }}</div>
        <nav @click="closeMobileMenu()" aria-label="ناوبری موبایل" class="flex flex-col space-y-1 text-xs font-semibold text-stone-800 dark:text-stone-200">
            @foreach($navGroups['products']['items'] as $item)
            <a href="{{ route($item['route']) }}" class="min-h-11 px-3 py-2.5 rounded-xl hover:bg-stone-100 dark:hover:bg-stone-800/80 flex items-center gap-2.5 transition-colors">
                @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                <span>{{ $item['mobile_title'] ?? $item['title'] }}</span>
            </a>
            @endforeach
            @if(!empty($navGroups['products']['footer_items']))
            <a href="{{ route('public.demo') }}" class="min-h-11 px-3 py-2.5 rounded-xl hover:bg-stone-100 dark:hover:bg-stone-800/80 flex items-center gap-2.5 text-amber-700 dark:text-amber-400 font-bold transition-colors">
                @include('partials.ui-icon', ['name' => 'play', 'class' => 'w-4 h-4'])
                <span>پیش‌نمایش زنده تابلو</span>
            </a>
            <a href="{{ route('public.app') }}" class="min-h-11 px-3 py-2.5 rounded-xl hover:bg-stone-100 dark:hover:bg-stone-800/80 flex items-center gap-2.5 text-stone-700 dark:text-stone-300 transition-colors">
                @include('partials.ui-icon', ['name' => 'smartphone', 'class' => 'w-4 h-4'])
                <span>دانلود اپلیکیشن و PWA</span>
            </a>
            @endif
        </nav>
    </div>
@endif

{{-- مقایسه‌ها و تعرفه --}}
@if(isset($navGroups['compare']))
    <div class="pt-2 border-t border-stone-200 dark:border-stone-800">
        <div class="text-xs font-semibold text-stone-600 dark:text-stone-400 mb-2 px-2.5">{{ $navGroups['compare']['mobile_heading'] }}</div>
        <nav @click="closeMobileMenu()" aria-label="مقایسه راهکارها و قیمت" class="flex flex-col space-y-1 text-xs font-semibold text-stone-800 dark:text-stone-200">
            <a href="{{ route('public.pricing') }}" class="min-h-11 px-3 py-2.5 rounded-xl hover:bg-stone-100 dark:hover:bg-stone-800/80 flex items-center gap-2.5 font-bold text-amber-700 dark:text-amber-400 transition-colors">
                @include('partials.ui-icon', ['name' => 'receipt', 'class' => 'w-4 h-4'])
                <span>تعرفه‌ها و اشتراک (۱۴ روز رایگان)</span>
            </a>
            @foreach($navGroups['compare']['items'] as $item)
            <a href="{{ route($item['route']) }}" class="min-h-11 px-3 py-2.5 rounded-xl hover:bg-stone-100 dark:hover:bg-stone-800/80 flex items-center gap-2.5 transition-colors">
                @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-stone-500 dark:text-stone-400'])
                <span>{{ $item['mobile_title'] ?? $item['title'] }}</span>
            </a>
            @endforeach
        </nav>
    </div>
@endif

{{-- ابزارهای آنلاین طلا --}}
@if(isset($navGroups['tools']))
    <div class="pt-2 border-t border-stone-200 dark:border-stone-800">
        <div class="text-xs font-semibold text-stone-600 dark:text-stone-400 mb-2 px-2.5">{{ $navGroups['tools']['mobile_heading'] }}</div>
        <nav @click="closeMobileMenu()" aria-label="ماشین‌حساب‌های تخصصی طلا" class="flex flex-col space-y-1 text-xs font-semibold text-stone-800 dark:text-stone-200">
            @foreach($navGroups['tools']['items'] as $item)
            <a href="{{ route($item['route']) }}" class="min-h-11 px-3 py-2.5 rounded-xl {{ !empty($item['highlight']) ? 'bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/25 font-bold text-amber-800 dark:text-amber-300' : 'hover:bg-stone-100 dark:hover:bg-stone-800/80' }} flex items-center gap-2.5 transition-colors">
                @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
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
    <div class="pt-2 border-t border-stone-200 dark:border-stone-800">
        <div class="text-xs font-semibold text-stone-600 dark:text-stone-400 mb-2 px-2.5">{{ $navGroups['guides']['mobile_heading'] ?? 'آموزش، شهرها و API' }}</div>
        <nav @click="closeMobileMenu()" aria-label="آموزش، شهرها و API" class="flex flex-col space-y-1 text-xs font-semibold text-stone-800 dark:text-stone-200">
            @foreach($combinedGuides as $item)
            <a href="{{ route($item['route']) }}" class="min-h-11 px-3 py-2.5 rounded-xl hover:bg-stone-100 dark:hover:bg-stone-800/80 flex items-center gap-2.5 transition-colors">
                @include('partials.ui-icon', ['name' => $item['icon'], 'class' => 'w-4 h-4 text-amber-700 dark:text-amber-400'])
                <span>{{ $item['mobile_title'] ?? $item['title'] }}</span>
            </a>
            @endforeach
        </nav>
    </div>
@endif
