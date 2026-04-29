<?php

namespace Database\Factories;

use App\Models\FacultyOrganization;
use App\Models\Faculty;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FacultyOrganization>
 */
class FacultyOrganizationFactory extends Factory
{
    protected $model = FacultyOrganization::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-3 years', '-1 year');

        return [
            'faculty_id' => Faculty::inRandomOrder()->value('faculty_id'),
            'organization_id' => Organization::inRandomOrder()->value('organization_id'),
            'role' => fake()->randomElement([
                'Adviser',
                'Co-Adviser',
                'Coordinator',
            ]),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => fake()->optional()->dateTimeBetween($start, 'now')?->format('Y-m-d'),
        ];
    }
}