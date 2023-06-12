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
            $table->dateTime('TSLO_PLAN_DLVDT')->nullable()->after('TSLO_ISSUDT');
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
