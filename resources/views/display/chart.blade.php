<!DOCTYPE html>
<html lang="fa" dir="rtl" class="{{ $isLightTheme ? 'light' : 'dark' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="{{ $isLightTheme ? '#f7f5f0' : '#0b0c0e' }}">
    @if($isEmbed || $isTv || $username === 'demo')
        <meta name="robots" content="noindex, follow">
    @else
        <meta name="robots" content="index, follow">
        <title>نمودار قیمت {{ $chartData['label'] }} | {{ $galleryDisplayName }} | طلالایو</title>
        <meta name="description" content="نمودار نوسانات ۱ روزه، ۷ روزه، ۳۰ روزه و ۱ ساله {{ $chartData['label'] }} در {{ $galleryDisplayName }} {{ $cityFullDisplay }}.">
        <link rel="canonical" href="{{ $standaloneUrl }}">
    @endif
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    <style>
        :root {
            color-scheme: {{ $isLightTheme ? 'light' : 'dark' }};
            --bg-page: {{ $isLightTheme ? '#f7f5f0' : '#0b0c0e' }};
            --bg-surface: {{ $isLightTheme ? '#ffffff' : '#13161b' }};
            --bg-inset: {{ $isLightTheme ? '#f1ede4' : '#191d24' }};
            --border-subtle: {{ $isLightTheme ? 'rgba(15, 23, 42, 0.10)' : 'rgba(255, 255, 255, 0.10)' }};
            --border-strong: {{ $isLightTheme ? 'rgba(180, 83, 9, 0.25)' : 'rgba(245, 158, 11, 0.28)' }};
            --text-primary: {{ $isLightTheme ? '#0f172a' : '#f8fafc' }};
            --text-secondary: {{ $isLightTheme ? '#475569' : '#94a3b8' }};
            --accent: {{ $isLightTheme ? '#b45309' : '#fbbf24' }};
            --accent-bg: {{ $isLightTheme ? 'rgba(217, 119, 6, 0.10)' : 'rgba(245, 158, 11, 0.12)' }};
            --up-color: {{ $isLightTheme ? '#047857' : '#34d399' }};
            --up-bg: {{ $isLightTheme ? 'rgba(4, 120, 87, 0.10)' : 'rgba(16, 185, 129, 0.14)' }};
            --down-color: {{ $isLightTheme ? '#be123c' : '#fb7185' }};
            --down-bg: {{ $isLightTheme ? 'rgba(190, 18, 60, 0.10)' : 'rgba(244, 63, 94, 0.14)' }};
            --grid-line: {{ $isLightTheme ? 'rgba(15, 23, 42, 0.08)' : 'rgba(255, 255, 255, 0.08)' }};
            --tooltip-bg: {{ $isLightTheme ? '#0f172a' : '#1e232c' }};
            --tooltip-text: #ffffff;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            min-height: 100%;
            font-family: 'Vazirmatn', Tahoma, Arial, sans-serif;
            background: var(--bg-page);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        .page-shell {
            min-height: 100vh;
            min-height: 100dvh;
            max-width: 1120px;
            margin: 0 auto;
            padding: 14px 16px 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .topbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            padding: 10px 14px;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 44px;
            padding: 8px 14px;
            border-radius: 12px;
            border: 1px solid var(--border-subtle);
            background: var(--bg-inset);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.15s ease, border-color 0.15s ease, opacity 0.15s ease;
        }
        .btn:hover { border-color: var(--border-strong); }
        .btn:active { transform: scale(0.98); }
        .btn-primary {
            background: var(--accent-bg);
            border-color: var(--border-strong);
            color: var(--accent);
        }
        .gallery-meta {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .gallery-name {
            font-size: 13px;
            font-weight: 900;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .gallery-sub {
            font-size: 11px;
            color: var(--text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .symbol-select {
            min-height: 44px;
            padding: 6px 12px;
            border-radius: 12px;
            border: 1px solid var(--border-subtle);
            background: var(--bg-inset);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
        }
        .timer-pill {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-secondary);
            background: var(--bg-inset);
            border: 1px solid var(--border-subtle);
            padding: 6px 11px;
            border-radius: 999px;
            font-variant-numeric: tabular-nums;
        }
        .hero-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: 22px;
            padding: 16px 18px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            flex: 1;
        }
        .hero-head {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 14px;
        }
        .price-block {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .symbol-title-row {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .symbol-title {
            font-size: 20px;
            font-weight: 900;
            letter-spacing: -0.02em;
        }
        .point-time-badge {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-secondary);
            background: var(--bg-inset);
            border: 1px solid var(--border-subtle);
            border-radius: 999px;
            padding: 3px 10px;
        }
        .price-line {
            display: flex;
            align-items: baseline;
            gap: 10px;
            flex-wrap: wrap;
        }
        .price-value {
            font-size: clamp(28px, 4.4vw, 44px);
            font-weight: 900;
            letter-spacing: -0.03em;
            font-variant-numeric: tabular-nums;
            line-height: 1.1;
        }
        .price-unit {
            font-size: 14px;
            font-weight: 800;
            color: var(--text-secondary);
        }
        .delta-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 900;
            font-variant-numeric: tabular-nums;
            direction: ltr;
        }
        .delta-up { background: var(--up-bg); color: var(--up-color); }
        .delta-down { background: var(--down-bg); color: var(--down-color); }
        .delta-flat { background: var(--accent-bg); color: var(--accent); }
        .range-tabs {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px;
            border-radius: 14px;
            background: var(--bg-inset);
            border: 1px solid var(--border-subtle);
        }
        .range-tab {
            min-height: 40px;
            padding: 7px 14px;
            border-radius: 10px;
            border: 1px solid transparent;
            background: transparent;
            color: var(--text-secondary);
            font-family: inherit;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .range-tab[aria-selected="true"] {
            background: var(--bg-surface);
            color: var(--accent);
            border-color: var(--border-strong);
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }
        .chart-stage {
            position: relative;
            width: 100%;
            min-height: 290px;
            flex: 1;
            display: flex;
            align-items: stretch;
            justify-content: center;
            border-radius: 16px;
            background: var(--bg-inset);
            border: 1px solid var(--border-subtle);
            padding: 10px 8px 6px;
            overflow: hidden;
            touch-action: pan-y;
        }
        .chart-svg {
            width: 100%;
            height: 100%;
            min-height: 270px;
            max-height: 430px;
            display: block;
            user-select: none;
            -webkit-user-select: none;
        }
        .axis-label {
            fill: var(--text-secondary);
            font-size: 12px;
            font-weight: 700;
            font-family: 'Vazirmatn', Tahoma, sans-serif;
        }
        .chart-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 700;
            padding: 36px 16px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }
        .stat-box {
            background: var(--bg-inset);
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            padding: 10px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }
        .stat-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-secondary);
        }
        .stat-value {
            font-size: 15px;
            font-weight: 900;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .footer-note {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            font-size: 11px;
            color: var(--text-secondary);
            padding: 0 4px;
        }
        @media (max-width: 720px) {
            .page-shell { padding: 10px 10px 16px; gap: 10px; }
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .range-tabs { width: 100%; justify-content: space-between; }
            .range-tab { flex: 1; padding: 7px 6px; font-size: 12px; }
            .chart-stage { min-height: 230px; }
            .chart-svg { min-height: 220px; }
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <div class="topbar-right">
                <button type="button" id="backBoardBtn" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    <span>بازگشت به تابلو</span>
                </button>
                <div class="gallery-meta">
                    <span class="gallery-name">{{ $galleryDisplayName }}</span>
                    <span class="gallery-sub">{{ $cityFullDisplay }}</span>
                </div>
            </div>

            <div class="topbar-left">
                @if(count($switchItems) > 1)
                    <select id="symbolSwitcher" class="symbol-select" aria-label="تغییر نماد نمودار">
                        @foreach($switchItems as $opt)
                            <option value="{{ $opt['key'] }}" @selected($opt['key'] === $symbol)>{{ $opt['label'] }}</option>
                        @endforeach
                    </select>
                @endif

                @if($isEmbed)
                    <span id="inactivityPill" class="timer-pill">بازگشت خودکار: ۶۰ ثانیه</span>
                    <a id="openStandaloneLink" href="{{ $standaloneUrl }}" target="_blank" rel="noopener" class="btn" title="باز کردن در صفحه مستقل">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        <span>صفحه مستقل</span>
                    </a>
                @else
                    <button type="button" id="copyChartUrlBtn" class="btn">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                        <span id="copyBtnText">کپی لینک نمودار</span>
                    </button>
                @endif
            </div>
        </header>

        <section class="hero-card" aria-label="نمودار نوسانات قیمت">
            <div class="hero-head">
                <div class="price-block">
                    <div class="symbol-title-row">
                        <h1 class="symbol-title" id="symbolTitle">{{ $chartData['label'] }}</h1>
                        <span class="point-time-badge" id="pointTimeBadge">نرخ لحظه‌ای تابلو</span>
                    </div>
                    <div class="price-line">
                        <span class="price-value" id="displayPrice">---</span>
                        <span class="price-unit" id="displayUnit">{{ $chartData['unit'] }}</span>
                        <span class="delta-badge delta-flat" id="deltaBadge">---</span>
                    </div>
                </div>

                <div class="range-tabs" role="tablist" aria-label="بازه زمانی نمودار">
                    <button type="button" role="tab" class="range-tab" data-range="1d" aria-selected="{{ $range === '1d' ? 'true' : 'false' }}">۱ روزه</button>
                    <button type="button" role="tab" class="range-tab" data-range="7d" aria-selected="{{ $range === '7d' ? 'true' : 'false' }}">۷ روزه</button>
                    <button type="button" role="tab" class="range-tab" data-range="30d" aria-selected="{{ $range === '30d' ? 'true' : 'false' }}">۳۰ روزه</button>
                    <button type="button" role="tab" class="range-tab" data-range="1y" aria-selected="{{ $range === '1y' ? 'true' : 'false' }}">۱ ساله</button>
                </div>
            </div>

            <div class="chart-stage" id="chartStage">
                <svg id="chartSvg" class="chart-svg" viewBox="0 0 960 360" preserveAspectRatio="none" role="img" aria-label="نمودار قیمت">
                    <defs>
                        <linearGradient id="chartAreaGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop id="gradTopStop" offset="0%" stop-color="#10b981" stop-opacity="0.34" />
                            <stop id="gradBottomStop" offset="100%" stop-color="#10b981" stop-opacity="0.01" />
                        </linearGradient>
                    </defs>
                    <g id="gridLayer"></g>
                    <path id="areaPath" d="" fill="url(#chartAreaGrad)" />
                    <path id="linePath" d="" fill="none" stroke="#10b981" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round" />
                    <line id="crosshairLine" x1="0" y1="24" x2="0" y2="312" stroke="currentColor" stroke-opacity="0.28" stroke-width="1.5" stroke-dasharray="4 4" visibility="hidden" />
                    <circle id="endPointHalo" cx="0" cy="0" r="9" fill="#10b981" fill-opacity="0.22" visibility="hidden" />
                    <circle id="endPointDot" cx="0" cy="0" r="4.5" fill="#10b981" stroke="#ffffff" stroke-width="2" visibility="hidden" />
                    <circle id="hoverDot" cx="0" cy="0" r="6" fill="#10b981" stroke="#ffffff" stroke-width="2.5" visibility="hidden" />
                    <g id="tooltipGroup" visibility="hidden">
                        <rect id="tooltipBg" x="0" y="0" width="184" height="52" rx="10" fill="var(--tooltip-bg)" />
                        <text id="tooltipPrice" x="92" y="22" text-anchor="middle" fill="#ffffff" font-size="14" font-weight="900" font-family="Vazirmatn, Tahoma, sans-serif"></text>
                        <text id="tooltipDate" x="92" y="40" text-anchor="middle" fill="#cbd5e1" font-size="11" font-weight="700" font-family="Vazirmatn, Tahoma, sans-serif"></text>
                    </g>
                    <g id="xAxisLayer"></g>
                    <rect id="interactionLayer" x="0" y="0" width="960" height="360" fill="transparent" style="cursor: crosshair;" />
                </svg>

                <div id="chartEmpty" class="chart-empty" style="display: none;">
                    <span>اطلاعات کافی برای این بازه زمانی هنوز ثبت نشده است.</span>
                    <button type="button" id="retryLoadBtn" class="btn btn-primary">تلاش مجدد</button>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-box">
                    <span class="stat-label">نرخ فعلی</span>
                    <span class="stat-value" id="statCurrent">---</span>
                </div>
                <div class="stat-box">
                    <span class="stat-label">سقف بازه</span>
                    <span class="stat-value" id="statHigh">---</span>
                </div>
                <div class="stat-box">
                    <span class="stat-label">کف بازه</span>
                    <span class="stat-value" id="statLow">---</span>
                </div>
                <div class="stat-box">
                    <span class="stat-label">تغییر بازه</span>
                    <span class="stat-value" dir="ltr" style="text-align: right;" id="statChange">---</span>
                </div>
            </div>
        </section>

        <footer class="footer-note">
            <span>داده‌های واقعی بازار · برای مشاهده دقیق هر نقطه روی نمودار لمس یا حرکت دهید</span>
            <span>{{ $isEmbed ? 'حالت هم‌نشین روی تابلو · کلیدهای چپ و راست ریموت برای تغییر بازه و Esc برای بازگشت' : 'سامانه تابلوی هوشمند طلالایو' }}</span>
        </footer>
    </div>

    <script>
    (function() {
        var INITIAL_DATA = @json($chartData);
        var USERNAME = @json($username);
        var SYMBOL = @json($symbol);
        var API_URL = @json($apiUrl);
        var BACK_URL = @json($backUrl);
        var STANDALONE_URL = @json($standaloneUrl);
        var THEME_KEY = @json($themeKey);
        var IS_EMBED = {{ $isEmbed ? 'true' : 'false' }};
        var IS_TV = {{ $isTv ? 'true' : 'false' }};
        var RANGES = ['1d', '7d', '30d', '1y'];

        var currentRange = INITIAL_DATA.range || '7d';
        var seriesCache = Object.create(null);
        seriesCache[currentRange] = INITIAL_DATA;

        var activeSeries = INITIAL_DATA;
        var plottedCoords = [];
        var isHovering = false;
        var autoCloseSeconds = 60;
        var autoCloseTimer = null;

        var fmtInt = new Intl.NumberFormat('fa-IR', { maximumFractionDigits: 0 });
        var fmtDec2 = new Intl.NumberFormat('fa-IR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        function formatPrice(val, decimals) {
            var n = Number(val || 0);
            if (!isFinite(n) || n <= 0) return '---';
            return decimals > 0 ? fmtDec2.format(n) : fmtInt.format(Math.round(n));
        }

        function formatSigned(val, decimals) {
            var n = Number(val || 0);
            if (!isFinite(n)) return '۰';
            var sign = n > 0.0001 ? '+' : (n < -0.0001 ? '-' : '');
            var absVal = Math.abs(n);
            return sign + (decimals > 0 ? fmtDec2.format(absVal) : fmtInt.format(Math.round(absVal)));
        }

        function formatFaInt(val) {
            return fmtInt.format(Math.max(0, Math.round(val)));
        }

        function closeOrBack() {
            if (IS_EMBED && window.parent && window.parent !== window) {
                try {
                    window.parent.postMessage({ type: 'talalive-close-chart' }, '*');
                    return;
                } catch (e) {}
            }
            window.location.href = BACK_URL;
        }

        function resetAutoClose() {
            if (!IS_EMBED) return;
            autoCloseSeconds = 60;
            var pill = document.getElementById('inactivityPill');
            if (pill) pill.textContent = 'بازگشت خودکار: ' + formatFaInt(autoCloseSeconds) + ' ثانیه';
        }

        if (IS_EMBED) {
            ['mousemove', 'touchstart', 'touchmove', 'keydown', 'click'].forEach(function(evtName) {
                window.addEventListener(evtName, resetAutoClose, { passive: true });
            });
            autoCloseTimer = setInterval(function() {
                autoCloseSeconds -= 1;
                var pill = document.getElementById('inactivityPill');
                if (pill) {
                    pill.textContent = 'بازگشت خودکار: ' + formatFaInt(Math.max(0, autoCloseSeconds)) + ' ثانیه';
                }
                if (autoCloseSeconds <= 0) {
                    clearInterval(autoCloseTimer);
                    closeOrBack();
                }
            }, 1000);
        }

        var backBtn = document.getElementById('backBoardBtn');
        if (backBtn) backBtn.addEventListener('click', closeOrBack);

        var switcher = document.getElementById('symbolSwitcher');
        if (switcher) {
            switcher.addEventListener('change', function() {
                var nextSym = switcher.value;
                if (!nextSym) return;
                var target = '/' + encodeURIComponent(USERNAME) + '/chart/' + encodeURIComponent(nextSym) + '?range=' + encodeURIComponent(currentRange);
                if (IS_EMBED) target += '&embed=1';
                if (THEME_KEY) target += '&theme=' + encodeURIComponent(THEME_KEY);
                if (IS_TV) target += '&tv=1';
                window.location.href = target;
            });
        }

        var copyBtn = document.getElementById('copyChartUrlBtn');
        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                var btnText = document.getElementById('copyBtnText');
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(STANDALONE_URL).then(function() {
                        if (btnText) btnText.textContent = 'کپی شد ✓';
                        setTimeout(function() {
                            if (btnText) btnText.textContent = 'کپی لینک نمودار';
                        }, 2000);
                    }).catch(function() {});
                }
            });
        }

        function setHeaderSummary(series, hoverPoint) {
            var decimals = Number(series.decimals || 0);
            var priceEl = document.getElementById('displayPrice');
            var timeBadge = document.getElementById('pointTimeBadge');
            var deltaBadge = document.getElementById('deltaBadge');

            var shownPrice = hoverPoint ? hoverPoint.price : series.currentPrice;
            if (priceEl) priceEl.textContent = formatPrice(shownPrice, decimals);

            if (timeBadge) {
                timeBadge.textContent = hoverPoint ? hoverPoint.label : 'نرخ لحظه‌ای تابلو';
            }

            var startVal = Number(series.startPrice || shownPrice || 0);
            var deltaVal = hoverPoint ? (shownPrice - startVal) : Number(series.changeValue || 0);
            var deltaPct = startVal > 0 ? ((deltaVal / startVal) * 100) : 0;

            if (deltaBadge) {
                deltaBadge.className = 'delta-badge ' + (deltaVal > 0.0001 ? 'delta-up' : (deltaVal < -0.0001 ? 'delta-down' : 'delta-flat'));
                deltaBadge.textContent = formatSigned(deltaPct, 2) + '% | ' + formatSigned(deltaVal, decimals);
            }
        }

        function createSvgEl(tag, attrs) {
            var el = document.createElementNS('http://www.w3.org/2000/svg', tag);
            if (attrs) {
                Object.keys(attrs).forEach(function(k) {
                    el.setAttribute(k, String(attrs[k]));
                });
            }
            return el;
        }

        function renderSeries(series) {
            activeSeries = series;
            isHovering = false;

            var decimals = Number(series.decimals || 0);
            var unit = series.unit || 'تومان';
            var titleEl = document.getElementById('symbolTitle');
            var unitEl = document.getElementById('displayUnit');
            if (titleEl && series.label) titleEl.textContent = series.label;
            if (unitEl) unitEl.textContent = unit;

            setHeaderSummary(series, null);

            document.getElementById('statCurrent').textContent = formatPrice(series.currentPrice, decimals) + ' ' + unit;
            document.getElementById('statHigh').textContent = formatPrice(series.highPrice, decimals) + ' ' + unit;
            document.getElementById('statLow').textContent = formatPrice(series.lowPrice, decimals) + ' ' + unit;
            var chEl = document.getElementById('statChange');
            chEl.textContent = formatSigned(series.changePercent, 2) + '% (' + formatSigned(series.changeValue, decimals) + ')';
            chEl.style.color = series.changeValue > 0.0001 ? 'var(--up-color)' : (series.changeValue < -0.0001 ? 'var(--down-color)' : 'var(--accent)');

            var pts = Array.isArray(series.points) ? series.points.filter(function(p) {
                return p && Number(p.price) > 0;
            }) : [];

            var svgEl = document.getElementById('chartSvg');
            var emptyEl = document.getElementById('chartEmpty');

            if (pts.length === 0) {
                svgEl.style.display = 'none';
                emptyEl.style.display = 'flex';
                plottedCoords = [];
                return;
            }

            svgEl.style.display = 'block';
            emptyEl.style.display = 'none';

            if (pts.length === 1) {
                pts = [pts[0], { t: pts[0].t, label: pts[0].label, short: 'اکنون', price: pts[0].price }];
            }

            var strokeColor = series.changeValue > 0.0001
                ? '#10b981'
                : (series.changeValue < -0.0001 ? '#f43f5e' : '#f59e0b');

            document.getElementById('gradTopStop').setAttribute('stop-color', strokeColor);
            document.getElementById('gradBottomStop').setAttribute('stop-color', strokeColor);
            document.getElementById('linePath').setAttribute('stroke', strokeColor);
            document.getElementById('endPointDot').setAttribute('fill', strokeColor);
            document.getElementById('endPointHalo').setAttribute('fill', strokeColor);
            document.getElementById('hoverDot').setAttribute('fill', strokeColor);

            var W = 960;
            var H = 360;
            var padLeft = 24;
            var padRight = 98;
            var padTop = 24;
            var padBottom = 46;
            var plotW = W - padLeft - padRight;
            var plotH = H - padTop - padBottom;

            var prices = pts.map(function(p) { return Number(p.price); });
            var minP = Math.min.apply(null, prices);
            var maxP = Math.max.apply(null, prices);
            var rawSpan = maxP - minP;
            var minSpan = Math.max(maxP * 0.0025, decimals > 0 ? 0.5 : 100);
            if (rawSpan < minSpan) {
                var mid = (maxP + minP) / 2;
                minP = mid - (minSpan / 2);
                maxP = mid + (minSpan / 2);
            } else {
                var padVal = rawSpan * 0.12;
                minP = Math.max(0, minP - padVal);
                maxP = maxP + padVal;
            }
            var span = Math.max(maxP - minP, 1);

            var gridLayer = document.getElementById('gridLayer');
            while (gridLayer.firstChild) gridLayer.removeChild(gridLayer.firstChild);

            var gridSteps = 4;
            for (var g = 0; g <= gridSteps; g++) {
                var frac = g / gridSteps;
                var gy = padTop + (plotH * frac);
                var gVal = maxP - (span * frac);
                gridLayer.appendChild(createSvgEl('line', {
                    x1: padLeft,
                    y1: gy.toFixed(1),
                    x2: (W - padRight).toFixed(1),
                    y2: gy.toFixed(1),
                    stroke: 'var(--grid-line)',
                    'stroke-width': '1',
                    'stroke-dasharray': g === gridSteps ? '' : '4 4'
                }));
                var yLabel = createSvgEl('text', {
                    x: (W - padRight + 10).toFixed(1),
                    y: (gy + 4).toFixed(1),
                    'text-anchor': 'start',
                    'class': 'axis-label'
                });
                yLabel.textContent = formatPrice(gVal, decimals);
                gridLayer.appendChild(yLabel);
            }

            plottedCoords = [];
            var count = pts.length;
            for (var i = 0; i < count; i++) {
                var ratioX = count > 1 ? (i / (count - 1)) : 0.5;
                var px = padLeft + (plotW * ratioX);
                var py = padTop + ((maxP - Number(pts[i].price)) / span) * plotH;
                plottedCoords.push({
                    x: px,
                    y: py,
                    point: pts[i]
                });
            }

            // ساخت مسیر نرم بدون افتادن به بیرون از بازه قیمتی (Catmull-Rom / Midpoint Smooth)
            var dLine = 'M ' + plottedCoords[0].x.toFixed(2) + ' ' + plottedCoords[0].y.toFixed(2);
            if (plottedCoords.length > 2) {
                for (var j = 1; j < plottedCoords.length - 1; j++) {
                    var xc = (plottedCoords[j].x + plottedCoords[j + 1].x) / 2;
                    var yc = (plottedCoords[j].y + plottedCoords[j + 1].y) / 2;
                    dLine += ' Q ' + plottedCoords[j].x.toFixed(2) + ' ' + plottedCoords[j].y.toFixed(2) + ', ' + xc.toFixed(2) + ' ' + yc.toFixed(2);
                }
                var lastPt = plottedCoords[plottedCoords.length - 1];
                dLine += ' T ' + lastPt.x.toFixed(2) + ' ' + lastPt.y.toFixed(2);
            } else {
                dLine += ' L ' + plottedCoords[1].x.toFixed(2) + ' ' + plottedCoords[1].y.toFixed(2);
            }

            var baselineY = (padTop + plotH).toFixed(2);
            var dArea = dLine + ' L ' + plottedCoords[plottedCoords.length - 1].x.toFixed(2) + ' ' + baselineY + ' L ' + plottedCoords[0].x.toFixed(2) + ' ' + baselineY + ' Z';

            document.getElementById('linePath').setAttribute('d', dLine);
            document.getElementById('areaPath').setAttribute('d', dArea);

            var endCoord = plottedCoords[plottedCoords.length - 1];
            document.getElementById('endPointDot').setAttribute('cx', endCoord.x.toFixed(2));
            document.getElementById('endPointDot').setAttribute('cy', endCoord.y.toFixed(2));
            document.getElementById('endPointDot').setAttribute('visibility', 'visible');
            document.getElementById('endPointHalo').setAttribute('cx', endCoord.x.toFixed(2));
            document.getElementById('endPointHalo').setAttribute('cy', endCoord.y.toFixed(2));
            document.getElementById('endPointHalo').setAttribute('visibility', 'visible');

            var xAxisLayer = document.getElementById('xAxisLayer');
            while (xAxisLayer.firstChild) xAxisLayer.removeChild(xAxisLayer.firstChild);

            var tickCount = Math.min(5, plottedCoords.length);
            var chosenIdx = Object.create(null);
            for (var k = 0; k < tickCount; k++) {
                var idx = tickCount === 1 ? 0 : Math.round((k / (tickCount - 1)) * (plottedCoords.length - 1));
                if (chosenIdx[idx]) continue;
                chosenIdx[idx] = true;
                var c = plottedCoords[idx];
                var anchor = idx === 0 ? 'start' : (idx === plottedCoords.length - 1 ? 'end' : 'middle');
                var xLbl = createSvgEl('text', {
                    x: c.x.toFixed(1),
                    y: (H - 14).toFixed(1),
                    'text-anchor': anchor,
                    'class': 'axis-label'
                });
                xLbl.textContent = c.point.short || c.point.label || '';
                xAxisLayer.appendChild(xLbl);
            }

            hideCrosshair();
        }

        function showCrosshairAtClientX(clientX) {
            if (!plottedCoords.length) return;
            var svg = document.getElementById('chartSvg');
            var rect = svg.getBoundingClientRect();
            if (!rect.width) return;

            var relX = ((clientX - rect.left) / rect.width) * 960;
            var nearest = plottedCoords[0];
            var minDist = Math.abs(relX - nearest.x);

            for (var i = 1; i < plottedCoords.length; i++) {
                var dist = Math.abs(relX - plottedCoords[i].x);
                if (dist < minDist) {
                    minDist = dist;
                    nearest = plottedCoords[i];
                }
            }

            isHovering = true;
            setHeaderSummary(activeSeries, nearest.point);

            var crossLine = document.getElementById('crosshairLine');
            var hoverDot = document.getElementById('hoverDot');
            var tooltipGroup = document.getElementById('tooltipGroup');
            var tooltipBg = document.getElementById('tooltipBg');
            var tooltipPrice = document.getElementById('tooltipPrice');
            var tooltipDate = document.getElementById('tooltipDate');

            crossLine.setAttribute('x1', nearest.x.toFixed(2));
            crossLine.setAttribute('x2', nearest.x.toFixed(2));
            crossLine.setAttribute('visibility', 'visible');

            hoverDot.setAttribute('cx', nearest.x.toFixed(2));
            hoverDot.setAttribute('cy', nearest.y.toFixed(2));
            hoverDot.setAttribute('visibility', 'visible');

            var decimals = Number(activeSeries.decimals || 0);
            tooltipPrice.textContent = formatPrice(nearest.point.price, decimals) + ' ' + (activeSeries.unit || 'تومان');
            tooltipDate.textContent = nearest.point.label || '';

            var boxW = 196;
            var boxH = 52;
            var bx = nearest.x - (boxW / 2);
            if (bx < 16) bx = 16;
            if (bx + boxW > 856) bx = 856 - boxW;
            var by = nearest.y - boxH - 14;
            if (by < 10) by = nearest.y + 14;

            tooltipBg.setAttribute('x', bx.toFixed(1));
            tooltipBg.setAttribute('y', by.toFixed(1));
            tooltipBg.setAttribute('width', boxW);
            tooltipBg.setAttribute('height', boxH);

            tooltipPrice.setAttribute('x', (bx + boxW / 2).toFixed(1));
            tooltipPrice.setAttribute('y', (by + 22).toFixed(1));
            tooltipDate.setAttribute('x', (bx + boxW / 2).toFixed(1));
            tooltipDate.setAttribute('y', (by + 40).toFixed(1));

            tooltipGroup.setAttribute('visibility', 'visible');
        }

        function hideCrosshair() {
            isHovering = false;
            document.getElementById('crosshairLine').setAttribute('visibility', 'hidden');
            document.getElementById('hoverDot').setAttribute('visibility', 'hidden');
            document.getElementById('tooltipGroup').setAttribute('visibility', 'hidden');
            if (activeSeries) {
                setHeaderSummary(activeSeries, null);
            }
        }

        var hitLayer = document.getElementById('interactionLayer');
        if (hitLayer) {
            hitLayer.addEventListener('mousemove', function(e) {
                showCrosshairAtClientX(e.clientX);
            });
            hitLayer.addEventListener('mouseleave', hideCrosshair);
            hitLayer.addEventListener('touchstart', function(e) {
                if (e.touches && e.touches[0]) showCrosshairAtClientX(e.touches[0].clientX);
            }, { passive: true });
            hitLayer.addEventListener('touchmove', function(e) {
                if (e.touches && e.touches[0]) showCrosshairAtClientX(e.touches[0].clientX);
            }, { passive: true });
        }

        function updateTabUI(range) {
            var tabs = document.querySelectorAll('.range-tab');
            for (var i = 0; i < tabs.length; i++) {
                var r = tabs[i].getAttribute('data-range');
                tabs[i].setAttribute('aria-selected', r === range ? 'true' : 'false');
            }
        }

        function switchRange(nextRange, forceRefresh) {
            if (RANGES.indexOf(nextRange) === -1) return;
            currentRange = nextRange;
            updateTabUI(nextRange);
            resetAutoClose();

            if (!forceRefresh && seriesCache[nextRange]) {
                renderSeries(seriesCache[nextRange]);
                return;
            }

            var stage = document.getElementById('chartStage');
            if (stage) stage.style.opacity = '0.72';

            fetch(API_URL + '?range=' + encodeURIComponent(nextRange), {
                headers: { 'Accept': 'application/json' },
                cache: 'no-store'
            })
            .then(function(res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(function(data) {
                seriesCache[nextRange] = data;
                if (currentRange === nextRange) {
                    renderSeries(data);
                }
            })
            .catch(function() {})
            .finally(function() {
                if (stage) stage.style.opacity = '1';
            });
        }

        var tabs = document.querySelectorAll('.range-tab');
        for (var t = 0; t < tabs.length; t++) {
            tabs[t].addEventListener('click', function() {
                switchRange(this.getAttribute('data-range'), false);
            });
        }

        var retryBtn = document.getElementById('retryLoadBtn');
        if (retryBtn) {
            retryBtn.addEventListener('click', function() {
                switchRange(currentRange, true);
            });
        }

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' || e.key === 'Backspace') {
                if (e.target && ['INPUT', 'SELECT', 'TEXTAREA'].indexOf(e.target.tagName) === -1) {
                    e.preventDefault();
                    closeOrBack();
                    return;
                }
            }
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                var nextIdx = (RANGES.indexOf(currentRange) + 1) % RANGES.length;
                switchRange(RANGES[nextIdx], false);
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                var prevIdx = (RANGES.indexOf(currentRange) - 1 + RANGES.length) % RANGES.length;
                switchRange(RANGES[prevIdx], false);
            }
        });

        renderSeries(INITIAL_DATA);

        // همگام‌سازی خودکار قیمت و نقطه آخر نمودار هر ۳۰ ثانیه بدون رفرش صفحه
        setInterval(function() {
            if (isHovering || document.visibilityState === 'hidden') return;
            switchRange(currentRange, true);
        }, 30000);
    })();
    </script>
</body>
</html>
