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
        Schema::create('M_USAGE', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('created_by', 16);
            $table->string('updated_by', 16)->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
            $table->string('MUSAGE_BRANCH', 3);
            $table->string('MUSAGE_CD', 2);
            $table->string('MUSAGE_ALIAS', 15);
            $table->string('MUSAGE_DESCRIPTION', 45);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('M_USAGE');
    }
};
