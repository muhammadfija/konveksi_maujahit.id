<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Public tracking
Route::get('/track/{code}', [TrackingController::class, 'show']);

// Protected admin routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Orders
    Route::get('/admin/orders/stats', [OrderController::class, 'stats']);
    Route::get('/admin/orders', [OrderController::class, 'index']);
    Route::post('/admin/orders', [OrderController::class, 'store']);
    Route::get('/admin/orders/{id}', [OrderController::class, 'show']);
    Route::put('/admin/orders/{id}', [OrderController::class, 'update']);
    Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy']);
    Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus']);
    Route::post('/admin/orders/{id}/photos', [OrderController::class, 'uploadPhoto']);
});
