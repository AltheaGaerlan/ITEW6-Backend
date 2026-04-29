<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->text('description')->nullable()->after('subject_name');
            $table->integer('units')->default(3)->after('description');
            $table->integer('lecture_hours')->default(0)->after('units');
            $table->integer('lab_hours')->default(0)->after('lecture_hours');
            $table->unsignedBigInteger('prerequisite_subject_id')->nullable()->after('lab_hours');
            $table->string('course_category', 30)->default('Core')->after('prerequisite_subject_id');
            $table->string('semester', 20)->nullable()->after('course_category');
        });
    }

    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'units',
                'lecture_hours',
                'lab_hours',
                'prerequisite_subject_id',
                'course_category',
                'semester',
            ]);
        });
    }
};