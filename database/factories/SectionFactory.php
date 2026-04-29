<?php

namespace Database\Factories;

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
        $year = $this->faker->numberBetween(1, 4);

        return [
            'section_name' => 'BSIT-' . $year . $this->faker->randomElement(['A', 'B', 'C']),
            'year_level' => $year,
            'school_year' => '2024-2025',
            'adviser_id' => Faculty::inRandomOrder()->value('faculty_id'),
        ];
    }
}