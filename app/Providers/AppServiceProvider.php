<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // این خط برای کارکرد صحیح پوشه public_html ضروری است
        // Host keeps assets in public_html; local development uses Laravel's public directory.
        if ($this->app->environment('production') || filter_var(env('USE_PUBLIC_HTML', false), FILTER_VALIDATE_BOOL)) {
            $this->app->usePublicPath(base_path('public_html'));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // اجبار به استفاده از HTTPS (فقط در حالتی که صریحاً از فایل env درخواست شود، برای رفع مشکل آپلود روی هاست‌های بدون SSL)
        if (env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
    }
}
