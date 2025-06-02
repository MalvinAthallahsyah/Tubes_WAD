<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController; // <-- DITAMBAHKAN
use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Review;

// Route utama - redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Routes untuk Auth punya wira
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard & Profile routes - harus login dulu punya wira
Route::middleware('auth')->group(function () {
    // Route::get('/dashboard', function () {         <-- BARIS LAMA
    //     return view('dashboard');                 <-- BARIS LAMA
    // })->name('dashboard');                         <-- BARIS LAMA
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // <-- BARIS DIPERBARUI

    Route::get('/dashboard/profile', function () {
        $user = Auth::user();
        return view('dashboard.profile', ['user' => $user]);
    })->name('dashboard.profile');

    Route::post('/dashboard/profile/update', function (Request $request) {
        $user = Auth::user();

        // Data profil
        $profileData = [
            'name' => $request->name,
            'nim' => $request->nim,
            'phone' => $request->phone,
            'faculty' => $request->faculty,
            'major' => $request->major,
            'bio' => $request->bio,
            'street_address' => $request->street,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal
        ];

        // Jika ada foto yang diunggah
        if ($request->hasFile('profile_photo')) {
            $fileName = 'profile_' . time() . '_' . $user->id . '.' . $request->profile_photo->extension();
            $request->profile_photo->move(public_path('profile_photos'), $fileName);
            $profileData['profile_photo'] = $fileName;
        }

        // Update profil
        $user->update($profileData);

        return redirect()->route('dashboard.profile')
            ->with('success', 'Profile updated successfully!');
    })->name('profile.update');
});

// ====================================================================
// Product routes
Route::resource('products', ProductController::class);
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Seller routes
Route::get('/sellers/{seller}', [SellerController::class, 'show'])->name('sellers.show');

// Review Routes
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/products/{product}/reviews/create', [ReviewController::class, 'createForProduct'])->name('reviews.create.product');
Route::get('/sellers/{seller}/reviews/create', [ReviewController::class, 'createForSeller'])->name('reviews.create.seller');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Development/Test routes
Route::get('/setup-test-data', function () {
    //

})->name('setup.test.data');
// Debug route - only for development
Route::get('/show-users-for-id', function() {
    //
})->name('show-users-for-id');