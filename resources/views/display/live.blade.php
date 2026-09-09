<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1440">
    <meta name="theme-color" content="#020617">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="TalaLive">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <title>Live Gold Display</title>
    @vite('resources/css/app.css')
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
        @keyframes ticker-rtl {
            0% { transform: translateX(-100vw); }
            100% { transform: translateX(100%); }
        }
        .animate-ticker-rtl {
            animation: ticker-rtl 45s linear infinite;
        }
        html { background: #020617; }
        body { min-width: 1440px; font-family: Vazirmatn, ui-sans-serif, system-ui, sans-serif; }
        .market-tile-label { overflow-wrap: anywhere; }
        .market-tile-label { line-height: 1.12; }
        .market-price-number { line-height: 0.95; white-space: nowrap; }
        @media (min-width: 1280px) and (max-height: 760px) {
            .display-shell { gap: 0.5rem; padding: 0.75rem; }
            .display-header { padding-block: 0.75rem; }
            .price-grid { gap: 0.5rem; }
        }
        @keyframes flash-green {
            0%, 87% { color: #10b981; } /* emerald-500 */
            100% { color: inherit; }
        }
        @keyframes flash-red {
            0%, 87% { color: #f43f5e; } /* rose-500 */
            100% { color: inherit; }
        }
        .flash-green-tv {
            animation: flash-green 2.3s ease-out forwards;
        }
        .flash-red-tv {
            animation: flash-red 2.3s ease-out forwards;
        }
        .glow-amber { text-shadow: 0 0 10px rgba(245, 158, 11, 0.4), 0 0 20px rgba(245, 158, 11, 0.2); }
        .glow-cyan { text-shadow: 0 0 10px rgba(6, 182, 212, 0.45), 0 0 20px rgba(6, 182, 212, 0.2); }
        .glow-purple { text-shadow: 0 0 10px rgba(217, 70, 239, 0.45), 0 0 20px rgba(217, 70, 239, 0.2); }
        .glow-emerald { text-shadow: 0 0 10px rgba(16, 185, 129, 0.45), 0 0 20px rgba(16, 185, 129, 0.2); }
        .glow-rose { text-shadow: 0 0 10px rgba(244, 63, 94, 0.45), 0 0 20px rgba(244, 63, 94, 0.2); }
    </style>
</head>
<body :class="themeKey === 'light-modern' ? 'bg-slate-50 text-slate-900' : 'bg-black text-white'" x-data="displayApp(@js($snapshot))" @dblclick="toggleFullscreen">
    <main x-show="!isLoading" :class="theme.bg" class="relative min-h-[100dvh] w-full overflow-hidden transition-colors duration-1000">

        {{-- Orbs --}}
        <template x-if="theme.orbs">
            <div>
                <template x-for="(cls, i) in theme.orbColors" :key="i">
                    <div class="pointer-events-none absolute rounded-full opacity-100" :class="cls + ' ' + orbPositions[i]" style="transition: background 1s"></div>
                </template>
            </div>
        </template>

        <div class="display-shell relative z-10 flex min-h-[100dvh] flex-col gap-3 p-4 xl:h-screen xl:min-h-screen xl:p-5">

            {{-- Header --}}
            <header :class="theme.headerBg" class="display-header rounded-[2rem] px-8 py-4 flex flex-row items-center justify-between gap-4 shrink-0 animate-fadeInUp shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all duration-500">

                {{-- سمت راست: QR کد و اطلاعات --}}
                <div class="order-1 flex w-[38%] items-center gap-5 text-right">
                    {{-- دکمه‌ها و اطلاعات تماس (سایز بزرگتر و خواناتر) --}}
                    <div class="flex flex-col gap-2 justify-center items-stretch shrink-0 w-fit">
                        <template x-if="settings.phone">
                            <div :class="themeKey === 'light-modern' ? 'bg-black/5 border-black/10' : 'bg-white/5 border-white/10'" 
                                 class="flex items-center gap-3 px-4 py-2 rounded-2xl border text-sm xl:text-base font-black transition-all hover:bg-white/10 w-full" dir="ltr">
                                <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.387a12.035 12.035 0 01-7.108-7.108c-.157-.44.009-.928.387-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                <span :class="theme.textPrimary" class="tracking-wide select-all" x-text="settings.phone.replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d])"></span>
                            </div>
                        </template>
                        
                        <template x-if="settings.instagram">
                            <div :class="themeKey === 'light-modern' ? 'bg-black/5 border-black/10' : 'bg-white/5 border-white/10'" 
                                 class="flex items-center gap-3 px-4 py-2 rounded-2xl border text-sm xl:text-base font-bold transition-all hover:bg-white/10 w-full" dir="ltr">
                                <svg class="w-5 h-5 text-pink-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                <span :class="theme.textPrimary" class="tracking-wide truncate" x-text="settings.instagram"></span>
                            </div>
                        </template>
 
                        <template x-if="settings.rubika">
                            <div :class="themeKey === 'light-modern' ? 'bg-black/5 border-black/10' : 'bg-white/5 border-white/10'" 
                                 class="flex items-center gap-3 px-4 py-2 rounded-2xl border text-sm xl:text-base font-bold transition-all hover:bg-white/10 w-full" dir="ltr">
                                <img src="/images/logos/rubika.png" x-on:error="$event.target.src = '/icons/icon-72x72.png'" class="w-5 h-5 object-contain shrink-0">
                                <span :class="theme.textPrimary" class="tracking-wide truncate" x-text="settings.rubika"></span>
                            </div>
                        </template>
                    </div>

                    {{-- QR Code (بدون کادر بیرونی) --}}
                    <div class="flex items-center gap-4 transition-all duration-300 hover:scale-[1.02] shrink-0">
                        <div class="bg-white p-1.5 rounded-2xl shadow-lg shrink-0">
                            <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' + encodeURIComponent(settings.qr_link || (window.location.origin + '/' + (snapshotData.username || '')))" 
                                 alt="QR Code" class="w-24 h-24 xl:w-28 xl:h-28 object-contain">
                        </div>
                        <div class="flex flex-col justify-center max-w-[150px] pr-1">
                            <span :class="theme.textPrimary" class="text-sm xl:text-base font-black leading-tight" 
                                  x-text="settings.qr_link ? (settings.qr_label || 'اسکن کنید') : 'همراه ما باشید'"></span>
                            <span :class="theme.textSecondary" class="text-[11px] xl:text-xs mt-1.5 leading-normal opacity-80 font-bold"
                                  x-text="settings.qr_desc ? settings.qr_desc : (settings.qr_link ? 'عضویت در شبکه‌های اجتماعی' : 'اسکن جهت مشاهده در موبایل')"></span>
                        </div>
                    </div>
                </div>

                {{-- نام فروشگاه (وسط) --}}
                <div class="order-2 flex w-[24%] flex-col items-center justify-center text-center">
                    <h1 :class="themeKey === 'light-modern' ? 'text-slate-900' : 'text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-yellow-400 to-amber-300 drop-shadow-[0_0_20px_rgba(251,191,36,0.2)]'" 
                        class="max-w-full break-words text-4xl xl:text-5xl font-black tracking-tight leading-tight" x-text="settings.shop_name"></h1>
                    <div :class="themeKey === 'light-modern' ? 'bg-blue-600/10 text-blue-700' : 'bg-amber-400/10 text-amber-300 border border-amber-400/20'" 
                         class="mt-1 px-4 py-0.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                         ✦ نرخ‌گذاری لحظه‌ای طلا و ارز ✦
                    </div>
                </div>

                {{-- تاریخ و ساعت (سمت چپ) --}}
                <div class="order-3 flex w-[38%] flex-row items-center justify-end gap-5 text-left">
                    {{-- کنترل‌ها و دکمه‌های وضعیت --}}
                    <div class="flex flex-col gap-2 items-end justify-center">
                        {{-- وضعیت اتصال --}}
                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[0.7rem] font-semibold shrink-0" 
                              :class="connectionState === 'online' ? 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/20'">
                            <span class="w-1.5 h-1.5 rounded-full animate-pulse" :class="connectionState === 'online' ? 'bg-emerald-500 dark:bg-emerald-400' : 'bg-amber-500 dark:bg-amber-400'"></span>
                            <span x-text="connectionState === 'online' ? 'وضعیت: برخط' : 'وضعیت: پشتیبان'"></span>
                        </span>

                        {{-- کنترل زوم و تمام صفحه --}}
                        <div class="flex items-center gap-2" dir="ltr">
                            <div class="flex items-center gap-1 opacity-60 hover:opacity-100 transition-opacity bg-black/10 dark:bg-white/5 border border-white/5 rounded-lg px-1" dir="ltr">
                                <button @click.stop="zoomOut" class="p-1 rounded-md cursor-pointer transition-colors hover:bg-black/10 dark:hover:bg-white/10" title="کوچک‌نمایی">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path></svg>
                                </button>
                                <span :class="theme.textPrimary" class="text-[10px] font-black font-mono w-8 text-center" x-text="Math.round(zoomLevel * 100) + '%'"></span>
                                <button @click.stop="zoomIn" class="p-1 rounded-md cursor-pointer transition-colors hover:bg-black/10 dark:hover:bg-white/10" title="بزرگ‌نمایی">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                </button>
                            </div>
                            <button @click.stop="toggleFullscreen" class="p-1 rounded-lg cursor-pointer opacity-60 hover:opacity-100 bg-black/10 dark:bg-white/5 border border-white/5 transition-all" title="تمام‌صفحه">
                                <svg x-show="!isFullscreen" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                <svg x-show="isFullscreen" style="display: none;" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 14h4v4m0-4l-5 5m15-5h-4v4m0-4l5 5M4 10h4V6m0 4l-5-5m15 5h-4V6m0 4l5-5"></path></svg>
                            </button>
                        </div>
                    </div>

                    {{-- خط عمودی جداکننده --}}
                    <div :class="themeKey === 'light-modern' ? 'bg-black/10' : 'bg-white/10'" class="w-[1px] h-16"></div>

                    {{-- ساعت و تاریخ --}}
                    <div class="flex flex-col items-center justify-center text-center">
                        <p :class="theme.textPrimary" class="text-6xl xl:text-7xl font-black tabular-nums tracking-tight leading-none" x-text="timeText"></p>
                        <p :class="theme.textSecondary" class="text-base xl:text-lg font-bold mt-1.5 opacity-80" x-text="weekDay + ' ' + dateText"></p>
                    </div>
                </div>

            </header>

            {{-- Main Content --}}
            <div class="flex flex-1 flex-row gap-3 min-h-0">
                {{-- Product Slider --}}
                <section :class="[theme.card, themeKey === 'light-modern' ? 'border-black/5' : 'border-white/10']" class="relative overflow-hidden rounded-[3rem] w-[35%] h-auto min-h-0 max-h-none group border shadow-3xl shrink-0">
                    <template x-if="activeProduct" x-key="activeIndex + '-' + productImageIndex">
                        <div class="absolute inset-0 animate-slideSwap">
                            <img :src="(activeProduct.images && activeProduct.images.length > 0) ? (activeProduct.images[productImageIndex % activeProduct.images.length]?.url || '/icons/icon-512x512.png') : '/icons/icon-512x512.png'" 
                                 x-on:error="$event.target.src = '/icons/icon-512x512.png'" :alt="activeProduct.title" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[20s] ease-linear group-hover:scale-105">
                            <!-- نشان پیشنهاد ویژه -->
                            <div x-show="Boolean(activeProduct.is_special)" class="absolute top-5 left-5 z-20 select-none pointer-events-none">
                                <div class="relative flex items-center gap-3 rounded-full border border-red-200/35 bg-gradient-to-br from-red-500/20 via-rose-500/14 to-white/10 px-4 py-3 backdrop-blur-xl shadow-[0_18px_40px_rgba(0,0,0,0.28),0_0_28px_rgba(239,68,68,0.18)] ring-1 ring-inset ring-white/10">
                                    <span class="relative flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-red-500 via-rose-500 to-red-700 shadow-[0_0_18px_rgba(239,68,68,0.45)] ring-1 ring-white/20 animate-[pulse_1.8s_ease-in-out_infinite]">
                                        <span class="h-2.5 w-2.5 rounded-full bg-white/90 animate-ping"></span>
                                    </span>
                                    <div class="flex flex-col pl-3 pr-2">
                                        <span class="text-xl font-black leading-tight tracking-wide text-white drop-shadow-[0_2px_6px_rgba(0,0,0,0.35)]">
                                            پیشنهاد ویژه
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent pointer-events-none"></div>
                            <div class="absolute bottom-4 right-4 left-4">
                                <div class="rounded-[1.75rem] border border-white/10 bg-slate-950/24 px-4 py-3 shadow-[0_16px_40px_rgba(0,0,0,0.30)] backdrop-blur-2xl">
                                    <div class="flex flex-row items-end justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="break-words text-4xl font-black leading-tight text-white drop-shadow-md" x-text="activeProduct.title"></p>
                                            <div class="mt-2 flex items-center gap-2">
                                                <template x-if="settings.show_weight">
                                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-white/10 bg-white/8 px-3.5 py-1.5 text-sm font-bold text-white/90 backdrop-blur-xl">
                                                        وزن: <span x-text="activeProduct.weight_gram"></span> گرم
                                                    </span>
                                                </template>
                                                <template x-if="settings.show_profit">
                                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-white/10 bg-white/8 px-3.5 py-1.5 text-sm font-bold text-white/90 backdrop-blur-xl">
                                                        سود: <span x-text="activeProductProfitPercent"></span>%
                                                    </span>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="shrink-0 rounded-2xl border border-amber-200/35 bg-gradient-to-br from-amber-300 to-amber-500 px-4 py-2.5 text-black">
                                            <span class="block text-[9px] font-black uppercase opacity-60 tracking-[0.35em] mb-1">قیمت نهایی</span>
                                            <template x-if="activeProductFinalPrice > 0">
                                                <div>
                                                    <span class="text-3xl font-black tabular-nums" x-text="formatNumber(activeProductFinalPrice)"></span>
                                                    <span class="text-xs font-black opacity-80 whitespace-nowrap"> تومان</span>
                                                </div>
                                            </template>
                                            <template x-if="activeProductFinalPrice <= 0">
                                                <span class="text-xs font-black text-amber-950 bg-amber-200/70 rounded px-2 py-1 block">در حال استعلام نرخ...</span>
                                            </template>
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
                    <div class="price-grid grid grid-cols-12 gap-3 h-full auto-rows-fr grid-rows-[1.5fr_1fr_1fr]">
                        <template x-for="(item, index) in orderedMetrics" :key="item.symbol">
                            <div :class="[
                                 item.symbol === 'gold18'
                                 ? (themeKey === 'light-modern'
                                    ? 'ring-2 ring-amber-400 bg-gradient-to-br from-amber-100/50 via-white to-amber-50 shadow-[0_15px_40px_-10px_rgba(245,158,11,0.2)]'
                                    : 'ring-2 ring-amber-500/60 bg-gradient-to-br from-amber-600/30 via-slate-900/40 to-slate-900/90 shadow-[0_20px_50px_-12px_rgba(245,158,11,0.3)]')
                                 : theme.card + ' ' + theme.cardHover,
                                 index < 3 ? 'col-span-4 px-4 xl:px-6 pb-6 pt-5' : 'col-span-3 px-3 xl:px-4 pb-4 pt-4'
                                 ]"
                                 class="relative overflow-hidden flex min-w-0 flex-col justify-between rounded-2xl transition-all duration-500 h-full">

                                <template x-if="item.symbol === 'gold18'">
                                    <div class="absolute inset-0 pointer-events-none overflow-hidden">
                                        <div class="absolute inset-0" :class="themeKey === 'light-modern' ? 'bg-[radial-gradient(circle_at_50%_0%,rgba(245,158,11,0.15),transparent_75%)]' : 'bg-[radial-gradient(circle_at_50%_0%,rgba(245,158,11,0.25),transparent_75%)]'"></div>
                                        <div class="absolute inset-0 animate-gold-shine bg-gradient-to-r from-transparent via-amber-400/20 to-transparent w-1/2 h-full"></div>
                                    </div>
                                </template>

                                <div class="relative flex justify-between items-start gap-4">
                                    <p :class="[item.symbol === 'gold18' ? (themeKey === 'light-modern' ? 'text-amber-800' : 'text-amber-400') : theme.textSecondary, index < 3 ? 'text-2xl' : 'text-lg']"
                                       class="market-tile-label min-w-0 font-black drop-shadow-sm line-clamp-2 shrink-0 max-w-none" style="line-height:1.2;" x-text="item.label"></p>
                                    <div x-show="item.value > 0" class="flex items-center shrink-0">
                                        <template x-if="item.change_percent > 0">
                                            <div :class="index < 3 ? 'p-2 rounded-lg' : 'p-1 xl:p-1.5 rounded-md'" class="flex items-center justify-center bg-emerald-500/10 border border-emerald-500/20 animate-pulse">
                                                <svg :class="index < 3 ? 'w-6 h-6 xl:w-8 xl:h-8' : 'w-5 h-5 xl:w-6 xl:h-6'" class="text-emerald-500 filter drop-shadow-[0_0_8px_rgba(16,185,129,0.6)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                    <polyline points="17 6 23 6 23 12"></polyline>
                                                </svg>
                                            </div>
                                        </template>
                                        <template x-if="item.change_percent < 0">
                                            <div :class="index < 3 ? 'p-2 rounded-lg' : 'p-1 xl:p-1.5 rounded-md'" class="flex items-center justify-center bg-rose-500/10 border border-rose-500/20 animate-pulse">
                                                <svg :class="index < 3 ? 'w-6 h-6 xl:w-8 xl:h-8' : 'w-5 h-5 xl:w-6 xl:h-6'" class="text-rose-500 filter drop-shadow-[0_0_8px_rgba(244,63,94,0.6)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                    <polyline points="17 18 23 18 23 12"></polyline>
                                                </svg>
                                            </div>
                                        </template>
                                        <template x-if="item.change_percent == 0">
                                            <div class="flex items-center justify-center p-2">
                                                <svg class="w-5 h-5 text-slate-400 opacity-40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div :class="[
                                    item.symbol === 'gold18' ? (themeKey === 'light-modern' ? 'text-amber-700' : 'text-amber-400') : theme.priceColor,
                                    index < 3 ? 'py-4' : 'pt-3 pb-1'
                                ]" class="relative flex-1 flex min-w-0 flex-col justify-center items-center">
                                    <div class="text-center whitespace-nowrap w-full">
                                         <span :class="[index < 3 ? 'text-4xl xl:text-5xl leading-none' : 'text-2xl xl:text-3xl', theme.priceGlow]" class="market-price-number font-black tabular-nums drop-shadow-md" x-html="item.displayHtml"></span>
                                         <span :class="[index < 3 ? 'text-xl xl:text-2xl' : 'text-sm xl:text-base']" class="font-bold opacity-70 mx-1 xl:mx-1.5 align-baseline" x-text="item.unit"></span>
                                    </div>
                                </div>

                                <div class="relative flex justify-between items-center border-t" :class="[index < 3 ? 'mt-2 pt-2' : 'mt-0 pt-1', themeKey === 'light-modern' ? 'border-amber-200/40' : 'border-white/5']">
                                    <div class="flex items-center gap-2 font-bold" :class="[
                                        item.change_percent > 0 ? 'text-emerald-500' : (item.change_percent < 0 ? 'text-rose-500' : 'text-slate-400'),
                                        index < 3 ? 'text-lg' : 'text-base'
                                    ]" dir="ltr">
                                        <span x-text="formatSignedNumber(item.change_percent, 2) + '%'"></span>
                                        <span class="opacity-20">|</span>
                                        <span class="tabular-nums" x-text="(item.symbol === 'ounce' || item.symbol === 'bitcoin') ? formatSignedNumber(item.change_value, 2) : formatSignedNumber(item.change_value)"></span>
                                    </div>
                                    <div class="flex items-center">
                                        <span x-show="(/خرید.*(18|۱۸)/.test(item.label)) ? (orderedMetrics.find(m => m.symbol === 'gold18')?.is_stale ?? item.is_stale) : item.is_stale"
                                              class="text-xs rounded-full px-2.5 py-1 font-medium border"
                                          :class="themeKey === 'light-modern' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-amber-500/10 text-amber-500 border-amber-500/20'">● قدیمی</span>
                                    <span x-show="!((/خرید.*(18|۱۸)/.test(item.label)) ? (orderedMetrics.find(m => m.symbol === 'gold18')?.is_stale ?? item.is_stale) : item.is_stale)" class="text-xs rounded-full px-2.5 py-1 font-medium border"
                                          :class="themeKey === 'light-modern' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20'"><span class="w-2 h-2 bg-emerald-500 rounded-full inline-block animate-pulse ml-1.5"></span>زنده</span>
                                </div>
                            </div>
                        </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Premium Glassmorphic Footer --}}
            <footer :class="theme.footerBg" class="relative overflow-hidden rounded-[1.5rem] border flex items-center justify-between shrink-0 h-14 animate-fadeInUp shadow-[0_15px_35px_rgba(0,0,0,0.3)] px-6 backdrop-blur-2xl" style="animation-delay: 200ms;" dir="rtl">
                
                {{-- Background decorative glows inside the footer --}}
                <div class="absolute inset-0 pointer-events-none opacity-20 bg-[radial-gradient(circle_at_20%_50%,rgba(245,158,11,0.15),transparent_50%)]"></div>

                {{-- Right Side (visually): Developer Info --}}
                <div class="flex items-center gap-3 h-full z-10">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                        <span :class="themeKey === 'light-modern' ? 'text-slate-500' : 'text-slate-400'" class="text-xs font-bold">طراحی و توسعه:</span>
                        <span :class="themeKey === 'light-modern' ? 'text-blue-600' : 'text-amber-400'" class="font-black tracking-wide text-sm">Bahman Dev</span>
                    </div>
                </div>

                {{-- Center: App Signature & Powered By --}}
                <div class="hidden md:flex items-center gap-2 justify-center z-10 text-xs font-black" :class="theme.textPrimary">
                    <span>سیستم هوشمند نمایش نرخ طلا و ارز</span>
                    <span class="opacity-30">|</span>
                    <span :class="themeKey === 'light-modern' ? 'text-slate-400' : 'text-slate-500'" class="font-normal font-mono">Powered by <span class="font-bold text-slate-400 dark:text-slate-300">TalaLive.ir</span> <span class="text-[10px] opacity-65">v2.1.4</span></span>
                </div>

                {{-- Left Side (visually): Market Update Status with live status dot --}}
                <div class="flex items-center gap-3 z-10 font-bold text-xs" :class="theme.textSecondary">
                    <span class="flex items-center gap-1.5 bg-black/10 dark:bg-white/5 border border-white/5 rounded-full px-3.5 py-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-[pulse_1.5s_infinite]"></span>
                        <span dir="ltr" x-text="errorMessage || 'بروزرسانی: ' + (snapshotData?.updatedAt ? new Date(snapshotData.updatedAt).toLocaleTimeString('fa-IR', {hour: '2-digit', minute:'2-digit', second:'2-digit'}) : '---')"></span>
                    </span>
                </div>

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
            'dark-glass': { 
                bg: 'bg-[radial-gradient(ellipse_at_top_right,#111827_0%,#0f172a_40%,#020617_100%)]', 
                headerBg: 'bg-slate-900/60 backdrop-blur-2xl border border-white/10 shadow-[0_4px_30px_rgba(0,0,0,0.4)]', 
                card: 'bg-slate-900/40 backdrop-blur-2xl border border-white/10 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)] shadow-indigo-500/5', 
                cardHover: 'hover:bg-slate-900/60 hover:border-indigo-500/30 hover:shadow-indigo-500/10', 
                accent: 'text-amber-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/70', 
                textMuted: 'text-white/40', 
                footerBg: 'bg-slate-900/80 backdrop-blur-2xl border border-white/10 shadow-[0_8px_32px_0_rgba(0,0,0,0.37)]', 
                priceColor: 'text-white', 
                priceGlow: 'glow-amber',
                orbs: true, 
                orbColors: ['bg-indigo-600/10 blur-[120px]', 'bg-violet-600/10 blur-[100px]', 'bg-amber-500/5 blur-[120px]'] 
            },
            'light-modern': { 
                bg: 'bg-gradient-to-br from-slate-100 via-white to-blue-50', 
                headerBg: 'bg-white/90 backdrop-blur-xl border border-slate-200', 
                card: 'bg-white/40 backdrop-blur-xl border border-white/60 shadow-xl', 
                cardHover: 'hover:bg-white/60 hover:shadow-2xl', 
                accent: 'text-blue-600', 
                textPrimary: 'text-slate-900', 
                textSecondary: 'text-slate-900/70', 
                textMuted: 'text-slate-900/40', 
                footerBg: 'bg-white/80 backdrop-blur-md border border-slate-200', 
                priceColor: 'text-slate-900', 
                priceGlow: '',
                orbs: true, 
                orbColors: ['bg-blue-400/20 blur-[120px]', 'bg-purple-300/20 blur-[120px]', 'bg-emerald-300/20 blur-[120px]'] 
            },
            'gold-royal': { 
                bg: 'bg-[radial-gradient(ellipse_at_top,#2b1502_0%,#140800_50%,#050200_100%)]', 
                headerBg: 'bg-yellow-950/40 backdrop-blur-2xl border border-amber-500/20 shadow-[0_4px_30px_rgba(0,0,0,0.5)]', 
                card: 'bg-gradient-to-br from-yellow-950/40 to-amber-950/30 backdrop-blur-2xl border border-amber-500/15 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)] shadow-amber-500/5', 
                cardHover: 'hover:from-yellow-950/50 hover:to-amber-950/40 hover:border-amber-400/40 hover:shadow-amber-400/10', 
                accent: 'text-amber-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/70', 
                textMuted: 'text-white/40', 
                footerBg: 'bg-yellow-950/50 backdrop-blur-2xl border border-amber-500/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)]', 
                priceColor: 'text-white', 
                priceGlow: 'glow-amber',
                orbs: true, 
                orbColors: ['bg-amber-500/15 blur-[100px]', 'bg-orange-600/15 blur-[120px]', 'bg-yellow-500/10 blur-[80px]'] 
            },
            'blue-ocean': { 
                bg: 'bg-[radial-gradient(ellipse_at_top,#0a192f_0%,#020c1b_60%,#00030a_100%)]', 
                headerBg: 'bg-blue-950/40 backdrop-blur-2xl border border-cyan-500/20 shadow-[0_4px_30px_rgba(0,0,0,0.5)]', 
                card: 'bg-gradient-to-br from-blue-950/40 to-slate-950/30 backdrop-blur-2xl border border-cyan-500/15 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)] shadow-cyan-500/5', 
                cardHover: 'hover:from-blue-950/50 hover:to-slate-950/40 hover:border-cyan-400/40 hover:shadow-cyan-400/10', 
                accent: 'text-cyan-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/70', 
                textMuted: 'text-white/40', 
                footerBg: 'bg-blue-950/50 backdrop-blur-2xl border border-cyan-500/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)]', 
                priceColor: 'text-white', 
                priceGlow: 'glow-cyan',
                orbs: true, 
                orbColors: ['bg-cyan-500/15 blur-[100px]', 'bg-blue-600/15 blur-[120px]', 'bg-indigo-600/10 blur-[80px]'] 
            },
            'purple-haze': { 
                bg: 'bg-[radial-gradient(ellipse_at_top,#1e0b36_0%,#0f051d_50%,#04010a_100%)]', 
                headerBg: 'bg-purple-950/40 backdrop-blur-2xl border border-fuchsia-500/20 shadow-[0_4px_30px_rgba(0,0,0,0.5)]', 
                card: 'bg-gradient-to-br from-purple-950/40 to-slate-950/30 backdrop-blur-2xl border border-fuchsia-500/15 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)] shadow-fuchsia-500/5', 
                cardHover: 'hover:from-purple-950/50 hover:to-slate-950/40 hover:border-fuchsia-400/40 hover:shadow-fuchsia-400/10', 
                accent: 'text-fuchsia-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/70', 
                textMuted: 'text-white/40', 
                footerBg: 'bg-purple-950/50 backdrop-blur-2xl border border-fuchsia-500/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)]', 
                priceColor: 'text-white', 
                priceGlow: 'glow-purple',
                orbs: true, 
                orbColors: ['bg-fuchsia-600/15 blur-[100px]', 'bg-violet-600/15 blur-[120px]', 'bg-purple-800/10 blur-[80px]'] 
            },
            'emerald-night': { 
                bg: 'bg-[radial-gradient(ellipse_at_top,#022c22_0%,#011c15_50%,#000504_100%)]', 
                headerBg: 'bg-emerald-950/40 backdrop-blur-2xl border border-emerald-500/20 shadow-[0_4px_30px_rgba(0,0,0,0.5)]', 
                card: 'bg-gradient-to-br from-emerald-950/40 to-slate-950/30 backdrop-blur-2xl border border-emerald-500/15 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)] shadow-emerald-500/5', 
                cardHover: 'hover:from-emerald-950/50 hover:to-slate-950/40 hover:border-emerald-400/40 hover:shadow-emerald-400/10', 
                accent: 'text-emerald-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/70', 
                textMuted: 'text-white/40', 
                footerBg: 'bg-emerald-950/50 backdrop-blur-2xl border border-emerald-500/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)]', 
                priceColor: 'text-white', 
                priceGlow: 'glow-emerald',
                orbs: true, 
                orbColors: ['bg-emerald-500/15 blur-[100px]', 'bg-teal-600/15 blur-[120px]', 'bg-green-600/10 blur-[80px]'] 
            },
            'rose-dark': { 
                bg: 'bg-[radial-gradient(ellipse_at_top,#3f0212_0%,#1c0007_50%,#050002_100%)]', 
                headerBg: 'bg-rose-950/40 backdrop-blur-2xl border border-rose-500/20 shadow-[0_4px_30px_rgba(0,0,0,0.5)]', 
                card: 'bg-gradient-to-br from-rose-950/40 to-slate-950/30 backdrop-blur-2xl border border-rose-500/15 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)] shadow-rose-500/5', 
                cardHover: 'hover:from-rose-950/50 hover:to-slate-950/40 hover:border-rose-400/40 hover:shadow-rose-400/10', 
                accent: 'text-rose-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/70', 
                textMuted: 'text-white/40', 
                footerBg: 'bg-rose-950/50 backdrop-blur-2xl border border-rose-500/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)]', 
                priceColor: 'text-white', 
                priceGlow: 'glow-rose',
                orbs: true, 
                orbColors: ['bg-rose-500/15 blur-[100px]', 'bg-pink-600/15 blur-[120px]', 'bg-red-600/10 blur-[80px]'] 
            },
            'pure-black': { 
                bg: 'bg-black', 
                headerBg: 'bg-[#0a0a0a]/80 backdrop-blur-2xl border border-white/5', 
                card: 'bg-white/[0.08] backdrop-blur-xl border border-white/10 shadow-lg', 
                cardHover: 'hover:border-white/20 hover:bg-white/[0.12]', 
                accent: 'text-zinc-300', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/70', 
                textMuted: 'text-white/40', 
                footerBg: 'bg-[#050505]/90 backdrop-blur-xl border border-white/5', 
                priceColor: 'text-white', 
                priceGlow: '', 
                orbs: false, 
                orbColors: [] 
            },
        };
        const orbPositions = ["top-[-10%] left-[10%] w-[40vw] h-[40vw]", "bottom-[5%] right-[5%] w-[35vw] h-[35vw]", "top-[40%] left-[50%] w-[30vw] h-[30vw]"];

        function formatNumber(value, decimals = 0) {
            if (decimals > 0) return new Intl.NumberFormat('fa-IR', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }).format(value);
            return new Intl.NumberFormat('fa-IR').format(Math.round(value));
        }

        function formatSignedNumber(value, decimals = 0) {
            const number = Number(value || 0);
            const prefix = number > 0 ? '+' : number < 0 ? '-' : '';
            return prefix + formatNumber(Math.abs(number), decimals);
        }

        function displayApp(initialSnapshot) {
            // پیش‌مقداردهی displayHtml برای مقادیر اولیه
            if (initialSnapshot && initialSnapshot.priceFeed) {
                initialSnapshot.priceFeed.forEach(item => {
                    const decimals = (item.symbol === 'ounce' || item.symbol === 'bitcoin') ? 2 : 0;
                    item.displayHtml = formatNumber(item.value, decimals);
                });
            }
            return {
                snapshotData: initialSnapshot,
                isLoading: false, // چون داده‌ها را از سرور گرفته‌ایم
                connectionState: 'online',
                errorMessage: '',
                activeIndex: 0,
                productImageIndex: 0,
                sliderTimer: null,
                now: new Date(),
                refreshTimer: null,
                isFullscreen: false,
                zoomLevel: parseFloat(localStorage.getItem('display_zoom') || '1'),

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
                    const gold18 = this.snapshotData.priceFeed?.find(p => p.symbol === 'gold18')?.value;
                    // اگر نرخ طلای ۱۸ عیار موجود نباشد، قیمت صفر بازگردانده می‌شود تا نرخ نامعتبر نمایش داده نشود
                    if (!gold18 || Number(gold18) <= 0) return 0;
                    const base = (Number(gold18) * Number(this.activeProduct.weight_gram)) + Number(this.activeProduct.labor_fee);
                    const profit = this.activeProduct.profit_type === 'percent' ? base * (Number(this.activeProduct.profit_value) / 100) : Number(this.activeProduct.profit_value);
                    return Math.round(base + profit);
                },
                get weekDay() { return this.now.toLocaleDateString('fa-IR', { weekday: 'long' }); },
                get dateText() { return this.now.toLocaleDateString('fa-IR', { year: 'numeric', month: 'long', day: 'numeric' }); },
                get timeText() { return this.now.toLocaleTimeString('fa-IR', { hour: '2-digit', minute: '2-digit', second: '2-digit' }); },
                get refreshIntervalMs() {
                    const seconds = Number(this.snapshotData?.refreshIntervalSeconds || 60);
                    return Math.max(seconds, 5) * 1000;
                },

                startSlider() {
                    if (this.sliderTimer) {
                        clearInterval(this.sliderTimer);
                    }
                    const intervalSec = Number(this.settings?.slider_interval_sec) || 8;
                    this.sliderTimer = setInterval(() => {
                        if (this.products.length > 0) {
                            // چرخش تصاویر در صورتی که محصول چند تصویر داشته باشد
                            if (this.activeProduct && this.activeProduct.images && this.activeProduct.images.length > 1) {
                                this.productImageIndex++;
                                if (this.productImageIndex % this.activeProduct.images.length === 0) {
                                    this.activeIndex = (this.activeIndex + 1) % this.products.length;
                                    this.productImageIndex = 0;
                                }
                            } else {
                                this.activeIndex = (this.activeIndex + 1) % this.products.length;
                                this.productImageIndex = 0;
                            }
                        }
                    }, Math.max(intervalSec, 3) * 1000);
                },

                scheduleSnapshotRefresh() {
                    if (this.refreshTimer) {
                        clearTimeout(this.refreshTimer);
                    }
                    this.refreshTimer = setTimeout(() => this.refreshSnapshot(), this.refreshIntervalMs);
                },

                async refreshSnapshot() {
                    try {
                        const username = this.snapshotData?.username || 'admin';
                        const displayToken = new URLSearchParams(window.location.search).get('key') || '';
                        const res = await fetch('/api/display/snapshot/' + username + '?key=' + displayToken + '&t=' + Date.now());
                        if (!res.ok) throw new Error('Network response was not ok: ' + res.status);
                        const newData = await res.json();

                        if (newData && newData.settings) {
                            const oldPub = this.snapshotData?.settings?.published_at;
                            const newPub = newData.settings.published_at;
                            // بررسی تغییر وضعیت انتشار (شامل اولین انتشار)
                            if ((!oldPub && newPub) || (oldPub && newPub && oldPub !== newPub)) {
                                window.location.reload();
                                return;
                            }

                            if (this.settings.slider_interval_sec !== newData.settings.slider_interval_sec) {
                                this.snapshotData.settings.slider_interval_sec = newData.settings.slider_interval_sec;
                                this.startSlider();
                            }
                        }
 
                        if (newData && newData.priceFeed) {
                            if (this.snapshotData && this.snapshotData.priceFeed) {
                                newData.priceFeed.forEach(newItem => {
                                    const oldItem = this.snapshotData.priceFeed.find(n => n.symbol === newItem.symbol);
                                    const decimals = (newItem.symbol === 'ounce' || newItem.symbol === 'bitcoin') ? 2 : 0;
                                    const currentFormatted = formatNumber(newItem.value, decimals);
                                    newItem.displayHtml = currentFormatted;
                                    
                                    if (oldItem && Number(newItem.value) !== Number(oldItem.value)) {
                                        const prevFormatted = formatNumber(oldItem.value, decimals);
                                        
                                        // مقایسه کاراکتر به کاراکتر از چپ به راست
                                        let i = 0;
                                        const len = Math.min(prevFormatted.length, currentFormatted.length);
                                        while (i < len && prevFormatted[i] === currentFormatted[i]) {
                                            i++;
                                        }
                                        
                                        if (i < currentFormatted.length) {
                                            const prefix = currentFormatted.slice(0, i);
                                            const suffix = currentFormatted.slice(i);
                                            const changeDir = Number(newItem.value) > Number(oldItem.value) ? 'up' : 'down';
                                            const colorClass = changeDir === 'up' ? 'flash-green-tv' : 'flash-red-tv';
                                            
                                            newItem.displayHtml = `${prefix}<span class="${colorClass}">${suffix}</span>`;
                                            
                                            // بازگرداندن به حالت ساده متنی بعد از ۲.۳ ثانیه (۲ ثانیه رنگ ثابت + ۰.۳ ثانیه محو شدن)
                                            const symbolToReset = newItem.symbol;
                                            const targetValue = newItem.value;
                                            setTimeout(() => {
                                                const targetItem = this.snapshotData.priceFeed.find(n => n.symbol === symbolToReset);
                                                if (targetItem && targetItem.value === targetValue) {
                                                    targetItem.displayHtml = currentFormatted;
                                                }
                                            }, 2300);
                                        }
                                    }
                                });
                            } else {
                                newData.priceFeed.forEach(item => {
                                    const decimals = (item.symbol === 'ounce' || item.symbol === 'bitcoin') ? 2 : 0;
                                    item.displayHtml = formatNumber(item.value, decimals);
                                });
                            }
                            this.snapshotData = newData;
                        }
 
                        this.connectionState = 'online';
                        this.errorMessage = '';
                    } catch (e) {
                        console.error('Fetch error:', e);
                        if (!navigator.onLine) {
                            this.connectionState = 'offline';
                            this.errorMessage = 'اتصال اینترنت قطع شده است';
                        } else {
                            this.connectionState = 'fallback';
                            this.errorMessage = 'عدم ارتباط با سرور، نمایش آخرین داده‌ها';
                        }
                    } finally {
                        this.scheduleSnapshotRefresh();
                    }
                },

                toggleFullscreen() {
                    if (!document.fullscreenElement) {
                        document.documentElement.requestFullscreen().catch(err => console.log(err));
                    } else {
                        if (document.exitFullscreen) {
                            document.exitFullscreen();
                        }
                    }
                },

                zoomIn() {
                    if (this.zoomLevel < 1.5) {
                        this.zoomLevel = Math.min(1.5, this.zoomLevel + 0.05);
                        localStorage.setItem('display_zoom', this.zoomLevel.toString());
                    }
                },

                zoomOut() {
                    if (this.zoomLevel > 0.5) {
                        this.zoomLevel = Math.max(0.5, this.zoomLevel - 0.05);
                        localStorage.setItem('display_zoom', this.zoomLevel.toString());
                    }
                },

                init() {
                    // جلوگیری از به خواب رفتن تلویزیون (Wake Lock API)
                    let wakeLock = null;
                    const requestWakeLock = async () => {
                        try {
                            if ('wakeLock' in navigator) {
                                wakeLock = await navigator.wakeLock.request('screen');
                                console.log('Screen Wake Lock activated successfully.');
                            }
                        } catch (err) {
                            console.warn(`Wake Lock error: ${err.name}, ${err.message}`);
                        }
                    };
                    requestWakeLock();
                    document.addEventListener('visibilitychange', async () => {
                        if (wakeLock !== null && document.visibilityState === 'visible') {
                            await requestWakeLock();
                        }
                    });

                    document.addEventListener('fullscreenchange', () => {
                        this.isFullscreen = !!document.fullscreenElement;
                    });
                    
                    this.$watch('zoomLevel', val => document.documentElement.style.fontSize = Math.round(val * 100) + '%');
                    document.documentElement.style.fontSize = Math.round(this.zoomLevel * 100) + '%';

                    // Sync theme class
                    this.$watch('themeKey', val => document.documentElement.className = (val === 'light-modern' ? 'light' : 'dark'));
                    document.documentElement.className = (this.themeKey === 'light-modern' ? 'light' : 'dark');

                    // شروع هوشمند اسلایدر با قابلیت تنظیم داینامیک
                    this.startSlider();
                    this.$watch('settings.slider_interval_sec', () => this.startSlider());

                    // ساعت
                    setInterval(() => { this.now = new Date(); }, 1000);

                    this.scheduleSnapshotRefresh();
                }
            };
        }

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(error => {
                    console.error('Service worker registration failed:', error);
                });
            });
        }
    </script>
</body>
</html>
