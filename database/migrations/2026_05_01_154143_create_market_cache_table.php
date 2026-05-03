<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('market_cache', function (Blueprint $table) {
            $table->string('symbol')->primary();
            $table->decimal('value', 20, 2);
            $table->string('unit')->default('تومان');
            $table->decimal('change_value', 15, 2)->default(0);
            $table->decimal('change_percent', 8, 2)->default(0);
            $table->string('direction')->default('flat');
            $table->boolean('is_stale')->default(false);
            $table->timestamp('fetched_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_cache');
    }
};