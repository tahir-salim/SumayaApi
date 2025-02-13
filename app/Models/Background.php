<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Background extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUserBackgrounds($query){
        return $query->where('user_id', Auth::id());
    }
}
