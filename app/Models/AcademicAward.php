<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicAward extends Model
{
    use HasFactory;

    protected $primaryKey = 'award_id';

    protected $fillable = [
        'student_id',
        'school_year',
        'GPA',
        'honors',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}