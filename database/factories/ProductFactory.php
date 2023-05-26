<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'productCode' => fake()->unique()->numerify('P-####'),
            'productName' => fake()->word(),
            'productDescription' => fake()->text(),
            'quantityInStock' => fake()->randomNumber(2, true),
            'buyPrice' => fake()->randomFloat('price',500,2),
            'MSRP' => fake()->randomFloat('price',500,2),

        ];
    }
}
