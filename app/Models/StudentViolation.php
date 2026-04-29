<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentViolation extends Model
{
    use HasFactory;

    protected $primaryKey = 'violation_id';

    protected $fillable = [
        'student_id',
        'violation_type_id',
        'violation_date',
        'description',
        'action_taken',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function violationType()
    {
        return $this->belongsTo(ViolationType::class, 'violation_type_id', 'violation_type_id');
    }
}