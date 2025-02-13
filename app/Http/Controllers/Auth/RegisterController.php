<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AccountCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Country;
use App\Models\UserVerification;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Location\Facades\Location;

class RegisterController extends Controller
{
    public function signUpRequest(Request $request)
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

        if (User::where('email', $request->email)->count()) {
            // if user found
            return $this->formatResponse(
                'error',
                'user-already-exists'
            );
        }

        // delete old verification if exists
        UserVerification::where('email', $request->email)->delete();

        $token = rand(1000, 9999);
        // $token = 1111;
        Mail::to($request->email)->send(new VerificationEmail($token));
        $verification = new UserVerification();
        $verification->email = $request->email;
        $verification->token = $token;
        $verification->save();

        return $this->formatResponse(
            'success',
            'code-has-been-sent',
            [
                'token' => $token,
            ]
        );
    }

    public function setupEmail(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'name' => 'required|string',
            'dob' => 'required|date|after:'.Carbon::now()
            ->subYears(99)
            ->toDateString(). '|before:' . Carbon::now()
            ->subYears(10)
            ->toDateString(),
            'gender' => 'required',
            'phone' => 'required',
            'device_type' => 'required',
            'fcm_token' => '',
            'app_version' => '',
            'device_id' => '',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse(
                'error',
                'validation-error',
                $validate->errors()->first()
            );
        }

        $userVerification = UserVerification::where('token', $request->token)
            ->where('email', $request->email)
            ->first();
        //check if exist
        if ($userVerification) {

            if ($userVerification->status !== UserVerification::STATUS_PENDING) {
                return $this->formatResponse(
                    'error',
                    'verification-code-is-expired'
                );
            }

            $userVerification->status = UserVerification::STATUS_VERIFIED;
            $userVerification->save();

            // return $this->formatResponse(
            //     'success',
            //     'email-has-been-verified'
            // );
        } else {
            return $this->formatResponse(
                'error',
                'verification-code-not-valid-or-email-not-exist'
            );
        }

        $verification = UserVerification::where('email', $request->email)
            ->where('token', $request->token)
            ->where('status', UserVerification::STATUS_VERIFIED)
            ->first();
        if (!$verification) {
            return $this->formatResponse(
                'error',
                'unauthorized-user'
            );
        }

        if (User::where('email', $request->email)->count()) {
            // if user found
            return $this->formatResponse(
                'error',
                'user-already-exists'
            );
        }
        $user = new User();
        $user->name = $request->name;
        $user->full_name = $request->full_name;
        $user->password = Hash::make($request->password);
        // $user->gender = $request->gender;

        // $user->phone = $request->phone;
        $user->email = $request->email;
        // $user->dob = $request->dob;
        // $user->is_verified = true;
        // $user->last_activity_at = now();
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
        $user->save();

        if($position = Location::get())
        {
            $user->userProfile()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'country_id' => optional(Country::where('name', $position->countryName)->first())->id,
                'date_of_birth' => $request->dob,
                'gender' => $request->gender,
                'phone' => $request->phone
            ]);
        }

        $token = $user->createToken($request->device_id ?: $request->device_type)->plainTextToken;
        $user->api_token = $token;
        Mail::to($request->email)->send(new AccountCreated($user->full_name));

        return $this->formatResponse('success', 'signup-Successfully',$user);
    }

}
