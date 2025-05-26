<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts(int $perPage = 15)
    {
        return Product::paginate($perPage);
    }

    public function findProductById(int $id)
    {
        return Product::findOrFail($id);
    }
}