<?php

namespace Database\Factories;

use App\Models\Section;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Section>
 */
class SectionFactory extends Factory
{
    protected $model = Section::class;

    public function definition(): array
    {
        $year = fake()->numberBetween(1, 4);

        return [
            'section_name' => 'BSIT-' . $year . fake()->randomElement(['A', 'B', 'C']),
            'year_level' => $year,
            'school_year' => '2024-2025',
            'adviser_id' => Faculty::inRandomOrder()->value('faculty_id'),
        ];
    }
}