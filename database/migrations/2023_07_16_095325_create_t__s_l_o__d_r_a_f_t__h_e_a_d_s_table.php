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
        Schema::create('T_SLO_DRAFT_HEAD', function (Blueprint $table) {
            $table->string('TSLODRAFT_SLOCD', 25)->primary();
            $table->string('TSLODRAFT_CUSCD', 10);
            $table->integer('TSLODRAFT_LINE');
            $table->string('TSLODRAFT_ATTN', 100);            
            $table->string('TSLODRAFT_POCD', 50);
            $table->date('TSLODRAFT_ISSUDT');
            $table->string('TSLODRAFT_APPRVBY', 16)->nullable();
            $table->dateTime('TSLODRAFT_APPRVDT')->nullable();
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
        Schema::dropIfExists('T_SLO_DRAFT_HEAD');
    }
};
