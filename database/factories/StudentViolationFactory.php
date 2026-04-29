<?php

namespace Database\Factories;

use App\Models\StudentViolation;
use App\Models\Student;
use App\Models\ViolationType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentViolation>
 */
class StudentViolationFactory extends Factory
{
    protected $model = StudentViolation::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->value('student_id'),
            'violation_type_id' => ViolationType::inRandomOrder()->value('violation_type_id'),
            'violation_date' => fake()->date(),
            'description' => fake()->sentence(),
            'action_taken' => fake()->optional()->randomElement([
                'Warning Issued',
                'Parent Notified',
                'Community Service',
                'Guidance Counseling',
            ]),
            'status' => fake()->randomElement([
                'Pending',
                'Resolved',
            ]),
        ];
    }
}