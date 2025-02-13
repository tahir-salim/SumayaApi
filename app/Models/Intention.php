<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Intention extends Model
{
    use HasFactory;

    protected $table = 'intentions';
    protected $fillable = [
        'name_en',
        'name_ar',
        'status'
    ];

    const ACTIVE = 'ACTIVE';
    const CACHE_TAGS = ['intention-tags'];

    public function letters()
    {
        return $this->hasMany(Letter::class);
    }

    public function affirmations()
    {
        return $this->hasMany(Affirmation::class);
    }

    public function users()
    {
        return $this->hasMany(UserProfile::class);
    }

    public function scopeActive($query)
    {
        return $this->query('status', self::ACTIVE);
    }

    public static function removeCache()
    {
        foreach (static::CACHE_TAGS as $tag) {
            Cache::forget($tag);
        }
    }
}
