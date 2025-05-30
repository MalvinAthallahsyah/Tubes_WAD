<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

/// Ini route buat login ya
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

/// Ini buat logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/// Ini rute buat lupa password
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
