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
        'paymentAgreementId',
        'statusId'
    ];

    public function getHouse()
    {
        return $this->belongsTo(House::class, 'houseId');
    }

    public function getRoomImages()
    {
        return $this->hasMany(roomImage::class, 'roomId', 'id');
    }

    public function getAmenities()
    {
        return $this->hasMany(Amenity::class, 'amenityId', 'id');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_amenities', 'roomId', 'amenityId');
    }

    public function getRoomType()
    {
        return $this->hasOne(RoomType::class, 'id', 'roomTypeId');
    }

    public function getStatus()
    {
        return $this->hasOne(Status::class, 'id', 'statusId');
    }

    public function getPaymentAgreement()
    {
        return $this->hasOne(PaymentAgreementType::class, 'id', 'paymentAgreementId');
    }

    public function getRoomUtilities()
    {
        return $this->hasMany(RoomUtility::class, 'roomId', 'id');
    }
}
