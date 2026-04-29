<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'birthdate',
        'civil_status',
        'contact_number',
        'email',
        'address',
        'section_id',
        'status',
        'guardian_id',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'section_id');
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id', 'guardian_id');
    }

    public function subjects()
    {
        return $this->hasMany(StudentSubject::class, 'student_id', 'student_id');
    }

    public function academicAwards()
    {
        return $this->hasMany(AcademicAward::class, 'student_id', 'student_id');
    }

    public function organizations()
    {
        return $this->hasMany(StudentOrganization::class, 'student_id', 'student_id');
    }

    public function nonAcademicActivities()
    {
        return $this->hasMany(NonAcademicActivity::class, 'student_id', 'student_id');
    }

    public function skills()
    {
        return $this->hasMany(StudentSkill::class, 'student_id', 'student_id');
    }

    public function violations()
    {
        return $this->hasMany(StudentViolation::class, 'student_id', 'student_id');
    }
}