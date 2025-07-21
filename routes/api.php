<?php

use App\Http\Controllers\Webhook;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/order-status', [Webhook::class, 'updateStatus']);
