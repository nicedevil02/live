# 🚀 راهنمای جامع استقرار طلالایو (Deployment Checklist)

این چک‌لیست مراحل استقرار اولیه و به‌روزرسانی سامانه طلالایو و اپلیکیشن اندروید تی‌وی را در هاست اشتراکی cPanel مشخص می‌کند.

---

## ۱. پیکربندی اولیه سرور و فایل `.env`

### ۱️⃣ ورود به مسیر پروژه
```bash
cd /home/talaliv1/repositories/live
```

### ۲️⃣ متغیرهای محیطی در `.env`
```env
APP_NAME="طلالایو"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://talalive.ir

# دیتابیس MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=talaliv1_db
DB_USERNAME=talaliv1_user
DB_PASSWORD=your_secure_password

# درایور نشست‌ها و کش
SESSION_DRIVER=database
CACHE_STORE=file

# توکن ایمن کرون جاب بازار
CRON_TOKEN=talalive-cron-secret-2026
```

### ۳️⃣ مجوز دسترسی پوشه‌ها (Permissions)
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
```

### ۴️⃣ کلید اپلیکیشن و مایگریشن دیتابیس
```bash
php artisan key:generate --force
php artisan migrate --force
```

### ۵️⃣ پاک‌سازی و کش بهینه‌ساز لاراول
```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ۲. استقرار خودکار با Git™ Version Control و Webhook

1. در پنل cPanel به بخش **Git™ Version Control** بروید و روی **Update from Remote** کلیک کنید تا آخرین تغییرات شاخهٔ `master` دریافت شود.
2. سپس لینک استقرار سریع را در مرورگر باز کنید:
```
https://talalive.ir/deploy-run.php?key=tala_deploy_7f8c9b1e2a3d4f5
```
این اسکریپت فایل‌ها را سینک کرده، مایگریشن‌ها را اعمال و کش Blade را پاک می‌کند.

---

## ۳. استقرار و انتشار نسخه جدید اپلیکیشن اندروید تی‌وی (APK Release)

هنگام انتشار نسخه جدید برای تلویزیون‌ها:

### ۱️⃣ بیلد و امضای نسخه Release در سیستم توسعه
```powershell
cd tv_app_native
.\gradlew.bat assembleRelease
```
فایل خروجی تولید شده: `tv_app_native/app/build/outputs/apk/release/app-release.apk`

### ۲️⃣ قرار دادن فایل نصبی در پوشه دانلود
فایل APK را به مسیر زیر کپی کرده و به `talalive-tv.apk` تغییر نام دهید:
```
public_html/downloads/talalive-tv.apk
```

### ۳️⃣ به‌روزرسانی مانیفست نسخه (`talalive-tv.json`)
فایل `public_html/downloads/talalive-tv.json` را با مشخصات نسخه جدید ویرایش کنید:
```json
{
  "version_code": 2,
  "version_name": "1.1.0",
  "sha256": "اثرانگشت هش SHA-256 فایل APK",
  "size_bytes": 52340,
  "released_at": "2026-09-18T12:00:00+03:30",
  "min_version_code": 2
}
```

### ۴️⃣ به‌روزرسانی کانفیگ بک‌اند (`config/tv.php`)
```php
'latest_version_code' => 2,
'min_version_code' => 2,
```
تلویزیون‌ها در بازهٔ ضربان بعدی به‌طور خودکار پیام به‌روزرسانی را دریافت و نصب می‌کنند.

---

## ۴. رفع اشکال و لاگ‌ها

- لاگ‌های زنده لاراول:
```bash
tail -n 100 storage/logs/laravel.log
```
- تست سلامت سامانه و API تلویزیون:
```
GET https://talalive.ir/api/tv/health
```

