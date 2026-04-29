<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FacultySubject;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FacultySubjectController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            FacultySubject::with(['faculty', 'subject'])->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'faculty_id'  => 'required|exists:faculty,faculty_id',
            'subject_id'  => 'required|exists:subjects,subject_id',
            'school_year' => 'required|string|max:20',
            'semester'    => 'required|string|max:20',
        ]);

        $record = FacultySubject::create($validated);
        return response()->json($record->load(['faculty', 'subject']), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            FacultySubject::with(['faculty', 'subject'])->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $record = FacultySubject::findOrFail($id);

        $validated = $request->validate([
            'faculty_id'  => 'sometimes|exists:faculty,faculty_id',
            'subject_id'  => 'sometimes|exists:subjects,subject_id',
            'school_year' => 'sometimes|string|max:20',
            'semester'    => 'sometimes|string|max:20',
        ]);

        $record->update($validated);
        return response()->json($record->load(['faculty', 'subject']));
    }

    public function destroy(int $id): JsonResponse
    {
        FacultySubject::findOrFail($id)->delete();
        return response()->json(['message' => 'Faculty subject record deleted successfully']);
    }
}