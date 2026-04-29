<?php

namespace Database\Factories;

use App\Models\StudentSkill;
use App\Models\Student;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentSkill>
 */
class StudentSkillFactory extends Factory
{
    protected $model = StudentSkill::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->value('student_id'),
            'skill_id' => Skill::inRandomOrder()->value('skill_id'),
            'skill_level' => fake()->randomElement([
                'Beginner',
                'Intermediate',
                'Advanced',
            ]),
            'certification' => fake()->optional()->randomElement([
                'TESDA NC II',
                'Cisco Certificate',
                'Google Certificate',
                'Microsoft Certification',
            ]),
            'date_acquired' => fake()->optional()->date(),
        ];
    }
}