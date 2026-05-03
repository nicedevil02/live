<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formula_config', function (Blueprint $table) {
            $table->id(); // فقط یک رکورد با id=1
            $table->float('buy_multiplier_a')->default(740);
            $table->float('buy_divisor_b')->default(750);
            $table->timestamps();
        });

        // رکورد پیش‌فرض
        DB::table('formula_config')->insert([
            'id' => 1,
            'buy_multiplier_a' => 740,
            'buy_divisor_b' => 750,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('formula_config');
    }
};