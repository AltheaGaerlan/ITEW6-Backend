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
        Schema::create('sections', function (Blueprint $table) {
            $table->id('section_id');
            $table->string('section_name', 50);
            $table->integer('year_level');
            $table->string('school_year', 20);
            $table->unsignedBigInteger('adviser_id')->nullable();
            $table->timestamps();

            $table->foreign('adviser_id')->references('faculty_id')->on('faculty')->onDelete('set null');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
