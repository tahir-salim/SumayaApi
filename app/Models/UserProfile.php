<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Model
{
    use HasFactory;

    protected $casts = [
        'date_of_birth' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'country_id',
        'gender',
        'categories',
        'marital_status',
        'hobbies',
        'interests',
        'educational_level',
        'income_level',
        'intentions',
        'no_of_reminders_per_day',
        'phone',
        'start_time',
        'end_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function incomeLevel()
    {
        return $this->belongsTo(IncomeLevel::class);
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationalLevel::class);
    }

    public function intention()
    {
        return $this->belongsTo(Intention::class);
    }

    public function scopeAuthProfile($query){
        return $query->where('user_id', Auth::id());
    }
}
