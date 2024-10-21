<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController ;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DetailOrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// endpoint for users
Route::post('/users/login', [UserController::class ,'loginUser']);
Route::get('/users/select', [UserController::class ,'showUsers']);
Route::post('/users/create', [UserController::class ,'createUser']);
Route::put('/users/update/{id}', [UserController::class ,'updateUser']);
Route::delete('/users/delete/{id}', [UserController::class ,'deleteUser']);
Route::get('/users/search', [UserController::class ,'searchUser']);

// Endpoints for costumer.
Route::get('/customers', [CustomerController::class, 'showCustomers']);
Route::post('/customers/create', [CustomerController::class, 'createCustomer']);
Route::put('/customers/update/{dui}', [CustomerController::class, 'updateCustomer']);
Route::delete('/customers/delete/{dui}', [CustomerController::class, 'deleteCustomer']);

// Endpoints for Tables.
Route::get('/tables', [TableController::class, 'showTables']);
Route::post('/tables/create', [TableController::class, 'createTable']);
Route::put('/tables/update/{id}', [TableController::class, 'updateTable']);
Route::delete('/tables/delete/{id}', [TableController::class, 'deleteTable']);

// Endpoints for Dishes

Route::get('/dishes', [DishController::class, 'showDishes']); 
Route::post('/dishes/create', [DishController::class, 'createDish']); 
Route::put('/dishes/update/{id_dish}', [DishController::class, 'updateDish']);
Route::delete('/dishes/delete/{id_dish}', [DishController::class, 'deleteDish']); 

//Endpoins for categories
Route::get('/categories', [CategoryController::class, 'showCategories']); 
Route::post('/categories/create', [CategoryController::class, 'createCategory']); 
Route::put('/categories/update/{id}', [CategoryController::class, 'updateCategory']); 
Route::delete('/categories/delete/{id}', [CategoryController::class, 'deleteCategory']); 

// Endpoints for orders.
Route::get('/orders', [OrderController::class, 'showOrders']); 
Route::post('/orders/create', [OrderController::class, 'createOrder']);
Route::put('/orders/update/{id}', [OrderController::class, 'updateOrder']);
Route::delete('/orders/delete/{id}', [OrderController::class, 'deleteOrder']); 



// Endpoints for detail orders
Route::get('/detail-orders', [DetailOrderController::class, 'showDetailOrders']); 
Route::post('/detail-orders/create', [DetailOrderController::class, 'createDetailOrder']); 
Route::put('/detail-orders/update/{id}', [DetailOrderController::class, 'updateDetailOrder']);
Route::delete('/detail-orders/delete/{id}', [DetailOrderController::class, 'deleteDetailOrder']); 