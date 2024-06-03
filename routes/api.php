<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['prefix' => 'product'], function () {
    Route::get('index', [ProductController::class, 'index'])->name('product.getAllProduct');
    Route::get('detail/{id}', [ProductController::class, 'show'])->name('product.getDetailProduct');
});
Route::group(['prefix' => 'store'], function () {
    Route::get('index', [StoreController::class, 'index'])->name('store.getAllStore');
    Route::get('detail/{id}', [StoreController::class, 'show'])->name('store.getDetailStore');
});

Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'product'], function () {
        Route::post('created', [ProductController::class, 'store'])->name('auth.admin.product.createProduct');
        Route::post('destroy/{id}', [ProductController::class, 'destroy'])->name('auth.admin.product.destroyProduct');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('auth.admin.updateProduct');
    });
    Route::group(['prefix' => 'store'], function () {
        Route::post('created', [StoreController::class, 'store'])->name('auth.admin.addStore');
        Route::post('destroy/{id}', [StoreController::class, 'destroy'])->name('auth.admin.destroyStore');
        Route::post('update/{id}', [StoreController::class, 'update'])->name('auth.admin.updateStore');
    });
    Route::post('logout', [AuthController::class, 'logout']);
});
