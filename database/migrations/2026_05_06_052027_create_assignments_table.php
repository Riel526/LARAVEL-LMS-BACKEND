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
        Schema::create('assignments', function (Blueprint $table) {
        $table->id('assignment_id');
        $table->foreignId('teacher_id')->constrained('users');
        $table->foreignId('subject_id')->constrained('subjects');
        $table->string('grade_level'); 
        $table->string('section');
        $table->string('title');
        $table->text('instructions')->nullable();
        $table->dateTime('due_date');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
