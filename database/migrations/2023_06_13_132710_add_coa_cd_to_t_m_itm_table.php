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
        Schema::table('M_ITM', function (Blueprint $table) {
            $table->string('MITM_COACD',10)->nullable()->after('MITM_ITMCAT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('M_ITM', function (Blueprint $table) {
            //
        });
    }
};
