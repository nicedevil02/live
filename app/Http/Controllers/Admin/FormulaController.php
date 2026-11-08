<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormulaConfig;
use Illuminate\Http\Request;

class FormulaController extends Controller
{
    /**
     * نمایش صفحه فرمول‌ها
     */
    public function index()
    {
        // فقط یک رکورد در جدول داریم
        $formula = FormulaConfig::firstOrCreate(
            ['user_id' => auth()->id()],
            ['buy_multiplier_a' => 740, 'buy_divisor_b' => 750]
        );

        // اگر درخواست JSON بود (برای بارگزاری اولیه Alpine)
        if (request()->expectsJson()) {
            return response()->json([
                'buy_multiplier_a' => $formula->buy_multiplier_a,
                'buy_divisor_b'    => $formula->buy_divisor_b,
            ]);
        }

        return view('admin.formulas.index', compact('formula'));
    }

    /**
     * به‌روزرسانی ضرایب خرید
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'buy_multiplier_a' => 'required|numeric|gt:0',
            'buy_divisor_b'    => 'required|numeric|gt:0',
        ]);

        $formula = FormulaConfig::where('user_id', auth()->id())->firstOrFail();
        $formula->update($validated);

        return response()->json($formula);
    }

    /**
     * پیش‌نمایش جهانی ۱۸ عیار (برای بخش Preview)
     * محاسبات دقیقاً مطابق server.js
     */
    public function global18kPreview()
    {
        $service = resolve(\App\Services\MarketService::class);
        $feed = collect($service->getPriceFeed(auth()->user()))->keyBy('symbol');

        $ouncePrice     = $feed->get('ounce')['value'] ?? 0;
        $usdtDollarRate = \App\Models\MarketCache::where('symbol', 'usdt_dollar')->value('value')
            ?? $feed->get('usdt')['value']
            ?? 0;
        $gold18Tablo    = $feed->get('gold18')['value'] ?? 0;

        // فرمول واقعی بر مبنای اونس جهانی و تتر (دلار دیجیتال): (اونس × تتر × 0.75) ÷ 31.1035
        $gold18Real = ($ouncePrice > 0 && $usdtDollarRate > 0)
            ? round(($ouncePrice * $usdtDollarRate * 0.75) / 31.1035)
            : 0;

        $formula = FormulaConfig::where('user_id', auth()->id())->first();
        $buyGold = ($gold18Tablo * $formula->buy_multiplier_a) / $formula->buy_divisor_b;

        return response()->json([
            'ouncePrice'    => $ouncePrice,
            'usdtRate'      => $usdtDollarRate,
            'usdRate'       => $usdtDollarRate,
            'gold18Tablo'   => $gold18Tablo,
            'gold18Real'    => $gold18Real,
            'buyGold'       => round($buyGold),
            'formula'       => '(ouncePrice * usdtRate * 0.75) / 31.1035',
        ]);
    }
}
