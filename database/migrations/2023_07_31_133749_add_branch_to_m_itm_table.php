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
        Schema::table('M_ITM', function (Blueprint $table) {
            $table->dropPrimary();
            $table->string('MITM_BRANCH', 3)->after('MITM_ITMCAT');
            $table->unique(['MITM_ITMCD', 'MITM_BRANCH']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('M_ITM', function (Blueprint $table) {
            //
        });
    }
};
