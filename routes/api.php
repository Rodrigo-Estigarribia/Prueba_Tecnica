<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\WebhookController;

Route::apiResource('clientes', ClienteController::class);
Route::apiResource('productos', ProductoController::class);

Route::post('/webhook/stock', [WebhookController::class, 'descontarStock']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
