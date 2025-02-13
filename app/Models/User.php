<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }


    public function userVerifications()
    {
        return $this->hasMany(UserVerification::class);
    }

    // public function ads()
    // {
    //     return $this->belongsToMany(Ad::class, 'user_ads', 'user_id', 'ad_id');
    // }

    public function backgrounds()
    {
        return $this->hasMany(Background::class);
    }

    public function hobbies()
    {
        return $this->hasMany(Hobby::class);
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'user_interests', 'user_id', 'interest_id');
    }

    // public function intention()
    // {
    //     return $this->belongsTo(intention::class);
    // }

    public function isAdmin()
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isUser()
    {
        return $this->role === UserRole::USER;
    }

    // public function

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
