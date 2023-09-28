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
        Schema::create('C_CASHIER', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('created_by', 16);
            $table->string('updated_by', 16)->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
            $table->string('CCASHIER_BRANCH', 3);
            $table->date('CCASHIER_ISSUDT');
            $table->string('CCASHIER_ITMCD', 45);
            $table->string('CCASHIER_LOCATION', 9);
            $table->float('CCASHIER_PRICE', 18, 2);
            $table->string('CCASHIER_REFF_DOC', 45);
            $table->string('CCASHIER_REMARK', 45);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('C_CASHIER');
    }
};
