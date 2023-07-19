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
        Schema::create('T_PCHORDHEAD', function (Blueprint $table) {
            $table->string('TPCHORD_PCHCD', 25)->primary();
            $table->string('TPCHORD_ATTN');
            $table->string('TPCHORD_SUPCD', 10);
            $table->integer('TPCHORD_LINE');
            $table->string('TPCHORD_REMARK')->nullable();
            $table->date('TPCHORD_ISSUDT');
            $table->date('TPCHORD_DLVDT')->nullable();
            $table->string('TPCHORD_APPRVBY', 16)->nullable();
            $table->dateTime('TPCHORD_APPRVDT')->nullable();
            $table->string('TPCHORD_REJCTBY', 16)->nullable();
            $table->dateTime('TPCHORD_REJCTDT')->nullable();
            $table->string('TPCHORD_REQCD', 25);
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
        Schema::dropIfExists('T_PCHORDHEAD');
    }
};
