<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculateSellingPriceRequest;
use App\Http\Requests\StoreSaleRequest;
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

    public function store(StoreSaleRequest $request)
    {
        $product = Product::findOrFail($request->input('productId'));

        $quantity = $request->input('quantity');
        $unitCost = $request->input('unitCost');
        $sellingPrice = $request->input('sellingPrice');

        // Create a new sale via the Product relationship
        $sale = $product->sales()->create([
            'quantity' => $quantity,
            'unit_cost' => $unitCost,
            'selling_price' => $sellingPrice,
        ]);

        return response()->json(['sale' => $sale], 201);
    }

    public function calculateSellingPrice(CalculateSellingPriceRequest $request)
    {
        $product = Product::findOrFail($request->input('product-id'));

        $proftMargin = $product->profit_margin;
        $shippingCost = $product->shipping_cost;

        $quantity = $request->input('quantity');
        $unitCost = $request->input('unit-cost');

        // Calculate the selling price
        $cost = $quantity * $unitCost;
        $sellingPrice = ($cost / (1 - $proftMargin)) + $shippingCost;

        //round the sellingPrice to two decimal places
        $sellingPrice = round($sellingPrice, 2);

        return response()->json(['selling_price' => $sellingPrice]);
    }
}
