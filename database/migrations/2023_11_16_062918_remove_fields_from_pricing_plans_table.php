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
        Schema::table('pricing_plans', function (Blueprint $table) {
            $table->dropColumn('plan_type');
            $table->dropColumn('plan_interval');
            $table->dropColumn('price');
            $table->dropColumn('maximum_users');
            $table->dropColumn('monthly_invoices');
            $table->double('price_per_user', 10, 2)->default(0)->after('plan_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pricing_plans', function (Blueprint $table) {
            //
        });
    }
};
