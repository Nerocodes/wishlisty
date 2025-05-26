<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::post('/auth/register', [App\Http\Controllers\AuthenticationController::class, 'register']);
Route::post('/auth/login', [App\Http\Controllers\AuthenticationController::class, 'login']);
Route::post('/auth/logout', [App\Http\Controllers\AuthenticationController::class, 'logout'])
    ->middleware('auth:sanctum');

// Product routes
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index']);
Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    // Wishlist routes
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index']);
    Route::post('/wishlist', [App\Http\Controllers\WishlistController::class, 'store']);
    Route::delete('/wishlist/{productId}', [App\Http\Controllers\WishlistController::class, 'destroy']);
});
