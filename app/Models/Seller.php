<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function reviews()
    {
        // Reviews directly for the seller
        return $this->hasMany(Review::class)->whereNull('product_id');
    }

    // Accessor for average rating for seller reviews
    public function getReputationScoreAttribute()
    {
        return round($this->reviews()->avg('rating'), 1);
    }

    // Accessor for total seller reviews
    public function getTotalSellerReviewsAttribute()
    {
        return $this->reviews()->count();
    }
}