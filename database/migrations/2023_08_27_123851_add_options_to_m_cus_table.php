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
            $table->string('MCUS_TYPE', 1);
            $table->string('MCUS_KTP_FILE', 100)->nullable();
            $table->string('MCUS_NPWP_FILE', 100)->nullable();
            $table->string('MCUS_NIB_FILE', 100)->nullable();
            $table->string('MCUS_GROUP', 70)->nullable();
            $table->string('MCUS_REFF_MKT', 70)->nullable();
            $table->string('MCUS_PIC_NAME', 70);
            $table->string('MCUS_PIC_TELNO', 20);
            $table->string('MCUS_EMAIL', 70)->nullable();
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
