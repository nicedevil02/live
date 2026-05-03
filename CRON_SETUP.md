# تنظیم Cron Job برای به‌روزرسانی قیمت‌های بازار

## مسئله
اپلیکیشن هر 60 ثانیه باید داده‌های بازار را از API دریافت کند، اما بدون cron job یا scheduler، این کار خودکار انجام نمی‌شود.

## حل‌های دستیاب

### حل 1: Cron Job (بهترین برای Production)
اگر hosting شما دسترسی به cron job اعطا می‌دهد:

#### گزینه الف: استفاده از `php artisan schedule:run`
```bash
*/1 * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1
```

مثال (اگر app در `/home/user/public_html/gold-app` باشد):
```bash
*/1 * * * * cd /home/user/public_html/gold-app && php artisan schedule:run >> /dev/null 2>&1
```

#### گزینه ب: استفاده از API Endpoint (راحت‌تر)
```bash
*/1 * * * * curl -s "https://yourdomain.com/api/public/cron/market-fetch?token=secure-market-fetch-token-2026" > /dev/null 2>&1
```

مثال دقیق:
```bash
*/1 * * * * curl -s "https://goldapp.com/api/public/cron/market-fetch?token=secure-market-fetch-token-2026" > /dev/null 2>&1
```

### حل 2: Middleware خودکار (Fallback)
اگر cron job تنظیم نشود، میانبر `FetchMarketDataMiddleware` در هر درخواست HTTP بررسی می‌کند و اگر 60 ثانیه گذشته باشد، درخواست خودکار می‌شود.

**نکته:** این روش فقط زمانی کار می‌کند که درخواست HTTP وجود داشته باشد. اگر هیچ کسی صفحه را نبیند، درخواست نمی‌شود.

### حل 3: cPanel/Hosting Panel
اگر hosting شما cPanel دارد:

1. وارد cPanel شوید
2. به بخش "Cron Jobs" رفتید
3. "Add New Cron Job" کلیک کنید
4. Common Settings: **Every Minute** انتخاب کنید
5. Command: 
```
curl -s "https://yourdomain.com/api/public/cron/market-fetch?token=secure-market-fetch-token-2026" > /dev/null 2>&1
```
6. Add Cron Job کلیک کنید

## تغییرات کد

- ✅ **Middleware اضافه شد:** `app/Http/Middleware/FetchMarketDataMiddleware.php`
- ✅ **API Endpoint اضافه شد:** `GET /api/public/cron/market-fetch`
- ✅ **Cron Token اضافه شد:** `.env` میں `CRON_TOKEN`

## تست

برای تست دستی endpoint:

```bash
# بدون token (اگر ENV میں token نباشد یا check disable شود)
curl "https://yourdomain.com/api/public/cron/market-fetch"

# با token
curl "https://yourdomain.com/api/public/cron/market-fetch?token=secure-market-fetch-token-2026"

# با verbose برای دیدن response
curl -v "https://yourdomain.com/api/public/cron/market-fetch?token=secure-market-fetch-token-2026"
```

## بررسی وضعیت

چک کنید آیا درخواست‌ها ثبت شده‌اند:

```bash
php artisan tinker

# تمام درخواست‌های با موضوع market را نمایش بده
>>> \App\Models\AuditLog::where('action', 'api_request_attempt')->latest()->limit(10)->get()
```

## نکات مهم

1. **Token:** برای امنیت بیشتر، token در `.env` تغییر دهید
2. **Timeout:** اگر درخواست timeout شود، cron interval را کاهش ندهید (مثلا 2 دقیقه بجای 1 دقیقه)
3. **Logs:** وضعیت درخواست‌ها در `storage/logs/laravel.log` ثبت می‌شود
4. **Performance:** API درخواست بطور synchronous انجام می‌شود؛ اگر خیلی بطی باشد، API timeout خواهد شد
