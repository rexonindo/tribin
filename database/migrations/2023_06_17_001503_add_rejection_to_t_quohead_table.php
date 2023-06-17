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
        Schema::table('t_quohead', function (Blueprint $table) {
            $table->string('TQUO_REJCTBY', 16)->nullable()->after('TQUO_APPRVDT');
            $table->dateTime('TQUO_REJCTDT')->nullable()->after('TQUO_REJCTBY');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_quohead', function (Blueprint $table) {
            //
        });
    }
};
