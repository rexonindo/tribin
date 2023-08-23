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
            $table->string('TQUO_TYPE', 1);
            $table->float('TQUO_SERVTRANS_COST', 18, 2)->nullable();
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
