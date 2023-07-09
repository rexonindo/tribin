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
        Schema::create('T_PCHREQHEAD', function (Blueprint $table) {
            $table->string('TPCHREQ_PCHCD', 25)->primary();
            $table->string('TPCHREQ_PURPOSE');
            $table->integer('TPCHREQ_LINE');
            $table->string('TPCHREQ_REMARK')->nullable();
            $table->date('TPCHREQ_ISSUDT');
            $table->string('TPCHREQ_APPRVBY', 16)->nullable();
            $table->dateTime('TPCHREQ_APPRVDT')->nullable();
            $table->string('TPCHREQ_REJCTBY', 16)->nullable();
            $table->dateTime('TPCHREQ_REJCTDT')->nullable();
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
        Schema::dropIfExists('T_PCHREQHEAD');
    }
};
