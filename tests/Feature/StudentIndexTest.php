<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Guardian;
use App\Models\Section;
use App\Models\Skill;
use App\Models\Student;
use App\Models\StudentSkill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StudentIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_supports_search_and_skill_filter_in_student_listing(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $department = Department::create([
            'department_name' => 'College of Computing Studies',
        ]);

        $faculty = Faculty::create([
            'first_name' => 'Ana',
            'last_name' => 'Santos',
            'email' => 'ana.santos@example.com',
            'department_id' => $department->department_id,
            'position' => 'Instructor',
            'expertise' => 'Web Development',
            'status' => 'Active',
        ]);

        $section = Section::create([
            'section_name' => 'BSIT-3A',
            'year_level' => 3,
            'school_year' => '2025-2026',
            'adviser_id' => $faculty->faculty_id,
        ]);

        $guardian = Guardian::create([
            'first_name' => 'Mario',
            'last_name' => 'Dela Cruz',
            'email' => 'guardian@example.com',
            'contact_number' => '09123456789',
        ]);

        $matchingStudent = Student::create([
            'student_number' => '2026-0001',
            'first_name' => 'Joana',
            'last_name' => 'Lumogda',
            'middle_name' => 'Marie',
            'gender' => 'Female',
            'birthdate' => '2005-01-01',
            'civil_status' => 'Single',
            'contact_number' => '09123456780',
            'email' => 'joana@example.com',
            'address' => 'Manila',
            'section_id' => $section->section_id,
            'status' => 'Active',
            'guardian_id' => $guardian->guardian_id,
        ]);

        $otherStudent = Student::create([
            'student_number' => '2026-0002',
            'first_name' => 'Pedro',
            'last_name' => 'Reyes',
            'middle_name' => null,
            'gender' => 'Male',
            'birthdate' => '2004-02-02',
            'civil_status' => 'Single',
            'contact_number' => '09123456781',
            'email' => 'pedro@example.com',
            'address' => 'Cebu',
            'section_id' => $section->section_id,
            'status' => 'Inactive',
            'guardian_id' => $guardian->guardian_id,
        ]);

        $matchingSkill = Skill::create([
            'skill_name' => 'JavaScript',
            'skill_category' => 'Programming',
        ]);

        $otherSkill = Skill::create([
            'skill_name' => 'Networking',
            'skill_category' => 'Infrastructure',
        ]);

        StudentSkill::create([
            'student_id' => $matchingStudent->student_id,
            'skill_id' => $matchingSkill->skill_id,
        ]);

        StudentSkill::create([
            'student_id' => $otherStudent->student_id,
            'skill_id' => $otherSkill->skill_id,
        ]);

        $response = $this->getJson('/api/v1/students?limit=10&page=1&q=Joana&skill=Java');

        $response
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('data.0.student_number', '2026-0001')
            ->assertJsonPath('data.0.skills.0.skill.skill_name', 'JavaScript');
    }
}
