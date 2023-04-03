<?php

use Illuminate\Support\Facades\Route;
use WebFuelAgency\Socialite\Http\Controllers\SocialiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('auth', [SocialiteController::class, 'index']);
Route::get('auth/{provider}', [SocialiteController::class, 'redirect']);
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handle']);

