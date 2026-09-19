<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicDisplayController;

Route::get('/market/ticker', [PublicDisplayController::class, 'publicTicker'])->middleware('throttle:120,1')->name('api.market.ticker');
Route::get('/display/snapshot/{username}', [PublicDisplayController::class, 'snapshot'])->middleware('throttle:120,1')->name('api.display.snapshot');
Route::get('/display/health/{username}', [PublicDisplayController::class, 'health']);
Route::get('/tv/check/{session_code}', [PublicDisplayController::class, 'checkPairingStatus']);
Route::get('/tv/qr/{code}', [PublicDisplayController::class, 'qrCode'])->middleware('throttle:60,1');
Route::post('/tv/register-session', [PublicDisplayController::class, 'registerSession']);
Route::post('/tv/magic-sms', [PublicDisplayController::class, 'sendMagicSms'])->middleware('throttle:5,1');
Route::post('/tv/heartbeat', [PublicDisplayController::class, 'heartbeat'])->middleware('throttle:120,1');

// Endpoint برای دریافت دستی قیمت‌ها (محافظت‌شده با توکن و محدودیت نرخ)
Route::post('/display/refresh', function () {
    $token = request()->query('token') ?? request()->header('X-Cron-Token') ?? request()->input('token');
    $expected = env('CRON_TOKEN', 'talalive-cron-secret-2026');
    if (!auth()->check() && (!$token || $token !== $expected)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    try {
        $marketService = resolve(\App\Services\MarketService::class);
        $didFetch = $marketService->refreshIfStale(0);
        return response()->json(['success' => true, 'fetched' => $didFetch, 'message' => 'قیمت‌ها با موفقیت آپدیت شدند']);
    } catch (\Exception $e) {
        \Log::error('Refresh failed: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
})->middleware('throttle:10,1');

// Endpoint برای cron job - احراز هویت اجباری با توکن
Route::get('/public/cron/market-fetch', function () {
    try {
        $token = request()->query('token') ?? request()->header('X-Cron-Token');
        $expected = env('CRON_TOKEN', 'talalive-cron-secret-2026');
        if (!$token || $token !== $expected) {
            return response()->json(['error' => 'Unauthorized: Valid token is required'], 401);
        }
        
        $marketService = resolve(\App\Services\MarketService::class);
        $didFetch = $marketService->refreshIfStale($marketService->currentRefreshIntervalSeconds());
        
        return response()->json([
            'success' => true,
            'fetched' => $didFetch,
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
})->middleware('throttle:60,1');

// وب‌سرویس عمومی RESTful نرخ لحظه‌ای طلا، سکه و ارز
Route::get('/v1/rates', [\App\Http\Controllers\PublicPageController::class, 'apiRates'])->middleware('throttle:60,1');

