<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserLetter extends Model
{
    use HasFactory;

    public function scopeTodayUnreadLetter($query){
        return $query->where('user_id', Auth::id())
                    ->whereDate('date_time', now())
                    ->whereNull('read_at');
    }

    public function letter(){
        return $this->belongsTo(Letter::class)
    }
}
