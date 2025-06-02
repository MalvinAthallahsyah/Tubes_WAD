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

        // Ambil data produk
        $products = Product::latest()->take(8)->get();

        return view('dashboard', [
            'user' => $user,
            'products' => $products,
        ]);
    }
}
