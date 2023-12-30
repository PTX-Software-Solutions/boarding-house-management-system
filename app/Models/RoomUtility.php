<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomUtility extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'roomId',
        'roomUtilityType',
        'roomUtilityScope',
        'price',
        'order'
    ];

    public function getRoomUtilityType()
    {
        return $this->hasOne(RoomUtilityType::class, 'id', 'roomUtilityType');
    }

    public function getRoomUtilityScope()
    {
        return $this->hasOne(RoomUtilityScope::class, 'id', 'roomUtilityScope');
    }
}
