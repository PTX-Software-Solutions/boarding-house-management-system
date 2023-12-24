<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'userId',
        'houseId',
        'roomId',
        'statusId',
        'checkIn',
        'checkOut',
        'note'
    ];

    public function getUser(): HasOne {
        return $this->hasOne(User::class, 'id', 'userId');
    }

    public function getHouse(): HasOne {
        return $this->hasOne(House::class, 'id', 'houseId');
    }

    public function getRoom(): HasOne {
        return $this->hasOne(Room::class, 'id', 'roomId');
    }

    public function getStatus(): HasOne {
        return $this->hasOne(Status::class, 'id', 'statusId');
    }

}
