<?php

namespace Database\Factories;

use App\Models\StudentOrganization;
use App\Models\Student;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentOrganization>
 */
class StudentOrganizationFactory extends Factory
{
    protected $model = StudentOrganization::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-2 years', '-6 months');
        $isEnded = fake()->boolean(25);

        return [
            'student_id' => Student::inRandomOrder()->value('student_id'),
            'organization_id' => Organization::inRandomOrder()->value('organization_id'),
            'role' => fake()->randomElement([
                'Member',
                'Officer',
                'President',
                'Vice President',
                'Secretary',
            ]),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $isEnded ? fake()->dateTimeBetween($start, 'now')->format('Y-m-d') : null,
            'status' => $isEnded ? 'Inactive' : 'Active',
        ];
    }
}