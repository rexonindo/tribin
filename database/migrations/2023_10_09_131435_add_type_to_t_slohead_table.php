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
            $table->string('TSLO_TYPE', 1);
            $table->float('TSLO_SERVTRANS_COST', 18, 2)->nullable();
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
