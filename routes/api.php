<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\HistorialController;

#ruta al controlador cliente
Route::apiResource('clientes', ClienteController::class);

#ruta al controlador producto
Route::apiResource('productos', ProductoController::class);

#ruta al controlador historial
Route::apiResource('historial', HistorialController::class);

#ruta al controlador webhook para descontar stock
Route::post('/webhook/stock', [WebhookController::class, 'descontarStock']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
