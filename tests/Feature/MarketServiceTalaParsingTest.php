<?php

namespace Tests\Feature;

use App\Services\MarketService;
use App\Models\MarketCache;
use App\Models\ApiSourceConfig;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketServiceTalaParsingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::clear();
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_save_price_item_divides_six_digit_ounce_by_100(): void
    {
        $service = app(MarketService::class);
        $service->savePriceItem('ounce', 265050.0, 'دلار', '2026-06-08');

        $record = MarketCache::where('symbol', 'ounce')->first();
        $this->assertNotNull($record);
        $this->assertEquals(2650.50, $record->value);
    }

    public function test_save_price_item_does_not_divide_four_digit_ounce(): void
    {
        $service = app(MarketService::class);
        $service->savePriceItem('ounce', 2650.5, 'دلار', '2026-06-08');

        $record = MarketCache::where('symbol', 'ounce')->first();
        $this->assertNotNull($record);
        $this->assertEquals(2650.5, $record->value);
    }

    public function test_set_cache_divides_six_digit_ounce_by_100(): void
    {
        $service = app(MarketService::class);
        $service->setCache('ounce', 265000.0, 'دلار', 5000.0);

        $record = MarketCache::where('symbol', 'ounce')->first();
        $this->assertNotNull($record);
        $this->assertEquals(2650.0, $record->value);
        $this->assertEquals(50.0, $record->change_value);
    }

    public function test_parse_bale_primary_content_with_all_items(): void
    {
        $sampleHtml = <<<HTML
        <div class="Text_text__Um9IF">
            <span class="p" dir="rtl">📊 #تابلوی_نرخ_لحظه‌ای_بازار</span><br />
            <span class="p" dir="rtl">✨ طلای ۱۸ عیار: 27,818,459</span><br />
            <span class="p" dir="rtl">🌟 طلای ۲۴ عیار: 37,091,279</span><br />
            <span class="p" dir="rtl">💰 آبشده اتحادیه: 120,505,000</span><br />
            <span class="p" dir="rtl">🟡 انس جهانی طلا: 4,603.90</span><br />
            <span class="p" dir="rtl">🌕 سکه امامی: 202,500</span><br />
            <span class="p" dir="rtl">🌕 سکه بهار آزادی: 198,990</span><br />
            <span class="p" dir="rtl">🌕 نیم سکه: 102,000</span><br />
            <span class="p" dir="rtl">🌕 ربع سکه: 56,000</span><br />
            <span class="p" dir="rtl">🌕 سکه گرمی: 29,000</span><br />
            <span class="p" dir="rtl">💵 دلار نقدی تهران: 95,000</span><br />
            <span class="p" dir="rtl">💸 بیت‌کوین: 77,739 دلار</span><br />
            <span class="p" dir="rtl">💶 یورو: 222,170</span><br />
            <span class="p" dir="rtl">🇦🇪 درهم: 51,710</span><br />
            <span class="p" dir="rtl">🕒 آخرین بروزرسانی: 01:03:12</span><br />
            <span class="p" dir="ltr">🆔 @talalive_ir</span>
        </div>
        HTML;

        $service = app(MarketService::class);
        $rates = $service->parseBalePrimaryContent($sampleHtml);

        $this->assertNotEmpty($rates);
        $this->assertEquals(120505000.0, $rates['mesghal17']);
        $this->assertEquals(4603.90, $rates['ounce']);
        $this->assertEquals(202500.0, $rates['coin_emami']);
        $this->assertEquals(198990.0, $rates['coin_bahar']);
        $this->assertEquals(102000.0, $rates['coin_nim']);
        $this->assertEquals(56000.0, $rates['coin_rob']);
        $this->assertEquals(29000.0, $rates['coin_gerami']);
        $this->assertEquals(95000.0, $rates['usd']);
        $this->assertEquals(77739.0, $rates['bitcoin']);
        $this->assertEquals(222170.0, $rates['euro']);
        $this->assertEquals(51710.0, $rates['dirham']);
    }

    public function test_parse_bale_primary_content_with_mazaneh_tala_format(): void
    {
        $sampleHtml = <<<HTML
        <div class="Text_text__Um9IF">
            <span class="p" dir="rtl">📊 <span class="hashtag">#تابلوی_نرخ_لحظه‌ای_بازار</span></span><br />
            <span class="p" dir="rtl">🔄 ✨ طلای ۱۸ عیار: 21,815,412</span>
            <span class="p" dir="rtl">🔄 🌟 طلای ۲۴ عیار: 29,087,216</span>
            <span class="p" dir="rtl">🔄 💰 مظنه طلا: 94,500,000</span>
            <span class="p" dir="rtl">🔄 🟡 انس جهانی طلا: 4,439.98</span><br />
            <span class="p" dir="rtl">🌕 سکه امامی: 219,360,000</span>
            <span class="p" dir="rtl">🌕 سکه بهار آزادی: 214,180,000</span>
            <span class="p" dir="rtl">🌕 نیم سکه: 112,460,000</span>
            <span class="p" dir="rtl">🌕 ربع سکه: 60,000,000</span>
            <span class="p" dir="rtl">🌕 سکه گرمی: 30,000,000</span><br />
            <span class="p" dir="rtl">🔄 💵 دلار نقدی تهران: 206,800</span>
            <span class="p" dir="rtl">💶 یورو: 239,710</span>
            <span class="p" dir="rtl">🇦🇪 درهم: 56,390</span>
            <span class="p" dir="rtl">💸 بیت‌کوین: 78,196 دلار</span><br />
            <span class="p" dir="rtl">🕒 آخرین بروزرسانی: 11:48:48</span>
            <span class="p" dir="ltr">🆔 @talalive_ir</span>
        </div>
        HTML;

        $service = app(MarketService::class);
        $rates = $service->parseBalePrimaryContent($sampleHtml);

        $this->assertNotEmpty($rates);
        $this->assertEquals(94500000.0, $rates['mesghal17']);
        $this->assertEquals(4439.98, $rates['ounce']);
        $this->assertEquals(219360000.0, $rates['coin_emami']);
        $this->assertEquals(214180000.0, $rates['coin_bahar']);
        $this->assertEquals(112460000.0, $rates['coin_nim']);
        $this->assertEquals(60000000.0, $rates['coin_rob']);
        $this->assertEquals(30000000.0, $rates['coin_gerami']);
        $this->assertEquals(206800.0, $rates['usd']);
        $this->assertEquals(239710.0, $rates['euro']);
        $this->assertEquals(56390.0, $rates['dirham']);
        $this->assertEquals(78196.0, $rates['bitcoin']);
        $this->assertEquals('11:48:48', $rates['update_time']);
    }

    public function test_primary_bale_fetch_calculates_18k_and_24k_gold_from_abshodeh(): void
    {
        $sampleHtml = <<<HTML
        <div class="Text_text__Um9IF">
            <span class="p" dir="rtl">📊 #تابلوی_نرخ_لحظه‌ای_بازار</span><br />
            <span class="p" dir="rtl">✨ طلای ۱۸ عیار: 99,999,999</span><br />
            <span class="p" dir="rtl">🌟 طلای ۲۴ عیار: 88,888,888</span><br />
            <span class="p" dir="rtl">💰 آبشده اتحادیه: 120,505,000</span><br />
            <span class="p" dir="rtl">🟡 انس جهانی طلا: 4,603.90</span><br />
            <span class="p" dir="ltr">🆔 @talalive_ir</span>
        </div>
        HTML;

        Http::fake([
            'https://ble.ir/s/talaliveir*' => Http::response($sampleHtml, 200),
            'https://api.zipodo.ir/usdt/*' => Http::response(['price' => 95200, 'Ex-name' => 'Nobitex'], 200),
        ]);

        $service = app(MarketService::class);
        $service->fetchAndCache();

        // 120505000 / 4.3318 = 27818689.689967 -> round = 27818690
        $gold18 = MarketCache::where('symbol', 'gold18')->first();
        $this->assertNotNull($gold18);
        $this->assertEquals(27818690.0, $gold18->value);

        // 27818690 / 0.75 = 37091586.666667 -> round = 37091587
        $gold24 = MarketCache::where('symbol', 'gold24')->first();
        $this->assertNotNull($gold24);
        $this->assertEquals(37091587.0, $gold24->value);

        // آبشده
        $mesghal = MarketCache::where('symbol', 'mesghal17')->first();
        $this->assertNotNull($mesghal);
        $this->assertEquals(120505000.0, $mesghal->value);

        // تتر از زیپودو
        $usdt = MarketCache::where('symbol', 'usdt')->first();
        $this->assertNotNull($usdt);
        $this->assertEquals(95200.0, $usdt->value);
    }

    public function test_fallback_to_talanerkh_when_talaliveir_fails(): void
    {
        $backupHtml = <<<HTML
        <div>اعلام نرخ رسمی طلا</div>
        <div>
            هر گرم 18 عیار: 3,450,000 تومان<br />
            انس جهانی طلا: 2,650 دلار<br />
            سکه طرح جدید: 42,000,000 تومان<br />
            دلار: 60,000 تومان<br />
        </div>
        HTML;

        Http::fake([
            'https://ble.ir/s/talaliveir*' => Http::response('Server Error', 500),
            'https://ble.ir/s/talanerkh*'  => Http::response($backupHtml, 200),
            'https://api.zipodo.ir/usdt/*' => Http::response(['price' => 60500, 'Ex-name' => 'Nobitex'], 200),
        ]);

        $service = app(MarketService::class);
        $service->fetchAndCache();

        $gold18 = MarketCache::where('symbol', 'gold18')->first();
        $this->assertNotNull($gold18);
        $this->assertEquals(3450000.0, $gold18->value);

        $ounce = MarketCache::where('symbol', 'ounce')->first();
        $this->assertNotNull($ounce);
        $this->assertEquals(2650.0, $ounce->value);

        $usd = MarketCache::where('symbol', 'usd')->first();
        $this->assertNotNull($usd);
        $this->assertEquals(60000.0, $usd->value);
    }
}
