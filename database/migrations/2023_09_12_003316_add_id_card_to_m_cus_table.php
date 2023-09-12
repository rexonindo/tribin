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
        Schema::table('M_CUS', function (Blueprint $table) {
            $table->string('MCUS_IDCARD', 25)->nullable();
            $table->integer('MCUS_GENID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('M_CUS', function (Blueprint $table) {
            //
        });
    }
};
