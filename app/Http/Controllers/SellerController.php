<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function show(Seller $seller)
    {
        // Eager load reviews specific to the seller and their users
        $seller->load(['reviews.user']); // Ensure 'reviews' on Seller model gets direct seller reviews
        return view('sellers.show', compact('seller'));
    }
}