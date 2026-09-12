<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MarketCache;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    /**
     * نمایه اصلی نقشه سایت (Sitemap Index)
     */
    public function index(): Response
    {
        $lastModified = Carbon::now()->toAtomString();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        $sections = [
            'sitemap-pages.xml',
            'sitemap-tools.xml',
            'sitemap-guides.xml',
            'sitemap-cities.xml',
            'sitemap-shops.xml',
        ];

        foreach ($sections as $section) {
            $xml .= "    <sitemap>\n";
            $xml .= "        <loc>https://talalive.ir/{$section}</loc>\n";
            $xml .= "        <lastmod>{$lastModified}</lastmod>\n";
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
        $today = Carbon::now()->toDateString();

        $pages = [
            ['url' => 'https://talalive.ir/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => 'https://talalive.ir/smart-gold-board', 'priority' => '0.95', 'changefreq' => 'weekly'],
            ['url' => 'https://talalive.ir/led-vs-smart-board', 'priority' => '0.90', 'changefreq' => 'weekly'],
            ['url' => 'https://talalive.ir/pricing', 'priority' => '0.85', 'changefreq' => 'monthly'],
            ['url' => 'https://talalive.ir/tv-setup-guide', 'priority' => '0.85', 'changefreq' => 'monthly'],
            ['url' => 'https://talalive.ir/about', 'priority' => '0.60', 'changefreq' => 'monthly'],
            ['url' => 'https://talalive.ir/contact', 'priority' => '0.60', 'changefreq' => 'monthly'],
            ['url' => 'https://talalive.ir/terms', 'priority' => '0.50', 'changefreq' => 'monthly'],
            ['url' => 'https://talalive.ir/privacy', 'priority' => '0.50', 'changefreq' => 'monthly'],
        ];

        return $this->renderUrlset($pages, $today);
    }

    /**
     * نقشه ابزارهای محاسباتی تخصصی طلا و مسکوکات
     */
    public function tools(): Response
    {
        $today = Carbon::now()->toDateString();

        $tools = [
            ['url' => 'https://talalive.ir/gold-calculator', 'priority' => '0.90', 'changefreq' => 'daily'],
            ['url' => 'https://talalive.ir/tools/gold-price-calculator', 'priority' => '0.90', 'changefreq' => 'daily'],
            ['url' => 'https://talalive.ir/tools/coin-bubble', 'priority' => '0.90', 'changefreq' => 'daily'],
            ['url' => 'https://talalive.ir/tools/mesghal', 'priority' => '0.85', 'changefreq' => 'daily'],
            ['url' => 'https://talalive.ir/tools/melted-gold', 'priority' => '0.85', 'changefreq' => 'daily'],
            ['url' => 'https://talalive.ir/tools/karat-converter', 'priority' => '0.80', 'changefreq' => 'weekly'],
        ];

        return $this->renderUrlset($tools, $today);
    }

    /**
     * نقشه مقالات، آموزش‌ها و پایگاه دانش
     */
    public function guides(): Response
    {
        $today = Carbon::now()->toDateString();

        $guides = [
            ['url' => 'https://talalive.ir/guides', 'priority' => '0.80', 'changefreq' => 'weekly'],
            ['url' => 'https://talalive.ir/guides/gold-price-formula-18k', 'priority' => '0.75', 'changefreq' => 'monthly'],
            ['url' => 'https://talalive.ir/guides/gold-tax-regulations', 'priority' => '0.75', 'changefreq' => 'monthly'],
            ['url' => 'https://talalive.ir/guides/best-tv-for-jewelry-shop', 'priority' => '0.75', 'changefreq' => 'monthly'],
            ['url' => 'https://talalive.ir/guides/how-to-calculate-coin-bubble', 'priority' => '0.75', 'changefreq' => 'monthly'],
        ];

        return $this->renderUrlset($guides, $today);
    }

    /**
     * نقشه صفحات شهرهای قطب بازار طلا (Local SEO)
     */
    public function cities(): Response
    {
        $today = Carbon::now()->toDateString();

        $cities = [
            'tehran'    => 'تهران (بازار بزرگ و سبزه میدان)',
            'isfahan'   => 'اصفهان (بازار هنر و نقش جهان)',
            'mashhad'   => 'مشهد (راسته طلافروشان خسروی)',
            'tabriz'    => 'تبریز (بازار امیر)',
            'shiraz'    => 'شیراز (بازار زرگرها)',
            'yazd'      => 'یزد (خانقاه و زرگری)',
            'hamedan'   => 'همدان (راسته مظفریه)',
            'qom'       => 'قم (بازار کهنه)',
            'ahvaz'     => 'اهواز',
            'rasht'     => 'رشت',
        ];

        $urls = [];
        foreach (array_keys($cities) as $citySlug) {
            $urls[] = [
                'url' => "https://talalive.ir/cities/{$citySlug}",
                'priority' => '0.70',
                'changefreq' => 'weekly',
            ];
        }

        return $this->renderUrlset($urls, $today);
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
            $lastmod = $user->updated_at ? Carbon::parse($user->updated_at)->toDateString() : Carbon::now()->toDateString();
            $urls[] = [
                'url' => "https://talalive.ir/{$user->username}",
                'priority' => '0.65',
                'changefreq' => 'daily',
                'lastmod' => $lastmod,
            ];
        }

        return $this->renderUrlset($urls, Carbon::now()->toDateString());
    }

    /**
     * ساخت ساختار XML خروجی urlset
     */
    protected function renderUrlset(array $items, string $defaultDate): Response
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($items as $item) {
            $lastmod = $item['lastmod'] ?? $defaultDate;
            $xml .= "    <url>\n";
            $xml .= "        <loc>" . htmlspecialchars($item['url']) . "</loc>\n";
            $xml .= "        <lastmod>{$lastmod}</lastmod>\n";
            $xml .= "        <changefreq>{$item['changefreq']}</changefreq>\n";
            $xml .= "        <priority>{$item['priority']}</priority>\n";
            $xml .= "    </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }
}
