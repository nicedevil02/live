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
        Schema::table('tv_devices', function (Blueprint $table) {
            $table->string('render_mode', 32)->nullable()->after('webview_version');
            $table->string('fallback_reason', 64)->nullable()->after('render_mode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tv_devices', function (Blueprint $table) {
            $table->dropColumn(['render_mode', 'fallback_reason']);
        });
    }
};
