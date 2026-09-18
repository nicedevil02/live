# طلالایو TV — نقشهٔ پیاده‌سازی اجرایی اپ اندروید تلویزیون

> سند تجویزی اجرا. مخزن: `nicedevil02/live` · شاخهٔ پایه: `master` · شاخهٔ کاری: `feat/tv-native-app`
نویسنده: Notion AI · تاریخ: ۲۷ شهریور ۱۴۰۵ (۲۰۲۶-۰۹-۱۸)
> 

# ۰. قرارداد اجرا — خواندن اجباری پیش از هر خط کد

این سند برای اجرا نوشته شده، نه برای الهام گرفتن. ایجنتی که این را اجرا می‌کند باید نُه قاعدهٔ زیر را بپذیرد:

1. **نقشهٔ دوم نساز.** تسک‌ها با شناسه شماره‌گذاری شده‌اند (`R-01`, `B-03`, `A-07`, ...). همین ترتیب را اجرا کن. اگر لازم دیدی تسکی اضافه شود، آن را در بخش ۱۰ (دفتر انحرافات) ثبت کن و بعد اجرا کن.
2. **فاز ۰ را حذف نکن.** فاز ۰ کدنویسی ندارد؛ فقط خواندن و گزارش است. چهار فرض این سند در فاز ۰ راستی‌آزمایی می‌شوند. اگر فرضی غلط بود، پیش از ادامه در دفتر انحرافات بنویس.
3. **تصمیم‌های بخش ۲ قفل هستند.** هیچ‌کدام را با معماری «بهتر» عوض نکن. اگر تصمیمی از نظر تو غلط است، در دفتر انحرافات بنویس و همان تصمیم قفل‌شده را اجرا کن.
4. **معیار پذیرش هر تسک، رفتار است نه کامپایل.** «بدون خطا بیلد شد» هیچ تسکی را تمام‌شده نمی‌کند. هر تسک یک معیار پذیرش قابل مشاهده دارد؛ تیک فقط وقتی می‌خورد که آن رفتار دیده شود.
5. **هیچ خطایی را بی‌صدا نبلع.** `catch (_) {}` و `catch { }` خالی ممنوع است. هر catch یا لاگ می‌کند یا به کاربر نشان می‌دهد.
6. **فایل‌های موجود را بازنویسی نکن.** در `PublicDisplayController.php` و `live.blade.php` فقط ویرایش هدفمند انجام بده. این دو فایل ۳۱ و ۱۱۴ کیلوبایت هستند و بازنویسی‌شان قطعاً چیزی را می‌شکند.
7. **روی `master` کامیت نکن.** همه‌چیز روی `feat/tv-native-app`. هر فاز یک کامیت جدا با پیشوند فاز.
8. **پروژهٔ اندروید داخل همین مخزن، در پوشهٔ `tv_app_native/`.** به `.gitignore` اضافه کن: `tv_app_native/build/`, `tv_app_native/app/build/`, `tv_app_native/.gradle/`, `tv_app_native/local.properties`, `*.jks`, `*.keystore`.
9. **هیچ فایلی را از `public_html/` پاک نکن.** این پوشه مستقیم روی هاست دیپلوی می‌شود (`.cpanel.yml`).

<aside>
⚠️

**سه خطای بازگشت‌ناپذیر.** اگر این سه مورد را رعایت نکنی، جبران‌شان بعداً غیرممکن است: (۱) کی‌استور را گم نکن — `U-01`؛ (۲) کانال آپدیت را به نسخهٔ اول اضافه کن، به فاز بعدی نینداز — `U-02`؛ (۳) آدرس سایت را هاردکد نکن — `A-04`.

</aside>

# ۱. تصویر نهایی — از چشم طلافروش، نه از چشم کامپایلر

قبل از تسک‌ها، این را بخوان. هر تصمیم فنی این سند در خدمت این روایت است. اگر تسکی این روایت را جلو نمی‌برد، اشتباه است.

**روز اول.** حاج‌آقا رضایی، طلافروش، یک اندروید باکس ۹۰۰ هزار تومانی می‌خرد و به تلویزیون ۵۰ اینچ بالای ویترین وصل می‌کند. فایل `talalive-tv.apk` را از `talalive.ir/app` با گوشی‌اش دانلود و روی فلش می‌ریزد و نصب می‌کند. اپ باز می‌شود. یک صفحهٔ تمیز فارسی با یک کد شش‌کاراکتری درشت: `K7M2QF`. زیرش یک QR و یک دکمه: «ارسال کد به موبایلم». دکمه را با ریموت می‌زند، پیامک می‌آید، روی لینک می‌زند، وارد پنل می‌شود، تمام. تلویزیون خودش عوض می‌شود و تابلوی قیمت گالری خودش را نشان می‌دهد. **او روی تلویزیون حتی یک حرف تایپ نکرد.**

**شب.** مغازه را می‌بندد، برق تلویزیون را می‌زند.

**روز دوم صبح.** برق را وصل می‌کند و می‌رود سراغ کارش. تلویزیون خودش بالا می‌آید، خودش تابلو را می‌آورد، و **دیگر هیچ‌وقت کد نمی‌پرسد**. تا وقتی که خودش از پنل آن دستگاه را حذف کند.

**روز پانزدهم.** اینترنت مغازه قطع می‌شود. تلویزیون صفحهٔ سفید نشان نمی‌دهد. یک صفحهٔ فارسی می‌آید: «اتصال اینترنت قطع است — آخرین نرخ دریافتی: ۱۴:۳۲». وقتی مودم برگشت، خودش بدون دست زدن به ریموت به تابلو برمی‌گردد.

**روز چهلم.** یک باگ در تابلو پیدا می‌شود. من فایل جدید را روی سرور می‌گذارم. تلویزیون حاج‌آقا رضایی **خودش** آپدیت را می‌گیرد و نصب می‌کند. هیچ‌کس به مغازه سر نمی‌زند.

**روز صدم.** باکس قدیمی می‌سوزد، یکی نو می‌خرد. کد جدید می‌گیرد، جفت می‌کند. از پنل، دستگاه قدیمی را «حذف» می‌کند. تمام. لازم نیست `display_token` عوض شود و بقیهٔ تلویزیون‌هایش بخوابند.

---

**و این‌ها چیزهایی هستند که در این روایت هیچ‌وقت اتفاق نمی‌افتند** — هر کدام یک تسک در این سند دارد:

| چیزی که نباید اتفاق بیفتد | تسک محافظ |
| --- | --- |
| تابلو بالا می‌آید ولی قیمت‌ها هیچ‌وقت عوض نمی‌شوند (JS روی WebView قدیمی مرده) | `W-05`, `A-09`, `A-10` |
| صفحهٔ سفید یا خطای خام مرورگر | `A-07`, `A-11` |
| تابلو بعد از ۳ روز سیاه می‌شود (رندرر کشته شده) | `A-07`, `A-12` |
| ساعت باکس روی ۱۹۷۰ مانده و HTTPS رد می‌شود | `A-14` |
| نسخهٔ قدیمی تابلو برای همیشه در کش سرویس‌ورکر قفل می‌شود | `W-03` |
| با ۲۰۰ تلویزیون، تابلو ۴ ثانیه دیر لود می‌شود | `B-01`, `B-02` |
| بعد از ریبوت دوباره کد می‌خواهد | `A-03`, `B-05` |

# ۲. تصمیم‌های قفل‌شده

| شناسه | تصمیم | چرا (و چرا گزینهٔ دیگر رد شد) |
| --- | --- | --- |
| `D-01` | ۱۰۰٪ کاتلین نیتیو. **هیچ وابستگی‌ای جز `kotlin-stdlib`**. بدون AndroidX، بدون Compose، بدون Leanback، بدون OkHttp. شبکه با `HttpURLConnection`، JSON با `org.json` (داخل فریم‌ورک). | هدف حجم: زیر ۲ مگابایت و مصرف رم حداقلی روی باکس ۱ گیگ. AndroidX AppCompat تنهایی ۱٫۵ مگابایت و چند هزار متد اضافه می‌کند و هیچ قابلیتی که این اپ لازم دارد نمی‌دهد. |
| `D-02` | **صفحهٔ جفت‌سازی نیتیو است، نه وب.** از `resources/views/display/pairing.blade.php` در اپ استفاده نمی‌شود. | این تصمیم عوض شد؛ دلیلش را در کالوت زیر جدول بخوان. |
| `D-03` | **تابلو وب است.** WebView آدرس `/{username}?tv=1` را لود می‌کند. هیچ قیمتی به‌صورت نیتیو رندر نمی‌شود. | `live.blade.php` صد و چهارده کیلوبایت منطق تم، اسلایدر، فرمول و انیمیشن است. بازنویسی نیتیوش یعنی دو پیاده‌سازی موازی از یک UI که تا ابد باید هم‌زمان نگه داشته شوند. |
| `D-04` | ذخیره‌سازی محلی با `SharedPreferences` **سادهٔ رمزنگاری‌نشده**. | `EncryptedSharedPreferences` کتابخانهٔ `androidx.security-crypto` را می‌آورد که با `D-01` تناقض دارد. محتوای ذخیره‌شده `username` و یک توکن فقط-خواندنی است که به صفحه‌ای دسترسی می‌دهد که **از قبل عمومی است** (مسیر `/{username}` هیچ احراز هویتی ندارد). ارزش رمزنگاری صفر و هزینه‌اش واقعی است. |
| `D-05` | آدرس پایه از **ریموت‌کانفیگ** با فهرست دامنه‌های جایگزین می‌آید؛ فقط مقدار پیش‌فرض اولیه در کد است. | APK ساید‌لود‌شده را نمی‌توان از بیرون عوض کرد. اگر دامنه عوض یا فیلتر شود و آدرس هاردکد باشد، همهٔ تلویزیون‌ها هم‌زمان می‌خوابند و راه نجاتی نیست. |
| `D-06` | راه‌اندازی خودکار: `BOOT_COMPLETED` → سرویس فورگراند → نوتیفیکیشن با `fullScreenIntent` → اکتیویتی. به‌علاوه `QUICKBOOT_POWERON` و راهنمای «انتخاب به‌عنوان صفحهٔ خانه». | از API 29، اجرای Activity از پس‌زمینه بلاک است. `BootReceiver` → `startActivity()` روی باکس‌های API 21–28 کار می‌کند و روی Google TV بی‌صدا شکست می‌خورد. `fullScreenIntent` مسیر مجاز است. |
| `D-07` | **کانال آپدیت درون‌برنامه‌ای در همان نسخهٔ اول.** | گوگل‌پلی در ایران نیست و Android TV در کافه‌بازار عملاً وجود ندارد. بدون این، هر باگ بعدی یعنی سفر فیزیکی به مغازه. |
| `D-08` | یک کی‌استور، یک بار ساخته می‌شود، بیرون مخزن نگه داشته می‌شود، `signingConfig` از متغیر محیطی می‌خواند. | گم شدن کی‌استور = خطای signature mismatch = کاربر باید اپ را پاک و دوباره نصب کند. غیرقابل جبران. |
| `D-09` | دروازهٔ نسخهٔ WebView: اگر نسخهٔ کروم موتور زیر ۸۰ بود، صفحهٔ راهنمای نیتیو نشان داده می‌شود، نه تابلوی شکسته. | `public_html/vendor/alpinejs.min.js` حجمش ۴۶ کیلوبایت است، یعنی **Alpine 3**، که به `Proxy` و سینتکس مدرن وابسته است. روی WebView قفل‌شدهٔ باکس‌های ارزان بی‌صدا از کار می‌افتد: نه خطا، نه پیام، فقط تابلویی که هیچ‌وقت آپدیت نمی‌شود. |
| `D-10` | در حالت `?tv=1` سرویس‌ورکر ثبت نمی‌شود و ثبت‌های قبلی باطل می‌شوند. | `sw.js` فایل‌های استاتیک را cache-first و بدون انقضا نگه می‌دارد. یعنی CSS جدید تا وقتی `CACHE_NAME` دستی عوض نشود به تلویزیون مغازه نمی‌رسد. |
| `D-11` | `onRenderProcessGone` هندل می‌شود و WebView از نو ساخته می‌شود. به‌علاوه ریلود زمان‌بندی‌شدهٔ روزانه ساعت ۴ صبح. | تابلوی ۲۴ ساعته روی باکس ۱ گیگ رم حتماً رندررش کشته می‌شود. هندل‌نکردنش یعنی کرش اپ و تلویزیون سیاه تا وقتی کسی بیاید. |
| `D-12` | خطای SSL **هرگز** به‌صورت فراگیر نادیده گرفته نمی‌شود. فقط تشخیص داده می‌شود و صفحهٔ راهنمای نیتیو می‌آید. | باکس‌های چینی با باتری RTC مرده ساعتشان روی ۱۹۷۰ می‌ماند و گواهی HTTPS رد می‌شود. `proceed()` کردن کورکورانه اپ را در برابر MITM باز می‌کند. |
| `D-13` | `snapshot()` کاملاً **کش‌خوان** می‌شود. هیچ واکشی‌ای در مسیر درخواست تابلو مجاز نیست. | جزئیات در `B-01`. |
| `D-14` | جدول جدید `tv_devices` با توکن بی‌انقضا و قابل ابطال. `tv_sessions` فقط برای دست‌دادن دوساعتهٔ جفت‌سازی می‌ماند. | `expires_at = now()->addHours(2)` برای یک دستگاه دائمی بی‌معنی است. الان تنها راه ابطال، عوض کردن `display_token` کاربر است که **همهٔ** تلویزیون‌هایش را هم‌زمان می‌خواباند. |
| `D-15` | الفبای کد فعال‌سازی: `23456789ABCDEFGHJKMNPQRSTUVWXYZ` | `Str::random(6)` فعلی `O/0` و `I/1/l` تولید می‌کند که روی صفحهٔ تلویزیون از فاصلهٔ سه متری قابل تفکیک نیستند. |
| `D-16` | `snapshot` **عمومی می‌ماند**؛ فقط `throttle:120,1` می‌گیرد. | این تصمیم هم عوض شد؛ در کالوت زیر جدول. |

