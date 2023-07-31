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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_title_id');
            $table->foreignId('candidate_id');
            $table->string('contact')->nullable();
            $table->string('email_id')->nullable();
            $table->string('total_experience')->nullable();
            $table->string('relevant_experience')->nullable();
            $table->string('current_location')->nullable();
            $table->string('education')->nullable();
            $table->string('rate')->nullable();
            $table->string('notice_period')->nullable();
            $table->string('visa_status')->nullable();
            $table->string('relocation')->nullable();
            $table->string('candidate_type')->nullable();
            $table->string('interview_availability')->nullable();
            $table->string('open_for_location')->nullable();
            $table->text('resume')->nullable();
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
        Schema::dropIfExists('submissions');
    }
};
