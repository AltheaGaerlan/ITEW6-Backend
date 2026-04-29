<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentSubject;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentSubjectController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            StudentSubject::with(['student', 'subject'])->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id'  => 'required|exists:students,student_id',
            'subject_id'  => 'required|exists:subjects,subject_id',
            'school_year' => 'required|string|max:20',
            'semester'    => 'required|string|max:20',
            'grade'       => 'nullable|numeric|min:0|max:100',
            'remarks'     => 'nullable|string|max:50',
        ]);

        $record = StudentSubject::create($validated);
        return response()->json($record->load(['student', 'subject']), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            StudentSubject::with(['student', 'subject'])->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $record = StudentSubject::findOrFail($id);

        $validated = $request->validate([
            'school_year' => 'sometimes|string|max:20',
            'semester'    => 'sometimes|string|max:20',
            'grade'       => 'nullable|numeric|min:0|max:100',
            'remarks'     => 'nullable|string|max:50',
        ]);

        $record->update($validated);
        return response()->json($record->load(['student', 'subject']));
    }

    public function destroy(int $id): JsonResponse
    {
        StudentSubject::findOrFail($id)->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }
}