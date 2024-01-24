<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->orderBy('created_at', 'desc')->get();

        return view('coffee_sales', [
            'sales' => $sales,
            'products' => Product::all(),
        ]);
    }
}
