<?php

namespace App\Http\Controllers\Api; // Correct namespace

use App\Http\Controllers\Controller; // Base controller
use App\Models\Product;
use App\Models\Seller;
use App\Models\Review;
use Illuminate\Http\Request;

class ApiReviewController extends Controller
{
    public function getProductReviews(Product $product)
    {
        $reviews = $product->reviews()->with('user:id,name')->latest()->get();
        return response()->json($reviews);
    }

    public function getProductRating(Product $product)
    {
        return response()->json([
            'product_id' => $product->id,
            'average_rating' => $product->average_rating,
            'total_reviews' => $product->total_reviews,
            'rating_distribution' => $product->reviews()
                                    ->selectRaw('rating, count(*) as count')
                                    ->groupBy('rating')
                                    ->orderBy('rating', 'desc')
                                    ->pluck('count', 'rating'),
        ]);
    }

    public function getSellerReviews(Seller $seller)
    {
        // Using the 'reviews' relationship on Seller model
        $reviews = $seller->reviews()->with('user:id,name')->latest()->get();
        return response()->json($reviews);
    }

    public function getSellerReputation(Seller $seller)
    {
        return response()->json([
            'seller_id' => $seller->id,
            'seller_name' => $seller->name,
            'reputation_score' => $seller->reputation_score,
            'total_seller_reviews' => $seller->total_seller_reviews,
        ]);
    }

    public function getReview(Review $review)
    {
        return response()->json($review->load(['user:id,name', 'product:id,name', 'seller:id,name']));
    }
}
