<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'country_code',
        'phone_code',
        'phone_digits',
        'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const ACTIVE = 'ACTIVE';

    public function userProfiles()
    {
        return $this->hasMany(UserProfile::class);
    }

    public function scopeActive($query)
    {
        return $this->query('status', self::ACTIVE);
    }
}
