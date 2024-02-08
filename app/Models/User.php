<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Casts\UserTypeCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'origination_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed',
    // ];

    // protected $userTypes = [
    //     "admin",
    //     "user1",
    //     "user2",
    //     "user3",
    //     "user4",
    // ];

    // public function setTypeAttribute($value)
    // {
    //     $this->attributes['user_type'] = array_search($value, $this->userTypes);
    // }

    // public function getTypeAttribute($value)
    // {
    //     return $this->userTypes[$value];
    // }



    protected $casts = [
        'email_verified_at' => 'datetime',
        'userType' => UserTypeCast::class, // Use your custom cast class here
    ];
}
