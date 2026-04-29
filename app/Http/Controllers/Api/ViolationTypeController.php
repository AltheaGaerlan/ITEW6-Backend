<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ViolationType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ViolationTypeController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ViolationType::with('violations')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'violation_name' => 'required|string|max:100',
            'severity_level' => 'required|string|max:20',
        ]);

        return response()->json(ViolationType::create($validated), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            ViolationType::with('violations')->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $violationType = ViolationType::findOrFail($id);

        $validated = $request->validate([
            'violation_name' => 'sometimes|string|max:100',
            'severity_level' => 'sometimes|string|max:20',
        ]);

        $violationType->update($validated);
        return response()->json($violationType);
    }

    public function destroy(int $id): JsonResponse
    {
        ViolationType::findOrFail($id)->delete();
        return response()->json(['message' => 'Violation type deleted successfully']);
    }
}