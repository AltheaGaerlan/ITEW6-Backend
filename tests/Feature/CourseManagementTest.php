<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CourseManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_courses_with_department_and_prerequisite_data(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        $department = Department::create([
            'department_name' => 'College of Computing Studies',
        ]);

        $prerequisite = Subject::create([
            'subject_code' => 'IT101',
            'subject_name' => 'Introduction to Computing',
            'description' => 'Intro course',
            'units' => 3,
            'lecture_hours' => 3,
            'lab_hours' => 0,
            'department_id' => $department->department_id,
            'course_category' => 'Core',
            'semester' => '1st',
        ]);

        Subject::create([
            'subject_code' => 'IT102',
            'subject_name' => 'Programming 1',
            'description' => 'Programming course',
            'units' => 3,
            'lecture_hours' => 2,
            'lab_hours' => 3,
            'department_id' => $department->department_id,
            'prerequisite_subject_id' => $prerequisite->subject_id,
            'course_category' => 'Core',
            'semester' => '2nd',
        ]);

        $this->getJson('/api/v1/subjects')
            ->assertOk()
            ->assertJsonPath('1.department.department_name', 'College of Computing Studies')
            ->assertJsonPath('1.prerequisite.subject_code', 'IT101');
    }

    public function test_it_rejects_self_prerequisite_on_update(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        $department = Department::create([
            'department_name' => 'College of Computing Studies',
        ]);

        $subject = Subject::create([
            'subject_code' => 'IT201',
            'subject_name' => 'Database Management Systems',
            'description' => 'Database course',
            'units' => 3,
            'lecture_hours' => 3,
            'lab_hours' => 0,
            'department_id' => $department->department_id,
            'course_category' => 'Core',
            'semester' => '1st',
        ]);

        $this->putJson("/api/v1/subjects/{$subject->subject_id}", [
            'prerequisite_subject_id' => $subject->subject_id,
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['prerequisite_subject_id']);
    }
}
