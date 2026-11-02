<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('display_settings', 'show_weather')) {
            Schema::table('display_settings', function (Blueprint $table) {
                $table->boolean('show_weather')->default(true);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('display_settings', 'show_weather')) {
            Schema::table('display_settings', function (Blueprint $table) {
                $table->dropColumn('show_weather');
            });
        }
    }
};
