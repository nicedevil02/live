<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\MarketService;

class FetchMarketDataMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // فقط اگر دیتای مارکت در کش وجود نداشت (مثلاً اولین بار بعد از نصب) اقدام به واکشی می‌کنیم.
        // در بقیه موارد، Schedule Task مسئول آپدیت در پس‌زمینه است.
        if (!\App\Models\MarketCache::exists()) {
            try {
                $service = resolve(MarketService::class);
                $service->refreshIfStale(0); // اجبار به واکشی
            } catch (\Throwable $e) {
                \Log::warning('Market data initial fetch error: ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}
