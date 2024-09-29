<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacionController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/iniciar-sesion', [AutenticacionController::class, 'iniciarSesion']);
Route::post('/cerrar-sesion', [AutenticacionController::class, 'cerrarSesion'])->middleware('auth');