<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Department::with(['faculty', 'subjects'])->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:100|unique:departments',
        ]);

        return response()->json(Department::create($validated), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(Department::with(['faculty', 'subjects'])->findOrFail($id));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $department = Department::findOrFail($id);

        $validated = $request->validate([
            'department_name' => 'required|string|max:100|unique:departments,department_name,' . $id . ',department_id',
        ]);

        $department->update($validated);
        return response()->json($department);
    }

    public function destroy(int $id): JsonResponse
    {
        Department::findOrFail($id)->delete();
        return response()->json(['message' => 'Department deleted successfully']);
    }
}