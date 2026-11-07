<?php

namespace App\Console\Commands;

use App\Services\BingWallpaperService;
use Illuminate\Console\Command;

class FetchBingWallpaper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bing:wallpaper {--force : Force download fresh wallpaper even if cached today}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and cache the latest Bing daily wallpaper for display screens';

    /**
     * Execute the console command.
     */
    public function handle(BingWallpaperService $service): int
    {
        $force = (bool)$this->option('force');
        $this->info($force ? 'Forcing refresh of Bing daily wallpaper...' : 'Checking Bing daily wallpaper cache...');

        $start = microtime(true);
        $result = $service->getTodayWallpaper($force);
        $duration = round(microtime(true) - $start, 2);

        if (!empty($result['title'])) {
            $this->info("Successfully processed Bing wallpaper in {$duration}s:");
            $this->line("  Title:     " . ($result['title'] ?? '-'));
            $this->line("  Date:      " . ($result['date'] ?? '-'));
            $this->line("  URL:       " . ($result['url'] ?? '-'));
            $this->line("  Copyright: " . ($result['copyright'] ?? '-'));
            if (!empty($result['size_kb'])) {
                $this->line("  Size:      {$result['size_kb']} KB");
            }
            return self::SUCCESS;
        }

        $this->warn('Bing wallpaper returned with fallback or empty data.');
        return self::FAILURE;
    }
}
