<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    //trae todos los clientes
    public function index()
    {
        return Cliente::all();
    }

    //crea un nuevo cliente
    public function store(Request $request)
    {
        $cliente = Cliente::create($request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes',
            'telefono' => 'nullable|string|max:20',
        ]));
        return response()->json($cliente, 201);
    }

    //muestra un cliente por id
    public function show(string $id)
    {
        return Cliente::findOrFail($id);
    }

    //actualiza un cliente por id
    public function update(Request $request, string $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:clientes,email,' . $id,
            'telefono' => 'nullable|string|max:20',
        ]));
        return response()->json($cliente, 200);
    }

    //elimina un cliente por id
    public function destroy(string $id)
    {
        Cliente::destroy($id);
        return response()->json(null, 204); 
    }
}
