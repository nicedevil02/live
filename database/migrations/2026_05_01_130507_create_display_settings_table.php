<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('display_settings', function (Blueprint $table) {
            $table->id();
            $table->string('theme_mode')->default('auto');
            $table->integer('slider_interval_sec')->default(8);
            $table->boolean('show_weight')->default(true);
            $table->boolean('show_labor')->default(true);
            $table->boolean('show_profit')->default(true);
            $table->string('shop_name')->default('گالری طلای سجاد');
            $table->string('phone')->default('');
            $table->string('instagram')->default('');
            $table->string('rubika')->default('');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        $now = now()->toDateTimeString();
        DB::table('display_settings')->insert([
            'id' => 1,
            'theme_mode' => 'auto',
            'slider_interval_sec' => 8,
            'show_weight' => true,
            'show_labor' => true,
            'show_profit' => true,
            'shop_name' => 'گالری طلای سجاد',
            'phone' => '',
            'instagram' => '',
            'rubika' => '',
            'published_at' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('display_settings');
    }
};