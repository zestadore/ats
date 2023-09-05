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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('type')->default(0)->comment('0: note, 1: todo');
            $table->integer('status')->default(0)->comment('0: pending, 1: done');
            $table->string('color_code')->nullable();
            $table->foreignId('created_by')->default(1);
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
