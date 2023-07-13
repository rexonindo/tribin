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
        Schema::create('M_PCHREQTYPE', function (Blueprint $table) {
            $table->string('MPCHREQTYPE_ID', 1)->primary();
            $table->string('MPCHREQTYPE_NAME', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('M_PCHREQTYPE');
    }
};
