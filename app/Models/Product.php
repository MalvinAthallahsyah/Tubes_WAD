<?php

namespace App\Models; // Namespace saat ini

use Illuminate\Database\Eloquent\Model;
use App\Models\Category; // Anda sudah punya ini
use App\Models\Seller;   // <-- TAMBAHKAN IMPORT INI JIKA BELUM ADA
use App\Models\Review;   // <-- Tambahkan ini juga jika belum ada untuk relasi reviews

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'stock',
        'description',
        'image_path',
        'seller_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // METHOD RELASI SELLER YANG DIPERBAIKI
    public function seller()
    {
        // Gunakan Seller::class karena sudah di-import di atas
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    // Relasi reviews
    public function reviews()
    {
        return $this->hasMany(Review::class); // Gunakan Review::class jika sudah di-import
    }

    // Accessor untuk total_reviews
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    // Accessor untuk average_rating
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }
}