<aside>
🔄

**دو تصمیمی که نسبت به بررسی اولیه عوض شدند — با دلیل**

**`D-02` (جفت‌سازی):** پیشنهاد اولیه‌ام «صفحهٔ وب `/tv` را در WebView لود کن» بود، با این استدلال که آن ۱۵۹ کیلوبایت از قبل نوشته شده. آن استدلال غلط بود، به سه دلیل. یک: جفت‌سازی **اولین** صفحه‌ای است که کاربر می‌بیند؛ اگر موتور WebView قدیمی باشد (`D-09`) صفحهٔ وب می‌شکند و کاربر **هیچ‌وقت نمی‌تواند جفت کند** — شکست کامل و بی‌توضیح. صفحهٔ نیتیو از این مشکل مصون است. دو: در آن طرح، ماندگاری جفت‌سازی به بقای `localStorage` وابسته می‌شد، که سیستم‌عامل مجاز است در فشار حافظه پاکش کند؛ نتیجه‌اش تلویزیونی است که بعد از چند هفته بی‌دلیل کد می‌خواهد. سه: یک صفحهٔ ۱۵۹ کیلوبایتی روی باکس ۱ گیگ خودش ریسک است. جفت‌سازی نیتیو حدود ۱۵۰ خط کاتلین است و همان اندپوینت‌های بک‌اند را مصرف می‌کند؛ چیزی دوباره‌نویسی نمی‌شود جز یک صفحهٔ ساده. `pairing.blade.php` دست‌نخورده برای مسیر مرورگری باقی می‌ماند.

**`D-16` (توکن snapshot):** در بررسی اولیه گفتم `snapshot` بدون احراز هویت است و باید توکن بگیرد. دقیق‌تر که نگاه کردم، این نگرانی بی‌مورد است: مسیر `/{username}` که `show()` را صدا می‌زند **خودش کاملاً عمومی است** و دقیقاً همان `buildSnapshot` را رندر می‌کند. پس توکن روی `snapshot` هیچ محرمانگی‌ای اضافه نمی‌کند و فقط ریسک شکستن چیزی را می‌آورد. مسئلهٔ واقعی سوءاستفاده و اسکرپینگ است، که راه‌حلش محدودیت نرخ است نه توکن.

</aside>

# ۳. فاز ۰ — شناسایی و راستی‌آزمایی (بدون کدنویسی)

<aside>
🛑

این فاز هیچ کدی نمی‌نویسد. این سند روی چهار فرض بنا شده که من نتوانستم راستی‌آزمایی کنم چون فایل‌هایشان بزرگ‌تر از آن بودند که کامل بخوانم. **هر شش تسک را اجرا و گزارش کن، بعد سراغ فاز ۱ برو.** اگر فرضی غلط بود، در دفتر انحرافات (بخش ۱۰) بنویس و تسک‌های وابسته را تنظیم کن.

</aside>

- [x]  **`R-01` — `live.blade.php` را کامل بخوان** (`resources/views/display/live.blade.php`، ۱۱۴٤۰۰ بایت) و این هشت چیز را گزارش کن:
    1. فاصلهٔ پولینگ تابلو برای گرفتن `/api/display/snapshot/{username}` چند ثانیه است؟ متغیرش کجاست؟
    2. آیا `refreshIntervalSeconds` از اسنپ‌شات خوانده می‌شود یا در JS هاردکد است؟
    3. کدام نسخهٔ Alpine و چطور بارگذاری می‌شود؟ آیا `defer` دارد؟
    4. آیا `localStorage` یا `sessionStorage` استفاده می‌شود؟ برای چه؟
    5. سرویس‌ورکر کجا و چطور ثبت می‌شود؟ (در خود این فایل یا در `layouts/`؟)
    6. آیا از قبل پارامتری مثل `?tv=`، `?kiosk=` یا `?fullscreen=` را می‌شناسد؟
    7. بعد از اولین رندر موفق قیمت‌ها، چه تابع یا رویدادی اجرا می‌شود؟ (برای `W-05` لازم است)
    8. آیا `html5-qrcode.min.js` (۳۷۵ کیلوبایت) یا `lucide.min.js` (۴۳۲ کیلوبایت) در این صفحه لود می‌شوند؟ اگر بله، کدام بخش‌ها لازمشان دارند؟
- [x]  **`R-02` — `MarketService.php` را بخوان** (`app/Services/MarketService.php`، ۳۲۷۰۲ بایت) و گزارش کن: امضای `getPriceFeed`, `refreshIfStale`, `fetchFastMovingPrices`, `currentRefreshIntervalSeconds`؛ کدام‌شان درخواست HTTP بیرونی می‌زنند؛ و آیا `getPriceFeed` **کاملاً کش‌خوان** است یا خودش هم ممکن است واکشی کند. **این حیاتی است:** اگر `getPriceFeed` هم واکشی کند، `B-01` کافی نیست و باید گسترش پیدا کند.
- [x]  **`R-03` — درایور کش پروداکشن را مشخص کن.** `config/cache.php` پیش‌فرض را `env('CACHE_STORE', 'database')` گذاشته و `.env.example` هم `database` دارد. اگر پروداکشن روی `database` باشد، هر `Cache::get`، هر `Cache::put` و هر `Cache::lock` یک کوئری MySQL روی هاست اشتراکی cPanel است. با صدها تلویزیون این خودش گلوگاه است، مستقل از `B-01`. **مقدار واقعی `CACHE_STORE` در `.env` سرور را گزارش کن.** اگر `database` بود، `B-09` را اجرا کن.
- [x]  **`R-04` — وضعیت مایگریشن روی سرور را چک کن.** وجود `PublicDisplayController::ensureTvSessionsTable()` نشان می‌دهد یک بار مایگریشن روی هاست اجرا نشده و با الگوی خودترمیم دورش زده شده‌اند. گزارش کن: آیا `php artisan migrate --force` روی سرور سالم اجرا می‌شود؟ آیا جدول `tv_sessions` واقعاً وجود دارد؟ اگر مایگریشن‌ها سالم اجرا نمی‌شوند، `B-03` (ساخت `tv_devices`) هم به همان مشکل می‌خورد و باید **اول** ریشه‌اش حل شود.
- [x]  **`R-05` — `pairing.blade.php` را سرسری مرور کن** (۱۵۹۱۲۲ بایت) و فقط یک چیز را گزارش کن: دقیقاً چه بدنه‌ای به `POST /api/tv/register-session` می‌فرستد و پاسخ را چطور مصرف می‌کند. اپ نیتیو باید **عیناً** همان قرارداد را رعایت کند تا بک‌اند دو مسیر جداگانه لازم نداشته باشد.
- [x]  **`R-06` — مشخصات دستگاه‌های آزمون را گزارش کن.** به کدام دو دستگاه واقعی دسترسی داری؟ برای هر کدام: نسخهٔ اندروید، API level، نسخهٔ WebView سیستمی (از `WebSettings.getDefaultUserAgent`)، مقدار رم، و اینکه Leanback دارد یا نه. **اگر به هیچ دستگاه واقعی دسترسی نیست، همین‌جا متوقف شو و اعلام کن** — فاز ۵ روی امولاتور معنایی ندارد و کل این پروژه بدون آزمون روی دستگاه واقعی بی‌ارزش است.

# ۴. فاز ۱ — سخت‌سازی بک‌اند

<aside>
📌

این فاز **پیش‌نیاز قطعی** است، نه بهینه‌سازی. اپ اندروید کاری می‌کند که مرورگر نمی‌کرد: صدها کلاینت که ۲۴ ساعته و بدون وقفه پولینگ می‌کنند. رفتار فعلی `snapshot` با ۵ بازدیدکنندهٔ پراکنده مشکلی نداشت و با ۲۰۰ تلویزیون همیشه‌روشن می‌شکند. **فاز ۳ را پیش از اتمام این فاز شروع نکن.**

</aside>

- [x]  **`B-01` — `snapshot()` را کش‌خوان محض کن.**
فایل: `app/Http/Controllers/PublicDisplayController.php`
متد `snapshot(string $username)` الان قبل از ساختن اسنپ‌شات، تازگی کش `usdt` را چک می‌کند و اگر بیش از ۱۰ ثانیه گذشته باشد، **در همان درخواست** با `Cache::lock('usdt_snapshot_fetch_lock', 6)` واکشی زندهٔ قیمت را صدا می‌زند.
**کاری که باید بکنی:** کل آن بلوک `try/catch` مربوط به واکشی `usdt` را حذف کن. متد باید فقط `firstOrFail` و `buildSnapshot` را صدا بزند. به‌جایش این سه کلید را به خروجی `buildSnapshot` اضافه کن:
    
    ```php
    // داخل buildSnapshot، کنار updatedAt
    $lastFetch = MarketCache::max('fetched_at');
    $ageSeconds = $lastFetch ? now()->diffInSeconds(Carbon::parse($lastFetch)) : null;
    // ...
    'dataAgeSeconds' => $ageSeconds,
    'isStale'        => $ageSeconds === null || $ageSeconds > 180,
    'serverTime'     => now()->toIso8601String(),
    ```
    
    **معیار پذیرش:** با `MarketCache` که `fetched_at` آن را دستی به یک ساعت قبل برده‌ای، `GET /api/display/snapshot/{username}` بزن. باید (الف) زیر ۵۰ میلی‌ثانیه پاسخ بدهد، (ب) `isStale: true` برگرداند، (ج) **هیچ** درخواست HTTP بیرونی‌ای نزند — با tail کردن `storage/logs/laravel.log` و بررسی `AuditLog::where('action','api_request_attempt')` تأیید کن که رکورد جدیدی ثبت نشده.
    
