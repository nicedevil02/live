<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#09090b">
    <meta name="robots" content="noindex, follow">
    <title>راه‌اندازی تلویزیون مغازه | طلالایو</title>
    <meta name="description" content="اتصال سریع و بی‌سیم تلویزیون هوشمند مغازه طلافروشی به تابلوی آنلاین نرخ طلا و سکه طلالایو با کد ۶ رقمی و اسکن بارکد.">
    <link rel="canonical" href="https://talalive.ir/tv">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=2">

    {{-- اسکریپت ES5 خالص برای ریدایرکت فوری تلویزیون متصل‌شده یا پاکسازی کامل در حالت reset=1 --}}
    <script>
        (function () {
            function getQueryParam(name) {
                var search = window.location.search || '';
                if (search.charAt(0) === '?') {
                    search = search.substring(1);
                }
                if (!search) return '';
                var parts = search.split('&');
                for (var i = 0; i < parts.length; i++) {
                    var kv = parts[i].split('=');
                    if (decodeURIComponent(kv[0] || '') === name) {
                        return decodeURIComponent((kv[1] || '').replace(/\+/g, ' '));
                    }
                }
                return '';
            }

            try {
                var isReset = getQueryParam('reset') === '1' || getQueryParam('disconnect') === '1';
                if (isReset) {
                    try {
                        localStorage.removeItem('display_username');
                        localStorage.removeItem('display_token');
                        localStorage.removeItem('tv_device_token');
                        localStorage.removeItem('tv_device_username');
                        sessionStorage.removeItem('skip_redirect');
                    } catch (e) {}
                    document.cookie = 'display_token=; path=/; max-age=0;';
                    return;
                }

                var savedUsername = '';
                var savedToken = '';
                try {
                    savedUsername = localStorage.getItem('display_username') || '';
                    savedToken = localStorage.getItem('display_token') || '';
                } catch (e2) {}

                if (savedUsername && savedToken) {
                    window.location.replace('/' + encodeURIComponent(savedUsername) + '?key=' + encodeURIComponent(savedToken) + '&tv=1');
                }
            } catch (err) {
                if (window.console && console.warn) {
                    console.warn('Pairing init check error:', err);
                }
            }
        })();
    </script>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
    {{-- تولید بارکد QR به صورت ۱۰۰٪ آفلاین روی سرور خودمان بدون وابستگی به سرویس خارجی --}}
    <script src="{{ asset('vendor/qrcode-generator.min.js') }}"></script>

    {{-- استایل استاندارد CSS3 با مقادیر hex/rgba برای تضمین نمایش بی‌نقص روی مرورگرهای قدیمی تلویزیون (Tizen 2016+ / webOS) --}}
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100%;
            background-color: #09090b;
            background-image: radial-gradient(circle at 80% 15%, rgba(245, 158, 11, 0.13) 0%, rgba(9, 9, 11, 0) 52%);
            color: #fafaf9;
            font-family: 'Vazirmatn', Tahoma, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .tv-shell {
            width: 100%;
            min-height: 100vh;
            max-width: 1380px;
            margin: 0 auto;
            padding: 20px 18px 28px;
            display: -webkit-flex;
            display: flex;
            -webkit-flex-direction: column;
            flex-direction: column;
            -webkit-justify-content: space-between;
            justify-content: space-between;
        }

        .tv-topbar {
            display: -webkit-flex;
            display: flex;
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: space-between;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .tv-brand {
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            gap: 12px;
        }

        .tv-logo-wrap {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background-color: #18181b;
            border: 1px solid rgba(251, 191, 36, 0.35);
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
            padding: 5px;
            -webkit-flex-shrink: 0;
            flex-shrink: 0;
        }

        .tv-logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .tv-brand-title {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.3;
        }

        .tv-brand-sub {
            margin: 2px 0 0;
            font-size: 12px;
            color: #a8a29e;
            font-weight: 500;
        }

        .tv-meta-bar {
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            gap: 10px;
        }

        .tv-status-pill {
            display: -webkit-inline-flex;
            display: inline-flex;
            -webkit-align-items: center;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #e7e5e4;
        }

        .tv-status-pill.is-ready {
            background-color: rgba(16, 185, 129, 0.12);
            border-color: rgba(16, 185, 129, 0.35);
            color: #6ee7b7;
        }

        .tv-status-pill.is-error {
            background-color: rgba(244, 63, 94, 0.14);
            border-color: rgba(244, 63, 94, 0.35);
            color: #fda4af;
        }

        .tv-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background-color: #fbbf24;
            display: inline-block;
        }

        .tv-status-pill.is-ready .tv-status-dot {
            background-color: #10b981;
        }

        .tv-status-pill.is-error .tv-status-dot {
            background-color: #f43f5e;
        }

        .tv-clock {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 15px;
            font-weight: 800;
            color: #e7e5e4;
            padding: 6px 12px;
            border-radius: 12px;
            background-color: #18181b;
            border: 1px solid rgba(255, 255, 255, 0.08);
            direction: ltr;
        }

        /* هشدار تشخیص گوشی موبایل: نمایش در نمایشگرهای کوچک زیر 768px */
        .mobile-hint-banner {
            margin-top: 14px;
            padding: 14px 16px;
            border-radius: 18px;
            background-color: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.38);
            display: block;
        }

        .mobile-hint-title {
            margin: 0 0 4px;
            font-size: 13px;
            font-weight: 800;
            color: #fcd34d;
        }

        .mobile-hint-text {
            margin: 0 0 10px;
            font-size: 12px;
            line-height: 1.7;
            color: #e7e5e4;
        }

        .mobile-hint-btn {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 12px;
            background-color: #f59e0b;
            color: #09090b;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        .tv-stage {
            margin: 18px 0;
            display: -webkit-flex;
            display: flex;
            -webkit-flex-direction: column;
            flex-direction: column;
            gap: 18px;
            -webkit-flex: 1;
            flex: 1;
            -webkit-justify-content: center;
            justify-content: center;
        }

        .tv-card {
            background-color: #141417;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 26px;
            padding: 24px 22px;
            display: -webkit-flex;
            display: flex;
            -webkit-flex-direction: column;
            flex-direction: column;
            -webkit-justify-content: space-between;
            justify-content: space-between;
        }

        .tv-card-code {
            border-color: rgba(245, 158, 11, 0.28);
            background-color: #151412;
        }

        .tv-method-tag {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            color: #fbbf24;
            background-color: rgba(245, 158, 11, 0.14);
            border: 1px solid rgba(245, 158, 11, 0.32);
            margin-bottom: 12px;
        }

        .tv-card-heading {
            margin: 0 0 10px;
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.4;
        }

        .tv-steps-list {
            margin: 0 0 18px;
            padding: 0;
            list-style: none;
        }

        .tv-steps-list li {
            font-size: 14px;
            line-height: 1.75;
            color: #d6d3d1;
            margin-bottom: 6px;
        }

        .tv-steps-list strong {
            color: #fcd34d;
        }

        .tv-code-well {
            background-color: #09090b;
            border: 2px solid rgba(245, 158, 11, 0.45);
            border-radius: 22px;
            padding: 20px 16px;
            text-align: center;
        }

        .tv-code-digits {
            display: block;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 46px;
            font-weight: 900;
            letter-spacing: 0.16em;
            color: #fbbf24;
            direction: ltr;
            line-height: 1.15;
            margin: 4px 0 8px;
        }

        .tv-code-digits.is-loading {
            color: #78716c;
        }

        .tv-code-sub {
            font-size: 12px;
            font-weight: 600;
            color: #a8a29e;
        }

        .tv-support-line {
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 13px;
            color: #a8a29e;
            display: -webkit-flex;
            display: flex;
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
            -webkit-justify-content: space-between;
            justify-content: space-between;
            gap: 8px;
        }

        .tv-support-phone {
            color: #fafaf9;
            font-weight: 800;
            direction: ltr;
            display: inline-block;
        }

        .tv-card-qr {
            text-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .tv-qr-whitebox {
            width: 210px;
            height: 210px;
            margin: 10px auto 14px;
            padding: 12px;
            border-radius: 22px;
            background-color: #ffffff;
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
            position: relative;
        }

        .tv-qr-target {
            width: 100%;
            height: 100%;
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
        }

        .tv-qr-target svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .tv-qr-loader {
            position: absolute;
            inset: 0;
            border-radius: 22px;
            background-color: #ffffff;
            color: #44403c;
            font-size: 12px;
            font-weight: 700;
            display: -webkit-flex;
            display: flex;
            -webkit-flex-direction: column;
            flex-direction: column;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
            gap: 10px;
        }

        .tv-spinner {
            width: 30px;
            height: 30px;
            border: 3px solid #e7e5e4;
            border-top-color: #d97706;
            border-radius: 999px;
            -webkit-animation: tvSpin 0.8s linear infinite;
            animation: tvSpin 0.8s linear infinite;
        }

        @-webkit-keyframes tvSpin {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }
        @keyframes tvSpin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .tv-short-url {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 10px;
            background-color: #09090b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 13px;
            font-weight: 700;
            color: #fcd34d;
            direction: ltr;
        }

        .tv-actions {
            display: -webkit-flex;
            display: flex;
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: space-between;
            justify-content: space-between;
            gap: 12px;
            padding-top: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .tv-btn-group {
            display: -webkit-flex;
            display: flex;
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tv-btn {
            display: -webkit-inline-flex;
            display: inline-flex;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
            min-height: 46px;
            padding: 10px 20px;
            border-radius: 14px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            background-color: #18181b;
            color: #e7e5e4;
            border: 1px solid rgba(255, 255, 255, 0.16);
            transition: background-color 0.15s ease, border-color 0.15s ease, transform 0.15s ease;
        }

        .tv-btn:hover {
            background-color: #27272a;
            border-color: rgba(251, 191, 36, 0.55);
            color: #ffffff;
        }

        .tv-btn-primary {
            background-color: #f59e0b;
            color: #09090b;
            border-color: #fbbf24;
            font-weight: 800;
        }

        .tv-btn-primary:hover {
            background-color: #fbbf24;
            color: #09090b;
        }

        .tv-btn:focus {
            outline: 3px solid #fbbf24;
            outline-offset: 3px;
            background-color: #27272a;
            color: #ffffff;
        }

        .tv-btn-primary:focus {
            background-color: #fbbf24;
            color: #09090b;
        }

        .tv-remote-hint {
            font-size: 12px;
            color: #a8a29e;
        }

        .tv-paired-overlay {
            position: fixed;
            inset: 0;
            z-index: 90;
            background-color: rgba(9, 9, 11, 0.96);
            display: none;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
            padding: 24px;
            text-align: center;
        }

        .tv-paired-overlay.is-visible {
            display: -webkit-flex;
            display: flex;
        }

        .tv-paired-box {
            max-width: 460px;
            width: 100%;
            background-color: #141417;
            border: 2px solid rgba(16, 185, 129, 0.5);
            border-radius: 28px;
            padding: 36px 28px;
        }

        .tv-paired-icon {
            width: 68px;
            height: 68px;
            margin: 0 auto 18px;
            border-radius: 999px;
            background-color: rgba(16, 185, 129, 0.16);
            border: 1px solid rgba(16, 185, 129, 0.45);
            color: #34d399;
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
        }

        /* چیدمان تمام‌صفحه بدون اسکرول در تلویزیون و دسکتاپ افقی */
        @media (min-width: 768px) {
            html, body {
                height: 100%;
                overflow: hidden;
            }

            .tv-shell {
                height: 100vh;
                padding: clamp(18px, 3vh, 42px) clamp(24px, 3.8vw, 56px);
            }

            .mobile-hint-banner {
                display: none;
            }

            .tv-stage {
                -webkit-flex-direction: row;
                flex-direction: row;
                -webkit-align-items: stretch;
                align-items: stretch;
                gap: clamp(18px, 2.2vw, 32px);
                margin: clamp(14px, 2.4vh, 28px) 0;
            }

            .tv-card-code {
                width: 56%;
                padding: clamp(22px, 3.2vh, 38px) clamp(24px, 2.8vw, 40px);
            }

            .tv-card-qr {
                width: 44%;
                padding: clamp(22px, 3.2vh, 38px) clamp(20px, 2.4vw, 34px);
            }

            .tv-brand-title {
                font-size: clamp(18px, 1.5vw, 24px);
            }

            .tv-brand-sub {
                font-size: clamp(12px, 1vw, 14px);
            }

            .tv-card-heading {
                font-size: clamp(20px, 1.9vw, 30px);
            }

            .tv-steps-list li {
                font-size: clamp(13px, 1.15vw, 17px);
            }

            .tv-code-digits {
                font-size: clamp(44px, 4.8vw, 76px);
            }

            .tv-code-sub {
                font-size: clamp(12px, 1vw, 15px);
            }

            .tv-qr-whitebox {
                width: clamp(175px, 29vh, 275px);
                height: clamp(175px, 29vh, 275px);
                padding: clamp(10px, 1.5vh, 16px);
            }
        }
    </style>
</head>
<body>
    <main class="tv-shell">
        {{-- نوار بالای صفحه: هویت طلالایو، وضعیت ارتباط با سرور و ساعت زنده --}}
        <header class="tv-topbar">
            <div class="tv-brand">
                <div class="tv-logo-wrap">
                    <img src="{{ asset('images/logo.png') }}?v=2" alt="طلالایو">
                </div>
                <div>
                    <h1 class="tv-brand-title">طلالایو · راه‌اندازی تابلوی تلویزیون</h1>
                    <p class="tv-brand-sub">اتصال مستقیم و دائمی نمایشگر مغازه بدون نیاز به کیس یا کابل</p>
                </div>
            </div>

            <div class="tv-meta-bar">
                <div id="statusBadge" class="tv-status-pill" aria-live="polite">
                    <span class="tv-status-dot"></span>
                    <span id="statusText">در حال دریافت کد از سرور...</span>
                </div>
                <div id="tvClock" class="tv-clock">--:--</div>
            </div>
        </header>

        {{-- راهنمای ویژه کاربرانی که به‌اشتباه صفحه تلویزیون را در گوشی باز کرده‌اند --}}
        <section class="mobile-hint-banner" aria-label="راهنمای استفاده در موبایل">
            <p class="mobile-hint-title">این صفحه مخصوص نمایشگر تلویزیون مغازه است</p>
            <p class="mobile-hint-text">
                آدرس <strong dir="ltr">talalive.ir/tv</strong> را در مرورگر تلویزیون مغازه باز کنید و سپس کد ۶ رقمی نمایش‌داده‌شده روی تلویزیون را در پنل گوشی خود وارد نمایید.
            </p>
            <a href="{{ auth()->check() ? route('admin.devices.index') : route('admin.login') }}" class="mobile-hint-btn">
                ورود به پنل گوشی برای ثبت کد تلویزیون
            </a>
        </section>

        {{-- صحنه اصلی دو ستونه: کد ۶ رقمی + اسکن بارکد محلی --}}
        <section class="tv-stage" aria-label="روش‌های اتصال تلویزیون">
            {{-- روش اول: کد عددی ۶ رقمی --}}
            <div class="tv-card tv-card-code">
                <div>
                    <span class="tv-method-tag">روش ۱ · سریع‌ترین اتصال با کد ۶ رقمی</span>
                    <h2 class="tv-card-heading">کد زیر را در پنل گوشی خود وارد کنید</h2>
                    <ul class="tv-steps-list">
                        <li>۱. در گوشی موبایل وارد سایت <strong>talalive.ir</strong> شوید (بخش داشبورد یا تلویزیون‌های من).</li>
                        <li>۲. کد ۶ رقمی زیر را وارد کنید تا تابلوی زنده گالری فوراً روی همین صفحه باز شود.</li>
                    </ul>
                </div>

                <div class="tv-code-well">
                    <div class="tv-code-sub">کد اتصال اختصاصی این تلویزیون</div>
                    <div id="activationCode" class="tv-code-digits is-loading" aria-live="polite">--- ---</div>
                    <div id="codeSubStatus" class="tv-code-sub">در حال دریافت کد معتبر از سرور...</div>
                </div>

                <div class="tv-support-line">
                    <span>پس از اتصال، با خاموش و روشن کردن تلویزیون دیگر نیازی به ثبت مجدد کد نیست.</span>
                    <span>پشتیبانی تلفنی: <span class="tv-support-phone">0918-700-9064</span></span>
                </div>
            </div>

            {{-- روش دوم: بارکد QR تولیدشده به صورت ۱۰۰٪ محلی و آفلاین --}}
            <div class="tv-card tv-card-qr">
                <div>
                    <span class="tv-method-tag">روش ۲ · اسکن با دوربین گوشی</span>
                    <h2 class="tv-card-heading">یا بارکد زیر را اسکن کنید</h2>
                </div>

                <div class="tv-qr-whitebox">
                    <div id="qrContainer" class="tv-qr-target" aria-label="بارکد اتصال تلویزیون"></div>
                    <div id="qrLoader" class="tv-qr-loader">
                        <div class="tv-spinner"></div>
                        <span id="qrLoaderText">در حال ساخت بارکد...</span>
                    </div>
                </div>

                <div>
                    <p style="margin: 0 0 8px; font-size: 13px; color: #d6d3d1;">
                        دوربین گوشی یا اسکنر داخل پنل طلالایو را روبه‌روی بارکد بگیرید
                    </p>
                    <div id="shortPairUrl" class="tv-short-url">talalive.ir/p/------</div>
                </div>
            </div>
        </section>

        {{-- نوار دکمه‌های سازگار با کنترل تلویزیون (D-Pad Focusable) --}}
        <footer class="tv-actions">
            <div class="tv-btn-group">
                <button type="button" id="refreshCodeBtn" class="tv-btn tv-btn-primary" tabindex="0">
                    دریافت کد جدید
                </button>
                <a href="{{ url('/demo') }}" id="demoBoardBtn" class="tv-btn" tabindex="0">
                    مشاهده تابلوی نمونه
                </a>
                <a href="{{ url('/?home=1') }}" id="homeSiteBtn" class="tv-btn" tabindex="0">
                    صفحه اصلی سایت
                </a>
            </div>
            <div class="tv-remote-hint">
                برای جابه‌جایی بین گزینه‌ها از دکمه‌های جهت کنترل تلویزیون و تایید (OK) استفاده کنید.
            </div>
        </footer>
    </main>

    {{-- لایه تایید نهایی هنگام جفت‌سازی موفق --}}
    <div id="pairedSuccessOverlay" class="tv-paired-overlay" role="status" aria-live="assertive">
        <div class="tv-paired-box">
            <div class="tv-paired-icon" aria-hidden="true">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <h2 style="margin: 0 0 10px; font-size: 24px; font-weight: 800; color: #ffffff;">
                تلویزیون با موفقیت متصل شد
            </h2>
            <p id="pairedShopLabel" style="margin: 0; font-size: 15px; line-height: 1.7; color: #a7f3d0;">
                در حال باز کردن تابلوی زنده گالری...
            </p>
        </div>
    </div>

    {{-- موتور اتصال خالص ES5 سازگار با تمامی مرورگرهای تلویزیون هوشمند (2015 تا 2026) --}}
    <script>
        (function () {
            var sessionCode = '';
            var activationCode = '';
            var pollTimer = null;
            var retryTimer = null;
            var renewTimer = null;
            var registerXhr = null;
            var checkXhr = null;
            var isChecking = false;
            var isPairedDone = false;
            var requestSeq = 0;

            var codeEl = document.getElementById('activationCode');
            var codeSubEl = document.getElementById('codeSubStatus');
            var statusBadgeEl = document.getElementById('statusBadge');
            var statusTextEl = document.getElementById('statusText');
            var qrContainerEl = document.getElementById('qrContainer');
            var qrLoaderEl = document.getElementById('qrLoader');
            var qrLoaderTextEl = document.getElementById('qrLoaderText');
            var shortUrlEl = document.getElementById('shortPairUrl');
            var clockEl = document.getElementById('tvClock');
            var overlayEl = document.getElementById('pairedSuccessOverlay');
            var shopLabelEl = document.getElementById('pairedShopLabel');
            var refreshBtn = document.getElementById('refreshCodeBtn');
            var demoBtn = document.getElementById('demoBoardBtn');
            var homeBtn = document.getElementById('homeSiteBtn');

            function padTwo(n) {
                return n < 10 ? '0' + n : String(n);
            }

            function updateClock() {
                if (!clockEl) return;
                var d = new Date();
                clockEl.innerHTML = padTwo(d.getHours()) + ':' + padTwo(d.getMinutes());
            }

            function formatDisplayCode(code) {
                var clean = String(code || '').replace(/\s+/g, '');
                if (clean.length === 6) {
                    return clean.substring(0, 3) + ' ' + clean.substring(3, 6);
                }
                return clean || '--- ---';
            }

            function setStatus(state, text) {
                if (statusBadgeEl) {
                    statusBadgeEl.className = 'tv-status-pill' + (state === 'ready' ? ' is-ready' : (state === 'error' ? ' is-error' : ''));
                }
                if (statusTextEl) {
                    statusTextEl.innerHTML = text;
                }
            }

            function renderLocalQrSvg(targetUrl) {
                if (!qrContainerEl) return;
                if (typeof window.qrcode !== 'function') {
                    qrContainerEl.innerHTML = '<div style="padding:12px;color:#0f172a;font-size:13px;font-weight:700;text-align:center;">اسکنر محلی بارگذاری نشد. از کد ۶ رقمی سمت راست استفاده کنید.</div>';
                    if (qrLoaderEl) qrLoaderEl.style.display = 'none';
                    return;
                }

                try {
                    var qr = window.qrcode(0, 'M');
                    qr.addData(targetUrl, 'Byte');
                    qr.make();
                    var count = qr.getModuleCount();
                    var pad = 2;
                    var size = count + pad * 2;
                    var pathParts = [];
                    for (var r = 0; r < count; r++) {
                        for (var c = 0; c < count; c++) {
                            if (qr.isDark(r, c)) {
                                pathParts.push('M' + (c + pad) + ',' + (r + pad) + 'h1v1h-1z');
                            }
                        }
                    }
                    qrContainerEl.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' + size + ' ' + size + '" shape-rendering="crispEdges" role="img" aria-label="QR"><rect width="100%" height="100%" fill="#ffffff"/><path d="' + pathParts.join('') + '" fill="#09090b"/></svg>';
                    if (qrLoaderEl) {
                        qrLoaderEl.style.display = 'none';
                    }
                } catch (e) {
                    qrContainerEl.innerHTML = qr.createTableTag ? qr.createTableTag(5, 8) : '<div style="color:#09090b;font-weight:700;">QR</div>';
                    if (qrLoaderEl) {
                        qrLoaderEl.style.display = 'none';
                    }
                }
            }

            function clearTimers() {
                if (pollTimer) {
                    clearInterval(pollTimer);
                    pollTimer = null;
                }
                if (retryTimer) {
                    clearTimeout(retryTimer);
                    retryTimer = null;
                }
                if (renewTimer) {
                    clearTimeout(renewTimer);
                    renewTimer = null;
                }
            }

            function checkPairing() {
                if (isPairedDone || !sessionCode || isChecking) return;
                isChecking = true;

                try {
                    checkXhr = new XMLHttpRequest();
                    checkXhr.open('GET', '/api/tv/check/' + encodeURIComponent(sessionCode) + '?_t=' + new Date().getTime(), true);
                    checkXhr.timeout = 8000;
                    checkXhr.setRequestHeader('Accept', 'application/json');

                    checkXhr.onreadystatechange = function () {
                        if (checkXhr.readyState !== 4) return;
                        isChecking = false;

                        if (checkXhr.status < 200 || checkXhr.status >= 300) return;

                        var data = null;
                        try {
                            data = JSON.parse(checkXhr.responseText);
                        } catch (e) {
                            data = null;
                        }

                        if (data && data.paired && data.username && (data.display_token || data.token)) {
                            isPairedDone = true;
                            clearTimers();

                            var finalDisplayToken = data.display_token || data.token;
                            var finalDeviceToken = data.device_token || data.token || '';

                            try {
                                localStorage.setItem('display_username', data.username);
                                localStorage.setItem('display_token', finalDisplayToken);
                                if (finalDeviceToken) {
                                    localStorage.setItem('tv_device_token', finalDeviceToken);
                                    localStorage.setItem('tv_device_username', data.username);
                                }
                                sessionStorage.removeItem('skip_redirect');
                            } catch (e2) {}

                            document.cookie = 'display_token=' + encodeURIComponent(finalDisplayToken) + '; path=/; max-age=31536000';

                            setStatus('ready', 'متصل شد');
                            if (shopLabelEl) {
                                shopLabelEl.innerHTML = 'گالری <strong dir="ltr">@' + String(data.username).replace(/</g, '&lt;') + '</strong> متصل گردید. در حال باز کردن تابلوی زنده...';
                            }
                            if (overlayEl) {
                                overlayEl.className = 'tv-paired-overlay is-visible';
                            }

                            setTimeout(function () {
                                window.location.replace('/' + encodeURIComponent(data.username) + '?key=' + encodeURIComponent(finalDisplayToken) + '&tv=1&paired=1');
                            }, 650);
                        }
                    };

                    checkXhr.ontimeout = function () {
                        isChecking = false;
                    };

                    checkXhr.onerror = function () {
                        isChecking = false;
                    };

                    checkXhr.send();
                } catch (err) {
                    isChecking = false;
                }
            }

            function scheduleRetry() {
                setStatus('error', 'اختلال شبکه · تلاش مجدد...');
                if (codeEl) {
                    codeEl.className = 'tv-code-digits is-loading';
                    codeEl.innerHTML = '--- ---';
                }
                if (codeSubEl) {
                    codeSubEl.innerHTML = 'ارتباط با سرور برقرار نشد. تلاش مجدد خودکار تا ۴ ثانیه دیگر...';
                }
                if (qrLoaderTextEl) {
                    qrLoaderTextEl.innerHTML = 'در انتظار اتصال به سرور...';
                }
                retryTimer = setTimeout(function () {
                    registerTvSession();
                }, 4000);
            }

            function registerTvSession() {
                if (isPairedDone) return;

                requestSeq += 1;
                var mySeq = requestSeq;

                clearTimers();
                isChecking = false;

                if (registerXhr && registerXhr.readyState !== 4) {
                    try { registerXhr.abort(); } catch (e) {}
                }
                if (checkXhr && checkXhr.readyState !== 4) {
                    try { checkXhr.abort(); } catch (e2) {}
                }

                setStatus('loading', 'در حال دریافت کد از سرور...');
                if (codeEl) {
                    codeEl.className = 'tv-code-digits is-loading';
                    codeEl.innerHTML = '--- ---';
                }
                if (codeSubEl) {
                    codeSubEl.innerHTML = 'در حال دریافت کد معتبر از سرور...';
                }
                if (qrLoaderEl) {
                    qrLoaderEl.style.display = 'flex';
                }
                if (qrLoaderTextEl) {
                    qrLoaderTextEl.innerHTML = 'در حال ساخت بارکد...';
                }

                try {
                    registerXhr = new XMLHttpRequest();
                    registerXhr.open('POST', '/api/tv/register-session?_t=' + new Date().getTime(), true);
                    registerXhr.timeout = 10000;
                    registerXhr.setRequestHeader('Content-Type', 'application/json');
                    registerXhr.setRequestHeader('Accept', 'application/json');

                    registerXhr.onreadystatechange = function () {
                        if (registerXhr.readyState !== 4 || mySeq !== requestSeq) return;

                        if (registerXhr.status < 200 || registerXhr.status >= 300) {
                            scheduleRetry();
                            return;
                        }

                        var res = null;
                        try {
                            res = JSON.parse(registerXhr.responseText);
                        } catch (parseErr) {
                            res = null;
                        }

                        if (!res || !res.success || !res.activation_code || !res.session_code) {
                            scheduleRetry();
                            return;
                        }

                        sessionCode = String(res.session_code);
                        activationCode = String(res.activation_code);

                        if (codeEl) {
                            codeEl.className = 'tv-code-digits';
                            codeEl.innerHTML = formatDisplayCode(activationCode);
                        }
                        if (codeSubEl) {
                            codeSubEl.innerHTML = 'کد فعال است · تمدید خودکار هر ۹۰ دقیقه';
                        }
                        if (shortUrlEl) {
                            shortUrlEl.innerHTML = window.location.host + '/p/' + activationCode;
                        }

                        var pairLink = window.location.origin + '/p/' + encodeURIComponent(activationCode);
                        renderLocalQrSvg(pairLink);
                        setStatus('ready', 'آماده اتصال به گوشی');

                        var pollMs = (res.poll_interval_seconds ? Number(res.poll_interval_seconds) : 3) * 1000;
                        if (pollMs < 2000) pollMs = 3000;

                        pollTimer = setInterval(checkPairing, pollMs);

                        // تمدید خودکار پیش از انقضای سشن ۲ ساعته
                        renewTimer = setTimeout(function () {
                            if (!isPairedDone) {
                                registerTvSession();
                            }
                        }, 5400000);
                    };

                    registerXhr.ontimeout = function () {
                        if (mySeq === requestSeq) {
                            scheduleRetry();
                        }
                    };

                    registerXhr.onerror = function () {
                        if (mySeq === requestSeq) {
                            scheduleRetry();
                        }
                    };

                    registerXhr.send('{}');
                } catch (err) {
                    scheduleRetry();
                }
            }

            // پشتیبانی کامل از جهت‌های کنترل تلویزیون (D-Pad Navigation)
            function setupRemoteNavigation() {
                var navButtons = [];
                if (refreshBtn) navButtons.push(refreshBtn);
                if (demoBtn) navButtons.push(demoBtn);
                if (homeBtn) navButtons.push(homeBtn);

                if (refreshBtn) {
                    refreshBtn.onclick = function () {
                        registerTvSession();
                    };
                }

                document.addEventListener('keydown', function (e) {
                    var key = e.key || '';
                    var code = e.keyCode || 0;
                    var currentIndex = -1;
                    for (var i = 0; i < navButtons.length; i++) {
                        if (document.activeElement === navButtons[i]) {
                            currentIndex = i;
                            break;
                        }
                    }

                    // چپ یا پایین: حرکت به دکمه بعدی در چیدمان راست‌به‌چپ
                    if (key === 'ArrowLeft' || key === 'ArrowDown' || code === 37 || code === 40) {
                        if (navButtons.length > 0) {
                            e.preventDefault();
                            var nextIdx = currentIndex === -1 ? 0 : (currentIndex + 1) % navButtons.length;
                            navButtons[nextIdx].focus();
                        }
                    } else if (key === 'ArrowRight' || key === 'ArrowUp' || code === 39 || code === 38) {
                        if (navButtons.length > 0) {
                            e.preventDefault();
                            var prevIdx = currentIndex === -1 ? 0 : (currentIndex - 1 + navButtons.length) % navButtons.length;
                            navButtons[prevIdx].focus();
                        }
                    }
                });
            }

            updateClock();
            setInterval(updateClock, 15000);
            setupRemoteNavigation();
            registerTvSession();
        })();
    </script>
</body>
</html>
