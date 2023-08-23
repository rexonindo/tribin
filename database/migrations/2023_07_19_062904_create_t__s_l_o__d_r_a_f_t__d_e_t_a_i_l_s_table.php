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
        Schema::create('T_SLO_DRAFT_DETAIL', function (Blueprint $table) {
            $table->id();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
            $table->string('TSLODRAFTDETA_SLOCD', 25);
            $table->string('TSLODRAFTDETA_ITMCD', 25);
            $table->float('TSLODRAFTDETA_ITMQT');
            $table->float('TSLODRAFTDETA_ITMPRC_PER',18,2);
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
        Schema::dropIfExists('T_SLO_DRAFT_DETAIL');
    }
};
