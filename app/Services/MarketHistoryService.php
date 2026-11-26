<?php

namespace App\Services;

use App\Models\FormulaConfig;
use App\Models\MarketCache;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class MarketHistoryService
{
    public const VALID_RANGES = ['1d', '7d', '30d', '1y'];

    public const SYMBOL_META = [
        'gold18'         => ['label' => 'طلای ۱۸ عیار',       'unit' => 'تومان', 'decimals' => 0, 'tgju' => 'geram18',           'scale' => 0.1],
        'buy_gold'       => ['label' => 'گرم خرید ۱۸',        'unit' => 'تومان', 'decimals' => 0, 'tgju' => null,                'scale' => 1.0],
        'gold24'         => ['label' => 'طلای ۲۴ عیار',       'unit' => 'تومان', 'decimals' => 0, 'tgju' => 'geram24',           'scale' => 0.1],
        'mesghal17'      => ['label' => 'آبشده',              'unit' => 'تومان', 'decimals' => 0, 'tgju' => 'mesghal',           'scale' => 0.1],
        'coin_emami'     => ['label' => 'سکه امامی',          'unit' => 'تومان', 'decimals' => 0, 'tgju' => 'sekee',             'scale' => 0.1],
        'coin_bahar'     => ['label' => 'سکه بهار آزادی',     'unit' => 'تومان', 'decimals' => 0, 'tgju' => 'sekeb',             'scale' => 0.1],
        'coin_nim'       => ['label' => 'نیم سکه',            'unit' => 'تومان', 'decimals' => 0, 'tgju' => 'nim',               'scale' => 0.1],
        'coin_rob'       => ['label' => 'ربع سکه',            'unit' => 'تومان', 'decimals' => 0, 'tgju' => 'rob',               'scale' => 0.1],
        'coin_gerami'    => ['label' => 'سکه گرمی',           'unit' => 'تومان', 'decimals' => 0, 'tgju' => 'gerami',            'scale' => 0.1],
        'usdt'           => ['label' => 'تتر (دلار دیجیتال)', 'unit' => 'تومان', 'decimals' => 0, 'tgju' => 'crypto-tether-irr', 'scale' => 0.1],
        'global_mesghal' => ['label' => 'مظنه جهانی طلا',     'unit' => 'تومان', 'decimals' => 0, 'tgju' => null,                'scale' => 1.0],
        'ounce'          => ['label' => 'انس جهانی طلا',      'unit' => 'دلار',  'decimals' => 2, 'tgju' => 'ons',               'scale' => 1.0],
        'silver_ounce'   => ['label' => 'انس جهانی نقره',     'unit' => 'دلار',  'decimals' => 2, 'tgju' => 'silver',            'scale' => 1.0],
        'oil_brent'      => ['label' => 'نفت برنت',           'unit' => 'دلار',  'decimals' => 2, 'tgju' => 'oil_brent',         'scale' => 1.0],
        'bitcoin'        => ['label' => 'بیت کوین',           'unit' => 'دلار',  'decimals' => 2, 'tgju' => 'crypto-bitcoin',    'scale' => 1.0],
    ];

    protected static bool $tablesChecked = false;

    public static function ensureTablesExist(): void
    {
        if (self::$tablesChecked) {
            return;
        }
        self::$tablesChecked = true;

        try {
            if (!Schema::hasTable('market_daily_candles')) {
                Schema::create('market_daily_candles', function (Blueprint $table) {
                    $table->id();
                    $table->string('symbol', 40);
                    $table->date('trade_date');
                    $table->string('jalali_date', 16)->nullable();
                    $table->decimal('open_price', 20, 2);
                    $table->decimal('high_price', 20, 2);
                    $table->decimal('low_price', 20, 2);
                    $table->decimal('close_price', 20, 2);
                    $table->timestamps();

                    $table->unique(['symbol', 'trade_date']);
                    $table->index(['symbol', 'trade_date']);
                });
            }

            if (!Schema::hasTable('market_price_points')) {
                Schema::create('market_price_points', function (Blueprint $table) {
                    $table->id();
                    $table->string('symbol', 40);
                    $table->decimal('price', 20, 2);
                    $table->timestamp('recorded_at');

                    $table->index(['symbol', 'recorded_at']);
                });
            }

            if (!Schema::hasTable('market_hourly_points')) {
                Schema::create('market_hourly_points', function (Blueprint $table) {
                    $table->id();
                    $table->string('symbol', 40);
                    $table->timestamp('bucket_at');
                    $table->decimal('price', 20, 2);

                    $table->unique(['symbol', 'bucket_at']);
                });
            }
        } catch (\Throwable $e) {
            Log::warning('MarketHistoryService ensureTablesExist error: ' . $e->getMessage());
        }
    }

    public static function isValidSymbol(string $symbol): bool
    {
        return isset(self::SYMBOL_META[$symbol]);
    }

    public static function getSymbolMeta(string $symbol): ?array
    {
        return self::SYMBOL_META[$symbol] ?? null;
    }

    public static function getBaseSymbols(): array
    {
        return array_keys(self::SYMBOL_META);
    }

    public function recordTick(string $symbol, float $value, ?float $todayOpenPrice = null): void
    {
        if ($value <= 0 || !isset(self::SYMBOL_META[$symbol]) || $symbol === 'buy_gold') {
            return;
        }

        self::ensureTablesExist();

        $meta = self::SYMBOL_META[$symbol];
        $decimals = $meta['decimals'];
        $cleanVal = round($value, $decimals);

        $tehranNow = now('Asia/Tehran');
        $today = $tehranNow->format('Y-m-d');
        $lastGuardKey = "mkt_cdl_val_{$symbol}_{$today}";
        $prevRecorded = Cache::get($lastGuardKey);
        $shouldUpdateCandle = Cache::add("mkt_cdl_{$symbol}", 1, 45);

        if (!$shouldUpdateCandle && $prevRecorded !== null && (float) $prevRecorded > 0) {
            $diffRatio = abs($cleanVal - (float) $prevRecorded) / (float) $prevRecorded;
            if ($diffRatio > 0.0005) {
                $shouldUpdateCandle = true;
            }
        }

        if ($shouldUpdateCandle) {
            $existing = DB::table('market_daily_candles')
                ->where('symbol', $symbol)
                ->where('trade_date', $today)
                ->first();

            if ($existing) {
                DB::table('market_daily_candles')
                    ->where('id', $existing->id)
                    ->update([
                        'high_price'  => max((float) $existing->high_price, $cleanVal),
                        'low_price'   => min((float) $existing->low_price, $cleanVal),
                        'close_price' => $cleanVal,
                        'updated_at'  => now(),
                    ]);
            } else {
                $open = ($todayOpenPrice && $todayOpenPrice > 0) ? round($todayOpenPrice, $decimals) : $cleanVal;
                DB::table('market_daily_candles')->insert([
                    'symbol'      => $symbol,
                    'trade_date'  => $today,
                    'jalali_date' => User::toJalali($tehranNow, false),
                    'open_price'  => $open,
                    'high_price'  => max($open, $cleanVal),
                    'low_price'   => min($open, $cleanVal),
                    'close_price' => $cleanVal,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            Cache::put($lastGuardKey, $cleanVal, 3600);
        }

        // یک نقطه در هر دقیقه برای نمودار ۱ روزه
        if (Cache::add("mkt_pt_{$symbol}", 1, 55)) {
            DB::table('market_price_points')->insert([
                'symbol'      => $symbol,
                'price'       => $cleanVal,
                'recorded_at' => now(),
            ]);
        }

        // آخرین نرخ هر ساعت برای نمودار ۷ روزه
        if (Cache::add("mkt_hr_{$symbol}", 1, 50)) {
            DB::table('market_hourly_points')->upsert(
                [[
                    'symbol'    => $symbol,
                    'bucket_at' => now()->startOfHour()->format('Y-m-d H:i:s'),
                    'price'     => $cleanVal,
                ]],
                ['symbol', 'bucket_at'],
                ['price']
            );
        }

        if (Cache::add('mkt_pt_prune_lock', 1, 3600)) {
            DB::table('market_price_points')
                ->where('recorded_at', '<', now()->subHours(48))
                ->delete();
            DB::table('market_hourly_points')
                ->where('bucket_at', '<', now()->subDays(9))
                ->delete();
        }
    }

    public function backfillSymbolFromTgju(string $symbol, int $days = 370): int
    {
        if (!isset(self::SYMBOL_META[$symbol])) {
            return 0;
        }

        self::ensureTablesExist();

        if ($symbol === 'buy_gold') {
            return $this->backfillSymbolFromTgju('gold18', $days);
        }

        if ($symbol === 'global_mesghal') {
            $this->backfillSymbolFromTgju('ounce', $days);
            $this->backfillSymbolFromTgju('usdt', $days);
            return $this->backfillGlobalMesghalFromCandles($days);
        }

        $meta = self::SYMBOL_META[$symbol];
        $slug = $meta['tgju'] ?? null;
        if (!$slug) {
            return 0;
        }

        $length = max(7, min(400, $days));
        $url = "https://api.tgju.org/v1/market/indicator/summary-table-data/{$slug}?length={$length}&start=0";

        try {
            $response = Http::retry(2, 500)
                ->withOptions(['verify' => false])
                ->timeout(12)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) TalaLive/1.0'])
                ->get($url);

            if (!$response->successful()) {
                Log::warning("TGJU history HTTP {$response->status()} for {$symbol} ({$slug})");
                return 0;
            }

            $json = $response->json();
            $rawRows = $json['data'] ?? null;
            if (!is_array($rawRows) || empty($rawRows)) {
                return 0;
            }
        } catch (\Throwable $e) {
            Log::warning("TGJU history request error for {$symbol}: " . $e->getMessage());
            return 0;
        }

        $scale = (float) $meta['scale'];
        $decimals = (int) $meta['decimals'];
        $now = now();
        $todayStr = now('Asia/Tehran')->format('Y-m-d');
        $parsedByDate = [];

        foreach ($rawRows as $row) {
            if (!is_array($row) || count($row) < 7) {
                continue;
            }

            $rawDate = trim(strip_tags((string) ($row[6] ?? '')));
            $tradeDate = str_replace('/', '-', $rawDate);
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tradeDate)) {
                continue;
            }

            $close = round($this->parseTgjuNumber($row[3] ?? '') * $scale, $decimals);
            if ($close <= 0) {
                continue;
            }

            $openRaw = round($this->parseTgjuNumber($row[0] ?? '') * $scale, $decimals);
            $lowRaw  = round($this->parseTgjuNumber($row[1] ?? '') * $scale, $decimals);
            $highRaw = round($this->parseTgjuNumber($row[2] ?? '') * $scale, $decimals);

            $open = $openRaw > 0 ? $openRaw : $close;
            $high = max($open, $close, $highRaw > 0 ? $highRaw : $close);
            $low  = min($open, $close, $lowRaw > 0 ? $lowRaw : $close);

            $jalaliRaw = trim(strip_tags((string) ($row[7] ?? '')));
            if (!preg_match('/^\d{4}\/\d{2}\/\d{2}$/', $jalaliRaw)) {
                $jalaliRaw = User::toJalali(Carbon::parse($tradeDate), false);
            }

            $parsedByDate[$tradeDate] = [
                'symbol'      => $symbol,
                'trade_date'  => $tradeDate,
                'jalali_date' => $jalaliRaw,
                'open_price'  => $open,
                'high_price'  => $high,
                'low_price'   => $low,
                'close_price' => $close,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        if (empty($parsedByDate)) {
            return 0;
        }

        // اگر امروز از قبل رکورد زنده داشت، کندل تاریخی غیرزنده امروز روی دیتای زنده بازنویسی نشود
        $existingToday = DB::table('market_daily_candles')
            ->where('symbol', $symbol)
            ->where('trade_date', $todayStr)
            ->first();

        if ($existingToday) {
            unset($parsedByDate[$todayStr]);
        }

        $rows = array_values($parsedByDate);
        if (empty($rows)) {
            return 0;
        }

        foreach (array_chunk($rows, 200) as $chunk) {
            DB::table('market_daily_candles')->upsert(
                $chunk,
                ['symbol', 'trade_date'],
                ['jalali_date', 'open_price', 'high_price', 'low_price', 'close_price', 'updated_at']
            );
        }

        return count($rows);
    }

    protected function backfillGlobalMesghalFromCandles(int $days): int
    {
        $since = now('Asia/Tehran')->subDays(max(7, $days) + 5)->format('Y-m-d');

        $ounceRows = DB::table('market_daily_candles')
            ->where('symbol', 'ounce')
            ->where('trade_date', '>=', $since)
            ->orderBy('trade_date', 'asc')
            ->get()
            ->keyBy('trade_date');

        $usdtRows = DB::table('market_daily_candles')
            ->where('symbol', 'usdt')
            ->where('trade_date', '>=', $since)
            ->orderBy('trade_date', 'asc')
            ->get();

        if ($ounceRows->isEmpty() || $usdtRows->isEmpty()) {
            return 0;
        }

        $ounceDates = $ounceRows->keys()->all();
        $now = now();
        $todayStr = now('Asia/Tehran')->format('Y-m-d');
        $upsertRows = [];

        foreach ($usdtRows as $uRow) {
            if ($uRow->trade_date === $todayStr) {
                continue;
            }

            $oRow = $ounceRows->get($uRow->trade_date);
            if (!$oRow) {
                $targetTs = strtotime($uRow->trade_date);
                for ($i = count($ounceDates) - 1; $i >= 0; $i--) {
                    $candDate = $ounceDates[$i];
                    $diffDays = ($targetTs - strtotime($candDate)) / 86400;
                    if ($diffDays >= 0 && $diffDays <= 4) {
                        $oRow = $ounceRows->get($candDate);
                        break;
                    }
                }
            }

            if (!$oRow) {
                continue;
            }

            $open  = round(((float) $oRow->open_price * (float) $uRow->open_price) / 9.5742);
            $close = round(((float) $oRow->close_price * (float) $uRow->close_price) / 9.5742);
            $high  = round(((float) $oRow->high_price * (float) $uRow->high_price) / 9.5742);
            $low   = round(((float) $oRow->low_price * (float) $uRow->low_price) / 9.5742);

            if ($close <= 0) {
                continue;
            }

            $upsertRows[] = [
                'symbol'      => 'global_mesghal',
                'trade_date'  => $uRow->trade_date,
                'jalali_date' => $uRow->jalali_date ?: User::toJalali(Carbon::parse($uRow->trade_date), false),
                'open_price'  => $open > 0 ? $open : $close,
                'high_price'  => max($open, $close, $high > 0 ? $high : $close),
                'low_price'   => min($open > 0 ? $open : $close, $close, $low > 0 ? $low : $close),
                'close_price' => $close,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        if (empty($upsertRows)) {
            return 0;
        }

        foreach (array_chunk($upsertRows, 200) as $chunk) {
            DB::table('market_daily_candles')->upsert(
                $chunk,
                ['symbol', 'trade_date'],
                ['jalali_date', 'open_price', 'high_price', 'low_price', 'close_price', 'updated_at']
            );
        }

        return count($upsertRows);
    }

    public function parseTgjuNumber($raw): float
    {
        $text = strip_tags((string) $raw);
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٬', '،'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ',', ','];
        $text = str_replace($persian, $english, $text);
        $text = str_replace(',', '', $text);
        $text = preg_replace('/[^0-9.\-]/', '', $text);

        return is_numeric($text) ? (float) $text : 0.0;
    }

    public function getChartSeries(string $symbol, string $range = '7d', ?User $user = null): array
    {
        if (!isset(self::SYMBOL_META[$symbol])) {
            throw new \InvalidArgumentException("Invalid chart symbol: {$symbol}");
        }

        if (!in_array($range, self::VALID_RANGES, true)) {
            $range = '7d';
        }

        self::ensureTablesExist();

        $meta = self::SYMBOL_META[$symbol];
        $decimals = (int) $meta['decimals'];
        $baseSymbol = ($symbol === 'buy_gold') ? 'gold18' : $symbol;
        $multiplier = 1.0;

        if ($symbol === 'buy_gold') {
            $formula = $user
                ? FormulaConfig::where('user_id', $user->id)->first()
                : null;
            if (!$formula) {
                $superUser = User::where('is_super_admin', true)->first() ?? User::first();
                $formula = $superUser
                    ? FormulaConfig::where('user_id', $superUser->id)->first()
                    : FormulaConfig::first();
            }
            $multA = (float) ($formula?->buy_multiplier_a ?? 740);
            $divB  = (float) ($formula?->buy_divisor_b ?? 750);
            $multiplier = ($divB > 0) ? ($multA / $divB) : (740 / 750);
        }

        // واکشی خودکار تاریخچه واقعی در اولین درخواست در صورت خالی بودن جدول کندل‌ها
        $candleCount = DB::table('market_daily_candles')->where('symbol', $baseSymbol)->count();
        if ($candleCount < 10 && Cache::add("tgju_bf_guard_{$baseSymbol}", 1, 600)) {
            $this->backfillSymbolFromTgju($baseSymbol, 370);
        }

        $cacheRecord = MarketCache::where('symbol', $baseSymbol)->first();
        $rawLive = (float) ($cacheRecord?->value ?? 0);

        if ($baseSymbol === 'global_mesghal' && $rawLive <= 0) {
            $ounceRef = (float) (MarketCache::where('symbol', 'ounce')->value('value') ?? 0);
            $usdtRef  = (float) (MarketCache::where('symbol', 'usdt')->value('value') ?? 0);
            if ($ounceRef > 0 && $usdtRef > 0) {
                $rawLive = ($ounceRef * $usdtRef) / 9.5742;
            }
        } elseif ($baseSymbol === 'oil_brent' && $rawLive <= 0) {
            $rawLive = 98.32;
        } elseif ($baseSymbol === 'silver_ounce' && $rawLive <= 0) {
            $rawLive = 31.45;
        }

        $livePrice = $rawLive > 0 ? round($rawLive * $multiplier, $decimals) : 0.0;
        $yesterdayRaw = (float) ($cacheRecord?->yesterday_price ?? 0);
        $todayOpenRaw = (float) ($cacheRecord?->today_open_price ?? 0);
        $yesterdayPrice = $yesterdayRaw > 0 ? round($yesterdayRaw * $multiplier, $decimals) : 0.0;
        $todayOpenPrice = $todayOpenRaw > 0 ? round($todayOpenRaw * $multiplier, $decimals) : 0.0;

        $tehranNow = now('Asia/Tehran');
        $todayStr = $tehranNow->format('Y-m-d');
        $points = [];
        $baseline = $livePrice;
        $periodHigh = $livePrice;
        $periodLow = $livePrice;
        $jalaliCache = [];
        $jalaliOf = function (Carbon $dt) use (&$jalaliCache) {
            $key = $dt->format('Y-m-d');
            if (!isset($jalaliCache[$key])) {
                $jalaliCache[$key] = User::toJalali($dt, false);
            }
            return $jalaliCache[$key];
        };

        if ($range === '1d') {
            // نمودار ۱ روزه: نرخ هر دقیقه در ۲۴ ساعت گذشته
            $tickRows = DB::table('market_price_points')
                ->where('symbol', $baseSymbol)
                ->where('recorded_at', '>=', now()->subHours(24))
                ->orderBy('recorded_at', 'asc')
                ->get(['price', 'recorded_at']);

            $tickPoints = [];
            foreach ($tickRows as $row) {
                $p = round(((float) $row->price) * $multiplier, $decimals);
                if ($p <= 0) {
                    continue;
                }
                $dt = Carbon::parse($row->recorded_at)->setTimezone('Asia/Tehran');
                $tickPoints[] = [
                    'ts'    => $dt->timestamp,
                    'label' => $jalaliOf($dt) . ' · ساعت ' . $dt->format('H:i'),
                    'short' => $dt->format('H:i'),
                    'price' => $p,
                ];
            }

            if ($yesterdayPrice <= 0) {
                $prevCandle = DB::table('market_daily_candles')
                    ->where('symbol', $baseSymbol)
                    ->where('trade_date', '<', $todayStr)
                    ->orderBy('trade_date', 'desc')
                    ->first();
                if ($prevCandle && (float) $prevCandle->close_price > 0) {
                    $yesterdayPrice = round(((float) $prevCandle->close_price) * $multiplier, $decimals);
                }
            }

            // تا زمانی که نقاط دقیقه‌ای کافی ثبت نشده، از نرخ‌های واقعی پایانی دیروز و بازگشایی امروز به عنوان لنگر استفاده می‌شود
            $prefixPoints = [];
            if (count($tickPoints) < 4) {
                $firstTickTs = !empty($tickPoints) ? $tickPoints[0]['ts'] : $tehranNow->timestamp;

                if ($yesterdayPrice > 0) {
                    $yDt = $tehranNow->copy()->subHours(24);
                    if ($yDt->timestamp < $firstTickTs - 300) {
                        $prefixPoints[] = [
                            'ts'    => $yDt->timestamp,
                            'label' => 'نرخ پایانی دیروز',
                            'short' => 'دیروز',
                            'price' => $yesterdayPrice,
                        ];
                    }
                }

                if ($todayOpenPrice > 0) {
                    $openDt = $tehranNow->copy()->setTime(9, 0, 0);
                    if ($openDt->greaterThan($tehranNow->copy()->subMinutes(5))) {
                        $openDt = $tehranNow->copy()->subHours(2);
                    }
                    if ($openDt->timestamp < $firstTickTs - 120) {
                        $prefixPoints[] = [
                            'ts'    => $openDt->timestamp,
                            'label' => 'بازگشایی امروز · ساعت ' . $openDt->format('H:i'),
                            'short' => $openDt->format('H:i'),
                            'price' => $todayOpenPrice,
                        ];
                    }
                }
            }

            $points = array_merge($prefixPoints, $tickPoints);

            if ($livePrice > 0) {
                $last = !empty($points) ? $points[count($points) - 1] : null;
                if (!$last || ($tehranNow->timestamp - $last['ts'] > 55) || abs($last['price'] - $livePrice) > 0.0001) {
                    $points[] = [
                        'ts'    => $tehranNow->timestamp,
                        'label' => 'نرخ فعلی · ساعت ' . $tehranNow->format('H:i'),
                        'short' => $tehranNow->format('H:i'),
                        'price' => $livePrice,
                    ];
                }
            } elseif (!empty($points)) {
                $livePrice = (float) $points[count($points) - 1]['price'];
            }

            $baseline = $yesterdayPrice > 0
                ? $yesterdayPrice
                : (!empty($points) ? (float) $points[0]['price'] : $livePrice);

            $prices = array_column($points, 'price');
            if (!empty($prices)) {
                $periodHigh = max($prices);
                $periodLow = min($prices);
            }

            $todayCandle = DB::table('market_daily_candles')
                ->where('symbol', $baseSymbol)
                ->where('trade_date', $todayStr)
                ->first();
            if ($todayCandle) {
                $cHigh = round(((float) $todayCandle->high_price) * $multiplier, $decimals);
                $cLow  = round(((float) $todayCandle->low_price) * $multiplier, $decimals);
                if ($cHigh > 0) {
                    $periodHigh = $periodHigh > 0 ? max($periodHigh, $cHigh) : $cHigh;
                }
                if ($cLow > 0) {
                    $periodLow = $periodLow > 0 ? min($periodLow, $cLow) : $cLow;
                }
            }
        } elseif ($range === '7d') {
            // نمودار ۷ روزه: نرخ هر ساعت. بخش‌هایی از هفته که هنوز نقطه ساعتی ثبت نشده با نرخ پایانی روزانه واقعی پر می‌شود
            $sinceTs = now()->subDays(7);
            $hourly = [];

            $hourRows = DB::table('market_hourly_points')
                ->where('symbol', $baseSymbol)
                ->where('bucket_at', '>=', $sinceTs)
                ->orderBy('bucket_at', 'asc')
                ->get(['price', 'bucket_at']);
            foreach ($hourRows as $row) {
                $dt = Carbon::parse($row->bucket_at)->setTimezone('Asia/Tehran');
                $hourly[$dt->copy()->startOfHour()->timestamp] = (float) $row->price;
            }

            $tickRows = DB::table('market_price_points')
                ->where('symbol', $baseSymbol)
                ->where('recorded_at', '>=', $sinceTs)
                ->orderBy('recorded_at', 'asc')
                ->get(['price', 'recorded_at']);
            $tickByHour = [];
            foreach ($tickRows as $row) {
                $dt = Carbon::parse($row->recorded_at)->setTimezone('Asia/Tehran');
                $tickByHour[$dt->copy()->startOfHour()->timestamp] = (float) $row->price;
            }
            foreach ($tickByHour as $hourTs => $price) {
                if (!isset($hourly[$hourTs])) {
                    $hourly[$hourTs] = $price;
                }
            }
            ksort($hourly);

            $firstHourlyTs = !empty($hourly) ? array_key_first($hourly) : PHP_INT_MAX;

            $sinceDate = $tehranNow->copy()->subDays(7)->format('Y-m-d');
            $candleRows = DB::table('market_daily_candles')
                ->where('symbol', $baseSymbol)
                ->where('trade_date', '>=', $sinceDate)
                ->orderBy('trade_date', 'asc')
                ->get();

            $candleHigh = 0.0;
            $candleLow = 0.0;
            foreach ($candleRows as $row) {
                $close = round(((float) $row->close_price) * $multiplier, $decimals);
                if ($close <= 0) {
                    continue;
                }
                $high = round(((float) $row->high_price) * $multiplier, $decimals);
                $low  = round(((float) $row->low_price) * $multiplier, $decimals);
                $candleHigh = max($candleHigh, $high);
                $candleLow = $candleLow > 0 ? min($candleLow, $low > 0 ? $low : $close) : ($low > 0 ? $low : $close);

                $dayDt = Carbon::parse($row->trade_date . ' 12:00:00', 'Asia/Tehran');
                if ($dayDt->timestamp >= $firstHourlyTs - 3600) {
                    continue;
                }
                $jDate = $row->jalali_date ?: $jalaliOf($dayDt);
                $points[] = [
                    'ts'    => $dayDt->timestamp,
                    'label' => $jDate . ' · نرخ پایانی روز',
                    'short' => substr($jDate, 5),
                    'price' => $close,
                ];
            }

            foreach ($hourly as $hourTs => $rawPrice) {
                $p = round($rawPrice * $multiplier, $decimals);
                if ($p <= 0) {
                    continue;
                }
                $dt = Carbon::createFromTimestamp($hourTs, 'Asia/Tehran');
                $jDate = $jalaliOf($dt);
                $points[] = [
                    'ts'    => $hourTs,
                    'label' => $jDate . ' · ساعت ' . $dt->format('H:i'),
                    'short' => substr($jDate, 5) . ' ' . $dt->format('H:i'),
                    'price' => $p,
                ];
            }

            if ($livePrice > 0) {
                $last = !empty($points) ? $points[count($points) - 1] : null;
                if (!$last || ($tehranNow->timestamp - $last['ts'] > 600) || abs($last['price'] - $livePrice) > 0.0001) {
                    $jDate = $jalaliOf($tehranNow);
                    $points[] = [
                        'ts'    => $tehranNow->timestamp,
                        'label' => $jDate . ' · نرخ فعلی ' . $tehranNow->format('H:i'),
                        'short' => substr($jDate, 5) . ' ' . $tehranNow->format('H:i'),
                        'price' => $livePrice,
                    ];
                }
            } elseif (!empty($points)) {
                $livePrice = (float) $points[count($points) - 1]['price'];
            }

            usort($points, static fn (array $a, array $b) => $a['ts'] <=> $b['ts']);

            $baseline = !empty($points) ? (float) $points[0]['price'] : $livePrice;
            if (!empty($points)) {
                $prices = array_column($points, 'price');
                $periodHigh = max($prices);
                $periodLow = min($prices);
                if ($candleHigh > 0) {
                    $periodHigh = max($periodHigh, $candleHigh);
                }
                if ($candleLow > 0) {
                    $periodLow = min($periodLow, $candleLow);
                }
            }
        } else {
            $days = $range === '30d' ? 30 : 365;
            $sinceDate = $tehranNow->copy()->subDays($days)->format('Y-m-d');

            $candleRows = DB::table('market_daily_candles')
                ->where('symbol', $baseSymbol)
                ->where('trade_date', '>=', $sinceDate)
                ->orderBy('trade_date', 'asc')
                ->get();

            $highs = [];
            $lows = [];
            foreach ($candleRows as $row) {
                $close = round(((float) $row->close_price) * $multiplier, $decimals);
                if ($close <= 0) {
                    continue;
                }
                $high = round(((float) $row->high_price) * $multiplier, $decimals);
                $low  = round(((float) $row->low_price) * $multiplier, $decimals);
                $highs[] = max($close, $high);
                $lows[] = min($close, $low > 0 ? $low : $close);

                $dayDt = Carbon::parse($row->trade_date . ' 12:00:00', 'Asia/Tehran');
                $jDate = $row->jalali_date ?: $jalaliOf($dayDt);
                $points[] = [
                    'ts'    => $dayDt->timestamp,
                    'label' => $jDate,
                    'short' => substr($jDate, 5),
                    'price' => $close,
                ];
            }

            if ($livePrice > 0) {
                $todayJalali = $jalaliOf($tehranNow);
                $lastIdx = count($points) - 1;
                $todayNoon = Carbon::parse($todayStr . ' 12:00:00', 'Asia/Tehran')->timestamp;
                if ($lastIdx >= 0 && $points[$lastIdx]['ts'] === $todayNoon) {
                    $points[$lastIdx]['price'] = $livePrice;
                    $points[$lastIdx]['ts'] = $tehranNow->timestamp;
                } else {
                    $points[] = [
                        'ts'    => $tehranNow->timestamp,
                        'label' => $todayJalali . ' (امروز)',
                        'short' => substr($todayJalali, 5),
                        'price' => $livePrice,
                    ];
                }
                $highs[] = $livePrice;
                $lows[] = $livePrice;
            } elseif (!empty($points)) {
                $livePrice = (float) $points[count($points) - 1]['price'];
            }

            $baseline = !empty($points) ? (float) $points[0]['price'] : $livePrice;
            if (!empty($highs)) {
                $periodHigh = max($highs);
                $periodLow = min($lows);
            }
        }

        $changeValue = round($livePrice - $baseline, $decimals);
        $changePercent = $baseline > 0 ? round(($changeValue / $baseline) * 100, 2) : 0.0;
        $direction = 'flat';
        if ($changeValue > 0.0001) {
            $direction = 'up';
        } elseif ($changeValue < -0.0001) {
            $direction = 'down';
        }

        return [
            'symbol'        => $symbol,
            'label'         => $meta['label'],
            'unit'          => $meta['unit'],
            'decimals'      => $decimals,
            'range'         => $range,
            'currentPrice'  => $livePrice,
            'startPrice'    => $baseline,
            'changeValue'   => $changeValue,
            'changePercent' => $changePercent,
            'direction'     => $direction,
            'highPrice'     => $periodHigh,
            'lowPrice'      => $periodLow,
            'updatedAt'     => $cacheRecord?->fetched_at?->toIso8601String() ?? now()->toIso8601String(),
            'points'        => array_values($points),
        ];
    }
}
