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
        Schema::table('candidates', function (Blueprint $table) {
            $table->foreignId('company_id')->default(0)->after('id');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('company_id')->default(0)->after('id');
        });
        Schema::table('interviews', function (Blueprint $table) {
            $table->foreignId('company_id')->default(0)->after('id');
        });
        Schema::table('job_opportunities', function (Blueprint $table) {
            $table->foreignId('company_id')->default(0)->after('id');
        });
        Schema::table('submissions', function (Blueprint $table) {
            $table->foreignId('company_id')->default(0)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            //
        });
    }
};
