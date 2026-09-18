<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    /**
     * نمایه اصلی نقشه سایت (Sitemap Index)
     */
    public function index(): Response
    {
        $sections = [
            [
                'loc' => 'https://talalive.ir/sitemap-pages.xml',
                'lastmod' => $this->getSectionLastMod($this->getPagesList()),
            ],
            [
                'loc' => 'https://talalive.ir/sitemap-tools.xml',
                'lastmod' => $this->getSectionLastMod($this->getToolsList()),
            ],
            [
                'loc' => 'https://talalive.ir/sitemap-guides.xml',
                'lastmod' => $this->getSectionLastMod($this->getGuidesList()),
            ],
            [
                'loc' => 'https://talalive.ir/sitemap-cities.xml',
                'lastmod' => $this->getViewLastMod('pages.cities.hub'),
            ],
            [
                'loc' => 'https://talalive.ir/sitemap-shops.xml',
                'lastmod' => $this->getShopsLastMod(),
            ],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($sections as $section) {
            $xml .= "    <sitemap>\n";
            $xml .= "        <loc>" . htmlspecialchars($section['loc']) . "</loc>\n";
            $xml .= "        <lastmod>{$section['lastmod']}</lastmod>\n";
            $xml .= "    </sitemap>\n";
        }

        $xml .= '</sitemapindex>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }

    /**
     * نقشه صفحات اصلی و لندینگ‌های تجاری
     */
    public function pages(): Response
    {
        return $this->renderUrlset($this->getPagesList());
    }

    /**
     * نقشه ابزارهای محاسباتی تخصصی طلا و مسکوکات
     */
    public function tools(): Response
    {
        return $this->renderUrlset($this->getToolsList());
    }

    /**
     * نقشه مقالات، آموزش‌ها و پایگاه دانش
     */
    public function guides(): Response
    {
        return $this->renderUrlset($this->getGuidesList());
    }

    /**
     * نقشه صفحات شهرهای قطب بازار طلا (Local SEO)
     */
    public function cities(): Response
    {
        $cityDate = $this->getViewLastMod('pages.cities.hub');

        // در گام ۷.۴ تمامی ۱۰ شهر با محتوای اختصاصی کامل در نقشه سایت قرار می‌گیرند
        $cities = array_keys(config('cities', []));

        $urls = [];
        $urls[] = [
            'url' => 'https://talalive.ir/cities',
            'lastmod' => $this->getViewLastMod('pages.cities.index'),
        ];
        foreach ($cities as $citySlug) {
            $urls[] = [
                'url' => "https://talalive.ir/cities/{$citySlug}",
                'lastmod' => $cityDate,
            ];
        }

        return $this->renderUrlset($urls);
    }

    /**
     * نقشه گالری‌های طلا فعال و معتبر
     */
    public function shops(): Response
    {
        try {
            $activeUsers = User::query()
                ->where('is_approved', true)
                ->where(function ($q) {
                    $q->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
                })
                ->where(function ($q) {
                    $q->whereHas('productSlides')
                      ->orWhereHas('displaySetting', function ($sq) {
                          $sq->whereNotNull('shop_name')->where('shop_name', '!=', '');
                      });
                })
                ->select(['username', 'updated_at'])
                ->limit(500)
                ->get();
        } catch (\Throwable $e) {
            $activeUsers = collect();
        }

        $urls = [];
        foreach ($activeUsers as $user) {
            $lastmod = $user->updated_at ? Carbon::parse($user->updated_at)->toDateString() : date('Y-m-d');
            $urls[] = [
                'url' => "https://talalive.ir/{$user->username}",
                'lastmod' => $lastmod,
            ];
        }

        return $this->renderUrlset($urls);
    }

    /**
     * لیست صفحات اصلی به همراه تاریخ تغییر فایل ویو
     */
    protected function getPagesList(): array
    {
        return [
            [
                'url' => 'https://talalive.ir/',
                'lastmod' => $this->getViewLastMod('pages.home'),
                'images' => [
                    ['loc' => 'https://talalive.ir/images/tv-preview.webp', 'title' => 'اسکرین‌شات تابلوی هوشمند نرخ لحظه‌ای طلا و سکه طلالایو روی تلویزیون مغازه'],
                    ['loc' => 'https://talalive.ir/images/og-cover.png', 'title' => 'سامانه ابری تابلوی هوشمند طلافروشی طلالایو'],
                ]
            ],
            [
                'url' => 'https://talalive.ir/smart-gold-board',
                'lastmod' => $this->getViewLastMod('pages.smart-gold-board'),
                'image' => ['loc' => 'https://talalive.ir/images/tv-preview.webp', 'title' => 'تابلوی هوشمند طلافروشی بدون نیاز به کیس'],
            ],
            [
                'url' => 'https://talalive.ir/led-vs-smart-board',
                'lastmod' => $this->getViewLastMod('pages.led-vs-smart-board'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/led-board-price-1405.webp', 'title' => 'مقایسه تابلوی ال ای دی با تابلوی هوشمند تلویزیون'],
            ],
            ['url' => 'https://talalive.ir/pricing', 'lastmod' => $this->getViewLastMod('pages.pricing')],
            [
                'url' => 'https://talalive.ir/tv-setup-guide',
                'lastmod' => $this->getViewLastMod('pages.tv-setup-guide'),
                'image' => ['loc' => 'https://talalive.ir/images/tv-preview.webp', 'title' => 'آموزش اتصال تلویزیون به تابلوی طلا'],
            ],
            [
                'url' => 'https://talalive.ir/digital-rate-board',
                'lastmod' => $this->getViewLastMod('pages.digital-rate-board'),
                'image' => ['loc' => 'https://talalive.ir/images/tv-preview.webp', 'title' => 'تابلو دیجیتال نرخ طلا و ارز'],
            ],
            [
                'url' => 'https://talalive.ir/gold-board-without-device',
                'lastmod' => $this->getViewLastMod('pages.gold-board-without-device'),
                'image' => ['loc' => 'https://talalive.ir/images/tv-preview.webp', 'title' => 'تابلوی طلا بدون دستگاه و سخت‌افزار واسط'],
            ],
            ['url' => 'https://talalive.ir/online-gold-price-board', 'lastmod' => $this->getViewLastMod('pages.online-gold-price-board')],
            ['url' => 'https://talalive.ir/currency-exchange-board', 'lastmod' => $this->getViewLastMod('pages.currency-exchange-board')],
            ['url' => 'https://talalive.ir/silver-bullion-board', 'lastmod' => $this->getViewLastMod('pages.silver-bullion-board')],
            ['url' => 'https://talalive.ir/compare/tabangohar', 'lastmod' => $this->getViewLastMod('pages.compare.tabangohar')],
            ['url' => 'https://talalive.ir/compare/tgju-tv', 'lastmod' => $this->getViewLastMod('pages.compare.tgju-tv')],
            ['url' => 'https://talalive.ir/compare/tablotala', 'lastmod' => $this->getViewLastMod('pages.compare.tablotala')],
            ['url' => 'https://talalive.ir/about', 'lastmod' => $this->getViewLastMod('pages.about')],
            ['url' => 'https://talalive.ir/contact', 'lastmod' => $this->getViewLastMod('pages.contact')],
            ['url' => 'https://talalive.ir/terms', 'lastmod' => $this->getViewLastMod('pages.terms')],
            ['url' => 'https://talalive.ir/privacy', 'lastmod' => $this->getViewLastMod('pages.privacy')],
            ['url' => 'https://talalive.ir/demo', 'lastmod' => $this->getViewLastMod('pages.demo')],
            ['url' => 'https://talalive.ir/widget', 'lastmod' => $this->getViewLastMod('pages.widget')],
            ['url' => 'https://talalive.ir/api-docs', 'lastmod' => $this->getViewLastMod('pages.api-docs')],
            ['url' => 'https://talalive.ir/app', 'lastmod' => $this->getViewLastMod('pages.app')],
        ];
    }

    /**
     * لیست ابزارهای تخصصی به همراه تاریخ تغییر فایل ویو
     */
    protected function getToolsList(): array
    {
        return [
            ['url' => 'https://talalive.ir/gold-calculator', 'lastmod' => $this->getViewLastMod('pages.gold-calculator')],
            ['url' => 'https://talalive.ir/tools/gold-price-calculator', 'lastmod' => $this->getViewLastMod('pages.tools.gold-price-calculator')],
            ['url' => 'https://talalive.ir/tools/coin-bubble', 'lastmod' => $this->getViewLastMod('pages.tools.coin-bubble')],
            ['url' => 'https://talalive.ir/tools/mesghal', 'lastmod' => $this->getViewLastMod('pages.tools.mesghal')],
            ['url' => 'https://talalive.ir/tools/melted-gold', 'lastmod' => $this->getViewLastMod('pages.tools.melted-gold')],
            ['url' => 'https://talalive.ir/tools/karat-converter', 'lastmod' => $this->getViewLastMod('pages.tools.karat-converter')],
            ['url' => 'https://talalive.ir/tools/wage-calculator', 'lastmod' => $this->getViewLastMod('pages.tools.wage-calculator')],
            ['url' => 'https://talalive.ir/tools/second-hand-gold', 'lastmod' => $this->getViewLastMod('pages.tools.second-hand-gold')],
        ];
    }

    /**
     * لیست مقالات و پایگاه دانش به همراه تاریخ تغییر فایل ویو
     */
    protected function getGuidesList(): array
    {
        return [
            ['url' => 'https://talalive.ir/guides', 'lastmod' => $this->getViewLastMod('pages.guides-index')],
            [
                'url' => 'https://talalive.ir/guides/gold-price-formula-18k',
                'lastmod' => $this->getViewLastMod('pages.guides.gold-price-formula'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/gold-price-formula-18k.webp', 'title' => 'فرمول دقیق محاسبه قیمت طلا ۱۸ عیار با اجرت و سود'],
            ],
            [
                'url' => 'https://talalive.ir/guides/gold-tax-regulations',
                'lastmod' => $this->getViewLastMod('pages.guides.gold-tax-regulations'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/gold-tax-regulations.webp', 'title' => 'قوانین مالیات بر ارزش افزوده طلا و سامانه مودیان'],
            ],
            [
                'url' => 'https://talalive.ir/guides/best-tv-for-jewelry-shop',
                'lastmod' => $this->getViewLastMod('pages.guides.best-tv-for-jewelry-shop'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/best-tv-gold-shop.webp', 'title' => 'بهترین تلویزیون برای تابلو و ویترین مغازه طلافروشی'],
            ],
            [
                'url' => 'https://talalive.ir/guides/how-to-calculate-coin-bubble',
                'lastmod' => $this->getViewLastMod('pages.guides.coin-bubble-calculation'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/coin-bubble-calculation.webp', 'title' => 'فرمول و نحوه محاسبه حباب انواع سکه طلا'],
            ],
            [
                'url' => 'https://talalive.ir/guides/mazaneh-fardaei',
                'lastmod' => $this->getViewLastMod('pages.guides.mazaneh-fardaei'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/mazaneh-fardaei.webp', 'title' => 'مظنه فردایی و نقدی طلا چیست و چه فرقی دارد'],
            ],
            [
                'url' => 'https://talalive.ir/guides/motefareghe-18',
                'lastmod' => $this->getViewLastMod('pages.guides.motefareghe-18'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/motefareghe-18.webp', 'title' => 'تعویض و خرید طلای متفرقه ۱۸ عیار و نحوه محاسبه'],
            ],
            [
                'url' => 'https://talalive.ir/guides/goldsmith-legal-profit',
                'lastmod' => $this->getViewLastMod('pages.guides.goldsmith-legal-profit'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/goldsmith-legal-profit.webp', 'title' => 'سود قانونی و اجرت مصوب مغازه طلافروشی'],
            ],
            [
                'url' => 'https://talalive.ir/guides/led-board-price-1405',
                'lastmod' => $this->getViewLastMod('pages.guides.led-board-price-1405'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/led-board-price-1405.webp', 'title' => 'قیمت تابلو ال ای دی طلافروشی در سال ۱۴۰۵'],
            ],
            [
                'url' => 'https://talalive.ir/guides/gold-hallmark-inquiry',
                'lastmod' => $this->getViewLastMod('pages.guides.gold-hallmark-inquiry'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/gold-hallmark-inquiry.webp', 'title' => 'راهنمای استعلام انگ طلا و ری‌گیری'],
            ],
            [
                'url' => 'https://talalive.ir/android-tv-gold-board',
                'lastmod' => $this->getViewLastMod('pages.android-tv-gold-board'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/android-tv-gold-board.webp', 'title' => 'راه‌اندازی تابلوی طلا روی تلویزیون‌های اندروید'],
            ],
            [
                'url' => 'https://talalive.ir/guides/samsung-tizen-gold-board',
                'lastmod' => $this->getViewLastMod('pages.guides.samsung-tizen-gold-board'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/samsung-tizen-gold-board.webp', 'title' => 'راه‌اندازی تابلو قیمت طلا روی تلویزیون سامسونگ تایزن'],
            ],
            [
                'url' => 'https://talalive.ir/guides/lg-webos-gold-board',
                'lastmod' => $this->getViewLastMod('pages.guides.lg-webos-gold-board'),
                'image' => ['loc' => 'https://talalive.ir/images/guides/lg-webos-gold-board.webp', 'title' => 'راه‌اندازی تابلو قیمت طلا روی تلویزیون ال‌جی webOS'],
            ],
        ];
    }

    /**
     * دریافت تاریخ واقعی آخرین تغییر فایل یک ویو به صورت Y-m-d
     */
    protected function getViewLastMod(string $view): string
    {
        $path = resource_path('views/' . str_replace('.', '/', $view) . '.blade.php');
        if (file_exists($path)) {
            return date('Y-m-d', filemtime($path));
        }
        $routesPath = base_path('routes/web.php');
        if (file_exists($routesPath)) {
            return date('Y-m-d', filemtime($routesPath));
        }
        return date('Y-m-d');
    }

    /**
     * محاسبه بیشترین تاریخ (جدیدترین) در یک لیست
     */
    protected function getSectionLastMod(array $items): string
    {
        $dates = array_filter(array_column($items, 'lastmod'));
        return !empty($dates) ? max($dates) : date('Y-m-d');
    }

    /**
     * تاریخ آخرین تغییر مغازه‌ها
     */
    protected function getShopsLastMod(): string
    {
        try {
            $latest = User::query()->where('is_approved', true)->max('updated_at');
            return $latest ? Carbon::parse($latest)->toDateString() : date('Y-m-d');
        } catch (\Throwable $e) {
            return date('Y-m-d');
        }
    }

    /**
     * ساخت ساختار استاندارد XML خروجی urlset بر اساس W3C / Google Image Sitemap
     */
    protected function renderUrlset(array $items): Response
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        foreach ($items as $item) {
            $lastmod = $item['lastmod'] ?? date('Y-m-d');
            $xml .= "    <url>\n";
            $xml .= "        <loc>" . htmlspecialchars($item['url']) . "</loc>\n";
            $xml .= "        <lastmod>{$lastmod}</lastmod>\n";

            if (!empty($item['images'])) {
                foreach ($item['images'] as $img) {
                    $xml .= "        <image:image>\n";
                    $xml .= "            <image:loc>" . htmlspecialchars($img['loc']) . "</image:loc>\n";
                    if (!empty($img['title'])) {
                        $xml .= "            <image:title>" . htmlspecialchars($img['title']) . "</image:title>\n";
                    }
                    $xml .= "        </image:image>\n";
                }
            } elseif (!empty($item['image'])) {
                $xml .= "        <image:image>\n";
                $xml .= "            <image:loc>" . htmlspecialchars($item['image']['loc']) . "</image:loc>\n";
                if (!empty($item['image']['title'])) {
                    $xml .= "            <image:title>" . htmlspecialchars($item['image']['title']) . "</image:title>\n";
                }
                $xml .= "        </image:image>\n";
            }

            $xml .= "    </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }
}
