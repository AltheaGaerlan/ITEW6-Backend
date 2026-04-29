<?php

namespace Database\Factories;

use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faculty>
 */
class FacultyFactory extends Factory
{
    protected $model = Faculty::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'department_id' => Department::inRandomOrder()->value('department_id'),
            'position' => fake()->randomElement([
                'Instructor',
                'Assistant Professor',
                'Associate Professor',
                'Professor',
            ]),
            'expertise' => fake()->randomElement([
                'Web Development',
                'Database Systems',
                'Networking',
                'Cybersecurity',
                'Software Engineering',
                'Data Analytics',
            ]),
            'status' => fake()->randomElement([
                'Active',
                'Inactive',
            ]),
        ];
    }
}