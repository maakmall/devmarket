<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('users/signup', [AuthController::class, 'signUp']);
Route::post('users/signin', [AuthController::class, 'signIn']);
Route::get('users/me', [AuthController::class, 'current'])->middleware('auth:sanctum');
Route::patch('users/me', [AuthController::class, 'update'])->middleware('auth:sanctum');
Route::delete('users/signout', [AuthController::class, 'signOut'])->middleware('auth:sanctum');
