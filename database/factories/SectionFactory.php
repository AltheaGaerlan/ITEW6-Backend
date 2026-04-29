<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use App\Models\Faculty;
use App\Models\Section;

/**
 * @extends Factory<Section>
 */
class SectionFactory extends Factory
{
    protected $model = Section::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        $year = $faker->numberBetween(1, 4);

        return [
            'section_name' => 'BSIT-' . $year . $faker->randomElement(['A', 'B', 'C']),
            'year_level' => $year,
            'school_year' => '2024-2025',
            'adviser_id' => Faculty::inRandomOrder()->value('faculty_id'),
        ];
    }
}