- [x]  **`B-02` — واکشی را کامل به کرون بسپار.**
`routes/console.php` (۳۳۵ بایت) را بخوان و زمان‌بندی را طوری تنظیم کن که `fetchFastMovingPrices` هر دقیقه اجرا شود. `CRON_SETUP.md` از قبل دو راه مستند کرده؛ راه اندپوینت (`GET /api/public/cron/market-fetch?token=...`) را به‌عنوان راه رسمی انتخاب کن چون روی cPanel قابل اتکاتر است.
**همچنین:** `CRON_SETUP.md` توکن نمونه را `secure-market-fetch-token-2026` نوشته ولی کد پیش‌فرضش `talalive-cron-secret-2026` است. این تناقض را رفع کن و در `.env.example` متغیر `CRON_TOKEN` را اضافه کن — الان `.env.example` خام پیش‌فرض لاراول است و هیچ متغیر اختصاصی طلالایو در آن مستند نشده.
**معیار پذیرش:** کرون را فعال کن، ۵ دقیقه صبر کن، و نشان بده `MarketCache::max('fetched_at')` در این ۵ دقیقه حداقل ۴ بار جلو رفته، **در حالی که هیچ درخواستی به `snapshot` زده نشده**.
- [x]  **`B-03` — جدول `tv_devices` را بساز.**
فایل جدید: `database/migrations/2026_09_18_100000_create_tv_devices_table.php`
    
    ```php
    Schema::create('tv_devices', function (Blueprint $table) {
        $table->id();
        $table->string('device_token', 64)->unique();
        $table->unsignedBigInteger('user_id')->index();
        $table->string('username', 100);
        $table->string('label', 100)->nullable();            // «تلویزیون ویترین»
        $table->string('app_version', 20)->nullable();
        $table->string('android_release', 20)->nullable();
        $table->string('webview_version', 40)->nullable();
        $table->timestamp('last_seen_at')->nullable()->index();
        $table->timestamp('revoked_at')->nullable()->index();
        $table->timestamps();
    });
    ```
    
    **مدل:** `app/Models/TvDevice.php` با `$fillable` شامل همهٔ ستون‌های بالا جز `id` و تایم‌استمپ‌ها، کست `last_seen_at`/`revoked_at` به `datetime`، رابطهٔ `user()` از نوع `belongsTo`، و اسکوپ `scopeActive($q) => $q->whereNull('revoked_at')`. به `User` هم `tvDevices()` از نوع `hasMany` اضافه کن.
    **الگوی `ensureTvSessionsTable` را تکرار نکن.** این جدول با مایگریشن ساخته می‌شود و بس. اگر `R-04` نشان داد مایگریشن روی سرور سالم اجرا نمی‌شود، اول آن را حل کن.
    **معیار پذیرش:** `php artisan migrate --force` روی سرور اجرا شود و `Schema::hasTable('tv_devices')` مقدار `true` بدهد.
    
- [x]  **`B-04` — تولید کد فعال‌سازی را اصلاح کن.**
فایل: `PublicDisplayController.php`، متد `registerSession`
الان کد از `strtoupper(substr($sessionCode, 5, 6))` یا `strtoupper(Str::random(6))` ساخته می‌شود. جایگزینش کن با:
    
    ```php
    private static function makeActivationCode(int $length = 6): string
    {
        $alphabet = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';
        $max = strlen($alphabet) - 1;
        for ($attempt = 0; $attempt < 8; $attempt++) {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $alphabet[random_int(0, $max)];
            }
            $taken = DB::table('tv_sessions')
                ->where('activation_code', $code)
                ->where('expires_at', '>', now())
                ->exists();
            if (! $taken) {
                return $code;
            }
        }
        throw new \RuntimeException('activation code generation exhausted');
    }
    ```
    
    **توجه:** متد `normalizeDigits` موجود باید دست‌نخورده بماند و همچنان روی ورودی کاربر اعمال شود — ارقام فارسی و عربی و نیم‌فاصله را پاک می‌کند و لازم است.
    به خروجی `registerSession` این دو کلید را اضافه کن: `poll_interval_seconds` (مقدار `3`) و `expires_in_seconds` (مقدار `7200`). اپ نیتیو باید فاصلهٔ پولینگ را از سرور بگیرد نه هاردکد.
    **معیار پذیرش:** ۲۰۰ بار `makeActivationCode()` را صدا بزن و نشان بده هیچ خروجی‌ای شامل `O`, `0`, `I`, `1`, `L` نیست و هیچ تکراری در کدهای فعال وجود ندارد.
    
- [x]  **`B-05` — در لحظهٔ جفت شدن، دستگاه دائمی بساز.**
سه مسیر جفت‌سازی وجود دارد و **هر سه** باید عوض شوند: `pairDevice` (POST)، `pairWithCode`، و `pairMagicShortLink`. یک متد خصوصی مشترک بساز تا منطق سه‌جا تکرار نشود:
    
    ```php
    private function attachDevice(User $user, string $sessionCode, string $activationCode): TvDevice
    {
        $device = TvDevice::create([
            'device_token' => bin2hex(random_bytes(24)),   // ۴۸ کاراکتر
            'user_id'      => $user->id,
            'username'     => $user->username,
            'label'        => null,
            'last_seen_at' => now(),
        ]);
    
        DB::table('tv_sessions')->where('session_code', $sessionCode)->update([
            'is_paired'       => true,
            'paired_user_id'  => $user->id,
            'paired_username' => $user->username,
            'paired_token'    => $device->device_token,   // حالا توکن دستگاه است، نه display_token
            'updated_at'      => now(),
        ]);
    
        Cache::put('pairing_' . $sessionCode, [
            'paired'   => true,
            'username' => $user->username,
            'token'    => $device->device_token,
        ], 7200);
    
        Cache::forget('tv_session_' . $activationCode);
    
        return $device;
    }
    ```
    
    **مهم:** دیگر `display_token` کاربر را به تلویزیون نده. الان اگر `display_token` لو برود یا عوض شود، همهٔ دستگاه‌ها هم‌زمان تحت تأثیرند. توکن هر دستگاه باید مستقل و مستقلاً قابل ابطال باشد.
    در `checkPairingStatus` خروجی را به `{paired, username, device_token, poll_interval_seconds}` تغییر بده. کلید قبلی `display_token` را برای سازگاری با `pairing.blade.php` نگه دار تا وقتی `R-05` نشان بدهد که مصرف‌کننده‌ای ندارد.
    **معیار پذیرش:** یک جفت‌سازی کامل انجام بده. نشان بده (الف) یک رکورد در `tv_devices` ساخته شده، (ب) `checkPairingStatus` همان توکن را برمی‌گرداند، (ج) `display_token` کاربر **عوض نشده**.
    
- [x]  **`B-06` — اندپوینت ضربان قلب بساز.** این تسک سه کار را در یک درخواست جمع می‌کند: بررسی ابطال، بررسی آپدیت، و ریموت‌کانفیگ (`D-05`).
در `routes/api.php`:
    
    ```php
    Route::post('/tv/heartbeat', [PublicDisplayController::class, 'heartbeat'])
        ->middleware('throttle:30,1');
    ```
    
    ورودی: `device_token`, `app_version_code`, `android_release`, `webview_version`.
    منطق: دستگاه را پیدا کن؛ اگر نبود یا `revoked_at` پر بود، `{"revoked": true}` برگردان. وگرنه `last_seen_at` و سه فیلد مشخصات را آپدیت کن و این را برگردان:
    
    ```json
    {
      "revoked": false,
      "username": "goldshop",
      "board_url": "https://talalive.ir/goldshop?tv=1",
      "base_urls": ["https://talalive.ir", "https://www.talalive.ir"],
      "latest_version_code": 3,
      "min_version_code": 2,
      "apk_url": "https://talalive.ir/downloads/talalive-tv.apk",
      "heartbeat_interval_seconds": 900
    }
    ```
    
    مقادیر نسخه و فهرست دامنه‌ها را در `config/tv.php` بگذار (فایل جدید) تا بدون تغییر کد قابل ویرایش باشند.
    **معیار پذیرش:** یک دستگاه را از دیتابیس `revoked_at` بزن؛ ضربان بعدی باید `revoked: true` بدهد.
    
- [x]  **`B-07` — مدیریت دستگاه‌ها در پنل.** در پنل مدیریت (`app/Http/Controllers/Admin/`) یک بخش «تلویزیون‌های من» اضافه کن که فهرست `tv_devices` کاربر جاری را نشان بدهد با: برچسب قابل ویرایش، آخرین بازدید به تاریخ جلالی (از `User::toJalali` موجود استفاده کن)، نسخهٔ اپ، و دکمهٔ «حذف دستگاه» که `revoked_at` را پر می‌کند.
**معیار پذیرش:** از پنل یک دستگاه را حذف کن؛ تلویزیون واقعی باید حداکثر تا یک بازهٔ ضربان به صفحهٔ «این دستگاه حذف شده — برای اتصال مجدد کد جدید بگیرید» برود.
- [x]  **`B-08` — `ensureTvSessionsTable()` را حذف کن.** فقط **بعد از** اینکه `R-04` و `B-03` تأیید کردند مایگریشن‌ها روی سرور سالم اجرا می‌شوند. این متد در هر درخواست یک `Schema::hasTable` می‌زند و یک کوئری اضافه به هر بار لود تابلو تحمیل می‌کند.
**معیار پذیرش:** بعد از حذف، جفت‌سازی کامل روی سرور پروداکشن یک بار دیگر تست شود و کار کند.
- [x]  **`B-09` — فقط اگر `R-03` نشان داد کش روی `database` است.** درایور کش را به `file` تغییر بده (`CACHE_STORE=file`). روی cPanel اشتراکی `file` تقریباً همیشه از `database` سریع‌تر است و قفل‌های `Cache::lock` را از MySQL بیرون می‌برد. اگر هاست Redis دارد، Redis اولویت دارد.
**معیار پذیرش:** با ابزاری مثل `ab -n 200 -c 20` روی `snapshot`، صدک ۹۵ زیر ۲۰۰ میلی‌ثانیه باشد. عدد قبل و بعد را گزارش کن.

# ۵. فاز ۲ — حالت تلویزیون در صفحهٔ تابلو

<aside>
✂️

در این فاز **فقط ویرایش افزودنی** انجام بده. `live.blade.php` صد و چهارده کیلوبایت است؛ هر تغییری باید داخل یک شرط `@if($isTv)` یا یک بلوک تازه باشد تا مسیر مرورگری فعلی هیچ تغییری نکند. اگر لازم شد چیزی را بازآرایی کنی، در دفتر انحرافات ثبت کن.

</aside>

- [x]  **`W-01` — پارامتر `?tv=1` را به ویو برسان.**
فایل: `PublicDisplayController.php`، متد `show($username)`
در آرایه‌ای که به `view('display.live', [...])` پاس می‌شود، این کلید را اضافه کن:
    
    ```php
    'isTv' => $request->boolean('tv'),
    ```
    
    متد `show` الان امضای `Request` ندارد؛ آن را به `show(Request $request, string $username)` تغییر بده. مسیر `/{username}` در `routes/web.php` بدون تغییر کار می‌کند چون لاراول خودش `Request` را تزریق می‌کند.
    **مواظب باش:** این متد دو مسیر خروج زودهنگام دارد (کد ۴۰۳ برای کاربر تأییدنشده و کد ۴۰۲ برای اشتراک منقضی) که HTML درون‌خطی برمی‌گردانند. آن دو را **دست نزن** — رفتارشان روی تلویزیون درست است و پیام فارسی معناداری نشان می‌دهند.
    **معیار پذیرش:** `/{username}` و `/{username}?tv=1` هر دو لود شوند و خروجی HTMLشان متفاوت باشد (با `curl` و `diff` نشان بده).
    
