<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentOrganization;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentOrganizationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            StudentOrganization::with(['student', 'organization'])->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id'      => 'required|exists:students,student_id',
            'organization_id' => 'required|exists:organizations,organization_id',
            'role'            => 'nullable|string|max:50',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'status'          => 'required|string|max:20',
        ]);

        $record = StudentOrganization::create($validated);
        return response()->json($record->load(['student', 'organization']), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            StudentOrganization::with(['student', 'organization'])->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $record = StudentOrganization::findOrFail($id);

        $validated = $request->validate([
            'role'       => 'nullable|string|max:50',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'status'     => 'sometimes|string|max:20',
        ]);

        $record->update($validated);
        return response()->json($record->load(['student', 'organization']));
    }

    public function destroy(int $id): JsonResponse
    {
        StudentOrganization::findOrFail($id)->delete();
        return response()->json(['message' => 'Student organization record deleted successfully']);
    }
}