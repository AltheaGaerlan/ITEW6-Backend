<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_violations', function (Blueprint $table) {
            $table->id('violation_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('violation_type_id');
            $table->date('violation_date');
            $table->text('description')->nullable();
            $table->string('action_taken', 100)->nullable();
            $table->string('status', 20);
            $table->timestamps();

            $table->foreign('student_id')
                  ->references('student_id')
                  ->on('students')
                  ->onDelete('cascade');

            $table->foreign('violation_type_id')
                  ->references('violation_type_id')
                  ->on('violation_types')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_violations');
    }
};