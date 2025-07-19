<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('customer.index');
});

Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class);
