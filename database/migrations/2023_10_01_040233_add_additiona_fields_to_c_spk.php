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
            $table->float('CSPK_LITER_EXISTING');
            $table->string('CSPK_DOCNO', 45);
            $table->integer('CSPK_DOCNO_ORDER');
            $table->dateTime('CSPK_LEAVEDT')->nullable();
            $table->dateTime('CSPK_BACKDT')->nullable();
            $table->string('CSPK_VEHICLE_TYPE', 35);
            $table->string('CSPK_JOBDESK', 70);
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
