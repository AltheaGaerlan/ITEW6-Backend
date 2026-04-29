<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use App\Models\Student;
use App\Models\Organization;
use App\Models\StudentOrganization;

/**
 * @extends Factory<StudentOrganization>
 */
class StudentOrganizationFactory extends Factory
{
    protected $model = StudentOrganization::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        $start = $faker->dateTimeBetween('-2 years', '-6 months');
        $isEnded = $faker->boolean(25);

        return [
            'student_id' => Student::inRandomOrder()->value('student_id'),
            'organization_id' => Organization::inRandomOrder()->value('organization_id'),
            'role' => $faker->randomElement([
                'Member',
                'Officer',
                'President',
                'Vice President',
                'Secretary',
            ]),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $isEnded ? $faker->dateTimeBetween($start, 'now')->format('Y-m-d') : null,
            'status' => $isEnded ? 'Inactive' : 'Active',
        ];
    }
}