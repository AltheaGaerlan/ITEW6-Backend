<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use App\Models\Skill;

/**
 * @extends Factory<Skill>
 */
class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        $skills = [
            ['name' => 'PHP Programming', 'category' => 'Technical'],
            ['name' => 'Java Programming', 'category' => 'Technical'],
            ['name' => 'JavaScript', 'category' => 'Technical'],
            ['name' => 'UI/UX Design', 'category' => 'Technical'],
            ['name' => 'Database Design', 'category' => 'Technical'],
            ['name' => 'Network Configuration', 'category' => 'Technical'],
            ['name' => 'Problem Solving', 'category' => 'Soft Skill'],
            ['name' => 'Leadership', 'category' => 'Soft Skill'],
            ['name' => 'Communication', 'category' => 'Soft Skill'],
            ['name' => 'Teamwork', 'category' => 'Soft Skill'],
        ];

        $picked = $faker->unique()->randomElement($skills);

        return [
            'skill_name' => $picked['name'],
            'skill_category' => $picked['category'],
        ];
    }
}