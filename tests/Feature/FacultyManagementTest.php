<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FacultyManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_faculty_with_department_and_counts(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        $department = Department::create([
            'department_name' => 'College of Computing Studies',
        ]);

        Faculty::create([
            'first_name' => 'Ana',
            'last_name' => 'Santos',
            'email' => 'ana@example.com',
            'department_id' => $department->department_id,
            'position' => 'Instructor',
            'expertise' => 'Web Development',
            'status' => 'Active',
        ]);

        $this->getJson('/api/v1/faculty')
            ->assertOk()
            ->assertJsonPath('0.department.department_name', 'College of Computing Studies')
            ->assertJsonPath('0.sections_count', 0)
            ->assertJsonPath('0.subjects_count', 0)
            ->assertJsonPath('0.organizations_count', 0);
    }

    public function test_it_validates_unique_faculty_email(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        $department = Department::create([
            'department_name' => 'College of Computing Studies',
        ]);

        Faculty::create([
            'first_name' => 'Ana',
            'last_name' => 'Santos',
            'email' => 'ana@example.com',
            'department_id' => $department->department_id,
            'position' => 'Instructor',
            'expertise' => 'Web Development',
            'status' => 'Active',
        ]);

        $this->postJson('/api/v1/faculty', [
            'first_name' => 'Maria',
            'last_name' => 'Lopez',
            'email' => 'ana@example.com',
            'department_id' => $department->department_id,
            'position' => 'Professor',
            'expertise' => 'Database Systems',
            'status' => 'Active',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
