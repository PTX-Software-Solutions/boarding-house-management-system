<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'name',
        'monthlyDeposit',
        'houseId',
        'roomTypeId',
        'statusId'
    ];

    public function getRoomImages()
    {
        return $this->hasMany(roomImage::class, 'roomId', 'id');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_amenities', 'roomId', 'amenityId');
    }

    public function getRoomType()
    {
        return $this->hasOne(RoomType::class, 'id', 'roomTypeId');
    }
}
