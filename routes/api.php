<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class);
Route::post('orders', [OrderController::class, 'CreateOrder']);
Route::get('top-5-products', [ReportController::class, 'top5Selling']);
Route::get('user-orders', [ReportController::class, 'userOrders']);