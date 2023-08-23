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
        Schema::create('T_PCHORDDETA', function (Blueprint $table) {
            $table->id();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
            $table->string('TPCHORDDETA_PCHCD', 25);
            $table->string('TPCHORDDETA_ITMCD', 25);
            $table->float('TPCHORDDETA_ITMQT');
            $table->float('TPCHORDDETA_ITMPRC_PER', 18, 2);
            $table->string('created_by', 16);
            $table->string('updated_by', 16)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('T_PCHORDDETA');
    }
};
