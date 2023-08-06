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
        Schema::table('T_QUOHEAD', function (Blueprint $table) {
            $table->dropPrimary();
            $table->string('TQUO_BRANCH', 3)->after('TQUO_REJCTDT');
            $table->unique(['TQUO_QUOCD', 'TQUO_BRANCH']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('T_QUOHEAD', function (Blueprint $table) {
            //
        });
    }
};
