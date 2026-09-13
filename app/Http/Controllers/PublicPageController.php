<?php

namespace App\Http\Controllers;

use App\Models\MarketCache;
use App\Services\MarketService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class PublicPageController extends Controller
{
    protected MarketService $marketService;

    public function __construct(MarketService $marketService)
    {
        $this->marketService = $marketService;
    }

    /**
     * صفحه فرود اختصاصی تابلوی هوشمند طلافروشی (ستون تجاری B2B)
     */
    public function smartGoldBoard()
    {
        return view('pages.smart-gold-board');
    }

    /**
     * صفحه فرود تخصصی مقایسه تابلو LED و تلویزیون هوشمند (تسخیر بازار LED)
     */
    public function ledVsSmartBoard()
    {
        return view('pages.led-vs-smart-board');
    }

    /**
     * صفحه تعرفه‌ها و شفافیت قیمت اشتراک طلالایو
     */
    public function pricing()
    {
        return view('pages.pricing');
    }

    /**
     * راهنمای جامع اتصال تلویزیون به تابلوی طلا بدون کیس و کابل
     */
    public function tvSetupGuide()
    {
        return view('pages.tv-setup-guide');
    }

    /**
     * درباره طلالایو (سیگنال E-E-A-T و هویت برند)
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * تماس با ما و پشتیبانی اختصاصی طلالایو
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * شرایط و قوانین استفاده از خدمات
     */
    public function terms()
    {
        return view('pages.terms');
    }

    /**
     * حریم خصوصی و امنیت اطلاعات کاربران
     */
    public function privacy()
    {
        return view('pages.privacy');
    }

    /**
     * ماشین‌حساب آنلاین جامع طلا و مسکوکات
     */
    public function goldCalculator()
    {
        $data = $this->getRatesData();
        return view('pages.gold-calculator', $data);
    }

    /**
     * ابزار تخصصی ۱: ماشین‌حساب محاسبه قیمت طلا با اجرت، سود و مالیات
     */
    public function toolGoldPrice()
    {
        $data = $this->getRatesData();
        return view('pages.tools.gold-price-calculator', $data);
    }

    /**
     * ابزار تخصصی ۲: محاسبه‌گر آنلاین حباب انواع سکه با فرمول بانک مرکزی
     */
    public function toolCoinBubble()
    {
        $data = $this->getRatesData();
        return view('pages.tools.coin-bubble', $data);
    }

    /**
     * ابزار تخصصی ۳: تبدیل مظنه مثقال ۱۷ به گرم طلای ۱۸ عیار
     */
    public function toolMesghal()
    {
        $data = $this->getRatesData();
        return view('pages.tools.mesghal', $data);
    }

    /**
     * ابزار تخصصی ۴: محاسبه‌گر تخصصی طلای آبشده، شرطی و انگ
     */
    public function toolMeltedGold()
    {
        $data = $this->getRatesData();
        return view('pages.tools.melted-gold', $data);
    }

    /**
     * ابزار تخصصی ۵: تبدیل عیار طلا (۷۵۰، ۷۰۵، ۹۹۹ و...)
     */
    public function toolKaratConverter()
    {
        $data = $this->getRatesData();
        return view('pages.tools.karat-converter', $data);
    }

    /**
     * هاب مقالات، پایگاه دانش و راهنماهای صنف طلا و جواهر
     */
    public function guidesIndex()
    {
        return view('pages.guides-index');
    }

    /**
     * نمایش تک مقاله پایگاه دانش
     */
    public function guideShow(string $slug)
    {
        $guides = [
            'gold-price-formula-18k' => [
                'title' => 'فرمول دقیق محاسبه قیمت طلا ۱۸ عیار با اجرت، طلای دست دوم و سود در طلا فروشی',
                'description' => 'آموزش گام‌به‌گام نحوه محاسبه فاکتور طلا، طلای دست دوم (دستدوم)، طلای کم اجرت (کماجرت)، سود ۷ درصد مغازه طلا فروشی و قانون جدید مالیات در سال ۱۴۰۴.',
                'date' => '۱۴۰۴/۰۶/۲۰',
                'view' => 'pages.guides.gold-price-formula',
            ],
            'gold-tax-regulations' => [
                'title' => 'قانون جدید مالیات طلا و اجرت در سامانه مودیان صنف طلا و مغازه طلا فروشی',
                'description' => 'بررسی کامل تکالیف مالیاتی طلافروشان و مغازه‌های طلا فروشی، نحوه محاسبه مالیات ۹ درصدی روی اجرت و سود، و ثبت در پایانه فروشگاهی.',
                'date' => '۱۴۰۴/۰۶/۱۸',
                'view' => 'pages.guides.gold-tax-regulations',
            ],
            'best-tv-for-jewelry-shop' => [
                'title' => 'راهنمای انتخاب بهترین تلویزیون برای تابلو طلا فروشی و مغازه طلافروشی',
                'description' => 'مقایسه تلویزیون‌های مناسب تابلو طلا فروشی و تابلوی طلافروشی (سامسونگ، ال‌جی، سونی و اسنوا) از نظر زاویه دید، طول عمر پنل و روشنایی در ویترین.',
                'date' => '۱۴۰۴/۰۶/۱۵',
                'view' => 'pages.guides.best-tv-for-jewelry-shop',
            ],
            'how-to-calculate-coin-bubble' => [
                'title' => 'فرمول محاسبه حباب سکه امامی، بهار آزادی، نیم سکه و ربع سکه با انس جهانی',
                'description' => 'نحوه محاسبه ارزش ذاتی و حباب سکه امامی، بهار آزادی، بهار ازادی، بهارآزادی، بهارازادی، نیم سکه و ربع سکه بر اساس وزن، عیار ۹۰۰ و نرخ لحظه ای طلا و دلار.',
                'date' => '۱۴۰۴/۰۶/۱۲',
                'view' => 'pages.guides.coin-bubble-calculation',
            ],
        ];

        if (!isset($guides[$slug])) {
            abort(404, 'مقاله مورد نظر در پایگاه دانش طلالایو یافت نشد.');
        }

        $guide = $guides[$slug];
        return view($guide['view'], ['guide' => $guide, 'slug' => $slug]);
    }

    /**
     * لندینگ‌های محلی و شهرهای قطب بازار طلا (Local SEO Hub)
     */
    public function cityHub(string $city)
    {
        $cityData = [
            'tehran'  => ['name' => 'تهران', 'bazaar' => 'بازار بزرگ تهران و سبزه میدان', 'title' => 'تابلو طلا فروشی و تابلوی هوشمند طلافروشی در تهران | سبزه میدان'],
            'isfahan' => ['name' => 'اصفهان', 'bazaar' => 'بازار هنر و میدان نقش جهان', 'title' => 'تابلو طلا فروشی و تابلوی طلافروشی در اصفهان | بازار هنر'],
            'mashhad' => ['name' => 'مشهد', 'bazaar' => 'راسته طلافروشان خسروی و پاساژ ارگ', 'title' => 'تابلو طلا فروشی و نرم‌افزار تابلوی طلا در مشهد | خسروی و ارگ'],
            'tabriz'  => ['name' => 'تبریز', 'bazaar' => 'بازار تاریخی امیر و راسته طلافروشان', 'title' => 'تابلو طلا فروشی و تابلوی اعلام نرخ طلا در تبریز | بازار امیر'],
            'shiraz'  => ['name' => 'شیراز', 'bazaar' => 'بازار زرگرها و زند', 'title' => 'تابلو طلا فروشی و تابلوی طلافروشی در شیراز | بازار زرگرها'],
            'yazd'    => ['name' => 'یزد', 'bazaar' => 'بازار خان و راسته زرگری', 'title' => 'تابلو طلا فروشی و تابلوی نرخ طلا در یزد | بازار خان'],
            'hamedan' => ['name' => 'همدان', 'bazaar' => 'راسته مظفریه و طلافروشان', 'title' => 'تابلو طلا فروشی و تابلوی هوشمند طلافروشی در همدان'],
            'qom'     => ['name' => 'قم', 'bazaar' => 'بازار کهنه و راسته طلافروشان', 'title' => 'تابلو طلا فروشی و تابلوی دیجیتال طلا در قم'],
            'ahvaz'   => ['name' => 'اهواز', 'bazaar' => 'خیابان امام و راسته طلا و جواهر', 'title' => 'تابلو طلا فروشی و تابلوی اعلام قیمت طلا در اهواز'],
            'rasht'   => ['name' => 'رشت', 'bazaar' => 'بازار زرگران و میدان شهرداری', 'title' => 'تابلو طلا فروشی و تابلوی هوشمند طلافروشی در رشت'],
        ];

        if (!isset($cityData[$city])) {
            abort(404, 'شهر مورد نظر یافت نشد.');
        }

        return view('pages.cities.hub', [
            'city' => $city,
            'info' => $cityData[$city],
            'rates' => $this->getRatesData()['rates'],
        ]);
    }

    /**
     * استخراج مستقیم نرخ‌های تابلوی طلالایو برای ماشین‌حساب‌ها و ابزارها
     */
    protected function getRatesData(): array
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

        // استخراج مستقیم نرخ طلای ۱۸ و ۲۴ عیار و مثقال از تابلوی خودمان
        $gold18 = (float)($rawRates->get('gold18')?->value ?? $rawRates->get('raw_gold18')?->value ?? 0);
        $gold24 = (float)($rawRates->get('gold24')?->value ?? $rawRates->get('raw_gold24')?->value ?? 0);
        $mesghal = (float)($rawRates->get('mesghal17')?->value ?? 0);

        // استخراج انس جهانی و دلار
        $ons = (float)($rawRates->get('ounce')?->value ?? $rawRates->get('ons_gold')?->value ?? 0);
        $dollar = (float)($rawRates->get('usd')?->value ?? $rawRates->get('usdt')?->value ?? $rawRates->get('usd_sell')?->value ?? 0);

        // استخراج مستقیم قیمت مسکوکات دقیقاً از تابلوی خودمان (coin_emami, coin_bahar, coin_nim, coin_rob, coin_gerami)
        $coinEmami = (float)($rawRates->get('coin_emami')?->value ?? 0);
        $coinBahar = (float)($rawRates->get('coin_bahar')?->value ?? 0);
        $coinNim = (float)($rawRates->get('coin_nim')?->value ?? $rawRates->get('coin_half')?->value ?? 0);
        $coinRob = (float)($rawRates->get('coin_rob')?->value ?? $rawRates->get('coin_quarter')?->value ?? 0);
        $coinGerami = (float)($rawRates->get('coin_gerami')?->value ?? 0);

        // در صورت خالی بودن اولیه دیتابیس محلی
        if ($gold18 <= 0 && $mesghal > 0) {
            $gold18 = round($mesghal / MarketService::MESGHAL_TO_GRAM_18K);
        }

        return [
            'hasRealRates' => ($gold18 > 0),
            'rates' => [
                'gold18'       => $gold18,
                'gold24'       => $gold24 > 0 ? $gold24 : round($gold18 * (24 / 18)),
                'mesghal'      => $mesghal > 0 ? $mesghal : round($gold18 * MarketService::MESGHAL_TO_GRAM_18K),
                'ons'          => $ons,
                'dollar'       => $dollar,
                'coin_emami'   => $coinEmami,
                'coin_bahar'   => $coinBahar,
                'coin_nim'     => $coinNim,
                'coin_half'    => $coinNim,
                'coin_rob'     => $coinRob,
                'coin_quarter' => $coinRob,
                'coin_gerami'  => $coinGerami,
            ],
            'lastUpdated' => $lastFetch ? Carbon::parse($lastFetch)->diffForHumans() : 'لحظه‌ای',
            'apiTime'     => $apiTime,
        ];
    }
}
