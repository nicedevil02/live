<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('api_source_config')->where('key', 'market')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed as we want it permanently removed.
    }
};
