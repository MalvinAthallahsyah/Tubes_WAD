<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB; // <-- DITAMBAHKAN: Untuk DB::raw() jika menghitung rating

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->available();

        // Jika ada filter kategori dari query string (?category=ID)
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        $products = $query->get();
        $categories = Category::all(); // Untuk tab navigasi kategori di view

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Menampilkan detail satu produk.
     *
     * @param  \App\Models\Product  $product  <-- DIPERBARUI: Menggunakan Route Model Binding
     * @return \Illuminate\View\View
     */
    public function show(Product $product) // <-- DIPERBARUI: Menggunakan Route Model Binding
    {
        // $product sudah otomatis diambil dari database berdasarkan ID di URL
        // Eager load relasi yang dibutuhkan oleh view products.show.blade.php
        $product->load(['category', 'seller', 'reviews.user']); // Asumsi ada relasi 'seller' dan 'reviews' (dengan 'user' di dalamnya) di model Product

        // Menghitung rating distribution untuk histogram
        // Ini adalah contoh, Anda mungkin perlu menyesuaikan berdasarkan struktur tabel 'reviews' Anda
        $ratingDistribution = $product->reviews() // Panggil sebagai method untuk query builder
            ->select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->pluck('count', 'rating') // Hasilnya: [5 => jumlah_bintang_5, 4 => jumlah_bintang_4, ...]
            ->all();

        // Memastikan semua level bintang (1-5) ada di array, meskipun hitungannya 0
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingDistribution[$i])) {
                $ratingDistribution[$i] = 0;
            }
        }
        // ksort($ratingDistribution); // Opsional, untuk mengurutkan berdasarkan kunci (bintang 1 ke 5) jika pluck tidak menjaga urutan


        // Kirim data produk dan ratingDistribution ke view
        return view('products.show', compact('product', 'ratingDistribution'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = new Product($request->only([
            'name', 'price', 'category_id', 'stock', 'description'
        ]));

        if ($request->hasFile('image_path')) {
            // Menyimpan gambar ke 'storage/app/public/images'
            // Pastikan Anda sudah menjalankan `php artisan storage:link`
            $product->image_path = $request->file('image_path')->store('images', 'public');
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(string $id) // Bisa juga diubah ke Product $product jika mau konsisten
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id) // Bisa juga diubah ke Product $product
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->fill($request->only([
            'name', 'price', 'category_id', 'stock', 'description'
        ]));

        if ($request->hasFile('image_path')) {
            // Hapus gambar lama jika ada dan jika diperlukan (belum diimplementasikan di sini)
            // Storage::disk('public')->delete($product->image_path);
            $product->image_path = $request->file('image_path')->store('images', 'public');
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id) // Bisa juga diubah ke Product $product
    {
        $product = Product::findOrFail($id);
        // Hapus gambar terkait jika ada sebelum menghapus produk (belum diimplementasikan di sini)
        // if ($product->image_path) {
        //     Storage::disk('public')->delete($product->image_path);
        // }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}