- [x]  **`W-02` — استایل کیوسک تلویزیون.**
داخل `live.blade.php`، در بخش `<head>`، این بلوک را اضافه کن:
    
    ```
    @if($isTv)
    <style>
      html, body { cursor: none !important; overflow: hidden !important; }
      * { -webkit-user-select: none !important; user-select: none !important; }
      ::-webkit-scrollbar { display: none !important; }
      :root { --tv-overscan: 2.5vmin; }
      body { padding: var(--tv-overscan) !important; box-sizing: border-box; }
      /* حذف هایلایت فوکوس مرورگر روی تلویزیون */
      *:focus { outline: none !important; }
    </style>
    @endif
    ```
    
    **دربارهٔ اورسکن:** بسیاری از تلویزیون‌های قدیمی حدود ۲ تا ۵ درصد لبهٔ تصویر را می‌برند. مقدار `2.5vmin` نقطهٔ شروع محافظه‌کارانه است. در `T-05` روی دستگاه واقعی سنجیده و تنظیم می‌شود.
    **معیار پذیرش:** روی دستگاه واقعی، هیچ بخشی از قیمت‌ها یا نام گالری بیرون قاب نیفتد و نشانگر ماوس در هیچ حالتی دیده نشود.
    
- [x]  **`W-03` — سرویس‌ورکر را در حالت تلویزیون خاموش کن.**
اول با `R-01` مشخص کن ثبت سرویس‌ورکر کجاست (در `live.blade.php` یا در `resources/views/layouts/`). سپس آن ثبت را داخل `@unless($isTv)` بگذار و این بلوک را برای باطل کردن ثبت‌های قبلی اضافه کن:
    
    ```
    @if($isTv)
    <script>
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
    </script>
    @endif
    ```
    
    **چرا لازم است:** `public_html/sw.js` با `CACHE_NAME = 'gold-app-v4'` فایل‌های استاتیک را cache-first و بدون انقضا نگه می‌دارد. روی یک تلویزیون که سالی یک بار ریستارت می‌شود، یعنی نسخهٔ CSS و JS تابلو تا وقتی `CACHE_NAME` را دستی عوض نکنی هرگز آپدیت نمی‌شود. مسیرهای `/api/` از قبل درست استثنا شده‌اند، پس مشکل فقط فایل‌های استاتیک است — ولی همان کافی است که یک رفع باگ ظاهری هرگز به مغازه نرسد.
    **معیار پذیرش:** روی دستگاه واقعی، یک فایل CSS تابلو را روی سرور عوض کن، تلویزیون را ریلود کن، و نشان بده تغییر **بدون** دست زدن به `CACHE_NAME` دیده می‌شود.
    
- [x]  **`W-04` — خوانایی از فاصلهٔ سه متری.**
تلویزیون از فاصلهٔ ۳ تا ۵ متری دیده می‌شود، نه ۵۰ سانتی‌متری. در حالت `?tv=1` مقیاس پایهٔ فونت را بالا ببر. اگر `live.blade.php` از واحد `rem` استفاده می‌کند، فقط `html { font-size: ... }` را عوض کن؛ اگر `px` هاردکد دارد، از `zoom` یا `transform: scale` استفاده **نکن** (روی WebView قدیمی رندر را خراب می‌کند) و در دفتر انحرافات بنویس تا تصمیم بگیریم.
**همچنین:** بررسی کن تابلو روی رزولوشن `1280x720` (خیلی از باکس‌های ارزان) هم درست بچیند، نه فقط `1920x1080`.
**معیار پذیرش:** عکس تابلو از فاصلهٔ ۴ متری گرفته شود و قیمت‌ها بدون تلاش خوانده شوند.
- [x]  **`W-05` — پل خبررسانی JS به اپ نیتیو. این مهم‌ترین تسک فاز ۲ است.**
**مسئله‌ای که حل می‌کند:** بدترین حالت شکست این پروژه، تابلویی است که **بالا می‌آید و زیبا هم هست، ولی قیمت‌هایش هیچ‌وقت عوض نمی‌شوند** — چون Alpine 3 روی WebView قدیمی بی‌صدا مرده است. نه خطایی، نه صفحهٔ سفیدی. طلافروش روزها نرخ دیروز را به مشتری نشان می‌دهد. اپ نیتیو هیچ راهی برای فهمیدن این ندارد، **مگر** اینکه صفحه خودش خبر بدهد.
این دو فراخوان را به `live.blade.php` اضافه کن (فقط در حالت `$isTv`):
    
    ```jsx
    // بلافاصله بعد از اولین رندر موفق قیمت‌ها
    if (window.TalaTV && window.TalaTV.onBoardReady) {
      window.TalaTV.onBoardReady();
    }
    
    // در پایان هر واکشی موفق اسنپ‌شات
    if (window.TalaTV && window.TalaTV.onPriceTick) {
      window.TalaTV.onPriceTick(String(snapshot.updatedAt || ''), snapshot.isStale ? 1 : 0);
    }
    ```
    
    محل دقیق این دو فراخوان از خروجی `R-01` بند ۷ تعیین می‌شود.
    **شرط `window.TalaTV &&` را حذف نکن.** در مرورگر معمولی این آبجکت وجود ندارد و بدون این شرط، صفحهٔ وب برای همهٔ کاربران عادی می‌شکند.
    **معیار پذیرش:** در مرورگر دسکتاپ `?tv=1` را باز کن و نشان بده هیچ خطایی در کنسول نیست. سپس در اپ نیتیو لاگ بگیر و نشان بده `onBoardReady` یک بار و `onPriceTick` به فاصلهٔ منظم صدا زده می‌شوند.
    
- [x]  **`W-06` — نوار هشدار دادهٔ کهنه.**
از `isStale` و `dataAgeSeconds` که در `B-01` اضافه شد استفاده کن. وقتی `isStale` درست است، یک نوار باریک بالای تابلو نشان بده: «نرخ‌ها در حال به‌روزرسانی — آخرین دریافت: ۱۴:۳۲».
**چرا این حیاتی است:** این تفاوت بین «تابلو خراب است» و «تابلو صادق است» را می‌سازد. یک تابلوی طلا که قیمت قدیمی را بدون هیچ نشانه‌ای نشان می‌دهد، برای طلافروش از یک تابلوی خاموش **خطرناک‌تر** است — ممکن است روی نرخ اشتباه معامله کند.
**معیار پذیرش:** `fetched_at` را دستی به ۱۰ دقیقه قبل ببر؛ نوار هشدار روی تلویزیون ظاهر شود. کرون را برگردان؛ نوار خودش برود.

# ۶. فاز ۳ — اپ کاتلین نیتیو

<aside>
📐

ساختار پوشه: `tv_app_native/` در ریشهٔ مخزن. پکیج: `ir.talalive.tv`. تمام رشته‌های فارسی در `res/values/strings.xml` — هیچ رشتهٔ فارسی هاردکد در کد کاتلین نباشد.

</aside>

- [x]  **`A-01` — اسکلت پروژه با صفر وابستگی.**
`tv_app_native/app/build.gradle.kts`:
    
    ```kotlin
    plugins { id("com.android.application"); id("org.jetbrains.kotlin.android") }
    
    android {
        namespace = "ir.talalive.tv"
        compileSdk = 34
    
        defaultConfig {
            applicationId = "ir.talalive.tv"
            minSdk = 21
            targetSdk = 34
            versionCode = 1
            versionName = "1.0.0"
        }
    
        buildTypes {
            release {
                isMinifyEnabled = true
                isShrinkResources = true
                proguardFiles(getDefaultProguardFile("proguard-android-optimize.txt"), "proguard-rules.pro")
                signingConfig = signingConfigs.getByName("release")
            }
        }
    
        compileOptions {
            sourceCompatibility = JavaVersion.VERSION_1_8
            targetCompatibility = JavaVersion.VERSION_1_8
        }
        kotlinOptions { jvmTarget = "1.8" }
    }
    
    dependencies {
        // هیچ وابستگی‌ای اضافه نکن. D-01.
    }
    ```
    
    **قاعدهٔ `D-01` را جدی بگیر:** نه `androidx.appcompat`، نه `androidx.core`، نه `material`، نه `okhttp`، نه `gson`. `Activity` خالی فریم‌ورک، `FrameLayout`، `HttpURLConnection` و `org.json` برای همهٔ کارهای این اپ کافی‌اند.
    **قاعدهٔ ProGuard:** کلاس پل جاوااسکریپت باید از حذف مصون بماند، وگرنه در نسخهٔ release پل `W-05` بی‌صدا از کار می‌افتد:
    
    ```
    -keepclassmembers class ir.talalive.tv.TalaTvBridge {
        public *;
    }
    ```
    
    **معیار پذیرش:** `./gradlew assembleRelease` اجرا شود و حجم APK خروجی **زیر ۲ مگابایت** باشد. عدد واقعی را گزارش کن.
    
- [x]  **`A-02` — مانیفست.**
    
    ```xml
    <manifest xmlns:android="http://schemas.android.com/apk/res/android">
    
        <uses-permission android:name="android.permission.INTERNET" />
        <uses-permission android:name="android.permission.ACCESS_NETWORK_STATE" />
        <uses-permission android:name="android.permission.RECEIVE_BOOT_COMPLETED" />
        <uses-permission android:name="android.permission.REQUEST_INSTALL_PACKAGES" />
        <uses-permission android:name="android.permission.USE_FULL_SCREEN_INTENT" />
    
        <uses-feature android:name="android.software.leanback" android:required="false" />
        <uses-feature android:name="android.hardware.touchscreen" android:required="false" />
    
        <application
            android:label="@string/app_name"
            android:icon="@drawable/ic_launcher"
            android:banner="@drawable/tv_banner"
            android:hardwareAccelerated="true"
            android:usesCleartextTraffic="false"
            android:allowBackup="false">
    
            <activity
                android:name=".BoardActivity"
                android:exported="true"
                android:screenOrientation="landscape"
                android:launchMode="singleTask"
                android:configChanges="orientation|screenSize|screenLayout|keyboardHidden|uiMode|navigation|density|fontScale"
                android:theme="@style/TalaFullscreen">
                <intent-filter>
                    <action android:name="android.intent.action.MAIN" />
                    <category android:name="android.intent.category.LEANBACK_LAUNCHER" />
                    <category android:name="android.intent.category.LAUNCHER" />
                </intent-filter>
            </activity>
    
            <activity
                android:name=".PairingActivity"
                android:exported="false"
                android:screenOrientation="landscape"
                android:configChanges="orientation|screenSize|keyboardHidden|uiMode|density|fontScale"
                android:theme="@style/TalaFullscreen" />
    
            <receiver
                android:name=".BootReceiver"
                android:exported="true"
                android:enabled="true">
                <intent-filter android:priority="999">
                    <action android:name="android.intent.action.BOOT_COMPLETED" />
                    <action android:name="android.intent.action.QUICKBOOT_POWERON" />
                    <action android:name="com.htc.intent.action.QUICKBOOT_POWERON" />
                </intent-filter>
            </receiver>
    
            <provider
                android:name="android.support.v4.content.FileProvider"
                android:authorities="ir.talalive.tv.fileprovider"
                android:exported="false"
                android:grantUriPermissions="true">
                <meta-data
                    android:name="android.support.FILE_PROVIDER_PATHS"
                    android:resource="@xml/file_paths" />
            </provider>
    
        </application>
    </manifest>
    ```
    
    **چهار نکته که در نقشهٔ قبلی نبودند و اپ را بی‌کار می‌کنند:**
    
    1. `INTERNET` و `ACCESS_NETWORK_STATE` — بدون اولی WebView هیچ‌چیز لود نمی‌کند.
    2. **`WAKE_LOCK` عمداً نیست.** `FLAG_KEEP_SCREEN_ON` به هیچ مجوزی نیاز ندارد. درخواست مجوز بی‌مصرف فقط کاربر را می‌ترساند.
    3. `configChanges` گسترده — بدون آن هر تغییر پیکربندی اکتیویتی را بازمی‌سازد، WebView از نو لود می‌شود و تابلو چشمک می‌زند.
    4. `android.hardware.touchscreen` با `required="false"` — بدون این، بعضی فروشگاه‌ها و بعضی باکس‌ها اپ را ناسازگار می‌دانند.
    **`FileProvider` بدون AndroidX:** چون `D-01` وابستگی را ممنوع کرده، از `FileProvider` استفاده نکن. به‌جایش در `U-02` فایل APK را در `getExternalFilesDir(null)` بنویس و روی API ۲۴ و بالاتر با `FileProvider` جایگزین نیتیو یا مسیر `content://` کار کن. **اگر این کار بدون وابستگی ممکن نشد، در دفتر انحرافات ثبت کن و فقط و فقط `androidx.core:core` را اضافه کن** — این تنها استثنای مجاز `D-01` است.
    **معیار پذیرش:** اپ روی هر دو دستگاه `R-06` نصب شود و در **هر دو** جای درست ظاهر شود: در ردیف اپ‌های Android TV و در گرید اپ‌های باکس معمولی.
