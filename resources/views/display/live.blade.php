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
        @keyframes float-slow-1 {
            0% { transform: translate3d(0px, 0px, 0) scale(1); }
            25% { transform: translate3d(180px, -90px, 0) scale(1.20); }
            50% { transform: translate3d(90px, 170px, 0) scale(0.86); }
            75% { transform: translate3d(-150px, 80px, 0) scale(1.15); }
            100% { transform: translate3d(0px, 0px, 0) scale(1); }
        }
        @keyframes float-slow-2 {
            0% { transform: translate3d(0px, 0px, 0) scale(1); }
            25% { transform: translate3d(-170px, 110px, 0) scale(1.18); }
            50% { transform: translate3d(-90px, -150px, 0) scale(0.85); }
            75% { transform: translate3d(150px, -70px, 0) scale(1.14); }
            100% { transform: translate3d(0px, 0px, 0) scale(1); }
        }
        @keyframes float-slow-3 {
            0% { transform: translate3d(0px, 0px, 0) scale(1); }
            30% { transform: translate3d(-200px, 140px, 0) scale(1.24); }
            65% { transform: translate3d(160px, -120px, 0) scale(0.82); }
            100% { transform: translate3d(0px, 0px, 0) scale(1); }
        }
        @keyframes float-slow-4 {
            0% { transform: translate3d(0px, 0px, 0) scale(1); }
            30% { transform: translate3d(170px, -160px, 0) scale(1.18); }
            70% { transform: translate3d(-130px, -90px, 0) scale(0.88); }
            100% { transform: translate3d(0px, 0px, 0) scale(1); }
        }
        @keyframes float-slow-5 {
            0% { transform: translate3d(0px, 0px, 0) scale(1); }
            35% { transform: translate3d(-180px, 160px, 0) scale(1.22); }
            70% { transform: translate3d(140px, -110px, 0) scale(0.86); }
            100% { transform: translate3d(0px, 0px, 0) scale(1); }
        }
        .animate-float-slow-1 { animation: float-slow-1 8s ease-in-out infinite; will-change: transform; }
        .animate-float-slow-2 { animation: float-slow-2 10s ease-in-out infinite; will-change: transform; }
        .animate-float-slow-3 { animation: float-slow-3 7s ease-in-out infinite; will-change: transform; }
        .animate-float-slow-4 { animation: float-slow-4 9s ease-in-out infinite; will-change: transform; }
        .animate-float-slow-5 { animation: float-slow-5 8.5s ease-in-out infinite; will-change: transform; }
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
        .glow-amber-imperial { text-shadow: 0 0 12px rgba(251, 191, 36, 0.60), 0 0 26px rgba(217, 119, 6, 0.40), 0 2px 4px rgba(0, 0, 0, 0.9); }
        .glow-cyan { text-shadow: 0 0 10px rgba(6, 182, 212, 0.45), 0 0 20px rgba(6, 182, 212, 0.2); }
        .glow-purple { text-shadow: 0 0 10px rgba(217, 70, 239, 0.45), 0 0 20px rgba(217, 70, 239, 0.2); }
        .glow-emerald { text-shadow: 0 0 10px rgba(16, 185, 129, 0.45), 0 0 20px rgba(16, 185, 129, 0.2); }
        .glow-rose { text-shadow: 0 0 10px rgba(244, 63, 94, 0.45), 0 0 20px rgba(244, 63, 94, 0.2); }

        /* Ambient QR Laser Sweep */
        @keyframes laser-sweep {
            0% { transform: translateY(-100%); opacity: 0; }
            15% { opacity: 0.85; }
            85% { opacity: 0.85; }
            100% { transform: translateY(220%); opacity: 0; }
        }
        .animate-laser-sweep {
            animation: laser-sweep 3.5s ease-in-out infinite;
        }

        /* Neumorphic + Apple HIG Soft Physics Engine (8 Luxury Themes) */
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
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            box-shadow: inset 0 1px 1.5px 0 rgba(255, 255, 255, 0.95), inset 0 -1px 0 0 rgba(255, 255, 255, 0.4), -5px -5px 14px rgba(255, 255, 255, 0.9), 5px 8px 20px rgba(148, 163, 184, 0.22) !important;
            border: 1px solid rgba(255, 255, 255, 0.88) !important;
            transform: translateZ(0);
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
            backdrop-filter: blur(28px) saturate(190%) !important;
            -webkit-backdrop-filter: blur(28px) saturate(190%) !important;
            border: 1px solid rgba(251, 191, 36, 0.38) !important;
            box-shadow: 
                inset 0 1.5px 1px 0 rgba(255, 255, 255, 0.22),
                inset 0 -1px 0 0 rgba(251, 191, 36, 0.18),
                0 16px 40px -8px rgba(0, 0, 0, 0.88),
                0 0 20px -2px rgba(245, 158, 11, 0.10) !important;
            transform: scale(1) translateZ(0);
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
            background: linear-gradient(135deg, rgba(146, 64, 14, 0.80) 0%, rgba(69, 26, 3, 0.90) 50%, rgba(26, 10, 1, 0.96) 100%) !important;
            backdrop-filter: blur(28px) saturate(220%) !important;
            -webkit-backdrop-filter: blur(28px) saturate(220%) !important;
            border: 1.5px solid rgba(251, 191, 36, 0.88) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 0.50),
                inset 0 -1px 0 0 rgba(251, 191, 36, 0.35),
                0 18px 48px -6px rgba(217, 119, 6, 0.65),
                0 0 40px rgba(251, 191, 36, 0.40) !important;
            transform: scale(1) translateZ(0);
            transition: transform 0.38s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.38s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-gold-imperial:hover {
            transform: scale(1.028) translateY(-4px) translateZ(0) !important;
            box-shadow: 
                inset 0 2.5px 2px 0 rgba(255, 255, 255, 0.65),
                0 28px 62px -6px rgba(217, 119, 6, 0.80),
                0 0 50px rgba(251, 191, 36, 0.55) !important;
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
            backdrop-filter: blur(28px) saturate(160%) !important;
            -webkit-backdrop-filter: blur(28px) saturate(160%) !important;
            border: 1.5px solid rgba(217, 119, 6, 0.35) !important;
            box-shadow: 
                inset 0 1.5px 1.5px 0 rgba(255, 255, 255, 1),
                inset 0 -1px 0 0 rgba(217, 119, 6, 0.15),
                -6px -6px 18px rgba(255, 255, 255, 0.95),
                8px 16px 32px rgba(148, 163, 184, 0.22),
                0 0 16px rgba(245, 158, 11, 0.08) !important;
            transform: scale(1) translateZ(0);
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
            background: linear-gradient(135deg, rgba(254, 243, 199, 0.94) 0%, rgba(253, 230, 138, 0.88) 50%, rgba(245, 158, 11, 0.22) 100%) !important;
            backdrop-filter: blur(28px) saturate(200%) !important;
            -webkit-backdrop-filter: blur(28px) saturate(200%) !important;
            border: 1.5px solid rgba(217, 119, 6, 0.75) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 1),
                inset 0 -1px 0 0 rgba(217, 119, 6, 0.35),
                -6px -6px 18px rgba(255, 255, 255, 0.95),
                10px 20px 40px rgba(217, 119, 6, 0.25),
                0 0 30px rgba(251, 191, 36, 0.30) !important;
            transform: scale(1) translateZ(0);
            transition: transform 0.38s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.38s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-gold-pearl:hover {
            transform: scale(1.028) translateY(-4px) translateZ(0) !important;
            box-shadow: 
                inset 0 2.5px 2px 0 rgba(255, 255, 255, 1),
                -8px -8px 24px rgba(255, 255, 255, 1),
                14px 28px 50px rgba(217, 119, 6, 0.35),
                0 0 45px rgba(251, 191, 36, 0.45) !important;
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

        /* 1. Apple Vision Pro / Dark Obsidian Glass (پیشنهاد اول - شیشه دودی ابسیدین با لبه طلایی ۲۴ عیار و اسکیل) */
        .neu-card-bing-obsidian {
            background: linear-gradient(145deg, rgba(15, 23, 42, 0.70) 0%, rgba(2, 6, 23, 0.86) 100%) !important;
            backdrop-filter: blur(28px) saturate(170%) !important;
            -webkit-backdrop-filter: blur(28px) saturate(170%) !important;
            border: 1px solid rgba(251, 191, 36, 0.30) !important;
            box-shadow: 
                inset 0 1.5px 1px 0 rgba(255, 255, 255, 0.18),
                inset 0 -1px 0 0 rgba(251, 191, 36, 0.15),
                0 14px 36px -4px rgba(0, 0, 0, 0.75),
                0 4px 14px 0 rgba(0, 0, 0, 0.35) !important;
            transform: scale(1) translateZ(0);
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
            background: linear-gradient(145deg, rgba(69, 26, 3, 0.75) 0%, rgba(20, 8, 0, 0.92) 100%) !important;
            backdrop-filter: blur(28px) saturate(200%) !important;
            -webkit-backdrop-filter: blur(28px) saturate(200%) !important;
            border: 1.5px solid rgba(251, 191, 36, 0.65) !important;
            box-shadow: 
                inset 0 2px 1.5px 0 rgba(255, 255, 255, 0.32),
                inset 0 -1px 0 0 rgba(251, 191, 36, 0.25),
                0 16px 42px -4px rgba(217, 119, 6, 0.50),
                0 4px 16px 0 rgba(0, 0, 0, 0.4) !important;
            transform: scale(1) translateZ(0);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-gold-obsidian:hover {
            transform: scale(1.028) translateY(-4px) translateZ(0) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 0.45),
                0 26px 56px -6px rgba(217, 119, 6, 0.65),
                0 0 30px rgba(251, 191, 36, 0.35) !important;
            border-color: rgba(251, 191, 36, 0.95) !important;
        }

        /* 2. Apple Studio Unified Canvas (پیشنهاد دوم - استیج شیشه‌ای مات و یکدست) */
        .neu-card-bing-studio {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.65) 0%, rgba(15, 23, 42, 0.82) 100%) !important;
            backdrop-filter: blur(22px) !important;
            -webkit-backdrop-filter: blur(22px) !important;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
            box-shadow: 
                inset 0 1px 1px 0 rgba(255, 255, 255, 0.16),
                0 10px 28px -4px rgba(0, 0, 0, 0.55) !important;
            transform: scale(1) translateZ(0);
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
            background: linear-gradient(145deg, rgba(69, 26, 3, 0.70) 0%, rgba(20, 8, 0, 0.88) 100%) !important;
            backdrop-filter: blur(22px) !important;
            -webkit-backdrop-filter: blur(22px) !important;
            border: 1.5px solid rgba(251, 191, 36, 0.60) !important;
            box-shadow: inset 0 1.5px 1px 0 rgba(255, 255, 255, 0.28), 0 14px 34px -4px rgba(217, 119, 6, 0.45) !important;
            transform: scale(1) translateZ(0);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-gold-studio:hover {
            transform: scale(1.028) translateY(-4px) translateZ(0) !important;
            border-color: rgba(251, 191, 36, 0.90) !important;
        }

        /* 3. Apple Ceramic Porcelain (پیشنهاد سوم - سرامیک پرسلین سفید با وقار و کنتراست شفاف) */
        .neu-card-bing-ceramic {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.90) 0%, rgba(248, 250, 252, 0.84) 100%) !important;
            backdrop-filter: blur(28px) !important;
            -webkit-backdrop-filter: blur(28px) !important;
            border: 1px solid rgba(255, 255, 255, 0.95) !important;
            box-shadow: 
                inset 0 1.5px 1.5px 0 rgba(255, 255, 255, 1),
                inset 0 -1px 0 0 rgba(255, 255, 255, 0.4),
                -4px -4px 14px rgba(255, 255, 255, 0.85),
                0 14px 34px -4px rgba(15, 23, 42, 0.18),
                0 4px 10px 0 rgba(0, 0, 0, 0.06) !important;
            transform: scale(1) translateZ(0);
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
            background: linear-gradient(145deg, rgba(254, 243, 199, 0.92) 0%, rgba(255, 251, 235, 0.88) 100%) !important;
            backdrop-filter: blur(28px) !important;
            -webkit-backdrop-filter: blur(28px) !important;
            border: 1.5px solid rgba(251, 191, 36, 0.70) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 1),
                0 14px 36px -4px rgba(217, 119, 6, 0.28),
                0 4px 12px 0 rgba(0, 0, 0, 0.06) !important;
            transform: scale(1) translateZ(0);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s ease !important;
        }
        .neu-hero-gold-ceramic:hover {
            transform: scale(1.028) translateY(-4px) translateZ(0) !important;
            box-shadow: 
                inset 0 2px 2px 0 rgba(255, 255, 255, 1),
                0 24px 50px -6px rgba(217, 119, 6, 0.40),
                0 6px 16px 0 rgba(0, 0, 0, 0.10) !important;
            border-color: rgba(251, 191, 36, 0.95) !important;
        }

        .neu-card-dark-glass {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.48), rgba(15, 23, 42, 0.65)) !important;
            backdrop-filter: blur(28px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(28px) saturate(180%) !important;
            box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.16), -4px -4px 14px rgba(255, 255, 255, 0.04), 8px 12px 28px rgba(0, 0, 0, 0.65) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
        }
        .neu-card-dark-glass:hover {
            transform: translateY(-2px) scale(1.008);
            box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.22), -5px -5px 18px rgba(255, 255, 255, 0.07), 10px 16px 34px rgba(0, 0, 0, 0.75) !important;
            border-color: rgba(99, 102, 241, 0.4) !important;
        }

        .neu-card-gold-royal {
            background: linear-gradient(145deg, rgba(69, 26, 3, 0.55), rgba(20, 8, 0, 0.8)) !important;
            backdrop-filter: blur(28px) !important;
            -webkit-backdrop-filter: blur(28px) !important;
            box-shadow: inset 0 1px 0 0 rgba(251, 191, 36, 0.22), -4px -4px 14px rgba(245, 158, 11, 0.08), 8px 12px 28px rgba(0, 0, 0, 0.75) !important;
            border: 1px solid rgba(245, 158, 11, 0.22) !important;
        }
        .neu-card-gold-royal:hover {
            transform: translateY(-2px) scale(1.008);
            box-shadow: inset 0 1px 0 0 rgba(251, 191, 36, 0.3), -6px -6px 20px rgba(245, 158, 11, 0.14), 10px 16px 34px rgba(0, 0, 0, 0.85) !important;
            border-color: rgba(245, 158, 11, 0.45) !important;
        }

        .neu-card-blue-ocean {
            background: linear-gradient(145deg, rgba(10, 25, 47, 0.55), rgba(2, 12, 27, 0.82)) !important;
            backdrop-filter: blur(28px) !important;
            -webkit-backdrop-filter: blur(28px) !important;
            box-shadow: inset 0 1px 0 0 rgba(34, 211, 238, 0.18), -4px -4px 14px rgba(6, 182, 212, 0.08), 8px 12px 28px rgba(0, 0, 0, 0.75) !important;
            border: 1px solid rgba(6, 182, 212, 0.2) !important;
        }
        .neu-card-blue-ocean:hover {
            transform: translateY(-2px) scale(1.008);
            box-shadow: inset 0 1px 0 0 rgba(34, 211, 238, 0.26), -6px -6px 20px rgba(6, 182, 212, 0.14), 10px 16px 34px rgba(0, 0, 0, 0.85) !important;
            border-color: rgba(6, 182, 212, 0.45) !important;
        }

        .neu-card-purple-haze {
            background: linear-gradient(145deg, rgba(30, 11, 54, 0.55), rgba(15, 5, 29, 0.82)) !important;
            backdrop-filter: blur(28px) !important;
            -webkit-backdrop-filter: blur(28px) !important;
            box-shadow: inset 0 1px 0 0 rgba(232, 121, 249, 0.18), -4px -4px 14px rgba(217, 70, 239, 0.08), 8px 12px 28px rgba(0, 0, 0, 0.75) !important;
            border: 1px solid rgba(217, 70, 239, 0.2) !important;
        }
        .neu-card-purple-haze:hover {
            transform: translateY(-2px) scale(1.008);
            box-shadow: inset 0 1px 0 0 rgba(232, 121, 249, 0.26), -6px -6px 20px rgba(217, 70, 239, 0.14), 10px 16px 34px rgba(0, 0, 0, 0.85) !important;
            border-color: rgba(217, 70, 239, 0.45) !important;
        }

        .neu-card-emerald-night {
            background: linear-gradient(145deg, rgba(2, 44, 34, 0.55), rgba(1, 28, 21, 0.82)) !important;
            backdrop-filter: blur(28px) !important;
            -webkit-backdrop-filter: blur(28px) !important;
            box-shadow: inset 0 1px 0 0 rgba(52, 211, 153, 0.18), -4px -4px 14px rgba(16, 185, 129, 0.08), 8px 12px 28px rgba(0, 0, 0, 0.75) !important;
            border: 1px solid rgba(16, 185, 129, 0.2) !important;
        }
        .neu-card-emerald-night:hover {
            transform: translateY(-2px) scale(1.008);
            box-shadow: inset 0 1px 0 0 rgba(52, 211, 153, 0.26), -6px -6px 20px rgba(16, 185, 129, 0.14), 10px 16px 34px rgba(0, 0, 0, 0.85) !important;
            border-color: rgba(16, 185, 129, 0.45) !important;
        }

        .neu-card-rose-dark {
            background: linear-gradient(145deg, rgba(63, 2, 18, 0.55), rgba(28, 0, 7, 0.82)) !important;
            backdrop-filter: blur(28px) !important;
            -webkit-backdrop-filter: blur(28px) !important;
            box-shadow: inset 0 1px 0 0 rgba(251, 113, 133, 0.18), -4px -4px 14px rgba(244, 63, 94, 0.08), 8px 12px 28px rgba(0, 0, 0, 0.75) !important;
            border: 1px solid rgba(244, 63, 94, 0.2) !important;
        }
        .neu-card-rose-dark:hover {
            transform: translateY(-2px) scale(1.008);
            box-shadow: inset 0 1px 0 0 rgba(251, 113, 133, 0.26), -6px -6px 20px rgba(244, 63, 94, 0.14), 10px 16px 34px rgba(0, 0, 0, 0.85) !important;
            border-color: rgba(244, 63, 94, 0.45) !important;
        }

        .neu-card-pure-black {
            background: linear-gradient(145deg, rgba(24, 24, 27, 0.75), rgba(9, 9, 11, 0.92)) !important;
            backdrop-filter: blur(28px) !important;
            -webkit-backdrop-filter: blur(28px) !important;
            box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.1), -3px -3px 10px rgba(255, 255, 255, 0.03), 6px 8px 24px rgba(0, 0, 0, 0.95) !important;
            border: 1px solid rgba(255, 255, 255, 0.11) !important;
        }
        .neu-card-pure-black:hover {
            transform: translateY(-2px) scale(1.008);
            box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.18), -4px -4px 14px rgba(255, 255, 255, 0.06), 8px 12px 28px rgba(0, 0, 0, 1) !important;
            border-color: rgba(255, 255, 255, 0.25) !important;
        }

        /* Frosted Glass Champagne Showcase */
        .champagne-showcase {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.22) 0%, rgba(217, 119, 6, 0.15) 50%, rgba(180, 83, 9, 0.25) 100%);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(251, 191, 36, 0.38);
            box-shadow: 0 16px 40px -10px rgba(217, 119, 6, 0.32), inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        /* =========================================================================
           APPLE PREMIUM COLORFUL AMBIENT FLOATING ORBS ENGINE (گوی‌های فوق‌العاده رنگی و پرمیوم اپل)
           ========================================================================= */
        .ambient-orb-container {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 1;
        }

        .ambient-orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            will-change: transform;
            opacity: 0.92;
        }

        /* ۱. گوی فیروزه‌ای و یاقوت کبود اپل (Apple Electric Cyan & Sapphire Blue) - بالا چپ */
        .orb-1 {
            top: -10%;
            left: 4%;
            width: 48vw;
            height: 48vw;
            min-width: 460px;
            min-height: 460px;
            max-width: 760px;
            max-height: 760px;
            background: radial-gradient(circle at 45% 45%, #06b6d4 0%, #2563eb 38%, rgba(30, 58, 138, 0.35) 65%, transparent 78%) !important;
            filter: blur(48px) !important;
            -webkit-filter: blur(48px) !important;
            mix-blend-mode: screen;
            animation: float-slow-1 8s ease-in-out infinite;
        }

        /* ۲. گوی ارکیده نئونی و سرخابی غروب اپل (Apple Neon Magenta & Sunset Orchid) - پایین راست */
        .orb-2 {
            bottom: -10%;
            right: 4%;
            width: 46vw;
            height: 46vw;
            min-width: 440px;
            min-height: 440px;
            max-width: 720px;
            max-height: 720px;
            background: radial-gradient(circle at 50% 50%, #f43f5e 0%, #d946ef 38%, rgba(126, 34, 206, 0.35) 65%, transparent 78%) !important;
            filter: blur(48px) !important;
            -webkit-filter: blur(48px) !important;
            mix-blend-mode: screen;
            animation: float-slow-2 10s ease-in-out infinite;
        }

        /* ۳. گوی طلای درخشان ۲۴ عیار و خورشیدی اپل (Apple 24K Liquid Gold & Amber) - مرکز */
        .orb-3 {
            top: 25%;
            left: 36%;
            width: 40vw;
            height: 40vw;
            min-width: 400px;
            min-height: 400px;
            max-width: 640px;
            max-height: 640px;
            background: radial-gradient(circle at 45% 45%, #fef08a 0%, #f59e0b 35%, rgba(180, 83, 9, 0.40) 65%, transparent 78%) !important;
            filter: blur(42px) !important;
            -webkit-filter: blur(42px) !important;
            mix-blend-mode: screen;
            animation: float-slow-3 7s ease-in-out infinite;
        }

        /* ۴. گوی شفق زمردین و فیروزه‌ای نعنایی اپل (Apple Aurora Emerald & Mint) - پایین چپ */
        .orb-4 {
            bottom: 5%;
            left: 12%;
            width: 38vw;
            height: 38vw;
            min-width: 380px;
            min-height: 380px;
            max-width: 600px;
            max-height: 600px;
            background: radial-gradient(circle at 50% 50%, #34d399 0%, #10b981 38%, rgba(6, 78, 59, 0.35) 65%, transparent 78%) !important;
            filter: blur(46px) !important;
            -webkit-filter: blur(46px) !important;
            mix-blend-mode: screen;
            animation: float-slow-4 9s ease-in-out infinite;
        }

        /* ۵. گوی بنفش کیهانی و نیلگون اپل (Apple Cosmic Violet & Royal Indigo) - بالا راست */
        .orb-5 {
            top: 8%;
            right: 14%;
            width: 42vw;
            height: 42vw;
            min-width: 410px;
            min-height: 410px;
            max-width: 660px;
            max-height: 660px;
            background: radial-gradient(circle at 45% 45%, #c084fc 0%, #6366f1 38%, rgba(49, 46, 129, 0.35) 65%, transparent 78%) !important;
            filter: blur(50px) !important;
            -webkit-filter: blur(50px) !important;
            mix-blend-mode: screen;
            animation: float-slow-5 8.5s ease-in-out infinite;
        }

        /* پالت تم روشن شاهنشاهی و روشن مدرن (Light Mode Apple Palette) */
        .theme-imperial-pearl .orb-1,
        .theme-light-modern .orb-1 {
            mix-blend-mode: multiply !important;
            opacity: 0.65 !important;
            background: radial-gradient(circle at 45% 45%, rgba(56, 189, 248, 0.70) 0%, rgba(96, 165, 250, 0.40) 45%, transparent 70%) !important;
        }
        .theme-imperial-pearl .orb-2,
        .theme-light-modern .orb-2 {
            mix-blend-mode: multiply !important;
            opacity: 0.65 !important;
            background: radial-gradient(circle at 50% 50%, rgba(244, 114, 182, 0.65) 0%, rgba(192, 132, 252, 0.35) 45%, transparent 70%) !important;
        }
        .theme-imperial-pearl .orb-3,
        .theme-light-modern .orb-3 {
            mix-blend-mode: multiply !important;
            opacity: 0.70 !important;
            background: radial-gradient(circle at 45% 45%, rgba(251, 191, 36, 0.75) 0%, rgba(245, 158, 11, 0.40) 45%, transparent 70%) !important;
        }
        .theme-imperial-pearl .orb-4,
        .theme-light-modern .orb-4 {
            mix-blend-mode: multiply !important;
            opacity: 0.65 !important;
            background: radial-gradient(circle at 50% 50%, rgba(52, 211, 153, 0.60) 0%, rgba(45, 212, 191, 0.30) 45%, transparent 70%) !important;
        }
        .theme-imperial-pearl .orb-5,
        .theme-light-modern .orb-5 {
            mix-blend-mode: multiply !important;
            opacity: 0.65 !important;
            background: radial-gradient(circle at 45% 45%, rgba(167, 139, 250, 0.60) 0%, rgba(129, 140, 248, 0.30) 45%, transparent 70%) !important;
        }
    </style>
</head>
<body :class="isLightTheme ? 'bg-slate-50 text-slate-900' : 'bg-black text-white'" x-data="displayApp(@js($snapshot))" @dblclick="toggleFullscreen">
    <main x-show="!isLoading" :class="theme.bg" class="relative min-h-[100dvh] w-full overflow-hidden transition-colors duration-1000">

        {{-- Bing Daily Wallpaper Canvas (عکس روز بینگ با فیلترهای کنتراست داینامیک سینمایی) --}}
        <div x-show="isBingTheme" class="pointer-events-none absolute inset-0 z-0 overflow-hidden select-none">
            <img :src="bingWallpaperUrl" 
                 alt="Bing Wallpaper" 
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
        <template x-if="themeKey === 'imperial-onyx' || themeKey === 'imperial-pearl'">
            <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden select-none opacity-60">
                <svg class="w-full h-full object-cover" viewBox="0 0 1440 900" fill="none" preserveAspectRatio="none">
                    <path d="M-100 200 C350 100, 700 450, 1100 240 C1380 90, 1520 340, 1600 300" :stroke="themeKey === 'imperial-onyx' ? 'rgba(251,191,36,0.24)' : 'rgba(217,119,6,0.20)'" stroke-width="2"/>
                    <path d="M-100 240 C400 140, 750 490, 1150 280 C1420 130, 1550 380, 1600 340" :stroke="themeKey === 'imperial-onyx' ? 'rgba(251,191,36,0.18)' : 'rgba(217,119,6,0.15)'" stroke-width="1.6"/>
                    <path d="M-100 280 C450 180, 800 530, 1200 320 C1460 170, 1580 420, 1600 380" :stroke="themeKey === 'imperial-onyx' ? 'rgba(251,191,36,0.12)' : 'rgba(217,119,6,0.10)'" stroke-width="1.2"/>
                    <path d="M-100 640 C420 450, 800 840, 1200 640 C1440 500, 1560 700, 1600 640" :stroke="themeKey === 'imperial-onyx' ? 'rgba(245,158,11,0.20)' : 'rgba(217,119,6,0.18)'" stroke-width="2"/>
                    <path d="M-100 680 C470 490, 840 880, 1240 680 C1480 540, 1580 740, 1600 680" :stroke="themeKey === 'imperial-onyx' ? 'rgba(245,158,11,0.14)' : 'rgba(217,119,6,0.12)'" stroke-width="1.5"/>
                    <path d="M-100 720 C520 530, 880 920, 1280 720 C1510 580, 1600 780, 1600 720" :stroke="themeKey === 'imperial-onyx' ? 'rgba(245,158,11,0.08)' : 'rgba(217,119,6,0.08)'" stroke-width="1.2"/>
                </svg>
            </div>
        </template>

        {{-- Apple Premium Colorful Ambient Floating Orbs Engine (۵ گوی نورانی و پرمیوم رنگی اپل) --}}
        <div class="ambient-orb-container" :class="'theme-' + themeKey" x-show="themeKey !== 'pure-black'">
            <div class="ambient-orb orb-1"></div>
            <div class="ambient-orb orb-2"></div>
            <div class="ambient-orb orb-3"></div>
            <div class="ambient-orb orb-4"></div>
            <div class="ambient-orb orb-5"></div>
        </div>

        <div class="display-shell relative z-10 flex min-h-[100dvh] flex-col gap-3 p-4 xl:h-screen xl:min-h-screen xl:p-5">

            {{-- Header --}}
            <header :class="theme.headerBg" class="display-header rounded-[2rem] px-8 py-4 flex flex-row items-center justify-between gap-4 shrink-0 animate-fadeInUp shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all duration-500">

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
                                <img src="/images/logos/rubika.png" x-on:error="$event.target.src = '/icons/icon-72x72.png'" class="w-5 h-5 object-contain shrink-0">
                                <span :class="theme.textPrimary" class="tracking-wide truncate" x-text="settings.rubika"></span>
                            </div>
                        </template>
                    </div>

                    {{-- QR Code (فریم لوکس با خط اسکن لیزری ملایم) --}}
                    <div class="flex items-center gap-4 transition-all duration-300 hover:scale-[1.02] shrink-0">
                        <div class="relative bg-white p-2 rounded-2xl shadow-[0_10px_25px_rgba(0,0,0,0.25)] border border-white/30 shrink-0 overflow-hidden group">
                            <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' + encodeURIComponent(settings.qr_link || (window.location.origin + '/' + (snapshotData.username || '')))" 
                                 alt="QR Code" class="w-24 h-24 xl:w-28 xl:h-28 object-contain rounded-lg">
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
                <div class="order-2 flex w-[24%] flex-col items-center justify-center text-center">
                    <h1 :class="isLightTheme ? (themeKey === 'imperial-pearl' ? 'text-transparent bg-clip-text bg-gradient-to-r from-amber-700 via-yellow-600 to-amber-800 drop-shadow-[0_1px_4px_rgba(217,119,6,0.3)]' : 'text-slate-900') : 'text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-yellow-400 to-amber-300 drop-shadow-[0_0_20px_rgba(251,191,36,0.2)]'" 
                        class="max-w-full break-words text-4xl xl:text-5xl font-black tracking-tight leading-tight" x-text="settings.shop_name"></h1>
                    <div :class="themeKey === 'imperial-pearl' ? 'bg-amber-500/15 text-amber-900 border border-amber-500/30' : (isLightTheme ? 'bg-blue-600/10 text-blue-700' : 'bg-amber-400/10 text-amber-300 border border-amber-400/20')" 
                         class="mt-1 px-4 py-0.5 rounded-full text-[10px] font-black tracking-wider uppercase">
                         ✦ نرخ‌گذاری لحظه‌ای طلا و ارز ✦
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
                                        <div class="shrink-0 champagne-showcase rounded-2xl px-5 py-3 text-right">
                                            <div class="flex items-center justify-between gap-2 mb-1">
                                                <span class="text-[10px] font-black uppercase tracking-[0.25em] text-amber-300/90 drop-shadow-sm">مبلغ نهایی ویترین</span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping"></span>
                                            </div>
                                            <template x-if="activeProductFinalPrice > 0">
                                                <div class="flex items-baseline gap-1.5">
                                                    <span class="text-3xl xl:text-4xl font-black tabular-nums tracking-tight text-white drop-shadow-[0_2px_12px_rgba(251,191,36,0.5)]" x-text="formatNumber(activeProductFinalPrice)"></span>
                                                    <span class="text-xs font-black text-amber-200/80 whitespace-nowrap">تومان</span>
                                                </div>
                                            </template>
                                            <template x-if="activeProductFinalPrice <= 0">
                                                <span class="text-xs font-black text-amber-200 bg-amber-950/60 border border-amber-500/30 rounded-lg px-2.5 py-1 block">در حال استعلام نرخ...</span>
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
                                 ? (themeKey === 'bing-daily'
                                    ? 'neu-hero-gold-obsidian'
                                    : (themeKey === 'bing-studio'
                                       ? 'neu-hero-gold-studio'
                                       : (themeKey === 'bing-ceramic'
                                          ? 'neu-hero-gold-ceramic'
                                          : (themeKey === 'imperial-onyx'
                                             ? 'neu-hero-gold-imperial'
                                             : (themeKey === 'imperial-pearl'
                                                ? 'neu-hero-gold-pearl'
                                                : (isLightTheme
                                                   ? 'ring-2 ring-amber-400/90 bg-gradient-to-br from-amber-100/75 via-white/80 to-amber-50/70 shadow-[-5px_-5px_16px_rgba(255,255,255,1),8px_14px_28px_rgba(245,158,11,0.3)] border border-amber-300 backdrop-blur-2xl'
                                                   : 'ring-2 ring-amber-500/80 bg-gradient-to-br from-amber-600/35 via-slate-900/70 to-slate-950/95 shadow-[-4px_-4px_16px_rgba(245,158,11,0.2),9px_14px_36px_rgba(0,0,0,0.9)] border border-amber-400/40 backdrop-blur-2xl'))))))
                                 : theme.card + ' ' + theme.cardHover,
                                 index < 3 ? 'col-span-4 px-5 xl:px-6 pb-5 pt-4' : 'col-span-3 px-3.5 xl:px-4 pb-3.5 pt-3.5'
                                 ]"
                                 class="relative overflow-hidden flex min-w-0 flex-col justify-between rounded-[1.75rem] transition-all duration-300 h-full">

                                <template x-if="item.symbol === 'gold18'">
                                    <div class="absolute inset-0 pointer-events-none overflow-hidden">
                                        <div class="absolute inset-0" :class="isLightTheme ? 'bg-[radial-gradient(circle_at_50%_0%,rgba(245,158,11,0.18),transparent_75%)]' : 'bg-[radial-gradient(circle_at_50%_0%,rgba(245,158,11,0.28),transparent_75%)]'"></div>
                                        <div class="absolute inset-0 animate-gold-shine bg-gradient-to-r from-transparent via-amber-400/25 to-transparent w-1/2 h-full"></div>
                                    </div>
                                </template>

                                {{-- هدر کارت: عنوان نماد و فلش روند اپلی --}}
                                <div class="relative flex justify-between items-center gap-3">
                                    <p :class="[item.symbol === 'gold18' ? (isLightTheme ? 'text-amber-900' : 'text-amber-300') : theme.textPrimary, index < 3 ? 'text-2xl xl:text-3xl' : 'text-lg xl:text-xl']"
                                       class="market-tile-label min-w-0 font-black tracking-tight drop-shadow-sm line-clamp-1 shrink-0" style="line-height:1.2;" x-text="item.label"></p>
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
                                    item.symbol === 'gold18' ? (isLightTheme ? 'text-amber-800' : 'text-amber-300') : theme.priceColor,
                                    index < 3 ? 'py-3' : 'py-1.5'
                                ]" class="relative flex-1 flex min-w-0 flex-col justify-center items-center">
                                    <div class="flex items-baseline justify-center whitespace-nowrap w-full gap-1.5">
                                         <span :class="[index < 3 ? 'text-4xl xl:text-5xl leading-none' : 'text-2xl xl:text-3xl', theme.priceGlow]" class="market-price-number font-black tabular-nums tracking-tighter drop-shadow-md" x-html="item.displayHtml"></span>
                                         <span :class="[index < 3 ? 'text-sm xl:text-base' : 'text-[11px] xl:text-xs', themeKey === 'imperial-onyx' ? 'neu-inset-onyx' : (themeKey === 'imperial-pearl' ? 'neu-inset-pearl' : (themeKey === 'bing-daily' ? 'text-slate-900 bg-white/45 border border-white/60 backdrop-blur-md shadow-xs' : (isLightTheme ? 'text-slate-600 bg-black/5' : 'text-white/70 bg-white/10')))]" class="font-bold px-2 py-0.5 rounded-md whitespace-nowrap select-none border border-white/5" x-text="item.unit"></span>
                                    </div>
                                </div>

                                {{-- فوتر کارت: کپسول نوسان به سبک Apple Stocks و نشانگر زنده --}}
                                <div class="relative flex justify-between items-center border-t" :class="[index < 3 ? 'mt-2 pt-2.5' : 'mt-1 pt-2', isLightTheme ? 'border-black/5' : 'border-white/10']">
                                    {{-- کپسول درصد و نوسان (طراحی مشابه Apple Stocks و Neumorphic) --}}
                                    <div class="flex items-center gap-2 font-black tabular-nums text-xs xl:text-sm px-2.5 py-1 rounded-full border shadow-sm" :class="[
                                        themeKey === 'imperial-onyx'
                                            ? (item.change_percent > 0 ? 'neu-pill-convex-dark-up' : (item.change_percent < 0 ? 'neu-pill-convex-dark-down' : 'neu-pill-convex-dark-flat'))
                                            : (themeKey === 'imperial-pearl'
                                                ? (item.change_percent > 0 ? 'neu-pill-convex-light-up' : (item.change_percent < 0 ? 'neu-pill-convex-light-down' : 'neu-pill-convex-light-flat'))
                                                : (themeKey === 'bing-daily'
                                                    ? (item.change_percent > 0 ? 'bg-emerald-500/25 text-emerald-950 border-emerald-400/50 shadow-xs' : (item.change_percent < 0 ? 'bg-rose-500/25 text-rose-950 border-rose-400/50 shadow-xs' : 'bg-white/30 text-slate-800 border-white/40 shadow-xs'))
                                                    : (item.change_percent > 0 ? 'bg-emerald-500/15 text-emerald-400 border-emerald-500/25' : (item.change_percent < 0 ? 'bg-rose-500/15 text-rose-400 border-rose-500/25' : 'bg-white/5 text-slate-400 border-white/10')))),
                                    ]" dir="ltr">
                                        <span x-text="formatSignedNumber(item.change_percent, 2) + '%'"></span>
                                        <span class="opacity-30">|</span>
                                        <span x-text="(item.symbol === 'ounce' || item.symbol === 'bitcoin') ? formatSignedNumber(item.change_value, 2) : formatSignedNumber(item.change_value)"></span>
                                    </div>

                                    {{-- وضعیت زنده با میکرو-پالس اپلی --}}
                                    <div class="flex items-center">
                                        <template x-if="(/خرید.*(18|۱۸)/.test(item.label)) ? (orderedMetrics.find(m => m.symbol === 'gold18')?.is_stale ?? item.is_stale) : item.is_stale">
                                            <span class="inline-flex items-center gap-1 text-[11px] rounded-full px-2.5 py-0.5 font-bold border shadow-sm"
                                                  :class="isLightTheme ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-amber-500/15 text-amber-400 border-amber-500/30'">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                <span>قدیمی</span>
                                            </span>
                                        </template>
                                        <template x-if="!((/خرید.*(18|۱۸)/.test(item.label)) ? (orderedMetrics.find(m => m.symbol === 'gold18')?.is_stale ?? item.is_stale) : item.is_stale)">
                                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-0.5 rounded-full shadow-sm"
                                                  :class="themeKey === 'imperial-onyx' ? 'neu-status-pill-dark' : (themeKey === 'imperial-pearl' ? 'neu-status-pill-light' : (isLightTheme ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/80' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20'))">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                </span>
                                                <span class="text-[10px] opacity-80">لحظه‌ای</span>
                                            </span>
                                        </template>
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

                {{-- سمت راست: کپسول تبلیغ و راه‌اندازی اختصاصی TalaLive جهت جذب همکاران و طلافروشان --}}
                <div class="flex items-center gap-3 h-full z-10">
                    <a href="https://talalive.ir" target="_blank" 
                       class="group flex items-center gap-2.5 px-4 py-1.5 rounded-full border transition-all duration-300 hover:scale-105 shadow-sm cursor-pointer"
                       :class="isLightTheme ? 'bg-amber-500/10 border-amber-500/30 text-amber-950 hover:bg-amber-500/20' : 'bg-gradient-to-r from-amber-500/20 via-yellow-500/15 to-amber-600/20 border-amber-400/40 text-amber-200 shadow-[0_0_18px_rgba(245,158,11,0.2)] hover:border-amber-300/60'">
                        <span class="flex h-2.5 w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-400"></span>
                        </span>
                        <span class="text-xs font-black tracking-wide">راه‌اندازی این تابلوی هوشمند برای فروشگاه شما:</span>
                        <span class="font-mono font-black text-xs px-2.5 py-0.5 rounded-full" :class="isLightTheme ? 'bg-amber-300/80 text-amber-950' : 'bg-amber-400/30 text-amber-300 border border-amber-400/40'">TalaLive.ir</span>
                    </a>
                </div>


                {{-- مرکز: هویت و فناوری پلتفرم کشوری --}}
                <div class="hidden xl:flex items-center gap-2 justify-center z-10 text-xs font-black" :class="theme.textPrimary">
                    <span class="opacity-90">پلتفرم هوشمند نمایش نرخ و ویترین آنلاین طلا</span>
                    <span class="opacity-25">✦</span>
                    <span :class="isLightTheme ? 'text-slate-500' : 'text-slate-400'" class="font-normal font-mono">By <span class="font-bold text-slate-400 dark:text-slate-300">Bahman Dev</span></span>
                </div>

                {{-- سمت چپ: وضعیت اتصال و بروزرسانی لحظه‌ای --}}
                <div class="flex items-center gap-3 z-10 font-bold text-xs" :class="theme.textSecondary">
                    <span class="flex items-center gap-2 bg-black/15 dark:bg-white/10 border border-white/10 rounded-full px-4 py-1.5 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-[pulse_1.5s_infinite]"></span>
                        <span dir="ltr" class="font-mono" x-text="errorMessage || 'بروزرسانی: ' + (snapshotData?.updatedAt ? new Date(snapshotData.updatedAt).toLocaleTimeString('fa-IR', {hour: '2-digit', minute:'2-digit', second:'2-digit'}) : '---')"></span>
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
                headerBg: 'neu-card-dark-glass', 
                card: 'neu-card-dark-glass', 
                cardHover: '', 
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
                bg: 'bg-slate-950', 
                headerBg: 'neu-card-bing-obsidian', 
                card: 'neu-card-bing-obsidian', 
                cardHover: '', 
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
                bg: 'bg-slate-950', 
                headerBg: 'neu-card-bing-studio', 
                card: 'neu-card-bing-studio', 
                cardHover: '', 
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
                bg: 'bg-slate-950', 
                headerBg: 'neu-card-bing-ceramic', 
                card: 'neu-card-bing-ceramic', 
                cardHover: '', 
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
                bg: 'bg-[radial-gradient(ellipse_at_top,#2b1502_0%,#140800_50%,#050200_100%)]', 
                headerBg: 'neu-card-gold-royal', 
                card: 'neu-card-gold-royal', 
                cardHover: '', 
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
                bg: 'bg-[radial-gradient(ellipse_at_top,#0a192f_0%,#020c1b_60%,#00030a_100%)]', 
                headerBg: 'neu-card-blue-ocean', 
                card: 'neu-card-blue-ocean', 
                cardHover: '', 
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
                bg: 'bg-[radial-gradient(ellipse_at_top,#1e0b36_0%,#0f051d_50%,#04010a_100%)]', 
                headerBg: 'neu-card-purple-haze', 
                card: 'neu-card-purple-haze', 
                cardHover: '', 
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
                bg: 'bg-[radial-gradient(ellipse_at_top,#022c22_0%,#011c15_50%,#000504_100%)]', 
                headerBg: 'neu-card-emerald-night', 
                card: 'neu-card-emerald-night', 
                cardHover: '', 
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
                bg: 'bg-[radial-gradient(ellipse_at_top,#3f0212_0%,#1c0007_50%,#050002_100%)]', 
                headerBg: 'neu-card-rose-dark', 
                card: 'neu-card-rose-dark', 
                cardHover: '', 
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
                bg: 'bg-black', 
                headerBg: 'neu-card-pure-black', 
                card: 'neu-card-pure-black', 
                cardHover: '', 
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
                productImageIndex: 0,
                sliderTimer: null,
                now: new Date(),
                refreshTimer: null,
                isFullscreen: false,
                zoomLevel: parseFloat(localStorage.getItem('display_zoom') || '1'),
                showControls: false,
                controlsTimer: null,

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
                get orderedMetrics() {
                    const items = this.snapshotData?.displayItems || [];
                    const feed = this.snapshotData?.priceFeed || [];
                    const enabledKeys = items.filter(i => i.enabled && i.key !== 'exchange_gold').sort((a,b) => a.order - b.order).map(i => i.key);
                    return feed.filter(f => enabledKeys.includes(f.symbol)).sort((a,b) => enabledKeys.indexOf(a.symbol) - enabledKeys.indexOf(b.symbol));
                },
                                get isLightTheme() { return this.themeKey === 'light-modern' || this.themeKey === 'bing-ceramic' || this.themeKey === 'imperial-pearl'; },
                get isBingTheme() { return this.themeKey === 'bing-daily' || this.themeKey === 'bing-studio' || this.themeKey === 'bing-ceramic'; },
                get bingWallpaper() { return this.snapshotData?.bingWallpaper || { url: '/images/bing/today.jpg', title: 'عکس روز بینگ', copyright: 'Bing Daily Wallpaper' }; },
                get bingWallpaperUrl() { return this.bingWallpaper?.url || '/images/bing/today.jpg'; },
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

                    // HUD هوشمند با Auto-Hide پس از ۳.۵ ثانیه عدم فعالیت
                    this.triggerControls();
                    window.addEventListener('mousemove', () => this.triggerControls(), { passive: true });
                    window.addEventListener('touchstart', () => this.triggerControls(), { passive: true });
                    window.addEventListener('keydown', () => this.triggerControls(), { passive: true });

                    document.addEventListener('fullscreenchange', () => {
                        this.isFullscreen = !!document.fullscreenElement;
                    });
                    
                    this.$watch('zoomLevel', val => document.documentElement.style.fontSize = Math.round(val * 100) + '%');
                    document.documentElement.style.fontSize = Math.round(this.zoomLevel * 100) + '%';

                    // Sync theme class
                    this.$watch('themeKey', () => document.documentElement.className = (this.isLightTheme ? 'light' : 'dark'));
                    document.documentElement.className = (this.isLightTheme ? 'light' : 'dark');

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
