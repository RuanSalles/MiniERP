<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\Webhook;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home.index');
});
Route::resource('home', HomeController::class);

Route::resource('customers', CustomerController::class);
Route::get('/customers/select/{id}', [CustomerController::class, 'select'])->name('customers.select');

Route::resource('stocks', StockController::class);
Route::resource('products', ProductController::class);
Route::resource('carts', CartController::class);
Route::get('webhook/{id}/{status}', [Webhook::class, 'updateStatus']);
Route::get('/orders/{order}/pdf', [OrderController::class, 'generatePdf'])->name('orders.pdf');


Route::resource('orders', OrderController::class);
Route::resource('coupons', CouponController::class);
Route::get('getCoupon/{data}', [CouponController::class, 'loadCoupon'])->name('getCoupon');
Route::post('/carrinho/adicionar', [CartController::class, 'add'])->name('cart.add');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('/loja', [CartController::class, 'index'])->name('carts.index');

