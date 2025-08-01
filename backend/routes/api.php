<?php

use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/signup', [SignupController::class, 'signup'])->name('signup');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});