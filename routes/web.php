<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.home');
});

Route::resource('customers', CustomerController::class);
Route::get('/customers/select/{id}', [CustomerController::class, 'select'])->name('customers.select');

Route::resource('stocks', StockController::class);
Route::resource('products', ProductController::class);
Route::resource('carts', CartController::class);
Route::post('/carrinho/adicionar', [CartController::class, 'add'])->name('cart.add');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('/loja', [CartController::class, 'index'])->name('carts.index');