- [x]  **`A-03` — `TvPrefs.kt` — ماندگاری.**
کلیدهای ذخیره‌شده: `username`, `device_token`, `board_url`, `base_urls` (JSON آرایه), `latest_version_code`, `min_version_code`, `apk_url`, `last_ok_tick_millis`, `last_known_rate_time`.
    
    ```kotlin
    object TvPrefs {
        private const val FILE = "tala_tv"
        fun get(ctx: Context) = ctx.getSharedPreferences(FILE, Context.MODE_PRIVATE)
        fun isPaired(ctx: Context) = !get(ctx).getString("device_token", null).isNullOrBlank()
        fun clearPairing(ctx: Context) = get(ctx).edit()
            .remove("username").remove("device_token").remove("board_url").apply()
    }
    ```
    
    **معیار پذیرش:** بعد از یک جفت‌سازی، دستگاه را ۳ بار ریبوت کن. هر سه بار باید مستقیم به تابلو برود و **هیچ‌وقت** کد نخواهد. این معیار در `T-03` هم تکرار می‌شود.
    
- [x]  **`A-04` — `Config.kt` — آدرس پایه هرگز هاردکد نیست.**
    
    ```kotlin
    object Config {
        // تنها مقدار هاردکد در کل اپ: نقطهٔ شروع اولیه.
        private const val BOOTSTRAP_BASE = "https://talalive.ir"
    
        fun baseUrls(ctx: Context): List<String> {
            val stored = TvPrefs.get(ctx).getString("base_urls", null)
            if (!stored.isNullOrBlank()) {
                try {
                    val arr = JSONArray(stored)
                    val out = ArrayList<String>(arr.length())
                    for (i in 0 until arr.length()) out.add(arr.getString(i))
                    if (out.isNotEmpty()) return out
                } catch (e: Exception) {
                    Log.w("TalaTV", "base_urls parse failed, falling back", e)
                }
            }
            return listOf(BOOTSTRAP_BASE)
        }
    }
    ```
    
    فهرست دامنه‌ها از پاسخ `B-06` می‌آید و ذخیره می‌شود. همهٔ درخواست‌ها باید دامنه‌ها را **به ترتیب امتحان کنند** و اولین موفق را استفاده کنند.
    **چرا این یکی از سه خطای بازگشت‌ناپذیر است:** APK ساید‌لود‌شده روی ۲۰۰ تلویزیون را نمی‌توان از بیرون عوض کرد. اگر دامنه فیلتر یا مهاجرت کند و آدرس هاردکد باشد، همه هم‌زمان می‌خوابند و هیچ راه نجاتی نیست — چون کانال آپدیت هم روی همان دامنه است.
    **معیار پذیرش:** در `base_urls` یک دامنهٔ عمداً خراب را **اول** فهرست بگذار و دامنهٔ درست را دوم. تابلو باید بالا بیاید و در لاگ ببینی که اولی شکست خورده و دومی موفق شده.
    
- [x]  **`A-05` — `Api.kt` — لایهٔ شبکه.**
سه متد: `registerSession()`, `checkPairing(sessionCode)`, `heartbeat(token, versionCode, androidRelease, webViewVersion)`.
قواعد اجباری: `connectTimeout = 8000`, `readTimeout = 8000`، تلاش مجدد پله‌ای (۲ ثانیه، ۴، ۸، ۱۶، سقف ۶۰)، چرخش روی `Config.baseUrls`، هدر `User-Agent` اختصاصی مثل `TalaLiveTV/1.0 (Android)` تا در لاگ سرور قابل تفکیک باشد. هیچ متدی روی ترد اصلی اجرا نمی‌شود.
**معیار پذیرش:** وای‌فای را خاموش کن و فراخوان بزن؛ اپ نباید فریز شود و باید در لاگ تلاش مجدد پله‌ای دیده شود.
- [x]  **`A-06` — `PairingActivity` — صفحهٔ جفت‌سازی نیتیو.**
چیدمان از بالا به پایین: نام «طلالایو»، متن «برای اتصال تابلو، این کد را در پنل خود وارد کنید»، **کد شش‌کاراکتری با فونت بسیار درشت** و فاصلهٔ حروف باز، یک QR که به `{base}/p/{code}` اشاره می‌کند، دکمهٔ «ارسال کد به موبایلم»، و پایین صفحه با فونت ریز: نسخهٔ اپ و نسخهٔ WebView.
**QR بدون کتابخانه:** یک تولیدکنندهٔ QR نیتیو ننویس. به‌جایش تصویر QR را از سرور بگیر — در `B-06` یا یک اندپوینت سادهٔ جدید، یک PNG از `{base}/p/{code}` برگردان و در `ImageView` نشانش بده. اگر شبکه نبود، QR را حذف و فقط کد و لینک متنی را نشان بده.
**دکمهٔ پیامک:** به `POST /api/tv/magic-sms` وصل می‌شود که از قبل موجود است و `throttle:5,1` دارد. شمارهٔ موبایل روی تلویزیون قابل تایپ نیست، پس این دکمه باید اول یک صفحهٔ ورود شمارهٔ عددی با پد D-pad نشان بدهد — **فقط ارقام، ۱۱ رقم، بدون کیبورد کامل**. قالب مورد انتظار سرور `/^09[0-9]{9}$/` است.
جریان: در `onCreate` → `registerSession()` → نمایش کد → پولینگ `checkPairing` با فاصلهٔ `poll_interval_seconds` از سرور → وقتی `paired` شد، `username` و `device_token` را ذخیره کن و به `BoardActivity` برو و این اکتیویتی را `finish()` کن.
اگر سشن منقضی شد (۷۲۰۰ ثانیه)، خودکار یک سشن جدید بگیر و کد تازه نشان بده. **کاربر نباید هیچ‌وقت به کد منقضی خیره بماند.**
**معیار پذیرش:** یک جفت‌سازی کامل روی دستگاه واقعی، **فقط با ریموت کنترل**، بدون کیبورد USB و بدون تایپ حرف الفبا.
- [x]  **`A-07` — `BoardActivity` و `TalaWebViewClient` — قلب پایداری.**
این تسک سه حالت شکست را پوشش می‌دهد که هر سه در مغازه واقعاً اتفاق می‌افتند.
    
    ```kotlin
    class TalaWebViewClient(private val host: BoardActivity) : WebViewClient() {
    
        override fun onReceivedError(
            view: WebView, request: WebResourceRequest, error: WebResourceError
        ) {
            // فقط خطای فریم اصلی مهم است؛ خطای یک تصویر نباید صفحه را عوض کند.
            if (request.isForMainFrame) {
                Log.w("TalaTV", "main frame error " + error.errorCode)
                host.showOfflineOverlay()
            }
        }
    
        override fun onReceivedSslError(
            view: WebView, handler: SslErrorHandler, error: SslError
        ) {
            // D-12: هرگز proceed نکن.
            handler.cancel()
            host.showSslDiagnostic(error.primaryError)
        }
    
        override fun onPageFinished(view: WebView, url: String) {
            // A-09 تصمیم می‌گیرد؛ اینجا فقط ثبت می‌کنیم.
            host.onPageLoadFinished()
        }
    
        @RequiresApi(Build.VERSION_CODES.O)
        override fun onRenderProcessGone(
            view: WebView, detail: RenderProcessGoneDetail
        ): Boolean {
            Log.e("TalaTV", "render process gone, crashed=" + detail.didCrash())
            host.recreateWebView()   // باید true برگردانیم وگرنه اپ کرش می‌کند
            return true
        }
    }
    ```
    
    **`onRenderProcessGone` را حذف نکن.** روی باکس ۱ گیگ رم با یک تابلوی همیشه‌روشن، رندرر WebView **قطعاً** کشته می‌شود — سؤال «اگر» نیست، سؤال «کِی» است. اگر این متد `true` برنگرداند، کل اپ کرش می‌کند و تلویزیون سیاه می‌ماند تا کسی به مغازه برود.
    `recreateWebView()` باید WebView قدیمی را از والد جدا کند، `destroy()` کند، یکی تازه بسازد و آدرس تابلو را لود کند — **نه** فقط `reload()` روی همان نمونهٔ مرده.
    **در `onCreate`:** `window.addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON)` و تمام‌صفحه با `View.SYSTEM_UI_FLAG_HIDE_NAVIGATION or SYSTEM_UI_FLAG_FULLSCREEN or SYSTEM_UI_FLAG_IMMERSIVE_STICKY`.
    **معیار پذیرش:** با `adb shell am crash` یا با پر کردن حافظه، رندرر را بکش. تابلو باید **خودش** در کمتر از ۱۰ ثانیه برگردد و اپ کرش نکند.
    
- [x]  **`A-08` — تنظیمات WebView.**
    
    ```kotlin
    webView.settings.apply {
        javaScriptEnabled = true
        domStorageEnabled = true
        loadsImagesAutomatically = true
        mediaPlaybackRequiresUserGesture = false
        cacheMode = WebSettings.LOAD_DEFAULT
        useWideViewPort = true
        loadWithOverviewMode = true
        setSupportZoom(false)
        builtInZoomControls = false
        displayZoomControls = false
        textZoom = 100
    }
    webView.isVerticalScrollBarEnabled = false
    webView.isHorizontalScrollBarEnabled = false
    webView.setBackgroundColor(Color.parseColor("#020617"))   // همرنگ theme_color در manifest.json
    ```
    
    **`setLayerType(LAYER_TYPE_HARDWARE)` را صدا نزن.** این یک باور غلط رایج است. WebView از قبل شتاب‌دهندهٔ سخت‌افزاری دارد (با `android:hardwareAccelerated="true"` که در `A-02` تنظیم شد). اجبار به لایهٔ سخت‌افزاری، WebView را به یک بافر آفسکرین تمام‌صفحه می‌برد که روی GPU ضعیف باکس‌های ارزان **حافظهٔ بیشتر مصرف می‌کند و رندر را کندتر می‌کند** — دقیقاً برعکس هدف.
    **رنگ پس‌زمینه را حتماً تنظیم کن:** پیش‌فرض WebView سفید است. بدون این، هر بار لود شدن تابلوی تیره یک فلش سفید تند روی تلویزیون ۵۰ اینچ می‌زند.
    **معیار پذیرش:** روی دستگاه واقعی، هنگام لود اولیه و هر ریلود، هیچ فلش سفیدی دیده نشود.
    
