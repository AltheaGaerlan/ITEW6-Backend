<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'department_name' => fake()->unique()->randomElement([
                'College of Computing Studies',
                'Information Technology Department',
                'Computer Science Department',
                'Information Systems Department',
            ]),
        ];
    }
}