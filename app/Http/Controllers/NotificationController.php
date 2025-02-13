<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function notifications(Request $request)
    {
        $limit = $request->query('limit') ?? 10;
        return $this->formatResponse(
            'success',
            'notification-messages',
            Notification::where('user_id', Auth::id())
                ->orderBy('updated_at', 'desc')->paginate($limit)
        );
    }

    public function delete(Request $request){

        $ids = explode(',', $request->notification_ids);
        Notification::whereIn('id', $ids)->delete();
        return $this->formatResponse('success', 'deleted-notification-with-success');

    }
}
