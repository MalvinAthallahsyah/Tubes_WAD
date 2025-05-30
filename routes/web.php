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

/// Route untuk register
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::get('/dashboard', function () {
    // Pastikan user sudah login
    if (!auth()->check()) {
        return redirect('/login');
    }

    return view('dashboard');
})->name('dashboard');
