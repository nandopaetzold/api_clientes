<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::post('/cliente', [ClienteController::class, 'create']);
Route::put('/cliente/{id}', [ClienteController::class, 'update']);
Route::delete('/cliente/{id}', [ClienteController::class, 'delete']);
Route::get('/cliente/{id}', [ClienteController::class, 'read']);
Route::get('/cliente/final-placa/{id}', [ClienteController::class, 'findByFinalPlaca']);