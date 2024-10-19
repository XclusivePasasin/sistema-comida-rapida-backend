<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController ;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// endpoint for users
Route::post('/users/login', [UserController::class ,'loginUser']);
Route::get('/users/select', [UserController::class ,'showUsers']);
Route::post('/users/create', [UserController::class ,'createUser']);
Route::put('/users/update', [UserController::class ,'updateUser']);
Route::delete('/users/delete', [UserController::class ,'deleteUser']);
Route::get('/users/search', [UserController::class ,'searchUser']);