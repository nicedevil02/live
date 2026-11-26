<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('market_hourly_points')) {
            Schema::create('market_hourly_points', function (Blueprint $table) {
                $table->id();
                $table->string('symbol', 40);
                $table->timestamp('bucket_at');
                $table->decimal('price', 20, 2);

                $table->unique(['symbol', 'bucket_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('market_hourly_points');
    }
};
