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
        Schema::table('T_PCHORDHEAD', function (Blueprint $table) {
            $table->dropPrimary();
            $table->string('TPCHORD_BRANCH', 3)->after('TPCHORD_PCHCD');
            $table->unique(['TPCHORD_PCHCD', 'TPCHORD_BRANCH']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('T_PCHORDHEAD', function (Blueprint $table) {
            //
        });
    }
};