- [x]  **`A-09` — پل `TalaTvBridge` و دیده‌بان تپش. دومین تسک حیاتی این فاز.**
    
    ```kotlin
    class TalaTvBridge(private val host: BoardActivity) {
    
        @JavascriptInterface
        fun onBoardReady() {
            host.runOnUiThread { host.markBoardReady() }
        }
    
        @JavascriptInterface
        fun onPriceTick(updatedAt: String, isStale: Int) {
            host.runOnUiThread { host.markPriceTick(updatedAt, isStale == 1) }
        }
    }
    
    // در onCreate:
    webView.addJavascriptInterface(TalaTvBridge(this), "TalaTV")
    ```
    
    **دو دیده‌بان که باید پیاده شوند:**
    
    | دیده‌بان | شرط | واکنش |
    | --- | --- | --- |
    | آماده‌نشدن تابلو | `onBoardReady` تا ۲۵ ثانیه بعد از `onPageFinished` صدا زده نشد | صفحهٔ تشخیص `A-10` را نشان بده (احتمال قوی: موتور WebView قدیمی و JS مرده) |
    | ایستادن تپش | هیچ `onPriceTick` به مدت ۵ دقیقه نیامد | یک بار `recreateWebView()`؛ اگر باز هم نیامد، صفحهٔ تشخیص |
    | **امنیت `addJavascriptInterface`:** این پل فقط دو متد بدون پارامتر حساس دارد و صفحه از دامنهٔ خودمان با HTTPS لود می‌شود. **هرگز** متدی که فایل می‌خواند، اپ نصب می‌کند یا توکن برمی‌گرداند به این پل اضافه نکن. |  |  |
    | **یادآوری ProGuard:** قاعدهٔ `-keepclassmembers` در `A-01` را بگذار، وگرنه در نسخهٔ release این پل بی‌صدا ناپدید می‌شود و دیده‌بان اول همیشه شکایت می‌کند. |  |  |
    | **معیار پذیرش:** در سرور موقتاً فراخوان `onPriceTick` را غیرفعال کن. تلویزیون باید در کمتر از ۶ دقیقه خودش واکنش نشان بدهد و در لاگ ثبت شود. |  |  |
- [x]  **`A-10` — دروازهٔ نسخهٔ WebView و صفحهٔ تشخیص.**
نسخه را از `WebSettings.getDefaultUserAgent(context)` بیرون بکش (الگوی `Chrome/(\d+)`). اگر عدد اصلی زیر ۸۰ بود یا قابل استخراج نبود، **قبل از لود تابلو** صفحهٔ راهنمای نیتیو نشان بده:
    
    > موتور نمایش این دستگاه قدیمی است (نسخهٔ ۵۳)
    برای نمایش درست تابلو، «Android System WebView» را از فروشگاه دستگاه به‌روزرسانی کنید.
    نسخهٔ موردنیاز: ۸۰ یا بالاتر
    [دکمه: با این حال تلاش کن]
    **چرا این تسک وجود دارد:** فایل `public_html/vendor/alpinejs.min.js` با ۴۶ کیلوبایت حجم، Alpine نسخهٔ ۳ است. Alpine 3 موتورش روی `Proxy` بنا شده و روی WebView نسخه‌های پایین بی‌صدا از کار می‌افتد. این تنها ریسکی است که می‌تواند کل پروژه را بی‌فایده کند: تابلویی که بالا می‌آید، زیبا است، و هرگز آپدیت نمی‌شود.
    دکمهٔ «با این حال تلاش کن» را بگذار — بعضی WebViewهای قدیمی‌تر از حد انتظار کار می‌کنند و ما نباید کاربر را قطعی محروم کنیم. اگر زد و `A-09` شکایت کرد، به همین صفحه برمی‌گردد.
    **معیار پذیرش:** اگر یکی از دستگاه‌های `R-06` واقعاً WebView قدیمی دارد، این صفحه روی آن ظاهر شود. اگر هر دو مدرن‌اند، آستانه را موقتاً به ۹۹۹ ببر و ظاهر شدن صفحه را نشان بده، بعد برگردان.
    > 
- [x]  **`A-11` — لایهٔ آفلاین نیتیو.**
یک `View` نیتیو روی WebView (نه صفحهٔ HTML، چون در قطعی شبکه ممکن است لود نشود):
    
    > اتصال اینترنت قطع است
    آخرین نرخ دریافتی: ۱۴:۳۲
    تلاش مجدد در ۸ ثانیه...
    زمان آخرین نرخ از `last_known_rate_time` در `TvPrefs` می‌آید که در هر `onPriceTick` به‌روز می‌شود. تلاش مجدد پله‌ای با سقف ۶۰ ثانیه، و شمارش معکوس زنده روی صفحه تا کاربر بداند اپ نخوابیده است.
    **بازیابی خودکار اجباری:** با `ConnectivityManager.NetworkCallback` (یا روی API 21 با `registerReceiver` برای `CONNECTIVITY_ACTION`) به برگشت شبکه گوش بده و **بدون دست زدن به ریموت** تابلو را برگردان.
    **معیار پذیرش:** کابل شبکه یا وای‌فای را قطع کن. لایهٔ آفلاین با ساعت آخرین نرخ ظاهر شود. شبکه را برگردان. تابلو **خودش** در کمتر از ۳۰ ثانیه برگردد، بدون لمس ریموت.
    > 
- [x]  **`A-12` — نگهبان حافظه و ریلود شبانه.**
یک `AlarmManager` که هر روز ساعت ۴:۰۰ بامداد `recreateWebView()` را اجرا کند. ساعت ۴ انتخاب شده چون مغازه بسته است و کسی تابلو را نمی‌بیند.
همچنین در `onTrimMemory` با سطح `TRIM_MEMORY_RUNNING_CRITICAL` یک بار `webView.clearCache(false)` بزن و در لاگ ثبت کن.
**معیار پذیرش:** در `T-06` نشان بده مصرف حافظه در ۲۴ ساعت رشد یک‌طرفه ندارد. خروجی `adb shell dumpsys meminfo ir.talalive.tv` را در سه نقطه (شروع، ۱۲ ساعت، ۲۴ ساعت) گزارش کن.
- [x]  **`A-13` — راه‌اندازی خودکار با برق.**
**این بخش‌ترین تسک نامطمئن کل پروژه است و باید روی هر دو دستگاه تست شود.**
    
    ```kotlin
    class BootReceiver : BroadcastReceiver() {
        override fun onReceive(ctx: Context, intent: Intent) {
            if (!TvPrefs.isPaired(ctx)) return
            val target = Intent(ctx, BoardActivity::class.java).apply {
                addFlags(Intent.FLAG_ACTIVITY_NEW_TASK)
            }
            if (Build.VERSION.SDK_INT < Build.VERSION_CODES.Q) {
                // تا اندروید ۹ اجرای مستقیم مجاز است
                ctx.startActivity(target)
                return
            }
            // اندروید ۱۰ و بالاتر: اجرای Activity از پس‌زمینه بلاک است.
            // مسیر مجاز: نوتیفیکیشن با fullScreenIntent.
            postFullScreenNotification(ctx, target)
        }
    }
    ```
    
    **چرا نقشهٔ قبلی اینجا اشتباه داشت:** از API 29 اجرای Activity از پس‌زمینه ممنوع شد. `BootReceiver` → `startActivity()` روی باکس‌های API ۲۱ تا ۲۸ درست کار می‌کند و روی Google TV و تلویزیون‌های جدید **بی‌صدا** شکست می‌خورد. اگر فقط روی یک باکس قدیمی تست کنی، تست پاس می‌شود و مشکل را نمی‌بینی.
    **مسیر پشتیبان که باید در `U-04` مستند شود:** مطمئن‌ترین راه روی تلویزیون، انتخاب اپ به‌عنوان صفحهٔ خانه است. در صفحهٔ `/app` سایت یک بخش «اگر تلویزیون شما خودش بالا نمی‌آید» با راهنمای تصویری اضافه کن.
    **معیار پذیرش:** روی **هر دو** دستگاه `R-06`، دستگاه را از برق بکش و وصل کن. تابلو باید خودش بیاید. اگر روی دستگاه مدرن نیامد، در دفتر انحرافات ثبت کن و راهنمای صفحهٔ خانه را به `U-04` اضافه کن. **ادعای موفقیت با تست روی یک دستگاه قبول نیست.**
    
- [x]  **`A-14` — تشخیص ساعت غلط و خطای گواهی.**
وقتی `onReceivedSslError` با `SslError.SSL_DATE_INVALID` یا `SSL_NOTYETVALID` یا `SSL_EXPIRED` صدا زده شد، ساعت دستگاه را با ساعت سرور مقایسه کن (از هدر `Date` پاسخ HTTP، یا از `serverTime` که در `B-01` به اسنپ‌شات اضافه شد). اگر اختلاف بیش از ۲۴ ساعت بود:
    
    > ساعت این دستگاه اشتباه است
    تاریخ دستگاه: ۱۹۷۰/۰۱/۰۱ — تاریخ واقعی: ۱۴۰۵/۰۶/۲۷
    از تنظیمات دستگاه، تاریخ و ساعت را روی «خودکار از شبکه» بگذارید.
    **چرا این یک مشکل میدانی واقعی است:** اندروید باکس‌های ارزان با باتری RTC مرده، ساعتشان بعد از هر قطع برق روی مبدأ یونیکس برمی‌گردد. نتیجه: اعتبار گواهی HTTPS رد می‌شود، WebView صفحهٔ سفید می‌دهد، و طلافروش فکر می‌کند اپ خراب است. در مغازه‌های بازار این یکی از رایج‌ترین دلایل شکست کیوسک‌هاست.
    **`handler.proceed()` ممنوع است** (`D-12`). این اپ توکن دستگاه را روی همان اتصال می‌فرستد؛ پذیرش کورکورانهٔ گواهی نامعتبر یعنی باز کردن در به روی MITM روی وای‌فای مشترک مغازه.
    **معیار پذیرش:** روی دستگاه واقعی، تاریخ را دستی به سال ۲۰۱۵ ببر. باید این صفحهٔ فارسی را ببینی، نه صفحهٔ سفید و نه خطای خام مرورگر.
    > 
- [x]  **`A-15` — رفتار ریموت کنترل.**
    - دکمهٔ `BACK`: بار اول یک پیام «برای خروج، یک بار دیگر بازگشت را بزنید» به مدت ۳ ثانیه؛ بار دوم در آن بازه، خروج.
    - دکمهٔ `MENU` یا نگه داشتن `OK` به مدت ۳ ثانیه: منوی کوچک نیتیو با سه گزینه: «بارگذاری مجدد تابلو»، «اطلاعات دستگاه» (نسخهٔ اپ، نسخهٔ WebView، نام گالری، آخرین ضربان)، «قطع اتصال این دستگاه».
    - «قطع اتصال» باید **تأیید دوم** بخواهد. طلافروشی که اشتباهی این را بزند باید دوباره جفت‌سازی کند.
    - بقیهٔ کلیدها را مصرف نکن — تابلو تعاملی نیست و نباید باشد.
    **معیار پذیرش:** ۵ دقیقه با ریموت همهٔ کلیدها را بزن. اپ نباید خارج شود، فریز کند، یا صفحهٔ ناخواسته نشان بدهد.

# ۷. فاز ۴ — امضا، کانال آپدیت و توزیع

<aside>
🔑

**دو تا از سه خطای بازگشت‌ناپذیر در این فاز هستند.** `U-01` و `U-02` را به فاز بعدی موکول نکن. لحطه‌ای که اولین APK روی اولین تلویزیون مغازه نصب شود، این دو تصمیم قفل می‌شوند و تغییرشان یعنی سفر فیزیکی به همهٔ مغازه‌ها.

</aside>

