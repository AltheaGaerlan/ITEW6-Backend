<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculty';
    protected $primaryKey = 'faculty_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'department_id',
        'position',
        'expertise',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'adviser_id', 'faculty_id');
    }

    public function subjects()
    {
        return $this->hasMany(FacultySubject::class, 'faculty_id', 'faculty_id');
    }

    public function organizations()
    {
        return $this->hasMany(FacultyOrganization::class, 'faculty_id', 'faculty_id');
    }
}