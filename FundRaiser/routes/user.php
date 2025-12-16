<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'showSettings'])->name('profile');
    Route::post('/profile-info', [UserController::class, 'updateInfo']);
    Route::post('/account-settings', [UserController::class, 'updateAccount']);
    Route::post('/delete-account', [UserController::class, 'deleteAccount']);
    
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});