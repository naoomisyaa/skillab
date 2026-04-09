<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollaborationRequestController;
use App\Http\Controllers\MatchmakingController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register/step/1', [AuthController::class, 'storeStep1'])->name('register.step1');
    Route::post('/register/step/2', [AuthController::class, 'storeStep2'])->name('register.step2');
    Route::post('/register/step/3', [AuthController::class, 'storeStep3'])->name('register.step3');
    Route::get('/register/back/{step}', [AuthController::class, 'backToStep'])
        ->name('register.back')
        ->middleware('guest');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Matchmaking page
    Route::get('/matchmaking', [MatchmakingController::class, 'index'])->name('matchmaking.index');

    // Collaboration Requests
    Route::prefix('collaboration-requests')->name('collaboration-requests.')->group(function () {
        Route::get('/', [CollaborationRequestController::class, 'index'])->name('index');
        Route::post('/', [CollaborationRequestController::class, 'store'])->name('store');
        Route::patch('/{collaborationRequest}/accept', [CollaborationRequestController::class, 'accept'])->name('accept');
        Route::patch('/{collaborationRequest}/decline', [CollaborationRequestController::class, 'decline'])->name('decline');

        Route::get('/api/list', [CollaborationRequestController::class, 'apiIndex'])->name('api.index');
    });
});
