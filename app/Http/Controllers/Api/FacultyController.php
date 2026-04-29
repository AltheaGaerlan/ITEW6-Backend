<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FacultyController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Faculty::with('department')
                ->withCount(['sections', 'subjects', 'organizations'])
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name'    => 'required|string|max:50',
            'last_name'     => 'required|string|max:50',
            'email'         => 'required|email|max:100|unique:faculty',
            'department_id' => 'required|exists:departments,department_id',
            'position'      => 'required|string|max:50',
            'expertise'     => 'required|string|max:50',
            'status'        => 'required|string|max:20',
        ]);

        $faculty = Faculty::create($validated);
        return response()->json($faculty->load('department')->loadCount(['sections', 'subjects', 'organizations']), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            Faculty::with(['department', 'sections', 'subjects.subject', 'organizations.organization'])
                ->withCount(['sections', 'subjects', 'organizations'])
                ->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $faculty = Faculty::findOrFail($id);

        $validated = $request->validate([
            'first_name'    => 'sometimes|string|max:50',
            'last_name'     => 'sometimes|string|max:50',
            'email'         => 'sometimes|email|max:100|unique:faculty,email,' . $id . ',faculty_id',
            'department_id' => 'sometimes|exists:departments,department_id',
            'position'      => 'sometimes|string|max:50',
            'expertise'     => 'sometimes|string|max:50',
            'status'        => 'sometimes|string|max:20',
        ]);

        $faculty->update($validated);
        return response()->json($faculty->load('department')->loadCount(['sections', 'subjects', 'organizations']));
    }

    public function destroy(int $id): JsonResponse
    {
        Faculty::findOrFail($id)->delete();
        return response()->json(['message' => 'Faculty deleted successfully']);
    }

    public function subjects(int $id): JsonResponse
    {
        return response()->json(Faculty::with('subjects.subject')->findOrFail($id)->subjects);
    }

    public function organizations(int $id): JsonResponse
    {
        return response()->json(Faculty::with('organizations.organization')->findOrFail($id)->organizations);
    }

    public function sections(int $id): JsonResponse
    {
        return response()->json(Faculty::with('sections')->findOrFail($id)->sections);
    }
}
