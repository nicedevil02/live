<?php

namespace App\Console\Commands;

use App\Services\MarketService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FetchMarketData extends Command
{
    protected $signature = 'market:fetch';
    protected $description = 'Fetch market data from active API sources';

    public function handle(MarketService $service): int
    {
        $this->info('Fetching market data...');
        
        Cache::lock('market_fetch_lock', 25)->get(function () use ($service) {
            $service->refreshIfStale($service->currentRefreshIntervalSeconds());
            Cache::put('market_last_fetch_at', now()->toISOString(), 3600);
        });
        
        $this->info('Done.');
        return 0;
    }
}
