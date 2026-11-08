@extends('layouts.public')

@section('title', 'مستندات وب‌سرویس عمومی و API نرخ لحظه‌ای طلا و سکه | طلالایو')
@section('meta_description', 'مستندات جامع وب‌سرویس RESTful طلالایو برای دریافت لحظه‌ای قیمت طلای ۱۸ عیار، مظنه مثقال، انواع سکه و ارز. نمونه کدهای cURL، پایتون، PHP و جاوااسکریپت همراه با قوانین مصرف رایگان.')
@section('canonical', 'https://talalive.ir/api-docs')

@push('styles')
<style>
    .code-box {
        direction: ltr;
        text-align: left;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 0.875rem;
    }
    .tab-btn.active {
        background-color: #f59e0b;
        color: #0c0a09;
        font-weight: 800;
    }
</style>
@endpush

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-12">
    <!-- Breadcrumb -->
    <nav class="flex items-center text-xs text-stone-500 space-x-2 space-x-reverse" aria-label="مسیر راهنما">
        <a href="/" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">صفحه اصلی</a>
        <span>/</span>
        <span class="text-amber-600 dark:text-amber-400">مستندات وب‌سرویس (API)</span>
    </nav>

    <!-- Header -->
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold bg-amber-500/10 text-amber-700 dark:text-amber-300 border border-amber-500/20">
            <x-ui-icon name="code" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
            <span>RESTful API v1.0 • دسترسی آزاد و رایگان</span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-stone-900 dark:text-white leading-tight">
            مستندات وب‌سرویس (API) رایگان نرخ لحظه‌ای طلا و سکه
        </h1>
        <p class="text-base text-stone-600 dark:text-stone-300 leading-relaxed">
            با اتصال به API زنده طلالایو، آخرین نرخ‌های مظنه مثقال آبشده، طلای ۱۸ و ۲۴ عیار، انواع مسکوکات بانکی و ارزهای پایه را با بالاترین سرعت و دقت در پروژه‌ها، اپلیکیشن‌ها و سامانه‌های حسابداری خود نمایش دهید.
        </p>
    </div>

    <!-- Quick Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 text-center shadow-sm">
            <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-stone-700 dark:text-stone-300">
                <x-ui-icon name="bolt" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
            </div>
            <h2 class="text-xs font-bold text-stone-500 dark:text-stone-400 mb-1">فرمت خروجی</h2>
            <p class="text-sm font-bold text-stone-900 dark:text-white">JSON استاندارد (UTF-8)</p>
        </div>
        <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 text-center shadow-sm">
            <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-stone-700 dark:text-stone-300">
                <x-ui-icon name="shield" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
            </div>
            <h2 class="text-xs font-bold text-stone-500 dark:text-stone-400 mb-1">احراز هویت</h2>
            <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">عمومی / بدون توکن (v1)</p>
        </div>
        <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 text-center shadow-sm">
            <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-stone-700 dark:text-stone-300">
                <x-ui-icon name="clock" class="w-5 h-5 text-stone-700 dark:text-stone-300" />
            </div>
            <h2 class="text-xs font-bold text-stone-500 dark:text-stone-400 mb-1">محدودیت نرخ (Rate Limit)</h2>
            <p class="text-sm font-bold text-stone-900 dark:text-white tabular-nums">۶۰ درخواست در دقیقه</p>
        </div>
        <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-2xl p-5 text-center shadow-sm">
            <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-stone-700 dark:text-stone-300">
                <x-ui-icon name="globe" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
            </div>
            <h2 class="text-xs font-bold text-stone-500 dark:text-stone-400 mb-1">پشتیبانی CORS</h2>
            <p class="text-sm font-bold text-amber-600 dark:text-amber-400">فعال (Access-Control: *)</p>
        </div>
    </div>

    <!-- Endpoint Section -->
    <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-stone-200 dark:border-stone-800">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 text-sm font-black rounded-xl border border-emerald-500/30">
                    GET
                </span>
                <span class="text-lg sm:text-xl font-mono text-stone-900 dark:text-white select-all">
                    /api/v1/rates
                </span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <span class="text-xs text-stone-500 dark:text-stone-400">وضعیت سرور: فعال و آنلاین</span>
            </div>
        </div>

        <div class="space-y-3">
            <h2 class="text-xl font-bold text-stone-900 dark:text-white">شرح عملکرد اندپوینت</h2>
            <p class="text-stone-600 dark:text-stone-300 text-sm leading-relaxed">
                این متد آخرین نرخ‌های بازار طلا و جواهر تهران را شامل قیمت هر گرم طلای ۱۸ عیار، ۲۴ عیار، مظنه مثقال ۱۷ عیار، انس جهانی طلا، تمام سکه امامی و بهار آزادی، نیم سکه، ربع سکه، سکه گرمی و نرخ‌های تتر (دلار دیجیتال)، نفت برنت، انس نقره و مظنه جهانی بازمی‌گرداند. کلیه مبالغ ریالی به واحد تومان محاسبه و اعلام شده‌اند.
            </p>
        </div>

        <div>
            <h3 class="text-sm font-bold text-stone-900 dark:text-white mb-1">پارامترهای ورودی (Query Parameters):</h3>
            <p class="text-xs text-stone-500 dark:text-stone-400">
                این اندپوینت در نسخه ۱ به هیچ پارامتر اجباری یا اختیاری نیاز ندارد و خروجی کامل بسته‌ی قیمتی را تحویل می‌دهد.
            </p>
        </div>

        <div>
            <h3 class="text-sm font-bold text-stone-900 dark:text-white mb-2">هدرهای استاندارد پاسخ (Response Headers):</h3>
            <div class="bg-stone-950 rounded-2xl p-4 code-box text-stone-300 border border-stone-800 text-xs">
                <code>
                    Content-Type: application/json; charset=utf-8<br>
                    Access-Control-Allow-Origin: *<br>
                    Cache-Control: public, max-age=15<br>
                    X-RateLimit-Limit: 60<br>
                    X-RateLimit-Remaining: 59
                </code>
            </div>
        </div>

        <!-- Response Sample -->
        <div class="space-y-3 pt-2">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-stone-900 dark:text-white">نمونه خروجی واقعی (JSON Response 200 OK):</h3>
                <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('sample-json').innerText); this.innerText='کپی شد'; setTimeout(() => this.innerText='کپی JSON', 2000);" class="text-xs px-3 py-1.5 bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-800 dark:text-stone-200 rounded-xl transition-colors font-bold min-h-11 inline-flex items-center">
                    کپی JSON
                </button>
            </div>
            <pre id="sample-json" class="bg-stone-950 p-5 rounded-2xl border border-stone-800 text-emerald-400 code-box overflow-x-auto text-xs leading-relaxed max-h-96"><code>{
  "status": "success",
  "attribution": {
    "provider": "سامانه تابلوی طلای آنلاین طلالایو",
    "website": "https://talalive.ir",
    "terms": "استفاده از این وب‌سرویس منوط به درج لینک مستقیم و فعال به talalive.ir به عنوان منبع داده است."
  },
  "rate_limits": {
    "allowed_requests_per_minute": 60,
    "throttle_policy": "IP-based sliding window"
  },
  "timestamp": "{{ now()->toIso8601String() }}",
  "api_time": "لحظه‌ای",
  "currency": "IRR (Toman)",
  "data": {
    "gold": {
      "gram_18k": {
        "name": "طلای ۱۸ عیار (گرم)",
        "price": {{ $rates['gold18'] ?: 3650000 }},
        "unit": "تومان"
      },
      "gram_24k": {
        "name": "طلای ۲۴ عیار (گرم)",
        "price": {{ $rates['gold24'] ?: 4866667 }},
        "unit": "تومان"
      },
      "mesghal_17k": {
        "name": "آبشده",
        "price": {{ $rates['mesghal'] ?: 15800000 }},
        "unit": "تومان"
      },
      "ounce_global": {
        "name": "انس جهانی طلا",
        "price": {{ $rates['ons'] ?: 2720 }},
        "unit": "دلار"
      }
    },
    "coins": {
      "emami": {
        "name": "سکه تمام طرح جدید (امامی)",
        "price": {{ $rates['coin_emami'] ?: 43500000 }},
        "unit": "تومان"
      },
      "bahar": {
        "name": "سکه تمام بهار آزادی (طرح قدیم)",
        "price": {{ $rates['coin_bahar'] ?: 39800000 }},
        "unit": "تومان"
      },
      "half": {
        "name": "نیم سکه بهار آزادی",
        "price": {{ $rates['coin_nim'] ?: 23800000 }},
        "unit": "تومان"
      },
      "quarter": {
        "name": "ربع سکه بهار آزادی",
        "price": {{ $rates['coin_rob'] ?: 15200000 }},
        "unit": "تومان"
      },
      "gerami": {
        "name": "سکه گرمی",
        "price": {{ $rates['coin_gerami'] ?: 7200000 }},
        "unit": "تومان"
      }
    },
    "commodities": {
      "usdt": {
        "name": "تتر (دلار دیجیتال)",
        "price": {{ $rates['usdt'] ?: 89500 }},
        "unit": "تومان"
      },
      "oil_brent": {
        "name": "نفت برنت",
        "price": {{ $rates['oil_brent'] ?: 98.32 }},
        "unit": "دلار"
      },
      "silver_ounce": {
        "name": "انس جهانی نقره",
        "price": {{ $rates['silver_ounce'] ?: 31.45 }},
        "unit": "دلار"
      },
      "global_mesghal": {
        "name": "مظنه جهانی طلا",
        "price": {{ $rates['global_mesghal'] ?: 26150000 }},
        "unit": "تومان"
      }
    }
  }
}</code></pre>
        </div>
    </div>

    <!-- Code Examples -->
    <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-white mb-2">نمونه کدهای اتصال در زبان‌های مختلف</h2>
            <p class="text-stone-600 dark:text-stone-400 text-sm">
                برای اتصال سریع، کدهای تست‌شده زیر را مستقیماً در پروژه خود کپی و اجرا نمایید:
            </p>
        </div>

        <div class="flex flex-wrap gap-2 border-b border-stone-200 dark:border-stone-800 pb-3">
            <button onclick="showCodeTab('curl')" id="tab-btn-curl" class="tab-btn active px-4 py-2 text-xs font-bold rounded-xl bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-stone-200 dark:hover:bg-stone-700 transition-colors min-h-11">cURL</button>
            <button onclick="showCodeTab('js')" id="tab-btn-js" class="tab-btn px-4 py-2 text-xs font-bold rounded-xl bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-stone-200 dark:hover:bg-stone-700 transition-colors min-h-11">JavaScript</button>
            <button onclick="showCodeTab('python')" id="tab-btn-python" class="tab-btn px-4 py-2 text-xs font-bold rounded-xl bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-stone-200 dark:hover:bg-stone-700 transition-colors min-h-11">Python</button>
            <button onclick="showCodeTab('php')" id="tab-btn-php" class="tab-btn px-4 py-2 text-xs font-bold rounded-xl bg-stone-100 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-stone-200 dark:hover:bg-stone-700 transition-colors min-h-11">PHP</button>
        </div>

        <!-- cURL snippet -->
        <div id="code-curl" class="code-tab-panel">
            <pre class="bg-stone-950 p-4 rounded-2xl border border-stone-800 text-amber-300 code-box overflow-x-auto text-xs leading-relaxed"><code>curl -X GET "https://talalive.ir/api/v1/rates" \
     -H "Accept: application/json"</code></pre>
        </div>

        <!-- JS snippet -->
        <div id="code-js" class="code-tab-panel hidden">
            <pre class="bg-stone-950 p-4 rounded-2xl border border-stone-800 text-amber-200 code-box overflow-x-auto text-xs leading-relaxed"><code>async function fetchGoldRates() {
    try {
        const response = await fetch('https://talalive.ir/api/v1/rates');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        console.log('قیمت طلای ۱۸ عیار:', result.data.gold.gram_18k.price);
        console.log('سکه امامی:', result.data.coins.emami.price);
        return result.data;
    } catch (error) {
        console.error('خطا در دریافت نرخ:', error);
    }
}

