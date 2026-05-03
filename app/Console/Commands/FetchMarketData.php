<?php

namespace App\Console\Commands;

use App\Services\MarketService;
use Illuminate\Console\Command;

class FetchMarketData extends Command
{
    protected $signature = 'market:fetch';
    protected $description = 'Fetch market data from active API sources';

    public function handle(MarketService $service): int
    {
        $this->info('Fetching market data...');
        $service->fetchAndCache();
        $this->info('Done.');
        return 0;
    }
}
