<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RoomManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_rooms_with_section_counts(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        $room = Room::create([
            'room_name' => 'Room 101',
            'room_type' => 'Classroom',
            'capacity' => 40,
            'building' => 'Main Building',
            'floor' => 1,
            'status' => 'available',
        ]);

        Section::create([
            'section_name' => 'BSIT-3A',
            'year_level' => 3,
            'school_year' => '2025-2026',
            'adviser_id' => null,
            'room_id' => $room->room_id,
        ]);

        $this->getJson('/api/v1/rooms')
            ->assertOk()
            ->assertJsonPath('0.room_name', 'Room 101')
            ->assertJsonPath('0.sections_count', 1);
    }

    public function test_it_prevents_duplicate_room_names_in_the_same_building(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        Room::create([
            'room_name' => 'Room 101',
            'room_type' => 'Classroom',
            'capacity' => 40,
            'building' => 'Main Building',
            'floor' => 1,
            'status' => 'available',
        ]);

        $this->postJson('/api/v1/rooms', [
            'room_name' => 'Room 101',
            'room_type' => 'Laboratory',
            'capacity' => 35,
            'building' => 'Main Building',
            'floor' => 2,
            'status' => 'available',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['room_name']);
    }

    public function test_it_allows_the_same_room_name_in_a_different_building(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        Room::create([
            'room_name' => 'Room 101',
            'room_type' => 'Classroom',
            'capacity' => 40,
            'building' => 'Main Building',
            'floor' => 1,
            'status' => 'available',
        ]);

        $this->postJson('/api/v1/rooms', [
            'room_name' => 'Room 101',
            'room_type' => 'Classroom',
            'capacity' => 50,
            'building' => 'Science Building',
            'floor' => 3,
            'status' => 'maintenance',
        ])->assertCreated()
            ->assertJsonPath('building', 'Science Building');
    }

    public function test_it_validates_room_status_on_update(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        $room = Room::create([
            'room_name' => 'Room 202',
            'room_type' => 'Classroom',
            'capacity' => 45,
            'building' => 'Main Building',
            'floor' => 2,
            'status' => 'available',
        ]);

        $this->putJson("/api/v1/rooms/{$room->room_id}", [
            'status' => 'broken',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }
}
