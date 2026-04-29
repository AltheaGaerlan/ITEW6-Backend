<?php

use Illuminate\Support\Facades\Route;
// Import your new Auth controller
use App\Http\Controllers\Auth\LoginController;

// Import your existing API controllers
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\GuardianController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\StudentSubjectController;
use App\Http\Controllers\Api\AcademicAwardController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\StudentOrganizationController;
use App\Http\Controllers\Api\NonAcademicActivityController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\StudentSkillController;
use App\Http\Controllers\Api\ViolationTypeController;
use App\Http\Controllers\Api\StudentViolationController;
use App\Http\Controllers\Api\FacultySubjectController;
use App\Http\Controllers\Api\FacultyOrganizationController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RoomController;

Route::get('/test', function () {
    return response()->json(['message' => 'Hello from API!']);
});

// The login route must be public so users can actually log in!
Route::post('/login', [LoginController::class, 'login']);


// We use 'auth:sanctum' to ensure only logged-in users with a token can enter

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    Route::get('dashboard/stats', [StudentController::class, 'stats']);
    Route::get('notifications', [NotificationController::class, 'index']);

    Route::apiResource('students', StudentController::class);
    Route::get('students/{id}/violations', [StudentController::class, 'violations']);
    Route::get('students/{id}/subjects',   [StudentController::class, 'subjects']);
    Route::get('students/{id}/skills',     [StudentController::class, 'skills']);
    Route::get('students/{id}/awards',     [StudentController::class, 'awards']);

    Route::get('faculty', [FacultyController::class, 'index']);
    Route::get('faculty/{faculty}', [FacultyController::class, 'show']);

    Route::get('departments', [DepartmentController::class, 'index']);
    Route::get('departments/{department}', [DepartmentController::class, 'show']);

    Route::get('sections', [SectionController::class, 'index']);
    Route::get('sections/{section}', [SectionController::class, 'show']);

    Route::get('rooms', [RoomController::class, 'index']);
    Route::get('rooms/{room}', [RoomController::class, 'show']);
    Route::get('rooms/{id}/sections', [RoomController::class, 'sections']);

    Route::get('subjects', [SubjectController::class, 'index']);
    Route::get('subjects/{subject}', [SubjectController::class, 'show']);
    

    Route::apiResource('guardians', GuardianController::class);
    Route::apiResource('student-subjects', StudentSubjectController::class);
    Route::apiResource('academic-awards', AcademicAwardController::class);
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('student-organizations', StudentOrganizationController::class);
    Route::apiResource('non-academic-activities', NonAcademicActivityController::class);


    Route::apiResource('skills', SkillController::class);
    Route::apiResource('student-skills', StudentSkillController::class);
    Route::apiResource('violation-types', ViolationTypeController::class);
    Route::apiResource('student-violations', StudentViolationController::class);


    Route::apiResource('faculty-subjects', FacultySubjectController::class);
    Route::apiResource('faculty-organizations', FacultyOrganizationController::class);
    
    Route::get('/user-profile', [ProfileController::class, 'show']);
    Route::put('/user-profile/update', [ProfileController::class, 'update']);

    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('v1')->group(function () {
    Route::post('faculty', [FacultyController::class, 'store']);
    Route::put('faculty/{faculty}', [FacultyController::class, 'update']);
    Route::patch('faculty/{faculty}', [FacultyController::class, 'update']);
    Route::delete('faculty/{faculty}', [FacultyController::class, 'destroy']);

    Route::post('departments', [DepartmentController::class, 'store']);
    Route::put('departments/{department}', [DepartmentController::class, 'update']);
    Route::patch('departments/{department}', [DepartmentController::class, 'update']);
    Route::delete('departments/{department}', [DepartmentController::class, 'destroy']);

    Route::post('sections', [SectionController::class, 'store']);
    Route::put('sections/{section}', [SectionController::class, 'update']);
    Route::patch('sections/{section}', [SectionController::class, 'update']);
    Route::delete('sections/{section}', [SectionController::class, 'destroy']);

    Route::post('rooms', [RoomController::class, 'store']);
    Route::put('rooms/{room}', [RoomController::class, 'update']);
    Route::patch('rooms/{room}', [RoomController::class, 'update']);
    Route::delete('rooms/{room}', [RoomController::class, 'destroy']);

    Route::post('subjects', [SubjectController::class, 'store']);
    Route::put('subjects/{subject}', [SubjectController::class, 'update']);
    Route::patch('subjects/{subject}', [SubjectController::class, 'update']);
    Route::delete('subjects/{subject}', [SubjectController::class, 'destroy']);

    Route::get('/users', [ProfileController::class, 'index']);
    Route::post('/users', [ProfileController::class, 'store']);
    Route::delete('/users/{id}', [ProfileController::class, 'destroy']);
});
