<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('display_settings')) {
            DB::table('display_settings')->update(['theme_mode' => 'light-modern']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Do not revert automatically to preserve user choice
    }
};
