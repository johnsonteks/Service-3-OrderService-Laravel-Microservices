<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/orders/user/{userId}', [OrderController::class, 'getOrdersByUser']);
Route::get('/orders/product/{productId}', [OrderController::class, 'getOrdersByProduct']);

