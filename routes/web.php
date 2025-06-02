<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Models\User;
use App\Models\Product;

// Route utama - redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Routes untuk Auth
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Dashboard & Profile routes - harus login dulu
Route::middleware('auth')->group(function () {
    // Dashboard utama pengguna
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'user' => auth()->user(),
            'products' => Product::with('category')->latest()->get()
        ]);
    })->name('dashboard');

    // Profile page dan update profile
    Route::get('/dashboard/profile', function () {
        return view('dashboard.profile', ['user' => Auth::user()]);
    })->name('dashboard.profile');

    Route::post('/dashboard/profile/update', function (Request $request) {
        $user = Auth::user();
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

        // Upload foto profil jika ada
        if ($request->hasFile('profile_photo')) {
            $fileName = 'profile_' . time() . '_' . $user->id . '.' . $request->profile_photo->extension();
            $request->profile_photo->move(public_path('profile_photos'), $fileName);
            $profileData['profile_photo'] = $fileName;
        }

        $user->update($profileData);
        return redirect()->route('dashboard.profile')->with('success', 'Profile updated successfully!');
    })->name('profile.update');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', function () {
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Silakan login dulu!');
        }
        if (auth()->user()->role != 'admin') {
            return redirect('/dashboard')->with('error', 'Kamu bukan admin!');
        }
        return view('dashboardadmin');
    })->name('dashboard');

    // Users management
    Route::get('/users', function () {
        if (!auth()->check() || auth()->user()->role != 'admin') {
            return redirect('/login')->with('error', 'Silakan login dulu!');
        }

        $allUsers = User::all();
        $adminUsers = $allUsers->filter(fn($user) => $user->role === 'admin');
        $regularUsers = $allUsers->filter(fn($user) => $user->role !== 'admin');

        return view('admin.users_index', compact('adminUsers', 'regularUsers'));
    })->name('users.index');

    // Delete user
    Route::delete('/users/{user}', function (User $user) {
        if (!auth()->check() || auth()->user()->role != 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Aksi tidak diizinkan.');
        }
        if (auth()->id() == $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', "Pengguna '{$userName}' berhasil dihapus.");
    })->name('users.destroy');

    // User edit form (masih dummy)
    Route::get('/users/{user}/edit', function (User $user) {
        if (!auth()->check() || auth()->user()->role != 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Aksi tidak diizinkan.');
        }
        return "Halaman untuk mengedit User ID: " . $user->id . " (Nama: " . $user->name . "). Form edit akan ada di sini.";
    })->name('users.edit');

    // Update user (masih dummy)
    Route::put('/users/{user}', function (Request $request, User $user) {
        if (!auth()->check() || auth()->user()->role != 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Aksi tidak diizinkan.');
        }
        return "Proses update untuk User ID: " . $user->id . ". Data dari form: " . json_encode($request->all());
    })->name('users.update');

    // Products management
    Route::get('/products', function () {
        if (!auth()->check() || auth()->user()->role != 'admin') {
            return redirect('/login');
        }

        $products = Product::with('category')->latest()->get();
        return view('admin.products_index', compact('products'));
    })->name('products.index');

    // Delete product
    Route::delete('/products/{product}', function (Product $product) {
        if (!auth()->check() || auth()->user()->role != 'admin') {
            return redirect()->route('admin.products.index')->with('error', 'Unauthorized action.');
        }

        if ($product->image_path && \Storage::exists('public/' . $product->image_path)) {
            \Storage::delete('public/' . $product->image_path);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    })->name('products.destroy');
});

// Product routes
Route::resource('products', ProductController::class);
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
