<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVarianceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'color' => $this->faker->safeColorName(),
            'size' => $this->faker->randomElement(['P', 'M', 'G', 'GG']),
            'isPrinted' => $this->faker->boolean(),
        ];
    }
}
