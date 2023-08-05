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
            $table->dropPrimary();
            $table->string('MCUS_BRANCH', 3)->after('MCUS_CGCON');
            $table->unique(['MCUS_CUSCD', 'MCUS_BRANCH']);
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
