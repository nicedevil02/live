<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_slide', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->float('weight_gram');
            $table->integer('labor_fee');
            $table->float('profit_value');
            $table->string('profit_type'); // percent / amount
            $table->integer('base_gold_price');
            $table->integer('final_price');
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_slide');
    }
};