<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    protected $primaryKey = 'skill_id';

    protected $fillable = [
        'skill_name',
        'skill_category',
    ];

    public function students()
    {
        return $this->hasMany(StudentSkill::class, 'skill_id', 'skill_id');
    }
}