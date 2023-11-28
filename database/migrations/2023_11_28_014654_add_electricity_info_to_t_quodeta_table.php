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
        Schema::table('T_QUODETA', function (Blueprint $table) {
            $table->string('TQUODETA_ELECTRICITY', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('T_QUODETA', function (Blueprint $table) {
            //
        });
    }
};
