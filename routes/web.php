<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.home');
});

Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class);
