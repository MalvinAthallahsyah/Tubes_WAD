<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiReviewController; 

// Public API Routes for Reviews (GET Only)
Route::get('products/{product}/reviews', [ApiReviewController::class, 'getProductReviews']);
Route::get('products/{product}/rating', [ApiReviewController::class, 'getProductRating']);

Route::get('sellers/{seller}/reviews', [ApiReviewController::class, 'getSellerReviews']);
Route::get('sellers/{seller}/reputation', [ApiReviewController::class, 'getSellerReputation']);

Route::get('reviews/{review}', [ApiReviewController::class, 'getReview']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); 
});