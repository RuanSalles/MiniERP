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
Route::resource('stocks', StockController::class);
Route::resource('products', ProductController::class);
Route::resource('carts', CartController::class);
Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
