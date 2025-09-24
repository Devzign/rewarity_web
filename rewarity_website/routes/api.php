<?php

use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\PurchaseApiController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::get('users', [UserController::class, 'index']);
    Route::get('products', [ProductApiController::class, 'index']);
    Route::get('purchases', [PurchaseApiController::class, 'index']);
    Route::get('users/profile', [UserController::class, 'profile']);
    Route::get('users/roles', [UserController::class, 'roles']);
    Route::post('users/profile/update', [UserController::class, 'updateProfile']);
    Route::post('users/login', [UserController::class, 'login']);
    Route::post('users/register', [UserController::class, 'register']);
});
