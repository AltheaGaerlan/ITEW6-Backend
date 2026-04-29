<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SkillController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Skill::with('students')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'skill_name'     => 'required|string|max:100',
            'skill_category' => 'required|string|max:50',
        ]);

        return response()->json(Skill::create($validated), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            Skill::with('students')->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $skill = Skill::findOrFail($id);

        $validated = $request->validate([
            'skill_name'     => 'sometimes|string|max:100',
            'skill_category' => 'sometimes|string|max:50',
        ]);

        $skill->update($validated);
        return response()->json($skill);
    }

    public function destroy(int $id): JsonResponse
    {
        Skill::findOrFail($id)->delete();
        return response()->json(['message' => 'Skill deleted successfully']);
    }
}