<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan model Product Anda di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mengambil data pengguna yang login

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard aplikasi.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Ambil data produk.
        // Contoh: mengambil 8 produk terbaru
        $products = Product::latest()->take(8)->get();
        // Atau jika Anda ingin menampilkan semua produk:
        // $products = Product::all();

        return view('dashboard', [ // Pastikan Anda memiliki view 'dashboard.blade.php'
            'user' => $user,
            'products' => $products,
        ]);
    }
}