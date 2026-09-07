<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('display_settings', function (Blueprint $table) {
            $table->string('qr_desc')->nullable()->after('qr_label');
        });
    }

    public function down(): void
    {
        Schema::table('display_settings', function (Blueprint $table) {
            $table->dropColumn(['qr_desc']);
        });
    }
};
