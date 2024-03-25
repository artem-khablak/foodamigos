<?php

namespace Tests\Feature\Order;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates an order successfully', function () {
    $user = User::factory()->create();
    $product1 = Product::factory()->create();
    $product2 = Product::factory()->create();

    $products = [
        ['id' => $product1->id, 'quantity' => 2],
        ['id' => $product2->id, 'quantity' => 3],
    ];

    // Acting as a signed-in user
    $this->actingAs($user)
        ->postJson(route('orders.store'), ['products' => $products])
        ->assertStatus(201)
        ->assertJsonStructure([
            'id', 'user_id', 'total', 'status', 'created_at', 'updated_at',
        ]);
});

it('throws an exception when the total price is less than 15', function () {
    $user = User::factory()->create();
    $product1 = Product::factory()->create(['price' => 5]);
    $product2 = Product::factory()->create(['price' => 4]); // Ensure these prices reflect your app's logic

    $products = [
        ['id' => $product1->id, 'quantity' => 1],
        ['id' => $product2->id, 'quantity' => 1],
    ];

    // Acting as a signed-in user
    $this->actingAs($user)
        ->postJson(route('orders.store'), ['products' => $products])
        ->assertStatus(400)
        ->assertJson([
            'message' => 'Minimum order amount is 15 EUR'
        ]);
});
