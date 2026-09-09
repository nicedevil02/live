<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_slide', function (Blueprint $table) {
            $table->unsignedBigInteger('labor_fee')->default(0)->change();
            $table->unsignedBigInteger('base_gold_price')->default(0)->change();
            $table->unsignedBigInteger('final_price')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('product_slide', function (Blueprint $table) {
            $table->integer('labor_fee')->default(0)->change();
            $table->integer('base_gold_price')->default(0)->change();
            $table->integer('final_price')->default(0)->change();
        });
    }
};
