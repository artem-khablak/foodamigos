<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\Order\EloquentOrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\EloquentProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, function () {
            return new EloquentProductRepository(new Product);
        });
        $this->app->bind(OrderRepositoryInterface::class, function () {
            return new EloquentOrderRepository(new Order);
        });
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
