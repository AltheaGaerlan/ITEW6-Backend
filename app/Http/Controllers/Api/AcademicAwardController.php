<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicAward;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AcademicAwardController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(AcademicAward::with('student')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id'  => 'required|exists:students,student_id',
            'school_year' => 'required|string|max:20',
            'GPA'         => 'required|numeric|min:0|max:4',
            'honors'      => 'nullable|string|max:50',
        ]);

        $award = AcademicAward::create($validated);
        return response()->json($award->load('student'), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(AcademicAward::with('student')->findOrFail($id));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $award = AcademicAward::findOrFail($id);

        $validated = $request->validate([
            'school_year' => 'sometimes|string|max:20',
            'GPA'         => 'sometimes|numeric|min:0|max:4',
            'honors'      => 'nullable|string|max:50',
        ]);

        $award->update($validated);
        return response()->json($award->load('student'));
    }

    public function destroy(int $id): JsonResponse
    {
        AcademicAward::findOrFail($id)->delete();
        return response()->json(['message' => 'Award deleted successfully']);
    }
}