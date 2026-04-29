<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $primaryKey = 'room_id';

    protected $fillable = [
        'room_name',
        'room_type',
        'capacity',
        'building',
        'floor',
        'status',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'floor' => 'integer',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class, 'room_id', 'room_id');
    }
}