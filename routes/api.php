<?php

use App\Http\Controllers\AdController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use \App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BackgroundController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntentionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Auth
Route::post('/auth/login', [LoginController::class, 'login']);
Route::post('/auth/social-login', [LoginController::class, 'socialLogin']);

Route::post('/auth/signup-request', [RegisterController::class, 'signUpRequest']);
Route::post('/auth/signup-confirm', [RegisterController::class, 'setupEmail']);

Route::post('/auth/verification-resend', [VerificationController::class, 'resendCode']);
Route::post('/auth/verification-confirm', [VerificationController::class, 'verify']);

Route::post('/auth/reset-password-request', [ResetPasswordController::class, 'index']);
Route::post('/auth/reset-password-store', [ResetPasswordController::class, 'store']);
Route::get('/intention', [IntentionController::class, 'index']);
Route::get('/country', [CountryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/backgrounds', [BackgroundController::class, 'index']);
    Route::get('/init', [HomeController::class, 'init']);

    Route::get('/user/profile', [UserController::class, 'index']);
    Route::post('/user/update-profile', [UserController::class, 'updateProfile']);
    Route::post('/user/upload-avatar', [UserController::class, 'uploadProfileImage']);
    Route::post('/user/upload-background', [UserController::class, 'uploadBackground']);
    Route::post('/user/delete-background', [UserController::class, 'deleteBackground']);
    Route::post('/user/app-details', [UserController::class, 'saveAppDetail']);
    Route::get('/user/affirmations', [UserController::class, 'affirmations']);
    Route::post('/user/affirmations/{id}/read', [UserController::class, 'read']);
    Route::post('/user/affirmations-letters/{id}/share', [UserController::class, 'share']);

    Route::get('/notifications', [NotificationController::class, 'notifications']);
    Route::post('/notifications/delete', [NotificationController::class, 'delete']);

    Route::get('/ads', [AdController::class, 'index']);
    Route::get('/ads/{id}/read', [AdController::class, 'read']);

    Route::post('/auth/logout', [LoginController::class, 'logout']);
});
