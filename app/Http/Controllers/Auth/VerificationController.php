<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserVerification;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;


class VerificationController extends Controller
{

    public function resendCode(Request $request)
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

        // get old verification if exists
        $verification = UserVerification::where('email', $request->email)->first();

        if ($verification) {

            $token = rand(1000, 9999);

            Mail::to($request->email)->send(new VerificationEmail($token));

            $verification->token = $token;
            $verification->status = UserVerification::STATUS_PENDING;
            $verification->save();

            return $this->formatResponse(
                'success',
                'code-has-been-sent',
                [
                    'token' => $token,
                ]
            );
        } else {
            return $this->formatResponse(
                'error',
                'email-not-exist'
            );
        }
    }

    public function verify(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|int|min:4',
        ]);
        if ($validate->fails()) {
            return $this->formatResponse(
                'error',
                'validation-error',
                $validate->errors()->first()
            );
        }

        $user = User::where('email', $request->email)->first();

        if (UserVerification::where('token', $request->token)
            ->where('email', $request->email)
            ->where('user_id', $user->id)
            ->where('status', UserVerification::STATUS_PENDING)
            ->count()) {
            UserVerification::where('email', $request->email)
                ->update([
                    "status" => UserVerification::STATUS_VERIFIED,
                ]);
            return $this->formatResponse(
                'success',
                'email-has-been-verified'
            );
        } else {
            return $this->formatResponse(
                'error',
                'email-or-token-invalid'
            );
        }
    }
}
