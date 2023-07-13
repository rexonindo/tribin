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
            $table->string('MSUP_CGCON',45)->nullable()->after('MSUP_TELNO');
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
