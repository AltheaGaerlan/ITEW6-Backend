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
        Schema::create('student_subjects', function (Blueprint $table) {
            $table->id('record_id');
            $table->foreignId('student_id')->constrained('students', 'student_id');
            $table->foreignId('subject_id')->constrained('subjects', 'subject_id');
            $table->string('school_year', 20);
            $table->string('semester', 20);
            $table->float('grade')->nullable();
            $table->string('remarks', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subjects');
    }
};
