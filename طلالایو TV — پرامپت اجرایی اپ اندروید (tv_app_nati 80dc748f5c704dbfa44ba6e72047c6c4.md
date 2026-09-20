# طلالایو TV — پرامپت اجرایی اپ اندروید (tv_app_native) — رندر نیتیو داخل اپ و استقلال از وب‌ویوی دستگاه (N-01..N-24)

<aside>
⛔

این سند نقشهٔ اجرا است، نه صورت مسئله. برای خودت نقشهٔ دیگری ننویس، تسک‌ها را ادغام یا بازتعریف نکن، ترتیب فازها را عوض نکن. هر تسک را دقیقاً همان‌طور که نوشته شده اجرا کن و چک‌باکسش را بزن. تست و اندازه‌گیری فقط یک بار و در مرحلهٔ آخر انجام می‌شود.

</aside>

<aside>
📱

**موضوع این سند فقط و فقط اپ اندروید تلویزیون است که در پوشهٔ `tv_app_native/` قرار دارد (پکیج `ir.talalive.tv`، زبان Kotlin).** هیچ تسکی در این سند مربوط به تابلوی وب سایت نیست. اگر داری فایل Blade، CSS، یا جاوااسکریپت سایت را ویرایش می‌کنی، در حال انجام کار اشتباهی هستی — متوقف شو.

</aside>

## ۰.۱ واژه‌نامه — قبل از هر کار بخوان

کلمهٔ «تابلو» در این پروژه دو معنای متفاوت دارد. این جدول تعیین‌کننده است:

| اصطلاح در این سند | دقیقاً یعنی چه | وضعیت |
| --- | --- | --- |
| تابلوی نیتیو · `NativeBoardView` | یک کلاس Kotlin جدید درون اپ اندروید که قیمت‌ها را با `TextView` رسم می‌کند | موضوع این سند — ساخته می‌شود |
| تابلوی وب · تابلوی اصلی سایت | صفحهٔ `resources/views/display/live.blade.php` که در مرورگر باز می‌شود | **دست نمی‌خورد — حتی یک کاراکتر** |
| وب‌ویو | کامپوننت `android.webkit.WebView` داخل اپ که همین صفحهٔ سایت را نشان می‌دهد | از مسیر اصلی خارج می‌شود، ولی حذف نمی‌شود |

**فهرست سفید فایل‌ها.** فقط اجازه داری این مسیرها را تغییر بدهی:

1. هر چیزی درون `tv_app_native/` — دامنهٔ اصلی ۲۲ تسک از ۲۴ تسک
2. `docs/tv-native-evidence/` — فقط برای ثبت نتیجهٔ مرحلهٔ آخر
3. سه فایل سمت سرور، آن هم فقط در دو تسک `N-16` و `N-23` و فقط به صورت **افزودن** (نه تغییر رفتار موجود): `config/tv.php`، تابع `heartbeat()` در `app/Http/Controllers/PublicDisplayController.php`، و `resources/views/admin/devices/index.blade.php`

هر فایل دیگری خارج از این سه مورد — به‌ویژه هر چیزی در `resources/views/display/`، `resources/views/layouts/`، `public_html/`، `routes/`، و `app/Services/` — **فقط خواندنی است**. مجازی برای فهمیدن قرارداد داده بازشان کنی، ولی حق ویرایششان را نداری.

<aside>
✅

**آزمون سالمت در پایان هر فاز.** دستور `git diff --name-only master` را بزن. اگر حتی یک مسیر خارج از فهرست سفید بالا در خروجی بود، آن تغییر را `git checkout` کن و در دفتر انحرافات بنویس. کافی است خروجی را در گزارش همان دروازه بیاوری؛ این یک دستور گیت است، نه تست.

</aside>

| کلید | مقدار |
| --- | --- |
| مخزن | `nicedevil02/live` |
| شاخهٔ پایه | `master` |
| شاخهٔ کاری | `feat/tv-native-board` |
| ماژول هدف | `tv_app_native/` — اپ اندروید، پکیج `ir.talalive.tv` |
| خارج از دامنه | کل اپلیکیشن لاراول و تابلوی وب `display/live.blade.php` |
| API مرجع | `GET {base}/api/display/snapshot/{username}` (عمومی، `throttle:120,1`) |
| تعداد تسک | ۲۴ |
| فازها | A سپر سازگاری · B تابلوی نیتیو به‌عنوان جایگزین اضطراری · C نیتیو به‌عنوان مسیر اصلی · D پایداری میدانی |
| تست و اندازه‌گیری | فقط یک بار در مرحلهٔ آخر (`N-21` و `N-22`) |

## ۰. قرارداد اجرا

1. روی `master` کامیت نکن. اول `git checkout -b feat/tv-native-board` از `master`. فقط فایل‌های فهرست سفید بخش ۰.۱ را تغییر بده.
2. هیچ وابستگی جدید Gradle اضافه نکن. نه androidx، نه Glide، نه Gson، نه Compose. فقط `kotlin-stdlib` و APIهای خود اندروید (`org.json`, `HttpURLConnection`, `Typeface`, `View`). این قید عمدی است و تخطی از آن نقض سند است.
3. `minSdk = 21` تغییر نمی‌کند. هر API بالاتر از ۲۱ باید پشت `Build.VERSION.SDK_INT` گارد شود.
4. برای هر تسک، بخش «کد فعلی» را در فایل واقعی پیدا کن. اگر مو‌به‌مو پیدا نشد، **توقف کن** و در دفتر انحرافات (بخش ۸) بنویس. حق حدس‌زدن نداری.
5. هر تسک یک چک‌باکس دارد. وقتی کد را نوشتی و پروژه بیلد شد، تیک بزن. لازم نیست برای هر تسک تست دستگاهی بگیری یا فایل شاهد بسازی.
6. **تست فقط یک بار، در مرحلهٔ آخر.** همهٔ آزمون‌های واقعی روی دستگاه یک‌جا در `N-21` و `N-22` انجام می‌شود. تا آن مرحله فقط کد بنویس و جلو برو. تنها استثنا `N-07` است که تست نیست؛ گرفتن قرارداد واقعی داده است و بدونش کد رندر قابل نوشتن نیست.
7. «معیار پذیرش» در هر تسک توصیف رفتار درست است تا بدانی کد را چطور بنویسی؛ دستور گرفتن آزمون در همان جا نیست.
8. در پایان هر فاز یک کامیت با پیام مشخص‌شده بزن و **بایست**. گزارش بده و منتظر تأیید بمان.
9. کد مرده را حذف کن، کامنت‌نویسی نکن. اگر تابعی بعد از تسک بلااستفاده شد، در همان تسک حذفش کن.
10. متن‌های فارسی جدید فقط در `res/values/strings.xml`. هیچ رشتهٔ فارسی هاردکد در کاتلین نگذار.

<aside>
🚫

سه کاری که اگر بکنی کار را خراب می‌کنی: (۱) موتور مرورگر جاسازی‌شده مثل GeckoView اضافه کنی — صریحاً رد شده است. (۲) شکل JSON خروجی `snapshot` را از روی حدس بنویسی به‌جای اینکه اول خروجی واقعی را بگیری (`N-07`). (۳) واحد `dp` یا `sp` را برای اندازهٔ متن تابلو به کار ببری — روی باکس‌های تلویزیون این دو دروغ می‌گویند.

</aside>

## ۱. تصمیم معماری (پس‌زمینه — اجرا نکن، فقط بدان)

مشکل «ناسازگاری با تلویزیون‌های مختلف» یک علت ندارد. جاسازی موتور مرورگر فقط یکی از شش علت را حل می‌کند و در عوض حجم APK را از ۵۵ کیلوبایت به ده‌ها مگابایت می‌برد و مصرف رم را روی باکس‌های ۱ گیگابایتی بحرانی می‌کند.

تصمیم: **تابلو به‌صورت نیتیو رندر می‌شود.** داده از `snapshot` می‌آید که همین حالا وجود دارد و شامل `priceFeed`, `displayItems`, `products`, `settings`, `updatedAt`, `dataAgeSeconds`, `isStale`, `refreshIntervalSeconds` است. وب‌ویو در فاز B به جایگزین اضطراری تنزل می‌کند و در فاز C از مسیر اصلی خارج می‌شود.

نتیجهٔ مورد انتظار: APK زیر ۱ مگابایت، اجرا روی اندروید ۵ تا ۱۵ بدون وابستگی به نسخهٔ Android System WebView، فونت فارسی تضمینی، مصرف رم زیر ۵۰ مگابایت، استارت‌آپ زیر ۲ ثانیه.

## ۲. خط مبنا (یک کار کوتاه، قبل از شروع)

- [ ]  **B-1** روی شاخهٔ `master` یک بیلد ریلیز بگیر و فقط دو عدد را جایی یادداشت کن: حجم APK و مصرف رم. این دو عدد فقط به کار مقایسهٔ نهایی در `N-21` می‌آیند. اگر دستگاه واقعی دم دستت نیست، فقط حجم APK را ثبت کن و برو جلو.

## ۳. فاز A — سپر سازگاری

هدف فاز: بدون تغییر معماری، بیشترین درد میدانی را کم کن. هیچ‌کدام از این تسک‌ها ظاهر تابلو را عوض نمی‌کند.

### N-01 — بازگرداندن اعتبارسنجی SSL و زنده‌کردن تشخیص ساعت غلط

فایل: `tv_app_native/app/src/main/java/ir/talalive/tv/TalaWebViewClient.kt`

کد فعلی:

```kotlin
override fun onReceivedSslError(view: WebView, handler: SslErrorHandler, error: SslError) {
    val failingUrl = error.url ?: view.url ?: ""
    Log.w(tag, "SSL notice on $failingUrl (${error.primaryError}). Auto-proceeding for universal TV compatibility.")
    handler.proceed()
}
```

این یک رگرسیون امنیتی است: هر گواهی جعلی پذیرفته می‌شود و تابع `showSslDiagnostic()` در `BoardActivity` عملاً کد مرده شده است.

کد جدید:

```kotlin
override fun onReceivedSslError(view: WebView, handler: SslErrorHandler, error: SslError) {
    Log.w(tag, "SSL error ${error.primaryError} on ${error.url ?: view.url}")
    handler.cancel()
    host.showSslDiagnostic(error)
}
```

معیار پذیرش: ساعت دستگاه را دستی روی سال ۲۰۱۵ بگذار و اپ را باز کن. باید صفحهٔ «ساعت این دستگاه اشتباه است» با تاریخ دستگاه و تاریخ واقعی ظاهر شود، نه تابلو.

### N-02 — تشخیص قابل‌اتکای وضعیت WebView دستگاه

فایل: `BoardActivity.kt`

کد فعلی نسخه را با رجکس از User-Agent درمی‌آورد:

```kotlin
private fun getChromeVersion(): String {
    val ua = try { WebSettings.getDefaultUserAgent(this) } catch (e: Exception) { "" }
    val p = Pattern.compile("Chrome/([0-9]+)")
    val m = p.matcher(ua)
    return if (m.find()) m.group(1) ?: "Unknown" else "Unknown"
}
```

سه ایراد: روی دستگاه‌هایی که WebView اصلاً نصب نیست `getDefaultUserAgent` خودش استثنا می‌دهد و ساخت `WebView(this)` کرش می‌کند؛ روی برخی باکس‌ها UA دستکاری شده؛ و ما بعداً UA را خودمان بازنویسی می‌کنیم.

یک فایل جدید `WebViewProbe.kt` بساز با این مسئولیت‌ها (بدون androidx، با ریفلکشن روی `android.webkit.WebViewFactory`):

```kotlin
package ir.talalive.tv

import android.content.Context
import android.content.pm.PackageInfo
import android.os.Build
import android.util.Log
import android.webkit.WebSettings
import java.util.regex.Pattern

object WebViewProbe {
    private const val TAG = "TalaTV.Probe"

    data class Info(
        val available: Boolean,
        val packageName: String?,
        val versionName: String?,
        val majorVersion: Int
    )

    fun probe(ctx: Context): Info {
        val pkg = currentPackage(ctx)
        if (pkg != null) {
            val major = pkg.versionName?.substringBefore('.')?.toIntOrNull() ?: 0
            return Info(true, pkg.packageName, pkg.versionName, major)
        }
        val ua = try { WebSettings.getDefaultUserAgent(ctx) } catch (e: Throwable) {
            Log.w(TAG, "getDefaultUserAgent failed: ${e.message}")
            return Info(false, null, null, 0)
        }
        val m = Pattern.compile("Chrome/([0-9]+)").matcher(ua)
        val major = if (m.find()) m.group(1)?.toIntOrNull() ?: 0 else 0
        return Info(true, null, null, major)
    }

    private fun currentPackage(ctx: Context): PackageInfo? {
        return try {
            if (Build.VERSION.SDK_INT >= 26) {
                val cls = Class.forName("android.webkit.WebViewFactory")
                cls.getMethod("getLoadedPackageInfo").invoke(null) as? PackageInfo
            } else null
        } catch (e: Throwable) {
            Log.w(TAG, "WebViewFactory reflection failed: ${e.message}")
            null
        }
    }
}
```

سپس در `BoardActivity`، `getChromeVersion()` و `getChromeVersionInt()` را حذف کن و همهٔ مصرف‌کننده‌هایشان (`readyWatchdogRunnable`, `performHeartbeat`, `showDeviceInfoDialog`, بلوک `test_min_chrome`) را به `WebViewProbe.probe(this)` وصل کن.

معیار پذیرش: منوی «مشخصات دستگاه» نسخهٔ WebView و نام بستهٔ ارائه‌دهنده را نشان می‌دهد. روی دستگاهی که WebView ندارد، اپ کرش نمی‌کند.

### N-03 — محافظت از ساخت WebView در برابر کرش

فایل: `BoardActivity.kt`، تابع `initAndLoadWebView()`

کد فعلی مستقیم `WebView(this)` می‌سازد. روی دستگاه‌هایی که بستهٔ WebView غایب، غیرفعال یا در حال به‌روزرسانی است، این خط `AndroidRuntimeException` یا `MissingWebViewPackageException` می‌دهد و اپ می‌میرد — یعنی تابلوی مغازه سیاه می‌شود.

کل بدنهٔ `initAndLoadWebView()` را داخل `try/catch (t: Throwable)` بگذار. در `catch`:

```kotlin
Log.e(tag, "WebView creation failed", t)
webView = null
showDiagnostic(
    getString(R.string.webview_missing_title),
    getString(R.string.webview_missing_desc),
    getString(R.string.menu_reload)
) { recreateWebView() }
```

دو رشتهٔ جدید به `strings.xml` اضافه کن:

```xml
<string name="webview_missing_title">موتور نمایش روی این دستگاه در دسترس نیست</string>
<string name="webview_missing_desc">بستهٔ «Android System WebView» روی این تلویزیون نصب یا فعال نیست. تابلو به‌زودی در حالت مستقل نمایش داده می‌شود.</string>
```

معیار پذیرش: با `adb shell pm disable-user com.google.android.webview` (روی امولاتور) اپ به‌جای کرش، صفحهٔ تشخیص را نشان می‌دهد.

### N-04 — فونت فارسی مستقل از سیستم‌عامل دستگاه

بسیاری از باکس‌های چینی فونت عربی/فارسی ندارند و متن به‌صورت مربع یا حروف جدا نمایش داده می‌شود. این مشکل با هیچ تنظیم وب‌ویویی حل نمی‌شود.

1. فایل `Vazirmatn-Regular.ttf` و `Vazirmatn-Bold.ttf` را در `tv_app_native/app/src/main/assets/fonts/` قرار بده. (از `res/font/` استفاده نکن؛ بارگذاری XML آن به androidx یا API 26 نیاز دارد و ما هر دو را نداریم.)
2. یک فایل `Fonts.kt` بساز:

```kotlin
package ir.talalive.tv

import android.content.Context
import android.graphics.Typeface
import android.util.Log

object Fonts {
    private var regular: Typeface? = null
    private var bold: Typeface? = null

    fun regular(ctx: Context): Typeface {
        regular?.let { return it }
        val t = load(ctx, "fonts/Vazirmatn-Regular.ttf") ?: Typeface.DEFAULT
        regular = t
        return t
    }

    fun bold(ctx: Context): Typeface {
        bold?.let { return it }
        val t = load(ctx, "fonts/Vazirmatn-Bold.ttf") ?: Typeface.DEFAULT_BOLD
        bold = t
        return t
    }

    private fun load(ctx: Context, path: String): Typeface? = try {
        Typeface.createFromAsset(ctx.assets, path)
    } catch (e: Throwable) {
        Log.e("TalaTV.Fonts", "font load failed: $path", e)
        null
    }
}
```

1. در `BoardActivity` و `PairingActivity`، هر جا `typeface = Typeface.DEFAULT_BOLD` هست به `typeface = Fonts.bold(this)` تغییر بده و به تمام `TextView` و `Button`های ساخته‌شده `typeface = Fonts.regular(this)` بده.

معیار پذیرش: روی دستگاهی که فونت فارسی سیستمی ندارد، اورلی آفلاین و منوها کاملاً خوانا هستند.

### N-05 — حاشیهٔ امن Overscan قابل تنظیم

تلویزیون‌های قدیمی و برخی باکس‌ها حدود ۳ تا ۵ درصد لبهٔ تصویر را می‌برند. سربرگ و ردیف آخر تابلو دیده نمی‌شود.

در `TvPrefs.kt` اضافه کن:

```kotlin
fun getOverscanPercent(ctx: Context): Int = get(ctx).getInt("overscan_percent", 0)

fun setOverscanPercent(ctx: Context, value: Int) {
    get(ctx).edit().putInt("overscan_percent", value.coerceIn(0, 10)).apply()
}
```

در `BoardActivity.buildViews()`، بعد از ساخت `rootContainer`، پدینگ را اعمال کن:

```kotlin
private fun applyOverscan() {
    val pct = TvPrefs.getOverscanPercent(this)
    val w = resources.displayMetrics.widthPixels * pct / 100
    val h = resources.displayMetrics.heightPixels * pct / 100
    rootContainer.setPadding(w, h, w, h)
}
```

و در `showTvMenu()` یک آیتم چهارم «تنظیم حاشیهٔ تصویر» اضافه کن که دیالوگی با گزینه‌های ۰٪، ۳٪، ۵٪، ۷٪ باز می‌کند و بعد از انتخاب `applyOverscan()` را صدا می‌زند.

رشته‌های جدید: `menu_overscan`، `overscan_dialog_title`.

معیار پذیرش: با انتخاب ۵٪، کل محتوا به داخل جمع می‌شود و پس‌زمینهٔ `#020617` لبه‌ها را پر می‌کند.

### N-06 — سوییچ خودکار لایهٔ رندر در صورت کرش مکرر

روی برخی GPUهای Mali و Amlogic قدیمی، `LAYER_TYPE_HARDWARE` دقیقاً منبع صفحهٔ سیاه است.

در `TvPrefs` یک شمارندهٔ `render_crash_count` نگه دار. در `BoardActivity.recreateWebView()` هر بار که از مسیر `onRenderProcessGone` آمده‌ایم آن را یک واحد زیاد کن. در `initAndLoadWebView()`:

```kotlin
val layer = if (TvPrefs.getRenderCrashCount(this) >= 2) View.LAYER_TYPE_SOFTWARE else View.LAYER_TYPE_HARDWARE
setLayerType(layer, null)
```

و در `markBoardReady()` شمارنده را صفر کن.

معیار پذیرش: بعد از دو بار `onRenderProcessGone` پشت‌سرهم، در logcat خط `Falling back to software layer` دیده می‌شود و تابلو بالا می‌آید.

<aside>
🛑

**دروازهٔ توقف فاز A.** کامیت با پیام `fix(tv): phase A — compatibility shield N-01..N-06`. فقط مطمئن شو پروژه بیلد می‌شود، سپس بایست و گزارش بده کدام تسک‌ها تیک خوردند و چه انحرافی ثبت شد. تست دستگاهی در این مرحله لازم نیست. تا تأیید نگرفته‌ای وارد فاز B نشو.

</aside>

## ۴. فاز B — تابلوی نیتیو به‌عنوان جایگزین اضطراری

هدف فاز: یک رندرر نیتیو کامل بساز که وقتی وب‌ویو شکست می‌خورد، به‌جای پیام خطا **تابلوی واقعی** را نشان بدهد. در این فاز وب‌ویو هنوز مسیر پیش‌فرض است.

### N-07 — ثبت خروجی واقعی snapshot (قبل از نوشتن هر کد رندر)

این اولین و مهم‌ترین تسک فاز است. در پروژهٔ قبلی، قرارداد `magic-sms` از روی حدس نوشته شد و همیشه ۴۲۲ برگرداند. آن اشتباه را تکرار نکن.

1. با یک نام کاربری واقعی که تابلوی فعال دارد، خروجی زیر را بگیر:

```bash
curl -s "https://talalive.ir/api/display/snapshot/<username>" | python3 -m json.tool > docs/tv-native-evidence/N-07-snapshot-sample.json
```

1. فایل `app/Http/Controllers/PublicDisplayController.php` تابع `buildSnapshot()` و مدل‌های `DisplaySetting`, `DisplayItem`, `ProductSlide` و سرویس `MarketService::getPriceFeed()` را بخوان و یک جدول نگاشت بنویس: هر فیلدی که تابلو لازم دارد، نوع دقیقش، و اینکه ممکن است `null` باشد یا نه → `docs/tv-native-evidence/N-07-field-map.md`
2. مشخص کن `priceFeed` آرایه است یا آبجکت، کلید هر آیتم چیست، قیمت رشته است یا عدد، و `displayItems` چطور به `priceFeed` وصل می‌شود.

معیار پذیرش: فایل JSON واقعی و جدول نگاشت هر دو در مخزن هستند و هیچ فیلدی در جدول با عبارت «احتمالاً» یا «به نظر می‌رسد» توصیف نشده است.

<aside>
⛔

تا وقتی `N-07-snapshot-sample.json` کامیت نشده، حق نداری `N-08` تا `N-15` را شروع کنی. اگر به سرور دسترسی نداری، همین‌جا توقف کن و بگو.

</aside>

### N-08 — لایهٔ دریافت داده

فایل جدید: `SnapshotApi.kt`

هم‌سبک با `Api.kt` موجود بنویس: `HttpURLConnection`, `org.json`, حلقه روی `Config.baseUrls(ctx)`, تایم‌اوت ۸۰۰۰، `User-Agent` همان `TalaLiveTV/1.0 (Android)`.

```kotlin
object SnapshotApi {
    fun fetch(ctx: Context, username: String): String? {
        for (base in Config.baseUrls(ctx)) {
            try {
                val conn = (URL("$base/api/display/snapshot/$username").openConnection() as HttpURLConnection).apply {
                    requestMethod = "GET"
                    connectTimeout = 8000
                    readTimeout = 8000
                    setRequestProperty("User-Agent", "TalaLiveTV/1.0 (Android)")
                    setRequestProperty("Accept", "application/json")
                    useCaches = false
                }
                if (conn.responseCode in 200..299) {
                    return conn.inputStream.bufferedReader(Charsets.UTF_8).use { it.readText() }
                }
                Log.w("TalaTV.Snapshot", "HTTP ${conn.responseCode} on $base")
            } catch (e: Throwable) {
                Log.w("TalaTV.Snapshot", "fetch failed on $base: ${e.message}")
            }
        }
        return null
    }
}
```

نکته: `username` را از `TvPrefs.getUsername(ctx)` بگیر. اگر خالی بود، تابلو نباید تلاش کند — به `PairingActivity` برو.

معیار پذیرش: در logcat یک خط با طول پاسخ دریافتی دیده می‌شود و در حالت قطع اینترنت، تابع `null` برمی‌گرداند بدون کرش.

### N-09 — مدل داده و پارسر مقاوم

فایل جدید: `BoardModel.kt`

دقیقاً بر اساس `N-07-field-map.md` بنویس، نه بر اساس حدس. سه اصل:

1. هر خواندن با `opt*` انجام شود، نه `get*`. هیچ `JSONException` نباید به بالا درز کند.
2. اگر یک آیتم قیمت ناقص بود، همان آیتم حذف شود نه کل تابلو.
3. تابع `parse(raw: String): BoardModel?` در صورت شکست کامل `null` برگرداند و لاگ بزند.

ساختار پیشنهادی (فیلدها را مطابق نگاشت واقعی تنظیم کن):

```kotlin
data class PriceRow(
    val title: String,
    val price: String,
    val changeDirection: Int,   // -1, 0, +1
    val changeText: String?
)

data class BoardModel(
    val shopName: String,
    val rows: List<PriceRow>,
    val updatedAtText: String,
    val isStale: Boolean,
    val refreshIntervalSeconds: Int,
    val rawJson: String
)
```

معیار پذیرش: یک تست دستی بنویس که `N-07-snapshot-sample.json` را از `assets/` می‌خواند و تعداد ردیف‌های پارس‌شده را لاگ می‌کند. عدد باید با تعداد آیتم‌های فایل JSON برابر باشد.

### N-10 — مقیاس‌بندی مستقل از density

این تسک را قبل از نوشتن ویو انجام بده، چون کل چیدمان به آن وابسته است.

روی باکس‌های تلویزیون، `density` و `densityDpi` اغلب اشتباه گزارش می‌شوند (مثلاً tvdpi روی صفحهٔ 1080p) و `sp` تحت تأثیر تنظیم اندازهٔ فونت کاربر است. نتیجه: تابلو روی یک دستگاه درست و روی دیگری ریز یا بریده است.

فایل جدید: `Scale.kt`

```kotlin
object Scale {
    // همهٔ اندازه‌ها کسری از ارتفاع صفحه هستند، نه dp و نه sp
    fun px(ctx: Context, fractionOfHeight: Float): Float =
        ctx.resources.displayMetrics.heightPixels * fractionOfHeight

    fun applyTextSize(tv: TextView, fractionOfHeight: Float) {
        tv.setTextSize(TypedValue.COMPLEX_UNIT_PX, px(tv.context, fractionOfHeight))
    }
}
```

قاعده: در کل `NativeBoardView` حتی یک بار `COMPLEX_UNIT_SP` یا `COMPLEX_UNIT_DIP` استفاده نکن.

معیار پذیرش: تابلو روی سه رزولوشن 1280×720، 1920×1080 و 3840×2160 (با `adb shell wm size`) بدون بریدگی و با نسبت یکسان دیده شود.

### N-11 — ارقام و تاریخ فارسی

فایل جدید: `PersianText.kt`

```kotlin
object PersianText {
    private val digits = charArrayOf('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹')

    fun toPersianDigits(s: String): String {
        val sb = StringBuilder(s.length)
        for (c in s) sb.append(if (c in '0'..'9') digits[c - '0'] else c)
        return sb.toString()
    }

    fun groupThousands(raw: String): String {
        val clean = raw.filter { it.isDigit() }
        if (clean.isEmpty()) return raw
        return clean.reversed().chunked(3).joinToString(",").reversed()
    }
}
```

همهٔ اعداد تابلو قبل از نمایش از `groupThousands` و سپس `toPersianDigits` رد شوند.

معیار پذیرش: عدد `54820000` روی تابلو به شکل `۵۴,۸۲۰,۰۰۰` دیده شود.

### N-12 — ویوی تابلوی نیتیو

فایل جدید: `NativeBoardView.kt` — یک `LinearLayout` عمودی که برنامه‌نویسی ساخته می‌شود (هم‌سبک با اورلی‌های موجود در `BoardActivity`، بدون XML).

ساختار:

1. **سربرگ:** نام گالری (از `settings`) + ساعت جاری + برچسب وضعیت داده
2. **بدنه:** برای هر `PriceRow` یک ردیف با سه ستون: عنوان (راست)، قیمت (وسط، بزرگ‌ترین فونت)، فلش تغییر (چپ)
3. **پاورقی:** «آخرین به‌روزرسانی: …» + نام دامنه

قواعد اجباری:

- پس‌زمینه `#020617`، متن `#E2E8F0`، طلایی `#F59E0B`، صعودی `#22C55E`، نزولی `#EF4444` — همان پالت فعلی اپ
- `layoutDirection = View.LAYOUT_DIRECTION_RTL` روی ریشه (پشت گارد `SDK_INT >= 17`)
- تعداد ردیف قابل نمایش را از ارتفاع صفحه محاسبه کن؛ اگر ردیف‌ها بیشتر بودند، هر ۱۰ ثانیه صفحه‌بندی کن (نه اسکرول)
- هیچ انیمیشنی جز یک fade ساده روی تغییر قیمت نداشته باش

معیار پذیرش: با فراخوانی دستی از منوی مخفی، تابلوی نیتیو با دادهٔ واقعی سرور نمایش داده می‌شود و اعداد با تابلوی وب یکسان‌اند.

### N-13 — حلقهٔ به‌روزرسانی و کش آفلاین

در `NativeBoardController` (می‌تواند داخل `BoardActivity` باشد):

- هر `refreshIntervalSeconds` ثانیه (پیش‌فرض ۶۰، حداقل ۳۰، حداکثر ۳۰۰) یک `SnapshotApi.fetch` روی `Executors` اجرا شود
- در صورت موفقیت، JSON خام در `TvPrefs` ذخیره شود با کلید `last_snapshot_json` و زمانش با `last_snapshot_millis`
- در استارت‌آپ، **اول** کش نمایش داده شود و بعد درخواست شبکه برود. تابلو هرگز نباید صفحهٔ خالی نشان بدهد
- backoff در صورت خطا: ۵، ۱۰، ۲۰، ۶۰ ثانیه (همان الگوی موجود)

معیار پذیرش: اینترنت را قطع کن و اپ را ری‌استارت کن. تابلو بلافاصله آخرین قیمت‌ها را با برچسب کهنگی نشان می‌دهد، نه صفحهٔ آفلاین خالی.

### N-14 — نمایش وضعیت کهنگی داده

از `isStale` و `dataAgeSeconds` که سرور همین حالا می‌فرستد استفاده کن (آستانهٔ سرور ۱۸۰ ثانیه است).

- `isStale == false` → نوار وضعیت سبز کم‌رنگ، متن «به‌روز»
- `isStale == true` → نوار کهربایی، متن «تأخیر در به‌روزرسانی — آخرین نرخ: HH:mm»
- اگر بیش از ۱۵ دقیقه هیچ پاسخ موفقی نبود → نوار قرمز، متن «اتصال برقرار نیست»

قیمت‌ها در هیچ‌کدام از این حالت‌ها مخفی نمی‌شوند؛ فقط برچسب عوض می‌شود. مغازه‌دار باید بداند عدد قدیمی است، نه اینکه صفحه سیاه ببیند.

معیار پذیرش: هر سه حالت با دستکاری شبکه بازتولید و اسکرین‌شات شود.

### N-15 — منطق سوییچ خودکار از وب‌ویو به نیتیو

در `BoardActivity`، حالت رندر را در یک enum نگه دار:

```kotlin
enum class RenderMode { WEB, NATIVE }
```

شرایط سوییچ به `NATIVE` (هر کدام کافی است):

1. `WebViewProbe.probe()` گزارش کند `available == false`
2. `majorVersion in 1..69` باشد
3. ساخت `WebView` استثنا بدهد (`N-03`)
4. `readyWatchdogRunnable` (۲۵ ثانیه) دو بار پشت‌سرهم شکست بخورد
5. `onRenderProcessGone` سه بار در یک ساعت رخ دهد

وقتی سوییچ رخ داد، در `TvPrefs` فلگ `forced_native = true` بنویس تا در ری‌استارت‌های بعدی مستقیم نیتیو بالا بیاید و وب‌ویو اصلاً ساخته نشود. این فلگ فقط از منوی ریموت («تلاش مجدد با حالت وب») پاک شود.

معیار پذیرش: روی امولاتوری که WebView غیرفعال شده، اپ بعد از حداکثر ۳۰ ثانیه تابلوی نیتیو را نشان می‌دهد و در ری‌استارت دوم بلافاصله (زیر ۲ ثانیه) بالا می‌آید.

<aside>
🛑

**دروازهٔ توقف فاز B.** کامیت با پیام `feat(tv): phase B — native board fallback N-07..N-15`. بایست و گزارش بده: خروجی واقعی snapshot چه شکلی بود و چه فایل‌هایی اضافه شد. تست روی دستگاه را به مرحلهٔ آخر بسپار.

</aside>

## ۵. فاز C — نیتیو به‌عنوان مسیر اصلی

بعد از تأیید دروازهٔ فاز B وارد این فاز شو. لازم نیست منتظر دورهٔ پایداری طولانی بمانی.

### N-16 — نیتیو پیش‌فرض با کلید کنترل سروری

دو طرف دارد.

**سمت سرور** — فایل `config/tv.php` یک کلید جدید بگیرد:

```php
'render_mode' => env('TV_RENDER_MODE', 'native'), // native | web | auto
```

و در `PublicDisplayController::heartbeat()` در آرایهٔ پاسخ اضافه شود:

```php
'render_mode' => $tvConfig['render_mode'] ?? 'native',
```

**سمت اپ** — در `Api.HeartbeatResult` فیلد `renderMode: String?` اضافه کن، در `TvPrefs.saveHeartbeat` ذخیره‌اش کن، و در `BoardActivity.onCreate` ترتیب تصمیم این باشد:

1. `forced_native == true` → `NATIVE`
2. مقدار سروری `web` → `WEB`
3. مقدار سروری `auto` → منطق `N-15`
4. در غیر این صورت → `NATIVE`

معیار پذیرش: با تغییر `TV_RENDER_MODE` در `.env` سرور و یک دورهٔ heartbeat، دستگاه بدون نصب مجدد بین دو حالت جابه‌جا شود.

### N-17 — اسلایدشوی محصولات نیتیو

خروجی `snapshot` فیلد `products` دارد (`ProductSlide` با `images`). اگر تابلوی نیتیو این را نداشته باشد، نسبت به تابلوی وب پسرفت است.

- یک `ImageCache.kt` ساده بنویس: دانلود با `HttpURLConnection` → ذخیره در `context.cacheDir/slides/` با نام هش URL → خواندن با `BitmapFactory.decodeFile`
- اجباری: `BitmapFactory.Options.inSampleSize` را طوری حساب کن که عرض تصویر دکدشده از عرض صفحه بیشتر نشود. بدون این، روی باکس ۱ گیگابایتی `OutOfMemoryError` می‌گیری
- حداکثر ۲۰ تصویر در کش؛ قدیمی‌ترین حذف شود
- چرخش اسلایدها هر ۸ ثانیه، فقط fade
- اگر `products` خالی بود، کل ناحیه حذف شود و جدول قیمت تمام صفحه را بگیرد

معیار پذیرش: با حسابی که حداقل سه اسلاید دارد، هر سه به ترتیب نمایش داده می‌شوند، و بعد از قطع اینترنت هم از کش ادامه می‌دهند. `dumpsys meminfo` بعد از یک ساعت چرخش، رشد پیوسته نشان ندهد.

### N-18 — اعمال تنظیمات گالری از سرور

هدف: بخش بزرگی از تغییرات ظاهری بدون آپدیت APK ممکن باشد.

از آبجکت `settings` در snapshot حداقل این‌ها را بخوان و اعمال کن (نام دقیق فیلدها را از `N-07-field-map.md` بردار):

- نام مغازه و شمارهٔ تماس
- حالت تم (روشن/تاریک)
- ترتیب و وضعیت نمایش آیتم‌ها (`displayItems.order`, فیلد نمایش/عدم نمایش)
- متن دلخواه نوار پایین اگر وجود دارد

مواردی که در این فاز پشتیبانی نمی‌شوند (والپیپر Bing، تم‌های تصویری) را صریحاً در دفتر انحرافات بنویس و به پس‌زمینهٔ یکدست `#020617` تنزل بده. برای آن‌ها خودت راه‌حل اختراع نکن.

معیار پذیرش: تغییر ترتیب آیتم‌ها در پنل ادمین، حداکثر در یک دورهٔ به‌روزرسانی روی تابلوی نیتیو دیده شود.

### N-19 — پیشگیری از سوختگی تصویر

تابلوی مغازه ۱۲ ساعت در روز تصویر ثابت نشان می‌دهد. روی پنل‌های OLED و حتی برخی LCD، این رد دائمی می‌گذارد.

هر ۱۵ دقیقه، کل `NativeBoardView` را به اندازهٔ یک تا دو پیکسل در یک الگوی چرخشی جابه‌جا کن (`translationX`/`translationY` بین ۰ تا ۲). این برای چشم نامحسوس است.

معیار پذیرش: در logcat هر ۱۵ دقیقه خط `pixel shift applied` دیده شود و چیدمان نشکند.

### N-20 — حذف کد مردهٔ وب‌ویو

وقتی نیتیو مسیر اصلی شد، این‌ها دیگر موضوعیت ندارند و باید فقط در مسیر `RenderMode.WEB` زنده بمانند:

- `tickWatchdogRunnable` (آستانهٔ ۵ دقیقه)
- `readyWatchdogRunnable` (۲۵ ثانیه)
- `TalaTvBridge` و `addJavascriptInterface`
- `onRenderProcessGone` و `recreateWebView`
- `scheduleDailyReload` — در حالت نیتیو فقط برای بررسی آپدیت لازم است، نه reload

در حالت `NATIVE` هیچ `WebView` اینستنسی نباید ساخته شود. این نکتهٔ کلیدی کاهش حافظه است.

معیار پذیرش: `adb shell dumpsys meminfo ir.talalive.tv` در حالت نیتیو هیچ فرآیند `sandboxed_process` و هیچ ردپایی از `webview` نشان ندهد.

### N-21 — اندازه‌گیری نتیجه در برابر خط مبنا

این تسک بخشی از مرحلهٔ آخر است و همراه `N-22` یک بار انجام می‌شود. جدول زیر را با اعداد واقعی پر کن و در گزارش نهایی بیاور:

| معیار | خط مبنا (وب‌ویو) | نیتیو | هدف |
| --- | --- | --- | --- |
| حجم APK |  |  | زیر ۱ مگابایت |
| مصرف رم (PSS) |  |  | زیر ۵۰ مگابایت |
| زمان تا نمایش اولین قیمت |  |  | زیر ۲ ثانیه |
| تعداد دستگاه موفق از ماتریس |  |  | هر سه |

اگر هرکدام از اهداف محقق نشد، عدد واقعی را بنویس و دلیلش را توضیح بده. عدد را مخفی یا گرد نکن.

<aside>
🛑

**دروازهٔ توقف فاز C.** کامیت با پیام `feat(tv): phase C — native as primary N-16..N-21`. بایست و بگو چه تغییر کرد؛ بعد از تأیید، مرحلهٔ آخر (فاز D) همان مرحلهٔ تست است.

</aside>

## ۶. فاز D — مرحلهٔ آخر: تنها مرحلهٔ تست

<aside>
🧪

تمام آزمون پروژه فقط همینجا انجام می‌شود. در فازهای A تا C فقط کد نوشته می‌شود و هیچ فایل شاهدی لازم نیست.

</aside>

### N-22 — آزمون یکجای نهایی

حداقل روی یک دستگاه واقعی (و اگر هست، یک امولاتور اندروید قدیمی) این هفت سناریو را یک بار اجرا کن:

1. نصب تازه و جفت‌سازی کامل
2. ری‌استارت دستگاه و بالا آمدن خودکار با `BootReceiver`
3. قطع و وصل اینترنت حین نمایش
4. ۲۴ ساعت کار مداوم بدون ری‌استارت
5. ابطال دستگاه از پنل و فعال‌سازی مجدد
6. دریافت و نصب آپدیت اجباری
7. ساعت غلط دستگاه

بعد از این هفت مورد، یک بار چشمی رفتارهایی را هم که در فازهای قبل کد شده‌اند ببین: ساعت غلط (`N-01`)، دستگاه بدون WebView (`N-03`)، فونت فارسی (`N-04`)، حاشیهٔ تصویر (`N-05`)، سوییچ خودکار به نیتیو (`N-15`)، اسلایدها (`N-17`)، تنطیمات سرور (`N-18`).

معیار پذیرش: همهٔ موارد یک بار اجرا شده و نتیجه در گزارش نهایی نوشته شده است. هر چیزی که خراب بود را بنویس؛ مخفی نکن.

### N-23 — تله‌متری حالت رندر در پنل

بدون این، نمی‌فهمی در مغازه‌های واقعی چه خبر است.

- مایگریشن جدید: دو ستون `render_mode` (string, nullable) و `fallback_reason` (string, nullable) روی جدول `tv_devices`
- در `Api.heartbeat` دو فیلد جدید به payload اضافه شود
- در `PublicDisplayController::heartbeat()` در `$device->update([...])` ذخیره شوند
- در `resources/views/admin/devices/index.blade.php` یک ستون «حالت نمایش» اضافه شود

معیار پذیرش: در پنل ادمین، برای هر دستگاه معلوم است وب است یا نیتیو، و اگر نیتیو است به چه دلیل.

### N-24 — انتشار تدریجی

1. `versionCode` را به `2` و `versionName` را به `"2.0.0"` ببر
2. در `config/tv.php`، `latest_version_code = 2` و `min_version_code` را فعلاً روی `1` نگه دار (آپدیت اختیاری)
3. `TV_RENDER_MODE=auto` را اول روی یک دستگاه آزمایشی بگذار، یک هفته رصد کن، بعد `native`
4. `README` کوتاهی در `tv_app_native/README.md` بنویس: معماری دوحالته و نحوهٔ سوییچ بین دو حالت

معیار پذیرش: یک دستگاه واقعی در مغازه از نسخهٔ ۱ به ۲ آپدیت شود و تابلو بدون دخالت دستی بالا بیاید.

<aside>
🛑

**دروازهٔ توقف فاز D.** کامیت با پیام `chore(tv): phase D — field hardening N-22..N-24`. سپس یک PR از `feat/tv-native-board` به `master` باز کن و خلاصهٔ هر چهار فاز را در توضیحات PR بگذار. خودت merge نکن.

</aside>

## ۷. خارج از دامنهٔ این سند

این‌ها را لمس نکن، حتی اگر به چشمت مربوط آمد:

- سه باگ باز اپ TV که در ممیزی قبلی پیدا شدند (قرارداد `magic-sms`، در پشتی `BoardActivity`، رمز کی‌استور در مخزن عمومی) — سند جداگانه دارند
- هدر سایت و `resources/views/layouts/public.blade.php` — سند جداگانه دارد
- **تابلوی اصلی سایت** `resources/views/display/live.blade.php` و هر CSS/JS مربوط به آن — مطلقاً دست نخورد. نه بهینه‌سازی، نه ریفکتور، نه حتی تغییر فاصله و تو‌رفتگی. مشتری‌های فعلی روی این صفحه حساب باز کرده‌اند و در حالت `?tv=1` هم باید دقیقاً مثل امروز کار کند
- کل اپلیکیشن لاراول خارج از سه فایل نام‌برده‌شده در بخش ۰.۱ — مدل‌ها، مایگریشن‌های موجود، `MarketService`، روت‌ها، و `buildSnapshot()` فقط خواندنی هستند. اگر به نظرت از `snapshot` چیزی کم است، خودت اضافه‌اش نکن — در دفتر انحرافات بنویس و بپرس
- جفت‌سازی و `PairingActivity` — فقط فونتش (`N-04`) عوض می‌شود، منطقش دست نخورد
- افزودن پشتیبانی ویدئو، مرورگر داخلی، یا محتوای دلخواه در تابلوی نیتیو

## ۸. دفتر انحرافات

هر جا «کد فعلی» نخواند، یا مجبور شدی از دستور سند عدول کنی، یک ردیف اینجا اضافه کن. خالی ماندن این جدول در پایان کار، خودش یک علامت هشدار است.

| شناسه | چه چیزی فرق داشت | تصمیم |
| --- | --- | --- |
|  |  |  |
|  |  |  |
|  |  |  |

## ۹. جمع‌بندی دروازه‌های توقف

| دروازه | تسک‌ها | پیام کامیت |
| --- | --- | --- |
| پایان فاز A | `N-01`–`N-06` | `fix(tv): phase A — compatibility shield N-01..N-06` |
| پایان فاز B | `N-07`–`N-15` | `feat(tv): phase B — native board fallback N-07..N-15` |
| پایان فاز C | `N-16`–`N-21` | `feat(tv): phase C — native as primary N-16..N-21` |
| پایان فاز D | `N-22`–`N-24` | `chore(tv): phase D — field hardening N-22..N-24` |

در دروازه‌های A، B و C فقط سه چیز را گزارش بده: تسک‌های تیک‌خورده، اینکه پروژه بیلد می‌شود، و ردیف‌های جدید دفتر انحرافات. فقط در دروازهٔ آخر (فاز D) نتیجهٔ تست‌ها و جدول `N-21` را هم بیاور.