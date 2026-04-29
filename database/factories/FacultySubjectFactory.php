<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\FacultySubject;

/**
 * @extends Factory<FacultySubject>
 */
class FacultySubjectFactory extends Factory
{
    protected $model = FacultySubject::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        return [
            'faculty_id' => Faculty::inRandomOrder()->value('faculty_id'),
            'subject_id' => Subject::inRandomOrder()->value('subject_id'),
            'school_year' => '2024-2025',
            'semester' => $faker->randomElement(['1st Semester', '2nd Semester']),
        ];
    }
}