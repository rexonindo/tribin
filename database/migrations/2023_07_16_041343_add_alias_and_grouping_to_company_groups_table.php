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
        Schema::table('COMPANY_GROUPS', function (Blueprint $table) {
            $table->string('alias_code',3)->nullable()->after('fax');
            $table->string('alias_group_code',5)->nullable()->after('alias_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('COMPANY_GROUPS', function (Blueprint $table) {
            //
        });
    }
};
