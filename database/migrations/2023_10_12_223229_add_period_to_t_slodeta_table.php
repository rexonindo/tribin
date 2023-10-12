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
        Schema::table('T_SLODETA', function (Blueprint $table) {
            $table->dateTime('TSLODETA_PERIOD_FR')->nullable();
            $table->dateTime('TSLODETA_PERIOD_TO')->nullable();
            $table->string('TSLODETA_USAGE_DESCRIPTION', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('T_SLODETA', function (Blueprint $table) {
            //
        });
    }
};
