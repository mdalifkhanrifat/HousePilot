<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\OAuthController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/index', function () {
    return view('index');
});

Route::get('/auth/google', [OAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [OAuthController::class, 'handleGoogleCallback']);





