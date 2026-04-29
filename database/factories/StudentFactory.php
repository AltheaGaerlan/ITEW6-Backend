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
            'student_number' => '2024-' . $this->faker->unique()->numerify('####'),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'middle_name' => $this->faker->optional()->firstName(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'birthdate' => $this->faker->dateTimeBetween('-25 years', '-17 years')->format('Y-m-d'),
            'civil_status' => 'Single',
            'contact_number' => $this->faker->numerify('09#########'),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'section_id' => Section::inRandomOrder()->value('section_id'),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'guardian_id' => Guardian::inRandomOrder()->value('guardian_id'),
        ];
    }
}