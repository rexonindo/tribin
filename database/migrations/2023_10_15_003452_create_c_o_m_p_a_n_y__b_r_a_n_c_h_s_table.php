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
        Schema::create('COMPANY_BRANCHES', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 65);
            $table->string('address', 200);
            $table->string('connection', 45);
            $table->string('phone', 45);
            $table->string('fax', 45);
            $table->string('invoice_letter_id', 45);
            $table->string('created_by', 16);
            $table->string('updated_by', 16)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('COMPANY_BRANCHES');
    }
};
