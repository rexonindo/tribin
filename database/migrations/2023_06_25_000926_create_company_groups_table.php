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
        Schema::create('COMPANY_GROUPS', function (Blueprint $table) {
            $table->id();
            $table->string('name', 65);
            $table->string('address', 200);
            $table->string('connection', 45);
            $table->string('phone', 45);
            $table->string('fax', 45);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('COMPANY_GROUPS');
    }
};
