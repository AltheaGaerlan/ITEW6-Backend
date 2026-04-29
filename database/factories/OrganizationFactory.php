<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Organization>
 */
class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {
        $orgs = [
            ['name' => 'Junior Programmers Guild', 'type' => 'Academic'],
            ['name' => 'CCS Student Council', 'type' => 'Academic'],
            ['name' => 'E-Sports Club', 'type' => 'Recreational'],
            ['name' => 'Multimedia Arts Circle', 'type' => 'Cultural'],
            ['name' => 'Cybersecurity Society', 'type' => 'Academic'],
        ];

        $picked = fake()->unique()->randomElement($orgs);

        return [
            'organization_name' => $picked['name'],
            'organization_type' => $picked['type'],
        ];
    }
}