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
        Schema::table('M_COA', function (Blueprint $table) {
            $table->dropPrimary();
            $table->string('MCOA_BRANCH', 3)->after('MCOA_COANM');
            $table->unique(['MCOA_COACD', 'MCOA_BRANCH']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('M_COA', function (Blueprint $table) {
            //
        });
    }
};
