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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->string('interview_name');
            $table->foreignId('candidate_id');
            $table->foreignId('client_id');
            $table->foreignId('job_opportunity_id');
            $table->json('interviewers_id')->nullable();
            $table->foreignId('interview_owner_id')->nullable();
            $table->dateTime('from_date');
            $table->dateTime('to_date');
            $table->text('location')->nullable();
            $table->text('comments')->nullable();
            $table->text('assesment_name')->nullable();
            $table->foreignId('created_by');
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
        Schema::dropIfExists('interviews');
    }
};
