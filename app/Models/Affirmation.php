<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Affirmation extends Model
{
    use HasFactory;

    protected $fillable = [
        'ar_text',
        'en_text'
    ];

    public function intention()
    {
        return $this->belongsTo(Intention::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_affirmations', 'affirmation_id', 'user_id')->withPivot('date_time');
    }

    // public function userAffirmations(){
    //     return $this->users()->wherePivot('user_id', Auth::id());
    // }
}
