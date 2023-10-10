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
        Schema::table('T_SLOHEAD', function (Blueprint $table) {
            $table->date('TSLO_PERIOD_FR')->nullable();
            $table->date('TSLO_PERIOD_TO')->nullable();
            $table->string('TSLO_USAGE_DESCRIPTION', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('T_SLOHEAD', function (Blueprint $table) {
            //
        });
    }
};
