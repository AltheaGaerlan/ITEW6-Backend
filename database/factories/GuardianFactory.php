<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use App\Models\Guardian;

/**
 * @extends Factory<Guardian>
 */
class GuardianFactory extends Factory
{
    protected $model = Guardian::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        return [
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => $faker->unique()->safeEmail(),
            'contact_number' => $faker->numerify('09#########'),
        ];
    }
}