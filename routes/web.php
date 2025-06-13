<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
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
    // Ini middleware 'auth' buat pastiin user udah login, kalo belom ya dilempar ke login page dulu
    Route::get('/dashboard', function () {
        // Pass the authenticated user to the view
        return view('dashboard', [
            'user' => auth()->user(),
            'products' => \App\Models\Product::with('category')->latest()->get()
        ]);
    })->name('dashboard');

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
            // Ini bikin nama file unik pake time() + user id biar gak tabrakan nama filenya
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

// Ganti route admin yang pakai middleware 'admin' dengan route yang ada pengecekan admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Prefix 'admin' bikin semua URL dimulai dengan '/admin', name('admin.') nambahin 'admin.' di depan nama routenya

    // Route dashboard admin (yang sudah ada)
    Route::get('/dashboard', function () {
        // Double check keamanan - ini penting biar admin page aman banget
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Silakan login dulu!');
        }
        if (auth()->user()->role != 'admin') {
            return redirect('/dashboard')->with('error', 'Kamu bukan admin!');
        }
        return view('dashboardadmin');
    })->name('dashboard');

    // ROUTE UNTUK HALAMAN USERS
    Route::get('/users', function () {
        // Cek login dan role admin lagi (penting untuk keamanan setiap halaman admin)
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Silakan login dulu!');
        }
        if (auth()->user()->role != 'admin') {
            return redirect('/dashboard')->with('error', 'Kamu bukan admin!');
        }

        // Ambil semua pengguna dari database
        $allUsers = \App\Models\User::all();

        // Pisahkan pengguna berdasarkan role
        // Filter() ini fungsi collection Laravel yg keren buat misahin data dengan cepet
        $adminUsers = $allUsers->filter(function ($user) {
            return $user->role === 'admin';
        });

        $regularUsers = $allUsers->filter(function ($user) {
            return $user->role !== 'admin';
        });

        // Kirim data adminUsers dan regularUsers ke view
        return view('admin.users_index', [
            'adminUsers' => $adminUsers,
            'regularUsers' => $regularUsers
        ]);
    })->name('users.index');

    // UNTUK DELETE USER
    Route::delete('/users/{user}', function (\App\Models\User $user) {
        // Parameter {user} otomatis ambil data user dari database - ini fitur Route Model Binding Laravel
        if (!auth()->check() || auth()->user()->role != 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Aksi tidak diizinkan.');
        }

        // Cegah admin hapus diri sendiri - safety measure yang penting
        if (auth()->id() == $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name; // Simpan nama untuk pesan sukses
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', "Pengguna '{$userName}' berhasil dihapus.");
    })->name('users.destroy');

    // TAMBAHKAN ROUTE UNTUK MENAMPILKAN FORM EDIT USER
    Route::get('/users/{user}/edit', function (\App\Models\User $user) {
        // Cek login dan role admin
        if (!auth()->check() || auth()->user()->role != 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Aksi tidak diizinkan.');
        }
        // Ini dummy return - harusnya nanti diganti sama view beneran
        return "Halaman untuk mengedit User ID: " . $user->id . " (Nama: " . $user->name . "). Form edit akan ada di sini.";
    })->name('users.edit');

    // TAMBAHKAN ROUTE UNTUK MEMPROSES UPDATE USER (DARI FORM EDIT)
    Route::put('/users/{user}', function (Request $request, \App\Models\User $user) {
        // Cek login dan role admin
        if (!auth()->check() || auth()->user()->role != 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Aksi tidak diizinkan.');
        }
        // Juga masih dummy return - nanti isinya logic buat update user
        return "Proses update untuk User ID: " . $user->id . ". Data dari form: " . json_encode($request->all());
    })->name('users.update');

    // Products routes
    Route::get('/products', function () {
        // Validasi apakah user adalah admin
        if (!auth()->check() || auth()->user()->role != 'admin') {
            return redirect('/login');
        }

        $products = \App\Models\Product::with('category')->latest()->get();
        return view('admin.products_index', compact('products'));
    })->name('products.index');

    Route::delete('/products/{product}', function (\App\Models\Product $product) {
        // Validasi apakah user adalah admin
        if (!auth()->check() || auth()->user()->role != 'admin') {
            return redirect()->route('admin.products.index')->with('error', 'Unauthorized action.');
        }

        // Hapus file gambar jika ada
        if ($product->image_path && \Storage::exists('public/' . $product->image_path)) {
            \Storage::delete('public/' . $product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    })->name('products.destroy');

    // Route admin lainnya bisa ditambahkan di sini
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

// route untuk UserController
Route::resource('users', 'App\Http\Controllers\UserController');

// Development/Test routes
Route::get('/setup-test-data', function () {
    //

})->name('setup.test.data');
// Debug route - only for development
Route::get('/show-users-for-id', function() {
    //
})->name('show-users-for-id');
