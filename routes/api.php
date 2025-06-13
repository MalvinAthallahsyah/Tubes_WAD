<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;

// Product Management
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// User Management
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);

Route::get('/reviews', [App\Http\Controllers\Api\ApiReviewController::class, 'index']);
Route::get('/reviews/{review}', [App\Http\Controllers\Api\ApiReviewController::class, 'show']);
