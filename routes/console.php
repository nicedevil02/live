<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('market:fetch')
    ->everyMinute()
    ->withoutOverlapping();

Schedule::command('bing:wallpaper')
    ->dailyAt('00:05')
    ->withoutOverlapping();

Schedule::command('bing:wallpaper')
    ->dailyAt('06:00')
    ->withoutOverlapping();
