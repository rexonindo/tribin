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
        Schema::create('branch_payment_accounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('connection', 45);
            $table->string('BRANCH', 3);
            $table->string('bank_name', 75);
            $table->string('bank_account_name', 75);
            $table->string('bank_account_number', 75);
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
        Schema::dropIfExists('branch_payment_accounts');
    }
};
