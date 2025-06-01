<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('/login');
});

/// Ini route buat login ya
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

/// Ini buat logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/// Ini rute buat lupa password
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');

/// Route untuk register
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::get('/dashboard', function () {
    // ini biar memastikan user sudah login
    if (!auth()->check()) {
        return redirect('/login');
    }

    return view('dashboard');
})->name('dashboard');

Route::get('/dashboard/profile', function () {
    // Get logged in user
    $user = Auth::user();
    return view('dashboard.profile', ['user' => $user]);
})->middleware('auth')->name('dashboard.profile');

Route::get('/force-logout', function() {
    auth()->logout();
    session()->flush();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login')->with('message', 'Berhasil logout!');
});
