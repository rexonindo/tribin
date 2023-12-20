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
        Schema::create('T_RCV_HEAD', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
            $table->string('updated_by', 16)->nullable();
            $table->string('TRCV_RCVCD', 50);
            $table->string('TRCV_BRANCH', 3);
            $table->string('TRCV_SUPCD', 10);
            $table->date('TRCV_ISSUDT');
            $table->dateTime('TRCV_SUBMITTED_AT')->nullable();
            $table->string('TRCV_SUBMITTED_BY', 16)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('T_RCV_HEAD');
    }
};
