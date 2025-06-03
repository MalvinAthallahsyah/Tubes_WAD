<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ApiReviewController extends Controller
{
    /**
     * Display a listing of all reviews.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $reviews = Review::all();
        return response()->json([
            'status' => 'success',
            'data' => $reviews
        ]);
    }

    /**
     * Display the specified review.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Review $review)
    {
        return response()->json([
            'status' => 'success',
            'data' => $review
        ]);
    }
}
