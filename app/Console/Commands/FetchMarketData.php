<?php

namespace App\Console\Commands;

use App\Services\MarketService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class FetchMarketData extends Command
{
    protected $signature = 'market:fetch';
    protected $description = 'Fetch market data from active API sources';

    public function handle(MarketService $service): int
    {
        $this->info('Fetching market data...');
        
        $now = Carbon::now('Asia/Tehran');
        $hour = $now->hour;
        
        // در ساعات کاری (۹ الی ۲۲): بروزرسانی هر ۱۰ ثانیه (۶ بار در دقیقه)
        $iterations = ($hour >= 9 && $hour < 22) ? 6 : 1;
        $interval = ($hour >= 9 && $hour < 22) ? 10 : 60;

        for ($i = 0; $i < $iterations; $i++) {
            $service->refreshIfStale($interval);

            if ($i < $iterations - 1) {
                sleep(10);
            }
        }
        
        $this->info('Done.');
        return 0;
    }
}
