<?php

namespace Tests\Feature;

use App\Models\Guardian;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentViolation;
use App\Models\User;
use App\Models\ViolationType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NotificationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_recent_notifications_from_students_and_violations(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $guardian = Guardian::create([
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'email' => 'guardian@example.com',
            'contact_number' => '09123456789',
        ]);

        $section = Section::create([
            'section_name' => 'BSIT-3A',
            'year_level' => 3,
            'school_year' => '2025-2026',
            'adviser_id' => null,
        ]);

        $student = Student::create([
            'student_number' => '2026-0001',
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'middle_name' => 'Reyes',
            'gender' => 'Male',
            'birthdate' => '2005-01-01',
            'civil_status' => 'Single',
            'contact_number' => '09123456780',
            'email' => 'juan@example.com',
            'address' => 'Manila',
            'section_id' => $section->section_id,
            'status' => 'Active',
            'guardian_id' => $guardian->guardian_id,
        ]);

        $violationType = ViolationType::create([
            'violation_name' => 'Late Attendance',
            'severity_level' => 'Low',
        ]);

        StudentViolation::create([
            'student_id' => $student->student_id,
            'violation_type_id' => $violationType->violation_type_id,
            'violation_date' => now()->toDateString(),
            'description' => 'Late for first subject.',
            'action_taken' => 'Warning Issued',
            'status' => 'Pending',
        ]);

        $response = $this->getJson('/api/v1/notifications');

        $response
            ->assertOk()
            ->assertJsonPath('meta.total', 2)
            ->assertJsonStructure([
                'notifications' => [
                    '*' => [
                        'id',
                        'type',
                        'title',
                        'message',
                        'route',
                        'severity',
                        'occurred_at',
                    ],
                ],
                'meta' => [
                    'total',
                    'generated_at',
                ],
            ]);
    }
}
