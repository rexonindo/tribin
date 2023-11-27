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
        Schema::create('T_SLOHEAD', function (Blueprint $table) {
            $table->string('TSLO_SLOCD', 25)->primary();
            $table->string('TSLO_CUSCD', 10);
            $table->integer('TSLO_LINE');
            $table->string('TSLO_ATTN', 100);
            $table->string('TSLO_QUOCD', 25);
            $table->string('TSLO_POCD', 50);
            $table->date('TSLO_ISSUDT');
            $table->string('TSLO_APPRVBY', 16)->nullable();
            $table->dateTime('TSLO_APPRVDT')->nullable();
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
        Schema::dropIfExists('T_SLOHEAD');
    }
};
