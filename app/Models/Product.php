<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'seller_id'];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Accessor for average rating
    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating'), 1);
    }

    // Accessor for total reviews
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }
}