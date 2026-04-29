<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Skill;
use App\Models\StudentSkill;
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
            'skill_level' => $this->faker->randomElement([
                'Beginner',
                'Intermediate',
                'Advanced',
            ]),
            'certification' => $this->faker->optional()->randomElement([
                'TESDA NC II',
                'Cisco Certificate',
                'Google Certificate',
                'Microsoft Certification',
            ]),
            'date_acquired' => $this->faker->optional()->date(),
        ];
    }
}