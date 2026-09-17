<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow">
    <title>ویجت نرخ لحظه‌ای طلا و سکه — طلالایو</title>
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Vazirmatn', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        
        /* تم‌ها */
        .theme-dark { background-color: #090d16; color: #f1f5f9; border-color: #1e293b; }
        .theme-light { background-color: #ffffff; color: #0f172a; border-color: #e2e8f0; }
        .theme-gold { background-color: #120e06; color: #fef08a; border-color: #78350f; }

        .price-gold { color: #f59e0b; font-weight: 900; }
        .theme-light .price-gold { color: #d97706; }

        /* اندازه‌ها */
        /* حالت کادر مستطیلی Box */
        .widget-box {
            width: 100%;
            height: 100vh;
            border-radius: 16px;
            border: 1px solid;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            padding: 14px;
        }

        .header-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .rates-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
            overflow-y: auto;
        }

        .rate-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 7px 10px;
            border-radius: 10px;
            background: rgba(148, 163, 184, 0.08);
            font-size: 13px;
        }

        /* حالت نوار افقی Ticker */
        .widget-ticker {
            width: 100%;
            height: 100vh;
            border-radius: 12px;
            border: 1px solid;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            gap: 12px;
            overflow-x: auto;
        }

        .ticker-items {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
            overflow-x: auto;
            white-space: nowrap;
        }

        .ticker-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            padding: 4px 10px;
            border-radius: 8px;
            background: rgba(148, 163, 184, 0.1);
        }

        .attribution {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-size: 11px;
            padding-top: 8px;
            border-top: 1px solid rgba(148, 163, 184, 0.15);
            text-align: center;
        }

        .attribution a {
            color: #f59e0b;
            text-decoration: none;
            font-weight: bold;
        }
        .attribution a:hover { text-decoration: underline; }

        .live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #10b981;
            display: inline-block;
            box-shadow: 0 0 6px #10b981;
        }
    </style>
</head>
<body class="theme-{{ $theme ?? 'dark' }}">

    @php
        if (!function_exists('formatVal')) {
            function formatVal($val) {
                return $val > 0 ? number_format($val) : '---';
            }
        }
    @endphp

    @if(($size ?? 'box') === 'ticker')
        {{-- قالب نوار افقی (Ticker) --}}
        <div class="widget-ticker theme-{{ $theme ?? 'dark' }}">
            <div style="display: flex; align-items: center; gap: 6px; font-weight: 800; font-size: 12px; shrink-0;">
                <span class="live-dot"></span>
                <span>نرخ زنده:</span>
            </div>

            <div class="ticker-items">
                <div class="ticker-item">
                    <span>طلا ۱۸:</span>
                    <strong class="price-gold">{{ formatVal($rates['gold18'] ?? 0) }}</strong>
                    <small>تومان</small>
                </div>
                <div class="ticker-item">
                    <span>مثقال ۱۷:</span>
                    <strong>{{ formatVal($rates['mesghal'] ?? 0) }}</strong>
                </div>
                <div class="ticker-item">
                    <span>سکه امامی:</span>
                    <strong class="price-gold">{{ formatVal($rates['coin_emami'] ?? 0) }}</strong>
                </div>
                <div class="ticker-item">
                    <span>نیم سکه:</span>
                    <strong>{{ formatVal($rates['coin_nim'] ?? 0) }}</strong>
                </div>
                <div class="ticker-item">
                    <span>دلار:</span>
                    <strong>{{ formatVal($rates['dollar'] ?? 0) }}</strong>
                </div>
                <div class="ticker-item">
                    <span>انس جهانی:</span>
                    <strong>${{ formatVal($rates['ons'] ?? 0) }}</strong>
                </div>
            </div>

            <div style="font-size: 11px; white-space: nowrap; font-weight: bold;">
                <a href="https://talalive.ir" target="_blank" rel="noopener" style="color: #f59e0b; text-decoration: none;">طلالایو</a>
            </div>
        </div>

    @else
        {{-- قالب کادر مستطیل عمودی (Box) --}}
        <div class="widget-box theme-{{ $theme ?? 'dark' }}">
            <div class="header-box">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <span class="live-dot"></span>
                    <strong style="font-size: 13px;">قیمت لحظه‌ای طلا و سکه</strong>
                </div>
                <span style="font-size: 10px; opacity: 0.7;">{{ $lastUpdated ?? 'لحظه‌ای' }}</span>
            </div>

            <div class="rates-list">
                <div class="rate-row">
                    <span>طلای ۱۸ عیار (گرم)</span>
                    <div>
                        <strong class="price-gold">{{ formatVal($rates['gold18'] ?? 0) }}</strong>
                        <small style="font-size: 10px; opacity: 0.8;">تومان</small>
                    </div>
                </div>

                <div class="rate-row">
                    <span>مظنه مثقال ۱۷ عیار</span>
                    <div>
                        <strong>{{ formatVal($rates['mesghal'] ?? 0) }}</strong>
                        <small style="font-size: 10px; opacity: 0.8;">تومان</small>
                    </div>
                </div>

                <div class="rate-row">
                    <span>سکه تمام امامی</span>
                    <div>
                        <strong class="price-gold">{{ formatVal($rates['coin_emami'] ?? 0) }}</strong>
                        <small style="font-size: 10px; opacity: 0.8;">تومان</small>
                    </div>
                </div>

                <div class="rate-row">
                    <span>تمام بهار آزادی</span>
                    <div>
                        <strong>{{ formatVal($rates['coin_bahar'] ?? 0) }}</strong>
                        <small style="font-size: 10px; opacity: 0.8;">تومان</small>
                    </div>
                </div>

                <div class="rate-row">
                    <span>نیم سکه بهار آزادی</span>
                    <div>
                        <strong>{{ formatVal($rates['coin_nim'] ?? 0) }}</strong>
                        <small style="font-size: 10px; opacity: 0.8;">تومان</small>
                    </div>
                </div>

                <div class="rate-row">
                    <span>دلار آزاد تهران</span>
                    <div>
                        <strong>{{ formatVal($rates['dollar'] ?? 0) }}</strong>
                        <small style="font-size: 10px; opacity: 0.8;">تومان</small>
                    </div>
                </div>

                <div class="rate-row">
                    <span>انس جهانی طلا</span>
                    <div>
                        <strong style="font-family: monospace;">${{ formatVal($rates['ons'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>

            {{-- اتریبیوشن اجباری به همراه لینک فعال به دامنه اصلی --}}
            <div class="attribution">
                <span>ارائه‌شده توسط</span>
                <a href="https://talalive.ir" target="_blank" rel="noopener">سامانه تابلوی طلالایو</a>
            </div>
        </div>
    @endif

</body>
</html>
