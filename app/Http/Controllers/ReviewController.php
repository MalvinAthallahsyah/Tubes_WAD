<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Seller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

class ReviewController extends Controller
{
    public function index()
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
        $validatedData['user_id'] = auth()->id();

        if ($request->hasFile('review_images')) {
            $file = $request->file('review_images')[0]; // Get the first file
            $path = $file->store('review_images', 'public');
            $validatedData['image_path'] = $path; // Save the path to the database
        } elseif ($request->hasFile('review_image_single')) {
            $path = $request->file('review_image_single')->store('review_images', 'public');
            $validatedData['image_path'] = $path;
        }

        Review::create($validatedData);

        if ($request->filled('product_id')) {
            return redirect()->route('products.show', $request->product_id)->with('success', 'Feedback submitted successfully!');
        } elseif ($request->filled('seller_id')) {
            return redirect()->route('sellers.show', $request->seller_id)->with('success', 'Feedback submitted successfully!');
        }
        return redirect()->route('reviews.index')->with('success', 'Feedback submitted successfully!');
    }


    public function edit(Review $review)
    {
        $type = $review->product_id ? 'product' : 'seller';
        $reviewable = $review->product_id ? $review->product : $review->seller;
        return view('reviews.edit', compact('review', 'reviewable', 'type'));
    }

    public function update(UpdateReviewRequest $request, Review $review)
    {
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
