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
        Schema::table('M_CONDITIONS', function (Blueprint $table) {
            $table->string('MCONDITION_BRANCH', 3)->nullable();
            $table->integer('MCONDITION_ORDER_NUMBER')->nullable();
            $table->string('created_by', 16)->nullable();
            $table->string('updated_by', 16)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('M_CONDITIONS', function (Blueprint $table) {
            //
        });
    }
};
