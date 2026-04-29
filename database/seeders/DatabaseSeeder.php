<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Guardian;
use App\Models\Faculty;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Skill;
use App\Models\Organization;
use App\Models\ViolationType;
use App\Models\StudentSkill;
use App\Models\StudentViolation;
use App\Models\StudentSubject;
use App\Models\AcademicAward;
use App\Models\StudentOrganization;
use App\Models\NonAcademicActivity;
use App\Models\FacultySubject;
use App\Models\FacultyOrganization;
use App\Models\User;
use App\Models\Room;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username' => 'admin',
                'name' => 'System Admin',
                'role' => 'admin',
                'password' => Hash::make('password123'),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'username' => 'user',
                'name' => 'Standard User',
                'role' => 'user',
                'password' => Hash::make('user123'),
            ]
        );

        Department::factory(3)->create();
        Room::factory(15)->create();
        Guardian::factory(20)->create();

        $faculty = Faculty::factory(10)->create();
        Section::factory(5)->create();
        $subjects = Subject::factory(8)->create();

        $students = Student::factory(1000)->create();
    
        $skills = Skill::factory(10)->create();
        $organizations = Organization::factory(5)->create();

        $violations = collect([
            ['name' => 'Late Attendance', 'severity' => 'Low'],
            ['name' => 'Absence Without Excuse', 'severity' => 'Medium'],
            ['name' => 'Dress Code Violation', 'severity' => 'Low'],
            ['name' => 'Academic Dishonesty', 'severity' => 'High'],
            ['name' => 'Misconduct', 'severity' => 'High'],
        ])->map(function (array $type) {
            return ViolationType::updateOrCreate(
                ['violation_name' => $type['name']],
                ['severity_level' => $type['severity']]
            );
        });

        foreach ($students as $student) {
            $studentSkills = $skills->random(rand(1, 3));
            foreach ($studentSkills as $skill) {
                StudentSkill::factory()->create([
                    'student_id' => $student->student_id,
                    'skill_id' => $skill->skill_id,
                ]);
            }

            $studentSubjects = $subjects->random(rand(3, min(6, $subjects->count())));
            foreach ($studentSubjects as $subject) {
                StudentSubject::factory()->create([
                    'student_id' => $student->student_id,
                    'subject_id' => $subject->subject_id,
                    'school_year' => '2024-2025',
                    'semester' => '1st',
                ]);
            }

            $studentOrgs = $organizations->random(rand(0, 2));
            foreach ($studentOrgs as $org) {
                StudentOrganization::factory()->create([
                    'student_id' => $student->student_id,
                    'organization_id' => $org->organization_id,
                ]);
            }

            StudentViolation::factory(rand(0, 2))->create([
                'student_id' => $student->student_id,
                'violation_type_id' => $violations->random()->violation_type_id,
                'status' => 'Pending',
            ]);

            AcademicAward::factory(rand(0, 1))->create([
                'student_id' => $student->student_id,
                'school_year' => '2024-2025',
            ]);

            NonAcademicActivity::factory(rand(0, 2))->create([
                'student_id' => $student->student_id,
            ]);
        }

        foreach ($faculty as $member) {
            $facultySubjects = $subjects->random(rand(1, 3));
            foreach ($facultySubjects as $subject) {
                FacultySubject::factory()->create([
                    'faculty_id' => $member->faculty_id,
                    'subject_id' => $subject->subject_id,
                    'school_year' => '2024-2025',
                    'semester' => '1st',
                ]);
            }

            $facultyOrgs = $organizations->random(rand(0, 2));
            foreach ($facultyOrgs as $org) {
                FacultyOrganization::factory()->create([
                    'faculty_id' => $member->faculty_id,
                    'organization_id' => $org->organization_id,
                ]);
            }
        }
    }
}
