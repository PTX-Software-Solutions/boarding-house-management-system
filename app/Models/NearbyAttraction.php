<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NearbyAttraction extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'houseId',
        'name',
        'distance',
        'order',
        'distanceTypeId'
    ];

    public function distanceTypes()
    {
        return $this->hasOne(DistanceTypes::class, 'id', 'distanceTypeId');
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
