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
Route::post('/customers/search-dui', [CustomerController::class, 'verifyDUI']);
Route::post('/customers/create', [CustomerController::class, 'createCustomer']);
Route::put('/customers/update', [CustomerController::class, 'updateCustomer']);
Route::delete('/customers/delete', [CustomerController::class, 'deleteCustomer']);

// Endpoints for Tables.
Route::get('/tables', [TableController::class, 'showTables']);
Route::get('/tables/check-existence', [TableController::class, 'checkTableExistence']);
Route::post('/tables/create', [TableController::class, 'createTable']);
Route::put('/tables/update', [TableController::class, 'updateTable']);
Route::delete('/tables/delete', [TableController::class, 'deleteTable']);
Route::get('/tables/search', [TableController::class, 'searchTable']);
Route::get('/tables/available-tables', [TableController::class, 'showAvailableTables']);
Route::put('/tables/update-status', [TableController::class, 'updateTableStatus']);


// Endpoints for Dishes
Route::get('/dishes', [DishController::class, 'showDishes']); 
Route::post('/dishes/create', [DishController::class, 'createDish']); 
Route::put('/dishes/update', [DishController::class, 'updateDish']);
Route::delete('/dishes/delete', [DishController::class, 'deleteDish']); 
Route::get('/dishes/search', [DishController::class, 'searchDish']); 
Route::get('/dishes/category/{id_category}', [DishController::class, 'getDishesByCategory']);

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
Route::put('/orders/update/{id}', [OrderController::class, 'updateOrder']);
Route::delete('/orders/delete', [OrderController::class, 'deleteOrder']); 
Route::get('/orders/next-id', [OrderController::class, 'getNextOrderId']);
Route::get('/orders/status/{status}', [OrderController::class, 'showOrdersByStatus']);
Route::get('/orders/invoice/{order_id}', [OrderController::class, 'generateInvoice']);

//endpoint for generate reports
Route::post('/report/daily-sales', [OrderController::class, 'generateDailySalesReport']);
Route::get('/report/periodic-sales', [OrderController::class, 'generatePeriodicSalesReport']); 
Route::post('/report/sales-by-category', [OrderController::class, 'generateSalesByCategoryReport']); 

// Endpoints for detail orders
Route::get('/detail-orders', [DetailOrderController::class, 'showDetailOrders']); 
Route::post('/detail-orders/create', [DetailOrderController::class, 'createDetailOrder']); 
Route::put('/detail-orders/update', [DetailOrderController::class, 'updateDetailOrder']);
Route::delete('/detail-orders/delete', [DetailOrderController::class, 'deleteDetailOrder']); 
Route::get('/orders/{id_order}/details', [DetailOrderController::class, 'getOrderDetails']);
