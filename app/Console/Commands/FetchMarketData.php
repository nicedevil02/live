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
        
        $now = \Illuminate\Support\Carbon::now('Asia/Tehran');
        $hour = $now->hour;
        
        if ($hour >= 9 && $hour < 22) {
            // در ساعات کاری (۹ الی ۲۲): بروزرسانی همه قیمت‌ها هر ۱۰ ثانیه (۶ بار در دقیقه)
            for ($i = 0; $i < 6; $i++) {
                $service->fetchAndCache();
                if ($i < 5) {
                    sleep(10);
                }
            }
        } else {
            // خارج از ساعات کاری: یک بروزرسانی در هر دقیقه
            $service->fetchAndCache();
        }
        
        $this->info('Done.');
        return 0;
    }
}
