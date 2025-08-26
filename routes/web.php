<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    CategoryController,
    UserController
};

Route::get('/', function () {
    return view('welcome');
});

Route::post('users/signup', [AuthController::class, 'signUp']);
Route::post('users/signin', [AuthController::class, 'signIn']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('users/me', [AuthController::class, 'current']);
    Route::patch('users/me', [AuthController::class, 'update']);
    Route::delete('users/signout', [AuthController::class, 'signOut']);

    Route::apiResources([
        'users' => UserController::class,
        'categories' => CategoryController::class,
    ]);
});
