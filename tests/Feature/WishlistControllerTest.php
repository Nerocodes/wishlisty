<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WishlistControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCanAddProductToWishlist()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/wishlist', [
            'product_id' => $product->id,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'item' => ['id', 'user_id', 'product_id', 'created_at', 'updated_at'],
                 ])
                 ->assertJsonFragment(['message' => 'Product added to wishlist successfully']);
    }

    public function testCanGetWishlistItems()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->getJson('/api/wishlist');

        $response->assertStatus(200)
                ->assertJsonStructure([
                     'message',
                    'items' => [
                        'data' => [
                            '*' => ['id', 'user_id', 'product_id', 'created_at', 'updated_at'],
                        ],
                    ],
                 ])
                 ->assertJsonFragment(['message' => 'Wishlist items retrieved successfully']);
    }

    public function testCanRemoveProductFromWishlist()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->postJson('/api/wishlist', ['product_id' => $product->id]);

        $response = $this->deleteJson("/api/wishlist/{$product->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Product removed from wishlist successfully']);
    }
}
