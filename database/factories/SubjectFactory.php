<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        $subjects = [
            ['code' => 'IT101', 'name' => 'Introduction to Computing', 'units' => 3, 'category' => 'Core', 'semester' => '1st'],
            ['code' => 'IT102', 'name' => 'Computer Programming 1', 'units' => 3, 'category' => 'Core', 'semester' => '1st'],
            ['code' => 'IT103', 'name' => 'Computer Programming 2', 'units' => 3, 'category' => 'Core', 'semester' => '2nd', 'prereq' => 'IT102'],
            ['code' => 'IT201', 'name' => 'Database Management Systems', 'units' => 3, 'category' => 'Core', 'semester' => '1st'],
            ['code' => 'IT202', 'name' => 'Networking 1', 'units' => 3, 'category' => 'Core', 'semester' => '2nd'],
            ['code' => 'IT301', 'name' => 'Web Systems and Technologies', 'units' => 3, 'category' => 'Core', 'semester' => '1st'],
            ['code' => 'IT302', 'name' => 'Information Assurance and Security', 'units' => 3, 'category' => 'Core', 'semester' => '2nd'],
            ['code' => 'IT303', 'name' => 'Mobile Application Development', 'units' => 3, 'category' => 'Elective', 'semester' => '1st'],
            ['code' => 'IT304', 'name' => 'Cloud Computing', 'units' => 3, 'category' => 'Elective', 'semester' => '2nd'],
            ['code' => 'IT401', 'name' => 'Capstone Project 1', 'units' => 3, 'category' => 'Core', 'semester' => '1st'],
            ['code' => 'IT402', 'name' => 'Capstone Project 2', 'units' => 3, 'category' => 'Core', 'semester' => '2nd', 'prereq' => 'IT401'],
            ['code' => 'IT311', 'name' => 'Data Structures and Algorithms', 'units' => 3, 'category' => 'Core', 'semester' => '1st'],
            ['code' => 'CS101', 'name' => 'Discrete Mathematics', 'units' => 3, 'category' => 'Core', 'semester' => '1st'],
            ['code' => 'CS102', 'name' => 'Linear Algebra', 'units' => 3, 'category' => 'Core', 'semester' => '2nd'],
            ['code' => 'GE101', 'name' => 'Purposive Communication', 'units' => 3, 'category' => 'GE', 'semester' => '1st'],
            ['code' => 'GE102', 'name' => 'Mathematics in the Modern World', 'units' => 3, 'category' => 'GE', 'semester' => '2nd'],
        ];

        $picked = fake()->unique()->randomElement($subjects);

        return [
            'subject_code' => $picked['code'],
            'subject_name' => $picked['name'],
            'description' => fake()->sentence(20),
            'units' => $picked['units'],
            'lecture_hours' => $picked['units'],
            'lab_hours' => fake()->randomElement([0, 3, 6]),
            'department_id' => Department::inRandomOrder()->value('department_id'),
            'course_category' => $picked['category'],
            'semester' => $picked['semester'],
        ];
    }
}