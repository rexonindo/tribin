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
        Schema::table('C_ITRN', function (Blueprint $table) {
            $table->float('CITRN_PRCPER', 18, 2)->change();
            $table->float('CITRN_PRCAMT', 18, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('C_ITRN', function (Blueprint $table) {
            //
        });
    }
};
