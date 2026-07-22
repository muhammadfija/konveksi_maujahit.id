<?php

use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang-kami', function () {
    return view('about');
});

Route::get('/cek-progres', function () {
    return view('tracking');
});

// Sistem Admin (Tanpa Auth)
Route::get('/admin/login', [\App\Http\Controllers\Web\AdminAuthController::class, 'showLogin']);
Route::post('/admin/login', [\App\Http\Controllers\Web\AdminAuthController::class, 'login']);

// Sistem Admin (Dengan Auth)
Route::middleware('admin.auth')->group(function () {
    Route::post('/admin/logout', [\App\Http\Controllers\Web\AdminAuthController::class, 'logout']);
    
    Route::get('/admin/profile', [\App\Http\Controllers\Web\AdminProfileController::class, 'index']);
    Route::post('/admin/profile', [\App\Http\Controllers\Web\AdminProfileController::class, 'update']);

    Route::get('/admin/dashboard', [\App\Http\Controllers\Web\AdminOrderController::class, 'dashboard']);
    Route::get('/admin/dashboard/export', [\App\Http\Controllers\Web\AdminOrderController::class, 'exportExcel']);
    
    Route::get('/admin/pesanan', [\App\Http\Controllers\Web\AdminOrderController::class, 'index']);
    Route::get('/admin/pesanan/baru', [\App\Http\Controllers\Web\AdminOrderController::class, 'create']);
    Route::post('/admin/pesanan', [\App\Http\Controllers\Web\AdminOrderController::class, 'store']);
    Route::get('/admin/pesanan/{id}', [\App\Http\Controllers\Web\AdminOrderController::class, 'show']);
    Route::put('/admin/pesanan/{id}', [\App\Http\Controllers\Web\AdminOrderController::class, 'update']);
    Route::delete('/admin/pesanan/{id}', [\App\Http\Controllers\Web\AdminOrderController::class, 'destroy']);
    
    Route::patch('/admin/pesanan/{id}/status', [\App\Http\Controllers\Web\AdminOrderController::class, 'updateStatus']);
    Route::post('/admin/pesanan/{id}/photo', [\App\Http\Controllers\Web\AdminOrderController::class, 'uploadPhoto']);
});
