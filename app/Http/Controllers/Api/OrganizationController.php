<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Organization::with(['students', 'faculty'])->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:100',
            'organization_type' => 'required|string|max:50',
        ]);

        return response()->json(Organization::create($validated), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            Organization::with(['students', 'faculty'])->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $organization = Organization::findOrFail($id);

        $validated = $request->validate([
            'organization_name' => 'sometimes|string|max:100',
            'organization_type' => 'sometimes|string|max:50',
        ]);

        $organization->update($validated);
        return response()->json($organization);
    }

    public function destroy(int $id): JsonResponse
    {
        Organization::findOrFail($id)->delete();
        return response()->json(['message' => 'Organization deleted successfully']);
    }
}