<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class EloquentProductRepository implements ProductRepositoryInterface
{
    protected Product $model;

    /**
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    /**
     * Get all the records from the database.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @return Product
     *
     * @throws ModelNotFoundException
     */
    public function findOrFail(int $id): Product
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Check if the requested quantity of a product is available.
     *
     * @param int $productId The ID of the product
     * @param int $quantity The requested quantity
     * @return bool Returns true if the requested quantity is available
     */
    public function checkAvailability(int $productId, int $quantity): bool
    {
        $product = $this->findOrFail($productId);
        if ($product->quantity < $quantity) {
            throw new ModelNotFoundException('Requested quantity for product ' . $product->name . ' is not available.');
        }
        return true;
    }

}
