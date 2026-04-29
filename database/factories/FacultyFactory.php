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
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'department_id' => Department::inRandomOrder()->value('department_id'),
            'position' => $this->faker->randomElement([
                'Instructor',
                'Assistant Professor',
                'Associate Professor',
                'Professor',
            ]),
            'expertise' => $this->faker->randomElement([
                'Web Development',
                'Database Systems',
                'Networking',
                'Cybersecurity',
                'Software Engineering',
                'Data Analytics',
            ]),
            'status' => $this->faker->randomElement([
                'Active',
                'Inactive',
            ]),
        ];
    }
}