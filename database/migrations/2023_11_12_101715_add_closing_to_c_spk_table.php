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
        Schema::table('C_SPK', function (Blueprint $table) {
            $table->string('closed_by', 16)->nullable();
            $table->dateTime('closed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('C_SPK', function (Blueprint $table) {
            //
        });
    }
};
