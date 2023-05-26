<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName('male'|'female');
        $lastName = fake()->lastName();
        $name = $firstName.' '.$lastName;
        return [
            'customerName' => $name,
            'contactFirstName' => $firstName,
            'contactLastName' => $lastName,
            'phone' => fake()->phoneNumber(),
            'addressLine1' => fake()->address(),
            'addressLine2' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'postalCode' => fake()->postcode(6),
            'country' => fake()->country(),
            'status' => fake()->randomElement(['pending' ,'active', 'deactive'])

        ];
    }
}
