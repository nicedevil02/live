@extends('layouts.public')

@section('title', 'مستندات وب‌سرویس عمومی و API نرخ لحظه‌ای طلا و سکه | طلالایو')
@section('meta_desc', 'مستندات جامع وب‌سرویس RESTful طلالایو برای دریافت لحظه‌ای قیمت طلای ۱۸ عیار، مظنه مثقال، انواع سکه و ارز. نمونه کدهای cURL، پایتون، PHP و جاوااسکریپت همراه با قوانین مصرف رایگان.')
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
        background-color: #3b82f6;
        color: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="py-12 bg-slate-900 text-slate-100 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm text-slate-400 mb-8 space-x-2 space-x-reverse" aria-label="مسیر راهنما">
            <a href="/" class="hover:text-amber-400 transition-colors">صفحه اصلی</a>
            <span>/</span>
            <span class="text-amber-400">مستندات وب‌سرویس (API)</span>
        </nav>

        <!-- Header -->
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1.5 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-4">
                RESTful API v1.0 • دسترسی آزاد و رایگان
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-4">
                مستندات وب‌سرویس (API) رایگان نرخ لحظه‌ای طلا و سکه
            </h1>
            <p class="text-lg text-slate-300 max-w-3xl mx-auto leading-relaxed">
                با اتصال به API زنده طلالایو، آخرین نرخ‌های مظنه مثقال آبشده، طلای ۱۸ و ۲۴ عیار، انواع مسکوکات بانکی و ارزهای پایه را با بالاترین سرعت و دقت میلی‌ثانیه‌ای در پروژه‌ها، اپلیکیشن‌ها و سامانه‌های حسابداری خود نمایش دهید.
            </p>
        </div>

        <!-- Quick Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
            <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-5 text-center shadow-lg">
                <span class="text-2xl mb-2 block">⚡</span>
                <h2 class="text-sm font-semibold text-slate-400 mb-1">فرمت خروجی</h2>
                <p class="text-base font-bold text-white">JSON استاندارد (UTF-8)</p>
            </div>
            <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-5 text-center shadow-lg">
                <span class="text-2xl mb-2 block">🔒</span>
                <h2 class="text-sm font-semibold text-slate-400 mb-1">احراز هویت</h2>
                <p class="text-base font-bold text-emerald-400">عمومی / بدون توکن (v1)</p>
            </div>
            <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-5 text-center shadow-lg">
                <span class="text-2xl mb-2 block">⏱️</span>
                <h2 class="text-sm font-semibold text-slate-400 mb-1">محدودیت نرخ (Rate Limit)</h2>
                <p class="text-base font-bold text-white">۶۰ درخواست در دقیقه</p>
            </div>
            <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-5 text-center shadow-lg">
                <span class="text-2xl mb-2 block">🌐</span>
                <h2 class="text-sm font-semibold text-slate-400 mb-1">پشتیبانی CORS</h2>
                <p class="text-base font-bold text-amber-400">فعال (Access-Control: *)</p>
            </div>
        </div>

        <!-- Endpoint Section -->
        <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 sm:p-8 mb-10 shadow-xl">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6 pb-6 border-b border-slate-700">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-sm font-black rounded-lg border border-emerald-500/30">
                        GET
                    </span>
                    <span class="text-lg sm:text-xl font-mono text-white select-all">
                        /api/v1/rates
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-xs text-slate-400">وضعیت سرور: فعال و آنلاین</span>
                </div>
            </div>

            <h2 class="text-xl font-bold text-amber-400 mb-3">شرح عملکرد اندپوینت</h2>
            <p class="text-slate-300 leading-relaxed mb-6">
                این متد آخرین نرخ‌های بازار طلا و جواهر تهران را شامل قیمت هر گرم طلای ۱۸ عیار، ۲۴ عیار، مظنه مثقال ۱۷ عیار، انس جهانی طلا، تمام سکه امامی و بهار آزادی، نیم سکه، ربع سکه، سکه گرمی و نرخ پایه دلار آزاد بازمی‌گرداند. کلیه مبالغ به واحد تومان محاسبه و اعلام شده‌اند.
            </p>

            <h3 class="text-base font-semibold text-white mb-2">پارامترهای ورودی (Query Parameters):</h3>
            <p class="text-sm text-slate-400 mb-6">
                این اندپوینت در نسخه ۱ به هیچ پارامتر اجباری یا اختیاری نیاز ندارد و خروجی کامل بسته‌ی قیمتی را تحویل می‌دهد.
            </p>

            <h3 class="text-base font-semibold text-white mb-2">هدرهای استاندارد پاسخ (Response Headers):</h3>
            <div class="bg-slate-950 rounded-xl p-4 code-box text-slate-300 border border-slate-800 mb-6">
                <code>
                    Content-Type: application/json; charset=utf-8<br>
                    Access-Control-Allow-Origin: *<br>
                    Cache-Control: public, max-age=15<br>
                    X-RateLimit-Limit: 60<br>
                    X-RateLimit-Remaining: 59
                </code>
            </div>

            <!-- Response Sample -->
            <div class="mt-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-base font-semibold text-white">نمونه خروجی واقعی (JSON Response 200 OK):</h3>
                    <button onclick="navigator.clipboard.writeText(document.getElementById('sample-json').innerText); alert('نمونه JSON کپی شد');" class="text-xs px-3 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded-md transition-colors">
                        کپی JSON
                    </button>
                </div>
                <pre id="sample-json" class="bg-slate-950 p-5 rounded-xl border border-slate-800 text-emerald-300 code-box overflow-x-auto text-xs leading-relaxed max-h-96"><code>{
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
        "name": "مظنه مثقال ۱۷ عیار (تهران)",
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
    "currency": {
      "usd_free": {
        "name": "دلار آمریکا (آزاد)",
        "price": {{ $rates['dollar'] ?: 68500 }},
        "unit": "تومان"
      }
    }
  }
}</code></pre>
            </div>
        </div>

        <!-- Code Examples -->
        <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 sm:p-8 mb-10 shadow-xl">
            <h2 class="text-2xl font-bold text-white mb-4">نمونه کدهای اتصال در زبان‌های مختلف</h2>
            <p class="text-slate-300 mb-6">
                برای اتصال سریع، کدهای تست‌شده زیر را مستقیماً در پروژه خود کپی و اجرا نمایید:
            </p>

            <div class="flex flex-wrap gap-2 mb-4 border-b border-slate-700 pb-3">
                <button onclick="showCodeTab('curl')" id="tab-btn-curl" class="tab-btn active px-4 py-2 text-sm font-medium rounded-lg text-slate-300 hover:bg-slate-700 transition-colors">cURL</button>
                <button onclick="showCodeTab('js')" id="tab-btn-js" class="tab-btn px-4 py-2 text-sm font-medium rounded-lg text-slate-300 hover:bg-slate-700 transition-colors">JavaScript</button>
                <button onclick="showCodeTab('python')" id="tab-btn-python" class="tab-btn px-4 py-2 text-sm font-medium rounded-lg text-slate-300 hover:bg-slate-700 transition-colors">Python</button>
                <button onclick="showCodeTab('php')" id="tab-btn-php" class="tab-btn px-4 py-2 text-sm font-medium rounded-lg text-slate-300 hover:bg-slate-700 transition-colors">PHP</button>
            </div>

            <!-- cURL snippet -->
            <div id="code-curl" class="code-tab-panel">
                <pre class="bg-slate-950 p-4 rounded-xl border border-slate-800 text-sky-300 code-box overflow-x-auto"><code>curl -X GET "https://talalive.ir/api/v1/rates" \
     -H "Accept: application/json"</code></pre>
            </div>

            <!-- JS snippet -->
            <div id="code-js" class="code-tab-panel hidden">
                <pre class="bg-slate-950 p-4 rounded-xl border border-slate-800 text-amber-200 code-box overflow-x-auto"><code>async function fetchGoldRates() {
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
                <pre class="bg-slate-950 p-4 rounded-xl border border-slate-800 text-emerald-300 code-box overflow-x-auto"><code>import requests

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
                <pre class="bg-slate-950 p-4 rounded-xl border border-slate-800 text-purple-300 code-box overflow-x-auto"><code>&lt;?php

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
        <div class="bg-gradient-to-r from-amber-950/40 via-slate-800 to-slate-800 border border-amber-500/30 rounded-2xl p-6 sm:p-8 mb-10 shadow-xl">
            <h2 class="text-2xl font-bold text-amber-400 mb-4 flex items-center gap-2">
                <span>⚖️</span>
                <span>شرایط استفاده، محدودیت‌ها و الزام درج منبع</span>
            </h2>
            <div class="space-y-4 text-slate-300 text-sm leading-relaxed">
                <p>
                    دسترسی به API نرخ طلالایو برای کلیه توسعه‌دهندگان، استارتاپ‌ها، سامانه‌های حسابداری طلافروشی و وب‌سایت‌های خبری آزاد و رایگان است؛ مشروط به رعایت مفاد زیر:
                </p>
                <ul class="list-disc list-inside space-y-2 text-slate-300 pr-2">
                    <li><strong class="text-white">الزام ذکر منبع با لینک فعال:</strong> در صورت استفاده از داده‌های این وب‌سرویس در صفحات وب یا اپلیکیشن‌ها، درج عنوان و لینک فعال مستقیم به <a href="https://talalive.ir" class="text-amber-400 font-semibold underline underline-offset-4 hover:text-amber-300">طلالایو (talalive.ir)</a> با عنوان «منبع قیمت: طلالایو» یا «منبع داده: سامانه تابلوی طلای آنلاین طلالایو» الزامی است.</li>
                    <li><strong class="text-white">سقف درخواست مجاز:</strong> حداکثر سقف مجاز برای هر آی‌پی (IP Address)، ۶۰ فراخوانی در هر دقیقه می‌باشد. سیستم به طور خودکار درخواست‌های فراتر از این سقف را با خطای <code>HTTP 429 Too Many Requests</code> متوقف خواهد کرد.</li>
                    <li><strong class="text-white">کش کردن داده‌ها در سمت سرور مصرف‌کننده:</strong> توصیه اکید می‌شود داده‌های دریافتی را حداقل به مدت ۱۵ الی ۳۰ ثانیه در سرور خود کش (Cache) کنید تا از ارسال درخواست‌های غیرضروری و بلاک شدن آی‌پی سرور جلوگیری شود.</li>
                    <li><strong class="text-white">ممنوعیت حملات و فشار غیرمتعارف:</strong> هرگونه تلاش برای مهندسی معکوس، حملات Denial-of-Service یا فرار از محدودیت نرخ موجب مسدودسازی دائمی دسترسی آی‌پی یا رنج آی‌پی خواهد شد.</li>
                </ul>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-slate-800/80 border border-slate-700/70 rounded-2xl p-6 sm:p-8 mb-12 shadow-xl">
            <h2 class="text-2xl font-bold text-white mb-6">سؤالات متداول توسعه‌دهندگان درباره API طلالایو</h2>
            <div class="space-y-6 text-slate-300">
                <div>
                    <h3 class="text-base font-semibold text-amber-400 mb-2">۱. آیا برای استفاده از API به ساخت حساب کاربری یا API Key نیاز است؟</h3>
                    <p class="text-sm leading-relaxed">
                        خیر؛ نسخه ۱ این وب‌سرویس به‌صورت کاملاً باز و بدون نیاز به کلید دسترسی ارائه شده است. شما می‌توانید مستقیماً از اندپوینت <code>/api/v1/rates</code> استفاده نمایید.
                    </p>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-amber-400 mb-2">۲. نرخ‌ها در این API در چه فواصل زمانی به‌روزرسانی می‌شوند؟</h3>
                    <p class="text-sm leading-relaxed">
                        سامانه طلالایو قیمت‌های صنف طلا را از ساعت ۱۰:۳۰ صبح همزمان با گشایش بازار سبزه میدان و اتحادیه‌های مرجع به صورت میلی‌ثانیه‌ای دریافت و در کش توزیع‌شده با طول عمر ۱۵ ثانیه نگهداری می‌کند.
                    </p>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-amber-400 mb-2">۳. اگر نیاز به وب‌سرویس اختصاصی یا خروجی با وب‌سوکت داشته باشیم چه کنیم؟</h3>
                    <p class="text-sm leading-relaxed">
                        توسعه‌دهندگان و شرکت‌های صرافی یا نرم‌افزاری که نیازمند ترافیک بالا، وب‌سوکت زنده یا داده‌های تاریخی هستند، می‌توانند از طریق <a href="/contact" class="text-amber-400 underline">صفحه تماس با ما</a> درخواست خود را برای دریافت پنل تجاری سازمانی ثبت نمایند.
                    </p>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-amber-400 mb-2">۴. آیا امکان استفاده از ویجت آماده به جای کدنویسی API وجود دارد؟</h3>
                    <p class="text-sm leading-relaxed">
                        بله! اگر تمایل به برنامه‌نویسی اختصاصی ندارید، می‌توانید با مراجعه به <a href="/widget" class="text-amber-400 underline">سازنده ویجت آنلاین طلالایو</a> تنها با یک خط کد آی‌فریم، تابلوی زنده قیمت طلا را در سایت یا وبلاگ وردپرسی خود قرار دهید.
                    </p>
                </div>
            </div>
        </div>

        <!-- Related Links & CTA -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700/80 rounded-2xl p-8 text-center shadow-xl">
            <h2 class="text-xl font-bold text-white mb-3">سایر ابزارها و خدمات دیجیتال طلالایو</h2>
            <p class="text-slate-300 text-sm max-w-xl mx-auto mb-6">
                علاوه بر وب‌سرویس توسعه‌دهندگان، طلالایو راهکارهای هوشمند تابلوی مغازه طلافروشی و ماشین‌حساب‌های صنفی پیشرفته را در اختیارتان می‌گذارد:
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="/widget" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl text-sm font-semibold transition-colors">
                    دریافت کد ویجت طلای سایت
                </a>
                <a href="/tools/gold-price-calculator" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl text-sm font-semibold transition-colors">
                    ماشین‌حساب فاکتور طلا
                </a>
                <a href="/smart-gold-board" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-xl text-sm font-bold transition-colors">
                    آشنایی با تابلوی طلافروشی
                </a>
                <a href="/contact" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-600 rounded-xl text-sm font-medium transition-colors">
                    پشتیبانی فنی و تماس
                </a>
            </div>
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
  "@@graph": [
    {
      "@@type": "WebAPI",
      "@@id": "https://talalive.ir/api-docs#api",
      "name": "وب‌سرویس عمومی و API نرخ لحظه‌ای طلا و سکه طلالایو",
      "description": "API زنده و رایگان برای دریافت لحظه‌ای مظنه آبشده، هر گرم طلای ۱۸ عیار، انواع سکه بانکی و ارز آزاد با استاندارد RESTful.",
      "documentation": "https://talalive.ir/api-docs",
      "termsOfService": "https://talalive.ir/api-docs#terms",
      "provider": {
        "@@type": "Organization",
        "name": "سامانه طلالایو",
        "url": "https://talalive.ir"
      }
    },
    {
      "@@type": "TechArticle",
      "@@id": "https://talalive.ir/api-docs#article",
      "headline": "مستندات وب‌سرویس (API) رایگان نرخ لحظه‌ای طلا و سکه",
      "description": "راهنمای اتصال به API نرخ لحظه‌ای طلا و سکه طلالایو به همراه نمونه کدهای زبان‌های مختلف و فرمت خروجی JSON.",
      "url": "https://talalive.ir/api-docs",
      "publisher": {
        "@@type": "Organization",
        "name": "طلالایو",
        "url": "https://talalive.ir"
      }
    },
    {
      "@@type": "FAQPage",
      "@@id": "https://talalive.ir/api-docs#faq",
      "mainEntity": [
        {
          "@@type": "Question",
          "name": "آیا برای استفاده از API به ساخت حساب کاربری یا API Key نیاز است؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "خیر؛ نسخه ۱ این وب‌سرویس به‌صورت کاملاً باز و بدون نیاز به کلید دسترسی ارائه شده است."
          }
        },
        {
          "@@type": "Question",
          "name": "محدودیت تعداد درخواست در API طلالایو چقدر است؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "سقف مجاز مصرف رایگان ۶۰ درخواست در دقیقه به ازای هر آدرس آی‌پی می‌باشد."
          }
        },
        {
          "@@type": "Question",
          "name": "شرایط استفاده و الزام ذکر منبع در API چیست؟",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "استفاده از داده‌های این وب‌سرویس منوط به درج لینک مستقیم و فعال به وب‌سایت talalive.ir به عنوان منبع قیمت طلا است."
          }
        }
      ]
    }
  ]
}
</script>
@endsection
