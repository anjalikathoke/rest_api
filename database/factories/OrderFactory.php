<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'orderDate' => fake()->date(),
            'status' => fake()->randomElement(['Ordered','Pending','Shipped','Canceled','Delivered']),
            'comments' => fake()->sentence(),
            'customerNumber' => Customer::all()->random()->customerNumber
        ];
    }
}
