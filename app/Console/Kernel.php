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
            ->everyMinute()
            ->timezone('Asia/Tehran')
            ->between('09:00', '22:00')
            ->withoutOverlapping()
            ->onSuccess(function () {
                \Log::info('Scheduler: قیمت‌های بازار با موفقیت آپدیت شدند');
            })
            ->onFailure(function () {
                \Log::warning('Scheduler: خطا در آپدیت قیمت‌های بازار');
            });

        // روش 2: dispatch کردن Job برای Queue (بهتر برای production)
        $schedule->command('market:fetch')
            ->everyFiveMinutes()
            ->timezone('Asia/Tehran')
            ->unlessBetween('09:00', '22:00')
            ->withoutOverlapping();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
