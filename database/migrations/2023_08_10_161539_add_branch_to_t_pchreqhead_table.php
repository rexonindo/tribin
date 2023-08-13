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
        Schema::table('T_PCHREQHEAD', function (Blueprint $table) {
            $table->dropPrimary();
            $table->string('TPCHREQ_BRANCH', 3)->after('TPCHREQ_PCHCD');
            $table->unique(['TPCHREQ_PCHCD', 'TPCHREQ_BRANCH']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_pchreqhead', function (Blueprint $table) {
            //
        });
    }
};
