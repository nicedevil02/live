<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('market_daily_candles')) {
            Schema::create('market_daily_candles', function (Blueprint $table) {
                $table->id();
                $table->string('symbol', 40);
                $table->date('trade_date');
                $table->string('jalali_date', 16)->nullable();
                $table->decimal('open_price', 20, 2);
                $table->decimal('high_price', 20, 2);
                $table->decimal('low_price', 20, 2);
                $table->decimal('close_price', 20, 2);
                $table->timestamps();

                $table->unique(['symbol', 'trade_date']);
                $table->index(['symbol', 'trade_date']);
            });
        }

        if (!Schema::hasTable('market_price_points')) {
            Schema::create('market_price_points', function (Blueprint $table) {
                $table->id();
                $table->string('symbol', 40);
                $table->decimal('price', 20, 2);
                $table->timestamp('recorded_at');

                $table->index(['symbol', 'recorded_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('market_price_points');
        Schema::dropIfExists('market_daily_candles');
    }
};
