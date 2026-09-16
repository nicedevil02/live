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

        $cities = [
            'tehran', 'isfahan', 'mashhad', 'tabriz',
            'shiraz', 'yazd', 'hamedan', 'qom',
            'ahvaz', 'rasht',
        ];

        $urls = [];
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
                ->whereHas('products')
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
            ['url' => 'https://talalive.ir/', 'lastmod' => $this->getViewLastMod('pages.home')],
            ['url' => 'https://talalive.ir/smart-gold-board', 'lastmod' => $this->getViewLastMod('pages.smart-gold-board')],
            ['url' => 'https://talalive.ir/led-vs-smart-board', 'lastmod' => $this->getViewLastMod('pages.led-vs-smart-board')],
            ['url' => 'https://talalive.ir/pricing', 'lastmod' => $this->getViewLastMod('pages.pricing')],
            ['url' => 'https://talalive.ir/tv-setup-guide', 'lastmod' => $this->getViewLastMod('pages.tv-setup-guide')],
            ['url' => 'https://talalive.ir/about', 'lastmod' => $this->getViewLastMod('pages.about')],
            ['url' => 'https://talalive.ir/contact', 'lastmod' => $this->getViewLastMod('pages.contact')],
            ['url' => 'https://talalive.ir/terms', 'lastmod' => $this->getViewLastMod('pages.terms')],
            ['url' => 'https://talalive.ir/privacy', 'lastmod' => $this->getViewLastMod('pages.privacy')],
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
        ];
    }

    /**
     * لیست مقالات و پایگاه دانش به همراه تاریخ تغییر فایل ویو
     */
    protected function getGuidesList(): array
    {
        return [
            ['url' => 'https://talalive.ir/guides', 'lastmod' => $this->getViewLastMod('pages.guides-index')],
            ['url' => 'https://talalive.ir/guides/gold-price-formula-18k', 'lastmod' => $this->getViewLastMod('pages.guides.gold-price-formula')],
            ['url' => 'https://talalive.ir/guides/gold-tax-regulations', 'lastmod' => $this->getViewLastMod('pages.guides.gold-tax-regulations')],
            ['url' => 'https://talalive.ir/guides/best-tv-for-jewelry-shop', 'lastmod' => $this->getViewLastMod('pages.guides.best-tv-for-jewelry-shop')],
            ['url' => 'https://talalive.ir/guides/how-to-calculate-coin-bubble', 'lastmod' => $this->getViewLastMod('pages.guides.coin-bubble-calculation')],
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
     * ساخت ساختار استاندارد XML خروجی urlset بر اساس W3C / Google
     */
    protected function renderUrlset(array $items): Response
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($items as $item) {
            $lastmod = $item['lastmod'] ?? date('Y-m-d');
            $xml .= "    <url>\n";
            $xml .= "        <loc>" . htmlspecialchars($item['url']) . "</loc>\n";
            $xml .= "        <lastmod>{$lastmod}</lastmod>\n";
            $xml .= "    </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }
}
