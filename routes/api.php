<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//register and login

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

//only logged in users
Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::post('logout', [UserController::class, 'logout']);
    Route::resource('challenges', ChallengeController::class)->only(['index', 'show']);

    Route::post('getUserChallenge',[UserController::class, 'getUserChallenge']);
});
