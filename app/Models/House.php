<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'userId',
        'houseName',
        'contact',
        'address',
        'address2',
        'city',
        'zip',
        'longitude',
        'latitude',
        'paymentTypeId'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function getPaymentType()
    {
        return $this->belongsTo(PaymentType::class, 'paymentTypeId');
    }

    public function nearbyAttraction()
    {
        return $this->hasMany(NearbyAttraction::class, 'houseId', 'id');
    }

    public function getHousePhoto()
    {
        return $this->hasMany(HouseImage::class, 'houseId', 'id');
    }

    public function getNearbyAttractionInOrder()
    {
        return $this->hasMany(NearbyAttraction::class, 'houseId', 'id')->orderBy('order', 'ASC');
    }

    public function getNearbyAttractions()
    {
        return $this->hasMany(NearbyAttraction::class, 'houseId', 'id');
    }

    public function getHomeRooms()
    {
        return $this->hasMany(Room::class, 'houseId', 'id');
    }

    public function getRooms()
    {
        return $this->hasMany(Room::class, 'houseId', 'id');
    }

    public function getSocialLinksInOrder()
    {
        return $this->hasMany(SocialMedia::class, 'houseId', 'id')->orderBy('order', 'ASC');
    }

    public function getSocialLinks()
    {
        return $this->hasMany(SocialMedia::class, 'houseId', 'id');
    }

    public function getRatings()
    {
        return $this->hasMany(Rating::class, 'houseId', 'id');
    }
}
