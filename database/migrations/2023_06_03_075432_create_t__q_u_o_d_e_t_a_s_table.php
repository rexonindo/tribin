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
        Schema::create('T_QUODETA', function (Blueprint $table) {
            $table->id();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
            $table->string('TQUODETA_QUOCD', 25);
            $table->string('TQUODETA_ITMCD', 25);
            $table->float('TQUODETA_ITMQT');
            $table->float('TQUODETA_USAGE');
            $table->float('TQUODETA_PRC',18,2);
            $table->float('TQUODETA_OPRPRC',18,2);
            $table->float('TQUODETA_MOBDEMOB',18,2);
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
        Schema::dropIfExists('T_QUODETA');
    }
};
