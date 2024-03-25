<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function all();
    public function findOrFail(int $id);
    public function checkAvailability(int $productId, int $quantity): bool;
}
