<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ۱. دریافت تمام شناسه‌های یکتای کاربران دارای ردیف‌های نمایشی
        $userIds = DB::table('display_items')->select('user_id')->distinct()->pluck('user_id');

        foreach ($userIds as $userId) {
            // به‌روزرسانی برچسب مثقال ۱۷ به «آبشده»
            DB::table('display_items')
                ->where('user_id', $userId)
                ->where('key', 'mesghal17')
                ->update(['label' => 'آبشده']);

            // به‌روزرسانی برچسب انس جهانی به «انس جهانی طلا»
            DB::table('display_items')
                ->where('user_id', $userId)
                ->where('key', 'ounce')
                ->update(['label' => 'انس جهانی طلا']);

            // جابجایی ۱: جای آبشده (mesghal17) با کارت نفت برنت (oil_brent)
            $mesghal = DB::table('display_items')->where('user_id', $userId)->where('key', 'mesghal17')->first();
            $oil = DB::table('display_items')->where('user_id', $userId)->where('key', 'oil_brent')->first();
            if ($mesghal && $oil && $mesghal->order !== $oil->order) {
                $orderM = $mesghal->order;
                $orderO = $oil->order;
                DB::table('display_items')->where('id', $mesghal->id)->update(['order' => $orderO]);
                DB::table('display_items')->where('id', $oil->id)->update(['order' => $orderM]);
            }

            // جابجایی ۲: جای سکه گرمی (coin_gerami) با بیت‌کوین (bitcoin)
            $gerami = DB::table('display_items')->where('user_id', $userId)->where('key', 'coin_gerami')->first();
            $btc = DB::table('display_items')->where('user_id', $userId)->where('key', 'bitcoin')->first();
            if ($gerami && $btc && $gerami->order !== $btc->order) {
                $orderG = $gerami->order;
                $orderB = $btc->order;
                DB::table('display_items')->where('id', $gerami->id)->update(['order' => $orderB]);
                DB::table('display_items')->where('id', $btc->id)->update(['order' => $orderG]);
            }

            // جابجایی ۳: جای انس نقره (silver_ounce) با انس جهانی طلا (ounce)
            $silver = DB::table('display_items')->where('user_id', $userId)->where('key', 'silver_ounce')->first();
            $ounce = DB::table('display_items')->where('user_id', $userId)->where('key', 'ounce')->first();
            if ($silver && $ounce && $silver->order !== $ounce->order) {
                $orderS = $silver->order;
                $orderOun = $ounce->order;
                DB::table('display_items')->where('id', $silver->id)->update(['order' => $orderOun]);
                DB::table('display_items')->where('id', $ounce->id)->update(['order' => $orderS]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $userIds = DB::table('display_items')->select('user_id')->distinct()->pluck('user_id');

        foreach ($userIds as $userId) {
            DB::table('display_items')
                ->where('user_id', $userId)
                ->where('key', 'mesghal17')
                ->update(['label' => 'مثقال ۱۷']);

            DB::table('display_items')
                ->where('user_id', $userId)
                ->where('key', 'ounce')
                ->update(['label' => 'انس جهانی']);

            // معکوس‌سازی جابجایی‌ها
            $mesghal = DB::table('display_items')->where('user_id', $userId)->where('key', 'mesghal17')->first();
            $oil = DB::table('display_items')->where('user_id', $userId)->where('key', 'oil_brent')->first();
            if ($mesghal && $oil) {
                $orderM = $mesghal->order;
                $orderO = $oil->order;
                DB::table('display_items')->where('id', $mesghal->id)->update(['order' => $orderO]);
                DB::table('display_items')->where('id', $oil->id)->update(['order' => $orderM]);
            }

            $gerami = DB::table('display_items')->where('user_id', $userId)->where('key', 'coin_gerami')->first();
            $btc = DB::table('display_items')->where('user_id', $userId)->where('key', 'bitcoin')->first();
            if ($gerami && $btc) {
                $orderG = $gerami->order;
                $orderB = $btc->order;
                DB::table('display_items')->where('id', $gerami->id)->update(['order' => $orderB]);
                DB::table('display_items')->where('id', $btc->id)->update(['order' => $orderG]);
            }

            $silver = DB::table('display_items')->where('user_id', $userId)->where('key', 'silver_ounce')->first();
            $ounce = DB::table('display_items')->where('user_id', $userId)->where('key', 'ounce')->first();
            if ($silver && $ounce) {
                $orderS = $silver->order;
                $orderOun = $ounce->order;
                DB::table('display_items')->where('id', $silver->id)->update(['order' => $orderOun]);
                DB::table('display_items')->where('id', $ounce->id)->update(['order' => $orderS]);
            }
        }
    }
};
