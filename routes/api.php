<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/users', [UserController::class, 'store']);

Route::group(['prefix' => '/products'], function () {
    Route::get('/', [ProductController::class, 'index']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => '/orders'], function () {
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/{order}', [OrderController::class, 'show']);
    });
});
