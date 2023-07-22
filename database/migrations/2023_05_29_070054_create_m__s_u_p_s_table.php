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
        Schema::create('M_SUP', function (Blueprint $table) {
            $table->string('MSUP_SUPCD', 10)->primary();
            $table->string('MSUP_CURCD', 3);
            $table->string('MSUP_SUPNM', 50);
            $table->string('MSUP_TAXREG', 25)->nullable();
            $table->string('MSUP_ADDR1', 50);
            $table->string('MSUP_TELNO', 20);
            $table->string('created_by', 16);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('M_SUP');
    }
};
