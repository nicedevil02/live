<?php

namespace App\Services;

use App\Models\ApiSourceConfig;
use App\Models\FormulaConfig;
use App\Models\MarketCache;
use App\Models\AuditLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MarketService
{
    protected int $timeout = 15;

    public function refreshIfStale(int $maxAgeSeconds = 60): bool
    {
        return Cache::lock('market_fetch_lock', 30)->get(function () use ($maxAgeSeconds) {
            $lastFetch = $this->getLastFetchTime();

            if ($lastFetch && now()->diffInSeconds($lastFetch) <= $maxAgeSeconds) {
                return false;
            }

            $this->fetchAndCache();
            Cache::put('market_last_fetch_at', now()->toISOString(), 3600);

            return true;
        }) ?: false;
    }

    protected function getLastFetchTime(): ?Carbon
    {
        $lastFetchRaw = Cache::get('market_last_fetch_at');

        if (!$lastFetchRaw) {
            return null;
        }

        try {
            return Carbon::parse($lastFetchRaw);
        } catch (\Exception $e) {
            Cache::forget('market_last_fetch_at');
            return null;
        }
    }

    /**
     * دریافت و ذخیره‌سازی قیمت‌ها از منابع فعال
     */
    public function fetchAndCache(): void
    {
        $sources = ApiSourceConfig::where('is_active', true)->get();

        if ($sources->isEmpty()) {
            $this->markAllStale();
            return;
        }

        // ثبت شروع عملیات در لاگ برای نمایش در پنل ادمین
        AuditLog::create([
            'id' => (string) Str::uuid(),
            'actor' => 'system',
            'action' => 'schedule_work_run',
            'entity_type' => 'scheduler',
            'entity_id' => 'market_fetcher',
            'payload' => ['message' => 'شروع عملیات دریافت خودکار قیمت‌ها (Schedule)'],
            'created_at' => now(),
        ]);

        foreach ($sources as $source) {
            $this->fetchFromSource($source);
        }
    }

    /**
     * دریافت از یک منبع مشخص
     */
    protected function fetchFromSource(ApiSourceConfig $source): void
    {
        $started = now();
        $fallback = $source->fallback_urls;

        // تبدیل fallback_urls به آرایه (اگر رشته‌ی JSON باشد)
        if (is_string($fallback)) {
            $fallback = json_decode($fallback, true);
        }
        if (!is_array($fallback)) {
            $fallback = [];
        }

        $urls = array_values(array_filter(array_merge([$source->base_url], $fallback)));

        foreach ($urls as $url) {
            $urlStarted = now();
            // record attempt
            AuditLog::create([
                'id' => (string) Str::uuid(),
                'actor' => 'system',
                'action' => 'api_request_attempt',
                'entity_type' => 'api_source',
                'entity_id' => $source->id,
                'payload' => [
                    'key' => $source->key,
                    'url' => $url,
                    'started_at' => $urlStarted->toISOString(),
                ],
                'created_at' => now(),
            ]);

            try {
                $response = Http::withOptions(['verify' => false])
                    ->connectTimeout(10)
                    ->timeout($this->timeout)
                    ->retry(2, 1000)
                    ->withHeaders($source->auth_token ? ['Authorization' => "Bearer {$source->auth_token}"] : [])
                    ->get($url);

                if ($response->successful()) {
                    $payload = $response->json();
                    if (empty($payload)) {
                        throw new \Exception('Empty payload');
                    }
                    $this->updateCacheFromPayload($payload);

                    $lat = now()->diffInMilliseconds($urlStarted);

                    // record success
                    AuditLog::create([
                        'id' => (string) Str::uuid(),
                        'actor' => 'system',
                        'action' => 'api_request_success',
                        'entity_type' => 'api_source',
                        'entity_id' => $source->id,
                        'payload' => [
                            'key' => $source->key,
                            'url' => $url,
                            'status' => $response->status(),
                            'latency_ms' => $lat,
                            'body_preview' => Str::limit($response->body(), 1000),
                        ],
                        'created_at' => now(),
                    ]);

                    $source->update([
                        'last_status'     => 'ok',
                        'last_latency_ms' => $lat,
                        'last_checked_at' => now(),
                        'last_error'      => null,
                    ]);
                    return;
                }

                \Illuminate\Support\Facades\Log::warning('Market API returned non-success status', [
                    'source' => $source->key,
                    'url' => $url,
                    'status' => $response->status(),
                    'body' => Str::limit($response->body(), 200),
                ]);

                // record non-success
                AuditLog::create([
                    'id' => (string) Str::uuid(),
                    'actor' => 'system',
                    'action' => 'api_request_non_success',
                    'entity_type' => 'api_source',
                    'entity_id' => $source->id,
                    'payload' => [
                        'key' => $source->key,
                        'url' => $url,
                        'status' => $response->status(),
                        'body_preview' => Str::limit($response->body(), 1000),
                    ],
                    'created_at' => now(),
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Market API fetch failed', [
                    'source' => $source->key,
                    'url' => $url,
                    'error' => $e->getMessage(),
                ]);

                // record failure
                AuditLog::create([
                    'id' => (string) Str::uuid(),
                    'actor' => 'system',
                    'action' => 'api_request_failed',
                    'entity_type' => 'api_source',
                    'entity_id' => $source->id,
                    'payload' => [
                        'key' => $source->key,
                        'url' => $url,
                        'error' => $e->getMessage(),
                        'latency_ms' => now()->diffInMilliseconds($urlStarted),
                    ],
                    'created_at' => now(),
                ]);
            }
        }

        // همهٔ URLها ناموفق
        $source->update([
            'last_status'     => 'error',
            'last_latency_ms' => now()->diffInMilliseconds($started),
            'last_checked_at' => now(),
            'last_error'      => 'All URLs failed',
        ]);
        $this->markAllStale();
    }

    /**
     * استخراج قیمت‌ها از ساختار API و ذخیره در market_cache
     */
    protected function updateCacheFromPayload(array $payload): void
    {
        $allItems = array_merge(
            $payload['gold'] ?? [],
            $payload['currency'] ?? [],
            $payload['cryptocurrency'] ?? []
        );

        // استخراج زمان از اولین آیتم موجود در پکیج جی‌سان
        $apiTime = null;
        if (!empty($allItems)) {
            $firstItem = $allItems[0];
            if (isset($firstItem['time'])) {
                $apiTime = $firstItem['time'];
                Cache::put('market_api_last_time', $apiTime, 3600);
            }
        }

        $map = [
            'IR_GOLD_18K' => 'gold18', 'IR_GOLD_24K' => 'gold24', 'IR_GOLD_MELTED' => 'mesghal17',
            'XAUUSD' => 'ounce', 'IR_COIN_1G' => 'coin_gerami', 'IR_COIN_QUARTER' => 'coin_rob',
            'IR_COIN_HALF' => 'coin_nim', 'IR_COIN_EMAMI' => 'coin_emami', 'IR_COIN_BAHAR' => 'coin_bahar',
            'USDT_IRT' => 'usdt', 'USD' => 'usd', 'EUR' => 'euro', 'AED' => 'dirham',
            'BTC' => 'bitcoin',
        ];

        foreach ($allItems as $item) {
            $symbol = $item['symbol'] ?? null;
            if (!$symbol || !isset($map[$symbol])) continue;

            $key = $map[$symbol];
            $value = str_replace(',', '', $item['price'] ?? 0);

            if (is_numeric($value) && $value > 0) {
                $this->setCache($key, $value, $item['unit'] ?? 'تومان', $item['change_value'] ?? null, $item['change_percent'] ?? null);
            }
        }
    }

    /**
     * ذخیره یک نماد در cache
     */
    protected function setCache(string $symbol, float $value, string $unit, $changeValue = null, $changePercent = null): void
    {
        $prev = MarketCache::find($symbol);
        $prevValue = $prev?->value;

        $changeVal = $changeValue !== null ? $changeValue : (($prevValue && $prevValue > 0) ? round($value - $prevValue, 2) : 0);
        $changePct = $changePercent !== null ? $changePercent : (($prevValue && $prevValue > 0) ? round(($value - $prevValue) / $prevValue * 100, 2) : 0);
        $direction = $changeVal > 0 ? 'up' : ($changeVal < 0 ? 'down' : ($prev->direction ?? 'flat'));

        MarketCache::updateOrCreate(
            ['symbol' => $symbol],
            [
                'value'          => $value,
                'unit'           => $unit,
                'change_value'   => $changeVal,
                'change_percent' => $changePct,
                'direction'      => $direction,
                'is_stale'       => false,
                'fetched_at'     => now(),
            ]
        );
    }

    /**
     * علامت‌گذاری همهٔ قیمت‌ها به‌عنوان قدیمی
     */
    protected function markAllStale(): void
    {
        MarketCache::where('is_stale', false)->update(['is_stale' => true, 'fetched_at' => now()]);
    }

    /**
     * تولید آرایهٔ کامل قیمت‌ها برای نمایشگر (همان getPriceFeed قبلی)
     */
    public function getPriceFeed(): array
    {
        $cache   = MarketCache::all()->keyBy('symbol');
        $formula = FormulaConfig::firstOrCreate(['id' => 1], ['buy_multiplier_a' => 740, 'buy_divisor_b' => 750]);

        $ounce = $cache->get('ounce')?->value ?? 3360;
        $usd   = $cache->get('usd')?->value ?? 85800;

        $gold18       = $cache->get('gold18')?->value ?? round(($ounce * $usd * 0.75) / 31.1035);
        $gold24       = $cache->get('gold24')?->value ?? round(($gold18 * 24) / 18);
        $buyGold      = round(($gold18 * $formula->buy_multiplier_a) / $formula->buy_divisor_b);
        $exchangeGold = round(($gold18 * 745) / 750);
        $dirham       = $cache->get('dirham')?->value ?? round($usd / 3.67);
        $gold18ChangeValue = $cache->get('gold18')?->change_value ?? 0;
        $gold18ChangePercent = $cache->get('gold18')?->change_percent ?? 0;
        $gold18Stale = $cache->get('gold18')?->is_stale ?? true;
        $gold18FetchedAt = $cache->get('gold18')?->fetched_at;

        $symbols = [
            'gold18'        => ['label' => 'طلای ۱۸ عیار',         'value' => $gold18],
            'buy_gold'      => ['label' => 'گرم خرید ۱۸ عیار',    'value' => $buyGold, 'change_value' => $gold18ChangeValue, 'change_percent' => $gold18ChangePercent, 'base' => 'gold18'],
            'gold24'        => ['label' => 'طلای ۲۴ عیار',         'value' => $gold24, 'base' => 'gold18'],
            'mesghal17'     => ['label' => 'مثقال ۱۷',            'value' => $cache->get('mesghal17')?->value ?? 28000000],
            'ounce'         => ['label' => 'انس جهانی',            'value' => $ounce],
            'usd'           => ['label' => 'دلار',                'value' => $usd],
            'euro'          => ['label' => 'یورو',                'value' => $cache->get('euro')?->value ?? 92000],
            'dirham'        => ['label' => 'درهم',                'value' => $dirham],
            'bitcoin'       => ['label' => 'بیت کوین',            'value' => $cache->get('bitcoin')?->value ?? 0],
            'coin_emami'    => ['label' => 'سکه امامی',           'value' => $cache->get('coin_emami')?->value ?? 0],
            'coin_bahar'    => ['label' => 'سکه بهار آزادی',      'value' => $cache->get('coin_bahar')?->value ?? 0],
            'coin_nim'      => ['label' => 'نیم سکه',             'value' => $cache->get('coin_nim')?->value ?? 0],
            'coin_rob'      => ['label' => 'ربع سکه',             'value' => $cache->get('coin_rob')?->value ?? 0],
            'coin_gerami'   => ['label' => 'سکه گرمی',            'value' => $cache->get('coin_gerami')?->value ?? 0],
            'usdt'          => ['label' => 'تتر',                 'value' => $cache->get('usdt')?->value ?? 0],
        ];

        $now = now();
        $feed = [];
        foreach ($symbols as $sym => $meta) {
            $c = $cache->get($sym);

            // اگر آیتم محاسباتی باشد، اطلاعات زمانی را از پایه می‌گیرد
            $fetchedAt = $c ? $c->fetched_at : (isset($meta['base']) ? $gold18FetchedAt : null);

            $isStale = false;
            if ($c) {
                // اگر بیشتر از 10 دقیقه از فچ گذشته باشد (منعطف برای هاست اشتراکی)
                if ($fetchedAt && $now->diffInSeconds($fetchedAt) > 600) {
                    $isStale = true;
                } elseif ($c->is_stale) {
                    $isStale = true;
                }
            } else {
                // برای آیتم‌های محاسباتی مثل buy_gold
                if (isset($meta['base'])) {
                    $isStale = $gold18Stale || ($gold18FetchedAt && $now->diffInSeconds($gold18FetchedAt) > 600);
                } else {
                    $isStale = true;
                }
            }

            $feed[] = [
                'symbol'         => $sym,
                'label'          => $meta['label'],
                'value'          => $meta['value'],
                'unit'           => $c->unit ?? 'تومان',
                'change_value'   => $meta['change_value'] ?? ($c->change_value ?? 0),
                'change_percent' => $meta['change_percent'] ?? ($c->change_percent ?? 0),
                'direction'      => $c->direction ?? 'flat',
                'is_stale'       => $isStale,
                'fetched_at'     => $fetchedAt?->toISOString() ?? now()->toISOString(),
            ];
        }
        return $feed;
    }
}
