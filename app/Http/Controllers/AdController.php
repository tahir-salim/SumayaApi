<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    public function index(Request $request){
        $type = $request->query('ad_type') ?? 'ad';
        $limit = $request->query('limit') ?? 10;
        $data = Ad::when($type == 'ad', function($q){
            $q->ads();
        })
        ->when($type == 'publication', function($q){
            $q->publications();
        })
        ->paginate($limit);

        return $this->formatResponse('success', $type.'-get', $data);
    }

    public function read(Request $request, $id){
        if (!isset($id)) {
            return $this->formatResponse(
                'error',
                'validation-error',
                'The ad id field is required',
                400
            );
        }

        $ad_view = AdView::updateOrCreate([
            'user_id' => Auth::id(), 'ad_id' => $id
        ],[
            'clicked_at' => now()
        ]);

        return $this->formatResponse('success', 'ad-viewed-successfully');
    }

    // public function click(Request $request, $id){

    // }
}
