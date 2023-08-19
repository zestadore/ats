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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->text('logo')->nullable();
            $table->text('address')->nullable();
            $table->text('website')->nullable();
            $table->string('date_format')->default('d-m-y');
            $table->string('time_zone')->default('Asia/Kolkata');
            $table->string('currency_symbol');
            $table->string('currency_position');
            $table->string('precision');
            $table->text('invoice_footer')->nullable();
            $table->foreignId('pricing_plan_id');
            $table->integer('status')->default(1);
            $table->foreignId('created_by')->default(1);
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
