<?php

namespace Database\Factories;

use App\Models\Faculty;
use App\Models\Organization;
use App\Models\FacultyOrganization;

/**
 * @extends Factory<FacultyOrganization>
 */
class FacultyOrganizationFactory extends Factory
{
    protected $model = FacultyOrganization::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-3 years', '-1 year');

        return [
            'faculty_id' => Faculty::inRandomOrder()->value('faculty_id'),
            'organization_id' => Organization::inRandomOrder()->value('organization_id'),
            'role' => $this->faker->randomElement([
                'Adviser',
                'Co-Adviser',
                'Coordinator',
            ]),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $this->faker->optional()->dateTimeBetween($start, 'now')?->format('Y-m-d'),
        ];
    }
}