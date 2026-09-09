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
        
        $now = \Illuminate\Support\Carbon::now('Asia/Tehran');
        $hour = $now->hour;
        
        $iterations = ($hour >= 9 && $hour < 22) ? 6 : 1;

        for ($i = 0; $i < $iterations; $i++) {
            Cache::lock('market_fetch_lock', 25)->get(function () use ($service) {
                $service->fetchAndCache();
                Cache::put('market_last_fetch_at', now()->toISOString(), 3600);
            });

            if ($i < $iterations - 1) {
                sleep(10);
            }
        }
        
        $this->info('Done.');
        return 0;
    }
}
