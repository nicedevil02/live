<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditSeoRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:audit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Audit all public SEO routes for H1, canonical, meta tags, schema, and sitemap compliance';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // استقلال کامل از دیتابیس خارجی جهت اجرای فوق‌سریع و پایدار در هر شرایطی
        config([
            'cache.default' => 'array',
            'session.driver' => 'array',
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);

        try {
            \Illuminate\Support\Facades\Schema::create('market_caches', function ($table) {
                $table->id();
                $table->string('symbol')->unique();
                $table->decimal('value', 20, 4)->default(0);
                $table->timestamp('fetched_at')->nullable();
                $table->timestamps();
            });
            \Illuminate\Support\Facades\Schema::create('users', function ($table) {
                $table->id();
                $table->string('username')->unique();
                $table->boolean('is_approved')->default(true);
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        } catch (\Throwable $e) {
            // جدول‌های حافظه ایجاد نشد یا نیاز نیست
        }

        // غیرفعال‌سازی واکشی خارجی مارکت حین ممیزی سئو جهت صفر شدن تاخیر شبکه
        app()->instance(\App\Http\Middleware\FetchMarketDataMiddleware::class, new class {
            public function handle($request, $next) {
                return $next($request);
            }
        });

        $this->info('========================================================================================');
        $this->info('                 TALALIVE: COMPREHENSIVE SEO & TECHNICAL AUDIT                  ');
        $this->info('========================================================================================');

        // استخراج تمام لینک‌های عمومی موجود در نقشه‌های سایت
        $sitemapUrls = $this->extractSitemapUrls();

        $routesToAudit = [
            '/',
            '/smart-gold-board',
            '/led-vs-smart-board',
            '/pricing',
            '/tv-setup-guide',
            '/digital-rate-board',
            '/gold-board-without-device',
            '/online-gold-price-board',
            '/currency-exchange-board',
            '/silver-bullion-board',
            '/compare/tabangohar',
            '/compare/tgju-tv',
            '/compare/tablotala',
            '/about',
            '/contact',
            '/terms',
            '/privacy',
            '/demo',
            '/widget',
            '/api-docs',
            '/app',
            '/gold-calculator',
            '/tools/gold-price-calculator',
            '/tools/coin-bubble',
            '/tools/mesghal',
            '/tools/melted-gold',
            '/tools/karat-converter',
            '/tools/wage-calculator',
            '/tools/second-hand-gold',
            '/guides',
            '/guides/gold-price-formula-18k',
            '/guides/gold-tax-regulations',
            '/guides/best-tv-for-jewelry-shop',
            '/guides/how-to-calculate-coin-bubble',
            '/guides/mazaneh-fardaei',
            '/guides/motefareghe-18',
            '/guides/goldsmith-legal-profit',
            '/guides/led-board-price-1405',
            '/guides/gold-hallmark-inquiry',
            '/android-tv-gold-board',
            '/guides/samsung-tizen-gold-board',
            '/guides/lg-webos-gold-board',
            '/cities',
            '/cities/tehran',
            '/cities/mashhad',
            '/cities/hamedan',
            '/cities/isfahan',
            '/cities/tabriz',
            '/cities/shiraz',
            '/cities/yazd',
            '/cities/qom',
            '/cities/ahvaz',
            '/cities/rasht',
        ];

        $headers = ['URL Path', 'HTTP', 'H1', 'Canonical', 'NoKeyw', 'NoAgg', 'TitleLen', 'DescLen', 'Sitemap', 'Status'];
        $rows = [];
        $passCount = 0;
        $failCount = 0;

        foreach ($routesToAudit as $path) {
            $req = Request::create($path, 'GET');
            $kernel = app()->make(\Illuminate\Contracts\Http\Kernel::class);
            $res = $kernel->handle($req);

            $status = $res->getStatusCode();
            $content = $res->getContent();

            // 1. H1 count
            preg_match_all('/<h1\b[^>]*>(.*?)<\/h1>/si', $content, $h1Matches);
            $h1Count = count($h1Matches[0] ?? []);

            // 2. Canonical
            preg_match('/<link\s+[^>]*rel=["\']canonical["\'][^>]*href=["\']([^"\']+)["\']/i', $content, $canMatches);
            if (empty($canMatches[1])) {
                preg_match('/<link\s+[^>]*href=["\']([^"\']+)["\'][^>]*rel=["\']canonical["\']/i', $content, $canMatches);
            }
            $canonical = $canMatches[1] ?? '';
            $canonicalOk = str_starts_with($canonical, 'https://talalive.ir');

            // 3. No meta keywords
            $hasKeywords = (bool) preg_match('/<meta\s+[^>]*name=["\']keywords["\']/i', $content);

            // 4. No aggregateRating
            $hasAggRating = (bool) preg_match('/["\']@?type["\']\s*:\s*["\']AggregateRating["\']/i', $content);

            // 5. Title length
            preg_match('/<title\b[^>]*>(.*?)<\/title>/si', $content, $titleMatches);
            $title = trim($titleMatches[1] ?? '');
            $titleLen = mb_strlen(html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $titleOk = ($titleLen >= 30 && $titleLen <= 100);

            // 6. Meta Description length
            preg_match('/<meta\s+[^>]*name=["\']description["\'][^>]*content=["\']([^"\']+)["\']/i', $content, $descMatches);
            if (empty($descMatches[1])) {
                preg_match('/<meta\s+[^>]*content=["\']([^"\']+)["\'][^>]*name=["\']description["\']/i', $content, $descMatches);
            }
            $desc = trim($descMatches[1] ?? '');
            $descLen = mb_strlen(html_entity_decode($desc, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $descOk = ($descLen >= 70 && $descLen <= 170);

            // 7. Sitemap inclusion
            $fullUrl = $path === '/' ? 'https://talalive.ir/' : 'https://talalive.ir' . $path;
            $inSitemap = in_array($fullUrl, $sitemapUrls, true) || in_array(rtrim($fullUrl, '/'), $sitemapUrls, true);

            // Verdict
            $isPass = ($status === 200)
                && ($h1Count === 1)
                && $canonicalOk
                && !$hasKeywords
                && !$hasAggRating
                && $titleOk
                && $descOk
                && $inSitemap;

            if ($isPass) {
                $passCount++;
                $statusStr = '<info>PASS</info>';
            } else {
                $failCount++;
                $statusStr = '<error>FAIL</error>';
            }

            $rows[] = [
                $path,
                $status === 200 ? '200' : "<error>{$status}</error>",
                $h1Count === 1 ? '1' : "<error>{$h1Count}</error>",
                $canonicalOk ? 'OK' : '<error>FAIL</error>',
                !$hasKeywords ? 'OK' : '<error>FAIL</error>',
                !$hasAggRating ? 'OK' : '<error>FAIL</error>',
                $titleOk ? (string)$titleLen : "<comment>{$titleLen}</comment>",
                $descOk ? (string)$descLen : "<comment>{$descLen}</comment>",
                $inSitemap ? 'YES' : '<error>NO</error>',
                $statusStr,
            ];
        }

        $this->table($headers, $rows);

        $this->newLine();
        $this->info("Total Audited URLs: " . count($routesToAudit));
        $this->info("Passed: {$passCount}");
        if ($failCount > 0) {
            $this->error("Failed: {$failCount}");
            $this->error(">>> AUDIT FAILED! Please fix the reported issues. <<<");
            return 1;
        }

        $this->info("Failed: 0");
        $this->info(">>> 100% OF ALL PUBLIC PAGES PASSED ALL SEO AUDIT CRITERIA! <<<");
        return 0;
    }

    /**
     * جمع‌آوری تمام آدرس‌های معتبر از تمامی نقشه‌های سایت
     */
    protected function extractSitemapUrls(): array
    {
        $urls = [];
        $sitemaps = ['pages', 'guides', 'tools', 'cities', 'shops'];

        $kernel = app()->make(\Illuminate\Contracts\Http\Kernel::class);

        foreach ($sitemaps as $sitemap) {
            $req = Request::create("/sitemap-{$sitemap}.xml", 'GET');
            $res = $kernel->handle($req);
            if ($res->getStatusCode() === 200) {
                preg_match_all('/<loc>(.*?)<\/loc>/si', $res->getContent(), $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $u) {
                        $urls[] = trim($u);
                    }
                }
            }
        }

        return array_unique($urls);
    }
}
