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
        Schema::create('M_CUS', function (Blueprint $table) {
            $table->string('MCUS_CUSCD', 10)->primary();
            $table->string('MCUS_CURCD', 3);
            $table->string('MCUS_CUSNM', 50);
            $table->string('MCUS_TAXREG', 25);
            $table->string('MCUS_ADDR1', 100);
            $table->string('MCUS_TELNO', 20);
            $table->string('created_by', 16);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('M_CUS');
    }
};
