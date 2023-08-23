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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->string('invoice_no');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->foreignId('client_id');
            $table->foreignId('candidate_id');
            $table->double('total_hrs', 10, 2)->default(0.00);
            $table->double('total_amount', 10, 2)->default(0.00);
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
        Schema::dropIfExists('invoices');
    }
};
