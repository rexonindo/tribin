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
        Schema::create('T_DLVORDDETA', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('created_by', 16);
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
            $table->string('TDLVORDDETA_DLVCD', 15);
            $table->string('TDLVORDDETA_BRANCH', 3);
            $table->string('TDLVORDDETA_ITMCD', 25);
            $table->float('TDLVORDDETA_ITMQT');
            $table->float('TDLVORDDETA_PRC',10,2);
            $table->string('updated_by', 16)->nullable();
            $table->string('TDLVORDDETA_SLOCD', 25);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('T_DLVORDDETA');
    }
};
