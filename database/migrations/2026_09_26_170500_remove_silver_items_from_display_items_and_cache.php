<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('display_items')) {
            DB::table('display_items')->whereIn('key', ['silver999', 'silver925'])->delete();
        }

        if (Schema::hasTable('market_cache')) {
            DB::table('market_cache')->whereIn('symbol', ['silver999', 'silver925'])->delete();
        }
    }

    public function down(): void
    {
        // No-op: removed permanently per design directive
    }
};
