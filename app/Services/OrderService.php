<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class OrderService
{
    private ProductRepositoryInterface $productRepository;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(ProductRepositoryInterface $productRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $data
     * @return Order
     * @throws Exception
     */
    public function create(array $data): Order
    {
        $userId = auth()->id();
        $products = collect($data);

        $total = $this->calculateTotal($products);
        $this->validateOrderTotal($total);

        $order = $this->orderRepository->create([
            'user_id' => $userId,
            'total' => $total,
            'status' => 'pending'
        ]);
        $products->each(function ($product) use ($order) {
            $this->orderRepository->attachProduct($order, $product['id'], $product['quantity']);
        });

        return $order;
    }

    /**
     * @param Collection $products
     * @return float
     */
    private function calculateTotal(Collection $products): float
    {
        return $products->reduce(function ($carry, $product) {
            $this->productRepository->checkAvailability($product['id'], $product['quantity']);
            $productData = $this->productRepository->findOrFail($product['id']);
            return $carry + ($productData->price * $product['quantity']);
        }, 0);
    }

    /**
     * @param float $total
     * @throws Exception
     */
    private function validateOrderTotal(float $total): void
    {
        if ($total < 15) {
            throw new Exception('Minimum order amount is 15 EUR');
        }
    }

    /**
     * @param int $id
     * @return Order
     */
    public function show(int $id): Order
    {
        return $this->orderRepository->withRelations($id, ['user', 'products']);
    }
}
