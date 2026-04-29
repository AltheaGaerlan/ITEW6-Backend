<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SectionController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Section::with(['adviser', 'room'])
                ->withCount('students')
                ->orderBy('school_year', 'desc')
                ->orderBy('section_name')
                ->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'section_name' => 'required|string|max:50',
            'year_level'   => 'required|integer',
            'school_year'  => 'required|string|max:20',
            'adviser_id'   => 'nullable|exists:faculty,faculty_id',
            'room_id'      => 'nullable|exists:rooms,room_id',
        ]);

        $this->validateSectionUniqueness($validated['section_name'], $validated['school_year']);

        $section = Section::create($validated);
        return response()->json($section->load(['adviser', 'room'])->loadCount('students'), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            Section::with(['adviser', 'students', 'room'])->withCount('students')->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $section = Section::findOrFail($id);

        $validated = $request->validate([
            'section_name' => 'sometimes|string|max:50',
            'year_level'   => 'sometimes|integer',
            'school_year'  => 'sometimes|string|max:20',
            'adviser_id'   => 'nullable|exists:faculty,faculty_id',
            'room_id'      => 'nullable|exists:rooms,room_id',
        ]);

        $this->validateSectionUniqueness(
            $validated['section_name'] ?? $section->section_name,
            $validated['school_year'] ?? $section->school_year,
            $section->section_id
        );

        $section->update($validated);
        return response()->json($section->load(['adviser', 'room'])->loadCount('students'));
    }

    public function destroy(int $id): JsonResponse
    {
        Section::findOrFail($id)->delete();
        return response()->json(['message' => 'Section deleted successfully']);
    }

    // GET /api/v1/sections/{id}/students
    public function students(int $id): JsonResponse
    {
        return response()->json(
            Section::with('students')->findOrFail($id)->students
        );
    }

    protected function validateSectionUniqueness(string $sectionName, string $schoolYear, ?int $ignoreSectionId = null): void
    {
        $query = Section::query()
            ->where('section_name', $sectionName)
            ->where('school_year', $schoolYear);

        if ($ignoreSectionId !== null) {
            $query->where('section_id', '!=', $ignoreSectionId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'section_name' => ['A section with the same name already exists for this school year.'],
            ]);
        }
    }
}
