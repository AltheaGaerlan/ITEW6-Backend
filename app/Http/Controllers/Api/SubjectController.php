<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Subject::with(['department', 'prerequisite'])
                ->orderBy('subject_code')
                ->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'subject_code'  => 'required|string|max:20|unique:subjects',
            'subject_name'  => 'required|string|max:100',
            'description'   => 'nullable|string',
            'units'         => 'required|integer|min:0|max:10',
            'lecture_hours' => 'required|integer|min:0',
            'lab_hours'     => 'required|integer|min:0',
            'department_id' => 'required|exists:departments,department_id',
            'prerequisite_subject_id' => 'nullable|exists:subjects,subject_id',
            'course_category' => 'sometimes|string|max:30',
            'semester'      => 'nullable|string|max:20',
        ]);

        $this->validatePrerequisite($validated['subject_code'], $validated['prerequisite_subject_id'] ?? null);

        $subject = Subject::create($validated);
        return response()->json($subject->load(['department', 'prerequisite']), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            Subject::with(['department', 'prerequisite', 'students', 'faculty'])->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $subject = Subject::findOrFail($id);

        $validated = $request->validate([
            'subject_code'  => 'sometimes|string|max:20|unique:subjects,subject_code,' . $id . ',subject_id',
            'subject_name'  => 'sometimes|string|max:100',
            'description'   => 'nullable|string',
            'units'         => 'sometimes|integer|min:0|max:10',
            'lecture_hours' => 'sometimes|integer|min:0',
            'lab_hours'     => 'sometimes|integer|min:0',
            'department_id' => 'sometimes|exists:departments,department_id',
            'prerequisite_subject_id' => 'nullable|exists:subjects,subject_id',
            'course_category' => 'sometimes|string|max:30',
            'semester'      => 'nullable|string|max:20',
        ]);

        $nextSubjectCode = $validated['subject_code'] ?? $subject->subject_code;
        $nextPrerequisiteId = array_key_exists('prerequisite_subject_id', $validated)
            ? $validated['prerequisite_subject_id']
            : $subject->prerequisite_subject_id;

        $this->validatePrerequisite($nextSubjectCode, $nextPrerequisiteId, $subject->subject_id);

        $subject->update($validated);
        return response()->json($subject->load(['department', 'prerequisite']));
    }

    public function destroy(int $id): JsonResponse
    {
        Subject::findOrFail($id)->delete();
        return response()->json(['message' => 'Subject deleted successfully']);
    }

    protected function validatePrerequisite(string $subjectCode, ?int $prerequisiteSubjectId, ?int $currentSubjectId = null): void
    {
        if ($prerequisiteSubjectId === null) {
            return;
        }

        if ($currentSubjectId !== null && $prerequisiteSubjectId === $currentSubjectId) {
            throw ValidationException::withMessages([
                'prerequisite_subject_id' => ['A subject cannot be its own prerequisite.'],
            ]);
        }

        $prerequisite = Subject::find($prerequisiteSubjectId);

        if ($prerequisite && $prerequisite->subject_code === $subjectCode) {
            throw ValidationException::withMessages([
                'prerequisite_subject_id' => ['A subject cannot use itself as a prerequisite.'],
            ]);
        }
    }
}
