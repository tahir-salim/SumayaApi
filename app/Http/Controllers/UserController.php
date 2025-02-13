<?php

namespace App\Http\Controllers;

use App\Models\Background;
use App\Models\User;
use App\Models\UserAffirmation;
use App\Models\UserProfile;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return $this->formatResponse('success', 'user-profile-details-get', UserProfile::authProfile()->first());
    }

    public function updateProfile(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => '',
            'full_name' => '',
            'marital_status' => '',
            'dob' => '',
            'gender' => '',
            'phone' => '',
        ]);
        if ($validate->fails()) {
            return $this->formatResponse(
                'error',
                'validation-error',
                $validate->errors()->first()
            );
        }

        $user = User::find(Auth::id());
        if ($request->name) {
            $user->name = $request->name;
        }

        if ($request->full_name) {
            $user->full_name = $request->full_name;
        }

        // $user->email = $request->email;
        // $user->country_id = $request->country_id;
        // $user->city_id = $request->city_id;
        // $user->cpr = $request->cpr;
        // if($request->dob) $user->dob = $request->dob;
        // if($request->gender) $user->gender = $request->gender;
        // if($request->phone) $user->phone = $request->phone;
        // if($request->marital_status) $user->marital_status = $request->marital_status;
        $user->save();

        $userProfile = UserProfile::where('user_id', Auth::id())->first();
        if (!$userProfile) {
            $userProfile = new UserProfile();
            $userProfile->user_id = Auth::id();
        }

        if ($request->dob) {
            $userProfile->date_of_birth = $request->dob;
        }

        if ($request->gender) {
            $userProfile->gender = $request->gender;
        }

        if ($request->phone) {
            $userProfile->phone = $request->phone;
        }

        if ($request->intention_id) {
            $userProfile->intention_id = $request->intention_id;
        }

        if ($request->country_id) {
            $userProfile->country_id = $request->country_id;
        }

        if ($request->income_level_id) {
            $userProfile->income_level_id = $request->income_level_id;
        }

        if ($request->education_level_id) {
            $userProfile->education_level_id = $request->education_level_id;
        }

        if ($request->max_reminders_per_day) {
            $userProfile->max_reminders_per_day = $request->max_reminders_per_day;
        }

        if ($request->min_reminders_per_day) {
            $userProfile->min_reminders_per_day = $request->min_reminders_per_day;
        }

        if ($request->start_time) {
            $userProfile->start_time = $request->start_time;
        }

        if ($request->end_time) {
            $userProfile->end_time = $request->end_time;
        }

        $userProfile->save();
        // $userProfile = UserProfile::firstOrCreate([
        //     'user_id' => $user->id
        // ], [
        //     'intention_id' => $request->intention_id,
        //     'country_id' => $request->country_id,
        //     'income_level_id'=> $request->income_level_id,
        //     'education_level_id'=> $request->education_level_id,
        // ]);

        return $this->formatResponse('success', 'profile-updated', $user, 200);
    }

    public function uploadProfileImage(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'file' => 'required|image',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse(
                'error',
                'validation-error',
                $validate->errors(),
                400
            );
        }

        $path = Storage::disk('s3')->put('images/users', new File($request->file));
        $user = Auth::user();
        $user->avatar = $path;
        $user->save();
        return $this->formatResponse('success', 'successfully-uploaded', $user);
    }

    public function uploadBackground(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'file' => 'required|image',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse(
                'error',
                'validation-error',
                $validate->errors(),
                400
            );
        }

        $path = Storage::disk('public')->put('images/backgrounds', new File($request->file));
        // $user = Auth::user();
        // $user->avatar = $path;
        // $user->save();
        $background = new Background();
        $background->user_id = Auth::id();
        $background->image_url = $path;
        $background->save();

        return $this->formatResponse('success', 'background-uploaded', $background);
    }

    public function deleteBackground(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse(
                'error',
                'validation-error',
                $validate->errors(),
                400
            );
        }

        $background = Background::where('id', $request->id)->first();
        Storage::disk('public')->delete($background->image_url);
        $background->delete();

        return $this->formatResponse('success', 'background-deleted');
    }

    public function saveAppDetail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'fcm_token' => 'nullable',
            'app_version' => 'nullable',
            'device_info' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse(
                'error',
                'validation-error',
                $validate->errors()->first()
            );
        }

        $user = User::find(Auth::id());
        if ($request->fcm_token) {
            $user->fcm_token = $request->fcm_token;
        }
        if ($request->app_version) {
            $user->app_version = $request->app_version;
        }
        $user->device_id = $request->device_info['deviceId'];
        $user->device_type = $request->device_info['deviceType'];
        $user->device_os = $request->device_info['deviceOS'];
        $user->device_token = $request->device_info['deviceToken'];
        $user->last_activity_at = now();
        $user->last_ip_address = $request->ip();
        $user->save();

        return $this->formatResponse(
            'success',
            'app-details-saved-for-user',
        );
    }

    public function affirmations(Request $request)
    {
        return $this->formatResponse(
            'success',
            'affirmations-get',
            UserAffirmation::where('user_id', Auth::id())->with('affirmation')->orderBy('date_time', 'desc')->paginate($request->query('limit') ?? 10)
        );
    }

    public function read($id)
    {
        if (!isset($id)) {
            return $this->formatResponse(
                'error',
                'validation-error',
                'The affirmation id field is required',
                400
            );
        }

        UserAffirmation::where([
            ['id', '=', $id],
            ['read_at', '=', null],
        ])->update('read_at', now());

        return $this->formatResponse('success', 'affirmation-read');
    }

    public function share(Request $request, $id)
    {
        if (!isset($id)) {
            return $this->formatResponse(
                'error',
                'validation-error',
                'The id field is required',
                400
            );
        }

        $type = $request->query('item_type') ?? 'letter';

        if ($type == 'letter') {
            UserLetter::where('id', $id)->update(['shared_at' => now(), 'shared_with_background_id' => $request->query('background_id')]);
        } elseif ($type == 'affirmation') {
            UserAffirmation::where('id', $id)->update(['shared_at' => now(), 'shared_with_background_id' => $request->query('background_id')]);
        }

        return $this->formatResponse('success', 'share-successfull')
    }
}
