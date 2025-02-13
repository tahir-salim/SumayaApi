<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
