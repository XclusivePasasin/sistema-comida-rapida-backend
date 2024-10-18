<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

// Route for users
Route::prefix('api')->group(function () {
    Route::get('/users/select', [UsersController::class ,'showUsers']);
    Route::post('/users/create', [UsersController::class ,'createUser']);
    Route::put('/users/update', [UsersController::class ,'updateUser']);
    Route::delete('/users/delete', [UsersController::class ,'deleteUser']);
    Route::get('/users/search', [UsersController::class ,'searchUser']);
});