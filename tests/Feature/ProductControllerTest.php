<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCanGetProducts()
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'products' => [
                         'data' => [
                             '*' => ['id', 'name', 'description', 'price', 'created_at', 'updated_at'],
                         ],
                     ],
                 ]);
    }

    public function testCanGetSingleProduct()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => ['id', 'name', 'description', 'price', 'created_at', 'updated_at'],
                 ])
                 ->assertJsonFragment(['id' => $product->id]);
    }
}
