<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'houseId',
        'userId',
        'message'
    ];

    public function getUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }

    public function getHouse(): HasOne
    {
        return $this->hasOne(House::class, 'id', 'houseId');
    }
}
