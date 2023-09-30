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
        Schema::create('C_SPK', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('created_by', 16);
            $table->string('updated_by', 16)->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by', 16)->nullable();
            $table->string('CSPK_BRANCH', 3);
            $table->string('CSPK_PIC_AS', 45);
            $table->string('CSPK_PIC_NAME', 45);
            $table->string('CSPK_REFF_DOC', 45);
            $table->float('CSPK_KM');
            $table->integer('CSPK_WHEELS');
            $table->float('CSPK_UANG_JALAN', 18, 2);
            $table->string('CSPK_SUPPLIER', 20);
            $table->float('CSPK_LITER', 18, 2);
            $table->float('CSPK_UANG_SOLAR', 18, 2);
            $table->float('CSPK_UANG_MAKAN', 18, 2);
            $table->float('CSPK_UANG_MANDAH', 18, 2);
            $table->float('CSPK_UANG_PENGINAPAN', 18, 2);
            $table->float('CSPK_UANG_PENGAWALAN', 18, 2);
            $table->float('CSPK_UANG_LAIN2', 18, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('C_SPK');
    }
};
