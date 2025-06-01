<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerController;
use App\Models\User;

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
       return view('dashboard');
    })->name('dashboard');
});

Route::get('/dashboard/profile', function () {
    return view('dashboard.profile');
    })->name('dashboard.profile');
 
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); 
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/sellers/{seller}', [SellerController::class, 'show'])->name('sellers.show');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/products/{product}/reviews/create', [ReviewController::class, 'createForProduct'])->name('reviews.create.product');
Route::get('/sellers/{seller}/reviews/create', [ReviewController::class, 'createForSeller'])->name('reviews.create.seller');
Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

Route::get('/setup-test-data', function () {
    if (!app()->environment('local')) {
        return 'Not allowed in this environment.';
    }

    \App\Models\Review::query()->delete();
    \App\Models\Product::query()->delete();
    \App\Models\User::query()->delete();

    $user1 = User::create(['name' => 'Adit', 'email' => 'adit@example.com', 'password' => bcrypt('password')]);
    $user2 = User::create(['name' => 'Denis', 'email' => 'denis@example.com', 'password' => bcrypt('password')]);

    return redirect()->route('login.form')->with('status', 'Test data created successfully! Please login.');
});

?>