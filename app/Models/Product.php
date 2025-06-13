<?php

namespace App\Models; // Ini kayak alamat rumah buat kelas Product ini, biar PHP tau nyarinya di mana

use Illuminate\Database\Eloquent\Model; // Kita pake "cetakan" Model dari Laravel, biar gampang ngomong sama database
use App\Models\Category; // Manggil kelas Category biar bisa dipake di sini
use App\Models\Seller;   // Sama, ini buat kelas Seller
use App\Models\Review;   // Dan ini buat kelas Review

class Product extends Model
{
    // Nah, $fillable ini daftar kolom di tabel 'products' yang boleh diisi
    // pas kita bikin atau update data produk lewat Eloquent
    // Jadi, kalo ada data lain yang coba dimasukin, bakal diabaikan, buat keamanan gitu
    protected $fillable = [
        'name',
        'price',
        'category_id', // Ini foreign key buat nyambung ke tabel categories
        'stock',
        'description',
        'image_path',
        'seller_id',    // Ini foreign key buat nyambung ke tabel sellers
    ];

    // Fungsi ini buat ngedefinisiin relasi "belongsTo" ke model Category
    // Artinya, satu produk itu "milik" satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Sama kayak category(), tapi ini buat relasi ke model Seller
    // Satu produk "milik" satu seller 'seller_id' itu nunjukin kolom foreign key-nya
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    // Kalo yang ini, relasi "hasMany" ke model Review
    // Artinya, satu produk bisa "punya banyak" review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Ini namanya Accessor Keren kan?
    // Jadi, kita bisa manggil `$product->total_reviews` seolah-olah 'total_reviews' itu kolom di database,
    // padahal nilainya diitung dari fungsi ini (jumlah review yang ada)
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count(); // Ngitung jumlah review dari relasi reviews()
    }

    // Accessor lagi nih, buat dapetin rata-rata rating
    // Sama kayak di atas, bisa dipanggil pake `$product->average_rating`
    // `?? 0` itu buat jaga-jaga, kalo gak ada review, rata-ratanya jadi 0, gak error
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0; // Ngitung rata-rata dari kolom 'rating' di tabel reviews
    }

    // Ini namanya Local Scope Gunanya buat bikin query yang sering dipake jadi lebih simpel
    // Jadi, kalo mau cari produk yang stoknya masih ada, tinggal panggil `Product::available()->get()`
    // Gak perlu nulis `Product::where('stock', '>', 0)->get()` lagi
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }
}
