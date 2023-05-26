<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::all()->random();
        return [
            'orderNumber' => Order::all()->random()->orderNumber,
            'productNumber' => $product->productNumber,
            'productCode' => $product->productCode,
            'priceEach' => $product->buyPrice,
            'quantityOrdered' => fake()->randomNumber(2, true),
        ];
    }
}
