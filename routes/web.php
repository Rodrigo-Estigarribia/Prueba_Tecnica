<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;

#ruta a la vista clientes
Route::get('/', function () {
    return view('clientes');
});

#ruta a la vista productos
Route::get('/productos', function () {
    return view('productos');
});

#ruta a la vista compra
Route::get('/compra', function () {
    return view('compra');
});

#ruta a la vista historial
Route::get('/historial', function () {
    return view('historial');
});

