<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    //muestra todos los productos
    public function index()
    {
        return Producto::all();
    }

    //crea un nuevo producto
    public function store(Request $request)
    {
        $producto = Producto::create($request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'cliente_id' => 'exists:clientes,id',
        ]));
        return response()->json($producto, 201);
    }

    //muestra un producto por id
    public function show(string $id)
    {
        return Producto::findOrFail($id);
    }

    //actualiza un producto por id
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'precio' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'cliente_id' => 'sometimes|exists:clientes,id',
        ]));
        return response()->json($producto, 200);
    }

    //elimina un producto por id
    public function destroy(string $id)
    {
        Producto::destroy($id);
        return response()->json(null, 204);
    }
}
