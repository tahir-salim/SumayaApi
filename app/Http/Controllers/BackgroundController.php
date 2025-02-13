<?php

namespace App\Http\Controllers;

use App\Models\Background;
use Illuminate\Http\Request;

class BackgroundController extends Controller
{
    public function index(Request $request){
        return $this->formatResponse('success', 'background-get',
            Background::userBackgrounds()->paginate($request->query('limit') ?? 10)
        );
    }
}
