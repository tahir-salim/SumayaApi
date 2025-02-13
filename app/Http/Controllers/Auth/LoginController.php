<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AccountCreated;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Stevebauman\Location\Facades\Location;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'device_type' => 'required',
            'fcm_token' => '',
            'device_id' => '',
            'app_version' => '',
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
                'Email-address-not-found'
            );
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->formatResponse(
                'error',
                'credentials-not-match'
            );
        }

        if ($user->is_blocked) {
            return $this->formatResponse(
                'error',
                'user-blocked'
            );
        }


        // first you need to make sure the password is correct before updating data
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
        if ($request->device_os) {
            $user->device_os = $request->device_os;
        }
        if ($request->device_token) {
            $user->device_token = $request->device_token;
        }

        $user->last_activity_at = now();
        $user->save();
        $token = $user->createToken($request->device_id ?: $request->device_type)->plainTextToken;

        $user->api_token = $token;

        return $this->formatResponse(
            'success',
            'login-successfully',
            $user
        )->withHeaders([
            'x-auth-token' => $token,
        ]);
    }
    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => '',
            'provider_id' => 'required',
            'provider' => 'required|in:apple,google', // apple/google
            'name' => 'nullable|string',
            // 'name' => 'nullable|string',
            // 'last_name' => 'nullable|string',
            'device_type'=> 'required',
            'device_id'=> 'nullable|string',
            'app_version' => 'nullable|string',
            'fcm_token' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->formatResponse(
                'error',
                'validation-error',
                $validator->errors()->first()
            );
        }

        if (strtolower($request->provider) == "apple") {
            $user = User::where("provider_id", trim($request->provider_id))->first();
        } elseif (strtolower($request->provider) == "google") {
            $user = User::where("provider_id", trim($request->provider_id))->first();
        }

        if (!$user && isset($request->email) && trim($request->email)) {
            $user = User::where("email", trim($request->email))->first();
        }

        if (!$user) {
            if(!$request->email){
                return $this->formatResponse(
                    'error',
                    'email-not-found'
                );
            }
            $user = new User();
            $user->name = $request->name;
            // $user->full_name = $request->full_name;
            $user->email = $request->email ?? null;
            // if($position = Location::get())
            // {
            //     $user->country_id = optional(Country::where('name', $position->countryName)->first())->id;
            // }
            $user->password = Hash::make('SUMAYA' . $request->provider . $request->provider);
            // $user->role_id = Role::STUDENT;
            // if ($user->email) {
            //     $user->is_verified = 1;
            // }

            $email = $user->email;
            if ($email ) {
                Mail::to($request->email)->send(new AccountCreated($user->name));
            }
        }
        $user->provider = $request->provider;
        $user->provider_id = $request->provider_id;


        if ($request->fcm_token) {
            $user->fcm_token = $request->fcm_token;
        }
        if ($request->app_version) {
            $user->app_version = $request->app_version;
        }
        if ($request->device_id) {
            $user->device_id = $request->device_id;
        }
        if ($request->device_type) {
            $user->device_type = $request->device_type;
        }

        // $user->is_verified = 1;
        $user->save();
        if($position = Location::get())
        {
            $user->userProfile()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'country_id' => optional(Country::where('name', $position->countryName)->first())->id
            ]);
        }

        $user->api_token = $user->createToken($request->device_id ?: $request->device_type)->plainTextToken;

        return $this->formatResponse(
            'success',
            'login-successfully',
            $user
        );
    }
    public function logout(Request $request)
    {
        if ($request->user()->currentAccessToken()->delete()) {
            return $this->formatResponse('success', 'logout-successfully');
        }
        abort(401);
    }
}
