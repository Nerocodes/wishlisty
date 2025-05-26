<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishlistRequest;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    protected $wishlistRepository;

    public function __construct(WishlistRepositoryInterface $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    /**
     * Display the wishlist items for the authenticated user.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $wishlistItems = $this->wishlistRepository->getWishlistItems($userId);

        return response()->json([
            'message' => 'Wishlist items retrieved successfully',
            'items' => $wishlistItems,
        ], 200);
    }

    /**
     * Add an item to the wishlist.
     */
    public function store(WishlistRequest $request)
    {
        $data = $request->validated();

        $userId = $request->user()->id;

        $wishlistItem = $this->wishlistRepository->addItemToWishlist($userId, $data);

        return response()->json([
            'message' => 'Item added to wishlist successfully',
            'item' => $wishlistItem,
        ], 201);
    }

    /**
     * Remove an item from the wishlist.
     */
    public function destroy(Request $request, $productId)
    {
        $userId = $request->user()->id;

        $this->wishlistRepository->removeItemFromWishlist($userId, $productId);

        return response()->json([
            'message' => 'Item removed from wishlist successfully',
        ], 200);
    }
}
