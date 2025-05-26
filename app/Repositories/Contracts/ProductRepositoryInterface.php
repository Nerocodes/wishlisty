<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    /**
     * Get all products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllProducts(int $perPage = 15);

    /**
     * Find a product by its ID.
     *
     * @param int $id
     * @return \App\Models\Product
     */
    public function findProductById(int $id);
}