<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * اجرای مایگریشن جایگزینی ارزهای سنتی با کامودیتی‌های نوین و مظنه جهانی
     */
    public function up(): void
    {
        if (!Schema::hasTable('display_items')) {
            return;
        }

        DB::transaction(function () {
            $now = now()->toDateTimeString();

            // دریافت تمام شناسه‌های کاربران موجود در جدول
            $userIds = DB::table('display_items')
                ->whereNotNull('user_id')
                ->distinct()
                ->pluck('user_id')
                ->toArray();

            // همچنین دریافت کاربرانی که ممکن است رکوردی در جدول نداشته باشند
            if (Schema::hasTable('users')) {
                $allUsers = DB::table('users')->pluck('id')->toArray();
                $userIds = array_values(array_unique(array_merge($userIds, $allUsers)));
            }

            foreach ($userIds as $userId) {
                // ۱. جایگزینی دلار (usd) با تتر (usdt)
                $hasUsdt = DB::table('display_items')
                    ->where('user_id', $userId)
                    ->where('key', 'usdt')
                    ->exists();

                $usdItem = DB::table('display_items')
                    ->where('user_id', $userId)
                    ->where('key', 'usd')
                    ->first();

                if ($usdItem) {
                    if ($hasUsdt) {
                        // حذف رکورد دلار و بروزرسانی رکورد تتر
                        DB::table('display_items')
                            ->where('id', $usdItem->id)
                            ->delete();

                        DB::table('display_items')
                            ->where('user_id', $userId)
                            ->where('key', 'usdt')
                            ->update([
                                'label' => 'تتر (دلار دیجیتال)',
                                'order' => min($usdItem->order, 8),
                                'updated_at' => $now,
                            ]);
                    } else {
                        // تغییر کلید usd به usdt
                        DB::table('display_items')
                            ->where('id', $usdItem->id)
                            ->update([
                                'key' => 'usdt',
                                'label' => 'تتر (دلار دیجیتال)',
                                'updated_at' => $now,
                            ]);
                    }
                } elseif ($hasUsdt) {
                    DB::table('display_items')
                        ->where('user_id', $userId)
                        ->where('key', 'usdt')
                        ->update([
                            'label' => 'تتر (دلار دیجیتال)',
                            'updated_at' => $now,
                        ]);
                } else {
                    DB::table('display_items')->insert([
                        'user_id'    => $userId,
                        'key'        => 'usdt',
                        'label'      => 'تتر (دلار دیجیتال)',
                        'enabled'    => true,
                        'order'      => 8,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }

                // ۲. جایگزینی یورو (euro) با نفت برنت (oil_brent)
                $hasOil = DB::table('display_items')
                    ->where('user_id', $userId)
                    ->where('key', 'oil_brent')
                    ->exists();

                $euroItem = DB::table('display_items')
                    ->where('user_id', $userId)
                    ->where('key', 'euro')
                    ->first();

                if ($euroItem) {
                    if ($hasOil) {
                        DB::table('display_items')->where('id', $euroItem->id)->delete();
                        DB::table('display_items')
                            ->where('user_id', $userId)
                            ->where('key', 'oil_brent')
                            ->update(['label' => 'نفت برنت', 'updated_at' => $now]);
                    } else {
                        DB::table('display_items')
                            ->where('id', $euroItem->id)
                            ->update([
                                'key'        => 'oil_brent',
                                'label'      => 'نفت برنت',
                                'updated_at' => $now,
                            ]);
                    }
                } elseif (!$hasOil) {
                    DB::table('display_items')->insert([
                        'user_id'    => $userId,
                        'key'        => 'oil_brent',
                        'label'      => 'نفت برنت',
                        'enabled'    => true,
                        'order'      => 9,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }

                // ۳. جایگزینی درهم (dirham) با انس جهانی نقره (silver_ounce)
                $hasSilver = DB::table('display_items')
                    ->where('user_id', $userId)
                    ->where('key', 'silver_ounce')
                    ->exists();

                $dirhamItem = DB::table('display_items')
                    ->where('user_id', $userId)
                    ->where('key', 'dirham')
                    ->first();

                if ($dirhamItem) {
                    if ($hasSilver) {
                        DB::table('display_items')->where('id', $dirhamItem->id)->delete();
                        DB::table('display_items')
                            ->where('user_id', $userId)
                            ->where('key', 'silver_ounce')
                            ->update(['label' => 'انس جهانی نقره', 'updated_at' => $now]);
                    } else {
                        DB::table('display_items')
                            ->where('id', $dirhamItem->id)
                            ->update([
                                'key'        => 'silver_ounce',
                                'label'      => 'انس جهانی نقره',
                                'updated_at' => $now,
                            ]);
                    }
                } elseif (!$hasSilver) {
                    DB::table('display_items')->insert([
                        'user_id'    => $userId,
                        'key'        => 'silver_ounce',
                        'label'      => 'انس جهانی نقره',
                        'enabled'    => true,
                        'order'      => 10,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }

                // ۴. افزودن مظنه جهانی طلا (global_mesghal)
                $hasGlobalMesghal = DB::table('display_items')
                    ->where('user_id', $userId)
                    ->where('key', 'global_mesghal')
                    ->exists();

                if (!$hasGlobalMesghal) {
                    DB::table('display_items')->insert([
                        'user_id'    => $userId,
                        'key'        => 'global_mesghal',
                        'label'      => 'مظنه جهانی طلا',
                        'enabled'    => true,
                        'order'      => 11,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }

                // پاکسازی هرگونه رکورد باقیمانده ارزهای سنتی برای این کاربر
                DB::table('display_items')
                    ->where('user_id', $userId)
                    ->whereIn('key', ['usd', 'euro', 'dirham'])
                    ->delete();

                // مرتب‌سازی مجدد شماره ترتیب (order)
                $items = DB::table('display_items')
                    ->where('user_id', $userId)
                    ->orderBy('order')
                    ->orderBy('id')
                    ->get();

                $seq = 1;
                foreach ($items as $itm) {
                    DB::table('display_items')
                        ->where('id', $itm->id)
                        ->update(['order' => $seq++]);
                }
            }

            // پاکسازی رکوردهای بدون user_id
            DB::table('display_items')
                ->whereNull('user_id')
                ->whereIn('key', ['usd', 'euro', 'dirham'])
                ->delete();

            // ۵. بروزرسانی و پاکسازی جدول کش بازار (market_cache)
            if (Schema::hasTable('market_cache')) {
                DB::table('market_cache')->whereIn('symbol', ['usd', 'euro', 'dirham'])->delete();

                $defaults = [
                    'oil_brent' => [
                        'value' => 98.32,
                        'unit'  => 'دلار',
                    ],
                    'silver_ounce' => [
                        'value' => 31.45,
                        'unit'  => 'دلار',
                    ],
                    'global_mesghal' => [
                        'value' => 26150000.00,
                        'unit'  => 'تومان',
                    ],
                ];

                foreach ($defaults as $sym => $meta) {
                    if (!DB::table('market_cache')->where('symbol', $sym)->exists()) {
                        DB::table('market_cache')->insert([
                            'symbol'         => $sym,
                            'value'          => $meta['value'],
                            'unit'           => $meta['unit'],
                            'change_value'   => 0,
                            'change_percent' => 0,
                            'direction'      => 'flat',
                            'is_stale'       => false,
                            'fetched_at'     => $now,
                            'created_at'     => $now,
                            'updated_at'     => $now,
                        ]);
                    }
                }
            }
        });
    }

    public function down(): void
    {
        // رول‌بک انجام نمی‌شود زیرا حذف ارزها دائمی و قانونی است
    }
};
