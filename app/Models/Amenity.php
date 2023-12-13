<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amenity extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'name',
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_amenities', 'amenityId', 'roomId');
    }
}
