@php
    $navGroups = collect(config('navigation.groups'))->keyBy('key');
@endphp

{{-- سامانه‌ها و تابلوهای تخصصی --}}
@if(isset($navGroups['products']))
            <div>
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-2.5">{{ $navGroups['products']['mobile_heading'] }}</div>
                <nav @click="closeMobileMenu()" aria-label="ناوبری موبایل" class="flex flex-col space-y-1 text-xs font-bold text-slate-700 dark:text-slate-200">
                    @foreach($navGroups['products']['items'] as $item)
                    <a href="{{ route($item['route']) }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>{{ $item['icon'] }}</span>
                        <span>{{ $item['mobile_title'] ?? $item['title'] }}</span>
                    </a>
                    @endforeach
                    @if(!empty($navGroups['products']['footer_items']))
                    <a href="{{ route('public.demo') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2 text-amber-600 dark:text-amber-400">
                        <span>▶️</span>
                        <span>پیش‌نمایش زنده تابلو</span>
                    </a>
                    <a href="{{ route('public.app') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <span>📱</span>
                        <span>دانلود اپلیکیشن و PWA</span>
                    </a>
                    @endif
                </nav>
            </div>
@endif

{{-- مقایسه‌ها و تعرفه --}}
@if(isset($navGroups['compare']))
            <div class="pt-2 border-t border-slate-100 dark:border-slate-800/80">
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-2.5">{{ $navGroups['compare']['mobile_heading'] }}</div>
                <nav @click="closeMobileMenu()" aria-label="مقایسه راهکارها و قیمت" class="flex flex-col space-y-1 text-xs font-semibold text-slate-700 dark:text-slate-300">
                    <a href="{{ route('public.pricing') }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2 font-bold text-amber-600 dark:text-amber-400">
                        <span>🏷️</span>
                        <span>تعرفه‌ها و اشتراک (۱۴ روز رایگان)</span>
                    </a>
                    @foreach($navGroups['compare']['items'] as $item)
                    <a href="{{ route($item['route']) }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>{{ $item['icon'] }}</span>
                        <span>{{ $item['mobile_title'] ?? $item['title'] }}</span>
                    </a>
                    @endforeach
                </nav>
            </div>
@endif

{{-- ابزارهای آنلاین طلا --}}
@if(isset($navGroups['tools']))
            <div class="pt-2 border-t border-slate-100 dark:border-slate-800/80">
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-2.5">{{ $navGroups['tools']['mobile_heading'] }}</div>
                <nav @click="closeMobileMenu()" aria-label="ماشین‌حساب‌های تخصصی طلا" class="flex flex-col space-y-1 text-xs font-semibold text-slate-600 dark:text-slate-300">
                    @foreach($navGroups['tools']['items'] as $item)
                    <a href="{{ route($item['route']) }}" class="p-2 rounded-xl {{ !empty($item['highlight']) ? 'bg-amber-500/10 hover:bg-amber-500/20 flex items-center gap-2 font-bold text-amber-700 dark:text-amber-300' : 'hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2' }}">
                        <span>{{ $item['icon'] }}</span>
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
            <div class="pt-2 border-t border-slate-100 dark:border-slate-800/80">
                <div class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2 px-2.5">{{ $navGroups['guides']['mobile_heading'] ?? 'آموزش، شهرها و API' }}</div>
                <nav @click="closeMobileMenu()" aria-label="آموزش، شهرها و API" class="flex flex-col space-y-1 text-xs font-semibold text-slate-600 dark:text-slate-300">
                    @foreach($combinedGuides as $item)
                    <a href="{{ route($item['route']) }}" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 flex items-center gap-2">
                        <span>{{ $item['icon'] }}</span>
                        <span>{{ $item['mobile_title'] ?? $item['title'] }}</span>
                    </a>
                    @endforeach
                </nav>
            </div>
@endif
