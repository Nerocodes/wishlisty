<?php

namespace App\Repositories\Contracts;

interface WishlistRepositoryInterface
{
    /**
     * Get all items in the wishlist for a user.
     *
     * @param int $userId
     * @return mixed
     */
    public function getWishlistItems(int $userId);

    /**
     * Add an item to the wishlist.
     *
     * @param int $userId
     * @param array $data
     * @return mixed
     */
    public function addItemToWishlist(int $userId, array $data);

    /**
     * Remove an item from the wishlist.
     *
     * @param int $userId
     * @param int $productId
     * @return mixed
     */
    public function removeItemFromWishlist(int $userId, int $productId);
}