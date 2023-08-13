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
        Schema::table('T_PCHORDDETA', function (Blueprint $table) {
            $table->string('TPCHORDDETA_BRANCH', 3)->after('TPCHORDDETA_PCHCD');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('T_PCHORDDETA', function (Blueprint $table) {
            //
        });
    }
};
