<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreRequest;
use App\Jobs\ProcessOrder;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected OrderService $orderService;

    /**
     * Constructor for the class
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $products = $request->validated()['products'];

        try {
            $order = $this->orderService->create($products);

            ProcessOrder::dispatch($order->id)->delay(now()->addMinutes(3));

            return response()->json($order, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @param Order $order
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Order $order): JsonResponse
    {
        $this->authorize('view', $order);
        $order->load(['user', 'products']);

        return response()->json($order);
    }
}
