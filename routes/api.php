<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products',[ProductController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
route::get('/orders', [OrderController::class, 'myorders']);
route::get('/cart', [CartController::class, 'mycart']);
route::get('/cart/remove/{id}', [CartController::class, 'destroy']);
});
