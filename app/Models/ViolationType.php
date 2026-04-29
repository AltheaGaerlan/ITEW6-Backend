<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ViolationType extends Model
{
    use HasFactory;

    protected $primaryKey = 'violation_type_id';

    protected $fillable = [
        'violation_name',
        'severity_level',
    ];

    public function violations()
    {
        return $this->hasMany(StudentViolation::class, 'violation_type_id', 'violation_type_id');
    }
}