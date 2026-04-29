<?php

namespace Database\Factories;

use App\Models\StudentSubject;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentSubject>
 */
class StudentSubjectFactory extends Factory
{
    protected $model = StudentSubject::class;

    public function definition(): array
    {
        $grade = fake()->randomFloat(2, 1.00, 3.00);

        return [
            'student_id' => Student::inRandomOrder()->value('student_id'),
            'subject_id' => Subject::inRandomOrder()->value('subject_id'),
            'school_year' => '2024-2025',
            'semester' => fake()->randomElement(['1st Semester', '2nd Semester']),
            'grade' => $grade,
            'remarks' => $grade <= 3.00 ? 'Passed' : 'Failed',
        ];
    }
}