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
        Schema::table('T_SLO_DRAFT_DETAIL', function (Blueprint $table) {
            $table->string('TSLODRAFTDETA_BRANCH', 3)->after('TSLODRAFTDETA_SLOCD');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('T_SLO_DRAFT_DETAIL', function (Blueprint $table) {
            //
        });
    }
};