fetchGoldRates();</code></pre>
        </div>

        <!-- Python snippet -->
        <div id="code-python" class="code-tab-panel hidden">
            <pre class="bg-stone-950 p-4 rounded-2xl border border-stone-800 text-emerald-300 code-box overflow-x-auto text-xs leading-relaxed"><code>import requests

url = "https://talalive.ir/api/v1/rates"
headers = {"Accept": "application/json"}

try:
    response = requests.get(url, headers=headers, timeout=10)
    response.raise_for_status()
    data = response.json()
    
    gold_18k = data["data"]["gold"]["gram_18k"]["price"]
    coin_emami = data["data"]["coins"]["emami"]["price"]
    
    print(f"هر گرم طلای ۱۸ عیار: {gold_18k:,} تومان")
    print(f"سکه طرح جدید: {coin_emami:,} تومان")
except requests.exceptions.RequestException as e:
    print(f"خطا در برقراری ارتباط: {e}")</code></pre>
        </div>

        <!-- PHP snippet -->
        <div id="code-php" class="code-tab-panel hidden">
            <pre class="bg-stone-950 p-4 rounded-2xl border border-stone-800 text-stone-200 code-box overflow-x-auto text-xs leading-relaxed"><code>&lt;?php

$url = 'https://talalive.ir/api/v1/rates';
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
if ($result && $result['status'] === 'success') {
    $gold18k = $result['data']['gold']['gram_18k']['price'];
    echo "طلای ۱۸ عیار: " . number_format($gold18k) . " تومان";
}</code></pre>
        </div>
    </div>

    <!-- Terms of Service & Attribution Requirements -->
    <div class="bg-stone-100 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-4">
        <h2 class="text-xl font-bold text-stone-900 dark:text-white flex items-center gap-2">
            <x-ui-icon name="scale" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
            <span>شرایط استفاده، محدودیت‌ها و الزام درج منبع</span>
        </h2>
        <div class="space-y-4 text-stone-700 dark:text-stone-300 text-sm leading-relaxed">
            <p>
                دسترسی به API نرخ طلالایو برای کلیه توسعه‌دهندگان، استارتاپ‌ها، سامانه‌های حسابداری طلافروشی و وب‌سایت‌های خبری آزاد و رایگان است؛ مشروط به رعایت مفاد زیر:
            </p>
            <ul class="list-disc list-inside space-y-2 text-stone-600 dark:text-stone-300 pr-2">
                <li><strong class="text-stone-900 dark:text-white">الزام ذکر منبع با لینک فعال:</strong> در صورت استفاده از داده‌های این وب‌سرویس در صفحات وب یا اپلیکیشن‌ها، درج عنوان و لینک فعال مستقیم به <a href="https://talalive.ir" class="text-amber-600 dark:text-amber-400 font-semibold underline underline-offset-4 hover:underline">طلالایو (talalive.ir)</a> با عنوان «منبع قیمت: طلالایو» یا «منبع داده: سامانه تابلوی طلای آنلاین طلالایو» الزامی است.</li>
                <li><strong class="text-stone-900 dark:text-white">سقف درخواست مجاز:</strong> حداکثر سقف مجاز برای هر آی‌پی (IP Address)، ۶۰ فراخوانی در هر دقیقه می‌باشد. سیستم به طور خودکار درخواست‌های فراتر از این سقف را با خطای <code>HTTP 429 Too Many Requests</code> متوقف خواهد کرد.</li>
                <li><strong class="text-stone-900 dark:text-white">کش کردن داده‌ها در سمت سرور مصرف‌کننده:</strong> توصیه اکید می‌شود داده‌های دریافتی را حداقل به مدت ۱۵ الی ۳۰ ثانیه در سرور خود کش (Cache) کنید تا از ارسال درخواست‌های غیرضروری و مسدود شدن آی‌پی سرور جلوگیری شود.</li>
                <li><strong class="text-stone-900 dark:text-white">ممنوعیت رفتارهای تهاجمی:</strong> هرگونه تلاش برای مهندسی معکوس، حملات Denial-of-Service یا فرار از محدودیت نرخ موجب مسدودسازی دائمی دسترسی آی‌پی یا رنج آی‌پی خواهد شد.</li>
            </ul>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
        <h2 class="text-xl sm:text-2xl font-black text-stone-900 dark:text-white">سؤالات متداول توسعه‌دهندگان درباره API طلالایو</h2>
        <div class="space-y-4 text-stone-700 dark:text-stone-300">
            <details class="group p-4 rounded-2xl bg-stone-50 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-800 cursor-pointer">
                <summary class="font-bold text-stone-900 dark:text-white text-sm list-none flex items-center justify-between">
                    <span>۱. آیا برای استفاده از API به ساخت حساب کاربری یا API Key نیاز است؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform">▼</span>
                </summary>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed mt-3 pt-3 border-t border-stone-200 dark:border-stone-700">
                    خیر؛ نسخه ۱ این وب‌سرویس به‌صورت کاملاً باز و بدون نیاز به کلید دسترسی ارائه شده است. شما می‌توانید مستقیماً از اندپوینت <code>/api/v1/rates</code> استفاده نمایید.
                </p>
            </details>
            <details class="group p-4 rounded-2xl bg-stone-50 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-800 cursor-pointer">
                <summary class="font-bold text-stone-900 dark:text-white text-sm list-none flex items-center justify-between">
                    <span>۲. نرخ‌ها در این API در چه فواصل زمانی به‌روزرسانی می‌شوند؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform">▼</span>
                </summary>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed mt-3 pt-3 border-t border-stone-200 dark:border-stone-700">
                    سامانه طلالایو قیمت‌های صنف طلا را از ساعت ۱۰:۳۰ صبح همزمان با گشایش بازار سبزه میدان و اتحادیه‌های مرجع به صورت میلی‌ثانیه‌ای دریافت و در کش توزیع‌شده با طول عمر ۱۵ ثانیه نگهداری می‌کند.
                </p>
            </details>
            <details class="group p-4 rounded-2xl bg-stone-50 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-800 cursor-pointer">
                <summary class="font-bold text-stone-900 dark:text-white text-sm list-none flex items-center justify-between">
                    <span>۳. اگر نیاز به وب‌سرویس اختصاصی یا خروجی با وب‌سوکت داشته باشیم چه کنیم؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform">▼</span>
                </summary>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed mt-3 pt-3 border-t border-stone-200 dark:border-stone-700">
                    توسعه‌دهندگان و شرکت‌های صرافی یا نرم‌افزاری که نیازمند ترافیک بالا، وب‌سوکت زنده یا داده‌های تاریخی هستند، می‌توانند از طریق <a href="{{ route('public.contact') }}" class="text-amber-600 dark:text-amber-400 underline">صفحه تماس با ما</a> درخواست خود را برای دریافت پنل تجاری سازمانی ثبت نمایند.
                </p>
            </details>
            <details class="group p-4 rounded-2xl bg-stone-50 dark:bg-stone-800/60 border border-stone-200 dark:border-stone-800 cursor-pointer">
                <summary class="font-bold text-stone-900 dark:text-white text-sm list-none flex items-center justify-between">
                    <span>۴. آیا امکان استفاده از ویجت آماده به جای کدنویسی API وجود دارد؟</span>
                    <span class="text-stone-400 group-open:rotate-180 transition-transform">▼</span>
                </summary>
                <p class="text-xs sm:text-sm text-stone-600 dark:text-stone-400 leading-relaxed mt-3 pt-3 border-t border-stone-200 dark:border-stone-700">
                    بله؛ اگر تمایل به برنامه‌نویسی اختصاصی ندارید، می‌توانید با مراجعه به <a href="{{ route('public.widget') }}" class="text-amber-600 dark:text-amber-400 underline">سازنده ویجت آنلاین طلالایو</a> تنها با یک خط کد آی‌فریم، تابلوی زنده قیمت طلا را در سایت یا وبلاگ وردپرسی خود قرار دهید.
                </p>
            </details>
        </div>
    </div>

    <!-- Related Links & CTA -->
    <div class="bg-stone-50 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-3xl p-8 text-center shadow-sm space-y-6">
        <h2 class="text-xl font-bold text-stone-900 dark:text-white">سایر ابزارها و خدمات دیجیتال طلالایو</h2>
        <p class="text-stone-600 dark:text-stone-400 text-sm max-w-xl mx-auto leading-relaxed">
            علاوه بر وب‌سرویس توسعه‌دهندگان، طلالایو راهکارهای هوشمند تابلوی مغازه طلافروشی و ماشین‌حساب‌های صنفی پیشرفته را در اختیارتان می‌گذارد:
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('public.widget') }}" class="min-h-11 inline-flex items-center justify-center px-5 py-2.5 bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-800 dark:text-stone-200 rounded-2xl text-xs font-bold transition-colors">
                دریافت کد ویجت طلای سایت
            </a>
            <a href="{{ route('public.tools.gold-price') }}" class="min-h-11 inline-flex items-center justify-center px-5 py-2.5 bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-800 dark:text-stone-200 rounded-2xl text-xs font-bold transition-colors">
                ماشین‌حساب فاکتور طلا
            </a>
            <a href="{{ route('public.smart-gold-board') }}" class="min-h-11 inline-flex items-center justify-center px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-stone-950 rounded-2xl text-xs font-black transition-colors shadow-sm">
                آشنایی با تابلوی طلافروشی
            </a>
            <a href="{{ route('public.contact') }}" class="min-h-11 inline-flex items-center justify-center px-5 py-2.5 bg-white dark:bg-stone-800 hover:bg-stone-100 dark:hover:bg-stone-700 text-stone-700 dark:text-stone-300 border border-stone-300 dark:border-stone-700 rounded-2xl text-xs font-bold transition-colors">
                پشتیبانی فنی و تماس
            </a>
        </div>
    </div>
