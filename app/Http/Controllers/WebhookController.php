<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function descontarStock(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $product = Product::find($data['product_id']);
        if ($product->stock < $data['cantidad']) {
            return response()->json(['error' => 'Stock insuficiente'], 400);
        }

        $product->stock -= $data['cantidad'];
        $product->save();

        return response()->json($product);
    }
}