<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // روش 1: اجرای مستقیم command (اگر queue worker اجرا شود)
        $schedule->command('market:fetch')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->onSuccess(function () {
                \Log::info('Scheduler: قیمت‌های بازار با موفقیت آپدیت شدند');
            })
            ->onFailure(function () {
                \Log::warning('Scheduler: خطا در آپدیت قیمت‌های بازار');
            });

        // روش 2: dispatch کردن Job برای Queue (بهتر برای production)
        $schedule->job(new \App\Jobs\FetchMarketPrices)
            ->everyFiveMinutes()
            ->withoutOverlapping();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
