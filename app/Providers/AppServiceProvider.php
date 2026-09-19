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
        if (is_dir(base_path('public_html')) && ($this->app->environment('production') || filter_var(env('USE_PUBLIC_HTML', true), FILTER_VALIDATE_BOOL))) {
            $this->app->usePublicPath(base_path('public_html'));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // اجبار به استفاده از HTTPS در پروداکشن یا با کانفیگ FORCE_HTTPS
        if ($this->app->environment('production') || env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
    }
}
