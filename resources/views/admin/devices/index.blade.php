@extends('admin.layouts.app')

@section('title', 'تلویزیون‌های من')

@section('content')
<div class="space-y-6">

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-300 text-sm font-bold shadow-sm">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Header Card --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="p-3.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl shadow-inner">
                <i data-lucide="tv" class="w-7 h-7"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-800 dark:text-slate-100">تلویزیون‌های متصل به تابلو</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    مدیریت هوشمند، نام‌گذاری و نظارت بر دستگاه‌های تلویزیون و کیوسک‌های اختصاصی گالری
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 text-xs font-bold transition-all">
                <span>داشبورد</span>
            </a>
            <a href="{{ url('/tv') }}" target="_blank" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-600/20 transition-all">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>اتصال تلویزیون جدید</span>
            </a>
        </div>
    </div>

    {{-- Device Cards / List --}}
    @if($devices->isEmpty())
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 rounded-3xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="tv-minimal" class="w-8 h-8"></i>
            </div>
            <h3 class="text-base font-black text-slate-700 dark:text-slate-200 mb-2">هنوز هیچ دستگاهی متصل نشده است</h3>
            <p class="text-xs text-slate-400 dark:text-slate-500 max-w-md mx-auto mb-6 leading-relaxed">
                برای نمایش قیمت‌های زنده در ویترین مغازه، اپلیکیشن «طلالایو TV» را روی تلویزیون هوشمند یا اندروید باکس نصب کنید و کد ۶ رقمی را در داشبورد ثبت کنید.
            </p>
            <a href="{{ url('/tv') }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-lg shadow-blue-600/30 transition-all">
                <i data-lucide="scan-line" class="w-4 h-4"></i>
                <span>دریافت کد اتصال تلویزیون</span>
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($devices as $dev)
                @php
                    $isRevoked = !is_null($dev->revoked_at);
                    $lastSeenParsed = $dev->last_seen_at ? ($dev->last_seen_at instanceof \DateTimeInterface ? $dev->last_seen_at : \Carbon\Carbon::parse($dev->last_seen_at)) : null;
                    $lastSeenText = $lastSeenParsed ? \App\Models\User::toJalali($lastSeenParsed) : 'نامشخص';
                    $isRecent = $lastSeenParsed && now()->diffInMinutes($lastSeenParsed) < 30;
                @endphp
                <div class="bg-white dark:bg-slate-900 border {{ $isRevoked ? 'border-rose-200 dark:border-rose-900/40 opacity-75' : 'border-slate-200 dark:border-slate-800' }} rounded-3xl p-6 shadow-sm flex flex-col justify-between transition-all hover:shadow-md">
                    <div>
                        {{-- Top status row --}}
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black {{ $isRevoked ? 'bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800/40' : ($isRecent ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/40' : 'bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800/40') }}">
                                <span class="w-2 h-2 rounded-full {{ $isRevoked ? 'bg-rose-500' : ($isRecent ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500') }}"></span>
                                {{ $isRevoked ? 'غیرفعال / لغو شده' : ($isRecent ? 'برخط و متصل' : 'آماده به کار') }}
                            </span>

                            <span class="text-[10px] text-slate-400 font-mono" title="شناسه توکن سخت‌افزاری">
                                ID: #{{ $dev->id }}
                            </span>
                        </div>

                        {{-- Editable Label Form --}}
                        <form method="POST" action="{{ route('admin.devices.update', $dev) }}" class="mb-4">
                            @csrf
                            @method('PUT')
                            <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1.5">نام / محل نصب تلویزیون</label>
                            <div class="flex items-center gap-2">
                                <input type="text" name="label" value="{{ $dev->label }}" placeholder="مثلاً: تلویزیون ویترین، نمایشگر سالن"
                                       class="flex-1 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-800 dark:text-white focus:outline-none focus:border-blue-500 transition-colors">
                                <button type="submit" title="ذخیره نام" class="p-2 bg-slate-100 dark:bg-slate-800 hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-blue-900/30 dark:hover:text-blue-400 rounded-xl text-slate-500 transition-colors">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </form>

                        {{-- Specs Grid --}}
                        <div class="space-y-2.5 pt-3 border-t border-slate-100 dark:border-slate-800 text-xs">
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400">
                                <span>آخرین بازدید / تپش:</span>
                                <span class="font-bold text-slate-700 dark:text-slate-200 font-mono text-[11px]">{{ $lastSeenText }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400">
                                <span>نسخه اپلیکیشن:</span>
                                <span class="font-bold text-slate-700 dark:text-slate-200 font-mono text-[11px]">{{ $dev->app_version ?: 'v1.0 (Native)' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400">
                                <span>اندروید:</span>
                                <span class="font-bold text-slate-700 dark:text-slate-200 font-mono text-[11px]">{{ $dev->android_release ? 'Android ' . $dev->android_release : '---' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400">
                                <span>موتور وب‌ویو:</span>
                                <span class="font-bold text-slate-700 dark:text-slate-200 font-mono text-[11px] truncate max-w-[140px]" title="{{ $dev->webview_version }}">{{ $dev->webview_version ?: '---' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Bottom --}}
                    <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                        @if(!$isRevoked)
                            <form method="POST" action="{{ route('admin.devices.destroy', $dev) }}" onsubmit="return confirm('آیا از قطع اتصال این تلویزیون اطمینان دارید؟ با قطع اتصال، صفحه تلویزیون به حالت جفت‌سازی برمی‌گردد.')" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl border border-rose-200 dark:border-rose-900/40 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 text-xs font-bold transition-colors">
                                    <i data-lucide="power-off" class="w-4 h-4"></i>
                                    <span>قطع اتصال این دستگاه</span>
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.devices.restore', $dev) }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors shadow-sm">
                                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                    <span>فعال‌سازی مجدد دستگاه</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
