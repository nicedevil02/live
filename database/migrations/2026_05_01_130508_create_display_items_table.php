<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('display_items', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->boolean('enabled')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        $now = now()->toDateTimeString();
        $items = [
            ['key' => 'gold18', 'label' => 'طلای ۱۸ عیار', 'order' => 1],
            ['key' => 'buy_gold', 'label' => 'گرم خرید ۱۸ عیار', 'order' => 2],
            ['key' => 'gold24', 'label' => 'طلای ۲۴ عیار', 'order' => 3],
            ['key' => 'coin_emami', 'label' => 'سکه امامی', 'order' => 4],
            ['key' => 'coin_bahar', 'label' => 'سکه بهار آزادی', 'order' => 5],
            ['key' => 'coin_nim', 'label' => 'نیم سکه', 'order' => 6],
            ['key' => 'coin_rob', 'label' => 'ربع سکه', 'order' => 7],
            ['key' => 'usd', 'label' => 'دلار', 'order' => 8],
            ['key' => 'euro', 'label' => 'یورو', 'order' => 9],
            ['key' => 'dirham', 'label' => 'درهم', 'order' => 10],
            ['key' => 'bitcoin', 'label' => 'بیت کوین', 'order' => 11],
            ['key' => 'ounce', 'label' => 'انس جهانی', 'order' => 12],
            ['key' => 'mesghal17', 'label' => 'مثقال ۱۷', 'order' => 13],
            ['key' => 'coin_gerami', 'label' => 'سکه گرمی', 'order' => 14],
            ['key' => 'usdt', 'label' => 'تتر', 'order' => 15],
        ];

        foreach ($items as $item) {
            DB::table('display_items')->insert(array_merge($item, [
                'enabled' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('display_items');
    }
};
