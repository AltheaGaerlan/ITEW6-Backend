<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\NonAcademicActivity;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends Factory<NonAcademicActivity>
 */
class NonAcademicActivityFactory extends Factory
{
    protected $model = NonAcademicActivity::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->value('student_id'),
            'activity_name' => $this->faker->randomElement([
                'Hackathon Participation',
                'Basketball Tournament',
                'Debate Competition',
                'Volunteer Outreach Program',
                'Coding Bootcamp',
            ]),
            'category' => $this->faker->randomElement([
                'Sports',
                'Community Extension',
                'Competition',
                'Leadership',
            ]),
            'achievement' => $this->faker->optional()->randomElement([
                'Champion',
                '1st Runner-Up',
                'Best in Teamwork',
                'Certificate of Participation',
            ]),
            'activity_date' => $this->faker->date(),
        ];
    }
}