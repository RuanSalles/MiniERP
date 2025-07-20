<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => '(81) ' . $this->faker->numerify('9####-####'),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Customer $customer) {
            $address = Address::factory()->create();
            $customer->update(['address_id' => $address->id]);
        });
    }
}
