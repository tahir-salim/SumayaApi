<?php

namespace App\Http\Controllers;

use App\Models\Intention;
use App\Models\Setting;
use App\Models\UserAffirmation;
use App\Models\UserLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function init(Request $request)
    {
        $user = Auth::user();
        $user->last_ip_address = $request->ip();
        $user->last_activity_at = now();
        $user->save();

        $todayLetter = UserLetter::todayUnreadLetter()->first();

        if(!isset($todayLetter->read_at)){
            $todayLetter->read_at = now();
            $todayLetter->save();
        }

        $todayAffirmation = UserAffirmation::todayUnreadAffirmation()->first();

        if(!isset($todayAffirmation->read_at)){
            $todayAffirmation->read_at = now();
            $todayAffirmation->save();
        }

        return $this->formatResponse('success', 'init-successfull',[
            'settings' => Setting::get(),
            'todayLetter' => $todayLetter->letter,
            'todayAffirmation' => $todayAffirmation->affirmation,
            'user' => Auth::user(),
            'intentions' => Intention::get()
        ]);
    }
}