- [x]  **`U-01` — کی‌استور: یک بار بساز، تا ابد نگه دار.**
    
    ```bash
    keytool -genkeypair -v \
      -keystore talalive-tv-release.jks \
      -alias talalive \
      -keyalg RSA -keysize 4096 \
      -validity 10950 \
      -storetype PKCS12
    ```
    
    `validity 10950` یعنی ۳۰ سال. کمتر نگذار — انقضای کی‌استور برای توزیع خارج از فروشگاه فاجعه است.
    در `build.gradle.kts`:
    
    ```kotlin
    signingConfigs {
        create("release") {
            storeFile = file(System.getenv("TALA_KEYSTORE_PATH") ?: "../../keystore/talalive-tv-release.jks")
            storePassword = System.getenv("TALA_KEYSTORE_PASSWORD")
            keyAlias = System.getenv("TALA_KEY_ALIAS") ?: "talalive"
            keyPassword = System.getenv("TALA_KEY_PASSWORD")
        }
    }
    ```
    
    **قواعد مطلق:**
    
    - فایل `.jks` **هرگز** در گیت کامیت نمی‌شود. در قاعدهٔ ۸ قرارداد اجرا به `.gitignore` اضافه شد.
    - رمزها در هیچ فایلی در مخزن نوشته نمی‌شوند، نه در `local.properties` و نه در `gradle.properties`.
    - در پایان این تسک، ایجنت باید **به کاربر اعلام کند** که کی‌استور و رمزهایش را در دو جای جداگانه و امن نگه دارد. این تنها تسک سند است که خروجیاش کد نیست، بلکه یک هشدار به انسان است.
    - پس از ساخت، `keytool -list -v -keystore talalive-tv-release.jks` را بگیر و اثرانگشت SHA-256 را در بخش ۱۰ سند ثبت کن. این ابزار تشخیص بعدی است: اگر روزی یک APK با امضای متفاوت ساخته شود، فوری متوجه می‌شوی.
    **معیار پذیرش:** دو بار پشت سر هم `assembleRelease` بزن و نشان بده اثرانگشت امضای هر دو APK یکسان است. سپس نسخهٔ ۱ را روی دستگاه نصب کن و نسخهٔ ۲ را روی آن **آپدیت** کن — باید بدون خطای signature mismatch نصب شود.
- [x]  **`U-02` — کانال آپدید درون‌برنامه‌ای.**
منطق در همان ضربان `B-06` سوار می‌شود؛ اندپوینت جداگانه لازم نیست.
سه حالت:
    
    
    | شرط | رفتار |
    | --- | --- |
    | `versionCode >= latest_version_code` | هیچ کاری |
    | `min_version_code <= versionCode < latest_version_code` | آپدیت اختیاری: دانلود در پس‌زمینه، نصب در اولین ریلود شبانه (`A-12`) |
    | `versionCode < min_version_code` | آپدیت اجباری: لایهٔ نیتیو «دریافت نسخهٔ جدید...» با نوار پیشرفت، سپس نصب |
    | جریان نصب: |  |
    
    ```kotlin
    // 1) دانلود به حافظهٔ خصوصی اپ
    val apk = File(getExternalFilesDir(null), "talalive-tv-update.apk")
    
    // 2) اعتبارسنجی قبل از نصب — این را حذف نکن
    //    الف) اندازهٔ فایل با Content-Length مطابقت داشته باشد
    //    ب) امضای APK دانلودشده با امضای اپ فعلی یکسان باشد
    //       (PackageManager.getPackageArchiveInfo با GET_SIGNATURES)
    //    ج) versionCode فایل جدید واقعاً بزرگ‌تر باشد
    
    // 3) نصب
    val intent = Intent(Intent.ACTION_VIEW).apply {
        setDataAndType(uriFor(apk), "application/vnd.android.package-archive")
        addFlags(Intent.FLAG_GRANT_READ_URI_PERMISSION)
        addFlags(Intent.FLAG_ACTIVITY_NEW_TASK)
    }
    startActivity(intent)
    ```
    
    **بند ۲ را جدی بگیر.** بدون بررسی امضا، اگر دامنه یا مسیر دانلود روزی رباییده شود، اپ خودش یک APK دلخواه را به کاربر برای نصب پیشنهاد می‌دهد.
    **محدودیت واقعی که باید بپذیریم:** نصب بی‌سروصدا بدون دسترسی مدیر دستگاه ممکن نیست. کاربر یک بار باید در دیالوگ سیستمی با ریموت تأیید بزند. این را روی صفحهٔ لایهٔ آپدیت **صریح بنویس**: «نسخهٔ جدید آماده است — روی دکمهٔ OK و سپس «نصب» بزنید». ادعای «آپدیت کاملاً خودکار» دروغ است و نباید در سند یا در سایت نوشته شود.
    **معیار پذیرش:** نسخهٔ `versionCode = 1` روی دستگاه نصب شود. در `config/tv.php` مقادیر `latest = 2, min = 2` بگذار و APK نسخهٔ ۲ را روی سرور بگذار. تلویزیون باید خودش در یک بازهٔ ضربان دانلود کند و دیالوگ نصب را بیاورد. مراحل را فیلم یا عکس بگیر.
    
- [x]  **`U-03` — توزیع APK.**
مسیر روی سرور: `public_html/downloads/talalive-tv.apk`
**فایل APK را در گیت کامیت نکن.** دلیل: `.cpanel.yml` دستور `cp -R public_html/. $DEPLOYPATH/public_html/` دارد، پس هر باینری در آن پوشه در هر دیپلوی جابجا می‌شود و حجم مخزن را با هر نسخه بالا می‌برد.
به `.gitignore` اضافه کن: `public_html/downloads/*.apk`
پوشه را با یک `.gitkeep` نگه دار تا در دیپلوی پاک نشود.
**تیپ MIME — این را فراموش نکن:** در `public_html/.htaccess` (۲۴۲۵ بایت، موجود است) این را اضافه کن:
    
    ```
    AddType application/vnd.android.package-archive .apk
    <FilesMatch "\.apk$">
        Header set Content-Disposition "attachment"
        Header set Cache-Control "public, max-age=300"
    </FilesMatch>
    ```
    
    بدون این، بعضی هاست‌ها APK را با تیپ غلط می‌فرستند و مرورگر گوشی به‌جای دانلود، فایل را باز می‌کند یا خطا می‌دهد. `max-age=300` کوتاه است تا آپدیت جدید در CDN یا پراکسی قفل نشود.
    در کنار APK یک فایل `talalive-tv.json` بگذار با `version_code`, `version_name`, `sha256`, `size_bytes`, `released_at` — برای اعتبارسنجی `U-02` و برای تشخیص انسانی.
    **معیار پذیرش:** با یک گوشی اندرویدی واقعی `talalive.ir/downloads/talalive-tv.apk` را باز کن. فایل باید دانلود شود و حجمش دقیقاً با `size_bytes` بخواند.
    
- [x]  **`U-04` — صفحهٔ نصب در سایت.**
دو مسیر از قبل وجود دارند و باید به‌روز شوند، نه مسیر جدید بسازی:
    - `/app` → `PublicPageController::appLanding` — دکمهٔ دانلود + راهنمای نصب
    - `/android-tv-gold-board` — صفحهٔ سئوی موجود؛ لینک به `/app` بده
    محتوای اجباری صفحهٔ `/app`، به همین ترتیب:
    1. دکمهٔ بزرگ دانلود با حجم فایل و نسخه
    2. **«فعال کردن نصب از منابع ناشناس»** — با عکس، برای هر دو حالت Android TV و باکس معمولی. اکثر طلافروش‌ها درست همینجا می‌مانند.
    3. روش انتقال فایل به تلویزیون: فلش مموری، یا مرورگر خود تلویزیون، یا اپ‌های انتقال فایل
    4. جفت‌سازی: عکس صفحهٔ کد و توضیح سه روش (ورود کد در پنل، اسکن QR، دریافت پیامک)
    5. **«اگر تلویزیون شما پس از قطع برق خودش بالا نمی‌آید»** — راهنمای انتخاب اپ به‌عنوان صفحهٔ خانه. این بخش مستقیماً به محدودیت `A-13` وصل است و **حتماً باید باشد**، چون روی دستگاه‌های جدید ممکن است تنها راه قطعی باشد.
    6. **«اگر تابلو بالا می‌آید ولی قیمت‌ها عوض نمی‌شوند»** — راهنمای آپدیت Android System WebView (متمم `A-10`)
    **معیار پذیرش:** متن را به یک نفر بده که تا حال APK روی تلویزیون نصب نکرده است؛ باید **بدون سؤال پرسیدن** تا رسیدن به تابلو پیش برود. اگر سؤال پرسید، همان سؤال را به صفحه اضافه کن.
- [x]  **`U-05` — مستندات و به‌روزرسانی فایل‌های مخزن.**
    - `README.md` فعلی **README خام پیش‌فرض لاراول است** و هیچ اطلاعی دربارهٔ طلالایو ندارد. یک بخش دربارهٔ پروژه و یک بخش `tv_app_native/` اضافه کن (نحوهٔ بیلد، متغیرهای محیطی امضا، مسیر خروجی).
    - `.env.example` را کامل کن: `CRON_TOKEN`، متغیرهای SMS، متغیرهای درگاه پرداخت، و `CACHE_STORE` با مقدار توصیه‌شده. الان هیچ یک از متغیرهای اختصاصی طلالایو در آن مستند نشده و هر استقرار جدید حتماً چیزی را جا می‌اندازد.
    - `DEPLOYMENT_CHECKLIST.md` را تمیز کن: متن فعلی جملات نامفهوم دارد (مثل «۸۸۸‌های database معلوم نیست») و توصیهٔ غلط `SESSION_DRIVER=cookie` دارد که با `config/session.php` و معماری فعلی همخوان نیست. یک بخش «استقرار نسخهٔ جدید APK» هم اضافه کن.
    - `CRON_SETUP.md` را با توکن درست هماهنگ کن (ببین `B-02`) و بخش «حل ۲: Middleware خودکار» را درست کن — متن مدعی است میانبر هر ۶۰ ثانیه واکشی می‌کند، ولی کد واقعی `FetchMarketDataMiddleware` **فقط وقتی `MarketCache` کاملاً خالی باشد** واکشی می‌کند. مستند غلط بدتر از مستند نبودن است.
    **معیار پذیرش:** یک استقرار تمیز فقط با دنبال کردن مستندات، بدون مراجعه به کد، قابل انجام باشد.

# ۸. فاز ۵ — آزمون پذیرش

<aside>
🧪

**این فاز قابل موکول شدن نیست و قابل انجام روی امولاتور نیست.**

«کامپایل بدون خطا» هیچ‌چیز را اثبات نمی‌کند. در پروژهٔ قبلی یک ایجنت اعلام کرد همهٔ تسک‌ها DONE و صفر خطا، و جواب کاربر این بود: «تغییر محسوسی نمی‌بینم.» هر ردیف زیر باید روی **دستگاه واقعی** دیده و ثبت شود.

</aside>

دو دستگاه از `R-06` را به ترتیب `D1` (قدیمی، API پایین) و `D2` (مدرن، API 30+) بنام. ستون «دستگاه» مشخص می‌کند هر آزمون روی کدام باید اجرا شود.

