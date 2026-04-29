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
        Schema::create('non_academic_activities', function (Blueprint $table) {
            $table->id('activity_id');
            $table->unsignedBigInteger('student_id');
            $table->string('activity_name', 100);
            $table->string('category', 50);
            $table->string('achievement', 100)->nullable();
            $table->date('activity_date');
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_academic_activities');
    }
};
