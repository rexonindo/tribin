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
        Schema::create('C_ITRN', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('CITRN_BRANCH', 3);
            $table->string('CITRN_LOCCD', 7);
            $table->string('CITRN_DOCNO', 45);
            $table->date('CITRN_ISSUDT', 45);
            $table->string('CITRN_FORM', 15);
            $table->string('CITRN_ITMCD', 25);
            $table->float('CITRN_ITMQT');
            $table->float('CITRN_PRCPER');
            $table->float('CITRN_PRCAMT');
            $table->string('created_by', 16);
            $table->string('updated_by', 16)->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('C_ITRN');
    }
};
