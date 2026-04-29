<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
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
        $faker = FakerFactory::create();
        return [
            'student_id' => Student::inRandomOrder()->value('student_id'),
            'violation_type_id' => ViolationType::inRandomOrder()->value('violation_type_id'),
            'violation_date' => $faker->date(),
            'description' => $faker->sentence(),
            'action_taken' => $faker->optional()->randomElement([
                'Warning Issued',
                'Parent Notified',
                'Community Service',
                'Guidance Counseling',
            ]),
            'status' => $faker->randomElement([
                'Pending',
                'Resolved',
            ]),
        ];
    }
}