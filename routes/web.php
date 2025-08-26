<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    CategoryController,
    ProductController,
    UserController
};

Route::get('/', function () {
    return view('welcome');
});

Route::post('users/signup', [AuthController::class, 'signUp']);
Route::post('users/signin', [AuthController::class, 'signIn']);

Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('products', [ProductController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('users/me', [AuthController::class, 'current']);
    Route::patch('users/me', [AuthController::class, 'update']);
    Route::delete('users/signout', [AuthController::class, 'signOut']);

    Route::apiResource('users', UserController::class);

    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::patch('categories/{categories}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{categories}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('categories/{categories}', [CategoryController::class, 'show'])->name('categories.show');

    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::patch('products/{product}', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'destroy']);
});
