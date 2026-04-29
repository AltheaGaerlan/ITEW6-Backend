<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $primaryKey = 'organization_id';

    protected $fillable = [
        'organization_name',
        'organization_type',
    ];

    public function students()
    {
        return $this->hasMany(StudentOrganization::class, 'organization_id', 'organization_id');
    }

    public function faculty()
    {
        return $this->hasMany(FacultyOrganization::class, 'organization_id', 'organization_id');
    }
}