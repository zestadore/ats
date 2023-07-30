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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('email')->unique();
            $table->string('contact');
            $table->text('skills')->nullable();
            $table->text('key_skills')->nullable();
            $table->string('location');
            $table->text('linked_in')->nullable();
            $table->string('visa_status');
            $table->string('candidate_type')->nullable();
            $table->string('job_tag')->nullable();
            $table->string('job_title');
            $table->text('notes')->nullable();
            $table->text('resume')->nullable();
            $table->integer('employer_details')->default(0);
            $table->string('employer_name')->nullable();
            $table->string('employer_contact')->nullable();
            $table->string('employer_email')->nullable();
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
        Schema::dropIfExists('candidates');
    }
};
