# 🚀 راهنمای استقرار (Deployment Checklist)

## ❌ مشکل فعلی
- جداول دیتابیس ایجاد نشده‌اند
- `.env` هنوز برای محیط local تنظیم شده است

## ✅ مراحل اجرایی در هاست

### 1️⃣ به SSH هاست متصل شوید و به مجلد پروژه بروید
```bash
cd /path/to/your/project
```

### 2️⃣ فایل `.env` را ویرایش کنید
**مقادیری که باید تغییر دهید:**

```
# تغییر APP_ENV
APP_ENV=production    # ← از local به production

# تغییر APP_DEBUG
APP_DEBUG=false       # ← از true به false

# تغییر APP_URL
APP_URL=https://yourdomain.com    # ← به آدرس واقعی سایت

# تغییر دیتابیس (بگویید هاست شما مقادیر را):
DB_HOST=your_host     # نام یا IP سرور
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass

# تغییر SESSION_DRIVER (بهتر است از file برای production استفاده نکنید)
SESSION_DRIVER=cookie
```

### 3️⃣ مجوزهای پوشه‌ها (Permissions)
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
```

### 4️⃣ نصب وابستگی‌ها
```bash
composer install --no-dev --optimize-autoloader
npm install && npm run build
```

### 5️⃣ کلید اپلیکیشن تولید کنید
```bash
php artisan key:generate
```

### 6️⃣ **دیتابیس مایگریشن** (مهم‌ترین مرحله)
```bash
php artisan migrate --force
```

### 7️⃣ کش را پاکی کنید
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 8️⃣ Admin کاربر ایجاد کنید
```bash
php artisan create-admin
```

## ⚠️ نکات مهم

- **۸۸۸‌های database معلوم نیست**: مقادیر `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD` را از پنل هاست کپی کنید
- **SSL**: اگر سایت شما HTTPS است، `APP_URL` باید با `https://` شروع شود
- **Environment**: هرگز `.env` فایل را در git کمیت نکنید (اما `.env.example` را نگاه دارید)

## 🔍 اگر خطا دوباره رخ دهد

دستور زیر را اجرا کنید و خروجی را بفرستید:
```bash
php artisan tinker
```

یا:
```bash
tail -f storage/logs/laravel.log
```

---

**نیاز به کمک؟ مقادیر هاست شما را مشخص کنید.**
