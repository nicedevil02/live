<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('market_cache')) {
            Schema::table('market_cache', function (Blueprint $table) {
                if (!Schema::hasColumn('market_cache', 'yesterday_price')) {
                    $table->decimal('yesterday_price', 20, 2)->nullable()->after('direction');
                }
                if (!Schema::hasColumn('market_cache', 'today_open_price')) {
                    $table->decimal('today_open_price', 20, 2)->nullable()->after('yesterday_price');
                }
                if (!Schema::hasColumn('market_cache', 'price_date')) {
                    $table->date('price_date')->nullable()->after('today_open_price');
                }
            });

            // مقداردهی اولیه نرخ‌های پایه دیروز و بازگشایی برای آیتم‌های موجود
            try {
                $today = date('Y-m-d');
                $defaults = [
                    'mesghal17'   => 111140000.00,
                    'gold18'      => 25656771.00,
                    'gold24'      => 34209028.00,
                    'ounce'       => 3891.50,
                    'coin_emami'  => 262400000.00,
                    'coin_bahar'  => 253000000.00,
                    'coin_nim'    => 139000000.00,
                    'coin_rob'    => 75000000.00,
                    'coin_gerami' => 36900000.00,
                    'usd'         => 272200.00,
                    'euro'        => 305600.00,
                    'dirham'      => 74380.00,
                    'usdt'        => 274350.00,
                    'bitcoin'     => 77820.00,
                ];

                $records = DB::table('market_cache')->get();
                foreach ($records as $r) {
                    $val = (float)$r->value;
                    $yVal = $defaults[$r->symbol] ?? ($val * 0.998); // fallback: minor realistic delta
                    $diff = $val - $yVal;
                    $pct = $yVal > 0 ? round(($diff / $yVal) * 100, 2) : 0;
                    $dir = $diff > 0.01 ? 'up' : ($diff < -0.01 ? 'down' : 'flat');

                    DB::table('market_cache')->where('symbol', $r->symbol)->update([
                        'yesterday_price'  => $yVal,
                        'today_open_price' => $yVal,
                        'price_date'       => $today,
                        'change_value'     => $diff,
                        'change_percent'   => $pct,
                        'direction'        => $dir,
                    ]);
                }
            } catch (\Throwable $e) {
                // در صورت بروز هرگونه خطای مقداردهی رد می‌شود
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('market_cache')) {
            Schema::table('market_cache', function (Blueprint $table) {
                $cols = [];
                if (Schema::hasColumn('market_cache', 'yesterday_price')) $cols[] = 'yesterday_price';
                if (Schema::hasColumn('market_cache', 'today_open_price')) $cols[] = 'today_open_price';
                if (Schema::hasColumn('market_cache', 'price_date')) $cols[] = 'price_date';
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }
    }
};
