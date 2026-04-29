<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use App\Models\Student;
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
        $faker = FakerFactory::create();
        return [
            'student_number' => '2024-' . $faker->unique()->numerify('####'),
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'middle_name' => $faker->optional()->firstName(),
            'gender' => $faker->randomElement(['Male', 'Female']),
            'birthdate' => $faker->dateTimeBetween('-25 years', '-17 years')->format('Y-m-d'),
            'civil_status' => 'Single',
            'contact_number' => $faker->numerify('09#########'),
            'email' => $faker->unique()->safeEmail(),
            'address' => $faker->address(),
            'section_id' => Section::inRandomOrder()->value('section_id'),
            'status' => $faker->randomElement(['Active', 'Inactive']),
            'guardian_id' => Guardian::inRandomOrder()->value('guardian_id'),
        ];
    }
}