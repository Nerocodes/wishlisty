<?php
namespace App\Repositories;

use App\Models\Product;
use App\Models\Wishlist;
use App\Repositories\Contracts\WishlistRepositoryInterface;

class WishlistRepository implements WishlistRepositoryInterface
{
    public function getWishlistItems(int $userId)
    {
        return Product::whereHas('wishlists', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['wishlist' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->paginate();
    }

    public function addItemToWishlist(int $userId, array $data)
    {
        return Wishlist::create([
            'user_id' => $userId,
            'product_id' => $data['product_id'],
            'priority' => $data['priority'] ?? Wishlist::PRIORITY_MEDIUM,
            'notes' => $data['notes'] ?? null,
        ]);
    }

    public function removeItemFromWishlist(int $userId, int $productId)
    {
        return Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }
}