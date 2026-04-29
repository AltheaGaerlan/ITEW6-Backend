<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_regular_users_cannot_create_faculty_records(): void
    {
        $department = Department::create([
            'department_name' => 'College of Computing Studies',
        ]);

        Sanctum::actingAs(User::factory()->create(['role' => 'user']));

        $this->postJson('/api/v1/faculty', [
            'first_name' => 'Ana',
            'last_name' => 'Santos',
            'email' => 'ana@example.com',
            'department_id' => $department->department_id,
            'position' => 'Instructor',
            'expertise' => 'Web Development',
            'status' => 'Active',
        ])->assertStatus(403)
            ->assertJson([
                'message' => 'Forbidden. Admin access is required.',
            ]);
    }

    public function test_regular_users_cannot_manage_user_accounts(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'user']));

        $this->getJson('/api/v1/users')
            ->assertStatus(403);
    }

    public function test_regular_users_can_view_reference_modules(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'user']));

        $this->getJson('/api/v1/subjects')->assertOk();
        $this->getJson('/api/v1/sections')->assertOk();
        $this->getJson('/api/v1/rooms')->assertOk();
    }
}
