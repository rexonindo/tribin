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
        Schema::create('T_DLVORDHEAD', function (Blueprint $table) {
            $table->string('TDLVORD_DLVCD', 15);
            $table->string('TDLVORD_BRANCH', 3);
            $table->string('TDLVORD_CUSCD', 10);
            $table->integer('TDLVORD_LINE');
            $table->date('TDLVORD_ISSUDT');
            $table->timestamps();
            $table->unique(['TDLVORD_DLVCD', 'TDLVORD_BRANCH']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('T_DLVORDHEAD');
    }
};
