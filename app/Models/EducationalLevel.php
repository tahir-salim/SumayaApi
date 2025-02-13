<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalLevel extends Model
{
    use HasFactory;

    protected $table = 'educational_levels';
    protected $fillable = [
        'name_en',
        'name_ar'
    ];

    public function users()
    {
        return $this->hasMany(UserProfile::class, 'education_level_id' );
    }
}
