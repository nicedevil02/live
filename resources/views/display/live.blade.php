<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Gold Display</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite('resources/css/app.css')
    @endif
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    <script defer src="{{ asset('vendor/alpinejs.min.js') }}"></script>
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideSwap { 0% { opacity: 0; transform: scale(1.05); } 20% { opacity: 1; transform: scale(1); } 100% { opacity: 1; transform: scale(1); } }
        @keyframes float1 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-5%, 5%); } }
        @keyframes float2 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(5%, -5%); } }
        @keyframes float3 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-3%, -3%); } }
        @keyframes gold-shine {
            0% { transform: translateX(-200%) skewX(-15deg); }
            35% { transform: translateX(200%) skewX(-15deg); }
            100% { transform: translateX(200%) skewX(-15deg); }
        }
        .animate-gold-shine { animation: gold-shine 4s infinite linear; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out; }
        .animate-slideSwap { animation: slideSwap 0.5s ease-out; }
        .animate-float1 { animation: float1 20s ease-in-out infinite; }
        .animate-float2 { animation: float2 25s ease-in-out infinite; }
        .animate-float3 { animation: float3 18s ease-in-out infinite; }
    </style>
</head>
<body :class="themeKey === 'light-modern' ? 'bg-slate-50 text-slate-900' : 'bg-black text-white'" x-data="displayApp(@js($snapshot))">
    <main x-show="!isLoading" :class="theme.bg" class="relative min-h-screen w-full overflow-hidden transition-colors duration-1000">

        {{-- Orbs --}}
        <template x-if="theme.orbs">
            <div>
                <template x-for="(cls, i) in theme.orbColors" :key="i">
                    <div class="pointer-events-none absolute rounded-full opacity-100" :class="cls + ' ' + orbPositions[i]" style="transition: background 1s"></div>
                </template>
            </div>
        </template>

        <div class="relative z-10 flex flex-col h-screen gap-3 p-4 md:p-5">

            {{-- Header --}}
            <header :class="theme.headerBg" class="rounded-2xl px-6 py-4 flex items-center justify-between gap-4 shrink-0 animate-fadeInUp">
                <div class="flex flex-col gap-2.5 flex-1 items-start">
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold" :class="connectionState === 'online' ? 'bg-emerald-500/15 text-emerald-400' : 'bg-amber-500/15 text-amber-400'">
                        <span class="w-1.5 h-1.5 rounded-full animate-pulse" :class="connectionState === 'online' ? 'bg-emerald-400' : 'bg-amber-400'"></span>
                        <span x-text="connectionState === 'online' ? 'برخط' : 'پشتیبان'"></span>
                    </span>
                    <div :class="theme.textPrimary" class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-1 text-base xl:text-lg font-bold">
                        <template x-if="settings.phone">
                            <span class="flex items-center gap-2" dir="ltr">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3.22a1 1 0 0 1-1.08 1.02C18.59 21.33 16.3 20.49 14.3 19.31c-1.87-1.09-3.5-2.47-4.79-4.06-1.3-1.59-2.47-3.23-3.39-5.08C5.21 8.6 4.38 6.39 3.94 3.98 3.85 3.5 4.2 3.07 4.74 3.02h3.7c.46 0 .86.34.95.79a12 12 0 0 0 .93 3.13c.18.38.09.8-.18 1.06l-1.31 1.31a13.39 13.39 0 0 0 7.02 7.02l1.31-1.31c.26-.26.68-.36 1.06-.18a12 12 0 0 0 3.13.93c.45.09.79.49.79.95v3.7Z"/></svg>
                                <span class="tracking-wider" x-text="settings.phone"></span>
                            </span>
                        </template>
                        <template x-if="settings.instagram">
                            <span class="flex items-center gap-2" dir="ltr">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37a4 4 0 1 1-3.12-3.87"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                                <span class="tracking-wider" x-text="settings.instagram"></span>
                            </span>
                        </template>
                        <template x-if="settings.rubika">
                            <span class="flex items-center gap-2" dir="ltr">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.15 2a2 2 0 0 0-2.14.22l-14 10a2 2 0 0 0-.01 3.63l14 10a2 2 0 0 0 3-1.71V3.25a2 2 0 0 0-1.85-1.25z"/><path d="M10.92 14.96 16 20l-1.89-1.5z"/></svg>
                                <span class="tracking-wider" x-text="settings.rubika"></span>
                            </span>
                        </template>
                    </div>
                </div>

                <div class="flex flex-col items-center justify-center shrink-0">
                    <h1 :class="theme.accent" class="text-4xl md:text-5xl xl:text-6xl font-black tracking-tight" x-text="settings.shop_name"></h1>
                    <p :class="theme.textMuted" class="text-sm md:text-base font-semibold tracking-widest uppercase mt-2">Live Gold Pricing System</p>
                </div>

                <div class="flex flex-col items-end gap-1 text-right flex-1">
                    <p :class="theme.textSecondary" class="text-lg md:text-xl font-bold" x-text="weekDay + ' ' + dateText"></p>
                    <p :class="theme.textPrimary" class="text-6xl md:text-7xl xl:text-8xl font-black tabular-nums tracking-tight" x-text="timeText"></p>
                </div>
            </header>

            {{-- Main Content --}}
            <div class="flex flex-1 gap-3 min-h-0">
                {{-- Product Slider --}}
                <section :class="theme.card" class="relative overflow-hidden rounded-[3rem] w-[40%] xl:w-[35%] group border shadow-3xl shrink-0" :class="themeKey === 'light-modern' ? 'border-black/5' : 'border-white/10'">
                    <template x-if="activeProduct" x-key="activeIndex">
                        <div class="absolute inset-0 animate-slideSwap">
                            <img :src="activeProduct.images?.[0]?.url" :alt="activeProduct.title" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[20s] ease-linear group-hover:scale-105">
                            <!-- نشان پیشنهاد شگفت‌انگیز -->
                            <div class="absolute top-5 left-5 z-20 select-none pointer-events-none">
                                <div class="relative flex items-center gap-3 rounded-full border border-red-200/35 bg-gradient-to-br from-red-500/20 via-rose-500/14 to-white/10 px-4 py-3 backdrop-blur-xl shadow-[0_18px_40px_rgba(0,0,0,0.28),0_0_28px_rgba(239,68,68,0.18)] ring-1 ring-inset ring-white/10">
                                    <span class="relative flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-red-500 via-rose-500 to-red-700 shadow-[0_0_18px_rgba(239,68,68,0.45)] ring-1 ring-white/20 animate-[pulse_1.8s_ease-in-out_infinite]">
                                        <span class="h-2.5 w-2.5 rounded-full bg-white/90 animate-ping"></span>
                                    </span>
                                    <div class="flex flex-col pl-3 pr-2">
                                        <span class="text-lg md:text-xl font-black leading-tight tracking-wide text-white drop-shadow-[0_2px_6px_rgba(0,0,0,0.35)]">
                                            پیشنهاد شگفت‌انگیز
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent pointer-events-none"></div>
                            <div class="absolute bottom-4 right-4 left-4">
                                <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/24 px-4 py-3 shadow-[0_16px_40px_rgba(0,0,0,0.30)] backdrop-blur-2xl">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                                        <div>
                                            <p class="text-2xl md:text-4xl font-black text-white drop-shadow-md" x-text="activeProduct.title"></p>
                                            <div class="mt-2 flex items-center gap-2">
                                                <template x-if="settings.show_weight">
                                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-white/10 bg-white/8 px-3.5 py-1.5 text-sm font-bold text-white/90 backdrop-blur-xl">
                                                        وزن: <span x-text="activeProduct.weight_gram"></span> گرم
                                                    </span>
                                                </template>
                                                <span class="inline-flex items-center gap-1.5 rounded-full border border-white/10 bg-white/8 px-3.5 py-1.5 text-sm font-bold text-white/90 backdrop-blur-xl">
                                                    سود: <span x-text="activeProductProfitPercent"></span>%
                                                </span>
                                            </div>
                                        </div>
                                        <div class="shrink-0 rounded-2xl border border-amber-200/35 bg-gradient-to-br from-amber-300 to-amber-500 px-4 py-2.5 text-black">
                                            <span class="block text-[9px] font-black uppercase opacity-60 tracking-[0.35em] mb-1">قیمت نهایی</span>
                                            <span class="text-2xl md:text-3xl font-black tabular-nums" x-text="formatNumber(activeProductFinalPrice)"></span>
                                            <span class="text-xs font-black opacity-80"> تومان</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="!activeProduct">
                        <div class="flex w-full h-full items-center justify-center text-white/5">
                            <span class="text-[10rem]">💎</span>
                        </div>
                    </template>
                    <div class="absolute top-6 right-6 flex gap-2" x-show="products.length > 1">
                        <template x-for="(dot, i) in products" :key="i">
                            <div class="h-1.5 rounded-full transition-all duration-300" :class="i === activeIndex ? 'w-10 bg-white' : 'w-3 bg-white/30'"></div>
                        </template>
                    </div>
                </section>

                {{-- Price Grid --}}
                <div class="flex-1 min-h-0 animate-fadeInUp" style="animation-delay: 150ms;">
                    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-12 gap-3 h-full auto-rows-fr xl:auto-rows-fr xl:grid-rows-[1.3fr_1fr_1fr]">
                        <template x-for="(item, index) in orderedMetrics" :key="item.symbol">
                            <div :class="[
                                 item.symbol === 'gold18'
                                 ? (themeKey === 'light-modern'
                                    ? 'ring-2 ring-amber-400 bg-gradient-to-br from-amber-100/50 via-white to-amber-50 shadow-[0_15px_40px_-10px_rgba(245,158,11,0.2)]'
                                    : 'ring-2 ring-amber-500/60 bg-gradient-to-br from-amber-600/30 via-slate-900/40 to-slate-900/90 shadow-[0_20px_50px_-12px_rgba(245,158,11,0.3)]')
                                 : theme.card + ' ' + theme.cardHover,
                                 index < 3 ? 'xl:col-span-4 pt-4 pb-8 px-6' : 'xl:col-span-3'
                                 ]"
                                 class="relative overflow-hidden flex flex-col justify-between rounded-2xl p-4 transition-all duration-500 h-full">

                                <template x-if="item.symbol === 'gold18'">
                                    <div class="absolute inset-0 pointer-events-none overflow-hidden">
                                        <div class="absolute inset-0" :class="themeKey === 'light-modern' ? 'bg-[radial-gradient(circle_at_50%_0%,rgba(245,158,11,0.15),transparent_75%)]' : 'bg-[radial-gradient(circle_at_50%_0%,rgba(245,158,11,0.25),transparent_75%)]'"></div>
                                        <div class="absolute inset-0 animate-gold-shine bg-gradient-to-r from-transparent via-amber-400/20 to-transparent w-1/2 h-full"></div>
                                    </div>
                                </template>

                                <div class="relative flex justify-between items-start gap-2">
                                    <p :class="item.symbol === 'gold18' ? (themeKey === 'light-modern' ? 'text-amber-800' : 'text-amber-400') : theme.textSecondary"
                                       :class="index < 3 ? 'text-4xl md:text-5xl' : 'text-3xl md:text-4xl'"
                                       class="font-black drop-shadow-sm" x-text="item.label"></p>
                                    <div x-show="item.value > 0" class="flex items-center" dir="ltr">
                                        <span class="flex items-center gap-1.5 font-bold rounded-lg px-2.5 py-1 shadow-sm transition-colors duration-500 border"
                                              :class="[
                                                item.change_percent > 0
                                                      ? (themeKey === 'light-modern' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-emerald-500/20 text-emerald-400 border-transparent')
                                                      : (item.change_percent < 0
                                                         ? (themeKey === 'light-modern' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-red-500/20 text-red-400 border-transparent')
                                                         : (themeKey === 'light-modern' ? 'bg-slate-50 text-slate-600 border-slate-100' : 'bg-slate-500/20 text-slate-400 border-transparent')),
                                                index < 3 ? 'text-[12px]' : 'text-[11px]'
                                              ]">
                                            <span x-show="item.change_percent != 0" class="text-[10px]" x-text="item.change_percent > 0 ? '▲' : '▼'"></span>
                                            <span x-text="Math.abs(item.change_percent).toFixed(2) + '%'"></span>
                                            <span x-show="item.change_value != 0" class="mx-0.5" :class="themeKey === 'light-modern' ? 'text-slate-300' : 'opacity-30'">|</span>
                                            <span class="tabular-nums" x-show="item.change_value != 0" x-text="formatNumber(Math.abs(item.change_value))"></span>
                                        </span>
                                    </div>
                                </div>

                                <div :class="[
                                    item.symbol === 'gold18' ? (themeKey === 'light-modern' ? 'text-amber-700' : 'text-amber-400') : theme.priceColor,
                                    index < 3 ? 'py-5' : 'py-2'
                                ]" class="relative flex-1 flex flex-col justify-center items-center">
                                    <div class="flex items-baseline gap-2">
                                        <span :class="index < 3 ? 'text-3xl' : 'text-xl'" class="font-bold opacity-70" x-text="item.unit === 'تومان' ? 'T' : (item.unit === 'دلار' ? '$' : '')"></span>
                                        <span :class="index < 3 ? 'text-6xl' : 'text-4xl'" class="font-black tabular-nums drop-shadow-md" x-text="formatNumber(item.value)"></span>
                                    </div>
                                </div>

                                <div class="relative flex justify-between items-center mt-2 border-t pt-2" :class="themeKey === 'light-modern' ? 'border-amber-200/40' : 'border-white/5'">
                                    <span :class="item.symbol === 'gold18' ? (themeKey === 'light-modern' ? 'text-amber-700/70' : 'text-amber-500/70') : theme.textSecondary"
                                          :class="index < 3 ? 'text-base' : 'text-sm'"
                                          class="font-bold" x-text="item.unit"></span>
                                    <span x-show="item.is_stale" class="text-xs rounded-full px-2.5 py-1 font-medium border"
                                          :class="themeKey === 'light-modern' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-amber-500/10 text-amber-500 border-amber-500/20'">● قدیمی</span>
                                    <span x-show="!item.is_stale" class="text-xs rounded-full px-2.5 py-1 font-medium border"
                                          :class="themeKey === 'light-modern' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20'"><span class="w-2 h-2 bg-emerald-500 rounded-full inline-block animate-pulse ml-1.5"></span>زنده</span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <footer :class="theme.footerBg" class="rounded-xl px-6 py-2 flex items-center justify-between gap-4 text-sm shrink-0 animate-fadeInUp" style="animation-delay: 200ms;">
                <span :class="theme.textMuted" class="text-xs font-semibold flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Live Gold Display System v2.1
                </span>
                <span :class="theme.textSecondary" class="text-xs font-bold" x-text="errorMessage || 'بروزرسانی مارکت: ' + (snapshotData?.apiTime || '---')"></span>
            </footer>

        </div>
    </main>

    {{-- Loading Screen --}}
    <div x-show="isLoading" class="fixed inset-0 z-[200] flex flex-col items-center justify-center bg-slate-950 animate-fadeIn">
        <div class="relative mb-8">
            <div class="w-24 h-24 rounded-full border-[3px] border-slate-700"></div>
            <div class="w-24 h-24 rounded-full border-[3px] border-transparent border-t-amber-400 absolute inset-0 animate-spin"></div>
            <span class="absolute inset-0 flex items-center justify-center text-3xl">✦</span>
        </div>
        <h2 class="text-2xl font-black text-amber-400 mb-2">Live Gold</h2>
        <p class="text-slate-400 animate-pulse">در حال بارگذاری قیمت‌ها...</p>
    </div>

    <script>
        const THEMES = {
            'dark-glass': { bg: 'bg-[radial-gradient(ellipse_at_top_left,#1e293b_0%,#0f172a_50%,#020617_100%)]', headerBg: 'bg-slate-800/50 backdrop-blur-2xl border border-slate-700/60', card: 'bg-slate-700/30 backdrop-blur-3xl border border-white/10 shadow-lg', cardHover: 'hover:bg-slate-700/40 hover:border-white/20', accent: 'text-amber-400', textPrimary: 'text-white', textSecondary: 'text-slate-400', textMuted: 'text-slate-500', footerBg: 'bg-slate-900/60 backdrop-blur-xl border border-slate-700/40', priceColor: 'text-amber-300', orbs: true, orbColors: ['bg-blue-600/15 blur-[80px]', 'bg-violet-600/15 blur-[80px]', 'bg-amber-500/10 blur-[100px]'] },
            'light-modern': { bg: 'bg-gradient-to-br from-slate-100 via-white to-blue-50', headerBg: 'bg-white/90 backdrop-blur-xl border border-slate-200', card: 'bg-white/40 backdrop-blur-xl border border-white/60 shadow-xl', cardHover: 'hover:bg-white/60 hover:shadow-2xl', accent: 'text-blue-600', textPrimary: 'text-slate-900', textSecondary: 'text-slate-500', textMuted: 'text-slate-400', footerBg: 'bg-white/80 backdrop-blur-md border border-slate-200', priceColor: 'text-slate-900', orbs: true, orbColors: ['bg-blue-400/20 blur-[120px]', 'bg-purple-300/20 blur-[120px]', 'bg-emerald-300/20 blur-[120px]'] },
            'gold-royal': { bg: 'bg-[radial-gradient(ellipse_at_top,#431407_0%,#1c0d00_60%,#000000_100%)]', headerBg: 'bg-amber-950/60 backdrop-blur-2xl border border-amber-800/40', card: 'bg-gradient-to-br from-amber-950/50 to-orange-950/30 backdrop-blur-xl border border-amber-700/30', cardHover: 'hover:border-amber-600/40', accent: 'text-amber-400', textPrimary: 'text-amber-100', textSecondary: 'text-amber-300/60', textMuted: 'text-amber-500/50', footerBg: 'bg-amber-950/70 backdrop-blur-xl border border-amber-800/30', priceColor: 'text-amber-400', orbs: true, orbColors: ['bg-amber-600/20 blur-[80px]', 'bg-orange-700/15 blur-[100px]', 'bg-yellow-500/10 blur-[80px]'] },
            'blue-ocean': { bg: 'bg-[radial-gradient(ellipse_at_bottom_right,#1e3a5f_0%,#0c1a3a_50%,#020b1a_100%)]', headerBg: 'bg-blue-950/60 backdrop-blur-2xl border border-blue-800/40', card: 'bg-blue-950/40 backdrop-blur-xl border border-blue-700/30', cardHover: 'hover:border-cyan-600/40', accent: 'text-cyan-400', textPrimary: 'text-white', textSecondary: 'text-blue-300/70', textMuted: 'text-blue-400/50', footerBg: 'bg-blue-950/70 backdrop-blur-xl border border-blue-800/30', priceColor: 'text-cyan-300', orbs: true, orbColors: ['bg-blue-500/20 blur-[80px]', 'bg-cyan-600/15 blur-[100px]', 'bg-indigo-600/15 blur-[80px]'] },
            'purple-haze': { bg: 'bg-[radial-gradient(ellipse_at_top_right,#2d1b69_0%,#1a0b3b_50%,#050012_100%)]', headerBg: 'bg-purple-950/60 backdrop-blur-2xl border border-purple-700/40', card: 'bg-purple-950/40 backdrop-blur-xl border border-purple-700/30', cardHover: 'hover:border-violet-500/40', accent: 'text-violet-400', textPrimary: 'text-white', textSecondary: 'text-purple-300/70', textMuted: 'text-purple-400/50', footerBg: 'bg-purple-950/70 backdrop-blur-xl border border-purple-800/30', priceColor: 'text-violet-300', orbs: true, orbColors: ['bg-purple-600/20 blur-[80px]', 'bg-violet-500/15 blur-[100px]', 'bg-fuchsia-600/10 blur-[80px]'] },
            'emerald-night': { bg: 'bg-[radial-gradient(ellipse_at_center,#052e16_0%,#021a0a_60%,#000000_100%)]', headerBg: 'bg-emerald-950/60 backdrop-blur-2xl border border-emerald-800/40', card: 'bg-emerald-950/40 backdrop-blur-xl border border-emerald-700/30', cardHover: 'hover:border-emerald-500/40', accent: 'text-emerald-400', textPrimary: 'text-white', textSecondary: 'text-emerald-300/70', textMuted: 'text-emerald-500/50', footerBg: 'bg-emerald-950/70 backdrop-blur-xl border border-emerald-800/30', priceColor: 'text-emerald-300', orbs: true, orbColors: ['bg-emerald-600/20 blur-[80px]', 'bg-green-500/15 blur-[100px]', 'bg-teal-600/10 blur-[80px]'] },
            'rose-dark': { bg: 'bg-[radial-gradient(ellipse_at_top,#4c0519_0%,#1f0209_60%,#000000_100%)]', headerBg: 'bg-rose-950/60 backdrop-blur-2xl border border-rose-800/40', card: 'bg-rose-950/40 backdrop-blur-xl border border-rose-700/30', cardHover: 'hover:border-rose-500/40', accent: 'text-rose-400', textPrimary: 'text-white', textSecondary: 'text-rose-300/70', textMuted: 'text-rose-500/50', footerBg: 'bg-rose-950/70 backdrop-blur-xl border border-rose-800/30', priceColor: 'text-rose-300', orbs: true, orbColors: ['bg-rose-600/20 blur-[80px]', 'bg-pink-500/15 blur-[100px]', 'bg-red-600/10 blur-[80px]'] },
            'pure-black': { bg: 'bg-black', headerBg: 'bg-[#0a0a0a]/80 backdrop-blur-2xl border border-white/5', card: 'bg-white/[0.08] backdrop-blur-xl border border-white/10 shadow-lg', cardHover: 'hover:border-white/20 hover:bg-white/[0.12]', accent: 'text-zinc-300', textPrimary: 'text-white', textSecondary: 'text-zinc-400', textMuted: 'text-zinc-600', footerBg: 'bg-[#050505]/90 backdrop-blur-xl border border-white/5', priceColor: 'text-zinc-100', orbs: false, orbColors: [] },
        };
        const orbPositions = ["top-[-10%] left-[10%] w-[40vw] h-[40vw]", "bottom-[5%] right-[5%] w-[35vw] h-[35vw]", "top-[40%] left-[50%] w-[30vw] h-[30vw]"];

        function formatNumber(value, decimals = 0) {
            if (decimals > 0) return new Intl.NumberFormat('fa-IR', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }).format(value);
            return new Intl.NumberFormat('fa-IR').format(Math.round(value));
        }

        function displayApp(initialSnapshot) {
            return {
                snapshotData: initialSnapshot,
                isLoading: false, // چون داده‌ها را از سرور گرفته‌ایم
                connectionState: 'online',
                errorMessage: '',
                activeIndex: 0,
                now: new Date(),

                get settings() { return this.snapshotData?.settings || {}; },
                get products() { return this.snapshotData?.products || []; },
                get activeProduct() { return this.products[this.activeIndex] || null; },
                get orderedMetrics() {
                    const items = this.snapshotData?.displayItems || [];
                    const feed = this.snapshotData?.priceFeed || [];
                    const enabledKeys = items.filter(i => i.enabled && i.key !== 'exchange_gold').sort((a,b) => a.order - b.order).map(i => i.key);
                    return feed.filter(f => enabledKeys.includes(f.symbol)).sort((a,b) => enabledKeys.indexOf(a.symbol) - enabledKeys.indexOf(b.symbol));
                },
                get themeKey() { return this.settings.theme_mode && THEMES[this.settings.theme_mode] ? this.settings.theme_mode : 'dark-glass'; },
                get theme() { return THEMES[this.themeKey]; },
                get activeProductProfitPercent() {
                    if (!this.activeProduct) return 0;
                    if (this.activeProduct.profit_type === 'percent') return this.activeProduct.profit_value;
                    const gold18 = this.snapshotData.priceFeed?.find(p => p.symbol === 'gold18')?.value || this.activeProduct.base_gold_price;
                    const base = (gold18 * this.activeProduct.weight_gram) + this.activeProduct.labor_fee;
                    return base > 0 ? (this.activeProduct.profit_value / base * 100) : 0;
                },
                get activeProductFinalPrice() {
                    if (!this.activeProduct) return 0;
                    const gold18 = this.snapshotData.priceFeed?.find(p => p.symbol === 'gold18')?.value || 0;
                    const base = (gold18 * this.activeProduct.weight_gram) + Number(this.activeProduct.labor_fee);
                    const profit = this.activeProduct.profit_type === 'percent' ? base * (this.activeProduct.profit_value / 100) : Number(this.activeProduct.profit_value);
                    return Math.round(base + profit);
                },
                get weekDay() { return this.now.toLocaleDateString('fa-IR', { weekday: 'long' }); },
                get dateText() { return this.now.toLocaleDateString('fa-IR', { year: 'numeric', month: 'long', day: 'numeric' }); },
                get timeText() { return this.now.toLocaleTimeString('fa-IR', { hour: '2-digit', minute: '2-digit', second: '2-digit' }); },

                init() {
                    // Sync theme class
                    this.$watch('themeKey', val => document.documentElement.className = (val === 'light-modern' ? 'light' : 'dark'));
                    document.documentElement.className = (this.themeKey === 'light-modern' ? 'light' : 'dark');

                    // اسلایدر
                    const interval = (this.settings.slider_interval_sec || 8) * 1000;
                    setInterval(() => {
                        if (this.products.length > 0) {
                            this.activeIndex = (this.activeIndex + 1) % this.products.length;
                        }
                    }, interval);

                    // ساعت
                    setInterval(() => { this.now = new Date(); }, 1000);

                    // بروزرسانی خودکار هر ۳۰ ثانیه با حذف کش
                    setInterval(async () => {
                        try {
                            const res = await fetch('/api/display/snapshot?t=' + Date.now());
                            if (!res.ok) throw new Error('Network response was not ok');
                            const newData = await res.json();

                            if (newData && newData.priceFeed) {
                                this.snapshotData = newData;
                            }

                            this.connectionState = 'online';
                            this.errorMessage = '';
                        } catch (e) {
                            console.error('Fetch error:', e);
                            this.connectionState = 'fallback';
                        }
                    }, 30000);
                }
            };
        }
    </script>
</body>
</html>
