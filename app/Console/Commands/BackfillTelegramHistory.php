<?php

namespace App\Console\Commands;

use App\Services\MarketHistoryService;
use Illuminate\Console\Command;

class BackfillTelegramHistory extends Command
{
    protected $signature = 'market:backfill-telegram {--hours=168 : Hours back to fetch} {--pages=80 : Max Telegram pages to paginate}';

    protected $description = 'Backfill real minute and hourly prices from @talalive_ir Telegram channel archive';

    public function handle(MarketHistoryService $historyService): int
    {
        $hours = max(24, min(240, (int) $this->option('hours')));
        $pages = max(1, min(150, (int) $this->option('pages')));

        $this->info("Fetching up to {$hours}h ({$pages} pages) from @talalive_ir...");
        $res = $historyService->backfillFromTelegramChannel($hours, $pages);

        $this->info(sprintf(
            'Done: %d pages, %d posts, %d hourly points, %d minute points synced.',
            $res['pages'],
            $res['posts'],
            $res['hourly_synced'],
            $res['minute_synced']
        ));

        return self::SUCCESS;
    }
}
