<?php

use App\Http\Controllers\AlternativeChallengeController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ProfileController;
use App\Models\AlternativeChallenge;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'is_admin'])->name('dashboard');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('challenges', ChallengeController::class);
    Route::resource('alternative_challenges', AlternativeChallengeController::class);

    Route::get('alternative_challenge', function() {
        return  Inertia::render('Alternative_Challenges');
    })->name("alternative_challenge");
    
});

require __DIR__.'/auth.php';
