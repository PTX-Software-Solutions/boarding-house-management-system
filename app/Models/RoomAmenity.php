<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomAmenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'roomId',
        'amenityId',
    ];

    // public function getAmenity()
    // {
    //     return $this->belongsTo(Amenity::class, 'amenityId', 'id');
    // }
}
