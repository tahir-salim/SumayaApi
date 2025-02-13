<?php

namespace App\Http\Controllers;

use App\Models\Intention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IntentionController extends Controller
{
    public function index(Request $request){

        $limit = $request->query('limit') ?? null;

        // $result = Intention::active();
        $result = null;
        if($limit)
            $result = Intention::active()->paginate($limit);
        else
            $result = Cache::tags(Intention::CACHE_TAGS)->remember('countries',now()->addDays(7), function(){
                return Intention::active()->get();
            });;

        return $this->formatResponse('success', 'intentions-get', $result);
    }
}
