<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentSkill;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentSkillController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            StudentSkill::with(['student', 'skill'])->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id'    => 'required|exists:students,student_id',
            'skill_id'      => 'required|exists:skills,skill_id',
            'skill_level'   => 'nullable|string|max:50',
            'certification' => 'nullable|string|max:100',
            'date_acquired' => 'nullable|date',
        ]);

        $record = StudentSkill::create($validated);
        return response()->json($record->load(['student', 'skill']), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            StudentSkill::with(['student', 'skill'])->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $record = StudentSkill::findOrFail($id);

        $validated = $request->validate([
            'skill_level'   => 'nullable|string|max:50',
            'certification' => 'nullable|string|max:100',
            'date_acquired' => 'nullable|date',
        ]);

        $record->update($validated);
        return response()->json($record->load(['student', 'skill']));
    }

    public function destroy(int $id): JsonResponse
    {
        StudentSkill::findOrFail($id)->delete();
        return response()->json(['message' => 'Student skill deleted successfully']);
    }
}