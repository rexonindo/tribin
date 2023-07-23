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
        Schema::create('T_PCHREQDETA', function (Blueprint $table) {
            $table->id();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
            $table->string('TPCHREQDETA_PCHCD', 25);
            $table->string('TPCHREQDETA_ITMCD', 25);
            $table->float('TPCHREQDETA_ITMQT');
            $table->date('TPCHREQDETA_REQDT');
            $table->string('TPCHREQDETA_REMARK')->nullable();
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
        Schema::dropIfExists('T_PCHREQDETA');
    }
};
