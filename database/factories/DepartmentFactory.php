<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        return [
            'department_name' => $faker->unique()->randomElement([
                'College of Computing Studies',
                'Information Technology Department',
                'Computer Science Department',
                'Information Systems Department',
            ]),
        ];
    }
}