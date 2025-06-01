<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Route utama - redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Routes untuk Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard & Profile routes - harus login dulu
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard/profile', function () {
        $user = Auth::user();
        return view('dashboard.profile', ['user' => $user]);
    })->name('dashboard.profile');
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

    $seller1 = \App\Models\Seller::create(['name' => 'Budi', 'description' => 'Your one-stop shop for cool gadgets.']);
    $seller2 = \App\Models\Seller::create(['name' => 'Don', 'description' => 'Curated collection of fine reads.']);

    // Ensure seller_id's exist for products
    $product1 = \App\Models\Product::create(['seller_id' => $seller1->id, 'name' => 'Super Smartphone X', 'description' => 'Latest generation smartphone with AI features.', 'price' => 12000000, 'stock' => 10]);
    $product2 = \App\Models\Product::create(['seller_id' => $seller1->id, 'name' => 'Noise-Cancelling Headphones Z', 'description' => 'Immersive sound experience.', 'price' => 2500000, 'stock' => 5]);
    $product3 = \App\Models\Product::create(['seller_id' => $seller2->id, 'name' => 'The Mystery of the Clockwork Dragon', 'description' => 'A thrilling adventure novel.', 'price' => 150000, 'stock' => 20]);

    // Ensure product_id's and user_id's exist for reviews
    \App\Models\Review::create(['user_id' => $user1->id, 'product_id' => $product1->id, 'rating' => 5, 'comment' => 'Absolutely fantastic phone! Best I have ever owned.', 'title' => 'Amazing Phone!']);
    \App\Models\Review::create(['user_id' => $user2->id, 'product_id' => $product1->id, 'rating' => 4, 'comment' => 'Great phone, but battery could be a bit better.', 'title' => 'Good, but...']);
    \App\Models\Review::create(['user_id' => $user1->id, 'product_id' => $product2->id, 'rating' => 5, 'comment' => 'These headphones are amazing for travel. Sound quality is superb.', 'title' => 'Perfect for Travel!']);

    // Ensure seller_id's and user_id's exist for seller reviews
    \App\Models\Review::create(['user_id' => $user2->id, 'seller_id' => $seller1->id, 'rating' => 4, 'comment' => 'Good seller, fast shipping for my headphones.', 'title' => 'Reliable Seller']);
    \App\Models\Review::create(['user_id' => $user1->id, 'seller_id' => $seller2->id, 'rating' => 5, 'comment' => 'Bookworm Nook has an amazing selection and service!', 'title' => 'Fantastic Bookstore!']);


    return 'Test data created! Visit <a href="/products/'. $product1->id .'">Product: '. $product1->name .'</a>, <a href="/sellers/'. $seller1->id .'">Seller: '. $seller1->name .'</a>. User IDs created: '. $user1->id .' (Adit), '. $user2->id .' (Denis).';
})->name('setup.test.data');

Route::get('/show-users-for-id', function() {
     if (!app()->environment('local')) {
        return 'Not allowed in this environment.';
    }
    return \App\Models\User::all(['id', 'name', 'email']);
})->name('show-users-for-id');
