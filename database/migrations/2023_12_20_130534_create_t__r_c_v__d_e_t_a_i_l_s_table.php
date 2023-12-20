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
        Schema::create('T_RCV_DETAIL', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
            $table->string('updated_by', 16)->nullable();
            $table->unsignedBigInteger('id_header');
            $table->string('branch', 3);
            $table->string('po_number', 25);
            $table->string('item_code', 25);
            $table->float('quantity');
            $table->float('unit_price', 18, 2);

            $table->foreign('id_header')->references('id')->on('T_RCV_HEAD');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('T_RCV_DETAIL');
    }
};
