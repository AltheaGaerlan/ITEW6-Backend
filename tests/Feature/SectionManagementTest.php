<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Room;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SectionManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_sections_with_room_adviser_and_student_counts(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        $department = Department::create([
            'department_name' => 'College of Computing Studies',
        ]);

        $faculty = Faculty::create([
            'first_name' => 'Ana',
            'last_name' => 'Santos',
            'email' => 'ana@example.com',
            'department_id' => $department->department_id,
            'position' => 'Instructor',
            'expertise' => 'Web Development',
            'status' => 'Active',
        ]);

        $room = Room::create([
            'room_name' => 'Room 301',
            'room_type' => 'Classroom',
            'capacity' => 40,
            'building' => 'Main Building',
            'floor' => 3,
            'status' => 'available',
        ]);

        Section::create([
            'section_name' => 'BSIT-3A',
            'year_level' => 3,
            'school_year' => '2025-2026',
            'adviser_id' => $faculty->faculty_id,
            'room_id' => $room->room_id,
        ]);

        $this->getJson('/api/v1/sections')
            ->assertOk()
            ->assertJsonPath('0.adviser.last_name', 'Santos')
            ->assertJsonPath('0.room.room_name', 'Room 301')
            ->assertJsonPath('0.students_count', 0);
    }

    public function test_it_rejects_duplicate_section_names_in_the_same_school_year(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        Section::create([
            'section_name' => 'BSIT-3A',
            'year_level' => 3,
            'school_year' => '2025-2026',
            'adviser_id' => null,
            'room_id' => null,
        ]);

        $this->postJson('/api/v1/sections', [
            'section_name' => 'BSIT-3A',
            'year_level' => 3,
            'school_year' => '2025-2026',
            'adviser_id' => null,
            'room_id' => null,
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['section_name']);
    }
}
