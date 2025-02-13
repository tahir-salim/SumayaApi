<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeLevel extends Model
{
    use HasFactory;

    protected $table = 'income_levels';
    protected $fillable = [
        'name_en',
        'name_ar'
    ];

    public function users()
    {
        return $this->hasMany(UserProfile::class);
    }
}
