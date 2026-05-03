<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            $didFetch = resolve(\App\Services\MarketService::class)->refreshIfStale(60);

            if ($didFetch) {
                \Log::info('Fetching market data on boot...', ['timestamp' => now()->toISOString()]);
                \Log::info('Market data fetch completed and cached');
            }
        } catch (\Throwable $e) {
            \Log::error('Failed to fetch market data on boot', ['error' => $e->getMessage(), 'trace' => substr($e->getTraceAsString(), 0, 500)]);
        }
    }
}
