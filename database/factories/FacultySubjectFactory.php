<?php

namespace Database\Factories;

use App\Models\FacultySubject;
use App\Models\Faculty;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FacultySubject>
 */
class FacultySubjectFactory extends Factory
{
    protected $model = FacultySubject::class;

    public function definition(): array
    {
        return [
            'faculty_id' => Faculty::inRandomOrder()->value('faculty_id'),
            'subject_id' => Subject::inRandomOrder()->value('subject_id'),
            'school_year' => '2024-2025',
            'semester' => fake()->randomElement(['1st Semester', '2nd Semester']),
        ];
    }
}