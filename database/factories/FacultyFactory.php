<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faculty>
 */
class FacultyFactory extends Factory
{
    protected $model = Faculty::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        return [
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => $faker->unique()->safeEmail(),
            'department_id' => Department::inRandomOrder()->value('department_id'),
            'position' => $faker->randomElement([
                'Instructor',
                'Assistant Professor',
                'Associate Professor',
                'Professor',
            ]),
            'expertise' => $faker->randomElement([
                'Web Development',
                'Database Systems',
                'Networking',
                'Cybersecurity',
                'Software Engineering',
                'Data Analytics',
            ]),
            'status' => $faker->randomElement([
                'Active',
                'Inactive',
            ]),
        ];
    }
}