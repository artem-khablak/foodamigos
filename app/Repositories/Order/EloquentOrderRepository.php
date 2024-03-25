<?php

namespace App\Repositories\Order;

use App\Models\Order;

class EloquentOrderRepository implements OrderRepositoryInterface
{
    protected Order $model;

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    /**
     * @param array $attributes
     * @return Order
     */
    public function create(array $attributes): Order
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $order
     * @param int $productId
     * @param int $quantity
     * @return void
     */
    public function attachProduct($order, int $productId, int $quantity): void
    {
        $order->products()->attach($productId, ['quantity' => $quantity]);
    }

    /**
     * @param int $id
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
     */
    public function withRelations(int $id, array $relations): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    /**
     * @param int $orderId
     * @param array $attributes
     * @return Order
     */
    public function update(int $orderId, array $attributes): Order
    {
        $order = $this->model->findOrFail($orderId);
        $order->fill($attributes);
        $order->save();

        return $order;
    }
}
