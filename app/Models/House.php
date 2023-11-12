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
        'houseName',
        'contact',
        'address',
        'address2',
        'city',
        'zip',
        'longitude',
        'latitude'
    ];
}
