<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// Product and Seller display routes
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/sellers/{seller}', [SellerController::class, 'show'])->name('sellers.show');

// Review Routes
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

// Create review for a product
Route::get('/products/{product}/reviews/create', [ReviewController::class, 'createForProduct'])->name('reviews.create.product');
// Create review for a seller
Route::get('/sellers/{seller}/reviews/create', [ReviewController::class, 'createForSeller'])->name('reviews.create.seller');

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');


// --- Routes for creating test data ---
Route::get('/setup-test-data', function () {
    if (!app()->environment('local')) {
        return 'Not allowed in this environment.';
    }

    // Clear existing data to avoid conflicts if re-running
    // Be careful with the order if you have strict foreign key constraints that are not onDelete('cascade')
    \App\Models\Review::query()->delete();
    \App\Models\Product::query()->delete();
    \App\Models\Seller::query()->delete();
    \App\Models\User::query()->delete();


    $user1 = User::create(['name' => 'Adit', 'email' => 'adit@example.com', 'password' => bcrypt('password')]);
    $user2 = User::create(['name' => 'Denis', 'email' => 'denis@example.com', 'password' => bcrypt('password')]);

    return redirect('/login')->with('message', 'Berhasil logout!');
});

Route::resource('products', ProductController::class);
