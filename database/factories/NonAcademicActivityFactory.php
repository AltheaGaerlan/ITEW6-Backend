<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use App\Models\Student;
use App\Models\NonAcademicActivity;

/**
 * @extends Factory<NonAcademicActivity>
 */
class NonAcademicActivityFactory extends Factory
{
    protected $model = NonAcademicActivity::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        return [
            'student_id' => Student::inRandomOrder()->value('student_id'),
            'activity_name' => $faker->randomElement([
                'Hackathon Participation',
                'Basketball Tournament',
                'Debate Competition',
                'Volunteer Outreach Program',
                'Coding Bootcamp',
            ]),
            'category' => $faker->randomElement([
                'Sports',
                'Community Extension',
                'Competition',
                'Leadership',
            ]),
            'achievement' => $faker->optional()->randomElement([
                'Champion',
                '1st Runner-Up',
                'Best in Teamwork',
                'Certificate of Participation',
            ]),
            'activity_date' => $faker->date(),
        ];
    }
}