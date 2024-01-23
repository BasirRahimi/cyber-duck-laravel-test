<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

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
    }
}
