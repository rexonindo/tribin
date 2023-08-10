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
        Schema::table('T_SLOHEAD', function (Blueprint $table) {
            $table->dropPrimary();
            $table->string('TSLO_BRANCH', 3)->after('TSLO_SLOCD');
            $table->unique(['TSLO_SLOCD', 'TSLO_BRANCH']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('T_SLOHEAD', function (Blueprint $table) {
            //
        });
    }
};
