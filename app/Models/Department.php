<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $primaryKey = 'department_id';

    protected $fillable = [
        'department_name',
    ];

    public function faculty()
    {
        return $this->hasMany(Faculty::class, 'department_id', 'department_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'department_id', 'department_id');
    }
}