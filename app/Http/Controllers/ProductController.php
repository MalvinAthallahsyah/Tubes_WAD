<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Untuk Storage::disk()

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->available(); // Asumsi scope 'available()' sudah ada di Model Product

        if ($request->has('category') && !empty($request->category)) {
            // Pertimbangkan validasi $request->category jika perlu (misalnya, integer)
            $query->where('category_id', $request->category);
        }

        // Pertimbangkan pagination jika produk sangat banyak: $products = $query->paginate(15);
        $products = $query->orderBy('created_at', 'desc')->get(); // Contoh: urutkan berdasarkan terbaru
        $categories = Category::orderBy('name')->get(); // Diurutkan berdasarkan nama untuk tampilan filter

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product) // Route Model Binding sudah baik
    {
        $product->load(['category', 'seller', 'reviews.user']); // Asumsi relasi 'seller' dan 'reviews' ada

        $ratingDistribution = $product->reviews()
            ->select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            // ->orderBy('rating', 'desc') // Urutan dari pluck akan mengikuti ini
            ->pluck('count', 'rating')
            ->all();

        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingDistribution[$i])) {
                $ratingDistribution[$i] = 0;
            }
        }
        ksort($ratingDistribution); // Memastikan urutan rating 1-5 untuk view

        return view('products.show', compact('product', 'ratingDistribution'));
    }

    public function create()
    {
        // Mengambil kategori, diurutkan berdasarkan nama untuk dropdown
        $categories = Category::orderBy('name')->get();
        // Alternatif jika hanya butuh id dan nama untuk dropdown, lebih hemat memori:
        // $categories = Category::orderBy('name')->pluck('name', 'id');
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Pertimbangkan menggunakan Form Request jika validasi kompleks: php artisan make:request StoreProductRequest
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // tambahkan webp jika diinginkan
            // 'seller_id' => 'required|exists:users,id', // Jika produk harus punya seller saat dibuat
        ]);

        $productData = $request->only(['name', 'price', 'category_id', 'stock', 'description']);
        // Jika ada seller_id dari user yang login:
        // $productData['seller_id'] = auth()->id(); // Pastikan user login

        $product = new Product($productData);

        if ($request->hasFile('image_path')) {
            $product->image_path = $request->file('image_path')->store('images/products', 'public');
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // MENGGUNAKAN ROUTE MODEL BINDING
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        // $categories = Category::orderBy('name')->pluck('name', 'id'); // Alternatif
        return view('products.edit', compact('product', 'categories'));
    }

    // MENGGUNAKAN ROUTE MODEL BINDING
    public function update(Request $request, Product $product)
    {
        // Pertimbangkan menggunakan Form Request: php artisan make:request UpdateProductRequest
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $updateData = $request->only(['name', 'price', 'category_id', 'stock', 'description']);

        if ($request->hasFile('image_path')) {
            // Hapus gambar lama jika ada
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $updateData['image_path'] = $request->file('image_path')->store('images/products', 'public');
        }

        $product->fill($updateData)->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // MENGGUNAKAN ROUTE MODEL BINDING
    public function destroy(Product $product)
    {
        // Hapus gambar terkait jika ada
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
