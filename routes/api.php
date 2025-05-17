<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);


// Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
// Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
// Route::post('/reset-password', [AuthController::class, 'resetPassword']); // via token or OTP

Route::post('/forgot-password/otp', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/reset-password-otp', [AuthController::class, 'resetPasswordWithOtp']);





Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
