<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Seller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
// use Illuminate\Support\Facades\Gate; // Keep if you plan to use Policies later

class ReviewController extends Controller
{
    public function index() // General index, maybe for admin later
    {
        $reviews = Review::with(['user', 'product', 'seller'])->latest()->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    public function createForProduct(Product $product)
    {
        return view('reviews.create', ['reviewable' => $product, 'type' => 'product']);
    }

    public function createForSeller(Seller $seller)
    {
        return view('reviews.create', ['reviewable' => $seller, 'type' => 'seller']);
    }

    public function store(StoreReviewRequest $request)
    {
        $validatedData = $request->validated();

        // When auth is integrated, user_id will come from auth()->id()
        // $validatedData['user_id'] = auth()->id();

        Review::create($validatedData);

        $redirectTarget = null;
        if ($request->has('product_id') && $request->product_id) {
            $redirectTarget = Product::find($request->product_id);
            if ($redirectTarget) {
                 return redirect()->route('products.show', $redirectTarget)->with('success', 'Review submitted successfully!');
            }
        } elseif ($request->has('seller_id') && $request->seller_id) {
             $redirectTarget = Seller::find($request->seller_id);
             if ($redirectTarget) {
                return redirect()->route('sellers.show', $redirectTarget)->with('success', 'Review submitted successfully!');
             }
        }
        return redirect()->route('reviews.index')->with('success', 'Review submitted successfully!');
    }

    public function edit(Review $review)
    {
        // Gate::authorize('update', $review); // Placeholder for policy
        $type = $review->product_id ? 'product' : 'seller';
        $reviewable = $review->product_id ? $review->product : $review->seller;
        return view('reviews.edit', compact('review', 'reviewable', 'type'));
    }

    public function update(UpdateReviewRequest $request, Review $review)
    {
        // Gate::authorize('update', $review); // Placeholder for policy
        $review->update($request->validated());

        if ($review->product_id) {
            return redirect()->route('products.show', $review->product_id)->with('success', 'Review updated successfully!');
        } elseif ($review->seller_id) {
            return redirect()->route('sellers.show', $review->seller_id)->with('success', 'Review updated successfully!');
        }
        return redirect()->route('reviews.index')->with('success', 'Review updated successfully!');
    }

    public function destroy(Review $review)
    {
        // Gate::authorize('delete', $review); // Placeholder for policy
        $productId = $review->product_id;
        $sellerId = $review->seller_id;

        $review->delete();

        if ($productId) {
            return redirect()->route('products.show', $productId)->with('success', 'Review deleted successfully!');
        } elseif ($sellerId) {
            return redirect()->route('sellers.show', $sellerId)->with('success', 'Review deleted successfully!');
        }
        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully!');
    }
}