</div>

<script>
function showCodeTab(tab) {
    document.querySelectorAll('.code-tab-panel').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    
    const panel = document.getElementById('code-' + tab);
    const btn = document.getElementById('tab-btn-' + tab);
    if (panel) panel.classList.remove('hidden');
    if (btn) btn.classList.add('active');
}
</script>

<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebAPI",
      "@id": "https://talalive.ir/api-docs#api",
      "name": "وب‌سرویس عمومی و API نرخ لحظه‌ای طلا و سکه طلالایو",
      "description": "API زنده و رایگان برای دریافت لحظه‌ای مظنه آبشده، هر گرم طلای ۱۸ عیار، انواع سکه بانکی و ارز آزاد با استاندارد RESTful.",
      "documentation": "https://talalive.ir/api-docs",
      "termsOfService": "https://talalive.ir/api-docs#terms",
      "provider": {
        "@type": "Organization",
        "name": "سامانه طلالایو",
        "url": "https://talalive.ir"
      }
    },
    {
      "@type": "TechArticle",
      "@id": "https://talalive.ir/api-docs#article",
      "headline": "مستندات وب‌سرویس (API) رایگان نرخ لحظه‌ای طلا و سکه",
      "description": "راهنمای اتصال به API نرخ لحظه‌ای طلا و سکه طلالایو به همراه نمونه کدهای زبان‌های مختلف و فرمت خروجی JSON.",
      "url": "https://talalive.ir/api-docs",
      "publisher": {
        "@type": "Organization",
        "name": "طلالایو",
        "url": "https://talalive.ir"
      }
    },
    {
      "@type": "FAQPage",
      "@id": "https://talalive.ir/api-docs#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "آیا برای استفاده از API به ساخت حساب کاربری یا API Key نیاز است؟",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "خیر؛ نسخه ۱ این وب‌سرویس به‌صورت کاملاً باز و بدون نیاز به کلید دسترسی ارائه شده است."
          }
        },
        {
          "@type": "Question",
          "name": "محدودیت تعداد درخواست در API طلالایو چقدر است؟",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "سقف مجاز مصرف رایگان ۶۰ درخواست در دقیقه به ازای هر آدرس آی‌پی می‌باشد."
          }
        },
        {
          "@type": "Question",
          "name": "شرایط استفاده و الزام ذکر منبع در API چیست؟",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "استفاده از داده‌های این وب‌سرویس منوط به درج لینک مستقیم و فعال به وب‌سایت talalive.ir به عنوان منبع قیمت طلا است."
          }
        }
      ]
    }
  ]
}
</script>
@endsection
