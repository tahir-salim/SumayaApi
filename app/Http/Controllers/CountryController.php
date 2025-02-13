<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $countries = Cache::remember('countries',now()->addDays(7), function(){
            return Country::active()->get();
        });
        return $this->formatResponse(
            'success',
            'category-get',
            $countries
        );
    }
}
