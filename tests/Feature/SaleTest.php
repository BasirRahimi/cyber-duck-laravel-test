<?php

namespace Tests\Feature;

use Akaunting\Money\Money;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the selling price calculation returns the correct value.
     */
    public function test_selling_price_calculation_is_correct(): void
    {
        $user = User::factory()->create();
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
        $sellingPriceFormatted = Money::GBP($sellingPrice, true)->format();

        $response = $this->actingAs($user)->getJson("/api/v1/selling-price?product-id=$product->id&quantity=$quantity&unit-cost=$unitCost");

        // Assert the selling price is correct
        $response->assertStatus(200)
            ->assertExactJson(['sellingPrice' => $sellingPrice, 'sellingPriceFormatted' => $sellingPriceFormatted]);
    }

    /**
     * Test creating a sale with valid data.
     */
    public function test_creating_a_sale_with_valid_data_returns_201(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/v1/sales', [
            'productId' => $product->id,
            'quantity' => 5,
            'unitCost' => 1,
            'sellingPrice' => 5,
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test creating a sale with invalid data.
     */
    public function test_creating_a_sale_with_invalid_data_returns_error(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/v1/sales', [
            'productId' => $product->id + 1,
            'quantity' => 1,
            'unitCost' => 1,
            'sellingPrice' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->actingAs($user)->postJson('/api/v1/sales', [
            'productId' => $product->id,
            'quantity' => 0,
            'unitCost' => 1,
            'sellingPrice' => 1,
        ]);
        $response->assertStatus(422);

        $response = $this->actingAs($user)->postJson('/api/v1/sales', [
            'productId' => $product->id,
            'quantity' => 5,
            'unitCost' => '',
            'sellingPrice' => 5,
        ]);
        $response->assertStatus(422);

        $response = $this->actingAs($user)->postJson('/api/v1/sales', [
            'productId' => $product->id,
            'quantity' => 5,
            'unitCost' => 1,
            'sellingPrice' => '',
        ]);
        $response->assertStatus(422);
    }

    /**
     * Test the Api index method returns the correct data.
     */
    public function test_api_index_method_returns_correct_data(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/v1/sales');

        $response->assertStatus(200)
            ->assertExactJson(['sales' => []]);

        $product->sales()->create([
            'quantity' => 1,
            'unit_cost' => 1,
            'selling_price' => 1,
        ]);

        $response = $this->actingAs($user)->get('/api/v1/sales');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'sales')
            ->assertJsonStructure([
                'sales' => [
                    '*' => [
                        'id',
                        'product_id',
                        'quantity',
                        'unit_cost',
                        'selling_price',
                        'created_at',
                        'updated_at',
                        'product' => [
                            'id',
                            'name',
                            'profit_margin',
                            'shipping_cost',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ],
            ]);
    }
}
