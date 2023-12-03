<?php

namespace App\Models;

use App\Enums\UserTypeEnums;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, UUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'profileImage',
        'userTypeId'
    ];

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if (is_null($this->lastName)) {
            return "{$this->firstName}";
        }

        return "{$this->firstName} {$this->lastName}";
    }

    public function userType(): HasOne
    {
        return $this->hasOne(UserType::class, 'id', 'userTypeId');
    }

    public function isUser()
    {
        return $this->userType->name === UserTypeEnums::USER;
    }

    public function isAdmin()
    {
        return $this->userType->name === UserTypeEnums::ADMIN;
    }

    public function isManagement()
    {
        return $this->userType->name === UserTypeEnums::MANAGEMENT;
    }
}
