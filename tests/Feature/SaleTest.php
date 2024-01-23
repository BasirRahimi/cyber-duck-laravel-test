<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SaleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test the selling price calculation returns the correct value.
     */

    public function test_selling_price_calculation(): void
    {
    }

    /**
     * Test creating a sale with valid data.
     */
    public function test_creating_a_sale_with_valid_data(): void
    {
    }

    /**
     * Test creating a sale with invalid data.
     */
    public function test_creating_a_sale_with_invalid_data(): void
    {
    }
}
