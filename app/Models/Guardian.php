<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guardian extends Model
{
    use HasFactory;

    protected $primaryKey = 'guardian_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_number',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'guardian_id', 'guardian_id');
    }
}