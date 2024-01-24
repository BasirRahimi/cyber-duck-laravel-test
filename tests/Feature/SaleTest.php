<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class SaleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test the selling price calculation returns the correct value.
     */
    public function test_selling_price_calculation(): void
    {
        // Set up the product
        $product = Product::factory()->create();

        $quantity = rand(1, 1000);
        $unitCost = rand(1, 1000);

        $shippingCost = $product->shipping_cost;
        $profitMargin = $product->profit_margin;

        // calculate the selling price
        $cost = $quantity * $unitCost;
        $sellingPrice = ($cost / (1 - $profitMargin)) + $shippingCost;

        // Round the selling price to 2 decimal places
        $sellingPrice = round($sellingPrice, 2);

        // Set up the user and authenticate
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get("/api/v1/selling-price?product-id=$product->id&quantity=$quantity&unit-cost=$unitCost");

        // Assert the selling price is correct
        $response->assertStatus(200)
            ->assertExactJson(['selling_price' => $sellingPrice]);
    }

    /**
     * Test creating a sale with valid data.
     */
    // public function test_creating_a_sale_with_valid_data(): void
    // {
    // }

    /**
     * Test creating a sale with invalid data.
     */
    // public function test_creating_a_sale_with_invalid_data(): void
    // {
    // }
}
