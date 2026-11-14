<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('display_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('display_settings', 'hide_showcase')) {
                $table->boolean('hide_showcase')->default(false);
            }
            if (!Schema::hasColumn('display_settings', 'auto_theme_enabled')) {
                $table->boolean('auto_theme_enabled')->default(false);
            }
            if (!Schema::hasColumn('display_settings', 'day_theme_mode')) {
                $table->string('day_theme_mode', 40)->default('light-modern');
            }
            if (!Schema::hasColumn('display_settings', 'night_theme_mode')) {
                $table->string('night_theme_mode', 40)->default('imperial-onyx');
            }
            if (!Schema::hasColumn('display_settings', 'day_start_time')) {
                $table->string('day_start_time', 5)->default('07:00');
            }
            if (!Schema::hasColumn('display_settings', 'night_start_time')) {
                $table->string('night_start_time', 5)->default('18:30');
            }
            if (!Schema::hasColumn('display_settings', 'footer_ticker_text')) {
                $table->string('footer_ticker_text', 300)->nullable();
            }
        });
    }

    public function down(): void
    {
        $cols = [
            'hide_showcase',
            'auto_theme_enabled',
            'day_theme_mode',
            'night_theme_mode',
            'day_start_time',
            'night_start_time',
            'footer_ticker_text',
        ];
        foreach ($cols as $col) {
            if (Schema::hasColumn('display_settings', $col)) {
                Schema::table('display_settings', function (Blueprint $table) use ($col) {
                    $table->dropColumn($col);
                });
            }
        }
    }
};
