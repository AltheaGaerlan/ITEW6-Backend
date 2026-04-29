<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NonAcademicActivity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NonAcademicActivityController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            NonAcademicActivity::with('student')->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id'    => 'required|exists:students,student_id',
            'activity_name' => 'required|string|max:100',
            'category'      => 'required|string|max:50',
            'achievement'   => 'nullable|string|max:100',
            'activity_date' => 'required|date',
        ]);

        $activity = NonAcademicActivity::create($validated);
        return response()->json($activity->load('student'), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            NonAcademicActivity::with('student')->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $activity = NonAcademicActivity::findOrFail($id);

        $validated = $request->validate([
            'activity_name' => 'sometimes|string|max:100',
            'category'      => 'sometimes|string|max:50',
            'achievement'   => 'nullable|string|max:100',
            'activity_date' => 'sometimes|date',
        ]);

        $activity->update($validated);
        return response()->json($activity->load('student'));
    }

    public function destroy(int $id): JsonResponse
    {
        NonAcademicActivity::findOrFail($id)->delete();
        return response()->json(['message' => 'Activity deleted successfully']);
    }
}