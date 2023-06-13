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
        Schema::create('M_ITM', function (Blueprint $table) {
            $table->string('MITM_ITMCD',25)->primary();
            $table->string('MITM_ITMNM',50);
            $table->string('MITM_ITMTYPE',2)->default('1');
            $table->string('MITM_STKUOM',15);
            $table->string('MITM_BRAND',45)->nullable();
            $table->string('MITM_MODEL',45);
            $table->string('MITM_SPEC',50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('M_ITM');
    }
};
