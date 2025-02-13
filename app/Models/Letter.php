<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $casts = [
        'day' => 'date',
    ];

    protected $table = 'letters';
    protected $fillable = [
        'name_en',
        'name_ar',
        'day'
    ];

    public function intention()
    {
        return $this->belongsTo(Intention::class);
    }


}
