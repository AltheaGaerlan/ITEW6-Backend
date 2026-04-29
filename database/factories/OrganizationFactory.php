<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use App\Models\Organization;

/**
 * @extends Factory<Organization>
 */
class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        $orgs = [
            ['name' => 'Junior Programmers Guild', 'type' => 'Academic'],
            ['name' => 'CCS Student Council', 'type' => 'Academic'],
            ['name' => 'E-Sports Club', 'type' => 'Recreational'],
            ['name' => 'Multimedia Arts Circle', 'type' => 'Cultural'],
            ['name' => 'Cybersecurity Society', 'type' => 'Academic'],
        ];

        $picked = $faker->unique()->randomElement($orgs);

        return [
            'organization_name' => $picked['name'],
            'organization_type' => $picked['type'],
        ];
    }
}