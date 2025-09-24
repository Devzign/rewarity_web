<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::get('users', [UserController::class, 'index']);
    Route::post('users/login', [UserController::class, 'login']);
    Route::post('users/register', [UserController::class, 'register']);
});
