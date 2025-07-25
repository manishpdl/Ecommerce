<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'home']);
Route::get('/viewproduct/{id}', [PagesController::class, 'viewproduct'])->name('viewproduct');
Route::get('/categoryproduct/{catid}', [PagesController::class, 'categoryproduct'])->name('categoryproduct');
Route::get('/search',[PagesController::class,'search'])->name('search');
Route::get('/order/search',[OrderController::class,'searchorder'])->name('search.order');
Route::get('/products/search',[ProductController::class,'searchproduct'])->name('search.product');

Route::post('/product/review', [ReviewController::class, 'review'])->middleware('auth')->name('product.review');



Route::middleware('auth')->group(function(){
    Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
    Route::get('/mycart', [PagesController::class, 'mycart'])->name('mycart');
    Route::get('/checkout/{cartid}', [PagesController::class, 'checkout'])->name('checkout');
    Route::post('/cart/update/{cartid}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/order/store/{cartid}', [OrderController::class, 'store'])->name('order.store');
    Route::post('/order/store/{cartid}', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/esewa/{cartid}', [OrderController::class, 'store_esewa'])->name('order.esewa');
    Route::get('/myorders', [PagesController::class, 'myorders'])->name('myorders');
    Route::post('/order/cancel', [PagesController::class, 'cancelorder'])->name('order.cancel');


});


Route::get('/dashboard',[DashboardController::class,'dashboard'])->middleware(['auth', 'isadmin'])->name('dashboard');

Route::middleware(['auth','isadmin'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit',[CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/{id}/destroy',[CategoryController::class,'destroy'])->name('categories.destroy');

    //Product
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/{id}/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get(('/orders/status/{orderid}/{status}'), [OrderController::class, 'update_status'])->name('orders.status');


    Route::get('/reviews/show', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/{id}/destroy', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';