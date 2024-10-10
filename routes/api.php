<?php
use App\Http\Controllers\AutenticacionController;

Route::post('/login', [AutenticacionController::class, 'login']);

