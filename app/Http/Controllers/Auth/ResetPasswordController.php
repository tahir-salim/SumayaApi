<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\VerificationEmail;
use App\Models\User;
use App\Models\UserVerification;

class ResetPasswordController extends Controller
{
    public function index(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse(
                'error',
                'validation-error',
                $validate->errors()->first()
            );
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->formatResponse(
                'error',
                'email not exists'
            );
        }

        if ($user->is_blocked) {
            return $this->formatResponse(
                'error',
                'user-blocked'
            );
        }

        $token = rand(1000, 9999);
        $verification = UserVerification::where('email', $request->email)
            ->where('user_id', $user->id)
            ->first();

        if ($verification) {
            $verification->token = $token;
            $verification->status = UserVerification::STATUS_PENDING;
            $verification->save();
        } else {
            $verification = new UserVerification();
            $verification->email = $request->email;
            $verification->user_id = $user->id;
            $verification->token = $token;
            $verification->save();
        }

        Mail::to($request->email)->send(new VerificationEmail($token));
        return $this->formatResponse(
            'success',
            'otp-sent-success',
            $token
        );

    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|int',
            'password' => 'required|min:6',
            'device_type' => '',
            'device_id' => '',
            'fcm_token' => '',
            'app_version' => '',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('validation-error', $validate->errors()->first());
        }

        $verification = UserVerification::where('email', $request->email)
            ->where('token', $request->token)
            ->where('status', UserVerification::STATUS_PENDING)
            ->first();

        if (!$verification) {
            return $this->formatResponse(
                'error',
                'email-or-token-invalid'
            );
        }

        $user = $verification->user()->where('email', $request->email)->first();

        if (!$user) {
            return $this->formatResponse(
                'error',
                'no-user-found'
            );
        }

        $user->password = Hash::make($request->password);
        $user->device_type = $request->device_type;
        if (isset($request->fcm_token)) {
            $user->fcm_token = $request->fcm_token;
        }
        if ($request->app_version) {
            $user->app_version = $request->app_version;
        }
        if ($request->device_id) {
            $user->device_id = $request->device_id;
        }
        // $user->last_activity_at = now();
        $user->save();

        return $this->formatResponse('success', 'reset-successfully');
    }
}
