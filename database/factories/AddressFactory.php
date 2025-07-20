<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'neighborhood' => $this->faker->citySuffix(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),
            'country' => $this->faker->country(),
            'zip' => $this->faker->postcode(),
        ];
    }
}
