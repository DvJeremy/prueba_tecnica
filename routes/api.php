<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->apiResource('products', ProductController::class);
Route::middleware('auth:sanctum')->post('orders', [OrderController::class, 'CreateOrder']);
Route::middleware('auth:sanctum')->get('top-5-products', [ReportController::class, 'top5Selling']);
Route::middleware('auth:sanctum')->get('user-orders', [ReportController::class, 'userOrders']);