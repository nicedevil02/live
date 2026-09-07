<?php

namespace Tests\Feature;

use App\Services\MarketService;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class MarketRefreshIntervalTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_market_refresh_interval_is_ten_seconds_during_business_hours(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-05-05 09:00:00', 'Asia/Tehran'));

        $this->assertSame(10, app(MarketService::class)->currentRefreshIntervalSeconds());
    }

    public function test_market_refresh_interval_is_one_minute_after_business_hours(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-05-05 22:00:00', 'Asia/Tehran'));

        $this->assertSame(60, app(MarketService::class)->currentRefreshIntervalSeconds());
    }
}
