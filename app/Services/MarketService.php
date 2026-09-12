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
    public const MESGHAL_TO_GRAM_18K = 4.3318;
    protected int $timeout = 15;

    public function refreshIfStale(?int $maxAgeSeconds = null): bool
    {
        if ($maxAgeSeconds === null) {
            $hour = now('Asia/Tehran')->hour;
            $maxAgeSeconds = ($hour >= 9 && $hour < 22) ? 10 : 60;
        }

        return Cache::lock('market_fetch_lock', 30)->get(function () use ($maxAgeSeconds) {
            $lastFetch = $this->getLastFetchTime();
            if ($lastFetch) {
                $ageSeconds = max(0, now()->timestamp - $lastFetch->timestamp);
                if ($ageSeconds <= $maxAgeSeconds) {
                    return false;
                }
            }

            $this->fetchAndCache();
            Cache::put('market_last_fetch_at', now()->toISOString(), 3600);
            return true;
        }) ?: false;
    }

    protected function getLastFetchTime(): ?Carbon
    {
        $lastFetchRaw = Cache::get('market_last_fetch_at');
        if (!$lastFetchRaw) return null;
        try {
            return Carbon::parse($lastFetchRaw);
        } catch (\Exception $e) {
            Cache::forget('market_last_fetch_at');
            return null;
        }
    }

    public function fetchAndCache(): void
    {
        // ۱. واکشی منبع اصلی (کانال بله talaliveir)
        $balePrimaryConfig = ApiSourceConfig::where('key', 'bale_channel')->first();
        $primarySuccess = false;

        if (!$balePrimaryConfig || $balePrimaryConfig->is_active) {
            $primarySuccess = $this->fetchFromBalePrimary($balePrimaryConfig);
        }

        // ۲. در صورت بروز خطا در منبع اصلی، استفاده از فال‌بک اضطراری (کانال بله talanerkh)
        if (!$primarySuccess) {
            $baleBackupConfig = ApiSourceConfig::where('key', 'bale_backup')->first();
            if (!$baleBackupConfig || $baleBackupConfig->is_active) {
                $backupRates = $this->fetchFromBaleBackup($baleBackupConfig);
                if ($backupRates) {
                    $this->updateCacheFromBaleBackup($backupRates);
                }
            }
        }

        // ۳. واکشی تتر از زیپودو (Zipodo)
        $usdtConfig = ApiSourceConfig::where('key', 'usdt')->first();
        if (!$usdtConfig || $usdtConfig->is_active) {
            $this->fetchUsdt($usdtConfig);
        }
    }

    public function fetchFastMovingPrices(): void
    {
        // دریافت پرسرعت تتر از زیپودو
        $usdtConfig = ApiSourceConfig::where('key', 'usdt')->first();
        if (!$usdtConfig || $usdtConfig->is_active) {
            $this->fetchUsdt($usdtConfig);
        }
    }

    public function fetchFromGenericApi(ApiSourceConfig $source): void
    {
        if ($source->key === 'bale_channel') {
            $this->fetchFromBalePrimary($source);
        } elseif ($source->key === 'bale_backup') {
            $backupRates = $this->fetchFromBaleBackup($source);
            if ($backupRates) {
                $this->updateCacheFromBaleBackup($backupRates);
            }
        } elseif ($source->key === 'usdt') {
            $this->fetchUsdt($source);
        }
    }

    /**
     * واکشی و پارس منبع اصلی از کانال بله تالالایو (talaliveir)
     */
    public function fetchFromBalePrimary(?ApiSourceConfig $config = null): bool
    {
        $url = $config ? $config->base_url : 'https://ble.ir/s/talaliveir';
        if ($config && !$config->is_active) {
            return false;
        }

        try {
            $start = microtime(true);
            $response = Http::retry(3, 2000)->withOptions(['verify' => config('services.market.verify_ssl', true)])->timeout($this->timeout)->get($url);
            $latency = (int) round((microtime(true) - $start) * 1000);

            if (!$response->successful()) {
                if ($config) {
                    $errStr = 'Status: ' . $response->status();
                    $config->update([
                        'last_status' => 'error',
                        'last_checked_at' => now(),
                        'last_error' => $errStr,
                    ]);
                    $this->logFetchResult($config, 'error', "خطا: کد وضعیت " . $response->status());
                }
                return false;
            }

            $html = $response->body();
            $parsedRates = $this->parseBalePrimaryContent($html);

            if (empty($parsedRates)) {
                if ($config) {
                    $config->update([
                        'last_status' => 'error',
                        'last_checked_at' => now(),
                        'last_error' => 'الگوی پیام‌های بازار در محتوای کانال یافت نشد',
                    ]);
                    $this->logFetchResult($config, 'error', 'خطا: الگوی تابلوی نرخ در کانال یافت نشد');
                }
                return false;
            }

            // ذخیره مقادیر استخراج‌شده در کش و دیتابیس
            $this->saveParsedPrimaryRates($parsedRates);

            if ($config) {
                $config->update([
                    'last_status' => 'ok',
                    'last_latency_ms' => $latency,
                    'last_checked_at' => now(),
                    'last_error' => null,
                ]);
                $this->logFetchResult($config, 'ok', "دریافت موفق از کانال تالالایو در {$latency}ms");
            }

            return true;
        } catch (\Exception $e) {
            \Log::warning('Fetch from Bale Primary (talaliveir) failed: ' . $e->getMessage());
            if ($config) {
                $config->update([
                    'last_status' => 'error',
                    'last_checked_at' => now(),
                    'last_error' => $e->getMessage(),
                ]);
                $this->logFetchResult($config, 'error', 'خطا: ' . $e->getMessage());
            }
            return false;
        }
    }

    /**
     * پارس کردن محتوای کانال اصلی تالالایو بر اساس ساختار ربات
     */
    public function parseBalePrimaryContent(string $html): array
    {
        // پیدا کردن موقعیت آخرین پیام تابلوی نرخ
        $pos = mb_strrpos($html, 'تابلوی_نرخ');
        if ($pos === false) {
            $pos = mb_strrpos($html, 'talalive_ir');
        }
        if ($pos === false) {
            $pos = mb_strrpos($html, 'talaliveir');
        }

        if ($pos === false) {
            return [];
        }

        // استخراج بخش پیام و تبدیل کدهای یونیکد و تگ‌های HTML
        $subHtml = mb_substr($html, max(0, $pos - 200), 5000);
        $decoded = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($m) {
            return mb_chr(hexdec($m[1]), 'UTF-8');
        }, $subHtml);

        $text = strip_tags($decoded);
        $cleanText = $this->convertPersianDigitsToEnglish($text);
        // یکسان‌سازی علامت دونقطه فارسی و تمام‌پهنا
        $cleanText = str_replace(['：', '︓'], ':', $cleanText);

        // استفاده از [^\d\r\n:]{0,30} به جای \D* تا از خط جاری خارج نشود و نرخ خطوط دیگر را نخواند
        $mappings = [
            'mesghal17'    => '/(?:مظنه|آبشده|مثقال)(?:\s*(?:طلا|اتحادیه|۱۷|17))*\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'raw_gold18'   => '/(?:طلای\s*18\s*عیار|گرم\s*18)\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'raw_gold24'   => '/(?:طلای\s*24\s*عیار|گرم\s*24)\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'ounce'        => '/(?:انس|اونس)(?:\s*(?:جهانی|طلا))*\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'coin_emami'   => '/(?:سکه\s*)?امامی\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'coin_bahar'   => '/(?:سکه\s*)?(?:بهار\s*آزادی|طرح\s*قدیم|قدیم)\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'coin_nim'     => '/(?:سکه\s*)?نیم(?:\s*سکه)?\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'coin_rob'     => '/(?:سکه\s*)?ربع(?:\s*سکه)?\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'coin_gerami'  => '/(?:سکه\s*)?گرمی(?:\s*سکه)?\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'usd'          => '/دلار(?:\s*(?:نقدی|سبزه|هرات|تهران|آزاد))*\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'euro'         => '/یورو\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'dirham'       => '/درهم\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
            'bitcoin'      => '/بیت\s*[\x{200c}\x{200d}]?کوین\s*:[^\d\r\n:]{0,30}([\d,\.]+)/iu',
        ];

        $rates = [];
        foreach ($mappings as $key => $pattern) {
            if (preg_match($pattern, $cleanText, $matches)) {
                $val = (float)str_replace(',', '', $matches[1]);

                // Circuit Breaker & بررسی سلامت دامنه قیمت:
                // نرخ طلای ۱۸ و ۲۴ عیار نمی‌تواند زیر ۱ میلیون تومان باشد (مثلاً نشت قیمت ارز)
                if (in_array($key, ['raw_gold18', 'raw_gold24']) && $val < 1000000) {
                    \Log::warning("MarketService: Extracted abnormal low value for {$key}: {$val}");
                    continue;
                }
                // نرخ مثقال نمی‌تواند زیر ۴ میلیون تومان باشد
                if ($key === 'mesghal17' && $val < 4000000) {
                    \Log::warning("MarketService: Extracted abnormal low value for mesghal17: {$val}");
                    continue;
                }
                // نرخ سکه تمام و قطعات نمی‌تواند زیر ۱.۵ میلیون تومان باشد
                if (str_starts_with($key, 'coin_') && $val < 1500000) {
                    \Log::warning("MarketService: Extracted abnormal low value for {$key}: {$val}");
                    continue;
                }

                if ($val > 0) {
                    $rates[$key] = $val;
                }
            }
        }

        // بررسی اینکه آیا حداقل یکی از نرخ‌های پایه طلا (مثقال یا طلای ۱۸) استخراج شده است یا خیر
        if (!isset($rates['mesghal17']) && !isset($rates['raw_gold18'])) {
            \Log::warning('MarketService: Bale primary content parsed without core gold rates (mesghal/gold18).');
            return [];
        }

        // استخراج تاریخ یا ساعت آخرین بروزرسانی در صورت وجود
        if (preg_match('/آخرین\s*بروزرسانی\s*:\s*([0-9:]+)/iu', $cleanText, $timeMatches)) {
            $rates['update_time'] = trim($timeMatches[1]);
            Cache::put('market_api_last_time', $rates['update_time'], 3600);
        }

        return $rates;
    }

    /**
     * ذخیره داده‌های پارس شده منبع اصلی با محاسبه خودکار طلای ۱۸ و ۲۴ عیار از آبشده
     */
    protected function saveParsedPrimaryRates(array $rates): void
    {
        $apiDate = now()->format('Y-m-d');

        // ۱. محاسبه خودکار طلای ۱۸ و ۲۴ عیار از روی آبشده (mesghal17) طبق ضریب استاندارد اتحادیه ۷۰۵
        if (isset($rates['mesghal17']) && $rates['mesghal17'] > 0) {
            $mesghalVal = $rates['mesghal17'];
            $gold18Val = round($mesghalVal / self::MESGHAL_TO_GRAM_18K);
            $gold24Val = round($gold18Val / 0.75);

            $this->savePriceItem('mesghal17', $mesghalVal, 'تومان', $apiDate);
            $this->savePriceItem('gold18', $gold18Val, 'تومان', $apiDate);
            $this->savePriceItem('gold24', $gold24Val, 'تومان', $apiDate);
        } elseif (isset($rates['raw_gold18']) && $rates['raw_gold18'] > 0) {
            // در صورتی که به هر دلیل عنوان آبشده در پیام نباشد ولی طلای ۱۸ باشد
            $gold18Val = $rates['raw_gold18'];
            $mesghalVal = round($gold18Val * self::MESGHAL_TO_GRAM_18K);
            $gold24Val = round($gold18Val / 0.75);

            $this->savePriceItem('mesghal17', $mesghalVal, 'تومان', $apiDate);
            $this->savePriceItem('gold18', $gold18Val, 'تومان', $apiDate);
            $this->savePriceItem('gold24', $gold24Val, 'تومان', $apiDate);
        }

        // ۲. ذخیره انس جهانی طلا (دلار)
        if (isset($rates['ounce']) && $rates['ounce'] > 0) {
            $this->savePriceItem('ounce', round($rates['ounce'], 2), 'دلار', $apiDate);
        }

        // ۳. ذخیره بیت‌کوین (دلار)
        if (isset($rates['bitcoin']) && $rates['bitcoin'] > 0) {
            $this->savePriceItem('bitcoin', round($rates['bitcoin'], 2), 'دلار', $apiDate);
        }

        // ۴. ذخیره انواع مسکوکات
        $coinSymbols = ['coin_emami', 'coin_bahar', 'coin_nim', 'coin_rob', 'coin_gerami'];
        foreach ($coinSymbols as $sym) {
            if (isset($rates[$sym]) && $rates[$sym] > 0) {
                $this->savePriceItem($sym, $rates[$sym], 'تومان', $apiDate);
            }
        }

        // ۵. ذخیره ارزها (دلار نقدی، یورو، درهم)
        $currencySymbols = ['usd', 'euro', 'dirham'];
        foreach ($currencySymbols as $sym) {
            if (isset($rates[$sym]) && $rates[$sym] > 0) {
                $this->savePriceItem($sym, $rates[$sym], 'تومان', $apiDate);
            }
        }
    }

    /**
     * واکشی منبع پشتیبان اضطراری (کانال بله talanerkh)
     */
    public function fetchFromBaleBackup(?ApiSourceConfig $config = null): ?array
    {
        try {
            $baleConfig = $config ?? ApiSourceConfig::where('key', 'bale_backup')->first();
            if ($baleConfig && !$baleConfig->is_active) {
                return null;
            }
            $url = $baleConfig ? $baleConfig->base_url : 'https://ble.ir/s/talanerkh';

            $start = microtime(true);
            $response = Http::retry(3, 2000)->withOptions(['verify' => false])->timeout($this->timeout)->get($url);
            $latency = (int) round((microtime(true) - $start) * 1000);

            if (!$response->successful()) {
                if ($baleConfig) {
                    $baleConfig->update([
                        'last_status' => 'error',
                        'last_checked_at' => now(),
                        'last_error' => 'Status: ' . $response->status()
                    ]);
                    $this->logFetchResult($baleConfig, 'error', "خطا: کد وضعیت " . $response->status());
                }
                return null;
            }

            if ($baleConfig) {
                $baleConfig->update([
                    'last_status' => 'ok',
                    'last_latency_ms' => $latency,
                    'last_checked_at' => now(),
                    'last_error' => null
                ]);
                $this->logFetchResult($baleConfig, 'ok', "دریافت موفق قیمت از فال‌بک در {$latency}ms");
            }

            $html = $response->body();
            $pos = mb_strrpos($html, 'اعلام نرخ رسمی طلا');
            if ($pos === false) {
                if ($baleConfig) {
                    $this->logFetchResult($baleConfig, 'error', "خطا: الگوی اعلام نرخ در متن کانال فال‌بک یافت نشد");
                }
                return null;
            }

            $subHtml = mb_substr($html, $pos, 5000);
            $text = strip_tags($subHtml);
            $cleanText = $this->convertPersianDigitsToEnglish($text);

            $mappings = [
                'gold18'       => '/هر گرم 18 عیار:\D*([\d,\.]+)\s*تومان/iu',
                'ounce'        => '/انس جهانی طلا:\D*([\d,\.]+)\s*دلار/iu',
                'coin_emami'   => '/سکه طرح جدید:\D*([\d,\.]+)\s*تومان/iu',
                'coin_bahar'   => '/سکه طرح قدیم:\D*([\d,\.]+)\s*تومان/iu',
                'coin_nim'     => '/سکه نیم:\D*([\d,\.]+)\s*تومان/iu',
                'coin_rob'     => '/سکه ربع:\D*([\d,\.]+)\s*تومان/iu',
                'coin_gerami'  => '/سکه یک گرمی:\D*([\d,\.]+)\s*تومان/iu',
                'usd'          => '/دلار:\D*([\d,\.]+)\s*تومان/iu',
                'euro'         => '/یورو:\D*([\d,\.]+)\s*تومان/iu',
                'dirham'       => '/درهم:\D*([\d,\.]+)\s*تومان/iu',
            ];

            $rates = [];
            foreach ($mappings as $key => $pattern) {
                if (preg_match($pattern, $cleanText, $matches)) {
                    $val = (float)str_replace(',', '', $matches[1]);
                    if ($val > 0) {
                        $rates[$key] = $val;
                    }
                }
            }

            if (empty($rates) && $baleConfig) {
                $this->logFetchResult($baleConfig, 'error', "خطا: قیمت‌های مورد نظر در پیام فال‌بک یافت نشدند");
            }

            return empty($rates) ? null : $rates;
        } catch (\Exception $e) {
            \Log::error('Bale fallback fetch failed: ' . $e->getMessage());
            $baleConfig = $config ?? ApiSourceConfig::where('key', 'bale_backup')->first();
            if ($baleConfig) {
                $baleConfig->update([
                    'last_status' => 'error',
                    'last_checked_at' => now(),
                    'last_error' => $e->getMessage()
                ]);
                $this->logFetchResult($baleConfig, 'error', "خطا: " . $e->getMessage());
            }
            return null;
        }
    }

    /**
     * ذخیره مقادیر دریافتی از فال‌بک اضطراری
     */
    protected function updateCacheFromBaleBackup(array $rates): void
    {
        $apiDate = now()->format('Y-m-d');

        $units = [
            'gold18'       => 'تومان',
            'gold24'       => 'تومان',
            'mesghal17'    => 'تومان',
            'ounce'        => 'دلار',
            'coin_emami'   => 'تومان',
            'coin_bahar'   => 'تومان',
            'coin_nim'     => 'تومان',
            'coin_rob'     => 'تومان',
            'coin_gerami'  => 'تومان',
            'usd'          => 'تومان',
            'euro'         => 'تومان',
            'dirham'       => 'تومان',
            'usdt'         => 'تومان',
        ];

        // ۱. طلای ۲۴ عیار محاسباتی
        if (isset($rates['gold18']) && !isset($rates['gold24'])) {
            $rates['gold24'] = round($rates['gold18'] / 0.75);
        }

        // ۲. تتر محاسباتی از دلار در صورت نبود منبع زیپودو
        if (isset($rates['usd']) && !isset($rates['usdt'])) {
            $rates['usdt'] = $rates['usd'];
        }

        // ۳. مثقال ۱۷ محاسباتی از روی طلای ۱۸ عیار طبق ضریب اتحادیه ۷۰۵
        if (isset($rates['gold18']) && !isset($rates['mesghal17'])) {
            $rates['mesghal17'] = round($rates['gold18'] * self::MESGHAL_TO_GRAM_18K);
        }

        foreach ($rates as $symbol => $val) {
            if ($val > 0) {
                $unit = $units[$symbol] ?? 'تومان';
                $this->savePriceItem($symbol, $val, $unit, $apiDate);
            }
        }
    }

    /**
     * دریافت نرخ تتر از سرویس زیپودو (Zipodo)
     */
    public function fetchUsdt(?ApiSourceConfig $config = null): bool
    {
        $usdtConfig = $config ?? ApiSourceConfig::where('key', 'usdt')->first();
        if ($usdtConfig && !$usdtConfig->is_active) {
            return false;
        }

        $url = $usdtConfig ? $usdtConfig->base_url : 'https://api.zipodo.ir/usdt/';

        try {
            $start = microtime(true);
            $response = Http::retry(2, 1000)->withOptions(['verify' => false])->timeout(4)->get($url);
            $latency = (int) round((microtime(true) - $start) * 1000);

            if ($response->successful() && !empty($payload = $response->json())) {
                if (isset($payload['price'])) {
                    $val = (float)$payload['price'];
                    if ($val > 0) {
                        $this->savePriceItem('usdt', $val, 'تومان', now()->format('Y-m-d'));

                        if ($usdtConfig) {
                            $usdtConfig->update([
                                'last_status' => 'ok',
                                'last_latency_ms' => $latency,
                                'last_checked_at' => now(),
                                'last_error' => null
                            ]);
                            $this->logFetchResult($usdtConfig, 'ok', "دریافت موفق تتر در {$latency}ms");
                        }
                        return true;
                    }
                }
            }

            // فال‌بک نوبیتکس در صورت بروز خطا در منبع اصلی
            try {
                $nobiRes = Http::withOptions(['verify' => false])->timeout(4)->get('https://api.nobitex.ir/v2/orderbook/USDTIRT');
                if ($nobiRes->successful() && !empty($nobiData = $nobiRes->json())) {
                    $nobiPrice = (float)($nobiData['lastTradePrice'] ?? 0);
                    if ($nobiPrice > 0) {
                        $valToman = round($nobiPrice / 10);
                        $this->savePriceItem('usdt', $valToman, 'تومان', now()->format('Y-m-d'));
                        if ($usdtConfig) {
                            $usdtConfig->update([
                                'last_status' => 'ok',
                                'last_latency_ms' => $latency,
                                'last_checked_at' => now(),
                                'last_error' => null
                            ]);
                            $this->logFetchResult($usdtConfig, 'ok', "دریافت موفق تتر از نوبیتکس ({$valToman} تومان)");
                        }
                        return true;
                    }
                }
            } catch (\Throwable $nobiEx) {}

            if ($usdtConfig) {
                $errStr = 'Status: ' . $response->status();
                $usdtConfig->update([
                    'last_status' => 'error',
                    'last_checked_at' => now(),
                    'last_error' => $errStr
                ]);
                $this->logFetchResult($usdtConfig, 'error', "خطا در دریافت تتر");
            }
            return false;
        } catch (\Exception $e) {
            // در صورت بروز Exception نیز فال‌بک نوبیتکس را فراخوانی می‌کنیم
            try {
                $nobiRes = Http::withOptions(['verify' => false])->timeout(4)->get('https://api.nobitex.ir/v2/orderbook/USDTIRT');
                if ($nobiRes->successful() && !empty($nobiData = $nobiRes->json())) {
                    $nobiPrice = (float)($nobiData['lastTradePrice'] ?? 0);
                    if ($nobiPrice > 0) {
                        $valToman = round($nobiPrice / 10);
                        $this->savePriceItem('usdt', $valToman, 'تومان', now()->format('Y-m-d'));
                        if ($usdtConfig) {
                            $usdtConfig->update([
                                'last_status' => 'ok',
                                'last_latency_ms' => 150,
                                'last_checked_at' => now(),
                                'last_error' => null
                            ]);
                            $this->logFetchResult($usdtConfig, 'ok', "دریافت تتر از نوبیتکس: {$valToman} تومان");
                        }
                        return true;
                    }
                }
            } catch (\Throwable $nobiEx) {}

            \Log::warning('USDT fetch failed: ' . $e->getMessage());
            if ($usdtConfig) {
                $usdtConfig->update([
                    'last_status' => 'error',
                    'last_checked_at' => now(),
                    'last_error' => $e->getMessage()
                ]);
                $this->logFetchResult($usdtConfig, 'error', "خطا: " . $e->getMessage());
            }
            return false;
        }
    }

    /**
     * متد ذخیره و بروزرسانی قیمت و محاسبه درصد و جهت نوسان
     */
    public function savePriceItem(string $symbol, float $val, string $unit, string $apiDate = ''): void
    {
        if ($val <= 0) return;

        if ($symbol === 'ounce') {
            $integerPart = (int)$val;
            if ($integerPart >= 100000 && $integerPart <= 999999) {
                $val = $val / 100;
            }
        }

        if (!empty($apiDate)) {
            $lastApiDate = Cache::get('last_api_date_' . $symbol);
            if ($lastApiDate && $lastApiDate !== $apiDate) {
                $currentRecord = MarketCache::where('symbol', $symbol)->first();
                if ($currentRecord && $currentRecord->value > 0) {
                    Cache::forever('yesterday_price_' . $symbol, (float)$currentRecord->value);
                }
            }
            Cache::put('last_api_date_' . $symbol, $apiDate, now()->addDays(2));
        }

        $yesterdayPrice = Cache::get('yesterday_price_' . $symbol);
        if ($yesterdayPrice === null || $yesterdayPrice <= 0) {
            Cache::forever('yesterday_price_' . $symbol, $val);
            $yesterdayPrice = $val;
        }

        $changeValue = $val - $yesterdayPrice;
        $changePercent = $yesterdayPrice > 0 ? ($changeValue / $yesterdayPrice * 100) : 0;

        $direction = 'flat';
        if ($changeValue > 0.01) {
            $direction = 'up';
        } elseif ($changeValue < -0.01) {
            $direction = 'down';
        }

        $this->setCache($symbol, $val, $unit, $changeValue, $changePercent, $direction);
    }

    /**
     * سازگاری با متدهای قدیمی تست
     */
    public function saveNerkhioItem(string $symbol, float $val, string $unit, string $apiDate = ''): void
    {
        $this->savePriceItem($symbol, $val, $unit, $apiDate);
    }

    protected function convertPersianToEnglish($string): float
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $string = str_replace($persian, $english, $string);
        $string = str_replace(',', '', $string);
        $string = preg_replace('/[^0-9.\-]/', '', $string);
        return (float) $string;
    }

    public function convertPersianDigitsToEnglish($string): string
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٬'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ','];
        return str_replace($persian, $english, $string);
    }

    public function setCache(string $symbol, float $value, string $unit, ?float $changeValue = null, ?float $changePercent = null, ?string $direction = null): void
    {
        if ($symbol === 'ounce') {
            $integerPart = (int)$value;
            if ($integerPart >= 100000 && $integerPart <= 999999) {
                $value = $value / 100;
                if ($changeValue !== null) {
                    $changeValue = $changeValue / 100;
                }
            }
        }

        MarketCache::updateOrCreate(
            ['symbol' => $symbol],
            [
                'value'          => $value,
                'unit'           => $unit,
                'change_value'   => $changeValue ?? 0,
                'change_percent' => $changePercent ?? 0,
                'direction'      => $direction ?? 'flat',
                'is_stale'       => false,
                'fetched_at'     => now(),
            ]
        );
    }

    protected function markAllStale(): void
    {
        MarketCache::where('is_stale', false)->update(['is_stale' => true, 'fetched_at' => now()]);
    }

    public function currentRefreshIntervalSeconds(): int
    {
        $hour = now('Asia/Tehran')->hour;
        // در ساعات کاری هر ۱۰ ثانیه، خارج از آن هر ۱ دقیقه (۶۰ ثانیه)
        return ($hour >= 9 && $hour < 22) ? 10 : 60;
    }

    public function getPriceFeed(?\App\Models\User $user = null): array
    {
        if ($user === null) {
            $user = \App\Models\User::where('is_super_admin', true)->first() ?? \App\Models\User::first();
        }

        $cache = MarketCache::all()->keyBy('symbol');
        
        $formula = $user 
            ? FormulaConfig::firstOrCreate(['user_id' => $user->id], ['buy_multiplier_a' => 740, 'buy_divisor_b' => 750])
            : FormulaConfig::firstOrCreate(['id' => 1], ['buy_multiplier_a' => 740, 'buy_divisor_b' => 750]);

        $gold18 = $cache->get('gold18')?->value ?? 0;

        $symbols = [
            'gold18' => 'طلای ۱۸ عیار', 'mesghal17' => 'مثقال ۱۷', 'ounce' => 'انس جهانی',
            'buy_gold' => 'گرم خرید ۱۸', 'gold24' => 'طلای ۲۴ عیار', 'usd' => 'دلار',
            'coin_emami' => 'سکه امامی', 'coin_bahar' => 'سکه بهار آزادی', 'coin_nim' => 'نیم سکه',
            'coin_rob' => 'ربع سکه', 'coin_gerami' => 'سکه گرمی', 'euro' => 'یورو',
            'dirham' => 'درهم', 'usdt' => 'تتر', 'bitcoin' => 'بیت کوین',
        ];

        $feed = [];
        foreach ($symbols as $sym => $label) {
            $c = $cache->get($sym);

            if ($sym === 'buy_gold') {
                $val = round(($gold18 * $formula->buy_multiplier_a) / $formula->buy_divisor_b);
                $ref = $cache->get('gold18');
                $changeVal = $ref?->change_value ?? 0;
                $changePct = $ref?->change_percent ?? 0;
                $dir = $ref?->direction ?? 'flat';

                $isStale = true;
                if ($ref && $ref->fetched_at) {
                    $ageSeconds = max(0, now()->timestamp - $ref->fetched_at->timestamp);
                    $isStale = $ageSeconds > ($this->currentRefreshIntervalSeconds() * 3);
                }
            } else {
                $val = $c?->value ?? 0;
                $changeVal = $c?->change_value ?? 0;
                $changePct = $c?->change_percent ?? 0;
                $dir = $c?->direction ?? 'flat';

                $isStale = true;
                if ($c && $c->fetched_at) {
                    $ageSeconds = max(0, now()->timestamp - $c->fetched_at->timestamp);
                    $isStale = $ageSeconds > ($this->currentRefreshIntervalSeconds() * 3);
                }
            }

            $feed[] = [
                'symbol' => $sym, 'label' => $label, 'value' => $val,
                'unit' => ($sym === 'ounce' || $sym === 'bitcoin') ? 'دلار' : ($c?->unit ?? 'تومان'),
                'change_value' => $changeVal, 'change_percent' => $changePct,
                'direction' => $dir, 'is_stale' => $isStale,
                'fetched_at' => $c?->fetched_at?->toISOString() ?? now()->toISOString(),
            ];
        }
        return $feed;
    }

    public function logFetchResult(ApiSourceConfig $config, string $status, string $message): void
    {
        $logs = $config->last_logs ?? [];
        if (!is_array($logs)) {
            $logs = [];
        }

        array_unshift($logs, [
            'time' => now('Asia/Tehran')->format('H:i:s'),
            'status' => $status,
            'message' => $message,
        ]);

        $logs = array_slice($logs, 0, 3);

        $config->update([
            'last_logs' => $logs
        ]);
    }
}
