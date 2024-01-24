<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->orderBy('created_at', 'desc')->get();

        return view('coffee_sales', [
            'sales' => $sales,
            'products' => Product::all()
        ]);
    }
}
