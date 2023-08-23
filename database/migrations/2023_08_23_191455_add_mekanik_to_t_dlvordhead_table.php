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
        Schema::table('T_DLVORDHEAD', function (Blueprint $table) {
            $table->string('TDLVORD_MEKANIK', 45)->nullable();
            $table->float('TDLVORD_JALAN_COST', 18, 2)->nullable();
            $table->string('TDLVORD_VEHICLE_REGNUM', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('T_DLVORDHEAD', function (Blueprint $table) {
            //
        });
    }
};
