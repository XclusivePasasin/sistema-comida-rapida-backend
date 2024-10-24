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
Route::put('/users/update', [UserController::class ,'updateUser']);
Route::delete('/users/delete', [UserController::class ,'deleteUser']);
Route::get('/users/search', [UserController::class ,'searchUser']);

// Endpoints for costumer.
Route::get('/customers', [CustomerController::class, 'showCustomers']);
Route::get('/customers/search', [CustomerController::class, 'searchCustomer']);
Route::post('/customers/create', [CustomerController::class, 'createCustomer']);
Route::put('/customers/update', [CustomerController::class, 'updateCustomer']);
Route::delete('/customers/delete', [CustomerController::class, 'deleteCustomer']);

// Endpoints for Tables.
Route::get('/tables', [TableController::class, 'showTables']);
Route::get('/tables/check-existence', [TableController::class, 'checkTableExistence']);
Route::post('/tables/create', [TableController::class, 'createTable']);
Route::put('/tables/update', [TableController::class, 'updateTable']);
Route::delete('/tables/delete', [TableController::class, 'deleteTable']);

// Endpoints for Dishes
Route::get('/dishes', [DishController::class, 'showDishes']); 
Route::post('/dishes/create', [DishController::class, 'createDish']); 
Route::put('/dishes/update', [DishController::class, 'updateDish']);
Route::delete('/dishes/delete', [DishController::class, 'deleteDish']); 
Route::get('/dishes/search', [DishController::class, 'searchDish']); 

//Endpoins for categories
Route::get('/categories', [CategoryController::class, 'showCategories']); 
Route::get('/categories/search', [CategoryController::class, 'searchCategories']);
Route::post('/categories/create', [CategoryController::class, 'createCategory']); 
Route::put('/categories/update', [CategoryController::class, 'updateCategory']); 
Route::delete('/categories/delete', [CategoryController::class, 'deleteCategory']); 
Route::get('categories/check-existence', [CategoryController::class, 'checkCategoryExists']);

// Endpoints for orders.
Route::get('/orders', [OrderController::class, 'showOrders']); 
Route::post('/orders/create', [OrderController::class, 'createOrder']);
Route::put('/orders/update', [OrderController::class, 'updateOrder']);
Route::delete('/orders/delete', [OrderController::class, 'deleteOrder']); 



// Endpoints for detail orders
Route::get('/detail-orders', [DetailOrderController::class, 'showDetailOrders']); 
Route::post('/detail-orders/create', [DetailOrderController::class, 'createDetailOrder']); 
Route::put('/detail-orders/update', [DetailOrderController::class, 'updateDetailOrder']);
Route::delete('/detail-orders/delete', [DetailOrderController::class, 'deleteDetailOrder']); 