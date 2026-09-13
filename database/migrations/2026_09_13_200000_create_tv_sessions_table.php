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
        if (!Schema::hasTable('tv_sessions')) {
            Schema::create('tv_sessions', function (Blueprint $table) {
                $table->id();
                $table->string('session_code', 100)->unique()->index();
                $table->string('activation_code', 10)->index();
                $table->unsignedBigInteger('paired_user_id')->nullable()->index();
                $table->string('paired_username', 100)->nullable();
                $table->string('paired_token', 255)->nullable();
                $table->boolean('is_paired')->default(false)->index();
                $table->timestamp('expires_at')->nullable()->index();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tv_sessions');
    }
};
