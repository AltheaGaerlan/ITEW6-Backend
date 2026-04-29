<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentViolation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $studentNotifications = Student::with('section')
            ->latest('created_at')
            ->take(6)
            ->get()
            ->map(function (Student $student): array {
                $fullName = trim(collect([
                    $student->first_name,
                    $student->middle_name,
                    $student->last_name,
                ])->filter()->implode(' '));

                $sectionName = $student->section?->section_name ?? 'No section assigned';

                return [
                    'id' => sprintf(
                        'student-%s-%s',
                        $student->student_id,
                        optional($student->updated_at)->timestamp ?? $student->student_id
                    ),
                    'type' => 'student',
                    'title' => 'New student added',
                    'message' => "{$fullName} was added to {$sectionName}.",
                    'route' => '/students',
                    'severity' => 'info',
                    'occurred_at' => optional($student->created_at)->toIso8601String(),
                ];
            });

        $violationNotifications = StudentViolation::with(['student', 'violationType'])
            ->latest('created_at')
            ->take(6)
            ->get()
            ->map(function (StudentViolation $violation): array {
                $studentName = trim(collect([
                    $violation->student?->first_name,
                    $violation->student?->middle_name,
                    $violation->student?->last_name,
                ])->filter()->implode(' '));

                $violationName = $violation->violationType?->violation_name ?? 'a violation';
                $severity = strtolower($violation->violationType?->severity_level ?? 'medium');
                $status = strtolower($violation->status ?? 'pending');

                return [
                    'id' => sprintf(
                        'violation-%s-%s',
                        $violation->violation_id,
                        optional($violation->updated_at)->timestamp ?? $violation->violation_id
                    ),
                    'type' => 'violation',
                    'title' => 'New violation recorded',
                    'message' => "{$studentName} was tagged for {$violationName} ({$status}).",
                    'route' => '/violations',
                    'severity' => $severity,
                    'occurred_at' => optional($violation->created_at)->toIso8601String(),
                ];
            });

        $notifications = $studentNotifications
            ->concat($violationNotifications)
            ->sortByDesc('occurred_at')
            ->take(8)
            ->values();

        return response()->json([
            'notifications' => $notifications,
            'meta' => [
                'total' => $notifications->count(),
                'generated_at' => now()->toIso8601String(),
            ],
        ]);
    }
}
