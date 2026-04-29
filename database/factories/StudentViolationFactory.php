<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\ViolationType;
use App\Models\StudentViolation;

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
            'violation_date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
            'action_taken' => $this->faker->optional()->randomElement([
                'Warning Issued',
                'Parent Notified',
                'Community Service',
                'Guidance Counseling',
            ]),
            'status' => $this->faker->randomElement([
                'Pending',
                'Resolved',
            ]),
        ];
    }
}