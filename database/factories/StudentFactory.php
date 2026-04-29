<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Section;
use App\Models\Guardian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'student_number' => '2024-' . fake()->unique()->numerify('####'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'middle_name' => fake()->optional()->firstName(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'birthdate' => fake()->dateTimeBetween('-25 years', '-17 years')->format('Y-m-d'),
            'civil_status' => 'Single',
            'contact_number' => fake()->numerify('09#########'),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->address(),
            'section_id' => Section::inRandomOrder()->value('section_id'),
            'status' => fake()->randomElement(['Active', 'Inactive']),
            'guardian_id' => Guardian::inRandomOrder()->value('guardian_id'),
        ];
    }
}