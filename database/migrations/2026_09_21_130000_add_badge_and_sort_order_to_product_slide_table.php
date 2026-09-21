<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_slide', function (Blueprint $table) {
            $table->string('badge')->nullable()->after('final_price');
            $table->unsignedInteger('sort_order')->default(0)->after('badge');
        });
    }

    public function down(): void
    {
        Schema::table('product_slide', function (Blueprint $table) {
            $table->dropColumn(['badge', 'sort_order']);
        });
    }
};
