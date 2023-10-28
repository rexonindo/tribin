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
        Schema::table('C_SPK', function (Blueprint $table) {
            $table->string('CSPK_GA_SPV_APPROVED_BY', 16)->nullable();
            $table->string('CSPK_GA_MGR_APPROVED_BY', 16)->nullable();
            $table->string('CSPK_MECHANIC_LDR_APPROVED_BY', 16)->nullable();
            $table->dateTime('CSPK_GA_SPV_APPROVED_AT')->nullable();
            $table->dateTime('CSPK_GA_MGR_APPROVED_AT')->nullable();
            $table->dateTime('CSPK_MECHANIC_LDR_APPROVED_AT')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('C_SPK', function (Blueprint $table) {
            //
        });
    }
};
