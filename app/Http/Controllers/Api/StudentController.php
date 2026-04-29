<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    // GET /api/v1/students
    public function index(Request $request): JsonResponse
    {
        $query = Student::with([
            'section',
            'guardian',
            'skills.skill',  
            'skills',
            'violations'
        ]);

        // Handle search query
        if ($request->has('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('student_number', 'like', "%{$search}%");
            });
        }

        // Handle skill filter
        if ($request->has('skill')) {
            $skill = $request->input('skill');
            $query->whereHas('skills', function ($q) use ($skill) {
                // This looks at the 'skill()' relationship in your StudentSkill model
                $q->whereHas('skill', function ($subQ) use ($skill) {
                    // This is where the actual column 'skill_name' lives
                    $subQ->whereRaw('LOWER(skill_name) LIKE ?', ["%" . strtolower($skill) . "%"]);
                });
            });
        }

        $perPage = $request->query('limit');
        $page = $request->query('page', 1);

        $query->latest('student_id');

        if ($perPage) {
            $students = $query->paginate(intval($perPage), ['*'], 'page', intval($page));
            return response()->json($students);
        }

        $students = $query->get();
        return response()->json($students);
    }

    // POST /api/v1/students
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_number' => 'required|string|max:20|unique:students',
            'first_name'     => 'required|string|max:50',
            'last_name'      => 'required|string|max:50',
            'middle_name'    => 'nullable|string|max:50',
            'gender'         => 'required|string|max:10',
            'birthdate'      => 'required|date',
            'civil_status'   => 'nullable|string|max:20',
            'contact_number' => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:100',
            'address'        => 'nullable|string',
            'section_id'     => 'required|exists:sections,section_id',
            'status'         => 'required|string|max:20',
            'guardian_id'    => 'required|exists:guardians,guardian_id',
        ]);

        $student = Student::create($validated);
        return response()->json($student->load(['section', 'guardian']), 201);
    }

    // GET /api/v1/students/{id}
    public function show(int $id): JsonResponse
    {
        $student = Student::with([
            'section',
            'guardian',
            'subjects.subject',
            'academicAwards',
            'organizations.organization',
            'nonAcademicActivities',
            'skills.skill',
            'violations.violationType',
        ])->findOrFail($id);

        return response()->json($student);
    }

    // PUT /api/v1/students/{id}
    public function update(Request $request, int $id): JsonResponse
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'student_number' => 'sometimes|string|max:20|unique:students,student_number,' . $id . ',student_id',
            'first_name'     => 'sometimes|string|max:50',
            'last_name'      => 'sometimes|string|max:50',
            'middle_name'    => 'nullable|string|max:50',
            'gender'         => 'sometimes|string|max:10',
            'birthdate'      => 'sometimes|date',
            'civil_status'   => 'nullable|string|max:20',
            'contact_number' => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:100',
            'address'        => 'nullable|string',
            'section_id'     => 'sometimes|exists:sections,section_id',
            'status'         => 'sometimes|string|max:20',
            'guardian_id'    => 'sometimes|exists:guardians,guardian_id',
        ]);

        $student->update($validated);
        return response()->json($student->load(['section', 'guardian']));
    }

   // DELETE /api/v1/students/{id}
public function destroy(int $id): JsonResponse
{
    $student = Student::findOrFail($id);

    
    $student->violations()->delete();
    $student->subjects()->delete();
    $student->skills()->delete();
    $student->organizations()->delete();
    $student->nonAcademicActivities()->delete();
    $student->academicAwards()->delete();

    $student->delete();

    return response()->json(['message' => 'Student deleted successfully']);
}

    // GET /api/v1/students/{id}/violations
    public function violations(int $id): JsonResponse
    {
        $student = Student::with('violations.violationType')->findOrFail($id);
        return response()->json($student->violations);
    }

    // GET /api/v1/students/{id}/subjects
    public function subjects(int $id): JsonResponse
    {
        $student = Student::with('subjects.subject')->findOrFail($id);
        return response()->json($student->subjects);
    }

    // GET /api/v1/students/{id}/skills
    public function skills(int $id): JsonResponse
    {
        $student = Student::with('skills.skill')->findOrFail($id);
        return response()->json($student->skills);
    }

    // GET /api/v1/students/{id}/awards
    public function awards(int $id): JsonResponse
    {
        $student = Student::with('academicAwards')->findOrFail($id);
        return response()->json($student->academicAwards);
    }

    // GET /api/v1/dashboard/stats
    public function stats(): JsonResponse
    {
        // SQLite doesn't have CURDATE, we use strftime or just calculate in PHP
        $avgAge = Student::all()->map(function ($student) {
            return \Carbon\Carbon::parse($student->birthdate)->age;
        })->avg();

        return response()->json([
            'total_students'  => Student::count(),
            'active_profiles' => Student::where('status', 'Active')->count(),
            'average_age'     => round($avgAge ?? 0),
        ]);
    }
}
