<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'profileImage'
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

    // public function generateNewProfileImage($value)
    // {

    //     dd($value);
    //     $randomName = Str::random(20);
    //     $extension = $value->getClientOriginalExtension();
    //     $newName = $randomName . '.' . $extension;

    //     Log::debug($newName);

    //     return $newName;
    // }

    // protected function profileImage(): Attribute {
    //     return Attribute::make(
    //         get: fn(string $value) => ucfirst($value),
    //         set: fn(string $value) => $value ? $this->generateNewProfileImage($value) : null
    //     );
    // }

    // public function setProfileImageAttribute($value)
    // {
    //     if ($this->attributes['profileImage']) {
    //         $this->attributes['profileImage'] = $this->generateNewProfileImage($value);
    //     }
    // }

    // public function storeImage

    // /**
    //  * Set the user's password.
    //  *
    //  * @param string $value
    //  * @return void
    //  */
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }
}
