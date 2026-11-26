<?php

namespace App\Console\Commands;

use App\Services\MarketHistoryService;
use Illuminate\Console\Command;

class BackfillMarketHistory extends Command
{
    protected $signature = 'market:backfill-history {--symbol= : Optional single symbol to backfill} {--days=370 : Number of historical days to fetch}';

    protected $description = 'Backfill real daily historical OHLC candles for board symbols from TGJU';

    public function handle(MarketHistoryService $historyService): int
    {
        $single = $this->option('symbol');
        $days = max(7, min(400, (int) $this->option('days')));

        if ($single) {
            if (!MarketHistoryService::isValidSymbol((string) $single)) {
                $this->error("Unknown symbol: {$single}");
                return self::FAILURE;
            }
            $targets = [(string) $single];
        } else {
            // backfill از نمادهای پایه به همراه مظنه جهانی انجام می‌شود (buy_gold از gold18 مشتق می‌شود)
            $targets = array_values(array_filter(
                MarketHistoryService::getBaseSymbols(),
                static fn (string $s) => $s !== 'buy_gold' && $s !== 'global_mesghal'
            ));
            $targets[] = 'global_mesghal';
        }

        $totalRows = 0;
        foreach ($targets as $sym) {
            $count = $historyService->backfillSymbolFromTgju($sym, $days);
            $totalRows += $count;
            $this->line(sprintf('  %-16s => %d candles synced', $sym, $count));
        }

        $this->info("Completed market history backfill ({$totalRows} total candles synced).");
        return self::SUCCESS;
    }
}
