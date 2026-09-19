<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'city_slug')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('city_slug', 50)->nullable()->after('display_token');
                $table->string('city_name', 100)->nullable()->after('city_slug');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'city_slug')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['city_slug', 'city_name']);
            });
        }
    }
};
