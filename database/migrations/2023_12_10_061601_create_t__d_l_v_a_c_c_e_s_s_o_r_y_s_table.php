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
        Schema::create('T_DLVACCESSORY', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('created_by', 16);
            $table->string('updated_by', 16)->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
            $table->string('TDLVACCESSORY_DLVCD', 15);
            $table->string('TDLVACCESSORY_BRANCH', 3);
            $table->string('TDLVACCESSORY_ITMCD', 25);
            $table->float('TDLVACCESSORY_ITMQT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('T_DLVACCESSORY');
    }
};
