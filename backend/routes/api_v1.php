<?php

use App\Http\Controllers\Auth\SignupController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/signup', [SignupController::class, 'signup'])->name('signup');
});