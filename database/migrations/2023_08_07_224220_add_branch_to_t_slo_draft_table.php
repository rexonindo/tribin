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
        Schema::table('T_SLO_DRAFT_HEAD', function (Blueprint $table) {
            $table->dropPrimary();
            $table->string('TSLODRAFT_BRANCH', 3)->after('TSLODRAFT_SLOCD');
            $table->unique(['TSLODRAFT_SLOCD', 'TSLODRAFT_BRANCH']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('T_SLO_DRAFT_HEAD', function (Blueprint $table) {
            //
        });
    }
};
