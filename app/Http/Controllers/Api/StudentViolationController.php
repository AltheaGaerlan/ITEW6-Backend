<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentViolation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentViolationController extends Controller
{
    // GET /api/v1/student-violations
    public function index(): JsonResponse
    {
        $violations = StudentViolation::with(['student', 'violationType'])
            ->orderBy('violation_date', 'desc')
            ->get();
        return response()->json($violations);
    }

    // POST /api/v1/student-violations
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id'        => 'required|exists:students,student_id',
            'violation_type_id' => 'required|exists:violation_types,violation_type_id',
            'violation_date'    => 'required|date',
            'description'       => 'nullable|string',
            'action_taken'      => 'nullable|string|max:100',
            'status'            => 'required|string|max:20',
        ]);

        $violation = StudentViolation::create($validated);
        return response()->json($violation->load(['student', 'violationType']), 201);
    }

    // GET /api/v1/student-violations/{id}
    public function show(int $id): JsonResponse
    {
        $violation = StudentViolation::with(['student', 'violationType'])->findOrFail($id);
        return response()->json($violation);
    }

    // PUT /api/v1/student-violations/{id}
    public function update(Request $request, int $id): JsonResponse
    {
        $violation = StudentViolation::findOrFail($id);

        $validated = $request->validate([
            'violation_type_id' => 'sometimes|exists:violation_types,violation_type_id',
            'violation_date'    => 'sometimes|date',
            'description'       => 'nullable|string',
            'action_taken'      => 'nullable|string|max:100',
            'status'            => 'sometimes|string|max:20',
        ]);

        $violation->update($validated);
        return response()->json($violation->load(['student', 'violationType']));
    }

    // DELETE /api/v1/student-violations/{id}
    public function destroy(int $id): JsonResponse
    {
        StudentViolation::findOrFail($id)->delete();
        return response()->json(['message' => 'Violation deleted successfully']);
    }
}