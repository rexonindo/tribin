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
        Schema::create('T_QUOHEAD', function (Blueprint $table) {
            $table->string('TQUO_QUOCD', 25)->primary();
            $table->string('TQUO_CUSCD', 10);
            $table->integer('TQUO_LINE');
            $table->string('TQUO_ATTN', 100);
            $table->string('TQUO_SBJCT', 100);
            $table->date('TQUO_ISSUDT');
            $table->string('TQUO_APPRVBY', 16)->nullable();
            $table->dateTime('TQUO_APPRVDT')->nullable();
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
        Schema::dropIfExists('T_QUOHEAD');
    }
};
