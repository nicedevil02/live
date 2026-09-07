<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('api_source_config', function (Blueprint $table) {
            $table->text('last_logs')->nullable()->after('last_error');
        });
    }

    public function down(): void
    {
        Schema::table('api_source_config', function (Blueprint $table) {
            $table->dropColumn('last_logs');
        });
    }
};
