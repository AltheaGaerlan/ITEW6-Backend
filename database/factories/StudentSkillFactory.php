<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use App\Models\Student;
use App\Models\Skill;
use App\Models\StudentSkill;

/**
 * @extends Factory<StudentSkill>
 */
class StudentSkillFactory extends Factory
{
    protected $model = StudentSkill::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        return [
            'student_id' => Student::inRandomOrder()->value('student_id'),
            'skill_id' => Skill::inRandomOrder()->value('skill_id'),
            'skill_level' => $faker->randomElement([
                'Beginner',
                'Intermediate',
                'Advanced',
            ]),
            'certification' => $faker->optional()->randomElement([
                'TESDA NC II',
                'Cisco Certificate',
                'Google Certificate',
                'Microsoft Certification',
            ]),
            'date_acquired' => $faker->optional()->date(),
        ];
    }
}