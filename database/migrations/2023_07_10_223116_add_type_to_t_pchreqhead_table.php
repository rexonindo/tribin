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
            $table->string('TPCHREQ_TYPE',1)->nullable()->after('TPCHREQ_PURPOSE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('T_PCHREQHEAD', function (Blueprint $table) {
            //
        });
    }
};
