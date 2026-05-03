<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicDisplayController;
use App\Http\Middleware\RequestAuditMiddleware;

Route::middleware([RequestAuditMiddleware::class])->group(function () {
    Route::get('/display/snapshot', [PublicDisplayController::class, 'snapshot']);
    Route::get('/display/health', [PublicDisplayController::class, 'health']);

    // Endpoint برای دریافت دستی قیمت‌ها (فقط برای testing)
    Route::post('/display/refresh', function () {
        try {
            resolve(\App\Services\MarketService::class)->fetchAndCache();
            return response()->json(['success' => true, 'message' => 'قیمت‌ها با موفقیت آپدیت شدند']);
        } catch (\Exception $e) {
            \Log::error('Refresh failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    });

    // Endpoint برای cron job - بدون احتیاج به احراز هویت
    Route::get('/public/cron/market-fetch', function () {
        try {
            // بررسی simple auth token (اختیاری برای امنیت)
            $token = request()->query('token');
            if ($token && $token !== env('CRON_TOKEN', 'default-secret')) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            resolve(\App\Services\MarketService::class)->fetchAndCache();
            \Cache::put('market_last_fetch_at', now()->toISOString(), 3600);

            return response()->json([
                'success' => true,
                'message' => 'Market data fetched successfully',
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            \Log::error('Cron market fetch failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    });
});
