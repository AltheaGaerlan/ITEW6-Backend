<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FacultyOrganization;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FacultyOrganizationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            FacultyOrganization::with(['faculty', 'organization'])->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'faculty_id'      => 'required|exists:faculty,faculty_id',
            'organization_id' => 'required|exists:organizations,organization_id',
            'role'            => 'nullable|string|max:50',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
        ]);

        $record = FacultyOrganization::create($validated);
        return response()->json($record->load(['faculty', 'organization']), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            FacultyOrganization::with(['faculty', 'organization'])->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $record = FacultyOrganization::findOrFail($id);

        $validated = $request->validate([
            'role'       => 'nullable|string|max:50',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $record->update($validated);
        return response()->json($record->load(['faculty', 'organization']));
    }

    public function destroy(int $id): JsonResponse
    {
        FacultyOrganization::findOrFail($id)->delete();
        return response()->json(['message' => 'Faculty organization record deleted successfully']);
    }
}