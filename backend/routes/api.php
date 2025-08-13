<?php

use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/signup', [SignupController::class, 'signup'])->name('signup');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

Route::prefix('transaction')->middleware(['jwt.verify'])->group(function () {
    Route::post('/get', [TransactionController::class, 'getTransaction'])->name('getTransaction');
    Route::post('/add', [TransactionController::class, 'addTransaction'])->name('addTransaction');
    Route::post('/edit', [TransactionController::class, 'editTransaction'])->name('editTransaction');
    Route::post('/delete', [TransactionController::class, 'deleteTransaction'])->name('deleteTransaction');
    Route::post('/category-summary', [TransactionController::class, 'getCategorySummary'])->name('getCategorySummary');
});