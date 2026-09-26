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
     * صفحه اصلی و لندینگ‌پیج تجاری طلالایو ویژه معرفی و جذب طلافروشان
     */
    public function home()
    {
        $data = $this->getRatesData();
        return view('pages.home', $data);
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
     * لندینگ تجاری نرخ‌نامه دیجیتال طلافروشی جایگزین تابلوهای ۷ رقمه
     */
    public function digitalRateBoard()
    {
        return view('pages.digital-rate-board');
    }

    /**
     * لندینگ تجاری تابلو طلا بدون دستگاه ویژه اجرای تمام‌ابری روی تلویزیون
     */
    public function goldBoardWithoutDevice()
    {
        return view('pages.gold-board-without-device');
    }

    /**
     * صفحه مقایسه تابان گوهر با طلالایو
     */
    public function compareTabangohar()
    {
        return view('pages.compare.tabangohar');
    }

    /**
     * صفحه مقایسه تابلوی TGJU با طلالایو
     */
    public function compareTgjuTv()
    {
        return view('pages.compare.tgju-tv');
    }

    /**
     * صفحه مقایسه اپلیکیشن تابلو طلا با طلالایو
     */
    public function compareTablotala()
    {
        return view('pages.compare.tablotala');
    }

    /**
     * لندینگ تجاری تابلو آنلاین قیمت طلا و مسکوکات با نرخ لحظه‌ای
     */
    public function onlineGoldPriceBoard()
    {
        return view('pages.online-gold-price-board');
    }

    /**
     * لندینگ تجاری تابلو صرافی و نرخ ارز برای تلویزیون هوشمند
     */
    public function currencyExchangeBoard()
    {
        return view('pages.currency-exchange-board');
    }

    /**
     * لندینگ تجاری تابلو نرخ نقره و شمش برای تلویزیون
     */
    public function silverBullionBoard()
    {
        return view('pages.silver-bullion-board');
    }

    /**
     * راهنمای فنی راه‌اندازی تابلو طلا روی اندروید تی‌وی و باکس اندروید
     */
    public function androidTvGoldBoard()
    {
        return view('pages.android-tv-gold-board');
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
     * ابزار تخصصی ۶: ماشین‌حساب آنلاین محاسبه اجرت ساخت طلا
     */
    public function toolWageCalculator()
    {
        $data = $this->getRatesData();
        return view('pages.tools.wage-calculator', $data);
    }

    /**
     * ابزار تخصصی ۷: محاسبه‌گر آنلاین قیمت‌گذاری طلای دست دوم و مستعمل
     */
    public function toolSecondHandGold()
    {
        $data = $this->getRatesData();
        return view('pages.tools.second-hand-gold', $data);
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
                'description' => 'آموزش گام‌به‌گام نحوه محاسبه فاکتور طلا، طلای دست دوم، طلای کم‌اجرت، سود ۷ درصد مغازه طلا فروشی و قانون جدید مالیات در سال ۱۴۰۵.',
                'date' => '۱۴۰۴/۰۶/۲۰',
                'image' => 'images/guides/gold-price-formula-18k.webp',
                'view' => 'pages.guides.gold-price-formula',
            ],
            'gold-tax-regulations' => [
                'title' => 'قانون جدید مالیات طلا و اجرت در سامانه مودیان صنف طلا و مغازه طلا فروشی',
                'description' => 'بررسی کامل تکالیف مالیاتی طلافروشان و مغازه‌های طلا فروشی، نحوه محاسبه مالیات ۹ درصدی روی اجرت و سود، و ثبت در پایانه فروشگاهی.',
                'date' => '۱۴۰۴/۰۶/۱۸',
                'image' => 'images/guides/gold-tax-regulations.webp',
                'view' => 'pages.guides.gold-tax-regulations',
            ],
            'best-tv-for-jewelry-shop' => [
                'title' => 'راهنمای انتخاب بهترین تلویزیون برای تابلو طلا فروشی و مغازه طلافروشی',
                'description' => 'مقایسه تلویزیون‌های مناسب تابلو طلا فروشی و تابلوی طلافروشی (سامسونگ، ال‌جی، سونی و اسنوا) از نظر زاویه دید، طول عمر پنل و روشنایی در ویترین.',
                'date' => '۱۴۰۴/۰۶/۱۵',
                'image' => 'images/guides/best-tv-gold-shop.webp',
                'view' => 'pages.guides.best-tv-for-jewelry-shop',
            ],
            'how-to-calculate-coin-bubble' => [
                'title' => 'فرمول محاسبه حباب سکه امامی، بهار آزادی، نیم سکه و ربع سکه با انس جهانی',
                'description' => 'نحوه محاسبه ارزش ذاتی و حباب سکه امامی، تمام بهار آزادی، نیم سکه و ربع سکه بر اساس وزن، عیار ۹۰۰ و نرخ لحظه ای طلا و دلار.',
                'date' => '۱۴۰۴/۰۶/۱۲',
                'image' => 'images/guides/coin-bubble-calculation.webp',
                'view' => 'pages.guides.coin-bubble-calculation',
            ],
            'mazaneh-fardaei' => [
                'title' => 'مظنه فردایی چیست و چه فرقی با مظنه نقدی دارد؟',
                'description' => 'بررسی تفاوت مظنه فردایی و مظنه نقدی در بازار طلا، فرمول تبدیل مثقال ۱۷ به ۱۸ عیار با مثال عددی ۱ و نحوه نمایش در تابلوی طلالایو.',
                'date' => '۱۴۰۵/۰۱/۱۵',
                'image' => 'images/guides/mazaneh-fardaei.webp',
                'view' => 'pages.guides.mazaneh-fardaei',
            ],
            'motefareghe-18' => [
                'title' => 'تعویض و خرید متفرقه ۱۸ چیست؟ راهنمای طلافروش',
                'description' => 'تعویض و خرید متفرقه ۱۸ چیست؟ تفاوت ۲ نرخ طلای متفرقه، نمونه فاکتور تعویض با برچسب مثال و نحوه نمایش در تابلوی طلالایو. مطالعه کنید.',
                'date' => '۱۴۰۵/۰۱/۱۶',
                'image' => 'images/guides/motefareghe-18.webp',
                'view' => 'pages.guides.motefareghe-18',
            ],
            'goldsmith-legal-profit' => [
                'title' => 'سود قانونی طلافروشی چند درصد است؟ (۱۴۰۵)',
                'description' => 'سود قانونی طلافروشی چند درصد است؟ تفکیک ۳ جزء فاکتور طلا (سود ۷٪، اجرت و مالیات)، فرمول محاسبه قانونی و بررسی مصوبه اتحادیه طلا. مطالعه کنید.',
                'date' => '۱۴۰۵/۰۱/۱۸',
                'image' => 'images/guides/goldsmith-legal-profit.webp',
                'view' => 'pages.guides.goldsmith-legal-profit',
            ],
            'led-board-price-1405' => [
                'title' => 'قیمت تابلو ال ای دی طلافروشی در ۱۴۰۵ — راهنمای کامل',
                'description' => 'لیست قیمت تابلو ال ای دی طلافروشی در ۱۴۰۵: بررسی قیمت متری انواع ماژول P10، هزینه‌های پنهان ساخت و مقایسه اقتصادی با تلویزیون. همین حالا مطالعه کنید.',
                'date' => '۱۴۰۵/۰۱/۲۰',
                'image' => 'images/guides/led-board-price-1405.webp',
                'view' => 'pages.guides.led-board-price-1405',
            ],
            'gold-hallmark-inquiry' => [
                'title' => 'استعلام انگ طلا و ری‌گیری — راهنمای کامل',
                'description' => 'راهنمای استعلام انگ طلا و آزمایشگاه‌های ری‌گیری: روش خواندن شماره پاکت و عیار ۷۵۰ آبشده به همراه نکات رهگیری در سال ۱۴۰۵. همین حالا روش استعلام را بخوانید.',
                'date' => '۱۴۰۵/۰۱/۲۲',
                'image' => 'images/guides/gold-hallmark-inquiry.webp',
                'view' => 'pages.guides.gold-hallmark-inquiry',
            ],
            'samsung-tizen-gold-board' => [
                'title' => 'تابلو قیمت طلا روی تلویزیون سامسونگ (Tizen) | طلالایو',
                'description' => 'راهنمای گام‌به‌گام اتصال مرورگر تایزن تلویزیون‌های سامسونگ به سامانه تابلوی طلالایو بدون نیاز به دانگل در سال ۱۴۰۵. همین حالا تابلوی مغازه را رایگان فعال کنید.',
                'date' => '۱۴۰۵/۰۱/۲۳',
                'image' => 'images/guides/samsung-tizen-gold-board.webp',
                'view' => 'pages.guides.samsung-tizen-gold-board',
            ],
            'lg-webos-gold-board' => [
                'title' => 'تابلو قیمت طلا روی تلویزیون ال‌جی (webOS) | طلالایو',
                'description' => 'آموزش تنظیمات اتصال مرورگر webOS تلویزیون‌های ال‌جی به تابلوی طلا و فعال‌سازی حالت تمام‌صفحه در سال ۱۴۰۵. همین حالا ۵ دقیقه‌ای تابلوی مغازه را فعال کنید.',
                'date' => '۱۴۰۵/۰۱/۲۴',
                'image' => 'images/guides/lg-webos-gold-board.webp',
                'view' => 'pages.guides.lg-webos-gold-board',
            ],
        ];

        if (!isset($guides[$slug])) {
            abort(404, 'مقاله مورد نظر در پایگاه دانش طلالایو یافت نشد.');
        }

        $guide = $guides[$slug];
        return view($guide['view'], ['guide' => $guide, 'slug' => $slug]);
    }

    /**
     * نمایه و فهرست شهرهای فعال بازار طلا (Local SEO Index)
     */
    public function citiesIndex()
    {
        $cityData = config('cities', []);
        return view('pages.cities.index', [
            'cities' => $cityData,
            'rates' => $this->getRatesData()['rates'],
        ]);
    }

    /**
     * لندینگ‌های محلی و شهرهای قطب بازار طلا (Local SEO Hub)
     */
    public function cityHub(string $city)
    {
        $cityData = config('cities', []);

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

    /**
     * صفحه پیش‌نمایش زنده تابلو بدون نیاز به ثبت‌نام (دموی عمومی آنلاین)
     */
    public function demo()
    {
        $ratesData = $this->getRatesData();
        
        $demoSetting = [
            'shop_name' => 'گالری نمونه طلالایو',
            'phone' => '۰۹۱۸۷۰۰۹۰۶۴',
            'instagram' => 'talalive.ir',
            'rubika' => 'talalive',
            'theme_mode' => 'light-modern',
            'slider_interval_sec' => 8,
            'show_weight' => true,
            'show_labor' => true,
            'show_profit' => true,
            'qr_link' => 'https://talalive.ir',
            'qr_label' => 'اسکن تابلوی زنده',
            'qr_desc' => 'مشاهده روی گوشی همراه',
            'published_at' => now()->toIso8601String(),
        ];

        $demoFeed = [
            ['symbol' => 'gold18', 'name' => 'طلای ۱۸ عیار', 'value' => $ratesData['rates']['gold18'] ?: 3650000, 'unit' => 'تومان', 'direction' => 'flat', 'is_stale' => false],
            ['symbol' => 'mesghal17', 'name' => 'مظنه مثقال ۱۷', 'value' => $ratesData['rates']['mesghal'] ?: 15800000, 'unit' => 'تومان', 'direction' => 'flat', 'is_stale' => false],
            ['symbol' => 'coin_emami', 'name' => 'سکه امامی', 'value' => $ratesData['rates']['coin_emami'] ?: 43500000, 'unit' => 'تومان', 'direction' => 'flat', 'is_stale' => false],
            ['symbol' => 'coin_bahar', 'name' => 'تمام بهار آزادی', 'value' => $ratesData['rates']['coin_bahar'] ?: 39800000, 'unit' => 'تومان', 'direction' => 'flat', 'is_stale' => false],
            ['symbol' => 'coin_nim', 'name' => 'نیم سکه', 'value' => $ratesData['rates']['coin_nim'] ?: 23800000, 'unit' => 'تومان', 'direction' => 'flat', 'is_stale' => false],
            ['symbol' => 'coin_rob', 'name' => 'ربع سکه', 'value' => $ratesData['rates']['coin_rob'] ?: 15200000, 'unit' => 'تومان', 'direction' => 'flat', 'is_stale' => false],
            ['symbol' => 'coin_gerami', 'name' => 'سکه گرمی', 'value' => $ratesData['rates']['coin_gerami'] ?: 7200000, 'unit' => 'تومان', 'direction' => 'flat', 'is_stale' => false],
            ['symbol' => 'ounce', 'name' => 'انس جهانی طلا', 'value' => $ratesData['rates']['ons'] ?: 2720, 'unit' => 'دلار', 'direction' => 'flat', 'is_stale' => false],
            ['symbol' => 'usd', 'name' => 'دلار آزاد', 'value' => $ratesData['rates']['dollar'] ?: 68500, 'unit' => 'تومان', 'direction' => 'flat', 'is_stale' => false],
        ];

        $demoItems = [
            ['key' => 'gold18', 'label' => 'طلای ۱۸ عیار', 'enabled' => true, 'order' => 1],
            ['key' => 'mesghal17', 'label' => 'مظنه مثقال ۱۷', 'enabled' => true, 'order' => 2],
            ['key' => 'coin_emami', 'label' => 'سکه امامی', 'enabled' => true, 'order' => 3],
            ['key' => 'coin_bahar', 'label' => 'تمام بهار آزادی', 'enabled' => true, 'order' => 4],
            ['key' => 'coin_nim', 'label' => 'نیم سکه', 'enabled' => true, 'order' => 5],
            ['key' => 'coin_rob', 'label' => 'ربع سکه', 'enabled' => true, 'order' => 6],
            ['key' => 'coin_gerami', 'label' => 'سکه گرمی', 'enabled' => true, 'order' => 7],
            ['key' => 'ounce', 'label' => 'انس جهانی طلا', 'enabled' => true, 'order' => 8],
            ['key' => 'usd', 'label' => 'دلار آزاد', 'enabled' => true, 'order' => 9],
        ];

        $snapshot = [
            'username' => 'demo',
            'updatedAt' => now()->toIso8601String(),
            'apiTime' => $ratesData['apiTime'] ?? 'لحظه‌ای',
            'refreshIntervalSeconds' => 10,
            'displayItems' => $demoItems,
            'priceFeed' => $demoFeed,
            'products' => [],
            'settings' => (object)$demoSetting,
        ];

        return view('pages.demo', array_merge($ratesData, [
            'snapshot' => $snapshot,
        ]));
    }

    /**
     * صفحه راهنما و سازنده کد ویجت امبد نرخ طلا
     */
    public function widgetGuide()
    {
        $ratesData = $this->getRatesData();
        return view('pages.widget', $ratesData);
    }

    /**
     * رندر مستقیم ویجت امبدشده داخل آی‌فریم
     */
    public function widgetEmbed(\Illuminate\Http\Request $request)
    {
        $ratesData = $this->getRatesData();
        $theme = $request->query('theme', 'dark');
        $size = $request->query('size', 'box');

        $content = view('pages.widget-embed', array_merge($ratesData, [
            'theme' => $theme,
            'size'  => $size,
        ]))->render();

        return response($content, 200, [
            'Content-Type'    => 'text/html; charset=utf-8',
            'X-Frame-Options' => 'ALLOWALL',
        ]);
    }

    /**
     * وب‌سرویس عمومی RESTful نرخ لحظه‌ای طلا، سکه و ارز
     */
    public function apiRates(Request $request)
    {
        $ratesData = $this->getRatesData();
        $rates = $ratesData['rates'];

        return response()->json([
            'status' => 'success',
            'attribution' => [
                'provider' => 'سامانه تابلوی طلای آنلاین طلالایو',
                'website' => 'https://talalive.ir',
                'terms' => 'استفاده از این وب‌سرویس منوط به درج لینک مستقیم و فعال به talalive.ir به عنوان منبع داده است.'
            ],
            'rate_limits' => [
                'allowed_requests_per_minute' => 60,
                'throttle_policy' => 'IP-based sliding window'
            ],
            'timestamp' => now()->toIso8601String(),
            'api_time' => $ratesData['apiTime'] ?? 'لحظه‌ای',
            'currency' => 'IRR (Toman)',
            'data' => [
                'gold' => [
                    'gram_18k' => [
                        'name' => 'طلای ۱۸ عیار (گرم)',
                        'price' => (float)$rates['gold18'],
                        'unit' => 'تومان'
                    ],
                    'gram_24k' => [
                        'name' => 'طلای ۲۴ عیار (گرم)',
                        'price' => (float)$rates['gold24'],
                        'unit' => 'تومان'
                    ],
                    'mesghal_17k' => [
                        'name' => 'مظنه مثقال ۱۷ عیار (تهران)',
                        'price' => (float)$rates['mesghal'],
                        'unit' => 'تومان'
                    ],
                    'ounce_global' => [
                        'name' => 'انس جهانی طلا',
                        'price' => (float)$rates['ons'],
                        'unit' => 'دلار'
                    ],
                ],
                'coins' => [
                    'emami' => [
                        'name' => 'سکه تمام طرح جدید (امامی)',
                        'price' => (float)$rates['coin_emami'],
                        'unit' => 'تومان'
                    ],
                    'bahar' => [
                        'name' => 'سکه تمام بهار آزادی (طرح قدیم)',
                        'price' => (float)$rates['coin_bahar'],
                        'unit' => 'تومان'
                    ],
                    'half' => [
                        'name' => 'نیم سکه بهار آزادی',
                        'price' => (float)$rates['coin_nim'],
                        'unit' => 'تومان'
                    ],
                    'quarter' => [
                        'name' => 'ربع سکه بهار آزادی',
                        'price' => (float)$rates['coin_rob'],
                        'unit' => 'تومان'
                    ],
                    'gerami' => [
                        'name' => 'سکه گرمی',
                        'price' => (float)$rates['coin_gerami'],
                        'unit' => 'تومان'
                    ],
                ],
                'currency' => [
                    'usd_free' => [
                        'name' => 'دلار آمریکا (آزاد)',
                        'price' => (float)$rates['dollar'],
                        'unit' => 'تومان'
                    ]
                ]
            ]
        ], 200, [
            'Content-Type' => 'application/json; charset=utf-8',
            'Access-Control-Allow-Origin' => '*',
            'Cache-Control' => 'public, max-age=15',
        ]);
    }

    /**
     * صفحه مستندات جامع وب‌سرویس عمومی و API نرخ لحظه‌ای طلا
     */
    public function apiDocs()
    {
        $ratesData = $this->getRatesData();
        return view('pages.api-docs', $ratesData);
    }

    /**
     * صفحه فرود معرفی و دانلود اپلیکیشن موبایل و تلویزیون طلالایو
     */
    public function appLanding()
    {
        $ratesData = $this->getRatesData();
        return view('pages.app', $ratesData);
    }
}
