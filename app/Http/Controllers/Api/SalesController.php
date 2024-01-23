<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->get();

        return response()->json(['sales' => $sales]);
    }

    public function store(Request $request)
    {
        $quantity = $request->input('quantity');
        $unitCost = $request->input('unitCost');
        $sellingPrice = $request->input('sellingPrice');
        try {
            $product = Product::findOrFail($request->input('productId'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        if (!$quantity || $quantity < 1) {
            return response()->json(['error' => 'Quantity is required'], 422);
        }

        // if unitCost is 0 it's okay
        if (!$unitCost && $unitCost != 0) {
            return response()->json(['error' => 'Unit cost is required'], 422);
        }

        if (!$sellingPrice) {
            return response()->json(['error' => 'Selling price is required'], 422);
        }

        // Create a new sale via the Product relationship
        $sale = $product->sales()->create([
            'quantity' => $quantity,
            'unit_cost' => $unitCost,
            'selling_price' => $sellingPrice,
        ]);

        return response()->json(['sale' => $sale], 201);
    }

    public function sellingPrice(Request $request)
    {
        $quantity = $request->input('quantity');
        $unitCost = $request->input('unit-cost');
        try {
            $product = Product::findOrFail($request->input('product-id'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        if (!$quantity) {
            return response()->json(['selling_price' => 0]);
        }

        $proftMargin = $product->profit_margin;
        $shippingCost = $product->shipping_cost;

        if (!$unitCost) {
            return response()->json(['selling_price' => $shippingCost]);
        }


        // Calculate the selling price
        $cost = $quantity * $unitCost;
        $sellingPrice = ($cost / (1 - $proftMargin)) + $shippingCost;

        //round the sellingPrice to two decimal places
        $sellingPrice = round($sellingPrice, 2);

        return response()->json(['selling_price' => $sellingPrice]);
    }
}
