<?php

namespace App\Http\Controllers;

use App\Models\DisplayItem;
use App\Models\DisplaySetting;
use App\Models\ProductSlide;
use App\Services\MarketService;
use Illuminate\Http\Request;

class PublicDisplayController extends Controller
{
    protected $marketService;

    public function __construct(MarketService $marketService)
    {
        $this->marketService = $marketService;
    }

    public function show()
    {
        // آپدیت در صورت قدیمی بودن (کاهش بازه به 30 ثانیه برای نمایشگر طلا)
        $this->marketService->refreshIfStale(30);

        $snapshot = $this->buildSnapshot();
        return view('display.live', ['snapshot' => $snapshot]);
    }

    public function snapshot()
    {
        $this->marketService->refreshIfStale(30);

        return response()->json($this->buildSnapshot());
    }

    public function health()
    {
        // به جای چک کردن فیلد is_stale، چک می‌کنیم که آیا در 10 دقیقه اخیر فچ موفقی داشته‌ایم یا خیر
        $lastFetch = \App\Models\MarketCache::max('fetched_at');
        $isHealthy = $lastFetch && \Illuminate\Support\Carbon::parse($lastFetch)->diffInMinutes(now()) < 10;

        return response()->json([
            'status'              => $isHealthy ? 'ok' : 'degraded',
            'lastSuccessfulFetch' => $lastFetch ?? now()->toISOString(),
        ]);
    }

    private function buildSnapshot()
    {
        $settings = DisplaySetting::firstOrFail();
        $items    = DisplayItem::orderBy('order')->get();
        $products = ProductSlide::with('images')->where('is_visible', true)->latest()->get();
        $priceFeed = $this->marketService->getPriceFeed();

        // پیدا کردن آخرین زمان آپدیت واقعی از کش قیمت‌ها
        $lastFetch = \App\Models\MarketCache::max('fetched_at');

        return [
            'updatedAt'    => $lastFetch ? \Illuminate\Support\Carbon::parse($lastFetch)->toISOString() : now()->toISOString(),
            'apiTime'      => \Cache::get('market_api_last_time', '---'),
            'displayItems' => $items,
            'priceFeed'    => $priceFeed,
            'products'     => $products,
            'settings'     => $settings,
        ];
    }
}
