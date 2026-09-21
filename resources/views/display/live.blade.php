<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#020617">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="TalaLive">
    <meta name="robots" content="{{ (($isExpired ?? false) || ($isTv ?? false) || ($isApp ?? false) || request()->has('tv') || request()->has('app')) ? 'noindex, follow' : 'index, follow, max-image-preview:large' }}">
    <title>{{ $pageTitle ?? ("قیمت لحظه‌ای طلا و سکه — " . ($galleryDisplayName ?? 'گالری طلا') . " در " . ($cityFullDisplay ?? $cityName ?? 'ایران') . " | طلالایو") }}</title>
    <meta name="description" content="{{ $metaDescription ?? ("مشاهده آنلاین قیمت لحظه‌ای طلا ۱۸ عیار، سکه و مسکوکات در " . ($galleryDisplayName ?? 'گالری طلا') . " " . ($cityFullDisplay ?? $cityName ?? '') . ". نرخ‌های بروزرسانی شده متصل به شبکه ابری طلالایو.") }}">
    <link rel="canonical" href="{{ url('/' . ($username ?? '')) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=2">

    {{-- اسکیما ساختاریافته JewelryStore (زیرمجموعه LocalBusiness) صنف طلا و جواهر بدون امتیاز ساختگی --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "JewelryStore",
        "@@id": "{{ url('/' . ($username ?? '')) }}#store",
        "name": "{{ $galleryDisplayName ?? 'گالری طلا' }}",
        "url": "{{ url('/' . ($username ?? '')) }}",
        "image": "https://talalive.ir/images/og-cover.png",
        "logo": "https://talalive.ir/images/logo.png",
        "description": "{{ $galleryIntro ?? ("تابلوی آنلاین اعلام قیمت طلا و سکه " . ($galleryDisplayName ?? 'گالری طلا') . " در شهر " . ($cityFullDisplay ?? $cityName ?? 'ایران')) }}",
        @if(!empty($phone))
        "telephone": "{{ $phone }}",
        @endif
        "priceRange": "$$$$",
        "currenciesAccepted": "IRR",
        "paymentAccepted": "Cash, Credit Card",
        "address": {
            "@@type": "PostalAddress",
            "addressLocality": "{{ $cityFullDisplay ?? $cityName ?? 'تهران' }}",
            "addressCountry": "IR"@if(!empty($galleryAddress)),
            "streetAddress": "{{ $galleryAddress }}"
            @endif
        },
        "areaServed": {
            "@@type": "City",
            "name": "{{ $cityFullDisplay ?? $cityName ?? 'تهران' }}"
        },
        "parentOrganization": {
            "@@type": "Organization",
            "name": "طلالایو",
            "url": "https://talalive.ir"
        }
    }
    </script>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    {{-- Polyfills برای اجرای روان روی انواع وب‌ویوهای قدیمی تلویزیون بدون نیاز به آپدیت --}}
    <script>
        (function() {
            if (!String.prototype.replaceAll) {
                String.prototype.replaceAll = function(str, newStr) {
                    if (Object.prototype.toString.call(str).toLowerCase() === '[object regexp]') {
                        return this.replace(str, newStr);
                    }
                    return this.replace(new RegExp(str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), newStr);
                };
            }
            if (!Object.fromEntries) {
                Object.fromEntries = function(entries) {
                    if (!entries) return {};
                    var obj = {};
                    for (var i = 0; i < entries.length; i++) {
                        var pair = entries[i];
                        if (pair && pair.length >= 2) { obj[pair[0]] = pair[1]; }
                    }
                    return obj;
                };
            }
            if (!Object.assign) {
                Object.assign = function(target) {
                    if (target == null) throw new TypeError('Cannot convert undefined or null to object');
                    var to = Object(target);
                    for (var index = 1; index < arguments.length; index++) {
                        var nextSource = arguments[index];
                        if (nextSource != null) {
                            for (var nextKey in nextSource) {
                                if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) { to[nextKey] = nextSource[nextKey]; }
                            }
                        }
                    }
                    return to;
                };
            }
            if (!Array.prototype.find) {
                Array.prototype.find = function(predicate) {
                    if (this == null) throw new TypeError('Array.prototype.find called on null or undefined');
                    if (typeof predicate !== 'function') throw new TypeError('predicate must be a function');
                    var list = Object(this);
                    var length = list.length >>> 0;
                    var thisArg = arguments[1];
                    for (var i = 0; i < length; i++) {
                        var value = list[i];
                        if (predicate.call(thisArg, value, i, list)) return value;
                    }
                    return undefined;
                };
            }
            if (!Array.prototype.includes) {
                Array.prototype.includes = function(searchElement, fromIndex) {
                    return this.indexOf(searchElement, fromIndex) !== -1;
                };
            }
            window.addEventListener('error', function(e) {
                console.warn('TalaLive handled legacy browser event:', e ? e.message : 'unknown');
            });

            @if($isTv ?? false)
            (function() {
                var mouseTimer = null;
                function onUserMouseMove() {
                    if (!document.documentElement.classList.contains('tv-mouse-active')) {
                        document.documentElement.classList.add('tv-mouse-active');
                    }
                    if (mouseTimer) clearTimeout(mouseTimer);
                    mouseTimer = setTimeout(function() {
                        document.documentElement.classList.remove('tv-mouse-active');
                    }, 3500);
                }
                window.addEventListener('mousemove', onUserMouseMove, { passive: true });
                window.addEventListener('pointermove', onUserMouseMove, { passive: true });
                window.addEventListener('mousedown', onUserMouseMove, { passive: true });
                window.addEventListener('wheel', onUserMouseMove, { passive: true });
            })();
            @endif
        })();
    </script>
    <script defer src="{{ asset('vendor/alpinejs.min.js') }}"></script>
    <style>
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            overflow: hidden !important;
            background: #020617;
            font-family: Vazirmatn, ui-sans-serif, system-ui, sans-serif;
            -webkit-user-select: none !important;
            user-select: none !important;
        }
        @if($isTv ?? false)
        html.tv-mouse-active, html.tv-mouse-active body, html.tv-mouse-active * {
            cursor: default !important;
        }
        html.tv-mouse-active a, html.tv-mouse-active button, html.tv-mouse-active [role="button"], html.tv-mouse-active .cursor-pointer {
            cursor: pointer !important;
        }
        html:not(.tv-mouse-active), html:not(.tv-mouse-active) body, html:not(.tv-mouse-active) * {
            cursor: none !important;
        }
        @endif
        @if($isApp ?? false)
        /* بهینه‌سازی پردازش گرافیکی اختصاصی داخل اپلیکیشن بدون کوچکترین تاثیر روی مرورگر */
        /* .ambient-orb-container { display: none !important; } */
        #tv-stage-canvas { transform-style: flat !important; }
        @endif
        ::-webkit-scrollbar { display: none !important; }
        *:focus { outline: none !important; }

        /* معماری بوم مجازی مقیاس‌پذیر خودکار (Virtual Canvas Auto-Scaler Engine) */
        #tv-stage-viewport {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            pointer-events: none;
        }
        #tv-stage-canvas {
            position: absolute;
            left: 0;
            top: 0;
            width: 1920px;
            height: 1080px;
            transform-origin: 0 0;
            -webkit-transform-origin: 0 0;
            transform: scale(1);
        }
    </style>
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideSwap { 0% { opacity: 0; transform: scale(1.03) translate3d(0,0,0); } 100% { opacity: 1; transform: scale(1) translate3d(0,0,0); } }
        @keyframes crossFadeIn { 0% { opacity: 0; } 100% { opacity: 1; } }
        .animate-crossFade { animation: crossFadeIn 0.7s ease-in-out forwards; will-change: opacity; }
        /* شیوه سخت‌افزاری اپل: ترنزیشن مقیاس مستقیم روی کارت گرافیک (Zero CPU / 60-120 FPS GPU Compositing) */
        .apple-zoom-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1) translateZ(0);
            transform-origin: center center;
            will-change: transform;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            transition: transform var(--zoom-duration, 8s) linear;
        }
        .apple-zoom-img.is-zooming {
            transform: scale(1.08) translateZ(0);
        }

        .apple-story-bar {
            width: 100%;
            height: 100%;
            transform-origin: right center; /* RTL */
            transform: scaleX(0) translateZ(0);
            will-change: transform;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        .apple-story-bar.is-waiting {
            transform: scaleX(0) translateZ(0);
            transition: none;
        }
        .apple-story-bar.is-completed {
            transform: scaleX(1) translateZ(0);
            transition: none;
        }
        .apple-story-bar.is-active {
            transform: scaleX(1) translateZ(0);
            transition: transform var(--story-duration, 8s) linear;
        }
        @keyframes float1 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-5%, 5%); } }
        @keyframes float2 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(5%, -5%); } }
        @keyframes float3 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-3%, -3%); } }
        /* انیمیشن پرمیوم پرتو نوری مایع آینه‌ای (Liquid Gold Specular Beam) - ۱۰۰٪ شتاب‌یافته 3D */
        .gold-beam-shimmer {
            position: absolute;
            top: -120%;
            bottom: -120%;
            left: 0;
            width: 45%;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(251, 191, 36, 0.0) 15%,
                rgba(254, 240, 138, 0.20) 38%,
                rgba(255, 255, 255, 0.75) 50%,
                rgba(254, 240, 138, 0.20) 62%,
                rgba(251, 191, 36, 0.0) 85%,
                transparent 100%
            );
            transform: translate3d(-200%, 0, 0) rotate(28deg);
            transform-origin: center center;
            will-change: transform;
            backface-visibility: hidden;
            pointer-events: none;
        }

        @keyframes gold-beam-sweep {
            0% {
                transform: translate3d(-200%, 0, 0) rotate(28deg);
                opacity: 0;
            }
            3% {
                opacity: 1;
            }
            24% {
                transform: translate3d(380%, 0, 0) rotate(28deg);
                opacity: 1;
            }
            27%, 100% {
                transform: translate3d(380%, 0, 0) rotate(28deg);
                opacity: 0;
            }
        }
        .animate-gold-beam {
            animation: gold-beam-sweep 6s cubic-bezier(0.25, 1, 0.5, 1) infinite;
        }

        /* انیمیشن تنفس نوری کادر طلای ۱۸ عیار با شتاب‌دهنده سخت‌افزاری 3D Compositor (بدون فشار به پردازنده) */
        @keyframes gold-glow-pulse {
            0%, 100% { opacity: 0.25; }
            50% { opacity: 0.95; }
        }

        /* چشمک ملایم ستاره درخشان طلایی هدر (100% GPU Compositor با text-shadow استاتیک) */
        @keyframes sparkle-twinkle {
            0%, 100% { opacity: 0.35; transform: scale(0.85) rotate(0deg); }
            50% { opacity: 1; transform: scale(1.2) rotate(45deg); }
        }
        .animate-sparkle {
            display: inline-block;
            animation: sparkle-twinkle 3s ease-in-out infinite;
            text-shadow: 0 0 6px rgba(251, 191, 36, 0.85);
            will-change: transform, opacity;
            backface-visibility: hidden;
        }

        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out; }
        .animate-slideSwap { animation: slideSwap 0.5s ease-out; }
        .animate-float1 { animation: float1 20s ease-in-out infinite; }
        .animate-float2 { animation: float2 25s ease-in-out infinite; }
        .animate-float3 { animation: float3 18s ease-in-out infinite; }

        /* =========================================================================
           12-ZONE HARDWARE-ACCELERATED FLOATING AMBIENT ORBS ENGINE
           کاملاً ایزوله در لایه GPU Compositor با translate3d بدون ری‌پینت و بدون داغ کردن پردازنده
           ========================================================================= */
        @keyframes orb-float-1 {
            0% { transform: translate3d(0, 0, 0); }
            33% { transform: translate3d(75px, 55px, 0); }
            66% { transform: translate3d(-30px, 80px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes orb-float-2 {
            0% { transform: translate3d(0, 0, 0); }
            35% { transform: translate3d(65px, -70px, 0); }
            70% { transform: translate3d(-40px, -45px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes orb-float-3 {
            0% { transform: translate3d(0, 0, 0); }
            30% { transform: translate3d(-70px, 60px, 0); }
            65% { transform: translate3d(50px, 75px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes orb-float-4 {
            0% { transform: translate3d(0, 0, 0); }
            35% { transform: translate3d(60px, -60px, 0); }
            70% { transform: translate3d(-50px, -35px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes orb-float-5 {
            0% { transform: translate3d(0, 0, 0); }
            33% { transform: translate3d(-55px, -65px, 0); }
            66% { transform: translate3d(65px, 40px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes orb-float-6 {
            0% { transform: translate3d(0, 0, 0); }
            35% { transform: translate3d(65px, 70px, 0); }
            70% { transform: translate3d(-45px, 50px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes orb-float-7 {
            0% { transform: translate3d(0, 0, 0); }
            38% { transform: translate3d(-60px, -60px, 0); }
            72% { transform: translate3d(45px, -40px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes orb-float-8 {
            0% { transform: translate3d(0, 0, 0); }
            30% { transform: translate3d(70px, -45px, 0); }
            68% { transform: translate3d(-40px, 65px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes orb-float-9 {
            0% { transform: translate3d(0, 0, 0); }
            36% { transform: translate3d(60px, 60px, 0); }
            72% { transform: translate3d(-50px, 40px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes orb-float-10 {
            0% { transform: translate3d(0, 0, 0); }
            32% { transform: translate3d(-65px, -55px, 0); }
            68% { transform: translate3d(55px, -65px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes orb-float-11 {
            0% { transform: translate3d(0, 0, 0); }
            34% { transform: translate3d(65px, -50px, 0); }
            70% { transform: translate3d(-55px, 55px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes orb-float-12 {
            0% { transform: translate3d(0, 0, 0); }
            38% { transform: translate3d(-60px, 65px, 0); }
            74% { transform: translate3d(50px, -45px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }
        @keyframes ticker-rtl {
            0% { transform: translateX(-100vw); }
            100% { transform: translateX(100%); }
        }
        .animate-ticker-rtl {
            animation: ticker-rtl 45s linear infinite;
        }
        html { background: #020617; }
        body { font-family: Vazirmatn, ui-sans-serif, system-ui, sans-serif; }
        .market-tile-label { overflow-wrap: anywhere; }
        .market-tile-label { line-height: 1.12; }
        .market-price-number { line-height: 0.95; white-space: nowrap; }
        .tv-price-featured {
            font-size: 3.85rem !important;
            line-height: 1 !important;
        }
        .tv-price-regular {
            font-size: 2.5rem !important;
            line-height: 1.05 !important;
        }
        .price-grid {
            grid-template-rows: 1.5fr 1fr 1fr 1fr;
        }
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
        .glow-amber-imperial { text-shadow: 0 0 12px rgba(251, 191, 36, 0.60), 0 0 26px rgba(217, 119, 6, 0.40), 0 2px 4px rgba(0, 0, 0, 0.9); }
        .glow-cyan { text-shadow: 0 0 10px rgba(6, 182, 212, 0.45), 0 0 20px rgba(6, 182, 212, 0.2); }
        .glow-purple { text-shadow: 0 0 10px rgba(217, 70, 239, 0.45), 0 0 20px rgba(217, 70, 239, 0.2); }
        .glow-emerald { text-shadow: 0 0 10px rgba(16, 185, 129, 0.45), 0 0 20px rgba(16, 185, 129, 0.2); }
        .glow-rose { text-shadow: 0 0 10px rgba(244, 63, 94, 0.45), 0 0 20px rgba(244, 63, 94, 0.2); }

        /* Ambient QR Laser Sweep (100% GPU Composited with translate3d) */
        @keyframes laser-sweep {
            0% { transform: translate3d(0, -100%, 0); opacity: 0; }
            15% { opacity: 0.85; }
            85% { opacity: 0.85; }
            100% { transform: translate3d(0, 220%, 0); opacity: 0; }
        }
        .animate-laser-sweep {
            animation: laser-sweep 3.5s ease-in-out infinite;
            will-change: transform, opacity;
            backface-visibility: hidden;
        }

        /* Neumorphic + Apple HIG Soft Physics Engine (All Luxury Themes) */
        
        /* Dedicated Hardware-Accelerated Canvas Backgrounds */
        .theme-bg-dark-glass {
            background-color: #030712 !important;
            background-image: 
                radial-gradient(ellipse 75% 65% at 85% 15%, rgba(49, 46, 129, 0.35) 0%, transparent 70%),
                radial-gradient(ellipse 65% 55% at 15% 85%, rgba(15, 23, 42, 0.70) 0%, transparent 70%),
                linear-gradient(145deg, #0f172a 0%, #070b14 50%, #020617 100%) !important;
            background-attachment: fixed !important;
        }

        .theme-bg-gold-royal {
            background-color: #0a0400 !important;
            background-image: 
                radial-gradient(ellipse 75% 65% at 50% 12%, rgba(217, 119, 6, 0.22) 0%, transparent 65%),
                radial-gradient(ellipse 60% 50% at 15% 85%, rgba(180, 83, 9, 0.18) 0%, transparent 65%),
                linear-gradient(145deg, #1c0b02 0%, #0d0501 50%, #050200 100%) !important;
            background-attachment: fixed !important;
        }

        .theme-bg-blue-ocean {
            background-color: #010712 !important;
            background-image: 
                radial-gradient(ellipse 75% 65% at 50% 12%, rgba(6, 182, 212, 0.22) 0%, transparent 65%),
                radial-gradient(ellipse 65% 55% at 85% 85%, rgba(14, 165, 233, 0.18) 0%, transparent 65%),
                linear-gradient(145deg, #06192e 0%, #030d1a 50%, #00040a 100%) !important;
            background-attachment: fixed !important;
        }

        .theme-bg-purple-haze {
            background-color: #07010e !important;
            background-image: 
                radial-gradient(ellipse 75% 65% at 50% 12%, rgba(192, 38, 211, 0.22) 0%, transparent 65%),
                radial-gradient(ellipse 65% 55% at 15% 85%, rgba(147, 51, 234, 0.18) 0%, transparent 65%),
                linear-gradient(145deg, #1b072c 0%, #0e0317 50%, #04010a 100%) !important;
            background-attachment: fixed !important;
        }

        .theme-bg-emerald-night {
            background-color: #000a06 !important;
            background-image: 
                radial-gradient(ellipse 75% 65% at 50% 12%, rgba(16, 185, 129, 0.22) 0%, transparent 65%),
                radial-gradient(ellipse 65% 55% at 85% 85%, rgba(5, 150, 105, 0.18) 0%, transparent 65%),
                linear-gradient(145deg, #02261b 0%, #01140e 50%, #000604 100%) !important;
            background-attachment: fixed !important;
        }

        .theme-bg-rose-dark {
            background-color: #0c0004 !important;
            background-image: 
                radial-gradient(ellipse 75% 65% at 50% 12%, rgba(244, 63, 94, 0.22) 0%, transparent 65%),
                radial-gradient(ellipse 65% 55% at 15% 85%, rgba(225, 29, 72, 0.18) 0%, transparent 65%),
                linear-gradient(145deg, #2b020d 0%, #150006 50%, #060002 100%) !important;
            background-attachment: fixed !important;
        }

        .theme-bg-pure-black {
            background-color: #000000 !important;
            background-image: none !important;
        }

        .theme-bg-bing {
            background-color: #020617 !important;
        }

        /* Royal Champagne & Silk Mesh (Light Theme Canvas - Zero CPU, 100% GPU) */
        .theme-light-champagne-silk {
            background-color: #fbfbfd !important;
            background-image: 
                radial-gradient(ellipse 65% 55% at 15% 15%, rgba(251, 191, 36, 0.25) 0%, transparent 70%),
                radial-gradient(ellipse 60% 50% at 85% 18%, rgba(186, 230, 253, 0.38) 0%, transparent 70%),
                radial-gradient(ellipse 70% 60% at 50% 85%, rgba(254, 215, 170, 0.30) 0%, transparent 70%),
                radial-gradient(ellipse 50% 50% at 85% 85%, rgba(224, 231, 255, 0.28) 0%, transparent 70%),
                linear-gradient(135deg, #fdfbf7 0%, #f7f5f0 50%, #f1f4f9 100%) !important;
            background-attachment: fixed !important;
        }

        .neu-card-light-modern {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.72) 0%, rgba(248, 250, 252, 0.50) 100%) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            box-shadow: inset 0 1px 1.5px 0 rgba(255, 255, 255, 0.95), inset 0 -1px 0 0 rgba(255, 255, 255, 0.4), -5px -5px 14px rgba(255, 255, 255, 0.9), 5px 8px 20px rgba(148, 163, 184, 0.22) !important;
            border: 1px solid rgba(255, 255, 255, 0.88) !important;
            transform: translateZ(0);
            backface-visibility: hidden;
        }
        .neu-card-light-modern:hover {
            transform: translateY(-2px) scale(1.008) translateZ(0);
            box-shadow: inset 0 1px 1.5px 0 rgba(255, 255, 255, 1), inset 0 -1px 0 0 rgba(255, 255, 255, 0.5), -7px -7px 18px rgba(255, 255, 255, 1), 7px 12px 26px rgba(148, 163, 184, 0.28) !important;
        }

        /* 0. Imperial Onyx & 24K Gold VIP Theme (شاهکار اونیکس شاهنشاهی ۲۴ عیار - فوق‌العاده باوقار و لوکس) */
        .theme-imperial-onyx {
            background-color: #05070c !important;
            background-image: 
                radial-gradient(circle 900px at 50% 35%, rgba(217, 119, 6, 0.12) 0%, transparent 65%),
                radial-gradient(ellipse 65% 50% at 15% 15%, rgba(251, 191, 36, 0.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 45% at 85% 85%, rgba(180, 83, 9, 0.09) 0%, transparent 60%),
                linear-gradient(145deg, #07090f 0%, #030407 50%, #000103 100%) !important;
            background-attachment: fixed !important;
        }

        .neu-card-imperial-onyx {
            background: linear-gradient(145deg, rgba(22, 28, 42, 0.52) 0%, rgba(10, 14, 23, 0.68) 100%) !important;
            backdrop-filter: blur(12px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(140%) !important;
            border: 1px solid rgba(251, 191, 36, 0.38) !important;
            box-shadow: 
                inset 0 1.5px 1px 0 rgba(255, 255, 255, 0.22),
                inset 0 -1px 0 0 rgba(251, 191, 36, 0.18),
                0 16px 40px -8px rgba(0, 0, 0, 0.88),
                0 0 20px -2px rgba(245, 158, 11, 0.10) !important;
            transform: scale(1) translateZ(0);
            backface-visibility: hidden;
            transition: transform 0.38s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.38s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-card-imperial-onyx:hover {
            transform: scale(1.025) translateY(-4px) translateZ(0) !important;
            box-shadow: 
                inset 0 2px 1.5px 0 rgba(255, 255, 255, 0.35),
                0 24px 52px -6px rgba(0, 0, 0, 0.98),
                0 0 32px rgba(251, 191, 36, 0.30) !important;
            border-color: rgba(251, 191, 36, 0.80) !important;
        }

        .neu-hero-gold-imperial {
            position: relative;
            background: linear-gradient(145deg, rgba(69, 26, 3, 0.88) 0%, rgba(30, 11, 2, 0.94) 50%, rgba(15, 5, 1, 0.98) 100%) !important;
            backdrop-filter: blur(12px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(140%) !important;
            border: 1.5px solid rgba(251, 191, 36, 0.70) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 0.40),
                inset 0 -1.5px 2px 0 rgba(180, 83, 9, 0.35),
                0 10px 28px -4px rgba(217, 119, 6, 0.45),
                0 0 16px rgba(251, 191, 36, 0.20) !important;
            transform: translate3d(0, 0, 0) !important;
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-gold-imperial::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            pointer-events: none;
            border: 1.5px solid rgba(254, 240, 138, 0.95);
            box-shadow: 0 0 28px rgba(251, 191, 36, 0.45), inset 0 0 14px rgba(251, 191, 36, 0.25);
            animation: gold-glow-pulse 4s ease-in-out infinite;
            will-change: opacity;
            z-index: 2;
        }
        .neu-hero-gold-imperial:hover {
            transform: translateY(-3px) translateZ(0) !important;
            border-color: #fef08a !important;
        }

        /* 0.1 Imperial Pearl & 24K Gold VIP Theme (مروارید و طلای شاهنشاهی ۲۴ عیار - روشن VIP) */
        .theme-imperial-pearl {
            background-color: #f6f7fb !important;
            background-image: 
                radial-gradient(circle 900px at 50% 30%, rgba(251, 191, 36, 0.16) 0%, transparent 65%),
                radial-gradient(ellipse 70% 55% at 15% 15%, rgba(245, 158, 11, 0.12) 0%, transparent 60%),
                radial-gradient(ellipse 65% 50% at 85% 85%, rgba(217, 119, 6, 0.10) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 85% 15%, rgba(224, 231, 255, 0.45) 0%, transparent 60%),
                linear-gradient(145deg, #fafafa 0%, #f4f5f9 50%, #ebedf5 100%) !important;
            background-attachment: fixed !important;
        }

        .neu-card-imperial-pearl {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.88) 0%, rgba(248, 250, 252, 0.72) 100%) !important;
            backdrop-filter: blur(12px) saturate(135%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(135%) !important;
            border: 1.5px solid rgba(217, 119, 6, 0.35) !important;
            box-shadow: 
                inset 0 1.5px 1.5px 0 rgba(255, 255, 255, 1),
                inset 0 -1px 0 0 rgba(217, 119, 6, 0.15),
                -6px -6px 18px rgba(255, 255, 255, 0.95),
                8px 16px 32px rgba(148, 163, 184, 0.22),
                0 0 16px rgba(245, 158, 11, 0.08) !important;
            transform: scale(1) translateZ(0);
            backface-visibility: hidden;
            transition: transform 0.38s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.38s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-card-imperial-pearl:hover {
            transform: scale(1.025) translateY(-4px) translateZ(0) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 1),
                -8px -8px 24px rgba(255, 255, 255, 1),
                12px 24px 44px rgba(148, 163, 184, 0.30),
                0 0 28px rgba(217, 119, 6, 0.22) !important;
            border-color: rgba(217, 119, 6, 0.75) !important;
        }

        .neu-hero-gold-pearl {
            position: relative;
            background: linear-gradient(145deg, rgba(255, 253, 245, 0.97) 0%, rgba(254, 243, 199, 0.72) 50%, rgba(253, 230, 138, 0.50) 100%) !important;
            backdrop-filter: blur(12px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(140%) !important;
            border: 1.5px solid rgba(217, 119, 6, 0.65) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 1),
                inset 0 -1.5px 2px 0 rgba(217, 119, 6, 0.18),
                -4px -4px 14px rgba(255, 255, 255, 0.95),
                0 8px 24px -2px rgba(245, 158, 11, 0.20),
                0 0 16px rgba(251, 191, 36, 0.15) !important;
            transform: translate3d(0, 0, 0) !important;
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-gold-pearl::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            pointer-events: none;
            border: 1.5px solid rgba(217, 119, 6, 0.90);
            box-shadow: 0 0 24px rgba(251, 191, 36, 0.35), inset 0 0 12px rgba(251, 191, 36, 0.20);
            animation: gold-glow-pulse 4s ease-in-out infinite;
            will-change: opacity;
            z-index: 2;
        }
        .neu-hero-gold-pearl:hover {
            transform: translateY(-3px) translateZ(0) !important;
            border-color: #b45309 !important;
        }

        /* Neumorphic Inset Badges (کپسول فرورفته تومان) */
        .neu-inset-onyx {
            background: rgba(10, 14, 23, 0.75) !important;
            box-shadow: inset 1.5px 1.5px 3px rgba(0, 0, 0, 0.85), inset -1px -1px 2px rgba(251, 191, 36, 0.18) !important;
            border: 1px solid rgba(251, 191, 36, 0.25) !important;
            color: #fef08a !important;
        }
        .neu-inset-pearl {
            background: rgba(235, 239, 245, 0.85) !important;
            box-shadow: inset 1.5px 1.5px 3px rgba(148, 163, 184, 0.45), inset -1.5px -1.5px 3px rgba(255, 255, 255, 0.95) !important;
            border: 1px solid rgba(217, 119, 6, 0.25) !important;
            color: #92400e !important;
        }

        /* Neumorphic Convex Pills (کپسول نوسان و درصد) */
        .neu-pill-convex-dark-up {
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.50), rgba(4, 47, 36, 0.75)) !important;
            border: 1px solid rgba(52, 211, 153, 0.45) !important;
            color: #34d399 !important;
            box-shadow: inset 1px 1px 1px rgba(255, 255, 255, 0.20), 0 4px 10px rgba(0, 0, 0, 0.50), 0 0 12px rgba(16, 185, 129, 0.25) !important;
        }
        .neu-pill-convex-dark-down {
            background: linear-gradient(135deg, rgba(136, 19, 55, 0.50), rgba(76, 5, 25, 0.75)) !important;
            border: 1px solid rgba(251, 113, 133, 0.45) !important;
            color: #fb7185 !important;
            box-shadow: inset 1px 1px 1px rgba(255, 255, 255, 0.20), 0 4px 10px rgba(0, 0, 0, 0.50), 0 0 12px rgba(244, 63, 94, 0.25) !important;
        }
        .neu-pill-convex-dark-flat {
            background: rgba(15, 23, 42, 0.60) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #94a3b8 !important;
            box-shadow: inset 1px 1px 1px rgba(255, 255, 255, 0.10), 0 4px 8px rgba(0, 0, 0, 0.40) !important;
        }

        .neu-pill-convex-light-up {
            background: linear-gradient(135deg, rgba(209, 250, 229, 0.92), rgba(167, 243, 208, 0.80)) !important;
            border: 1px solid rgba(5, 150, 105, 0.35) !important;
            color: #065f46 !important;
            box-shadow: inset 1px 1px 2px rgba(255, 255, 255, 1), 0 4px 12px rgba(5, 150, 105, 0.18), -2px -2px 6px rgba(255, 255, 255, 0.90) !important;
        }
        .neu-pill-convex-light-down {
            background: linear-gradient(135deg, rgba(255, 228, 230, 0.92), rgba(254, 205, 211, 0.80)) !important;
            border: 1px solid rgba(225, 29, 72, 0.35) !important;
            color: #9f1239 !important;
            box-shadow: inset 1px 1px 2px rgba(255, 255, 255, 1), 0 4px 12px rgba(225, 29, 72, 0.18), -2px -2px 6px rgba(255, 255, 255, 0.90) !important;
        }
        .neu-pill-convex-light-flat {
            background: rgba(241, 245, 249, 0.85) !important;
            border: 1px solid rgba(203, 213, 225, 0.60) !important;
            color: #475569 !important;
            box-shadow: inset 1px 1px 2px rgba(255, 255, 255, 1), 0 4px 8px rgba(148, 163, 184, 0.15), -2px -2px 6px rgba(255, 255, 255, 0.90) !important;
        }

        /* Neumorphic Live Status Badge (کپسول وضعیت لحظه‌ای) */
        .neu-status-pill-dark {
            background: rgba(6, 78, 59, 0.35) !important;
            border: 1px solid rgba(52, 211, 153, 0.35) !important;
            color: #6ee7b7 !important;
            box-shadow: inset 1px 1px 1.5px rgba(255, 255, 255, 0.20), 0 2px 8px rgba(0, 0, 0, 0.50), 0 0 10px rgba(16, 185, 129, 0.20) !important;
        }
        .neu-status-pill-light {
            background: rgba(236, 253, 245, 0.85) !important;
            border: 1px solid rgba(16, 185, 129, 0.40) !important;
            color: #047857 !important;
            box-shadow: inset 1px 1px 2px rgba(255, 255, 255, 1), -2px -2px 6px rgba(255, 255, 255, 0.90), 0 2px 8px rgba(16, 185, 129, 0.15) !important;
        }

        /* Neumorphic Currency Unit Badge (کپسول واحد پول) */
        .neu-unit-pill-dark {
            background: rgba(15, 23, 42, 0.60) !important;
            border: 1px solid rgba(251, 191, 36, 0.30) !important;
            color: #fde68a !important;
            box-shadow: inset 1px 1px 1px rgba(255, 255, 255, 0.10), 0 4px 8px rgba(0, 0, 0, 0.40) !important;
        }
        .neu-unit-pill-light {
            background: rgba(241, 245, 249, 0.85) !important;
            border: 1px solid rgba(217, 119, 6, 0.35) !important;
            color: #78350f !important;
            box-shadow: inset 1px 1px 2px rgba(255, 255, 255, 1), 0 4px 8px rgba(148, 163, 184, 0.15), -2px -2px 6px rgba(255, 255, 255, 0.90) !important;
        }

        /* 1. Apple Vision Pro / Dark Obsidian Glass (پیشنهاد اول - شیشه دودی ابسیدین با لبه طلایی ۲۴ عیار و اسکیل) */
        .neu-card-bing-obsidian {
            background: linear-gradient(145deg, rgba(15, 23, 42, 0.70) 0%, rgba(2, 6, 23, 0.86) 100%) !important;
            backdrop-filter: blur(12px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(140%) !important;
            border: 1px solid rgba(251, 191, 36, 0.30) !important;
            box-shadow: 
                inset 0 1.5px 1px 0 rgba(255, 255, 255, 0.18),
                inset 0 -1px 0 0 rgba(251, 191, 36, 0.15),
                0 14px 36px -4px rgba(0, 0, 0, 0.75),
                0 4px 14px 0 rgba(0, 0, 0, 0.35) !important;
            transform: scale(1) translateZ(0);
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-card-bing-obsidian:hover {
            transform: scale(1.025) translateY(-4px) translateZ(0) !important;
            box-shadow: 
                inset 0 2px 1.5px 0 rgba(255, 255, 255, 0.28),
                0 24px 50px -6px rgba(0, 0, 0, 0.90),
                0 0 25px rgba(245, 158, 11, 0.22) !important;
            border-color: rgba(251, 191, 36, 0.65) !important;
        }

        .neu-hero-gold-obsidian {
            position: relative;
            background: linear-gradient(145deg, rgba(50, 18, 1, 0.88) 0%, rgba(20, 8, 0, 0.95) 100%) !important;
            backdrop-filter: blur(12px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(140%) !important;
            border: 1.5px solid rgba(251, 191, 36, 0.70) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 0.40),
                0 10px 28px -4px rgba(217, 119, 6, 0.45),
                0 0 16px rgba(251, 191, 36, 0.20) !important;
            transform: translate3d(0, 0, 0) !important;
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-gold-obsidian::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            pointer-events: none;
            border: 1.5px solid rgba(254, 240, 138, 0.95);
            box-shadow: 0 0 28px rgba(251, 191, 36, 0.45), inset 0 0 14px rgba(251, 191, 36, 0.25);
            animation: gold-glow-pulse 4s ease-in-out infinite;
            will-change: opacity;
            z-index: 2;
        }
        .neu-hero-gold-obsidian:hover {
            transform: translateY(-3px) translateZ(0) !important;
            border-color: #fef08a !important;
        }

        /* 2. Apple Studio Unified Canvas (پیشنهاد دوم - استیج شیشه‌ای مات و یکدست) */
        .neu-card-bing-studio {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.65) 0%, rgba(15, 23, 42, 0.82) 100%) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
            box-shadow: 
                inset 0 1px 1px 0 rgba(255, 255, 255, 0.16),
                0 10px 28px -4px rgba(0, 0, 0, 0.55) !important;
            transform: scale(1) translateZ(0);
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-card-bing-studio:hover {
            transform: scale(1.025) translateY(-4px) translateZ(0) !important;
            box-shadow: 
                inset 0 1.5px 1px 0 rgba(255, 255, 255, 0.25),
                0 18px 40px -4px rgba(0, 0, 0, 0.70) !important;
            border-color: rgba(99, 102, 241, 0.50) !important;
        }

        .neu-hero-gold-studio {
            position: relative;
            background: linear-gradient(145deg, rgba(69, 26, 3, 0.80) 0%, rgba(20, 8, 0, 0.94) 100%) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1.5px solid rgba(251, 191, 36, 0.70) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 0.35),
                0 10px 28px -4px rgba(217, 119, 6, 0.40),
                0 0 16px rgba(251, 191, 36, 0.20) !important;
            transform: translate3d(0, 0, 0) !important;
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-gold-studio::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            pointer-events: none;
            border: 1.5px solid rgba(254, 240, 138, 0.95);
            box-shadow: 0 0 28px rgba(251, 191, 36, 0.45), inset 0 0 14px rgba(251, 191, 36, 0.25);
            animation: gold-glow-pulse 4s ease-in-out infinite;
            will-change: opacity;
            z-index: 2;
        }
        .neu-hero-gold-studio:hover {
            transform: translateY(-3px) translateZ(0) !important;
            border-color: rgba(251, 191, 36, 1) !important;
        }

        /* 3. Apple Ceramic Porcelain (پیشنهاد سوم - سرامیک پرسلین سفید با وقار و کنتراست شفاف) */
        .neu-card-bing-ceramic {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.90) 0%, rgba(248, 250, 252, 0.84) 100%) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.95) !important;
            box-shadow: 
                inset 0 1.5px 1.5px 0 rgba(255, 255, 255, 1),
                inset 0 -1px 0 0 rgba(255, 255, 255, 0.4),
                -4px -4px 14px rgba(255, 255, 255, 0.85),
                0 14px 34px -4px rgba(15, 23, 42, 0.18),
                0 4px 10px 0 rgba(0, 0, 0, 0.06) !important;
            transform: scale(1) translateZ(0);
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-card-bing-ceramic:hover {
            transform: scale(1.025) translateY(-4px) translateZ(0) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 1),
                -6px -6px 18px rgba(255, 255, 255, 1),
                0 22px 48px -6px rgba(15, 23, 42, 0.26),
                0 6px 16px 0 rgba(0, 0, 0, 0.10) !important;
            border-color: #ffffff !important;
        }

        .neu-hero-gold-ceramic {
            position: relative;
            background: linear-gradient(145deg, rgba(255, 253, 245, 0.97) 0%, rgba(254, 243, 199, 0.72) 50%, rgba(253, 230, 138, 0.50) 100%) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1.5px solid rgba(217, 119, 6, 0.65) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 1),
                -4px -4px 14px rgba(255, 255, 255, 0.95),
                0 8px 24px -2px rgba(245, 158, 11, 0.20),
                0 0 16px rgba(251, 191, 36, 0.15) !important;
            transform: translate3d(0, 0, 0) !important;
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-gold-ceramic::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            pointer-events: none;
            border: 1.5px solid rgba(217, 119, 6, 0.90);
            box-shadow: 0 0 24px rgba(251, 191, 36, 0.35), inset 0 0 12px rgba(251, 191, 36, 0.20);
            animation: gold-glow-pulse 4s ease-in-out infinite;
            will-change: opacity;
            z-index: 2;
        }
        .neu-hero-gold-ceramic:hover {
            transform: translateY(-3px) translateZ(0) !important;
            border-color: rgba(217, 119, 6, 1) !important;
        }

        .neu-card-dark-glass {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.48), rgba(15, 23, 42, 0.65)) !important;
            backdrop-filter: blur(12px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(140%) !important;
            box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.16), -4px -4px 14px rgba(255, 255, 255, 0.04), 8px 12px 28px rgba(0, 0, 0, 0.65) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            transform: translateZ(0);
            backface-visibility: hidden;
        }
        .neu-card-dark-glass:hover {
            transform: translateY(-2px) scale(1.008) translateZ(0);
            box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.22), -5px -5px 18px rgba(255, 255, 255, 0.07), 10px 16px 34px rgba(0, 0, 0, 0.75) !important;
            border-color: rgba(99, 102, 241, 0.4) !important;
        }

        .neu-card-gold-royal {
            background: linear-gradient(145deg, rgba(69, 26, 3, 0.55), rgba(20, 8, 0, 0.8)) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            box-shadow: inset 0 1px 0 0 rgba(251, 191, 36, 0.22), -4px -4px 14px rgba(245, 158, 11, 0.08), 8px 12px 28px rgba(0, 0, 0, 0.75) !important;
            border: 1px solid rgba(245, 158, 11, 0.22) !important;
            transform: translateZ(0);
            backface-visibility: hidden;
        }
        .neu-card-gold-royal:hover {
            transform: translateY(-2px) scale(1.008) translateZ(0);
            box-shadow: inset 0 1px 0 0 rgba(251, 191, 36, 0.3), -6px -6px 20px rgba(245, 158, 11, 0.14), 10px 16px 34px rgba(0, 0, 0, 0.85) !important;
            border-color: rgba(245, 158, 11, 0.45) !important;
        }

        .neu-card-blue-ocean {
            background: linear-gradient(145deg, rgba(10, 25, 47, 0.55), rgba(2, 12, 27, 0.82)) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            box-shadow: inset 0 1px 0 0 rgba(34, 211, 238, 0.18), -4px -4px 14px rgba(6, 182, 212, 0.08), 8px 12px 28px rgba(0, 0, 0, 0.75) !important;
            border: 1px solid rgba(6, 182, 212, 0.2) !important;
            transform: translateZ(0);
            backface-visibility: hidden;
        }
        .neu-card-blue-ocean:hover {
            transform: translateY(-2px) scale(1.008) translateZ(0);
            box-shadow: inset 0 1px 0 0 rgba(34, 211, 238, 0.26), -6px -6px 20px rgba(6, 182, 212, 0.14), 10px 16px 34px rgba(0, 0, 0, 0.85) !important;
            border-color: rgba(6, 182, 212, 0.45) !important;
        }

        .neu-card-purple-haze {
            background: linear-gradient(145deg, rgba(30, 11, 54, 0.55), rgba(15, 5, 29, 0.82)) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            box-shadow: inset 0 1px 0 0 rgba(232, 121, 249, 0.18), -4px -4px 14px rgba(217, 70, 239, 0.08), 8px 12px 28px rgba(0, 0, 0, 0.75) !important;
            border: 1px solid rgba(217, 70, 239, 0.2) !important;
            transform: translateZ(0);
            backface-visibility: hidden;
        }
        .neu-card-purple-haze:hover {
            transform: translateY(-2px) scale(1.008) translateZ(0);
            box-shadow: inset 0 1px 0 0 rgba(232, 121, 249, 0.26), -6px -6px 20px rgba(217, 70, 239, 0.14), 10px 16px 34px rgba(0, 0, 0, 0.85) !important;
            border-color: rgba(217, 70, 239, 0.45) !important;
        }

        .neu-card-emerald-night {
            background: linear-gradient(145deg, rgba(2, 44, 34, 0.55), rgba(1, 28, 21, 0.82)) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            box-shadow: inset 0 1px 0 0 rgba(52, 211, 153, 0.18), -4px -4px 14px rgba(16, 185, 129, 0.08), 8px 12px 28px rgba(0, 0, 0, 0.75) !important;
            border: 1px solid rgba(16, 185, 129, 0.2) !important;
            transform: translateZ(0);
            backface-visibility: hidden;
        }
        .neu-card-emerald-night:hover {
            transform: translateY(-2px) scale(1.008) translateZ(0);
            box-shadow: inset 0 1px 0 0 rgba(52, 211, 153, 0.26), -6px -6px 20px rgba(16, 185, 129, 0.14), 10px 16px 34px rgba(0, 0, 0, 0.85) !important;
            border-color: rgba(16, 185, 129, 0.45) !important;
        }

        .neu-card-rose-dark {
            background: linear-gradient(145deg, rgba(63, 2, 18, 0.55), rgba(28, 0, 7, 0.82)) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            box-shadow: inset 0 1px 0 0 rgba(251, 113, 133, 0.18), -4px -4px 14px rgba(244, 63, 94, 0.08), 8px 12px 28px rgba(0, 0, 0, 0.75) !important;
            border: 1px solid rgba(244, 63, 94, 0.2) !important;
            transform: translateZ(0);
            backface-visibility: hidden;
        }
        .neu-card-rose-dark:hover {
            transform: translateY(-2px) scale(1.008) translateZ(0);
            box-shadow: inset 0 1px 0 0 rgba(251, 113, 133, 0.26), -6px -6px 20px rgba(244, 63, 94, 0.14), 10px 16px 34px rgba(0, 0, 0, 0.85) !important;
            border-color: rgba(244, 63, 94, 0.45) !important;
        }

        .neu-card-pure-black {
            background: linear-gradient(145deg, rgba(24, 24, 27, 0.75), rgba(9, 9, 11, 0.92)) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.1), -3px -3px 10px rgba(255, 255, 255, 0.03), 6px 8px 24px rgba(0, 0, 0, 0.95) !important;
            border: 1px solid rgba(255, 255, 255, 0.11) !important;
            transform: translateZ(0);
            backface-visibility: hidden;
        }
        .neu-card-pure-black:hover {
            transform: translateY(-2px) scale(1.008) translateZ(0);
            box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.18), -4px -4px 14px rgba(255, 255, 255, 0.06), 8px 12px 28px rgba(0, 0, 0, 1) !important;
            border-color: rgba(255, 255, 255, 0.25) !important;
        }

        /* 18K Gold Hero Card Variants for Each Theme */
        .neu-hero-blue-ocean {
            position: relative;
            background: linear-gradient(145deg, rgba(6, 40, 75, 0.85) 0%, rgba(2, 18, 38, 0.94) 100%) !important;
            backdrop-filter: blur(12px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(140%) !important;
            border: 1.5px solid rgba(34, 211, 238, 0.65) !important;
            box-shadow: inset 0 2px 2px 0 rgba(255, 255, 255, 0.35), 0 10px 28px -4px rgba(6, 182, 212, 0.40), 0 0 16px rgba(34, 211, 238, 0.20) !important;
            transform: translate3d(0, 0, 0) !important;
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-blue-ocean::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            pointer-events: none;
            border: 1.5px solid rgba(165, 243, 252, 0.90);
            box-shadow: 0 0 24px rgba(6, 182, 212, 0.40), inset 0 0 12px rgba(6, 182, 212, 0.20);
            animation: gold-glow-pulse 4s ease-in-out infinite;
            will-change: opacity;
            z-index: 2;
        }

        .neu-hero-purple-haze {
            position: relative;
            background: linear-gradient(145deg, rgba(55, 12, 85, 0.85) 0%, rgba(22, 5, 36, 0.94) 100%) !important;
            backdrop-filter: blur(12px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(140%) !important;
            border: 1.5px solid rgba(217, 70, 239, 0.65) !important;
            box-shadow: inset 0 2px 2px 0 rgba(255, 255, 255, 0.35), 0 10px 28px -4px rgba(192, 38, 211, 0.40), 0 0 16px rgba(217, 70, 239, 0.20) !important;
            transform: translate3d(0, 0, 0) !important;
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-purple-haze::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            pointer-events: none;
            border: 1.5px solid rgba(245, 208, 254, 0.90);
            box-shadow: 0 0 24px rgba(217, 70, 239, 0.40), inset 0 0 12px rgba(217, 70, 239, 0.20);
            animation: gold-glow-pulse 4s ease-in-out infinite;
            will-change: opacity;
            z-index: 2;
        }

        .neu-hero-emerald-night {
            position: relative;
            background: linear-gradient(145deg, rgba(4, 55, 40, 0.85) 0%, rgba(1, 24, 17, 0.94) 100%) !important;
            backdrop-filter: blur(12px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(140%) !important;
            border: 1.5px solid rgba(52, 211, 153, 0.65) !important;
            box-shadow: inset 0 2px 2px 0 rgba(255, 255, 255, 0.35), 0 10px 28px -4px rgba(16, 185, 129, 0.40), 0 0 16px rgba(52, 211, 153, 0.20) !important;
            transform: translate3d(0, 0, 0) !important;
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-emerald-night::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            pointer-events: none;
            border: 1.5px solid rgba(167, 243, 208, 0.90);
            box-shadow: 0 0 24px rgba(16, 185, 129, 0.40), inset 0 0 12px rgba(16, 185, 129, 0.20);
            animation: gold-glow-pulse 4s ease-in-out infinite;
            will-change: opacity;
            z-index: 2;
        }

        .neu-hero-rose-dark {
            position: relative;
            background: linear-gradient(145deg, rgba(75, 4, 25, 0.85) 0%, rgba(30, 1, 9, 0.94) 100%) !important;
            backdrop-filter: blur(12px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(140%) !important;
            border: 1.5px solid rgba(251, 113, 133, 0.65) !important;
            box-shadow: inset 0 2px 2px 0 rgba(255, 255, 255, 0.35), 0 10px 28px -4px rgba(244, 63, 94, 0.40), 0 0 16px rgba(251, 113, 133, 0.20) !important;
            transform: translate3d(0, 0, 0) !important;
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-rose-dark::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            pointer-events: none;
            border: 1.5px solid rgba(254, 205, 211, 0.90);
            box-shadow: 0 0 24px rgba(244, 63, 94, 0.40), inset 0 0 12px rgba(244, 63, 94, 0.20);
            animation: gold-glow-pulse 4s ease-in-out infinite;
            will-change: opacity;
            z-index: 2;
        }

        .neu-hero-pure-black {
            position: relative;
            background: linear-gradient(145deg, rgba(20, 20, 23, 0.95) 0%, rgba(5, 5, 6, 0.98) 100%) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1.5px solid rgba(251, 191, 36, 0.65) !important;
            box-shadow: inset 0 2px 2px 0 rgba(255, 255, 255, 0.25), 0 10px 28px -4px rgba(0, 0, 0, 0.9), 0 0 16px rgba(251, 191, 36, 0.15) !important;
            transform: translate3d(0, 0, 0) !important;
            backface-visibility: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-pure-black::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            pointer-events: none;
            border: 1.5px solid rgba(254, 240, 138, 0.85);
            box-shadow: 0 0 24px rgba(251, 191, 36, 0.35), inset 0 0 12px rgba(251, 191, 36, 0.15);
            animation: gold-glow-pulse 4s ease-in-out infinite;
            will-change: opacity;
            z-index: 2;
        }

        /* Apple Premium Slider Overlays & Glass Cards (Adaptive for Light/Dark) */
        /* Apple Premium Slider Overlays & Glass Cards (100% Theme-Adaptive) */
        .slider-scrim-bottom-dark {
            position: absolute !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            height: 14rem !important;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.78) 0%, rgba(0, 0, 0, 0.35) 50%, transparent 100%) !important;
            pointer-events: none !important;
            z-index: 10 !important;
        }
        .slider-scrim-bottom-light {
            position: absolute !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            height: 14rem !important;
            background: linear-gradient(to top, rgba(255, 255, 255, 0.75) 0%, rgba(255, 255, 255, 0.25) 50%, transparent 100%) !important;
            pointer-events: none !important;
            z-index: 10 !important;
        }
        .slider-glass-dock {
            position: absolute !important;
            bottom: 1.15rem !important;
            left: 1.15rem !important;
            right: 1.15rem !important;
            z-index: 20 !important;
        }
        .slider-info-card-adaptive {
            backdrop-filter: blur(20px) saturate(160%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(160%) !important;
            border-radius: 1.75rem !important;
            padding: 0.9rem 1.15rem !important;
            transition: all 0.35s ease !important;
        }
        .slider-chip {
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.35rem !important;
            border-radius: 9999px !important;
            padding: 0.3rem 0.75rem !important;
            font-size: 0.8rem !important;
            font-weight: 700 !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            transition: all 0.2s ease !important;
        }
        .slider-chip-dark {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.16) !important;
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.15), 0 2px 8px rgba(0, 0, 0, 0.35) !important;
            color: rgba(255, 255, 255, 0.95) !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6) !important;
        }
        .slider-chip-light {
            background: rgba(0, 0, 0, 0.04) !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: inset 0 1px 1.5px rgba(255, 255, 255, 0.9), 0 2px 6px rgba(0, 0, 0, 0.04) !important;
            color: #1e293b !important;
        }
        .slider-price-badge-adaptive {
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border-radius: 1.25rem !important;
            padding: 0.65rem 1.1rem !important;
            text-align: right !important;
            transition: all 0.35s ease !important;
        }
        .slider-top-badge {
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.92) 0%, rgba(190, 18, 60, 0.95) 60%, rgba(180, 83, 9, 0.90) 100%) !important;
            border: 1.5px solid rgba(255, 255, 255, 0.35) !important;
            box-shadow: 0 14px 32px -4px rgba(225, 29, 72, 0.45), 0 0 20px rgba(244, 63, 94, 0.30), inset 0 1.5px 2px rgba(255, 255, 255, 0.45) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        /* =========================================================================
           APPLE PREMIUM 4-CORNER SEPARATED AMBIENT ORBS ENGINE
           (۴ گوی فوق‌العاده تفکیک‌شده و پرمیوم اپل - کاملاً خنک و سبک برای تلویزیون‌های طلافروشی)
           ویژگی‌های کلیدی:
           ۱. تفکیک کامل: هر گوی منحصراً در یکی از ۴ گوشه صفحه قرار دارد و فضای مرکزی آزاد است.
           ۲. رفع مه‌آلودگی: بلور از ۵۰ به ۲۰ پیکسل کاهش یافته تا گوی‌ها شبیه کره‌های درخشان باشند نه مه تیره.
           ۳. حذف mix-blend-mode: بار محاسباتی GPU را ۷۵٪ کاهش داده و از داغ شدن تلویزیون جلوگیری می‌کند.
           ۴. ایزولاسیون سخت‌افزاری 3D: با translate3d و contain: strict بدون repaint در بک‌گراند حرکت می‌کنند.
           ========================================================================= */
        .ambient-orb-container {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 1;
            contain: strict;
            transform: translateZ(0);
        }

        .ambient-orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            will-change: transform;
            backface-visibility: hidden;
            transform: translate3d(0, 0, 0);
            filter: none !important;
            -webkit-filter: none !important;
        }

        /* ۱. گوی فیروزه‌ای و یاقوت کبود اپل (Electric Cyan & Sapphire) - بالا چپ */
        .orb-1 {
            top: 1%;
            left: 1%;
            width: clamp(170px, 17vw, 245px);
            height: clamp(170px, 17vw, 245px);
            background: radial-gradient(circle at 48% 48%, rgba(6, 182, 212, 0.85) 0%, rgba(2, 132, 199, 0.55) 32%, rgba(2, 132, 199, 0.18) 60%, transparent 80%) !important;
            opacity: 0.90;
            animation: orb-float-1 8s ease-in-out infinite;
        }

        /* ۲. گوی ارکیده نئونی و سرخابی غروب اپل (Neon Magenta & Orchid) - پایین چپ */
        .orb-2 {
            bottom: 3%;
            left: 3%;
            width: clamp(165px, 16vw, 235px);
            height: clamp(165px, 16vw, 235px);
            background: radial-gradient(circle at 50% 50%, rgba(244, 63, 94, 0.85) 0%, rgba(192, 38, 211, 0.55) 32%, rgba(192, 38, 211, 0.18) 60%, transparent 80%) !important;
            opacity: 0.90;
            animation: orb-float-2 10s ease-in-out infinite;
        }

        /* ۳. گوی طلای خالص ۲۴ عیار و کهربایی اپل (24K Liquid Gold & Amber) - مرکز-چپ بالا */
        .orb-3 {
            top: 5%;
            left: 30%;
            width: clamp(175px, 18vw, 250px);
            height: clamp(175px, 18vw, 250px);
            background: radial-gradient(circle at 48% 48%, rgba(253, 224, 71, 0.90) 0%, rgba(245, 158, 11, 0.60) 32%, rgba(217, 119, 6, 0.20) 60%, transparent 80%) !important;
            opacity: 0.90;
            animation: orb-float-3 9s ease-in-out infinite;
        }

        /* ۴. گوی شفق زمردین و نعنایی اپل (Aurora Emerald & Mint) - مرکز-چپ پایین */
        .orb-4 {
            bottom: 5%;
            left: 28%;
            width: clamp(170px, 17vw, 240px);
            height: clamp(170px, 17vw, 240px);
            background: radial-gradient(circle at 50% 50%, rgba(52, 211, 153, 0.85) 0%, rgba(5, 150, 105, 0.55) 32%, rgba(5, 150, 105, 0.18) 60%, transparent 80%) !important;
            opacity: 0.90;
            animation: orb-float-4 11s ease-in-out infinite;
        }

        /* ۵. گوی سرمه‌ای یاقوتی و کبالت (Sapphire Deep Blue & Cobalt) - میانه چپ */
        .orb-5 {
            top: 38%;
            left: 6%;
            width: clamp(160px, 16vw, 230px);
            height: clamp(160px, 16vw, 230px);
            background: radial-gradient(circle at 48% 48%, rgba(59, 130, 246, 0.85) 0%, rgba(37, 99, 235, 0.55) 32%, rgba(29, 78, 216, 0.18) 60%, transparent 80%) !important;
            opacity: 0.88;
            animation: orb-float-5 12s ease-in-out infinite;
        }

        /* ۶. گوی طلای شامپاینی و آفتابی (Champagne Spark & Warm Gold) - بالا مرکز */
        .orb-6 {
            top: 2%;
            left: 46%;
            width: clamp(170px, 17vw, 245px);
            height: clamp(170px, 17vw, 245px);
            background: radial-gradient(circle at 50% 50%, rgba(251, 191, 36, 0.88) 0%, rgba(217, 119, 6, 0.55) 32%, rgba(180, 83, 9, 0.18) 60%, transparent 80%) !important;
            opacity: 0.90;
            animation: orb-float-6 8.5s ease-in-out infinite;
        }

        /* ۷. گوی مرجانی نئون و رزگلد (Coral Neon & Rose Gold) - پایین مرکز */
        .orb-7 {
            bottom: 3%;
            left: 44%;
            width: clamp(165px, 16vw, 235px);
            height: clamp(165px, 16vw, 235px);
            background: radial-gradient(circle at 48% 48%, rgba(251, 113, 133, 0.85) 0%, rgba(225, 29, 72, 0.55) 32%, rgba(190, 18, 60, 0.18) 60%, transparent 80%) !important;
            opacity: 0.88;
            animation: orb-float-7 9.5s ease-in-out infinite;
        }

        /* ۸. گوی بنفش کیهانی و اسطوخودوس (Cosmic Violet & Lavender) - میانه کارت‌ها */
        .orb-8 {
            top: 42%;
            left: 22%;
            width: clamp(160px, 16vw, 230px);
            height: clamp(160px, 16vw, 230px);
            background: radial-gradient(circle at 50% 50%, rgba(168, 85, 247, 0.85) 0%, rgba(147, 51, 234, 0.55) 32%, rgba(126, 34, 206, 0.18) 60%, transparent 80%) !important;
            opacity: 0.88;
            animation: orb-float-8 13s ease-in-out infinite;
        }

        /* ۹. گوی فیروزه‌ای متالیک و آبنوس (Electric Turquoise & Azure) - میانه بالا */
        .orb-9 {
            top: 22%;
            left: 14%;
            width: clamp(165px, 16vw, 235px);
            height: clamp(165px, 16vw, 235px);
            background: radial-gradient(circle at 48% 48%, rgba(20, 184, 166, 0.85) 0%, rgba(13, 148, 136, 0.55) 32%, rgba(15, 118, 110, 0.18) 60%, transparent 80%) !important;
            opacity: 0.88;
            animation: orb-float-9 10.5s ease-in-out infinite;
        }

        /* ۱۰. گوی زردآلویی غروب و شیمر طلایی (Sunset Apricot & Golden Shimmer) - میانه پایین */
        .orb-10 {
            bottom: 24%;
            left: 16%;
            width: clamp(160px, 16vw, 230px);
            height: clamp(160px, 16vw, 230px);
            background: radial-gradient(circle at 50% 50%, rgba(251, 146, 60, 0.85) 0%, rgba(234, 88, 12, 0.55) 32%, rgba(194, 65, 12, 0.18) 60%, transparent 80%) !important;
            opacity: 0.88;
            animation: orb-float-10 11.5s ease-in-out infinite;
        }

        /* ۱۱. گوی یاقوت سرخ و تپاز صورتی (Glowing Ruby & Pink Topaz) - میانه راست استیج */
        .orb-11 {
            top: 20%;
            left: 38%;
            width: clamp(160px, 16vw, 230px);
            height: clamp(160px, 16vw, 230px);
            background: radial-gradient(circle at 48% 48%, rgba(236, 72, 153, 0.85) 0%, rgba(219, 39, 119, 0.55) 32%, rgba(190, 24, 93, 0.18) 60%, transparent 80%) !important;
            opacity: 0.88;
            animation: orb-float-11 9s ease-in-out infinite;
        }

        /* ۱۲. گوی یشمی بلورین و نعنایی (Mint Jade & Crystal Aqua) - میانه پایین راست */
        .orb-12 {
            bottom: 22%;
            left: 36%;
            width: clamp(165px, 16vw, 235px);
            height: clamp(165px, 16vw, 235px);
            background: radial-gradient(circle at 50% 50%, rgba(45, 212, 191, 0.85) 0%, rgba(16, 185, 129, 0.55) 32%, rgba(5, 150, 105, 0.18) 60%, transparent 80%) !important;
            opacity: 0.88;
            animation: orb-float-12 12.5s ease-in-out infinite;
        }

        /* پالت تم روشن شاهنشاهی و روشن مدرن (Light Mode Apple Palette) */
        .theme-imperial-pearl .orb-1, .theme-light-modern .orb-1, .theme-bing-ceramic .orb-1 {
            opacity: 0.55 !important;
            background: radial-gradient(circle at 48% 48%, rgba(14, 165, 233, 0.65) 0%, rgba(56, 189, 248, 0.35) 32%, rgba(186, 230, 253, 0.12) 60%, transparent 80%) !important;
        }
        .theme-imperial-pearl .orb-2, .theme-light-modern .orb-2, .theme-bing-ceramic .orb-2 {
            opacity: 0.55 !important;
            background: radial-gradient(circle at 50% 50%, rgba(244, 63, 94, 0.55) 0%, rgba(217, 70, 239, 0.30) 32%, rgba(251, 207, 232, 0.12) 60%, transparent 80%) !important;
        }
        .theme-imperial-pearl .orb-3, .theme-light-modern .orb-3, .theme-bing-ceramic .orb-3 {
            opacity: 0.60 !important;
            background: radial-gradient(circle at 48% 48%, rgba(245, 158, 11, 0.65) 0%, rgba(251, 191, 36, 0.35) 32%, rgba(254, 243, 199, 0.12) 60%, transparent 80%) !important;
        }
        .theme-imperial-pearl .orb-4, .theme-light-modern .orb-4, .theme-bing-ceramic .orb-4 {
            opacity: 0.55 !important;
            background: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.60) 0%, rgba(52, 211, 153, 0.32) 32%, rgba(167, 243, 208, 0.12) 60%, transparent 80%) !important;
        }
        .theme-imperial-pearl .orb-5, .theme-light-modern .orb-5, .theme-bing-ceramic .orb-5 {
            opacity: 0.55 !important;
            background: radial-gradient(circle at 48% 48%, rgba(59, 130, 246, 0.60) 0%, rgba(96, 165, 250, 0.32) 32%, rgba(191, 219, 254, 0.12) 60%, transparent 80%) !important;
        }
        .theme-imperial-pearl .orb-6, .theme-light-modern .orb-6, .theme-bing-ceramic .orb-6 {
            opacity: 0.60 !important;
            background: radial-gradient(circle at 50% 50%, rgba(245, 158, 11, 0.62) 0%, rgba(252, 211, 77, 0.32) 32%, rgba(254, 243, 199, 0.12) 60%, transparent 80%) !important;
        }
        .theme-imperial-pearl .orb-7, .theme-light-modern .orb-7, .theme-bing-ceramic .orb-7 {
            opacity: 0.55 !important;
            background: radial-gradient(circle at 48% 48%, rgba(244, 63, 94, 0.55) 0%, rgba(251, 113, 133, 0.30) 32%, rgba(254, 205, 211, 0.12) 60%, transparent 80%) !important;
        }
        .theme-imperial-pearl .orb-8, .theme-light-modern .orb-8, .theme-bing-ceramic .orb-8 {
            opacity: 0.55 !important;
            background: radial-gradient(circle at 50% 50%, rgba(168, 85, 247, 0.55) 0%, rgba(192, 132, 252, 0.30) 32%, rgba(243, 232, 255, 0.12) 60%, transparent 80%) !important;
        }
        .theme-imperial-pearl .orb-9, .theme-light-modern .orb-9, .theme-bing-ceramic .orb-9 {
            opacity: 0.55 !important;
            background: radial-gradient(circle at 48% 48%, rgba(20, 184, 166, 0.55) 0%, rgba(45, 212, 191, 0.30) 32%, rgba(204, 251, 241, 0.12) 60%, transparent 80%) !important;
        }
        .theme-imperial-pearl .orb-10, .theme-light-modern .orb-10, .theme-bing-ceramic .orb-10 {
            opacity: 0.55 !important;
            background: radial-gradient(circle at 50% 50%, rgba(251, 146, 60, 0.55) 0%, rgba(253, 186, 116, 0.30) 32%, rgba(255, 237, 213, 0.12) 60%, transparent 80%) !important;
        }
        .theme-imperial-pearl .orb-11, .theme-light-modern .orb-11, .theme-bing-ceramic .orb-11 {
            opacity: 0.55 !important;
            background: radial-gradient(circle at 48% 48%, rgba(236, 72, 153, 0.55) 0%, rgba(244, 114, 182, 0.30) 32%, rgba(252, 231, 243, 0.12) 60%, transparent 80%) !important;
        }
        .theme-imperial-pearl .orb-12, .theme-light-modern .orb-12, .theme-bing-ceramic .orb-12 {
            opacity: 0.55 !important;
            background: radial-gradient(circle at 50% 50%, rgba(45, 212, 191, 0.55) 0%, rgba(110, 231, 183, 0.30) 32%, rgba(209, 250, 229, 0.12) 60%, transparent 80%) !important;
        }

        /* Palette: Gold Royal */
        .theme-gold-royal .orb-1, .theme-gold-royal .orb-2, .theme-gold-royal .orb-3,
        .theme-gold-royal .orb-4, .theme-gold-royal .orb-5, .theme-gold-royal .orb-6,
        .theme-gold-royal .orb-7, .theme-gold-royal .orb-8, .theme-gold-royal .orb-9,
        .theme-gold-royal .orb-10, .theme-gold-royal .orb-11, .theme-gold-royal .orb-12 { opacity: 0.65 !important; }
        .theme-gold-royal .orb-1, .theme-gold-royal .orb-6 { background: radial-gradient(circle, rgba(251,191,36,0.65) 0%, rgba(217,119,6,0.30) 40%, transparent 75%) !important; }
        .theme-gold-royal .orb-2, .theme-gold-royal .orb-7 { background: radial-gradient(circle, rgba(245,158,11,0.60) 0%, rgba(180,83,9,0.25) 40%, transparent 75%) !important; }
        .theme-gold-royal .orb-3, .theme-gold-royal .orb-8 { background: radial-gradient(circle, rgba(253,224,71,0.65) 0%, rgba(245,158,11,0.30) 40%, transparent 75%) !important; }
        .theme-gold-royal .orb-4, .theme-gold-royal .orb-9 { background: radial-gradient(circle, rgba(217,119,6,0.55) 0%, rgba(146,64,14,0.25) 40%, transparent 75%) !important; }
        .theme-gold-royal .orb-5, .theme-gold-royal .orb-10 { background: radial-gradient(circle, rgba(252,211,77,0.60) 0%, rgba(217,119,6,0.25) 40%, transparent 75%) !important; }
        .theme-gold-royal .orb-11, .theme-gold-royal .orb-12 { background: radial-gradient(circle, rgba(245,158,11,0.55) 0%, rgba(180,83,9,0.25) 40%, transparent 75%) !important; }

        /* Palette: Blue Ocean */
        .theme-blue-ocean .orb-1, .theme-blue-ocean .orb-2, .theme-blue-ocean .orb-3,
        .theme-blue-ocean .orb-4, .theme-blue-ocean .orb-5, .theme-blue-ocean .orb-6,
        .theme-blue-ocean .orb-7, .theme-blue-ocean .orb-8, .theme-blue-ocean .orb-9,
        .theme-blue-ocean .orb-10, .theme-blue-ocean .orb-11, .theme-blue-ocean .orb-12 { opacity: 0.65 !important; }
        .theme-blue-ocean .orb-1, .theme-blue-ocean .orb-6 { background: radial-gradient(circle, rgba(6,182,212,0.70) 0%, rgba(2,132,199,0.35) 40%, transparent 75%) !important; }
        .theme-blue-ocean .orb-2, .theme-blue-ocean .orb-7 { background: radial-gradient(circle, rgba(14,165,233,0.65) 0%, rgba(3,105,161,0.30) 40%, transparent 75%) !important; }
        .theme-blue-ocean .orb-3, .theme-blue-ocean .orb-8 { background: radial-gradient(circle, rgba(34,211,238,0.70) 0%, rgba(6,182,212,0.35) 40%, transparent 75%) !important; }
        .theme-blue-ocean .orb-4, .theme-blue-ocean .orb-9 { background: radial-gradient(circle, rgba(56,189,248,0.60) 0%, rgba(14,165,233,0.25) 40%, transparent 75%) !important; }
        .theme-blue-ocean .orb-5, .theme-blue-ocean .orb-10 { background: radial-gradient(circle, rgba(2,132,199,0.60) 0%, rgba(30,58,138,0.30) 40%, transparent 75%) !important; }
        .theme-blue-ocean .orb-11, .theme-blue-ocean .orb-12 { background: radial-gradient(circle, rgba(6,182,212,0.60) 0%, rgba(14,165,233,0.25) 40%, transparent 75%) !important; }

        /* Palette: Purple Haze */
        .theme-purple-haze .orb-1, .theme-purple-haze .orb-2, .theme-purple-haze .orb-3,
        .theme-purple-haze .orb-4, .theme-purple-haze .orb-5, .theme-purple-haze .orb-6,
        .theme-purple-haze .orb-7, .theme-purple-haze .orb-8, .theme-purple-haze .orb-9,
        .theme-purple-haze .orb-10, .theme-purple-haze .orb-11, .theme-purple-haze .orb-12 { opacity: 0.65 !important; }
        .theme-purple-haze .orb-1, .theme-purple-haze .orb-6 { background: radial-gradient(circle, rgba(192,38,211,0.70) 0%, rgba(147,51,234,0.35) 40%, transparent 75%) !important; }
        .theme-purple-haze .orb-2, .theme-purple-haze .orb-7 { background: radial-gradient(circle, rgba(168,85,247,0.65) 0%, rgba(126,34,206,0.30) 40%, transparent 75%) !important; }
        .theme-purple-haze .orb-3, .theme-purple-haze .orb-8 { background: radial-gradient(circle, rgba(217,70,239,0.70) 0%, rgba(192,38,211,0.35) 40%, transparent 75%) !important; }
        .theme-purple-haze .orb-4, .theme-purple-haze .orb-9 { background: radial-gradient(circle, rgba(147,51,234,0.60) 0%, rgba(107,33,168,0.25) 40%, transparent 75%) !important; }
        .theme-purple-haze .orb-5, .theme-purple-haze .orb-10 { background: radial-gradient(circle, rgba(232,121,249,0.60) 0%, rgba(168,85,247,0.25) 40%, transparent 75%) !important; }
        .theme-purple-haze .orb-11, .theme-purple-haze .orb-12 { background: radial-gradient(circle, rgba(192,38,211,0.60) 0%, rgba(147,51,234,0.25) 40%, transparent 75%) !important; }

        /* Palette: Emerald Night */
        .theme-emerald-night .orb-1, .theme-emerald-night .orb-2, .theme-emerald-night .orb-3,
        .theme-emerald-night .orb-4, .theme-emerald-night .orb-5, .theme-emerald-night .orb-6,
        .theme-emerald-night .orb-7, .theme-emerald-night .orb-8, .theme-emerald-night .orb-9,
        .theme-emerald-night .orb-10, .theme-emerald-night .orb-11, .theme-emerald-night .orb-12 { opacity: 0.65 !important; }
        .theme-emerald-night .orb-1, .theme-emerald-night .orb-6 { background: radial-gradient(circle, rgba(16,185,129,0.70) 0%, rgba(5,150,105,0.35) 40%, transparent 75%) !important; }
        .theme-emerald-night .orb-2, .theme-emerald-night .orb-7 { background: radial-gradient(circle, rgba(52,211,153,0.65) 0%, rgba(4,120,87,0.30) 40%, transparent 75%) !important; }
        .theme-emerald-night .orb-3, .theme-emerald-night .orb-8 { background: radial-gradient(circle, rgba(5,150,105,0.70) 0%, rgba(6,95,70,0.35) 40%, transparent 75%) !important; }
        .theme-emerald-night .orb-4, .theme-emerald-night .orb-9 { background: radial-gradient(circle, rgba(110,231,183,0.60) 0%, rgba(16,185,129,0.25) 40%, transparent 75%) !important; }
        .theme-emerald-night .orb-5, .theme-emerald-night .orb-10 { background: radial-gradient(circle, rgba(4,120,87,0.60) 0%, rgba(2,44,34,0.30) 40%, transparent 75%) !important; }
        .theme-emerald-night .orb-11, .theme-emerald-night .orb-12 { background: radial-gradient(circle, rgba(16,185,129,0.60) 0%, rgba(5,150,105,0.25) 40%, transparent 75%) !important; }

        /* Palette: Rose Dark */
        .theme-rose-dark .orb-1, .theme-rose-dark .orb-2, .theme-rose-dark .orb-3,
        .theme-rose-dark .orb-4, .theme-rose-dark .orb-5, .theme-rose-dark .orb-6,
        .theme-rose-dark .orb-7, .theme-rose-dark .orb-8, .theme-rose-dark .orb-9,
        .theme-rose-dark .orb-10, .theme-rose-dark .orb-11, .theme-rose-dark .orb-12 { opacity: 0.65 !important; }
        .theme-rose-dark .orb-1, .theme-rose-dark .orb-6 { background: radial-gradient(circle, rgba(244,63,94,0.70) 0%, rgba(225,29,72,0.35) 40%, transparent 75%) !important; }
        .theme-rose-dark .orb-2, .theme-rose-dark .orb-7 { background: radial-gradient(circle, rgba(251,113,133,0.65) 0%, rgba(190,18,60,0.30) 40%, transparent 75%) !important; }
        .theme-rose-dark .orb-3, .theme-rose-dark .orb-8 { background: radial-gradient(circle, rgba(225,29,72,0.70) 0%, rgba(159,18,57,0.35) 40%, transparent 75%) !important; }
        .theme-rose-dark .orb-4, .theme-rose-dark .orb-9 { background: radial-gradient(circle, rgba(253,164,175,0.60) 0%, rgba(244,63,94,0.25) 40%, transparent 75%) !important; }
        .theme-rose-dark .orb-5, .theme-rose-dark .orb-10 { background: radial-gradient(circle, rgba(190,18,60,0.60) 0%, rgba(136,19,55,0.30) 40%, transparent 75%) !important; }
        .theme-rose-dark .orb-11, .theme-rose-dark .orb-12 { background: radial-gradient(circle, rgba(244,63,94,0.60) 0%, rgba(225,29,72,0.25) 40%, transparent 75%) !important; }

        /* Palette: Imperial Onyx */
        .theme-imperial-onyx .orb-1, .theme-imperial-onyx .orb-2, .theme-imperial-onyx .orb-3,
        .theme-imperial-onyx .orb-4, .theme-imperial-onyx .orb-5, .theme-imperial-onyx .orb-6,
        .theme-imperial-onyx .orb-7, .theme-imperial-onyx .orb-8, .theme-imperial-onyx .orb-9,
        .theme-imperial-onyx .orb-10, .theme-imperial-onyx .orb-11, .theme-imperial-onyx .orb-12 { opacity: 0.60 !important; }
        .theme-imperial-onyx .orb-1, .theme-imperial-onyx .orb-6 { background: radial-gradient(circle, rgba(251,191,36,0.60) 0%, rgba(217,119,6,0.25) 40%, transparent 75%) !important; }
        .theme-imperial-onyx .orb-2, .theme-imperial-onyx .orb-7 { background: radial-gradient(circle, rgba(245,158,11,0.55) 0%, rgba(180,83,9,0.20) 40%, transparent 75%) !important; }
        .theme-imperial-onyx .orb-3, .theme-imperial-onyx .orb-8 { background: radial-gradient(circle, rgba(254,240,138,0.65) 0%, rgba(251,191,36,0.25) 40%, transparent 75%) !important; }
        .theme-imperial-onyx .orb-4, .theme-imperial-onyx .orb-9 { background: radial-gradient(circle, rgba(217,119,6,0.50) 0%, rgba(146,64,14,0.20) 40%, transparent 75%) !important; }
        .theme-imperial-onyx .orb-5, .theme-imperial-onyx .orb-10 { background: radial-gradient(circle, rgba(252,211,77,0.55) 0%, rgba(217,119,6,0.20) 40%, transparent 75%) !important; }
        .theme-imperial-onyx .orb-11, .theme-imperial-onyx .orb-12 { background: radial-gradient(circle, rgba(245,158,11,0.50) 0%, rgba(180,83,9,0.20) 40%, transparent 75%) !important; }

        /* Hide orbs completely for Bing themes and pure-black */
        .theme-bing-daily .ambient-orb,
        .theme-bing-studio .ambient-orb,
        .theme-pure-black .ambient-orb {
            display: none !important;
        }

        /* =========================================================================
           حالت سبک / روان (Eco / Lite Mode Engine)
           توقف کامل تمام انیمیشن‌ها، فیلترهای بلور و پردازش‌های سنگین گرافیکی
           جهت کارکرد روان و بی‌نقص روی سیستم‌ها و تلویزیون‌های ضعیف
           ========================================================================= */
        .eco-mode *,
        .eco-mode *::before,
        .eco-mode *::after {
            animation: none !important;
            transition: none !important;
        }

        /* غیرفعال‌سازی فیلتر بلور پس‌زمینه در تمام بخش‌ها برای رفع فشار GPU */
        .eco-mode [class*="backdrop-blur"],
        .eco-mode [class*="neu-card"],
        .eco-mode header,
        .eco-mode footer,
        .eco-mode section {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        /* مخفی‌سازی کامل افکت‌های حرکتی و نوری تزیینی (اسلایدر فعال می‌ماند) */
        .eco-mode .animate-gold-beam,
        .eco-mode .ambient-orb-container,
        .eco-mode .animate-laser-sweep,
        .eco-mode [class*="neu-hero"]::after {
            display: none !important;
        }

        /* لغو درخشش و سایه‌های چندلایه متن و کارت‌ها */
        .eco-mode [class*="glow-"],
        .eco-mode [class*="drop-shadow"] {
            text-shadow: none !important;
            filter: none !important;
        }

        /* پس‌زمینه خوانا و بهینه برای کارت‌ها بدون مصرف GPU */
        .eco-mode .neu-card-light-modern,
        .eco-mode .neu-card-bing-ceramic,
        .eco-mode .neu-card-imperial-pearl {
            background: #ffffff !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
            border-color: rgba(226, 232, 240, 0.9) !important;
        }

        .eco-mode .neu-card-dark-glass,
        .eco-mode .neu-card-pure-black,
        .eco-mode .neu-card-gold-royal,
        .eco-mode .neu-card-blue-ocean,
        .eco-mode .neu-card-purple-haze,
        .eco-mode .neu-card-emerald-night,
        .eco-mode .neu-card-rose-dark,
        .eco-mode .neu-card-bing-obsidian,
        .eco-mode .neu-card-bing-studio,
        .eco-mode .neu-card-imperial-onyx {
            background: #0b1329 !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5) !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
        }

        /* =========================================================================
           UNIFIED SINGLE-PASS GLASS STAGE ENGINE
           (معماری بلور یکپارچه استیج: تجمیع ۱۶ پاس بلور جداگانه کارت‌ها در ۱ پاس رندر سخت‌افزاری)
           کاهش ۹۴ درصدی پردازش‌های شیدر GPU همراه با حفظ ۱۰۰٪ ظاهر شیشه‌ای و بردرهای لوکس
           ========================================================================= */
        .price-grid-backdrop {
            backdrop-filter: blur(14px) saturate(140%);
            -webkit-backdrop-filter: blur(14px) saturate(140%);
            background: rgba(0, 0, 0, 0.05);
        }

        .theme-imperial-pearl .price-grid-backdrop,
        .theme-light-modern .price-grid-backdrop,
        .theme-bing-ceramic .price-grid-backdrop {
            background: rgba(255, 255, 255, 0.08);
        }

        /* لغو فیلترهای بلور مجزای ۱۶ کارت درون استیج (استفاده از بلور یکپارچه پس‌زمینه) */
        .price-grid [class*="neu-card"],
        .price-grid [class*="neu-hero"] {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        .eco-mode .price-grid-backdrop {
            display: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }
    </style>
</head>
<body :class="[isLightTheme ? 'bg-slate-50 text-slate-900' : 'bg-black text-white', ecoMode ? 'eco-mode' : '']" x-data="displayApp(@js($snapshot))" @dblclick="toggleFullscreen" @keydown.window="handleKeydown($event)">
    <main x-show="!isLoading" :class="[theme.bg, 'theme-' + themeKey, ecoMode ? 'eco-mode' : '']" class="fixed inset-0 w-screen h-screen overflow-hidden transition-colors duration-1000 select-none">

        {{-- نوار وضعیت اتصال آفلاین هوشمند (Self-Healing Offline Notice) --}}
        <div x-show="connectionState !== 'online'"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="-translate-y-full opacity-0"
             class="fixed top-0 inset-x-0 z-50 py-1.5 px-4 bg-amber-500/90 text-slate-950 font-black text-xs text-center backdrop-blur-md shadow-lg flex items-center justify-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-slate-950 animate-ping"></span>
            <span x-text="errorMessage || 'در حال تلاش مجدد برای اتصال به اینترنت مغازه... (آخرین قیمت‌های معتبر در حال نمایش است)'"></span>
        </div>

        {{-- نوار هشدار دادهٔ کهنه (W-06 Stale Data Warning Banner) --}}
        <div x-show="connectionState === 'online' && (snapshotData?.isStale ?? false)"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="-translate-y-full opacity-0"
             class="fixed top-0 inset-x-0 z-50 py-1.5 px-4 bg-amber-600/95 text-white font-bold text-xs text-center backdrop-blur-md shadow-md flex items-center justify-center gap-2">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-amber-200 animate-ping"></span>
            <span>نرخ‌ها در حال به‌روزرسانی — آخرین دریافت: <strong x-text="staleTimeText"></strong></span>
        </div>

        {{-- Bing Daily Wallpaper Canvas (عکس روز بینگ با فیلترهای کنتراست داینامیک سینمایی) --}}
        <div x-show="isBingTheme" class="pointer-events-none absolute inset-0 z-0 overflow-hidden select-none">
            <img :src="bingWallpaperUrl" 
                 alt="تصویر پس‌زمینه روز تابلوی طلالایو" 
                 width="1920" height="1080"
                 loading="lazy" decoding="async"
                 class="w-full h-full object-cover transition-opacity duration-1000"
                 x-on:error="$el.src = '/images/bing/today.jpg'">

            {{-- 1. Scrim ابسیدین لوکس: لایه مخملین سینمایی برای مهار اشعه زننده و حفظ زیبایی تصویر --}}
            <div x-show="themeKey === 'bing-daily'" class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/65 to-slate-950/50 backdrop-blur-[1px] backdrop-contrast-[1.10]"></div>

            {{-- 2. Scrim استودیو: لایه ملایم نیمه‌تاریک --}}
            <div x-show="themeKey === 'bing-studio'" class="absolute inset-0 bg-slate-950/50 backdrop-blur-[1px]"></div>

            {{-- 3. Scrim پرسلین سرامیک: لایه روشن طبیعی --}}
            <div x-show="themeKey === 'bing-ceramic'" class="absolute inset-0 bg-slate-950/20 backdrop-contrast-[1.05]"></div>
        </div>

        {{-- Luxury Silk Wave Vector (اختصاصی تم روشن - کاملاً استاتیک و بدون هیچ‌گونه بار پردازنده) --}}
        <template x-if="themeKey === 'light-modern'">
            <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden select-none">
                <svg class="w-full h-full object-cover opacity-70" viewBox="0 0 1440 900" fill="none" preserveAspectRatio="none">
                    <path d="M-100 180 C300 80, 650 420, 1050 220 C1350 80, 1500 320, 1600 280" stroke="rgba(217,119,6,0.18)" stroke-width="1.8"/>
                    <path d="M-100 220 C350 120, 700 460, 1100 260 C1380 120, 1520 360, 1600 320" stroke="rgba(217,119,6,0.14)" stroke-width="1.5"/>
                    <path d="M-100 260 C400 160, 750 500, 1150 300 C1410 160, 1540 400, 1600 360" stroke="rgba(217,119,6,0.10)" stroke-width="1.2"/>
                    <path d="M-100 620 C400 430, 780 820, 1180 620 C1420 480, 1540 680, 1600 620" stroke="rgba(14,165,233,0.15)" stroke-width="1.8"/>
                    <path d="M-100 660 C450 470, 820 860, 1220 660 C1460 520, 1560 720, 1600 660" stroke="rgba(14,165,233,0.12)" stroke-width="1.5"/>
                    <path d="M-100 700 C500 510, 860 900, 1260 700 C1490 560, 1580 760, 1600 700" stroke="rgba(14,165,233,0.08)" stroke-width="1.2"/>
                </svg>
            </div>
        </template>

        {{-- Imperial Royal Gold Silk Mesh (تارهای طلای شاهنشاهی ۲۴ عیار - ۱۰۰٪ استاتیک و بدون بار پردازنده) --}}
        <template x-if="themeKey === 'imperial-onyx'">
            <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden select-none opacity-60">
                <svg class="w-full h-full object-cover" viewBox="0 0 1440 900" fill="none" preserveAspectRatio="none">
                    <path d="M-100 200 C350 100, 700 450, 1100 240 C1380 90, 1520 340, 1600 300" stroke="rgba(251,191,36,0.24)" stroke-width="2"/>
                    <path d="M-100 240 C400 140, 750 490, 1150 280 C1420 130, 1550 380, 1600 340" stroke="rgba(251,191,36,0.18)" stroke-width="1.6"/>
                    <path d="M-100 280 C450 180, 800 530, 1200 320 C1460 170, 1580 420, 1600 380" stroke="rgba(251,191,36,0.12)" stroke-width="1.2"/>
                    <path d="M-100 640 C420 450, 800 840, 1200 640 C1440 500, 1560 700, 1600 640" stroke="rgba(245,158,11,0.20)" stroke-width="2"/>
                    <path d="M-100 680 C470 490, 840 880, 1240 680 C1480 540, 1580 740, 1600 680" stroke="rgba(245,158,11,0.14)" stroke-width="1.5"/>
                    <path d="M-100 720 C520 530, 880 920, 1280 720 C1510 580, 1600 780, 1600 720" stroke="rgba(245,158,11,0.08)" stroke-width="1.2"/>
                </svg>
            </div>
        </template>

        <template x-if="themeKey === 'imperial-pearl'">
            <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden select-none opacity-60">
                <svg class="w-full h-full object-cover" viewBox="0 0 1440 900" fill="none" preserveAspectRatio="none">
                    <path d="M-100 200 C350 100, 700 450, 1100 240 C1380 90, 1520 340, 1600 300" stroke="rgba(217,119,6,0.20)" stroke-width="2"/>
                    <path d="M-100 240 C400 140, 750 490, 1150 280 C1420 130, 1550 380, 1600 340" stroke="rgba(217,119,6,0.15)" stroke-width="1.6"/>
                    <path d="M-100 280 C450 180, 800 530, 1200 320 C1460 170, 1580 420, 1600 380" stroke="rgba(217,119,6,0.10)" stroke-width="1.2"/>
                    <path d="M-100 640 C420 450, 800 840, 1200 640 C1440 500, 1560 700, 1600 640" stroke="rgba(217,119,6,0.18)" stroke-width="2"/>
                    <path d="M-100 680 C470 490, 840 880, 1240 680 C1480 540, 1580 740, 1600 680" stroke="rgba(217,119,6,0.12)" stroke-width="1.5"/>
                    <path d="M-100 720 C520 530, 880 920, 1280 720 C1510 580, 1600 780, 1600 720" stroke="rgba(217,119,6,0.08)" stroke-width="1.2"/>
                </svg>
            </div>
        </template>

        {{-- Apple Premium Ambient Floating Orbs Engine (۱۲ گوی نورانی، تفکیک‌شده، متحرک و سبک اپل) --}}
        <div class="ambient-orb-container" :class="'theme-' + themeKey" x-show="!ecoMode && !isBingTheme && themeKey !== 'pure-black'">
            <div class="ambient-orb orb-1"></div>
            <div class="ambient-orb orb-2"></div>
            <div class="ambient-orb orb-3"></div>
            <div class="ambient-orb orb-4"></div>
            <div class="ambient-orb orb-5"></div>
            <div class="ambient-orb orb-6"></div>
            <div class="ambient-orb orb-7"></div>
            <div class="ambient-orb orb-8"></div>
            <div class="ambient-orb orb-9"></div>
            <div class="ambient-orb orb-10"></div>
            <div class="ambient-orb orb-11"></div>
            <div class="ambient-orb orb-12"></div>
        </div>

        {{-- بوم مجازی با نسبت طلایی ۱۶:۹ با مقیاس‌گذاری خودکار سخت‌افزاری --}}
        <div id="tv-stage-viewport" class="fixed inset-0 z-10 w-screen h-screen overflow-hidden pointer-events-none">
            <div id="tv-stage-canvas" class="pointer-events-auto absolute left-0 top-0 w-[1920px] h-[1080px] p-4 xl:p-5 pb-3.5 flex flex-col justify-between gap-2 overflow-hidden select-none">

            {{-- Header --}}
            <header :class="theme.headerBg" class="display-header rounded-[2rem] px-8 py-3.5 h-[136px] flex flex-row items-center justify-between gap-4 shrink-0 animate-fadeInUp shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all duration-500">

                {{-- سمت راست: QR کد و اطلاعات --}}
                <div class="order-1 flex w-[38%] items-center gap-5 text-right">
                    {{-- دکمه‌ها و اطلاعات تماس (سایز بزرگتر و خواناتر) --}}
                    <div class="flex flex-col gap-2 justify-center items-stretch shrink-0 w-fit">
                        <template x-if="settings.phone">
                            <div :class="isLightTheme ? (themeKey === 'imperial-pearl' ? 'bg-white/90 hover:bg-white border-amber-300/50 text-amber-950 shadow-[inset_0_1.5px_1.5px_rgba(255,255,255,1),-3px_-3px_8px_rgba(255,255,255,0.9),3px_6px_14px_rgba(148,163,184,0.2)] hover:scale-[1.02]' : 'bg-white/80 border-white shadow-[-2px_-2px_6px_rgba(255,255,255,1),3px_3px_8px_rgba(148,163,184,0.25)]') : (themeKey === 'imperial-onyx' ? 'bg-amber-950/40 hover:bg-amber-900/50 border border-amber-400/35 text-amber-100 shadow-[inset_0_1px_1px_rgba(251,191,36,0.3),0_4px_14px_rgba(0,0,0,0.7)] hover:scale-[1.02]' : (isBingTheme ? 'bg-white/10 hover:bg-white/20 border-white/15 backdrop-blur-xl shadow-[-2px_-2px_6px_rgba(255,255,255,0.04),3px_4px_12px_rgba(0,0,0,0.6)]' : 'bg-black/20 border-white/10 shadow-[-2px_-2px_6px_rgba(255,255,255,0.03),3px_4px_10px_rgba(0,0,0,0.5)]'))" 
                                 class="flex items-center gap-3 px-4 py-2 rounded-2xl border text-sm xl:text-base font-black transition-all hover:scale-[1.02] w-full" dir="ltr">
                                <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.387a12.035 12.035 0 01-7.108-7.108c-.157-.44.009-.928.387-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                <span :class="theme.textPrimary" class="tracking-wide select-all" x-text="settings.phone.replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d])"></span>
                            </div>
                        </template>
                        
                        <template x-if="settings.instagram">
                            <div :class="isLightTheme ? (themeKey === 'imperial-pearl' ? 'bg-white/90 hover:bg-white border-amber-300/50 text-amber-950 shadow-[inset_0_1.5px_1.5px_rgba(255,255,255,1),-3px_-3px_8px_rgba(255,255,255,0.9),3px_6px_14px_rgba(148,163,184,0.2)] hover:scale-[1.02]' : 'bg-white/80 border-white shadow-[-2px_-2px_6px_rgba(255,255,255,1),3px_3px_8px_rgba(148,163,184,0.25)]') : (themeKey === 'imperial-onyx' ? 'bg-amber-950/40 hover:bg-amber-900/50 border border-amber-400/35 text-amber-100 shadow-[inset_0_1px_1px_rgba(251,191,36,0.3),0_4px_14px_rgba(0,0,0,0.7)] hover:scale-[1.02]' : (isBingTheme ? 'bg-white/10 hover:bg-white/20 border-white/15 backdrop-blur-xl shadow-[-2px_-2px_6px_rgba(255,255,255,0.04),3px_4px_12px_rgba(0,0,0,0.6)]' : 'bg-black/20 border-white/10 shadow-[-2px_-2px_6px_rgba(255,255,255,0.03),3px_4px_10px_rgba(0,0,0,0.5)]'))" 
                                 class="flex items-center gap-3 px-4 py-2 rounded-2xl border text-sm xl:text-base font-bold transition-all hover:scale-[1.02] w-full" dir="ltr">
                                <svg class="w-5 h-5 text-pink-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                <span :class="theme.textPrimary" class="tracking-wide truncate" x-text="settings.instagram"></span>
                            </div>
                        </template>
 
                        <template x-if="settings.rubika">
                            <div :class="isLightTheme ? (themeKey === 'imperial-pearl' ? 'bg-white/90 hover:bg-white border-amber-300/50 text-amber-950 shadow-[inset_0_1.5px_1.5px_rgba(255,255,255,1),-3px_-3px_8px_rgba(255,255,255,0.9),3px_6px_14px_rgba(148,163,184,0.2)] hover:scale-[1.02]' : 'bg-white/80 border-white shadow-[-2px_-2px_6px_rgba(255,255,255,1),3px_3px_8px_rgba(148,163,184,0.25)]') : (themeKey === 'imperial-onyx' ? 'bg-amber-950/40 hover:bg-amber-900/50 border border-amber-400/35 text-amber-100 shadow-[inset_0_1px_1px_rgba(251,191,36,0.3),0_4px_14px_rgba(0,0,0,0.7)] hover:scale-[1.02]' : (isBingTheme ? 'bg-white/10 hover:bg-white/20 border-white/15 backdrop-blur-xl shadow-[-2px_-2px_6px_rgba(255,255,255,0.04),3px_4px_12px_rgba(0,0,0,0.6)]' : 'bg-black/20 border-white/10 shadow-[-2px_-2px_6px_rgba(255,255,255,0.03),3px_4px_10px_rgba(0,0,0,0.5)]'))" 
                                 class="flex items-center gap-3 px-4 py-2 rounded-2xl border text-sm xl:text-base font-bold transition-all hover:scale-[1.02] w-full" dir="ltr">
                                <img src="/images/logos/rubika.png" x-on:error="$event.target.src = '/icons/icon-72x72.png'" width="20" height="20" loading="lazy" decoding="async" alt="روبیکا" class="w-5 h-5 object-contain shrink-0">
                                <span :class="theme.textPrimary" class="tracking-wide truncate" x-text="settings.rubika"></span>
                            </div>
                        </template>
                    </div>

                    {{-- QR Code (فریم لوکس با خط اسکن لیزری ملایم) --}}
                    <div class="flex items-center gap-4 transition-all duration-300 hover:scale-[1.02] shrink-0">
                        <div class="relative bg-white p-2 rounded-2xl shadow-[0_10px_25px_rgba(0,0,0,0.25)] border border-white/30 shrink-0 overflow-hidden group">
                            <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' + encodeURIComponent(settings.qr_link || (window.location.origin + '/' + (snapshotData.username || '')))" 
                                 alt="کد QR اختصاصی تابلوی طلافروشی {{ $galleryDisplayName ?? 'طلالایو' }}" 
                                 width="112" height="112"
                                 loading="lazy" decoding="async"
                                 class="w-24 h-24 xl:w-28 xl:h-28 object-contain rounded-lg">
                            {{-- خط اسکن لیزری امبینت --}}
                            <div class="pointer-events-none absolute inset-x-0 h-0.5 bg-gradient-to-r from-transparent via-amber-400 to-transparent shadow-[0_0_8px_rgba(251,191,36,0.85)] animate-laser-sweep"></div>
                        </div>
                        <div class="flex flex-col justify-center max-w-[150px] pr-1">
                            <span :class="theme.textPrimary" class="text-sm xl:text-base font-black leading-tight drop-shadow-sm" 
                                  x-text="settings.qr_link ? (settings.qr_label || 'اسکن کنید') : (settings.qr_label || 'همراه ما باشید')"></span>
                            <span :class="theme.textSecondary" class="text-[11px] xl:text-xs mt-1.5 leading-normal opacity-85 font-bold"
                                  x-text="settings.qr_desc ? settings.qr_desc : (settings.qr_link ? 'عضویت در شبکه‌های اجتماعی' : 'اسکن جهت مشاهده در موبایل')"></span>
                        </div>
                    </div>
                </div>

                {{-- نام فروشگاه (وسط) --}}
                <div class="order-2 flex w-[28%] flex-col items-center justify-center text-center">
                    <h1 :class="isLightTheme ? (themeKey === 'imperial-pearl' ? 'text-transparent bg-clip-text bg-gradient-to-r from-amber-700 via-yellow-600 to-amber-800 drop-shadow-[0_1px_4px_rgba(217,119,6,0.3)]' : 'text-slate-900') : 'text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-yellow-400 to-amber-300 drop-shadow-[0_0_20px_rgba(251,191,36,0.2)]'" 
                        class="max-w-full break-words text-3xl xl:text-4xl font-black tracking-tight leading-tight" x-text="settings.shop_name">{{ $galleryDisplayName ?? 'گالری طلا' }}</h1>
                    <div :class="themeKey === 'imperial-pearl' ? 'bg-amber-500/15 text-amber-900 border border-amber-500/30' : (isLightTheme ? 'bg-blue-600/10 text-blue-700' : 'bg-amber-400/10 text-amber-300 border border-amber-400/20')" 
                         class="mt-1 px-3 py-0.5 rounded-full text-[10px] font-black tracking-wider uppercase flex items-center gap-1.5">
                         <span>✦</span>
                         <span>نرخ‌گذاری لحظه‌ای طلا و ارز — {{ $cityFullDisplay ?? $cityName ?? 'تهران' }}</span>
                         <span>✦</span>
                    </div>
                    {{-- دکمه صفحه اصلی طلالایو --}}
                    <div class="mt-1.5 flex items-center justify-center">
                        <a href="{{ url('/') }}" target="_blank" 
                           :class="isLightTheme ? 'bg-amber-500/15 text-amber-900 border-amber-500/30 hover:bg-amber-500/25' : 'bg-white/10 text-amber-300 border-white/10 hover:bg-white/15'"
                           class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold border transition-all shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                            <span>صفحه اصلی طلالایو</span>
                        </a>
                    </div>

                    {{-- سئوی محلی گوگل و متن معرفی (نامرئی بصری - مخصوص موتورهای جستجو) --}}
                    <div class="sr-only">
                        <p>{{ $galleryIntro ?? ("تابلوی اعلام قیمت لحظه‌ای طلا و سکه " . ($galleryDisplayName ?? 'گالری طلا') . " در " . ($cityFullDisplay ?? $cityName ?? 'ایران')) }}</p>
                        <nav aria-label="راهنمای دسترسی">
                            <a href="{{ url('/cities/' . ($citySlug ?? 'tehran')) }}">طلافروشی‌های {{ $cityFullDisplay ?? $cityName ?? 'تهران' }}</a>
                        </nav>
                    </div>
                </div>

                {{-- تاریخ و ساعت (سمت چپ) --}}
                <div class="order-3 flex w-[38%] flex-row items-center justify-end gap-5 text-left">
                    {{-- کنترل‌ها و دکمه‌های وضعیت (HUD هوشمند با Auto-Hide) --}}
                    <div class="flex flex-col gap-2 items-end justify-center min-h-[58px]">
                        {{-- وضعیت اتصال: اگر ارتباط مختل شد همیشه نشان داده می‌شود، در حالت آنلاین با HUD هماهنگ است --}}
                        <div x-show="showControls || connectionState !== 'online'"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-500"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[0.7rem] font-semibold shrink-0 shadow-sm" 
                                  :class="connectionState === 'online' ? 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/20 text-rose-500 border border-rose-500/30 animate-pulse'">
                                <span class="w-1.5 h-1.5 rounded-full" :class="connectionState === 'online' ? 'bg-emerald-500 dark:bg-emerald-400 animate-pulse' : 'bg-rose-500'"></span>
                                <span x-text="connectionState === 'online' ? 'وضعیت: برخط' : (connectionState === 'offline' ? 'اتصال قطع است' : 'حالت پشتیبان')"></span>
                            </span>
                        </div>

                        {{-- کنترل زوم و تمام صفحه --}}
                        <div x-show="showControls"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-500"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="flex items-center gap-2" dir="ltr">
                            <div class="flex items-center gap-1 bg-black/15 dark:bg-white/10 backdrop-blur-md border border-white/10 rounded-xl px-1.5 py-0.5 shadow-sm" dir="ltr">
                                <button @click.stop="zoomOut(); triggerControls()" class="p-1 rounded-lg cursor-pointer transition-colors hover:bg-black/10 dark:hover:bg-white/15" title="کوچک‌نمایی">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path></svg>
                                </button>
                                <span :class="theme.textPrimary" class="text-[10px] font-black font-mono w-8 text-center select-none" x-text="Math.round(zoomLevel * 100) + '%'"></span>
                                <button @click.stop="zoomIn(); triggerControls()" class="p-1 rounded-lg cursor-pointer transition-colors hover:bg-black/10 dark:hover:bg-white/15" title="بزرگ‌نمایی">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                </button>
                            </div>
                            <button @click.stop="toggleFullscreen(); triggerControls()" class="p-1.5 rounded-xl cursor-pointer bg-black/15 dark:bg-white/10 backdrop-blur-md border border-white/10 transition-all hover:scale-105 shadow-sm" title="تمام‌صفحه">
                                <svg x-show="!isFullscreen" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                <svg x-show="isFullscreen" style="display: none;" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 14h4v4m0-4l-5 5m15-5h-4v4m0-4l5 5M4 10h4V6m0 4l-5-5m15 5h-4V6m0 4l5-5"></path></svg>
                            </button>
                        </div>
                    </div>

                    {{-- خط عمودی جداکننده --}}
                    <div :class="isLightTheme ? 'bg-black/10' : 'bg-white/10'" class="w-[1px] h-16"></div>

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
                <section :class="[theme.card, isLightTheme ? 'border-black/5' : 'border-white/10']" class="relative overflow-hidden rounded-[3rem] w-[35%] h-auto min-h-0 max-h-none group border shadow-3xl shrink-0 transition-transform duration-500 hover:scale-[1.015]">
                    <template x-if="activeProduct">
                        <div class="absolute inset-0" style="contain: paint layout; isolation: isolate;">
                            <!-- لایه‌های دوگانه پینگ‌پنگ جهت ترنزیشن فید متقاطع واقعی و ری‌استارت پیوسته کن‌برنز -->
                            <template x-for="(slot, sIdx) in slots" :key="slot.key">
                                <div class="absolute inset-0 transition-opacity duration-700 ease-in-out overflow-hidden"
                                     :class="slot.active ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'"
                                     style="contain: paint layout; will-change: opacity;">
                                    <img :key="'img-slot-' + slot.key"
                                         :src="slot.url || activeProductImageUrl" 
                                         x-on:error="$event.target.src = '/icons/icon-512x512.png'"
                                         :alt="activeProduct?.title || ''"
                                         class="apple-zoom-img"
                                         :class="slot.zoomed && !ecoMode ? 'is-zooming' : ''"
                                         :style="'--zoom-duration: ' + (Math.max(Number(settings?.slider_interval_sec) || 8, 3)) + 's;'">
                                </div>
                            </template>

                            <!-- نشان لوکس داینامیک محصول در بالای اسلایدر -->
                            <div class="absolute top-5 left-5 z-20 select-none pointer-events-none">
                                <div class="relative flex items-center gap-2.5 rounded-full px-4 py-2.5 shadow-xl border border-white/20 backdrop-blur-md"
                                     :class="{
                                         'slider-top-badge': !activeProduct.badge || activeProduct.badge === 'none',
                                         'bg-gradient-to-r from-emerald-600 via-teal-600 to-amber-600 shadow-emerald-900/40': activeProduct.badge === 'no_wage',
                                         'bg-gradient-to-r from-purple-700 via-violet-600 to-pink-600 shadow-purple-900/40': activeProduct.badge === 'best_seller',
                                         'bg-gradient-to-r from-sky-600 via-blue-600 to-amber-500 shadow-blue-900/40': activeProduct.badge === 'new_collection',
                                         'bg-gradient-to-r from-rose-600 via-red-600 to-amber-600 shadow-rose-900/40': activeProduct.badge === 'special_discount'
                                     }">
                                    <span class="relative flex h-6 w-6 items-center justify-center rounded-full bg-white/20 shadow-inner">
                                        <span class="animate-ping absolute inline-flex h-3.5 w-3.5 rounded-full bg-white opacity-80"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white shadow-sm"></span>
                                    </span>
                                    <span class="text-base xl:text-lg font-black leading-tight tracking-wide text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.4)]"
                                          x-text="{
                                              'no_wage': 'بدون اجرت / کم‌اجرت',
                                              'best_seller': 'پرفروش‌ترین ویترین',
                                              'new_collection': 'کالکشن جدید',
                                              'special_discount': 'تخفیف ویژه امروز'
                                          }[activeProduct.badge] || 'پیشنهاد شگفت‌انگیز'">
                                    </span>
                                </div>
                            </div>
                            
                            <!-- گرادیان محافظتی زیرین (تطبیقی با تم روشن و تاریک) -->
                            <div :class="isLightTheme ? 'slider-scrim-bottom-light' : 'slider-scrim-bottom-dark'"></div>
                            
                            <!-- داک شیشه‌ای اطلاعات محصول در پایین اسلایدر (کاملاً هماهنگ با تم فعال و متریال شیشه‌ای) -->
                            <div class="slider-glass-dock">
                                <div :class="[theme.headerBg || theme.card || 'neu-card-light-modern', 'slider-info-card-adaptive']"
                                     class="relative overflow-hidden border shadow-2xl">
                                    <div class="flex flex-row items-end justify-between gap-3">
                                        <div class="min-w-0 flex-1">
                                            <p :class="[theme.textPrimary, isLightTheme ? 'drop-shadow-sm' : 'drop-shadow-[0_2px_8px_rgba(0,0,0,0.85)]']" 
                                               class="break-words text-2xl xl:text-3xl font-black leading-tight line-clamp-1" 
                                               x-text="activeProduct.title"></p>
                                            <div class="mt-2 flex items-center gap-2 flex-wrap">
                                                <template x-if="settings.show_weight">
                                                    <span :class="isLightTheme ? 'slider-chip-light' : 'slider-chip-dark'" class="slider-chip">
                                                        <span class="opacity-80">وزن:</span>
                                                        <span class="tabular-nums font-black" :class="isLightTheme ? 'text-amber-700' : 'text-amber-300'" x-text="activeProduct.weight_gram"></span>
                                                        <span class="opacity-80">گرم</span>
                                                    </span>
                                                </template>
                                                <template x-if="settings.show_profit">
                                                    <span :class="isLightTheme ? 'slider-chip-light' : 'slider-chip-dark'" class="slider-chip">
                                                        <span class="opacity-80">سود:</span>
                                                        <span class="tabular-nums font-black" :class="isLightTheme ? 'text-amber-700' : 'text-amber-300'" x-text="activeProductProfitPercent"></span>
                                                        <span class="opacity-80">%</span>
                                                    </span>
                                                </template>
                                            </div>
                                        </div>
                                        <div :class="[theme.heroCard || (isLightTheme ? 'neu-hero-gold-pearl' : 'neu-hero-gold-imperial'), 'slider-price-badge-adaptive']" class="shrink-0">
                                            <div class="flex items-center justify-between gap-2 mb-0.5">
                                                <span :class="isLightTheme ? 'text-amber-950 font-black' : 'text-amber-300 drop-shadow-sm font-black'" class="text-[9px] xl:text-[10px] uppercase tracking-wider">مبلغ نهایی ویترین</span>
                                                <span class="w-1.5 h-1.5 rounded-full" :class="isLightTheme ? 'bg-amber-600 animate-ping' : 'bg-amber-400 animate-ping'"></span>
                                            </div>
                                            <template x-if="activeProductFinalPrice > 0">
                                                <div class="flex items-baseline gap-1.5 justify-between">
                                                    <span :class="isLightTheme ? 'text-amber-950 drop-shadow-sm' : 'text-white drop-shadow-[0_2px_12px_rgba(251,191,36,0.6)]'" 
                                                          class="text-2xl xl:text-3xl font-black tabular-nums tracking-tight font-['Vazirmatn']" 
                                                          style="font-family: 'Vazirmatn', sans-serif !important;"
                                                          x-text="formatNumber(activeProductFinalPrice)"></span>
                                                    <span :class="isLightTheme ? 'text-amber-900 font-bold' : 'text-amber-300 font-bold'" class="text-xs font-black whitespace-nowrap font-['Vazirmatn']" style="font-family: 'Vazirmatn', sans-serif !important;">تومان</span>
                                                </div>
                                            </template>
                                            <template x-if="activeProductFinalPrice <= 0">
                                                <span :class="isLightTheme ? 'text-amber-900 bg-amber-100/80 border border-amber-300' : 'text-amber-200 bg-amber-950/80 border border-amber-500/40'" 
                                                      class="text-[11px] font-black rounded-lg px-2.5 py-1 block text-center">در حال استعلام نرخ...</span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="!activeProduct">
                        <div class="relative w-full h-full overflow-hidden select-none">
                            {{-- حالت ۱: بنر تبریک یا پیام اختصاصی مغازه --}}
                            <template x-if="settings.empty_showcase_mode === 'custom_message'">
                                <div class="relative w-full h-full flex flex-col justify-between p-7 xl:p-9 overflow-hidden select-none animate-fadeIn text-center">
                                    <!-- افکت نور پس‌زمینه هماهنگ با تم بنر -->
                                    <div class="absolute inset-0 pointer-events-none opacity-20 blur-3xl"
                                         :class="{
                                             'bg-gradient-to-tr from-amber-500 via-yellow-400 to-amber-600': !settings.empty_showcase_theme || settings.empty_showcase_theme === 'gold',
                                             'bg-gradient-to-tr from-purple-600 via-pink-500 to-rose-600': settings.empty_showcase_theme === 'celebration',
                                             'bg-gradient-to-tr from-blue-700 via-indigo-600 to-sky-500': settings.empty_showcase_theme === 'royal',
                                             'bg-gradient-to-tr from-emerald-600 via-teal-500 to-amber-500': settings.empty_showcase_theme === 'special_offer'
                                         }"></div>

                                    <!-- هدر بنر: نشان تزیینی ستاره‌ها -->
                                    <div class="relative z-10 flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full border shadow-md backdrop-blur-md"
                                             :class="{
                                                 'bg-amber-500/15 border-amber-500/30 text-amber-300': !settings.empty_showcase_theme || settings.empty_showcase_theme === 'gold',
                                                 'bg-purple-500/15 border-purple-500/30 text-purple-300': settings.empty_showcase_theme === 'celebration',
                                                 'bg-sky-500/15 border-sky-500/30 text-sky-300': settings.empty_showcase_theme === 'royal',
                                                 'bg-emerald-500/15 border-emerald-500/30 text-emerald-300': settings.empty_showcase_theme === 'special_offer'
                                             }">
                                            <span class="text-sm">✦</span>
                                            <span class="text-xs xl:text-sm font-black tracking-wide">پیام ویژه گالری</span>
                                            <span class="text-sm">✦</span>
                                        </div>

                                        <div class="flex items-center gap-1.5 opacity-75 text-xs xl:text-sm font-bold" :class="theme.textSecondary">
                                            <span>✨</span>
                                            <span x-text="galleryDisplayName || 'گالری طلا'"></span>
                                        </div>
                                    </div>

                                    <!-- بخش میانی: آیکون بزرگ، عنوان درشت و متن پیام با فونت خوانا -->
                                    <div class="relative z-10 flex-1 flex flex-col justify-center items-center my-auto py-5 max-w-xl mx-auto">
                                        <div class="w-18 h-18 xl:w-22 xl:h-22 rounded-3xl flex items-center justify-center text-3xl xl:text-5xl shadow-2xl border mb-4 backdrop-blur-md"
                                             :class="{
                                                 'bg-amber-500/20 border-amber-400/50 shadow-amber-500/20 text-amber-300': !settings.empty_showcase_theme || settings.empty_showcase_theme === 'gold',
                                                 'bg-purple-500/20 border-purple-400/50 shadow-purple-500/20 text-pink-300': settings.empty_showcase_theme === 'celebration',
                                                 'bg-sky-500/20 border-sky-400/50 shadow-sky-500/20 text-sky-300': settings.empty_showcase_theme === 'royal',
                                                 'bg-emerald-500/20 border-emerald-400/50 shadow-emerald-500/20 text-emerald-300': settings.empty_showcase_theme === 'special_offer'
                                             }">
                                            <span x-text="{
                                                'gold': '💎',
                                                'celebration': '🌸',
                                                'royal': '👑',
                                                'special_offer': '🎁'
                                            }[settings.empty_showcase_theme] || '✨'"></span>
                                        </div>

                                        <h2 class="text-2xl xl:text-3xl 2xl:text-4xl font-black leading-tight tracking-tight drop-shadow-md mb-3"
                                            :class="isLightTheme ? 'text-slate-950' : 'text-white'"
                                            x-text="settings.empty_showcase_title || 'خوش‌آمدگویی به مشتریان محترم گالری'"></h2>

                                        <div class="w-24 h-1 rounded-full mx-auto my-2"
                                             :class="{
                                                 'bg-gradient-to-r from-transparent via-amber-400 to-transparent': !settings.empty_showcase_theme || settings.empty_showcase_theme === 'gold',
                                                 'bg-gradient-to-r from-transparent via-pink-400 to-transparent': settings.empty_showcase_theme === 'celebration',
                                                 'bg-gradient-to-r from-transparent via-sky-400 to-transparent': settings.empty_showcase_theme === 'royal',
                                                 'bg-gradient-to-r from-transparent via-emerald-400 to-transparent': settings.empty_showcase_theme === 'special_offer'
                                             }"></div>

                                        <p class="text-sm xl:text-base 2xl:text-lg font-bold leading-loose opacity-90 mt-2 max-w-lg"
                                           :class="isLightTheme ? 'text-slate-700' : 'text-slate-200'"
                                           x-text="settings.empty_showcase_text || 'به گالری طلا و جواهر ما خوش آمدید. افتخار ما همراهی با شما در انتخاب زیباترین زیورآلات و طلا با بهترین کیفیت و مناسب‌ترین اجرت است.'"></p>
                                    </div>

                                    <!-- فوتر بنر -->
                                    <div class="relative z-10 pt-3 border-t flex items-center justify-between gap-3"
                                         :class="isLightTheme ? 'border-slate-200 text-slate-600' : 'border-white/10 text-slate-300'">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                            <span class="text-xs xl:text-sm font-black" x-text="galleryDisplayName"></span>
                                        </div>
                                        <span class="text-xs xl:text-sm font-bold opacity-75">خرید و مشاوره حضوری در مغازه</span>
                                    </div>
                                </div>
                            </template>

                            {{-- حالت ۲: راهنمای هوشمند ویترین (با فونت درشت و خوانا) --}}
                            <template x-if="settings.empty_showcase_mode !== 'custom_message'">
                                <div class="relative w-full h-full flex flex-col justify-between p-6 xl:p-8 overflow-hidden select-none animate-fadeIn">
                                    <!-- نورپردازی پس‌زمینه ملایم لوکس -->
                                    <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full blur-3xl pointer-events-none opacity-20"
                                         :class="isLightTheme ? 'bg-amber-400' : 'bg-amber-500'"></div>
                                    <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full blur-3xl pointer-events-none opacity-15"
                                         :class="isLightTheme ? 'bg-amber-500' : 'bg-amber-400'"></div>

                                    <!-- هدر راهنما: نشان بالا و نقاط وضعیت اسلایدها -->
                                    <div class="relative z-10 flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2 px-4 py-2 rounded-full border shadow-sm backdrop-blur-md"
                                             :class="isLightTheme ? 'bg-amber-500/10 border-amber-500/20 text-amber-900' : 'bg-amber-500/15 border-amber-500/30 text-amber-300'">
                                            <span class="relative flex h-2.5 w-2.5">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                                            </span>
                                            <span class="text-xs xl:text-sm font-black tracking-wide">✨ راهنمای هوشمند ویترین طلا</span>
                                        </div>
                                        <div class="flex items-center gap-1.5" dir="ltr">
                                            <template x-for="i in [0, 1, 2]" :key="i">
                                                <div class="h-2 rounded-full transition-all duration-500"
                                                     :class="isLightTheme 
                                                        ? (i === emptyGuideIndex ? 'w-9 bg-amber-600' : 'w-2.5 bg-slate-300') 
                                                        : (i === emptyGuideIndex ? 'w-9 bg-amber-400' : 'w-2.5 bg-white/20')"></div>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- اسلاید ۱: معرفی ویترین هوشمند چیست -->
                                    <div x-show="emptyGuideIndex === 0"
                                         x-transition:enter="transition ease-out duration-500"
                                         x-transition:enter-start="opacity-0 translate-y-4 scale-98"
                                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                         x-transition:leave="transition ease-in duration-300"
                                         x-transition:leave-start="opacity-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 -translate-y-4"
                                         class="relative z-10 flex-1 flex flex-col justify-center my-auto py-3">
                                        <div class="flex items-center gap-3.5 mb-3">
                                            <div class="w-13 h-13 xl:w-16 xl:h-16 rounded-2xl flex items-center justify-center text-2xl xl:text-3xl shadow-lg border shrink-0"
                                                 :class="isLightTheme ? 'bg-amber-100 border-amber-300 text-amber-900 shadow-amber-500/10' : 'bg-amber-500/20 border-amber-400/40 text-amber-300 shadow-amber-500/20'">
                                                💎
                                            </div>
                                            <div>
                                                <h3 class="text-xl xl:text-2xl 2xl:text-3xl font-black leading-tight" :class="theme.textPrimary">
                                                    ویترین هوشمند گالری چیست؟
                                                </h3>
                                                <p class="text-xs xl:text-sm font-bold mt-1 opacity-85" :class="theme.textSecondary">
                                                    نمایشگر دیجیتال زیورآلات متصل به بازار لحظه‌ای طلا
                                                </p>
                                            </div>
                                        </div>

                                        <div class="space-y-3 mt-2">
                                            <div class="p-3.5 xl:p-4 rounded-2xl border backdrop-blur-sm flex items-start gap-3.5"
                                                 :class="isLightTheme ? 'bg-white/80 border-slate-200/80 shadow-sm' : 'bg-slate-900/60 border-white/10'">
                                                <span class="text-lg xl:text-2xl shrink-0 mt-0.5">⚡</span>
                                                <div class="min-w-0 flex-1 text-right">
                                                    <p class="text-sm xl:text-base font-black" :class="theme.textPrimary">محاسبه آنلاین قیمت فروش</p>
                                                    <p class="text-xs xl:text-sm font-semibold mt-1 leading-relaxed opacity-90" :class="theme.textSecondary">
                                                        مبلغ نهایی هر کار بر اساس وزن، اجرت و آخرین نرخ ثانیه‌ای طلای ۱۸ عیار خودکار محاسبه می‌شود.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="p-3.5 xl:p-4 rounded-2xl border backdrop-blur-sm flex items-start gap-3.5"
                                                 :class="isLightTheme ? 'bg-white/80 border-slate-200/80 shadow-sm' : 'bg-slate-900/60 border-white/10'">
                                                <span class="text-lg xl:text-2xl shrink-0 mt-0.5">🏷️</span>
                                                <div class="min-w-0 flex-1 text-right">
                                                    <p class="text-sm xl:text-base font-black" :class="theme.textPrimary">برچسب‌های جذاب بازاریابی</p>
                                                    <p class="text-xs xl:text-sm font-semibold mt-1 leading-relaxed opacity-90" :class="theme.textSecondary">
                                                        نشان‌های «بدون اجرت»، «پرفروش‌ترین»، «کالکشن جدید» و «تخفیف ویژه» جهت جلب توجه خریداران.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="p-3.5 xl:p-4 rounded-2xl border backdrop-blur-sm flex items-start gap-3.5"
                                                 :class="isLightTheme ? 'bg-white/80 border-slate-200/80 shadow-sm' : 'bg-slate-900/60 border-white/10'">
                                                <span class="text-lg xl:text-2xl shrink-0 mt-0.5">✨</span>
                                                <div class="min-w-0 flex-1 text-right">
                                                    <p class="text-sm xl:text-base font-black" :class="theme.textPrimary">افکت‌های سینمایی متحرک</p>
                                                    <p class="text-xs xl:text-sm font-semibold mt-1 leading-relaxed opacity-90" :class="theme.textSecondary">
                                                        چرخش خودکار اسلایدر و جلوه زوم آرام (Ken Burns) تصاویر طلا با کیفیت بالا.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- اسلاید ۲: راهنمای ۳ مرحله‌ای افزودن محصول -->
                                    <div x-show="emptyGuideIndex === 1"
                                         x-transition:enter="transition ease-out duration-500"
                                         x-transition:enter-start="opacity-0 translate-y-4 scale-98"
                                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                         x-transition:leave="transition ease-in duration-300"
                                         x-transition:leave-start="opacity-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 -translate-y-4"
                                         class="relative z-10 flex-1 flex flex-col justify-center my-auto py-3">
                                        <div class="flex items-center gap-3.5 mb-3">
                                            <div class="w-13 h-13 xl:w-16 xl:h-16 rounded-2xl flex items-center justify-center text-2xl xl:text-3xl shadow-lg border shrink-0"
                                                 :class="isLightTheme ? 'bg-amber-100 border-amber-300 text-amber-900 shadow-amber-500/10' : 'bg-amber-500/20 border-amber-400/40 text-amber-300 shadow-amber-500/20'">
                                                📲
                                            </div>
                                            <div>
                                                <h3 class="text-xl xl:text-2xl 2xl:text-3xl font-black leading-tight" :class="theme.textPrimary">
                                                    چگونه محصول اضافه کنیم؟
                                                </h3>
                                                <p class="text-xs xl:text-sm font-bold mt-1 opacity-85" :class="theme.textSecondary">
                                                    فعال‌سازی در کمتر از ۱ دقیقه با ۳ مرحله ساده
                                                </p>
                                            </div>
                                        </div>

                                        <div class="space-y-3 mt-2">
                                            <div class="p-3.5 xl:p-4 rounded-2xl border backdrop-blur-sm flex items-center gap-3.5"
                                                 :class="isLightTheme ? 'bg-white/80 border-slate-200/80 shadow-sm' : 'bg-slate-900/60 border-white/10'">
                                                <span class="w-8 h-8 xl:w-9 xl:h-9 rounded-full flex items-center justify-center text-sm font-black shrink-0 bg-amber-500 text-slate-950">۱</span>
                                                <div class="min-w-0 flex-1 text-right">
                                                    <p class="text-sm xl:text-base font-black" :class="theme.textPrimary">ورود به پنل مدیریت</p>
                                                    <p class="text-xs xl:text-sm font-semibold mt-0.5 opacity-90" :class="theme.textSecondary">
                                                        با گوشی یا رایانه وارد آدرس <span class="font-mono font-bold text-amber-500">talalive.ir/admin</span> شوید.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="p-3.5 xl:p-4 rounded-2xl border backdrop-blur-sm flex items-center gap-3.5"
                                                 :class="isLightTheme ? 'bg-white/80 border-slate-200/80 shadow-sm' : 'bg-slate-900/60 border-white/10'">
                                                <span class="w-8 h-8 xl:w-9 xl:h-9 rounded-full flex items-center justify-center text-sm font-black shrink-0 bg-amber-500 text-slate-950">۲</span>
                                                <div class="min-w-0 flex-1 text-right">
                                                    <p class="text-sm xl:text-base font-black" :class="theme.textPrimary">انتخاب «ویترین طلا (اسلایدر)»</p>
                                                    <p class="text-xs xl:text-sm font-semibold mt-0.5 opacity-90" :class="theme.textSecondary">
                                                        از منوی کناری، روی گزینه ویترین طلا کلیک کنید.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="p-3.5 xl:p-4 rounded-2xl border backdrop-blur-sm flex items-center gap-3.5"
                                                 :class="isLightTheme ? 'bg-white/80 border-slate-200/80 shadow-sm' : 'bg-slate-900/60 border-white/10'">
                                                <span class="w-8 h-8 xl:w-9 xl:h-9 rounded-full flex items-center justify-center text-sm font-black shrink-0 bg-amber-500 text-slate-950">۳</span>
                                                <div class="min-w-0 flex-1 text-right">
                                                    <p class="text-sm xl:text-base font-black" :class="theme.textPrimary">افزودن عکس، وزن و اجرت</p>
                                                    <p class="text-xs xl:text-sm font-semibold mt-0.5 opacity-90" :class="theme.textSecondary">
                                                        عکس زیورآلات را انتخاب و مشخصات را ثبت کنید (حجم عکس خودکار بهینه می‌شود).
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- اسلاید ۳: نکات طلایی فروش و بازاریابی -->
                                    <div x-show="emptyGuideIndex === 2"
                                         x-transition:enter="transition ease-out duration-500"
                                         x-transition:enter-start="opacity-0 translate-y-4 scale-98"
                                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                         x-transition:leave="transition ease-in duration-300"
                                         x-transition:leave-start="opacity-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 -translate-y-4"
                                         class="relative z-10 flex-1 flex flex-col justify-center my-auto py-3">
                                        <div class="flex items-center gap-3.5 mb-3">
                                            <div class="w-13 h-13 xl:w-16 xl:h-16 rounded-2xl flex items-center justify-center text-2xl xl:text-3xl shadow-lg border shrink-0"
                                                 :class="isLightTheme ? 'bg-amber-100 border-amber-300 text-amber-900 shadow-amber-500/10' : 'bg-amber-500/20 border-amber-400/40 text-amber-300 shadow-amber-500/20'">
                                                ⭐
                                            </div>
                                            <div>
                                                <h3 class="text-xl xl:text-2xl 2xl:text-3xl font-black leading-tight" :class="theme.textPrimary">
                                                    افزایش فروش با ویترین هوشمند
                                                </h3>
                                                <p class="text-xs xl:text-sm font-bold mt-1 opacity-85" :class="theme.textSecondary">
                                                    راهکارهایی برای بهره‌وری حداکثری از تابلوی مغازه
                                                </p>
                                            </div>
                                        </div>

                                        <div class="space-y-3 mt-2">
                                            <div class="p-3.5 xl:p-4 rounded-2xl border backdrop-blur-sm flex items-start gap-3.5"
                                                 :class="isLightTheme ? 'bg-white/80 border-slate-200/80 shadow-sm' : 'bg-slate-900/60 border-white/10'">
                                                <span class="text-lg xl:text-2xl shrink-0 mt-0.5">📸</span>
                                                <div class="min-w-0 flex-1 text-right">
                                                    <p class="text-sm xl:text-base font-black" :class="theme.textPrimary">عکاسی با موبایل زیر نور مغازه</p>
                                                    <p class="text-xs xl:text-sm font-semibold mt-1 leading-relaxed opacity-90" :class="theme.textSecondary">
                                                        عکسبرداری روی استند مخمل یا چرمی جلوه لوکسی روی نمایشگر بزرگ تلویزیون ایجاد می‌کند.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="p-3.5 xl:p-4 rounded-2xl border backdrop-blur-sm flex items-start gap-3.5"
                                                 :class="isLightTheme ? 'bg-white/80 border-slate-200/80 shadow-sm' : 'bg-slate-900/60 border-white/10'">
                                                <span class="text-lg xl:text-2xl shrink-0 mt-0.5">🔥</span>
                                                <div class="min-w-0 flex-1 text-right">
                                                    <p class="text-sm xl:text-base font-black" :class="theme.textPrimary">معرفی کارهای کم‌اجرت و بدون اجرت</p>
                                                    <p class="text-xs xl:text-sm font-semibold mt-1 leading-relaxed opacity-90" :class="theme.textSecondary">
                                                        با نشان «بدون اجرت»، کارهای مناسب پس‌انداز و سرمایه‌گذاری را سریع‌تر به فروش برسانید.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="p-3.5 xl:p-4 rounded-2xl border backdrop-blur-sm flex items-start gap-3.5"
                                                 :class="isLightTheme ? 'bg-white/80 border-slate-200/80 shadow-sm' : 'bg-slate-900/60 border-white/10'">
                                                <span class="text-lg xl:text-2xl shrink-0 mt-0.5">🔄</span>
                                                <div class="min-w-0 flex-1 text-right">
                                                    <p class="text-sm xl:text-base font-black" :class="theme.textPrimary">تنوع تا ۱۰ اسلایدر همزمان</p>
                                                    <p class="text-xs xl:text-sm font-semibold mt-1 leading-relaxed opacity-90" :class="theme.textSecondary">
                                                        می‌توانید تا ۱۰ محصول مختلف را ثبت کنید تا مشتریان در مغازه مجموعه‌ای از کارهایتان را ببینند.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- نوار فوتر کارت راهنما -->
                                    <div class="relative z-10 pt-3 border-t flex items-center justify-between gap-2"
                                         :class="isLightTheme ? 'border-slate-200 text-slate-600' : 'border-white/10 text-slate-300'">
                                        <span class="text-xs xl:text-sm font-bold opacity-85">
                                            ثبت و ویرایش محصولات: <span class="text-amber-500 font-black">پنل کاربری طلالایو</span>
                                        </span>
                                        <span class="text-xs xl:text-sm font-mono opacity-70">talalive.ir/admin</span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                    <!-- نوارهای پیشرفت استوری در بالای اسلایدر (طراحی مینیمال، پرمیوم، بدون کادر و حاشیه) -->
                    <div class="absolute top-6 right-8 flex items-center gap-1.5 z-30 select-none pointer-events-auto" 
                         x-show="products.length > 1"
                         dir="rtl">
                        <template x-for="(prod, i) in products" :key="i">
                            <div class="h-1 rounded-full overflow-hidden transition-all duration-300 cursor-pointer drop-shadow-[0_1px_3px_rgba(0,0,0,0.45)]"
                                 :style="{
                                     width: products.length > 8 ? '20px' : (products.length > 5 ? '32px' : '44px')
                                 }"
                                 :class="isLightTheme ? 'bg-slate-900/25' : 'bg-white/30'"
                                 @click="goToSlide(i)"
                                 :title="prod.title || ('محصول ' + (i + 1))">
                                <!-- نوار پر شونده نرم زمانی شیوه اپل (۱۰۰٪ شتاب‌یافته سخت‌افزاری scaleX با ترنزیشن GPU) -->
                                <div class="apple-story-bar rounded-full"
                                     :class="[
                                         isLightTheme ? 'bg-slate-900 shadow-sm' : 'bg-white shadow-[0_0_8px_rgba(255,255,255,0.9)]',
                                         i < activeIndex ? 'is-completed' : (i > activeIndex ? 'is-waiting' : (storyActive ? 'is-active' : 'is-waiting'))
                                     ]"
                                     :style="'--story-duration: ' + (Math.max(Number(settings?.slider_interval_sec) || 8, 3)) + 's;'"
                                     :key="'story-' + i + '-' + slideKey">
                                </div>
                            </div>
                        </template>
                    </div>
                </section>

                {{-- Price Grid With Unified Glass Stage --}}
                <div class="relative flex-1 min-h-0 animate-fadeInUp" style="animation-delay: 150ms;">
                    {{-- Unified Single-Pass Glass Backdrop (۱ پاس محاسباتی بلور برای کل ۱۶ کارت به جای ۱۶ پاس مجزا) --}}
                    <div class="price-grid-backdrop absolute -inset-1 rounded-[2.25rem] pointer-events-none z-0"></div>
                    <div class="price-grid relative z-10 grid grid-cols-12 gap-3 h-full min-h-0 auto-rows-fr"
                         :style="orderedMetrics.length > 11 ? 'grid-template-rows: 1.5fr 1fr 1fr 1fr;' : 'grid-template-rows: 1.5fr 1fr 1fr;'">
                        <template x-for="(item, index) in orderedMetrics" :key="item.symbol">
                            <div :class="[
                                 item.symbol === 'gold18' ? (theme.heroCard || 'neu-hero-gold-imperial') : (theme.card + ' ' + theme.cardHover),
                                 index < 3 ? 'col-span-4 px-5 xl:px-6 pb-5 pt-4' : 'col-span-3 px-3.5 xl:px-4 pb-3.5 pt-3.5'
                                 ]"
                                 class="relative overflow-hidden flex min-w-0 flex-col justify-between rounded-[1.75rem] transition-[transform,box-shadow,border-color] duration-300 h-full min-h-0">

                                <template x-if="item.symbol === 'gold18'">
                                    <div class="absolute inset-0 pointer-events-none overflow-hidden rounded-[1.75rem] z-0">
                                        {{-- Silky Liquid Gold Specular Shimmer (پرتو متحرک آینه‌ای لوکس طلای ۱۸ عیار) --}}
                                        <div class="gold-beam-shimmer animate-gold-beam"></div>
                                    </div>
                                </template>

                                {{-- هدر کارت: عنوان نماد، نشانگر زنده و فلش روند اپلی همراه با ستاره ظریف طلایی --}}
                                <div class="relative flex justify-between items-center gap-2.5 z-10">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <template x-if="item.symbol === 'gold18'">
                                            <span class="text-amber-500 animate-sparkle text-sm xl:text-base select-none leading-none">✦</span>
                                        </template>
                                        <p :class="[item.symbol === 'gold18' ? (isLightTheme ? 'text-amber-950 font-black' : 'text-amber-200 font-black') : theme.textPrimary, index < 3 ? 'text-2xl xl:text-3xl' : 'text-lg xl:text-xl']"
                                           class="market-tile-label min-w-0 font-black tracking-tight drop-shadow-sm line-clamp-1 shrink-0" style="line-height:1.2;" x-text="item.label"></p>

                                        {{-- نشانگر وضعیت زنده (لحظه‌ای / قدیمی) بعد از عنوان کارت --}}
                                        <template x-if="isItemStale(item)">
                                            <span class="inline-flex items-center rounded-full font-bold border shadow-sm shrink-0"
                                                  :class="[
                                                      isLightTheme ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-amber-500/15 text-amber-400 border-amber-500/30',
                                                      index < 3 ? 'gap-1.5 text-xs xl:text-sm px-2.5 py-1' : 'gap-1 text-[10px] xl:text-[11px] px-2 py-0.5'
                                                  ]">
                                                <span :class="index < 3 ? 'w-2 h-2' : 'w-1.5 h-1.5'" class="rounded-full bg-amber-500 shrink-0"></span>
                                                <span>قدیمی</span>
                                            </span>
                                        </template>
                                        <template x-if="!isItemStale(item)">
                                            <span class="inline-flex items-center rounded-full shadow-sm shrink-0 font-bold"
                                                  :class="[
                                                      themeKey === 'imperial-onyx' ? 'neu-status-pill-dark' : (themeKey === 'imperial-pearl' ? 'neu-status-pill-light' : (isLightTheme ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/80' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20')),
                                                      index < 3 ? 'gap-2 text-xs xl:text-sm px-2.5 py-1' : 'gap-1.5 text-[10px] xl:text-[11px] px-2 py-0.5'
                                                  ]">
                                                <span :class="index < 3 ? 'h-2 w-2 xl:h-2.5 xl:w-2.5' : 'h-1.5 w-1.5 xl:h-2 xl:w-2'" class="inline-block rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.95)] shrink-0"></span>
                                                <span class="opacity-90">لحظه‌ای</span>
                                            </span>
                                        </template>
                                    </div>
                                    <div x-show="item.value > 0" class="flex items-center shrink-0">
                                        <template x-if="item.change_percent > 0">
                                            <div class="flex items-center justify-center p-1.5 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 shadow-[0_0_12px_rgba(16,185,129,0.3)]">
                                                <svg class="w-4 h-4 xl:w-5 xl:h-5 text-emerald-500 stroke-[3]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                    <polyline points="17 6 23 6 23 12"></polyline>
                                                </svg>
                                            </div>
                                        </template>
                                        <template x-if="item.change_percent < 0">
                                            <div class="flex items-center justify-center p-1.5 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-400 shadow-[0_0_12px_rgba(244,63,94,0.3)]">
                                                <svg class="w-4 h-4 xl:w-5 xl:h-5 text-rose-500 stroke-[3]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                                    <polyline points="17 18 23 18 23 12"></polyline>
                                                </svg>
                                            </div>
                                        </template>
                                        <template x-if="item.change_percent == 0">
                                            <div class="flex items-center justify-center p-1.5 rounded-xl bg-white/5 border border-white/10 opacity-40">
                                                <svg class="w-4 h-4 xl:w-5 xl:h-5 text-slate-400 stroke-[3]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                {{-- بدنه کارت: ارقام قیمت با تایپوگرافی باوقار اپلی --}}
                                <div :class="[
                                    item.symbol === 'gold18' ? (isLightTheme ? 'text-amber-950' : 'text-amber-200') : theme.priceColor,
                                    index < 3 ? 'pt-6 pb-0 translate-y-5' : 'pt-2.5 pb-0 translate-y-2'
                                ]" class="relative flex-1 flex min-w-0 flex-col justify-center items-center">
                                    <div class="flex flex-col items-center justify-center whitespace-nowrap w-full">
                                          <span :class="[
                                              index < 3 ? 'tv-price-featured' : 'tv-price-regular',
                                              item.symbol === 'gold18' 
                                                  ? (isLightTheme ? 'text-amber-950 drop-shadow-[0_2px_10px_rgba(217,119,6,0.35)]' : 'text-amber-200 drop-shadow-[0_2px_14px_rgba(251,191,36,0.55)]') 
                                                  : theme.priceGlow
                                          ]" class="market-price-number font-black tabular-nums tracking-tighter drop-shadow-md text-center" x-html="item.displayHtml"></span>
                                    </div>
                                </div>

                                {{-- فوتر کارت: کپسول نوسان به سبک Apple Stocks و کپسول واحد پول (تومان / دلار) --}}
                                <div class="relative flex justify-between items-center border-t" :class="[index < 3 ? 'mt-2 pt-2.5' : 'mt-1 pt-2', isLightTheme ? 'border-black/5' : 'border-white/10']">
                                    {{-- کپسول درصد و نوسان (طراحی مشابه Apple Stocks و Neumorphic) --}}
                                    <div class="flex items-center font-black tabular-nums rounded-full border shadow-sm" :class="[
                                        themeKey === 'imperial-onyx'
                                            ? (item.change_percent > 0 ? 'neu-pill-convex-dark-up' : (item.change_percent < 0 ? 'neu-pill-convex-dark-down' : 'neu-pill-convex-dark-flat'))
                                            : (themeKey === 'imperial-pearl'
                                                ? (item.change_percent > 0 ? 'neu-pill-convex-light-up' : (item.change_percent < 0 ? 'neu-pill-convex-light-down' : 'neu-pill-convex-light-flat'))
                                                : (isBingTheme
                                                    ? (item.change_percent > 0 ? 'bg-emerald-500/25 text-emerald-300 border-emerald-400/50 shadow-xs' : (item.change_percent < 0 ? 'bg-rose-500/25 text-rose-300 border-rose-400/50 shadow-xs' : 'bg-white/20 text-white/90 border-white/30 shadow-xs'))
                                                    : (isLightTheme
                                                        ? (item.change_percent > 0 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : (item.change_percent < 0 ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-slate-100 text-slate-700 border-slate-200'))
                                                        : (item.change_percent > 0 ? 'bg-emerald-500/15 text-emerald-400 border-emerald-500/25' : (item.change_percent < 0 ? 'bg-rose-500/15 text-rose-400 border-rose-500/25' : 'bg-white/5 text-slate-400 border-white/10'))))),
                                        index < 3 ? 'gap-2.5 text-sm xl:text-base px-3.5 py-1.5' : 'gap-2 text-xs xl:text-sm px-2.5 py-1'
                                    ]" dir="ltr">
                                        <span x-text="formatSignedNumber(item.change_percent, 2) + '%'"></span>
                                        <span class="opacity-30">|</span>
                                        <span x-text="(item.symbol === 'ounce' || item.symbol === 'bitcoin') ? formatSignedNumber(item.change_value, 2) : formatSignedNumber(item.change_value)"></span>
                                    </div>

                                    {{-- کپسول واحد پول (تومان / دلار) با اندازه و استایل کاملاً هماهنگ با کپسول درصد --}}
                                    <div class="flex items-center">
                                        <span :class="[
                                            themeKey === 'imperial-onyx' 
                                                ? 'neu-unit-pill-dark' 
                                                : (themeKey === 'imperial-pearl' 
                                                    ? 'neu-unit-pill-light' 
                                                    : (isLightTheme ? 'bg-slate-100 text-slate-700 border border-slate-200' : 'bg-white/10 text-white/80 border border-white/15')),
                                            index < 3 ? 'text-sm xl:text-base px-3.5 py-1.5' : 'text-xs xl:text-sm px-2.5 py-1'
                                        ]" class="flex items-center justify-center font-black tabular-nums rounded-full border shadow-sm select-none tracking-wider" x-text="item.unit"></span>
                                    </div>

                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Premium Glassmorphic Footer --}}
            <footer :class="theme.footerBg" class="relative overflow-hidden rounded-[1.75rem] border flex items-center justify-between shrink-0 h-14 animate-fadeInUp shadow-[0_15px_35px_rgba(0,0,0,0.3)] px-6 backdrop-blur-2xl" style="animation-delay: 200ms;" dir="rtl">
                
                {{-- Background decorative glows inside the footer --}}
                <div class="absolute inset-0 pointer-events-none opacity-20 bg-[radial-gradient(circle_at_20%_50%,rgba(245,158,11,0.15),transparent_50%)]"></div>

                {{-- سمت راست: کپسول تبلیغ و راه‌اندازی اختصاصی TalaLive و لینک برگشتی به شهر --}}
                <div class="flex items-center gap-3 h-full z-10">
                    <a href="{{ url('/?home=1') }}" 
                       @click="try { sessionStorage.setItem('skip_redirect', '1'); } catch(e) {}"
                       class="group flex items-center gap-2.5 px-4 py-1.5 rounded-full border transition-all duration-300 hover:scale-105 shadow-sm cursor-pointer"
                       :class="isLightTheme ? 'bg-amber-500/10 border-amber-500/30 text-amber-950 hover:bg-amber-500/20' : 'bg-gradient-to-r from-amber-500/20 via-yellow-500/15 to-amber-600/20 border-amber-400/40 text-amber-200 shadow-[0_0_18px_rgba(245,158,11,0.2)] hover:border-amber-300/60'"
                       title="مشاهده صفحه اصلی سامانه طلالایو">
                        <span class="flex h-2.5 w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-400"></span>
                        </span>
                        <span class="text-xs font-black tracking-wide">راه‌اندازی تابلوی هوشمند:</span>
                        <span class="font-mono font-black text-xs px-2.5 py-0.5 rounded-full" :class="isLightTheme ? 'bg-amber-300/80 text-amber-950' : 'bg-amber-400/30 text-amber-300 border border-amber-400/40'">TalaLive.ir</span>
                    </a>

                    <a href="{{ url('/cities/' . ($citySlug ?? 'tehran')) }}" 
                       class="hidden md:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border border-white/10 hover:border-amber-400/40 transition-all hover:scale-105"
                       :class="isLightTheme ? 'text-slate-800 bg-black/5 hover:bg-black/10' : 'text-slate-200 bg-white/5 hover:bg-white/10'">
                        <span>مراکز طلای {{ $cityFullDisplay ?? $cityName ?? 'تهران' }}</span>
                        <span>←</span>
                    </a>
                </div>


                {{-- مرکز: هویت و فناوری پلتفرم کشوری --}}
                <div class="hidden xl:flex items-center gap-2 justify-center z-10 text-xs font-black" :class="theme.textPrimary">
                    <span class="opacity-90">پلتفرم هوشمند نمایش نرخ و ویترین آنلاین طلا</span>
                    <span class="opacity-25">✦</span>
                    <span :class="isLightTheme ? 'text-slate-500' : 'text-slate-400'" class="font-normal font-mono">By <span class="font-bold text-slate-400 dark:text-slate-300">Bahman Dev</span></span>
                </div>

                {{-- سمت چپ: دکمه خروج + دکمه حالت سبک/روان + وضعیت اتصال و بروزرسانی لحظه‌ای --}}
                <div class="flex items-center gap-2.5 z-10 font-bold text-xs" :class="theme.textSecondary">
                    {{-- دکمه قطع اتصال و خروج از تابلو --}}
                    <button @click="disconnectBoard()" 
                            type="button"
                            class="group flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-bold transition-all duration-200 cursor-pointer shadow-sm select-none"
                            :class="isLightTheme ? 'bg-black/5 hover:bg-rose-500 hover:text-white text-slate-700 border-black/10' : 'bg-white/5 hover:bg-rose-500/80 hover:text-white text-slate-300 border-white/10'"
                            title="قطع اتصال این تلویزیون و خروج از تابلو">
                        <span class="text-xs transition-transform duration-200 group-hover:scale-110">🔌</span>
                        <span>خروج</span>
                    </button>

                    {{-- دکمه حالت سبک / روان (Eco / Smooth Mode Toggle) --}}
                    <button @click="toggleEcoMode()" 
                            type="button"
                            class="group flex items-center gap-2 px-3 py-1.5 rounded-full border text-xs font-bold transition-all duration-200 cursor-pointer shadow-sm select-none"
                            :class="ecoMode 
                                ? (isLightTheme ? 'bg-emerald-600 text-white border-emerald-700 shadow-md ring-2 ring-emerald-400/30' : 'bg-emerald-500/25 text-emerald-300 border-emerald-400/60 shadow-[0_0_12px_rgba(16,185,129,0.35)]') 
                                : (isLightTheme ? 'bg-black/5 hover:bg-black/10 text-slate-700 border-black/10' : 'bg-white/5 hover:bg-white/10 text-slate-300 border-white/10')"
                            :title="ecoMode ? 'غیرفعال‌سازی حالت سبک و بازگشت به جلوه‌های بصری' : 'فعال‌سازی حالت سبک / روان جهت کاهش مصرف منابع سیستم'">
                        <span class="text-sm transition-transform duration-200" :class="ecoMode ? 'scale-110' : 'opacity-70'">⚡</span>
                        <span>حالت سبک</span>
                        <span class="w-2 h-2 rounded-full transition-colors duration-200" 
                              :class="ecoMode ? 'bg-emerald-400 ring-2 ring-emerald-300/50' : 'bg-slate-400/50'"></span>
                    </button>

                    <span class="flex items-center gap-2 bg-black/15 dark:bg-white/10 border border-white/10 rounded-full px-3.5 py-1.5 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500" :class="ecoMode ? '' : 'animate-[pulse_1.5s_infinite]'"></span>
                        <span dir="ltr" class="font-mono text-[11px]" x-text="errorMessage || (snapshotData?.updatedAt ? new Date(snapshotData.updatedAt).toLocaleTimeString('fa-IR', {hour: '2-digit', minute:'2-digit', second:'2-digit'}) : '---')"></span>
                    </span>
                </div>

            </footer>

            </div>
        </div>

        {{-- نشانگر بازخورد کلیدهای ریموت کنترل تلویزیون --}}
        <div x-show="hudFeedbackText"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-4"
             class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[300] px-6 py-2.5 rounded-2xl bg-slate-900/90 text-white font-black text-sm border border-amber-400/40 shadow-2xl backdrop-blur-xl flex items-center gap-2.5 pointer-events-none"
             dir="rtl">
            <span class="text-amber-400">📺</span>
            <span x-text="hudFeedbackText"></span>
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
                bg: 'theme-bg-dark-glass', 
                headerBg: 'neu-card-dark-glass', 
                card: 'neu-card-dark-glass', 
                cardHover: '', 
                heroCard: 'neu-hero-gold-imperial',
                accent: 'text-amber-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/75', 
                textMuted: 'text-white/40', 
                footerBg: 'neu-card-dark-glass', 
                priceColor: 'text-white', 
                priceGlow: 'glow-amber',
                orbs: true, 
                orbColors: ['bg-indigo-600/10 blur-[120px]', 'bg-violet-600/10 blur-[100px]', 'bg-amber-500/5 blur-[120px]'] 
            },
            'light-modern': { 
                bg: 'theme-light-champagne-silk', 
                headerBg: 'neu-card-light-modern', 
                card: 'neu-card-light-modern', 
                cardHover: '', 
                heroCard: 'neu-hero-gold-pearl',
                accent: 'text-amber-700', 
                textPrimary: 'text-slate-900', 
                textSecondary: 'text-slate-800/80', 
                textMuted: 'text-slate-600', 
                footerBg: 'neu-card-light-modern', 
                priceColor: 'text-slate-950', 
                priceGlow: '',
                orbs: false, 
                orbColors: [] 
            },
            'bing-daily': { 
                bg: 'theme-bg-bing', 
                headerBg: 'neu-card-bing-obsidian', 
                card: 'neu-card-bing-obsidian', 
                cardHover: '', 
                heroCard: 'neu-hero-gold-obsidian',
                accent: 'text-amber-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/75', 
                textMuted: 'text-white/45', 
                footerBg: 'neu-card-bing-obsidian', 
                priceColor: 'text-white', 
                priceGlow: 'glow-amber',
                orbs: false, 
                orbColors: [] 
            },
            'bing-studio': { 
                bg: 'theme-bg-bing', 
                headerBg: 'neu-card-bing-studio', 
                card: 'neu-card-bing-studio', 
                cardHover: '', 
                heroCard: 'neu-hero-gold-studio',
                accent: 'text-indigo-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/75', 
                textMuted: 'text-white/45', 
                footerBg: 'neu-card-bing-studio', 
                priceColor: 'text-white', 
                priceGlow: 'glow-cyan',
                orbs: false, 
                orbColors: [] 
            },
            'bing-ceramic': { 
                bg: 'theme-bg-bing', 
                headerBg: 'neu-card-bing-ceramic', 
                card: 'neu-card-bing-ceramic', 
                cardHover: '', 
                heroCard: 'neu-hero-gold-ceramic',
                accent: 'text-amber-700', 
                textPrimary: 'text-slate-900', 
                textSecondary: 'text-slate-800/85', 
                textMuted: 'text-slate-600', 
                footerBg: 'neu-card-bing-ceramic', 
                priceColor: 'text-slate-950', 
                priceGlow: '',
                orbs: false, 
                orbColors: [] 
            },
            'imperial-onyx': { 
                bg: 'theme-imperial-onyx', 
                headerBg: 'neu-card-imperial-onyx', 
                card: 'neu-card-imperial-onyx', 
                cardHover: '', 
                heroCard: 'neu-hero-gold-imperial',
                accent: 'text-amber-400', 
                textPrimary: 'text-amber-100', 
                textSecondary: 'text-amber-200/85', 
                textMuted: 'text-amber-300/45', 
                footerBg: 'neu-card-imperial-onyx', 
                priceColor: 'text-white', 
                priceGlow: 'glow-amber-imperial', 
                orbs: true, 
                orbColors: [
                    'bg-amber-500/18 blur-[130px] animate-float-slow-1',
                    'bg-yellow-500/12 blur-[110px] animate-float-slow-2',
                    'bg-orange-600/12 blur-[140px] animate-float-slow-3',
                    'bg-amber-600/10 blur-[120px] animate-float-slow-4'
                ] 
            },
            'imperial-pearl': { 
                bg: 'theme-imperial-pearl', 
                headerBg: 'neu-card-imperial-pearl', 
                card: 'neu-card-imperial-pearl', 
                cardHover: '', 
                heroCard: 'neu-hero-gold-pearl',
                accent: 'text-amber-600', 
                textPrimary: 'text-slate-900', 
                textSecondary: 'text-slate-700', 
                textMuted: 'text-slate-500', 
                footerBg: 'neu-card-imperial-pearl', 
                priceColor: 'text-slate-950', 
                priceGlow: '', 
                orbs: true, 
                orbColors: [
                    'bg-amber-400/22 blur-[130px] animate-float-slow-1',
                    'bg-yellow-300/20 blur-[110px] animate-float-slow-2',
                    'bg-orange-400/15 blur-[140px] animate-float-slow-3',
                    'bg-amber-300/18 blur-[120px] animate-float-slow-4'
                ] 
            },
            'gold-royal': { 
                bg: 'theme-bg-gold-royal', 
                headerBg: 'neu-card-gold-royal', 
                card: 'neu-card-gold-royal', 
                cardHover: '', 
                heroCard: 'neu-hero-gold-imperial',
                accent: 'text-amber-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/75', 
                textMuted: 'text-white/40', 
                footerBg: 'neu-card-gold-royal', 
                priceColor: 'text-white', 
                priceGlow: 'glow-amber',
                orbs: true, 
                orbColors: ['bg-amber-500/15 blur-[100px]', 'bg-orange-600/15 blur-[120px]', 'bg-yellow-500/10 blur-[80px]'] 
            },
            'blue-ocean': { 
                bg: 'theme-bg-blue-ocean', 
                headerBg: 'neu-card-blue-ocean', 
                card: 'neu-card-blue-ocean', 
                cardHover: '', 
                heroCard: 'neu-hero-blue-ocean',
                accent: 'text-cyan-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/75', 
                textMuted: 'text-white/40', 
                footerBg: 'neu-card-blue-ocean', 
                priceColor: 'text-white', 
                priceGlow: 'glow-cyan',
                orbs: true, 
                orbColors: ['bg-cyan-500/15 blur-[100px]', 'bg-blue-600/15 blur-[120px]', 'bg-indigo-600/10 blur-[80px]'] 
            },
            'purple-haze': { 
                bg: 'theme-bg-purple-haze', 
                headerBg: 'neu-card-purple-haze', 
                card: 'neu-card-purple-haze', 
                cardHover: '', 
                heroCard: 'neu-hero-purple-haze',
                accent: 'text-fuchsia-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/75', 
                textMuted: 'text-white/40', 
                footerBg: 'neu-card-purple-haze', 
                priceColor: 'text-white', 
                priceGlow: 'glow-purple',
                orbs: true, 
                orbColors: ['bg-fuchsia-600/15 blur-[100px]', 'bg-violet-600/15 blur-[120px]', 'bg-purple-800/10 blur-[80px]'] 
            },
            'emerald-night': { 
                bg: 'theme-bg-emerald-night', 
                headerBg: 'neu-card-emerald-night', 
                card: 'neu-card-emerald-night', 
                cardHover: '', 
                heroCard: 'neu-hero-emerald-night',
                accent: 'text-emerald-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/75', 
                textMuted: 'text-white/40', 
                footerBg: 'neu-card-emerald-night', 
                priceColor: 'text-white', 
                priceGlow: 'glow-emerald',
                orbs: true, 
                orbColors: ['bg-emerald-500/15 blur-[100px]', 'bg-teal-600/15 blur-[120px]', 'bg-green-600/10 blur-[80px]'] 
            },
            'rose-dark': { 
                bg: 'theme-bg-rose-dark', 
                headerBg: 'neu-card-rose-dark', 
                card: 'neu-card-rose-dark', 
                cardHover: '', 
                heroCard: 'neu-hero-rose-dark',
                accent: 'text-rose-400', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/75', 
                textMuted: 'text-white/40', 
                footerBg: 'neu-card-rose-dark', 
                priceColor: 'text-white', 
                priceGlow: 'glow-rose',
                orbs: true, 
                orbColors: ['bg-rose-500/15 blur-[100px]', 'bg-pink-600/15 blur-[120px]', 'bg-red-600/10 blur-[80px]'] 
            },
            'pure-black': { 
                bg: 'theme-bg-pure-black', 
                headerBg: 'neu-card-pure-black', 
                card: 'neu-card-pure-black', 
                cardHover: '', 
                heroCard: 'neu-hero-pure-black',
                accent: 'text-zinc-300', 
                textPrimary: 'text-white', 
                textSecondary: 'text-white/75', 
                textMuted: 'text-white/40', 
                footerBg: 'neu-card-pure-black', 
                priceColor: 'text-white', 
                priceGlow: '', 
                orbs: false, 
                orbColors: [] 
            },
        };


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
                emptyGuideIndex: 0,
                productImageIndex: 0,
                prevImageUrl: '',
                activeSlotIndex: 0,
                slideKey: 1,
                slots: [
                    { url: '', active: true, zoomed: false, key: 1 },
                    { url: '', active: false, zoomed: false, key: 2 }
                ],
                storyActive: false,
                sliderTimer: null,
                now: new Date(),
                refreshTimer: null,
                isFullscreen: false,
                zoomLevel: parseFloat(localStorage.getItem('display_zoom') || '1.0'),
                overscanMargin: parseFloat(localStorage.getItem('display_overscan') || '{{ ($isTv ?? false) ? "0.02" : "0.005" }}'),
                hudFeedbackText: '',
                hudFeedbackTimer: null,
                showControls: false,
                controlsTimer: null,
                ecoMode: (function() {
                    try {
                        const saved = localStorage.getItem('display_eco_mode');
                        if (saved !== null) {
                            return saved === 'true';
                        }
                        /* پیش‌فرض در صورت عدم ذخیره قبلی (برای اپ فعال باشد) - به درخواست غیرفعال شد
                        if (new URLSearchParams(window.location.search).get('app') === '1' || {{ ($isApp ?? false) ? 'true' : 'false' }}) {
                            return true;
                        }
                        */
                        return false;
                    } catch (e) {
                        return false;
                    }
                })(),

                toggleEcoMode() {
                    this.ecoMode = !this.ecoMode;
                    try {
                        localStorage.setItem('display_eco_mode', this.ecoMode ? 'true' : 'false');
                    } catch (e) {}
                },

                triggerControls() {
                    this.showControls = true;
                    if (this.controlsTimer) clearTimeout(this.controlsTimer);
                    this.controlsTimer = setTimeout(() => {
                        this.showControls = false;
                    }, 3500);
                },

                get settings() { return this.snapshotData?.settings || {}; },
                get products() { return this.snapshotData?.products || []; },
                get activeProduct() { return this.products[this.activeIndex] || null; },
                get activeProductImageUrl() {
                    if (!this.activeProduct) return '/icons/icon-512x512.png';
                    const imgs = this.activeProduct.images;
                    if (imgs && imgs.length > 0) {
                        return imgs[this.productImageIndex % imgs.length]?.url || '/icons/icon-512x512.png';
                    }
                    return '/icons/icon-512x512.png';
                },
                get orderedMetrics() {
                    const items = this.snapshotData?.displayItems || [];
                    const feed = this.snapshotData?.priceFeed || [];
                    const enabledKeys = items.filter(i => i.enabled && i.key !== 'exchange_gold').sort((a,b) => a.order - b.order).map(i => i.key);
                    return feed.filter(f => enabledKeys.includes(f.symbol)).sort((a,b) => enabledKeys.indexOf(a.symbol) - enabledKeys.indexOf(b.symbol));
                },
                isItemStale(item) {
                    if (!item) return false;
                    // اگر ارتباط با سرور قطع باشد یا در حالت پشتیبان قرار گیرد، داده‌ها قطعاً لحظه‌ای نیستند
                    if (this.connectionState !== 'online') return true;
                    // اگر اسنپ‌شات کلی تابلو کهنه شده باشد
                    if (this.snapshotData?.isStale) return true;
                    // برای خرید طلای ۱۸، اگر طلای ۱۸ عیار کهنه باشد
                    if (/خرید.*(18|۱۸)/.test(item.label || '')) {
                        const g18 = this.orderedMetrics.find(m => m.symbol === 'gold18');
                        if (g18 && g18.is_stale) return true;
                    }
                    return Boolean(item.is_stale);
                },
                                get isLightTheme() { return this.themeKey === 'light-modern' || this.themeKey === 'bing-ceramic' || this.themeKey === 'imperial-pearl'; },
                get isBingTheme() { return this.themeKey === 'bing-daily' || this.themeKey === 'bing-studio' || this.themeKey === 'bing-ceramic'; },
                get bingWallpaper() { return this.snapshotData?.bingWallpaper || { url: '/images/bing/today.jpg', title: 'عکس روز بینگ', copyright: 'Bing Daily Wallpaper' }; },
                get bingWallpaperUrl() { return this.bingWallpaper?.url || '/images/bing/today.jpg'; },
                get themeKey() { return this.settings.theme_mode && THEMES[this.settings.theme_mode] ? this.settings.theme_mode : 'light-modern'; },
                get theme() { return THEMES[this.themeKey]; },
                get activeProductProfitPercent() {
                    if (!this.activeProduct) return 0;
                    if (this.activeProduct.profit_type === 'percent') return this.activeProduct.profit_value;
                    const gold18 = this.snapshotData.priceFeed?.find(p => p.symbol === 'gold18')?.value || this.activeProduct.base_gold_price;
                    const base = (Number(gold18) * Number(this.activeProduct.weight_gram)) + Number(this.activeProduct.labor_fee || 0);
                    let profitAmount = 0;
                    if (this.activeProduct.profit_type === 'amount_per_gram') {
                        profitAmount = Number(this.activeProduct.profit_value) * Number(this.activeProduct.weight_gram);
                    } else {
                        profitAmount = Number(this.activeProduct.profit_value);
                    }
                    return base > 0 ? (profitAmount / base * 100).toFixed(1) : 0;
                },
                get activeProductFinalPrice() {
                    if (!this.activeProduct) return 0;
                    const gold18 = this.snapshotData.priceFeed?.find(p => p.symbol === 'gold18')?.value;
                    // اگر نرخ طلای ۱۸ عیار موجود نباشد، قیمت صفر بازگردانده می‌شود تا نرخ نامعتبر نمایش داده نشود
                    if (!gold18 || Number(gold18) <= 0) return 0;
                    const base = (Number(gold18) * Number(this.activeProduct.weight_gram)) + Number(this.activeProduct.labor_fee || 0);
                    let profit = 0;
                    if (this.activeProduct.profit_type === 'percent') {
                        profit = base * (Number(this.activeProduct.profit_value) / 100);
                    } else if (this.activeProduct.profit_type === 'amount_per_gram') {
                        profit = Number(this.activeProduct.profit_value) * Number(this.activeProduct.weight_gram);
                    } else {
                        profit = Number(this.activeProduct.profit_value);
                    }
                    return Math.round(base + profit);
                },
                get weekDay() { return this.now.toLocaleDateString('fa-IR', { weekday: 'long' }); },
                get dateText() { return this.now.toLocaleDateString('fa-IR', { year: 'numeric', month: 'long', day: 'numeric' }); },
                get timeText() { return this.now.toLocaleTimeString('fa-IR', { hour: '2-digit', minute: '2-digit', second: '2-digit' }); },
                get staleTimeText() {
                    const dt = this.snapshotData?.updatedAt;
                    if (!dt) return '---';
                    try {
                        const d = new Date(dt);
                        if (isNaN(d.getTime())) return dt;
                        return d.toLocaleTimeString('fa-IR', { hour: '2-digit', minute: '2-digit' });
                    } catch (e) {
                        return dt;
                    }
                },
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
                            this.transitionToNextSlide();
                        } else {
                            // چرخش خودکار اسلایدهای راهنمای ویترین در حالت بدون محصول
                            this.emptyGuideIndex = (this.emptyGuideIndex + 1) % 3;
                        }
                    }, Math.max(intervalSec, 3) * 1000);
                },

                transitionToNextSlide() {
                    this.slideKey++;
                    const nextSlot = 1 - this.activeSlotIndex;
                    this.storyActive = false;
                    this.slots[nextSlot] = {
                        url: this.activeProductImageUrl,
                        key: this.slideKey,
                        active: false,
                        zoomed: false
                    };
                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            this.slots[nextSlot].active = true;
                            this.slots[nextSlot].zoomed = true;
                            this.slots[this.activeSlotIndex].active = false;
                            this.slots[this.activeSlotIndex].zoomed = false;
                            this.activeSlotIndex = nextSlot;
                            this.storyActive = true;
                        });
                    });
                },

                goToSlide(index) {
                    if (this.products.length <= 1) return;
                    this.activeIndex = index % this.products.length;
                    this.productImageIndex = 0;
                    this.transitionToNextSlide();
                    this.startSlider();
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

                        // W-05: در پایان هر واکشی موفق اسنپ‌شات
                        if (window.TalaTV && window.TalaTV.onPriceTick) {
                            window.TalaTV.onPriceTick(String(newData.updatedAt || ''), newData.isStale ? 1 : 0);
                        }
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

                applyStageScale() {
                    const canvas = document.getElementById('tv-stage-canvas');
                    if (!canvas) return;
                    const vw = (window.innerWidth && window.innerWidth > 0) ? window.innerWidth : (document.documentElement.clientWidth || 1920);
                    const vh = (window.innerHeight && window.innerHeight > 0) ? window.innerHeight : (document.documentElement.clientHeight || 1080);
                    
                    // کسر حاشیه امن سخت‌افزاری تلویزیون جهت جلوگیری از اووراسکن لبه‌ها
                    const rawOverscan = Number(this.overscanMargin);
                    const overscan = Math.max(0, Math.min(0.08, (!isNaN(rawOverscan) ? rawOverscan : 0)));
                    const availW = Math.max(320, vw * (1 - overscan * 2));
                    const availH = Math.max(240, vh * (1 - overscan * 2));
                    
                    const scaleX = availW / 1920;
                    const scaleY = availH / 1080;
                    const baseScale = Math.min(scaleX, scaleY);
                    const rawZoom = Number(this.zoomLevel);
                    const validZoom = (!isNaN(rawZoom) && rawZoom > 0.1) ? rawZoom : 1.0;
                    const finalScale = (!isNaN(baseScale) && baseScale > 0.05) ? Math.max(0.2, baseScale * validZoom) : 1.0;
                    const scaledW = 1920 * finalScale;
                    const scaledH = 1080 * finalScale;
                    const offsetX = Math.round((vw - scaledW) / 2);
                    const offsetY = Math.round((vh - scaledH) / 2);

                    canvas.style.transformOrigin = '0 0';
                    canvas.style.webkitTransformOrigin = '0 0';
                    canvas.style.left = `${offsetX}px`;
                    canvas.style.top = `${offsetY}px`;
                    canvas.style.transform = `scale(${finalScale})`;
                    canvas.style.webkitTransform = `scale(${finalScale})`;
                },

                showHudFeedback(msg) {
                    this.hudFeedbackText = msg;
                    if (this.hudFeedbackTimer) clearTimeout(this.hudFeedbackTimer);
                    this.hudFeedbackTimer = setTimeout(() => { this.hudFeedbackText = ''; }, 2500);
                },

                zoomIn() {
                    if (this.zoomLevel < 1.35) {
                        this.zoomLevel = Math.round((this.zoomLevel + 0.03) * 100) / 100;
                        try { localStorage.setItem('display_zoom', this.zoomLevel.toString()); } catch (e) {}
                        this.applyStageScale();
                        this.showHudFeedback(`بزرگ‌نمایی: ${Math.round(this.zoomLevel * 100)}%`);
                    }
                },

                zoomOut() {
                    if (this.zoomLevel > 0.70) {
                        this.zoomLevel = Math.round((this.zoomLevel - 0.03) * 100) / 100;
                        try { localStorage.setItem('display_zoom', this.zoomLevel.toString()); } catch (e) {}
                        this.applyStageScale();
                        this.showHudFeedback(`کوچک‌نمایی: ${Math.round(this.zoomLevel * 100)}%`);
                    }
                },

                resetScale() {
                    this.zoomLevel = 1.0;
                    this.overscanMargin = 0.01;
                    try {
                        localStorage.setItem('display_zoom', '1.0');
                        localStorage.setItem('display_overscan', '0.01');
                    } catch (e) {}
                    this.applyStageScale();
                    this.showHudFeedback('تنظیمات مقیاس بازنشانی شد');
                },

                disconnectBoard() {
                    if (confirm('آیا می‌خواهید اتصال این دستگاه به تابلوی طلا قطع شود و به صفحه جفت‌سازی برگردید؟')) {
                        try {
                            localStorage.removeItem('display_username');
                            localStorage.removeItem('display_token');
                            document.cookie = 'display_token=; path=/; max-age=0;';
                            sessionStorage.removeItem('skip_redirect');
                        } catch (e) {}
                        window.location.href = '/tv?reset=1';
                    }
                },

                handleKeydown(e) {
                    this.triggerControls();
                    if (['input', 'textarea', 'select'].includes(e.target.tagName?.toLowerCase())) return;

                    switch (e.key) {
                        case 'ArrowUp':
                        case '+':
                        case '=':
                            e.preventDefault();
                            this.zoomIn();
                            break;
                        case 'ArrowDown':
                        case '-':
                        case '_':
                            e.preventDefault();
                            this.zoomOut();
                            break;
                        case 'f':
                        case 'F':
                            e.preventDefault();
                            this.toggleFullscreen();
                            break;
                        case 'm':
                        case 'M':
                        case 'Enter':
                            e.preventDefault();
                            this.showControls = !this.showControls;
                            break;
                        case 'e':
                        case 'E':
                            e.preventDefault();
                            this.toggleEcoMode();
                            this.showHudFeedback(this.ecoMode ? 'حالت سبک: فعال' : 'حالت سبک: غیرفعال');
                            break;
                        case '0':
                            e.preventDefault();
                            this.resetScale();
                            break;
                    }
                },

                init() {
                    // ذخیره پایدار توکن و نام کاربری در حافظه محلی و کوکی تلویزیون جهت اتصال همیشگی
                    try {
                        const urlParams = new URLSearchParams(window.location.search);
                        const currentKey = urlParams.get('key');
                        if (currentKey) {
                            localStorage.setItem('display_username', '{{ $username }}');
                            localStorage.setItem('display_token', currentKey);
                            document.cookie = `display_token=${encodeURIComponent(currentKey)}; path=/; max-age=31536000`;
                        }
                    } catch (e) {
                        console.warn('LocalStorage persistence error:', e);
                    }

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

                    // HUD هوشمند با Auto-Hide پس از ۳.۵ ثانیه عدم فعالیت
                    this.triggerControls();
                    window.addEventListener('mousemove', () => this.triggerControls(), { passive: true });
                    window.addEventListener('touchstart', () => this.triggerControls(), { passive: true });
                    window.addEventListener('keydown', () => this.triggerControls(), { passive: true });

                    const multiPassScale = () => {
                        this.applyStageScale();
                        setTimeout(() => this.applyStageScale(), 60);
                        setTimeout(() => this.applyStageScale(), 200);
                        setTimeout(() => this.applyStageScale(), 500);
                    };

                    ['fullscreenchange', 'webkitfullscreenchange', 'mozfullscreenchange', 'MSFullscreenChange'].forEach(evt => {
                        document.addEventListener(evt, () => {
                            this.isFullscreen = !!(document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement);
                            multiPassScale();
                        });
                    });
                    
                    // فعال‌سازی موتور مقیاس‌پذیری خودکار بوم برای انواع تلویزیون
                    this.applyStageScale();
                    window.addEventListener('resize', () => multiPassScale(), { passive: true });
                    window.addEventListener('orientationchange', () => {
                        setTimeout(() => multiPassScale(), 200);
                    });
                    this.$watch('zoomLevel', () => this.applyStageScale());
                    this.$watch('overscanMargin', () => this.applyStageScale());

                    // Sync theme class
                    this.$watch('themeKey', () => document.documentElement.className = (this.isLightTheme ? 'light' : 'dark'));
                    document.documentElement.className = (this.isLightTheme ? 'light' : 'dark');

                    // شروع هوشمند اسلایدر با قابلیت تنظیم داینامیک
                    this.slots[0].url = this.activeProductImageUrl;
                    this.slots[0].key = 1;
                    this.slots[0].active = true;
                    requestAnimationFrame(() => {
                        this.slots[0].zoomed = true;
                        this.storyActive = true;
                    });
                    this.startSlider();
                    this.$watch('settings.slider_interval_sec', () => this.startSlider());

                    // ساعت
                    setInterval(() => { this.now = new Date(); }, 1000);

                    this.scheduleSnapshotRefresh();

                    // W-05: بلافاصله بعد از اولین رندر موفق قیمت‌ها
                    if (window.TalaTV && window.TalaTV.onBoardReady) {
                        window.TalaTV.onBoardReady();
                    }
                    console.log('%c TalaLive Engine %c v5-perf-unified-stage ', 'background:#d97706;color:#fff;font-weight:bold;border-radius:3px;', 'background:#1e293b;color:#38bdf8;font-weight:bold;border-radius:3px;');
                }
            };
        }

        @if($isTv ?? false)
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistrations()
                .then(function (rs) { rs.forEach(function (r) { r.unregister(); }); })
                .catch(function (e) { console.warn('sw unregister failed', e); });
        }
        if (window.caches && caches.keys) {
            caches.keys().then(function (keys) {
                keys.forEach(function (k) { caches.delete(k); });
            }).catch(function (e) { console.warn('cache clear failed', e); });
        }
        @else
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(error => {
                    console.error('Service worker registration failed:', error);
                });
            });
        }
        @endif
    </script>

    {{-- اعلان تبریک و پیشنهاد ذخیره/نشانه‌گذاری پس از جفت‌سازی تلویزیون --}}
    <div id="tv-paired-toast"
         style="display: none;"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[9999] max-w-xl w-[90%] bg-slate-900/95 border-2 border-amber-400/80 rounded-2xl p-4 sm:p-5 shadow-2xl text-white backdrop-blur-2xl text-center select-none"
         dir="rtl">
        <div class="flex items-center justify-center gap-3 mb-2">
            <span class="text-3xl">📺</span>
            <span class="text-lg font-black text-amber-400">اتصال تلویزیون با موفقیت انجام شد!</span>
            <span class="text-2xl">✨</span>
        </div>
        <p class="text-xs sm:text-sm text-slate-200 leading-relaxed mb-3">
            برای اجرای تمام‌صفحه و دسترسی همیشگی بدون تایپ مجدد آدرس، این صفحه را به <strong>علاقه‌مندی‌ها (Bookmark)</strong> یا <strong>صفحه اصلی (Add to Home)</strong> تلویزیون اضافه کنید.
        </p>
        <div class="flex items-center justify-center gap-3">
            <button onclick="dismissTvPairedToast()" type="button" class="px-5 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 rounded-xl font-black text-xs shadow-lg cursor-pointer">
                متوجه شدم (بستن)
            </button>
            <span class="text-[11px] text-slate-400 font-mono">
                بستن خودکار در <span id="tv-toast-countdown" class="text-amber-400 font-bold">۸</span> ثانیه
            </span>
        </div>
    </div>

    <script>
        (function() {
            const urlParams = new URLSearchParams(window.location.search);
            const isJustPaired = urlParams.get('paired') === '1' || 
                                 sessionStorage.getItem('tv_just_paired') === '1' ||
                                 !localStorage.getItem('tv_pwa_welcome_shown');
            
            if (isJustPaired) {
                sessionStorage.removeItem('tv_just_paired');
                localStorage.setItem('tv_pwa_welcome_shown', '1');
                // پاک کردن پارامتر paired از آدرس بدون رفرش
                try {
                    urlParams.delete('paired');
                    const cleanUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
                    window.history.replaceState({}, document.title, cleanUrl);
                } catch(e) {}

                const toast = document.getElementById('tv-paired-toast');
                if (toast) {
                    toast.style.display = 'block';
                    let timeLeft = 8;
                    const countdownEl = document.getElementById('tv-toast-countdown');
                    const timer = setInterval(() => {
                        timeLeft--;
                        if (countdownEl) countdownEl.textContent = timeLeft;
                        if (timeLeft <= 0) {
                            clearInterval(timer);
                            dismissTvPairedToast();
                        }
                    }, 1000);

                    window.dismissTvPairedToast = function() {
                        clearInterval(timer);
                        if (toast) {
                            toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                            toast.style.opacity = '0';
                            toast.style.transform = 'translate(-50%, 20px)';
                            setTimeout(() => { toast.remove(); }, 500);
                        }
                    };

                    // بستن با کلیدهای ریموت کنترل (Enter / OK / Back / Esc)
                    window.addEventListener('keydown', function handleToastKey(e) {
                        if (['Enter', 'Escape', 'GoBack', 'Back'].includes(e.key) || e.keyCode === 13 || e.keyCode === 27 || e.keyCode === 10009 || e.keyCode === 8) {
                            window.dismissTvPairedToast();
                            window.removeEventListener('keydown', handleToastKey);
                        }
                    });
                }
            }
        })();
    </script>
</body>
</html>
