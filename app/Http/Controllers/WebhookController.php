<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function descontarStock(Request $request)
    {
        $data = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $product = Producto::find($data['producto_id']);
        if ($product->stock < $data['cantidad']) {
            return response()->json(['error' => 'Stock insuficiente'], 400);
        }

        $product->stock -= $data['cantidad'];
        $product->save();

        return response()->json($product);
    }
}