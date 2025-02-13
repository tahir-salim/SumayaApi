<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAffirmation extends Model
{
    use HasFactory;

    public function scopeTodayUnreadAffirmation($query){
        return $query->whereDate('date_time', now())
                     ->whereNull('read_at');
    }

    public function affirmation(){
        return $this->belongsTo(Affirmation::class);
    }
}
