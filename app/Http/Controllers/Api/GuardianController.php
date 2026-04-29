<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GuardianController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Guardian::with('students')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:50',
            'last_name'      => 'required|string|max:50',
            'email'          => 'required|email|max:100|unique:guardians',
            'contact_number' => 'nullable|string|max:20',
        ]);

        return response()->json(Guardian::create($validated), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(Guardian::with('students')->findOrFail($id));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $guardian = Guardian::findOrFail($id);

        $validated = $request->validate([
            'first_name'     => 'sometimes|string|max:50',
            'last_name'      => 'sometimes|string|max:50',
            'email'          => 'sometimes|email|max:100|unique:guardians,email,' . $id . ',guardian_id',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $guardian->update($validated);
        return response()->json($guardian);
    }

    public function destroy(int $id): JsonResponse
    {
        Guardian::findOrFail($id)->delete();
        return response()->json(['message' => 'Guardian deleted successfully']);
    }
}