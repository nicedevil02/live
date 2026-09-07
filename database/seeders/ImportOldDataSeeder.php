<?php

namespace Database\Seeders;

use App\Models\ApiSourceConfig;
use App\Models\AuditLog;
use App\Models\DisplayItem;
use App\Models\DisplaySetting;
use App\Models\FormulaConfig;
use App\Models\MarketCache;
use App\Models\ProductImage;
use App\Models\ProductSlide;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ImportOldDataSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(storage_path('app/state.json'));
        $data = json_decode($json, true);

        // 1. Admin user
        User::updateOrCreate(
            ['email' => 'nicedevil02@gmail.com'],
            [
                'name'           => $data['admin']['username'] ?? 'admin',
                'password'       => Hash::make('Bahman+11'),
                'is_admin'       => true,
                'is_super_admin' => true,
                'is_approved'    => true,
            ]
        );

        // 2. FormulaConfig
        FormulaConfig::updateOrCreate(
            ['id' => 1],
            [
                'buy_multiplier_a' => $data['formulas']['buy_multiplier_a'] ?? 740,
                'buy_divisor_b'    => $data['formulas']['buy_divisor_b'] ?? 750,
            ]
        );

        // 3. DisplaySettings
        DisplaySetting::updateOrCreate(
            ['id' => 1],
            [
                'theme_mode'          => $data['displaySettings']['theme_mode'] ?? 'dark-glass',
                'slider_interval_sec' => $data['displaySettings']['slider_interval_sec'] ?? 8,
                'show_weight'         => $data['displaySettings']['show_weight'] ?? true,
                'show_labor'          => $data['displaySettings']['show_labor'] ?? true,
                'show_profit'         => $data['displaySettings']['show_profit'] ?? true,
                'shop_name'           => $data['displaySettings']['shop_name'] ?? '',
                'phone'               => $data['displaySettings']['phone'] ?? '',
                'instagram'           => $data['displaySettings']['instagram'] ?? '',
                'rubika'              => $data['displaySettings']['rubika'] ?? '',
                'published_at'        => $data['displaySettings']['published_at'] ?? null,
            ]
        );

        // 4. DisplayItems
        if (!empty($data['displayItems'])) {
            foreach ($data['displayItems'] as $item) {
                DisplayItem::updateOrCreate(
                    ['key' => $item['key']],
                    [
                        'label'   => $item['label'],
                        'enabled' => $item['enabled'],
                        'order'   => $item['order'],
                    ]
                );
            }
        }

        // 5. ApiSourceConfig
        if (!empty($data['sources'])) {
            foreach ($data['sources'] as $source) {
                ApiSourceConfig::updateOrCreate(
                    ['key' => $source['key']],
                    [
                        'label'             => $source['label'],
                        'base_url'          => $source['base_url'],
                        'fallback_urls'     => $source['fallback_urls'] ?? [],
                        'auth_token'        => $source['auth_token'] ?? '',
                        'interval_seconds'  => $source['interval_seconds'] ?? 60,
                        'is_active'         => $source['is_active'] ?? true,
                        'last_status'       => $source['last_status'] ?? 'ok',
                        'last_latency_ms'   => $source['last_latency_ms'] ?? 0,
                        'last_checked_at'   => $source['last_checked_at'] ?? now(),
                        'last_error'        => $source['last_error'] ?? null,
                        'last_logs'         => $source['last_logs'] ?? [],
                    ]
                );
            }
        }

        // 6. MarketCache
        if (!empty($data['marketCache'])) {
            foreach ($data['marketCache'] as $symbol => $cache) {
                // اگر مقدار به‌جای آرایه، یک عدد ساده باشد (مثل buy_gold_prev)، از آن رد شو
                if (!is_array($cache)) {
                    continue;
                }

                MarketCache::updateOrCreate(
                    ['symbol' => $symbol],
                    [
                        'value'          => $cache['value'] ?? 0,
                        'unit'           => $cache['unit'] ?? 'تومان',
                        'change_value'   => $cache['change_value'] ?? 0,
                        'change_percent' => $cache['change_percent'] ?? 0,
                        'direction'      => $cache['direction'] ?? 'flat',
                        'is_stale'       => $cache['is_stale'] ?? false,
                        'fetched_at'     => $cache['fetched_at'] ?? now(),
                    ]
                );
            }
        }

        // 7. Products and images
        if (!empty($data['products'])) {
            foreach ($data['products'] as $productData) {
                $product = ProductSlide::updateOrCreate(
                    ['id' => $productData['id']],
                    [
                        'title'           => $productData['title'],
                        'weight_gram'     => $productData['weight_gram'],
                        'labor_fee'       => $productData['labor_fee'],
                        'profit_value'    => $productData['profit_value'],
                        'profit_type'     => $productData['profit_type'],
                        'base_gold_price' => $productData['base_gold_price'],
                        'final_price'     => $productData['final_price'],
                        'is_visible'      => $productData['is_visible'] ?? true,
                    ]
                );

                foreach ($productData['images'] as $img) {
                    ProductImage::updateOrCreate(
                        ['id' => $img['id']],
                        [
                            'product_id' => $product->id,
                            'url'        => $img['url'],
                            'alt'        => $img['alt'],
                            'sort_order' => $img['sort_order'] ?? 1,
                        ]
                    );
                }
            }
        }

        // 8. AuditLogs
        if (!empty($data['auditLogs'])) {
            foreach ($data['auditLogs'] as $log) {
                AuditLog::updateOrCreate(
                    ['id' => $log['id']],
                    [
                        'actor'       => $log['actor'],
                        'action'      => $log['action'],
                        'entity_type' => $log['entity_type'],
                        'entity_id'   => $log['entity_id'] ?? null,
                        'payload'     => json_encode($log['payload'] ?? []),
                        'created_at'  => $log['created_at'],
                    ]
                );
            }
        }
    }
}
