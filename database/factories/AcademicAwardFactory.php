<?php

namespace Database\Factories;

use App\Models\AcademicAward;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AcademicAward>
 */
class AcademicAwardFactory extends Factory
{
    protected $model = AcademicAward::class;

    public function definition(): array
    {
        $gpa = fake()->randomFloat(2, 1.00, 2.50);

        return [
            'student_id' => Student::inRandomOrder()->value('student_id'),
            'school_year' => '2024-2025',
            'GPA' => $gpa,
            'honors' => $gpa <= 1.50
                ? 'With High Honors'
                : ($gpa <= 2.00 ? 'With Honors' : null),
        ];
    }
}