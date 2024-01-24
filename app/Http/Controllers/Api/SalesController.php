<?php

namespace App\Http\Controllers\Api;

use Akaunting\Money\Money;
use App\Http\Controllers\Controller;
use App\Http\Requests\CalculateSellingPriceRequest;
use App\Http\Requests\StoreSaleRequest;
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

        // Load the product relationship
        $sale->load('product');

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

        // Format the selling price as a currency
        $sellingPriceFormatted = Money::GBP($sellingPrice, true)->format();

        return response()->json(['sellingPrice' => $sellingPrice, 'sellingPriceFormatted' => $sellingPriceFormatted]);
    }
}
