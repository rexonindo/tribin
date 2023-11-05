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
        Schema::table('COMPANY_BRANCHES', function (Blueprint $table) {
            $table->string('letter_head', 55);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('COMPANY_BRANCHES', function (Blueprint $table) {
            //
        });
    }
};
