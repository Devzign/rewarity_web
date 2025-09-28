<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PurchaseController as AdminPurchaseController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Middleware\EnsureUserHasRole;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest:web')->group(function (): void {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.attempt');
    });

    Route::middleware(['auth', EnsureUserHasRole::class . ':admin'])->group(function (): void {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', AdminUserController::class);
        Route::resource('products', AdminProductController::class);
        Route::resource('purchases', AdminPurchaseController::class)->only(['index', 'show']);

        Route::prefix('profile')->name('profile.')->group(function (): void {
            Route::get('/', [AdminProfileController::class, 'show'])->name('show');
            Route::get('edit', [AdminProfileController::class, 'edit'])->name('edit');
            Route::put('/', [AdminProfileController::class, 'update'])->name('update');
            Route::get('settings', [AdminProfileController::class, 'settings'])->name('settings');
            Route::get('privacy', [AdminProfileController::class, 'privacy'])->name('privacy');
        });
    });
});

Route::middleware(['auth', EnsureUserHasRole::class . ':dealer'])->group(function (): void {
    Route::resource('products', ProductController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('purchases', PurchaseController::class)->only(['index', 'store']);
});
