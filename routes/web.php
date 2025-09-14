<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;

Route::get('/clientes', function () {
    return view('clientes'); // tu Blade de clientes
});

Route::get('/productos', function () {
    return view('productos'); // tu Blade de productos
});

Route::get('/compra', function () {
    return view('compra'); // tu Blade de productos
});

#Route::resource('clientes', ClienteController::class);
#Route::resource('productos', ProductoController::class);

