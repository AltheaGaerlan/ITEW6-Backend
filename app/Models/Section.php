<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $primaryKey = 'section_id';

    protected $fillable = [
        'section_name',
        'year_level',
        'school_year',
        'adviser_id',
        'room_id',
    ];

    public function adviser()
    {
        return $this->belongsTo(Faculty::class, 'adviser_id', 'faculty_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'section_id', 'section_id');
    }
}