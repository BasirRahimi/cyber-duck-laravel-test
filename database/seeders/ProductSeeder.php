<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Product::where('name', 'Gold Coffee')->doesntExist()) {
            Product::factory()->create([
                'name' => 'Gold Coffee',
                'profit_margin' => 0.25,
                'shipping_cost' => 10.00,
            ]);
        }
        if (Product::where('name', 'Arabic Coffee')->doesntExist()) {
            Product::factory()->create([
                'name' => 'Arabic Coffee',
                'profit_margin' => 0.15,
                'shipping_cost' => 10.00,
            ]);
        }
    }
}
