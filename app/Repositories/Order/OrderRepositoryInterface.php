<?php

namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function create(array $attributes);
    public function attachProduct($order, int $productId, int $quantity);
    public function withRelations(int $id, array $relations);
    public function update(int $orderId, array $attributes);
}
