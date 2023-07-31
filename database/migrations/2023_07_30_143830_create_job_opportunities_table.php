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
        Schema::create('job_opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('type')->default(1)->comment('0->contract, 1->full time');
            $table->double('salary',10,2)->nullable();
            $table->string('job_owner')->nullable();
            $table->integer('status')->default(1);
            $table->foreignId('client_id');
            $table->foreignId('end_client_id');
            $table->text('key_skills')->nullable();
            $table->text('notes')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('job_opportunities');
    }
};
