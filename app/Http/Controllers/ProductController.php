<?php

namespace App\Http\Controllers;

use App\Models\Product;
// use Illuminate\Http\Request; // Not strictly needed if not used

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load(['reviews.user', 'seller']); // Eager load relationships

        // Calculate rating distribution
        $ratingDistribution = $product->reviews()
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc') // Order by rating descending (5, 4, 3, 2, 1)
            ->pluck('count', 'rating')  // Get counts keyed by rating
            ->all();                    // Convert to a plain array

        // Fill in missing ratings with 0 count for the histogram (1 to 5 stars)
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingDistribution[$i])) {
                $ratingDistribution[$i] = 0;
            }
        }
        // ksort($ratingDistribution); // To sort keys 1,2,3,4,5 if your view loop expects that.
                                    // My provided Blade histogram loops 5 down to 1.

        return view('products.show', compact('product', 'ratingDistribution'));
    }
}