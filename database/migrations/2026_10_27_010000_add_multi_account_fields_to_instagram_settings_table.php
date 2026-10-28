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
        Schema::table('instagram_settings', function (Blueprint $table) {
            $table->string('label', 60)->nullable()->after('username');
            $table->unsignedInteger('sort_order')->default(0)->after('is_active');
            $table->unique('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instagram_settings', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn(['label', 'sort_order']);
        });
    }
};
