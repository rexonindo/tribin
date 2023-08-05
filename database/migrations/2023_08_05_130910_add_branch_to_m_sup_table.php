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
        Schema::table('M_SUP', function (Blueprint $table) {
            $table->dropPrimary();
            $table->string('MSUP_BRANCH', 3)->after('MSUP_CGCON');
            $table->unique(['MSUP_SUPCD', 'MSUP_BRANCH']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('M_SUP', function (Blueprint $table) {
            //
        });
    }
};
