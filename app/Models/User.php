<?php

namespace App\Models;

use App\Enums\StatusEnums;
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
        'userTypeId',
        'statusId'
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

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'statusId');
    }

    public function userType(): HasOne
    {
        return $this->hasOne(UserType::class, 'id', 'userTypeId');
    }

    public function isUser()
    {
        return $this->userType->serial_id === UserTypeEnums::USER;
    }

    public function isAdmin()
    {
        return $this->userType->serial_id === UserTypeEnums::ADMIN;
    }

    public function isBanned()
    {
        return $this->status->serial_id === StatusEnums::BANNED;
    }

    public function isManagement()
    {
        return $this->userType->serial_id === UserTypeEnums::MANAGEMENT;
    }
}
