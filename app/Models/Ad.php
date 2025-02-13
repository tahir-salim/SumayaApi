<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    const ACTIVE = 'ACTIVE';
    const ENDED = 'ENDED';

    protected $table = 'ads';

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $fillable = [
        'client_name',
        'start_date',
        'end_date',
        'url',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_ads', 'ad_id', 'user_id');
    }

    public function adAssets()
    {
        return $this->hasMany(AdAsset::class);
    }

    public function scopeAds($query)
    {
        return $query->where('is_sumaya_publication', false);
    }
    public function scopePublications($query)
    {
        return $query->where('is_sumaya_publication', true);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeIsNotActive($query)
    {
        return $query->where('is_active', false);
    }
}
