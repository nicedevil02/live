<?php

namespace App\Http\Controllers;

use App\Models\MarketCache;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class PublicPageController extends Controller
{
    /**
     * صفحه فرود اختصاصی تابلوی هوشمند طلافروشی
     */
    public function smartGoldBoard()
    {
        return view('pages.smart-gold-board');
    }

    /**
     * راهنمای جامع اتصال تلویزیون به تابلوی طلا بدون کیس و کابل
     */
    public function tvSetupGuide()
    {
        return view('pages.tv-setup-guide');
    }

    /**
     * ماشین‌حساب آنلاین طلا، اجرت، سود و حباب انواع سکه با نرخ زنده
     */
    public function goldCalculator()
    {
        try {
            $rawRates = MarketCache::all()->keyBy('symbol');
            $lastFetch = MarketCache::max('fetched_at');
            $apiTime = Cache::get('market_api_last_time', '---');
        } catch (\Throwable $e) {
            $rawRates = collect();
            $lastFetch = null;
            $apiTime = '---';
        }

        // استخراج نرخ‌های اصلی با فال‌بک مطمئن
        $gold18 = (float)($rawRates->get('raw_gold18')->value ?? 0);
        $gold24 = (float)($rawRates->get('gold24')->value ?? 0);
        $mesghal = (float)($rawRates->get('mesghal17')->value ?? 0);
        $ons = (float)($rawRates->get('ons_gold')->value ?? 0);
        $dollar = (float)($rawRates->get('usd_sell')->value ?? 0);

        // مسکوکات
        $coinEmami = (float)($rawRates->get('coin_emami')->value ?? 0);
        $coinBahar = (float)($rawRates->get('coin_bahar')->value ?? 0);
        $coinHalf = (float)($rawRates->get('coin_half')->value ?? 0);
        $coinQuarter = (float)($rawRates->get('coin_quarter')->value ?? 0);
        $coinGerami = (float)($rawRates->get('coin_gerami')->value ?? 0);

        // در صورتی که دیتابیس لوکال خالی باشد، مقادیر معقول پایه جهت عدم خطا در ماشین‌حساب
        if ($gold18 <= 0) {
            $gold18 = 4500000;
        }

        return view('pages.gold-calculator', [
            'rates' => [
                'gold18'       => $gold18,
                'gold24'       => $gold24 > 0 ? $gold24 : round($gold18 * (24 / 18)),
                'mesghal'      => $mesghal > 0 ? $mesghal : round($gold18 * 4.3318),
                'ons'          => $ons,
                'dollar'       => $dollar,
                'coin_emami'   => $coinEmami > 0 ? $coinEmami : 52000000,
                'coin_bahar'   => $coinBahar > 0 ? $coinBahar : 47000000,
                'coin_half'    => $coinHalf > 0 ? $coinHalf : 27500000,
                'coin_quarter' => $coinQuarter > 0 ? $coinQuarter : 17500000,
                'coin_gerami'  => $coinGerami > 0 ? $coinGerami : 8500000,
            ],
            'lastUpdated' => $lastFetch ? Carbon::parse($lastFetch)->diffForHumans() : 'لحظه‌ای',
            'apiTime'     => $apiTime,
        ]);
    }

    /**
     * هاب مقالات، پایگاه دانش و راهنماهای صنف طلا و جواهر
     */
    public function guidesIndex()
    {
        return view('pages.guides-index');
    }
}