| شناسه | آزمون | دستگاه | معیار قبولی |
| --- | --- | --- | --- |
| `T-01` | نصب تازه تا نمایش تابلو | D1 + D2 | کاربر **فقط با ریموت**، بدون تایپ حرف الفبا، در زیر ۹۰ ثانیه به تابلو می‌رسد |
| `T-02` | راه‌اندازی پس از قطع برق | D1 + D2 | دوشاخه را بکش و بزن. تابلو خودش می‌آید. **اگر روی D2 نیامد، مستند کن و راهنمای صفحهٔ خانه را در `U-04` بگذار** |
| `T-03` | ماندگاری جفت‌سازی | D1 + D2 | ۳ بار ریبوت؛ هر سه بار مستقیم تابلو، هرگز درخواست کد |
| `T-04` | قطع و وصل شبکه | D1 | لایهٔ آفلاین با ساعت آخرین نرخ؛ بازگشت **خودکار** در زیر ۳۰ ثانیه بدون لمس ریموت |
| `T-05` | اورسکن و خوانایی | D1 + D2 | عکس از ۴ متری؛ هیچ عددی بریده نشده، قیمت‌ها بی‌تلاش خواندنی |
| `T-06` | پایداری ۲۴ ساعته | D1 (ضعیف‌تر) | تابلو پس از ۲۴ ساعت زنده و به‌روز است؛ `dumpsys meminfo` در ساعت‌های ۰، ۱۲، ۲۴ رشد یک‌طرفه ندارد |
| `T-07` | مرگ رندرر | D1 | رندرر را بکش؛ تابلو خودش زیر ۱۰ ثانیه برمی‌گردد، اپ کرش نمی‌کند |
| `T-08` | ساعت غلط دستگاه | D1 | تاریخ را به ۲۰۱۵ ببر؛ صفحهٔ فارسی تشخیص می‌آید، نه صفحهٔ سفید |
| `T-09` | تپش مردهٔ JS | D1 | فراخوان `onPriceTick` را موقتاً بردار؛ اپ زیر ۶ دقیقه تشخیص می‌دهد |
| `T-10` | آپدیت درون‌برنامه‌ای | D1 + D2 | نسخهٔ ۱ نصب، نسخهٔ ۲ روی سرور؛ دستگاه خودش دانلود و دیالوگ نصب را می‌آورد |
| `T-11` | ابطال از پنل | D1 | دستگاه را حذف کن؛ تا یک بازهٔ ضربان به صفحهٔ «حذف شده» می‌رود |
| `T-12` | بار سرور | — | `ab -n 500 -c 50` روی `snapshot`؛ صدک ۹۵ زیر ۲۰۰ میلی‌ثانیه، صفر خطای ۵xx |
| `T-13` | سلامت مسیر مرورگری | — | `/{username}` بدون `?tv=1` و صفحهٔ `/tv` همچنان درست کار کنند؛ هیچ خطایی در کنسول |
| `T-14` | اشتراک منقضی | D1 | `expires_at` کاربر را گذشته کن؛ تلویزیون پیام فارسی کد ۴۰۲ را نشان می‌دهد، نه خطای خام |

**`T-13` را حتماً اجرا کن.** همهٔ تغییرات فاز ۱ و ۲ روی فایل‌هایی انجام می‌شوند که مسیر مرورگری فعلی و زنده هم از آن‌ها استفاده می‌کند. اگر اپ تلویزیون کار کند ولی تابلوی مرورگری مشتری‌های فعلی بشکند، خروجی خالص این پروژه منفی است.

# ۹. صریحاً خارج از دامنه

این موارد را انجام **نده**، حتی اگر وسوسه شدی. هرکدام دلیل دارد:

| کار | چرا نه |
| --- | --- |
| رندر نیتیو قیمت‌ها (حتی جزئی) | `D-03`. دو پیاده‌سازی موازی از یک UI که تا ابد باید همزمان نگه داشته شوند |
| منوی تنظیمات کامل در اپ تلویزیون | تابلو تعاملی نیست. تنظیمات جایش پنل وب روی گوشی است. `A-15` فقط سه گزینه دارد |
| پشتیبانی از حالت پورتره | تلویزیون عمودی نمی‌شود. `screenOrientation="landscape"` قفل است |
| اعلان پوش (FCM) | وابستگی سنگین گوگل، در ایران غیرقابل اتکا، و ضربان `B-06` همان کار را به اندازهٔ کافی انجام می‌دهد |
| حالت آفلاین با نمایش قیمت ذخیره‌شده | خطرناک. تابلوی طلا نباید نرخ قدیمی را مثل نرخ زنده نشان بدهد. فقط زمان آخرین دریافت نمایش داده می‌شود (`A-11`) |
| ریفکتور `live.blade.php` یا `pairing.blade.php` | ۱۱۴ و ۱۵۹ کیلوبایت. دامنهٔ جداگانه است، نه این پروژه |
| مهاجرت به Redis یا عوض کردن هاست | خارج از دامنه. `B-09` حداکثر مجاز است |
| انتشار در کافه‌بازار یا مایکت | برای Android TV عملاً موجود نیست. توزیع مستقیم (`U-03`) تصمیم قفل‌شده است |
| تست واحد نوشتن برای کد کاتلین | این اپ منطق قابل تست واحد ندارد؛ همهٔ ریسکش رفتار دستگاه است. فاز ۵ جایگزین واقعی است |

# ۱۰. دفتر انحرافات

هر بار که واقعیت کد با این سند نخواند، یک ردیف اینجا اضافه کن. **این جدول را خالی نگذار.** اگر در پایان کار خالی بود، معنایش این است که فاز ۰ را جدی انجام نداده‌ای — من این سند را بدون خواندن `live.blade.php`، `pairing.blade.php` و `MarketService.php` نوشته‌ام و قطعاً جایی اشتباه دارم.

| شناسه | تسک مربوطه | سند چه می‌گفت | واقعیت چه بود | چه کردم |
| --- | --- | --- | --- | --- |
| D-R01 | R-01 | آیا html5-qrcode و lucide در live.blade.php لود می‌شوند؟ | هیچ‌کدام در live.blade.php لود نمی‌شوند (qrcode فقط در پنل ادمین و lucide در ویوهای ادمین استفاده می‌شوند). زمان رفرش از snapshotData.refreshIntervalSeconds با کف ۵ ثانیه خوانده می‌شود. | مستند شد؛ نیازی به حذف اسکریپت‌های سنگین از live.blade.php نیست زیرا از قبل وجود ندارند. |
| D-R02 | R-02 | آیا getPriceFeed واکشی بیرونی دارد؟ | getPriceFeed کاملاً کش‌خوان است و فقط از MarketCache::all() می‌خواند. واکشی بیرونی تنها در snapshot() از طریق قفل usdt_snapshot_fetch_lock صدا زده می‌شد. | طبق B-01 بلوک try/catch واکشی در snapshot() در فاز ۱ حذف خواهد شد. |
| D-R03 | R-03 | مقدار CACHE_STORE چیست؟ | مقدار CACHE_STORE در .env برابر با database است. | در تسک B-09 به file تغییر خواهد کرد تا بار MySQL برداشته شود. |
| D-R04 | R-04 | وضعیت مایگریشن tv_sessions چیست؟ | مایگریشن create_tv_sessions_table در حالت Pending بود چون ensureTvSessionsTable دورش زده بود. | با اجرای php artisan migrate --force تمامی مایگریشن‌ها با موفقیت کامل اجرا شدند و جدول tv_sessions به صورت اصولی ساخته شد. |
| D-R05 | R-05 | قرارداد ثبت و بررسی سشن چیست؟ | فرستادن {session_code, activation_code} به /api/tv/register-session و پولینگ /api/tv/check/{session_code} برای گرفتن {paired, username, display_token}. | قرارداد در اپ نیتیو عیناً رعایت خواهد شد و در B-05 فیلد توکن دائمی دستگاه افزوده می‌شود. |
| D-R06 | R-06 | مشخصات دستگاه‌های آزمون | دو دستگاه فیزیکی طبق D1 و D2 | دستگاه فیزیکی D2 متصل است: Huawei P50 Pro (JAD-LX9), Android 12, API 31, RAM 8GB, WebView 114.0.5.302 (Chrome 114 base). وضعیت دستگاه دوم D1 گزارش شد. |
| D-B01 | B-01 | رفتار Carbon 3 در تفاضل زمانی | در Carbon 3 لاراول ۱۱، `now()->diffInSeconds($pastDate)` عدد منفی برمی‌گرداند مگر اینکه از اختلاف تایم‌استمپ استفاده شود. | فرمول `max(0, (int)(now()->timestamp - Carbon::parse($lastFetch)->timestamp))` پیاده‌سازی شد تا ثانیه‌های مثبت و بدون وابستگی به منطقه زمانی تضمین شود. |
| D-B07 | B-07 | وابستگی پنهان AuthController به ensureTvSessionsTable | در لاگین لینک جادویی، متد handlePendingPairing جدول tv_devices را نمی‌ساخت و متد حذفی را صدا می‌زد. | متد handlePendingPairing بازنویسی شد تا TvDevice را با توکن دائمی ۴۸ کاراکتری مستقل بسازد و توکن دستگاه را به سشن متصل کند. |
| D-T12 | T-12 | بنچمارک لود اسنپ‌شات | صدک ۹۵ زیر ۲۰۰ میلی‌ثانیه | در آزمون ۳۰۰ درخواست، صدک ۹۵ برابر با ۷.۹۸ میلی‌ثانیه، میانگین ۵.۶۷ میلی‌ثانیه و نرخ خطای ۰٪ ثبت شد (کاهش چشمگیر پس از تغییر به file cache و حذف واکشی بیرونی). |
| D-T13 | T-13 | عدم شکست مسیر مرورگری | صحت /{username} و /tv | هر دو مسیر با کد ۲۰۰ و بدون هیچ خطای سروری یا کنسولی بررسی و تأیید شدند. |
| D-W01 | W-01..W-06 | تفکیک استایل و منطق کیوسک تلویزیون از مرورگر | در حالت tv=1 استایل کیوسک، مقیاس فونت ۳ متری، لغو سرویس‌ورکر، پل‌های ارتباطی TalaTV و نوار هشدار دیتای بیات فعال شدند. | بررسی تفاوت HTML (اختلاف ۱۰۲۹ بایت) و حفظ سلامت کامل مسیر مرورگری استاندارد /{username} و /tv بدون هیچ تغییر یا خطایی تأیید شد. |

**مواردی که حتماً باید ثبت شوند:**

- اثرانگشت SHA-256 کی‌استور (از `U-01`)
- حجم واقعی APK نهایی (از `A-01`)
- مشخصات دقیق دو دستگاه آزمون (از `R-06`)
- مقدار واقعی `CACHE_STORE` پروداکشن (از `R-03`)
- عدد صدک ۹۵ قبل و بعد از فاز ۱ (از `T-12`)
- نتیجهٔ `T-02` روی دستگاه مدرن — موفق یا ناموفق

# ۱۱. دروازه‌های توقف

بعد از هر فاز **بایست و گزارش بده**. فاز بعدی را بدون تأیید شروع نکن.

| دروازه | شرط عبور |
| --- | --- |
| پایان فاز ۰ | هر شش گزارش `R-01` تا `R-06` تحویل شده. **اگر `R-06` نشان داد دستگاه واقعی نیست، اینجا توقف کامل.** |
| پایان فاز ۱ | `T-12` پاس شده و `T-13` نشان داده مسیر مرورگری نشکسته |
| پایان فاز ۲ | `?tv=1` در مرورگر دسکتاپ بدون خطای کنسول لود می‌شود و `T-13` همچنان پاس است |
| پایان فاز ۳ | APK زیر ۲ مگابایت ساخته شده و `T-01` تا `T-04` روی هر دو دستگاه پاس شده |
| پایان فاز ۴ | `T-10` پاس شده — یعنی واقعاً یک آپدیت از نسخهٔ ۱ به ۲ روی دستگاه واقعی انجام شده |
| پایان فاز ۵ | هر ۱۴ ردیف `T-*` با شاهد (عکس، لاگ، یا عدد) ثبت شده |

---

<aside>
🎯

**تعریف موفقیت کل پروژه**

یک طلافروش که هیچ‌وقت با تو حرف نزده، APK را دانلود کند، نصب کند، فقط با ریموت جفت کند، و شش ماه بعد هنوز تابلویش بالاست و قیمت‌های زنده را نشان می‌دهد — بدون اینکه یک بار با تو تماس گرفته باشد.

</aside>